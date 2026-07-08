<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TiketKonser;

class TiketKonserController extends Controller
{
    /**
     * Menampilkan daftar pemesan tiket konser.
     */
    public function index()
    {
        $tikets = TiketKonser::latest()->paginate(15);

        return view('admin.tiket_konser.index', compact('tikets'));
    }

    /**
     * Menampilkan detail data pemesan tiket.
     */
    public function show($id)
    {
        $tiket = TiketKonser::with('bank')->findOrFail($id);

        return view('admin.tiket_konser.show', compact('tiket'));
    }

    /**
     * Menghapus data pemesan tiket.
     */
    public function destroy($id)
    {
        $tiket = TiketKonser::findOrFail($id);
        $tiket->delete();

        return redirect()->route('admin.tiket-konser.index')
            ->with('success', 'Data tiket berhasil dihapus.');
    }
}
