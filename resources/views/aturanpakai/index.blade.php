@extends('layouts.admin')

@section('title', 'Data aturanpakai')

@section('content')

        {{-- Tabel Data --}}
       <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Data aturanpakai</h1>
                   <div class="p-6">

        {{-- Tombol Tambah --}}
                 @role('admin')
                     <div class="mb-4">
                     <a href="{{ route('aturanpakai.create') }}" class="btn-sm btn btn-primary" data-toggle="modal" data-target="#modalAturanPakai">
                        + Tambah Aturan Pakai</a>
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
                                        <th>Frekuensi Pemakaian</th>
                                        <th>Waktu Pemakaian</th>
                                        <th>Deskripsi</th>
                                         @role('admin')
                                        <th>Aksi</th>
                                         @endrole
                                        </tr>
                                    </thead>
                                    <tbody class="text-start">
                                         @forelse($aturanpakai as $aturanpakai)
                                        <tr>
                                            <td>{{ $aturanpakai->frekuensi_pemakaian }}</td>
                                            <td>{{ $aturanpakai->waktu_pemakaian }}</td>
                                            <td>{{ $aturanpakai->deskripsi }}</td>
                                         @role('admin')
                                            <td>
                                                 <div class="d-flex justify-content-center">
                                                    <!-- Detail -->
                                                     <a href="{{ route('aturanpakai.show', $aturanpakai->id) }}" class="btn-sm btn btn-info btn-icon-split">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-info"></i>
                                                        </span>
                                                        <span class="text">Detail</span>
                                                    </a>
                                                    <!-- Edit -->
                                                    <a href="{{ route('aturanpakai.edit', $aturanpakai->id) }}" class="btn-sm btn btn-primary btn-icon-split mx-2">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-edit"></i>
                                                        </span>
                                                        <span class="text">Edit</span>
                                                    </a>
                                                    <!-- Hapus -->
                                                    <form action="{{ route('aturanpakai.destroy', $aturanpakai->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-sm btn btn-danger btn-icon-split show_confirm" data-name="{{ $aturanpakai->nama_aturanpakai }}">
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
             <div class="modal fade" id="modalAturanPakai" tabindex="-1" aria-labelledby="modalAturanPakaiLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalAturanPakaiLabel">Tambah Aturan Pakai</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <form action="{{ route('aturanpakai.store') }}" method="POST">
                                    @csrf

                                    <div class="form-group">
                                        <label for="nama">Frekuensi Pemakaian</label>
                                        <input type="text" name="frekuensi_pemakaian" id="frekuensi_pemakaian" class="form-control" placeholder="Masukkan Frekuensi Pemakaian" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="nama">Waktu Pemakaian</label>
                                        <input type="text" name="waktu_pemakaian" id="waktu_pemakaian" class="form-control" placeholder="Masukkan Waktu Pemakaian" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="nama">Deskripsi</label>
                                        <textarea name="deskripsi" id="deskripsi" class="form-control" placeholder="Masukkan Deskripsi" rows="4" required></textarea>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="{{ route('aturanpakai.index') }}" class="btn btn-secondary">Kembali</a>
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
                new bootstrap.Modal(document.getElementById('modalAturanPakai')).show();
            } else if (window.$) {
                // Bootstrap 4
                $('#modalAturanPakai').modal('show');
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
                @if($errors->has('frekuensi_pemakaian'))
                <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Input Frekuensi Pemakaian',
                    text: '{{ $errors->first('frekuensi_pemakaian') }}'
                });
                </script>
                @endif

                @endpush
    @endsection
