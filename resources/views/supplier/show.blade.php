@extends('layouts.admin')

@section('title', 'Detail Supplier')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Detail Supplier</h1>

    <div class="card shadow mb-4">
        <div class="card-body">

            <h5 class="font-weight-bold mb-3">Informasi Supplier</h5>
            <p><strong>Nama Supplier:</strong> {{ $supplier->nama_supplier }}</p>
            <p><strong>Telepon:</strong> {{ $supplier->telepon }}</p>
            <p><strong>Email:</strong> {{ $supplier->email }}</p>

            <hr>

            <h5 class="font-weight-bold mt-4 mb-3">Obat yang Disuplai</h5>

            @if($supplier->obats->isEmpty())
                <p>Tidak ada obat yang disuplai.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Obat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($supplier->obats as $index => $obat)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $obat->nama_obat }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <a href="{{ route('supplier.index') }}" class="btn btn-secondary mt-3">Kembali</a>
        </div>
    </div>

</div>
@endsection
