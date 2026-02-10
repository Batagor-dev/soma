@extends('layout.errors.main')

@section('title', '431 - Header Terlalu Besar')
@section('error-code', '431')
@section('error-title', 'Header Terlalu Besar')
@section('error-message', 'Ukuran header permintaan terlalu besar.')

@section('error-buttons')
<a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
@endsection
