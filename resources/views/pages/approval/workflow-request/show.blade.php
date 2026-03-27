@extends('layouts.main')

@section('title', config('app.alias') . ' | Detail Permintaan Approval')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        <i class="flaticon2-inbox"></i> &nbsp; Detail Permintaan Approval
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <a href="{{ route('approval.workflow-request.index') }}" class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left"></i> Kembali</a>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th width="40%">Kode Permintaan</th>
                                <td><span class="badge badge-secondary">{{ $data->request_code }}</span></td>
                            </tr>
                            <tr>
                                <th>Workflow</th>
                                <td>{{ $data->workflowApproval->workflowDefinition->name ?? '-' }} ({{ $data->workflowApproval->version ?? '-' }})</td>
                            </tr>
                            <tr>
                                <th>Pemohon</th>
                                <td>{{ $data->requester->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Sumber</th>
                                <td>{{ $data->request_source ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Level Saat Ini</th>
                                <td>{{ $data->current_level }}</td>
                            </tr>
                            <tr>
                                <th>Status Saat Ini</th>
                                <td>
                                    @if($data->currentStatus)
                                        <span class="badge badge-info">{{ $data->currentStatus->name }}</span>
                                    @else
                                        <span class="badge badge-warning">Menunggu</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Selesai Pada</th>
                                <td>{{ $data->completed_at ? $data->completed_at->format('d/m/Y H:i') : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Catatan</th>
                                <td>{{ $data->remarks ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                @if($data->approvals && $data->approvals->count())
                <hr>
                <h5>Riwayat Persetujuan</h5>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <td class="text-center" width="50px">No</td>
                                <td class="text-center">Approver</td>
                                <td class="text-center">Status</td>
                                <td class="text-center">Level</td>
                                <td class="text-center">Catatan</td>
                                <td class="text-center">Tanggal</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data->approvals as $i => $approval)
                            <tr>
                                <td class="text-center align-middle">{{ $i+1 }}</td>
                                <td class="align-middle">{{ $approval->user->name ?? '-' }}</td>
                                <td class="text-center align-middle">
                                    @if($approval->approvalStatus)
                                        <span class="badge badge-info">{{ $approval->approvalStatus->name }}</span>
                                    @else
                                        <span class="badge badge-warning">Menunggu</span>
                                    @endif
                                </td>
                                <td class="text-center align-middle">{{ $approval->level }}</td>
                                <td class="align-middle">{{ $approval->note ?? '-' }}</td>
                                <td class="align-middle">{{ $approval->approved_at ? $approval->approved_at->format('d/m/Y H:i') : '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
