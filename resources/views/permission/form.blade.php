@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Dashboard';

    if (isset($permission_data)) {
        // dd('tes');
        $breadcrumb_parent = Breadcrumbs::generate(Request::route()->getName(), $permission_data)
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
         {{ isset($permission_data) ? Breadcrumbs::render(Request::route()->getName(), $permission_data) : Breadcrumbs::render(Request::route()->getName()) }}
        <div class="card mb-6">
            <form class="card-body" method="POST" action="{{ $action }}">
                @isset($permission_data) @method('PUT') @endisset
                @csrf

                <!-- Name -->
                <div class="row mb-4">
                    <label class="col-sm-3 col-form-label" for="name">Name</label>
                    <div class="col-sm-9">
                        <input type="text" 
                            id="name"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $permission_data->name ?? '') }}"
                            placeholder="Name"/>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Permission Group -->
                <div class="row mb-4">
                    <label class="col-sm-3 col-form-label" for="permission_group_id">Permission Group</label>
                    <div class="col-sm-9">
                        <div class="form-floating form-floating-outline">
                            <select id="permission_group_id" name="permission_group_id" class="select2 form-select" data-allow-clear="true">
                                <option value="">-- Select Permission Group --</option>
                                @foreach($permissiongroups as $group)
                                    <option value="{{ $group->id }}"
                                        {{ old('permission_group_id', $permission_data->permission_group_id ?? '') == $group->id ? 'selected' : '' }}>
                                        {{ $group->name }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="permission_group_id">Permission Group</label>
                        </div>
                        @error('permission_group_id')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Guard -->
                <div class="row mb-4">
                    <label class="col-sm-3 col-form-label" for="guard_name">Guard</label>
                    <div class="col-sm-9">
                        <input type="text" 
                            id="guard_name"
                            name="guard_name"
                            class="form-control @error('guard_name') is-invalid @enderror"
                            value="{{ old('guard_name', $permission_data->guard_name ?? '') }}"
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

@push('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "-- Select Permission Group --",
            allowClear: true
        });
    });
</script>
@endpush