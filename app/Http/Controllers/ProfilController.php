<?php

namespace App\Http\Controllers;

use App\Models\Profil;
use App\Http\Requests\StoreProfilRequest;
use App\Http\Requests\UpdateProfilRequest;
use App\DataTables\ProfilDataTable;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProfilDataTable $dataTable)
    {
        return $dataTable->render('profil.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['profils'] = Profil::all();

        $this->data['action'] = "/profil";
        return view('profil.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProfilRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProfilRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')
                ->store('uploads/profil', 'public');
        }

        // pastikan poin tersimpan sebagai array
        if ($request->has('poin')) {
            $data['poin'] = $request->poin;
        }

        Profil::create($data);

        return redirect('/profil')->with('success', 'New Struktural has been created!');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profil  $profil
     * @return \Illuminate\Http\Response
     */
    public function edit(Profil $profil)
    {
        $this->data['profils'] = Profil::all();

        $this->data['profil_data'] = $profil;
        $this->data['action'] = "/profil/".$profil->uuid;
        return view('profil.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProfilRequest  $request
     * @param  \App\Models\Profil  $profil
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfilRequest $request, Profil $profil)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {

            if ($profil->photo && Storage::disk('public')->exists($profil->photo)) {
                Storage::disk('public')->delete($profil->photo);
            }

            $data['photo'] = $request->file('photo')
                ->store('uploads/profil', 'public');
        }

        // update poin
        if ($request->has('poin')) {
            $data['poin'] = $request->poin;
        }

        $profil->update($data);

        return redirect('/profil')->with('success', 'Struktural has been updated!');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profil  $profil
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profil $profil)
    {
        if ($profil->photo && Storage::disk('public')->exists($profil->photo)) {
            Storage::disk('public')->delete($profil->photo);
        }

        $profil->delete();

        return redirect('/profil')->with('success', 'Struktural has been deleted!');
    }

}
