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
            'harga_umum'         => 'required|integer|min:1000',
            'harga_member'       => 'required|integer|min:1000',
            'nama_kategori_umum' => 'required|string|max:100',
            'harga_vip'          => 'required|integer|min:1000',
            'nama_kategori_vip'  => 'required|string|max:100',
            'gambar_poster'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $pengaturan = PengaturanTiket::get();

        $data = [
            'harga_umum'         => $request->harga_umum,
            'harga_member'       => $request->harga_member,
            'nama_kategori_umum' => $request->nama_kategori_umum,
            'harga_vip'          => $request->harga_vip,
            'nama_kategori_vip'  => $request->nama_kategori_vip,
        ];

        if ($request->hasFile('gambar_poster')) {
            $data['gambar_poster'] = $request->file('gambar_poster')
                ->store('poster_konser', 'public');
        }

        $pengaturan->update($data);

        return redirect()->route('admin.pengaturan-tiket.edit')
            ->with('success', 'Pengaturan tiket berhasil diperbarui.');
    }
}

