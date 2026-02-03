@extends('layouts.appOrderPembelian')

@section('title', 'Revisi PO')

@section('content')
    @include('Beli/Transaksi/RevisiPO/modalDetailFinal')
    <style>
        thead th {
            text-align: center !important;
            vertical-align: middle !important;
        }

        .card-footer .btn {
            min-width: 100px;
        }

        .lbl_approved {
            background-color: #00ff00;
            color: #000;
            font-weight: bold;
            display: inline-block;
        }

        .lbl_pending {
            background-color: #de8f21;
            color: #000;
            font-weight: bold;
            display: inline-block;
        }

        .nowrap {
            white-space: nowrap;
        }
    </style>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-11 RDZMobilePaddingLR0">
                <div class="card">
                    <div class="card-header">Revisi PO</div>
                    <div class="card-body">
                        <div style="overflow: auto;">
                            <table id="table_Revisi" class="table table-bordered table-striped" style="max-width:100%;">
                                <thead class="thead-dark">
                                    <tr>
                                        <th></th>
                                        <th>Divisi</th>
                                        <th class="RDZCenterTable">
                                            Tanggal<br><label style="font-size:10px">(MM - DD - YYYY)</label>
                                        </th>
                                        <th>Jenis Barang</th>
                                        <th>Type</th>
                                        <th>Jumlah</th>
                                        <th>Satuan</th>
                                        <th>HargaPerkiraan</th>
                                        <th>No. PO</th>
                                        <th>Keterangan Beli</th>
                                        <th>Kd.Barang</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end mt-2">
                            <button class="btn btn-md btn-warning btn_revisi" name="action" value="Revisi">
                                Revisi
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/OrderPembelian/RevisiPO/RevisiPO.js') }}"></script>
@endsection
