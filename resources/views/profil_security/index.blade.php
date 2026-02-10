@extends('layout.public.main')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css"/>
<style>
    .avatar-wrapper {
        position: relative;
        width: 140px;
        height: 140px;
        margin: auto;
    }
    .avatar-wrapper img {
        width: 140px;
        height: 140px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #f1f1f1;
    }
    .avatar-wrapper label {
        position: absolute;
        bottom: 0;
        right: 0;
        background: #696cff;
        color: #fff;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">

                    <h4 class="text-center fw-bold mb-4">My Profile</h4>

                    <form method="POST"
                          action="{{ route('profil_security.store') }}"
                          enctype="multipart/form-data">
                        @csrf

                        {{-- Avatar --}}
                        <div class="avatar-wrapper mb-4">
                            <img id="uploadedAvatar"
                                 src="{{ Auth::user()->foto == '1.png'
                                    ? asset('assets/img/avatars/' . Auth::user()->foto)
                                    : asset('storage/uploads/avatars/' . Auth::user()->foto) }}">

                            <label for="upload">
                               <i class="bi bi-camera-fill"></i>
                                <input type="file" id="upload" hidden accept="image/*">
                            </label>
                        </div>

                        {{-- hidden cropped --}}
                        <input type="file" name="foto" id="croppedImage" hidden>

                        {{-- Name --}}
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   value="{{ old('name', Auth::user()->name) }}">
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email"
                                   name="email"
                                   class="form-control"
                                   value="{{ old('email', Auth::user()->email) }}">
                        </div>

                        {{-- Phone --}}
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text"
                                   name="phone"
                                   class="form-control"
                                   value="{{ old('phone', Auth::user()->phone) }}">
                        </div>

                        {{-- Address --}}
                        <div class="mb-4">
                            <label class="form-label">Address</label>
                            <textarea name="address"
                                      class="form-control"
                                      rows="2">{{ old('address', Auth::user()->address) }}</textarea>
                        </div>

                        <button class="btn btn-primary w-100">
                            Save Profile
                        </button>

                    </form>

                </div>
            </div>

        </div>
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
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>

<script>
let cropper;
const uploadInput = document.getElementById('upload');
const imageToCrop = document.getElementById('imageToCrop');
const avatar      = document.getElementById('uploadedAvatar');
const cropped     = document.getElementById('croppedImage');
const modal       = new bootstrap.Modal(document.getElementById('cropperModal'));

uploadInput.addEventListener('change', e => {
    const file = e.target.files[0];
    if(!file) return;

    const reader = new FileReader();
    reader.onload = ev => {
        imageToCrop.src = ev.target.result;
        modal.show();
    };
    reader.readAsDataURL(file);
});

document.getElementById('cropperModal')
.addEventListener('shown.bs.modal', () => {
    cropper = new Cropper(imageToCrop, {
        aspectRatio: 1,
        viewMode: 1
    });
});

document.getElementById('cropperModal')
.addEventListener('hidden.bs.modal', () => cropper?.destroy());

document.getElementById('cropAndSave').onclick = () => {
    const canvas = cropper.getCroppedCanvas({width:400,height:400});
    canvas.toBlob(blob => {
        avatar.src = URL.createObjectURL(blob);

        const file = new File([blob],'avatar.jpg',{type:'image/jpeg'});
        const dt = new DataTransfer();
        dt.items.add(file);
        cropped.files = dt.files;

        modal.hide();
    });
};
</script>
@endpush
