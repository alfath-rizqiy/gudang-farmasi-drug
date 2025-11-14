@extends('layouts.admin')

@section('title', 'Purchase Order')

@section('content')

<!-- heading -->
 <h1 class="h3 mb-2 text-gray-800"> Daftar Purchase Order</h1>
 <div class="p-6">

 <div class="d-flex justify-content-between align-items-center mb-2">
    <div class="d-flex gap-3 space-x-3">
        @role('admin|petugas')
        <div class="m-2 mb-4">
            <a href="{{ route('purchase_orders.create') }}" class="btn btn-sm btn-primary">
                <span class="icon text-white-10">
                    <i class="fa fa-plus"></i>
                </span>
                Tambah PO
            </a>
        </div>
        @endrole

    </div>
 </div>

 <div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Table</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive" style="overflow-x: auto; white-space: nowrap;">
            <table class="table table-bordered" id="tableObat" width="100%" cellspacing="0">
                <thead>
                    <tr>
                         <th>No</th>
                         <th>No. PO</th>
                         <th>Supplier</th>
                         <th>Tanggal</th>
                         <th>Metode Pembayaran</th>
                         <th>Total Harga</th>
                         <th>Status</th>
                         <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($purchaseOrders as $index => $po)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $po->no_po }}</td>
                    <td>{{ $po->supplier->nama_supplier ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($po->tanggal_po)->format('d-m-Y') }}</td>
                    <td>{{ $po->metode_pembayaran }}</td>
                    <td>Rp {{ number_format($po->totalHarga, 0, ',', '.') }}</td>
                    <td>
                        @if($po->status == 'Open')
                            <span class="badge bg-warning text-dark">Open</span>
                        @else
                            <span class="badge bg-success">Close</span>
                        @endif
                    </td>
                    <td>
                       <a href="{{ route('purchase_orders.show', $po->id) }}" class="btn btn-info btn-sm btn-show">
                        <i class="fas fa-info-circle"></i> 
                        Info
                       </a>

                        <a href="#" class="btn btn-primary btn-sm btn-edit">
                        <i class="fas fa-edit"></i>
                        Edit
                       </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Belum ada data Purchase Order</td>
                </tr>
            @endforelse
                </tbody>
            </table>
        </div>
    </div>
 </div>
 </div>
 @endsection

