@extends('layout.errors.main')

@section('title', '428 - Precondition Required')
@section('error-code', '428')
@section('error-title', 'Precondition Required')
@section('error-message', 'Permintaan membutuhkan prasyarat tambahan.')

@section('error-buttons')
<a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
@endsection
