<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengaturanTiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'harga_umum'                => 'required|integer|min:1000',
            'harga_member'              => 'required|integer|min:1000',
            'nama_kategori_umum'        => 'required|string|max:100',
            'deskripsi_umum'            => 'nullable|string|max:1000',
            'status_umum'               => 'required|string|in:tersedia,sold_out,coming_soon',
            
            'harga_vip'                 => 'required|integer|min:1000',
            'nama_kategori_vip'         => 'required|string|max:100',
            'deskripsi_vip'             => 'nullable|string|max:1000',
            'status_vip'                => 'required|string|in:tersedia,sold_out,coming_soon',
            
            'nama_kategori_member'      => 'required|string|max:100',
            'deskripsi_member'          => 'nullable|string|max:1000',
            'status_member'             => 'required|string|in:tersedia,sold_out,coming_soon',
            
            'nama_kategori_spesial'     => 'required|string|max:100',
            'harga_spesial'             => 'required|integer|min:0',
            'deskripsi_spesial'         => 'nullable|string|max:1000',
            'status_spesial'            => 'required|string|in:tersedia,sold_out,coming_soon',
            
            'gambar_poster'             => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $pengaturan = PengaturanTiket::get();

        $data = [
            'harga_umum'                => $request->harga_umum,
            'harga_member'              => $request->harga_member,
            'nama_kategori_umum'        => $request->nama_kategori_umum,
            'deskripsi_umum'            => $request->deskripsi_umum,
            'status_umum'               => $request->status_umum,
            
            'harga_vip'                 => $request->harga_vip,
            'nama_kategori_vip'         => $request->nama_kategori_vip,
            'deskripsi_vip'             => $request->deskripsi_vip,
            'status_vip'                => $request->status_vip,
            
            'nama_kategori_member'      => $request->nama_kategori_member,
            'deskripsi_member'          => $request->deskripsi_member,
            'status_member'             => $request->status_member,
            
            'nama_kategori_spesial'     => $request->nama_kategori_spesial,
            'harga_spesial'             => $request->harga_spesial,
            'deskripsi_spesial'         => $request->deskripsi_spesial,
            'status_spesial'            => $request->status_spesial,
        ];

        // Upload poster konser
        if ($request->hasFile('gambar_poster')) {
            if ($pengaturan->gambar_poster) {
                Storage::disk('public')->delete($pengaturan->gambar_poster);
            }
            $data['gambar_poster'] = $request->file('gambar_poster')
                ->store('poster_konser', 'public');
        }

        $pengaturan->update($data);

        return redirect()->route('admin.pengaturan-tiket.edit')
            ->with('success', 'Pengaturan tiket berhasil diperbarui.');
    }
}
