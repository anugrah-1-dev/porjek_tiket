<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program; // <-- PENTING: Import model Program
use App\Models\Galeri; // ✅ Tambahkan model Galeri

class LandingPageController extends Controller
{
    /**
     * Menampilkan halaman utama (landing page)
     * beserta data yang diperlukan.
     */
    public function index()
    {
        // 1. Ambil semua data dari tabel 'programs'
        $programs = Program::orderBy('id', 'asc')->get();
    $galeris = Galeri::where('status', 1)->latest()->get(); // Ambil galeri aktif saja
        // 2. Kirim data tersebut ke view 'landingpage'
        //    Variabel $programs sekarang akan tersedia di dalam view
        return view('landingpage', [
            'programs' => $programs,
            'galeris' => $galeris,
        ]);
    }
}