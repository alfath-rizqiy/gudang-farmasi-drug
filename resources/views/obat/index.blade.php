@extends('layouts.admin')

@section('title', 'Data Obat')

@section('content')

        <!-- Tabel Data -->
       <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Data Obat</h1>
                    <div class="p-6">

                    <div class="d-flex gap-3 space-x-3">
        <!-- Tombol Tambah -->
                 @role('admin|petugas')
                     <div class="m-2 mb-4">
                     <a href="{{ route('obat.create') }}" class="btn btn-sm btn-primary">
                        <span class="icon text-white-10">
                            <i class="fa fa-plus"></i>
                        </span>
                        Tambah Obat</a>
                     </div>
                 @endrole

        <!-- Tombol Download -->
                 @role('admin|petugas')
                     <div class="m-2 mb-4">
                     <a href="{{ route('obat.export.pdf') }}" class="btn-sm btn btn-danger">
                        <span class="icon text-white-10">
                            <i class="fas fa-download"></i>
                        </span>
                         Download PDF</a>
                     </div>
                 @endrole

        <!-- Tombol Download -->
                 @role('admin|petugas')
                     <div class="m-2 mb-4">
                     <a href="{{ route('obat.export.excel') }}" class="btn-sm btn btn-success">
                        <span class="icon text-white-10">
                            <i class="fas fa-download"></i>
                        </span>
                        Download Excel</a>
                     </div>
                 @endrole
                 </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data Table</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" style="overflow-x: auto; white-space: nowrap;">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <th>No</th>
                                        <th>Obat</th>
                                        <th>Supllier</th>
                                        <th>Kemasan</th>
                                        <th>Satuan Kecil</th>
                                        <th>Satuan Besar</th>
                                        <th>Aturan Pakai</th>
                                        <th>Kategori</th>
                                        <th>Metode Pembayaran</th>
                                        <th>Tanggal Input</th>
                                        <th>Foto Obat</th>
                                         @role('admin')
                                        <th>Aksi</th>
                                         @endrole
                                        </tr>
                                    </thead>
                                    <tbody class="text-start">
                                         @forelse($obat as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->nama_obat }}</td>
                                            <td>{{ $item->supplier->nama_supplier ?? '-' }}</td>
                                            <td>{{ $item->kemasan->nama_kemasan ?? '-' }}</td>
                                            <td>{{ $item->satuankecil->nama_satuankecil ?? '-' }}</td>
                                            <td>{{ $item->satuanbesar->nama_satuanbesar ?? '-' }}</td>
                                            <td>{{ $item->aturanpakai->frekuensi_pemakaian ?? '-' }}</td>
                                            <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                                            <td>{{ $item->metodepembayaran->nama_metode ?? '-' }}</td>
                                            <td>{{ $item->created_at->format('d F Y') }}</td>
                                            <td><!-- Button trigger modal -->
                                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalFoto{{ $item->id }}">
                                                    Lihat Foto
                                                </button></td>
                                         @role('admin')
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <!-- Edit -->
                                                    <a href="{{ route('obat.edit', $item->id) }}" class="btn-sm btn btn-primary btn-icon-split mx-2">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-edit"></i>
                                                        </span>
                                                        <span class="text">Edit</span>
                                                    </a>
                                                    <!-- Hapus -->
                                                    <form action="{{ route('obat.destroy', $item->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-sm btn btn-danger btn-icon-split show_confirm" data-name="{{ $item->nama_obat }}">
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

                <!-- Validasi nama serupa -->
                @if($errors->has('nama_obat'))
                <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Input Nama',
                    text: '{{ $errors->first('nama_obat') }}'
                });
                </script>
                @endif

                @endpush

                @foreach ($obat as $item)
                <!-- Modal Foto -->
                 <div class="modal fade" id="modalFoto{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Foto Obat</h1>
                                <button type="button" class="btn btn-outline-dark btn-sm" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
                            </div>
                            <div class="modal-body">
                                <img src="{{ asset('storage/foto_obat/'.$item->foto) }}" alt="{{ $item->foto}}" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @endsection
