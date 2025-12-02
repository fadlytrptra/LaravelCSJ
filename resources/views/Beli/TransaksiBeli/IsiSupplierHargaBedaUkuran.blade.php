@extends('layouts.appOrderPembelian')
@section('content')
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
                <div class="card">
                    <div class="card-header">Isi Supplier - Harga</div>
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
                                                class="input col-12 col-xl-3">
                                            <div class="col-xl-2">
                                                <input type="radio" name="filter_radioButton" id="filter_radioButtonUser"
                                                    value="User" class="radio-button">
                                                User
                                            </div>
                                            <input type="text" name="search_User" id="user"
                                                class="input col-12 col-xl-3">
                                        </div>

                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-success w-100" id="button_redisplay">Redisplay</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="div_tablePO" class="acs-form3">
                            <table id="table_IsiHarga" class="table table-bordered" style="width:100%">
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
                                        <th>Tgl. Dibutuhkan</th>
                                        <th>Ket. Order</th>
                                        <th>Ket. Internal</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4" id="formApprove">
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
                                        <label for="status_beli">Status Beli</label>
                                        <div class="row align-items-center">
                                            <div class="col-6">
                                                <input type="radio" name="status_beliRadioButton"
                                                    id="status_beliPengadaanPembelian" class="input" disabled checked>Pengadaan
                                                Pembelian
                                            </div>
                                            <div style="col-6">
                                                <input type="radio" name="status_beliRadioButton"
                                                    id="status_beliBeliSendiri" class="input" disabled>Beli Sendiri
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="row align-items-center">
                                            <div class="col-4">
                                                <label for="tanggal_dibutuhkan">Tanggal Dibutuhkan</label>
                                            </div>
                                            <div class="col-8 col-md-6">
                                                <input type="date" name="tanggal_dibutuhkan" id="tanggal_dibutuhkan"
                                                    class="form-control" readonly>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="row align-items-center">
                                            <div class="col-4">
                                                <label for="divisi">Divisi</label>
                                            </div>
                                            <div class="col-8 col-md-6">
                                                <input type="text" name="divisi" id="divisi" class="form-control"
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
                                                <input type="text" name="kode_barang" id="kode_barang"
                                                    class="form-control" readonly>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="row align-items-center">
                                            <div class="col-4">
                                                <label for="nama_barang">Nama Barang</label>
                                            </div>
                                            <div class="col-8 col-md-6">
                                                <input type="text" name="nama_barang" id="nama_barang"
                                                    class="form-control" readonly>

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
                                                <label for="user_input">User</label>
                                            </div>
                                            <div class="col-8 col-md-6">
                                                <input type="text" name="user_input" id="user_input"
                                                    class="form-control" readonly>
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
                                            <div class="col-4 col-md-2">
                                                <label for="supplier">Supplier</label>
                                            </div>
                                            <div class="col-8 col-md-10">
                                                <select name="supplier_select" id="supplier_select" class="w-100 input">
                                                    <option class="w-100" selected disabled>-- Pilih Supplier --</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="row align-items-center">
                                            <div class="col-4 col-md-2">
                                                <label for="mata_uang">Mata Uang</label>
                                            </div>
                                            <div class="col-8 col-md-10">
                                                <select name="matauang_select" id="matauang_select" class="w-100 input" disabled>
                                                    <option class="w-100" selected disabled>-- Pilih Mata Uang --</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="row align-items-center">
                                            <div class="col-4 col-md-2">
                                                <label for="kurs">Kurs</label>
                                            </div>
                                            <div class="col-8 col-md-10">
                                                <input type="text" name="kurs" id="kurs" class="form-control"
                                                    value="1">
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
                                    <div class="col-12 mb-2">
                                        <div class="row align-items-center">
                                            <div class="col-4 col-md-2">
                                                <label for="alasan_reject">Alasan Reject</label>
                                            </div>
                                            <div class="col-8 col-md-10">
                                                <textarea rows="4" type="text" name="alasan_reject" id="alasan_reject"
                                                    class="form-control"></textarea>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-success" id="btn_approve">Approve</button>
                                    <button class="btn btn-info" id="btn_clear">Clear</button>
                                    <button class="btn btn-danger" id="btn_reject">Reject</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/OrderPembelian/IsiSupplierHarga.js') }}"></script>
@endsection
