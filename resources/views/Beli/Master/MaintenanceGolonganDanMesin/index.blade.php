@extends('layouts.appOrderPembelian')
@section('content')
@section('title', 'Maintenance Golongan dan Mesin')
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
                <div class="card">
                    <div class="card-header">Maintenance Golongan dan Mesin</div>
                    <div class="card-body RDZOverflow RDZMobilePaddingLR0">
                        {{-- form --}}
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label for="divisi">Divisi</label>
                            </div>
                            <div class="form-group col-md-2">
                                <input type="text" id="divisi" name="divisi" class="form-control" readonly>
                            </div>
                            <div class="form-group col-md-8">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="namaDivisi" name="namaDivisi" readonly>
                                    <div class="input-group-append">
                                        <button type="button" id="btnDivisi" class="btn btn-info" disabled>...</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label for="golongan">Kelompok Utama</label>
                            </div>
                            <div class="form-group col-md-2">
                                <input type="text" id="golongan" name="golongan" class="form-control" readonly>
                            </div>
                            <div class="form-group col-md-8">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="namaGolongan" name="namaGolongan" readonly>
                                    <div class="input-group-append">
                                        <button type="button" id="btnGolongan" class="btn btn-info" disabled>...</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label for="mesin">Kelompok</label>
                            </div>
                            <div class="form-group col-md-2">
                                <input type="text" id="mesin" name="mesin" class="form-control" readonly>
                            </div>
                            <div class="form-group col-md-8">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="namaMesin"
                                        name="namaMesin" readonly>
                                    <div class="input-group-append">
                                        <button type="button" id="btnMesin" class="btn btn-info" disabled>...</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <button type="button" id="btnIsi" class="btn btn-primary">ISI</button>
                            <button type="button" id="btnKoreksi" class="btn btn-primary">KOREKSI</button>
                            <button type="button" id="btnHapus" class="btn btn-primary">HAPUS</button>
                            <button type="button" id="btnProses" class="btn btn-primary" disabled>PROSES</button>
                            <button type="button" id="btnBatal" class="btn btn-primary" disabled>BATAL</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('js/OrderPembelian/Master/MaintenanceGolonganDanMesin.js') }}"></script>
@endsection
