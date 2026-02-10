@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Dashboard';
@endphp

@extends('layout.backend.main', [
    'title'     => 'User | ' . config('app.name'),
    'sub_title' => $sub_title
])

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css"/>
@endpush

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    {{ Breadcrumbs::render(Request::route()->getName()) }}

    <div class="row">
        <div class="col-md-12">
            <div class="nav-align-top">
                <ul class="nav nav-pills flex-column flex-md-row mb-6 gap-2 gap-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="javascript:void(0);">
                            <i class="icon-base ri ri-group-line icon-sm me-2"></i>Account
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('acount.security') }}">
                            <i class="icon-base ri ri-lock-line icon-sm me-2"></i>Security
                        </a>
                    </li>
                </ul>
            </div>

            <div class="card mb-6">
                <div class="card-body">
                    <form id="formAccountSettings"
                          method="POST"
                          action="{{ route('acount.store') }}"
                          enctype="multipart/form-data">
                        @csrf

                        {{-- Avatar --}}
                        <div class="d-flex align-items-start align-items-sm-center gap-6 mb-4">
                            <img src="{{ Auth::user()->foto == '1.png'
                                    ? asset('assets/img/avatars/' . Auth::user()->foto)
                                    : asset('storage/uploads/avatars/' . Auth::user()->foto) }}"
                                 alt="user-avatar"
                                 class="d-block w-px-100 h-px-100 rounded-4"
                                 id="uploadedAvatar" />
                            <div class="button-wrapper">
                                <label for="upload" class="btn btn-primary me-3 mb-4" tabindex="0">
                                    <span class="d-none d-sm-block">Upload new photo</span>
                                    <i class="ri-upload-2-line d-block d-sm-none"></i>
                                    {{-- TIDAK pakai name="foto" --}}
                                    <input type="file" id="upload" hidden accept="image/*" />
                                </label>
                                <div class="form-text">Allowed JPG, PNG. Max size 2 MB.</div>
                            </div>
                        </div>

                        {{-- Modal Cropper --}}
                        <div class="modal fade" id="cropperModal" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">Crop Photo (1:1)</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                              </div>
                              <div class="modal-body text-center">
                                <div style="max-height:400px;">
                                  <img id="imageToCrop" src="" class="img-fluid" />
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary" id="cropAndSave">Crop & Save</button>
                              </div>
                            </div>
                          </div>
                        </div>

                        {{-- Hidden field untuk hasil crop --}}
                        <input type="file" name="foto" id="croppedImage" hidden>

                        {{-- Fields --}}
                        <div class="row g-5">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control @error('name') is-invalid @enderror"
                                           type="text" id="name" name="name"
                                           value="{{ old('name', Auth::user()->name) }}" />
                                    <label for="name">Full Name</label>
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control @error('email') is-invalid @enderror"
                                           type="email" id="email" name="email"
                                           value="{{ old('email', Auth::user()->email) }}" />
                                    <label for="email">E-mail</label>
                                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <select id="gender" name="gender" class="form-select select2">
                                        <option value="">-- Choose --</option>
                                        <option value="L" {{ old('gender', Auth::user()->gender) === 'L' ? 'selected' : '' }}>Male</option>
                                        <option value="P" {{ old('gender', Auth::user()->gender) === 'P' ? 'selected' : '' }}>Female</option>
                                    </select>
                                    <label for="gender">Gender</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control @error('phone') is-invalid @enderror"
                                           type="text" id="phone" name="phone"
                                           value="{{ old('phone', Auth::user()->phone) }}" />
                                    <label for="phone">Phone Number</label>
                                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating form-floating-outline">
                                    <textarea class="form-control @error('address') is-invalid @enderror"
                                              id="address" name="address"
                                              rows="2">{{ old('address', Auth::user()->address) }}</textarea>
                                    <label for="address">Address</label>
                                    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="btn btn-primary me-3">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>

@if(session('success'))
<script>Swal.fire({icon:'success',title:'Success',text:"{{ session('success') }}"});</script>
@endif
@if(session('error'))
<script>Swal.fire({icon:'error',title:'Error',text:"{{ session('error') }}"});</script>
@endif

<script>
let cropper;
const uploadInput   = document.getElementById('upload');
const imageToCrop   = document.getElementById('imageToCrop');
const uploadedAvatar= document.getElementById('uploadedAvatar');
const croppedInput  = document.getElementById('croppedImage'); // name="foto"
const cropperModal  = new bootstrap.Modal(document.getElementById('cropperModal'));

uploadInput.addEventListener('change', e => {
    const file = e.target.files[0];
    if(!file) return;
    const reader = new FileReader();
    reader.onload = evt => {
        imageToCrop.src = evt.target.result;
        cropperModal.show();
    };
    reader.readAsDataURL(file);
});

document.getElementById('cropperModal')
        .addEventListener('shown.bs.modal', () => {
            cropper = new Cropper(imageToCrop, {
                aspectRatio : 1,
                viewMode    : 1,
                minContainerWidth : 300,
                minContainerHeight: 300
            });
});
document.getElementById('cropperModal')
        .addEventListener('hidden.bs.modal', () => cropper?.destroy());

document.getElementById('cropAndSave').addEventListener('click', () => {
    if(!cropper) return;

    canvas = cropper.getCroppedCanvas({ width: 400, height: 400 });
    canvas.toBlob(blob => {
        // preview
        uploadedAvatar.src = URL.createObjectURL(blob);

        // masukkan ke input name="foto"
        const file = new File([blob], 'avatar.jpg', {type:'image/jpeg'});
        const dt   = new DataTransfer();
        dt.items.add(file);
        croppedInput.files = dt.files;

        cropperModal.hide();
    }, 'image/jpeg', 0.9);
});
</script>
@endpush