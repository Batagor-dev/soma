<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kegiatan;
use App\Models\Galery;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    protected array $data = [];

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Super Admin|Admin');
    }

    /**
     * Display dashboard
     */
    public function index()
    {
        // Statistik utama
        $this->data['totalUser']     = User::count();
        $this->data['totalKegiatan'] = Kegiatan::count();
        $this->data['totalGalery']   = Galery::count();

        // Grafik kegiatan per bulan (tahun ini)
        $this->data['kegiatanPerBulan'] = Kegiatan::select(
                DB::raw('MONTH(waktu) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('waktu', now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');

        return view('dashboard.index', $this->data);
    }
}
