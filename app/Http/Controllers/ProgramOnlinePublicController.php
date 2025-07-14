<?php

namespace App\Http\Controllers;

use App\Models\ProgramOnline;
use App\Models\Period;
use App\Models\PendaftaranProgramOnline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProgramOnlinePublicController extends Controller
{
    public function show(ProgramOnline $program)
    {
        if (!$program->is_active) {
            abort(404);
        }

        // $periods = Period::where('is_active', true)->get();

        $periods = Period::all();
        return view('programs.online.show', compact('program', 'periods'));
    }

    public function daftar(Request $request, ProgramOnline $program)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email',
            'no_hp' => 'required|string|max:20',
            'asal_kota' => 'nullable|string|max:100',
            'period_id' => 'required|exists:periods,id',
            'bukti_pembayaran' => 'nullable|image|max:2048',
        ]);

        $trx_id = 'TRX-ONL-' . strtoupper(Str::random(8));

        $bukti = null;
        if ($request->hasFile('bukti_pembayaran')) {
            $bukti = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
        }

        PendaftaranProgramOnline::create([
            'trx_id' => $trx_id,
            'program_id' => $program->id,
            'period_id' => $validated['period_id'],
            'nama_lengkap' => $validated['nama_lengkap'],
            'email' => $validated['email'],
            'no_hp' => $validated['no_hp'],
            'asal_kota' => $validated['asal_kota'],
            'bukti_pembayaran' => $bukti,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Pendaftaran berhasil dikirim!');
    }
}
