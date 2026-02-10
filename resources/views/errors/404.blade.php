@extends('layout.errors.main')

@section('title', '404 - Halaman Tidak Ditemukan')

@section('error-code', '404')
@section('error-title', 'Halaman Tidak Ditemukan')
@section('error-message', 'Halaman yang Anda cari mungkin sudah dipindahkan atau dihapus.')

@section('error-buttons')
    <a href="{{ url('/') }}" class="btn btn-primary">
        Kembali ke Beranda
    </a>
@endsection
