@extends('layouts.appEDP')
@section('content')
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/MaintenanceIsOnline.css') }}" rel="stylesheet">

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
                    <div class="card-header">Maintenance Is Online</div>

                    <div class="card-body RDZOverflow RDZMobilePaddingLR0">
                        <div class="acs-form">
                            <div class="acs-form1">
                               <form action="{{ route('maintenance.isonline.update') }}" method="POST">
                                    @csrf
                                    <div class="acs-div-filter">
                                        <label for="namaPegawai">Nama Pegawai</label>
                                        <select name="NomorUser" id="namaPegawai" class="input" required>
                                            <option selected disabled>-- Pilih Pegawai--</option>
                                            @foreach($pegawai as $p)
                                                <option
                                                    value="{{ $p->NomorUser }}"
                                                    data-isonline="{{ $p->IsOnline ? 1 : 0 }}">
                                                    {{ $p->NamaUser }} - {{ $p->NomorUser }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div style="margin-top:10px;">
                                            <input type="checkbox" id="IsOnline" name="IsOnline">
                                            <label for="IsOnline">Is Online</label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success">Proses</button>
                                    <button type="reset" class="btn btn-danger">Cancel</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('js/EDP/MaintenanceIsOnline.js') }}"></script>
@endsection
