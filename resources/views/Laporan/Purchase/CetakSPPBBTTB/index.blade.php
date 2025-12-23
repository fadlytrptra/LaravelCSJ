@extends('layouts.appOrderPembelian')
@section('content')
@section('title', 'Cetak BKM')
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
@if (session('error'))
    <script>
        window.close();
    </script>
@endif
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 RDZMobilePaddingLR0">
            <div class="card font-weight-bold">
                <div class="card-header">Cetak BKM</div>
                <div class="card-body">
                    <div style="display: flex; flex-direction: row">
                        <div class="p-2" style="display: flex; flex-direction: row;">
                            <input style="margin-right: 5px" type="radio" name="radio_jenisCetak" id="radio_jenisSPPB"
                                value="SPPB">
                            <label style="margin: 0; align-content: center;" for="radio_jenisSPPB">SPPB</label>
                        </div>
                        <div class="p-2" style="display: flex; flex-direction: row;">
                            <input style="margin-right: 5px" type="radio" name="radio_jenisCetak" id="radio_jenisBTTB"
                                value="BTTB">
                            <label style="margin: 0; align-content: center;" for="radio_jenisBTTB">BTTB</label>
                        </div>
                        {{-- <div class="p-2" style="display: flex; flex-direction: row;">
                            <input style="margin-right: 5px" type="radio" name="radio_jenisCetak"
                                id="radio_jenisRetur" value="Retur">
                            <label style="margin: 0; align-content: center;" for="radio_jenisRetur">Retur</label>
                        </div> --}}
                    </div>
                    <div style="display: flex; flex-direction: row;margin-top: 1rem; gap: 5px">
                        <div style="display: flex; flex-direction: column;">
                            <label for="divisi">Divisi</label>
                            <input type="text" name="nama_divisi" id="nama_divisi" class="form-control" readonly>
                            <input type="hidden" name="id_divisi" id="id_divisi" class="form-control">
                        </div>
                        <div style="align-content: end">
                            <button class="btn btn-info" id="button_browseDataDivisi">...</button>
                        </div>
                        <div style="display: flex; flex-direction: column;">
                            <label for="sppb">SPPB</label>
                            <input type="text" name="sppb" id="sppb" class="form-control" readonly>
                            <input type="hidden" name="no_trans" id="no_trans" class="form-control" readonly>
                        </div>
                        <div style="align-content: end">
                            <button class="btn btn-info" id="button_browseDataSPPB">...</button>
                        </div>
                        <div style="display: none; flex-direction: column;" id="div_noTerima">
                            <label for="no_terima">No. Terima</label>
                            <input type="text" name="no_terima" id="no_terima" class="form-control" readonly>
                            <input type="date" name="tgl_datang" id="tgl_datang" class="form-control"
                                style="display: none" readonly>
                        </div>
                        <div style="align-content: end">
                            <button class="btn btn-info" id="button_browseDataNomorTerima"
                                style="display: none">...</button>
                        </div>
                        <div style="align-content: end">
                            <button class="btn btn-success" id="button_cetak">Cetak</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/Laporan/CetakSPPBBTTB.js') }}"></script>
@endsection
