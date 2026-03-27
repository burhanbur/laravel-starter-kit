@section('content')
<form method="POST" action="{{ route('approval.workflow-approval.store') }}">
@csrf
    <div class="modal-body">
        <label>Workflow Definition <b class="text-danger">*</b></label>
        <div class="form-group">
            <select class="form-control select2-format" name="workflow_definition_id" required>
                <option value="">-- Pilih Workflow Definition --</option>
                @foreach($workflowDefinitions as $wd)
                    <option value="{{ $wd->id }}" {{ old('workflow_definition_id') == $wd->id ? 'selected' : '' }}>{{ $wd->name }}</option>
                @endforeach
            </select>
            @error('workflow_definition_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <label>Versi <b class="text-danger">*</b></label>
        <div class="form-group">
            <input type="text" class="form-control" name="version" required value="{{ old('version', 'v1.0') }}" placeholder="Contoh: v1.0">
            @error('version') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <label>Status Aktif</label>
        <div class="form-group">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', false) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Aktif</label>
            </div>
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
