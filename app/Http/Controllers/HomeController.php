<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Profil;
use App\Models\Stuktural;
use App\Models\Galery;
use App\Models\Kegiatan;

class HomeController extends Controller
{
    public function index()
    {
        if (request()->has('verified')) {
            return redirect()->route('home');
        }
        
        return view('home.index', [
            'banners' => Banner::where('status', 1)->latest()->get(),
            'profil' => Profil::latest()->first(),
            'struktur' => Stuktural::all(),

            // preview 6 foto
            'galery' => Galery::latest()->take(6)->get(),
            'totalGalery' => Galery::count(),

            'kegiatans' => Kegiatan::whereNull('deleted_at')
                ->orderBy('waktu', 'asc')
                ->take(6)
                ->get(),
        ]);
    }

    public function galery()
    {
        return view('home.galery', [
            'galery' => \App\Models\Galery::latest()->paginate(9)
        ]);
    }

}


