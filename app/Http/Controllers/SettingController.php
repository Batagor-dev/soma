<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreSettingRequest;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('Setting Access'), 403);

        return view('setting.form', [
            'action'      => route('setting.store'),
            'title'       => Setting::getValue('title'),
            'keyword'     => implode(',', Setting::getValue('keyword', [])),
            'description' => Setting::getValue('description'),
            'author'      => Setting::getValue('author'),
            'favicon'     => Setting::getValue('favicon'),
        ]);
    }

    public function store(StoreSettingRequest $request)
    {
        abort_if(Gate::denies('Setting Access'), 403);

        $payload = $request->except(['_token', 'favicon']);

        /* ---------- handle favicon ---------- */
        if ($request->hasFile('favicon')) {
            Setting::deleteOldFile('favicon');          // hapus lama
            $payload['favicon'] = $request->file('favicon')
                                          ->store('settings', 'public');
        }

        /* ---------- keyword jadi array ---------- */
        $payload['keyword'] = array_filter(
            explode(',', strtolower($request->input('keyword', '')))
        );

        Setting::setValue($payload);

        return redirect()->route('setting.index')
                         ->with('success', 'Pengaturan berhasil disimpan.');
    }
}