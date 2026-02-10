<?php

namespace App\Http\Controllers;

use App\Models\Galery;
use App\Http\Requests\StoreGaleryRequest;
use App\Http\Requests\UpdateGaleryRequest;
use App\DataTables\GaleryDataTable;
use Illuminate\Support\Facades\Storage;

class GaleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(GaleryDataTable $dataTable)
    {
        return $dataTable->render('galery.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['galerys'] = Galery::all();

        // action form create
        $this->data['action'] = "/galery";
        return view('galery.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreGaleryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGaleryRequest $request)
    {
        // create galery
        $data = $request->all();

        // Upload foto jika ada
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('galeries', 'public');
        }

        Galery::create($data);

        // redirect ke galery
        return redirect('/galery')->with('success', 'New Galery has been created!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Galery  $galery
     * @return \Illuminate\Http\Response
     */
    public function edit(Galery $galery)
    {
        $this->data['galerys'] = Galery::all();

        // data galery untuk form edit
        $this->data['galery_data'] = $galery;

        // action form edit
        $this->data['action'] = "/galery/" . $galery->uuid;

        return view('galery.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGaleryRequest  $request
     * @param  \App\Models\Galery  $galery
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGaleryRequest $request, Galery $galery)
    {
        // ambil semua data request
        $data = $request->all();

        // Upload foto baru jika ada
        if ($request->hasFile('photo')) {

            // Hapus foto lama jika ada
            if ($galery->photo && Storage::disk('public')->exists($galery->photo)) {
                Storage::disk('public')->delete($galery->photo);
            }

            // Simpan foto baru
            $data['photo'] = $request->file('photo')->store('galeries', 'public');
        }

        // update galery
        $galery->update($data);

        return redirect('/galery')->with('success', 'Galery has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Galery  $galery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Galery $galery)
    {
        // delete foto dari storage jika ada
        if ($galery->photo && Storage::disk('public')->exists($galery->photo)) {
            Storage::disk('public')->delete($galery->photo);
        }

        // delete galery
        $galery->delete();

        return redirect('/galery')->with('success', 'Galery has been deleted!');
    }
}


