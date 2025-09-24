@extends('layouts.admin')

@section('title', 'Data Harga Obat')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Data Harga Obat</h1>
    <div class="p-6">

        {{-- Tombol Tambah --}}
        @role('admin')
            <div class="mb-4">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalHarga">Tambah Harga</button>
            </div>
        @endrole

        {{-- Tabel Data --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                 <h6 class="m-0 font-weight-bold text-primary">Data Table</h6>
             </div>
        <div class="card-body">
        <div class="table-responsive">
           <table class="table table-bordered" id="hargaTable" width="100%" cellspacing="0">
                <thead>
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <tr>
                        <th>No</th>
                        <th>Nama Obat</th>
                        <th>Harga Jual</th>
                        @hasanyrole('admin|petugas')
                            <th>Harga Pokok</th>
                            <th>Margin</th>
                            <th>Update Terakhir</th>
                        @endhasanyrole
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
        </div>
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="modalHarga" tabindex="-1" aria-labelledby="modalHargaLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="form-harga">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalHargaLabel">Tambah Harga</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        {{-- Pilih Obat --}}
                        <div class="form-group mb-3">
                            <label for="obat_id">Nama Obat</label>
                            <select name="obat_id" id="obat_id" class="form-control" required>
                                <option value="">-- Pilih Obat --</option>
                                @foreach($obats as $obat)
                                    <option value="{{ $obat->id }}">{{ $obat->nama_obat }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Harga Pokok --}}
                        <div class="form-group mb-3">
                            <label for="harga_pokok">Harga Pokok</label>
                            <input type="number" name="harga_pokok" id="harga_pokok" class="form-control" required>
                        </div>

                        {{-- Margin --}}
                        <div class="form-group mb-3">
                            <label for="margin">Margin</label>
                            <input type="number" name="margin" id="margin" class="form-control" required>
                        </div>

                        {{-- Harga Jual --}}
                        <div class="form-group mb-3">
                            <label for="harga_jual">Harga Jual</label>
                            <input type="number" name="harga_jual" id="harga_jual" class="form-control" readonly>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="editModalHarga" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="form-edit-harga" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Harga</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit_id">

                        <div class="form-group mb-3">
                            <label for="edit_obat_id">Nama Obat</label>
                            <select name="obat_id" id="edit_obat_id" class="form-control" required>
                                @foreach($obats as $obat)
                                    <option value="{{ $obat->id }}">{{ $obat->nama_obat }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="edit_harga_pokok">Harga Pokok</label>
                            <input type="number" name="harga_pokok" id="edit_harga_pokok" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="edit_margin">Margin</label>
                            <input type="number" name="margin" id="edit_margin" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="edit_harga_jual">Harga Jual</label>
                            <input type="number" name="harga_jual" id="edit_harga_jual" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Detail -->
    <div class="modal fade" id="modalDetailHarga" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="detailModalLabel">Detail Harga</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <p><strong>Nama Obat:</strong> <span id="detail_nama_obat"></span></p>
              <hr>
              <h6>Riwayat Harga:</h6>
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Harga Pokok</th>
                      <th>Margin</th>
                      <th>Harga Jual</th>
                      <th>Update Terakhir</th>
                    </tr>
                  </thead>
                  <tbody id="detailRiwayat"></tbody>
                </table>
              </div>
          </div>
          <div class="modal-footer bg-light">
            <button class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Tutup</button>
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

    <script>
        // Auto hitung harga jual
        document.addEventListener("DOMContentLoaded", function() {
            const hargaPokok = document.getElementById("harga_pokok");
            const margin = document.getElementById("margin");
            const hargaJual = document.getElementById("harga_jual");

            function updateHargaJual() {
                const hp = parseFloat(hargaPokok.value) || 0;
                const m = parseFloat(margin.value) || 0;
                hargaJual.value = hp + m;
            }

            hargaPokok.addEventListener("input", updateHargaJual);
            margin.addEventListener("input", updateHargaJual);
        });
    </script>
@endsection

@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    const hargaApiUrl = "{{ url('/api/harga') }}";
    const userRole = @json(auth()->user()->getRoleNames()[0] ?? 'guest');
  </script>
  <script src="{{ asset('js/harga.js') }}"></script>
@endpush