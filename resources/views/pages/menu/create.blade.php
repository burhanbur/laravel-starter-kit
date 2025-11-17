@section('content')
<form method="POST" action="{{ route('menu.store') }}" enctype="multipart/form-data">
@csrf
	<div class="modal-body">
		<label>Nama Menu <b class="text-danger">*</b></label>
		<div class="form-group">
			<input type="text" class="form-control" name="name" required value="{{ old('name') }}" placeholder="Masukkan nama menu">
			@error('name')
				<small class="text-danger">{{ $message }}</small>
			@enderror
		</div>

		<label>Icon</label>
		<div class="form-group">
			<input type="text" class="form-control" name="icon" value="{{ old('icon') }}" placeholder="Masukkan icon (contoh: flaticon2-user)">
			@error('icon')
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