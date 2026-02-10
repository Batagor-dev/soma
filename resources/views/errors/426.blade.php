@extends('layout.errors.main')

@section('title', '426 - Upgrade Required')
@section('error-code', '426')
@section('error-title', 'Upgrade Diperlukan')
@section('error-message', 'Silakan upgrade protokol untuk melanjutkan.')

@section('error-buttons')
<a href="{{ url('/') }}" class="btn btn-primary">Beranda</a>
@endsection
