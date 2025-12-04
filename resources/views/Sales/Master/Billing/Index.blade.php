@extends('layouts.appSales')
@section('content')
@section('title', 'Billing')
    @include('Sales.Master.Billing.DetailBilling')
    <script>
        $(document).ready(function() {
            $('#table_Billing').DataTable({
                order: [
                    [1, 'desc']
                ],
            });
        });
    </script>
    <link href="{{ asset('css/billing.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10 RDZMobilePaddingLR0">
                {{-- button untuk munculin create billing --}}
                <button class="acs-icon-btn acs-add-btn acs-float" onclick="openNewWindow('Billing/create')">
                    <div class="acs-add-icon"></div>
                    <div class="acs-btn-txt">Tambah Billing</div>
                </button>
                <div class="card">
                    {{-- @if (Auth::user()->status == 1) --}}
                    <div class="card-header">Billing</div>
                    {{-- @else
                        <div class="card-header">Home</div>
                    @endif --}}
                    <div class="card-body RDZOverflow RDZMobilePaddingLR0">
                        <table id="table_Billing" class="table table-bordered table-striped" style="width:100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Id Billing</th>
                                    <th>Nama Billing </th>
                                    <th>Contact Person</th>
                                    <th>Negara</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td class="RDZPaddingTable RDZCenterTable"><a class="DetailBilling"
                                                data-id="{{ $item->IDBill }}">{{ $item['IDBill'] }}</a>
                                        </td>
                                        <td class="RDZPaddingTable RDZCenterTable">{{ $item['NamaBill'] }}</td>
                                        <td class="RDZPaddingTable RDZCenterTable">{{ $item['ContactPerson'] }}</td>
                                        <td class="RDZPaddingTable RDZCenterTable">{{ $item['Negara'] }}</td>
                                        <td class="acs-td-button"><button class="btn btn-sm btn-primary"
                                                onclick="openNewWindow('{{ url('Billing/' . $item->IDBill . '/edit') }}')"
                                                href=""><span>&#x270E;</span>Edit</button>
                                            <form onsubmit="return confirm('Apakah Anda Yakin ?');"
                                                action="{{ route('billing.destroy', $item->IDBill) }}" method="POST"
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
