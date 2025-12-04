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
    <link href="{{ asset('css/PenjualanNyangkut.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10 RDZMobilePaddingLR0">
                <div class="card">
                    <div class="card-header">Penjualan Nyangkut</div>
                    <div class="acs-div-form">
                        <div class="acs-div-filter">
                            <button class="btn btn-primary acs-btn-form">Tampilkan Data Tmp_Gudang</button>
                            <button class="btn btn-primary acs-btn-form">Tampilkan Data Dispresiasi</button>
                            <button class="btn btn-primary acs-btn-form">Tampilkan Data Dispresiasi Keluar</button>
                            <button class="btn btn-primary acs-btn-form">Update Dispresiasi</button>
                            <button class="btn btn-primary acs-btn-form">Hapus Data Kembar di Dispresiasi Keluar</button>
                            <button class="btn btn-primary acs-btn-form">Pindahkan ke Dispresiasi Keluar</button>
                            <button class="btn btn-primary acs-btn-form">Hapus Dispresiasi</button>
                            <button class="btn btn-primary acs-btn-form">Update tmp gudang</button>
                        </div>
                        <div class="acs-div-form1">
                            <div class="acs-div-filter2">
                                <div class="acs-div-filter3" style="width: 40%">
                                    <label for="kode_barang">Kode Barang</label>
                                    <input type="text" name="kode_barang" id="kode_barang" class="input">
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
                                        <label for="id_do">IDDO</label>
                                        <input type="text" name="id_do" id="id_do" class="input">
                                    </div>

                                </div>
                                <div class="acs-div-filter12">
                                    <div class="acs-div-filter3">
                                        <label for="yid_trans">Y IdTrans</label>
                                        <input type="text" name="yid_trans" id="yid_trans" class="input">
                                    </div>
                                    <div class="acs-div-filter3">
                                        <label for="xid_trans">X IdTrans</label>
                                        <input type="text" name="xid_trans" id="xid_trans" class="input">
                                    </div>
                                    <div class="acs-div-filter3">
                                        <label for="jumlah_do">Jml DO</label>
                                        <input type="text" name="jumlah_do" id="jumlah_do" class="input">
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
    <script type="text/javascript" src="{{ asset('js/Sales/PenjualanNyangkut.js') }}"></script>
@endsection
