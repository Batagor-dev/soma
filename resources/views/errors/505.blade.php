@extends('layout.errors.main')

@section('title', '505 - HTTP Version Not Supported')
@section('error-code', '505')
@section('error-title', 'Versi HTTP Tidak Didukung')
@section('error-message', 'Versi HTTP tidak didukung server.')

@section('error-buttons')
<a href="{{ url('/') }}" class="btn btn-primary">Beranda</a>
@endsection
