@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Menu';

    if (isset($menu_data)) {
        $breadcrumb_parent = Breadcrumbs::generate(Request::route()->getName(), $menu_data)
            ->where('title', '!=', $breadcrumb->title)
            ->last();
    } else {
        $breadcrumb_parent = Breadcrumbs::generate(Request::route()->getName())
            ->where('title', '!=', $breadcrumb->title)
            ->last();
    }
@endphp

@extends('layout.backend.main', [
    'title'     => 'Menu | ' . config('app.name'),
    'sub_title' => $sub_title,
])

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card mb-6">
        <form class="card-body" method="POST" action="{{ $action }}">
            @csrf
            @isset($menu_data) @method('PUT') @endisset

            <!-- Menu Name -->
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label" for="nama_menu">Menu Name<span class="text-danger">*</span></label>
                <div class="col-sm-9">
                    <input type="text" id="nama_menu" name="nama_menu" 
                        class="form-control @error('nama_menu') is-invalid @enderror"
                        value="{{ old('nama_menu', $menu_data->nama_menu ?? '') }}"
                        placeholder="Menu Display Name" required>
                    @error('nama_menu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <!-- Parent Menu -->
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label" for="menu_id">Parent Menu</label>
                <div class="col-sm-9">
                    <select id="menu_id" name="menu_id" class="form-select select2" data-allow-clear="true">
                        <option value="" {{ old('menu_id', $menu_data->menu_id ?? '') == '' ? 'selected' : '' }}>
                            -- No Parent (Root Menu) --
                        </option>
                        @foreach($menus as $pm)
                            <option value="{{ $pm->id }}"
                                {{ old('menu_id', $menu_data->menu_id ?? '') == $pm->id ? 'selected' : '' }}>
                                {{ $pm->nama_menu }}
                            </option>
                        @endforeach
                    </select>
                    @error('menu_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>


            <!-- Icon -->
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label" for="icon">Icon</label>
                <div class="col-sm-9">
                    <input type="text" id="icon" name="icon"
                        class="form-control @error('icon') is-invalid @enderror"
                        value="{{ old('icon', $menu_data->icon ?? '') }}"
                        placeholder="ri-home-line">
                    @error('icon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Refer to <a href="https://remixicon.com" target="_blank">RemixIcon</a></small>
                </div>
            </div>

            <!-- Permission Group -->
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label" for="permission_group_id">Permission Group<span class="text-danger">*</span></label>
                <div class="col-sm-9">
                    <select id="permission_group_id" name="permission_group_id" class="form-select select2" data-allow-clear="true">
                        <option value="">-- No Permission --</option>
                        @foreach($permissiongroups as $pg)
                            <option value="{{ $pg->id }}"
                                {{ old('permission_group_id', $menu_data->permission_group_id ?? '') == $pg->id ? 'selected' : '' }}>
                                {{ $pg->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('permission_group_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <!-- Route / Href -->
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label" for="href">Route / Href<span class="text-danger">*</span></label>
                <div class="col-sm-9">
                    <input type="text" id="href" name="href"
                        class="form-control @error('href') is-invalid @enderror"
                        value="{{ old('href', $menu_data->href ?? '') }}"
                        placeholder="/dashboard atau route name">
                    @error('href')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Sort Order -->
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label" for="sort">Sort Order<span class="text-danger">*</span></label>
                <div class="col-sm-9">
                    <input type="number" id="sort" name="sort" min="0"
                        class="form-control @error('sort') is-invalid @enderror"
                        value="{{ old('sort', $menu_data->sort ?? '') }}">
                    @error('sort')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Status -->
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label" for="status">Status<span class="text-danger">*</span></label>
                <div class="col-sm-9">
                    <div class="form-check form-switch">
                       <input type="hidden" name="status" value="0">
                        <input class="form-check-input" type="checkbox" id="status" name="status" value="1"
                            {{ old('status', $menu_data->status ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="status">Active</label>
                    </div>
                    @error('status')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <!-- Submit / Cancel -->
            <div class="mt-4 row justify-content-end">
                <div class="col-sm-9">
                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('.select2').select2({
            placeholder: "-- Choose --",
            allowClear: true,
            width: '100%'
        });
    });
</script>
@endpush