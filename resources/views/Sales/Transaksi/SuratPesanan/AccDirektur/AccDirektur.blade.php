@extends('layouts.appSales')
@section('content')
@section('title', 'ACC Direktur')
@include('Sales/Transaksi/SuratPesanan/AccDirektur/modalDetailSP')
<style>
    #sppb_tableOrderPembelian tr {
        cursor: pointer;
    }
</style>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 RDZMobilePaddingLR0">
            <div class="card">
                <div class="card-header">Surat Pesanan Belum ACC Direktur</div>
                <div class="card-body">
                    <div style="display: flex; flex-direction: row;margin: 0 0 1rem 0; gap: 5px">
                        <div style="display: flex; flex-direction: column;">
                            <label for="jenisSP">Jenis SP</label>
                            <input type="text" name="jenisSP" id="jenisSP" class="form-control" readonly>
                            <input type="hidden" name="id_jenisSP" id="id_jenisSP" class="form-control">
                        </div>
                        <div style="align-content: end">
                            <button class="btn btn-info" id="button_browseJenisSP">...</button>
                        </div>
                    </div>
                    <table id="table_suratPesanan" class="table table-bordered table-striped" style="width:100%">
                        <thead class="thead-light">
                            <tr>
                                <th style="width:30px;text-align:center;white-space: nowrap;">
                                    <input type="checkbox" id="checkAllSuratPesanan"> Check All
                                </th>
                                <th>Nomor SP</th>
                                <th>Tanggal SP</th>
                                <th>Nama Customer</th>
                                <th>Nomor PO</th>
                                <th>Nomor PI</th>
                                <th>Nama Sales</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    @php
                        $canApprove = in_array(trim($user), ['adam', 'rudy']);
                    @endphp
                    <button class="btn btn-sm btn-success"
                        @unless ($canApprove) style="display:none" @endunless
                        id="button_submitSelected"><span>&#x2713;</span>
                        Setujui Surat Pesanan yang Dipilih</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/Sales/ACCDirektur.js') }}"></script>

@endsection
