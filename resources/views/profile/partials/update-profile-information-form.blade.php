<section>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Profile Information</h6>
            <small class="text-muted">Update your account's profile information and email address.</small>
        </div>

        <div class="card-body">
            <form id="formProfile" method="post" action="/profile" enctype="multipart/form-data">
                @csrf
                @method('patch')

                {{-- Foto Profil --}}
                <div class="form-group">
                    <label for="foto">Foto Profil</label>
                    @if ($user->foto)
                        <div class="mb-2">
                            <img src="{{ $user->foto ? asset('storage/public/foto_profile/'.$user->foto) : asset('storage/public/foto_profile/default.jpg') }}" 
                            alt="Foto Profil" class="rounded-circle border shadow" width="80" height="80">
                        </div>
                    @endif
                    <input type="file" class="form-control @error('foto') is-invalid @enderror" name="foto" id="foto">
                    @error('foto') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Name --}}
                <div class="form-group">
                    <label for="name">Name</label>
                    <input id="name" type="text" name="name" 
                           value="{{ old('name', $user->name) }}" 
                           class="form-control @error('name') is-invalid @enderror" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Email --}}
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" 
                           value="{{ old('email', $user->email) }}" 
                           class="form-control @error('email') is-invalid @enderror" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn btn-sm btn-primary">Save</button>
                <a href="{{ route('obat.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
              
                
            </form>
        </div>
    </div>

    {{-- Loader overlay ketika proses tambah/hapus --}}
    <div id="loader" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(255,255,255,0.7); z-index:9999; text-align:center;">
        <div style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%);">
            <i class="fas fa-spinner fa-spin fa-3x text-primary"></i>
            <p>Memproses data...</p>
        </div>
    </div>


@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="{{ asset('js/profile.js') }}"></script>
@endpush

