@extends('layout.errors.main')

@section('title', '423 - Locked')
@section('error-code', '423')
@section('error-title', 'Terkunci')
@section('error-message', 'Resource sedang dikunci dan tidak dapat diakses.')

@section('error-buttons')
<a href="{{ url('/') }}" class="btn btn-primary">Beranda</a>
@endsection
