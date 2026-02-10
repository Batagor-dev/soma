@extends('layout.errors.main')

@section('title', '451 - Unavailable For Legal Reasons')

@section('error-code', '451')
@section('error-title', 'Tidak Tersedia Karena Alasan Hukum')
@section('error-message', 'Konten ini tidak dapat diakses karena pembatasan hukum.')

@section('error-buttons')
    <a href="{{ url('/') }}" class="btn btn-primary">Beranda</a>
@endsection
