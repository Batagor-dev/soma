@extends('layout.errors.main')

@section('title', '500 - Internal Server Error')

@section('error-code', '500')
@section('error-title', 'Kesalahan Server')
@section('error-message', 'Terjadi kesalahan pada server. Silakan coba lagi nanti.')

@section('error-buttons')
    <a href="{{ url('/') }}" class="btn btn-primary">Beranda</a>
@endsection
