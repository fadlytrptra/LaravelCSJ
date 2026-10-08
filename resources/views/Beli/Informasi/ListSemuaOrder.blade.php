@extends('layouts.appOrderPembelian')

@section('content')

@section('title', 'List Semua Order')

<link href="{{ asset('css/style.css') }}" rel="stylesheet">
<link href="{{ asset('css/ListOrderPembelian.css') }}" rel="stylesheet">

<style>
    .advanced-filter-container1::before {
        content: "Search Definition 1";
        position: relative;
        top: -15px;
        background-color: white;
    }

    .advanced-filter-container2::before {
        content: "Search Definition 2";
        position: relative;
        top: -15px;
        background-color: white;
    }

    .advanced-filter-container3::before {
        content: "Search Definition 3";
        position: relative;
        top: -15px;
        background-color: white;
    }

    .advanced-filter-option-container::before {
        content: "Search Options";
        position: relative;
        top: -15px;
        background-color: white;
    }
</style>

<div class="container-fluid">

    <div class="row justify-content-center">

        <div class="col-md-10 RDZMobilePaddingLR0">

            <div class="card">

                <div class="card-header">
                    List Semua Order
                </div>

                <div class="card-body">

                    <div class="scrollmenu">

                        <div style="width: 100%; text-align: right;">

                            <button
                                class="btn btn-success"
                                id="btnExportExcel">
                                Export to Excel
                            </button>

                            <button
                                class="btn btn-info"
                                id="btnAdvancedSearch">
                                Advanced Search
                            </button>

                        </div>

                        <table
                            id="tabelData"
                            class="table table-bordered"
                            style="width:100%;white-space:nowrap">

                            <thead class="table-primary">

                                <tr>

                                    <th>No. Order</th>
                                    <th>Tgl. Order</th>
                                    <th>Nama User</th>
                                    <th>Nama Divisi</th>

                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>

                                    <th>Sub Kategori</th>
                                    <th>Kategori</th>
                                    <th>Kategori Utama</th>

                                    <th>Qty. PO</th>
                                    <th>Satuan</th>

                                    <th>Supplier</th>
                                    <th>Jenis Pembelian</th>

                                    <th>No. Terima</th>
                                    <th>Tgl. Datang</th>
                                    <th>Qty. RCV</th>
                                    <th>No. SJ</th>

                                    <th>Price RCV</th>
                                    <th>Disc RCV</th>
                                    <th>Price RCV PPN</th>

                                    <th>Tgl. Transfer</th>
                                    <th>Id Penagihan</th>
                                    <th>No. PIB</th>

                                    <th>No. SPPB</th>
                                    <th>Tgl. SPPB</th>

                                </tr>

                            </thead>

                            <tbody>
                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<!-- =========================================================
     MODAL ADVANCED SEARCH
========================================================= -->
<div
    class="modal fade"
    id="modalAdvancedSearch"
    tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h5>
                    Advanced Search
                </h5>

                <button
                    type="button"
                    class="close"
                    id="closeModalButton">

                    <span>
                        ×
                    </span>

                </button>

            </div>

            <div class="modal-body">

                <!-- Search 1 -->
                <div
                    class="border border-dark advanced-filter-group advanced-filter-container1 mb-3"
                    data-index="1">

                    <div
                        class="d-flex w-100 px-2 pb-2"
                        style="gap: 0.5%">

                        <div style="flex: 0.2">

                            <select class="form-select column-select">

                                <option value="">
                                    No Column
                                </option>

                            </select>

                        </div>

                        <div style="flex: 0.25">

                            <select class="form-select filter-type">

                                <option value="">
                                    No Filter
                                </option>

                            </select>

                        </div>

                        <div style="flex: 0.2">

                            <select class="form-select sort-order">

                                <option value="">
                                    No Sort
                                </option>

                                <option value="asc">
                                    Ascending
                                </option>

                                <option value="desc">
                                    Descending
                                </option>

                            </select>

                        </div>

                        <div style="flex: 0.35">

                            <input
                                type="text"
                                class="form-control search-value"
                                placeholder="Enter value...">

                            <input
                                type="number"
                                class="form-control search-number"
                                placeholder="Enter value...">

                            <input
                                type="date"
                                class="form-control search-date">

                            <div
                                style="display: flex; gap: 0.5%"
                                class="div-date-between">

                                <input
                                    type="date"
                                    class="form-control search-date1"
                                    style="flex: 1">

                                <input
                                    type="date"
                                    class="form-control search-date2"
                                    style="flex: 1">

                            </div>

                            <div
                                style="display: flex; gap: 0.5%"
                                class="div-number-between">

                                <input
                                    type="number"
                                    class="form-control search-number1"
                                    style="flex: 1">

                                <input
                                    type="number"
                                    class="form-control search-number2"
                                    style="flex: 1">

                            </div>

                        </div>

                    </div>

                </div>


                <!-- Search 2 -->
                <div
                    class="border border-dark advanced-filter-group advanced-filter-container2 mb-3"
                    data-index="2">

                    <div
                        class="d-flex w-100 px-2 pb-2"
                        style="gap: 0.5%">

                        <div style="flex: 0.2">

                            <select class="form-select column-select">

                                <option value="">
                                    No Column
                                </option>

                            </select>

                        </div>

                        <div style="flex: 0.25">

                            <select class="form-select filter-type">

                                <option value="">
                                    No Filter
                                </option>

                            </select>

                        </div>

                        <div style="flex: 0.2">

                            <select class="form-select sort-order">

                                <option value="">
                                    No Sort
                                </option>

                                <option value="asc">
                                    Ascending
                                </option>

                                <option value="desc">
                                    Descending
                                </option>

                            </select>

                        </div>

                        <div style="flex: 0.35">

                            <input
                                type="text"
                                class="form-control search-value"
                                placeholder="Enter value...">

                            <input
                                type="number"
                                class="form-control search-number"
                                placeholder="Enter value...">

                            <input
                                type="date"
                                class="form-control search-date">

                            <div
                                style="display: flex; gap: 0.5%"
                                class="div-date-between">

                                <input
                                    type="date"
                                    class="form-control search-date1"
                                    style="flex: 1">

                                <input
                                    type="date"
                                    class="form-control search-date2"
                                    style="flex: 1">

                            </div>

                            <div
                                style="display: flex; gap: 0.5%"
                                class="div-number-between">

                                <input
                                    type="number"
                                    class="form-control search-number1"
                                    style="flex: 1">

                                <input
                                    type="number"
                                    class="form-control search-number2"
                                    style="flex: 1">

                            </div>

                        </div>

                    </div>

                </div>


                <!-- Search 3 -->
                <div
                    class="border border-dark advanced-filter-group advanced-filter-container3 mb-3"
                    data-index="3">

                    <div
                        class="d-flex w-100 px-2 pb-2"
                        style="gap: 0.5%">

                        <div style="flex: 0.2">

                            <select class="form-select column-select">

                                <option value="">
                                    No Column
                                </option>

                            </select>

                        </div>

                        <div style="flex: 0.25">

                            <select class="form-select filter-type">

                                <option value="">
                                    No Filter
                                </option>

                            </select>

                        </div>

                        <div style="flex: 0.2">

                            <select class="form-select sort-order">

                                <option value="">
                                    No Sort
                                </option>

                                <option value="asc">
                                    Ascending
                                </option>

                                <option value="desc">
                                    Descending
                                </option>

                            </select>

                        </div>

                        <div style="flex: 0.35">

                            <input
                                type="text"
                                class="form-control search-value"
                                placeholder="Enter value...">

                            <input
                                type="number"
                                class="form-control search-number"
                                placeholder="Enter value...">

                            <input
                                type="date"
                                class="form-control search-date">

                            <div
                                style="display: flex; gap: 0.5%"
                                class="div-date-between">

                                <input
                                    type="date"
                                    class="form-control search-date1"
                                    style="flex: 1">

                                <input
                                    type="date"
                                    class="form-control search-date2"
                                    style="flex: 1">

                            </div>

                            <div
                                style="display: flex; gap: 0.5%"
                                class="div-number-between">

                                <input
                                    type="number"
                                    class="form-control search-number1"
                                    style="flex: 1">

                                <input
                                    type="number"
                                    class="form-control search-number2"
                                    style="flex: 1">

                            </div>

                        </div>

                    </div>

                </div>


                <!-- Maximum Records -->
                <div
                    class="border border-dark advanced-filter-options advanced-filter-option-container"
                    data-index="3">

                    <div
                        class="d-flex w-100 px-2 pb-2"
                        style="gap: 0.5%">

                        <div style="flex: 0.3">

                            <input
                                id="maximumRecords"
                                type="number"
                                class="form-control search-value"
                                placeholder="Maximum Records (1000)">

                        </div>

                    </div>

                </div>

            </div>


            <div class="modal-footer">

                <button
                    type="button"
                    id="applySearch"
                    class="btn btn-success">
                    Apply Search
                </button>

                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>


<script src="{{ asset('js/OrderPembelian/Informasi/ListSemuaOrder.js') }}"></script>

@endsection
