@extends('layouts.appEDP')
@section('content')
@include('EDP/Jurnal/modalAddJurnal')
@include('EDP/Jurnal/modalEditJurnal')
@include('EDP/Jurnal/modalDelJurnal')
@include('EDP/Jurnal/modalDetailJurnal')
<script src="{{ asset('js/EDP/Jurnal.js') }}"></script>
<script>
    $(document).ready( function () {
    $('#table_Cartridge').DataTable({
        order: [[0, 'desc']],
    });
} );
</script>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 RDZMobilePaddingLR0">
            <div class="card">
                <div class="card-header" >Jurnal
                <a class="AddJurnal btn btn-primary btn-sm" href="" style="float:right;margin-right: 1px">ADD</a>
                </div>
                <div class="card-body RDZOverflow RDZMobilePaddingLR0">
                    @if (\Session::has('danger'))
                    <div class="alert alert-danger">
                        {!! \Session::get('danger') !!}
                    </div>
                    @endif
                    <table id="table_Cartridge" class="table table-bordered table-striped" style="width:100%;">
                        <thead class="thead-dark">
                            <tr>
                                <th>Tgl. Lapor</th>
                                <th>Pelapor</th>
                                <th>Kategori</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $index=>$item)
                            <tr>
                                <td class="RDZPaddingTable RDZDetailTable DetailJurnal" data-id="{{$item->IdJurnal}}">{{$item['Tgl_Lapor']}}</td>
                                <td class="RDZPaddingTable RDZDetailTable DetailJurnal" data-id="{{$item->IdJurnal}}">{{$item['NamaUser']}}</td>
                                <td class="RDZPaddingTable RDZDetailTable DetailJurnal" data-id="{{$item->IdJurnal}}">{{$item['Kategori']}}</td>
                                <td>
                                    @if($item['Id_Kelompok']==null)
                                    <a class="EditJurnal btn btn-warning btn-xs" style="border: 1px solid #212529;border-radius: 5px;" data-TglLapor="{{$item->Tgl_Lapor}}"
                                        data-TglSelesai="{{$item->Tgl_Selesai}}" data-Pelapor="{{$item->Pelapor}}" data-DetailPermasalahan="{{$item->DetailPermasalahan}}"
                                        data-Solusi="{{$item->Solusi}}" data-Kategori="{{$item->Kategori}}" data-Kelompok="{{$item->Kelompok}}"
                                        href="{{route('jurnal.update',$item->IdJurnal)}}">Edit</a>

                                    <a class="DelJurnal btn btn-danger btn-xs" style="border: 1px solid #212529;border-radius: 5px;"
                                        data-TglLapor="{{$item->Tgl_Lapor}}" data-Pelapor="{{$item->NamaUser}}" data-Kategori="{{$item->Kategori}}"
                                        href="{{route('jurnal.destroy',$item->IdJurnal)}}">Delete</a>
                                        @endif
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
