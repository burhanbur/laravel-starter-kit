@section('content')
<form method="POST" action="{{ route('approval.approval.store') }}">
@csrf
    <div class="modal-body">
        <label>Permintaan Approval <b class="text-danger">*</b></label>
        <div class="form-group">
            <select class="form-control select2-format" name="workflow_request_id" required>
                <option value="">-- Pilih Permintaan --</option>
                @foreach($workflowRequests as $wr)
                    <option value="{{ $wr->id }}" {{ old('workflow_request_id') == $wr->id ? 'selected' : '' }}>
                        {{ $wr->request_code }} - {{ $wr->workflowApproval->workflowDefinition->name ?? '-' }}
                    </option>
                @endforeach
            </select>
            @error('workflow_request_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <label>Status Persetujuan <b class="text-danger">*</b></label>
        <div class="form-group">
            <select class="form-control select2-format" name="approval_status_id" required>
                <option value="">-- Pilih Status --</option>
                @foreach($approvalStatuses as $status)
                    <option value="{{ $status->id }}" {{ old('approval_status_id') == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                @endforeach
            </select>
            @error('approval_status_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <label>Catatan</label>
        <div class="form-group">
            <textarea class="form-control" name="note" rows="3" placeholder="Catatan persetujuan (opsional)">{{ old('note') }}</textarea>
            @error('note') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
    </div>

    <div class="modal-footer">
        <div class="form-group">
            <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i> Proses</button>
            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal"><i class="fa fa-undo"></i> Tutup</button>
        </div>
    </div>
</form>

<script>
    $('.select2-format').select2({ allowClear: true });
</script>
@endsection
