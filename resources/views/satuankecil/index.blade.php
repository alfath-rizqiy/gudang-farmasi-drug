@extends('layouts.admin')

@section('title', 'Data Satuan Kecil')

@section('content')

        {{-- Tabel Data --}}
       <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Data Satuan Kecil</h1>
                  <div class="p-6">

        {{-- Tombol Tambah --}}
                 @role('admin')
                     <div class="mb-4">
                     <a href="{{ route('satuankecil.create') }}" class="btn-sm btn btn-primary" data-toggle="modal" data-target="#modalSatuankecil">
                        + Tambah Satuan Kecil</a>
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
                                        <th>Nama satuankecil</th>
                                        <th>Deskripsi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-start">
    @forelse($satuankecil as $item)
    <tr>
        <td>{{ $loop->iteration }}</td> 
        <td>{{ $item->nama_satuankecil }}</td>
        <td>{{ $item->deskripsi }}</td>
    @role('admin')
        <td>
            <div class="d-flex justify-content-center">
                <!-- Detail -->
                <a href="{{ route('satuankecil.show', $item->id) }}" class="btn-sm btn btn-info btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-info"></i>
                    </span>
                    <span class="text">Detail</span>
                </a>
                <!-- Edit -->
                <a href="#" class="btn-sm btn btn-primary btn-icon-split mx-2"
                   data-toggle="modal" data-target="#modalEditSatuankecil{{ $item->id }}">
                    <span class="icon text-white-50">
                        <i class="fas fa-edit"></i>
                    </span>
                    <span class="text">Edit</span>
                </a>
                <!-- Hapus -->
                <form action="{{ route('satuankecil.destroy', $item->id) }}" method="POST" >
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-sm btn btn-danger btn-icon-split show_confirm"
                     data-name="{{ $item->nama_satuankecil }}">
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

            <!-- Modal Form Tambah Kategori -->
             <div class="modal fade" id="modalSatuankecil" tabindex="-1" aria-labelledby="modalSatuankecilLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                         <div class="modal-header">
                            <h5 class="modal-title" id="modalSatuankecilLabel">Tambah satuankecil</h5>
                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <!-- Form Card Tambah -->
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <form action="{{ route('satuankecil.store') }}" method="POST">
                                     @csrf
                                    <div class="form-group">
                                        <label for="namaSatuanKecil">Nama Satuan Kecil</label>
                                        <input type="text" class="form-control" id="namaSatuanKecil" name="nama_satuankecil" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="deskripsiSatuanKecil">Deskripsi</label>
                                        <textarea class="form-control" id="deskripsiSatuanKecil" name="deskripsi" rows="3"></textarea>
                                    </div>

                                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                                    <a href="{{ route('satuankecil.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @foreach ($satuankecil as $item)
            <!-- Modal Form Edit satuankecil -->
             <div class="modal fade" id="modalEditSatuankecil{{ $item->id }}" tabindex="-1" aria-labelledby="modalSatuankecilLabel{{ $item->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalSatuankecilLabel{{ $item->id }}">Edit satuankecil</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                         <!-- Form Card Edit -->
                         <div class="card shadow mb-4">
                            <div class="card-body">
                                <form action="{{ route('satuankecil.update', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group">
                                        <label for="nama_satuankecil{{ $item->id }}">Nama satuankecil</label>
                                        <input type="text" name="nama_satuankecil" id="nama_satuankecil{{ $item->id }}" class="form-control"
                                        value="{{ old('nama_satuankecil', $item->nama_satuankecil) }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="deskripsi{{ $item->id }}">Deskripsi</label>
                                        <input type="text" name="deskripsi" id="deskripsi" class="form-control"
                                    value="{{ old('deskripsi', $item->deskripsi) }}" required>
                                    </div>

                                    <button type="submit" class="btn-sm btn btn-primary btn-icon-split show_update" data-name="{{ $item->nama_satuankecil }}">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-edit"></i>
                                        </span>
                                        <span class="text">Update</span>
                                    </button>
     
                                    <a href="{{ route('satuankecil.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
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
                new bootstrap.Modal(document.getElementById('modalSatuankecil')).show();
            } else if (window.$) {
                // Bootstrap 4
                $('#modalSatuankecil').modal('show');
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
                            text: `Apakah kamu yakin ingin mengupdate data "${nama}"?`,
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
                @if($errors->has('nama_satuankecil'))
                 <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Input Nama',
                    text: '{{ $errors->first('nama_satuankecil') }}'
                });
                </script>
                @endif

                @endpush
    @endsection