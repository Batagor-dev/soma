@extends('layout.errors.main')

@section('title', '511 - Network Authentication Required')

@section('error-code', '511')
@section('error-title', 'Autentikasi Jaringan Diperlukan')
@section('error-message', 'Anda perlu autentikasi jaringan untuk mengakses halaman ini.')

@section('error-buttons')
    <a href="{{ url('/') }}" class="btn btn-primary">Beranda</a>
@endsection
