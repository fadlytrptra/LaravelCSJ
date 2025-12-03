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
    <link href="{{ asset('css/PenjualanBarcode.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10 RDZMobilePaddingLR0">
                <div class="card">
                    <div class="card-header">Penjualan Barcode</div>
                    <div class="acs-div-form">
                        <div class="acs-div-filter">
                            <button class="btn btn-primary acs-btn-form">Cek Penjualan</button>
                            <button class="btn btn-primary acs-btn-form">Cek Data</button>
                            <div class="acs-div-filter1">
                                <button class="btn btn-primary acs-btn-form">Update Tmp Gudang</button>
                                <button class="btn btn-primary acs-btn-form">Update IDDO</button>
                            </div>
                            <button class="btn btn-primary acs-btn-form">Tampil Data Gudang</button>
                            <button class="btn btn-primary acs-btn-form">Update Dispresiasi</button>
                            <button class="btn btn-primary acs-btn-form">Hapus Data Kembar</button>
                            <button class="btn btn-primary acs-btn-form">Pindah ke Dispresiasi Keluar</button>
                            <button class="btn btn-primary acs-btn-form">Hapus Dispresiasi</button>
                            <button class="btn btn-primary acs-btn-form">Update Dispresiasi Keluar</button>
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
                                        <label for="id_do">IDDO</label>
                                        <input type="text" name="id_do" id="id_do" class="input">
                                    </div>
                                    <div class="acs-div-filter3">
                                        <label for="id_trans">Y IdTrans</label>
                                        <input type="text" name="id_trans" id="id_trans" class="input">
                                    </div>
                                </div>
                                <div class="acs-div-filter12">
                                    <div class="acs-div-filter3">
                                        <label for="kode_barang">Kode Barang</label>
                                        <input type="text" name="kode_barang" id="kode_barang" class="input">
                                    </div>
                                    <div class="acs-div-filter3">
                                        <label for="Dispresiasi">Dispresiasi</label>
                                        <div>
                                            <input type="text" name="Dispresiasi" id="Dispresiasi" class="input">
                                            <label for="y_dispresiasi">Y</label>
                                            <input type="text" name="y_dispresiasi" id="y_dispresiasi" class="input">
                                        </div>
                                    </div>
                                    <div class="acs-div-filter3">
                                        <label for="tmp_gudang">Tmp Gudang</label>
                                        <div>
                                            <input type="text" name="tmp_gudang" id="tmp_gudang" class="input">
                                            <label for="y_tmpGudang">Y</label>
                                            <input type="text" name="y_tmpGudang" id="y_tmpGudang" class="input">
                                        </div>
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
    <script type="text/javascript" src="{{ asset('js/Sales/PenjualanBarcode.js') }}"></script>
@endsection
