@extends('layouts.appOrderPembelian')

@section('title', 'ACC Direktur')

@section('content')
    @include('Beli/Transaksi/FinalApprove/modalDetailFinal')
    <style>
        thead th {
            text-align: center !important;
            vertical-align: middle !important;
        }

        .card-footer .btn {
            min-width: 100px;
        }

        .table-striped>tbody>tr:nth-child(even)>td,
        .table-striped>tbody>tr:nth-child(even)>th {
            background-color: #e5de00;
        }

        .row-approved td {
            background-color: #d4edda !important;
        }

        .row-pending td {
            background-color: #e5de00 !important;
        }

        .row-approved {
            opacity: 0.85;
        }

        .lbl_approved {
            background-color: #00ff00;
            color: #000;
            padding: 2px 8px;
            border-radius: 3px;
            font-weight: bold;
            display: inline-block;
        }

        .lbl_pending {
            background-color: #de8f21;
            color: #000;
            padding: 2px 8px;
            border-radius: 3px;
            font-weight: bold;
            display: inline-block;
        }
    </style>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10 RDZMobilePaddingLR0">
                <div class="card">
                    <div class="card-header">ACC Direktur</div>
                    {{-- kirim ke FinalApproveController@store --}}
                    <form class="form" method="POST" enctype="multipart/form-data" action="{{ url('/FinalApprove') }}">
                        @csrf
                        <input type="hidden" name="action" id="actionInput">
                        <div id="DataCheckbox"></div>
                        <div class="card-body">
                            @if (\Session::has('danger'))
                                <div class="alert alert-danger">{!! \Session::get('danger') !!}</div>
                            @endif

                            <table id="table_Approve" class="table table-bordered table-striped" style="width:100%;">
                                <thead class="thead-dark">
                                    <tr>
                                        <th class="text-center">
                                            <input type="checkbox" name="CheckedAll" id="CheckedAll"
                                                class="RDZCheckBoxSize" />
                                        </th>
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

                                <tbody>
                                    @foreach ($data as $index => $item)
                                        <tr id="{{ $index }}"
                                            class = "{{ $item->Dir_Agree ? 'row_approved' : 'row_pending' }} ">
                                            <td class="text-center">
                                                <input type="checkbox" name="Checked[]" onclick="x('{{ $item->No_trans }}')"
                                                    value="{{ $item->No_trans }}" id="{{ $item->No_trans }}"
                                                    style="width:20px;height:20px;" />
                                            </td>
                                            <td class="RDZPaddingTable">{{ $item->Kd_div }}</td>
                                            <td class="RDZPaddingTable RDZCenterTable" style="white-space: nowrap"
                                                data-order="{{ \Carbon\Carbon::parse($item->Tgl_order)->format('Y-m-d H:i:s') }}">
                                                {{ \Carbon\Carbon::parse($item->Tgl_order)->format('m-d-Y') }}
                                            </td>
                                            <td class="RDZPaddingTable">{{ $item->nama_sub_kategori }}</td>
                                            <td class="RDZPaddingTable">{{ $item->NAMA_BRG }}</td>
                                            <td class="RDZPaddingTable">{{ $item->Qty }}</td>
                                            <td class="RDZPaddingTable">{{ trim($item->Nama_satuan) }}</td>
                                            <td class="RDZPaddingTable text-end">
                                                {{ number_format($item->HargaPerkiraan ?? 0, 2) }}
                                            </td>
                                            <td class="RDZPaddingTable" style="white-space: nowrap;">{{ trim($item->No_sppb) }}</td>
                                            <td class="RDZPaddingTable">{{ $item->keterangan }}</td>
                                            <td class="RDZPaddingTable">{{ $item->Kd_brg }}</td>
                                            <td class="text-center">
                                                @if ($item->Dir_Agree)
                                                    <span class="lbl_approved">Approved</span>
                                                @else
                                                    <span class="lbl_pending">Pending</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-end gap-2">
                                <button type="submit" class="btn btn-md btn-primary" name="action" value="Approve">
                                    Proses
                                </button>
                                <button type="submit" class="btn btn-md btn-warning btn_revisi" name="action"
                                    value="Revisi">
                                    Revisi
                                </button>
                                {{-- BATAL --}}
                                <button type="submit" class="btn btn-md btn-danger btn_batal" name="action"
                                    value="Dibatalkan">
                                    Dibatalkan
                                </button>
                                {{-- <button type="submit" class="btn btn-md btn-warning" name="action" value="DownToManager">
                                    Turunkan ke Level Manager
                                </button> --}}
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // checkbox per baris
            window.x = function(No_trans) {
                let item = document.getElementById(No_trans);
                let add = document.getElementById("DataCheckbox");
                if (!item) return;

                if (item.checked) {
                    if (!document.getElementById("ID" + No_trans)) {
                        add.insertAdjacentHTML(
                            'beforeend',
                            "<input type='text' id='ID" + No_trans +
                            "' name='checkedBOX[]' value='" + No_trans +
                            "' style='display:none;'>"
                        );
                    }
                } else {
                    let Input = document.getElementById("ID" + No_trans);
                    if (Input) Input.remove();
                }
            };

            // checkbox "pilih semua"
            $('#CheckedAll').on('click', function() {
                let rows = table.rows({
                    search: 'applied'
                }).nodes();
                $('input[type="checkbox"]', rows).prop('checked', this.checked);

                let add = document.getElementById("DataCheckbox");
                let Data = {!! json_encode($data, JSON_HEX_TAG) !!};

                if (this.checked) {
                    Data.forEach(row => {
                        let id = "ID" + row.No_trans;
                        if (!document.getElementById(id)) {
                            add.insertAdjacentHTML(
                                'beforeend',
                                "<input type='text' id='" + id +
                                "' name='checkedBOX[]' value='" + row.No_trans +
                                "' style='display:none;'>"
                            );
                        }
                    });
                } else {
                    Data.forEach(row => {
                        let Input = document.getElementById("ID" + row.No_trans);
                        if (Input) Input.remove();
                    });
                }
            });
        });
    </script>
    <script src="{{ asset('js/OrderPembelian/FinalApprove/FinalApprove.js') }}"></script>
@endsection
