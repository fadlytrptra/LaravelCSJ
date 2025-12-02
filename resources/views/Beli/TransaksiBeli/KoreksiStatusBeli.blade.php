@extends('layouts.appOrderPembelian')
@section('content')
@section('title', 'Koreksi Status Beli')
    <link href="{{ asset('css/IsiSupplierHarga.css') }}" rel="stylesheet">
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
                <div class="card font-weight-bold">
                    <div class="card-header">Koreksi Status Beli</div>
                    <div class="card-body">
                        <div class="w-100 h-auto">
                            <div class="w-100 h-auto">
                                <label for="filter">Search by:</label>
                                <div class="row" id="formCekRedisplay">
                                    <div class="col-12 col-xl-10">
                                        <div class="row align-items-center mx-2 mb-4 " style="border: 0.5px grey solid;">
                                            <div class="col-xl-2">
                                                <input type="radio" name="filter_radioButton"
                                                    id="filter_radioButtonAllOrder" value="AllOrder" class="radio-button" checked>
                                                All Order
                                            </div>
                                            <div class="col-xl-2">
                                                <input type="radio" name="filter_radioButton"
                                                    id="filter_radioButtonNomorOrder" value="NomorOrder"
                                                    class="radio-button">
                                                No. Order
                                            </div>
                                            <input type="text" name="search_NomorOrder" id="nomor_order"
                                                class="input col-12 col-xl-3 font-weight-bold">
                                            <div class="col-xl-2">
                                                <input type="radio" name="filter_radioButton" id="filter_radioButtonUser"
                                                    value="User" class="radio-button">
                                                User
                                            </div>
                                            <input type="text" name="search_User" id="user"
                                                class="input col-12 col-xl-3 font-weight-bold">
                                        </div>

                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-info w-100" id="button_redisplay">Redisplay</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="div_tablePO" class="acs-form3">
                            <table id="table_koreksi" class="table table-bordered" style="width:100%;white-space: nowrap;">
                                <thead class="table-primary">
                                    <tr>
                                        <th>No. Order</th>
                                        <th>Status Beli</th>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Sub Kategori</th>
                                        <th>Qty</th>
                                        <th>Satuan</th>
                                        <th>User</th>
                                        <th>Id_Div</th>

                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4" id="formUpdate">
                            <div class="row">
                                <div class="col-md-4 ">
                                    <div class="col-12">
                                        <label for="no_po">Nomor Order</label>
                                    </div>
                                    <div class="col-12">
                                        <input type="text" name="no_po" id="no_po" class="form-control font-weight-bold"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-md-8 col-xl-6 ">
                                    <div class="col-12">
                                        <label for="status_beli">Status Beli</label>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-6">
                                            <input type="radio" name="status_beliRadioButton"
                                                id="status_beliPengadaanPembelian" class="input" checked>Pengadaan
                                            Pembelian
                                        </div>
                                        <div style="col-6">
                                            <input type="radio" name="status_beliRadioButton"
                                                id="status_beliBeliSendiri" class="input">Beli Sendiri
                                        </div>
                                    </div>
                                </div>

                                <div class="col-2 mt-4">
                                    <button class="btn btn-success w-100" id="btn_update">Update</button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/OrderPembelian/KoreksiStatusBeli.js') }}"></script>
@endsection
