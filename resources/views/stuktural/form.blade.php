@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Dashboard';

    if (isset($stuktural_data)) {
        $breadcrumb_parent = Breadcrumbs::generate(Request::route()->getName(), $stuktural_data)
            ->where('title', '!=', $breadcrumb->title)
            ->last();
    } else {
        $breadcrumb_parent = Breadcrumbs::generate(Request::route()->getName())
            ->where('title', '!=', $breadcrumb->title)
            ->last();
    }
@endphp

@extends('layout.backend.main', [
    'title' => 'Dashboard | ' . config('app.name'),
    'sub_title' => $sub_title,
])

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    {{ isset($stuktural_data) ? Breadcrumbs::render(Request::route()->getName(), $stuktural_data) : Breadcrumbs::render(Request::route()->getName()) }}

    <div class="card mb-6">
        <form class="card-body" method="POST" action="{{ $action }}" enctype="multipart/form-data">
            @isset($stuktural_data) @method('PUT') @endisset
            @csrf

            {{-- UNIT --}}
            <div class="row mb-4">
                <label class="col-sm-3 col-form-label" for="unit">Unit</label>
                <div class="col-sm-9">
                    <input type="text" id="unit" name="unit"
                           value="{{ old('unit', $stuktural_data->unit ?? '') }}"
                           class="form-control @error('unit') is-invalid @enderror">
                    @error('unit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            {{-- JABATAN --}}
            <div class="row mb-4">
                <label class="col-sm-3 col-form-label" for="jabatan">Jabatan</label>
                <div class="col-sm-9">
                    <input type="text" id="jabatan" name="jabatan"
                           value="{{ old('jabatan', $stuktural_data->jabatan ?? '') }}"
                           class="form-control @error('jabatan') is-invalid @enderror">
                    @error('jabatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            {{-- NAME --}}
            <div class="row mb-4">
                <label class="col-sm-3 col-form-label" for="name">Nama</label>
                <div class="col-sm-9">
                    <input type="text" id="name" name="name"
                           value="{{ old('name', $stuktural_data->name ?? '') }}"
                           class="form-control @error('name') is-invalid @enderror">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            {{-- FOTO + CROPPER --}}
            <div class="row mb-4">
                <label class="col-sm-3 col-form-label">Foto</label>
                <div class="col-sm-9">

                    @if(isset($stuktural_data) && $stuktural_data->photo)
                        <div class="mb-3 old-photo-wrapper">
                            <img src="{{ asset('storage/uploads/stuktural/' . $stuktural_data->photo) }}"
                                class="rounded old-photo-preview"
                                style="width: 80px; height: 80px; object-fit: cover;">
                        </div>
                    @endif

                    {{-- Preview hasil crop --}}
                    <div class="mb-3">
                        <img id="preview-cropped" class="rounded d-none"
                             style="width: 120px; height: 120px; object-fit: cover;">
                    </div>

                    {{-- Input file --}}
                    <input type="file" id="photo-input" accept="image/*"
                        class="form-control @error('photo') is-invalid @enderror">
                    @error('photo') <div class="invalid-feedback">{{ $message }}</div> @enderror

                    {{-- Hidden hasil crop --}}
                    <input type="hidden" name="photo" id="photo-cropped-hidden">

                    <small class="text-muted">Format: JPG, JPEG, PNG, WEBP • Max 2MB</small>
                </div>
            </div>

            {{-- SUBMIT --}}
            <div class="pt-6">
                <div class="row justify-content-end">
                    <div class="col-sm-9">
                        <button type="submit" class="btn btn-primary me-4">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary"
                                onclick="window.location.href='{{ $breadcrumb_parent->url }}'">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>

<!-- Modal Cropper -->
<div class="modal fade" id="cropperModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <!-- HEADER -->
            <div class="modal-header">
                <h5 class="modal-title fw-semibold">
                    <i class="bx bx-crop me-2"></i> Crop Foto Profil
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body">
                <div class="cropper-container" style="height: 500px; overflow: hidden; position: relative;">
                    <img id="cropper-image" class="img-fluid w-100 h-100" style="object-fit: contain;">
                </div>
            </div>

            <!-- FOOTER -->
            <div class="modal-footer justify-content-between">
                <div class="d-flex align-items-center">
                    <button type="button" class="btn btn-sm btn-outline-secondary me-2" id="rotate-left">
                        <i class="bx bx-rotate-left"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="rotate-right">
                        <i class="bx bx-rotate-right"></i>
                    </button>
                </div>

                <div class="text-muted small">
                    Ratio: 1:1
                </div>

                <div>
                    <button type="button" class="btn btn-outline-secondary me-2"
                        data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="button" id="crop-btn" class="btn btn-primary">
                        Crop & Simpan
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .cropper-container {
        background-color: #f8f9fa;
        border-radius: 8px;
        margin-bottom: 1rem;
    }
    
    .cropper-view-box,
    .cropper-face {
        border-radius: 50%;
    }
    
    .cropper-view-box {
        outline: 2px solid #007bff;
        outline-color: rgba(0, 123, 255, 0.75);
    }
    
    .cropper-line {
        background-color: #007bff;
    }
    
    .cropper-point {
        background-color: #007bff;
        width: 10px;
        height: 10px;
    }
</style>
@endpush

@push('scripts')
    <script>
        let cropper;

        const input        = document.getElementById('photo-input');
        const modalEl      = document.getElementById('cropperModal');
        const modal        = new bootstrap.Modal(modalEl);
        const image        = document.getElementById('cropper-image');
        const preview      = document.getElementById('preview-cropped');
        const hiddenInput  = document.getElementById('photo-cropped-hidden');
        const cropBtn      = document.getElementById('crop-btn');
        const rotateLeft   = document.getElementById('rotate-left');
        const rotateRight  = document.getElementById('rotate-right');

        input.addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (!file) return;

            // Validasi ukuran file (max 2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file maksimal 2MB');
                input.value = '';
                return;
            }

            // Validasi tipe file
            const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
            if (!validTypes.includes(file.type)) {
                alert('Format file harus JPG, JPEG, PNG, atau WEBP');
                input.value = '';
                return;
            }

            // hide foto lama kalau ada
            document.querySelector('.old-photo-wrapper')?.classList.add('d-none');

            // Hapus cropper lama jika ada
            if (cropper) {
                cropper.destroy();
            }

            image.src = URL.createObjectURL(file);
            modal.show();
        });

        modalEl.addEventListener('shown.bs.modal', function () {
            cropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 1,
                dragMode: 'move',
                autoCropArea: 1,
                responsive: true,
                restore: false,
                center: true,
                highlight: false,
                cropBoxMovable: true,
                cropBoxResizable: true,
                toggleDragModeOnDblclick: false,
                minContainerWidth: 400,
                minContainerHeight: 400,
                ready: function() {
                    // Reset posisi crop box ke tengah
                    const containerData = cropper.getContainerData();
                    const cropBoxData = {
                        width: Math.min(containerData.width, containerData.height),
                        height: Math.min(containerData.width, containerData.height),
                    };
                    
                    cropper.setCropBoxData({
                        left: (containerData.width - cropBoxData.width) / 2,
                        top: (containerData.height - cropBoxData.height) / 2,
                        width: cropBoxData.width,
                        height: cropBoxData.height
                    });
                }
            });
        });

        modalEl.addEventListener('hidden.bs.modal', function () {
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
            
            // Reset input file
            input.value = '';
            
            // Hapus URL object
            if (image.src.startsWith('blob:')) {
                URL.revokeObjectURL(image.src);
            }
        });

        // Rotate kiri
        rotateLeft.addEventListener('click', function() {
            if (cropper) {
                cropper.rotate(-90);
            }
        });

        // Rotate kanan
        rotateRight.addEventListener('click', function() {
            if (cropper) {
                cropper.rotate(90);
            }
        });

        cropBtn.addEventListener('click', function () {
            if (!cropper) return;

            const canvas = cropper.getCroppedCanvas({
                width: 500,
                height: 500,
                fillColor: '#fff',
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high'
            });

            // Konversi ke base64 dengan kualitas 0.9 (90%)
            const base64 = canvas.toDataURL('image/jpeg', 0.9);

            // Tampilkan preview
            preview.src = base64;
            preview.classList.remove('d-none');

            // Simpan ke hidden input
            hiddenInput.value = base64;

            // Tutup modal
            modal.hide();
        });
    </script>
@endpush