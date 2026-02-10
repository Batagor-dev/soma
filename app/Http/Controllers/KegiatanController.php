<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Http\Requests\StoreKegiatanRequest;
use App\Http\Requests\UpdateKegiatanRequest;
use App\DataTables\KegiatanDataTable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(KegiatanDataTable $dataTable)
    {
        return $dataTable->render('kegiatan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->data['kegiatans'] = Kegiatan::all();

        // action form create
        $this->data['action'] = '/kegiatan';

        return view('kegiatan.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKegiatanRequest $request)
    {
        $data = $request->all();

        // generate uuid & slug
        $data['uuid'] = Str::uuid();
        $data['slug'] = Str::slug($request->title);

        // upload photo
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('kegiatan', 'public');
        }

        Kegiatan::create($data);

        return redirect('/kegiatan')->with('success', 'Kegiatan berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kegiatan $kegiatan)
    {
        $this->data['kegiatan_data'] = $kegiatan;

        // action form edit
        $this->data['action'] = '/kegiatan/' . $kegiatan->uuid;

        return view('kegiatan.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKegiatanRequest $request, Kegiatan $kegiatan)
    {
        $data = $request->all();

        // update slug jika title berubah
        $data['slug'] = Str::slug($request->title);

        // upload photo baru
        if ($request->hasFile('photo')) {

            // hapus photo lama
            if ($kegiatan->photo && Storage::disk('public')->exists($kegiatan->photo)) {
                Storage::disk('public')->delete($kegiatan->photo);
            }

            $data['photo'] = $request->file('photo')->store('kegiatan', 'public');
        }

        $kegiatan->update($data);

        return redirect('/kegiatan')->with('success', 'Kegiatan berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kegiatan $kegiatan)
    {
        // hapus photo
        if ($kegiatan->photo && Storage::disk('public')->exists($kegiatan->photo)) {
            Storage::disk('public')->delete($kegiatan->photo);
        }

        $kegiatan->delete();

        return redirect('/kegiatan')->with('success', 'Kegiatan berhasil dihapus!');
    }
}
