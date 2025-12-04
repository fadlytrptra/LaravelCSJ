@extends('layouts.appOrderPembelian')

@section('title', 'Maintenance SPPB Pembelian')

@section('content')
<link href="{{ asset('css/CreatePurchaseOrder.css') }}" rel="stylesheet">
<link href="{{ asset('css/style.css') }}" rel="stylesheet">

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-11 RDZMobilePaddingLR0">
            @if (Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            @elseif (Session::has('error'))
                <div class="alert alert-danger">
                    {{ Session::get('error') }}
                </div>
            @endif

            <div class="card font-weight-bold">
                <div class="card-header">Maintenance SPPB Pembelian</div>

                {{-- sesuaikan action dengan route penyimpanan --}}
                <form method="POST" action="{{ url('purchase-order') }}">
                    @csrf

                    <div class="card-body">
                        {{-- BARIS ATAS: Nama Divisi, No SPPB, Tanggal, No Transaksi + Kode/Nama Barang --}}
                        <div class="row mb-3">
                            {{-- KIRI --}}
                            <div class="col-md-6">
                                <div class="mb-2 row">
                                    <label class="col-sm-3 col-form-label">Nama Divisi</label>
                                    <div class="col-sm-7">
                                        <select name="kd_div" id="kd_div" class="form-control">
                                            @foreach ($divisi as $d)
                                                <option value="{{ $d->Kd_div }}">{{ trim($d->NM_DIV) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    {{-- <div class="col-sm-2">
                                        <button type="button" class="btn btn-secondary btn-sm w-100">...</button>
                                    </div> --}}
                                </div>

                                <div class="mb-2 row">
                                    <label class="col-sm-3 col-form-label">No SPPB</label>
                                    <div class="col-sm-7">
                                        <input type="text" name="no_sppb" id="no_sppb" class="form-control">
                                    </div>
                                    {{-- <div class="col-sm-2">
                                        <button type="button" class="btn btn-secondary btn-sm w-100">...</button>
                                    </div> --}}
                                </div>

                                <div class="mb-2 row">
                                    <label class="col-sm-3 col-form-label">Tanggal SPPB</label>
                                    <div class="col-sm-7">
                                        <input type="date" name="tgl_sppb" id="tgl_sppb" class="form-control">
                                    </div>
                                </div>

                                <div class="mb-2 row">
                                    <label class="col-sm-3 col-form-label">No Transaksi</label>
                                    <div class="col-sm-7">
                                        <input type="text" name="no_trans" id="no_trans" class="form-control">
                                    </div>
                                </div>
                            </div>

                            {{-- KANAN: Barang + Qty / Mata Uang / Harga --}}
                            <div class="col-md-6">
                                <div class="mb-2 row">
                                    <label class="col-sm-3 col-form-label">Kd. Barang</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="kd_brg" id="kd_brg" class="form-control">
                                    </div>
                                </div>

                                <div class="mb-2 row">
                                    <label class="col-sm-3 col-form-label">Nama Barang</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="nama_brg" id="nama_brg" class="form-control">
                                    </div>
                                </div>

                                <div class="mb-2 row">
                                    <label class="col-sm-3 col-form-label">Ket. Barang</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="ket_brg" id="ket_brg" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- BARIS KEDUA: Kategori + Qty/Harga --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="mb-2 row">
                                    <label class="col-sm-3 col-form-label">Kategori Utama</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="kat_utama" id="kat_utama" class="form-control">
                                    </div>
                                </div>

                                <div class="mb-2 row">
                                    <label class="col-sm-3 col-form-label">Kategori</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="kategori" id="kategori" class="form-control">
                                    </div>
                                </div>

                                <div class="mb-2 row">
                                    <label class="col-sm-3 col-form-label">Sub Kategori</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="sub_kategori" id="sub_kategori" class="form-control">
                                    </div>
                                </div>

                                <div class="mb-2 row">
                                    <label class="col-sm-3 col-form-label">Ket. Pembelian</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="ket_pembelian" id="ket_pembelian" class="form-control">
                                    </div>
                                </div>

                                <div class="mb-2 row">
                                    <label class="col-sm-3 col-form-label">Satuan</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="satuan" id="satuan" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                {{-- QTY --}}
                                <div class="mb-2 row">
                                    <label class="col-sm-3 col-form-label">Qty</label>
                                    <div class="col-sm-4">
                                        <input type="number" step="0.01" name="qty" id="qty" class="form-control text-end">
                                    </div>
                                </div>
                            
                                {{-- MATA UANG + KURS (tanpa tombol lookup) --}}
                                <div class="mb-2 row align-items-center">
                                    <label class="col-sm-3 col-form-label">Mata Uang</label>
                            
                                    {{-- dropdown mata uang --}}
                                    <div class="col-sm-5">
                                        <select name="mata_uang" id="mata_uang" class="form-control">
                                            <option value="">Pilih Mata Uang</option>
                                            <option value="IDR">IDR - Rupiah</option>
                                            <option value="USD">USD - Dollar</option>
                                            <option value="EUR">EUR - Euro</option>
                                            <option value="JPY">JPY - Yen</option>
                                            {{-- kalau nanti di-load dari DB, ganti blok di atas dengan @foreach --}}
                                        </select>
                                    </div>
                            
                                    {{-- label kurs --}}
                                    <label class="col-sm-2 col-form-label text-end text-nowrap">Kurs</label>
                            
                                    {{-- input kurs --}}
                                    <div class="col-sm-2">
                                        <input type="number" step="1.0000" name="kurs" id="kurs" class="form-control text-end" value="0">
                                    </div>
                                </div>
                            
                                {{-- HARGA SATUAN --}}
                                <div class="mb-2 row">
                                    <label class="col-sm-3 col-form-label">Harga Satuan</label>
                                    <div class="col-sm-9">
                                        <input type="number" step="0.01" name="harga_satuan" id="harga_satuan" class="form-control text-end">
                                    </div>
                                </div>
                            
                                {{-- DISCOUNT + PPN --}}
                                <div class="mb-2 row">
                                    <label class="col-sm-3 col-form-label">Discount</label>
                                    <div class="col-sm-3">
                                        <input type="number" step="0.01" name="disc" id="disc" class="form-control text-end">
                                    </div>
                                    <label class="col-sm-1 col-form-label text-center">%</label>
                            
                                    <label class="col-sm-2 col-form-label text-end">PPN (%)</label>
                                    <div class="col-sm-3">
                                        <input type="number" step="0.1" name="ppn" id="ppn" class="form-control text-end">
                                    </div>
                                </div>
                            
                                {{-- TOTAL HARGA --}}
                                <div class="mb-2 row">
                                    <label class="col-sm-3 col-form-label">Total Harga</label>
                                    <div class="col-sm-9">
                                        <input type="number" step="0.01" name="total_harga" id="total_harga" class="form-control text-end">
                                    </div>
                                </div>
                            
                                {{-- JANGKA WAKTU --}}
                                <div class="mb-2 row">
                                    <label class="col-sm-3 col-form-label">Jangka Waktu</label>
                                    <div class="col-sm-3">
                                        <input type="number" name="jangka_waktu" id="jangka_waktu" class="form-control text-end">
                                    </div>
                                    <label class="col-sm-2 col-form-label">hari</label>
                                </div>
                            
                                {{-- PEMBAYARAN --}}
                                <div class="mb-2 row">
                                    <label class="col-sm-3 col-form-label">Pembayaran</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="pembayaran" id="pembayaran" class="form-control">
                                    </div>
                                </div>
                            
                                {{-- TOMBOL TAMBAH HARGA --}}
                                <div class="mb-2 row">
                                    <div class="col-sm-12 text-end">
                                        <button type="button" class="btn btn-primary btn-sm">
                                            Tambah Harga
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                        </div>

                        {{-- AREA KETERANGAN BESAR --}}
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label">Keterangan Tambahan</label>
                                <textarea name="keterangan_detail" id="keterangan_detail" rows="5" class="form-control"></textarea>
                            </div>
                        </div>

                        {{-- BARIS BAWAH: Tanggal Datang, Jenis Pembelian, Supplier, Alasan Hapus --}}
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Tgl. Datang (mm/dd/yyyy)</label>
                                <input type="date" name="tgl_datang" id="tgl_datang" class="form-control">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Pembelian</label>
                                <select name="jenis_pembelian" id="jenis_pembelian" class="form-control">
                                    <option value="">- Pilih -</option>
                                    <option value="local">Lokal</option>
                                    <option value="import">Import</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Supplier</label>
                                <select name="supplier" id="supplier" class="form-control">
                                    {{-- isi dari controller kalau perlu --}}
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Alasan Hapus</label>
                                <input type="text" name="alasan_hapus" id="alasan_hapus" class="form-control">
                            </div>
                        </div>
                    </div>

                    {{-- FOOTER BUTTONS --}}
                    <div class="card-footer d-flex justify-content-between">
                        <div>
                            <button type="button" class="btn btn-secondary">
                                Lihat Daftar Harga
                            </button>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                Kirim ke Supplier
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
