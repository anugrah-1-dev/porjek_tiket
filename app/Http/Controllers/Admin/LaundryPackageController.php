<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaundryPackage;
use Illuminate\Http\Request;

class LaundryPackageController extends Controller
{
    public function index()
    {
        $laundries = LaundryPackage::latest()->paginate(10);
        return view('admin.laundry.index', compact('laundries'));
    }

    public function create()
    {
        return view('admin.laundry.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_paket' => 'required|string|max:255',
            'harga'      => 'required|numeric',
            'jenis'      => 'nullable|string|max:255',
            'periode'    => 'nullable|integer',
            'status'     => 'required|in:aktif,nonaktif',
            'deskripsi'  => 'nullable|string',
            'thumbnail'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
    
        $data = $request->except('thumbnail');
    
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('laundry/thumbnails', 'public');
            $data['thumbnail'] = $path;
        }
    
        LaundryPackage::create($data);
    
        return redirect()->route('admin.laundry.index')->with('success', 'Laundry package berhasil ditambahkan!');
    }
    
    public function update(Request $request, LaundryPackage $laundryPackage)
    {
        $request->validate([
            'nama_paket' => 'required|string|max:255',
            'harga'      => 'required|numeric',
            'jenis'      => 'nullable|string|max:255',
            'periode'    => 'nullable|integer',
            'status'     => 'required|in:aktif,nonaktif',
            'deskripsi'  => 'nullable|string',
            'thumbnail'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
    
        $data = $request->except('thumbnail');
    
        if ($request->hasFile('thumbnail')) {
            // Hapus file lama kalau ada
            if ($laundryPackage->thumbnail && file_exists(storage_path('app/public/' . $laundryPackage->thumbnail))) {
                unlink(storage_path('app/public/' . $laundryPackage->thumbnail));
            }
    
            $path = $request->file('thumbnail')->store('laundry/thumbnails', 'public');
            $data['thumbnail'] = $path;
        }
    
        $laundryPackage->update($data);
    
        return redirect()->route('admin.laundry.index')->with('success', 'Laundry package berhasil diperbarui!');
    }
    

    public function destroy(LaundryPackage $laundryPackage)
    {
        $laundryPackage->delete();
        return redirect()->route('admin.laundry.index')->with('success', 'Laundry package berhasil dihapus!');
    }
}
