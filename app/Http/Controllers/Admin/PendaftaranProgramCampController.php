<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranProgramCamp;
use App\Models\ProgramCamp;
use App\Models\Period;
use App\Models\Bank;
use Illuminate\Http\Request;
use App\Exports\PendaftaranCampExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Rooms;

class PendaftaranProgramCampController extends Controller
{
    public function index()
    {
        $pendaftar = PendaftaranProgramCamp::with(['programCamp', 'period', 'bank'])->latest()->get();

        return view('admin.camp.index', compact('pendaftar'));
    }

    public function show($id)
    {
        $pendaftar = PendaftaranProgramCamp::with(['programCamp', 'period', 'bank'])->findOrFail($id);
        return view('admin.camp.show', compact('pendaftar'));
    }

    public function edit($id)
    {
        $pendaftar = PendaftaranProgramCamp::findOrFail($id);
        $statusList = ['pending', 'diterima', 'ditolak'];
        return view('admin.camp.edit', compact('pendaftar', 'statusList'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,validasi,diterima,ditolak',
        ]);

        $pendaftar = PendaftaranProgramCamp::findOrFail($id);
        $pendaftar->update([
            'status' => $request->status,
        ]);

        return redirect()->route('admin.camp.index')->with('success', 'Status berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pendaftar = PendaftaranProgramCamp::findOrFail($id);
        $pendaftar->delete();

        return redirect()->back()->with('success', 'Pendaftar berhasil dihapus.');
    }


    public function showBukti($id)
    {
        $pendaftar = PendaftaranProgramCamp::findOrFail($id);
        return view('admin.camp.bukti', compact('pendaftar'));
    }


    public function exportCsv()
    {
        return Excel::download(new PendaftaranCampExport, 'pendaftaran.camp.xlsx');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,diterima,ditolak',
        ]);

        $data = PendaftaranProgramCamp::findOrFail($id);
        $data->status = $request->status;
        $data->save();

        return redirect()->back()->with('success', 'Status berhasil diperbarui.');
    }

    public function pindahKamar(Request $request, $id)
    {
        $peserta = PendaftaranProgramCamp::findOrFail($id);

        $newRoomId = $request->input('target_room_id');

        $newRoom = Rooms::findOrFail($newRoomId);

        // Validasi jika kamar masih tersedia
        if ($newRoom->penghuni >= $newRoom->kapasitas) {
            return response()->json(['success' => false, 'message' => 'Kamar tujuan penuh.']);
        }

        // Update room lama: -1 penghuni
        $oldRoom = Rooms::find($peserta->room_id);
        if ($oldRoom) {
            $oldRoom->penghuni -= 1;
            $oldRoom->save();
        }

        // Pindahkan peserta
        $peserta->room_id = $newRoomId;
        $peserta->save();

        // Update room baru: +1 penghuni
        $newRoom->penghuni += 1;
        $newRoom->save();

        return response()->json(['success' => true]);
    }
}
