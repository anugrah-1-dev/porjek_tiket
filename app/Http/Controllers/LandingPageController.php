<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\ProgramOffline;
use App\Models\ProgramOnline;
use App\Models\ProgramCamp;

class LandingPageController extends Controller
{
    public function index()
    {
        $programs = Program::orderBy('id', 'asc')->get();

        $galleries = Gallery::where('status', 1)
                ->with('images')
                ->latest()
                ->get();

        $offlinePrograms = ProgramOffline::where('is_active', 1)->latest()->get();
        $onlinePrograms  = ProgramOnline::where('is_active', 1)->latest()->get();
        $camps           = ProgramCamp::orderBy('id', 'asc')->get();

        return view('landingpage', [
            'offlinePrograms' => $offlinePrograms,
            'onlinePrograms'  => $onlinePrograms,
            'programs'        => $programs,
            'galleries'       => $galleries,
            'camps'           => $camps,
        ]);
    }

    // Detail program offline (untuk public)// Di controller publik (misal: ProgramOfflinePublicController)
    public function showOfflinePublic(ProgramOffline $program)
    {
        if (!$program->is_active) {
            abort(404); // hanya tampilkan yang aktif
        }

        return view('programs.offline.show', compact('program'));
    }


    // Detail program online (untuk public)
    public function showOnlinePublic(ProgramOnline $program)
    {
        return view('admin.programs.online.show', compact('program'));
    }
}
