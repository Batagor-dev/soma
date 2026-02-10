<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Http\Requests\StoreBannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use App\DataTables\BannerDataTable;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BannerDataTable $dataTable)
    {
        return $dataTable->render('banner.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['banners'] = Banner::all();

        $this->data['action'] = "/banner";
        return view('banner.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBannerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBannerRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $file       = $request->file('photo');
            $extension  = $file->getClientOriginalExtension();

            $baseName    = Str::slug($request->name);
            $websiteName = Str::slug(config('app.name'));
            $timestamp   = time();

            $path = storage_path('app/public/banner/');
            if (!is_dir($path)) {
                mkdir($path, 0755, true);
            }

            $filename = "{$baseName}-{$websiteName}-{$timestamp}.{$extension}";

            $driver  = new GdDriver();
            $manager = new ImageManager($driver);

            // resize/crop tetap, walaupun ukuran sudah pas (jaga konsistensi)
            $resizedImage = $manager->read($file->getRealPath())->cover(1920, 1080);

            file_put_contents($path . $filename, $resizedImage->toJpeg(90));

            $data['photo'] = 'banner/'.$filename;
        }

        Banner::create($data);

        return redirect()->route('banner.index')->with('success', 'New banner has been created!');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function edit(Banner $banner)
    {
        $this->data['banners'] = Banner::all();

        $this->data['banner_data'] = $banner;
        $this->data['action'] = "/banner/".$banner->uuid;
        return view('banner.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBannerRequest  $request
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBannerRequest $request, Banner $banner)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $file       = $request->file('photo');
            $extension  = $file->getClientOriginalExtension();

            $baseName    = Str::slug($request->name);
            $websiteName = Str::slug(config('app.name'));
            $timestamp   = time();

            $path = storage_path('app/public/banner/');
            if (!is_dir($path)) {
                mkdir($path, 0755, true);
            }

            $filename = "{$baseName}-{$websiteName}-{$timestamp}.{$extension}";

            $driver  = new GdDriver();
            $manager = new ImageManager($driver);

            $resizedImage = $manager->read($file->getRealPath())->cover(1920, 1080);

            file_put_contents($path . $filename, $resizedImage->toJpeg(90));

            $data['photo'] = 'banner/'.$filename;

            // hapus foto lama
            if ($banner->photo && \Storage::disk('public')->exists($banner->photo)) {
                \Storage::disk('public')->delete($banner->photo);
            }
        }

        $banner->update($data);

        return redirect()->route('banner.index')->with('success', 'Banner has been updated!');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        $banner->delete();
        return redirect('/banner')->with('success', 'Banner has been deleted!');
    }
}
