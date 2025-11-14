@extends('layouts.admin')

@section('title', 'PurchaseOrder')

@section('content')
<!-- heading -->
 <h1 class="h3 mb-3 text-gray-800">Form Purchase Order</h1>
 <div class="p-6">

 <div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Purchase Order</h6>
    </div>

     {{-- Tampilkan pesan sukses/error --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('purchase_orders.store') }}" method="POST" id="poForm">
        @csrf
        
    <div class="card-body row g-3">

        <div class="col-md-4 mb-3">
            <label for="tanggal_po">Tanggal PO</label>
            <input type="date" name="tanggal_po" class="form-control" required>
        </div>

        <div class="col-md-4 mb-3">
            <label>Tanggal Kirim</label>
            <input type="date" name="tanggal_kirim" class="form-control">
        </div>

        <div class="col-md-4 mb-3">
            <label>Tanggal Jatuh Tempo</label>
            <input type="date" name="tanggal_jatuh_tempo" class="form-control">
        </div>

        <div class="col-md-6 mb-3">
            <label>Metode Pembayaran</label>
            <select name="metode_pembayaran" class="form-control" required>
                <option value="">Pilih Metode</option>
                <option value="Cash">Cash</option>
                <option value="Transfer">Transfer</option>
                <option value="Tempo">Tempo</option>
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label for="supplier_id">Supplier</label>
            <select name="supplier_id" id="supplier_id" class="form-control" require>
                <option value="">Pilih Supplier</option>
                 @foreach($supplier as $supplier)
                <option value="{{ $supplier->id }}">{{ $supplier->nama_supplier }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-12">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="2"></textarea>
        </div>
    </div>
 </div>

 <!-- Detail -->
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Data Obat</h6>
        <button type="button" class="btn btn-light btn-sm" id="addRow">
            <span class="icon text-white-10">
                    <i class="fa fa-plus"></i>
            </span>
            Tambah Kolom
            <!-- <h6 class="m-0 font-weight-bold text-primary">Tambah Kolom</h6> -->
        </button>
    </div>

    <div class="card-body row g-3">
        <div class="table-responsive">
        <table class="table table-bordered table-sm mb-3" id="obatTable">
            <thead>
                <tr>
                    <th>Obat</th>
                    <th>Jenis</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                     <td><select name="details[0][obat_id]" class="form-control">
                        @foreach($obats as $obat)
                        <option value="{{ $obat->id }}">{{ $obat->nama_obat }}</option>
                        @endforeach
                    </select></td>
                    <td><input type="text" name="details[0][jenis_obat]" class="form-control" placeholder="Jenis Obat"></td>
                    <td><input type="number" name="details[0][harga]" class="form-control harga" min="0" step="0.01"></td>
                    <td><input type="number" name="details[0][jumlah]" class="form-control jumlah" min="1"></td>
                    <td><input type="text" name="details[0][satuan]" class="form-control" placeholder="Tablet / Botol"></td>
                    <td><input type="number" name="details[0][subtotal]" class="form-control subtotal" readonly></td>
                    <td><button type="button" class="btn btn-danger btn-sm btn-delete removeRow">
                        <i class="fas fa-trash"></i>
                    </button></td>
                </tr>
            </tbody>
        </table>

        <!-- Total -->
        <div class="justify-content-start align-items-center mb-3">
            <label class="me-2 fw-bold">Total Harga: </label>
            <input type="number" name="total_harga" id="totalHarga" class="form-control w-auto" readonly>
        </div>
      </div>
   </div>
</div>
       <div class="d-flex">
        <button type="submit" class="btn btn-sm btn-primary mr-3">Simpan</button>
        <a href="{{ route('purchase_orders.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
    </div>
    </form>


{{-- ================= SCRIPT JS ================= --}}
<script>
let rowCount = 1;

// Tambah baris baru
document.getElementById('addRow').addEventListener('click', function() {
    const tableBody = document.querySelector('#obatTable tbody');
    const newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td>
        <select name="details[0][obat_id]" class="form-control">
        @foreach($obats as $obat)
        <option value="{{ $obat->id }}">{{ $obat->nama_obat }}</option>
        @endforeach
        </select>
        </td>
        <td><input type="text" name="details[${rowCount}][jenis_obat]" class="form-control" placeholder="Jenis Obat"></td>
        <td><input type="number" name="details[${rowCount}][harga]" class="form-control harga" min="0" step="0.01"></td>
        <td><input type="number" name="details[${rowCount}][jumlah]" class="form-control jumlah" min="1"></td>
        <td><input type="text" name="details[${rowCount}][satuan]" class="form-control" placeholder="Tablet / Botol"></td>
        <td><input type="number" name="details[${rowCount}][subtotal]" class="form-control subtotal" readonly></td>
        <td><button type="button" class="btn btn-danger btn-sm btn-delete removeRow"><i class="fas fa-trash"></i></button></td>
    `;
    tableBody.appendChild(newRow);
    rowCount++;
});

// Hapus baris
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('removeRow')) {
        e.target.closest('tr').remove();
        hitungTotal();
    }
});

// Hitung subtotal otomatis
document.addEventListener('input', function(e) {
    if (e.target.classList.contains('harga') || e.target.classList.contains('jumlah')) {
        const row = e.target.closest('tr');
        const harga = parseFloat(row.querySelector('.harga').value) || 0;
        const jumlah = parseFloat(row.querySelector('.jumlah').value) || 0;
        const subtotal = harga * jumlah;
        row.querySelector('.subtotal').value = subtotal;
        hitungTotal();
    }
});

// Hitung total keseluruhan
function hitungTotal() {
    let total = 0;
    document.querySelectorAll('.subtotal').forEach(el => {
        total += parseFloat(el.value) || 0;
    });
    document.getElementById('totalHarga').value = total;
}
</script>
@endsection
