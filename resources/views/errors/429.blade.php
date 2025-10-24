@extends('errors.layout')

@section('code', '429')
@section('title', 'Too Many Requests')
@section('subtitle', 'Terlalu Banyak Permintaan')

@section('icon')
<svg class="illustration" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
    <circle cx="60" cy="60" r="58" fill="white" opacity="0.2"/>
    <path d="M40 60H50M55 60H65M70 60H80" stroke="white" stroke-width="3" stroke-linecap="round"/>
    <path d="M60 40V50M60 55V65M60 70V80" stroke="white" stroke-width="3" stroke-linecap="round"/>
    <circle cx="60" cy="60" r="25" stroke="white" stroke-width="3" stroke-dasharray="4 4"/>
</svg>
@endsection

@section('message')
    Anda telah mengirim terlalu banyak permintaan dalam waktu singkat. Ini adalah mekanisme perlindungan untuk mencegah penyalahgunaan. Harap tunggu beberapa saat sebelum mencoba lagi.
@endsection

@section('suggestions')
    <ul>
        <li>Tunggu beberapa menit sebelum mencoba lagi</li>
        <li>Hindari refresh halaman secara berlebihan</li>
        <li>Jangan gunakan automated tools atau scripts</li>
        <li>Hubungi administrator jika Anda memerlukan rate limit yang lebih tinggi</li>
    </ul>
@endsection

@section('extra')
    <div style="text-align: center; margin-top: 20px;">
        <div style="background: #fee; padding: 15px; border-radius: 10px; border-left: 4px solid #ef4444;">
            <p style="margin: 0; color: #991b1b; font-weight: 600;">
                ⏱️ Silakan tunggu beberapa saat sebelum mencoba lagi
            </p>
        </div>
    </div>
@endsection

@section('debug')
    <strong>IP Address:</strong> {{ request()->ip() }}<br>
    <strong>Request Count:</strong> Rate limit exceeded<br>
    <strong>Rate Limit:</strong> {{ config('app.rate_limit', '60 per minute') }}<br>
    <strong>Retry After:</strong> Please wait a few minutes<br>
    <strong>Endpoint:</strong> {{ request()->path() }}
@endsection
