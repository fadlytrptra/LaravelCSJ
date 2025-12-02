@extends('layouts.appOrderPembelian')
@section('content')
@section('title', 'Transfer BTTB')
<link href="{{ asset('css/TransferBarang.css') }}" rel="stylesheet">
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
<script>
    let koreksi = {!! json_encode($koreksi) !!};
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
                <div class="card-header">Transfer BTTB</div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6 col-xl-4 mb-2">
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
                        <div class="col-md-6 col-xl-4 mb-2">
                            <div class="row align-items-center">
                                <div class="col-2">
                                    <label for="No BTTB">No BTTB</label>
                                </div>
                                <div class="col-10">
                                    <input type="text" name="no_bttb" id="no_bttb"
                                        class="form-control font-weight-bold" value="{{ $No_BTTB }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-4 mb-2">
                            <div class="row align-items-center">
                                <div class="col-2">
                                    <label for="tanggal">Tanggal</label>
                                </div>
                                <div class="col-10">
                                    <input type="date" name="tanggal" id="tanggal"
                                        class="form-control font-weight-bold" value="{{ $tanggalValue }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="acs-form3">
                        <table id="table_transferBTTB" class="table table-bordered" style="width:100%">
                            <thead class="table-primary">
                                <tr>
                                    <th>No Terima</th>
                                    <th>Kategori</th>
                                    <th>Sub Kategori</th>
                                    <th>Kd Barang</th>
                                    <th>Nama Barang</th>
                                    <th>QTY Shipped</th>
                                    <th>Satuan</th>
                                    <th>No PIB</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    <div class="row mt-4" id="formContainer">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="col-12 mb-2">
                                        <div class="row align-items-center">
                                            <div class="col-4">
                                                <label for="no_terima">Nomor Terima</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="text" name="no_terima" id="no_terima"
                                                    class="form-control font-weight-bold" readonly>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="row align-items-center">
                                            <div class="col-4">
                                                <label for="kode_barang">Kode Barang</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="text" name="kode_barang" id="kode_barang"
                                                    class="form-control font-weight-bold" readonly>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="row align-items-center">
                                            <div class="col-4">
                                                <label for="nama_barang">Nama Barang</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="text" name="nama_barang" id="nama_barang"
                                                    class="form-control font-weight-bold" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="row align-items-center">
                                            <div class="col-4">
                                                <label for="no_pib">No PIB</label>
                                            </div>
                                            <div class="col-8 ">
                                                <input type="text" name="no_pib" id="no_pib"
                                                    class="form-control font-weight-bold" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-12 mb-2">
                                        <div class="row align-items-center">
                                            <div class="col-4">
                                                <label for="qty_terima">Qty Terima</label>
                                            </div>
                                            <div class="col-6">
                                                <input type="text" name="qty_terima" id="qty_terima"
                                                    class="form-control font-weight-bold" value="0" readonly>
                                            </div>
                                            <div class="col-2">
                                                <input type="text" name="ket_qtyTerima" id="ket_qtyTerima"
                                                    class="form-control font-weight-bold" value="NULL" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="row align-items-center">
                                            <div class="col-4">
                                                <label for="qty_premier">Qty Primer</label>
                                            </div>
                                            <div class="col-6">
                                                <input type="text" name="qty_premier" id="qty_premier"
                                                    value="0" class="form-control font-weight-bold" readonly>
                                            </div>
                                            <div class="col-2">
                                                <input type="text" name="ket_qtyPremier" id="ket_qtyPremier"
                                                    class="form-control font-weight-bold" value="NULL" readonly>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="row align-items-center">
                                            <div class="col-4">
                                                <label for="qty_sekunder">Qty Sekunder</label>
                                            </div>
                                            <div class="col-6">
                                                <input type="text" name="qty_sekunder" id="qty_sekunder"
                                                    value="0" class="form-control font-weight-bold" readonly>
                                            </div>

                                            <div class="col-2">
                                                <input type="text" name="ket_qtySekunder" id="ket_qtySekunder"
                                                    class="form-control font-weight-bold" value="NULL" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="row align-items-center">
                                            <div class="col-4">
                                                <label for="qty_tertier">Qty Tertier</label>
                                            </div>
                                            <div class="col-6">
                                                <input type="text" name="qty_tertier" id="qty_tertier"
                                                    value="0" class="form-control font-weight-bold" readonly>
                                            </div>
                                            <div class="col-2">
                                                <input type="text" name="ket_qtyTertier" id="ket_qtyTertier"
                                                    class="form-control font-weight-bold" value="NULL" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <div class="row align-items-center">
                                            <div class="col-4 col-md-2">
                                                <label for="divisi">Divisi</label>
                                            </div>
                                            <div class="col-6 col-md-7">
                                                {{-- <select name="divisi_select" id="divisi_select"
                                                    class="w-100 input font-weight-bold">
                                                    <option class="w-100" selected disabled></option>
                                                </select> --}}
                                                <input type="text" name="divisi_tb" id="divisi_tb"
                                                    class="form-control font-weight-bold" readonly>
                                            </div>
                                            <div class="col-1 d-flex align-items-center">
                                                <button type="button" class="btn btn-default" id="btn_divisi">...</button>
                                            </div>
                                            <div class="col-2">
                                                <input type="text" name="ket_divisi" id="ket_divisi"
                                                    class="form-control font-weight-bold" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="row align-items-center">
                                            <div class="col-4 col-md-2">
                                                <label for="objek">Objek</label>
                                            </div>

                                            <div class="col-6 col-md-7">
                                                {{-- <select name="objek_select" id="objek_select"
                                                    class="w-100 input font-weight-bold">
                                                    <option class="w-100" selected disabled></option>
                                                </select> --}}
                                                <input type="text" name="objek_tb" id="objek_tb"
                                                    class="form-control font-weight-bold" readonly>
                                            </div>
                                            <div class="col-1 d-flex align-items-center">
                                                <button type="button" class="btn btn-default" id="btn_objek">...</button>
                                            </div>
                                            <div class="col-2">
                                                <input type="text" name="ket_objek" id="ket_objek"
                                                    class="form-control font-weight-bold" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="row align-items-center">
                                            <div class="col-4 col-md-2">
                                                <label for="kelompok_utama">Kelompok Utama</label>
                                            </div>

                                            <div class="col-6 col-md-7">
                                                <input type="text" name="kelompok_utama" id="kelompok_utama"
                                                    class="form-control font-weight-bold" readonly>

                                            </div>
                                            <div class="col-1 d-flex align-items-center">
                                                <button type="button" class="btn btn-default" id="btn_kelompokUtama">...</button>
                                            </div>
                                            <div class="col-2">
                                                <input type="text" name="ket_kelompokUtama" id="ket_kelompokUtama"
                                                    class="form-control font-weight-bold" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="row align-items-center">
                                            <div class="col-4 col-md-2">
                                                <label for="kelompok">Kelompok</label>
                                            </div>

                                            <div class="col-6 col-md-7">
                                                <input type="text" name="kelompok" id="kelompok"
                                                    class="form-control font-weight-bold" readonly>

                                            </div>
                                            <div class="col-1 d-flex align-items-center">
                                                <button type="button" class="btn btn-default" id="btn_kelompok">...</button>
                                            </div>
                                            <div class="col-2">
                                                <input type="text" name="ket_kelompok" id="ket_kelompok"
                                                    class="form-control font-weight-bold" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="row align-items-center">
                                            <div class="col-4 col-md-2">
                                                <label for="sub_kelompok">Sub Kelompok</label>
                                            </div>

                                            <div class="col-6 col-md-7">
                                                <input type="text" name="sub_kelompok" id="sub_kelompok"
                                                    class="form-control font-weight-bold" readonly>
                                            </div>
                                            <div class="col-1 d-flex align-items-center">
                                                <button type="button" class="btn btn-default" id="btn_subKelompok">...</button>
                                            </div>
                                            <div class="col-2">
                                                <input type="text" name="ket_subKelompok" id="ket_subKelompok"
                                                    class="form-control font-weight-bold" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="row align-items-center">
                                            <div class="col-4 col-md-2">
                                                <label for="idType">Id Type</label>
                                            </div>

                                            <div class="col-8 col-md-7">
                                                <input type="text" name="idType" id="idType"
                                                    class="form-control font-weight-bold" readonly>
                                            </div>
                                            <div class="col-1 d-flex align-items-center">
                                                <button type="button" class="btn btn-default" id="btn_idType">...</button>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="row align-items-center">
                                            <div class="col-4 col-md-2">
                                                <label for="saldo_premier">Saldo Primer</label>
                                            </div>
                                            <div class="col-6 col-md-8">
                                                <input type="text" name="saldo_premier" id="saldo_premier"
                                                    class="form-control font-weight-bold" readonly>
                                            </div>
                                            <div class="col-2">
                                                <input type="text" name="ket_saldoPremier" id="ket_saldoPremier"
                                                    class="form-control font-weight-bold" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="row align-items-center">
                                            <div class="col-4 col-md-2">
                                                <label for="saldo_sekunder">Saldo Sekunder</label>
                                            </div>
                                            <div class="col-6 col-md-8">
                                                <input type="text" name="saldo_sekunder" id="saldo_sekunder"
                                                    class="form-control font-weight-bold" readonly>
                                            </div>
                                            <div class="col-2">
                                                <input type="text" name="ket_saldoSekunder" id="ket_saldoSekunder"
                                                    class="form-control font-weight-bold" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="row align-items-center">
                                            <div class="col-4 col-md-2">
                                                <label for="saldo_tertier">Saldo Tertier</label>
                                            </div>
                                            <div class="col-6 col-md-8">
                                                <input type="text" name="saldo_tertier" id="saldo_tertier"
                                                    class="form-control font-weight-bold" readonly>
                                            </div>
                                            <div class="col-2">
                                                <input type="text" name="ket_saldoTertier" id="ket_saldoTertier"
                                                    class="form-control font-weight-bold" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="row align-items-center">
                                            <div class="col-2">
                                                <label for="keterangan">Keterangan</label>
                                            </div>
                                            <div class="col-10 ">
                                                <input type="text" name="keterangan" id="keterangan"
                                                    class="form-control font-weight-bold">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-success" id="btn_transfer">Transfer</button>
                            <button class="btn btn-warning" id="btn_koreksi">Koreksi</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <script src="{{ asset('js/OrderPembelian/TransferBTTB.js') }}"></script>
    @endsection
