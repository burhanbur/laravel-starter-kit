@extends('layouts.main')

@section('title', config('app.alias') . ' | Approval Status')

@push('styles')
<link href="{{ asset('assets/plugins/datatables/datatables.bundle.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
<script src="{{ asset('assets/plugins/datatables/datatables.bundle.min.js') }}" type="text/javascript"></script>
<script>
    var TableDatatablesEditable = function () {
        var handleTable = function () {
            var table = $('#myDataTables');
            var oTable = table.dataTable({
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

    setInterval(function(){
        $('.modalInterval').off('click').on('click', function () {
            $('#modalInterval').modal({backdrop: 'static', keyboard: false});
            $('#modalIntervalContent').load($(this).attr('value'));
            $('#modalIntervalTitle').html($(this).attr('title'));
        });
    }, 500);
</script>
@endpush

@push('modal')
<div class="modal fade" id="modalInterval" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalIntervalTitle"></h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
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
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        <i class="flaticon2-check-mark"></i> &nbsp; Approval Status
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions">
                            <a href="javascript:void(0)" value="{{ route('approval.approval-status.create') }}" class="btn btn-icon btn-success modalInterval" data-bs-toggle="modal" title="Tambah Approval Status" data-bs-target="#modalInterval"><i class="la la-plus"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered" id="myDataTables" style="width: 100%;">
                        <thead>
                            <tr>
                                <td class="text-center" width="50px">No</td>
                                <td class="text-center">Kode</td>
                                <td class="text-center">Nama</td>
                                <td class="text-center d-none d-md-table-cell">Workflow Approval</td>
                                <td class="text-center d-none d-lg-table-cell">Deskripsi</td>
                                <td class="text-center" width="120px">#</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $i => $item)
                            <tr>
                                <td class="text-center align-middle">{{ $i+1 }}</td>
                                <td class="align-middle"><span class="badge badge-secondary">{{ $item->code }}</span></td>
                                <td class="align-middle">{{ $item->name }}</td>
                                <td class="align-middle d-none d-md-table-cell">
                                    {{ $item->workflowApproval->workflowDefinition->name ?? '-' }} ({{ $item->workflowApproval->version ?? '-' }})
                                </td>
                                <td class="align-middle d-none d-lg-table-cell">{{ $item->description ?? '-' }}</td>
                                <td class="text-center align-middle">
                                    <form action="{{ route('approval.approval-status.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <span class="tooltips" data-original-title="Ubah">
                                            <a href="javascript:void(0)" value="{{ route('approval.approval-status.edit', $item->id) }}" class="btn btn-sm btn-icon btn-info modalInterval" data-bs-toggle="modal" title="Ubah Approval Status" data-bs-target="#modalInterval"><i class="fa fa-edit"></i></a>
                                        </span>
                                        <span class="tooltips" data-original-title="Hapus">
                                            <button type="submit" class="btn btn-sm btn-icon btn-danger js-submit-confirm"><i class="fa fa-times"></i></button>
                                        </span>
                                    </form>
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
