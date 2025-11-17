@section('content')
<form method="POST" action="{{ route('route.store') }}" enctype="multipart/form-data">
@csrf
	<div class="modal-body">
		<label>Nama Route <b class="text-danger">*</b></label>
		<div class="form-group">
			<input type="text" class="form-control" name="name" required value="{{ old('name') }}" placeholder="Masukkan nama route (contoh: user.index)">
			@error('name')
				<small class="text-danger">{{ $message }}</small>
			@enderror
		</div>

		<label>Method <b class="text-danger">*</b></label>
		<div class="form-group">
			<select class="form-control" name="method" required>
				<option value="">Pilih Method</option>
				<option value="GET" {{ old('method') == 'GET' ? 'selected' : '' }}>GET</option>
				<option value="POST" {{ old('method') == 'POST' ? 'selected' : '' }}>POST</option>
				<option value="PUT" {{ old('method') == 'PUT' ? 'selected' : '' }}>PUT</option>
				<option value="PATCH" {{ old('method') == 'PATCH' ? 'selected' : '' }}>PATCH</option>
				<option value="DELETE" {{ old('method') == 'DELETE' ? 'selected' : '' }}>DELETE</option>
			</select>
			@error('method')
				<small class="text-danger">{{ $message }}</small>
			@enderror
		</div>

		<label>Modul <b class="text-danger">*</b></label>
		<div class="form-group">
			<input type="text" class="form-control" name="module" required value="{{ old('module') }}" placeholder="Masukkan modul (contoh: User Management)">
			@error('module')
				<small class="text-danger">{{ $message }}</small>
			@enderror
		</div>

		<label>Deskripsi</label>
		<div class="form-group">
			<textarea class="form-control" name="description" rows="3" placeholder="Masukkan deskripsi route">{{ old('description') }}</textarea>
			@error('description')
				<small class="text-danger">{{ $message }}</small>
			@enderror
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