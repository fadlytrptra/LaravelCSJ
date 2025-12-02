@extends('layouts.appOrderPembelian')
@section('content')
@section('title', 'Cari Type')
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/ListOrderPembelian.css') }}" rel="stylesheet">

    <div class="container-fluid ">
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
                    <div class="card-header">Cari Type</div>
                    <div class="card-body">
                        <div  id="formCari">
                            <div class="scrollmenu">
                                <table id="tabelData" class="table table-bordered" style="width:100%;white-space: nowrap">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Nama Barang</th>
                                            <th>Kode Barang</th>
                                            <th>Kategori Utama</th>
                                            <th>Kategori</th>
                                            <th>Sub Kategori</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    {{-- <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody> --}}
                                </table>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-9">
                                    <div class="row mb-3">
                                        <label for="" class="col-md-2 col-form-label">
                                            Nama Barang
                                        </label>
                                        <div class="col-md-10">
                                            <input type="text" id="search_nama_barang" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="d-flex flex-column justify-content-between">
                                        <button type="button" id="search" class="btn btn-primary mb-2">Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <script src="{{ asset('js/OrderPembelian/CariType/CariType.js') }}"></script>

    @endsection
