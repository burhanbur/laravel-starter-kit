@extends('layouts.main')

@section('title', config('app.alias') . ' | Detail Riwayat Approval')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        <i class="flaticon2-list-2"></i> &nbsp; Detail Riwayat Approval
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <a href="{{ route('approval.approval-history.index') }}" class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left"></i> Kembali</a>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th width="40%">Permintaan</th>
                                <td>{{ $data->workflowRequest->request_code ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Workflow</th>
                                <td>{{ $data->workflowRequest->workflowApproval->workflowDefinition->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Pengguna</th>
                                <td>{{ $data->user->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Aksi</th>
                                <td><span class="badge badge-secondary">{{ $data->action ?? '-' }}</span></td>
                            </tr>
                            <tr>
                                <th>Status Approval</th>
                                <td>
                                    @if($data->approval && $data->approval->approvalStatus)
                                        <span class="badge badge-info">{{ $data->approval->approvalStatus->name }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Catatan</th>
                                <td>{{ $data->note ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal</th>
                                <td>{{ $data->approved_at ? $data->approved_at->format('d/m/Y H:i') : ($data->created_at ? $data->created_at->format('d/m/Y H:i') : '-') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
