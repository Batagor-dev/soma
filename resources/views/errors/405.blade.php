@extends('layout.errors.main')

@section('title', '405 - Method Not Allowed')

@section('error-code', '405')
@section('error-title', 'Metode Tidak Diizinkan')
@section('error-message', 'Metode request yang digunakan tidak diperbolehkan.')

@section('error-buttons')
    <a href="{{ url('/') }}" class="btn btn-primary">Beranda</a>
@endsection
