@section('content')
<form method="POST" action="{{ route('approval.workflow-definition.store') }}">
@csrf
    <div class="modal-body">
        <label>Kode <b class="text-danger">*</b></label>
        <div class="form-group">
            <input type="text" class="form-control" name="code" required value="{{ old('code') }}" placeholder="Contoh: WF-001">
            @error('code') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <label>Nama <b class="text-danger">*</b></label>
        <div class="form-group">
            <input type="text" class="form-control" name="name" required value="{{ old('name') }}" placeholder="Nama workflow definition">
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
@endsection
