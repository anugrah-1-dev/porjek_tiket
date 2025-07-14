<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramOnline;
use App\Models\Period;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\PendaftaranProgramOnline;

class PendaftaranOnlineController extends Controller
{


    public function index()
    {
        $pendaftar = PendaftaranProgramOnline::with(['program', 'period'])
            ->latest()->paginate(10);

        return view('admin.pendaftaran_online.index', compact('pendaftar'));
    }

    public function create()
    {
        $programs = ProgramOnline::where('is_active', 1)->get();
        $periods = Period::orderBy('date')->get();

        return view('pendaftaran.online.create', compact('programs', 'periods'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email',
            'no_hp' => 'nullable|string',
            'asal_kota' => 'nullable|string',
            'program_id' => 'required|exists:program_online,id',
            'period_id' => 'required|exists:periods,id',
            'bukti_pembayaran' => 'nullable|image|max:2048',
        ]);

        $trx_id = strtoupper(Str::random(10));

        // Upload file jika ada
        if ($request->hasFile('bukti_pembayaran')) {
            $validated['bukti_pembayaran'] = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
        }

        DB::table('pendaftaran_program_online')->insert([
            'trx_id' => $trx_id,
            'nama_lengkap' => $validated['nama_lengkap'],
            'email' => $validated['email'],
            'no_hp' => $validated['no_hp'],
            'asal_kota' => $validated['asal_kota'],
            'program_id' => $validated['program_id'],
            'period_id' => $validated['period_id'],
            'bukti_pembayaran' => $validated['bukti_pembayaran'] ?? null,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Pendaftaran berhasil! TRX ID: ' . $trx_id);
    }
}
