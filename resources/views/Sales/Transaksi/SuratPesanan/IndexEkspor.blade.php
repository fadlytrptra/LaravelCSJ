@extends('layouts.appSales') @section('content')
@section('title', 'Surat Pesanan Ekspor')
    <script>
        $(document).ready(function() {
            // console.log(dataArray.data);
            $('#table_SP').DataTable({
                processing: true,
                serverSide: true,
                "ajax": {
                    "url": "{{ url('spekspor') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        _token: "{{ csrf_token() }}"
                    }
                },
                "columns": [{
                        "data": "IDSuratPesanan"
                    },
                    {
                        "data": "NamaCust"
                    },
                    {
                        "data": "Tgl_Pesan"
                    },
                    {
                        "data": "Actions"
                    }
                ]
            });
        });
    </script>
    <link href="{{ asset('css/permohonan-s-p.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <div class="container-fluid">
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
                <button class="acs-icon-btn acs-add-btn acs-float" onclick="openNewWindow('SuratPesananEkspor/create')">
                    <div class="acs-add-icon"></div>
                    <div class="acs-btn-txt">Tambah SP</div>
                </button>
                <div class="card">
                    <div class="card-header">Surat Pesanan Ekspor</div>
                    <div class="card-body RDZOverflow RDZMobilePaddingLR0">
                        <div class="mb-2">
                        </div>
                        <table id="table_SP" class="table table-bordered table-striped SP_datatable" style="width:100%">
                            <thead class="thead-light">
                                <tr>
                                    <th>Nomor SP</th>
                                    <th>Nama Customer</th>
                                    <th>Tanggal Pesan</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    {{-- <button class="btn btn-info" onclick="openNewWindow('PenyesuaianSuratPesanan/A10830A/edit')">EDIT</button> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
