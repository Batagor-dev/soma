<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Produk;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $today = now()->toDateString();
        $kemarin = now()->subDay()->toDateString();

        // Greeting berdasarkan jam
        $hour = now()->hour;
        if ($hour < 11) $greeting = "Selamat Pagi";
        elseif ($hour < 15) $greeting = "Selamat Siang";
        elseif ($hour < 18) $greeting = "Selamat Sore";
        else $greeting = "Selamat Malam";


        // Ringkasan pengeluaran
        $pengeluaranHarian = Transaksi::where('user_id', $user->id)
            ->where('tipe', 'keluar')
            ->whereDate('created_at', $today)
            ->sum('total');

        $pengeluaranTotal = Transaksi::where('user_id', $user->id)
            ->where('tipe', 'keluar')
            ->sum('total');


        // Ringkasan pemasukan
        $pemasukanHarian = Transaksi::where('user_id', $user->id)
            ->where('tipe', 'masuk')
            ->whereDate('created_at', $today)
            ->sum('total');

        $pemasukanTotal = Transaksi::where('user_id', $user->id)
            ->where('tipe', 'masuk')
            ->sum('total');


        // 5 transaksi terbaru
        $transaksiTerbaru = Transaksi::where('user_id', $user->id)
            ->latest()
            ->limit(5)
            ->get([
                'id',
                'tipe',
                'sumber',
                'total',
                'deskripsi',
                'tanggal',
                'created_at'
            ]);


        // 5 produk terakhir diupdate
        $stokTerbaru = Produk::where('user_id', $user->id)
            ->latest('updated_at')
            ->limit(5)
            ->get([
                'id',
                'nama',
                'foto',
                'stok',
                'harga',
                'updated_at'
            ]);


        // Produk terlaris hari ini
       $produkTerlaris = Produk::whereHas('detailTransaksi.transaksi', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })
        ->with([
            'kategori:id,nama',    // ambil kategori
        ])
        ->withSum(['detailTransaksi as total_terjual' => function ($q) use ($user) {
            $q->whereHas('transaksi', function ($sub) use ($user) {
                $sub->where('user_id', $user->id);
            });
        }], 'jumlah')
        ->orderByDesc('total_terjual')
        ->take(3)
        ->get(['id', 'nama', 'kategori_id']); // kategori_id optional karena kita udah with('kategori')


        // Produk dengan stok menipis
        $stokMenipis = Produk::where('user_id', $user->id)
            ->where('stok', '<=', 10)
            ->orderBy('stok')
            ->get(['id', 'nama', 'stok']);


        // Grafik pemasukan 7 hari terakhir
        $penjualanMingguan = Transaksi::where('user_id', $user->id)
            ->where('tipe', 'masuk')
            ->whereBetween('created_at', [now()->subDays(6), now()])
            ->selectRaw('DATE(created_at) as tanggal, SUM(total) as total')
            ->groupByRaw('DATE(created_at)')
            ->orderByRaw('DATE(created_at) ASC')
            ->get();


        // Hitung persentase perubahan pemasukan hari ini vs kemarin
        $todayTotal = Transaksi::where('user_id', $user->id)
            ->where('tipe', 'masuk')
            ->whereDate('created_at', $today)
            ->sum('total');

        $yesterdayTotal = Transaksi::where('user_id', $user->id)
            ->where('tipe', 'masuk')
            ->whereDate('created_at', $kemarin)
            ->sum('total');

        $persentase = 0;
        if ($yesterdayTotal > 0) {
            $persentase = (($todayTotal - $yesterdayTotal) / $yesterdayTotal) * 100;
        }


        // Jam transaksi paling ramai
        $jamTeramai = Transaksi::where('user_id', $user->id)
            ->where('tipe', 'masuk')
            ->selectRaw('HOUR(created_at) as jam, COUNT(*) as total')
            ->groupBy('jam')
            ->orderByDesc('total')
            ->first();


            
        return response()->json([
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'greeting' => $greeting,
            'summary' => [
                'pengeluaran' => [
                    'harian' => $pengeluaranHarian,
                    'total'  => $pengeluaranTotal,
                ],
                'pemasukan' => [
                    'harian' => $pemasukanHarian,
                    'total'  => $pemasukanTotal,
                ],
            ],
            'produk_terlaris' => $produkTerlaris,
            'stok_menipis' => $stokMenipis,
            'stok_terbaru' => $stokTerbaru,
            'transaksi_terbaru' => $transaksiTerbaru,
            'chart' => [
                'mingguan' => $penjualanMingguan
            ],
            'insight' => [
                'persentase_penjualan_hari_ini' => round($persentase, 2),
                'jam_teramai' => $jamTeramai
            ]
        ]);
    }
}