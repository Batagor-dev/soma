{{-- verify-email --}}
@extends('layout.auth.main')

@push('styles')
<link rel="stylesheet" href="{{ asset('auth/css/verify-email.css') }}">
@endpush

@section('content')
<div class="verify-container">

    <div class="verify-card" data-aos="fade-up">

        <!-- Icon -->
        <div class="verify-icon" data-aos="zoom-in">
            <i class="bi bi-envelope-check-fill"></i>
        </div>

        <!-- Title -->
        <div class="verify-title">
            <h2>Verifikasi Email</h2>
            <p>
                Kami sudah mengirimkan link verifikasi ke email Anda.
                Silakan klik link tersebut untuk melanjutkan.
            </p>
        </div>

        <!-- Alert -->
        @if (session('resent'))
            <div class="verify-alert success">
                <i class="bi bi-check-circle-fill"></i>
                <span>Link verifikasi baru berhasil dikirim.</span>
            </div>
        @endif

        <!-- Info -->
        <div class="verify-info">
            <ul>
                <li>Periksa folder inbox dan spam</li>
                <li>Link hanya berlaku dalam waktu tertentu</li>
                <li>Verifikasi diperlukan sebelum masuk sistem</li>
            </ul>
        </div>

        <!-- Resend -->
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn-verify" id="resendBtn">
                <i class="bi bi-arrow-repeat"></i>
                <span>Kirim Ulang Email</span>
            </button>
        </form>

        <!-- Back -->
        <div class="verify-back">
            <a href="{{ route('login') }}">
                <i class="bi bi-arrow-left-circle"></i>
                Kembali ke Login
            </a>
        </div>

    </div>

</div>
@endsection

@push('scripts')
<script src="{{ asset('auth/js/verify-email.js') }}"></script>
@endpush
