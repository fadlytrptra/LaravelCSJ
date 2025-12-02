@extends('layouts.appOrderPembelian')
@section('content')
@section('title', 'Cancel PO')
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
                <div class="card font-weight-bold">
                    <div class="card-header">Cancel PO</div>
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
                                                    <select name="select_supplier" id="select_supplier" class="form-control font-weight-bold"
                                                        disabled>
                                                        <option class="w-100 text-center" selected disabled>-- Pilih
                                                            Supplier --
                                                        </option>
                                                        @foreach ($sup as $bttb)
                                                            <option value="{{ $bttb->NO_SUP }}">{{ $bttb->NM_SUP }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="row align-items-center">
                                                <div class="col-4 col-md-2">
                                                    <label for="noPO">No. PO</label>
                                                </div>
                                                <div class="col-8 col-md-10">
                                                    <input type="text" name="select_noPO" id="select_noPO"
                                                        class="form-control font-weight-bold">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="div_tablePO" class="acs-form3">
                                <table id="tableharga" class="table table-bordered"
                                    style="width:100%;white-space: nowrap">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>No. Order</th>
                                            <th>Kode Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Sub Kategori</th>
                                            <th>Qty Ordered</th>
                                            <th>Satuan</th>
                                            <th>Qty Received</th>
                                            <th>Qty Remaining</th>
                                            <th>Qty Cancel</th>
                                            <th>Status Beli</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                            <div class="row">
                                <div class="col-12 mb-2">
                                    <div class="row align-items-center">
                                        <div class="col-4 col-md-2">
                                            <label for="no_po">Nomor Order</label>
                                        </div>
                                        <div class="col-8 col-md-10">
                                            <input type="text" name="no_po" id="no_po" class="form-control font-weight-bold"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="row align-items-center">
                                        <div class="col-4 col-md-2">
                                            <label for="kd_barang">Kode Barang</label>
                                        </div>
                                        <div class="col-8 col-md-10">
                                            <input type="text" name="kd_barang" id="kd_barang" class="form-control font-weight-bold"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="row align-items-center">
                                        <div class="col-4 col-md-2">
                                            <label for="nama_barang">Nama Barang</label>
                                        </div>
                                        <div class="col-8 col-md-10">
                                            <input type="text" name="nama_barang" id="nama_barang" class="form-control font-weight-bold"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="row align-items-center">
                                        <div class="col-4 col-md-2">
                                            <label for="subkategori">Sub Kategori</label>
                                        </div>
                                        <div class="col-8 col-md-10">
                                            <input type="text" name="subkategori" id="subkategori" class="form-control font-weight-bold"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <div class="row align-items-center">
                                                <div class="col-4">
                                                    <label for="qty_ordered">Qty Ordered</label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" name="qty_ordered" id="qty_ordered"
                                                        class="form-control font-weight-bold" readonly>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row align-items-center">
                                                <div class="col-4 ">
                                                    <label for="qty_remaining">Qty Remaining</label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" name="qty_remaining" id="qty_remaining"
                                                        class="form-control font-weight-bold" readonly>
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
                                                    <label for="qty_received">Qty Received</label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" name="qty_received" id="qty_received"
                                                        class="form-control font-weight-bold" readonly>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row align-items-center">
                                                <div class="col-4 ">
                                                    <label for="qty_cancel">Qty Cancel</label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" name="qty_cancel" id="qty_cancel"
                                                        class="form-control font-weight-bold" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-9">
                                    <div class="row align-items-center">
                                        <div class="col-4 col-md-2">
                                            <label for="alasan_cancel">Alasan Cancel</label>
                                        </div>
                                        <div class="col-8 col-md-10">
                                            <input type="text" name="alasan_cancel" id="alasan_cancel"
                                                class="form-control font-weight-bold">
                                        </div>
                                    </div>
                                    <div class="col-md-12 d-flex justify-content-end pb-4">
                                        <button type="button" class="btn btn-danger mt-2 mr-3 mb-6" id="removebutton">
                                            Close</button>
                                        <button type="button" class="btn btn-danger mt-2 mr-3 mb-6" id="buttoncancel">
                                            Cancel PO</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script src="{{ asset('js/OrderPembelian/CancelPO.js') }}"></script>
        @endsection
