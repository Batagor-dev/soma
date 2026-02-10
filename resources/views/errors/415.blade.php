@extends('layout.errors.main')

@section('title', '415 - Unsupported Media Type')
@section('error-code', '415')
@section('error-title', 'Media Tidak Didukung')
@section('error-message', 'Format media yang dikirim tidak didukung server.')

@section('error-buttons')
<a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
@endsection
