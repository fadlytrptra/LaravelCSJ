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
    <link href="{{ asset('css/HapusCIR.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10 RDZMobilePaddingLR0">
                <div class="card">
                    <div class="card-header">Hapus CIR</div>
                    <div class="acs-div-form2">
                        <div class="acs-div-form3">
                            <div class="acs-div-filter1">
                                <label for="nomor_suratJalan">Tanggal</label>
                                <input type="date" name="nomor_suratJalan" id="nomor_suratJalan" class="input">
                            </div>
                            <div class="acs-div-filter2">
                                <label for="jumlah_kirim">Nama Mesin</label>
                                <input type="text" name="jumlah_kirim" id="jumlah_kirim" class="input">
                            </div>
                        </div>
                        <div class="card-body RDZOverflow RDZMobilePaddingLR0 acs-table-barcode" id="div_tableBarcode">
                            <table id="table_Barcode" class="table table-bordered table-striped" style="width:100%">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Id Log</th>
                                        <th>Status Log </th>
                                        <th>Shift</th>
                                        <th>RPM</th>
                                        <th>Id Order</th>
                                        <th>Id Karyawan</th>
                                        <th>Counter Awal</th>
                                        <th>Counter Akhir</th>
                                        <th>Jam Awal</th>
                                        <th>Jam Akhir</th>
                                        <th>Id User</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <div class="acs-div-filter3">
                            <label for="id_log">Id Log</label>
                            <input type="text" name="id_log" id="id_log" class="input">
                        </div>
                        <div class="acs-div-filter3">
                            <label for="id_order">Id Order</label>
                            <input type="text" name="id_order" id="id_order" class="input">
                        </div>
                        <div class="acs-div-filter3">
                            <label for="sisa">Sisa</label>
                            <input type="text" name="sisa" id="sisa" class="input">
                        </div>
                        <div>
                            <button class="btn btn-primary acs-btn-form" id="button_proses">Proses</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('js/Sales/HapusCIR.js') }}"></script>
@endsection
