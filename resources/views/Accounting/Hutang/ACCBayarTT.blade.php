@extends('layouts.appAccounting')
@section('content')
@section('title', 'ACC Bayar TT')

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12 RDZMobilePaddingLR0">
                <div class="card">
                    <div class="card-header">Maintenance BKK (Tunai) -- ACC TT</div>
                    <div class="card-body RDZOverflow RDZMobilePaddingLR0">
                        <div class="form-container col-md-12">
                            <form method="POST" action="">
                                @csrf
                                <!-- Form fields go here -->

                                <p><div style="overflow-x: auto;">
                                    <table style="width: 100%; table-layout: fixed;">
                                        <colgroup>
                                        <col style="width: 10%;">
                                        <col style="width: 10%;">
                                        <col style="width: 30%;">
                                        <col style="width: 10%;">
                                        <col style="width: 20%;">
                                        <col style="width: 10%;">
                                        </colgroup>
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>ID. Penagihan</th>
                                                <th>Nama Supplier</th>
                                                <th>Mata Uang Tagih</th>
                                                <th>Nilai Penagihan</th>
                                                <th>Lunas</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><input type="checkbox" class="data-checkbox">Data 1</td>
                                                <td>Data 2</td>
                                                <td>Data 3</td>
                                                <td>Data 4</td>
                                                <td>Data 5</td>
                                                <td>Data 6</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <p>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="checkbox2" value="option2">
                                    <label class="form-check-label" for="checkbox2">Centang Semua</label>
                                </div>
                                <div>
                                    <input type="submit" name="refresh" value="REFRESH" class="btn btn-primary">
                                    <input type="submit" name="ttditunai" value="TT diTunai" class="btn btn-primary">
                                    <input type="submit" name="proses" value="PROSES" class="btn btn-primary">
                                    <input type="submit" name="keluar" value="KELUAR" class="btn btn-primary">
                                </div>

                            </form>
                            <br>
                            <div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
