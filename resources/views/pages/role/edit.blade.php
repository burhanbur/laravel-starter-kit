@section('content')
<form method="POST" action="{{ route('role.update', ['id' => $data->id]) }}" enctype="multipart/form-data">
@csrf
@method('PUT')

	<div class="modal-body">
		<label>Kode Role <b class="text-danger">*</b></label>
		<div class="form-group">
			<input type="text" class="form-control" name="code" required value="{{ old('code', $data->code) }}" placeholder="Masukkan kode role (contoh: SA, ADM)">
			@error('code')
				<small class="text-danger">{{ $message }}</small>
			@enderror
		</div>

		<label>Nama Role <b class="text-danger">*</b></label>
		<div class="form-group">
			<input type="text" class="form-control" name="name" required value="{{ old('name', $data->name) }}" placeholder="Masukkan nama role">
			@error('name')
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