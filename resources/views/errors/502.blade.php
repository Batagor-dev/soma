@extends('layout.errors.main')

@section('title', '502 - Bad Gateway')

@section('error-code', '502')
@section('error-title', 'Gateway Bermasalah')
@section('error-message', 'Server menerima respon yang tidak valid.')

@section('error-buttons')
    <a href="{{ url('/') }}" class="btn btn-primary">Beranda</a>
@endsection
