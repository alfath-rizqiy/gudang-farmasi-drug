@extends('layouts.admin')

@section('title', 'Data Obat')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">🔍 Detail Purchase Order</h3>

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            Informasi PO
        </div>
        <div class="card-body row g-3">
            <div class="col-md-4">
                <strong>No PO:</strong> {{ $po->no_po }}
            </div>
            <div class="col-md-4">
                <strong>Tanggal PO:</strong> {{ \Carbon\Carbon::parse($po->tanggal_po)->format('d F Y') }}
            </div>
            <div class="col-md-4">
                <strong>Status:</strong>
                @if($po->status == 'Open')
                    <span class="badge bg-warning text-dark">Open</span>
                @else
                    <span class="badge bg-success">Close</span>
                @endif
            </div>

            <div class="col-md-4">
                <strong>Supplier:</strong> {{ $po->supplier->nama_supplier ?? '-' }}
            </div>
            <div class="col-md-4">
                <strong>Metode Pembayaran:</strong> {{ $po->metode_pembayaran }}
            </div>
            <div class="col-md-4">
                <strong>Total Harga:</strong> Rp {{ number_format($po->total_harga, 0, ',', '.') }}
            </div>

            <div class="col-md-4">
                <strong>Tanggal Kirim:</strong> {{ $po->tanggal_kirim ?? '-' }}
            </div>
            <div class="col-md-4">
                <strong>Jatuh Tempo:</strong> {{ $po->tanggal_jatuh_tempo ?? '-' }}
            </div>

            <div class="col-md-12">
                <strong>Keterangan:</strong> {{ $po->keterangan ?? '-' }}
            </div>
        </div>
    </div>

    {{-- ================= Detail Obat ================= --}}
    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            Daftar Obat dalam PO
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Obat</th>
                        <th>Jenis Obat</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($po->details as $i => $detail)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $detail->obat_id }}</td>
                            <td>{{ $detail->jenis_obat }}</td>
                            <td>Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                            <td>{{ $detail->jumlah }}</td>
                            <td>{{ $detail->satuan }}</td>
                            <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data obat</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

     <a href="{{ route('purchase_orders.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
</div>
@endsection
