@extends('layouts.appAccounting')
@section('content')
@section('title', 'MP Isi Detail')

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10 RDZMobilePaddingLR0">
                <div class="card">
                    <div class="card-header">ISI Data SPPB</div>
                    <div class="card-body RDZOverflow RDZMobilePaddingLR0">
                        <div class="form-container col-md-12">
                            <form method="POST" action="">
                                @csrf
                                <!-- Form fields go here -->
                                <div class="card-container" style="display: flex;">
                                    <div style="width: 40%;">
                                        <div>
                                            <div class="d-flex">
                                                <div class="col-md-3">
                                                    <label for="po" style="margin-right: 10px;">PO</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" id="noPO" class="form-control" style="width: 100%">
                                                </div>
                                                <div class="col-md-1">
                                                    <label for="divisi" style="margin-right: 10px;">Divisi</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" id="namaDivisi" name="namaDivisi" class="form-control" style="width: 100%">
                                                </div>
                                                <div class="col-md-1">
                                                    <select name="nama_select" id="idDivisi" name="idDivisi" class="form-control">
                                                        <option disabled selected>-- Pilih Divisi --</option>
                                                        @foreach ($divisi as $d)
                                                        <option value="{{ $d->KD_DIV }}">{{ $d->KD_DIV }} | {{ $d->NM_DIV }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="d-flex">
                                                <div class="col-md-3">
                                                    <label for="idPenagihan" style="margin-right: 10px;">ID. Penagihan</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" id="idPenagihan" name="idPenagihan" class="form-control" style="width: 100%">
                                                </div>
                                            </div>
                                        </div>

                                        <!--CARD 2-->
                                        <div class="card" style>
                                            <b>Data PO</b>
                                            <div class="d-flex">
                                                <div class="col-md-3">
                                                    <label for="noBttb" style="margin-right: 10px;">No. BTTB</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="number" id="noBttb" name="noBttb" class="form-control" style="width: 100%">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="kodeBarang" style="margin-right: 10px;">Kd. Barang</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="number" id="kodeBarang" name="kodeBarang" class="form-control" style="width: 100%">
                                                </div>
                                            </div>
                                            <div class="d-flex">
                                                <div class="col-md-3">
                                                    <label for="namaBarang" style="margin-right: 10px;">Nm. Barang</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <input type="text" id="namaBarang" name="namaBarang" class="form-control" style="width: 100%">
                                                </div>
                                            </div>

                                            <hr style="height:2px;">
                                            <div style="overflow-y: auto; height: 400px;">
                                                <table style="width: 500%; table-layout: fixed;" id="tabelPO">
                                                    <colgroup>
                                                    <col style="width: 25%;">
                                                    <col style="width: 25%;">
                                                    <col style="width: 25%;">
                                                    <col style="width: 25%;">
                                                    <col style="width: 25%;">
                                                    <col style="width: 25%;">
                                                    <col style="width: 25%;">
                                                    <col style="width: 25%;">
                                                    <col style="width: 25%;">
                                                    <col style="width: 25%;">
                                                    <col style="width: 25%;">
                                                    <col style="width: 25%;">
                                                    <col style="width: 25%;">
                                                    <col style="width: 25%;">
                                                    <col style="width: 25%;">
                                                    <col style="width: 25%;">
                                                    <col style="width: 25%;">
                                                    <col style="width: 25%;">
                                                    <col style="width: 25%;">
                                                    <col style="width: 25%;">
                                                    </colgroup>
                                                    <thead class="table-dark">
                                                    <tr>
                                                        <th>Divisi</th>
                                                        <th>No. SJ</th>
                                                        <th>No. BTTB</th>
                                                        <th>Spesifikasi</th>
                                                        <th>Qty</th>
                                                        <th>Satuan</th>
                                                        <th>MataUang</th>
                                                        <th>Hrg. Satuan</th>
                                                        <th>Total Harga</th>
                                                        <th>Kurs</th>
                                                        <th>Hrg. Disc</th>
                                                        <th>Hrg. PPN</th>
                                                        <th>Hrg. Terbayar</th>
                                                        <th>Hrg. TerbayarRp</th>
                                                        <th>Tgl. Datang</th>
                                                        <th>Tgl. Faktur</th>
                                                        <th>Disc</th>
                                                        <th>PPN</th>
                                                        <th>Lunas</th>
                                                        <th>No. Terima</th>
                                                    </tr>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>Data 1</td>
                                                        <td>Data 2</td>
                                                        <td>Data 3</td>
                                                        <td>Data 4</td>
                                                        <td>Data 5</td>
                                                        <td>Data 6</td>
                                                        <td>Data 7</td>
                                                        <td>Data 8</td>
                                                        <td>Data 9</td>
                                                        <td>Data 10</td>
                                                        <td>Data 11</td>
                                                        <td>Data 12</td>
                                                        <td>Data 13</td>
                                                        <td>Data 14</td>
                                                        <td>Data 15</td>
                                                        <td>Data 16</td>
                                                        <td>Data 17</td>
                                                        <td>Data 18</td>
                                                        <td>Data 19</td>
                                                        <td>Data 20</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <!--CARD 2-->
                                    <div class="card" style="width: 60%;">
                                        <div >
                                            <div class="card-body">
                                                <b>Data PENAGIHAN</b>
                                                <div class="d-flex">
                                                    <div class="col-md-2">
                                                        <label for="qtyTagihan" style="margin-right: 10px;">Qty Tagihan</label>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="number" id="qtyTagihan" name="qtyTagihan" class="form-control" style="width: 100%">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <select name="qtyTagihanSelect" id="qtyTagihanSelect" class="form-control">
                                                            <option disabled selected>-- Pilih No. --</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="mataUang" style="margin-right: 10px;">MataUang</label>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="number" id="mataUang" name="mataUang" class="form-control" style="width: 100%">
                                                    </div>
                                                </div>
                                                <div class="d-flex">
                                                    <div class="col-md-2">
                                                        <label for="kurs" style="margin-right: 10px;">Kurs</label>
                                                    </div>
                                                    <div class="col-md-7">
                                                        <input type="text" id="kurs" name="kurs" class="form-control" style="width: 100%">
                                                    </div>
                                                </div>
                                            </div>

                                            <hr style="height:2px;">
                                            <div class="d-flex">
                                                <div class="col-md-3">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="hargaSatuan" style="margin-right: 10px;">Harga Satuan</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="number" id="hargaSatuan" name="hargaSatuan" class="form-control" style="width: 100%">
                                                </div>
                                                <div class="col-md-1">
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="number" id="hargaSatuanRp" class="form-control" style="width: 100%">
                                                </div>
                                            </div>
                                            <div class="d-flex">
                                                <div class="col-md-3">

                                                </div>
                                                <div class="col-md-2">
                                                    <label for="hargaMurni" style="margin-right: 10px;">Hrg.Murni</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="number" id="hargaMurni" name="hargaMurni" class="form-control" style="width: 100%">
                                                </div>
                                                <div class="col-md-1">
                                                    <label for="hargaMurniRp" style="margin-right: 10px;">Rp</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="number" id="hargaMurniRp" name="hargaMurniRp" class="form-control" style="width: 100%">
                                                </div>
                                            </div>
                                            <div class="d-flex">
                                                <div class="col-md-1">
                                                    <label for="disc">Disc  %</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="number" id="disc" name="disc" class="form-control" style="width: 100%">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="hargaDisc" style="margin-right: 10px;">Hrg.Disc</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="number" id="hargaDisc" name="hargaDisc" class="form-control" style="width: 100%">
                                                </div>
                                                <div class="col-md-1">
                                                    <label for="hargaDiscRp" style="margin-right: 10px;">Rp</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="number" id="hargaDiscRp" name="hargaDiscRp" class="form-control" style="width: 100%">
                                                </div>
                                            </div>
                                            <div class="d-flex">
                                                <div class="col-md-1">
                                                    <label for="ppn">PPN  %</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="number" id="ppn" name="ppn" class="form-control" style="width: 100%">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="hargaPpn" style="margin-right: 10px;">Hrg.PPN</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="number" id="hargaPpn" name="hargaPpn" class="form-control" style="width: 100%">
                                                </div>
                                                <div class="col-md-1">
                                                    <label for="hargaPpnRp" style="margin-right: 10px;">Rp</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="number" id="hargaPpnRp" name="hargaPpnRp" class="form-control" style="width: 100%">
                                                </div>
                                            </div>
                                            <div class="d-flex">
                                                <div class="col-md-3">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="subtotalHarga" style="margin-right: 10px;">Subtotal Hrg</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="number" id="subtotalHarga" name="subtotalHarga" class="form-control" style="width: 100%">
                                                </div>
                                                <div class="col-md-1">
                                                    <label for="subtotalHargaRp" style="margin-right: 10px;">Rp</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="number" id="subtotalHargaRp" name="subtotalHargaRp" class="form-control" style="width: 100%">
                                                </div>
                                            </div>

                                            <hr style="height:2px;">
                                            <div class="row" style="margin-left: 10px;">
                                                <div class="col-md-7"></div>
                                                <div class="col-md-2">
                                                    <input type="submit" name="btnIsi" id="btnIsi" value="ISI" class="btn btn-primary d-flex ml-auto">
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="submit" name="btnKoreksi" id="btnKoreksi" value="Koreksi" class="btn btn-primary d-flex ml-auto">
                                                </div>
                                            </div>
                                            <hr style="height:2px;">

                                            <div class="card-body">
                                                <div style="overflow-y: auto; max-height: 250px;">
                                                    <table style="width: 400%; table-layout: fixed;" id="tabelPenagihan">
                                                        <colgroup>
                                                        <col style="width: 25%;">
                                                        <col style="width: 25%;">
                                                        <col style="width: 25%;">
                                                        <col style="width: 25%;">
                                                        <col style="width: 25%;">
                                                        <col style="width: 25%;">
                                                        <col style="width: 25%;">
                                                        <col style="width: 25%;">
                                                        <col style="width: 25%;">
                                                        <col style="width: 25%;">
                                                        <col style="width: 25%;">
                                                        <col style="width: 25%;">
                                                        <col style="width: 25%;">
                                                        <col style="width: 25%;">
                                                        <col style="width: 25%;">
                                                        <col style="width: 25%;">
                                                        </colgroup>
                                                        <thead class="table-dark">
                                                        <tr>
                                                            <th>No. BTTB</th>
                                                            <th>Hrg.Sat</th>
                                                            <th>Kurs</th>
                                                            <th>Disc</th>
                                                            <th>PPN</th>
                                                            <th>HrgDisc</th>
                                                            <th>HrgPPN</th>
                                                            <th>Qty. Tagih</th>
                                                            <th>Satuan</th>
                                                            <th>Hrg Murni</th>
                                                            <th>HrgSat_Rp</th>
                                                            <th>HrgMurni_Rp</th>
                                                            <th>HrgDisc_Rp</th>
                                                            <th>HrgPpn_Rp</th>
                                                            <th>No. Terima</th>
                                                            <th>Kd. Barang</th>
                                                        </tr>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td>Data 1</td>
                                                            <td>Data 2</td>
                                                            <td>Data 3</td>
                                                            <td>Data 4</td>
                                                            <td>Data 5</td>
                                                            <td>Data 6</td>
                                                            <td>Data 7</td>
                                                            <td>Data 8</td>
                                                            <td>Data 9</td>
                                                            <td>Data 10</td>
                                                            <td>Data 11</td>
                                                            <td>Data 12</td>
                                                            <td>Data 13</td>
                                                            <td>Data 14</td>
                                                            <td>Data 15</td>
                                                            <td>Data 16</td>
                                                        </tr>
                                                        <!-- Tambahkan baris lainnya jika diperlukan -->
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div >
                                    <div class="row">
                                        <div class="col-md-10"></div>
                                        <div class="col-md-1">
                                            <input type="submit" name="btnSimpan" id="btnSimpan" value="SIMPAN" class="btn btn-primary d-flex ml-auto">
                                        </div>
                                        <div class="col-md-1">
                                            <input type="submit" name="btnTutup" id="btnTutup" value="TUTUP" class="btn btn-primary d-flex ml-auto">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="{{ asset('js/Hutang/MPIsiDetail.js') }}"></script>
@endsection
