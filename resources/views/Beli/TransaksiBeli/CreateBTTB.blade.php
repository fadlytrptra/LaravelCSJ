@extends('layouts.appOrderPembelian')
@section('content')
@section('title', 'Create BTTB')
<link href="{{ asset('css/CreateBTTB.css') }}" rel="stylesheet">
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
                <div class="card-header font-weight-bold">Create BTTB</div>
                <div class="card-body font-weight-bold">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <label for="nobttb" class="form-label font-weight-bold">No. BTTB</label>
                            <input name="nobttb" class="form-control font-weight-bold" id="nobttb" readonly>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label for="nosj" class="form-label font-weight-bold">No. SJ</label>
                            <input type="text" class="form-control font-weight-bold" id="nosj" name="nosj">
                        </div>
                        <div class="col-md-3 mb-2">
                            <label for="sppb" class="form-label font-weight-bold">No. SPPB BC</label>
                            <input type="text" class="form-control font-weight-bold" id="sppb" name="sppb">
                        </div>
                        <div class="col-md-3 mb-2">
                            <label for="registrasi" class="form-label font-weight-bold">No. Registrasi</label>
                            <input type="text" class="form-control font-weight-bold" id="registrasi"
                                name="registrasi">
                        </div>
                        <div class="col-md-3 mb-2">
                            <label for="tglbttb" class="form-label font-weight-bold">Tanggal BTTB</label>
                            <input type="date" class="form-control font-weight-bold" id="tglbttb" name="tglbttb"
                                value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-3 mb-2">
                            <label for="nopib" class="form-label font-weight-bold">No. PIB Kerta</label>
                            <input type="text" class="form-control font-weight-bold" id="nopib" name="nopib">
                        </div>
                        <div class="col-md-3 mb-2">
                            <label for="tglsppb" class="form-label font-weight-bold">Tanggal SPPB BC</label>
                            <input type="date" class="form-control font-weight-bold" id="tglsppb" name="tglsppb"
                                value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-3 mb-2">
                            <label for="tglregis" class="form-label font-weight-bold">Tanggal Rgistrasi</label>
                            <input type="date" class="form-control font-weight-bold" id="tglregis" name="tglregis"
                                value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-3 mb-2">
                            <label for="supplier" class="form-label font-weight-bold">Supplier</label>
                            <select class="form-control font-weight-bold" id="supplier" name="supplier" disabled>
                                <option selected disabled>-- Pilih Supplier --</option>
                                @foreach ($nosup as $bttb)
                                    <option value="{{ $bttb->NO_SUP }}">{{ $bttb->NM_SUP }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label for="nopibext" class="form-label font-weight-bold">No. PIB Aju</label>
                            <input type="text" class="form-control font-weight-bold" id="nopibext" name="nopibext">
                        </div>
                        <div class="col-md-3 mb-2">
                            <label for="skbm" class="form-label font-weight-bold">No. SKBM</label>
                            <input type="text" class="form-control font-weight-bold" id="skbm" name="skbm">
                        </div>
                        <div class="col-md-3 mb-2">
                            <label for="kodehs" class="form-label font-weight-bold">Kode HS</label>
                            <input type="text" class="form-control font-weight-bold" id="kodehs" name="kodehs">
                        </div>
                        <div class="col-md-3">
                            <label for="po" class="form-label font-weight-bold">No. PO</label>
                            <input type="text" class="form-control font-weight-bold" id="po"
                                name="po">
                        </div>
                        <div class="col-md-3">
                            <label for="tglpib" class="form-label font-weight-bold">Tanggal PIB</label>
                            <input type="date" class="form-control font-weight-bold" id="tglpib"
                                name="tglpib" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="tglskbm" class="form-label font-weight-bold">Tanggal SKBM</label>
                            <input type="date" class="form-control font-weight-bold" id="tglskbm"
                                name="tglskbm" value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="table-responsive">
                            <table class="mx-auto table table-bordered" id="tabelcreate" style="white-space: nowrap">
                                <thead class="table-primary">
                                    <tr>
                                        <th>No Order</th>
                                        <th>Kd Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Sub Kategori</th>
                                        <th>Qty</th>
                                        <th>Satuan</th>
                                        <th>Qty Shipped</th>
                                        <th>Qty Remaining</th>
                                        <th>Harga Unit</th>
                                        <th>Subtotal</th>
                                        <th>DPP</th>
                                        <th>PPN</th>
                                        <th>Harga Total</th>
                                        <th>Kurs</th>
                                        <th>IDR Unit</th>
                                        <th>IDR SubTotal</th>
                                        <th>IDR DPP</th>
                                        <th>IDR PPN</th>
                                        <th>IDR total</th>
                                        <th>Mata Uang</th>
                                        <th>Disc</th>
                                        <th>Disc Harga</th>
                                        <th>Disc IDR</th>
                                        <th>Qty Received</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="col-12 mb-2">
                                <div class="row align-items-center">
                                    <div class="col-4">
                                        <label class="font-weight-bold" for="no_po">Nomor Order</label>
                                    </div>
                                    <div class="col-8 col-md-6">
                                        <input type="text" name="no_po" id="no_po"
                                            class="form-control font-weight-bold" readonly>
                                    </div>

                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="row align-items-center">
                                    <div class="col-4">
                                        <label class="font-weight-bold" for="kode_barang">Kode Barang</label>
                                    </div>
                                    <div class="col-8 col-md-6">
                                        <input type="text" name="kode_barang" id="kode_barang"
                                            class="form-control font-weight-bold" readonly>

                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="row align-items-center">
                                    <div class="col-4">
                                        <label class="font-weight-bold" for="nama_barang">Nama Barang</label>
                                    </div>
                                    <div class="col-8 col-md-6">
                                        <input type="text" name="nama_barang" id="nama_barang"
                                            class="form-control font-weight-bold" readonly>

                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="row align-items-center">
                                    <div class="col-4">
                                        <label class="font-weight-bold" for="sub_kategori">Sub Kategori</label>
                                    </div>
                                    <div class="col-8 col-md-6">
                                        <input type="text" name="sub_kategori" id="sub_kategori"
                                            class="form-control font-weight-bold" readonly>

                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="row align-items-center">
                                    <div class="col-4">
                                        <label class="font-weight-bold" for="qty_ordered">QTY Ordered</label>
                                    </div>
                                    <div class="col-6 col-md-4">
                                        <input type="text" name="qty_ordered" id="qty_ordered"
                                            class="form-control font-weight-bold" readonly>
                                    </div>
                                    <div class="col-2">
                                        <input type="text" name="ordered_satuan" id="ordered_satuan"
                                            class="form-control font-weight-bold" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="row align-items-center">
                                    <div class="col-4">
                                        <label class="font-weight-bold" for="qty_ship">QTY Shipped</label>
                                    </div>
                                    <div class="col-8 col-md-6">
                                        <input type="text" name="qty_ship" id="qty_ship"
                                            class="form-control font-weight-bold" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="row align-items-center">
                                    <div class="col-4">
                                        <label class="font-weight-bold" for="qty_received">QTY Receive</label>
                                    </div>
                                    <div class="col-8 col-md-6 d-flex align-items-center">
                                        <input type="text" name="qty_received" id="qty_received"
                                            class="form-control font-weight-bold me-2">
                                        <button type="button" class="btn btn-warning" id="btn_toleransi">Set
                                            Toleransi</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="row align-items-center">
                                    <div class="col-4">
                                        <label class="font-weight-bold" for="qty_remaining">QTY Remaining</label>
                                    </div>
                                    <div class="col-8 col-md-6">
                                        <input type="text" name="qty_remaining" id="qty_remaining"
                                            class="form-control font-weight-bold" readonly>
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
                                                <label class="font-weight-bold" for="kurs">Kurs</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="text" name="kurs" id="kurs"
                                                    class="form-control font-weight-bold" value="1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-4">
                                                <label class="font-weight-bold" for="mata_uang">Mata Uang</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="text" name="mata_uang" id="mata_uang"
                                                    class="form-control font-weight-bold" value="IDR" readonly>
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
                                                <label class="font-weight-bold" for="harga_unit">Harga Unit</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="text" name="harga_unit" id="harga_unit"
                                                    class="form-control font-weight-bold" value="0">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-4">
                                                <label class="font-weight-bold" for="idr_unit">IDR Unit</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="text" name="idr_unit" id="idr_unit"
                                                    class="form-control font-weight-bold" value="0" readonly>
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
                                                <label class="font-weight-bold" for="disc">Disc %</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="text" name="disc" id="disc"
                                                    class="form-control font-weight-bold" value="0">
                                                <input type="text" name="total_disc" id="total_disc"
                                                    class="form-control font-weight-bold" value="0">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-4">
                                                <label class="font-weight-bold" for="idr_total_disc">Idr
                                                    Discount</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="text" name="idr_total_disc" id="idr_total_disc"
                                                    class="form-control font-weight-bold" value="0" readonly>
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
                                                <label class="font-weight-bold" for="harga_sub_total">Harga Sub
                                                    Total</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="text" name="harga_sub_total" id="harga_sub_total"
                                                    class="form-control font-weight-bold" value="0" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-4">
                                                <label class="font-weight-bold" for="idr_sub_total">IDR Sub
                                                    Total</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="text" name="idr_sub_total" id="idr_sub_total"
                                                    class="form-control font-weight-bold" value="0" readonly>
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
                                                <label class="font-weight-bold" for="dpp_nilaiLain">DPP Nilai
                                                    Lain</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="text" name="dpp_nilaiLain" id="dpp_nilaiLain"
                                                    class="form-control font-weight-bold" value="0" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-4">
                                                <label class="font-weight-bold" for="idr_dpp">IDR DPP</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="text" name="idr_dpp" id="idr_dpp"
                                                    class="form-control font-weight-bold" value="0" readonly>
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
                                                <label class="font-weight-bold" for="ppn">PPN %</label>
                                            </div>
                                            <div class="col-8">
                                                <select name="ppn_select" id="ppn_select" class="w-100 input">
                                                    <option class="w-100" selected disabled></option>
                                                    @foreach ($ppn as $data)
                                                        <option value="{{ $data->IdPPN }}">
                                                            {{ number_format($data->JumPPN, 5) }}
                                                            @if ($data->IdPPN == 6)
                                                                (Tidak Pakai PPN)
                                                            @elseif ($data->IdPPN == 16)
                                                                (PPN Impor)
                                                            @elseif ($data->IdPPN == 17)
                                                                (Barang Mewah)
                                                            @elseif ($data->IdPPN == 19)
                                                                (DPP FULL)
                                                            @endif
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="ppn_persen" id="ppn_persen">
                                                <input type="text" name="ppn" id="ppn"
                                                    class="form-control font-weight-bold" value="0" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-4">
                                                <label class="font-weight-bold" for="idr_ppn">IDR PPN</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="text" name="idr_ppn" id="idr_ppn"
                                                    class="form-control font-weight-bold" value="0" readonly>
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
                                                <label class="font-weight-bold" for="harga_total">Harga Total</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="text" name="harga_total" id="harga_total"
                                                    class="form-control font-weight-bold" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-4">
                                                <label class="font-weight-bold" for="idr_harga_total">IDR
                                                    Total</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="text" name="idr_harga_total" id="idr_harga_total"
                                                    class="form-control font-weight-bold" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-12 d-flex justify-content-end pb-4">
                            <div class="col-md-12 d-flex justify-content-end">
                                <button type="button" class="btn btn-info" id="btn_update">Update</button>
                                <button type="button" class="btn btn-danger" id="btn_remove">Remove</button>
                                <button type="button" class="btn btn-success" id="post_btn">Post BTTB</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/OrderPembelian/CreateBTTB/CreateBTTB.js') }}"></script>
@endsection
