@extends('layout.errors.main')

@section('title', '403 - Forbidden')

@section('error-code', '403')
@section('error-title', 'Akses Ditolak')
@section('error-message', 'Anda tidak memiliki izin untuk mengakses halaman ini.')

@section('error-buttons')
    <a href="{{ url('/') }}" class="btn btn-primary">Beranda</a>
@endsection
