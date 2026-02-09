@extends('layouts.AppInventory')
@section('content')
@section('title', 'Maintenance Kode Perkiraan')
@include('Inventory.Master.KodePerkiraan.modalKodePerkiraan')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 RDZMobilePaddingLR0">
            <button class="acs-icon-btn acs-add-btn acs-float" data-bs-toggle="modal" data-bs-target="#modalKodePerkiraan"
                type="button" id="button_tambahKodePerkiraan">
                <div class="acs-add-icon"></div>
                <div class="acs-btn-txt">Tambah Kode</div>
            </button>
            <div class="card">
                <div class="card-header">Maintenance Kode Perkiraan</div>
                <div class="card-body RDZOverflow RDZMobilePaddingLR0">
                    <div style="width: 100%;">
                        <table id="table_kodePerkiraan" class="table table-bordered"
                            style="width:100%;white-space: nowrap;">
                            <thead class="table-primary">
                                <tr>
                                    <th>No Kode Perkiraan</th>
                                    <th>Keterangan </th>
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
</div>

<script src="{{ asset('js/Inventory/Master/KodePerkiraan.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/Inventory/Master/KodePerkiraan.css') }}">
<link rel="stylesheet" href="{{ asset('css/colResizeDatatable.css') }}">
<script src="{{ asset('js/colResizeDatatable.js') }}"></script>
@endsection
