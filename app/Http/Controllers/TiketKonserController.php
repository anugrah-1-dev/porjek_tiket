<?php

namespace App\Http\Controllers;

use App\Models\TiketKonser;
use Illuminate\Http\Request;

class TiketKonserController extends Controller
{
    // Harga satuan tiket (dalam rupiah) — ubah sesuai kebutuhan
    const HARGA_PER_TIKET = 100000;

    /**
     * Menampilkan form pembelian tiket konser.
     */
    public function create(Request $request)
    {
        $kategori = $request->query('kategori', 'umum');
        if (!in_array($kategori, ['umum', 'member'])) {
            $kategori = 'umum';
        }

        $hargaPerTiket = self::HARGA_PER_TIKET;

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
        $totalHarga  = $jumlahTiket * self::HARGA_PER_TIKET;

        // Simpan bukti pembayaran
        $pathBuktiPembayaran = $request->file('bukti_pembayaran')
            ->store('tiket_konser', 'public');

        // Simpan bukti member jika ada
        $pathBuktiMember = null;
        if ($request->hasFile('bukti_member')) {
            $pathBuktiMember = $request->file('bukti_member')
                ->store('tiket_konser', 'public');
        }

        TiketKonser::create([
            'kategori'         => $validated['kategori'],
            'nama_lengkap'     => $validated['nama_lengkap'],
            'ttl'              => $validated['ttl'],
            'no_hp'            => $validated['no_hp'],
            'jumlah_tiket'     => $jumlahTiket,
            'total_harga'      => $totalHarga,
            'bukti_pembayaran' => $pathBuktiPembayaran,
            'bukti_member'     => $pathBuktiMember,
        ]);

        return redirect()->route('tiket-konser.create')
            ->with('success', 'Pembelian tiket berhasil! Kami akan segera memverifikasi pembayaran Anda.');
    }
}
