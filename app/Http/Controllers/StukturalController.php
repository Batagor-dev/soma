<?php

namespace App\Http\Controllers;

use App\Models\Stuktural;
use App\Http\Requests\StoreStukturalRequest;
use App\Http\Requests\UpdateStukturalRequest;
use App\DataTables\StukturalDataTable;
use Illuminate\Support\Facades\Storage;



class StukturalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(StukturalDataTable $dataTable)
    {
        return $dataTable->render('stuktural.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['stukturals'] = Stuktural::all();

        $this->data['action'] = "/stuktural";
        return view('stuktural.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStukturalRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStukturalRequest $request)
    {
        $data = $request->validated();

        if ($request->photo) {
        $image = str_replace('data:image/jpeg;base64,', '', $request->photo);
        $image = base64_decode($image);

        $filename = 'photo_' . time() . '.jpg';

        Storage::disk('public')->put('uploads/stuktural/' . $filename, $image);

        $data['photo'] = $filename;
    }

        Stuktural::create($data);

        return redirect('/stuktural')->with('success', 'New Struktural has been created!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stuktural  $stuktural
     * @return \Illuminate\Http\Response
     */
    public function edit(Stuktural $stuktural)
    {
        $this->data['stukturals'] = Stuktural::all();

        $this->data['stuktural_data'] = $stuktural;
        $this->data['action'] = "/stuktural/".$stuktural->uuid;
        return view('stuktural.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStukturalRequest  $request
     * @param  \App\Models\Stuktural  $stuktural
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStukturalRequest $request, Stuktural $stuktural)
    {
        $data = $request->validated();

        if ($request->photo) {
            $image = str_replace('data:image/jpeg;base64,', '', $request->photo);
            $image = base64_decode($image);

            $filename = 'photo_' . time() . '.jpg';

            Storage::disk('public')->put('uploads/stuktural/' . $filename, $image);

            // delete file lama
            if ($stuktural->photo && Storage::disk('public')->exists('uploads/stuktural/' . $stuktural->photo)) {
                Storage::disk('public')->delete('uploads/stuktural/' . $stuktural->photo);
            }

            $data['photo'] = $filename;
        }

        $stuktural->update($data);

        return redirect('/stuktural')->with('success', 'Struktural has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stuktural  $stuktural
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stuktural $stuktural)
    {
        $stuktural->delete();
        return redirect('/stuktural')->with('success', 'Struktural has been deleted!');
    }
}
