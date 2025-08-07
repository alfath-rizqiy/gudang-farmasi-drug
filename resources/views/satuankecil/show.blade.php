@extends('layouts.admin')

@section('title', 'Detail Satuan Kecil')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Detail Satuan Kecil</h1>

    <div class="card shadow mb-4">
        <div class="card-body">

            <h5 class="font-weight-bold mb-3">Informasi Satuan Kecil</h5>
            <p><strong>Nama:</strong> {{ $satuankecil->nama_satuankecil }}</p>
            <p><strong>Deskripsi:</strong> {{ $satuankecil->deskripsi }}</p>

            <hr>

            <h5 class="font-weight-bold mt-4 mb-3">Satuan Kecil Obat</h5>

            @if($satuankecil->obats->isEmpty())
                <p>Tidak ada satuan kecil obat.</p>
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
                            @foreach($satuankecil->obats as $index => $obat)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $obat->nama_obat }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <a href="{{ route('satuankecil.index') }}" class="btn btn-secondary mt-3">Kembali</a>
        </div>
    </div>

</div>
@endsection