@extends('layout.errors.main')

@section('title', '408 - Request Timeout')

@section('error-code', '408')
@section('error-title', 'Permintaan Waktu Habis')
@section('error-message', 'Server terlalu lama merespons permintaan Anda.')

@section('error-buttons')
    <a href="{{ url('/') }}" class="btn btn-primary">Coba Lagi</a>
@endsection
