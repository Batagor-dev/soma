<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi;

class TransaksiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    // Tampilkan semua transaksi milik user
    public function index()
    {
        $userId = Auth::id();

        $transaksi = Transaksi::where('user_id', $userId)
            ->with('details') // ambil detail transaksi jika ada
            ->orderBy('tanggal', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar transaksi berhasil diambil',
            'data'    => $transaksi
        ], 200);
    }


    // Buat pengeluaran
    public function store(Request $request)
    {
        $request->validate([
            'deskripsi' => 'required|string|max:255',
            'total'     => 'required|numeric|min:0',
            'sumber'    => 'required|string|max:50' // misal RESTOK, BIAYA, DLL
        ]);

        try {
            $transaksi = Transaksi::create([
                'user_id'   => Auth::id(),
                'tipe'      => 'KELUAR',
                'sumber'    => $request->sumber,
                'total'     => $request->total,
                'deskripsi' => $request->deskripsi,
                'tanggal'   => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pengeluaran berhasil dicatat',
                'data'    => $transaksi
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    // Tampilkan 1 transaksi spesifik beserta detail
    public function show($id)
    {
        $transaksi = Transaksi::where('user_id', Auth::id())
            ->with('details')
            ->find($id);

        if (!$transaksi) {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi tidak ditemukan',
                'data'    => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil diambil',
            'data'    => $transaksi
        ], 200);
    }
}
