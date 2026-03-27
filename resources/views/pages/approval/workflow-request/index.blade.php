@extends('layouts.main')

@section('title', config('app.alias') . ' | Permintaan Approval')

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
                        <i class="flaticon2-inbox"></i> &nbsp; Permintaan Approval
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions">
                            <a href="javascript:void(0)" value="{{ route('approval.workflow-request.create') }}" class="btn btn-icon btn-success modalInterval" data-bs-toggle="modal" title="Buat Permintaan Approval" data-bs-target="#modalInterval"><i class="la la-plus"></i></a>
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
                                <td class="text-center">Kode Permintaan</td>
                                <td class="text-center">Workflow</td>
                                <td class="text-center">Pemohon</td>
                                <td class="text-center">Status</td>
                                <td class="text-center d-none d-md-table-cell">Level Saat Ini</td>
                                <td class="text-center d-none d-md-table-cell">Selesai</td>
                                <td class="text-center" width="120px">#</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $i => $item)
                            <tr>
                                <td class="text-center align-middle">{{ $i+1 }}</td>
                                <td class="align-middle"><span class="badge badge-secondary">{{ $item->request_code }}</span></td>
                                <td class="align-middle">{{ $item->workflowApproval->workflowDefinition->name ?? '-' }}</td>
                                <td class="align-middle">{{ $item->requester->name ?? '-' }}</td>
                                <td class="align-middle">
                                    @if($item->currentStatus)
                                        <span class="badge badge-info">{{ $item->currentStatus->name }}</span>
                                    @else
                                        <span class="badge badge-warning">Menunggu</span>
                                    @endif
                                </td>
                                <td class="text-center align-middle d-none d-md-table-cell">{{ $item->current_level }}</td>
                                <td class="text-center align-middle d-none d-md-table-cell">
                                    @if($item->completed_at)
                                        <span class="badge badge-success">{{ $item->completed_at->format('d/m/Y') }}</span>
                                    @else
                                        <span class="badge badge-secondary">-</span>
                                    @endif
                                </td>
                                <td class="text-center align-middle">
                                    <form action="{{ route('approval.workflow-request.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <span class="tooltips" data-original-title="Detail">
                                            <a href="{{ route('approval.workflow-request.show', $item->id) }}" class="btn btn-sm btn-icon btn-primary"><i class="fa fa-eye"></i></a>
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
