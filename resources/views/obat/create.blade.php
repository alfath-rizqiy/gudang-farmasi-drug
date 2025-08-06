@extends('layouts.admin')

@section('title', 'Tambah Data Obat')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Tambah Data Obat</h1>

    <!-- Form Card -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('obat.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="nama">Nama Obat</label>
                    <input type="text" name="nama_obat" id="nama_obat" class="form-control" placeholder="Masukkan Supplier" required>
                </div>

                <!-- Pemanggilan ID supplier-->
                <div class="mb-4">
                <label for="supplier_id" class="block mb-1 font-semibold">Supplier</label>
                 <select name="supplier_id" id="supplier_id" class="form-control" required>
                    required>
                    <option value="">Pilih Supplier</option>
                      @foreach($suppliers as $supplier)
                      <option value="{{ $supplier->id }}">{{ $supplier->nama_supplier }}</option>
                      @endforeach
                 </select>
                </div>

                 <!-- Pemanggilan ID kemasan-->
                <div class="mb-4">
                <label for="kemasan_id" class="block mb-1 font-semibold">Kemasan</label>
                 <select name="kemasan_id" id="kemasan_id" class="form-control" required>
                    required>
                    <option value="">Pilih Kemasan</option>
                      @foreach($kemasans as $kemasan)
                      <option value="{{ $kemasan->id }}">{{ $kemasan->nama_kemasan }}</option>
                      @endforeach
                 </select>
                </div>

                 <!-- Pemanggilan ID aturan pakai-->
                <div class="mb-4">
                <label for="aturanpakai_id" class="block mb-1 font-semibold">Aturan Pakai</label>
                 <select name="aturanpakai_id" id="aturanpakai_id" class="form-control" required>
                    required>
                    <option value="">Pilih Aturan Pakai</option>
                      @foreach($aturan_pakais as $aturanpakai)
                      <option value="{{ $aturanpakai->id }}">{{ $aturanpakai->frekuensi_pemakaian }}</option>
                      @endforeach
                 </select>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('obat.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
