<?php

namespace App\Http\Controllers;

use App\Models\ProgramOffline;
use App\Models\Transports;
use App\Models\Period;
use App\Models\PendaftaranProgramOffline;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProgramOfflinePublicController extends Controller
{
    // Tampilkan detail + form daftar
    public function showOfflinePublic(ProgramOffline $program)
    {
        $transports = Transports::all();
        $periods = Period::all();
        return view('programs.offline.show', compact('program', 'transports', 'periods'));
    }

    // Proses pendaftaran
    public function daftar(Request $request, ProgramOffline $program)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email',
            'no_hp' => 'required|string|max:20',
            'asal_kota' => 'nullable|string|max:100',
            'no_wali' => 'nullable|string|max:20',
            'period_id' => 'required|exists:periods,id',
            'transport_id' => 'nullable|exists:transports,id',
            'bukti_pembayaran' => 'nullable|image|max:2048',
        ]);

        // Generate trx_id unik
        $trx_id = 'TRX-' . strtoupper(Str::random(10));

        // Upload bukti pembayaran jika ada
        $bukti = null;
        if ($request->hasFile('bukti_pembayaran')) {
            $bukti = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
        }

        // Simpan ke database
        PendaftaranProgramOffline::create([
            'trx_id' => $trx_id,
            'program_id' => $program->id,
            'period_id' => $validated['period_id'],
            'transport_id' => $validated['transport_id'] ?? null,
            'nama_lengkap' => $validated['nama_lengkap'],
            'email' => $validated['email'],
            'no_hp' => $validated['no_hp'],
            'asal_kota' => $validated['asal_kota'] ?? null,
            'no_wali' => $validated['no_wali'] ?? null,
            'bukti_pembayaran' => $bukti,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Pendaftaran berhasil dikirim!');
    }
}
