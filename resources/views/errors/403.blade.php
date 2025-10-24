@extends('errors.layout')

@section('code', '403')
@section('title', 'Forbidden')
@section('subtitle', 'Akses Ditolak')

@section('icon')
<svg class="illustration" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
    <circle cx="60" cy="60" r="58" fill="white" opacity="0.2"/>
    <rect x="40" y="50" width="40" height="35" rx="3" stroke="white" stroke-width="3"/>
    <path d="M48 50V42C48 35.3726 53.3726 30 60 30C66.6274 30 72 35.3726 72 42V50" stroke="white" stroke-width="3" stroke-linecap="round"/>
    <circle cx="60" cy="67" r="4" fill="white"/>
    <path d="M60 71V75" stroke="white" stroke-width="3" stroke-linecap="round"/>
</svg>
@endsection

@section('message')
    Anda tidak memiliki hak akses untuk melihat halaman ini. Resource yang Anda minta dibatasi untuk pengguna dengan izin khusus.
@endsection

@section('suggestions')
    <ul>
        <li>Pastikan Anda menggunakan akun dengan hak akses yang sesuai</li>
        <li>Jika Anda memerlukan akses, hubungi administrator sistem</li>
        <li>Verifikasi bahwa Anda mengakses URL yang benar</li>
        <li>Coba refresh halaman atau clear cache browser Anda</li>
    </ul>
@endsection

@section('debug')
    <strong>User:</strong> {{ auth()->check() ? auth()->user()->email ?? auth()->user()->name : 'Guest' }}<br>
    <strong>User ID:</strong> {{ auth()->id() ?? 'N/A' }}<br>
    <strong>Roles:</strong> {{ auth()->check() && method_exists(auth()->user(), 'getRoleNames') ? auth()->user()->getRoleNames()->implode(', ') : 'N/A' }}<br>
    <strong>Requested Resource:</strong> {{ request()->fullUrl() }}<br>
    <strong>Referrer:</strong> {{ request()->header('referer') ?? 'N/A' }}
@endsection
