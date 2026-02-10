@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Dashboard';

    if (isset($role_data)) {
        $breadcrumb_parent = Breadcrumbs::generate(Request::route()->getName(), $role_data)
            ->where('title', '!=', $breadcrumb->title)
            ->last();
    } else {
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
        {{ isset($role_data) ? Breadcrumbs::render(Request::route()->getName(), $role_data) : Breadcrumbs::render(Request::route()->getName()) }}

        <div class="card mb-6">
            <form class="card-body" method="POST" action="{{ $action }}">
                @isset($role_data) @method('PUT') @endisset
                @csrf

                <!-- Name -->
                <div class="row mb-4">
                    <label class="col-sm-3 col-form-label" for="name">Role Name</label>
                    <div class="col-sm-9">
                        <input type="text"
                            id="name"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $role_data->name ?? '') }}"
                            placeholder="Role Name"/>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Guard Name -->
                <div class="row mb-4">
                    <label class="col-sm-3 col-form-label" for="guard_name">Guard</label>
                    <div class="col-sm-9">
                        <input type="text"
                            id="guard_name"
                            name="guard_name"
                            class="form-control @error('guard_name') is-invalid @enderror"
                            value="{{ old('guard_name', $role_data->guard_name ?? '') }}"
                            placeholder="Guard Name"/>
                        @error('guard_name')
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