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
    <link href="{{ asset('css/GantiRPM.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10 RDZMobilePaddingLR0">
                <div class="card">
                    <div class="card-header">Ganti RPM</div>
                    <div class="acs-div-form">
                        <div class="acs-div-form1">
                            <div class="acs-div-filter">
                                <label for="tanggal_gantiRPM">Tanggal</label>
                                <input type="date" name="tanggal_gantiRPM" id="tanggal_gantiRPM" class="input">
                            </div>
                            <div class="acs-div-filter1">
                                <label for="shift_select">Shift</label>
                                <select name="shift_select" id="shift_select" class="input">
                                    <option disabled selected>-- Pilih Shift --</option>
                                    <option value="P">P</option>
                                    <option value="S">S</option>
                                    <option value="M">M</option>
                                </select>
                            </div>
                            <div class="acs-div-filter2">
                                <label for="nama_mesin">Nama Mesin</label>
                                <input type="text" name="nama_mesin" id="nama_mesin" class="input">
                            </div>
                        </div>
                        <button class="btn btn-primary acs-btn-form" id="button_proses">Proses</button>
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
                            <label for="ganti_rpm">Ganti RPM</label>
                            <input type="text" name="ganti_rpm" id="ganti_rpm" class="input">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('js/Sales/GantiRPM.js') }}"></script>
@endsection
