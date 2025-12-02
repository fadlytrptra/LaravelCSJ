@extends('layouts.appOrderPembelian')
@section('content')
@section('title', 'Approve Pembelian')
@include('Beli/Transaksi/Approve/modalDetailApprove')
<script src="{{ asset('js/OrderPembelian/Approve/Approve.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#table_Approve').DataTable({
            searching: true,
            order: [
                [1, 'desc']
            ],
            "columnDefs": [{
                "orderable": false,
                "targets": 0
            }]
        });
    });
</script>
<style>
    .table-striped>tbody>tr:nth-child(even)>td,
    .table-striped>tbody>tr:nth-child(even)>th {
        background-color: #e5de00; // Choose your own color here
    }
</style>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 RDZMobilePaddingLR0">
            <div class="card">
                <div class="card-header">List Approve</div>
                <form class="form" method="POST" enctype="multipart/form-data" action="{{ url('/Approve') }}">
                    {{ csrf_field() }}
                    <div id="DataCheckbox"></div>
                    <div class="card-body">
                        @if (\Session::has('danger'))
                            <div class="alert alert-danger">
                                {!! \Session::get('danger') !!}
                            </div>
                        @endif
                        <table id="table_Approve" class="table table-bordered table-striped" style="width:100%;">
                            <thead class="thead-dark">
                                <tr>
                                    <!-- <th></th> -->
                                    <th class="text-center"><input type="checkbox" name="CheckedAll" id="CheckedAll"
                                            class="RDZCheckBoxSize" /></th>
                                    <th>No. Trans</th>
                                    <th class="RDZCenterTable">Tanggal<br><label
                                            style="font-size: 10px; margin-bottom: 0px;">(MM - DD - YYYY)</label></th>
                                    <th>Barang</th>
                                    <th>User</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $index => $item)
                                    <tr id={{ $index }}>
                                        <td class="text-center"><input type="checkbox" name="Checked[]"
                                                onclick="x('{{ $item->No_trans }}')" value="{{ $item->No_trans }}"
                                                id="{{ $item->No_trans }}" style="width: 20px;height: 20px;" />
                                        </td>
                                        <td class="RDZPaddingTable"><a class="DetailApprove"
                                                data-id="{{ $item->No_trans }}"
                                                href="{{ route('approve.update', $item->No_trans) }}">{{ $item->No_trans }}</a>
                                        </td>
                                        <td class="RDZPaddingTable RDZCenterTable">
                                            {{ date('m-d-Y', strtotime($item->Tgl_order)) }}</td>
                                        <td class="RDZPaddingTable">{{ $item->NAMA_BRG }} <label
                                                style="background-color:#00ff00;">{{ $item->Qty }}
                                                {{ $item->Nama_satuan }}</label></td>
                                        <td class="RDZPaddingTable">{{ $item->Nama }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer RDZApproveRejectButton">
                        <button type="submit" class="btn btn-md btn-primary" name="action"
                            value="Approve">Approve</button>
                        <button type="submit" class="btn btn-md btn-danger" name="action"
                            value="Reject">Reject</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(".DetailApprove").on('auxclick', function(e) {
        if (e.button === 1) { // 1 represents the middle mouse button
            e.preventDefault(); // Prevents the new tab from opening
        }
    });

    function x(No_trans) {
        let item = document.getElementById(No_trans);
        let add = document.getElementById("DataCheckbox");
        // console.log(item);
        if (item.checked == true) {
            //add.innerHTML+="<input type='text' name='checkedBOX[]' value='"+No_trans+"' style='Display: none;'>";
            add.innerHTML += "<input type='text' id='ID" + No_trans + "' name='checkedBOX[]' value='" + No_trans +
                "' style='Display: none;'>";
        }
        if (item.checked == false) {
            let Input = document.getElementById("ID" + No_trans);
            Input.remove();
            //add.innerHTML+="<input type='text' name='checkedBOX[]' value='"+No_trans+"' style='Display: none;'>";
        }
    }
    $('#CheckedAll').on('click', function() {
        let table = $('#table_Approve').DataTable();
        let rows = table.rows({
            'search': 'applied'
        }).nodes();
        // Check/uncheck checkboxes for all rows in the table
        $('input[type="checkbox"]', rows).prop('checked', this.checked);
        let item = document.getElementById("CheckedAll");
        let add = document.getElementById("DataCheckbox");
        let Data = {!! json_encode($data, JSON_HEX_TAG) !!};
        if (item.checked == true) {

            for (let i = 0; i <= Data.length - 1; i++) {
                add.innerHTML += "<input type='text' id='ID" + Data[i].No_trans +
                    "' name='checkedBOX[]' value='" + Data[i].No_trans + "' style='Display: none;'>";
                console.log("test");
            }
            console.log(add);
        }
        if (item.checked == false) {
            for (let i = 0; i <= Data.length - 1; i++) {
                let Input = document.getElementById("ID" + Data[i].No_trans);
                Input.remove();
            }
            console.log("hapus");
        }
    });

    function ALL() {
        let item = document.getElementById("CheckedAll");
        let add = document.getElementById("DataCheckbox");
        if (item.checked == true) {
            let Data = {!! json_encode($data, JSON_HEX_TAG) !!};
            for (let i = 0; i <= Data.length - 1; i++) {
                // console.log(Data[i].No_trans);
                document.getElementById(Data[i].No_trans).checked = true;
                add.innerHTML += "<input type='text' id='ID" + Data[i].No_trans + "' name='checkedBOX[]' value='" +
                    Data[i].No_trans + "' style='Display: none;'>";
            }
            // console.log(Data.length);
        }
        // console.log(add);
        if (item.checked == false) {
            console.log("hapus");
        }
    }
</script>

@endsection
