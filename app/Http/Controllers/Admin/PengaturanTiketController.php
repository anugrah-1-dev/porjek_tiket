<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengaturanTiket;
use App\Models\GambarKonser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaturanTiketController extends Controller
{
    public function edit()
    {
        $pengaturan = PengaturanTiket::get();
        $pengaturan->load('gambarKonser');
        return view('admin.pengaturan_tiket.edit', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'harga_umum'                => 'required|integer|min:1000',
            'harga_member'              => 'required|integer|min:1000',
            'nama_kategori_umum'        => 'required|string|max:100',
            'deskripsi_umum'            => 'nullable|string|max:1000',
            'harga_vip'                 => 'required|integer|min:1000',
            'nama_kategori_vip'         => 'required|string|max:100',
            'deskripsi_vip'             => 'nullable|string|max:1000',
            'deskripsi_member'          => 'nullable|string|max:1000',
            'nama_kategori_spesial'     => 'required|string|max:100',
            'harga_spesial'             => 'required|integer|min:0',
            'deskripsi_spesial'         => 'nullable|string|max:1000',
            'gambar_poster'             => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            // Info konser
            'tanggal_event'             => 'nullable|date',
            'lokasi_event'              => 'nullable|string|max:255',
            'nama_artis'                => 'nullable|string|max:255',
            'deskripsi_artis'           => 'nullable|string|max:2000',
            'gambar_artis'              => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'fasilitas_venue'           => 'nullable|string|max:3000',
            'deskripsi_section_konser'  => 'nullable|string|max:2000',
            // Gambar konser (multiple)
            'gambar_konser'             => 'nullable|array|max:10',
            'gambar_konser.*'           => 'image|mimes:jpg,jpeg,png,webp|max:5120',
            'caption_konser'            => 'nullable|array',
            'caption_konser.*'          => 'nullable|string|max:255',
        ]);

        $pengaturan = PengaturanTiket::get();

        $data = [
            'harga_umum'                => $request->harga_umum,
            'harga_member'              => $request->harga_member,
            'nama_kategori_umum'        => $request->nama_kategori_umum,
            'deskripsi_umum'            => $request->deskripsi_umum,
            'harga_vip'                 => $request->harga_vip,
            'nama_kategori_vip'         => $request->nama_kategori_vip,
            'deskripsi_vip'             => $request->deskripsi_vip,
            'deskripsi_member'          => $request->deskripsi_member,
            'nama_kategori_spesial'     => $request->nama_kategori_spesial,
            'harga_spesial'             => $request->harga_spesial,
            'deskripsi_spesial'         => $request->deskripsi_spesial,
            // Info konser
            'tanggal_event'             => $request->tanggal_event,
            'lokasi_event'              => $request->lokasi_event,
            'nama_artis'                => $request->nama_artis,
            'deskripsi_artis'           => $request->deskripsi_artis,
            'fasilitas_venue'           => $request->fasilitas_venue,
            'deskripsi_section_konser'  => $request->deskripsi_section_konser,
        ];

        // Upload poster konser
        if ($request->hasFile('gambar_poster')) {
            if ($pengaturan->gambar_poster) {
                Storage::disk('public')->delete($pengaturan->gambar_poster);
            }
            $data['gambar_poster'] = $request->file('gambar_poster')
                ->store('poster_konser', 'public');
        }

        // Upload gambar artis
        if ($request->hasFile('gambar_artis')) {
            if ($pengaturan->gambar_artis) {
                Storage::disk('public')->delete($pengaturan->gambar_artis);
            }
            $data['gambar_artis'] = $request->file('gambar_artis')
                ->store('gambar_artis', 'public');
        }

        $pengaturan->update($data);

        // Upload gambar-gambar konser (multiple)
        if ($request->hasFile('gambar_konser')) {
            $captions = $request->caption_konser ?? [];
            $maxUrutan = $pengaturan->gambarKonser()->max('urutan') ?? 0;

            foreach ($request->file('gambar_konser') as $index => $file) {
                $maxUrutan++;
                $path = $file->store('gambar_konser', 'public');

                GambarKonser::create([
                    'pengaturan_tiket_id' => $pengaturan->id,
                    'image_path'          => $path,
                    'caption'             => $captions[$index] ?? null,
                    'urutan'              => $maxUrutan,
                ]);
            }
        }

        return redirect()->route('admin.pengaturan-tiket.edit')
            ->with('success', 'Pengaturan tiket berhasil diperbarui.');
    }

    /**
     * Hapus gambar konser individual.
     */
    public function deleteGambarKonser($id)
    {
        $gambar = GambarKonser::findOrFail($id);
        Storage::disk('public')->delete($gambar->image_path);
        $gambar->delete();

        return redirect()->route('admin.pengaturan-tiket.edit')
            ->with('success', 'Gambar berhasil dihapus.');
    }
}
