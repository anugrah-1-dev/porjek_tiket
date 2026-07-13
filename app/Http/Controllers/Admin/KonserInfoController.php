<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengaturanTiket;
use App\Models\GambarKonser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KonserInfoController extends Controller
{
    public function edit()
    {
        $pengaturan = PengaturanTiket::get();
        $pengaturan->load('gambarKonser');
        return view('admin.konser_info.edit', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        $request->validate([
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
            'tanggal_event'             => $request->tanggal_event,
            'lokasi_event'              => $request->lokasi_event,
            'nama_artis'                => $request->nama_artis,
            'deskripsi_artis'           => $request->deskripsi_artis,
            'fasilitas_venue'           => $request->fasilitas_venue,
            'deskripsi_section_konser'  => $request->deskripsi_section_konser,
        ];

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

        return redirect()->route('admin.konser-info.edit')
            ->with('success', 'Info konser berhasil diperbarui.');
    }

    /**
     * Hapus gambar konser individual.
     */
    public function deleteGambar($id)
    {
        $gambar = GambarKonser::findOrFail($id);
        Storage::disk('public')->delete($gambar->image_path);
        $gambar->delete();

        return redirect()->route('admin.konser-info.edit')
            ->with('success', 'Gambar berhasil dihapus.');
    }
}
