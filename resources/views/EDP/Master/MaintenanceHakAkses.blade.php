@extends('layouts.appEDP')
@section('content')
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/EDP/MaintenanceHakAkses.css') }}" rel="stylesheet">

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
                    <div class="card-header">Maintenance Hak Akses</div>
                    <div class="card-body RDZOverflow RDZMobilePaddingLR0">
                        <div class="acs-form">
                            <div class="acs-form1">
                                <div class="acs-div-filter">
                                    <label for="namaPegawai">Nama Pegawai</label>
                                    <select name="namaPegawai" id="namaPegawai" class="input">
                                        <option selected disabled>-- Pilih Pegawai--</option>
                                        @foreach ($pegawai as $data)
                                            <option value="{{ $data->NomorUser }}">{{$data->NamaUser . " - " . $data->NomorUser}}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="namaPegawaiText" id="namaPegawaiText">
                                </div>
                                <div class="acs-div-filter">
                                    <label for="namaProgram">Nama Program</label>
                                    <select name="namaProgram" id="namaProgram" class="input">
                                        <option selected disabled>-- Pilih Program--</option>
                                        @foreach ($program as $data)
                                            <option value="{{ $data->IdProgram }}">{{ $data->NamaProgram }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="namaProgramText" id="namaProgramText">
                                </div>
                            </div>
                            <div id="divFitur" class="acs-div-fitur">
                                <div id="listFitur" class="acs-div-fitur1">

                                </div>
                            </div>
                            <div id="divButton">
                                <button id="buttonProses" class="btn btn-success">Proses</button>
                                <button id="buttonCancel" class="btn btn-danger">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('js/EDP/MaintenanceHakAkses.js') }}"></script>
@endsection
