@extends('layouts.appOrderPembelian')
@section('content')
@section('title', 'Review PO')
    <link href="{{ asset('css/CreateSPPB.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/PrintSPPB.css') }}" rel="stylesheet">
    <head>
    <link href="{{ asset('css/PrintSPPB.css') }}" rel="stylesheet">

    </head>
    <script>
        let loadPermohonanData = {!! json_encode($loadPermohonan) !!};
        let loadHeaderData = {!! json_encode($loadHeader) !!};
        let No_PO = {!! json_encode($No_PO) !!};
    </script>
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
                    <div class="card-header">Review PO</div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-6 col-xl-4">
                                <div class="row align-items-center">
                                    <div class="col-2">
                                        <label for="nomor_purchaseOrder">No. PO</label>
                                    </div>
                                    <div class="col-10">
                                        <input type="text" name="nomor_purchaseOrder" id="nomor_purchaseOrder"
                                            class="form-control font-weight-bold" value="{{ $No_PO }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-xl-4">
                                <div class="row align-items-center">
                                    <div class="col-2">
                                        <label for="supplier">Supplier</label>
                                    </div>
                                    <div class="col-10">
                                        <input type="text" name="supplier_select" id="supplier_select" readonly
                                            class="form-control font-weight-bold">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-xl-4">
                                <div class="row align-items-center">
                                    <div class="col-2">
                                        <label for="paymentTerm">Payment Term</label>

                                    </div>
                                    <div class="col-10">
                                        <input type="text" name="paymentTerm_select" id="paymentTerm_select"
                                            class="form-control font-weight-bold" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-xl-4">
                                <div class="row align-items-center">
                                    <div class="col-2">
                                        <label for="tanggal_mohonKirim">Tanggal Mohon Kirim</label>
                                    </div>
                                    <div class="col-10">
                                        <input type="date" name="tanggal_mohonKirim" id="tanggal_mohonKirim"
                                            class="form-control font-weight-bold">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-xl-4">
                                <div class="row align-items-center">
                                    <div class="col-2">
                                        <label for="tanggal_purchaseOrder">Tanggal PO</label>
                                    </div>
                                    <div class="col-10">
                                        <input type="date" name="tanggal_purchaseOrder" id="tanggal_purchaseOrder"
                                            class="form-control font-weight-bold">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-xl-4">
                                <div class="row align-items-center">
                                    <div class="col-2">
                                        <label for="mata_uang">Mata Uang</label>

                                    </div>
                                    <div class="col-10">
                                        <input type="text" name="matauang_select" id="matauang_select"
                                        class="form-control font-weight-bold" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="div_tablePO" class="acs-form-table">
                            <table id="table_CreatePurchaseOrder" class="table table-bordered"
                                style="width:100%;white-space: nowrap">
                                <thead class="table-primary">
                                    <tr>
                                        <th>No Order</th>
                                        <th>Kd. Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Sub Kategori</th>
                                        <th>Ket. Order</th>
                                        <th>Ket. Internal</th>
                                        <th>User</th>
                                        <th>Qty</th>
                                        <th>Satuan</th>
                                        <th>Qty Delay</th>
                                        <th>Harga Unit</th>
                                        <th>Sub Total</th>
                                        <th>PPN</th>
                                        <th>Harga Total</th>
                                        <th>Kurs</th>
                                        <th>IDR Unit</th>
                                        <th>IDR Subtotal</th>
                                        <th>IDRPPN</th>
                                        <th>IDRTotal</th>
                                        <th>Disc (%)</th>
                                        <th>Discount</th>
                                        <th>Disc. IDR</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <button class="btn btn-success" id="btn_post">Print</button>

                            </div>
                        </div>
                        <div id="printContent"></div>
                    </div>
                </div>
            </div>
            <script src="{{ asset('js/OrderPembelian/ReviewPO/ReviewPO.js') }}"></script>
        @endsection
