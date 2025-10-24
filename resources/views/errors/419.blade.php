@extends('errors.layout')

@section('code', '419')
@section('title', 'Page Expired')
@section('subtitle', 'Sesi Telah Berakhir')

@section('icon')
<svg class="illustration" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
    <circle cx="60" cy="60" r="58" fill="white" opacity="0.2"/>
    <circle cx="60" cy="60" r="28" stroke="white" stroke-width="3"/>
    <path d="M60 35V60L75 75" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
    <path d="M60 25V30M85 60H90M60 90V95M30 60H35" stroke="white" stroke-width="2" stroke-linecap="round"/>
</svg>
@endsection

@section('message')
    Halaman Anda telah kedaluwarsa karena tidak ada aktivitas dalam waktu yang lama. Ini adalah mekanisme keamanan untuk melindungi data Anda. Silakan refresh halaman dan coba lagi.
@endsection

@section('suggestions')
    <ul>
        <li>Refresh halaman ini (tekan F5 atau Ctrl+R)</li>
        <li>Kembali ke halaman sebelumnya dan ulangi aksi Anda</li>
        <li>Pastikan cookies browser Anda diaktifkan</li>
        <li>Jangan biarkan halaman form terbuka terlalu lama sebelum submit</li>
    </ul>
@endsection

@section('extra')
    <div style="text-align: center; margin-top: 20px;">
        <button onclick="location.reload()" class="btn btn-primary">
            <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            Refresh Halaman
        </button>
    </div>
@endsection

@section('debug')
    <strong>Session ID:</strong> {{ session()->getId() }}<br>
    <strong>CSRF Token:</strong> {{ csrf_token() }}<br>
    <strong>Session Lifetime:</strong> {{ config('session.lifetime') }} minutes<br>
    <strong>Last Activity:</strong> {{ session()->get('_previous.url') ?? 'N/A' }}
@endsection
