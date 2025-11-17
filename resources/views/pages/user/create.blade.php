@section('content')
<form method="POST" action="{{ route('user.store') }}" enctype="multipart/form-data">
@csrf
	<div class="modal-body">
		<label>Nama Lengkap <b class="text-danger">*</b></label>
		<div class="form-group">
			<input type="text" class="form-control" name="name" required value="{{ old('name') }}" placeholder="Masukkan nama lengkap">
			@error('name')
				<small class="text-danger">{{ $message }}</small>
			@enderror
		</div>

		<label>Username <b class="text-danger">*</b></label>
		<div class="form-group">
			<input type="text" class="form-control" name="username" required value="{{ old('username') }}" placeholder="Masukkan username">
			@error('username')
				<small class="text-danger">{{ $message }}</small>
			@enderror
		</div>

		<label>Email <b class="text-danger">*</b></label>
		<div class="form-group">
			<input type="email" class="form-control" name="email" required value="{{ old('email') }}" placeholder="Masukkan email">
			@error('email')
				<small class="text-danger">{{ $message }}</small>
			@enderror
		</div>

		<label>No. Telepon</label>
		<div class="form-group">
			<input type="text" class="form-control" name="phone" value="{{ old('phone') }}" placeholder="Masukkan nomor telepon">
			@error('phone')
				<small class="text-danger">{{ $message }}</small>
			@enderror
		</div>

		<label>Password <b class="text-danger">*</b></label>
		<div class="form-group">
			<input type="password" class="form-control" name="password" required placeholder="Masukkan password">
			@error('password')
				<small class="text-danger">{{ $message }}</small>
			@enderror
		</div>

		<label>Konfirmasi Password <b class="text-danger">*</b></label>
		<div class="form-group">
			<input type="password" class="form-control" name="password_confirmation" required placeholder="Masukkan konfirmasi password">
		</div>

		<label>Peran</label>
		<div class="form-group">
			<select class="form-control select2-format" name="roles[]" multiple>
				@foreach($roles as $role)
					<option value="{{ $role->id }}" {{ in_array($role->id, old('roles', [])) ? 'selected' : '' }}>{{ $role->name }}</option>
				@endforeach
			</select>
			@error('roles')
				<small class="text-danger">{{ $message }}</small>
			@enderror
		</div>

		<label>Status Aktif</label>
		<div class="form-group">
			<div class="form-check">
				<input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
				<label class="form-check-label" for="is_active">
					Aktif
				</label>
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
    $('.select2-format').select2({
		// placeholder: 'Pilih peran',
		allowClear: true,
		// dropdownParent: $('#modalInterval')
	});
</script>
@endsection