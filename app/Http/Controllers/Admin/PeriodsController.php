<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Period;
use Illuminate\Http\Request;

class PeriodsController extends Controller
{
    public function index()
    {
        $periods = Period::orderBy('date', 'desc')->paginate(10);
        return view('admin.periods.index', compact('periods'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date|unique:periods,date',
            'is_active' => 'nullable|boolean',
        ]);

        // If this period will be active, deactivate all others first
        if ($request->is_active) {
            Period::query()->update(['is_active' => false]);
        }

        Period::create([
            'date' => $request->date,
            'is_active' => $request->is_active ?? false,
        ]);

        return redirect()->back()->with('alert', [
            'icon' => 'success',
            'title' => 'Berhasil!',
            'text' => 'Periode berhasil ditambahkan.'
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date|unique:periods,date,' . $id,
            'is_active' => 'nullable|boolean',
        ]);

        $period = Period::findOrFail($id);

        // If this period will be active, deactivate all others first
        if ($request->is_active) {
            Period::where('id', '!=', $id)->update(['is_active' => false]);
        }

        $period->update([
            'date' => $request->date,
            'is_active' => $request->is_active ?? false,
        ]);

        return redirect()->back()->with('alert', [
            'icon' => 'success',
            'title' => 'Berhasil!',
            'text' => 'Periode berhasil diperbarui.'
        ]);
    }

    public function destroy($id)
    {
        $period = Period::findOrFail($id);

        // If deleting the active period, you might want to handle this case
        if ($period->is_active) {
            // Optionally activate another period here if needed
        }

        $period->delete();

        return redirect()->back()->with('alert', [
            'icon' => 'success',
            'title' => 'Berhasil!',
            'text' => 'Periode berhasil dihapus.'
        ]);
    }
}
