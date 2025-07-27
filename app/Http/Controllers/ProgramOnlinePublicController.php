<?php

namespace App\Http\Controllers;

use App\Models\ProgramOnline;
use App\Models\Period;
use App\Models\PendaftaranProgramOnline;
use App\Models\Banks;
use App\Models\Customer_Service; // 1. PASTIKAN MODEL INI DI-IMPORT
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ProgramOnlinePublicController extends Controller
{
    /**
     * Menampilkan detail program online.
     */
    public function show(ProgramOnline $program)
    {
        if (!$program->is_active) {
            abort(404);
        }
        $periods = Period::where('is_active', 1)->get();
        $banks = Banks::where('status', 'active')->get();

        // PERUBAHAN: Ambil semua data kontak untuk widget WA
        $contactServices = Customer_Service::all(); 

        // Kirim semua variabel ke view
        return view('programs.online.show', compact('program', 'periods', 'banks', 'contactServices'));
    }

    /**
     * Memproses pendaftaran untuk program online.
     */
    public function daftar(Request $request, ProgramOnline $program)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email',
            'no_hp' => 'required|string|max:20',
            'asal_kota' => 'nullable|string|max:100',
            'period_id' => 'required|exists:periods,id',
            'bank_id' => 'required|exists:banks,id',
        ]);

        // --- Logika untuk membuat trx_id ---
        $today = Carbon::now()->format('Ymd');
        $prefix = 'TRX-ONL-' . $today . '-';

        $lastRegistration = PendaftaranProgramOnline::where('trx_id', 'like', $prefix . '%')
                                            ->orderBy('id', 'desc')
                                            ->first();
        $nextSequence = 1;
        if ($lastRegistration) {
            $lastSequence = (int) str_replace($prefix, '', $lastRegistration->trx_id);
            $nextSequence = $lastSequence + 1;
        }
        $newTrxId = $prefix . $nextSequence;
        // --- Akhir logika trx_id ---

        $pendaftaran = PendaftaranProgramOnline::create([
            'trx_id' => $newTrxId,
            'program_id' => $program->id,
            'period_id' => $validated['period_id'],
            'bank_id' => $validated['bank_id'], // Simpan bank_id yang dipilih
            'nama_lengkap' => $validated['nama_lengkap'],
            'email' => $validated['email'],
            'no_hp' => $validated['no_hp'],
            'asal_kota' => $validated['asal_kota'] ?? null,
            'status' => 'pending',
        ]);

        // Arahkan ke halaman pembayaran online
        return redirect()->route('public.pendaftaran.online.pembayaran', ['trx_id' => $newTrxId])
                         ->with('success', 'Pendaftaran awal berhasil! Silakan lanjutkan ke tahap pembayaran.');
    }

    /**
     * Menampilkan halaman pembayaran berdasarkan trx_id untuk program online.
     */
    public function halamanPembayaran($trx_id)
    {
        // Muat relasi 'program' dan 'bank' saat mengambil data pendaftaran.
        $pendaftaran = PendaftaranProgramOnline::with(['program', 'bank'])
                                                ->where('trx_id', $trx_id)
                                                ->firstOrFail();

        // PERUBAHAN: Ambil semua data kontak dan gunakan variabel jamak ($contactServices)
        $contactServices = Customer_Service::all(); 

        // Kirim data pendaftaran dan kontak ke view
        return view('pembayaran.index', compact('pendaftaran', 'contactServices'));
    }
}
