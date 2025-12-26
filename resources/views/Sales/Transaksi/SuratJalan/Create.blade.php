@extends('layouts.appSales') @section('content')
@section('title', 'Create SJ')
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
<link href="{{ asset('css/permohonan-sj.css') }}" rel="stylesheet">
<style>
    #table_listStok tbody tr {
        cursor: pointer;
    }

    #table_listStok tbody tr.row-selected {
        background-color: #d2ebff !important;
        /* light blue */
    }
</style>
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
                <div class="card-header">Surat Jalan</div>
                <div class="card-body RDZOverflow RDZMobilePaddingLR0">
                    <div class="permohonan-sj-container">
                        <form method="POST" enctype="multipart/form-data" id="form_suratJalan"
                            class="permohonan-sj-form" action="{{ url('SuratJalan') }}">
                            {{ csrf_field() }}
                            <div class="acs-div-form1">
                                <div class="acs-div-form1" id="div_suratJalan">
                                    <div class="permohonan-sj-form">
                                        <div class="acs-div-form">
                                            <div class="acs-div-filter1">
                                                <label for="id_kirim">Id Kirim</label>
                                                <div class="acs-div-filter2">
                                                    <input type="text" name="id_kirimText" id="id_kirimText"
                                                        class="input" readonly>
                                                    <select name="id_kirimSelect" id="id_kirimSelect"
                                                        style="display: none" class="input">
                                                        <option selected disabled>--Pilih Id Kirim--</option>
                                                    </select>
                                                    <button disabled id="list_sjButton" class="btn btn-info"
                                                        style="display: inline;">↺ Lihat Data</button>
                                                </div>
                                            </div>
                                            <div class="acs-div-filter1">
                                                <label for="jenis_pengiriman">Jenis Pengiriman</label>
                                                <select name="jenis_pengiriman" id="jenis_pengiriman" class="input">
                                                    <option selected disabled>-- Pilih Jenis Pengiriman--</option>
                                                    @foreach ($jenisPengiriman as $data)
                                                        <option value="{{ $data->IDJnsSuratJalan }}">
                                                            {{ $data->NamaJnsSuratJalan }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="acs-div-filter1">
                                                <label for="surat_jalan">Surat Jalan</label>
                                                <input type="text" id="surat_jalan" name="surat_jalan"
                                                    placeholder="Surat Jalan" class="input" />
                                            </div>
                                            <div class="acs-div-filter1">
                                                <label for="surat_jalan">Tanggal</label>
                                                <input type="date" id="tanggal" name="tanggal"
                                                    placeholder="placeholder" class="input" />
                                            </div>
                                            <div class="acs-div-filter1">
                                                <label for="expeditor">Expeditor</label>
                                                <select name="expeditor" id="expeditor" class="input">
                                                    <option selected disabled>-- Pilih Expeditor--</option>
                                                    @foreach ($expeditor as $data)
                                                        <option value="{{ $data->IDEXPEDITOR }}">
                                                            {{ $data->NAMAEXPEDITOR }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="acs-div-filter1">
                                                <label for="customer">Customer</label>
                                                <select name="customer" id="customer" class="input">
                                                    <option selected disabled>-- Pilih Customer--</option>
                                                    @foreach ($customer as $data)
                                                        @php
                                                            $IDCust = explode(' - ', $data->IdCust);
                                                        @endphp
                                                        <option value="{{ $IDCust[0] }}">{{ $data->NamaCust }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="acs-div-form">
                                            <div class="acs-div-filter1">
                                                <label for="Keterangan">Keterangan</label>
                                                <textarea placeholder="Keterangan" name="keterangan" id="keterangan" class="textarea"></textarea>
                                            </div>
                                            <div class="acs-div-filter1">
                                                <label for="truk_nopol">Truk Nopol</label>
                                                <input type="text" id="truk_nopol" name="truk_nopol"
                                                    placeholder="Truk Nopol" class="input" />
                                            </div>
                                            <div class="acs-div-filter1">
                                                <label for="biaya">Biaya</label>
                                                <input type="text" id="biaya" name="biaya" placeholder="0"
                                                    class="input" value="0" readonly />
                                            </div>
                                            <div class="acs-div-filter1">
                                                <label for="nomor_container">No. Container</label>
                                                <input type="text" id="nomor_container" name="nomor_container"
                                                    placeholder="No. Container" class="input" />
                                            </div>
                                            <div class="acs-div-filter1">
                                                <label for="nomor_seal">No. Seal</label>
                                                <input type="text" id="nomor_seal" name="nomor_seal"
                                                    placeholder="No. Seal" class="input" />
                                            </div>
                                            <div class="acs-div-filter1">
                                                <label for="nomor_bl">No. BL</label>
                                                <input type="text" id="nomor_bl" name="nomor_bl"
                                                    placeholder="No. BL" class="input" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="permohonan-sj-container07">
                                        <table class="permohonan-sj-table" id="list_view" name="list_view">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>No. DO</th>
                                                    <th>No. Trans</th>
                                                    <th>Surat Pesanan</th>
                                                    <th>Kode Barang</th>
                                                    <th>IdTransTmp</th>
                                                    <th>Qty</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <div class="permohonan-sj-container08">
                                        <div class="permohonan-sj-container09">
                                            <span>Surat Pesanan</span>
                                            <select class="permohonan-sj-select3 input" id="surat_pesanan"
                                                name="surat_pesanan">
                                                <option disabled selected>-- Pilih Surat Pesanan --</option>
                                            </select>
                                        </div>
                                        <div class="permohonan-sj-container10">
                                            <span>Nomor DO</span>
                                            <select class="permohonan-sj-select4 input" id="nomor_do"
                                                name="nomor_do">
                                                <option disabled selected>-- Pilih Delivery Order --</option>
                                            </select>
                                        </div>
                                        {{-- <div class="permohonan-sj-container11">
                                            <span>Uraian</span>
                                            <textarea id="uraian" name="uraian" placeholder="Uraian" class="permohonan-sj-textarea1 textarea"></textarea>
                                        </div> --}}
                                        <input type="hidden" name="hidden_kodeBarang" id="hidden_kodeBarang">
                                        <input type="hidden" name="hidden_transTmp" id="hidden_transTmp">
                                        <input type="hidden" name="hidden_qty" id="hidden_qty">
                                        <div class="permohonan-sj-container12">
                                            <button id="add_item" name="add_item" type="button"
                                                class="permohonan-sj-button button">
                                                Add Item
                                            </button>
                                            <button id="remove_item" name="remove_item" type="button"
                                                class="permohonan-sj-button1 button">
                                                Remove Item
                                            </button>
                                        </div>
                                    </div>
                                    <div style="display: flex; flex-direction: row;gap:0.5%;">
                                        <div style="width: 25%">
                                            <div class="form-group">
                                                <label for="divisi">Divisi</label>
                                                <div class="input-group">
                                                    <input type="text" name="divisi" id="divisi"
                                                        class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="objek">Objek</label>
                                                <div class="input-group">
                                                    <input type="text" name="objek" id="objek"
                                                        class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="kelut">Kel. Utama</label>
                                                <div class="input-group">
                                                    <input type="text" name="kelut" id="kelut"
                                                        class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="width: 25%">
                                            <div class="form-group">
                                                <label for="idtrans">Id Transaksi</label>
                                                <div class="input-group">
                                                    <input type="text" name="idtrans" id="idtrans"
                                                        class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="kelompok">Kelompok</label>
                                                <div class="input-group">
                                                    <input type="text" name="kelompok" id="kelompok"
                                                        class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="subkelompok">Sub Kelompok</label>
                                                <div class="input-group">
                                                    <input type="text" name="subkelompok" id="subkelompok"
                                                        class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="width: 15%">
                                            <div class="form-group">
                                                <label for="min_do">Min. DO</label>
                                                <div class="input-group" style="gap: 1.5%">
                                                    <input type="text" name="min_do" id="min_do"
                                                        style="flex: 0.7" class="form-control" readonly>
                                                    <input type="text" class="form-control" style="flex: 0.3"
                                                        id="min_doSatuan" name="min_doSatuan" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="max_do">Max. DO</label>
                                                <div class="input-group" style="gap: 1.5%">
                                                    <input type="text" name="max_do" id="max_do"
                                                        style="flex: 0.7" class="form-control" readonly>
                                                    <input type="text" class="form-control" style="flex: 0.3"
                                                        id="max_doSatuan" name="max_doSatuan" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="tgl_mohonDO">Tanggal Mohon DO</label>
                                                <div class="input-group">
                                                    <input type="date" class="form-control" id="tgl_mohonDO"
                                                        name="tgl_mohonDO" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="width: 15%">
                                            <div class="form-group">
                                                <label for="saldo_akhirPrimer">Saldo Primer Akhir</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="saldo_akhirPrimer"
                                                        name="saldo_akhirPrimer" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="saldo_akhirSekunder">Saldo Sekunder Akhir</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control"
                                                        id="saldo_akhirSekunder" name="saldo_akhirSekunder" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="saldo_akhirTritier">Saldo Tritier Akhir</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control"
                                                        id="saldo_akhirTritier" name="saldo_akhirTritier" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="width: 20%">
                                            <div class="form-group">
                                                <label for="jumlah_dikeluarkanPrimer">Jumlah Keluar Primer</label>
                                                <div class="input-group" style="gap: 1%">
                                                    <input type="text" class="form-control" style="flex: 0.7"
                                                        id="jumlah_dikeluarkanPrimer" name="jumlah_dikeluarkanPrimer"
                                                        readonly>
                                                    <input type="text" class="form-control" style="flex: 0.3"
                                                        id="jumlah_dikeluarkanPrimerSatuan"
                                                        name="jumlah_dikeluarkanPrimerSatuan" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="jumlah_dikeluarkanSekunder">Jumlah Keluar Sekunder</label>
                                                <div class="input-group" style="gap: 1%">
                                                    <input type="text" class="form-control" style="flex: 0.7"
                                                        id="jumlah_dikeluarkanSekunder"
                                                        name="jumlah_dikeluarkanSekunder" readonly>
                                                    <input type="text" class="form-control" style="flex: 0.3"
                                                        id="jumlah_dikeluarkanSekunderSatuan"
                                                        name="jumlah_dikeluarkanSekunderSatuan" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="jumlah_dikeluarkanTritier">Jumlah Keluar Tritier</label>
                                                <div class="input-group" style="gap: 1%">
                                                    <input type="text" class="form-control" style="flex: 0.7"
                                                        id="jumlah_dikeluarkanTritier"
                                                        name="jumlah_dikeluarkanTritier" readonly>
                                                    <input type="text" class="form-control" style="flex: 0.3"
                                                        id="jumlah_dikeluarkanTritierSatuan"
                                                        name="jumlah_dikeluarkanTritierSatuan" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="display: flex; flex-direction: row;gap:0.5%;">
                                        <div class="form-group" style="width: 10%">
                                            <label for="no_sp">Nomor SP</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="no_sp"
                                                    name="no_sp" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group" style="width: 25%">
                                            <label for="customerDO">Customer</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="customerDO"
                                                    name="customerDO" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group" style="width: 48%">
                                            <label for="nama_barang">Nama Barang</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="nama_barang"
                                                    name="nama_barang" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group" style="width: 7%">
                                            <button id="isiQty_button" style="float:inline-end"
                                                class="btn btn-primary">Isi Qty</button>
                                        </div>
                                        <input type="hidden" name="hidden_idTypeDO" id="hidden_idTypeDO">
                                        <input type="hidden" name="hidden_kodeBarangDO" id="hidden_kodeBarangDO">
                                    </div>
                                </div>
                                <div class="permohonan-sj-container13">
                                    <button id="isi_button" class="permohonan-sj-button2 button">
                                        <span>Isi</span></button>
                                    <button id="edit_button" class="permohonan-sj-button3 button">
                                        <span>Koreksi</span></button>
                                    <button id="hapus_button" class="permohonan-sj-button4 button">
                                        <span>Hapus</span></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk isi qty DO -->
<div class="modal fade" id="isiQtyModal" tabindex="-1">
    <div class="modal-dialog" style="min-width: 70%">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h5 class="modal-title" id="isiQtyLabel">Isi Qty </h5>
                <button type="button" class="close" data-bs-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div style="overflow: auto; width: 100%; margin-bottom: 1%;">
                    Stok Gudang
                    <table id="table_listStok">
                        <thead>
                            <tr style="white-space: nowrap">
                                <th>No. PIB</th>
                                <th>Primer</th>
                                <th>Sekunder</th>
                                <th>Tritier</th>
                            </tr>
                        </thead>
                    </table>
                </div>

                <div style="display: flex; flex-direction: row;gap:0.5%;margin-bottom: 1%;">
                    <div style="width: 33%">
                        <div class="form-group">
                            <label for="no_pibQtyDO">No. PIB</label>
                            <div class="input-group">
                                <input type="text" name="no_pibQtyDO" id="no_pibQtyDO" class="form-control"
                                    readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="primer_qtyDO">Primer</label>
                            <div class="input-group">
                                <input type="number" name="primer_qtyDO" id="primer_qtyDO" class="form-control"
                                    readonly>
                            </div>
                        </div>
                        <button class="btn btn-primary" id="button_isiQtyDO">Isi</button>
                    </div>
                    <div style="width: 33%">
                        <div class="form-group">
                            <label for="id_typeQtyDO">Id Type</label>
                            <div class="input-group">
                                <input type="text" name="id_typeQtyDO" id="id_typeQtyDO" class="form-control"
                                    readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sekunder_qtyDO">Sekunder</label>
                            <div class="input-group">
                                <input type="number" name="sekunder_qtyDO" id="sekunder_qtyDO" class="form-control"
                                    readonly>
                            </div>
                        </div>
                    </div>
                    <div style="width: 33%">
                        <div class="form-group">
                            <label for="kode_barangQtyDO">Kode Barang</label>
                            <div class="input-group">
                                <input type="text" name="kode_barangQtyDO" id="kode_barangQtyDO"
                                    class="form-control" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tritier_qtyDO">Tritier</label>
                            <div class="input-group">
                                <input type="number" name="tritier_qtyDO" id="tritier_qtyDO" class="form-control"
                                    readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="overflow: auto; width: 100%; margin-bottom: 1%;">
                    Quantity Jual
                    <table id="table_listJual">
                        <thead>
                            <tr style="white-space: nowrap">
                                <th>No. PIB</th>
                                <th>Primer</th>
                                <th>Sekunder</th>
                                <th>Tritier</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="{{ asset('js/Sales/permohonan-s-j.js') }}"></script>
@endsection
