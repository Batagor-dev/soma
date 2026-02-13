<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\KategoriProduk;
use App\Models\RestokProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ProdukController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $produk = Produk::where('user_id', Auth::id())
            ->with('kategori')
            ->get();

        if ($produk->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Data produk tidak ditemukan',
                'data'    => []
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data produk berhasil ditampilkan',
            'data'    => $produk->map(function ($item) {
                return [
                    'id'          => $item->id,
                    'nama'        => $item->nama,
                    'deskripsi'   => $item->deskripsi,
                    'harga'       => $item->harga,
                    'stok'        => $item->stok,
                    'kategori' => $item->kategori ? $item->kategori->nama : 'Tidak ditemukan',

                ];
            })
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kategori_produk_id' => 'required|exists:kategori_produks,id',
            'nama'               => 'required|string|max:255',
            'deskripsi'          => 'nullable|string',
            'harga'              => 'required|numeric|min:0',
            'stok'               => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors()
            ], 422);
        }

        $produk = Produk::create([
            'user_id'            => Auth::id(),
            'kategori_produk_id' => $request->kategori_produk_id,
            'nama'               => $request->nama,
            'deskripsi'          => $request->deskripsi,
            'harga'              => $request->harga,
            'stok'               => $request->stok,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dibuat',
            'data'    => $produk
        ], 201);
    }

    public function show($id)
    {
        $produk = Produk::where('user_id', Auth::id())
            ->with('kategori')
            ->find($id);

        if (!$produk) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $produk
        ]);
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::where('user_id', Auth::id())->find($id);

        if (!$produk) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'kategori_produk_id' => 'required|exists:kategori_produks,id',
            'nama'               => 'required|string|max:255',
            'deskripsi'          => 'nullable|string',
            'harga'              => 'required|numeric|min:0',
            'stok'               => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors()
            ], 422);
        }

        $produk->update($request->only([
            'kategori_produk_id',
            'nama',
            'deskripsi',
            'harga',
            'stok'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil diupdate',
            'data'    => $produk
        ]);
    }

    public function destroy($id)
    {
        $produk = Produk::where('user_id', Auth::id())->find($id);

        if (!$produk) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }

        $produk->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dihapus',
            'data'    => $produk
        ]);
    }

    public function restok(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1'
        ]);

        $produk = Produk::where('user_id', Auth::id())->find($id);

        if (!$produk) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan atau bukan milik Anda'
            ], 404);
        }

        $stokSebelum = $produk->stok;
        $jumlahRestok = $request->jumlah;

        DB::transaction(function () use ($produk, $jumlahRestok, $request) {

            RestokProduk::create([
                'produk_id' => $produk->id,
                'user_id'   => Auth::id(),
                'jumlah'    => $jumlahRestok,
                'keterangan'=> $request->keterangan
            ]);

            $produk->increment('stok', $jumlahRestok);
        });

        $produk->refresh(); // ambil stok terbaru

        return response()->json([
            'success' => true,
            'message' => 'Restok berhasil',
            'data' => [
                'nama_produk'  => $produk->nama,
                'stok_sebelum' => $stokSebelum,
                'jumlah_tambah'=> $jumlahRestok,
                'stok_sekarang'=> $produk->stok
            ]
        ], 200);
    }

}
