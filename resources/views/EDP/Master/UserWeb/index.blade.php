@extends('layouts.appEDP')
@section('title', 'Maintenance User Web')
@section('content')
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/EDP/MaintenanceUserWeb.css') }}" rel="stylesheet">

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10 RDZMobilePaddingLR0">
                <div class="card">
                    <div class="card-header">Maintenance User Web</div>
                    <div class="card-body RDZOverflow RDZMobilePaddingLR0">
                        <table id="table_userWeb" class="table table-bordered table-striped" style="width:100%">
                            <thead class="thead-light">
                                <tr>
                                    <th>Nomor User</th>
                                    <th>Nama User</th>
                                    <th>Actions</th>
                                    <th>ttd</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('EDP/Master/UserWeb/modalTambahTTD')
    <script type="text/javascript" src="{{ asset('js/EDP/MaintenanceUserWeb.js') }}"></script>
@endsection
