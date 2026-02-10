@extends('layout.errors.main')

@section('title', '402 - Payment Required')

@section('error-code', '402')
@section('error-title', 'Pembayaran Diperlukan')
@section('error-message', 'Akses ke halaman ini memerlukan pembayaran.')

@section('error-buttons')
    <a href="{{ url('/') }}" class="btn btn-primary">Kembali</a>
@endsection
