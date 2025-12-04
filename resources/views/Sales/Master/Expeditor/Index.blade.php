@extends('layouts.appSales')
@section('title', 'Expeditor')
@section('content')
    @include('Sales.Master.Expeditor.DetailExpeditor')
    <script>
        $(document).ready(function() {
            $('#table_Expeditor').DataTable({
                order: [
                    [1, 'desc']
                ],
            });
        });
    </script>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10 RDZMobilePaddingLR0">
                {{-- button untuk munculin modal --}}
                <button class="acs-icon-btn acs-add-btn acs-float" onclick="openNewWindow('Expeditor/create')">
                    <div class="acs-add-icon"></div>
                    <div class="acs-btn-txt">Tambah Expeditor</div>
                </button>
                <div class="card">
                    {{-- @if (Auth::user()->status == 1) --}}
                    <div class="card-header">Expeditor</div>
                    {{-- @else
                        <div class="card-header">Home</div>
                    @endif --}}
                    <div class="card-body RDZOverflow RDZMobilePaddingLR0">
                        <table id="table_Expeditor" class="table table-bordered table-striped" style="width:100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Id Expeditor</th>
                                    <th>Nama Expeditor </th>
                                    <th>Contact Person</th>
                                    <th>Negara</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td class="RDZPaddingTable RDZCenterTable"><a class="DetailExpeditor"
                                                data-id="{{ $item->IDExpeditor }}">{{ $item['IDExpeditor'] }}</a>
                                        </td>
                                        <td class="RDZPaddingTable RDZCenterTable">{{ $item['NamaExpeditor'] }}</td>
                                        <td class="RDZPaddingTable RDZCenterTable">{{ $item['ContactPerson'] }}</td>
                                        <td class="RDZPaddingTable RDZCenterTable">{{ $item['Negara'] }}</td>
                                        <td class="acs-td-button"><button class="btn btn-sm btn-primary"
                                                onclick="openNewWindow('{{ url('Expeditor/' . $item->IDExpeditor . '/edit') }}')"
                                                href=""><span>&#x270E;</span>Edit</button>
                                            <form onsubmit="return confirm('Apakah Anda Yakin ?');"
                                                action="{{ route('expeditor.destroy', $item->IDExpeditor) }}" method="POST"
                                                enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                <button type="submit"
                                                    class="btn btn-sm btn-danger"><span>&#x1F5D1;</span>Hapus</button>
                                            </form>
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
