@extends('layouts.appSales')
@section('content')
@section('title', 'Pelunasan SP')
<style>
    .custom-modal-width {
        max-width: 95%;
        /* Adjust the percentage as needed */
    }
</style>
<link href="{{ asset('css/permohonan-s-p.css') }}" rel="stylesheet">
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 RDZMobilePaddingLR0">
            @if (Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header" id="headerCard">Surat Pesanan Belum Lunas</div>
                <div class="card-body RDZOverflow RDZMobilePaddingLR0">
                    <table id="table_SP" class="table table-bordered table-striped SP_datatable" style="width:100%">
                        <thead class="thead-light">
                            <tr>
                                <th>ID Pesanan</th>
                                <th>Nomor SP</th>
                                <th>Nama Customer </th>
                                <th>Nama Type</th>
                                <th>Tanggal Pesan</th>
                                <th>Nama Sales</th>
                                <th>Jumlah Order</th>
                                <th>Sisa Order</th>
                                <th>Saldo Primer</th>
                                <th>Saldo Sekunder</th>
                                <th>Saldo Tritier</th>
                            </tr>
                        </thead>
                    </table>
                    {{-- <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="checkbox_all" value="option2">
                        <label class="form-check-label" for="checkbox2">Pilih Semua</label>
                    </div> --}}
                    <div style="gap: 5px; grid-template-columns: auto;">
                        {{-- <form
                            onsubmit="return confirm('Apakah Anda Yakin untuk melunasi surat pesanan yang sudah dipilih?');"
                            id="form_submitSelected" action="{{ url('/SuratPesananManager/upall') }}" method="POST"
                            enctype="multipart/form-data">
                            {{ csrf_field() }} --}}
                            <button class="btn btn-sm btn-success" id="btn_submitSelected"><span>&#x2713;</span>
                                Lunasi Surat Pesanan yang Dipilih</button>
                        {{-- </form> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/Sales/PelunasanSP.js') }}"></script>
@endsection
