@extends('errors.layout')

@section('code', '405')
@section('title', 'Method Not Allowed')
@section('subtitle', 'Metode HTTP Tidak Diizinkan')

@section('icon')
<svg class="illustration" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
    <circle cx="60" cy="60" r="58" fill="white" opacity="0.2"/>
    <circle cx="60" cy="60" r="28" stroke="white" stroke-width="3"/>
    <path d="M45 45L75 75M75 45L45 75" stroke="white" stroke-width="3" stroke-linecap="round"/>
</svg>
@endsection

@section('message')
    Metode HTTP yang Anda gunakan tidak diizinkan untuk resource ini. Harap gunakan metode yang sesuai.
@endsection

@section('suggestions')
    <ul>
        <li>Periksa dokumentasi API untuk metode yang benar</li>
        <li>Pastikan Anda menggunakan metode HTTP yang tepat (GET, POST, PUT, DELETE, dll)</li>
        <li>Verifikasi bahwa route/endpoint mendukung metode yang Anda gunakan</li>
        <li>Hubungi developer jika Anda yakin metode sudah benar</li>
    </ul>
@endsection

@section('debug')
    <strong>Request Method:</strong> {{ request()->method() }}<br>
    <strong>Allowed Methods:</strong> {{ isset($exception) && method_exists($exception, 'getHeaders') ? implode(', ', $exception->getHeaders()['Allow'] ?? []) : 'Unknown' }}<br>
    <strong>Request URL:</strong> {{ request()->fullUrl() }}<br>
    <strong>Route Name:</strong> {{ request()->route()?->getName() ?? 'N/A' }}
@endsection
