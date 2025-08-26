@extends('layouts.admin')

@section('title', 'Data metodepembayaran')

@section('content')

        {{-- Tabel Data --}}
       <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Data metodepembayaran</h1>
                  <div class="p-6">

        {{-- Tombol Tambah --}}
                 @role('admin')
                     <div class="mb-4">
                     <a href="#" class="btn-sm btn btn-primary" data-toggle="modal" data-target="#modalMetodepembayaran">
                        + Tambah metodepembayaran</a>
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
                                        <th>No</th>
                                        <th>Nama Metode Pembayaran</th>
                                        <th>Deskripsi</th>
                                        <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-start">
                                         @forelse($metodepembayaran as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td> 
                                            <td>{{ $item->nama_metode }}</td>
                                            <td>{{ $item->deskripsi }}</td>
                                         @role('admin')
                                            <td>
                                                 <div class="d-flex justify-content-center">
                                                    <!-- Detail -->
                                                     <a href="{{ route('metodepembayaran.show', $item->id) }}" class="btn-sm btn btn-info btn-icon-split">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-info"></i>
                                                        </span>
                                                        <span class="text">Detail</span>
                                                    </a>
                                                    <!-- Edit -->
                                                    <a href="#" class="btn-sm btn btn-primary btn-icon-split mx-2"
                                                       data-toggle="modal" data-target="#modalEditMetodepembayaran{{ $item->id }}">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-edit"></i>
                                                        </span>
                                                        <span class="text">Edit</span>
                                                    </a>
                                                    <!-- Hapus -->
                                                    <form action="{{ route('metodepembayaran.destroy', $item->id) }}" method="POST" >
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-sm btn btn-danger btn-icon-split show_confirm"
                                                         data-name="{{ $item->nama_metode }}">
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

            <!-- Modal Form Tambah metodepembayaran -->
             <div class="modal fade" id="modalMetodepembayaran" tabindex="-1" aria-labelledby="modalMetodepembayaranLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                         <div class="modal-header">
                            <h5 class="modal-title" id="modalMetodepembayaranLabel">Tambah metodepembayaran</h5>
                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <!-- Form Card Tambah -->
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <form action="{{ route('metodepembayaran.store') }}" method="POST">
                                     @csrf
                                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_metode" class="form-label">Nama Metode</label>
                            <input type="text" class="form-control" id="nama_metode" name="nama_metode" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
                        </div>
                    </div>

                                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                                    <a href="{{ route('metodepembayaran.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @foreach ($metodepembayaran as $item)
            <!-- Modal Form Edit metodepembayaran -->
             <div class="modal fade" id="modalEditMetodepembayaran{{ $item->id }}" tabindex="-1" aria-labelledby="modalMetodepembayaranLabel{{ $item->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalMetodepembayaranLabel{{ $item->id }}">Edit metodepembayaran</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <!-- Form Card Edit -->
                         <div class="card shadow mb-4">
                            <div class="card-body">
                                <form action="{{ route('metodepembayaran.update', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group">
                                        <label for="nama_metode{{ $item->id }}">Nama Metode</label>
                                    <!--sama-->
                                    <input type="text" name="nama_metode" id="nama_metode" class="form-control"
                                    value="{{ old('nama_metode', $item->nama_metode) }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="deskripsi{{ $item->id }}">Deskripsi</label>
                                    <input type="text" name="deskripsi" id="deskripsi" class="form-control"
                                    value="{{ old('deskripsi', $item->deskripsi) }}" required>
                                    </div>



                                    <button type="submit" class="btn-sm btn btn-primary btn-icon-split show_update" data-name="{{ $item->nama_metode }}">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-edit"></i>
                                        </span>
                                        <span class="text">Update</span>
                                    </button>
     
                                    <a href="{{ route('metodepembayaran.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach


            <!-- Membuka kembali modal setelah validasi error -->
            @if(session('open_modal'))
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (window.bootstrap) {
                // Bootstrap 5
                new bootstrap.Modal(document.getElementById('modalMetodepembayaran')).show();
            } else if (window.$) {
                // Bootstrap 4
                $('#modalMetodepembayaran').modal('show');
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
                            text: 'Data "${nama}" akan dihapus secara permanen!',
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

            <!-- Konfirmasi Tindakan Update -->
            <script>
            document.addEventListener("DOMContentLoaded", function () {
                const updateButtons = document.querySelectorAll(".show_update");

                updateButtons.forEach(function (button) {
                    button.addEventListener("click", function (event) {
                        event.preventDefault();

                        const form = button.closest("form");
                        const nama = button.getAttribute("data-name");

                        Swal.fire({
                            title: 'Konfirmasi Update',
                            text: 'Apakah kamu yakin ingin mengupdate data?',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya, update!',
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
                @if($errors->has('nama_metode'))
                 <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Input Nama',
                    text: '{{ $errors->first('nama_metode') }}'
                });
                </script>
                @endif

                @endpush
    @endsection