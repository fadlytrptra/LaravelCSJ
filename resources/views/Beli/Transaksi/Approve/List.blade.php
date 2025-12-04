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
                                <select id="filterStatus" class="form-control"
                                        onchange="window.location='?status=' + this.value">
                                    <option value="ALL"   {{ $status == 'ALL'   ? 'selected' : '' }}>Semua</option>
                                    <option value="BELUM" {{ $status == 'BELUM' ? 'selected' : '' }}>Belum ACC</option>
                                    {{-- <option value="BATAL" {{ $status == 'BATAL' ? 'selected' : '' }}>Sudah Dibatalkan</option> --}}
                                </select>
                            </div>
                        </div>



                        <table id="table_Approve" class="table table-bordered table-striped" style="width:100%;">
                           <thead class="thead-dark">
                                <tr>
                                    <th class="text-center">
                                        <input type="checkbox" name="CheckedAll" id="CheckedAll" class="RDZCheckBoxSize" />
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
                                            name="Checked[]"
                                            onclick="x('{{ $item->No_trans }}')"
                                            value="{{ $item->No_trans }}"
                                            id="{{ $item->No_trans }}"
                                            style="width:20px;height:20px;" />
                                    </td>

                                    <td class="RDZPaddingTable">{{ $item->Divisi }}</td>

                                    <td style="display:none;">{{ $item->No_trans }}</td>  

                                    <td class="RDZPaddingTable RDZCenterTable">{{ date('m-d-Y', strtotime($item->Tanggal)) }}</td>
                                    <td class="RDZPaddingTable">{{ $item->{'Jenis Barang'} }}</td>
                                    <td class="RDZPaddingTable">{{ $item->Type }}</td>
                                    <td class="RDZPaddingTable">{{ $item->Jumlah }}</td>
                                    <td class="RDZPaddingTable">{{ $item->Satuan }}</td>
                                    <td class="RDZPaddingTable RDZCenterTable">{{ date('m-d-Y', strtotime($item->{'Tgl. Dibutuhkan'})) }}</td>
                                    <td class="RDZPaddingTable">{{ $item->{'Keterangan Beli'} }}</td>
                                    <td class="RDZPaddingTable">{{ $item->Pemesan }}</td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>

                    <div class="card-footer RDZApproveRejectButton">
                        <button type="submit" class="btn btn-md btn-primary" name="action" value="Approve">Proses</button>
                        <button type="submit" class="btn btn-md btn-danger" name="action" value="Reject">Reject</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {

    const table = $('#table_Approve').DataTable({
        searching: true,
        order: [[2, 'desc']],
        columnDefs: [{
            orderable: false,
            targets: 0
        }]
    });

    
    $(document).on('auxclick', '.DetailApprove', function (e) {
        if (e.button === 1) e.preventDefault();
    });

    // --- FUNGSI UNTUK CHECKBOX PER BARIS 
    window.x = function (No_trans) {
        const item = document.getElementById(No_trans);
        const add  = document.getElementById("DataCheckbox");

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

    // --- CHECKBOX "SELECT ALL" ---
    $('#CheckedAll').on('click', function () {
        const rows = table.rows({ search: 'applied' }).nodes();
        $('input[type="checkbox"]', rows).prop('checked', this.checked);

        const add  = document.getElementById("DataCheckbox");
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

    // --- FILTER STATUS ---
    // Sekarang dikosongkan supaya tidak error "originalData is not defined".
    // Kalau mau pakai filter client-side, bisa diisi logic DataTable di sini.
    $('#filterStatus').on('change', function () {
        // saat ini select sudah punya onchange="window.location='?status=' + this.value"
        // jadi di sini tidak perlu apa-apa.
    });
});
</script>
    
@endsection
