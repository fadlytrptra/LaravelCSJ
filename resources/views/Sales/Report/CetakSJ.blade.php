@extends('layouts.appSales')
@section('content')
@section('title', 'Cetak SJ')
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
<link href="{{ asset('css/cetakSJ.css') }}" rel="stylesheet">
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 RDZMobilePaddingLR0">
            <div class="acs-div-form">
                <div style="gap: 10px; display: flex">
                    <div>
                        <input type="radio" name="group_suratJalan" id="surat_jalanPPN" value="ppn"> SJ PPN
                    </div>
                    <div>
                        <input type="radio" name="group_suratJalan" id="surat_jalanNonPPN" value="non-ppn"
                            style="display: none">{{-- SJ Non PPN --}}
                    </div>
                    <div>
                        <input type="radio" name="group_suratJalan" id="surat_jalanAfalan" value="afalan"
                            style="display: none">{{-- SJ Afalan --}}
                    </div>
                    <div>
                        <input type="radio" name="group_suratJalan" id="surat_jalanExport" value="export"
                            style="display: none">{{-- SJ Export --}}
                    </div>
                </div>
                <div class="acs-div-filter">
                    <label for="tanggal_sj">Tanggal:</label>
                    <input type="date" name="tanggal_sj" id="tanggal_sj" class="input">
                </div>
                <div class="acs-div-filter1">
                    <label for="no_sj">Nomor SJ:</label>
                    <div>
                        <input type="text" name="no_sjText" id="no_sjText" style="width: 80%;display: inline;"
                            class="input">
                        <select name="no_sjSelect" id="no_sjSelect" style="width: 80%;display: none" class="input">
                            <option disabled selected>-- Pilih Nomor Surat Jalan --</option>
                        </select>
                        <button class="btn btn-primary" id="no_sjButton" style="width: 15%">...</button>
                    </div>
                </div>
                <div class="acs-div-filter1">
                    <label for="no_sp">Nomor SP:</label>
                    <input type="text" name="no_sp" id="no_sp" class="input" readonly>
                </div>
                {{-- <div class="acs-div-filter2">
                        <label for="jenis_sp">Jenis SP:</label>
                        <input type="text" name="jenis_sp" id="jenis_sp" class="input">
                    </div> --}}
                <button id="print_button" class="btn btn-info"><span>&#128462;</span> View Print</button>
                <button id="export_pdf" class="btn btn-primary"><span>&#11123;</span> Export PDF</button>
                <button id="print_pdf" class="btn btn-success"><span>&#128438;</span> Print Surat Jalan</button>
                <hr>
                <label for="contoh_print" id="contoh_print">Contoh print:</label>
            </div>
            <div class="acs-div-container" id="contoh_printDiv"
                style="display: none;width: 16cm;height:20cm;position: relative;font-size: smaller;">
                <span id="nomor_sjKolom" style="position: absolute;top: 5.5cm;left: 10.5cm;"
                    contenteditable="true">Nomor SJ</span>
                <span id="tanggal_kirimKolom" style="position: absolute;top: 6cm;left: 10.5cm;"
                    contenteditable="true">Tanggal Kirim</span>
                <span id="truk_nopolKolom" style="position: absolute;top: 6.5cm;left: 10.5cm;"
                    contenteditable="true">Plat Nomor</span>
                <span id="no_spKolom" style="position: absolute;top: 7cm;left: 10.5cm;" contenteditable="true">Nomor
                    SP</span>
                <span id="no_poKolom" style="position: absolute;top: 7.5cm;left: 10.5cm;" contenteditable="true">Nomor
                    PO</span>
                <span id="nama_customerKolomAlamat_kolom"
                    style="position: absolute;top: 6cm;left: 1cm;width: 8cm;height: 2cm;"
                    contenteditable="true">Customer</span>
                <span id="nama_typeBarangKolom" style="position: absolute;top: 10cm;left: 1cm;width: 8.5cm;height: 2cm;" contenteditable="true">Nama Barang</span>
                <span id="satuan_barangSekunderKolom" style="position: absolute;top: 10cm;left: 10.5cm;width: 2cm;height: 2cm;" contenteditable="true"></span>
                <span id="jumlah_barangSekunderKolom" style="position: absolute;top: 10cm;left: 12.5cm;width: 2cm;height: 2cm;" contenteditable="true"></span>
                <span id="satuan_barangTritierKolom" style="position: absolute;top: 11cm;left: 10.5cm;width: 2cm;height: 2cm;" contenteditable="true"></span>
                <span id="jumlah_barangTritierKolom" style="position: absolute;top: 11cm;left: 12.5cm;width: 2cm;height: 2cm;" contenteditable="true"></span>
                <span id="keterangan_tambahanKolom" style="position: absolute;" contenteditable="true"></span>
                <span id="alamat_kirimKolom" style="position: absolute;top: 12.5cm;left: 1cm;width: 8.5cm;height: 3cm;" contenteditable="true"></span>
                <span id="tanda_tanganKolom" style="position: absolute;top: 18.5cm;left: 1cm;width: 6cm;height: 2cm;" contenteditable="true">(SUNYATA
                    ICHWAN)</span>
            </div>
            <div class="acs-div-container" id="contoh_printSjEksportDiv" style="display: none"
                contenteditable="true">
                <div class="acs-div-printsjekspor-header">
                    <div class="acs-div-printsjekspor-header1">
                        <h3>PT. KERTA RAJASA RAYA</h3>
                        <h4>JL RAYA TROPODO No. 1 WARU - SIDOARJO - INDONESIA</h4>
                        <h4>TELP (031) 8669595 (HUNTING)</h4>
                        <h3 style="text-decoration: underline">SURAT PENGANTAR PENGIRIMAN BARANG EKSPORT</h3>
                    </div>
                    <div class="acs-div-printsjekspor-header2">
                        <div class="acs-div-printsjekspor-header3">
                            <h3 id="nomor_sjExport"></h3>
                            <div class="acs-div-printsjekspor-subheader">
                                <span>Kepada Yth.</span>
                                <br>
                                <span id="nama_customerExportKolom" contenteditable="true"></span>
                                <br>
                                <span id="kota_exportKolom" contenteditable="true"></span>
                            </div>
                            <table id="table_noBorder">
                                <tr>
                                    <td>EMKL</td>
                                    <td>: </td>
                                    <td id="nama_expeditorExportKolom" contenteditable="true"></td>
                                </tr>
                                <tr>
                                    <td>No. Container</td>
                                    <td>: </td>
                                    <td contenteditable="true"></td>
                                </tr>
                                <tr>
                                    <td>No. Seal</td>
                                    <td>: </td>
                                    <td contenteditable="true"></td>
                                </tr>
                            </table>
                        </div>
                        <div class="acs-div-printsjekspor-header4">
                            <table id="table_noBorder">
                                <tr>
                                    <td>Tanggal</td>
                                    <td>: </td>
                                    <td id="tanggal_sjExportKolom" contenteditable="true"></td>
                                </tr>
                                <tr>
                                    <td>Truk No.</td>
                                    <td>: </td>
                                    <td id="truk_nopolExportKolom" contenteditable="true"></td>
                                </tr>
                                <tr>
                                    <td>SP No.</td>
                                    <td>: </td>
                                    <td id="nomor_spExportKolom" contenteditable="true"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="acs-div-printsjekspor-body">
                    <span id="jenis_barangEksportKolom"></span>
                    <table id="table_barangEksport">
                        <thead>
                            <tr>
                                <td>No.</td>
                                <td style="width: 80%">Nama Barang</td>
                                <td style="white-space: nowrap">Jumlah Primer</td>
                                <td style="white-space: nowrap">Jumlah Sekunder</td>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="acs-div-printsjekspor-footer">
                    <span id="nomor_poEksportKolom" contenteditable="true"></span>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <span id="nama_tandaTanganKolom" contenteditable="true">( SUNYATA ICHWAN )</span>
                    <br>
                    <br>
                    <span>Lembar ke 2 = Untuk Adm. Kantor</span><br>
                    <span>Lembar ke 3 = Untuk Satpam</span>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ asset('js/Sales/CetakSJ.js') }}"></script>
@endsection
