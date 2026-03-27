@extends('layouts.main')

@section('title', config('app.alias') . ' | Riwayat Approval')

@push('styles')
<link href="{{ asset('assets/plugins/datatables/datatables.bundle.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
<script src="{{ asset('assets/plugins/datatables/datatables.bundle.min.js') }}" type="text/javascript"></script>
<script>
    var TableDatatablesEditable = function () {
        var handleTable = function () {
            $('#myDataTables').dataTable({
                "pageLength": 10,
                "lengthMenu": [[10, 15, 20, -1], [10, 15, 20, "All"]],
                "language": {
                    "search": "", "searchPlaceholder": "Cari data...",
                    "lengthMenu": "Tampilkan _MENU_ data",
                    "info": "Menampilkan _START_ hingga _END_ dari _TOTAL_ entri",
                    "infoEmpty": "Tidak ada entri yang ditemukan",
                    "zeroRecords": "Tidak ada data yang cocok ditemukan",
                    "paginate": {"first": "Pertama", "last": "Terakhir", "next": "Selanjutnya", "previous": "Sebelumnya"}
                },
                "columnDefs": [{'orderable': false, 'targets': [0, -1]}, {"searchable": true, "targets": [0]}],
                "order": [[0, "asc"]]
            });
        }
        return { init: function () { handleTable(); } };
    }();

    jQuery(document).ready(function() { TableDatatablesEditable.init(); });
</script>
@endpush

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        <i class="flaticon2-list-2"></i> &nbsp; Riwayat Approval
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered" id="myDataTables" style="width: 100%;">
                        <thead>
                            <tr>
                                <td class="text-center" width="50px">No</td>
                                <td class="text-center">Permintaan</td>
                                <td class="text-center">Pengguna</td>
                                <td class="text-center">Aksi</td>
                                <td class="text-center d-none d-md-table-cell">Catatan</td>
                                <td class="text-center d-none d-md-table-cell">Tanggal</td>
                                <td class="text-center" width="80px">#</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $i => $item)
                            <tr>
                                <td class="text-center align-middle">{{ $i+1 }}</td>
                                <td class="align-middle">{{ $item->workflowRequest->request_code ?? '-' }}</td>
                                <td class="align-middle">{{ $item->user->name ?? '-' }}</td>
                                <td class="align-middle"><span class="badge badge-secondary">{{ $item->action ?? '-' }}</span></td>
                                <td class="align-middle d-none d-md-table-cell">{{ $item->note ?? '-' }}</td>
                                <td class="align-middle d-none d-md-table-cell">{{ $item->approved_at ? $item->approved_at->format('d/m/Y H:i') : $item->created_at->format('d/m/Y H:i') }}</td>
                                <td class="text-center align-middle">
                                    <span class="tooltips" data-original-title="Detail">
                                        <a href="{{ route('approval.approval-history.show', $item->id) }}" class="btn btn-sm btn-icon btn-primary"><i class="fa fa-eye"></i></a>
                                    </span>
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
