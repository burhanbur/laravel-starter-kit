@section('content')
<form method="POST" action="{{ route('user.update-password', ['id' => $data->id]) }}" enctype="multipart/form-data" class="m-0">
@csrf
@method('PUT')

    @php
        $words = explode(' ', trim($data->name ?? ''));
        $initials = '';
        foreach (array_slice($words, 0, 2) as $w) {
            $initials .= mb_strtoupper(mb_substr($w, 0, 1));
        }
        if (empty($initials)) {
            $initials = 'U';
        }
    @endphp

	<div class="modal-body p-4">
        {{-- User Summary Card --}}
        <div class="d-flex align-items-center p-3 mb-3 rounded border" style="background-color: #f8fafc; border-color: #e2e8f0 !important;">
            <div class="d-flex align-items-center justify-content-center rounded-circle me-3 fw-bold" style="width: 44px; height: 44px; background-color: #e8f0fe; color: #1a73e8; border: 1px solid #d2e3fc; font-size: 15px;">
                {{ $initials }}
            </div>
            <div>
                <div class="fw-bold text-dark" style="font-size: 14px;">{{ $data->name }}</div>
                <div class="text-muted small" style="font-size: 12px;">
                    <span>{{ $data->email }}</span> &bull; <span>{{ '@' . $data->username }}</span>
                </div>
            </div>
        </div>

        <div class="row g-3">
            {{-- Password Baru --}}
            <div class="col-md-6 col-12">
                <div class="form-group mb-0">
                    <label class="form-label fw-semibold text-dark mb-1" for="new_password">
                        Password Baru <span class="text-danger">*</span>
                    </label>
                    <input type="password" class="form-control form-control-solid" id="new_password" name="password" required placeholder="Minimal 8 karakter">
                    @error('password')
                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            {{-- Konfirmasi Password Baru --}}
            <div class="col-md-6 col-12">
                <div class="form-group mb-0">
                    <label class="form-label fw-semibold text-dark mb-1" for="new_password_confirmation">
                        Konfirmasi Password Baru <span class="text-danger">*</span>
                    </label>
                    <input type="password" class="form-control form-control-solid" id="new_password_confirmation" name="password_confirmation" required placeholder="Ulangi password baru">
                </div>
            </div>

            <div class="col-12">
                <small class="text-muted d-block" style="font-size: 12px;">
                    <i class="fa fa-info-circle text-primary me-1"></i> Gunakan kombinasi huruf besar, huruf kecil, angka, dan simbol untuk kekuatan password yang maksimal.
                </small>
            </div>
        </div>
	</div>

	<div class="modal-footer bg-light px-4 py-3 d-flex justify-content-end gap-2 border-top">
		<button class="btn btn-secondary px-3" type="button" data-bs-dismiss="modal">
            <i class="fa fa-times me-1"></i> Batal
        </button>
		<button class="btn btn-primary px-4" type="submit">
            <i class="fa fa-key me-1"></i> Perbarui Password
        </button>
	</div>
</form>
@endsection