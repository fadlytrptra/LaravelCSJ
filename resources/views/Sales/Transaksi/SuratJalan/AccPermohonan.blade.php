@extends('layouts.appSales')
@section('content')
@section('title', 'ACC SJ')
    <script>
        $(document).ready(function() {
            $('#table_PK').DataTable({
                order: [
                    [0, 'desc']
                ],
            });
        });
    </script>
    <link href="{{ asset('css/AccPermohonan-s-j.css') }}" rel="stylesheet">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10 RDZMobilePaddingLR0">
                @if (Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">Surat Jalan Belum ACC Manager</div>
                    <div class="card-body RDZOverflow RDZMobilePaddingLR0">
                        <table id="table_SJ" class="table table-bordered table-striped SP_datatable" style="width:100%">
                            <thead class="thead-light">
                                <tr>
                                    <th>Surat Jalan</th>
                                    <th>Tanggal </th>
                                    <th>Customer</th>
                                    <th>Expeditor</th>
                                    <th>Kendaraan</th>
                                    <th>IDHeader</th>
                                    {{-- <th>Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr class="acs-tr-hover">
                                        <td class="RDZPaddingTable RDZCenterTable" onclick="rowClickHandler('{{ $item->IdHeaderKirim }}')"><input type="checkbox" name="selected[]"
                                            id="id_headerKirim" value="{{ $item->IdHeaderKirim }}">{{ $item->IDPengiriman }} </td>
                                        <td class="RDZPaddingTable RDZCenterTable">
                                            {{ date('m-d-Y', strtotime($item->Tanggal)) }}</td>
                                        <td class="RDZPaddingTable RDZCenterTable">{{ $item->NamaCust }}</td>
                                        <td class="RDZPaddingTable RDZCenterTable">{{ $item->NamaExpeditor }}</td>
                                        <td class="RDZPaddingTable RDZCenterTable">{{ $item->TrukNopol }}</td>
                                        <td class="RDZPaddingTable RDZCenterTable">{{ $item->IdHeaderKirim }}</td>
                                        {{-- <td class="acs-td-button">
                                            <form onsubmit="return confirm('Apakah Anda Yakin ?');"
                                                action="{{ url('SuratJalanManager/' . $item->IdHeaderKirim . '/up') }}"
                                                method="POST" enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-sm btn-success"><span>&#x2713;</span>
                                                    Setujui</button>
                                            </form>
                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div>
                            <form
                                onsubmit="return confirm('Apakah Anda Yakin untuk menyetujui surat pesanan yang sudah dipilih?');"
                                id="form_submitSelected"action="{{ url('/SuratJalanManager/up') }}" method="POST"
                                enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <button class="btn btn-sm btn-success" id="button_submitSelected"><span>&#x2713;</span>
                                    Setujui Surat Jalan yang Dipilih</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 id="modal-title"></h2>
            <hr>
            <p><span style="font-weight: bolder">Uraian: </span> <span id="Uraian"></span></p>
            <p><span style="font-weight: bolder">Qty Primer (Ball): </span><span id="QtyPrimer"></span></p>
            <p><span style="font-weight: bolder">Qty Sekunder (Lbr): </span><span id="QtySekunder"></span></p>
            <p><span style="font-weight: bolder">Qty Tritier (Kg): </span><span id="QtyTritier"></span></p>
            <p><span style="font-weight: bolder">Min DO: </span><span id="MinDO"></span></p>
            <p><span style="font-weight: bolder">Max DO: </span><span id="MaxDO"></span></p>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('js/Sales/AccPermohonan-s-j.js') }}"></script>
@endsection
