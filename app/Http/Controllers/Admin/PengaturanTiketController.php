<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengaturanTiket;
use Illuminate\Http\Request;

class PengaturanTiketController extends Controller
{
    public function edit()
    {
        $pengaturan = PengaturanTiket::get();

        return view('admin.pengaturan_tiket.edit', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'harga_per_tiket' => 'required|integer|min:1000',
        ]);

        $pengaturan = PengaturanTiket::get();
        $pengaturan->update([
            'harga_per_tiket' => $request->harga_per_tiket,
        ]);

        return redirect()->route('admin.pengaturan-tiket.edit')
            ->with('success', 'Harga tiket berhasil diperbarui menjadi Rp ' . number_format($request->harga_per_tiket, 0, ',', '.'));
    }
}
