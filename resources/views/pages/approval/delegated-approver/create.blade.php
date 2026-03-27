@section('content')
<form method="POST" action="{{ route('approval.delegated-approver.store') }}">
@csrf
    <div class="modal-body">
        <label>Workflow Approver <b class="text-danger">*</b></label>
        <div class="form-group">
            <select class="form-control select2-format" name="workflow_approver_id" required>
                <option value="">-- Pilih Workflow Approver --</option>
                @foreach($workflowApprovers as $approver)
                    <option value="{{ $approver->id }}" {{ old('workflow_approver_id') == $approver->id ? 'selected' : '' }}>
                        {{ $approver->stage->workflowApproval->workflowDefinition->name ?? '-' }} &rsaquo; {{ $approver->stage->name ?? '-' }} ({{ $approver->user->name ?? 'Tanpa Pengguna' }})
                    </option>
                @endforeach
            </select>
            @error('workflow_approver_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <label>Delegasi Kepada <b class="text-danger">*</b></label>
        <div class="form-group">
            <select class="form-control select2-format" name="delegate_user_id" required>
                <option value="">-- Pilih Pengguna --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('delegate_user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
            @error('delegate_user_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="row">
            <div class="col-md-6">
                <label>Tanggal Mulai <b class="text-danger">*</b></label>
                <div class="form-group">
                    <input type="date" class="form-control" name="start_date" required value="{{ old('start_date') }}">
                    @error('start_date') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <label>Tanggal Selesai <b class="text-danger">*</b></label>
                <div class="form-group">
                    <input type="date" class="form-control" name="end_date" required value="{{ old('end_date') }}">
                    @error('end_date') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>
        </div>

        <label>Status Aktif</label>
        <div class="form-group">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
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
