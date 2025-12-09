@extends('layouts.appEDP')
@section('content')
    @include('EDP/Master/Cartridge/modalAddCartridge')
    @include('EDP/Master/Cartridge/modalEditCartridge')
    @vite(['resources/js/RDZ.js', 'resources/js/EDP/Cartridge.js']);
    <script>
        var dataCatridgeController = {!! json_encode($data->toArray(), JSON_HEX_TAG) !!};
    </script>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10 RDZMobilePaddingLR0">
                <div class="card">
                    <div class="card-header">List Cartridge
                        <a class="AddCartridge btn btn-primary btn-sm" href=""
                            style="float:right;margin-right: 1px">ADD</a>
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
                                    <th>Nomor</th>
                                    <th>User</th>
                                    <th>Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $index => $item)
                                    <tr>
                                        <td class="RDZPaddingTable">{{ $item['id'] }}</td>
                                        <td class="RDZPaddingTable">{{ $item['User'] }}</td>
                                        <td class="RDZPaddingTable">{{ $item['Type'] }}</td>
                                        <td>
                                            <a class="EditCartridge btn btn-warning btn-xs RDZEditDelTBL"
                                                style="border: 1px solid #212529;border-radius: 5px;"
                                                data-number="{{ $item->id }}" data-user="{{ $item->User }}"
                                                data-type="{{ $item->Type }}"
                                                href="{{ route('cartridge.update', $item->id) }}">Edit</a>
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
