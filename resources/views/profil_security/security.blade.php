@extends('layout.public.main')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-5">

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">

                    <h4 class="fw-bold text-center mb-4">
                        Security Settings
                    </h4>

                    <form method="POST" action="{{ route('profil_security.password') }}">
                        @csrf

                        {{-- Current Password --}}
                        <div class="mb-3">
                            <label class="form-label">Current Password</label>
                            <div class="input-group">
                                <input type="password"
                                       name="currentPassword"
                                       class="form-control @error('currentPassword') is-invalid @enderror">
                                <span class="input-group-text cursor-pointer toggle-password">
                                    <i class="ri-eye-off-line"></i>
                                </span>
                            </div>
                            @error('currentPassword')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- New Password --}}
                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <div class="input-group">
                                <input type="password"
                                       name="newPassword"
                                       class="form-control @error('newPassword') is-invalid @enderror">
                                <span class="input-group-text cursor-pointer toggle-password">
                                    <i class="ri-eye-off-line"></i>
                                </span>
                            </div>
                            @error('newPassword')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Confirm Password --}}
                        <div class="mb-4">
                            <label class="form-label">Confirm New Password</label>
                            <div class="input-group">
                                <input type="password"
                                       name="newPassword_confirmation"
                                       class="form-control">
                                <span class="input-group-text cursor-pointer toggle-password">
                                    <i class="ri-eye-off-line"></i>
                                </span>
                            </div>
                        </div>

                        {{-- Info --}}
                        <div class="alert alert-light border small mb-4">
                            <ul class="mb-0 ps-3">
                                <li>Minimum 8 characters</li>
                                <li>At least one lowercase letter</li>
                                <li>At least one number or symbol</li>
                            </ul>
                        </div>

                        <button class="btn btn-primary w-100">
                            Update Password
                        </button>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: "{{ session('success') }}"
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: "{{ session('error') }}"
    });
</script>
@endif

<script>
    document.querySelectorAll('.toggle-password').forEach(btn => {
        btn.addEventListener('click', () => {
            const input = btn.previousElementSibling;
            const icon  = btn.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('ri-eye-off-line','ri-eye-line');
            } else {
                input.type = 'password';
                icon.classList.replace('ri-eye-line','ri-eye-off-line');
            }
        });
    });
</script>
@endpush
