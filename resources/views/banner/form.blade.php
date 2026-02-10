@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Dashboard';

    if (isset($banner_data)) {
        // dd('tes');
        $breadcrumb_parent = Breadcrumbs::generate(Request::route()->getName(), $banner_data)
            ->where('title', '!=', $breadcrumb->title)
            ->last();
    } else {
        // dd('tes2');
        $breadcrumb_parent = Breadcrumbs::generate(Request::route()->getName())
            ->where('title', '!=', $breadcrumb->title)
            ->last();
    }
@endphp

@extends('layout.backend.main', [
    'title'     => 'Dashboard | ' . config('app.name'),
    'sub_title' => $sub_title,
])

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {{ isset($banner_data) ? Breadcrumbs::render(Request::route()->getName(), $banner_data) : Breadcrumbs::render(Request::route()->getName()) }}
        <div class="card mb-6">
            <form class="card-body" method="POST" action="{{ $action }}" enctype="multipart/form-data">
                @isset($banner_data) @method('PUT') @endisset
                @csrf
                <div class="row mb-4">
                    <label class="col-sm-3 col-form-label" for="name">Name</label>
                    <div class="col-sm-9">
                        <input type="text" 
                            id="name"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $banner_data->name ?? '') }}"
                            placeholder="Name"/>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <label class="col-sm-3 col-form-label" for="link">Link (Optional)</label>
                    <div class="col-sm-9">
                        <input type="text"
                            id="link"
                            name="link"
                            class="form-control @error('link') is-invalid @enderror"
                            value="{{ old('link', $banner_data->link ?? '') }}"
                            placeholder="https://example.com"/>
                        @error('link')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <label class="col-sm-3 col-form-label" for="photo">Photo</label>
                    <div class="col-sm-9">
                        <input type="file"
                            id="photo"
                            name="photo"
                            class="form-control @error('photo') is-invalid @enderror"/>

                        @error('photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        @isset($banner_data->photo)
                            <div class="mt-3">
                                <img src="{{ asset('storage/' . $banner_data->photo) }}"
                                    class="img-thumbnail"
                                    style="width: 150px; height:150px; object-fit:cover;">
                            </div>
                        @endisset
                    </div>
                </div>
                <div class="row mb-4">
                    <label class="col-sm-3 col-form-label" for="photo">Active</label>
                    <div class="col-sm-9">
                        <input type="hidden" name="status" value="0">
                        <label class="switch switch-lg">
                        <input 
                            type="checkbox" 
                            class="switch-input" 
                            name="status" 
                            value="1"
                            {{ old('status', $banner_data->status ?? 0) == 1 ? 'checked' : '' }}
                        />
                        <span class="switch-toggle-slider">
                            <span class="switch-on"></span>
                            <span class="switch-off"></span>
                        </span>
                    </label>
                    </div>
                </div>

                


                <!-- Submit / Cancel -->
                <div class="pt-6">
                    <div class="row justify-content-end">
                        <div class="col-sm-9">
                            <button type="submit" class="btn btn-primary me-4">Submit</button>
                            <button type="reset" class="btn btn-outline-secondary" onclick="window.location.href='{{ $breadcrumb_parent->url }}'">Cancel</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection