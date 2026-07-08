<?php

namespace App\Http\Controllers;

use App\Models\TiketKonser;
use App\Models\PengaturanTiket;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TiketKonserController extends Controller
{
    /**
     * Menampilkan form pembelian tiket konser.
     */
    public function create(Request $request)
    {
        $kategori = $request->query('kategori', 'umum');
        if (!in_array($kategori, ['umum', 'member'])) {
            $kategori = 'umum';
        }

        $hargaPerTiket = PengaturanTiket::get()->harga_per_tiket;

        return view('tiket_konser.create', compact('kategori', 'hargaPerTiket'));
    }

    /**
     * Menyimpan data pembelian tiket konser.
     */
    public function store(Request $request)
    {
        $rules = [
            'kategori'         => 'required|in:umum,member',
            'nama_lengkap'     => 'required|string|max:255',
            'ttl'              => 'required|string|max:255',
            'no_hp'            => 'required|string|max:20',
            'jumlah_tiket'     => 'required|integer|min:1|max:100',
            'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ];

        if ($request->input('kategori') === 'member') {
            $rules['bukti_member'] = 'required|image|mimes:jpg,jpeg,png,webp|max:5120';
        }

        $validated = $request->validate($rules);

        $jumlahTiket = (int) $validated['jumlah_tiket'];
        $hargaPerTiket = PengaturanTiket::get()->harga_per_tiket;
        $totalHarga  = $jumlahTiket * $hargaPerTiket;

        // Simpan bukti pembayaran
        $pathBuktiPembayaran = $request->file('bukti_pembayaran')
            ->store('tiket_konser', 'public');

        // Simpan bukti member jika ada
        $pathBuktiMember = null;
        if ($request->hasFile('bukti_member')) {
            $pathBuktiMember = $request->file('bukti_member')
                ->store('tiket_konser', 'public');
        }

        $tiket = TiketKonser::create([
            'trx_id'           => 'TIK-' . strtoupper(Str::random(8)),
            'kategori'         => $validated['kategori'],
            'nama_lengkap'     => $validated['nama_lengkap'],
            'ttl'              => $validated['ttl'],
            'no_hp'            => $validated['no_hp'],
            'jumlah_tiket'     => $jumlahTiket,
            'total_harga'      => $totalHarga,
            'bukti_pembayaran' => $pathBuktiPembayaran,
            'bukti_member'     => $pathBuktiMember,
        ]);

        return redirect()->route('tiket-konser.invoice', $tiket->id);
    }

    /**
     * Menampilkan halaman invoice setelah pembelian tiket berhasil.
     */
    public function invoice($id)
    {
        $tiket = TiketKonser::findOrFail($id);
        $hargaPerTiket = PengaturanTiket::get()->harga_per_tiket;

        return view('tiket_konser.invoice', compact('tiket', 'hargaPerTiket'));
    }
}
