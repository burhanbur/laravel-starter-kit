@extends('errors.layout')

@section('code', '408')
@section('title', 'Request Timeout')
@section('subtitle', 'Waktu Permintaan Habis')

@section('icon')
<svg class="illustration" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
    <circle cx="60" cy="60" r="58" fill="white" opacity="0.2"/>
    <circle cx="60" cy="60" r="25" stroke="white" stroke-width="3"/>
    <path d="M60 40V60L70 70" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
    <path d="M85 60C85 60 88 60 90 58C92 56 92 53 92 53" stroke="white" stroke-width="2" stroke-linecap="round"/>
    <path d="M35 60C35 60 32 60 30 58C28 56 28 53 28 53" stroke="white" stroke-width="2" stroke-linecap="round"/>
</svg>
@endsection

@section('message')
    Server timeout saat menunggu permintaan Anda. Koneksi mungkin terlalu lambat atau ada masalah jaringan. Silakan coba lagi.
@endsection

@section('suggestions')
    <ul>
        <li>Periksa koneksi internet Anda</li>
        <li>Coba refresh halaman dan kirim ulang permintaan</li>
        <li>Jika mengunggah file besar, pastikan koneksi stabil</li>
        <li>Hubungi administrator jika masalah terus berlanjut</li>
    </ul>
@endsection

@section('debug')
    <strong>Timeout Duration:</strong> Server timeout occurred<br>
    <strong>Request URL:</strong> {{ request()->fullUrl() }}<br>
    <strong>Connection Speed:</strong> May be slow or unstable<br>
    <strong>Timestamp:</strong> {{ now()->format('Y-m-d H:i:s') }}
@endsection
