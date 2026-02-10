@extends('layout.errors.main')

@section('title', '425 - Too Early')
@section('error-code', '425')
@section('error-title', 'Terlalu Dini')
@section('error-message', 'Permintaan dikirim terlalu cepat.')

@section('error-buttons')
<a href="{{ url()->previous() }}" class="btn btn-secondary">Coba Lagi</a>
@endsection
