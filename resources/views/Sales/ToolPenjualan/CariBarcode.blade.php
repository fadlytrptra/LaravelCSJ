@extends('layouts.appSales')
@section('content')
@section('title', 'Cari Barcode')
    <script>
        $(document).ready(function() {
            $('#table_Barcode').DataTable({
                order: [
                    [1, 'desc']
                ],
            });
        });
    </script>
    <link href="{{ asset('css/CariBarcode.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10 RDZMobilePaddingLR0">
                <div class="card">
                    <div class="card-header">Cari Barcode</div>
                    <div class="acs-div-form">
                        <div class="acs-div-form1">
                            <div class="acs-div-form5">
                                <div class="acs-div-filter5">
                                    Tabel:
                                    <div>
                                        <input type="radio" name="group_cariBarcode" id="tempat_dispresiasi"> Dispresiasi
                                    </div>
                                    <div>
                                        <input type="radio" name="group_cariBarcode" id="tempat_tmpGudang"> Tmp_Gudang
                                    </div>
                                </div>
                                <div class="acs-div-filter">
                                    <label for="kode_barang">KodeBarang:</label>
                                    <div style="display: flex; flex-direction: row; align-items: center; gap: 3%">
                                        <input type="text" name="kode_barang" id="kode_barang" class="input">
                                        <span>Tekan Enter</span>
                                    </div>
                                </div>
                            </div>
                            <div class="acs-div-form2">
                                <legend>Pilihan</legend>
                                <div style="display: flex; flex-direction: row">
                                    <div class="acs-div-form3">
                                        <div class="acs-div-filter1">
                                            <label for="tanggal_cariBarcode">Tanggal:</label>
                                            <div>
                                                <input type="checkbox" id="checkbox_Tanggal" name="checkbox_Tanggal">
                                                <input type="date" name="tanggal_cariBarcode" id="tanggal_cariBarcode"
                                                    class="input">
                                            </div>
                                        </div>
                                        <div class="acs-div-filter2">
                                            <label for="id_type">Id Type:</label>
                                            <div>
                                                <input type="checkbox" id="checkbox_idType" name="checkbox_idType">
                                                <input type="text" name="id_typeText" id="id_typeText" class="input"
                                                    list="id_type" style="display: none">
                                                <select name="id_typeSelect" id="id_typeSelect" class="input"
                                                    style="display: inline-block">
                                                    <option disabled selected>-- Pilih Id Type --</option>
                                                </select>
                                                <button class="btn btn-primary" id="switch_idType">↺</button>
                                                <datalist id="id_type">
                                                    <option value="Tolong Isi Kode Barang untuk melihat daftar Id Type">
                                                </datalist>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="acs-div-form4">
                                        <div class="acs-div-filter3">
                                            <label for="lembar">Lembar</label>
                                            <div>
                                                <input type="checkbox" id="checkbox_lembar" name="checkbox_lembar">
                                                <input type="text" name="lembar" id="lembar" class="input">
                                            </div>
                                        </div>
                                        <div class="acs-div-filter4">
                                            <label for="Kg">Kg</label>
                                            <div>
                                                <input type="checkbox" id="checkbox_Kg" name="checkbox_Kg">
                                                <input type="text" name="Kg" id="Kg" class="input">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="acs-div-form7" id="jumlah_dataKolom">
                                <label for="jumlah_data">Jumlah data: </label>
                                <span id="jumlah_data">0</span>
                            </div>
                        </div>
                        <br>

                        <div class="acs-div-form6">
                            <button class="btn btn-primary acs-btn-form" id="button_proses">Proses</button>
                        </div>
                    </div>
                    <meta charset="UTF-8">
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <div class="card-body RDZOverflow RDZMobilePaddingLR0 acs-table-barcode" id="div_tableBarcode">
                        <table id="table_Barcode" class="table table-bordered table-striped" style="width:100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No Indeks</th>
                                    <th>Qty Primer </th>
                                    <th>Qty Sekunder</th>
                                    <th>Qty</th>
                                    <th>Id Type Tujuan</th>
                                    <th>Tgl Mutasi</th>
                                    <th>Status</th>
                                    <th>Type Transaksi</th>
                                    <th>Id Divisi</th>
                                    <th>Nama Kelompok Utama</th>
                                    <th>Nama Kelompok</th>
                                    <th>Nama Sub Kelompok</th>
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
    <script type="text/javascript" src="{{ asset('js/Sales/CariBarcode.js') }}"></script>
@endsection
