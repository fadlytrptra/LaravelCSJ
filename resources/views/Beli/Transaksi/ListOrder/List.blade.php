@extends('layouts.appOrderPembelian')
@section('title', 'List Order Pembelian')
@section('content')
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/ListOrderPembelian.css') }}" rel="stylesheet">

    @include('Beli/Transaksi/ListOrder/modalDetailListOrder')
    <style>
        .custom-modal-width {
            max-width: 90%;
        }
    </style>
    <script>
        let idUser = {!! json_encode($idUser) !!};
        $(document).ready(function() {
            $('#table_ListOrder').DataTable({
                searching: true,
                order: [
                    [1, 'desc']
                ],

            });
            let today = new Date();
            let dd = String(today.getDate()).padStart(2, '0');
            let mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            let yyyy = today.getFullYear();

            // today1 = mm + '/' + dd + '/' + yyyy;
            today1 = yyyy + '-' + mm + '-' + dd;
            // document.getElementById("tglAwal").value = today1;
            document.getElementById("tglAkhir").value = today1;
        });
    </script>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10 RDZMobilePaddingLR0">
                <button class="acs-icon-btn acs-add-btn acs-float" id="btn_tambahOrder">
                    <div class="acs-add-icon"></div>
                    <div class="acs-btn-txt">Tambah Order</div>
                </button>
                <div class="card">
                    @if (Auth::user()->status == 1)
                        <div class="card-header">List Order</div>
                    @else
                        <div class="card-header">List Order</div>
                    @endif
                    <div class="card-body RDZOverflow RDZMobilePaddingLR0">
                        <div style="border-bottom:1px solid;padding-bottom: 10px;">
                            <div class="form-row align-items-center RDZFilter">
                                <div class="col-auto">
                                    <label class="col-form-label">Divisi</label>
                                </div>
                                <div class="col-auto">
                                    <select class="form-control Filter" id="divisi">
                                        @foreach ($dataDiv as $item1)
                                            <option>{{ trim($item1->NM_DIV) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <label class="col-form-label">Tgl. Awal</label>
                                </div>
                                <div class="col-auto">
                                    <input type="date" class="form-control Filter w-100" id="tglAwal" name="tglAwal"
                                        value="{{ $dateAwal }}">
                                </div>
                                <div class="col-auto">
                                    <label class="col-form-label">Tgl. Akhir</label>
                                </div>
                                <div class="col-auto">
                                    <input type="date" class="form-control Filter w-100" id="tglAkhir" name="tglAkhir"
                                        value="{{ $dateAkhir }}">
                                </div>
                                <br>
                                <div class="col-auto">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input Filter" type="checkbox" value=""
                                            id="Me">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Tampilkan Hanya Saya
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <br>
                        <div class="scrollmenu">
                            <table id="table_ListOrder" class="table table-bordered table-striped" style="width:100%">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>No. Trans</th>
                                        <th class="RDZCenterTable">Tanggal<br><label
                                                style="font-size: 10px; margin-bottom: 0px;">(MM-DD-YYYY)</label></th>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>User</th>
                                        <th>Divisi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        {{-- @php
                                            dd($item);
                                        @endphp --}}
                                        <tr>
                                            <td><a data-id="{{ $item->No_trans }}" class="Detail_ListOrder" id="NoTrans"
                                                    href="">{{ $item->No_trans }}</a></td>
                                            <td>{{ date('m-d-Y', strtotime($item->Tgl_order)) }}</td>
                                            <td>{{ $item->Kd_brg }}</td>
                                            <td>{{ $item->NAMA_BRG }} <label
                                                    style="background-color:#00ff00;">{{ $item->Qty }}
                                                    {{ $item->Nama_satuan }}</label></td>
                                            <td>{{ $item->Pemesan }}</td>
                                            <td>{{ trim($item->NM_DIV) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div>
                            <p style="color: red;font-size: smaller;">Harap diperhatikan! <br>Untuk melakukan Maintenance
                                Order yang
                                memiliki status <b>SAVED</b>, filter dulu tabel ordernya baru double klik pada baris data
                                yang mau diproses </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_tambahOrder" tabindex="-1">
        <div class="modal-dialog custom-modal-width">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabelOrderBeli">Tambah Order</h5>
                    <button type="button" class="close" id="closeModalButton">
                        <span>×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-md-11 RDZMobilePaddingLR0">
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <div class="row">
                                        <div class="col-4 col-md-2">
                                            <label for="no_order">Nomer Order</label>
                                        </div>
                                        <div class="col-8 col-md-10">
                                            <input type="text" class="form-control" id="no_order" name="no_order"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="col-12 mb-2">
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
                                </div> --}}
                                <div class="col-12 mb-2">
                                    <div class="row">
                                        <div class="col-4 col-md-2">
                                            <label for="tgl_mohonKirim">Tanggal Mohon Kirim</label>
                                        </div>
                                        <div class="col-8 col-md-10">
                                            <input type="date" name="tgl_mohonKirim" id="tgl_mohonKirim"
                                                class="form-control">
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
                                                <option class="w-100 text-center" selected disabled>-- Pilih Divisi
                                                    --
                                                </option>
                                                @foreach ($dataDiv as $item1)
                                                    <option value="{{ $item1->Kd_div }}">{{ $item1->NM_DIV }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-2">
                                            <input type="text" class="form-control" id="selectedDivisi"
                                                name="selectedDivisi" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="row">
                                        <div class="col-4 col-md-2">
                                            <label for="golongan">Golongan</label>
                                        </div>
                                        <div class="col-8 col-md-10">
                                            <select name="select_golongan" id="select_golongan" class="w-100 input">
                                                <option class="w-100 text-center" selected disabled>-- Pilih
                                                    Golongan --
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="row">
                                        <div class="col-4 col-md-2">
                                            <label for="mesinGolongan">Kelompok</label>
                                        </div>
                                        <div class="col-8 col-md-10">
                                            <select name="select_mesinGolongan" id="select_mesinGolongan"
                                                class="w-100 input">
                                                <option class="w-100 text-center" selected disabled>-- Pilih Mesin
                                                    Golongan --
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
                                        <img src="" style="width: 10rem; height: 10rem;" id="foto"
                                            alt="">
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
                                                <option class="w-100 text-center" selected disabled>-- Pilih
                                                    Kategori Utama --
                                                </option>
                                                @foreach ($kategoriUtama as $katUtama)
                                                    <option value="{{ $katUtama->no_kat_utama }}">{{ $katUtama->nama }}
                                                    </option>
                                                @endforeach
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
                                                <option class="w-100 text-center" selected disabled>-- Pilih
                                                    Kategori --
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
                                            <select name="select_subKategori" id="select_subKategori"
                                                class="w-100 input">
                                                <option class="w-100 text-center" selected disabled>-- Pilih Sub
                                                    Kategori --
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
                                                <option class="w-100 text-center" selected disabled>-- Pilih Nama
                                                    Barang --
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
                                            <label for="satuanUmum">Satuan Umum</label>
                                        </div>
                                        <div class="col-8 col-md-10">
                                            <select name="select_satuanUmum" id="select_satuanUmum" class="w-100 input">
                                                @foreach ($satuanList as $satuan)
                                                    <option value="{{ $satuan->No_satuan }}">{{ $satuan->Nama_satuan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="row">
                                        <div class="col-4 col-md-2">
                                            <label for="ket_order">Keterangan Order</label>
                                        </div>
                                        <div class="col-8 col-md-10">
                                            <textarea type="text" class="w-100 h-100 " id="ket_order" name="ket_order" rows="4"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="row">
                                        <div class="col-4 col-md-2">
                                            <label for="qty_order">Qty Order</label>
                                        </div>
                                        <div class="col-6 col-md-8">
                                            <input type="text" class="form-control" id="qty_order" name="qty_order"
                                                value="1">
                                        </div>
                                        <div class="col-2">
                                            <input type="text" class="form-control" id="ketStatusOrder"
                                                name="ketStatusOrder" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-6 col-md-2">
                        <button type="button" class="w-100 btn btn-primary" id="btn_submit">Submit</button>
                    </div>
                    <div class="col-6 col-md-2">
                        <button type="button" class="w-100 btn btn-danger" id="btn_delete">Delete</button>
                    </div>
                    <div class="col-6 col-md-2">
                        <button type="button" class="w-100 btn btn-secondary" id="btn_clear">Clear</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/OrderPembelian/ListOrder/ListOrder.js') }}"></script>
@endsection
