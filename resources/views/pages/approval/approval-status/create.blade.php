@section('content')
<form method="POST" action="{{ route('approval.approval-status.store') }}">
@csrf
    <div class="modal-body">
        <label>Workflow Approval <b class="text-danger">*</b></label>
        <div class="form-group">
            <select class="form-control select2-format" name="workflow_approval_id" required>
                <option value="">-- Pilih Workflow Approval --</option>
                @foreach($workflowApprovals as $wa)
                    <option value="{{ $wa->id }}" {{ old('workflow_approval_id') == $wa->id ? 'selected' : '' }}>
                        {{ $wa->workflowDefinition->name ?? '-' }} ({{ $wa->version }})
                    </option>
                @endforeach
            </select>
            @error('workflow_approval_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <label>Kode <b class="text-danger">*</b></label>
        <div class="form-group">
            <input type="text" class="form-control" name="code" required value="{{ old('code') }}" placeholder="Contoh: APPROVED">
            @error('code') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <label>Nama <b class="text-danger">*</b></label>
        <div class="form-group">
            <input type="text" class="form-control" name="name" required value="{{ old('name') }}" placeholder="Nama status">
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <label>Deskripsi</label>
        <div class="form-group">
            <textarea class="form-control" name="description" rows="3" placeholder="Deskripsi (opsional)">{{ old('description') }}</textarea>
            @error('description') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
    </div>

    <div class="modal-footer">
        <div class="form-group">
            <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Simpan</button>
            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal"><i class="fa fa-undo"></i> Tutup</button>
        </div>
    </div>
</form>

<script>
    $('.select2-format').select2({ allowClear: true });
</script>
@endsection
