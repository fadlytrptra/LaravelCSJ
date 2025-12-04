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
    <link href="{{ asset('css/BarcodeKerta2.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10 RDZMobilePaddingLR0">
                <div class="card">
                    <div class="card-header">Barcode Kerta2</div>
                    <div class="acs-div-form2">
                        <div class="acs-div-form3">
                            <div class="acs-div-filter1">
                                <label for="nomor_suratJalan">Nomor Surat Jalan</label>
                                <input type="text" name="nomor_suratJalan" id="nomor_suratJalan" class="input">
                            </div>
                            <div class="acs-div-filter2">
                                <label for="jumlah_kirim">Jumlah Kirim</label>
                                <input type="text" name="jumlah_kirim" id="jumlah_kirim" class="input">
                            </div>
                        </div>
                        <div class="acs-div-form4">
                            <div class="acs-div-filter3">
                                <label for="jumlah_sudahDiproses">Jumlah Sudah Diproses</label>
                                <input type="text" name="jumlah_sudahDiproses" id="jumlah_sudahDiproses" class="input">
                            </div>
                            <div class="acs-div-filter4">
                                <label for="jumlah_belumDiproses">Jumlah Belum Diproses</label>
                                <input type="text" name="jumlah_belumDiproses" id="jumlah_belumDiproses" class="input">
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary acs-btn-form" id="button_proses">Proses</button>
                    <div class="card-body RDZOverflow RDZMobilePaddingLR0 acs-table-barcode" id="div_tableBarcode">
                        <table id="table_Barcode" class="table table-bordered table-striped" style="width:100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Tgl Terima</th>
                                    <th>No Barcode </th>
                                    <th>Id Type</th>
                                    <th>Primer</th>
                                    <th>Sekunder</th>
                                    <th>Tritier</th>
                                    <th>Penerima</th>
                                    <th>Kode Barang</th>
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
    <script type="text/javascript" src="{{ asset('js/Sales/BarcodeKerta2.js') }}"></script>
@endsection
