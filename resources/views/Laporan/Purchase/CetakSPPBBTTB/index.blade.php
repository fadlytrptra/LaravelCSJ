@extends('layouts.appOrderPembelian')
@section('content')
@section('title', 'Cetak SPPB / BTTB')
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
                <div class="card-header">Cetak SPPB / BTTB</div>
                <div class="card-body">
                    <div style="display: flex; flex-direction: row">
                        <div class="p-2" style="display: flex; flex-direction: row;">
                            <input style="margin-right: 5px" type="radio" name="radio_jenisCetak" id="radio_jenisSPPB"
                                value="SPPB">
                            <label style="margin: 0; align-content: center;" for="radio_jenisSPPB">SPPB</label>
                        </div>
                        <div class="p-2" style="display: flex; flex-direction: row;">
                            <input style="margin-right: 5px" type="radio" name="radio_jenisCetak"
                                id="radio_jenisSPPBBaru" value="SPPBBaru">
                            <label style="margin: 0; align-content: center;" for="radio_jenisSPPBBaru">SPPB New</label>
                        </div>
                        <div class="p-2" style="display: flex; flex-direction: row;">
                            <input style="margin-right: 5px" type="radio" name="radio_jenisCetak" id="radio_jenisBTTB"
                                value="BTTB">
                            <label style="margin: 0; align-content: center;" for="radio_jenisBTTB">BTTB</label>
                        </div>
                        @if ($user == 'adam')
                            <div class="p-2" style="display: flex; flex-direction: row;">
                                <input style="margin-right: 5px" type="radio" name="radio_jenisCetak"
                                    id="radio_jenisEmail" value="Email">
                                <label style="margin: 0; align-content: center;" for="radio_jenisEmail">Email
                                    PO</label>
                            </div>
                        @endif
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
                    <div id="div_emailPO" style="display: none;">
                        <div style="display: flex; flex-direction: row;margin-top: 1rem; gap: 5px">
                            <div style="display: flex; flex-direction: column;flex: 0.4;">
                                <label for="email_deliveryTerm">Delivery Term</label>
                                <input type="text" name="email_deliveryTerm" id="email_deliveryTerm"
                                    class="form-control">
                            </div>
                            <div style="display: flex; flex-direction: column;;flex: 0.4;">
                                <label for="email_packing">Packing</label>
                                <input type="text" name="email_packing" id="email_packing" class="form-control">
                            </div>
                            <div style="display: flex; flex-direction: column;;flex: 0.2;">
                                <label for="email_shippingMark">Shipping Mark</label>
                                <input type="text" name="email_shippingMark" id="email_shippingMark"
                                    class="form-control">
                            </div>
                        </div>
                        <div style="display: flex; flex-direction: row;margin-top: 1rem; gap: 5px">
                            <div style="display: flex; flex-direction: column;flex: 0.2;">
                                <label for="email_deliveryTime">Delivery Time</label>
                                <input type="text" name="email_deliveryTime" id="email_deliveryTime"
                                    class="form-control">
                            </div>
                            <div style="display: flex; flex-direction: column;;flex: 0.4;">
                                <label for="email_documentsRequired">Documents Required</label>
                                <input type="text" name="email_documentsRequired" id="email_documentsRequired"
                                    class="form-control">
                            </div>
                            <div style="display: flex; flex-direction: column;;flex: 0.2;">
                                <label for="email_partialShipmentTransit">Partial Shipment / Transit</label>
                                <input type="text" name="email_partialShipmentTransit"
                                    id="email_partialShipmentTransit" class="form-control">
                            </div>
                        </div>
                        <div style="display: flex; flex-direction: row;margin-top: 1rem; gap: 5px">
                            <div style="display: flex; flex-direction: column;flex: 0.2;">
                                <label for="email_portOfLoading">Port of Loading</label>
                                <input type="text" name="email_portOfLoading" id="email_portOfLoading"
                                    class="form-control">
                            </div>
                            <div style="display: flex; flex-direction: column;flex: 0.2;">
                                <label for="email_portOfDischarge">Port of Discharge</label>
                                <input type="text" name="email_portOfDischarge" id="email_portOfDischarge"
                                    class="form-control">
                            </div>
                            <div style="display: flex; flex-direction: column;;flex: 0.3;">
                                <label for="email_otherConditions">Other Conditions</label>
                                <input type="text" name="email_otherConditions" id="email_otherConditions"
                                    class="form-control">
                            </div>
                            <div style="display: flex; flex-direction: column;;flex: 0.3;">
                                <label for="email_payments">Payments</label>
                                <input type="text" name="email_payments" id="email_payments"
                                    class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/Laporan/CetakSPPBBTTB.js') }}"></script>
@endsection
