@extends('errors.layout')

@section('code', '502')
@section('title', 'Bad Gateway')
@section('subtitle', 'Gateway Bermasalah')

@section('icon')
<svg class="illustration" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
    <circle cx="60" cy="60" r="58" fill="white" opacity="0.2"/>
    <rect x="35" y="40" width="20" height="40" rx="3" stroke="white" stroke-width="3"/>
    <rect x="65" y="40" width="20" height="40" rx="3" stroke="white" stroke-width="3"/>
    <path d="M55 60H65" stroke="white" stroke-width="3" stroke-linecap="round"/>
    <path d="M60 55V65" stroke="white" stroke-width="3" stroke-linecap="round"/>
</svg>
@endsection

@section('message')
    Server bertindak sebagai gateway atau proxy dan menerima respons yang tidak valid dari server upstream. Tim kami sedang menyelidiki masalah ini.
@endsection

@section('suggestions')
    <ul>
        <li>Tunggu beberapa menit dan coba lagi</li>
        <li>Refresh halaman (F5 atau Ctrl+R)</li>
        <li>Periksa status layanan di halaman status sistem</li>
        <li>Hubungi support jika masalah berlanjut</li>
    </ul>
@endsection

@section('debug')
    <strong>Error Type:</strong> Bad Gateway<br>
    <strong>Gateway Status:</strong> Received invalid response from upstream<br>
    <strong>Request URL:</strong> {{ request()->fullUrl() }}<br>
    <strong>Timestamp:</strong> {{ now()->format('Y-m-d H:i:s') }}
@endsection
