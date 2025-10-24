@extends('errors.layout')

@section('code', '402')
@section('title', 'Payment Required')
@section('subtitle', 'Pembayaran Diperlukan')

@section('icon')
<svg class="illustration" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
    <circle cx="60" cy="60" r="58" fill="white" opacity="0.2"/>
    <rect x="30" y="45" width="60" height="35" rx="4" stroke="white" stroke-width="3"/>
    <path d="M30 55H90" stroke="white" stroke-width="3"/>
    <circle cx="45" cy="68" r="6" stroke="white" stroke-width="2"/>
    <path d="M55 65H75M55 72H70" stroke="white" stroke-width="2" stroke-linecap="round"/>
</svg>
@endsection

@section('message')
    Akses ke resource ini memerlukan pembayaran. Silakan selesaikan pembayaran terlebih dahulu atau hubungi bagian billing untuk informasi lebih lanjut.
@endsection

@section('suggestions')
    <ul>
        <li>Periksa status langganan atau pembayaran Anda</li>
        <li>Pastikan metode pembayaran Anda masih valid</li>
        <li>Hubungi bagian billing untuk konfirmasi pembayaran</li>
        <li>Upgrade paket Anda jika diperlukan</li>
    </ul>
@endsection

@section('debug')
    <strong>User:</strong> {{ auth()->check() ? auth()->user()->email ?? auth()->user()->name : 'Guest' }}<br>
    <strong>User ID:</strong> {{ auth()->id() ?? 'N/A' }}<br>
    <strong>Subscription Status:</strong> Payment Required<br>
    <strong>Requested Resource:</strong> {{ request()->fullUrl() }}
@endsection
