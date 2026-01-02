@extends('layouts.appOrderPembelian')
@section('content')
@section('title', 'Create SPPB')
@include('Beli/Transaksi/CreateSPPB/modalTambahSPPB')
<style>
    #sppb_tableOrderPembelian tr {
        cursor: pointer;
    }
</style>
<input type="hidden" name="idUser" id="idUser" value={{ $user_id }}>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 RDZMobilePaddingLR0">
            <button class="acs-icon-btn acs-add-btn acs-float" data-bs-toggle="modal" data-bs-target="#modalSPPB"
                data-typeForm="tambah" id="buttonTambahSPPB">
                <div class="acs-add-icon"></div>
                <div class="acs-btn-txt">Tambah SPPB</div>
            </button>
            <div class="card">
                <div class="card-header">Create SPPB</div>
                <div class="card-body">
                    <table id="table_sppb" class="table table-bordered table-striped" style="width:100%">
                        <thead class="thead-light">
                            <tr>
                                <th>Nomor SPPB</th>
                                <th>Nama Supplier</th>
                                <th>Tanggal SPPB</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/OrderPembelian/CreateSPPB/CreateSPPB.js') }}"></script>
@endsection
