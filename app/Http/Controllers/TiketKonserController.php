<?php

namespace App\Http\Controllers;

use App\Models\TiketKonser;
use App\Models\PengaturanTiket;
use App\Models\Banks;
use App\Models\Customer_Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TiketKonserController extends Controller
{
    // Prefix TRX ID per kategori
    const TRX_PREFIX = [
        'umum'    => 'YKIU',
        'member'  => 'YKIMA',
        'vip'     => 'YKIV',
        'spesial' => 'YKIS',
    ];

    /**
     * Generate TRX ID: PREFIX_DDMMYYYY_HHMMSS
     */
    private function generateTrxId(string $kategori): string
    {
        $prefix = self::TRX_PREFIX[$kategori] ?? 'YKIU';
        return $prefix . '_' . now()->format('dmY_His');
    }

    /**
     * Menampilkan form pembelian tiket konser.
     */
    public function create(Request $request)
    {
        $kategori = $request->query('kategori', 'umum');
        if (!in_array($kategori, ['umum', 'member', 'vip', 'spesial'])) {
            $kategori = 'umum';
        }

        $pengaturan      = PengaturanTiket::get();
        $hargaUmum       = $pengaturan->harga_umum;
        $hargaMember     = $pengaturan->harga_member;
        $hargaVip        = $pengaturan->harga_vip;
        $hargaSpesial    = $pengaturan->harga_spesial ?? 0;
        $namaUmum        = $pengaturan->nama_kategori_umum;
        $namaVip         = $pengaturan->nama_kategori_vip;
        $namaSpesial     = $pengaturan->nama_kategori_spesial;
        $deskripsiUmum     = $pengaturan->deskripsi_umum;
        $deskripsiVip      = $pengaturan->deskripsi_vip;
        $deskripsiMember   = $pengaturan->deskripsi_member;
        $deskripsiSpesial  = $pengaturan->deskripsi_spesial;

        $hargaPerTiket = match ($kategori) {
            'member'  => $hargaMember,
            'vip'     => $hargaVip,
            'spesial' => $hargaSpesial,
            default   => $hargaUmum,
        };
        $banks = Banks::where('status', 'active')->get();

        return view('tiket_konser.create', compact(
            'kategori', 'hargaPerTiket',
            'hargaUmum', 'hargaMember', 'hargaVip', 'hargaSpesial',
            'namaUmum', 'namaVip', 'namaSpesial', 'banks',
            'deskripsiUmum', 'deskripsiVip', 'deskripsiMember', 'deskripsiSpesial'
        ));
    }

    /**
     * Menyimpan data pembelian tiket konser.
     */
    public function store(Request $request)
    {
        $isSpesial = $request->input('kategori') === 'spesial';

        $rules = [
            'kategori'     => 'required|in:umum,member,vip,spesial',
            'nama_lengkap' => 'required|string|max:255',
            'ttl'          => 'required|string|max:255',
            'no_hp'        => 'required|string|max:20',
            'jumlah_tiket' => 'required|integer|min:1|max:100',
        ];

        // Bukti pembayaran & bank wajib kecuali kategori spesial (gratis)
        if (!$isSpesial) {
            $rules['bank_id']          = 'required|exists:banks,id';
            $rules['bukti_pembayaran'] = 'required|image|mimes:jpg,jpeg,png,webp|max:5120';
        }

        if ($request->input('kategori') === 'member' || $isSpesial) {
            $rules['bukti_member']   = 'required|image|mimes:jpg,jpeg,png,webp|max:5120';
            $rules['periode_member'] = 'required|string|max:255';
        }

        $validated = $request->validate($rules);

        $jumlahTiket   = (int) $validated['jumlah_tiket'];
        $pengaturan    = PengaturanTiket::get();
        $hargaPerTiket = match ($validated['kategori']) {
            'member'  => $pengaturan->harga_member,
            'vip'     => $pengaturan->harga_vip,
            'spesial' => $pengaturan->harga_spesial ?? 0,
            default   => $pengaturan->harga_umum,
        };
        $totalHarga = $jumlahTiket * $hargaPerTiket;

        // Simpan bukti pembayaran (opsional untuk spesial)
        $pathBuktiPembayaran = null;
        if ($request->hasFile('bukti_pembayaran')) {
            $pathBuktiPembayaran = $request->file('bukti_pembayaran')
                ->store('tiket_konser', 'public');
        }

        // Simpan bukti member jika ada
        $pathBuktiMember = null;
        if ($request->hasFile('bukti_member')) {
            $pathBuktiMember = $request->file('bukti_member')
                ->store('tiket_konser', 'public');
        }

        $tiket = TiketKonser::create([
            'trx_id'           => $this->generateTrxId($validated['kategori']),
            'kategori'         => $validated['kategori'],
            'nama_lengkap'     => $validated['nama_lengkap'],
            'ttl'              => $validated['ttl'],
            'no_hp'            => $validated['no_hp'],
            'jumlah_tiket'     => $jumlahTiket,
            'total_harga'      => $totalHarga,
            'bank_id'          => $validated['bank_id'] ?? null,
            'bukti_pembayaran' => $pathBuktiPembayaran,
            'bukti_member'     => $pathBuktiMember,
            'periode_member'   => $request->input('periode_member'),
        ]);

        return redirect()->route('tiket-konser.invoice', $tiket->id);
    }

    /**
     * Menampilkan halaman invoice setelah pembelian tiket berhasil.
     */
    public function invoice($id)
    {
        $tiket         = TiketKonser::with('bank')->findOrFail($id);
        $pengaturan    = PengaturanTiket::get();
        $cs            = Customer_Service::first();
        $hargaPerTiket = match ($tiket->kategori) {
            'member'  => $pengaturan->harga_member,
            'vip'     => $pengaturan->harga_vip,
            'spesial' => $pengaturan->harga_spesial ?? 0,
            default   => $pengaturan->harga_umum,
        };

        return view('tiket_konser.invoice', compact('tiket', 'hargaPerTiket', 'cs'));
    }
}
