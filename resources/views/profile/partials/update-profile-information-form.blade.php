<section>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Profile Information</h6>
            <small class="text-muted">Update your account's profile information and email address.</small>
        </div>

        <div class="card-body">
            <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
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

    <!-- Sweet Alert -->
            @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Succes -->
                <script>
                @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    timer: 2000,
                    showConfirmButton: false
                });
                @endif
                </script>
                @endpush
</section>
