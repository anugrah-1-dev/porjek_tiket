<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ProgramOffline;
use App\Models\ProgramOnline;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $online = ProgramOnline::where('is_active', 1)->get();
        $offline = ProgramOffline::where('is_active', 1)->get();
        
        $years = range(now()->year - 1, now()->year);
        $monthlyProfit = [];

        foreach ($years as $year) {
            $monthlyProfit[$year] = array_fill(1, 12, 0);
        }

        // Hitung total profit per bulan per tahun
        foreach ($online as $item) {
            $date = \Carbon\Carbon::parse($item->created_at);
            $monthlyProfit[$date->year][$date->month] += $item->harga;
        }

        foreach ($offline as $item) {
            $date = \Carbon\Carbon::parse($item->created_at);
            $monthlyProfit[$date->year][$date->month] += $item->harga;
        }


        // Buat data untuk grafik penjualan berdasarkan kuota
        $salesData = [
            'Online' => $online->count(), // Asumsi 1 kursus = 1 kuota
            'Offline' => $offline->sum('kuota')
        ];

        $totalKursus = $online->count() + $offline->count();
        $totalKeuntungan = $online->sum('harga') + $offline->sum('harga');
        $totalMediaSosial = 20;
        return view('admin.dashboard', compact('monthlyProfit', 'salesData','totalKursus', 'totalKeuntungan', 'totalMediaSosial'));
    }
}
