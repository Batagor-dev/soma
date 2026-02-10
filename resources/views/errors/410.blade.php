@extends('layout.errors.main')

@section('title', '410 - Gone')

@section('error-code', '410')
@section('error-title', 'Konten Tidak Tersedia')
@section('error-message', 'Halaman ini sudah tidak tersedia secara permanen.')

@section('error-buttons')
    <a href="{{ url('/') }}" class="btn btn-primary">Beranda</a>
@endsection
