@extends('layout.errors.main')

@section('title', '413 - Payload Too Large')

@section('error-code', '413')
@section('error-title', 'File Terlalu Besar')
@section('error-message', 'Ukuran data yang dikirim melebihi batas server.')

@section('error-buttons')
    <a href="{{ url()->previous() }}" class="btn btn-primary">Kembali</a>
@endsection
