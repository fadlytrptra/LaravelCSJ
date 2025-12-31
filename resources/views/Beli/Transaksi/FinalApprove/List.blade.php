@extends('layouts.appOrderPembelian')

@section('title', 'ACC Direktur')

@section('content')
    @include('Beli/Transaksi/FinalApprove/modalDetailFinal')
    <script src="{{ asset('js/OrderPembelian/FinalApprove/FinalApprove.js') }}"></script>

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

        .card-footer .btn {
            min-width: 100px;
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
                                        <th>Keterangan Beli</th>
                                        <th>Kd.Barang</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($data as $index => $item)
                                        <tr id="{{ $index }}">
                                            <td class="text-center">
                                                <input type="checkbox" name="Checked[]" onclick="x('{{ $item->No_trans }}')"
                                                    value="{{ $item->No_trans }}" id="{{ $item->No_trans }}"
                                                    style="width:20px;height:20px;" />
                                            </td>
                                            <td class="RDZPaddingTable">{{ $item->Kd_div }}</td>
                                            <td class="RDZPaddingTable RDZCenterTable">
                                                {{ date('m-d-Y', strtotime($item->Tgl_order)) }}
                                            </td>
                                            <td class="RDZPaddingTable">{{ $item->nama_sub_kategori }}</td>
                                            <td class="RDZPaddingTable">{{ $item->NAMA_BRG }}</td>
                                            <td class="RDZPaddingTable">{{ $item->Qty }}</td>
                                            <td class="RDZPaddingTable">{{ trim($item->Nama_satuan) }}</td>
                                            <td class="RDZPaddingTable text-end">
                                                {{ number_format($item->HargaPerkiraan ?? 0, 2) }}
                                            </td>
                                            <td class="RDZPaddingTable">{{ $item->keterangan }}</td>
                                            <td class="RDZPaddingTable">{{ $item->Kd_brg }}</td>
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

                                <button type="submit" class="btn btn-md btn-warning" name="action" value="DownToManager">
                                    Turunkan ke Level Manager
                                </button>

                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            const table = $('#table_Approve').DataTable({
                searching: true,
                order: [
                    [2, 'desc']
                ], // index 2 = kolom Tanggal
                columnDefs: [{
                    orderable: false,
                    targets: 0
                }]
            });

            $(document).on('auxclick', '.DetailApprove', function(e) {
                if (e.button === 1) e.preventDefault();
            });

            // checkbox per baris
            window.x = function(No_trans) {
                const item = document.getElementById(No_trans);
                const add = document.getElementById("DataCheckbox");
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
                    const Input = document.getElementById("ID" + No_trans);
                    if (Input) Input.remove();
                }
            };

            // checkbox "pilih semua"
            $('#CheckedAll').on('click', function() {
                const rows = table.rows({
                    search: 'applied'
                }).nodes();
                $('input[type="checkbox"]', rows).prop('checked', this.checked);

                const add = document.getElementById("DataCheckbox");
                const Data = {!! json_encode($data, JSON_HEX_TAG) !!};

                if (this.checked) {
                    Data.forEach(row => {
                        const id = "ID" + row.No_trans;
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
                        const Input = document.getElementById("ID" + row.No_trans);
                        if (Input) Input.remove();
                    });
                }
            });
        });
    </script>

@endsection
