@extends('errors.layout')

@section('code', '413')
@section('title', 'Payload Too Large')
@section('subtitle', 'Ukuran Data Terlalu Besar')

@section('icon')
<svg class="illustration" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
    <circle cx="60" cy="60" r="58" fill="white" opacity="0.2"/>
    <rect x="40" y="45" width="40" height="30" rx="3" stroke="white" stroke-width="3"/>
    <path d="M50 55V65M60 50V70M70 55V65" stroke="white" stroke-width="3" stroke-linecap="round"/>
    <path d="M60 30V40M50 35L60 30L70 35" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
@endsection

@section('message')
    Data yang Anda kirim melebihi batas maksimum yang diizinkan server. Harap kurangi ukuran data atau file yang diunggah.
@endsection

@section('suggestions')
    <ul>
        <li>Kurangi ukuran file yang Anda upload</li>
        <li>Kompres file sebelum mengunggah</li>
        <li>Kirim data dalam beberapa bagian jika memungkinkan</li>
        <li>Periksa batas maksimum upload yang diizinkan</li>
    </ul>
@endsection

@section('debug')
    <strong>Max Upload Size:</strong> {{ ini_get('upload_max_filesize') }}<br>
    <strong>Max Post Size:</strong> {{ ini_get('post_max_size') }}<br>
    <strong>Request Size:</strong> Too large<br>
    <strong>Request URL:</strong> {{ request()->fullUrl() }}
@endsection
