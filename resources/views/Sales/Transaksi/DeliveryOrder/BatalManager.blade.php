@extends('layouts.appSales')
@section('content')
@section('title', 'Batal DO')
<script>
    $(document).ready(function() {
        $('#table_DO').DataTable({
            order: [
                [0, 'desc']
            ],
        });
    });
</script>
<link href="{{ asset('css/batal-do.css') }}" rel="stylesheet">
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 RDZMobilePaddingLR0">
            @if (Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            @elseif (Session::has('error'))
                <div class="alert alert-danger">
                    <ul>
                        @foreach (Session::get('error') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card">
                <div class="card-header">Delivery Order Sudah ACC Manager</div>
                <div class="card-body RDZOverflow RDZMobilePaddingLR0">
                    <div style="padding:10px; overflow: auto;">
                        <table id="table_DO" class="table table-bordered table-striped SP_datatable"
                            style="width:100%">
                            <thead class="thead-light">
                                <tr>
                                    <th>Nomor DO</th>
                                    <th>Tanggal </th>
                                    <th>ID Pesanan</th>
                                    <th>No SP</th>
                                    <th>Customer</th>
                                    <th>ID Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Primer</th>
                                    <th>Sekunder</th>
                                    <th>Tritier</th>
                                    <th>ID Trans TMP</th>
                                    {{-- <th>Action</th> --}}

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td class="RDZPaddingTable RDZCenterTable">
                                            <div style="display: flex; align-items: center;gap:5px">
                                                <input type="checkbox" name="selected[]" id="id_do"
                                                    value="{{ $item->IDDO }}">{{ $item->IDDO }}
                                            </div>
                                        </td>
                                        <td class="RDZPaddingTable RDZCenterTable" style="white-space: nowrap">
                                            {{ date('m-d-Y', strtotime($item->tanggal)) }}</td>
                                        <td class="RDZPaddingTable RDZCenterTable">{{ $item->IDPesanan }}</td>
                                        <td class="RDZPaddingTable RDZCenterTable">{{ $item->IDSuratPesanan }}</td>
                                        <td class="RDZPaddingTable RDZCenterTable">{{ $item->NamaCust }}</td>
                                        <td class="RDZPaddingTable RDZCenterTable">{{ $item->IDBarang }}</td>
                                        <td class="RDZPaddingTable RDZCenterTable">{{ $item->NamaBarang }}</td>
                                        <td class="RDZPaddingTable RDZCenterTable">{{ $item->QtyPrimer }}</td>
                                        <td class="RDZPaddingTable RDZCenterTable">{{ $item->QtySekunder }}</td>
                                        <td class="RDZPaddingTable RDZCenterTable">{{ $item->QtyTritier }}</td>
                                        <td class="RDZPaddingTable RDZCenterTable">{{ $item->IdtransTmp }}</td>
                                        {{-- <td class="acs-td-button">
                                                <button type="button" class="btn btn-sm btn-danger" id="buttonBatal"
                                                    onclick="openModal('{{ $item->IdtransTmp }}','{{ $item->IDDO }}')"><span>&#x1F5D1;</span>
                                                    Batalkan</button>
                                            </td> --}}
                                    </tr>
                                @endforeach
                        </table>
                    </div>
                    @isset($item)
                        <button type="button" class="btn btn-sm btn-danger" id="buttonBatal"
                            onclick="openModal('{{ $item->IdtransTmp }}','{{ $item->IDDO }}')">
                            <span>&#x1F5D1;</span> Batalkan
                        </button>
                    @endisset

                </div>
            </div>
        </div>
    </div>
</div>
<!-- The modal -->
{{-- <div class="modal-overlay" id="modal-overlay" style="display: none;"></div> --}}
<div id="my-modal" class="modal">
    <div class="modal-content">
        <form id="modal-form" method="POST" action="{{ url('/DeliveryOrderManager/destroy') }}">
            {{ csrf_field() }}
            <p>Input keterangan pembatalan untuk semua DO yang akan dibatalkan</p>
            <div class="modal-body">
                <p>Keterangan Pembatalan:</p>
                <input type="text" name="value" id="modal-value" class="input" value="Stok Kosong"
                    style="width: 100%">
            </div>
            <div class="text-center" style="margin-bottom: 20px">
                <button type="button" class="btn btn-primary" id="modal-btnBatalDO"
                    onclick="setModalValue()">Ok</button>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="{{ asset('js/Sales/Batal-do.js') }}"></script>
@endsection
