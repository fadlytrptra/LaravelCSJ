@extends('layouts.appOrderPembelian')
@section('content')
    <link href="{{ asset('css/CreateSPPB.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/PrintSPPB.css') }}" rel="stylesheet">
    <head>
    <link href="{{ asset('css/PrintSPPB.css') }}" rel="stylesheet">

    </head>
    <script>
        let loadPermohonanData = {!! json_encode($loadPermohonan) !!};
        let loadHeaderData = {!! json_encode($loadHeader) !!};
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
                <div class="card">
                    <div class="card-header">Create Purchase Order</div>
                    <div class="card-body">
                        <input type="text" value="{{trim($namaDiv[0]->NM_DIV)}}" name="" id="nmDiv" style="display: none">
                        <div class="row align-items-center">
                            <div class="col-6 col-xl-4">
                                <div class="row align-items-center">
                                    <div class="col-2">
                                        <label for="nomor_purchaseOrder">No. PO</label>
                                    </div>
                                    <div class="col-10">
                                        <input type="text" name="nomor_purchaseOrder" id="nomor_purchaseOrder"
                                            class="form-control" value="{{ $No_PO }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-xl-4">
                                <div class="row align-items-center">
                                    <div class="col-2">
                                        <label for="supplier">Supplier</label>
                                    </div>
                                    <div class="col-10">
                                        <select class="form-control" name="supplier_select" id="supplier_select" disabled>
                                            <option selected disabled>-- Pilih Supplier --</option>
                                            @foreach ($supplier as $data)
                                                <option value="{{ $data->NO_SUP }}">{{ $data->NM_SUP }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-xl-4">
                                <div class="row align-items-center">
                                    <div class="col-2">
                                        <label for="paymentTerm">Payment Term</label>

                                    </div>
                                    <div class="col-10">
                                        <select class="form-control" name="paymentTerm_select" id="paymentTerm_select">
                                            <option selected disabled>-- Choose Payment Term --</option>
                                            @foreach ($listPayment as $data)
                                                <option value="{{ $data->Kode }}">{{ $data->Pembayaran }}</option>
                                            @endforeach
                                        </select>
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
                                            class="form-control">
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
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-xl-4">
                                <div class="row align-items-center">
                                    <div class="col-2">
                                        <label for="mata_uang">Mata Uang</label>

                                    </div>
                                    <div class="col-10">
                                        <select class="form-control" name="matauang_select" id="matauang_select" disabled>
                                            <option selected disabled>-- Pilih Mata Uang --</option>
                                            @foreach ($mataUang as $data)
                                                <option value="{{ $data->Id_MataUang }}">{{ $data->Nama_MataUang }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="div_tablePO" class="acs-form-table">
                            <table id="table_CreatePurchaseOrder" class="table table-bordered"
                                style="width:100%">
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-12 mb-2">
                                    <div class="row align-items-center">
                                        <div class="col-4">
                                            <label for="no_po">Nomor Order</label>
                                        </div>
                                        <div class="col-8 col-md-6">
                                            <input type="text" name="no_po" id="no_po" class="form-control"
                                                readonly>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="row align-items-center">
                                        <div class="col-4">
                                            <label for="kode_barang">Kode Barang</label>
                                        </div>
                                        <div class="col-8 col-md-6">
                                            <input type="text" name="kode_barang" id="kode_barang" class="form-control"
                                                readonly>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="row align-items-center">
                                        <div class="col-4">
                                            <label for="nama_barang">Nama Barang</label>
                                        </div>
                                        <div class="col-8 col-md-6">
                                            <input type="text" name="nama_barang" id="nama_barang" class="form-control"
                                                readonly>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="row align-items-center">
                                        <div class="col-4">
                                            <label for="sub_kategori">Sub Kategori</label>
                                        </div>
                                        <div class="col-8 col-md-6">
                                            <input type="text" name="sub_kategori" id="sub_kategori"
                                                class="form-control" readonly>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="row align-items-center">
                                        <div class="col-4">
                                            <label for="keterangan_order">Keterangan Order</label>
                                        </div>
                                        <div class="col-8 col-md-6">
                                            <input type="text" name="keterangan_order" id="keterangan_order"
                                                class="form-control" value="-" readonly>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="row align-items-center">
                                        <div class="col-4">
                                            <label for="keterangan_internal">Keterangan Internal</label>
                                        </div>
                                        <div class="col-8 col-md-6">
                                            <input type="text" name="keterangan_internal" id="keterangan_internal"
                                                class="form-control" value="-" readonly>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="row align-items-center">
                                        <div class="col-4">
                                            <label for="alasan_reject">Alasan Reject</label>
                                        </div>
                                        <div class="col-8 col-md-6">
                                            <textarea rows="4" type="text" name="alasan_reject" id="alasan_reject"
                                                class="form-control"></textarea>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-12 mb-2">
                                    <div class="row align-items-center">
                                        <div class="col-6">
                                            <div class="row">
                                                <div class="col-4">
                                                    <label for="qty_order">Qty Order</label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" name="qty_order" id="qty_order"
                                                        class="form-control" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="row">
                                                <div class="col-4">
                                                    <label for="qty_delay">Qty Delay</label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" name="qty_delay" id="qty_delay"
                                                        class="form-control" value="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="row align-items-center">
                                        <div class="col-6">
                                            <div class="row">
                                                <div class="col-4">
                                                    <label for="kurs">Kurs</label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" name="kurs" id="kurs"
                                                        class="form-control" value="1">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="row">
                                                <div class="col-4">
                                                    <label for="disc">Disc %</label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" name="disc" id="disc"
                                                        class="form-control" value="0">
                                                    <input type="text" name="total_disc" id="total_disc"
                                                        class="form-control" value="0">
                                                    <input type="text" name="idr_total_disc" id="idr_total_disc"
                                                        class="form-control" value="0" style="display: none" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="row align-items-center">
                                        <div class="col-6">
                                            <div class="row">
                                                <div class="col-4">
                                                    <label for="harga_unit">Harga Unit</label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" name="harga_unit" id="harga_unit"
                                                        class="form-control" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="row">
                                                <div class="col-4">
                                                    <label for="idr_unit">IDR Unit</label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" name="idr_unit" id="idr_unit"
                                                        class="form-control" value="0" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="row align-items-center">
                                        <div class="col-6">
                                            <div class="row">
                                                <div class="col-4">
                                                    <label for="harga_sub_total">Harga Sub Total</label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" name="harga_sub_total" id="harga_sub_total"
                                                        class="form-control" value="0" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="row">
                                                <div class="col-4">
                                                    <label for="idr_sub_total">IDR Sub Total</label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" name="idr_sub_total" id="idr_sub_total"
                                                        class="form-control" value="0" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="row align-items-center">
                                        <div class="col-6">
                                            <div class="row">
                                                <div class="col-4">
                                                    <label for="ppn">PPN %</label>
                                                </div>
                                                <div class="col-8">
                                                    <select name="ppn_select" id="ppn_select" class="w-100 input">
                                                        <option class="w-100" selected disabled></option>
                                                        @foreach ($ppn as $data)
                                                            <option value="{{ $data->IdPPN }}">{{ $data->JumPPN }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <input type="text" name="ppn" id="ppn"
                                                        class="form-control" value="0" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="row">
                                                <div class="col-4">
                                                    <label for="idr_ppn">IDR PPN</label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" name="idr_ppn" id="idr_ppn"
                                                        class="form-control" value="0" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="row align-items-center">
                                        <div class="col-6">
                                            <div class="row">
                                                <div class="col-4">
                                                    <label for="harga_total">Harga Total</label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" name="harga_total" id="harga_total"
                                                        class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="row">
                                                <div class="col-4">
                                                    <label for="idr_harga_total">IDR Total</label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" name="idr_harga_total" id="idr_harga_total"
                                                        class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-success" id="btn_update">Update</button>
                                <button class="btn btn-info" id="btn_remove" style="display: none">Remove</button>
                                <button class="btn btn-danger" id="btn_reject">Reject</button>
                                <button class="btn btn-success" id="btn_post">Post PO</button>

                            </div>
                        </div>
                        <div id="printContent"></div>
                    </div>
                </div>
            </div>
            <script src="{{ asset('js/OrderPembelian/CreateSPPB.js') }}"></script>
        @endsection
