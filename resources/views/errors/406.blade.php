@extends('layout.errors.main')

@section('title', '406 - Not Acceptable')
@section('error-code', '406')
@section('error-title', 'Tidak Dapat Diterima')
@section('error-message', 'Server tidak dapat memproses permintaan Anda.')

@section('error-buttons')
<a href="{{ url('/') }}" class="btn btn-primary">Beranda</a>
@endsection
