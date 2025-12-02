@extends('layouts.appOrderPembelian')
@section('content')
@section('title', 'Edit Supplier ' . $data[0]->NM_SUP)
<link href="{{ asset('css/Supplier.css') }}" rel="stylesheet">
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
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
            <div class="card font-weight-bold">
                <div class="card-header">Supplier Edit Data {{ $data[0]->NO_SUP }} - {{ $data[0]->NM_SUP }}</div>
                <div class="card-body">
                    <form class="form" method="POST" enctype="multipart/form-data" action="{{ url('Supplier') }}"
                        id="form_supplier">
                        {{ csrf_field() }}
                        <div class="">
                            <div class="acs-div-container">
                                <div class="pl-2">
                                    <label for="supplier">Supplier</label>
                                    <div class="acs-div-filter2">
                                        <input type="text" name="supplier_text" id="supplier_text"
                                            class="input font-weight-bold col-12" value="{{ $data[0]->NM_SUP }}">
                                        {{-- <select name="supplier_select" id="supplier_select" class="font-weight-bold"
                                                style="display: none; width:250px;">
                                                <option selected disabled>--Pilih Supplier--</option>
                                                @foreach ($supplier as $data)
                                                    <option value="{{ $data->NO_SUP }}">
                                                        {{ $data->NM_SUP }}</option>
                                                @endforeach
                                            </select> --}}
                                            <input type="hidden" name="kode" id="kode" value="2">
                                            <input type="hidden" name="supplier_id" id="supplier_id" value="{{ $data[0]->NO_SUP }}">
                                            <input type="hidden" name="kode_form" id="kode_form" value="Edit">
                                            {{-- <input type="hidden" name="kode" id="kode">
                                            <button id="swtich_supplier" class="btn btn-info"
                                                style="display: inline;">↺</button> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="col-12">
                                        <label for="contact_person1">Contact Person 1</label>
                                        <input type="text" name="contact_person1" id="contact_person1"
                                            class="form-control font-weight-bold" value="{{ $data[0]->PERSON1 }}">
                                    </div>
                                    <div class="col-12">
                                        <label for="phone1">Phone 1</label>
                                        <input type="text" name="phone1" id="phone1"
                                            class="form-control font-weight-bold" value="{{ $data[0]->TLP1 }}">
                                    </div>
                                    <div class="col-12">
                                        <label for="mobile_phone1">Mobile Phone 1</label>
                                        <input type="text" name="mobile_phone1" id="mobile_phone1"
                                            class="form-control font-weight-bold" value="{{ $data[0]->HPHONE1 }}">
                                    </div>
                                    <div class="col-12">
                                        <label for="email1">Email 1</label>
                                        <input type="text" name="email1" id="email1"
                                            class="form-control font-weight-bold" value="{{ $data[0]->TELEX1 }}">
                                    </div>
                                    <div class="col-12">
                                        <label for="fax1">Fax 1</label>
                                        <input type="text" name="fax1" id="fax1"
                                            class="form-control font-weight-bold" value="{{ $data[0]->FAX1 }}">
                                    </div>
                                    <div class="col-12">
                                        <label for="alamat1">Alamat 1</label>
                                        <input type="text" name="alamat1" id="alamat1"
                                            class="form-control font-weight-bold" value="{{ $data[0]->ALAMAT1 }}">
                                    </div>
                                    <div class="col-12">
                                        <label for="kota1">Kota 1</label>
                                        <input type="text" name="kota1" id="kota1"
                                            class="form-control font-weight-bold" value="{{ $data[0]->KOTA1 }}">
                                    </div>
                                    <div class="col-12">
                                        <label for="negara1">Negara 1</label>
                                        <input type="text" name="negara1" id="negara1"
                                            class="form-control font-weight-bold" value="{{ $data[0]->NEGARA1 }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-12">
                                        <label for="contact_person2">Contact Person 2</label>
                                        <input type="text" name="contact_person2" id="contact_person2"
                                            class="form-control font-weight-bold" value="{{ $data[0]->PERSON2 }}">
                                    </div>
                                    <div class="col-12">
                                        <label for="phone2">Phone 2</label>
                                        <input type="text" name="phone2" id="phone2"
                                            class="form-control font-weight-bold" value="{{ $data[0]->TLP2 }}">
                                    </div>
                                    <div class="col-12">
                                        <label for="mobile_phone2">Mobile Phone 2</label>
                                        <input type="text" name="mobile_phone2" id="mobile_phone2"
                                            class="form-control font-weight-bold" value="{{ $data[0]->HPHONE2 }}">
                                    </div>
                                    <div class="col-12">
                                        <label for="email2">Email 2</label>
                                        <input type="text" name="email2" id="email2"
                                            class="form-control font-weight-bold" value="{{ $data[0]->TELEX2 }}">
                                    </div>
                                    <div class="col-12">
                                        <label for="fax2">Fax 2</label>
                                        <input type="text" name="fax2" id="fax2"
                                            class="form-control font-weight-bold" value="{{ $data[0]->FAX2 }}">
                                    </div>
                                    <div class="col-12">
                                        <label for="alamat2">Alamat 2</label>
                                        <input type="text" name="alamat2" id="alamat2"
                                            class="form-control font-weight-bold" value="{{ $data[0]->ALAMAT2 }}">
                                    </div>
                                    <div class="col-12">
                                        <label for="kota2">Kota 2</label>
                                        <input type="text" name="kota2" id="kota2"
                                            class="form-control font-weight-bold" value="{{ $data[0]->KOTA2 }}">
                                    </div>
                                    <div class="col-12">
                                        <label for="negara2">Negara 2</label>
                                        <input type="text" name="negara2" id="negara2"
                                            class="form-control font-weight-bold" value="{{ $data[0]->NEGARA2 }}">
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <div class="acs-div-filter1 pl-3">
                                    <label for="mata_uang">Mata Uang</label>
                                    <select name="mata_uang" id="mata_uang" class="input font-weight-bold">
                                        <option selected disabled>-- Pilih Mata Uang--</option>
                                        @foreach ($matauang as $dataMataUang)
                                            <option value="{{ $dataMataUang->Id_MataUang }}"
                                                {{ $data[0]->Id_MataUang == $dataMataUang->Id_MataUang ? 'selected' : '' }}>
                                                {{ $dataMataUang->Nama_MataUang }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-4 pl-3">
                                <div class="col-md-12">
                                    <div class="text-end">
                                        <button id="save_button" class="btn btn-success font-weight-bold">
                                            <span>Save</span>
                                        </button>
                                        <button id="clear_button" class="btn btn-secondary font-weight-bold">
                                            <span>Clear All</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/OrderPembelian/Supplier.js') }}"></script>
@endsection
