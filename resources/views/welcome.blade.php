{{-- reset-password.blade.php --}}
@extends('layout.auth.main')

@push('styles')
<link rel="stylesheet" href="{{ asset('auth/css/auth-base.css') }}">
<link rel="stylesheet" href="{{ asset('auth/css/reset-password.css') }}">
@endpush

@section('content')
    <div class="reset-password-container">
        <div class="reset-password-card" data-aos="fade-up">
            <!-- Icon Header -->
            <div class="icon-header" data-aos="zoom-in" data-aos-delay="100">
                <div class="icon-circle">
                    <i class="bi bi-shield-lock-fill"></i>
                </div>
            </div>

            <!-- Title Section -->
            <div class="title-section" data-aos="fade-up" data-aos-delay="200">
                <h2>Reset Password</h2>
                <p>Buat password baru yang aman dan mudah diingat</p>
            </div>

            <!-- Alert Messages -->
            @if (session('status'))
                <div class="alert-custom alert-success-custom" data-aos="fade-in">
                    <div class="alert-icon">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div class="alert-content">
                        <div class="alert-title">Berhasil</div>
                        <div class="alert-message">{{ session('status') }}</div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="alert-custom alert-danger-custom" data-aos="fade-in">
                    <div class="alert-icon">
                        <i class="bi bi-exclamation-circle-fill"></i>
                    </div>
                    <div class="alert-content">
                        <div class="alert-title">Terjadi Kesalahan</div>
                        <div class="alert-message">{{ session('error') }}</div>
                    </div>
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('password.update') }}" data-aos="fade-up" data-aos-delay="300">
                @csrf
                <input type="hidden" name="token" value="{{ request()->route('token') }}">

                <!-- Email Field -->
                <div class="form-group-custom">
                    <label for="email" class="form-label-custom">
                        <i class="bi bi-envelope-fill"></i>
                        <span>Email</span>
                    </label>
                    <div class="input-wrapper-custom">
                        <input 
                            type="email" 
                            name="email" 
                            id="email" 
                            class="form-control-custom @error('email') is-invalid @enderror" 
                            value="{{ request()->email ?? old('email') }}" 
                            placeholder="Masukkan email Anda"
                            required
                        />
                        @error('email')
                            <div class="invalid-feedback-custom">
                                <span class="error-label">Error:</span>
                                <span class="error-message">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Password Field -->
                <div class="form-group-custom">
                    <label for="password" class="form-label-custom">
                        <i class="bi bi-lock-fill"></i>
                        <span>Password Baru</span>
                    </label>
                    <div class="password-wrapper">
                        <input 
                            type="password" 
                            name="password" 
                            id="password" 
                            class="form-control-custom @error('password') is-invalid @enderror" 
                            placeholder="Minimal 8 karakter"
                            required
                            onkeyup="checkPasswordStrength()"
                        />
                        <button type="button" class="password-toggle-btn" onclick="togglePassword('password', 'toggleIcon1')">
                            <i class="bi bi-eye-slash-fill" id="toggleIcon1"></i>
                        </button>
                        @error('password')
                            <div class="invalid-feedback-custom">
                                <span class="error-label">Error:</span>
                                <span class="error-message">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                    <!-- Password Strength Indicator -->
                    <div class="password-strength" id="passwordStrength">
                        <div class="password-strength-bar" id="passwordStrengthBar"></div>
                    </div>
                    <div class="password-strength-text" id="passwordStrengthText"></div>
                </div>

                <!-- Password Requirements -->
                <div class="password-requirements">
                    <div class="requirements-title">
                        <i class="bi bi-shield-check"></i>
                        <span>Persyaratan Password:</span>
                    </div>
                    <ul id="passwordRequirements">
                        <li id="req-length">Minimal 8 karakter</li>
                        <li id="req-uppercase">Satu huruf besar</li>
                        <li id="req-lowercase">Satu huruf kecil</li>
                        <li id="req-number">Satu angka</li>
                    </ul>
                </div>

                <!-- Password Confirmation Field -->
                <div class="form-group-custom">
                    <label for="password_confirmation" class="form-label-custom">
                        <i class="bi bi-shield-check"></i>
                        <span>Konfirmasi Password</span>
                    </label>
                    <div class="password-wrapper">
                        <input 
                            type="password" 
                            name="password_confirmation" 
                            id="password_confirmation" 
                            class="form-control-custom" 
                            placeholder="Ulangi password baru"
                            required
                            onkeyup="checkPasswordMatch()"
                        />
                        <button type="button" class="password-toggle-btn" onclick="togglePassword('password_confirmation', 'toggleIcon2')">
                            <i class="bi bi-eye-slash-fill" id="toggleIcon2"></i>
                        </button>
                    </div>
                    <!-- Password Match Indicator -->
                    <div class="password-match" id="passwordMatch"></div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-submit-custom">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>Reset Password</span>
                </button>
            </form>

            <!-- Back to Login -->
            <div class="back-to-login" data-aos="fade-up" data-aos-delay="400">
                <a href="{{ route('login') }}" class="back-link">
                    <i class="bi bi-arrow-left-circle-fill"></i>
                    <span>Kembali ke Halaman Login</span>
                </a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('auth/js/reset-password.js') }}"></script>
@endpush