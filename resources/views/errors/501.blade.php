@extends('layout.errors.main')

@section('title', '501 - Not Implemented')
@section('error-code', '501')
@section('error-title', 'Belum Diimplementasikan')
@section('error-message', 'Fitur ini belum tersedia di server.')

@section('error-buttons')
<a href="{{ url('/') }}" class="btn btn-primary">Beranda</a>
@endsection
