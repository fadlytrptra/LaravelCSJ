@extends('layouts.appSales') @section('content')
@section('title', 'Customer')
<style>
    .custom-modal-width {
        max-width: 90%;
        /* Adjust the percentage as needed */
    }
</style>
<link href="{{ asset('css/customer.css') }}" rel="stylesheet">
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 RDZMobilePaddingLR0">
            {{-- <button class="acs-icon-btn acs-add-btn acs-float" onclick="openNewWindow('Customer/create')"> --}}
            <button class="acs-icon-btn acs-add-btn acs-float" data-bs-toggle="modal" data-bs-target="#modalCustomer"
                data-typeForm="tambah" id="buttonTambahCustomer">
                <div class="acs-add-icon"></div>
                <div class="acs-btn-txt">Tambah Customer</div>
            </button>
            <div class="card">
                <div class="card-header">Customer</div>
                <div class="card-body RDZOverflow RDZMobilePaddingLR0">
                    <table id="table_Customer" class="table table-bordered table-striped" style="width:100%">
                        <thead class="thead-dark">
                            <tr>
                                <th>IdCustomer</th>
                                <th>Nama Customer </th>
                                <th>Kota Kirim</th>
                                <th>Negara</th>
                                <th>Action</th>
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
@include('Sales.Master.Customer.ModalCustomer')
@endsection
