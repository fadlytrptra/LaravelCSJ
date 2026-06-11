@extends('layouts.appOrderPembelian')
@section('content')
@section('title', 'ACC Manager')
@include('Beli/Transaksi/Approve/modalDetailApprove')
<script src="{{ asset('js/OrderPembelian/Approve/Approve.js') }}"></script>


<style>
.table-striped>tbody>tr:nth-child(even)>td,
.table-striped>tbody>tr:nth-child(even)>th {
    background-color: #e5de00;
}
</style>

<style>
    thead th {
        text-align: center !important;
        vertical-align: middle !important;
    }
</style>


<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 RDZMobilePaddingLR0">
            <div class="card">
                <div class="card-header">ACC Manager</div>

                <form class="form" method="POST" enctype="multipart/form-data" action="{{ url('/Approve') }}">
                    {{ csrf_field() }}
                    <div id="DataCheckbox"></div>

                    <div class="card-body">
                        @if (\Session::has('danger'))
                            <div class="alert alert-danger">{!! \Session::get('danger') !!}</div>
                        @endif

                        <div class="row mb-3">
                            <div class="col-md-4">
                               <select id="filterStatus" class="form-control">
                                    <option value="ACC">
                                        Acc Permohonan
                                    </option>

                                    <option value="BATAL">
                                        Batal Acc
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div id="tableACCWrapper">
                            <table id="table_Approve" class="table table-bordered table-striped" style="width:100%;">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center">
                                        <input type="checkbox" name="CheckedAllACC" id="CheckedAllACC" class="RDZCheckBoxSize" />
                                    </th>
                                    <th>Divisi</th>
                                    <th style="display:none;">No Trans</th>
                                    <th class="RDZCenterTable">Tanggal<br><label style="font-size: 10px">(MM - DD - YYYY)</label></th>
                                    <th>Jenis Barang</th>
                                    <th>Type</th>
                                    <th>Jumlah</th>
                                    <th>Satuan</th>
                                    <th class="RDZCenterTable">Tanggal Dibutuhkan<br><label style="font-size: 10px">(MM - DD - YYYY)</label></th>
                                    <th>Keterangan Beli</th>
                                    <th>Pemesan</th>
                                </tr>
                            </thead>

                           <tbody>
                                @foreach ($data as $index => $item)
                                <tr id="{{ $index }}">
                                    <td class="text-center">
                                        <input type="checkbox"
                                        class="check-row-acc"
                                        data-no-trans="{{ $item->No_trans }}"
                                        name="Checked[]"
                                        value="{{ $item->No_trans }}"
                                        id="ACC_{{ $item->No_trans }}"
                                        style="width:20px;height:20px;" />
                                    </td>

                                    <td class="RDZPaddingTable">
                                        {{ $item->Kd_div }}
                                    </td>
                                    <td style="display:none;">
                                        {{ $item->No_trans }}
                                    </td>
                                    <td class="RDZPaddingTable RDZCenterTable">
                                        {{ !empty($item->Tgl_order) ? date('m-d-Y', strtotime($item->Tgl_order)) : '-' }}
                                    </td>
                                    <td class="RDZPaddingTable">
                                        {{ $item->nama_sub_kategori ?? '-' }}
                                    </td>
                                    <td class="RDZPaddingTable">
                                        {{ $item->NAMA_BRG ?? '-' }}
                                    </td>
                                    <td class="RDZPaddingTable">
                                        {{ $item->Qty ?? 0 }}
                                    </td>
                                    <td class="RDZPaddingTable">
                                        {{ $item->Nama_satuan ?? '-' }}
                                    </td>
                                    <td class="RDZPaddingTable RDZCenterTable">
                                        {{ !empty($item->Tgl_Dibutuhkan) ? date('m-d-Y', strtotime($item->Tgl_Dibutuhkan)) : '-' }}
                                    </td>
                                    <td class="RDZPaddingTable">
                                        {{ $item->keterangan ?? '-' }}
                                    </td>
                                    <td class="RDZPaddingTable">
                                        {{ $item->Pemesan ?? '-' }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div id="tableBatalWrapper" style="display:none;">
                        <table id="table_Batal"
                            class="table table-bordered table-striped"
                            style="width:100%;">

                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center">
                                        <input type="checkbox" name="CheckedAllBATAL" id="CheckedAllBATAL" class="RDZCheckBoxSize" />
                                    </th>
                                    <th>Divisi</th>
                                    <th style="display:none;">No Trans</th>
                                    <th class="RDZCenterTable">Tanggal<br><label style="font-size: 10px">(MM - DD - YYYY)</label></th>
                                    <th>Jenis Barang</th>
                                    <th>Type</th>
                                    <th>Jumlah</th>
                                    <th>Satuan</th>
                                    <th class="RDZCenterTable">Tanggal Dibutuhkan<br><label style="font-size: 10px">(MM - DD - YYYY)</label></th>
                                    <th>Keterangan Beli</th>
                                    <th>Pemesan</th>
                                </tr>
                            </thead>

                           <tbody>
                                @foreach ($data as $index => $item)
                                <tr id="{{ $index }}">
                                    <td class="text-center">
                                        <input type="checkbox"
                                        class="check-row-batal"
                                        data-no-trans="{{ $item->No_trans }}"
                                        name="Checked[]"
                                        value="{{ $item->No_trans }}"
                                        id="BATAL_{{ $item->No_trans }}"
                                        style="width:20px;height:20px;" />
                                    </td>

                                    <td class="RDZPaddingTable">
                                        {{ $item->Kd_div }}
                                    </td>
                                    <td style="display:none;">
                                        {{ $item->No_trans }}
                                    </td>
                                    <td class="RDZPaddingTable RDZCenterTable">
                                        {{ !empty($item->Tgl_order) ? date('m-d-Y', strtotime($item->Tgl_order)) : '-' }}
                                    </td>
                                    <td class="RDZPaddingTable">
                                        {{ $item->nama_sub_kategori ?? '-' }}
                                    </td>
                                    <td class="RDZPaddingTable">
                                        {{ $item->NAMA_BRG ?? '-' }}
                                    </td>
                                    <td class="RDZPaddingTable">
                                        {{ $item->Qty ?? 0 }}
                                    </td>
                                    <td class="RDZPaddingTable">
                                        {{ $item->Nama_satuan ?? '-' }}
                                    </td>
                                    <td class="RDZPaddingTable RDZCenterTable">
                                        {{ !empty($item->Tgl_Dibutuhkan) ? date('m-d-Y', strtotime($item->Tgl_Dibutuhkan)) : '-' }}
                                    </td>
                                    <td class="RDZPaddingTable">
                                        {{ $item->keterangan ?? '-' }}
                                    </td>
                                    <td class="RDZPaddingTable">
                                        {{ $item->Pemesan ?? '-' }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>

                    <!-- FOOTER ACC -->
                    <div id="footerACC" class="card-footer">
                        <button type="submit" class="btn btn-md btn-primary" id="btnProses" name="action" value="ACC_PERMOHONAN">
                            Proses
                        </button>
                    </div>

                    <!-- FOOTER BATAL -->
                    <div id="footerBatal" class="card-footer" style="display:none;">
                        <button type="submit" class="btn btn-md btn-success" id="btnProsesBatal" name="action" value="BATAL_ACC">
                            Proses
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection
