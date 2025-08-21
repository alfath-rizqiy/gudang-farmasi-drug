@extends('layouts.admin')

@section('title', 'Data kemasan')

@section('content')

        {{-- Tabel Data --}}
       <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Data kemasan</h1>
                   <div class="p-6">

        {{-- Tombol Tambah --}}
                 @role('admin')
                     <div class="mb-4">
                     <a href="{{ route('kemasan.create') }}" class="btn-sm btn btn-primary" data-toggle="modal" data-target="#modalKemasan"
                     >+ Tambah kemasan</a>
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
                                        <th>Nama Kemasan</th>
                                        <th>Tanggal Produksi</th>
                                        <th>Tanggal Kadaluarsa</th>
                                        <th>Petunjuk Penyimpanan</th>
                                         @role('admin')
                                        <th>Aksi</th>
                                         @endrole
                                        </tr>
                                    </thead>
                                    <tbody class="text-start">
                                         @forelse($kemasan as $kemasan)
                                        <tr>
                                            <td>{{ $kemasan->nama_kemasan }}</td>
                                            <td>{{ $kemasan->tanggal_produksi }}</td>
                                            <td>{{ $kemasan->tanggal_kadaluarsa }}</td>
                                            <td>{{ $kemasan->petunjuk_penyimpanan }}</td>
                                         @role('admin')
                                            <td>
                                                 <div class="d-flex justify-content-center">
                                                    <!-- Detail -->
                                                     <a href="{{ route('kemasan.show', $kemasan->id) }}" class="btn-sm btn btn-info btn-icon-split">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-info"></i>
                                                        </span>
                                                        <span class="text">Detail</span>
                                                    </a>
                                                    <!-- Edit -->
                                                    <a href="{{ route('kemasan.edit', $kemasan->id) }}" class="btn-sm btn btn-primary btn-icon-split mx-2">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-edit"></i>
                                                        </span>
                                                        <span class="text">Edit</span>
                                                    </a>
                                                    <!-- Hapus -->
                                                    <form action="{{ route('kemasan.destroy', $kemasan->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-sm btn btn-danger btn-icon-split show_confirm" data-name="{{ $kemasan->nama_kemasan }}">
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
             <div class="modal fade" id="modalKemasan" tabindex="-1" aria-labelledby="modalKemasanLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalKemasanLabel">Tambah Kemasan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <form action="{{ route('kemasan.store') }}" method="POST">
                                    @csrf

                                    <div class="form-group">
                                        <label for="nama">Nama Kemasan</label>
                                        <input type="text" name="nama_kemasan" id="nama_kemasan" class="form-control" placeholder="Masukkan kemasan" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="nama">Tanggal Produksi</label>
                                        <input type="date" name="tanggal_produksi" id="tanggal_produksi" class="form-control" placeholder="Masukkan Tanggal Produksi" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="nama">tanggal Kadaluarsa</label>
                                        <input type="date" name="tanggal_kadaluarsa" id="tanggal_kadaluarsa" class="form-control" placeholder="Masukkan Tanggal Kadaluarsa" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="nama">Petunjuk Penyimpanan</label>
                                        <input type="text" name="petunjuk_penyimpanan" id="petunjuk_penyimpanan" class="form-control" placeholder="Masukkan petunjuk_penyimpanan" required>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="{{ route('kemasan.index') }}" class="btn btn-secondary">Kembali</a>
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
                            new bootstrap.Modal(document.getElementById('modalKemasan')).show();
                        } else if (window.$) {
                            // Bootstrap 4
                            $('#modalKemasan').modal('show');
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

                <!-- Validasi data serupa -->
                @if($errors->has('nama_kemasan'))
                <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Input Nama',
                    text: '{{ $errors->first('nama_kemasan') }}'
                });
                </script>
                @endif

                @endpush
    @endsection
