@extends('layouts.appSales')
@section('content')
    <script>
        $(document).ready(function() {
            $('#table_Barcode').DataTable({
                order: [
                    [1, 'desc']
                ],
            });
        });
    </script>
    <link href="{{ asset('css/AccPenjualanCloth.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10 RDZMobilePaddingLR0">
                <div class="card">
                    <div class="card-header">Acc Penjualan Cloth</div>
                    <div class="card-body RDZOverflow RDZMobilePaddingLR0 acs-table-barcode" id="div_tableBarcode">
                        <table id="table_AccPenjualan" class="table table-bordered table-striped" style="width:100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Id Transaksi</th>
                                    <th>Id Type</th>
                                    <th>Nama Type</th>
                                    <th>Primer</th>
                                    <th>Sekunder</th>
                                    <th>Tritier</th>
                                    <th>Kode Barang</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    <div class="acs-div-form">
                        <div class="acs-div-form2">
                            <div class="acs-div-form3">
                                <div class="acs-div-filter1">
                                    <label for="divisi">Divisi</label>
                                    <input type="text" name="divisi" id="divisi" class="input">
                                </div>
                                <div class="acs-div-filter1">
                                    <label for="objek">Objek</label>
                                    <input type="text" name="objek" id="objek" class="input">
                                </div>
                                <div class="acs-div-filter1">
                                    <label for="kelompok_utama">Kelompok Utama</label>
                                    <input type="text" name="kelompok_utama" id="kelompok_utama" class="input">
                                </div>
                                <div class="acs-div-filter1">
                                    <label for="kelompok">Kelompok</label>
                                    <input type="text" name="kelompok" id="kelompok" class="input">
                                </div>
                                <div class="acs-div-filter1">
                                    <label for="sub_kelompok">Sub Kelompok</label>
                                    <input type="text" name="sub_kelompok" id="sub_kelompok" class="input">
                                </div>
                            </div>
                            <div class="acs-div-form3" style="border: 1px solid grey; margin:3%; padding:1%">
                                <legend>Saldo</legend>
                                <div class="acs-div-filter1">
                                    <label for="saldo_primer">Primer</label>
                                    <div style="display: flex; flex-direction: row; gap: 3%">
                                        <input type="text" name="saldo_primer" id="saldo_primer" class="input">
                                        <input type="text" name="saldo_primer" id="saldo_primer" class="input"
                                            style="width: 25%">
                                    </div>
                                </div>
                                <div class="acs-div-filter1">
                                    <label for="saldo_sekunder">Sekunder</label>
                                    <div style="display: flex; flex-direction: row; gap: 3%">
                                        <input type="text" name="saldo_sekunder" id="saldo_sekunder" class="input">
                                        <input type="text" name="saldo_sekunder" id="saldo_sekunder" class="input"
                                            style="width: 25%">
                                    </div>
                                </div>
                                <div class="acs-div-filter1">
                                    <label for="saldo_tritier">Tritier</label>
                                    <div style="display: flex; flex-direction: row; gap: 3%">
                                        <input type="text" name="saldo_tritier" id="saldo_tritier" class="input">
                                        <input type="text" name="saldo_tritier" id="saldo_tritier" class="input"
                                            style="width:25%">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="acs-div-form2">
                            <div class="acs-div-form3">
                                <div class="acs-div-filter1">
                                    <label for="divisi">Id Transaksi</label>
                                    <input type="text" name="divisi" id="divisi" class="input">
                                </div>
                                <div class="acs-div-filter1">
                                    <label for="objek">Id Type</label>
                                    <input type="text" name="objek" id="objek" class="input">
                                </div>
                                <div class="acs-div-filter1">
                                    <label for="kelompok_utama">Nama Barang</label>
                                    <input type="text" name="kelompok_utama" id="kelompok_utama" class="input">
                                </div>
                            </div>
                            <div class="acs-div-form3">
                                <div class="acs-div-filter1">
                                    <label for="kelompok">Nama Customer</label>
                                    <input type="text" name="kelompok" id="kelompok" class="input">
                                </div>
                                <div class="acs-div-filter1">
                                    <label for="sub_kelompok">No SP</label>
                                    <input type="text" name="sub_kelompok" id="sub_kelompok" class="input">
                                </div>
                                <div class="acs-div-filter1">
                                    <label for="sub_kelompok">Tanggal Mohon DO</label>
                                    <input type="date" name="sub_kelompok" id="sub_kelompok" class="input">
                                </div>
                            </div>
                            <div class="acs-div-form3"
                                style="border: 1px solid grey; margin:3%; padding:1%; width: fit-content">
                                <div class="acs-div-filter1">
                                    <label for="saldo_primer">Max DO</label>
                                    <div style="display: flex; flex-direction: row; gap: 3%">
                                        <input type="text" name="saldo_primer" id="saldo_primer" class="input">
                                        <input type="text" name="saldo_primer" id="saldo_primer" class="input"
                                            style="width: 25%">
                                    </div>
                                </div>
                                <div class="acs-div-filter1">
                                    <label for="saldo_sekunder">Min DO</label>
                                    <div style="display: flex; flex-direction: row; gap: 3%">
                                        <input type="text" name="saldo_sekunder" id="saldo_sekunder" class="input">
                                        <input type="text" name="saldo_sekunder" id="saldo_sekunder" class="input"
                                            style="width: 25%">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="acs-div-form2">

                            <div class="acs-div-form3" style="">
                                <div>
                                    <span>Jumlah Dikeluarkan</span>
                                </div>
                                <div style="display: flex; flex-direction: row;gap: 2%">
                                    <div class="acs-div-filter1">
                                        <div style="display: flex; flex-direction: row; gap: 3%">
                                            <label for="saldo_primer">Primer</label>
                                            <input type="text" name="saldo_primer" id="saldo_primer" class="input">
                                            <input type="text" name="saldo_primer" id="saldo_primer" class="input"
                                                style="width: 25%">
                                        </div>
                                    </div>
                                    <div class="acs-div-filter1">
                                        <div style="display: flex; flex-direction: row; gap: 5px">
                                            <label for="saldo_sekunder">Sekunder</label>
                                            <input type="text" name="saldo_sekunder" id="saldo_sekunder" class="input">
                                            <input type="text" name="saldo_sekunder" id="saldo_sekunder" class="input"
                                                style="width: 25%">
                                        </div>
                                    </div>
                                    <div class="acs-div-filter1">
                                        <div style="display: flex; flex-direction: row; gap: 3%">
                                            <label for="saldo_tritier">Tritier</label>
                                            <input type="text" name="saldo_tritier" id="saldo_tritier" class="input">
                                            <input type="text" name="saldo_tritier" id="saldo_tritier" class="input"
                                                style="width:25%">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="acs-div-filter1">
                            <label for="kelompok">Jumlah Konversi</label>
                            <input type="text" name="kelompok" id="kelompok" class="input">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('js/Sales/AccPenjualanCloth.js') }}"></script>
@endsection
