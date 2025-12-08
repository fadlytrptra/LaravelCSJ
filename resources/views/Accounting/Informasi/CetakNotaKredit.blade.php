@extends('layouts.appAccounting')
@section('content')
@section('title', 'Cetak Nota Kredit')

<style>
    .table-responsive.fixed-height tbody {
        background-color: white;
    }

    .underline {
        border-bottom: 1px solid black;
        /* Change the color as needed */
        margin-bottom: 10px;
        /* Space between labels and line */
    }

    .table-responsive.fixed-height {
        /* overflow-y: auto; */
        /* position: relative; */
        border-radius: 8px;
        border: 2px solid black;
        /* width: 100%; */
        /* table-layout: fixed; */
        background-color: white;
    }

    .no-wrap-header thead th {
        white-space: nowrap;
        background-color: lightgoldenrodyellow;
        padding: 0;
    }

    .table-responsive.fixed-height tbody td {
        background-color: white;
        padding: 4px 5px;
    }

    .fixed-width {
        white-space: nowrap;
        /* Prevent text wrapping */
        overflow: hidden;
        /* Hide overflow text */
        text-overflow: ellipsis;
        /* Show "..." when the text overflows */
        padding: 0;
    }

    table.dataTable {
        table-layout: fixed;
        /* Ensure table uses fixed layout */
        width: 100%;
        /* Ensure the table takes up the full width */
    }

    #table_list th,
    #table_list td {
        padding-top: 0;
        padding-bottom: 0;
        font-size: 16px;
    }

    @media print {
        .card {
            display: none;
        }

        .print {
            visibility: visible !important;
        }

        .modal {
            display: none !important;
        }

        .fade {
            opacity: 0 !important;
        }
    }
</style>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-7 RDZMobilePaddingLR0">
            <div class="card">
                <div class="card-header">Cetak Nota Kredit</div>
                @if (Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                @endif
                <div class="card-body RDZOverflow RDZMobilePaddingLR0">
                    <div class="form-container col-md-12">
                        <div class="d-flex">
                            <div class="col-md-4">
                                <label for="tanggal">Tanggal</label>
                            </div>
                            <div class="col-md-3">
                                <input type="date" id="tanggal" name="tanggal" class="form-control"
                                    style="width: 100%">
                            </div>
                        </div>
                        <p>
                        <div class="d-flex">
                            <div class="col-md-4">
                                <label for="namaCustomer">Customer</label>
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="namaCustomer" name="namaCustomer"
                                        readonly>
                                    <div class="input-group-append">
                                        <button type="button" id="btn_cust" class="btn btn-default">...</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p>
                        <div class="d-flex">
                            <div class="col-md-4">
                                <label for="id_penagihan">Nota Kredit</label>
                            </div>
                            <div class="col-md-5">
                                <input type="text" id="id_penagihan" name="id_penagihan" class="form-control"
                                    style="width: 100%">
                            </div>
                        </div>

                        <div class="col-md-5">
                            <input type="hidden" id="statusPPN" name="statusPPN" class="form-control"
                                style="width: 100%">
                        </div>
                        <div class="col-md-5">
                            <input type="hidden" id="jnsNotaKredit" name="jnsNotaKredit" class="form-control"
                                style="width: 100%">
                        </div>

                        <br>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-2">
                                    <input type="submit" id="btnCetak" name="btnCetak" value="Cetak"
                                        class="btn btn-primary">
                                </div>
                                <div class="col-2">
                                    <input type="submit" id="btnKeluar" name="btnKeluar" value="Keluar"
                                        class="btn btn-primary">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- cetak notaKreditPPN & notaPotHargaPPN & notaFreePPN--}}
<div class="notaKreditPPN" style="display: none">
    <div class="container">
        <div class="row" style="margin-top: 10%">
            <div class="col-sm-12" style="text-align-last: center">
                <div class="col-sm-12" style="text-align: center;">
                    <strong><u>LAMPIRAN KEPUTUSAN MENTERI KEUANGAN R.I</u></strong>
                </div>
                <div class="col-sm-12" style="text-align: center; font: 14px">
                    Nomor : 987/KMK. 04/1984 Tanggal : 18 September 1984
                </div>
            </div>
        </div>
        <div class="row" style="border: solid 1px; font: 16px">
            <div class="col-sm-12"><strong><u>PEMBELI</u></strong></div>
            <div class="col-sm-2"></div>
            <div class="col-sm-10">
                <div class="row">
                    <div class="col-sm-2 p-0">NAMA &nbsp; &nbsp; :</div>
                    <div class="col-sm-8" id="nama" style="margin-left: -4vh"></div>
                    <div class="col-sm-2"></div>
                </div>
                <div class="row">
                    <div class="col-sm-2 p-0">ALAMAT :</div>
                    <div class="col-sm-9" id="alamat" style="margin-left: -4vh"></div>
                    <div class="col-sm-1"></div>
                </div>
                <div class="row">
                    <div class="col-sm-2 p-0">NPWP &nbsp; &nbsp; :</div>
                    <div class="col-sm-8" id="npwp" style="margin-left: -4vh"></div>
                    <div class="col-sm-2"></div>
                </div>
            </div>
        </div>
        <div class="row" style="border: solid 1px; font: 16px">
            <div class="col-sm-12">
                <strong>
                    <center><u>NOTA RETUR</u></center>
                </strong>
            </div>
            <div class="col-sm-12" style="text-align: center; font: 16px" id="nomor">
                <center></center>
            </div>
            <div class="col-sm-6" id="ketPajak"></div>
        </div>
        <div class="row" style="border: solid 1px; font: 16px">
            <div class="col-sm-12"><strong><u>Kepada P E N J U A L</u></strong></div>
            <div class="col-sm-4"></div>
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-3">NAMA &nbsp; &nbsp; :</div>
                    <div class="col-sm-9" style="margin-left: -3vh">PT. KERTA RAJASA RAYA</div>
                </div>
                <div class="row">
                    <div class="col-sm-3">ALAMAT :</div>
                    <div class="col-sm-9" style="margin-left: -3vh">Jl. Raya Tropodo No. 1, Waru - Sidoarjo</div>
                </div>
                <div class="row">
                    <div class="col-sm-3">NPWP &nbsp; &nbsp;:</div>
                    <div class="col-sm-9" style="margin-left: -3vh">01.140.897.8-617.000</div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-1" style="border: solid 1px; font: 16px">
                <center>No</center>
            </div>
            <div class="col-sm-5" style="border: solid 1px; font: 16px">
                <center>Nama Barang Kena Pajak / Barang Mewah Yang Retur</center>
            </div>
            <div class="col-sm-2" style="border: solid 1px; font: 16px">
                <center>Kuantum</center>
            </div>
            <div class="col-sm-2" style="border: solid 1px; font: 16px">
                <center>Harga Satuan Faktur Pajak (Rp. )</center>
            </div>
            <div class="col-sm-2" style="border: solid 1px; font: 16px">
                <center>Harga Jual Yang DiRetur (Rp. )</center>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-1" id="no" style="border: solid 1px; font: 16px; text-align: right;"></div>
            <div class="col-sm-5" id="namaTypeBarang" style="border: solid 1px; font: 16px"></div>
            <div class="col-sm-2 d-flex" style="border: solid 1px; font: 16px; justify-content: center;">
                <div id="qtyKonversi" style="padding-right: 3%"></div>
                <div id="satuanJual"></div>
            </div>
            <div class="col-sm-2" id="hargaSatuan" style="border: solid 1px; font: 16px; text-align: right;"></div>
            <div class="col-sm-2" id="total" style="border: solid 1px; font: 16px; text-align: right;"></div>
        </div>
        <div class="row" style="border: solid 1px; font: 16px">
            <div class="col-sm-2" style="font: 14px">Surat Jalan :</div>
            <div class="col-sm-6" id="suratJalan" style="margin-left: -5vh; margin-right: 5vh;"></div>
            <div class="col-sm-2" style="text-align: right;">Harga Jual</div>
            <div class="col-sm-2" id="grandTotal1"
                style="border: solid 1px; border-top: 0px; font: 16px; text-align: right;"></div>

            <div class="col-sm-2 offset-sm-8" style="text-align: right;">Potongan Harga</div>
            <div class="col-sm-2"
                style="border: solid 1px; border-top: 0px; border-bottom: 0px; ; font: 16px; text-align: right"> -
            </div>
        </div>
        <div class="row" style="border: solid 1px; font: 16px">
            <div class="col-sm-10">
                <center>Jumlah Harga Jual Barang yang diretur</center>
            </div>
            <div class="col-sm-2" id="grandTotal2"
                style="border: solid 1px; border-top: 0px; border-bottom: 0px; font: 16px; text-align: right;"></div>
        </div>


        <div class="row" style="border: solid 1px; font: 16px">
            <div class="col-sm-10">Jumlah Pajak Yang Dikurangkan :</div>
            <div class="col-sm-2" style="border: solid 1px; border-bottom: 0px; border-top: 0px;"></div>
            <div class="col-sm-5 offset-sm-5">a. Pajak Pertambahan Nilai (PPN) ........................................
            </div>
            <div class="col-sm-2" id="nilaiPajak" style="border: solid 1px; border-top: 0px; text-align: right;">
            </div>
            <div class="col-sm-5 offset-sm-5">b. Pajak Penjualan atas Barang Mewah (PPN) ....................</div>
            <div class="col-sm-2" style="border: solid 1px; border-bottom: 0px; border-top: 0px;">&nbsp;</div>

        </div>
        <div class="row" style="border: solid 1px; font: 16px">
            <div class="col-sm-12"></div>
            <div class="col-sm-2">Faktur No. :</div>
            <div class="col-sm-2" id="idPenagihan" style="margin-left: -5vh;"></div>
            <div class="col-sm-4" style="margin-right: 7%"></div>
            <div class="col-sm-1">Sidorarjo, </div>
            <div class="col-sm-3 p-0" id="tanggal"
                style="border: solid 1px; border-left: 0px; border-top: 0px; border-right: 0px; text-align: center;">
            </div>
            <div class="col-sm-3 offset-sm-9">
                <center>Pembeli</center>
            </div>
            <div class="col-sm-3 offset-sm-9">
                <center>Cap & ttd</center>
            </div>

            <div class="col-sm-5" style="margin-top: 7%">Lembar Ke-1 : Untuk PKP yang menerbitkan Faktur Pajak</div>
            <div class="col-sm-3 offset-sm-4"
                style="border: solid 1px; border-left: 0px; border-top: 0px; border-right: 0px;"></div>
            <div class="col-sm-12">Lembar Ke-2 : Untuk Pembeli Yang Meretur Barang</div>
            <div class="col-sm-12">Lembar Ke-3 : Untuk Kantor Pelayanan Pajak</div>

        </div>

    </div>
</div>

{{-- cetak notaKredit & notaFree --}}
<div class="notaKredit" style="display: none">
    <div class="container">
        <div class="row" style="font: 16px">
            <div class="col-sm-3">
                <center><strong>PT. KERTARAJASA RAYA</strong></center>
            </div>
            <div class="col-sm-1 offset-sm-6" style="text-align: right">Tanggal</div>
            <div class="col-sm-2" id="tanggal"></div>
            <div class="col-sm-3">
                <center><strong>WARU - SIDOARJO</strong></center>
            </div>
            <div class="col-sm-1 offset-sm-6" style="text-align: right">Nomor</div>
            <div class="col-sm-2" id="idNotaKredit"></div>
        </div>
        <div class="row" style="font: 16px">
            <div class="col-sm-12">
                <center><u><strong>NOTA KREDIT</strong></u></center>
            </div>
            <div class="col-sm-2">NAMA PEMBELI &nbsp; : </div>
            <div class="col-sm-10" id="nama" style="margin-left: -1vh"></div>
            <div class="col-sm-2">A L A M A T &nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;: </div>
            <div class="col-sm-10" id="alamat" style="margin-left: -1vh"></div>
            <div class="col-sm-2">NO. SJ / SP &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: </div>
            <div class="col-sm-2" id="suratJalan" style="margin-left: -1vh"></div>
            <p>/</p>
            <div class="col-sm-2" id="idSuratPesanan"></div>
            <div class="col-sm-12"></div>
        </div>
        <div class="row">
            <div class="col-sm-5" style="border: solid 1px; font: 16px">
                <center>NAMA BARANG</center>
            </div>
            <div class="col-sm-2" style="border: solid 1px; font: 16px">
                <center>KWANTUM</center>
            </div>
            <div class="col-sm-3" style="border: solid 1px; font: 16px">
                <center>HARGA SATUAN</center>
            </div>
            <div class="col-sm-2" style="border: solid 1px; font: 16px">
                <center>JUMLAH</center>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-5" id="namaTypeBarang" style="border: solid 1px; font: 16px"></div>
            <div class="col-sm-2 d-flex" style="border: solid 1px; font: 16px; justify-content: center;">
                <div id="qtyKonversi" style="padding-right: 3%"></div>
                <div id="satuanJual"></div>
            </div>
            <div class="col-sm-3" id="hargaSatuan" style="border: solid 1px; font: 16px; text-align: center;"></div>
            <div class="col-sm-2" id="total" style="border: solid 1px; font: 16px; text-align: center;"></div>
            <div class="col-sm-10" id="terbilang" style="border: solid 1px; font: 16px"></div>
            <div class="col-sm-2" id="grandTotal" style="border: solid 1px; font: 16px; text-align: center"></div>

        </div>
        <div class="row mt-3">
            <div class="col-sm-2 offset-sm-1">Potong Nota : </div>
            <div class="col-sm-2" id="idPenagihan" style="margin-left: -4vh; margin-right: 4vh; "></div>
            <div class="col-sm-2 offset-sm-2">
                <center>MENGETAHUI,</center>
            </div>
            <div class="col-sm-2 offset-sm-1">
                <center>MENYETUJUI,</center>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2 offset-sm-7"
                style="margin-top: 7%; border: solid 1px; border-left: 0px; border-top: 0px; border-right: 0px;"></div>
            <div class="col-sm-2 offset-sm-1"
                style="margin-top: 7%; border: solid 1px; border-left: 0px; border-top: 0px; border-right: 0px;">
                <center>YUDI SANTOSO</center>
            </div>
            <div class="col-sm-2 offset-sm-7" style="font: 12px">
                <center>MARKETING</center>
            </div>
            <div class="col-sm-2 offset-sm-1" style="font: 12px">
                <center>DIREKTUR KEUANGAN</center>
            </div>
        </div>
    </div>
</div>

<div class="notaSelisihPPN" style="display: none">
    <div class="container">
        <div class="row" style="font: 16px">
            <div class="col-sm-3">
                <center><strong>PT. KERTARAJASA RAYA</strong></center>
            </div>
            <div class="col-sm-1 offset-sm-6" style="text-align: right">Tanggal</div>
            <div class="col-sm-2" id="tanggal"></div>
            <div class="col-sm-3">
                <center><strong>WARU - SIDOARJO</strong></center>
            </div>
            <div class="col-sm-1 offset-sm-6" style="text-align: right">Nomor</div>
            <div class="col-sm-2" id="idNotaKredit"></div>
        </div>
        <div class="row" style="font: 16px">
            <div class="col-sm-12">
                <center><u><strong>NOTA KREDIT</strong></u></center>
            </div>
            <div class="col-sm-2">NAMA PEMBELI &nbsp; : </div>
            <div class="col-sm-10" id="nama" style="margin-left: -1vh"></div>
            <div class="col-sm-2">A L A M A T &nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;: </div>
            <div class="col-sm-10" id="alamat" style="margin-left: -1vh"></div>
            <div class="col-sm-2">NO. SJ &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: </div>
            <div class="col-sm-2" id="suratJalan" style="margin-left: -1vh"></div>
            <div class="col-sm-12"></div>
        </div>
        <div class="row">
            <div class="col-sm-5" style="border: solid 1px; font: 16px">
                <center>NAMA BARANG</center>
            </div>
            <div class="col-sm-2" style="border: solid 1px; font: 16px">
                <center>SELISIH QTY</center>
            </div>
            <div class="col-sm-3" style="border: solid 1px; font: 16px">
                <center>HARGA SATUAN</center>
            </div>
            <div class="col-sm-2" style="border: solid 1px; font: 16px">
                <center>JUMLAH</center>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-5" id="namaBarang" style="border: solid 1px; font: 16px"></div>
            <div class="col-sm-2" style="border: solid 1px; font: 16px; justify-content: center;"></div>
            <div class="col-sm-3" id="hargaSatuan" style="border: solid 1px; font: 16px; text-align: center;"></div>
            <div class="col-sm-2" id="total" style="border: solid 1px; font: 16px; text-align: center;"></div>
            <div class="col-sm-10" id="terbilang" style="border: solid 1px; font: 16px"></div>
            <div class="col-sm-2" id="grandTotal" style="border: solid 1px; font: 16px; text-align: center"></div>

        </div>
        <div class="row mt-3">
            <div class="col-sm-2">Potong Nota : </div>
            <div class="col-sm-2" id="idPenagihan" style="margin-left: -4vh; margin-right: 1vh; "></div>
            <div class="col-sm-5">
                <center>MENGETAHUI,</center>
            </div>
            <div class="col-sm-2 offset-sm-1" style="padding-left: 6vh;">
                <center>MENYETUJUI,</center>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2 offset-sm-4"
                style="margin-top: 7%; border: solid 1px; border-left: 0px; border-top: 0px; border-right: 0px;"></div>
            <div class="col-sm-2 offset-sm-1"
                style="margin-top: 7%; border: solid 1px; border-left: 0px; border-top: 0px; border-right: 0px;">
                <center>RUDY SANTOSO</center>
            </div>
            <div class="col-sm-2 offset-sm-1"
                style="margin-top: 7%; border: solid 1px; border-left: 0px; border-top: 0px; border-right: 0px;">
                <center>YUDI SANTOSO</center>
            </div>
            <div class="col-sm-2 offset-sm-4" style="font: 12px">
                <center>MARKETING</center>
            </div>
            <div class="col-sm-2 offset-sm-1 p-0" style="font: 12px">
                <center>MANAGER MARKETING</center>
            </div>
            <div class="col-sm-2 offset-sm-1 p-0" style="font: 12px">
                <center>DIREKTUR KEUANGAN</center>
            </div>
        </div>
    </div>
</div>

{{-- cetak notaSelisih & notaPotHarga --}}
<div class="notaSelisih" style="display: none">
    <div class="container">
        <div class="row" style="font: 16px">
            <div class="col-sm-3">
                <center><strong>PT. KERTARAJASA RAYA</strong></center>
            </div>
            <div class="col-sm-1 offset-sm-6" style="text-align: right">Tanggal</div>
            <div class="col-sm-2" id="tanggal"></div>
            <div class="col-sm-3">
                <center><strong>WARU - SIDOARJO</strong></center>
            </div>
            <div class="col-sm-1 offset-sm-6" style="text-align: right">Nomor</div>
            <div class="col-sm-2" id="idNotaKredit"></div>
        </div>
        <div class="row" style="font: 16px">
            <div class="col-sm-12">
                <center><u><strong>NOTA KREDIT</strong></u></center>
            </div>
            <div class="col-sm-2">NAMA PEMBELI &nbsp; : </div>
            <div class="col-sm-10" id="nama" style="margin-left: -1vh"></div>
            <div class="col-sm-2">A L A M A T &nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;: </div>
            <div class="col-sm-10" id="alamat" style="margin-left: -1vh"></div>
            <div class="col-sm-2">NO. SJ &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: </div>
            <div class="col-sm-2" id="suratJalan" style="margin-left: -1vh"></div>
            <div class="col-sm-12"></div>
        </div>
        <div class="row">
            <div class="col-sm-5" style="border: solid 1px; font: 16px">
                <center>NAMA BARANG</center>
            </div>
            <div class="col-sm-2" style="border: solid 1px; font: 16px">
                <center>KWANTUM</center>
            </div>
            <div class="col-sm-3" style="border: solid 1px; font: 16px">
                <center>HARGA SATUAN</center>
            </div>
            <div class="col-sm-2" style="border: solid 1px; font: 16px">
                <center>JUMLAH</center>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-5" id="namaTypeBarang" style="border: solid 1px; font: 16px"></div>
            <div class="col-sm-2 d-flex" style="border: solid 1px; font: 16px; justify-content: center;">
                <div id="qtyKonversi" style="padding-right: 3%"></div>
                <div id="satuanJual"></div>
            </div>
            <div class="col-sm-3" id="hargaSatuan" style="border: solid 1px; font: 16px; text-align: center;"></div>
            <div class="col-sm-2" id="total" style="border: solid 1px; font: 16px; text-align: center;"></div>
            <div class="col-sm-10" id="terbilang" style="border: solid 1px; font: 16px"></div>
            <div class="col-sm-2" id="grandTotal" style="border: solid 1px; font: 16px; text-align: center"></div>

        </div>
        <div class="row mt-3">
            <div class="col-sm-2">Potong Nota : </div>
            <div class="col-sm-2" id="idPenagihan" style="margin-left: -4vh; margin-right: 1vh; "></div>
            <div class="col-sm-5">
                <center>MENGETAHUI,</center>
            </div>
            <div class="col-sm-2 offset-sm-1" style="padding-left: 6vh;">
                <center>MENYETUJUI,</center>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2 offset-sm-4"
                style="margin-top: 7%; border: solid 1px; border-left: 0px; border-top: 0px; border-right: 0px;"></div>
            <div class="col-sm-2 offset-sm-1"
                style="margin-top: 7%; border: solid 1px; border-left: 0px; border-top: 0px; border-right: 0px;">
                <center>RUDY SANTOSO</center>
            </div>
            <div class="col-sm-2 offset-sm-1"
                style="margin-top: 7%; border: solid 1px; border-left: 0px; border-top: 0px; border-right: 0px;">
                <center>YUDI SANTOSO</center>
            </div>
            <div class="col-sm-2 offset-sm-4" style="font: 12px">
                <center>MARKETING</center>
            </div>
            <div class="col-sm-2 offset-sm-1 p-0" style="font: 12px">
                <center>MANAGER MARKETING</center>
            </div>
            <div class="col-sm-2 offset-sm-1 p-0" style="font: 12px">
                <center>DIREKTUR KEUANGAN</center>
            </div>
        </div>
    </div>
</div>


<script src="{{ asset('js/Accounting/Informasi/CetakNotaKredit.js') }}"></script>
@endsection
