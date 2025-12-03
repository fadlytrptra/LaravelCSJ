@extends('layouts.appSales')
@section('content')
@section('title', 'Cetak BonKas')
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
<link href="{{ asset('css/cetakBonKas.css') }}" rel="stylesheet">
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 RDZMobilePaddingLR0">
            <div class="card">
                <div class="card-header">Cetak Bon Kas</div>
                <div class="card-body">
                    <div class="d-flex" style="gap: 1%">
                        <div class="form-group" style="flex: 0.25">
                            <label for="tanggal_bonKas">Tanggal:</label>
                            <div class="input-group">
                                <input type="date" name="tanggal_bonKas" id="tanggal_bonKas" class="input"
                                    style="width: 75%">
                                <button class="btn btn-primary" style="width: 20%" id="no_sjButton">...</button>
                            </div>
                        </div>
                        <div class="form-group" style="flex: 0.2">
                            <label for="no_sj">Nomor SJ:</label>
                            <div class="input-group">
                                <input type="text" name="no_sj" id="no_sj" class="input w-100" readonly>
                            </div>
                        </div>
                        {{-- <div class="form-group" style="flex: 0.2">
                            <label for="no_sp">Nomor SP:</label>
                            <div class="input-group">
                                <input type="text" name="no_sp" id="no_sp" class="input w-100" readonly>
                            </div>
                        </div> --}}
                    </div>
                    <div>
                        <button id="print_view" class="btn btn-info"><span>&#128462;</span> View Print</button>
                        <button id="print_button" class="btn btn-success" style="display: none;"><span>🖶</span> Print
                            Surat Jalan</button>
                    </div>
                </div>
            </div>
            <label class="m-3" for="contoh_print" id="contoh_print" style="display: none">Contoh print:</label>
            <div class="acs-div-container mx-3" id="contoh_printDiv" style="display: none">
                <div class="d-flex">
                    <div style="flex: 0.5">

                    </div>
                    <div style="flex: 0.5">
                        <span id="print_id_pengiriman" class="span_id_pengiriman"
                            contenteditable="true">0000111395</span>
                    </div>
                </div>
                <div class="d-flex">
                    <div style="flex: 0.5">
                        <span id="print_nama_customer" class="span_nama_customer" contenteditable="true">KARYA INDAH
                            MULTIKREASINDO, PT</span>
                    </div>
                    <div style="flex: 0.5">
                        <span id="print_tgl_kirim" class="span_tgl_kirim" contenteditable="true">6/24/2025</span>
                    </div>
                </div>
                <div class="d-flex">
                    <div style="flex: 0.5">
                        <span id="print_kota" class="span_kota" contenteditable="true">KAB SIDOARJO</span>
                    </div>
                    <div style="flex: 0.5">
                        <span id="print_truk_nopol" class="span_truk_nopol" contenteditable="true">L8653UC/SUMBER
                            KARYA</span>
                    </div>
                </div>
                <div class="d-flex my-2">
                    <span id="print_nama_typeBarang" class="span_nama_typeBarang"
                        style="font-weight: bold;text-decoration: underline" contenteditable="true">Ass -
                        Pembantu</span>
                </div>
                <div class="d-flex">
                    <div style="flex: 0.5">
                        <span id="print_nama_type" class="span_nama_type" contenteditable="true">PP KARUNG HITAM PP
                            KARUNG HITAM PP KARUNG HITAM</span>
                    </div>
                    <div style="flex: 0.5">
                        <span id="print_qty_primer" class="span_qty_primer" contenteditable="true">0 NULL</span>
                    </div>
                </div>
                <div class="d-flex">
                    <div style="flex: 0.5">
                        <span id="print_no_po" class="span_no_po" contenteditable="true">PORMP-24.06-0016</span>
                    </div>
                    <div style="flex: 0.5">
                        <span id="print_qty_sekunder" class="span_qty_sekunder" contenteditable="true">510 ZAK</span>
                    </div>
                </div>
                <div class="d-flex">
                    <div style="flex: 0.5"></div>
                    <div style="flex: 0.5">
                        <span id="print_qty_tritier" class="span_qty_tritier" contenteditable="true">12,750.00
                            KGM</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ asset('js/Sales/CetakBonKas.js') }}"></script>
@endsection
