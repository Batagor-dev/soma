@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Dashboard';

    if (isset($permissiongroup_data)) {
        // dd('tes');
        $breadcrumb_parent = Breadcrumbs::generate(Request::route()->getName(), $permissiongroup_data)
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
        {{ isset($permissiongroup_data) ? Breadcrumbs::render(Request::route()->getName(), $permissiongroup_data) : Breadcrumbs::render(Request::route()->getName()) }}
        <div class="card mb-6">
            <form class="card-body" method="POST" action="{{ $action }}">
                @isset($permissiongroup_data) @method('PUT') @endisset
                @csrf
                <div class="row mb-4">
                    <label class="col-sm-3 col-form-label" for="name">Name</label>
                    <div class="col-sm-9">
                        <input type="text" 
                            id="name"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $permissiongroup_data->name ?? '') }}"
                            placeholder="Name"/>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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