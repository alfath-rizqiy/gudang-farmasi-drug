@extends('layouts.admin')

@section('title', 'Data Supplier')

@section('content')

        {{-- Tabel Data --}}
       <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Data Supplier</h1>
                  <div class="p-6">

        {{-- Tombol Tambah --}}
                 @role('admin')
                     <div class="mb-4">
                     <a href="{{ route('supplier.create') }}" class="btn-sm btn btn-primary" data-toggle="modal" data-target="#modalSupplier">
                        + Tambah Supplier</a>
                     </div>
                 @endrole

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" style="overflow-x: auto; white-space: nowrap;">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <th>Nama Supplier</th>
                                        <th>Telepon</th>
                                        <th>Email</th>
                                        <th>Alamat</th>
                                         @role('admin')
                                        <th>Aksi</th>
                                         @endrole
                                        </tr>
                                    </thead>
                                    <tbody class="text-start">
                                         @forelse($supplier as $supplier)
                                        <tr>
                                            <td>{{ $supplier->nama_supplier }}</td>
                                            <td>{{ $supplier->telepon }}</td>
                                            <td>{{ $supplier->email }}</td>
                                            <td>{{ $supplier->alamat }}</td>
                                         @role('admin')
                                            <td>
                                                 <div class="d-flex justify-content-center">
                                                    <!-- Detail -->
                                                     <a href="{{ route('supplier.show', $supplier->id) }}" class="btn-sm btn btn-info btn-icon-split">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-info"></i>
                                                        </span>
                                                        <span class="text">Detail</span>
                                                    </a>
                                                    <!-- Edit -->
                                                    <a href="{{ route('supplier.edit', $supplier->id) }}" class="btn-sm btn btn-primary btn-icon-split mx-2">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-edit"></i>
                                                        </span>
                                                        <span class="text">Edit</span>
                                                    </a>
                                                    <!-- Hapus -->
                                                    <form action="{{ route('supplier.destroy', $supplier->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-sm btn btn-danger btn-icon-split show_confirm" data-name="{{ $supplier->nama_supplier }}">
                                                            <span class="icon text-white-50">
                                                                <i class="fas fa-trash"></i>
                                                            </span>
                                                            <span class="text">Hapus</span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        @endrole
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7">Data tidak ditemukan.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </table>
            </div>

            <!-- Modal Tambah Kategori -->
             <div class="modal fade" id="modalSupplier" tabindex="-1" aria-labelledby="modalSupplierLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalSupplierLabel">Tambah Supplier</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

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
                </div>
            </div>

            <!-- Membuka kembali modal setelah validasi error -->
            @if(session('open_modal'))
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (window.bootstrap) {
                // Bootstrap 5
                new bootstrap.Modal(document.getElementById('modalSupplier')).show();
            } else if (window.$) {
                // Bootstrap 4
                $('#modalSupplier').modal('show');
            }
        });
         </script>
         @endif


         <!-- Sweet Alert -->
          @push('scripts')
          <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

          <!-- Sukses -->
            @if (session('success'))
            <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3085d6'
            });
            </script>
            @endif

            <!-- Gagal -->
            @if (session('error'))
            <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#d33'
            });
            </script>
            @endif

            <!-- Konfirmasi Tindakan -->
            <script>
            document.addEventListener("DOMContentLoaded", function () {
                const deleteButtons = document.querySelectorAll(".show_confirm");

                deleteButtons.forEach(function (button) {
                    button.addEventListener("click", function (event) {
                        event.preventDefault();

                        const form = button.closest("form");
                        const nama = button.getAttribute("data-name");

                        Swal.fire({
                            title: 'Apakah kamu yakin?',
                            text: `Data "${nama}" akan dihapus secara permanen!`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Ya, hapus!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    });
                });
                });
                </script>

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
