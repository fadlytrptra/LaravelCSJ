@extends('layouts.appOrderPembelian')
@section('content')
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/ListOrderPembelian.css') }}" rel="stylesheet">
    <script>
        let idUser = {!! json_encode($idUser) !!};
        let data = {!! json_encode($data) !!};
        let statusKoreksi = {!! json_encode($statusKoreksi) !!};
    </script>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10 RDZMobilePaddingLR0">
                @if (Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                @elseif (Session::has('error'))
                    <div class="alert alert-danger">
                        {{ Session::get('error') }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">Maintence Order Pembelian</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <div class="row">
                                    <div class="col-4 col-md-2">
                                        <label for="no_order">Nomer Order</label>
                                    </div>
                                    <div class="col-8 col-md-10">
                                        <input type="text" class="form-control" id="no_order" name="no_order" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="row align-items-center">
                                    <div class="col-4 col-md-2">
                                        <label for="status_beli">Status Beli</label>
                                    </div>
                                    <div class="col-4 col-md-5">
                                        <input type="radio" name="status_beliRadioButton"
                                            id="status_beliPengadaanPembelian" class="input" checked>Pengadaan
                                        Pembelian
                                    </div>
                                    <div style="col-4 col-md-5">
                                        <input type="radio" name="status_beliRadioButton" id="status_beliBeliSendiri"
                                            class="input">Beli Sendiri
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="row">
                                    <div class="col-4 col-md-2">
                                        <label for="tgl_mohonKirim">Tanggal Mohon Kirim</label>
                                    </div>
                                    <div class="col-8 col-md-10">
                                        <input type="date" name="tgl_mohonKirim" id="tgl_mohonKirim" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="row">
                                    <div class="col-4 col-md-2">
                                        <label for="divisi">Divisi</label>
                                    </div>
                                    <div class="col-6 col-md-8">
                                        <select name="select_divisi" id="select_divisi" class="w-100 input">
                                            <option class="w-100 text-center" selected disabled>-- Pilih Divisi --
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="divisi" name="divisi" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-2" style="display: none">
                                <div class="row">
                                    <div class="col-4 col-md-2">
                                        <label for="golongan">Golongan</label>
                                    </div>
                                    <div class="col-8 col-md-10">
                                        <select name="select_golongan" id="select_golongan" class="w-100 input">
                                            <option class="w-100 text-center" selected disabled>-- Pilih Golongan --
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-2" style="display: none">
                                <div class="row">
                                    <div class="col-4 col-md-2">
                                        <label for="mesinGolongan">Mesin Golongan</label>
                                    </div>
                                    <div class="col-8 col-md-10">
                                        <select name="select_mesinGolongan" id="select_mesinGolongan" class="w-100 input">
                                            <option class="w-100 text-center" selected disabled>-- Pilih Mesin Golongan --
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="row">
                                    <div class="col-4 col-md-2">
                                        <label for="pemesan">Pemesan</label>
                                    </div>
                                    <div class="col-8 col-md-10">
                                        <input type="text" class="form-control" id="pemesan" name="pemesan">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="row justify-content-center">
                                    <img src="" style="width: 10rem; height: 10rem;" id="foto" alt="">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="row">
                                    <div class="col-4 col-md-2">
                                        <label for="kd_barang">Kd Barang</label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control" id="kd_barang" name="kd_barang">
                                    </div>
                                    <div class="col-4 col-md-2">
                                        <button type="button" class="btn btn-primary w-100"
                                            id="btn_cari_kdBarang">Cari</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="row">
                                    <div class="col-4 col-md-2">
                                        <label for="kategori_utama">Kategori Utama</label>
                                    </div>
                                    <div class="col-8 col-md-10">
                                        <select name="select_kategori_utama" id="select_kategori_utama"
                                            class="w-100 input">
                                            <option class="w-100 text-center" selected disabled>-- Pilih Kategori Utama --
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="row">
                                    <div class="col-4 col-md-2">
                                        <label for="kategori">Kategori</label>
                                    </div>
                                    <div class="col-8 col-md-10">
                                        <select name="select_kategori" id="select_kategori" class="w-100 input">
                                            <option class="w-100 text-center" selected disabled>-- Pilih Kategori --
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="row">
                                    <div class="col-4 col-md-2 ">
                                        <label for="subKategori">Sub Kategori</label>
                                    </div>
                                    <div class="col-8 col-md-10">
                                        <select name="select_subKategori" id="select_subKategori" class="w-100 input">
                                            <option class="w-100 text-center" selected disabled>-- Pilih Sub Kategori --
                                            </option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="row">
                                    <div class="col-4 col-md-2">
                                        <label for="ket_khusus">Keterangan Khusus</label>
                                    </div>
                                    <div class="col-8 col-md-10">
                                        <input type="text" class="form-control" id="ket_khusus" name="ket_khusus"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="row">
                                    <div class="col-4 col-md-2">
                                        <label for="namaBarang">Nama Barang</label>
                                    </div>
                                    <div class="col-8 col-md-10">
                                        <select name="select_namaBarang" id="select_namaBarang" class="w-100 input">
                                            <option class="w-100 text-center" selected disabled>-- Pilih Nama Barang --
                                            </option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="row">
                                    <div class="col-4 col-md-2">
                                        <label for="ket_barang">Keterangan Barang</label>
                                    </div>
                                    <div class="col-8 col-md-10">
                                        <input type="text" class="form-control" id="ket_barang" name="ket_barang"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-2" style="display: none">
                                <div class="row">
                                    <div class="col-4 col-md-2 ">
                                        <label for="satuanUmum"">Satuan Umum</label>
                                    </div>
                                    <div class="col-8 col-md-10">
                                        <select name="select_satuanUmum" id="select_satuanUmum" class="w-100 input">
                                            <option class="w-100 text-center" selected disabled>
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="row">
                                    <div class="col-4 col-md-2">
                                        <label for="ket_order">Keterangan Order (akan ditampilkan di printout PO)</label>
                                    </div>
                                    <div class="col-8 col-md-10">
                                        <textarea type="text" class="w-100 h-100 " id="ket_order" name="ket_order" rows="4"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="row">
                                    <div class="col-4 col-md-2">
                                        <label for="ket_internal">Keterangan Internal (hanya sebagai informasi untuk divisi
                                            Pembelian)</label>
                                    </div>
                                    <div class="col-8 col-md-10">
                                        <textarea type="text" class="w-100 h-100" id="ket_internal" name="ket_internal" rows="4"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="row">
                                    <div class="col-4 col-md-2">
                                        <label for="qty_order">Qty Order</label>
                                    </div>
                                    <div class="col-6 col-md-8">
                                        <input type="text" class="form-control" id="qty_order" name="qty_order" value="1">
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="ketStatusOrder" name="ketStatusOrder" value="PC" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="acs-form3">
                                <table id="table_listSaldo" class="table table-bordered table-striped"
                                    style="width:100%">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Nama Divisi</th>
                                            <th>Saldo Tritier</th>
                                            <th>Satuan Tertier</th>
                                            <th>Saldo Sekunder</th>
                                            <th>Satuan Sekunder</th>
                                            <th>Saldo Premier</th>
                                            <th>Satuan Premier</th>
                                            <th>Nama Objek</th>
                                            <th>Nama Kelompok Utama</th>
                                            <th>Nama Kelompok</th>
                                            <th>Nama Sub Kelompok</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="row">
                                    <div class="col-6 col-md-2"><button type="button" class="w-100 btn btn-primary"
                                            id="btn_save">Save</button></div>
                                    <div class="col-6 col-md-2"><button type="button" class="w-100 btn btn-primary"
                                            id="btn_submit">Submit</button></div>
                                    <div class="col-6 col-md-2"><button type="button" class="w-100 btn btn-danger"
                                            id="btn_delete">Delete</button></div>
                                    <div class="col-6 col-md-2"><button type="button" class="w-100 btn btn-secondary"
                                            id="btn_clear">Clear</button></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/OrderPembelian/MaintenanceOrderPembelian/MaintenceOrderPembelian.js') }}"></script>
@endsection
