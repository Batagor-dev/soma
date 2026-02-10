@extends('layout.errors.main')

@section('title', '510 - Not Extended')
@section('error-code', '510')
@section('error-title', 'Not Extended')
@section('error-message', 'Permintaan membutuhkan ekstensi tambahan.')

@section('error-buttons')
<a href="{{ url('/') }}" class="btn btn-primary">Beranda</a>
@endsection
