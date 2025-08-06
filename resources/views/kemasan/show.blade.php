@extends('layouts.admin')

@section('title', 'Detail Kemasan')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Detail Kemasan</h1>

    <div class="card shadow mb-4">
        <div class="card-body">

            <h5 class="font-weight-bold mb-3">Informasi Kemasan</h5>
            <p><strong>Nama Kemasan:</strong> {{ $kemasan->nama_kemasan }}</p>
            <p><strong>Tanggal Produksi:</strong> {{ $kemasan->tanggal_produksi }}</p>
            <p><strong>Tanggal Kadaluarsa:</strong> {{ $kemasan->tanggal_kadaluarsa }}</p>
            <p><strong>Petunjuk Penyimpanan:</strong> {{ $kemasan->petunjuk_penyimpanan }}</p>

            <hr>

            <h5 class="font-weight-bold mt-4 mb-3">Kemasan Obat:</h5>

            @if($kemasan->obats->isEmpty())
                <p>Tidak ada obat di kemasan ini.</p>
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
                            @foreach($kemasan->obats as $index => $obat)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $obat->nama_obat }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <a href="{{ route('kemasan.index') }}" class="btn btn-secondary mt-3">Kembali</a>
        </div>
    </div>

</div>
@endsection
