@extends('layouts.appOrderPembelian')
@section('content')
    <div class="container-fluid ">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('css/ListOrderPembelian.css') }}" rel="stylesheet">

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
                <div class="card">
                    <div class="card-header">Input Bea</div>
                    <div class="card-body">
                        <div class="w-100 h-auto">
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <div class="row">
                                        <div class="col-6 ">
                                            <div class="row align-items-center">
                                                <div class="col-4 col-md-2">
                                                    <label for="supplier">Supplier</label>
                                                </div>
                                                <div class="col-8 col-md-10">
                                                    <select name="select_supplier" id="select_supplier" class="input w-100">
                                                        <option class="w-100 text-center" selected disabled>-- Pilih
                                                            Supplier --
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="row align-items-center">
                                                <div class="col-4 col-md-2">
                                                    <label for="noPO">No. PIB Ext</label>
                                                </div>
                                                <div class="col-8 col-md-10">
                                                    <select name="select_noPO" id="select_noPO" class="input w-100">
                                                        <option class="w-100">
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="div_tablePO" class="acs-form3">
                                <table id="tableharga" class="table table-bordered table-striped scrollmenu"
                                    style="width:100%">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>kd. Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Qty Rcv</th>
                                            <th>Satuan</th>
                                            <th>Valuta</th>
                                            <th>Nilai PIB</th>
                                            <th>Kurs PIB</th>
                                            <th>Nilai Pabean</th>
                                            <th>Nilai BM</th>
                                            <th>Nilai BM KITE</th>
                                            <th>PPN PIB</th>
                                            <th>PPH22</th>
                                            <th>Total PIB</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                            <div class="row">
                                <div class="col-12 mb-2">
                                    <div class="row align-items-center">
                                        <div class="col-4 col-md-2">
                                            <label for="no_po">Kd. Barang</label>
                                        </div>
                                        <div class="col-8 col-md-10">
                                            <input type="text" name="no_po" id="no_po" class="input w-100"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="row align-items-center">
                                        <div class="col-4 col-md-2">
                                            <label for="kd_barang">Nama Barang</label>
                                        </div>
                                        <div class="col-8 col-md-10">
                                            <input type="text" name="kd_barang" id="kd_barang" class="input w-100"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="row align-items-center">
                                        <div class="col-4 col-md-2">
                                            <label for="nama_barang">Qty Receive</label>
                                        </div>
                                        <div class="col-8 col-md-10">
                                            <input type="text" name="nama_barang" id="nama_barang" class="input w-100"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="row align-items-center">
                                        <div class="col-4 col-md-2">
                                            <label for="subkategori">Valuta</label>
                                        </div>
                                        <div class="col-8 col-md-10">
                                            <input type="text" name="subkategori" id="subkategori" class="input w-100"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <div class="row align-items-center">
                                                <div class="col-4">
                                                    <label for="qty_ordered">Nilai PIB</label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" name="qty_ordered" id="qty_ordered"
                                                        class="input w-100" readonly>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row align-items-center">
                                                <div class="col-4 ">
                                                    <label for="qty_remaining">Kurs PIB</label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" name="qty_remaining" id="qty_remaining"
                                                        class="input w-100" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <div class="row align-items-center">
                                                <div class="col-4">
                                                    <label for="qty_received">Nilai Pabean</label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" name="qty_received" id="qty_received"
                                                        class="input w-100" readonly>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row align-items-center">
                                                <div class="col-4 ">
                                                    <label for="qty_cancel">Nilai BM</label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" name="qty_cancel" id="qty_cancel"
                                                        class="input w-100" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-9">
                                    <div class="row align-items-center">
                                        <div class="col-4 col-md-2">
                                            <label for="alasan_cancel">Nilai BM KITE</label>
                                        </div>
                                        <div class="col-8 col-md-10">
                                            <input type="text" name="alasan_cancel" id="alasan_cancel"
                                                class="input w-100" readonly>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <button type="button" class="btn btn-primary btn-block"
                                                    id="updateButton">Update</button>
                                            </div>
                                            <div class="col-md-6">
                                                <button type="button" class="btn btn-secondary btn-block"
                                                    id="clearButton">Clear</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script src="{{ asset('js/OrderPembelian/IsiBea.js') }}"></script>
        @endsection
