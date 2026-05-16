<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LogoController extends Controller
{
    public function index()
    {
        $logos = Logo::latest()->get();
        return view('admin.logos.index', compact('logos'));
    }

    public function create()
    {
        return view('admin.logos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'key'        => 'required|string|max:100|unique:logos,key',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        ]);

        $data = $request->only('name', 'key');

        if ($request->hasFile('image_path')) {
            $data['image_path'] = $request->file('image_path')->store('logos', 'public');
        }

        Logo::create($data);

        return redirect()->route('admin.logos.index')->with('alert', [
            'icon'  => 'success',
            'title' => 'Berhasil!',
            'text'  => 'Logo baru telah ditambahkan.',
        ]);
    }

    public function edit(Logo $logo)
    {
        return view('admin.logos.edit', compact('logo'));
    }

    public function update(Request $request, Logo $logo)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'key'        => 'required|string|max:100|unique:logos,key,' . $logo->id,
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        ]);

        $data = $request->only('name', 'key');

        if ($request->hasFile('image_path')) {
            if ($logo->image_path) {
                Storage::disk('public')->delete($logo->image_path);
            }
            $data['image_path'] = $request->file('image_path')->store('logos', 'public');
        }

        $logo->update($data);

        return redirect()->route('admin.logos.index')->with('alert', [
            'icon'  => 'success',
            'title' => 'Berhasil!',
            'text'  => 'Logo berhasil diperbarui.',
        ]);
    }

    public function destroy(Logo $logo)
    {
        if ($logo->image_path) {
            Storage::disk('public')->delete($logo->image_path);
        }

        $logo->delete();

        return redirect()->route('admin.logos.index')->with('alert', [
            'icon'  => 'success',
            'title' => 'Berhasil!',
            'text'  => 'Logo telah dihapus.',
        ]);
    }
}
