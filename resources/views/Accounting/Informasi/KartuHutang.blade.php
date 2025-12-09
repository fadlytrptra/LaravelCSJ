@extends('layouts.appAccounting')
@section('content')
@section('title', 'Kartu Hutang')

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
</style>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-7 RDZMobilePaddingLR0">
            <div class="card">
                <div class="card-header">Informasi Piutang Penjualan</div>
                <div class="card-body RDZOverflow RDZMobilePaddingLR0">
                    <div class="form-container col-md-12">
                        <!-- Form fields go here -->
                        <div class="d-flex">
                            <div class="col-md-2">
                                <label for="periode">PERIODE</label>
                            </div>
                            <div class="col-md-3">
                                <input type="date" id="tanggal1" class="form-control" style="width: 100%">
                            </div>
                            <div class="col-md-3 text-center">
                                sampai dengan
                            </div>
                            <div class="col-md-3">
                                <input type="date" id="tanggal2" class="form-control" style="width: 100%">
                            </div>
                        </div>
                        <div class="d-flex mt-2">
                            <div class="col-md-2">
                                <label for="supplier">SUPPLIER</label>
                            </div>
                            <div class="col-md-2">
                                <input type="text" id="idSupplier" class="form-control" style="width: 100%">
                            </div>
                            <div class="col-md-7">
                                <input type="text" id="supplier" class="form-control" style="width: 100%">
                            </div>
                            <div class="col-md-1">
                                <button id="btnSupplier" class="btn btn-primary form-control"
                                    style="width: 100%">...</button>
                            </div>
                        </div>

                        <br>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-2">
                                    <input type="submit" id="btnProses" name="proses" value="Proses"
                                        class="btn btn-primary">
                                </div>
                                <div class="col-2">
                                    <input type="submit" id="btnPerbaiki" name="perbaiki" value="Perbaiki"
                                        class="btn btn-primary">
                                </div>
                                <div class="col-2">
                                    <input type="submit" id="btnKeluar" name="keluar" value="KELUAR"
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
<script src="{{ asset('js/Accounting/Informasi/KartuHutang.js') }}"></script>

@endsection
