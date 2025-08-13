@extends('layouts.admin')

@section('title', 'Tambah Data Obat')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Tambah Data Supplier</h1>

    <!-- Form Card -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('supplier.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="nama">Nama Supplier</label>
                    <input type="text" name="nama_supplier" id="nama_supplier" class="form-control" placeholder="Masukkan Supplier" required>
                </div>

                <div class="form-group">
                    <label for="nama">Telepon</label>
                    <input type="number" name="telepon" id="telepon" class="form-control" placeholder="Masukkan Telepon" required>
                </div>

                <div class="form-group">
                    <label for="nama">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan Email" required>
                </div>

                <div class="form-group">
                    <label for="nama">Alamat</label>
                    <input type="text" name="alamat" id="alamat" class="form-control" placeholder="Masukkan Alamat" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('supplier.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>

                <!-- Sweet Alert -->
                @push('scripts')
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                <!-- Validasi nama serupa -->
                @if($errors->has('nama_supplier'))
                <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Input Nama',
                    text: '{{ $errors->first('nama_supplier') }}'
                });
                </script>
                @endif
                @endpush
@endsection
