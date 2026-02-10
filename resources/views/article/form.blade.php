@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Articles';

    if (isset($article_data)) {
        $breadcrumb_parent = Breadcrumbs::generate(Request::route()->getName(), $article_data)
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
        <form class="card-body" method="POST" action="{{ $action }}" enctype="multipart/form-data">
            @csrf
            @isset($article_data) @method('PUT') @endisset

            <!-- Category -->
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label" for="article_category_id">Category <span class="text-danger">*</span></label>
                <div class="col-sm-9">
                    <select id="article_category_id" name="article_category_id"
                        class="form-select select2 @error('article_category_id') is-invalid @enderror"
                        data-allow-clear="true">

                        <option value="" {{ old('article_category_id', $article_data->article_category_id ?? '') == '' ? 'selected' : '' }}>
                            -- Pilih Category --
                        </option>

                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('article_category_id', $article_data->article_category_id ?? '') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('article_category_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <!-- Title -->
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label" for="title">Title <span class="text-danger">*</span></label>
                <div class="col-sm-9">
                    <input type="text" id="title" name="title"
                        class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title', $article_data->title ?? '') }}" placeholder="Article Title">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Published At -->
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label" for="published_at">Published at</label>
                <div class="col-sm-9">
                    <input type="text" id="published_at" name="published_at"
                        class="form-control flatpickr @error('published_at') is-invalid @enderror"
                        value="{{ old('published_at', isset($article_data->published_at) ? date('d-m-Y', strtotime($article_data->published_at)) : '') }}"
                        placeholder="DD-MM-YYYY" autocomplete="off">
                    @error('published_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Highlite -->
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label" for="highlite">Highlite</label>
                <div class="col-sm-9">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="highlite" id="highlite" value="1"
                            {{ old('highlite', $article_data->highlite ?? false) ? 'checked' : '' }}>
                    </div>
                    @error('highlite')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Tags (Tagify) -->
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label" for="tags">Tags</label>
                <div class="col-sm-9">
                    <div class="form-floating form-floating-outline">
                        <input id="tags"
                            class="form-control @error('tags') is-invalid @enderror"
                            name="tags"
                            value="{{ old('tags', $article_data->tags ?? '') }}"
                            placeholder="Article tags">
                        <label for="tags">Tags</label>
                    </div>
                    @error('tags')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Image -->
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label" for="image">Image</label>
                <div class="col-sm-9">
                    <input type="file" id="image" name="image"
                        class="form-control @error('image') is-invalid @enderror" onchange="previewImage()">
                    <img class="img-preview img-fluid mt-3"
                        @isset($article_data) src="{{ asset('storage/'.$article_data->image_path) }}" @endisset
                        style="max-height: 150px; max-width: 150px;"/>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Content -->
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label" for="content">Content</label>
                <div class="col-sm-9">
                    <textarea id="content" name="content" rows="10"
                        class="form-control @error('content') is-invalid @enderror">{{ old('content', $article_data->content ?? '') }}</textarea>
                    @error('content')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Submit / Cancel -->
            <div class="mt-4 row justify-content-end">
                <div class="col-sm-9">
                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                    <a href="{{ $breadcrumb_parent?->url ?? route('articles.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection

@push('scripts')
    {{-- CKEditor CDN --}}
    <script src="https://cdn.ckeditor.com/4.25.1-lts/standard/ckeditor.js"></script>

    {{-- Flatpickr CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <script>
        // CKEditor aktif di field content
        CKEDITOR.replace('content');

        // Preview gambar
        function previewImage() {
            const image = document.querySelector('#image');
            const imgPreview = document.querySelector('.img-preview');
            imgPreview.style.display = 'block';
            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);
            oFReader.onload = e => imgPreview.src = e.target.result;
        }

        // Flatpickr untuk published_at
        flatpickr("#published_at", {
            dateFormat: "d-m-Y",
            allowInput: true
        });
    </script>

    {{-- SweetAlert otomatis --}}
    @if(session('success'))
        <script>
            Swal.fire({ icon: 'success', title: 'Success', text: "{{ session('success') }}" });
        </script>
    @endif

    @if(session('error'))
        <script>
            Swal.fire({ icon: 'error', title: 'Error', text: "{{ session('error') }}" });
        </script>
    @endif

    <script>
        $(document).ready(function () {
            $('.select2').select2({
                placeholder: "-- Choose --",
                allowClear: true,
                width: '100%'
            });
        });
    </script>

<script>
    /* ---------- Tagify keyword ---------- */
    const keywordInput = document.querySelector('#keyword');
    const tagifyKeyword = new Tagify(keywordInput, {
        originalInputValueFormat: valuesArr => valuesArr.map(item => item.value).join(',')
    });

    /* ---------- Tagify tags ---------- */
    const tagsInput = document.querySelector('#tags');
    const tagifyTags = new Tagify(tagsInput, {
        originalInputValueFormat: valuesArr => valuesArr.map(item => item.value).join(',')
    });

    /* ---------- Preview favicon ---------- */
    function previewImage(input){
        const prev = document.getElementById('prev');
        if(input.files && input.files[0]){
            const r = new FileReader();
            r.onload = e => prev.src = e.target.result;
            r.readAsDataURL(input.files[0]);
        }
    }

    /* ---------- Description counter ------ */
    const desc = document.getElementById('description');
    const cnt  = document.getElementById('count');
    const max  = 160;

    function setCount() {
        const remaining = max - desc.value.length;
        cnt.textContent = remaining > 0 ? remaining : 0;
    }
    setCount();
    desc.addEventListener('input', setCount);
</script>

@endpush
