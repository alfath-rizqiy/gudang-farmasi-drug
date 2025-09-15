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
                     <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalObat">
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
                                <table class="table table-bordered" id="tableObat" width="100%" cellspacing="0">
                                    <thead>
                                        <meta name="csrf-token" content="{{ csrf_token() }}">
                                        <tr>
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
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>

<!-- Modal Foto -->
<div class="modal fade" id="modalFoto" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Foto Obat</h5>
        <button type="button" class="btn" data-bs-dismiss="modal">
            <i class="fas fa-times"></i>
        </button>
      </div>
      <div class="modal-body text-center">
        <img id="fotoPreview" src="" class="img-fluid rounded shadow" alt="Foto Obat">
        <p class="mt-2" id="namaObatFoto"></p>
      </div>
    </div>
  </div>
</div>


<!-- Modal Tambah Obat -->
<div class="modal fade" id="modalObat" tabindex="-1" aria-labelledby="modalObatLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalObatLabel">Tambah Data Obat</h5>
                <button type="button" class="btn" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="card-body">
                <form id="formObat" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <!-- Nama Obat -->
                        <div class="col-md-6 mb-3">
                            <label for="nama_obat">Nama Obat</label>
                            <input type="text" name="nama_obat" id="nama_obat" class="form-control" required>
                        </div>

                        <!-- Supplier -->
                        <div class="col-md-6 mb-3">
                            <label for="supplier_id">Supplier</label>
                            <select name="supplier_id" id="supplier_id" class="form-control" required>
                                <option value="">Pilih Supplier</option>
                            </select>
                        </div>

                        <!-- Kemasan -->
                        <div class="col-md-6 mb-3">
                            <label for="kemasan_id">Kemasan</label>
                            <select name="kemasan_id" id="kemasan_id" class="form-control" required>
                                <option value="">Pilih Kemasan</option>
                                
                            </select>
                        </div>

                        <!-- Satuan Kecil -->
                        <div class="col-md-6 mb-3">
                            <label for="satuan_kecil_id">Satuan Kecil</label>
                            <select name="satuan_kecil_id" id="satuan_kecil_id" class="form-control" required>
                                <option value="">Pilih Satuan Kecil</option>
                               
                            </select>
                        </div>

                        <!-- Satuan Besar -->
                        <div class="col-md-6 mb-3">
                            <label for="satuan_besar_id">Satuan Besar</label>
                            <select name="satuan_besar_id" id="satuan_besar_id" class="form-control" required>
                                <option value="">Pilih Satuan Besar</option>
                                
                            </select>
                        </div>

                        <!-- Kategori -->
                        <div class="col-md-6 mb-3">
                            <label for="kategori_id">Kategori</label>
                            <select name="kategori_id" id="kategori_id" class="form-control" required>
                                <option value="">Pilih Kategori</option>
                               
                            </select>
                        </div>

                        <!-- Aturan Pakai -->
                        <div class="col-md-6 mb-3">
                            <label for="aturanpakai_id">Aturan Pakai</label>
                            <select name="aturanpakai_id" id="aturanpakai_id" class="form-control" required>
                                <option value="">Pilih Aturan Pakai</option>
                               
                            </select>
                        </div>

                        <!-- Metode Pembayaran -->
                        <div class="col-md-6 mb-3">
                            <label for="metodepembayaran_id">Metode Pembayaran</label>
                            <select name="metodepembayaran_id" id="metodepembayaran_id" class="form-control" required>
                                <option value="">Pilih Metode Pembayaran</option>
                                
                            </select>
                        </div>

                        <!-- Foto Obat -->
                        <div class="col-md-12 mb-3">
                            <label for="foto">Foto Obat</label>
                            <input type="file" name="foto" id="foto" class="form-control">
                        </div>
                    </div>

                    <button type="submit" id="btnSaveObat" class="btn btn-sm btn-primary">Simpan</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Form Edit Supplier -->
 <div class="modal fade" id="modalEditObat" tabindex="-1"  aria-labelledby="modalEditObatLabel" aria-hidden="true">
    <div class="modal-dialog modal-x1 modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditObatLabel">Edit Obat</h5>
                <button type="button" class="btn" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>

<!-- Form Card Edit -->
 <div class="modal-body">
        <form id="formEditObat" method="POST">
            @csrf
            <div class="row">
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" id="edit_id" name="id">

            <div class="col-md-6 mb-3">
                <label>Nama Obat</label>
                <input type="text" name="nama_obat" id="edit_nama_obat" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="supplier_id">Supplier</label>
                <select name="supplier_id" id="edit_supplier_id" class="form-control" required>
                    <option value="">Pilih Supplier</option>
                   
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label for="kemasan_id">Kemasan</label>
                <select name="kemasan_id" id="edit_kemasan_id" class="form-control" required>
                    <option value="">Pilih Kemasan</option>
                   
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label for="satuan_kecil_id">Satuan Kecil</label>
                <select name="satuan_kecil_id" id="edit_satuan_kecil_id" class="form-control" required>
                    <option value="">Pilih Satuan Kecil</option>
                   
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label for="satuan_besar_id">Satuan Besar</label>
                <select name="satuan_besar_id" id="edit_satuan_besar_id" class="form-control" required>
                    <option value="">Pilih Satuan Besar</option>
                    
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label for="kategori_id">Kategori</label>
                <select name="kategori_id" id="edit_kategori_id" class="form-control" required>
                    <option value="">Pilih Kategori</option>
                    
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label for="aturanpakai_id">Aturan Pakai</label>
                <select name="aturanpakai_id" id="edit_aturanpakai_id" class="form-control" required>
                    <option value="">Pilih Aturan Pakai</option>
                    
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label for="metodepembayaran_id">Metode Pembayaran</label>
                <select name="metodepembayaran_id" id="edit_metodepembayaran_id" class="form-control" required>
                    <option value="">Pilih Metode Pembayaran</option>
                    
                </select>
            </div>

            <!-- Foto Obat -->
             <div class="col-md-12 mb-3">
                <label for="foto">Foto Obat</label>
                <input type="file" name="foto" id="foto" class="form-control">
            </div>
            <div class="col-md-12 mb-3">
                <label>Foto Lama</label><br>
                <img id="preview_edit_foto" src="" class="img-thumbnail d-none mb-2" width="100">
            </div>
            
        </div>
        
        <button type="submit" class="btn btn-sm btn-primary">Update</button>
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
      </form>
    </div>
  </div>
</div>

@endsection

@push ('scripts')
{{-- Pastikan DataTables JS& CSS sudah di-include di layout --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>const obatApiUrl = "{{ url('/api/obat') }}";</script>
</script>

<script src="{{ asset('js/obat.js') }}"></script>
@endpush
