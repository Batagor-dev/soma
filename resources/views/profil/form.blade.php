@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Dashboard';

    if (isset($profil_data)) {
        // dd('tes');
        $breadcrumb_parent = Breadcrumbs::generate(Request::route()->getName(), $profil_data)
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
        {{ isset($profil_data) ? Breadcrumbs::render(Request::route()->getName(), $profil_data) : Breadcrumbs::render(Request::route()->getName()) }}
        <div class="card mb-6">
            <form class="card-body" method="POST" action="{{ $action }}" enctype="multipart/form-data">
                @isset($profil_data) @method('PUT') @endisset
                @csrf
                {{-- Title --}}
                <div class="row mb-4">
                    <label class="col-sm-3 col-form-label" for="judul">judul</label>
                    <div class="col-sm-9">
                        <input type="text"
                            id="judul"
                            name="judul"
                            class="form-control @error('judul') is-invalid @enderror"
                            value="{{ old('judul', $profil_data->judul ?? '') }}"
                            placeholder="judul">
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="row mb-4">
                    <label class="col-sm-3 col-form-label" for="deskripsi">Deskripsi</label>
                    <div class="col-sm-9">
                        <textarea
                            id="deskripsi"
                            name="deskripsi"
                            rows="5"
                            class="form-control @error('deskripsi') is-invalid @enderror"
                            placeholder="Masukkan deskripsi...">{{ old('deskripsi', $profil_data->deskripsi ?? '') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Poin --}}
                <div class="row mb-4">
                    <label class="col-sm-3 col-form-label">Poin Komunitas</label>
                    <div class="col-sm-9">

                        <div id="poin-wrapper">

                            @php
                                $poinOld = old('poin', $profil_data->poin ?? []);
                            @endphp

                            @forelse($poinOld as $index => $poin)
                                <div class="card mb-3 poin-item">
                                    <div class="card-body">

                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label>Icon Bootstrap</label>
                                                <input type="text"
                                                    name="poin[{{ $index }}][icon]"
                                                    class="form-control"
                                                    placeholder="bi-people"
                                                    value="{{ $poin['icon'] ?? '' }}">
                                            </div>

                                            <div class="col-md-4">
                                                <label>Judul</label>
                                                <input type="text"
                                                    name="poin[{{ $index }}][judul]"
                                                    class="form-control"
                                                    placeholder="Judul poin"
                                                    value="{{ $poin['judul'] ?? '' }}">
                                            </div>

                                            <div class="col-md-4">
                                                <label>Deskripsi</label>
                                                <input type="text"
                                                    name="poin[{{ $index }}][deskripsi]"
                                                    class="form-control"
                                                    placeholder="Deskripsi poin"
                                                    value="{{ $poin['deskripsi'] ?? '' }}">
                                            </div>
                                        </div>

                                        <button type="button" class="btn btn-sm btn-danger remove-poin">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>

                                    </div>
                                </div>
                            @empty
                                {{-- kosong, nanti diisi via JS --}}
                            @endforelse

                        </div>

                        <button type="button" class="btn btn-outline-primary" id="add-poin">
                            <i class="bi bi-plus"></i> Tambah Poin
                        </button>

                        @error('poin')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror

                    </div>
                </div>

                {{-- Photo --}}
                <div class="row mb-4">
                    <label class="col-sm-3 col-form-label" for="photo">Photo</label>
                    <div class="col-sm-9">
                        <input
                            type="file"
                            id="photo"
                            name="photo"
                            accept="image/*"
                            class="form-control @error('photo') is-invalid @enderror">

                        @error('photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        {{-- Preview foto lama --}}
                    @if(isset($profil_data) && $profil_data->photo)
                    <div class="mt-3 old-photo-wrapper">
                        <img src="{{ asset('storage/' . $profil_data->photo) }}"
                            class="rounded old-photo-preview"
                            style="width: 120px; height: 120px; object-fit: cover;">
                    </div>
                @endif


                        {{-- Preview foto baru --}}
                        <div class="mt-3 d-none" id="new-photo-preview">
                            <img src="" class="rounded" style="width: 120px; height: 120px; object-fit: cover;">
                        </div>
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
    {{-- JS preview foto --}}
    <script>
    document.addEventListener('DOMContentLoaded', function () {

        let poinIndex = {{ count(old('poin', $profil_data->poin ?? [])) }};

        document.getElementById('add-poin').addEventListener('click', function () {

            const wrapper = document.getElementById('poin-wrapper');

            const html = `
                <div class="card mb-3 poin-item">
                    <div class="card-body">

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Icon Bootstrap</label>
                                <input type="text"
                                    name="poin[${poinIndex}][icon]"
                                    class="form-control"
                                    placeholder="bi-people">
                            </div>

                            <div class="col-md-4">
                                <label>Judul</label>
                                <input type="text"
                                    name="poin[${poinIndex}][judul]"
                                    class="form-control"
                                    placeholder="Judul poin">
                            </div>

                            <div class="col-md-4">
                                <label>Deskripsi</label>
                                <input type="text"
                                    name="poin[${poinIndex}][deskripsi]"
                                    class="form-control"
                                    placeholder="Deskripsi poin">
                            </div>
                        </div>

                        <button type="button" class="btn btn-sm btn-danger remove-poin">
                            <i class="bi bi-trash"></i> Hapus
                        </button>

                    </div>
                </div>
            `;

            wrapper.insertAdjacentHTML('beforeend', html);
            poinIndex++;
        });

        document.addEventListener('click', function (e) {
            if (e.target.closest('.remove-poin')) {
                e.target.closest('.poin-item').remove();
            }
        });
    });
    </script>

@endpush