@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Article Categories';

    if (isset($article_categories_data)) {
        $breadcrumb_parent = Breadcrumbs::generate(Request::route()->getName(), $article_categories_data)
            ->where('title', '!=', $breadcrumb->title)
            ->last();
    } else {
        $breadcrumb_parent = Breadcrumbs::generate(Request::route()->getName())
            ->where('title', '!=', $breadcrumb->title)
            ->last();
    }
@endphp

@extends('layout.backend.main', [
    'title'     => $sub_title . ' | ' . config('app.name'),
    'sub_title' => $sub_title,
])

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card mb-6">
        <form class="card-body" method="POST" action="{{ $action }}">
            @csrf
            @isset($article_categories_data) @method('PUT') @endisset

            <!-- Category Name -->
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label" for="name">
                    Category Name <span class="text-danger">*</span>
                </label>
                <div class="col-sm-9">
                    <input type="text" id="name" name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $article_categories_data->name ?? '') }}"
                        placeholder="Category name" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Submit / Cancel -->
            <div class="mt-4 row justify-content-end">
                <div class="col-sm-9">
                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                    <a href="{{ $breadcrumb_parent?->url ?? route('article_categories.index') }}" class="btn btn-outline-secondary">
                        Cancel
                    </a>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection

@push('scripts')
    {{-- SweetAlert otomatis --}}
    @if(session('success'))
        <script>
            Swal.fire({ icon: 'success', title: 'Success', text: "{{ session('success') }}" });
        </script>
    @endif

    @if(session('error'))
        <script>
            Swal.fire({ icon: 'error',   title: 'Error',  text: "{{ session('error') }}" });
        </script>
    @endif
@endpush
