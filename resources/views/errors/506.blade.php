@extends('layout.errors.main')

@section('title', '506 - Variant Also Negotiates')
@section('error-code', '506')
@section('error-title', 'Variant Error')
@section('error-message', 'Konfigurasi server tidak valid.')

@section('error-buttons')
<a href="{{ url('/') }}" class="btn btn-primary">Beranda</a>
@endsection
