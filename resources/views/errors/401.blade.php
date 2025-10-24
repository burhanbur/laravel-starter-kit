@extends('errors.layout')

@section('code', '401')
@section('title', 'Unauthorized')
@section('subtitle', 'Akses Tidak Diizinkan')

@section('icon')
<svg class="illustration" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
    <circle cx="60" cy="60" r="58" fill="white" opacity="0.2"/>
    <circle cx="60" cy="45" r="15" stroke="white" stroke-width="3"/>
    <path d="M35 85C35 85 40 65 60 65C80 65 85 85 85 85" stroke="white" stroke-width="3" stroke-linecap="round"/>
    <path d="M50 40L70 50M70 40L50 50" stroke="white" stroke-width="2.5" stroke-linecap="round"/>
</svg>
@endsection

@section('message')
    Maaf, Anda tidak memiliki otorisasi untuk mengakses halaman ini. Silakan login terlebih dahulu atau hubungi administrator jika Anda merasa ini adalah kesalahan.
@endsection

@section('suggestions')
    <ul>
        <li>Pastikan Anda sudah login dengan akun yang benar</li>
        <li>Periksa apakah akun Anda memiliki izin yang diperlukan</li>
        <li>Coba logout dan login kembali</li>
        <li>Hubungi administrator sistem jika masalah berlanjut</li>
    </ul>
@endsection

@section('extra')
    @auth
    <div style="text-align: center; margin-top: 20px;">
        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-secondary">
                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                Logout
            </button>
        </form>
    </div>
    @endauth
@endsection

@section('debug')
    <strong>User:</strong> {{ auth()->check() ? auth()->user()->email ?? auth()->user()->name : 'Guest' }}<br>
    <strong>Requested URL:</strong> {{ request()->fullUrl() }}<br>
    <strong>IP Address:</strong> {{ request()->ip() }}<br>
    <strong>User Agent:</strong> {{ request()->userAgent() }}
@endsection
