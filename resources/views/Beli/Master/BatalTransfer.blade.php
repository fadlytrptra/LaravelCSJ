@extends('layouts.appOrderPembelian')
@section('content')
    <div class="container-fluid ">
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
                    <div class="card-header">Batal Transfer</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-2">
                                <label for="">No Terima</label>
                            </div>
                            <div class="col-10 col-md-8">
                                <input type="text" id="no_terima" name="no_terima" class="input w-100">
                            </div>
                            <div class="col-2">
                                <button class="btn btn-success" id="btn_proses">Proses</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ asset('js/OrderPembelian/BatalTransfer.js') }}"></script>
    @endsection
