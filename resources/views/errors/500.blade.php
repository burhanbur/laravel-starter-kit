@extends('errors.layout')

@section('code', '500')
@section('title', 'Server Error')
@section('subtitle', 'Terjadi Kesalahan Server')

@section('icon')
<svg class="illustration" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
    <circle cx="60" cy="60" r="58" fill="white" opacity="0.2"/>
    <path d="M60 35L30 60L60 85L90 60L60 35Z" stroke="white" stroke-width="3" stroke-linejoin="round"/>
    <path d="M60 50V70" stroke="white" stroke-width="3" stroke-linecap="round"/>
    <circle cx="60" cy="78" r="2" fill="white"/>
    <path d="M40 60L60 75L80 60" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" opacity="0.5"/>
</svg>
@endsection

@section('message')
    Maaf, terjadi kesalahan pada server kami. Tim teknis kami telah diberitahu dan sedang bekerja untuk memperbaiki masalah ini. Silakan coba lagi nanti.
@endsection

@section('suggestions')
    <ul>
        <li>Coba refresh halaman dalam beberapa menit</li>
        <li>Periksa status sistem di halaman status kami (jika ada)</li>
        <li>Hubungi dukungan teknis jika masalah berlanjut</li>
        <li>Kembali ke halaman sebelumnya dan coba aksi lain</li>
    </ul>
@endsection

@section('debug')
    @if(isset($exception))
    <strong>Exception:</strong> {{ get_class($exception) }}<br>
    <strong>Message:</strong> {{ $exception->getMessage() }}<br>
    <strong>File:</strong> {{ $exception->getFile() }}:{{ $exception->getLine() }}<br>
    <strong>Stack Trace:</strong>
    <pre style="margin-top: 10px; white-space: pre-wrap;">{{ $exception->getTraceAsString() }}</pre>
    @else
    <strong>Error Type:</strong> Internal Server Error<br>
    <strong>Status:</strong> 500<br>
    <strong>Message:</strong> An unexpected error occurred on the server
    @endif
@endsection
