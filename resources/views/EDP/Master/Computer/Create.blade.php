@extends('layouts.appEDP') @section('content')
@section('title', 'Add Computer')
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
<link href="{{ asset('css/computer.css') }}" rel="stylesheet">
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 RDZMobilePaddingLR0">
            @if (Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">Add Computer</div>
                <div class="card-body RDZOverflow RDZMobilePaddingLR0">
                    <div>
                        <form method="POST" action="{{ url('Computer') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="jenisStore" value="CreateComputer">
                            <div class="permohonan-do-form">
                                <div class="acs-form">
                                    <div class="acs-form1">
                                        <div class="acs-div-filter">
                                            <label for="KodeComputer">Kode Computer</label>
                                            <input type="text" name="KodeComputer" id="KodeComputer"
                                                placeholder="Kode Computer" class="input">
                                        </div>
                                        <div class="acs-div-filter">
                                            <label for="NamaUser">Nama User</label>
                                            <input type="text" name="NamaUser" id="NamaUser" placeholder="Nama User"
                                                class="input">
                                        </div>
                                        <div class="acs-div-filter">
                                            <label for="ipAddress">IP Address</label>
                                            <div class="acs-div-filter1">
                                                <input type="text" name="ipAddress" id="ipAddress"
                                                    placeholder="IP Address" class="input" style="width: 65%;"
                                                    oninput="validateIpAddress()">
                                                <div id="result"></div>
                                                <div id="error"></div>
                                            </div>
                                        </div>
                                        <div class="acs-div-filter">
                                            <label for="Lokasi">Lokasi</label>
                                            <div>
                                                <select name="Lokasi" id="Lokasi" class="input">
                                                    <option selected disabled>-- Pilih Lokasi--</option>
                                                    @foreach ($lokasi as $data)
                                                        <option value="{{ $data->Id_Lokasi }}">
                                                            {{ $data->Id_Lokasi . ' - ' . $data->Lokasi }}</option>
                                                    @endforeach
                                                </select>
                                                <button type="button" onclick="showModal('AddNewLocation')"
                                                    class="btn btn-primary">Add New Location</button>
                                            </div>
                                        </div>
                                        <div class="acs-div-filter">
                                            <label for="Ruangan">Ruangan</label>
                                            <input type="text" name="Ruangan" id="Ruangan" class="input">
                                        </div>
                                        <div class="acs-div-filter">
                                            <label for="OperatingSystem">Operating System</label>
                                            <div>
                                                <select name="TypeOS" id="TypeOS" class="input">
                                                    <option selected disabled>-- Pilih Type OS--</option>
                                                    @foreach ($typeos as $data)
                                                        <option value="{{ $data->Is_OS }}">
                                                            {{ $data->Sistem_Operas }}</option>
                                                    @endforeach
                                                </select>
                                                <button type="button" onclick="showModal('AddNewOS')"
                                                    class="btn btn-primary">Add New OS</button>
                                            </div>
                                        </div>
                                        <div class="acs-div-filter">
                                            <label for="WindowsUpdate">Windows Update</label>
                                            <div>
                                                <input type="radio" name="WindowsUpdate" id="WindowsUpdateYes"
                                                    checked>Yes
                                                <input type="radio" name="WindowsUpdate" id="WindowsUpdateNo">No
                                            </div>
                                        </div>
                                        <div class="acs-div-filter">
                                            <label for="DeviceType">Device Type</label>
                                            <input type="text" name="DeviceType" id="DeviceType" class="input">
                                        </div>
                                        <div class="acs-div-filter">
                                            <label for="PurchaseDate">Purchase Date</label>
                                            <input type="date" name="PurchaseDate" id="PurchaseDate" class="input">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="acs-div-btn">
                                <button id="submit_btn" class="btn btn-primary">
                                    <span>Submit</span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ asset('js/EDP/Computer.js') }}"></script>
{{-- @include('EDP.Master.Computer.DetailComputer') --}}
@endsection
