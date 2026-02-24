@extends('layouts.appSales')
@section('content')
@section('title', 'Penyesuaian Harga Satuan 2')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 RDZMobilePaddingLR0">
            <div class="card">
                <div class="card-header">Penyesuaian Harga Satuan 2</div>
                <div class="card-body">
                    <div style="display: flex; flex-direction: row;margin: 0 0 1rem 0; gap: 5px">
                        <div style="display: flex; flex-direction: column;">
                            <label for="id_pengiriman">ID Pengiriman</label>
                            <textarea name="id_pengiriman" id="id_pengiriman" class="form-control" cols="100" rows="3"></textarea>
                        </div>
                        <div style="align-content: end">
                            <button class="btn btn-info" id="button_updateHargaSatuan2">Update Harga Satuan 2</button>
                        </div>
                    </div>
                    <p>Keterangan: <br>
                        Data ID Pengiriman yang diinput bisa lebih dari 1 dengan format sebagai berikut: <br>
                        (ID Pengiriman 1) (Koma) (Spasi) (ID Pengiriman 2) &rarr; 0000006500, 0000006501
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/Sales/PenyesuaianHargaSatuan2.js') }}"></script>

@endsection
