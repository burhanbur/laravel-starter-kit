@section('content')
<form method="POST" action="{{ route('approval.workflow-approval-stage.update', $data->id) }}">
@csrf
@method('PUT')
    <div class="modal-body">
        <label>Workflow Approval <b class="text-danger">*</b></label>
        <div class="form-group">
            <select class="form-control select2-format" name="workflow_approval_id" required>
                <option value="">-- Pilih Workflow Approval --</option>
                @foreach($workflowApprovals as $wa)
                    <option value="{{ $wa->id }}" {{ old('workflow_approval_id', $data->workflow_approval_id) == $wa->id ? 'selected' : '' }}>
                        {{ $wa->workflowDefinition->name ?? '-' }} ({{ $wa->version }})
                    </option>
                @endforeach
            </select>
            @error('workflow_approval_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <label>Nama Tahap <b class="text-danger">*</b></label>
        <div class="form-group">
            <input type="text" class="form-control" name="name" required value="{{ old('name', $data->name) }}" placeholder="Nama tahap">
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="row">
            <div class="col-md-6">
                <label>Urutan <b class="text-danger">*</b></label>
                <div class="form-group">
                    <input type="number" class="form-control" name="sequence" required value="{{ old('sequence', $data->sequence) }}" min="1">
                    @error('sequence') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <label>Level <b class="text-danger">*</b></label>
                <div class="form-group">
                    <input type="number" class="form-control" name="level" required value="{{ old('level', $data->level) }}" min="1">
                    @error('level') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>
        </div>

        <label>Logika Persetujuan <b class="text-danger">*</b></label>
        <div class="form-group">
            <select class="form-control" name="approval_logic" required>
                <option value="all" {{ old('approval_logic', $data->approval_logic) == 'all' ? 'selected' : '' }}>ALL - Semua approver harus menyetujui</option>
                <option value="any" {{ old('approval_logic', $data->approval_logic) == 'any' ? 'selected' : '' }}>ANY - Salah satu approver cukup</option>
            </select>
            @error('approval_logic') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
    </div>

    <div class="modal-footer">
        <div class="form-group">
            <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Perbarui</button>
            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal"><i class="fa fa-undo"></i> Tutup</button>
        </div>
    </div>
</form>

<script>
    $('.select2-format').select2({ allowClear: true });
</script>
@endsection
