@section('content')
<form method="POST" action="{{ route('user.update-password', ['id' => $data->id]) }}" enctype="multipart/form-data">
@csrf
@method('PUT')

	<div class="modal-body">
		<label>Nama Lengkap</label>
		<div class="form-group">
			<input type="text" class="form-control" disabled value="{{ old('name', $data->name) }}" placeholder="Masukkan nama lengkap">
		</div>

		<label>Email</label>
		<div class="form-group">
			<input type="email" class="form-control" disabled value="{{ old('email', $data->email) }}" placeholder="Masukkan email">
		</div>

		<label>Password <b class="text-danger">*</b></label>
		<div class="form-group">
			<input type="password" class="form-control" name="password" placeholder="Masukkan password" required>
			@error('password')
				<small class="text-danger d-block">{{ $message }}</small>
			@enderror
		</div>

		<label>Konfirmasi Password <b class="text-danger">*</b></label>
		<div class="form-group">
			<input type="password" class="form-control" name="password_confirmation" placeholder="Masukkan konfirmasi password" required>
			<small class="text-muted">Konfirmasi password harus sama dengan password</small>
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
    $('.select2-format').select2({
		placeholder: 'Pilih peran',
		allowClear: true
	});
</script>
@endsection