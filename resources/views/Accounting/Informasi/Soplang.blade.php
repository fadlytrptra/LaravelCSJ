@extends('layouts.appAccounting')
@section('content')
@section('title', 'Soplang')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6 RDZMobilePaddingLR0">
            <div class="card">
                <div class="card-header">Informasi Piutang Penjualan</div>
                {{-- @if (Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                    @endif --}}
                <div class="card-body RDZOverflow RDZMobilePaddingLR0">
                    <div class="form-container col-md-12">
                        {{-- <form method="POST" action="{{ url('Soplang') }}" id="formkoreksi"> --}}
                        {{-- {{csrf_field()}} --}}
                        <input type="hidden" name="_method" id="methodkoreksi">
                        <div class="d-flex">
                            <div class="col-md-4">
                                <label for="tglAkhirLaporan">Tgl Akhir Laporan</label>
                            </div>
                            <div class="col-md-5">
                                <input type="date" id="tglAkhirLaporan" name="tglAkhirLaporan" class="form-control"
                                    style="width: 100%">
                            </div>
                        </div>

                        <br>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-2">
                                    <input type="submit" id="btnProses" name="btnProses" value="Proses"
                                        class="btn btn-primary">
                                </div>
                            </div>
                        </div>
                        {{-- </form> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/Accounting/Informasi/Soplang.js') }}"></script>
@endsection
