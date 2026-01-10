@extends('layouts.appOrderPembelian')
@section('content')
@section('title', 'Create BTTB')
<link href="{{ asset('css/CreateBTTB.css') }}" rel="stylesheet">
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
<style>
    #table_terima tbody tr,
    #koreksiKurs_tableBarang tbody tr {
        cursor: pointer;
    }

    #table_terima tbody tr:hover,
    #koreksiKurs_tableBarang tbody tr:hover {
        background-color: #eef5ff;
        cursor: pointer;
    }

    #table_terima tbody tr.selected,
    #koreksiKurs_tableBarang tbody tr.selected {
        background-color: #cfe2ff !important;
    }
</style>
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
            <div class="card" id="dropdownParent1">
                <div class="card-header font-weight-bold">Maintenance BTTB</div>
                <div class="card-body font-weight-bold">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <label for="select_divisi" class="form-label font-weight-bold">Divisi</label>
                            <select class="form-control font-weight-bold" id="select_divisi"
                                name="select_divisi"></select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label for="select_noSPPB" class="form-label font-weight-bold">No. SPPB</label>
                            <select class="form-control font-weight-bold" id="select_noSPPB"
                                name="select_noSPPB"></select>
                        </div>
                        <div class="col-md-6 justify-content-end" style="display: inline-flex">
                            <button type="button" class="btn btn-light" id="btn_koreksiKurs">Koreksi Kurs</button>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="table-responsive">
                            <table class="mx-auto table table-bordered" id="table_barang" style="white-space: nowrap">
                                <thead class="table-primary">
                                    <tr>
                                        <th>Keterangan</th>
                                        <th>Kd. Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Kategori</th>
                                        <th>Jenis</th>
                                        <th>Qty. Pesan</th>
                                        <th>Satuan</th>
                                        <th>Tgl. Pesan</th>
                                        <th>No. Transaksi</th>
                                        <th>Selesai</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="table-responsive">
                            <table class="mx-auto table table-bordered" id="table_terima" style="white-space: nowrap">
                                <thead class="table-primary">
                                    <tr>
                                        <th>No.</th>
                                        <th>Tgl. Datang</th>
                                        <th>Qty. Pesan</th>
                                        <th>Sat. Pesan</th>
                                        <th>Qty. Terima</th>
                                        <th>Sat. Terima</th>
                                        <th>Hrg. Terima</th>
                                        <th>Disc (%)</th>
                                        <th>PPN (%)</th>
                                        <th>Hrg. Satuan</th>
                                        <th>Nilai Trans.</th>
                                        <th>Supplier</th>
                                        <th>Jk. Waktu</th>
                                        <th>No. Faktur</th>
                                        <th>Keterangan</th>
                                        <th>No. Terima</th>
                                        <th>No. Supp.</th>
                                        <th>Retur</th>
                                        <th>Mata Uang</th>
                                        <th>Kurs Rp.</th>
                                        <th>Tgl. Faktur</th>
                                        <th>Srt. Jalan</th>
                                        <th>No. Sat. Terima</th>
                                        <th>Kode Barang</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="font-weight-bold" for="total_terima">Total Diterima</label>
                                    <input type="text" name="total_terima" id="total_terima"
                                        class="form-control font-weight-bold" readonly>
                                </div>
                                <div class="col-md-10 justify-content-end" style="display: grid !important">
                                    <button type="button" class="btn btn-info" id="btn_isi">Isi</button>
                                    <button type="button" class="btn btn-warning" id="btn_koreksi">Koreksi</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('Beli.TransaksiBeli.BTTB.ModalMaintenanceBTTB')
@include('Beli.TransaksiBeli.BTTB.ModalKoreksiKursBTTB')
<script src="{{ asset('js/OrderPembelian/CreateBTTB/CreateBTTB.js') }}"></script>
@endsection
