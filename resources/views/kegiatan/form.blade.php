@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Dashboard';

    // Untuk tombol cancel
    if (isset($kegiatan_data)) {
        $breadcrumb_parent = Breadcrumbs::generate(Request::route()->getName(), $kegiatan_data)
            ->where('title', '!=', $breadcrumb->title)
            ->last();
    } else {
        $breadcrumb_parent = Breadcrumbs::generate(Request::route()->getName())
            ->where('title', '!=', $breadcrumb->title)
            ->last();
    }
@endphp

@extends('layout.backend.main', [
    'title' => 'Kegiatan | ' . config('app.name'),
    'sub_title' => $sub_title
])

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    {{-- Breadcrumb untuk create/edit --}}
    {{ isset($kegiatan_data)
        ? Breadcrumbs::render(Request::route()->getName(), $kegiatan_data)
        : Breadcrumbs::render(Request::route()->getName())
    }}

    <div class="card mb-6">
        <form class="card-body" method="POST" action="{{ $action }}" enctype="multipart/form-data">
            @csrf
            @isset($kegiatan_data)
                @method('PUT')
            @endisset

            {{-- Title --}}
            <div class="row mb-4">
                <label class="col-sm-3 col-form-label" for="title">Title</label>
                <div class="col-sm-9">
                    <input type="text"
                        id="title"
                        name="title"
                        class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title', $kegiatan_data->title ?? '') }}"
                        placeholder="Judul kegiatan">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Deskripsi --}}
            <div class="row mb-4">
                <label class="col-sm-3 col-form-label" for="deskripsi">Deskripsi</label>
                <div class="col-sm-9">
                    <textarea
                        id="deskripsi"
                        name="deskripsi"
                        rows="4"
                        class="form-control @error('deskripsi') is-invalid @enderror"
                        placeholder="Deskripsi kegiatan">{{ old('deskripsi', $kegiatan_data->deskripsi ?? '') }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Waktu --}}
            <div class="row mb-4">
                <label class="col-sm-3 col-form-label" for="waktu">Waktu</label>
                <div class="col-sm-9">
                    <input type="date"
                    id="waktu"
                    name="waktu"
                    class="form-control @error('waktu') is-invalid @enderror"
                    value="{{ old('waktu', isset($kegiatan_data->waktu)
                            ? $kegiatan_data->waktu->format('Y-m-d')
                            : '') }}">
                    @error('waktu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Photo --}}
            <div class="row mb-4">
                <label class="col-sm-3 col-form-label" for="photo">Photo</label>
                <div class="col-sm-9">

                    <input class="form-control @error('photo') is-invalid @enderror"
                           type="file"
                           id="photo"
                           name="photo"
                           accept="image/*">

                    @error('photo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    {{-- Preview photo saat edit --}}
                    @isset($kegiatan_data->photo)
                        <img src="{{ asset('storage/' . $kegiatan_data->photo) }}" class="mt-3" width="120">
                    @endisset
                </div>
            </div>

            {{-- Buttons --}}
            <div class="pt-6">
                <div class="row justify-content-end">
                    <div class="col-sm-9">
                        <button type="submit" class="btn btn-primary me-4">
                            Submit
                        </button>

                        <button type="reset"
                                class="btn btn-outline-secondary"
                                onclick="window.location.href='{{ $breadcrumb_parent->url }}'">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection
