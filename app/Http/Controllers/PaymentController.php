<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendaftaranProgramOnline; // Import model Online
use App\Models\PendaftaranProgramOffline; // Import model Offline
use App\Models\PendaftaranProgramCamp; // Import model Camp
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    /**
     * Mengunggah bukti pembayaran dan menyimpannya ke database.
     */
    public function uploadProof(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'id' => 'required|integer',
            'type' => 'required|in:online,offline,camp',
            'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // 2. Ambil model berdasarkan tipe
        $pendaftaran = match ($request->type) {
            'online' => PendaftaranProgramOnline::find($request->id),
            'offline' => PendaftaranProgramOffline::find($request->id),
            'camp' => PendaftaranProgramCamp::find($request->id),
            default => null,
        };

        if (!$pendaftaran) {
            return back()->withErrors(['msg' => 'Data pendaftaran tidak ditemukan.']);
        }

        // 3. Hapus file lama jika ada
        if ($pendaftaran->bukti_pembayaran) {
            Storage::disk('public')->delete($pendaftaran->bukti_pembayaran);
        }

        // 4. Simpan file baru ke storage dan catat path-nya
        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');

            // Buat nama unik berdasarkan timestamp dan ID
            $filename = 'bukti_' . $request->type . '_' . $pendaftaran->id . '_' . time() . '.' . $file->getClientOriginalExtension();

            // Simpan ke folder public/bukti_pembayaran
            $path = $file->storeAs('bukti_pembayaran', $filename, 'public');

            // Simpan path file ke database dan ubah status
            $pendaftaran->bukti_pembayaran = $path;
            $pendaftaran->status = 'pending'; // Status kembali ke pending untuk diverifikasi ulang oleh admin
            $pendaftaran->save();

            return back()->with('success', 'Bukti pembayaran berhasil diunggah! Mohon tunggu konfirmasi dari admin.');
        }

        return back()->withErrors(['msg' => 'Gagal mengunggah file.']);
    }
}
