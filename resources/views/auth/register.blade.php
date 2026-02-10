{{-- auth.register --}}
@extends('layout.auth.main')

@push('styles')
<link rel="stylesheet" href="{{ asset('auth/css/register.css') }}">
@endpush

@section('content')
<div class="col-12">
    <div class="auth-card" data-aos="fade-up">
        <div class="row g-0">
            <!-- Left Side - Branding -->
            <div class="col-md-5 auth-left d-none d-md-block">
                <div class="text-center position-relative" style="z-index: 1;">
                    <div class="auth-logo" data-aos="zoom-in" data-aos-delay="100">
                        <img 
                            src="{{ settings()['favicon'] ? asset('storage/' . settings()['favicon']) : asset('images/no-image.png') }}"
                            alt="Logo"
                            class="img-fluid"
                            style="max-width:80px"
                        >
                    </div>

                    <h2 class="fw-bold mb-3" data-aos="fade-up" data-aos-delay="200">
                        Komunitas Mancing APRI
                    </h2>
                    
                    <p class="mb-5 opacity-75" data-aos="fade-up" data-aos-delay="300">
                        Bergabunglah dengan komunitas pemancing terbesar di Indonesia
                    </p>

                    <div class="row g-4 mt-4">
                        <div class="col-12" data-aos="fade-up" data-aos-delay="400">
                            <div class="feature-icon">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <h6 class="fw-semibold">Komunitas Aktif</h6>
                            <p class="small opacity-75">Ribuan anggota siap berbagi</p>
                        </div>
                        
                        <div class="col-12" data-aos="fade-up" data-aos-delay="500">
                            <div class="feature-icon">
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>
                            <h6 class="fw-semibold">Spot Mancing</h6>
                            <p class="small opacity-75">Temukan lokasi terbaik</p>
                        </div>
                        
                        <div class="col-12" data-aos="fade-up" data-aos-delay="600">
                            <div class="feature-icon">
                                <i class="bi bi-trophy-fill"></i>
                            </div>
                            <h6 class="fw-semibold">Event & Lomba</h6>
                            <p class="small opacity-75">Ikuti kompetisi seru</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Register Form -->
            <div class="col-md-7 auth-right">
                <!-- Welcome Section -->
                <div class="welcome-section" data-aos="fade-down">
                    <div class="welcome-badge">
                        <i class="bi bi-person-plus-fill"></i>
                        <span>Daftar Sekarang</span>
                    </div>
                    <h3>Buat Akun Baru</h3>
                    <p>Bergabung dan nikmati semua fitur eksklusif</p>
                </div>

                <!-- Alerts -->
                @if(session('status'))
                    <div class="alert-custom alert-success-custom alert-dismissible fade show" role="alert" data-aos="fade-in">
                        <div class="alert-icon">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <div class="alert-content">
                            <div class="alert-title">Berhasil</div>
                            <div class="alert-message">{{ session('status') }}</div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert-custom alert-danger-custom alert-dismissible fade show" role="alert" data-aos="fade-in">
                        <div class="alert-icon">
                            <i class="bi bi-exclamation-circle-fill"></i>
                        </div>
                        <div class="alert-content">
                            <div class="alert-title">Terjadi Kesalahan</div>
                            <div class="alert-message">{{ session('error') }}</div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Register Form -->
                <form action="{{ route('register') }}" method="POST" data-aos="fade-up" data-aos-delay="200">
                    @csrf

                    <!-- Name Field -->
                    <div class="form-group-modern">
                        <label for="name" class="form-label-modern">
                            <i class="bi bi-person-fill"></i>Nama Lengkap
                        </label>
                        <div class="input-wrapper">
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                class="form-control-modern @error('name') is-invalid @enderror" 
                                value="{{ old('name') }}" 
                                placeholder="Masukkan nama lengkap"
                                required 
                                autofocus
                            />
                            @error('name')
                                <div class="invalid-feedback-modern">
                                    <span class="error-label">Error:</span>
                                    <span class="error-message">{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Username Field -->
                    <div class="form-group-modern">
                        <label for="username" class="form-label-modern">
                            <i class="bi bi-at"></i>Username
                        </label>
                        <div class="input-wrapper">
                            <input 
                                type="text" 
                                id="username" 
                                name="username" 
                                class="form-control-modern @error('username') is-invalid @enderror" 
                                value="{{ old('username') }}" 
                                placeholder="Pilih username unik"
                                required
                            />
                            @error('username')
                                <div class="invalid-feedback-modern">
                                    <span class="error-label">Error:</span>
                                    <span class="error-message">{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Email Field -->
                    <div class="form-group-modern">
                        <label for="email" class="form-label-modern">
                            <i class="bi bi-envelope-fill"></i>Email
                        </label>
                        <div class="input-wrapper">
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                class="form-control-modern @error('email') is-invalid @enderror" 
                                value="{{ old('email') }}" 
                                placeholder="contoh@email.com"
                                required
                            />
                            @error('email')
                                <div class="invalid-feedback-modern">
                                    <span class="error-label">Error:</span>
                                    <span class="error-message">{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div class="form-group-modern">
                        <label for="password" class="form-label-modern">
                            <i class="bi bi-lock-fill"></i>Password
                        </label>
                        <div class="password-wrapper">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="form-control-modern @error('password') is-invalid @enderror" 
                                placeholder="Minimal 8 karakter"
                                required
                                onkeyup="checkPasswordStrength()"
                            />
                            <button type="button" class="password-toggle-btn" onclick="togglePassword('password', 'toggleIcon1')">
                                <i class="bi bi-eye-slash-fill" id="toggleIcon1"></i>
                            </button>
                            @error('password')
                                <div class="invalid-feedback-modern">
                                    <span class="error-label">Error:</span>
                                    <span class="error-message">{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Password Confirmation Field -->
                    <div class="form-group-modern">
                        <label for="password_confirmation" class="form-label-modern">
                            <i class="bi bi-shield-check"></i>Konfirmasi Password
                        </label>
                        <div class="password-wrapper">
                            <input 
                                type="password" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                class="form-control-modern" 
                                placeholder="Ulangi password"
                                required
                            />
                            <button type="button" class="password-toggle-btn" onclick="togglePassword('password_confirmation', 'toggleIcon2')">
                                <i class="bi bi-eye-slash-fill" id="toggleIcon2"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Register Button -->
                    <button type="submit" class="btn-register">
                        <i class="bi bi-person-check-fill"></i>
                        <span>Daftar Sekarang</span>
                    </button>

                    <!-- Divider -->
                    <div class="divider-or">
                        <span>atau masuk jika sudah punya akun</span>
                    </div>

                    <!-- Login Card -->
                    <div class="login-card">
                        <p>Sudah punya akun?</p>
                        <a href="{{ route('login') }}" class="login-link">
                            <span>Masuk Sekarang</span>
                            <i class="bi bi-arrow-right-circle-fill"></i>
                        </a>
                    </div>

                    <!-- Benefits -->
                    <div class="benefits-list">
                        <div class="benefit-item">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Gratis selamanya</span>
                        </div>
                        <div class="benefit-item">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Akses semua fitur</span>
                        </div>
                        <div class="benefit-item">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Komunitas aktif</span>
                        </div>
                        <div class="benefit-item">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Event eksklusif</span>
                        </div>
                    </div>
                </form>

                <!-- Mobile Logo -->
                <div class="d-md-none text-center mt-4" data-aos="fade-up">
                    <div class="auth-logo d-inline-flex align-items-center justify-content-center">
                        <img 
                            src="{{ settings()['favicon'] ? asset('storage/' . settings()['favicon']) : asset('images/no-image.png') }}"
                            alt="Logo"
                            style="width:60px;height:60px;object-fit:contain"
                        >
                    </div>
                    <p class="text-muted small mt-2 mb-0">Komunitas Mancing APRI</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('auth/js/register.js') }}"></script>
@endpush