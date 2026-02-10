@extends('layout.errors.main')

@section('title', '504 - Gateway Timeout')

@section('error-code', '504')
@section('error-title', 'Gateway Timeout')
@section('error-message', 'Server membutuhkan waktu terlalu lama untuk merespons.')

@section('error-buttons')
    <a href="{{ url('/') }}" class="btn btn-primary">Beranda</a>
@endsection
