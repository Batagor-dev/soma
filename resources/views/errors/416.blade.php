@extends('layout.errors.main')

@section('title', '416 - Range Not Satisfiable')
@section('error-code', '416')
@section('error-title', 'Range Tidak Valid')
@section('error-message', 'Permintaan range data tidak dapat dipenuhi.')

@section('error-buttons')
<a href="{{ url('/') }}" class="btn btn-primary">Beranda</a>
@endsection
