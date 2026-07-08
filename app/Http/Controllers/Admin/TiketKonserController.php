<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TiketKonser;
use Illuminate\Http\Request;

class TiketKonserController extends Controller
{
    public function index()
    {
        $tikets = TiketKonser::latest()->paginate(15);
        return view('admin.tiket_konser.index', compact('tikets'));
    }

    public function show($id)
    {
        $tiket = TiketKonser::with('bank')->findOrFail($id);
        return view('admin.tiket_konser.show', compact('tiket'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,diterima,ditolak',
        ]);

        $tiket = TiketKonser::findOrFail($id);
        $tiket->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status tiket berhasil diperbarui.');
    }

    public function destroy($id)
    {
        TiketKonser::findOrFail($id)->delete();
        return redirect()->route('admin.tiket-konser.index')
            ->with('success', 'Data tiket berhasil dihapus.');
    }
}

