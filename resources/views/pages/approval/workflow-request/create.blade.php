@section('content')
<form method="POST" action="{{ route('approval.workflow-request.store') }}">
@csrf
    <div class="modal-body">
        <label>Workflow Approval <b class="text-danger">*</b></label>
        <div class="form-group">
            <select class="form-control select2-format" name="workflow_approval_id" required>
                <option value="">-- Pilih Workflow --</option>
                @foreach($workflowApprovals as $wa)
                    <option value="{{ $wa->id }}" {{ old('workflow_approval_id') == $wa->id ? 'selected' : '' }}>
                        {{ $wa->workflowDefinition->name ?? '-' }} ({{ $wa->version }})
                    </option>
                @endforeach
            </select>
            @error('workflow_approval_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <label>Kode Permintaan <b class="text-danger">*</b></label>
        <div class="form-group">
            <input type="text" class="form-control" name="request_code" required value="{{ old('request_code') }}" placeholder="Kode unik permintaan">
            @error('request_code') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <label>Sumber Permintaan</label>
        <div class="form-group">
            <input type="text" class="form-control" name="request_source" value="{{ old('request_source') }}" placeholder="Modul / sumber (opsional)">
            @error('request_source') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <label>Callback URL</label>
        <div class="form-group">
            <input type="url" class="form-control" name="callback_url" value="{{ old('callback_url') }}" placeholder="https://... (opsional)">
            @error('callback_url') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <label>Catatan</label>
        <div class="form-group">
            <textarea class="form-control" name="remarks" rows="3" placeholder="Catatan (opsional)">{{ old('remarks') }}</textarea>
            @error('remarks') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
    </div>

    <div class="modal-footer">
        <div class="form-group">
            <button class="btn btn-primary" type="submit"><i class="fa fa-paper-plane"></i> Kirim</button>
            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal"><i class="fa fa-undo"></i> Tutup</button>
        </div>
    </div>
</form>

<script>
    $('.select2-format').select2({ allowClear: true });
</script>
@endsection
