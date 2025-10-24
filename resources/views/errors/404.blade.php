@extends('errors.layout')

@section('code', '404')
@section('title', 'Not Found')
@section('subtitle', 'Halaman Tidak Ditemukan')

@section('icon')
<svg class="illustration" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
    <circle cx="60" cy="60" r="58" fill="white" opacity="0.2"/>
    <path d="M60 90C77.6731 90 92 75.6731 92 58C92 40.3269 77.6731 26 60 26C42.3269 26 28 40.3269 28 58C28 75.6731 42.3269 90 60 90Z" stroke="white" stroke-width="3" stroke-linecap="round"/>
    <path d="M48 52C48 52 48 50 48 48C48 46 50 46 50 46C50 46 52 46 52 48C52 50 52 52 52 52" stroke="white" stroke-width="3" stroke-linecap="round"/>
    <path d="M68 52C68 52 68 50 68 48C68 46 70 46 70 46C70 46 72 46 72 48C72 50 72 52 72 52" stroke="white" stroke-width="3" stroke-linecap="round"/>
    <path d="M45 68C45 68 50 64 60 64C70 64 75 68 75 68" stroke="white" stroke-width="3" stroke-linecap="round"/>
    <circle cx="50" cy="49" r="3" fill="white"/>
    <circle cx="70" cy="49" r="3" fill="white"/>
</svg>
@endsection

@section('message')
    Oops! Halaman yang Anda cari tidak dapat ditemukan. Mungkin halaman telah dipindahkan, dihapus, atau URL yang Anda masukkan salah.
@endsection

@section('suggestions')
    <ul>
        <li>Periksa kembali URL yang Anda masukkan</li>
        <li>Gunakan menu navigasi untuk menemukan halaman yang Anda cari</li>
        <li>Kembali ke halaman sebelumnya atau ke beranda</li>
        <li>Coba gunakan fitur pencarian jika tersedia</li>
    </ul>
@endsection

@section('debug')
    <strong>Requested URL:</strong> {{ request()->fullUrl() }}<br>
    <strong>Method:</strong> {{ request()->method() }}<br>
    <strong>Route Name:</strong> {{ request()->route()?->getName() ?? 'N/A' }}<br>
    <strong>Referrer:</strong> {{ request()->header('referer') ?? 'Direct Access' }}<br>
    <strong>Available Routes:</strong> Similar routes might be available in your application
@endsection
