@extends('layout.errors.main')

@section('title', '503 - Service Unavailable')

@section('error-code', '503')
@section('error-title', 'Layanan Tidak Tersedia')
@section('error-message', 'Server sedang dalam perawatan. Silakan coba lagi nanti.')

@section('error-buttons')
    <a href="{{ url('/') }}" class="btn btn-primary">Beranda</a>
@endsection
