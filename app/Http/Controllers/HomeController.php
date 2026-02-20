<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $user = $request->user();

        $today = now()->toDateString();

        // Pengeluaran           
        $pengeluaranHarian = Transaksi::where('tipe', 'keluar')
            ->whereDate('created_at', $today)
            ->sum('total');

        $pengeluaranTotal = Transaksi::where('tipe', 'keluar')
            ->sum('total');

        // Pemasukan
        $pemasukanHarian = Transaksi::where('tipe', 'masuk')
            ->whereDate('created_at', $today)
            ->sum('total');

        $pemasukanTotal = Transaksi::where('tipe', 'masuk')
            ->sum('total');

        //Last updated stok
        $stokTerbaru = Produk::orderBy('updated_at', 'desc')
            ->limit(5)
            ->get([
                'id',
                'nama',
                'stok',
                'harga',
                'updated_at'
            ]);

        return response()->json([
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $user->getRoleNames(),
            ],
            'pengeluaran' => [
                'harian' => $pengeluaranHarian,
                'total'  => $pengeluaranTotal,
            ],
            'pemasukan' => [
                'harian' => $pemasukanHarian,
                'total'  => $pemasukanTotal,
            ],
            'stok_terbaru' => $stokTerbaru,
        ]);
    }
}