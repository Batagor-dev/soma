@extends('layout.errors.main')

@section('title', '417 - Expectation Failed')
@section('error-code', '417')
@section('error-title', 'Expectation Failed')
@section('error-message', 'Server tidak dapat memenuhi ekspektasi permintaan.')

@section('error-buttons')
<a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
@endsection
