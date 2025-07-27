<?php

namespace App\Http\Controllers;

// Import kelas yang dibutuhkan
use App\Models\ProgramOffline;
use App\Models\Transports;
use App\Models\Period;
use App\Models\PendaftaranProgramOffline;
use App\Models\Bank; // Menggunakan nama model 'Bank' sesuai standar Laravel
use App\Models\Banks;
use App\Models\Customer_Service; // 1. PASTIKAN MODEL INI DI-IMPORT
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ProgramOfflinePublicController extends Controller
{
    /**
     * Menampilkan detail program offline beserta form pendaftaran.
     */
    public function showOfflinePublic(ProgramOffline $program)
    {
        $transports = Transports::all();
        $periods = Period::where('is_active', 1)->get();
        $banks = Banks::where('status', 'active')->get();
        
        // PERUBAHAN: Ambil semua data kontak untuk widget WA
        $contactServices = Customer_Service::all();

        // PERUBAHAN: Kirim variabel $banks dan $contactServices ke view
        return view('programs.offline.show', compact('program', 'transports', 'periods', 'banks', 'contactServices'));
    }

    /**
     * Memproses pendaftaran untuk program offline.
     */
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
            'bank_id' => 'required|exists:banks,id',
        ]);

        // --- Logika untuk membuat trx_id (tidak ada perubahan) ---
        $today = Carbon::now()->format('Ymd');
        $prefix = 'TRX-' . $today . '-';

        $lastRegistration = PendaftaranProgramOffline::where('trx_id', 'like', $prefix . '%')
                                            ->orderBy('id', 'desc')
                                            ->first();
        $nextSequence = 1;
        if ($lastRegistration) {
            $lastSequence = (int) str_replace($prefix, '', $lastRegistration->trx_id);
            $nextSequence = $lastSequence + 1;
        }
        $newTrxId = $prefix . $nextSequence;
        // --- Akhir logika trx_id ---

        $pendaftaran = PendaftaranProgramOffline::create([
            'trx_id' => $newTrxId,
            'program_id' => $program->id,
            'period_id' => $validated['period_id'],
            'transport_id' => $validated['transport_id'] ?? null,
            'bank_id' => $validated['bank_id'], // Simpan bank_id yang dipilih
            'nama_lengkap' => $validated['nama_lengkap'],
            'email' => $validated['email'],
            'no_hp' => $validated['no_hp'],
            'asal_kota' => $validated['asal_kota'] ?? null,
            'no_wali' => $validated['no_wali'] ?? null,
            'status' => 'pending',
        ]);
        
        // Redirect ke halaman pembayaran dengan membawa trx_id
        return redirect()->route('public.pendaftaran.offline.pembayaran', ['trx_id' => $newTrxId])
                         ->with('success', 'Pendaftaran awal berhasil! Silakan lanjutkan ke tahap pembayaran.');
    }

    /**
     * Menampilkan halaman pembayaran berdasarkan trx_id.
     */
    public function halamanPembayaran($trx_id)
    {
        // Muat relasi 'program' dan 'bank' saat mengambil data pendaftaran.
        $pendaftaran = PendaftaranProgramOffline::with(['program', 'bank'])
                                                ->where('trx_id', $trx_id)
                                                ->firstOrFail();

        // PERUBAHAN: Ambil semua data kontak dan gunakan variabel jamak ($contactServices)
        $contactServices = Customer_Service::all(); 

        // Tampilkan view pembayaran dan kirim data pendaftaran (yang sudah berisi detail bank) dan kontak
        return view('pembayaran.index', compact('pendaftaran', 'contactServices'));
    }
}
