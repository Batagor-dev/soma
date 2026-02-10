@extends('layout.errors.main')

@section('title', '429 - Too Many Requests')

@section('error-code', '429')
@section('error-title', 'Terlalu Banyak Permintaan')
@section('error-message', 'Anda mengirim terlalu banyak permintaan dalam waktu singkat.')

@section('error-buttons')
    <a href="{{ url('/') }}" class="btn btn-primary">Beranda</a>
@endsection
