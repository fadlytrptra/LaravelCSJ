@extends('layouts.appEDP')
@section('content')
@include('EDP/Perbaikan/Cartridge/modalAddNotaPerbaikan')
@include('EDP/Perbaikan/Cartridge/modalDetailPerbaikan')
<script src="{{ asset('js/EDP/PerbaikanCartridge.js') }}"></script>
<script>
    $(document).ready( function () {
    $('#table_PerbaikanCartridge').DataTable({
        order: [[0, 'desc']],
    });
} );
</script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Perbaikan
                    <a class="AddNota btn btn-primary btn-sm" href="" style="float:right;margin-right: 1px">ADD</a></div>

                <div class="card-body">
                    <table class="table table-borderless stripe overflow-scroll" id="table_PerbaikanCartridge">
                        <thead class="thead-dark">
                            <tr>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($CartridgeService as $item)
                            <tr>
                                <td><h3>{{$item['Tanggal']}}</h3></td>
                                <td>
                                    <a class="DetailRefill btn btn-primary btn-xs RDZEditDelTBL" style="border: 1px solid #212529;border-radius: 5px;" data-id="{{$item->id}}">Detail</a>
                                    <a href="{{route('perbaikancartridge.show', ['id' => $item->id])}}" class="btn btn-warning btn-xs RDZEditDelTBL" style="border: 1px solid #212529;border-radius: 5px;" data-id="{{$item->id}}">Edit</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
