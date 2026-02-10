{{-- forgot-password --}}
@extends('layout.auth.main')

@push('styles')
<link rel="stylesheet" href="{{ asset('auth/css/forgot-password.css') }}">
@endpush

@section('content')
    <div class="forgot-password-card" data-aos="fade-up">
        <!-- Icon Header -->
        <div class="icon-header" data-aos="zoom-in" data-aos-delay="100">
            <div class="icon-circle">
                <i class="bi bi-key-fill"></i>
            </div>
        </div>

        <!-- Title Section -->
        <div class="title-section" data-aos="fade-up" data-aos-delay="200">
            <h2>Lupa Password?</h2>
            <p>Jangan khawatir, kami akan mengirimkan instruksi reset password ke email Anda</p>
        </div>

        <!-- Alert Messages -->
        @if (session('status'))
            <div class="alert-custom alert-success-custom" data-aos="fade-in">
                <div class="alert-icon">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <div class="alert-content">
                    <div class="alert-title">Berhasil Dikirim</div>
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
        <form method="POST" action="{{ route('password.email') }}" data-aos="fade-up" data-aos-delay="300">
            @csrf

            <!-- Email Field -->
            <div class="form-group-custom">
                <label for="email" class="form-label-custom">
                    <i class="bi bi-envelope-fill"></i>
                    <span>Alamat Email</span>
                </label>
                <div class="input-wrapper-custom">
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        class="form-control-custom @error('email') is-invalid @enderror" 
                        value="{{ old('email') }}" 
                        placeholder="Masukkan email terdaftar Anda"
                        required 
                        autofocus
                    />
                    @error('email')
                        <div class="invalid-feedback-custom">
                            <span class="error-label">Error:</span>
                            <span class="error-message">{{ $message }}</span>
                        </div>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-submit-custom">
                <i class="bi bi-send-fill"></i>
                <span>Kirim Link Reset Password</span>
            </button>
        </form>

        <!-- Back to Login -->
        <div class="back-to-login" data-aos="fade-up" data-aos-delay="400">
            <div class="divider-line"></div>
            <a href="{{ route('login') }}" class="back-link">
                <i class="bi bi-arrow-left-circle-fill"></i>
                <span>Kembali ke Halaman Login</span>
            </a>
        </div>

        <!-- Help Section -->
        <div class="help-section" data-aos="fade-up" data-aos-delay="500">
            <div class="help-title">
                <i class="bi bi-info-circle-fill"></i>
                <span>Butuh Bantuan?</span>
            </div>
            <ul class="help-list">
                <li>Pastikan email yang Anda masukkan sudah terdaftar</li>
                <li>Periksa folder spam atau junk email Anda</li>
                <li>Link reset berlaku selama 60 menit</li>
            </ul>
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('auth/js/forgot-password.js') }}"></script>
@endpush