@extends('layouts.appSales')
@section('content')
@section('title', 'Cetak SP Lokal')
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
<link href="{{ asset('css/cetakSP.css') }}" rel="stylesheet">
<link href="{{ asset('css/cetak-sppdf.css') }}" rel="stylesheet" />
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 RDZMobilePaddingLR0">
            <div class="acs-div-filter">
                <label for="tanggal_sp">Tanggal:</label>
                <div class="acs-div-filter3">
                    <input type="date" name="tanggal_sp" id="tanggal_sp" class="input">
                    <button id="lihat_sp" class="btn" style="display: inline-block">Lihat Surat Pesanan</button>
                </div>
            </div>
            <div class="acs-div-filter1">
                <label for="no_sp">Nomor SP:</label>
                <div>
                    <select name="no_spSelect" id="no_spSelect" class="input">
                        <option disabled selected value>-- Pilih Nomor SP --</option>
                        @foreach ($nosp as $data)
                            @if ($data->IDSuratPesanan !== 'NO DATA')
                                <option value="{{ $data->IDSuratPesanan }}">{{ $data->IDSuratPesanan }} |
                                    {{ $data->NamaCust }}</option>
                            @endif
                        @endforeach
                    </select>
                    <input type="text" name="no_spText" id="no_spText" class="input">
                </div>
            </div>
            <div class="acs-div-filter2">
                <label for="jenis_sp">Jenis SP:</label>
                <input type="text" name="jenis_sp" id="jenis_sp" class="input">
            </div>
            <button id="print_button" class="btn btn-info" style="font-color: white"><span>&#128462;</span> View
                Print</button>
            <button id="print_pdf" class="btn btn-success"><span>&#128438;</span> Print Surat Pesanan</button>
            <hr>
            <label for="contoh_print" id="contoh_print">Contoh Print:</label>
            <div class="acs-div-container" id="contoh_printDiv" style="display: none">
                <div style="width: 20.5cm; height: 16.5cm;position: relative;">
                    <div style="width: 3cm;height: 1cm;position: absolute;top: 1.6cm;left:12cm" id="tgl_pesanKolom">
                        DD-MM-YY</div>
                    <div style="width: 5cm;height: 1cm;position: absolute;top: 2.2cm;left:14cm" id="nama_customerKolom">
                        Nama Customer</div>
                    <div style="width: 5cm;height: 1cm;position: absolute;top: 3.3cm;left:12cm" id="kota_customerKolom">
                        Kota Customer</div>
                    <div style="width: 5cm;height: 1cm;position: absolute;top: 3.4cm;left:3cm" id="no_poKolom">Nomor PO
                    </div>
                    <div style="width: 5cm;height: 1cm;position: absolute;top: 5.4cm;left:3cm" id="kode_barangKolom">
                        Kode Barang</div>
                    <div style="width: 5cm;height: 1cm;position: absolute;top: 5.4cm;left:9cm"
                        id="quantity_barangKolom">Jumlah Order</div>
                    <div style="width: 10cm;height: 4cm;position: absolute;top: 6.5cm;left:1.5cm" id="nama_barangKolom">
                        Nama Barang</div>
                    <div style="width: 6.5cm;height: 5cm;position: absolute;top: 5.5cm;left:12cm"
                        id="syarat_bayarKolom">Syarat Bayar</div>
                    <div style="width: 6.5cm;height: 5cm;position: absolute;top: 15.3cm;left:1.5cm"
                        id="nama_salesKolom">Nama Sales</div>
                    <div style="width: 6.5cm;height: 5cm;position: absolute;top: 15.3cm;left: 9cm"
                        id="nama_managerKolom">Nama Manager </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ asset('js/Sales/CetakSP.js') }}"></script>
@endsection
