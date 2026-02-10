@extends('layout.errors.main')

@section('title', '422 - Unprocessable Entity')
@section('error-code', '422')
@section('error-title', 'Data Tidak Valid')
@section('error-message', 'Data tidak dapat diproses meskipun format benar.')

@section('error-buttons')
<a href="{{ url()->previous() }}" class="btn btn-secondary">Perbaiki Data</a>
@endsection
