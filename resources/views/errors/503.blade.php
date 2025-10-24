@extends('errors.layout')

@section('code', '503')
@section('title', 'Service Unavailable')
@section('subtitle', 'Layanan Sedang Maintenance')

@section('icon')
<svg class="illustration" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
    <circle cx="60" cy="60" r="58" fill="white" opacity="0.2"/>
    <path d="M45 40L50 35L55 40M65 40L70 35L75 40" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
    <rect x="35" y="45" width="50" height="40" rx="4" stroke="white" stroke-width="3"/>
    <path d="M50 55H70M50 65H70M50 75H65" stroke="white" stroke-width="2" stroke-linecap="round"/>
    <circle cx="72" cy="72" r="12" fill="white" opacity="0.3"/>
    <path d="M72 66V72L76 76" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
@endsection

@section('message')
    Aplikasi sedang dalam mode pemeliharaan. Kami sedang melakukan perbaikan dan peningkatan sistem. Mohon maaf atas ketidaknyamanannya. Silakan kembali lagi sebentar lagi.
@endsection

@section('suggestions')
    <ul>
        <li>Pemeliharaan biasanya berlangsung singkat (5-30 menit)</li>
        <li>Bookmark halaman ini dan coba lagi nanti</li>
        <li>Ikuti media sosial kami untuk update status</li>
        <li>Hubungi dukungan jika ada keadaan darurat</li>
    </ul>
@endsection

@section('extra')
    <div style="text-align: center; margin-top: 20px;">
        <div style="background: #fef3c7; padding: 20px; border-radius: 10px; border-left: 4px solid #f59e0b;">
            <h3 style="margin: 0 0 10px 0; color: #92400e;">🔧 Mode Pemeliharaan</h3>
            <p style="margin: 0; color: #78350f;">
                Terima kasih atas kesabaran Anda. Kami akan segera kembali online!
            </p>
        </div>
    </div>
@endsection

@section('debug')
    <strong>Maintenance Mode:</strong> Active<br>
    <strong>Retry After:</strong> {{ isset($retryAfter) ? $retryAfter : 'Unknown' }}<br>
    <strong>Started At:</strong> {{ now()->format('Y-m-d H:i:s') }}<br>
    @if(isset($exception) && $exception->getMessage())
    <strong>Message:</strong> {{ $exception->getMessage() }}<br>
    @endif
@endsection
