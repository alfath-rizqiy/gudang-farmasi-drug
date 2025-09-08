@extends('layouts.admin')

@section('title', 'Data Supplier')

@section('content')

{{-- Tabel Data --}}
<!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Data Supplier</h1>
                  <div class="p-6">

                  <!-- Ajax -->
                  <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- Tombol Tambah --}}
                 @role('admin')
                     <div class="mb-4">
                     <a href="#" class="btn-sm btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalSupplier">
                        <span class="icon text-white-10">
                            <i class="fa fa-plus"></i>
                        </span>
                        Tambah Supplier</a>
                     </div>
                 @endrole

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data Table</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" style="overflow-x: auto; white-space: nowrap;">
                                <table class="table table-bordered" id="tabelSupplier" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                        <th>No</th>
                                        <th>Nama Supplier</th>
                                        <th>Telepon</th>
                                        <th>Email</th>
                                        <th>Alamat</th>
                                         @role('admin')
                                        <th>Aksi</th>
                                         @endrole
                                        </tr>
                                    </thead>
                                    <tbody class="text-start">
                                       
                                </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </table>
            </div>

            <!-- Modal Form Tambah Kategori -->
             <div class="modal fade" id="modalSupplier" tabindex="-1" aria-labelledby="modalSupplierLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalSupplierLabel">Tambah Supplier</h5>
                        </div>
                        <div class="modal-body">

                        <!-- Form Card Tambah -->
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <form id="formSupplier">
    @csrf
    <div class="form-group">    
        <label>Nama Supplier</label>
        <input type="text" name="nama_supplier" class="form-control">
        <span class="text-danger error-text nama_supplier_error"></span>
    </div>

    <div class="form-group">
        <label>Telepon</label>
        <input type="text" name="telepon" class="form-control">
        <span class="text-danger error-text telepon_error"></span>
    </div>

    <div class="form-group">
        <label>Email</label>
        <input type="text" name="email" class="form-control">
        <span class="text-danger error-text email_error"></span>
    </div>

    <div class="form-group">
        <label>Alamat</label>
        <textarea name="alamat" class="form-control"></textarea>
        <span class="text-danger error-text alamat_error"></span>
    </div>

    <button type="submit" id="btnSaveSupplier" class="btn btn-sm btn-primary">Simpan</button>
    <a href="{{ route('supplier.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
</form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

            @push('scripts')
            <script>

            $(document).ready(function () {
                var table = $('#tabelSupplier').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('supplier.data') }}",
                    columns: [
                        { data: 'DT_RowIndex', name:'DT_RowIndex', orderable: false, searchable: false },
                        { data: 'nama_supplier', name: 'nama_supplier' },
                        { data: 'telepon', name: 'telepon' },
                        { data: 'email', name: 'email' },
                        { data: 'alamat', name: 'alamat' },
                        { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
                    ]
            });



                // tambah supplier
                $('#formSupplier').on('submit', function(e){
                    e.preventDefault();
                    $.ajax({
                        url: "{{ route('supplier.store') }}",
                        type: "POST",
                        data: $(this).serialize(),
                        success: function(response){
                            if(response.status){
                                $('#modalSupplier').modal('hide');
                                table.ajax.reload(null, false); // reload otomatis
                            }
                        },
                        error: function(xhr){
                            console.log(xhr.responseJSON);
                        }
                    });
                });
            });

               // hapus data
               $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault();
                let url = $(this).attr('href');

                Swal.fire({
                    title: "Yakin?",
                    text: "Data ini akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#30852d',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: "DELETE",
                            data: { _token: $('meta[name="csrf-token"]').attr('content') },
                            success: function(res){
                                $('#tabelSupplier').DataTable().ajax.reload(null, false);
                                
                                Swal.fire( 
                                    'Berhasil!',
                                    res.message ?? 'Data Berhasil dihapus',
                                    'success'
                                )
                            },
                            error: function(xhr){
                                Swal.fire(
                                    'Gagal',
                                    'Terjadi kesalahan saat menghapus data.',
                                    'error'
                                )
                            }
                        });
                    }
                })
            });

              // Edit data
              $(document).on('click', '.btn-edit', function(e) {
                e.preventDefault();
                let url = $(this).attr('href');

                $.get(url, function(res) {
                    // old data
                    $('#edit_id').val(res.id);
                    $('#edit_nama_supplier').val(res.nama_supplier);
                    $('#edit_telepon').val(res.telepon);
                    $('#edit_email').val(res.email);
                    $('#edit_alamat').val(res.alamat);

                    $('#modalEditSupplier').modal('show');
                });
              });

              // submit edit
              $('#formEditSupplier').on('submit', function(e) {
                e.preventDefault();
                let id = $('#edit_id').val();
                let url = "/supplier/" + id;

                $.ajax({
                    url: url,
                    type: "PUT",
                    data: $(this).serialize(),
                    success: function(res){
                        $('#modalEditSupplier').modal('hide');
                        $('#tabelSupplier').DataTable().ajax.reload(null, false);

                        Swal.fire('Berhasil!', 'Data berhasil diupdate.', 'success');
                    },
                    error: function (xhr){
                        Swal.fire('Gagal!', 'Terjadi kesalahan saat update data', 'error');
                    }
                });
                });

                // Detail data
                $(document).on('click', '.btn-detail', function(e) {
                    e.preventDefault();
                    let id = $(this).data('id');

                    $.get("/supplier/" + id, function(res) {
                        $('#detail_nama_supplier').text(res.nama_supplier);
                     

                        // daftar obat
                        let rows = '';
                        if (res.obats && res.obats.length > 0) {
                            res.obats.forEach((obat, index) => {
                                rows += `
                                    <tr>
                                        <td>${index+1}</td>
                                        <td>${obat.nama_obat}</td>
                                    </tr>
                                `;
                            });
                        } else {
                            rows = `<tr><td colspan="4" class="text-center">Belum ada obat</td></tr>`;
                        }
                        
                        $('#detail_obat_list').html(rows);
                        $('#modalDetailSupplier').modal('show');
                    });
                });
                </script>
            @endpush
            @endsection
             
         
            <!-- Modal Form Edit Supplier -->
             <div class="modal fade" id="modalEditSupplier" tabindex="-1" aria-labelledby="modalSupplierLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEditSupplierLabel">Edit Supplier</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <!-- Form Card Edit -->
                         <div class="card shadow mb-4">
                            <div class="card-body">
                                <form id="formEditSupplier">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="id" id="edit_id">

                                    <div class="form-group">
                                        <label for="edit_nama_supplier">Nama Supplier</label>
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

                                    <button type="submit" class="btn-sm btn btn-primary btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-edit"></i>
                                        </span>
                                        <span class="text">Update</span>
                                    </button>
     
                                    <a href="{{ route('supplier.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
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
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <ul class="list-group">
                  <li class="list-group-item"><strong>Nama:</strong> <span id="detail_nama_supplier"></span></li>
                  
              </ul>

              <h6>Daftar Obat yang disuplai</h6>
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

   



         <!-- Sweet Alert -->
          <!-- @push('scripts')
          <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->

          <!-- Sukses -->
            <!-- @if (session('success'))
            <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3085d6'
            });
            </script>
            @endif -->

            <!-- Gagal -->
            <!-- @if (session('error'))
            <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#d33'
            });
            </script>
            @endif -->

            <!-- Konfirmasi Tindakan -->
            <!-- <script>
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
                </script> -->

            <!-- Konfirmasi Tindakan Update -->
            <!-- <script>
            document.addEventListener("DOMContentLoaded", function () {
                const updateButtons = document.querySelectorAll(".show_update");

                updateButtons.forEach(function (button) {
                    button.addEventListener("click", function (event) {
                        event.preventDefault();

                        const form = button.closest("form");
                        const nama = button.getAttribute("data-name");

                        Swal.fire({
                            title: 'Konfirmasi Update',
                            text: `Apakah kamu yakin ingin mengupdate data "${nama}"?`,
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya, update!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    });
                });
                });
                </script> -->

                <!-- Validasi nama serupa -->
                <!-- @if($errors->has('nama_supplier'))
                <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Input Nama',
                    text: '{{ $errors->first('nama_supplier') }}'
                });
                </script>
                @endif -->

                <!-- Validasi email serupa -->
                <!-- @if($errors->has('email'))
                <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Input Nama',
                    text: '{{ $errors->first('email') }}'
                });
                </script>
                @endif -->
                <!-- @endpush -->

                <!-- Bottsrap -->
                <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> -->

