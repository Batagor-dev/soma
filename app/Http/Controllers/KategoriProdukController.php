<?php

namespace App\Http\Controllers;

use App\Models\KategoriProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class KategoriProdukController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $kategori = KategoriProduk::where('user_id', Auth::id())->get();

        if ($kategori->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Data kategori tidak ditemukan',
                'data'    => []
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data kategori berhasil ditampilkan',
            'data'    => $kategori->map(function ($kategori) {
                return [
                    'id'        => $kategori->id,
                    'nama'      => $kategori->nama,
                    'deskripsi' => $kategori->deskripsi,
                ];
            })
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255|unique:kategori_produks,nama',
            'deskripsi' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $kategori = KategoriProduk::create([
            'user_id' => Auth::id(),
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil dibuat',
            'data' => [
                'id'        => $kategori->id,
                'user_id'   => $kategori->user_id,
                'nama'      => $kategori->nama,
                'deskripsi' => $kategori->deskripsi,
            ]
        ], 201);

    }

    public function show($id)
    {
        $kategori = KategoriProduk::where('user_id', Auth::id())->find($id);

        if (!$kategori) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $kategori
        ]);
    }

    public function update(Request $request, $id)
    {
        $kategori = KategoriProduk::where('user_id', Auth::id())->find($id);

        if (!$kategori) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama' => [
                'required',
                'string',
                'max:255',
                Rule::unique('kategori_produks')
                    ->where(fn ($query) =>
                        $query->where('user_id', Auth::guard('api')->id())
                    )
            ],
            'deskripsi' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $kategori->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil diupdate',
            'data' => [
                'id'        => $kategori->id,
                'user_id'   => $kategori->user_id,
                'nama'      => $kategori->nama,
                'deskripsi' => $kategori->deskripsi,
            ]
        ]);
    }

    public function destroy($id)
    {
        $kategori = KategoriProduk::where('user_id', Auth::id())->find($id);

        if (!$kategori) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan'
            ], 404);
        }

        $kategori->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil dihapus',
            'data'    => [
                'id'        => $kategori->id,
                'user_id'   => $kategori->user_id,
                'nama'      => $kategori->nama,
                'deskripsi' => $kategori->deskripsi,
            ]
        ]);
    }
}
