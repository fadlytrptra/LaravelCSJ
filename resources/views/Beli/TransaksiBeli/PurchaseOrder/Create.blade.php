@extends('layouts.appOrderPembelian')
@section('content')
@section('title', 'Create PO')
    <link href="{{ asset('css/CreatePurchaseOrder.css') }}" rel="stylesheet">
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
                    <div class="card-header">Daftar Order</div>
                    <div class="card-body">
                        <div class="row px-2 px-md">
                            <div class="col-md-4 h-auto mb-4 mb-md-0">
                                <div class="w-100 h-auto">
                                    <input type="radio" name="filter_radioButton" id="filter_radioButton1" value="Divisi"
                                        class="radio-button" checked>Divisi
                                </div>
                                <div class="w-100 col-12 rounded align-items-center pb-2" style="border: 0.5px solid grey"
                                    id="filter_radioButtonDivisiDiv">
                                    <div class="row">
                                        <div class="col-xxl-6">
                                            <input class="radio-button" type="radio" name="filter_divisiRadioButton"
                                                id="filter_divisiRadioButton1" value="PengadaanPembelian" checked>
                                            Pengadaan Pembelian

                                        </div>
                                        <div class="col-xxl-6">
                                            <input class="radio-button" type="radio" name="filter_divisiRadioButton"
                                                id="filter_divisiRadioButton2" value="Beli Sendiri">
                                            Beli Sendiri
                                        </div>
                                    </div>
                                    <select name="divisi_select" id="divisi_select" class="input w-100">
                                        <option value="ALL">ALL</option>
                                        @foreach ($divisi as $data)
                                            <option value="{{ $data->KD_DIV }}">{{ trim($data->NM_DIV) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 h-auto mb-4 mb-md-0">
                                <div class="w-100 h-auto">
                                    <input type="radio" name="filter_radioButton" id="filter_radioButton2" value="User"
                                        class="radio-button">User
                                </div>
                                <input class="w-100 font-weight-bold" type="text" name="filter_radioButtonUserInput"
                                    id="filter_radioButtonUserInput">
                            </div>
                            <div class="col-md-3 h-auto mb-4 mb-md-0">
                                <div class="w-100 h-auto">
                                    <input type="radio" name="filter_radioButton" id="filter_radioButton3" value="Order"
                                        class="radio-button"> Order
                                </div>
                                <input class="w-100 font-weight-bold" type="text" name="filter_radioButtonOrderInput"
                                    id="filter_radioButtonOrderInput">
                            </div>
                            <div class="w-auto h-auto pt-3 pl-2 pl-md-0">
                                <div class="">
                                    <input type="checkbox" id="check_nyantol">
                                    <label for="">No. Order Nyantol</label>
                                </div>
                                <button class="btn btn-info" id="redisplay"
                                    style="display: block">Redisplay</button>
                            </div>
                        </div>
                        <div id="div_tablePO" class="acs-form3">
                            <table id="table_PurchaseOrder" class="table table-bordered" style="width:100%;white-space: nowrap">
                                <thead class="table-primary">
                                    <tr>
                                        <th><input type="checkbox" name="CheckedAll"
                                                id="CheckedAll" class="RDZCheckBoxSize"></th>
                                        <th>Supplier</th>
                                        <th>Id_Div</th>
                                        <th>User</th>
                                        <th>Status Beli</th>
                                        <th>Nomor Order</th>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Sub Kategori</th>
                                        <th>Qty</th>
                                        <th>Satuan</th>
                                        <th>Harga Unit</th>
                                        <th>Sub Total</th>
                                        <th>PPN</th>
                                        <th>Harga Total</th>
                                        <th>Currency</th>
                                        <th>Tgl. Dibutuhkan <br>(DD-MM-YYYY)</th>
                                        <th>Ket. Order</th>
                                        <th>Ket. Internal</th>
                                        <th>AppManager</th>
                                        <th>AppPBL</th>
                                        <th>AppDireksi <br>(DD-MM-YYYY HH:MM:SS)</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <div class="">
                            <p id="checkedCount">Jumlah Data Yang TerCentang 0</p>
                        </div>
                        <div class="button-align-right">
                            <div style="display: block">
                                <div class="">
                                    <button class="btn btn-danger" id="btn_close">Close Order</button>
                                </div>
                            </div>

                            <form action="{{ url('openFormCreateSPPB/create') }}" id="form_createSPPB" method="GET">
                                <button class="btn btn-success" id="create_po">Create PO</button>
                            </form>
                            <div class="" id="backGroup">
                                <button class="btn btn-danger" id="btn_backCreatePO">Back Create PO</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ asset('js/OrderPembelian/CreatePurchaseOrder/CreatePurchaseOrder.js') }}"></script>
    @endsection
