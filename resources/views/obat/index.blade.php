@extends('layouts.admin')

@section('title', 'Data Obat')

@section('content')

        <!-- Tabel Data -->
       <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Data Obat</h1>
                    <div class="p-6">

        <!-- Tombol Tambah -->
                 @role('admin|petugas')
                     <div class="mb-4">
                     <a href="{{ route('obat.create') }}" class="btn btn-sm btn-primary">+ Tambah Obat</a>
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
                                        <th>Obat</th>
                                        <th>Supllier</th>
                                        <th>Kemasan</th>
                                        <th>Satuan Kecil</th>
                                        <th>Satuan Besar</th>
                                        <th>Aturan Pakai</th>
                                        <th>Kategori</th>
                                        <th>Metode Pembayaran</th>
                                         @role('admin')
                                        <th>Aksi</th>
                                         @endrole
                                        </tr>
                                    </thead>
                                    <tbody class="text-start">
                                         @forelse($obats as $obat)
                                        <tr>
                                            <td>{{ $obat->nama_obat }}</td>
                                            <td>{{ $obat->supplier->nama_supplier ?? '-' }}</td>
                                            <td>{{ $obat->kemasan->nama_kemasan ?? '-' }}</td>
                                            <td>{{ $obat->satuankecil->nama_satuankecil ?? '-' }}</td>
                                            <td>{{ $obat->satuanbesar->nama_satuanbesar ?? '-' }}</td>
                                            <td>{{ $obat->aturanpakai->frekuensi_pemakaian ?? '-' }}</td>
                                            <td>{{ $obat->kategori->nama_kategori ?? '-' }}</td>
                                            <td>{{ $obat->metodepembayaran->nama_metode ?? '-' }}</td>
                                         @role('admin')
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <!-- Edit -->
                                                    <a href="{{ route('obat.edit', $obat->id) }}" class="btn-sm btn btn-primary btn-icon-split mx-2">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-edit"></i>
                                                        </span>
                                                        <span class="text">Edit</span>
                                                    </a>
                                                    <!-- Hapus -->
                                                    <form action="{{ route('obat.destroy', $obat->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-sm btn btn-danger btn-icon-split show_confirm" data-name="{{ $obat->nama_obat }}">
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
