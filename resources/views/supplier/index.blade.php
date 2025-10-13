@extends('layouts.admin')

@section('title', 'Data Supplier')

@section('content')

<!-- Page Heading -->
 <h1 class="h3 mb-2 text-gray-800">Data Supplier</h1>
 <div class="p-6">

 <div class="d-flex justify-content-between align-items-center mb-2">
    <div class="d-flex gap-3 space-x-3">
        <!-- Tambah -->
         @role('admin')
         <div class="m-2 mb-4">
            <a href="#" class="btn-sm btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalSupplier">
                <span class="icon text-white-10">
                    <i class="fa fa-plus"></i>
                </span>
                Tambah Supplier</a>
            </div>
            @endrole

        <!-- Download PDF -->
         @role('admin|petugas')
         <div class="m-2 mb-4">
            <a href="{{ route('supplier.export.pdf') }}" class="btn-sm btn btn-danger">
                <span class="icon text-white-10">
                    <i class="fas fa-download"></i>
                </span>
                Download PDF</a>
            </div>
            @endrole

        <!-- Download Excel -->
         @role('admin|petugas')
         <div class="m-2 mb-4">
            <a href="{{ route('supplier.export.excel') }}" class="btn-sm btn btn-success">
                <span class="icon text-white-10">
                    <i class="fas fa-download"></i>
                </span>
                Download Excel</a>
            </div>
            @endrole
        
        </div>
    </div>

<!-- DataTales Example -->
 <div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Table</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive" style="overflow-x: auto; white-space: nowrap;">
            <table class="table table-bordered" id="tabelSupplier" width="100%" cellspacing="0">
                <thead>
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <tr>
                        <th>No</th>
                        <th>Nama Supplier</th>
                        <th>Telepon</th>
                        <th>Email</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- Modal Form Tambah kemasan -->
 <div class="modal fade" id="modalSupplier" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Supplier</h5>
                <button type="button" class="btn" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
<!-- Form Card Tambah -->
 <div class="card shadow mb-0">
    <div class="card-body">
        <form id="formSupplier">
    @csrf
    <div class="form-group">    
        <label>Nama Supplier</label>
        <input type="text" name="nama_supplier" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Telepon</label>
        <input type="text" name="telepon" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Email</label>
        <input type="text" name="email" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Alamat</label>
        <input type="text" name="alamat" class="form-control" required>
    </div>

    <button type="submit" id="btnSaveSupplier" class="btn btn-sm btn-primary">Simpan</button>
    <a href="{{ route('supplier.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
    </form>
   </div>
  </div>
 </div>
</div>
</div>
         
<!-- Modal Form Edit Supplier -->
 <div class="modal fade" id="modalEditSupplier" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Supplier</h5>
                <button type="button" class="btn" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
<!-- Form Card Edit -->
 <div class="card shadow mb-0">
    <div class="card-body">
        <form id="formEditSupplier">
            @csrf
            <input type="hidden" id="edit_id">

            <div class="form-group mb-3">
                <label>Nama Supplier</label>
                <input type="text" name="nama_supplier" id="edit_nama_supplier" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="edit_telepon">Telepon</label>
                <input type="text" name="telepon" id="edit_telepon" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="edit_email">Email</label>
                <input type="text" name="email" id="edit_email" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="edit_alamat">Alamat</label>
                <input type="text" name="alamat" id="edit_alamat" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-sm btn-primary">Update</button>
            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
        </form>
       </div>
      </div>
     </div>
    </div>
   </div>

<!-- Modal Detail Supplier -->
 <div class="modal fade" id="modalDetailSupplier" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailLabel">Detail Supplier</h5>
                <button type="button" class="btn" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-card shadow mb-0">
                <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item"><strong>Supplier:</strong> <span id="detail_nama_supplier"></span></li>
                </ul>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Obat</th>
                        </tr>
                    </thead>
                    <tbody id="detail_obat_list">

                    </tbody>
                </table>
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

@push ('scripts')
{{-- Pastikan DataTables JS& CSS sudah di-include di layout --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const supplierApiUrl = "{{ url('/api/supplier') }}";
</script>

<script src="{{ asset('js/supplier.js') }}"></script>
@endpush

   