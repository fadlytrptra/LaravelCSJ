@extends('layouts.appOrderPembelian')
@section('content')
@section('title', 'History Pembelian')
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
                <div class="card-header">History Pembelian</div>
                <div class="card-body ">
                    <div style="width: 100%; text-align: right;">
                        <button class="btn btn-success" id="btnExportExcel">Export to Excel</button>
                        <button class="btn btn-info" id="btnAdvancedSearch">Advanced Search</button>
                    </div>
                    <div style="overflow: auto;">
                        <table id="tabelData" class="table table-bordered" style="white-space: nowrap">
                            <thead class="table-primary">
                                <tr>
                                    <th>No Order</th>
                                    <th>Status Order</th>
                                    <th>Tgl PO</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Harga Unit</th>
                                    <th>Satuan</th>
                                    <th>Supplier</th>
                                    <th>Requester</th>
                                    <th>Nama Divisi</th>
                                    <th>Sub Kategori</th>
                                    <th>Status Beli</th>
                                    <th>Qty PO</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    {{-- <form action="" id="formDaftarHarga">

                        <div class="row mt-4">
                            <div class="col-md-9">
                                <div class="row mb-3">
                                    <label for="" class="col-md-2 col-form-label">
                                        <input type="radio" name="opsi" id="rbkode_barang" value="kode_barang">
                                        Kode Barang
                                    </label>
                                    <div class="col-md-10">
                                        <input type="text" name="search_kode_barang"
                                            id="search_kode_barang"class="form-control font-weight-bold">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="" class="col-md-2 col-form-label">
                                        <input type="radio" name="opsi" id="rbnama_barang" value="nama_barang">
                                        Nama Barang
                                    </label>
                                    <div class="col-md-10">
                                        <input type="text" name="search_nama_barang" id="search_nama_barang"
                                            class="form-control font-weight-bold">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="" class="col-md-2 col-form-label">
                                        <input type="radio" name="opsi" id="rbsupplier" value="supplier">
                                        Supplier
                                    </label>
                                    <div class="col-md-10">
                                        <input type="text" name="search_supplier" id="search_supplier"
                                            class="form-control font-weight-bold">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="" class="col-md-2 col-form-label">
                                        <input type="radio" name="opsi" id="rbuser" value="user">
                                        User
                                    </label>
                                    <div class="col-md-10">
                                        <input type="text" name="search_user" id="search_user"
                                            class="form-control font-weight-bold">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="d-flex flex-column justify-content-between">
                                    <button type="button" id="redisplay" class="custom-button1 mb-2">Redisplay</button>
                                </div>
                            </div>
                        </div>
                    </form> --}}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalAdvancedSearch" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Advanced Search</h5>
                <button type="button" class="close" id="closeModalButton">
                    <span>×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="border border-dark advanced-filter-group advanced-filter-container1 mb-3" data-index="1">
                    <div class="d-flex w-100 px-2 pb-2" style="gap: 0.5%">
                        <div style="flex: 0.2">
                            <select class="form-select column-select">
                                <option value="">No Column</option>
                            </select>
                        </div>
                        <div style="flex: 0.25">
                            <select class="form-select filter-type">
                                <option value="">No Filter</option>
                                <option value="=">Equal</option>
                                <option value="!=">Not Equal</option>
                                <option value="like">Contains</option>
                                <option value="isbetween">Is Between</option>
                                <option value="notbetween">Is Not Between</option>
                                <option value="in">In</option>
                                <option value="notin">Not In</option>
                                <option value="isnull">Is Null</option>
                                <option value="isnotnull">Is Not Null</option>
                            </select>
                        </div>
                        <div style="flex: 0.2">
                            <select class="form-select sort-order">
                                <option value="">No Sort</option>
                                <option value="asc">Ascending</option>
                                <option value="desc">Descending</option>
                            </select>
                        </div>
                        <div style="flex: 0.35">
                            <input type="text" class="form-control search-value" placeholder="Enter value...">
                            <input type="number" class="form-control search-number" placeholder="Enter value...">
                            <input type="date" class="form-control search-date">
                            <div style="display: flex; gap: 0.5%" class="div-date-between">
                                <input type="date" class="form-control search-date1" style="flex: 1">
                                <input type="date" class="form-control search-date2" style="flex: 1">
                            </div>
                            <div style="display: flex; gap: 0.5%" class="div-number-between">
                                <input type="number" class="form-control search-number1" style="flex: 1">
                                <input type="number" class="form-control search-number2" style="flex: 1">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border border-dark advanced-filter-group advanced-filter-container2 mb-3" data-index="2">
                    <div class="d-flex w-100 px-2 pb-2" style="gap: 0.5%">
                        <div style="flex: 0.2">
                            <select class="form-select column-select">
                                <option value="">No Column</option>
                            </select>
                        </div>
                        <div style="flex: 0.25">
                            <select class="form-select filter-type">
                                <option value="">No Filter</option>
                                <option value="=">Equal</option>
                                <option value="!=">Not Equal</option>
                                <option value="like">Contains</option>
                                <option value="isbetween">Is Between</option>
                                <option value="notbetween">Is Not Between</option>
                                <option value="in">In</option>
                                <option value="notin">Not In</option>
                                <option value="isnull">Is Null</option>
                                <option value="isnotnull">Is Not Null</option>
                            </select>
                        </div>
                        <div style="flex: 0.2">
                            <select class="form-select sort-order">
                                <option value="">No Sort</option>
                                <option value="asc">Ascending</option>
                                <option value="desc">Descending</option>
                            </select>
                        </div>
                        <div style="flex: 0.35">
                            <input type="text" class="form-control search-value" placeholder="Enter value...">
                            <input type="number" class="form-control search-number" placeholder="Enter value...">
                            <input type="date" class="form-control search-date">
                            <div style="display: flex; gap: 0.5%" class="div-date-between">
                                <input type="date" class="form-control search-date1" style="flex: 1">
                                <input type="date" class="form-control search-date2" style="flex: 1">
                            </div>
                            <div style="display: flex; gap: 0.5%" class="div-number-between">
                                <input type="number" class="form-control search-number1" style="flex: 1">
                                <input type="number" class="form-control search-number2" style="flex: 1">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border border-dark advanced-filter-group advanced-filter-container3 mb-3" data-index="3">
                    <div class="d-flex w-100 px-2 pb-2" style="gap: 0.5%">
                        <div style="flex: 0.2">
                            <select class="form-select column-select">
                                <option value="">No Column</option>
                            </select>
                        </div>
                        <div style="flex: 0.25">
                            <select class="form-select filter-type">
                                <option value="">No Filter</option>
                                <option value="=">Equal</option>
                                <option value="!=">Not Equal</option>
                                <option value="like">Contains</option>
                                <option value="isbetween">Is Between</option>
                                <option value="notbetween">Is Not Between</option>
                                <option value="in">In</option>
                                <option value="notin">Not In</option>
                                <option value="isnull">Is Null</option>
                                <option value="isnotnull">Is Not Null</option>
                            </select>
                        </div>
                        <div style="flex: 0.2">
                            <select class="form-select sort-order">
                                <option value="">No Sort</option>
                                <option value="asc">Ascending</option>
                                <option value="desc">Descending</option>
                            </select>
                        </div>
                        <div style="flex: 0.35">
                            <input type="text" class="form-control search-value" placeholder="Enter value...">
                            <input type="number" class="form-control search-number" placeholder="Enter value...">
                            <input type="date" class="form-control search-date">
                            <div style="display: flex; gap: 0.5%" class="div-date-between">
                                <input type="date" class="form-control search-date1" style="flex: 1">
                                <input type="date" class="form-control search-date2" style="flex: 1">
                            </div>
                            <div style="display: flex; gap: 0.5%" class="div-number-between">
                                <input type="number" class="form-control search-number1" style="flex: 1">
                                <input type="number" class="form-control search-number2" style="flex: 1">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border border-dark advanced-filter-options advanced-filter-option-container"
                    data-index="3">
                    <div class="d-flex w-100 px-2 pb-2" style="gap: 0.5%">
                        <div style="flex: 0.3">
                            <input id="maximumRecords" type="number" class="form-control search-value"
                                placeholder="Maximum Records (1000)">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="applySearch" class="btn btn-success">Apply Search</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/OrderPembelian/HistoryPembelianMaster/HistoryPembelianMaster.js') }}"></script>
@endsection
