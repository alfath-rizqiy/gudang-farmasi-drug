@extends('layouts.admin')

@section('title', 'Data Aturan Pakai')

@section('content')
<h1 class="h3 mb-2 text-gray-800">Data Aturan Pakai</h1>
<div class="p-6">

    @role('admin')
    <div class="mb-4">
        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modalAturanPakai">
            + Tambah Aturan Pakai
        </a>
    </div>
    @endrole

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive" style="overflow-x:auto; white-space:nowrap;">
                <table class="table table-bordered" id="aturanPakaiTable" width="100%" cellspacing="0">
                    <thead>
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <tr>
                            <th>No</th>
                            <th>Frekuensi Pemakaian</th>
                            <th>Waktu Pemakaian</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal Tambah --}}
<div class="modal fade" id="modalAturanPakai" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Aturan Pakai</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="card shadow mb-0">
        <div class="card-body">
        <form id="form-aturanpakai">
        @csrf
        <div class="form-group">
        <label>Frekuensi Pemakaian</label>
        <input type="text" name="frekuensi_pemakaian" class="form-control" required>
        </div>
        <div class="form-group">
        <label>Waktu Pemakaian</label>
        <input type="text" name="waktu_pemakaian" class="form-control" required>
        </div>
        <div class="form-group">
        <label>Deskripsi</label>
        <textarea name="deskripsi" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('aturanpakai.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Modal Edit --}}
<div class="modal fade" id="modalEditAturanPakai" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Aturan Pakai</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="card shadow mb-0">
        <div class="card-body">
          <form id="form-edit-aturanpakai" method="POST">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" id="edit_id">
            <div class="form-group mb-3">
              <label>Frekuensi Pemakaian</label>
              <input type="text" id="edit_frekuensi_pemakaian" name="frekuensi_pemakaian" class="form-control" required>
            </div>
            <div class="form-group mb-3">
              <label>Waktu Pemakaian</label>
              <input type="text" id="edit_waktu_pemakaian" name="waktu_pemakaian" class="form-control" required>
            </div>
            <div class="form-group mb-3">
              <label>Deskripsi</label>
              <textarea id="edit_deskripsi" name="deskripsi" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('aturanpakai.index') }}" class="btn btn-secondary">Kembali</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Loader overlay --}}
<div id="loader" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(255,255,255,0.7); z-index:9999; text-align:center;">
    <div style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%);">
        <i class="fas fa-spinner fa-spin fa-3x text-primary"></i>
        <p>Memproses data...</p>
    </div>
</div>
@endsection

@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    const aturanpakaiApiUrl = "{{ url('/api/aturanpakai') }}"; // sumber data DataTables
  </script>

  <script src="{{ asset('js/aturanpakai.js') }}"></script>
@endpush
