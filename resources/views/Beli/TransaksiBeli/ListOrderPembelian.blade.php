@extends('layouts.appOrderPembelian')
@section('content')
    <link href="{{ asset('css/ListOrderPembelian.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10 RDZMobilePaddingLR0">
                @if (Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                @elseif (Session::has('error'))
                    <div class="alert alert-danger">
                        {{ Session::get('error') }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">List Order Pembelian</div>
                    <div class="card-body RDZOverflow RDZMobilePaddingLR0">
                        <div class="acs-form">
                            <div class="acs-form1" style="width: 20%">
                                <label for="divisi">Divisi</label>
                                <select name="divisi" id="divisi" class="input">
                                    <option disabled selected>-- Pilih Divisi --</option>
                                </select>
                            </div>
                            <div class="acs-form1" style="width: 50%">
                                <label for="approve" style="white-space: nowrap">Tanggal dan Jam Approve</label>
                                <div class="acs-filter">
                                    <input type="date" name="tanggal_awal" id="tanggal_awal" class="input">
                                    <input type="time" name="waktu_awal" id="waktu_awal" class="input">
                                    s/d
                                    <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="input">
                                    <input type="time" name="waktu_akhir" id="waktu_akhir" class="input">
                                </div>
                            </div>
                            <div class="acs-form1" style="width: 20%">
                                <label for="status_beli">Status Beli</label>
                                <div class="acs-filter1">
                                    <input type="radio" name="radio_buttonStatusBeli" id="radio_buttonPengadaanPembelian" checked>Pengadaan Pembelian
                                    <input type="radio" name="radio_buttonStatusBeli" id="radio_buttonBeliSendiri">Beli Sendiri
                                </div>
                            </div>
                        </div>
                        <div id="div_tablePO" class="acs-form3">
                            <table id="table_ListOrderPembelian" class="table table-bordered table-striped"
                                style="width:100%">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Nomor Order</th>
                                        <th>Tgl & Jam App</th>
                                        <th>Status Beli</th>
                                        <th>Kode Barang</th>
                                        <th>Type</th>
                                        <th>Sub Kategori</th>
                                        <th>Qty</th>
                                        <th>Satuan</th>
                                        <th>Divisi</th>
                                        <th>Tgl Dibutuhkan</th>
                                        <th>Ket. Order</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <div>
                            <input type="checkbox" name="checkbox_centangSemua" id="checkbox_centangSemua"> Centang Semua
                            <form action="">
                                <button class="btn btn-success" id="button_print">Print</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ asset('js/OrderPembelian/ListOrderPembelian.js') }}"></script>
    @endsection
