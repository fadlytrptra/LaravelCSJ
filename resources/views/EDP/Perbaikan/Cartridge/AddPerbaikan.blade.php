@extends('layouts.appEDP')
@section('content')
@include('EDP/Perbaikan/Cartridge/modalEditNotaPerbaikan')
@include('EDP/Perbaikan/Cartridge/modalAddServiceCartridge')
<script src="{{ asset('js/EDP/PerbaikanCartridge.js') }}"></script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Cartridge List
                </div>

                <div class="card-body">
                    <form class="form" method="POST" enctype="multipart/form-data" action="{{route('perbaikancartridge.addrefill',$id)}}" >
                    {{ csrf_field() }}
                        <div width="100%">
                            <label>ID</label>
                            <input id="cartridge" type="text" class="form-control" name="cartridge" autocomplete="off"><br>
                            <label>Service</label><a class="AddService btn btn-primary btn-sm border-dark" href="" style="float:right;margin-right: 1px">ADD SERVICE</a>
                            <select name="service" id="service" class="form-control">
                                @foreach($Service as $item)
                                    <option value="{{$item->id}}">{{$item['perbaikan']}}</option>
                                @endforeach
                            </select>
                            <br>
                            <button type="submit" class="btn btn-sm btn-primary" style="width:100%;" name="submit">ADD</button>
                        </div>
                    </form>
                    <br>
                    <div class="border-top border-bottom border-dark">
                    <br>
                        <a class="EditNota btn btn-warning btn-sm border-dark" href="" style="float:right;margin-right: 1px">EDIT NOTA</a>
                        <p>Tanggal: {{$Nota->Tanggal}}</p>
                        <p>No Nota: {{$Nota->NoNota}}</p>
                    </div>
                    <br>
                    <table class="table table-borderless stripe overflow-scroll">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>User</th>
                                <th>Type</th>
                                <th>Service</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($Cartridge as $item)
                            <tr>
                                <td>{{$item['IdCartridge']}}</td>
                                <td>{{$item['User']}}</td>
                                <td>{{$item['perbaikan']}}</td>
                                <td>{{$item['Type']}}</td>

                                <td>
                                    <a class="DeleteRefill btn btn-danger btn-xs RDZEditDelTBL" style="border: 1px solid #212529;border-radius: 5px;" href="{{route('perbaikancartridge.DelCartridgeRefill',['id' => $id, 'IdCartridge' => $item->IdCartridge,'IdPerbaikan' => $item->IdPerbaikan])}}">Delete</a>
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
