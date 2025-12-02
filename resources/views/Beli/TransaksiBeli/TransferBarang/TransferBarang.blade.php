@extends('layouts.appOrderPembelian')
@section('content')
@section('title', 'Transfer Barang')
    <link href="{{ asset('css/TransferBarang.css') }}" rel="stylesheet">
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
                    <div class="card-header">Transfer Barang</div>
                    <div class="card-body">
                        <div class="row" id="formCekRedisplay">
                            <div class="col-md-5 mt-2">
                                <div class="row align-items-center">
                                    <div class="pl-3">
                                        <input type="radio" name="filter_radioButton" id="filter_radioButtonDivisi"
                                            value="Divisi" class="radio-button" checked>
                                        Divisi
                                    </div>
                                    <div class="col-xl-12">
                                        <select name="select_divisi" id="select_divisi" class="input w-100 font-weight-bold">
                                            <option class="w-100 text-center" value="ALL" selected>ALL
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 mt-2">
                                <div class="row align-items-center">
                                    <div class="pl-3">
                                        <input type="radio" name="filter_radioButton" id="filter_radioButtonNoBTTB"
                                            value="NoBTTB" class="radio-button">
                                        No BTTB
                                    </div>
                                    <div class="col-xl-12">
                                        <input type="text" name="no_bttb" id="no_bttb" class="input w-100 font-weight-bold">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="col-4 col-md-12 p-0">
                                    <input type="checkbox" class="input" id="check_koreksi">
                                    <label for="spek">Koreksi</label>
                                </div>
                                <div class="col-4 col-md-12 p-0">
                                    <button class="btn btn-info w-100" id="button_redisplay">Redisplay</button>
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                <table id="table_trasferBarang" class="table table-bordered" style="width:100%;white-space: nowrap;">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>No. PO</th>
                                            <th>No. BTTB</th>
                                            <th>Supplier</th>
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
        <script src="{{ asset('js/OrderPembelian/TransferBarang.js') }}"></script>
    @endsection
