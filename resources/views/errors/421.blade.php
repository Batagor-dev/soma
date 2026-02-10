@extends('layout.errors.main')

@section('title', '421 - Misdirected Request')
@section('error-code', '421')
@section('error-title', 'Permintaan Salah Arah')
@section('error-message', 'Permintaan dikirim ke server yang salah.')

@section('error-buttons')
<a href="{{ url('/') }}" class="btn btn-primary">Beranda</a>
@endsection
