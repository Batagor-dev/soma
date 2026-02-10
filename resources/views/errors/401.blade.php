@extends('layout.errors.main')

@section('title', '401 - Unauthorized')

@section('error-code', '401')
@section('error-title', 'Tidak Terautentikasi')
@section('error-message', 'Anda harus login terlebih dahulu untuk mengakses halaman ini.')

@section('error-buttons')
    <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
@endsection
