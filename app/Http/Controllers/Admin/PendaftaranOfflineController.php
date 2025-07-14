<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranProgramOffline;
use Illuminate\Http\Request;

class PendaftaranOfflineController extends Controller
{
    public function index()
    {
        $pendaftar = PendaftaranProgramOffline::with(['program', 'period'])
            ->latest()->paginate(10);

        return view('admin.pendaftaran_offline.index', compact('pendaftar'));
    }

    public function show($id)
    {
        $data = PendaftaranProgramOffline::with(['program', 'period'])->findOrFail($id);
        return view('admin.pendaftaran_offline.show', compact('data'));
    }

    public function destroy($id)
    {
        $data = PendaftaranProgramOffline::findOrFail($id);
        $data->delete();

        return redirect()->route('admin.pendaftaran.offline.index')->with('success', 'Data berhasil dihapus.');
    }
}
