@extends('layouts.appSales')
@section('content')
@section('title', 'Barcode Jual')
    <script>
        $(document).ready(function() {
            $('#table_Barcode').DataTable({
                order: [
                    [1, 'desc']
                ],
            });
        });
    </script>
    <link href="{{ asset('css/BarcodeJual.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10 RDZMobilePaddingLR0">
                <div class="card">
                    <div class="card-header">Barcode Jual</div>
                    <div class="acs-div-form2">
                        <div class="acs-div-form3">
                            <div class="acs-div-filter1">
                                <label for="tanggal">Tanggal</label>
                                <input type="date" name="tanggal" id="tanggal" class="input">
                            </div>
                            <button class="btn btn-primary acs-btn-form">Lihat Data</button>
                        </div>
                        <div class="acs-div-form3" style="align-items: flex-end">
                            {{-- <label for="jumlah">Jumlah</label> --}}
                            <input type="text" name="jumlah" id="jumlah" class="input" placeholder="Jumlah">
                        </div>
                    </div>
                    <div class="card-body RDZOverflow RDZMobilePaddingLR0 acs-table-barcode" id="div_tableBarcode">
                        <table id="table_Barcode" class="table table-bordered table-striped" style="width:100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>No Indeks</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Type</th>
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
    <script type="text/javascript" src="{{ asset('js/Sales/BarcodeJual.js') }}"></script>
@endsection
