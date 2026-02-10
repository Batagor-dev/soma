@extends('layout.errors.main')

@section('title', '444 - Connection Closed')
@section('error-code', '444')
@section('error-title', 'Koneksi Ditutup')
@section('error-message', 'Koneksi ditutup tanpa respon dari server.')

@section('error-buttons')
<a href="{{ url('/') }}" class="btn btn-primary">Beranda</a>
@endsection
