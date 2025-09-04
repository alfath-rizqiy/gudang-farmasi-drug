@extends('layouts.admin')

@section('title', 'Metode Pembayaran')

@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Data Metode Pembayaran</h1>
    <div class="p-6">

        {{-- Tombol Tambah --}}
        @role('admin')
            <div class="mb-4">
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modalMetodePembayaran">
                    + Tambah Metode Pembayaran
                </a>
            </div>
        @endrole

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive" style="overflow-x: auto; white-space: nowrap;">
                    <table class="table table-bordered" id="metodePembayaranTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Metode Pembayaran</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Metode Pembayaran -->
    <div class="modal fade" id="modalMetodePembayaran" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Metode Pembayaran</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="card shadow mb-0">
                    <div class="card-body">
                        <form id="form-metodepembayaran">
                            @csrf
                            <div class="form-group">
                                <label>Nama Metode Pembayaran</label>
                                <input type="text" name="nama_metode" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label>Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('metodepembayaran.index') }}" class="btn btn-secondary">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div class="modal fade" id="modalEditMetodePembayaran" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Metode Pembayaran</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="card shadow mb-0">
                    <div class="card-body">
                        <form id="form-edit-metodepembayaran" method="POST">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" id="edit_id">
                            <div class="form-group mb-3">
                                <label>Nama Metode Pembayaran</label>
                                <input type="text" id="edit_nama_metode" name="nama_metode" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label>Deskripsi</label>
                                <textarea id="edit_deskripsi" name="deskripsi" class="form-control" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('metodepembayaran.index') }}" class="btn btn-secondary">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Loader overlay ketika proses tambah/hapus --}}
    <div id="loader" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(255,255,255,0.7); z-index:9999; text-align:center;">
        <div style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%);">
            <i class="fas fa-spinner fa-spin fa-3x text-primary"></i>
            <p>Memproses data...</p>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Pastikan DataTables JS & CSS sudah di-include di layout --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const metodepembayaranApiUrl = "{{ url('/api/metodepembayaran') }}"; // sumber data DataTables
    </script>

    <script src="{{ asset('js/metodepembayaran.js') }}"></script>
@endpush
