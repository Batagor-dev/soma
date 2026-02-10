@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Dashboard';
    $breadcrumb_parent = Breadcrumbs::generate(Request::route()->getName(), $user)
                                   ->where('title', '!=', $breadcrumb->title)->last();
@endphp

@extends('layout.backend.main', [
    'title'     => 'Dashboard | '.config('app.name'),
    'sub_title' => $sub_title,
])

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    {{ Breadcrumbs::render(Request::route()->getName(), $user) }}
    <form class="card-body" method="POST" action="{{ $action }}">
        @csrf
        @method('PUT')
        <div class="card mb-6">
            <div class="card-header">
                <h5 class="card-title mb-0">{{$sub_title}}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <label class="col-sm-3 col-form-label" for="roles">Roles</label>
                    <div class="col-sm-9">
                        <div class="form-floating form-floating-outline">
                            <select id="roles" name="roles[]" class="select2 form-select" multiple
                                    data-placeholder="-- Pilih Role --">
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}"   {{-- <-- penting --}}
                                        {{ in_array($role->name, old('roles', $user->roles->pluck('name')->toArray())) ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="roles">Roles</label>
                        </div>
                        @error('roles')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                {{-- button --}}
                <div class="pt-6">
                    <div class="row justify-content-end">
                        <div class="col-sm-9">
                            <button type="submit" class="btn btn-primary me-4">Submit</button>
                            <button type="reset" class="btn btn-outline-secondary" onclick="window.location.href='{{ $breadcrumb_parent->url }}'">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    $(function () {
        $('.select2').select2({
            placeholder: $(this).data('placeholder') || '-- Select --',
            allowClear: true,
            closeOnSelect: false
        });
    });
</script>
@endpush