@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Dashboard';
@endphp

@extends('layout.backend.main', ['title' => 'User | ' . config('app.name'), 'sub_title' => $sub_title
])

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    {{-- Breadcrumbs --}}
    {{ Breadcrumbs::render(Request::route()->getName()) }}

    <div class="row">
        <div class="col-md-12">

            {{-- Nav tabs --}}
            <div class="nav-align-top">
                <ul class="nav nav-pills flex-column flex-md-row mb-6 gap-2 gap-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('acount.index') }}">
                            <i class="icon-base ri ri-group-line icon-sm me-2"></i>
                            Account
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="javascript:void(0);">
                            <i class="icon-base ri ri-lock-line icon-sm me-2"></i>
                            Security
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Change-Password card --}}
            <div class="card mb-6">
                <h5 class="card-header">Change Password</h5>

                <div class="card-body pt-1">
                    <form id="formSecurity" method="POST" action="{{ route('acount.password') }}">
                        @csrf

                        {{-- Current Password --}}
                        <div class="mb-4 form-password-toggle form-control-validation">
                            <div class="input-group input-group-merge">
                                <div class="form-floating form-floating-outline lex-grow-1">
                                    <input type="password"
                                        name="currentPassword"
                                        id="currentPassword"
                                        class="form-control @error('currentPassword') is-invalid @enderror"
                                        placeholder="············">
                                    <label for="currentPassword">Current Password</label>
                                </div>
                                <span class="input-group-text cursor-pointer">
                                    <i class="icon-base ri ri-eye-off-line icon-20px"></i>
                                </span>
                            </div>
                            @error('currentPassword')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- New Password --}}
                        <div class="mb-4 form-password-toggle form-control-validation">
                            <div class="input-group input-group-merge">
                                <div class="form-floating form-floating-outline lex-grow-1">
                                    <input type="password"
                                        name="newPassword"
                                        id="newPassword"
                                        class="form-control @error('newPassword') is-invalid @enderror"
                                        placeholder="············">
                                    <label for="newPassword">New Password</label>
                                </div>
                                <span class="input-group-text cursor-pointer">
                                    <i class="icon-base ri ri-eye-off-line icon-20px"></i>
                                </span>
                            </div>
                            @error('newPassword')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Confirm New Password --}}
                        <div class="mb-4 form-password-toggle">
                            <div class="input-group input-group-merge">
                                <div class="form-floating form-floating-outline lex-grow-1">
                                    <input type="password"
                                        name="newPassword_confirmation"
                                        id="confirmPassword"
                                        class="form-control"
                                        placeholder="············">
                                    <label for="confirmPassword">Confirm New Password</label>
                                </div>
                                <span class="input-group-text cursor-pointer">
                                    <i class="icon-base ri ri-eye-off-line icon-20px"></i>
                                </span>
                            </div>
                        </div>

                        {{-- Requirements --}}
                        <h6 class="text-body mt-3">Password Requirements:</h6>
                        <ul class="ps-4 mb-0">
                            <li class="mb-2">Minimum 8 characters long - the more, the better</li>
                            <li class="mb-2">At least one lowercase character</li>
                            <li>At least one number, symbol, or whitespace character</li>
                        </ul>

                        {{-- Actions --}}
                        <div class="mt-4">
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
    {{-- SweetAlert otomatis --}}
    @if(session('success'))
        <script>
            Swal.fire({
                icon : 'success',
                title: 'Success',
                text : "{{ session('success') }}"
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            Swal.fire({
                icon : 'error',
                title: 'Error',
                text : "{{ session('error') }}"
            });
        </script>
    @endif

    {{-- Delete confirmation --}}
    <script>
        $(document).on('click', '.delete-btn', function (e) {
            e.preventDefault();
            let form = $(this).closest('form');

            Swal.fire({
                title             : 'Are you sure?',
                text              : "You won't be able to revert this!",
                icon              : 'warning',
                showCancelButton  : true,
                confirmButtonColor: '#d33',
                cancelButtonColor : '#3085d6',
                confirmButtonText : 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        });
    </script>

    {{-- Select2 & avatar preview --}}
    <script>
        $(function () {
            $('.select2').select2({
                placeholder: "-- Choose --",
                allowClear : true,
                width      : '100%'
            });
        });

        document.getElementById('upload')?.addEventListener('change', e => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = evt => document.getElementById('uploadedAvatar').src = evt.target.result;
                reader.readAsDataURL(file);
            }
        });
    </script>
@endpush