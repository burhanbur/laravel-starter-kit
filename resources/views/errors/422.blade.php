@extends('errors.layout')

@section('code', '422')
@section('title', 'Unprocessable Entity')
@section('subtitle', 'Data Tidak Dapat Diproses')

@section('icon')
<svg class="illustration" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
    <circle cx="60" cy="60" r="58" fill="white" opacity="0.2"/>
    <rect x="35" y="35" width="50" height="50" rx="4" stroke="white" stroke-width="3"/>
    <path d="M45 50H75M45 60H75M45 70H65" stroke="white" stroke-width="2.5" stroke-linecap="round"/>
    <circle cx="75" cy="75" r="10" fill="white" opacity="0.3"/>
    <path d="M72 75L75 78L80 73" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
@endsection

@section('message')
    Server memahami permintaan Anda, tetapi tidak dapat memprosesnya karena ada kesalahan validasi. Harap periksa kembali data yang Anda kirimkan.
@endsection

@section('suggestions')
    <ul>
        <li>Periksa kembali semua field yang Anda isi</li>
        <li>Pastikan format data sesuai dengan yang diminta (email, nomor, tanggal, dll)</li>
        <li>Lengkapi semua field yang wajib diisi</li>
        <li>Periksa pesan error validasi jika ditampilkan</li>
    </ul>
@endsection

@section('debug')
    @if(session('errors'))
    <strong>Validation Errors:</strong><br>
    <pre style="margin-top: 5px;">{{ json_encode(session('errors')->toArray(), JSON_PRETTY_PRINT) }}</pre>
    @endif
    <strong>Request Method:</strong> {{ request()->method() }}<br>
    <strong>Request URL:</strong> {{ request()->fullUrl() }}<br>
    <strong>Input Data:</strong>
    <pre style="margin-top: 5px;">{{ json_encode(request()->except(['password', 'password_confirmation', 'token', '_token']), JSON_PRETTY_PRINT) }}</pre>
@endsection
