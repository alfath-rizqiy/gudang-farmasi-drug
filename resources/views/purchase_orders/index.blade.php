@extends('layouts.admin')

@section('title', 'Purchase Order')

@section('content')
<div class="card">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">Purchase Order</h5>
    </div>
    <div class="card-body">

        <!-- Filter -->
        <div class="row mb-3">
            <div class="col-md-3">
                <label>Supplier</label>
                <select id="filterSupplier" class="form-control">
                    <option value="">[ Semua Supplier ]</option>
                    @foreach($suppliers as $s)
                        <option value="{{ $s->id }}">{{ $s->nama_supplier }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label>Periode</label>
                <div class="d-flex">
                    <input type="date" id="tanggalMulai" class="form-control">
                    <span class="mx-2 mt-2">s/d</span>
                    <input type="date" id="tanggalSelesai" class="form-control">
                </div>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button id="btnCari" class="btn btn-primary w-100"><i class="fa fa-search"></i> Cari</button>
            </div>
        </div>

        <!-- Tabel Data -->
        <div class="table-responsive">
            <table id="tablePO" class="table table-bordered table-striped">
                <thead class="bg-dark text-white text-center">
                    <tr>
                        <th>No</th>
                        <th>Nomor PO</th>
                        <th>Tgl PO</th>
                        <th>Tgl Kirim</th>
                        <th>TOP</th>
                        <th>Tgl Jatuh Tempo</th>
                        <th>Supplier</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Valid User</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/purchase-order.js') }}"></script>
@endpush
