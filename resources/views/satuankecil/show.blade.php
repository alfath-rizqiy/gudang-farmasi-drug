@extends('layouts.admin')

@section('title', 'Detail SatuanKecil')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Detail SatuanKecil</h1>

    <div class="card shadow mb-4">
        <div class="card-body">

            <h5 class="font-weight-bold mb-3">Informasi satuankecil</h5>
            <p><strong>Nama satuankecil:</strong> {{ $satuankecil->nama_satuankecil }}</p>
            <p><strong>Deskripsi:</strong> {{ $satuankecil->deskripsi }}</p>

            <hr>

            <h5 class="font-weight-bold mt-4 mb-3">Obat yang Terdaftar</h5>

            @if($satuankecil->obats->isEmpty())
                <p>Tidak ada obat yang terdaftar.</p>
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

            <a href="{{ route('satuankecil.index') }}" class="btn btn-sm btn-secondary mt-3">Kembali</a>
        </div>
    </div>

</div>
@endsection