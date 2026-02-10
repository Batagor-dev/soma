@extends('layout.errors.main')

@section('title', '414 - URI Too Long')
@section('error-code', '414')
@section('error-title', 'URI Terlalu Panjang')
@section('error-message', 'Alamat URL yang diminta terlalu panjang untuk diproses server.')

@section('error-buttons')
<a href="{{ url('/') }}" class="btn btn-primary">Beranda</a>
@endsection
