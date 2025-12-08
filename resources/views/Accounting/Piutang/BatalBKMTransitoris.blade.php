@extends('layouts.appAccounting')
@section('content')
@section('title', 'Batal BKM')

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-6 RDZMobilePaddingLR0">
                <div class="card">
                    <div class="card-header">BATAL BKM</div>
                    @if (Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    <div class="card-body RDZOverflow RDZMobilePaddingLR0">
                        <div class="form-container col-md-12">
                            <form method="POST" action="{{ url('BatalBKMTransitoris') }}" id="formkoreksi">
                                {{csrf_field()}}
                                <input type="hidden" name="_method" id="methodkoreksi">
                                <!-- Form fields go here -->
                                <div>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <input type="radio" name="radiogrup1" value="besar" id="kasBesar" checked>
                                            <label for="kasBesar">Kas Besar</label>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="radio" name="radiogrup1" value="kecil" id="kasKecil">
                                            <label for="kasKecil">Kas Kecil</label>
                                        </div>
                                    </div>
                                </div>
                                <p><div class="row">
                                    <div class="col-md-3">
                                        <label for="bulanTahun">Bulan/Tahun</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" id="bulanTahun" name="bulanTahun" class="form-control" style="width: 100%">
                                    </div>
                                </div>
                                <p><div class="row">
                                    <div class="col-md-3">
                                        <label for="idBKMSelect">BKM</label>
                                    </div>
                                    <div class="col-md-5">
                                        <select id="idBKMSelect" name="idBKMSelect" class="form-control">

                                        </select>
                                    </div>
                                </div>

                                <hr style="height:2px;">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="statusPenagihan">Status Penagihan</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" id="statusPenagihan" name="statusPenagihan" class="form-control" style="width: 100%">
                                    </div>
                                </div>
                                <p><div class="row">
                                    <div class="col-md-3">
                                        <label for="mataUang">Mata Uang</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" id="mataUang" name="mataUang" class="form-control" style="width: 100%">
                                    </div>
                                </div>
                                <p><div class="row">
                                    <div class="col-md-3">
                                        <label for="nilaiBKM">Nilai BKM</label>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" id="nilaiBKM" name="nilaiBKM" class="form-control" style="width: 100%">
                                    </div>
                                </div>
                                <p><div class="row">
                                    <div class="col-md-3">
                                        <label for="alasan">Alasan</label>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" id="alasan" name="alasan" class="form-control" style="width: 100%">
                                    </div>
                                </div>

                                <p><div class="row">
                                    <div class="col-md-3">
                                        <label for="alasan">Tgl. Batal</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="date" id="tanggalBatal" name="tanggalBatal" class="form-control" style="width: 100%">
                                    </div>
                                </div>
                                <p><div class="mb-3">
                                    <div class="row">
                                        <div class="col-10" style="padding-left: 15px">
                                            <input type="submit" id="btnProses" name="btnProses" value="PROSES" class="btn btn-success" disabled>
                                        </div>
                                        <div class="col-1">
                                            <input type="submit" id="btnkeluar" name="btnkeluar" value="KELUAR" class="btn btn-primary d-flex ml-auto">
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="{{ asset('js/Piutang/BatalBKMTransitoris.js') }}"></script>
@endsection
