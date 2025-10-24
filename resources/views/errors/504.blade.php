@extends('errors.layout')

@section('code', '504')
@section('title', 'Gateway Timeout')
@section('subtitle', 'Gateway Timeout')

@section('icon')
<svg class="illustration" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
    <circle cx="60" cy="60" r="58" fill="white" opacity="0.2"/>
    <rect x="35" y="40" width="20" height="40" rx="3" stroke="white" stroke-width="3"/>
    <rect x="65" y="40" width="20" height="40" rx="3" stroke="white" stroke-width="3"/>
    <circle cx="60" cy="60" r="20" stroke="white" stroke-width="3" stroke-dasharray="3 3" opacity="0.5"/>
    <path d="M60 50V60L68 68" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
@endsection

@section('message')
    Server gateway tidak menerima respons tepat waktu dari server upstream. Ini mungkin karena beban tinggi atau masalah koneksi. Silakan coba lagi.
@endsection

@section('suggestions')
    <ul>
        <li>Tunggu beberapa menit sebelum mencoba lagi</li>
        <li>Refresh halaman untuk mencoba request ulang</li>
        <li>Jika masalah berlanjut, hubungi administrator</li>
        <li>Periksa status sistem di halaman monitoring</li>
    </ul>
@endsection

@section('debug')
    <strong>Error Type:</strong> Gateway Timeout<br>
    <strong>Gateway Status:</strong> Upstream server did not respond in time<br>
    <strong>Request URL:</strong> {{ request()->fullUrl() }}<br>
    <strong>Timestamp:</strong> {{ now()->format('Y-m-d H:i:s') }}
@endsection
