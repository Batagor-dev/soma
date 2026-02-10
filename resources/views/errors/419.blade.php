@extends('layout.errors.main')

@section('title', '419 - Sesi Kedaluwarsa')

@section('error-code', '419')
@section('error-title', 'Sesi Telah Kedaluwarsa')
@section('error-message', 'Sesi Anda telah berakhir atau token keamanan sudah tidak valid. Silakan muat ulang halaman atau login kembali.')

@section('error-buttons')
    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary me-2">
        ⟵ Kembali
    </a>

    <a href="{{ route('login') }}" class="btn btn-primary">
        Login Ulang
    </a>
@endsection
