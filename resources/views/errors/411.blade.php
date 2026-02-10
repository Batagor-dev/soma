@extends('layout.errors.main')

@section('title', '411 - Length Required')
@section('error-code', '411')
@section('error-title', 'Length Required')
@section('error-message', 'Server membutuhkan header Content-Length yang valid.')

@section('error-buttons')
<a href="{{ url('/') }}" class="btn btn-primary">Kembali ke Beranda</a>
@endsection
