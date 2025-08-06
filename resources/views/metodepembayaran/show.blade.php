@extends('layouts.admin')

@section('title', 'Detail Metode Pembayaran')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Detail Metode Pembayaran</h1>

    <div class="card shadow mb-4">
        <div class="card-body">

            <h5 class="font-weight-bold mb-3">Informasi Metode Pembayaran</h5>
            <p><strong>Nama Metode:</strong> {{ $metodepembayaran->nama_metode }}</p>
            <p><strong>Deskripsi:</strong> {{ $metodepembayaran->deskripsi }}</p>
            

            <hr>

            <h5 class="font-weight-bold mt-4 mb-3">Metode Pembayaran Obat:</h5>

            @if($metodepembayaran->obats->isEmpty())
                <p>Tidak ada obat di Metode Pembayaran ini.</p>
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
                            @foreach($metodepembayaran->obats as $index => $obat)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $obat->nama_obat }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <a href="{{ route('metodepembayaran.index') }}" class="btn btn-secondary mt-3">Kembali</a>
        </div>
    </div>

</div>
@endsection