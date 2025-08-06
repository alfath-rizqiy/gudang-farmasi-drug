@extends('layouts.admin')

@section('title', 'Data Aturan Pakai')

@section('content')

       <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Tabel Data Aturan Pakai</h1>
                    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
                        For more information about DataTables, please visit the <a target="_blank"
                            href="https://datatables.net">official DataTables documentation</a>.</p>
                    <div class="p-6">

                 @role('admin')
                     <div class="mb-4">
                     <a href="{{ route('aturanpakai.create') }}" class="btn btn-primary">+ Tambah Aturan Pakai</a>
                     </div>
                 @endrole

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
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
                                    <tbody class="text-center">
                                         @forelse($aturanpakai as $aturanpakai)
                                        <tr>
                                            <td>{{ $aturanpakai->frekuensi_pemakaian }}</td>
                                            <td>{{ $aturanpakai->waktu_pemakaian }}</td>
                                            <td>{{ $aturanpakai->deskripsi }}</td>
                                         @role('admin')
                                            <td>
                                                 <div class="d-flex justify-content-center">
                                                    <!-- Detail -->
                                                     <a href="{{ route('aturanpakai.show', $aturanpakai->id) }}" class="btn btn-info btn-icon-split">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-info"></i>
                                                        </span>
                                                        <span class="text">Detail</span>
                                                    </a>
                                                    <!-- Edit -->
                                                    <a href="{{ route('aturanpakai.edit', $aturanpakai->id) }}" class="btn btn-primary btn-icon-split mx-2">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-edit"></i>
                                                        </span>
                                                        <span class="text">Edit</span>
                                                    </a>
                                                    <!-- Hapus -->
                                                    <form action="{{ route('aturanpakai.destroy', $aturanpakai->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-icon-split show_confirm" data-name="{{ $aturanpakai->frekuensi_pemakaian }}">
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

            <!-- Sweet Alert -->
            @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
            document.addEventListener("DOMContentLoaded", function () {
                const deleteButtons = document.querySelectorAll(".show_confirm");

                deleteButtons.forEach(function (button) {
                    button.addEventListener("click", function (event) {
                        event.preventDefault();  // Mencegah form langsung submit

                        const form = button.closest("form");
                        const nama = button.getAttribute("data-name");

                         // Menampilkan konfirmasi SweetAlert
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
                                form.submit(); // Submit form jika dikonfirmasi
                            }
                        });
                    });
                });
                });
                </script>
                @endpush

                @push('scripts')
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    @endsection
