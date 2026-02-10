@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Dashboard';

    if (isset($user_data)) {
        // dd('tes');
        $breadcrumb_parent = Breadcrumbs::generate(Request::route()->getName(), $user_data)
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
        {{ isset($user_data) ? Breadcrumbs::render(Request::route()->getName(), $user_data) : Breadcrumbs::render(Request::route()->getName()) }}

        <div class="card mb-6">
            <form class="card-body" method="POST" action="{{ $action }}">
                @isset($user_data) @method('PUT') @endisset
                @csrf
                <div class="row mb-4">
                    <label class="col-sm-3 col-form-label" for="username">Username</label>
                    <div class="col-sm-9">
                        <input type="text" 
                            id="username"
                            name="username"
                            class="form-control @error('username') is-invalid @enderror"
                            value="{{ old('username', $user_data->username ?? '') }}"
                            placeholder="Username"/>
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <label class="col-sm-3 col-form-label" for="name">Name</label>
                    <div class="col-sm-9">
                        <input type="text" 
                            id="name"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $user_data->name ?? '') }}"
                            placeholder="Name"/>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <label class="col-sm-3 col-form-label" for="email">Email</label>
                    <div class="col-sm-9">
                        <input type="email" 
                            id="email"
                            name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $user_data->email ?? '') }}"
                            placeholder="Email"/>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-4">
                    <label class="col-sm-3 col-form-label" for="foto">Foto</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto aria-describedby="fotoAddon aria-label="Upload"/>
                            <button class="btn btn-outline-primary" type="button" id="fotoAddon">Upload</button>
                        </div>
                        @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                <div class="row form-password-toggle mb-4">
                    <label class="col-sm-3 col-form-label" for="multicol-password">Password</label>
                    <div class="col-sm-9">
                        <div class="input-group input-group-merge">
                            <input type="password" name="password" id="multicol-password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••" aria-describedby="password-toggle"/>
                            <span class="input-group-text cursor-pointer" id="password-toggle">
                                <i class="icon-base ri ri-eye-off-line"></i>
                            </span>
                        </div>

                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row form-password-toggle mb-4">
                    <label class="col-sm-3 col-form-label" for="multicol-password">Confrim Password</label>
                    <div class="col-sm-9">
                        <div class="input-group input-group-merge">
                            <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••" aria-describedby="password-confirm-toggle"/>
                            <span class="input-group-text cursor-pointer" id="password-toggle">
                                <i class="icon-base ri ri-eye-off-line"></i>
                            </span>
                        </div>

                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
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