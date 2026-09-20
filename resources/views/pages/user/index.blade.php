@extends('layouts.main')

@section('title', config('app.alias') . ' | Manajemen Pengguna')

@push('styles')
<link href="{{ asset('assets/plugins/datatables/datatables.bundle.min.css') }}" rel="stylesheet" type="text/css" />
<style>
    /* Select2 filter adjustments */
    .user-role-filter + .select2-container .select2-selection--multiple {
        min-height: 38px !important;
        padding: 0.25rem 0.5rem !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 6px !important;
        background-color: #ffffff !important;
    }

    .user-role-filter + .select2-container .select2-selection__rendered {
        gap: 0.35rem;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
    }

    .user-role-filter + .select2-container .select2-selection__choice {
        margin: 0 4px 0 0 !important;
        background-color: #f1f5f9 !important;
        border: 1px solid #cbd5e1 !important;
        color: #334155 !important;
        font-size: 12px !important;
        font-weight: 500 !important;
        border-radius: 4px !important;
        padding: 2px 8px !important;
    }

    .user-role-filter + .select2-container .select2-search--inline {
        flex: 1 1 10rem !important;
        min-width: 8rem;
    }

    .user-role-filter + .select2-container .select2-search__field {
        margin: 0 !important;
        height: 28px !important;
        font-size: 13px !important;
    }

    /* Modern Table Styling */
    .table-modern {
        border-collapse: separate !important;
        border-spacing: 0 !important;
    }

    .table-modern thead th {
        background-color: #f8fafc !important;
        color: #64748b !important;
        font-weight: 600 !important;
        font-size: 12px !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
        border-top: none !important;
        border-bottom: 2px solid #e2e8f0 !important;
        padding: 0.9rem 1rem !important;
        vertical-align: middle !important;
    }

    .table-modern tbody td {
        padding: 0.9rem 1rem !important;
        border-top: none !important;
        border-bottom: 1px solid #f1f5f9 !important;
        vertical-align: middle !important;
    }

    .table-modern tbody tr:hover td {
        background-color: #f8faff !important;
    }

    .table-modern tbody tr:last-child td {
        border-bottom: 1px solid #e2e8f0 !important;
    }

    /* Filter Toolbar Card */
    .filter-toolbar {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 1rem 1.25rem;
        margin-bottom: 1.25rem;
    }

    /* User Avatar & Identity Cell */
    .user-identity-cell {
        display: flex;
        align-items: center;
    }

    .user-avatar-circle {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        min-width: 40px;
        border-radius: 50%;
        font-weight: 700;
        font-size: 14px;
        letter-spacing: 0.5px;
        margin-right: 14px !important;
        flex-shrink: 0;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        transition: transform 0.15s ease;
    }

    .user-avatar-circle:hover {
        transform: scale(1.06);
    }

    .user-identity-info {
        display: flex;
        flex-direction: column;
    }

    /* Soft Action Buttons */
    .btn-action-icon {
        width: 33px;
        height: 33px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        border: 1px solid transparent;
        margin-right: 5px;
        margin-bottom: 2px;
        transition: all 0.2s ease;
        font-size: 12px;
        cursor: pointer;
        text-decoration: none !important;
        outline: none;
    }

    .btn-action-icon:last-child {
        margin-right: 0;
    }

    /* Soft Edit (Blue) */
    .btn-action-edit {
        background-color: #eff6ff;
        color: #2563eb;
        border-color: #dbeafe;
    }
    .btn-action-edit:hover {
        background-color: #2563eb;
        color: #ffffff;
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.35);
    }

    /* Soft Password (Amber) */
    .btn-action-password {
        background-color: #fef3c7;
        color: #d97706;
        border-color: #fde68a;
    }
    .btn-action-password:hover {
        background-color: #d97706;
        color: #ffffff;
        box-shadow: 0 2px 6px rgba(217, 119, 6, 0.35);
    }

    /* Soft Impersonate (Slate/Dark) */
    .btn-action-impersonate {
        background-color: #f1f5f9;
        color: #334155;
        border-color: #e2e8f0;
    }
    .btn-action-impersonate:hover {
        background-color: #334155;
        color: #ffffff;
        box-shadow: 0 2px 6px rgba(51, 65, 85, 0.35);
    }

    /* Soft Delete (Red) */
    .btn-action-delete {
        background-color: #fef2f2;
        color: #dc2626;
        border-color: #fecaca;
        padding: 0;
    }
    .btn-action-delete:hover:not(:disabled) {
        background-color: #dc2626;
        color: #ffffff;
        box-shadow: 0 2px 6px rgba(220, 38, 38, 0.35);
    }
    .btn-action-delete:disabled {
        opacity: 0.45;
        cursor: not-allowed;
    }

    /* Custom Modern Toggle Switch */
    .custom-toggle-switch {
        position: relative;
        display: inline-flex;
        align-items: center;
        user-select: none;
        cursor: pointer;
    }

    .custom-toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
        position: absolute;
    }

    .toggle-switch-slider {
        position: relative;
        display: inline-block;
        width: 38px;
        height: 22px;
        background-color: #cbd5e1;
        border-radius: 20px;
        transition: background-color 0.25s ease, box-shadow 0.25s ease;
        flex-shrink: 0;
        margin-right: 8px !important;
    }

    .toggle-switch-slider:before {
        position: absolute;
        content: "";
        height: 16px;
        width: 16px;
        left: 3px;
        bottom: 3px;
        background-color: #ffffff;
        border-radius: 50%;
        transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.18);
    }

    .custom-toggle-switch input:checked + .toggle-switch-slider {
        background-color: #10b981;
    }

    .custom-toggle-switch input:checked + .toggle-switch-slider:before {
        transform: translateX(16px);
    }

    .custom-toggle-switch input:focus + .toggle-switch-slider {
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.25);
    }

    .custom-toggle-switch input:disabled + .toggle-switch-slider {
        opacity: 0.45;
        cursor: not-allowed;
    }

    .custom-toggle-switch:has(input:disabled) {
        cursor: not-allowed;
    }
</style>
@endpush

@push('scripts')
<script src="{{ asset('assets/plugins/datatables/datatables.bundle.min.js') }}" type="text/javascript"></script>
<script>
    var TableDatatablesEditable = function () {
        var handleTable = function () {
            var table = $('#myDataTables');
            var oTable = table.dataTable({
                "pageLength": 10,
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "Semua"]
                ],
                "language": {
                    "search": "",
                    "searchPlaceholder": "Cari nama, email, username...",
                    "lengthMenu": "Tampilkan _MENU_ data",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ pengguna",
                    "infoEmpty": "Tidak ada data pengguna",
                    "zeroRecords": "Tidak ditemukan data pengguna yang cocok",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Selanjutnya",
                        "previous": "Sebelumnya"
                    }
                },
                "columnDefs": [
                    {
                        'orderable': false,
                        'targets': [0, -1]
                    }, 
                    {
                        "searchable": false,
                        "targets": [0, 4, -1]
                    }
                ],
                "order": [
                    [1, "asc"]
                ]
            });
        }

        return {
            init: function () {
                handleTable();
            }
        };
    }();

    jQuery(document).ready(function() {
        TableDatatablesEditable.init();

        var roleFilter = $('#roles');
        if (roleFilter.hasClass('select2-hidden-accessible')) {
            roleFilter.select2('destroy');
        }
        roleFilter.select2({
            placeholder: 'Semua peran (pilih untuk memfilter)',
            allowClear: true,
            closeOnSelect: false,
            width: '100%'
        });

        // Initialize tooltips
        if ($.fn.tooltip) {
            $('[data-bs-toggle="tooltip"], .tooltips').tooltip();
        }
    });

    // Delegated modal click listener (clean, no setInterval polling)
    $(document).on('click', '.modalInterval', function (e) {
        e.preventDefault();
        var url = $(this).attr('value');
        var title = $(this).attr('title') || 'Formulir Pengguna';

        if (!url) return;

        $('#modalIntervalTitle').html(title);
        $('#modalIntervalContent').html(`
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status" style="width: 2.2rem; height: 2.2rem;">
                    <span class="sr-only visually-hidden">Memuat...</span>
                </div>
                <div class="text-muted mt-2 small">Memuat konten formulir...</div>
            </div>
        `);

        var modalEl = document.getElementById('modalInterval');
        if (window.bootstrap && window.bootstrap.Modal) {
            var modalInstance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl, {
                backdrop: 'static',
                keyboard: false
            });
            modalInstance.show();
        } else {
            $('#modalInterval').modal({backdrop: 'static', keyboard: false});
        }

        $('#modalIntervalContent').load(url, function (response, status, xhr) {
            if (status === "error") {
                $('#modalIntervalContent').html(`
                    <div class="alert alert-danger m-3" role="alert">
                        <i class="fa fa-exclamation-triangle me-2"></i> Gagal memuat formulir. Silakan segarkan halaman dan coba lagi.
                    </div>
                `);
            }
        });
    });

    // Delegated Toggle Switch Change Listener (AJAX Status Update)
    $(document).on('change', '.toggle-status-input', function () {
        var $checkbox = $(this);
        var userId = $checkbox.data('id');
        var isChecked = $checkbox.is(':checked');
        var $label = $checkbox.closest('.custom-toggle-switch').find('.toggle-status-label');
        var originalState = !isChecked;

        if ($checkbox.data('processing')) {
            return;
        }
        $checkbox.data('processing', true);

        // Optimistically update label
        if (isChecked) {
            $label.text('Aktif').removeClass('text-muted').addClass('text-success');
        } else {
            $label.text('Nonaktif').removeClass('text-success').addClass('text-muted');
        }

        $.ajax({
            url: '{{ url("user/toggle-status") }}/' + userId,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function (response) {
                $checkbox.data('processing', false);
                if (response.success) {
                    if (response.is_active) {
                        $checkbox.prop('checked', true);
                        $label.text('Aktif').removeClass('text-muted').addClass('text-success');
                    } else {
                        $checkbox.prop('checked', false);
                        $label.text('Nonaktif').removeClass('text-success').addClass('text-muted');
                    }

                    if (typeof swal !== 'undefined') {
                        const Toast = swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2500,
                            timerProgressBar: true
                        });
                        Toast.fire({
                            icon: 'success',
                            title: response.message
                        });
                    }
                } else {
                    $checkbox.prop('checked', originalState);
                    if (originalState) {
                        $label.text('Aktif').removeClass('text-muted').addClass('text-success');
                    } else {
                        $label.text('Nonaktif').removeClass('text-success').addClass('text-muted');
                    }
                    if (typeof swal !== 'undefined') {
                        swal.fire({
                            icon: 'warning',
                            title: 'Perhatian',
                            text: response.message || 'Gagal memperbarui status.'
                        });
                    }
                }
            },
            error: function (xhr) {
                $checkbox.data('processing', false);
                $checkbox.prop('checked', originalState);
                if (originalState) {
                    $label.text('Aktif').removeClass('text-muted').addClass('text-success');
                } else {
                    $label.text('Nonaktif').removeClass('text-success').addClass('text-muted');
                }

                var errorMsg = 'Gagal memperbarui status pengguna.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                if (typeof swal !== 'undefined') {
                    swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: errorMsg
                    });
                }
            }
        });
    });
</script>
@endpush

@push('modal')
<div class="modal fade" id="modalInterval" tabindex="-1" role="dialog" aria-labelledby="modalIntervalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden;">
            <div class="modal-header bg-light border-bottom px-4 py-3">
                <h5 class="modal-title font-weight-bold text-dark m-0" id="modalIntervalTitle">Formulir Pengguna</h5>
                <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="modalError"></div>
                <div id="modalIntervalContent"></div>
            </div>
        </div>
    </div>
</div>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="kt-portlet shadow-sm border-0" style="border-radius: 10px; overflow: hidden;">
                {{-- Header --}}
                <div class="kt-portlet__head py-3 px-4 d-flex align-items-center justify-content-between flex-wrap" style="background-color: #ffffff; border-bottom: 1px solid #eef2f6;">
                    <div class="kt-portlet__head-label d-flex align-items-center">
                        <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 42px; height: 42px; background-color: #e8f0fe; color: #1a73e8; margin-right: 12px;">
                            <i class="flaticon2-user" style="font-size: 1.25rem;"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center">
                                <h3 class="kt-portlet__head-title m-0 font-weight-bold text-dark" style="font-size: 1.15rem; margin-right: 8px;">
                                    Manajemen Pengguna
                                </h3>
                                <span class="badge" style="background-color: #f1f5f9; color: #475569; font-weight: 600; font-size: 12px; border-radius: 12px; padding: 3px 9px;">
                                    {{ $user->count() }} Pengguna
                                </span>
                            </div>
                            <span class="text-muted small" style="font-size: 12px;">Kelola akun pengguna, hak akses peran, dan keamanan sistem</span>
                        </div>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <a href="javascript:void(0)" value="{{ route('user.create') }}" class="btn btn-primary btn-sm px-3 modalInterval shadow-sm d-inline-flex align-items-center" data-bs-toggle="modal" title="Tambah Data Pengguna" data-bs-target="#modalInterval" style="border-radius: 6px; font-weight: 500;">
                            <i class="fa fa-user-plus" style="margin-right: 6px;"></i>
                            <span>Tambah Pengguna</span>
                        </a>
                    </div>
                </div>

                <div class="kt-portlet__body p-4">
                    {{-- Filter Toolbar --}}
                    <div class="filter-toolbar">
                        <form method="GET" class="row align-items-center m-0">
                            <div class="col-12 col-md-auto p-0 mb-2 mb-md-0 d-flex align-items-center" style="margin-right: 12px;">
                                <span class="text-muted font-weight-bold" style="font-size: 13px; white-space: nowrap;">
                                    <i class="fa fa-filter text-primary" style="margin-right: 4px;"></i> Filter Peran:
                                </span>
                            </div>
                            <div class="col-12 col-md p-0 mb-2 mb-md-0" style="min-width: 260px;">
                                <select id="roles" name="roles[]" class="form-control select2-format user-role-filter" multiple data-placeholder="Pilih satu atau beberapa peran...">
                                    @foreach($roles as $row)
                                        <option value="{{ $row->id }}" {{ in_array($row->id, $selectedRoles) ? 'selected' : '' }}>{{ $row->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-auto p-0 d-flex align-items-center" style="margin-left: 10px;">
                                <button type="submit" class="btn btn-primary btn-sm px-3" style="height: 38px; border-radius: 6px; font-weight: 500; margin-right: 6px;">
                                    <i class="fa fa-search" style="margin-right: 4px;"></i> Terapkan
                                </button>
                                @if(!empty($selectedRoles))
                                    <a href="{{ route('user.index') }}" class="btn btn-sm px-3 d-inline-flex align-items-center" style="height: 38px; border-radius: 6px; background-color: #ffffff; border: 1px solid #cbd5e1; color: #64748b;" title="Reset filter">
                                        <i class="fa fa-undo" style="margin-right: 4px;"></i> Reset
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>

                    {{-- Table --}}
                    <div class="table-responsive">
                        <table class="table table-modern align-middle w-100" id="myDataTables">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 45px;">No</th>
                                    <th class="text-start">Pengguna</th>
                                    <th class="text-start d-none d-md-table-cell">Kontak</th>
                                    <th class="text-start d-none d-sm-table-cell">Peran</th>
                                    <th class="text-center" style="width: 140px;">Status</th>
                                    <th class="text-center" style="width: 165px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user as $i => $item)
                                @php
                                    // Generate initials for avatar
                                    $words = explode(' ', trim($item->name ?? ''));
                                    $initials = '';
                                    foreach (array_slice($words, 0, 2) as $w) {
                                        $initials .= mb_strtoupper(mb_substr($w, 0, 1));
                                    }
                                    if (empty($initials)) {
                                        $initials = 'U';
                                    }

                                    // Deterministic soft color based on name
                                    $colorPalette = [
                                        ['bg' => '#e8f0fe', 'text' => '#1a73e8', 'border' => '#d2e3fc'],
                                        ['bg' => '#e6f4ea', 'text' => '#137333', 'border' => '#ceead6'],
                                        ['bg' => '#fef7e0', 'text' => '#b06000', 'border' => '#feefc3'],
                                        ['bg' => '#fce8e6', 'text' => '#c5221f', 'border' => '#fad2cf'],
                                        ['bg' => '#f3e8fd', 'text' => '#8430ce', 'border' => '#e9d2fd'],
                                        ['bg' => '#e0f2f1', 'text' => '#00796b', 'border' => '#b2dfdb'],
                                    ];
                                    $paletteIndex = abs(crc32($item->name ?? 'user')) % count($colorPalette);
                                    $avatarColor = $colorPalette[$paletteIndex];
                                @endphp
                                <tr>
                                    {{-- No --}}
                                    <td class="text-center text-muted" style="font-size: 13px;">{{ $i+1 }}</td>

                                    {{-- Pengguna (Avatar + Nama + Username) --}}
                                    <td>
                                        <div class="user-identity-cell">
                                            <div class="user-avatar-circle" style="background-color: {{ $avatarColor['bg'] }}; color: {{ $avatarColor['text'] }}; border: 1px solid {{ $avatarColor['border'] }};">
                                                {{ $initials }}
                                            </div>
                                            <div class="user-identity-info">
                                                <div class="font-weight-bold text-dark" style="font-size: 13.5px; line-height: 1.3;">
                                                    {{ $item->name }}
                                                </div>
                                                <div class="text-muted small" style="font-size: 12px; margin-top: 2px;">
                                                    {{ '@' . $item->username }}
                                                </div>
                                                {{-- Mobile-only compact metadata --}}
                                                <div class="d-md-none text-muted small mt-1" style="font-size: 11px;">
                                                    <div><i class="fa fa-envelope" style="margin-right: 4px;"></i>{{ $item->email }}</div>
                                                    @if(!empty($item->phone))
                                                        <div><i class="fa fa-phone" style="margin-right: 4px;"></i>{{ $item->phone }}</div>
                                                    @endif
                                                    <div class="mt-1">
                                                        @forelse($item->roles as $role)
                                                            <span class="badge" style="background-color: #f1f5f9; color: #475569; font-size: 10px; margin-right: 3px;">{{ $role->name }}</span>
                                                        @empty
                                                        @endforelse
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Kontak (Email + Phone) --}}
                                    <td class="d-none d-md-table-cell">
                                        <div class="text-dark" style="font-size: 13px;">
                                            <i class="fa fa-envelope text-muted" style="font-size: 11px; margin-right: 6px;"></i>{{ $item->email }}
                                        </div>
                                        @if(!empty($item->phone))
                                            <div class="text-muted small mt-1" style="font-size: 12px;">
                                                <i class="fa fa-phone text-muted" style="font-size: 11px; margin-right: 6px;"></i>{{ $item->phone }}
                                            </div>
                                        @else
                                            <div class="text-muted small mt-1" style="font-size: 12px;">
                                                <span class="text-muted">-</span>
                                            </div>
                                        @endif
                                    </td>

                                    {{-- Peran --}}
                                    <td class="d-none d-sm-table-cell">
                                        <div>
                                            @forelse($item->roles as $role)
                                                <span class="badge" style="background-color: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; font-size: 11.5px; font-weight: 500; border-radius: 6px; padding: 4px 8px; margin-right: 4px; margin-bottom: 2px; display: inline-block;">
                                                    {{ $role->name }}
                                                </span>
                                            @empty
                                                <span class="text-muted small">-</span>
                                            @endforelse
                                        </div>
                                    </td>

                                    {{-- Status (Toggle Switch) --}}
                                    <td class="text-center">
                                        <label class="custom-toggle-switch d-inline-flex align-items-center m-0" 
                                               @if(auth()->id() === $item->id) 
                                                   title="Tidak dapat menonaktifkan akun sendiri" 
                                               @endif>
                                            <input type="checkbox" 
                                                   class="toggle-status-input" 
                                                   data-id="{{ $item->id }}" 
                                                   data-name="{{ $item->name }}"
                                                   {{ ($item->is_active ?? true) ? 'checked' : '' }} 
                                                   {{ auth()->id() === $item->id ? 'disabled' : '' }}>
                                            <span class="toggle-switch-slider"></span>
                                            <span class="toggle-status-label small font-weight-bold {{ ($item->is_active ?? true) ? 'text-success' : 'text-muted' }}" style="font-size: 12px; min-width: 52px; text-align: left;">
                                                {{ ($item->is_active ?? true) ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </label>
                                    </td>

                                    {{-- Aksi (Visible Soft Buttons) --}}
                                    <td class="text-center" style="white-space: nowrap;">
                                        {{-- 1. Ubah Data (Edit) --}}
                                        <a href="javascript:void(0)" 
                                           value="{{ route('user.edit', ['id' => $item->id]) }}" 
                                           class="btn-action-icon btn-action-edit modalInterval tooltips" 
                                           data-original-title="Ubah Data Pengguna"
                                           title="Ubah Data Pengguna">
                                            <i class="fa fa-pen"></i>
                                        </a>

                                        {{-- 2. Ubah Password --}}
                                        <a href="javascript:void(0)" 
                                           value="{{ route('user.change-password', ['id' => $item->id]) }}" 
                                           class="btn-action-icon btn-action-password modalInterval tooltips" 
                                           data-original-title="Ubah Password"
                                           title="Ubah Password">
                                            <i class="fa fa-key"></i>
                                        </a>

                                        {{-- 3. Impersonasi (hanya jika bukan akun sendiri) --}}
                                        @if(auth()->id() !== $item->id)
                                            <a href="{{ route('impersonate', $item->id) }}" 
                                               class="btn-action-icon btn-action-impersonate tooltips" 
                                               data-original-title="Masuk Sebagai Pengguna (Impersonasi)"
                                               title="Masuk Sebagai Pengguna">
                                                <i class="fa fa-user-secret"></i>
                                            </a>

                                            {{-- 4. Hapus Pengguna --}}
                                            <form action="{{ route('user.destroy', $item->id) }}" method="POST" class="d-inline m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn-action-icon btn-action-delete js-submit-confirm tooltips" 
                                                        {{ $item->hasChild() ? 'disabled' : '' }} 
                                                        data-original-title="Hapus Pengguna"
                                                        title="Hapus Pengguna">
                                                    <i class="fa fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection