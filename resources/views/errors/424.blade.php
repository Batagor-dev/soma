@extends('layout.errors.main')

@section('title', '424 - Failed Dependency')
@section('error-code', '424')
@section('error-title', 'Dependensi Gagal')
@section('error-message', 'Permintaan gagal karena dependensi lain bermasalah.')

@section('error-buttons')
<a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
@endsection
