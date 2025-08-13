@extends('layouts.admin')

@section('title', 'Data Aturan Pakai')

@section('content')

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Data Aturan Pakai</h1>
<div class="p-6">

    {{-- Tombol Tambah --}}
    @role('admin')
    <div class="mb-4">
        <button type="button" class="btn btn-primary btn-sm px-3 py-2" data-toggle="modal" data-target="#modalAturan">
            + Tambah Aturan Pakai
        </button>
    </div>
    @endrole

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Aturan Pakai</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive" style="overflow-x: auto; white-space: nowrap;">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Frekuensi Pemakaian</th>
                            <th>Waktu Pemakaian</th>
                            <th>Deskripsi</th>
                            @role('admin')
                            <th>Aksi</th>
                            @endrole
                        </tr>
                    </thead>
                    <tbody class="text-start">
                        @forelse($aturanpakai as $item)
                        <tr>
                            <td>{{ $item->frekuensi_pemakaian }}</td>
                            <td>{{ $item->waktu_pemakaian }}</td>
                            <td>{{ $item->deskripsi }}</td>
                            @role('admin')
                            <td>
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('aturanpakai.show', $item->id) }}" class="btn-sm btn btn-info btn-icon-split">
                                        <span class="icon text-white-50"><i class="fas fa-info"></i></span>
                                        <span class="text">Detail</span>
                                    </a>
                                    <a href="{{ route('aturanpakai.edit', $item->id) }}" class="btn-sm btn btn-primary btn-icon-split mx-2">
                                        <span class="icon text-white-50"><i class="fas fa-edit"></i></span>
                                        <span class="text">Edit</span>
                                    </a>
                                    <form action="{{ route('aturanpakai.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-sm btn btn-danger btn-icon-split show_confirm" data-name="{{ $item->frekuensi_pemakaian }}">
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
                            <td colspan="4">Data tidak ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Aturan Pakai -->
<div class="modal fade" id="modalAturan" tabindex="-1" role="dialog" aria-labelledby="modalAturanLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="modalAturanLabel">Tambah Aturan Pakai</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="{{ route('aturanpakai.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="frekuensi_pemakaian">Frekuensi Pemakaian</label>
            <input type="text" class="form-control" id="frekuensi_pemakaian" name="frekuensi_pemakaian" required>
          </div>

          <div class="form-group mt-3">
            <label for="waktu_pemakaian">Waktu Pemakaian</label>
            <input type="text" class="form-control" id="waktu_pemakaian" name="waktu_pemakaian" required>
          </div>

          <div class="form-group mt-3">
            <label for="deskripsi">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
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
