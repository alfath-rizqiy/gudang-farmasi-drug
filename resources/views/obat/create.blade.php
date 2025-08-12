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
                    <input type="text" name="nama_obat" id="nama_obat" class="form-control" placeholder="Masukkan Obat" required>
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
                      
                 <!-- Pemanggilan ID satuan kecil-->
                <div class="mb-4">
                <label for="satuan_kecil_id" class="block mb-1 font-semibold">Satuan Kecil</label>
                 <select name="satuan_kecil_id" id="satuan_kecil_id" class="form-control" required>
                    required>
                    <option value="">Pilih Satuan Kecil</option>
                      @foreach($satuan_kecils as $satuankecil)
                      <option value="{{ $satuankecil->id }}">{{ $satuankecil->nama_satuankecil }}</option>
                      @endforeach
                 </select>
                </div>
                    
                <!-- Pemanggilan ID kategori-->
                <div class="mb-4">
                <label for="kategori_id" class="block mb-1 font-semibold">kategori</label>
                 <select name="kategori_id" id="kategori_id" class="form-control" required>
                    required>
                    <option value="">Pilih kategori</option>
                      @foreach($kategoris as $kategori)
                      <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                      @endforeach
                 </select>
                </div>

                <!-- Pemanggilan ID satuan besar-->
                <div class="mb-4">
                <label for="satuan_besar_id" class="block mb-1 font-semibold">Satuan Besar</label>
                 <select name="satuan_besar_id" id="satuan_besar_id" class="form-control" required>
                    required>
                    <option value="">Pilih Satuan Besar</option>
                      @foreach($satuan_besars as $satuanbesar)
                      <option value="{{ $satuanbesar->id }}">{{ $satuanbesar->nama_satuanbesar }}</option>
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
                
                 <!-- Pemanggilan ID Metode Pembayaran-->
                <div class="mb-4">
                <label for="metodepembayaran_id" class="block mb-1 font-semibold">Metode Pembayaran</label>
                 <select name="metodepembayaran_id" id="metodepembayaran_id" class="form-control" required>
                    required>
                    <option value="">Pilih Metode Pembayaran</option>
                      @foreach($metode_pembayarans as $metodepembayaran)
                      <option value="{{ $metodepembayaran->id }}">{{ $metodepembayaran->nama_metode }}</option>
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
