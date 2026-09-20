@section('content')
<form method="POST" action="{{ route('user.store') }}" enctype="multipart/form-data" class="m-0">
@csrf
	<div class="modal-body p-4">
        <div class="row g-3">
            {{-- Nama Lengkap --}}
            <div class="col-md-6 col-12">
                <div class="form-group mb-0">
                    <label class="form-label fw-semibold text-dark mb-1" for="user_name">
                        Nama Lengkap <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control form-control-solid" id="user_name" name="name" required value="{{ old('name') }}" placeholder="Contoh: Burhan Mafazi">
                    @error('name')
                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            {{-- Username --}}
            <div class="col-md-6 col-12">
                <div class="form-group mb-0">
                    <label class="form-label fw-semibold text-dark mb-1" for="user_username">
                        Username <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted">@</span>
                        <input type="text" class="form-control form-control-solid border-start-0" id="user_username" name="username" required value="{{ old('username') }}" placeholder="bmafazi">
                    </div>
                    @error('username')
                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            {{-- Email --}}
            <div class="col-md-6 col-12">
                <div class="form-group mb-0">
                    <label class="form-label fw-semibold text-dark mb-1" for="user_email">
                        Alamat Email <span class="text-danger">*</span>
                    </label>
                    <input type="email" class="form-control form-control-solid" id="user_email" name="email" required value="{{ old('email') }}" placeholder="nama@domain.com">
                    @error('email')
                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            {{-- No. Telepon --}}
            <div class="col-md-6 col-12">
                <div class="form-group mb-0">
                    <label class="form-label fw-semibold text-dark mb-1" for="user_phone">
                        Nomor Telepon
                    </label>
                    <input type="text" class="form-control form-control-solid" id="user_phone" name="phone" value="{{ old('phone') }}" placeholder="Contoh: 081234567890">
                    @error('phone')
                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            {{-- Password --}}
            <div class="col-md-6 col-12">
                <div class="form-group mb-0">
                    <label class="form-label fw-semibold text-dark mb-1" for="user_password">
                        Password <span class="text-danger">*</span>
                    </label>
                    <input type="password" class="form-control form-control-solid" id="user_password" name="password" required placeholder="Minimal 8 karakter">
                    @error('password')
                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            {{-- Konfirmasi Password --}}
            <div class="col-md-6 col-12">
                <div class="form-group mb-0">
                    <label class="form-label fw-semibold text-dark mb-1" for="user_password_confirmation">
                        Konfirmasi Password <span class="text-danger">*</span>
                    </label>
                    <input type="password" class="form-control form-control-solid" id="user_password_confirmation" name="password_confirmation" required placeholder="Ulangi password">
                </div>
            </div>

            {{-- Peran (Roles) --}}
            <div class="col-12">
                <div class="form-group mb-0">
                    <label class="form-label fw-semibold text-dark mb-1" for="modal_user_roles">
                        Peran Akses <small class="text-muted fw-normal">(dapat memilih lebih dari satu)</small>
                    </label>
                    <select class="form-control modal-select2" id="modal_user_roles" name="roles[]" multiple data-placeholder="Pilih satu atau beberapa peran...">
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ in_array($role->id, old('roles', [])) ? 'selected' : '' }}>{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('roles')
                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            {{-- Status Aktif --}}
            <div class="col-12">
                <div class="p-3 rounded border d-flex align-items-center justify-content-between" style="background-color: #f8fafc; border-color: #e2e8f0 !important;">
                    <div>
                        <div class="fw-semibold text-dark" style="font-size: 13.5px;">Status Akun</div>
                        <small class="text-muted" style="font-size: 12px;">Pengguna berstatus aktif dapat masuk dan menggunakan sistem.</small>
                    </div>
                    <div>
                        <input type="hidden" name="is_active" value="0">
                        <label class="custom-toggle-switch m-0">
                            <input type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                            <span class="toggle-switch-slider"></span>
                            <span class="ms-2 fw-semibold small text-success" id="label_create_status">Aktif</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
	</div>

	<div class="modal-footer bg-light px-4 py-3 d-flex justify-content-end gap-2 border-top">
		<button class="btn btn-secondary px-3" type="button" data-bs-dismiss="modal">
            <i class="fa fa-times me-1"></i> Batal
        </button>
		<button class="btn btn-primary px-4" type="submit">
            <i class="fa fa-save me-1"></i> Simpan Pengguna
        </button>
	</div>
</form>

<script>
    $('#modalInterval').find('.modal-select2').select2({
		placeholder: 'Pilih satu atau beberapa peran...',
		allowClear: true,
		dropdownParent: $('#modalInterval'),
        width: '100%'
	});

    $('#is_active').on('change', function() {
        if ($(this).is(':checked')) {
            $('#label_create_status').text('Aktif').removeClass('text-muted').addClass('text-success');
        } else {
            $('#label_create_status').text('Nonaktif').removeClass('text-success').addClass('text-muted');
        }
    });
</script>
@endsection