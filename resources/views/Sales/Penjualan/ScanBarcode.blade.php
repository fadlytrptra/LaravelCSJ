@extends('layouts.appSales')
@section('title', 'Scan Barcode')
@section('content')
    <script>
        $(document).ready(function() {
            $('#table_detailBarcode').DataTable({
                order: [
                    [1, 'desc']
                ],
            });
        });
        let data_kodeBarang = {!! json_encode($data_kodeBarang) !!}; //PASSING DATA FROM PHP TO JAVASCRIPT HEHE
    </script>
    {{-- @php
        $data_kodeBarangString = implode(
            ',',
            array_map(function ($item) {
                return is_object($item) ? json_encode($item) : $item;
            }, $data_kodeBarang),
        );
        print $data_kodeBarangString;
    @endphp --}}
    <link href="{{ asset('css/ScanBarcode.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10 RDZMobilePaddingLR0">
                @if (Session::has('success'))
                    <div class="alert alert-info">
                        {!! Session::get('success') !!}
                    </div>
                @elseif (Session::has('error'))
                    <div class="alert alert-danger">
                        {{ Session::get('error') }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">Scan Barcode / Barcode Jual</div>
                    <div class="acs-div-form2">
                        <form action="{{ url('ScanBarcode') }}" method="POST" id="form_scanBarcode">
                            {{ csrf_field() }}
                            <div class="acs-div-form3">
                                <div class="acs-div-filter1">
                                    <label for="kode_barcode">Kode Barcode</label>
                                    <textarea class="input" name="kode_barcode" id="kode_barcode" cols="60" rows="1" placeholder="Indeks-Kode Barang"></textarea>Tekan Enter
                                    untuk Scan Barcode!
                                    {{-- <input type="text" name="kode_barcode" id="kode_barcode" class="input"> --}}
                                    {{-- <label for="">Untuk data uji coba 114-000067047</label> --}}
                                </div>
                            </div>
                        </form>
                        <br>
                        <div class="acs-div-form4">
                            <div class="acs-div-filter3">
                                <input type="date" name="tanggal_input" id="tanggal_input" class="input">
                                <button class="btn btn-primary acs-btn-form" id="lihat_data">Lihat Data</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body RDZOverflow RDZMobilePaddingLR0 acs-table-barcode" id="div_tableBarcodeData">
                        <legend>Data Barcode</legend>
                        <div class="acs-div-filter2">
                            <label for="jumlah" id="jumlah">Jumlah data Barcode: {{ $jumlah[0]->total }}</label>
                            {{-- <span id="jumlah">{{ $jumlah[0]->total }}</span> --}}
                        </div>
                        <table id="table_dataBarcode" class="table table-bordered table-striped" style="width:100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Id Type</th>
                                    <th>Kode Barang</th>
                                    <th>Ball/Roll</th>
                                    <th>Lembar/Meter</th>
                                    <th>Kg</th>
                                    <th>Tgl Scan</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    <div class="card-body RDZOverflow RDZMobilePaddingLR0 acs-table-barcode" id="div_tableBarcodeDetail">
                        <legend>Detail Data Barcode</legend>
                        <table id="table_detailBarcode" class="table table-bordered table-striped" style="width:100%">
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
    <script type="text/javascript" src="{{ asset('js/Sales/ScanBarcode.js') }}"></script>
@endsection
