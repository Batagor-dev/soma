@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Dashboard';
@endphp

@extends('layout.backend.main', ['title' => 'User | ' . config('app.name'), 'sub_title' => $sub_title
])

@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                {{ Breadcrumbs::render(Request::route()->getName()) }}
            </div>
        </div>
    </div>
</div>

<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <form class="form theme-form" method="post" action="{{ $action }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col">

                                <!-- Title -->
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="title">Title</label>
                                    <div class="col-sm-9">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text"
                                                   class="form-control @error('title') is-invalid @enderror"
                                                   id="title"
                                                   name="title"
                                                   placeholder="Site title"
                                                   value="{{ old('title', $title ?? '') }}">
                                            <label for="title">Title</label>
                                        </div>
                                        @error('title')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Keyword (Tagify) -->
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="keyword">Keyword</label>
                                    <div class="col-sm-9">
                                        <div class="form-floating form-floating-outline">
                                            <input id="keyword"
                                                   class="form-control @error('keyword') is-invalid @enderror"
                                                   name="keyword"
                                                   value="{{ old('keyword', $keyword ?? '') }}">
                                            <label for="keyword">Keyword</label>
                                        </div>
                                        @error('keyword')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Author -->
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="author">Author</label>
                                    <div class="col-sm-9">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text"
                                                   class="form-control @error('author') is-invalid @enderror"
                                                   id="author"
                                                   name="author"
                                                   placeholder="Author name"
                                                   value="{{ old('author', $author ?? '') }}">
                                            <label for="author">Author</label>
                                        </div>
                                        @error('author')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Favicon -->
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Favicon</label>
                                    <div class="col-sm-9">
                                        <input type="file"
                                               name="favicon"
                                               class="form-control mb-2 @error('favicon') is-invalid @enderror"
                                               onchange="previewImage(this)">
                                        <img id="prev"
                                             class="img-fluid"
                                             style="max-height: 36px; max-width: 36px;"
                                             src="{{ isset($favicon) ? asset('storage/'.$favicon) : asset('images/no-image.png') }}"
                                             alt="favicon">
                                        @error('favicon')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="description">Description</label>
                                    <div class="col-sm-9">
                                        <div class="form-floating form-floating-outline">
                                            <textarea class="form-control @error('description') is-invalid @enderror"
                                                      id="description"
                                                      name="description"
                                                      placeholder="Description"
                                                      style="height: 124px">{{ old('description', $description ?? '') }}</textarea>
                                            <label for="description">Description</label>
                                        </div>
                                        <div class="form-text">Remaining characters: <span id="count">160</span></div>
                                        @error('description')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-end">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    /* ---------- Tagify keyword ---------- */
    const keywordInput = document.querySelector('#keyword');
    const tagify = new Tagify(keywordInput, {
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