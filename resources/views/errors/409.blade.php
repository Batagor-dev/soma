@extends('layout.errors.main')

@section('title', '409 - Conflict')

@section('error-code', '409')
@section('error-title', 'Terjadi Konflik')
@section('error-message', 'Permintaan tidak dapat diproses karena konflik data.')

@section('error-buttons')
    <a href="{{ url()->previous() }}" class="btn btn-primary">Kembali</a>
@endsection
