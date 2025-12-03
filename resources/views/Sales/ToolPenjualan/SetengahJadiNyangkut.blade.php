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
    <link href="{{ asset('css/SetengahJadiNyangkut.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10 RDZMobilePaddingLR0">
                <div class="card">
                    <div class="card-header">Setengah Jadi Nyangkut</div>
                    <div class="acs-div-form">
                        <div class="acs-div-filter">
                            <button class="btn btn-primary acs-btn-form">Cek Dispresiasi</button>
                            <button class="btn btn-primary acs-btn-form">Update Dispresiasi</button>
                            <button class="btn btn-primary acs-btn-form">Pindah ke Dispresiasi Keluar</button>
                            <button class="btn btn-primary acs-btn-form">Hapus Dispresiasi</button>
                        </div>
                        <div class="acs-div-form1">
                            <div class="acs-div-filter2">
                                <div class="acs-div-filter3" style="width: 40%">
                                    <label for="tanggal_dataPenjualan">Tanggal</label>
                                    <input type="date" name="tanggal_dataPenjualan" id="tanggal_dataPenjualan" class="input">
                                </div>
                                <div class="acs-div-filter1" style="display: flex; justify-content: flex-end;flex-direction: row;width: 80%;margin-right: 10%">
                                    <label for="tanggal_dataPenjualan">Jumlah data:</label>&nbsp;
                                    <span id="jumlah_data">Jumlah</span>
                                </div>
                            </div>
                            <div class="acs-div-filter10">
                                <div class="acs-div-filter11">
                                    <div class="acs-div-filter3">
                                        <label for="tanggal_detailPenjualan">Tanggal</label>
                                        <input type="date" name="tanggal_detailPenjualan" id="tanggal_detailPenjualan" class="input">
                                    </div>
                                    <div class="acs-div-filter3">
                                        <label for="id_type">Id Type</label>
                                        <input type="text" name="id_type" id="id_type" class="input">
                                    </div>
                                    <div class="acs-div-filter3">
                                        <label for="id_do">Dispresiasi</label>
                                        <input type="text" name="id_do" id="id_do" class="input">
                                    </div>
                                    <div class="acs-div-filter3">
                                        <label for="id_do">Dispresiasi Keluar</label>
                                        <input type="text" name="id_do" id="id_do" class="input">
                                    </div>
                                </div>
                            </div>
                            <div>
                                <textarea name="" id="" cols="100" rows="10">AREA TABLE</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('js/Sales/SetengahJadiNyangkut.js') }}"></script>
@endsection
