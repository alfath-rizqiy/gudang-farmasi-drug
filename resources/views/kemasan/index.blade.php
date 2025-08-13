@extends('layouts.admin')

@section('title', 'Data Kemasan')

@section('content')

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Data Kemasan</h1>
<div class="p-6">

    {{-- Tombol Tambah --}}
    @role('admin')
    <div class="mb-4">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalKemasan">
            + Tambah Kemasan
        </button>
    </div>
    @endrole

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Kemasan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive" style="overflow-x: auto; white-space: nowrap;">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
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
                        @forelse($kemasan as $item)
                        <tr>
                            <td>{{ $item->nama_kemasan }}</td>
                            <td>{{ $item->tanggal_produksi }}</td>
                            <td>{{ $item->tanggal_kadaluarsa }}</td>
                            <td>{{ $item->petunjuk_penyimpanan }}</td>
                            @role('admin')
                            <td>
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('kemasan.show', $item->id) }}" class="btn-sm btn btn-info btn-icon-split">
                                        <span class="icon text-white-50"><i class="fas fa-info"></i></span>
                                        <span class="text">Detail</span>
                                    </a>
                                    <a href="{{ route('kemasan.edit', $item->id) }}" class="btn-sm btn btn-primary btn-icon-split mx-2">
                                        <span class="icon text-white-50"><i class="fas fa-edit"></i></span>
                                        <span class="text">Edit</span>
                                    </a>
                                    <form action="{{ route('kemasan.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-sm btn btn-danger btn-icon-split show_confirm" data-name="{{ $item->nama_kemasan }}">
                                            <span class="icon text-white-50"><i class="fas fa-trash"></i></span>
                                            <span class="text">Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            @endrole
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">Data kemasan tidak ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Kemasan -->
<div class="modal fade" id="modalKemasan" tabindex="-1" role="dialog" aria-labelledby="modalKemasanLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="modalKemasanLabel">Tambah Kemasan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="{{ route('kemasan.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="nama_kemasan">Nama Kemasan</label>
            <input type="text" class="form-control" id="nama_kemasan" name="nama_kemasan" required>
          </div>
          <div class="form-group">
            <label for="tanggal_produksi">Tanggal Produksi</label>
            <input type="date" class="form-control" id="tanggal_produksi" name="tanggal_produksi" required>
          </div>
          <div class="form-group">
            <label for="tanggal_kadaluarsa">Tanggal Kadaluarsa</label>
            <input type="date" class="form-control" id="tanggal_kadaluarsa" name="tanggal_kadaluarsa" required>
          </div>
          <div class="form-group">
            <label for="petunjuk_penyimpanan">Petunjuk Penyimpanan</label>
            <textarea class="form-control" id="petunjuk_penyimpanan" name="petunjuk_penyimpanan" required></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>

    </div>
  </div>
</div>

<!-- Sweet Alert -->
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

@if($errors->has('nama_kemasan'))
<script>
Swal.fire({
    icon: 'error',
    title: 'Gagal Input Nama Kemasan',
    text: '{{ $errors->first('nama_kemasan') }}'
});
</script>
@endif
@endpush

@endsection
