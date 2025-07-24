<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendaftaranProgramOnline; // Import model Online
use App\Models\PendaftaranProgramOffline; // Import model Offline

class PaymentController extends Controller
{
    /**
     * Mengunggah bukti pembayaran dan menyimpannya ke database.
     */
    public function uploadProof(Request $request)
    {
        // 1. Validasi input dari form
        $request->validate([
            'id' => 'required|integer',
            'type' => 'required|in:online,offline',
            'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // 2. Tentukan tabel mana yang akan di-update berdasarkan tipe
        $pendaftaran = null;
        if ($request->type === 'online') {
            $pendaftaran = PendaftaranProgramOnline::find($request->id);
        } else {
            $pendaftaran = PendaftaranProgramOffline::find($request->id);
        }

        if (!$pendaftaran) {
            return back()->withErrors(['msg' => 'Data pendaftaran tidak ditemukan.']);
        }

        // 3. Proses file dan simpan ke database
        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');

            // Simpan konten file langsung ke kolom 'bukti_pembayaran'
            $pendaftaran->bukti_pembayaran = file_get_contents($file->getRealPath());
            $pendaftaran->status = 'pending';
            $pendaftaran->save();

            return back()->with('success', 'Bukti pembayaran berhasil diunggah!');
        }

        return back()->withErrors(['msg' => 'Gagal mengunggah file.']);
    }
}