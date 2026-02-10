@extends('layout.errors.main')

@section('title', '508 - Loop Detected')
@section('error-code', '508')
@section('error-title', 'Loop Terdeteksi')
@section('error-message', 'Server mendeteksi loop tak berujung.')

@section('error-buttons')
<a href="{{ url('/') }}" class="btn btn-primary">Beranda</a>
@endsection
