@extends('layout.errors.main')

@section('title', '412 - Precondition Failed')
@section('error-code', '412')
@section('error-title', 'Precondition Failed')
@section('error-message', 'Kondisi prasyarat tidak terpenuhi.')

@section('error-buttons')
<a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
@endsection
