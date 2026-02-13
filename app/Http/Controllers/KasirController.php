<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KasirController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {

        // Ambil semua produk user beserta kategori
        $produk = Produk::where('user_id', Auth::id())
            ->with('kategori') // pastikan relasi kategori ada di model Produk
            ->get();

        if ($produk->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada produk ditemukan',
                'data' => []
            ], 404);
        }

        // Format output
        $data = $produk->map(function($item) {
            return [
                'id' => $item->id,
                'nama_produk' => $item->nama,
                'stok' => $item->stok,
                'harga' => $item->harga,
                'kategori' => $item->kategori ? $item->kategori->nama : null
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Data produk berhasil ditampilkan',
            'data' => $data
        ], 200);
    }


    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.produk_id' => 'required|exists:produks,id',
            'items.*.jumlah' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();

        try {

            $total = 0;

            // 1️⃣ Buat transaksi dulu (total masih 0)
            $transaksi = Transaksi::create([
                'user_id'  => Auth::id(),
                'tipe'     => 'MASUK',
                'sumber'   => 'KASIR',
                'total'    => 0,
                'deskripsi'=> 'Transaksi kasir',
                'tanggal'  => $request->tanggal ?? now()
            ]);

            // 2️⃣ Loop setiap item
            foreach ($request->items as $item) {

                $produk = Produk::where('user_id', Auth::id())
                    ->find($item['produk_id']);

                if (!$produk) {
                    throw new \Exception("Produk tidak ditemukan");
                }

                if ($produk->stok < $item['jumlah']) {
                    throw new \Exception("Stok tidak cukup untuk {$produk->nama}");
                }

                $subtotal = $produk->harga * $item['jumlah'];
                $total += $subtotal;

                // Simpan detail transaksi
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id'    => $produk->id,
                    'harga'        => $produk->harga,
                    'jumlah'       => $item['jumlah'],
                    'subtotal'     => $subtotal,
                ]);

                // Kurangi stok
                $produk->decrement('stok', $item['jumlah']);
            }

            // 3️⃣ Update total transaksi
            $transaksi->update([
                'total' => $total
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil',
                'data'    => $transaksi->load('details')
            ], 201);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
