@extends('layouts.admin')

@section('title', 'Metode Pembayaran')

@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Data Metode Pembayaran</h1>
    <div class="p-6">

        {{-- Tombol tambah hanya muncul untuk role admin --}}
        @role('admin')
            <div class="mb-4">
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modalMetodePembayaran">
                    + Tambah Metode Pembayaran
                </a>
            </div>
        @endrole

        <!-- Card untuk menampilkan tabel DataTables -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive" style="overflow-x: auto; white-space: nowrap;">
                    <table class="table table-bordered" id="metodePembayaranTable" width="100%" cellspacing="0">
                        <thead>
                             {{-- Token CSRF untuk kebutuhan AJAX --}}
                             <meta name="csrf-token" content="{{ csrf_token() }}">
                            <tr>
                                <th>No</th>
                                <th>Nama Metode Pembayaran</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th> {{-- Tombol aksi: detail, edit, hapus --}}
                            </tr>
                        </thead>
                        {{-- Body tabel diisi otomatis oleh DataTables --}}
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
                        {{-- Form tambah metode pembayaran --}}
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
                        {{-- Form edit metode pembayaran --}}
                        <form id="form-edit-metodepembayaran" method="POST">
                            @csrf
                            <input type="hidden" name="_method" value="PUT"> {{-- Spoofing method PUT --}}
                            <input type="hidden" id="edit_id"> {{-- ID yang akan diedit --}}
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

    <!-- Modal Detail Metode Pembayaran -->
    <div class="modal fade" id="modalDetailMetodePembayaran" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title"><i class="fas fa-info-circle"></i> Detail Metode Pembayaran</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <!-- Info utama metode pembayaran -->
            <div class="card mb-3">
              <div class="card-body">
                <p><strong>Nama:</strong> <span id="detail_nama_metode" class="text-dark"></span></p>
                <p><strong>Deskripsi:</strong> <span id="detail_deskripsi" class="text-muted"></span></p>
              </div>
            </div>

            <!-- Daftar obat yang memakai metode pembayaran -->
            <h6 class="mb-3"><i class="fas fa-pills"></i> Daftar Obat yang Terdaftar</h6>
            <div class="table-responsive">
              <table class="table table-bordered table-striped">
                <thead class="thead-light">
                  <tr>
                    <th style="width: 10%">No</th>
                    <th>Nama Obat</th>
                  </tr>
                </thead>
                <tbody id="detail_obats">
                  <tr>
                    <td colspan="2" class="text-center text-muted">Belum ada obat</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="modal-footer bg-light">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
    </div>

    {{-- Loader overlay saat proses tambah/edit/hapus berjalan --}}
    <div id="loader" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(255,255,255,0.7); z-index:9999; text-align:center;">
        <div style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%);">
            <i class="fas fa-spinner fa-spin fa-3x text-primary"></i>
            <p>Memproses data...</p>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- SweetAlert2 untuk konfirmasi & notifikasi --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Variabel global endpoint API untuk DataTables
        const metodepembayaranApiUrl = "{{ url('/api/metodepembayaran') }}"; 
    </script>

    {{-- File JS khusus metode pembayaran (CRUD + DataTables) --}}
    <script src="{{ asset('js/metodepembayaran.js') }}"></script>
@endpush
