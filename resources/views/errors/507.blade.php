@extends('layout.errors.main')

@section('title', '507 - Insufficient Storage')
@section('error-code', '507')
@section('error-title', 'Penyimpanan Penuh')
@section('error-message', 'Server kehabisan ruang penyimpanan.')

@section('error-buttons')
<a href="{{ url('/') }}" class="btn btn-primary">Beranda</a>
@endsection
