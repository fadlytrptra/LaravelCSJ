@extends('layouts.appOrderPembelian')
@section('content')
@section('title', 'Retur BTTB')
    <link href="{{ asset('css/ReturBTTB.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-11 RDZMobilePaddingLR0">
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
                    <div class="card-header font-weight-bold">Retur BTTB</div>
                    <div class="card-body font-weight-bold">
                        <div class="row align-items-center">
                            <div class="col-6 col-xl-4">
                                <div class="row align-items-center">
                                    <div class="col-2">
                                        <label for="nomor_po" class="form-label font-weight-bold">No PO</label>
                                    </div>
                                    <div class="col-10">
                                        <input type="text" class="form-control font-weight-bold" id="nomor_po" name="nomor_po">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-xl-4">
                                <div class="row align-items-center">
                                    <div class="col-2">
                                        <label for="suplier" class="form-label font-weight-bold">Suplier</label>
                                    </div>
                                    <div class="col-10">
                                        <div class="row">
                                            <div class="col-4">
                                                <input type="text" class="form-control font-weight-bold" id="idsuplier"
                                                    name="idsuplier"readonly>
                                            </div>
                                            <div class="col-8">
                                                <input type="text" class="form-control font-weight-bold" id="suplier"
                                                    name="suplier" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-xl-4">
                                <div class="row align-items-center">
                                    <div class="col-2">
                                        <label for="payment" class="form-label font-weight-bold">Payment Term</label>
                                    </div>
                                    <div class="col-10">
                                        <input type="text" class="form-control font-weight-bold" id="payment"
                                            name="payment"readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-xl-4">
                                <div class="row align-items-center">
                                    <div class="col-2">
                                        <label for="tanggal_po" class="form-label font-weight-bold">Tanggal PO</label>
                                    </div>
                                    <div class="col-10">
                                        <input type="date" class="form-control font-weight-bold" id="tanggal_po" name="tanggal_po"
                                            value="{{ date('Y-m-d') }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-xl-4">
                                <div class="row align-items-center">
                                    <div class="col-2">
                                        <label for="tanggalkirim" class="form-label font-weight-bold">Tanggal Mohon Kirim</label>
                                    </div>
                                    <div class="col-10">
                                        <input type="date" class="form-control font-weight-bold" id="tanggalkirim"
                                            name="tanggalkirim" value="{{ date('Y-m-d') }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-xl-4">
                                <div class="row align-items-center">
                                    <div class="col-2">
                                        <label for="matauang" class="form-label font-weight-bold">Mata uang</label>
                                    </div>
                                    <div class="col-10">
                                        <input type="text" class="form-control font-weight-bold" id="matauang"
                                            name="matauang"readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="mx-auto acs-form3">
                                <div class="table-responsive">
                                    <table class="mx-auto table table-bordered" id="tabelretur">
                                        <thead class="table-primary">
                                            <tr>
                                                <th id="nobttb"> BTTB</th>
                                                <th>No. SJ</th>
                                                <th>Id Terima</th>
                                                <th>Kd Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Sub Kategori</th>
                                                <th>Qty Terima</th>
                                                <th>Satuan</th>
                                                <th>id. Transfer</th>
                                                <th>id Trans INV</th>
                                                <th>No Order</th>
                                                <th>Qty Retur</th>
                                                <th>Tgl Retur</th>
                                                <th>Alasan Retur</th>
                                                <th>Penagih</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="text-left mt-20">
                                    <h5>Stock Inventory Divisi Pembelian</h5>
                                </div>
                            </div>

                            <div class="mx-auto acs-form3">
                                <div class="table-responsive">
                                    <table class="mx-auto table table-bordered" id="tabelretur1">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>Id Type</th>
                                                <th>Kd Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Qty Primer</th>
                                                <th>Satuan Primer</th>
                                                <th>Qty Sekunder </th>
                                                <th>Satuan Sekunder</th>
                                                <th>Qty Tertier</th>
                                                <th>Satuan Tertier</th>
                                                <th>Sub Kelompok</th>
                                                <th>Kelompok</th>
                                                <th>Kel Utama</th>
                                                <th>Objek</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="col-12 mb-2">
                                    <div class="row align-items-center">
                                        <div class="col-4">
                                            <label for="kdbarang" class="form-label font-weight-bold">Kode Barang</label>
                                        </div>
                                        <div class="col-8 col-md-6">
                                            <input type="text" class="form-control font-weight-bold" id="kdbarang"
                                                name="kdbarang" readonly>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="row align-items-center">
                                        <div class="col-4">
                                            <label for="namabarang" class="form-label font-weight-bold">Nama Barang</label>
                                        </div>
                                        <div class="col-8 col-md-6">
                                            <input type="text" class="form-control font-weight-bold" id="namabarang"
                                                name="namabarang" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="row align-items-center">
                                        <div class="col-4">
                                            <label for="subkategori" class="form-label font-weight-bold">Sub Kategori</label>
                                        </div>
                                        <div class="col-8 col-md-6">
                                            <input type="text" class="form-control font-weight-bold" id="subkategori"
                                                name="subkategori"readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="row align-items-center">
                                        <div class="col-4">
                                            <label for="bttb" class="form-label font-weight-bold">No. BTTB</label>
                                        </div>
                                        <div class="col-8 col-md-6">
                                            <input type="text" class="form-control font-weight-bold" id="bttb"
                                                name="bttb"readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="row align-items-center">
                                        <div class="col-4">
                                            <label for="sj" class="form-label font-weight-bold">No. SJ</label>
                                        </div>
                                        <div class="col-8 col-md-6">
                                            <input type="text" class="form-control font-weight-bold" id="sj"
                                                name="sj"readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="row align-items-center">
                                        <div class="col-4">
                                            <label for="id_terima" class="form-label font-weight-bold">Id Terima</label>
                                        </div>
                                        <div class="col-8 col-md-6">
                                            <input type="text" class="form-control font-weight-bold" id="id_terima"
                                                name="id_terima"readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="row align-items-center">
                                        <div class="col-4">
                                            <label for="qty_terima" class="form-label font-weight-bold">Qty Terima</label>
                                        </div>
                                        <div class="col-8 col-md-6">
                                            <input type="text" class="form-control font-weight-bold" id="qty_terima"
                                                name="qty_terima">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-12 mb-2">
                                    <div class="row align-items-center">
                                        <div class="col-4">
                                            <label for="tanggalretur" class="form-label font-weight-bold">Tanggal Retur</label>
                                        </div>
                                        <div class="col-8 col-md-6">
                                            <input type="date" class="form-control font-weight-bold" id="tanggalretur"
                                                name="tanggalretur" value="{{ date('Y-m-d') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="row align-items-center">
                                        <div class="col-4">
                                            <label for="type" class="form-label font-weight-bold">Id Type</label>
                                        </div>
                                        <div class="col-8 col-md-6">
                                            <input type="text" class="form-control font-weight-bold" id="type"
                                                name="type" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="row align-items-center">
                                        <div class="col-4">
                                            <label for="kelompok" class="form-label font-weight-bold">Kelompok</label>
                                        </div>
                                        <div class="col-8 col-md-6">
                                            <input type="text" class="form-control font-weight-bold" id="kelompok"
                                                name="kelompok"readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="row align-items-center">
                                        <div class="col-4">
                                            <label for="returprimer" class="form-label font-weight-bold">Qty Primer</label>
                                        </div>
                                        <div class="col-8 col-md-6">
                                            <input type="text" class="form-control font-weight-bold" id="returprimer"
                                                name="returprimer">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="row align-items-center">
                                        <div class="col-4">
                                            <label for="sekunder" class="form-label font-weight-bold">Qty Sekunder</label>
                                        </div>
                                        <div class="col-8 col-md-6">
                                            <input type="text" class="form-control font-weight-bold" id="sekunder"
                                                name="sekunder">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="row align-items-center">
                                        <div class="col-4">
                                            <label for="tertier" class="form-label font-weight-bold">Qty Tertier</label>
                                        </div>
                                        <div class="col-8 col-md-6">
                                            <input type="text" class="form-control font-weight-bold" id="tertier"
                                                name="tertier">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="row align-items-center">
                                        <div class="col-4">
                                            <label for="alasan" class="form-label font-weight-bold">Alasan</label>
                                        </div>
                                        <div class="col-8 col-md-6">
                                            <textarea rows="4" type="text" class="form-control font-weight-bold" id="alasan"
                                                name="alasan"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="row align-items-center">
                                        <div class="col-4">
                                            <label for="keterangan" class="form-label font-weight-bold">Keterangan :</label>
                                        </div>
                                        <div class="col-8 col-md-6">
                                            <span id="keterangan"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="button " id="returbutton"
                                    class="custom-button2 mr-3">RETUR</button>
                                <button type="button " id="batalbutton"
                                    class="custom-button2 mr-3">BATAL</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script src="{{ asset('js/OrderPembelian/ReturBTTB/Retur.js') }}"></script>
        @endsection
