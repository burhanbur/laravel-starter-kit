@extends('errors.layout')

@section('code', '400')
@section('title', 'Bad Request')
@section('subtitle', 'Permintaan Tidak Valid')

@section('icon')
<svg class="illustration" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
    <circle cx="60" cy="60" r="58" fill="white" opacity="0.2"/>
    <path d="M40 50L60 30L80 50L60 70L40 50Z" stroke="white" stroke-width="3" stroke-linejoin="round"/>
    <path d="M60 42V52" stroke="white" stroke-width="3" stroke-linecap="round"/>
    <circle cx="60" cy="58" r="2" fill="white"/>
    <path d="M35 75H85" stroke="white" stroke-width="3" stroke-linecap="round"/>
</svg>
@endsection

@section('message')
    Server tidak dapat memproses permintaan Anda karena ada kesalahan pada data yang dikirim. Harap periksa kembali input Anda.
@endsection

@section('suggestions')
    <ul>
        <li>Periksa format data yang Anda kirimkan</li>
        <li>Pastikan semua field yang required telah diisi</li>
        <li>Verifikasi bahwa data yang dikirim sesuai dengan format yang diminta</li>
        <li>Coba refresh halaman dan ulangi aksi Anda</li>
    </ul>
@endsection

@section('debug')
    <strong>Request Method:</strong> {{ request()->method() }}<br>
    <strong>Content Type:</strong> {{ request()->header('Content-Type') ?? 'N/A' }}<br>
    <strong>Request URL:</strong> {{ request()->fullUrl() }}<br>
    <strong>Request Data:</strong> 
    <pre style="margin-top: 5px;">{{ json_encode(request()->except(['password', 'password_confirmation', 'token']), JSON_PRETTY_PRINT) }}</pre>
@endsection
