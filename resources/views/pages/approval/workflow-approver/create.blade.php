@section('content')
<form method="POST" action="{{ route('approval.workflow-approver.store') }}">
@csrf
    <div class="modal-body">
        <label>Tahap Workflow <b class="text-danger">*</b></label>
        <div class="form-group">
            <select class="form-control select2-format" name="workflow_approval_stage_id" required>
                <option value="">-- Pilih Tahap --</option>
                @foreach($stages as $stage)
                    <option value="{{ $stage->id }}" {{ old('workflow_approval_stage_id') == $stage->id ? 'selected' : '' }}>
                        {{ $stage->workflowApproval->workflowDefinition->name ?? '-' }} &rsaquo; {{ $stage->name }} (Level {{ $stage->level }})
                    </option>
                @endforeach
            </select>
            @error('workflow_approval_stage_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <label>Tipe Approver <b class="text-danger">*</b></label>
        <div class="form-group">
            <select class="form-control select2-format" name="approval_type_id" required>
                <option value="">-- Pilih Tipe Approver --</option>
                @foreach($approverTypes as $type)
                    <option value="{{ $type->id }}" {{ old('approval_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                @endforeach
            </select>
            @error('approval_type_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <label>Pengguna</label>
        <div class="form-group">
            <select class="form-control select2-format" name="user_id">
                <option value="">-- Tidak Spesifik --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
            @error('user_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <label>Level <b class="text-danger">*</b></label>
        <div class="form-group">
            <input type="number" class="form-control" name="level" required value="{{ old('level', 1) }}" min="1">
            @error('level') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <label>Catatan</label>
        <div class="form-group">
            <textarea class="form-control" name="remarks" rows="2" placeholder="Catatan (opsional)">{{ old('remarks') }}</textarea>
            @error('remarks') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_optional" value="1" id="is_optional" {{ old('is_optional') ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_optional">Persetujuan Opsional</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="can_delegate" value="1" id="can_delegate" {{ old('can_delegate') ? 'checked' : '' }}>
                    <label class="form-check-label" for="can_delegate">Dapat Mendelegasikan</label>
                </div>
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
