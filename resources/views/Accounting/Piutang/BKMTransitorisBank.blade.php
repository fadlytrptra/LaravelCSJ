@extends('layouts.appAccounting')
@section('content')
@section('title', 'BKM Transitoris Bank')

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12 RDZMobilePaddingLR0">
                <div class="card">
                    <div class="card-header">BKM Transitoris Bank</div>
                    <div class="card-body RDZOverflow RDZMobilePaddingLR0">
                        <div class="form-container col-md-12">
                            <form method="POST" action="">
                                @csrf
                                <!-- Form fields go here -->
                                <div class="card-container" style="display: flex;">
                                    <div style="width: 60%;">
                                        <div class="card" style>
                                            <b>BKK</b>
                                            <div class="d-flex">
                                                <div class="col-md-3">
                                                    <label for="tanggal" style="margin-right: 10px;">Tanggal</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="date" id="tanggal" name="tanggal" class="form-control" style="width: 100%">
                                                </div>
                                                <div class="col-md-3">
                                                    Wajib di-ENTER
                                                </div>
                                            </div>
                                            <div class="d-flex">
                                                <div class="col-md-3">
                                                    <label for="idBKK" style="margin-right: 10px;">Id. BKK</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" id="idBKK" name="idBKK" class="form-control" style="width: 100%">
                                                </div>
                                            </div>
                                            <div class="d-flex">
                                                <div class="col-md-3">
                                                    <label for="mataUangSelect" style="margin-right: 10px;">Mata Uang</label>
                                                </div>
                                                <div class="col-md-5">
                                                    <select name="mataUangSelect" id="mataUangSelect" class="form-control">

                                                    </select>
                                                </div>
                                                <input type="text" id="idMataUang" name="idMataUang" class="form-control" style="width: 100%">
                                            </div>
                                            <div class="d-flex">
                                                <div class="col-md-3">
                                                    <label for="jumlahUang" style="margin-right: 10px;">Jumlah Uang</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="number" id="jumlahUang" name="jumlahUang" class="form-control" style="width: 100%">
                                                </div>
                                            </div>
                                            <div class="d-flex">
                                                <div class="col-md-3">
                                                    <label for="namaBankSelect" style="margin-right: 10px;">Bank</label>
                                                </div>
                                                <div class="col-md-5">
                                                    <select name="namaBankSelect" id="namaBankSelect" class="form-control">

                                                    </select>
                                                </div>
                                                <div class="col-3">
                                                    <input type="submit" id="btnTambahBiaya" name="btnTambahBiaya" value="Tambah Biaya" class="btn btn-primary" disabled>
                                                </div>
                                            </div>
                                            <!----->
                                            <input type="text" id="idBankBKK" name="idBankBKK" class="form-control" style="width: 100%">
                                            <input type="text" id="jenisBank" name="jenisBank" class="form-control" style="width: 100%">
                                            <!---->

                                            <div class="d-flex">
                                                <div class="col-md-3">
                                                    <label for="jenisPembayaranSelect" style="margin-right: 10px;">Jenis Pembayaran</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <select name="jenisPembayaranSelect" id="jenisPembayaranSelect" class="form-control">

                                                    </select>
                                                </div>
                                                <div class="col-3" style="padding-left: 40px">
                                                    <input type="submit" id="btnDetailBG" name="btnDetailBG" value="Detail BG/CEK/Transfer/DBT" class="btn btn-primary">
                                                </div>
                                            </div>
                                            <input type="text" id="namaJenisPembayaran" name="namaJenisPembayaran" class="form-control" style="width: 100%">
                                            <input type="text" id="idJenisPembayaran" name="idJenisPembayaran" class="form-control" style="width: 100%">
                                            <div class="d-flex">
                                                <div class="col-md-3">
                                                    <label for="kodePerkiraan" style="margin-right: 10px;">Kode Perkiraan</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="number" id="idKodePerkiraan" name="idKodePerkiraan" class="form-control" style="width: 100%">
                                                </div>
                                                <div class="col-md-5">
                                                    <select name="kodePerkiraanSelect" id="kodePerkiraanSelect" class="form-control">

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="d-flex">
                                                <div class="col-md-3">
                                                    <label for="uraian" style="margin-right: 10px;">Uraian</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <input type="text" id="uraian" name="uraian" class="form-control" style="width: 100%">
                                                </div>
                                            </div>
                                        </div>

                                        <!--CARD 2-->
                                        {{-- <div class="card disabled" id="cardBKM"> --}}
                                        <div class="card " id="cardBKM">
                                            <b>BKM</b>
                                            <div class="d-flex">
                                                <div class="col-md-3">
                                                    <label for="tanggalBKM" style="margin-right: 10px;">Tanggal</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="date" id="tanggalBKM" name="tanggalBKM" class="form-control" style="width: 100%">
                                                </div>
                                                <div class="col-md-3">
                                                    Wajib di-ENTER
                                                </div>
                                            </div>
                                            <div class="d-flex">
                                                <div class="col-md-3">
                                                    <label for="idBKM" style="margin-right: 10px;">Id. BKM</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" id="idBKM" name="idBKM" class="form-control" style="width: 100%">
                                                </div>
                                            </div>
                                            <div class="d-flex">
                                                <div class="col-md-3">
                                                    <label for="mataUangBKMSelect" style="margin-right: 10px;">Mata Uang</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <select id="mataUangBKMSelect" name="mataUangBKMSelect" class="form-control">
                                                    </select>
                                                </div>
                                                <div class="col-md-1">
                                                    <label for="kurs" style="margin-right: 10px;">Kurs</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="number" id="kurs" name="kurs" class="form-control" style="width: 100%">
                                                </div>
                                                <input type="text" id="idMataUangBKM" name="idMataUangBKM" class="form-control" style="width: 100%">
                                            </div>
                                            <div class="d-flex">
                                                <div class="col-md-3">
                                                    <label for="jumlahUangBKM" style="margin-right: 10px;">Jumlah Uang</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="number" id="jumlahUangBKM" name="jumlahUangBKM" class="form-control" style="width: 100%">
                                                </div>
                                            </div>
                                            <div class="d-flex">
                                                <div class="col-md-3">
                                                    <label for="namaBankBKMSelect" style="margin-right: 10px;">Bank</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <select id="namaBankBKMSelect" name="namaBankBKMSelect" class="form-control">
                                                    </select>
                                                </div>
                                            </div>
                                            <!----->
                                            <input type="text" id="idBankBKM" name="idBankBKM" class="form-control" style="width: 100%">
                                            <input type="text" id="jenisBankBKM" name="jenisBankBKM" class="form-control" style="width: 100%">
                                            <!---->
                                            <div class="d-flex">
                                                <div class="col-md-3">
                                                    <label for="jenisPembayaranBKMSelect" style="margin-right: 10px;">Jenis Pembayaran</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <select id="jenisPembayaranBKMSelect" name="jenisPembayaranBKMSelect" class="form-control">

                                                    </select>
                                                </div>
                                                <div class="col-3" style="padding-left: 70px">
                                                    <input type="submit" id="btnTambahBiayaBKM" name="btnTambahBiayaBKM" value="Tambah Biaya" class="btn btn-primary d-flex ml-auto" disabled>
                                                </div>
                                            </div>
                                            <input type="text" id="idJenisPembayaranBKM" name="idJenisPembayaranBKM" class="form-control" style="width: 100%">
                                            <div class="d-flex">
                                                <div class="col-md-3">
                                                    <label for="kodePerkiraanBKMSelect" style="margin-right: 10px;">Kode Perkiraan</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="number" id="idKodePerkiraanBKMSelect" name="idKodePerkiraanBKMSelect" class="form-control" style="width: 100%">
                                                </div>
                                                <div class="col-md-3">
                                                    <select id="kodePerkiraanBKMSelect" name="kodePerkiraanBKMSelect" class="form-control">

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="d-flex">
                                                <div class="col-md-3">
                                                    <label for="uraianBKM" style="margin-right: 10px;">Uraian</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <input type="text" id="uraianBKM" name="uraianBKM" class="form-control" style="width: 100%">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--CARD 2-->
                                    <div style="width: 40%;">
                                        <div >
                                            <div class="card-body">
                                                <b>Detail Biaya BKK</b>
                                                <div style="overflow-y: auto; max-height: 250px;">
                                                    <table style="width: 120%; table-layout: fixed;" id="tabelDetailBiayaBKK">
                                                        <colgroup>
                                                            <col style="width: 40%;">
                                                            <col style="width: 40%;">
                                                            <col style="width: 40%;">
                                                        </colgroup>
                                                        <thead class="table-dark">
                                                            <tr>
                                                                <th>Keterangan</th>
                                                                <th>Biaya</th>
                                                                <th>Kode Perkiraan</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <input type="submit" id="btnKoreksiBiayaBKK" name="btnKoreksiBiayaBKK" value="Koreksi Biaya" class="btn btn-primary">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="submit" name="hapusbiaya" value="Hapus Biaya" class="btn btn-primary">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="card-body">
                                                <b>Detail BG/CEK/TRANSFER BKK</b>
                                                <div style="overflow-y: auto; max-height: 250px;">
                                                    <table style="width: 100%; table-layout: fixed;" id="tabelDetailBG">
                                                        <colgroup>
                                                            <col style="width: 33%;">
                                                            <col style="width: 33%;">
                                                            <col style="width: 33%;">
                                                        </colgroup>
                                                        <thead class="table-dark">
                                                            <tr>
                                                                <th>Nomor</th>
                                                                <th>Jatuh Tempo</th>
                                                                <th>Status Cetak</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <input type="submit" id="btnKoreksiDetailBG" name="btnKoreksiDetailBG" value="Koreksi No BG" class="btn btn-primary">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="submit" name="hapusbg" value="Hapus BG" class="btn btn-primary">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <b>Detail Biaya BKM</b>
                                                <div style="overflow-y: auto; max-height: 250px;">
                                                    <table style="width: 100%; table-layout: fixed;" id="tabelDetailBiayaBKM">
                                                        <colgroup>
                                                            <col style="width: 33%;">
                                                            <col style="width: 33%;">
                                                            <col style="width: 33%;">
                                                        </colgroup>
                                                        <thead class="table-dark">
                                                            <tr>
                                                                <th>Keterangan</th>
                                                                <th>Biaya</th>
                                                                <th>Kode Perkiraan</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <input type="submit" id="btnKoreksiBiayaBKM" name="btnKoreksiBiayaBKM" value="Koreksi Biaya" class="btn btn-primary">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="submit" name="hapusbiaya" value="Hapus Biaya" class="btn btn-primary">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div >
                                    <div class="row">
                                        <div class="col-md-1">
                                            <input type="submit" name="proses" value="PROSES" class="btn btn-primary">
                                        </div>
                                        <div class="col-md-1">
                                            <input type="submit" id="btnKoreksi" name="btnKoreksi" value="KOREKSI" class="btn btn-primary">
                                        </div>
                                        <div class="col-md-1">
                                            <input type="submit" id="btnBatal" name="btnBatal" value="Batal" class="btn btn-primary d-flex ml-auto">
                                        </div>
                                        <div class="col-md-1">
                                            <input type="submit" id="btnTampilBKM" name="btnTampilBKM" value="TampilBKM" class="btn btn-primary d-flex ml-auto">
                                        </div>
                                        <div class="col-md-1" style="padding-left: 30px">
                                            <input type="submit" id="btnTampilBKK" name="btnTampilBKK" value="TampilBKK" class="btn btn-primary d-flex ml-auto">
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <!--MODAL TAMBAH BIAYA BKK-->
                            <div class="modal fade" id="modalTambahBiaya" tabindex="-1" role="dialog"
                                aria-labelledby="pilihBankModal" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="pilihBankModal">Maintenance Biaya BKK Transitoris</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ url('BKMTransitorisBank') }}" id="formTambahBiaya"
                                            method="POST">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" id="methodTambahBiaya">
                                            <div class="d-flex">
                                                <div class="col-md-3">
                                                    <label for="jumlahBiaya" style="margin-right: 10px;">Jumlah Biaya</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" id="jumlahBiaya" name="jumlahBiaya" class="form-control" style="width: 100%">
                                                </div>
                                                {{-- <input type="hidden" name="idcoba" id="idcoba" value="idcoba"> --}}
                                            </div>
                                            <div class="d-flex">
                                                <div class="col-md-3">
                                                    <label for="kodePerkiraanTambahBiayaSelect" style="margin-right: 10px;">Kode Perkiraan</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" id="idKodePerkiraanTambahBiaya" name="idKodePerkiraanKrgLbh" class="form-control" style="width: 100%">
                                                </div>
                                                <div class="col-md-7">
                                                    <select name="kodePerkiraanTambahBiayaSelect" id="kodePerkiraanTambahBiayaSelect" class="form-control">

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="d-flex">
                                                <div class="col-md-3">
                                                    <label for="keterangan" style="margin-right: 10px;">Keterangan</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" id="keterangan" name="keterangan"
                                                        class="form-control" style="width: 100%">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-5">
                                                    <input type="submit" id="btnProsesTambahBiaya" name="btnProsesTambahBiaya" value="Proses" class="btn btn-primary">
                                                </div>
                                                <div class="col-3">
                                                </div>
                                                <div class="col-4">
                                                    <input type="submit" id="btnTutupModal" name="btnTutupModal"
                                                        value="Tutup" class="btn btn-primary">
                                                </div>
                                            </div>
                                            <input type="hidden" name="detpelunasan" id="detpelunasan" value="detkuranglebih">
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!--MODAL DETAIL BG/CEK/TRANSFER/DBT-->
                            <div class="modal fade" id="modalDetailBG" tabindex="-1" role="dialog" aria-labelledby="pilihBankModal" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Maintenance Detail BG/CEK/TRANSFER/DBT LSG</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ url('BKMTransitorisBank') }}" id="formDetailBG"  method="POST">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" id="methodDetailBG">
                                            <div class="d-flex">
                                                <div class="col-md-3">
                                                    <label for="bank" style="margin-right: 10px;">Bank</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" id="bank" name="bank" class="form-control" style="width: 100%">
                                                </div>
                                            </div>
                                            <div class="d-flex">
                                                <div class="col-md-3">
                                                    <label for="jenisPembayaran" style="margin-right: 10px;">Jenis Pembayaran</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" id="jenisPembayaran" name="jenisPembayaran" class="form-control" style="width: 100%">
                                                </div>
                                            </div>
                                            <div class="d-flex">
                                                <div class="col-md-3">
                                                    <label for="nomor" style="margin-right: 10px;">Nomor</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" id="nomor" name="nomor" class="form-control" style="width: 100%">
                                                </div>
                                            </div>
                                            <div class="d-flex">
                                                <div class="col-md-3">
                                                    <label for="jatuhTempo" style="margin-right: 10px;">Jatuh Tempo</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="date" id="jatuhTempo" name="jatuhTempo" class="form-control" style="width: 100%">
                                                </div>
                                            </div>
                                            <div class="d-flex">
                                                <div class="col-md-3">
                                                    <label for="statusCetak" style="margin-right: 10px;">Status Cetak [T,O,S]</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" id="statusCetak" name="statusCetak" class="form-control" style="width: 100%">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-5">
                                                    <input type="submit" id="btnProsesDetailBG" name="btnProsesDetailBG" value="Proses" class="btn btn-primary">
                                                </div>
                                                <div class="col-3">
                                                </div>
                                                <div class="col-4">
                                                    <input type="submit" id="btnTutupModal" name="btnTutupModal"
                                                        value="Tutup" class="btn btn-primary">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!--MODAL TAMBAH BIAYA BKM-->
                            <div class="modal fade" id="modalTambahBiayaBKM" tabindex="-1" role="dialog"
                                aria-labelledby="pilihBankModal" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="pilihBankModal">Maintenance Biaya BKM Transitoris</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ url('BKMTransitorisBank') }}" id="formTambahBiayaBKM"
                                            method="POST">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" id="methodTambahBiayaBKM">
                                            <div class="d-flex">
                                                <div class="col-md-3">
                                                    <label for="jumlahBiayaBKM" style="margin-right: 10px;">Jumlah Biaya</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" id="jumlahBiayaBKM" name="jumlahBiayaBKM" class="form-control" style="width: 100%">
                                                </div>
                                                {{-- <input type="hidden" name="idcoba" id="idcoba" value="idcoba"> --}}
                                            </div>
                                            <div class="d-flex">
                                                <div class="col-md-3">
                                                    <label for="kodePerkiraanBKMTSelect" style="margin-right: 10px;">Kode Perkiraan</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" id="idKodePerkiraanBKMT" name="idKodePerkiraanBKMT" class="form-control" style="width: 100%">
                                                </div>
                                                <div class="col-md-7">
                                                    <select name="kodePerkiraanBKMTSelect" id="kodePerkiraanBKMTSelect" class="form-control">

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="d-flex">
                                                <div class="col-md-3">
                                                    <label for="keteranganBKM" style="margin-right: 10px;">Keterangan</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" id="keteranganBKM" name="keteranganBKM" class="form-control" style="width: 100%">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-5">
                                                    <input type="submit" id="btnProsesTambahBiayaBKM" name="btnProsesTambahBiayaBKM" value="Proses" class="btn btn-primary">
                                                </div>
                                                <div class="col-3">
                                                </div>
                                                <div class="col-4">
                                                    <input type="submit" id="btnTutupModal" name="btnTutupModal"
                                                        value="Tutup" class="btn btn-primary">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!--MODAL TAMPIL BKM-->
                            <div class="modal fade" id="modalTampilBKM" tabindex="-1" role="dialog"
                                aria-labelledby="pilihBankModal" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content" style="padding: 25px;">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Cetak BKM Transitoris</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ url('BKMTransitorisBank') }}" id="formTampilBKM" method="POST">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" id="methodTampilBKM">
                                            <div class="d-flex">
                                                <div class="col-md-3">
                                                    <label for="tanggalInputTampilBKM" style="margin-right: 10px;">Tanggal Input</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="date" id="tanggalInputTampilBKM" name="tanggalInputTampilBKM" class="form-control" style="width: 100%">
                                                </div>
                                                <div class="col-md-1">
                                                S/D
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="date" id="tanggalInputTampilBKM2" name="tanggalInputTampilBKM2" class="form-control" style="width: 100%">
                                                </div>
                                                <div class="col-md-3">
                                                    <button id="btnOkTampilBKM" name="btnOkTampilBKM">OK</button>
                                                </div>
                                            </div>
                                            <div class="d-flex">
                                                <div class="col-md-3">
                                                    <label for="idTampilBKM" style="margin-right: 10px;">Id. BKM</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" id="idTampilBKM" name="idTampilBKM" class="form-control" style="width: 100%">
                                                </div>
                                                <div class="col-md-3">
                                                    <button id="btnCetakBKM" name="btnCetakBKM">CETAK</button>
                                                </div>
                                            </div>
                                            <div style="overflow-x: auto; overflow-y: auto; max-height: 250px;">
                                                <table style="width: 120%; table-layout: fixed;"id="tabelTampilBKM">
                                                    <colgroup>
                                                        <col style="width: 30%;">
                                                        <col style="width: 30%;">
                                                        <col style="width: 30%;">
                                                        <col style="width: 30%;">
                                                    </colgroup>
                                                    <thead class="table-dark">
                                                        <tr>
                                                            <th>Tgl. Input</th>
                                                            <th>Id. BKM</th>
                                                            <th>Nilai Pelunasan</th>
                                                            <th>Terjemahan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <input type="hidden" name="cetak" id="cetak" value="tampilBKM">
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!--MODAL TAMPIL BKK-->
                            <div class="modal fade" id="modalTampilBKK" tabindex="-1" role="dialog" aria-labelledby="pilihBankModal" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content" style="padding: 25px;">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Cetak BKK Transitoris</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ url('BKMTransitorisBank') }}" id="formTampilBKK" method="post">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" id="methodTampilBKK">
                                            <div class="d-flex">
                                                <div class="col-md-3">
                                                    <label for="tanggalInputTampil" style="margin-right: 10px;">Tanggal Input</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="date" id="tanggalInputTampilBKK" name="tanggalInputTampilBKK" class="form-control" style="width: 100%">
                                                </div>
                                                <div class="col-md-1">
                                                S/D
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="date" id="tanggalInputTampilBKK2" name="tanggalInputTampilBKK2" class="form-control" style="width: 100%">
                                                </div>
                                                <div class="col-md-3">
                                                    <button id="btnOkTampilBKK" name="btnOkTampilBKK">OK</button>
                                                </div>
                                            </div>
                                            <div class="d-flex">
                                                <div class="col-md-3">
                                                    <label for="idBKK" style="margin-right: 10px;">Id. BKK</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" id="idTampilBKK" name="idTampilBKK" class="form-control" style="width: 100%">
                                                </div>
                                                <div class="col-md-2">
                                                    <button id="btnCetakBKK" name="btnCetakBKK">CETAK</button>
                                                </div>
                                            </div>
                                            <div style="overflow-x: auto; overflow-y: auto; max-height: 250px;">
                                                <table style="width: 120%; table-layout: fixed;"id="tabelTampilBKK">
                                                    <colgroup>
                                                        <col style="width: 30%;">
                                                        <col style="width: 30%;">
                                                        <col style="width: 30%;">
                                                        <col style="width: 30%;">
                                                    </colgroup>
                                                    <thead class="table-dark">
                                                        <tr>
                                                            <th>Tgl. Input</th>
                                                            <th>Id. BKK</th>
                                                            <th>Nilai Pelunasan</th>
                                                            <th>Terjemahan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <input type="hidden" name="cetak" id="cetak" value="tampilBKK">
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="{{ asset('js/Piutang/BKMTransitorisBank.js') }}"></script>
@endsection
