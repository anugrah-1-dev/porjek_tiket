<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    public function index()
    {
        $galeris = Galeri::all();
        return view('admin.galeri.index', compact('galeris'));
    }

    public function create()
    {
        return view('admin.galeri.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image_path.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:0,1',
        ]);

        if ($request->hasFile('image_path')) {
            foreach ($request->file('image_path') as $image) {
                $filename = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('galeri', $filename, 'public');

                Galeri::create([
                    'title' => $request->title,
                    'image_path' => 'galeri/' . $filename, // Disimpan sebagai relatif terhadap storage
                    'status' => $request->status,
                ]);
            }
        }

        return redirect()->route('admin.galeri.index')->with('success', 'Galeri berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $galeri = Galeri::findOrFail($id);
        return view('admin.galeri.edit', compact('galeri'));
    }

    public function update(Request $request, $id)
    {
        $galeri = Galeri::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:0,1',
        ]);

        if ($request->hasFile('image_path')) {
            // Hapus file lama
            if ($galeri->image_path && Storage::exists('public/' . $galeri->image_path)) {
                Storage::delete('public/' . $galeri->image_path);
            }

            $path = $request->file('image_path')->store('galeri', 'public');
            $galeri->image_path = $path;
        }

        $galeri->title = $request->title;
        $galeri->status = $request->status;
        $galeri->save();

        return redirect()->route('admin.galeri.index')->with('success', 'Galeri berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $galeri = Galeri::findOrFail($id);
        if ($galeri->image_path && Storage::exists('public/' . $galeri->image_path)) {
            Storage::delete('public/' . $galeri->image_path);
        }
        $galeri->delete();

        return redirect()->route('admin.galeri.index')->with('success', 'Galeri berhasil dihapus!');
    }
}
