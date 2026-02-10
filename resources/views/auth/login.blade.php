{{-- auth.login --}}
@extends('layout.auth.main')

@push('styles')
<link rel="stylesheet" href="{{ asset('auth/css/login.css') }}">
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

            <!-- Right Side - Login Form -->
            <div class="col-md-7 auth-right">
                <!-- Welcome Section -->
                <div class="welcome-section" data-aos="fade-down">
                    <div class="welcome-badge">
                        <i class="bi bi-hand-wave-fill"></i>
                        <span>Selamat Datang Kembali</span>
                    </div>
                    <h3>Masuk ke Akun Anda</h3>
                    <p>Lanjutkan petualangan memancing Anda</p>
                </div>

                <!-- Alerts -->
                @if(session('status'))
                    <div class="alert-custom alert-success-custom alert-dismissible fade show" role="alert" data-aos="fade-in">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>{{ session('status') }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert-custom alert-danger-custom alert-dismissible fade show" role="alert" data-aos="fade-in">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        <span>{{ session('error') }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Login Form -->
                <form action="{{ route('login') }}" method="POST" data-aos="fade-up" data-aos-delay="200">
                    @csrf

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
                                autofocus
                            />
                            @error('email')
                                <div class="invalid-feedback-modern">
                                    <i class="bi bi-exclamation-circle-fill"></i>
                                    <span>Email atau password tidak valid</span>
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
                                placeholder="Masukkan password"
                                required
                            />
                            <button type="button" class="password-toggle-btn" onclick="togglePassword()">
                                <i class="bi bi-eye-slash-fill" id="toggleIcon"></i>
                            </button>
                            @error('password')
                                <div class="invalid-feedback-modern">
                                    <i class="bi bi-exclamation-circle-fill"></i>
                                    <span>Password tidak valid</span>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Remember & Forgot -->
                    <div class="remember-forgot">
                        <div class="custom-checkbox-wrapper">
                            <input 
                                type="checkbox" 
                                name="remember" 
                                id="remember"
                            />
                            <label for="remember">Ingat Saya</label>
                        </div>
                        <a href="{{ route('password.request') }}" class="forgot-link">
                            Lupa Password?
                        </a>
                    </div>

                    <!-- Login Button -->
                    <button type="submit" class="btn-login">
                        <i class="bi bi-box-arrow-in-right"></i>
                        <span>Masuk Sekarang</span>
                    </button>

                    <!-- Divider -->
                    <div class="divider-or">
                        <span>atau</span>
                    </div>

                    <!-- Register Card -->
                    <div class="register-card">
                        <p>Belum bergabung dengan kami?</p>
                        <a href="{{ route('register') }}" class="register-link">
                            <span>Daftar Sekarang</span>
                            <i class="bi bi-arrow-right-circle-fill"></i>
                        </a>
                    </div>

                    <!-- Stats -->
                    <div class="stats-grid">
                        <div class="stat-box">
                            <span class="stat-number">5000+</span>
                            <span class="stat-text">Anggota Aktif</span>
                        </div>
                        <div class="stat-box">
                            <span class="stat-number">200+</span>
                            <span class="stat-text">Spot Mancing</span>
                        </div>
                        <div class="stat-box">
                            <span class="stat-number">50+</span>
                            <span class="stat-text">Event/Tahun</span>
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
<script src="{{ asset('auth/js/login.js') }}"></script>
@endpush