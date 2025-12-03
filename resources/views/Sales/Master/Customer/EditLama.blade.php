@extends('layouts.appSales') @section('content')
    <link href="{{ asset('css/customer.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <div class="col-md-10 RDZMobilePaddingLR0">
        <div class="customer-container">
            <div class="customer-container01">
                <form class="customer-form" method="POST" action="{{ route('customer.update', $model->IDCust) }}"
                    enctype="multipart/form-data"> {{ csrf_field() }} <div class="customer-container02">
                        <div class="customer-container03">
                            <div class="customer-container04">
                                <div class="customer-container05"> <span class="customer-text">Jenis Customer</span> </div>
                                <div class="customer-container06"> <span class="customer-text01">Nama Customer</span> </div>
                                <div class="customer-container07"> <span class="customer-text02">Initial Customer</span>
                                </div>
                                <div class="customer-container08"> <span class="customer-text03"> <span>Contact
                                            Person</span> <br /> </span> </div>
                                <div class="customer-container09"> <span class="customer-text06">Limit Pembelian</span>
                                </div>
                                <div class="customer-container10"> <span class="customer-text07"> <span>Alamat Kantor</span>
                                        <br /> </span> </div>
                                <div class="customer-container11"> <span class="customer-text10">Kota</span> </div>
                                <div class="customer-container12"> <span class="customer-text11"> <span>Provinsi</span>
                                        <br /> </span> </div>
                                <div class="customer-container13"> <span class="customer-text14"> <span>Negara</span> <br />
                                    </span> </div>
                                <div class="customer-container14"> <span class="customer-text17">Kode Pos</span> </div>
                            </div>
                            <div class="customer-container15">
                                <div class="customer-container16">
                                    <div class="customer-container17"> <select name="JnsCust" id="JnsCust"
                                            class="form-control" disabled>
                                            @foreach ($jnscust as $data)
                                                <option value="{{ $data->IDJnsCust }}"
                                                    {{ $model->JnsCust == $data->IDJnsCust ? 'selected' : '' }}>
                                                    {{ $data->IDJnsCust }} - {{ $data->NamaJnsCust }}</option>
                                                {{-- <option value="{{ $data->IDJnsCust }}">
                                                    {{ $data->IDJnsCust . ' - ' . $data->NamaJnsCust }}</option> --}}
                                            @endforeach
                                        </select> </div>
                                </div>
                                <div class="customer-container19"> <input type="text" value="{{ $model->NamaCust }}"
                                        name="NamaCust" placeholder="Nama Customer" class="customer-textinput02 input" />
                                </div>
                                <div class="customer-container20"> <input type="text" value="{{ $model->KodeCust }}"
                                        name="KodeCust" placeholder="Initial Customer" class="customer-textinput03 input" />
                                </div>
                                <div class="customer-container21"> <input type="text"
                                        value="{{ $model->ContactPerson }}" name="ContactPerson"
                                        placeholder="Contact Person" class="customer-textinput04 input" /> </div>
                                <div class="customer-container22"> <input type="text" value="{{ $model->LimitBeli }}"
                                        name="LimitBeli" placeholder="Limit Pembelian" class="customer-textinput05 input" />
                                </div>
                                <div class="customer-container23"> <input type="text" value="{{ $model->Alamat }}"
                                        name="Alamat" placeholder="Alamat Kantor" class="customer-textinput06 input" />
                                </div>
                                <div class="customer-container24"> <input type="text" value="{{ $model->Kota }}"
                                        name="Kota" placeholder="Kota" class="customer-textinput07 input" /> </div>
                                <div class="customer-container25"> <input type="text" value="{{ $model->Propinsi }}"
                                        name="Propinsi" placeholder="Provinsi" class="customer-textinput08 input" /> </div>
                                <div class="customer-container26"> <input type="text" value="{{ $model->Negara }}"
                                        name="Negara" placeholder="Negara" class="customer-textinput09 input" /> </div>
                                <div class="customer-container27"> <input type="text" value="{{ $model->KodePos }}"
                                        name="KodePos" placeholder="Kode Pos" class="customer-textinput10 input" /> </div>
                            </div>
                        </div>
                        <div class="customer-container28">
                            <div class="customer-container29">
                                <div class="customer-container30"> <span class="customer-text18"> <span>No. Telpon 1</span>
                                        <br /> </span> </div>
                                <div class="customer-container31"> <span class="customer-text21"> <span>No. Telpon 2</span>
                                        <br /> </span> </div>
                                <div class="customer-container32"> <span class="customer-text24"> <span>No. Telex</span>
                                        <br /> </span> </div>
                                <div class="customer-container33"> <span class="customer-text27"> <span>No. Fax 1</span>
                                        <br /> </span> </div>
                                <div class="customer-container34"> <span class="customer-text30"> <span>No. Fax 2</span>
                                        <br /> </span> </div>
                                <div class="customer-container35"> <span class="customer-text33"> <span>No. HP 1</span>
                                        <br /> </span> </div>
                                <div class="customer-container36"> <span class="customer-text36"> <span>No. HP 2</span>
                                        <br /> </span> </div>
                                <div class="customer-container37"> <span class="customer-text39"> <span>Email</span>
                                        <br /> </span> </div>
                                <div class="customer-container38"> <span class="customer-text42"> <span>Alamat
                                            Kirim</span> <br /> </span> </div>
                                <div class="customer-container39"> <span class="customer-text45"> <span>Kota Kirim</span>
                                        <br /> </span> </div>
                            </div>
                            <div class="customer-container40">
                                <div class="customer-container41"> <input type="text" value="{{ $model->NoTelp1 }}"
                                        name="NoTelp1" placeholder="Nomor Telpon 1" class="customer-textinput11 input" />
                                </div>
                                <div class="customer-container42"> <input type="text" value="{{ $model->NoTelp2 }}"
                                        name="NoTelp2" placeholder="Nomor Telpon 2" class="customer-textinput12 input" />
                                </div>
                                <div class="customer-container43"> <input type="text" value="{{ $model->NoTelex }}"
                                        name="NoTelex" placeholder="Nomor Telex" class="customer-textinput13 input" />
                                </div>
                                <div class="customer-container44"> <input type="text" value="{{ $model->NoFax1 }}"
                                        name="NoFax1" placeholder="Nomor Fax 1" class="customer-textinput14 input" />
                                </div>
                                <div class="customer-container45"> <input type="text" value="{{ $model->NoFax2 }}"
                                        name="NoFax2" placeholder="Nomor Fax 2" class="customer-textinput15 input" />
                                </div>
                                <div class="customer-container46"> <input type="text" value="{{ $model->NoHp1 }}"
                                        name="NoHp1" placeholder="Nomor HP 1" class="customer-textinput16 input" />
                                </div>
                                <div class="customer-container47"> <input type="text" value="{{ $model->NoHp2 }}"
                                        name="NoHp2" placeholder="Nomor HP 2" class="customer-textinput17 input" />
                                </div>
                                <div class="customer-container48"> <input type="text" value="{{ $model->Email }}"
                                        name="Email" placeholder="Email" class="customer-textinput18 input" /> </div>
                                <div class="customer-container49">
                                    <textarea value="{{ $model->AlamatKirim }}" name="AlamatKirim" placeholder="Alamat Kirim"
                                        class="customer-textarea textarea">{{ $model->AlamatKirim }}</textarea>
                                </div>
                                <div class="customer-container50"> <input type="text" value="{{ $model->KotaKirim }}"
                                        name="KotaKirim" placeholder="Kota Kirim" class="customer-textinput19 input" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <hr style="border-top: 1px solid #000000">
                    </div>
                    <div class="customer-container51">
                        <div class="customer-container52">
                            <div class="customer-container53"> <span class="customer-text48">No. NPWP</span> </div>
                            <div class="customer-container54"> <span class="customer-text49">Nama di NPWP</span> </div>
                            <div class="customer-container55"> <span>Alamat di NPWP</span> </div>
                        </div>
                        <div class="customer-container56">
                            <div class="customer-container57"> <input type="text" value="{{ $model->NPWP }}"
                                    name="NPWP" placeholder="Nomor NPWP" class="customer-textinput20 input" /> </div>
                            <div class="customer-container58"> <input type="text" value="{{ $model->NamaNPWP }}"
                                    name="NamaNPWP" placeholder="Nama sesuai di NPWP"
                                    class="customer-textinput21 input" /> </div>
                            <div class="customer-container59"> <input type="text" value="{{ $model->AlamatNPWP }}"
                                    name="AlamatNPWP" placeholder="Alamat sesuai di NPWP"
                                    class="customer-textinput22 input" /> </div>
                        </div>
                    </div>
                    <div class="customer-container60"> <button type="submit"
                            class="customer-button3 button">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
