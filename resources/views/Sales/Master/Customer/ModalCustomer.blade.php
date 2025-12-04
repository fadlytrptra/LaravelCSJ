<div class="modal fade" id="modalCustomer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog custom-modal-width">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabelCustomer">Tambah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-container col-md-12">
                    <form class="permohonan-do-form" method="POST" action="{{ url('Customer') }}" id="FormCustomer">
                        {{ csrf_field() }}
                        <input type="hidden" name="id_pesanan" id="id_pesanan_hidden" value="">
                        <input type="hidden" name="_method" id="methodkoreksi">
                        <input type="hidden" name="typeKegiatanForm" id="typeKegiatanForm">
                        <div id="div_deliveryOrder" class="permohonan-do-form">
                            <div class="acs-form">
                                <div class="acs-form1">
                                    <div class="acs-div-filter">
                                        <label for="JnsCust">Jenis Customer</label>
                                        <select name="JnsCust" id="JnsCust" class="input">
                                            <option selected disabled>-- Pilih Jenis Customer--</option>
                                            @foreach ($jnscust as $data)
                                                <option value="{{ $data->IDJnsCust }}"
                                                    {{ $model->JnsCust == $data->IDJnsCust ? 'selected' : '' }}>
                                                    {{ $data->IDJnsCust }} - {{ $data->NamaJnsCust }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="acs-div-filter">
                                        <label for="NamaCust">Nama Customer</label>
                                        <input type="text" name="NamaCust" id="NamaCust" class="input"
                                            value="{{ $model->NamaCust }}" placeholder="NamaCustomer">
                                    </div>
                                    <div class="acs-div-filter">
                                        <label for="KodeCust">Initial Customer</label>
                                        <input type="text" name="KodeCust" id="KodeCust" class="input"
                                            value="{{ $model->KodeCust }}" placeholder="Initial Customer">
                                    </div>
                                    <div class="acs-div-filter">
                                        <label for="ContactPerson">Contact Person</label>
                                        <input type="text" name="ContactPerson" id="ContactPerson"
                                            value="{{ $model->ContactPerson }}" placeholder="Contact Person"
                                            class="input">
                                    </div>
                                    <div class="acs-div-filter">
                                        <label for="LimitBeli">Limit Pembelian</label>
                                        <input type="text" name="LimitBeli"
                                            id="LimitBeli"value="{{ $model->LimitBeli }}" placeholder="Limit Pembelian"
                                            class="input">
                                    </div>
                                    <div class="acs-div-filter">
                                        <label for="Alamat">Alamat Kantor</label>
                                        <textarea name="Alamat" id="Alamat" cols="30" rows="3" placeholder="Alamat Kantor">{{ $model->Alamat }}</textarea>
                                        {{-- <input type="text" name="Alamat" id="Alamat"
                                                    value="{{ $model->Alamat }}" placeholder="Alamat Kantor"
                                                    class="input"> --}}
                                    </div>
                                    <div class="acs-div-filter">
                                        <label for="Kota">Kota</label>
                                        <input type="text" name="Kota" id="Kota" placeholder="Kota"
                                            value="{{ $model->Kota }}" class="input">
                                    </div>
                                    <div class="acs-div-filter">
                                        <label for="Province">Provinsi</label>
                                        <input type="text" name="Province" id="Province" placeholder="Provinsi"
                                            value="{{ $model->Propinsi }}" class="input">
                                    </div>
                                    <div class="acs-div-filter">
                                        <label for="Negara">Negara</label>
                                        <input type="text" name="Negara" id="Negara" placeholder="Negara"
                                            value="{{ $model->Negara }}" class="input">
                                    </div>
                                    <div class="acs-div-filter">
                                        <label for="KodePos">Kode Pos</label>
                                        <input type="text" name="KodePos" id="KodePos" placeholder="Kode Pos"
                                            value="{{ $model->KodePos }}" class="input">
                                    </div>
                                </div>
                                <div class="acs-form1">
                                    <div class="acs-div-filter">
                                        <label for="NoTelp1">No Telpon 1</label>
                                        <input type="text" name="NoTelp1" id="NoTelp1"
                                            value="{{ $model->NoTelp1 }}" placeholder="No Telpon 1" class="input">
                                    </div>
                                    <div class="acs-div-filter">
                                        <label for="NoTelp2">No Telpon 2</label>
                                        <input type="text" name="NoTelp2" id="NoTelp2"
                                            value="{{ $model->NoTelp2 }}" placeholder="No Telpon 2" class="input">
                                    </div>
                                    <div class="acs-div-filter">
                                        <label for="NoTelex">No Telex</label>
                                        <input type="text" name="NoTelex" id="NoTelex"
                                            value="{{ $model->NoTelex }}" placeholder="No Telex" class="input">
                                    </div>
                                    <div class="acs-div-filter">
                                        <label for="NoFax1">No Fax 1</label>
                                        <input type="text" name="NoFax1" id="NoFax1"
                                            value="{{ $model->NoFax1 }}" placeholder="No Fax 1" class="input">
                                    </div>
                                    <div class="acs-div-filter">
                                        <label for="NoFax2">No Fax 2</label>
                                        <input type="text" name="NoFax2"
                                            id="NoFax2"value="{{ $model->NoFax2 }}" placeholder="No Fax 2"
                                            class="input">
                                    </div>
                                    <div class="acs-div-filter">
                                        <label for="NoHp1">No. HP 1</label>
                                        <input type="text" name="NoHp1"
                                            id="NoHp1"value="{{ $model->NoHp1 }}" placeholder="No. HP 1"
                                            class="input">
                                    </div>
                                    <div class="acs-div-filter">
                                        <label for="NoHp2">No. HP 2</label>
                                        <input type="text" name="NoHp2"
                                            id="NoHp2"value="{{ $model->NoHp2 }}" placeholder="No. HP 2"
                                            class="input">
                                    </div>
                                    <div class="acs-div-filter">
                                        <label for="Email">Email</label>
                                        <input type="text" name="Email" id="Email"
                                            placeholder="Email"value="{{ $model->Email }}" class="input">
                                    </div>
                                    <div class="acs-div-filter">
                                        <label for="AlamatKirim">Alamat Kirim</label>
                                        <textarea placeholder="Alamat Kirim" name="AlamatKirim" id="AlamatKirim" cols="30" rows="3">{{ $model->AlamatKirim }}</textarea>
                                    </div>
                                    <div class="acs-div-filter">
                                        <label for="KotaKirim">Kota Kirim</label>
                                        <input type="text" name="KotaKirim" id="KotaKirim"
                                            value="{{ $model->KotaKirim }}" placeholder="Kota Kirim" class="input">
                                    </div>
                                </div>
                                <div class="acs-form1">
                                    <div class="acs-div-filter">
                                        <label for="NPWP">No. NPWP</label>
                                        <input type="text" name="NPWP" id="NPWP"
                                            value="{{ $model->NPWP }}" placeholder="No. NPWP" class="input">
                                    </div>
                                    <div class="acs-div-filter">
                                        <label for="NamaNPWP">Nama di NPWP</label>
                                        <input type="text" name="NamaNPWP" id="NamaNPWP"
                                            value="{{ $model->NamaNPWP }}" placeholder="Nama di NPWP"
                                            class="input">
                                    </div>
                                    <div class="acs-div-filter">
                                        <label for="AlamatNPWP">Alamat di NPWP</label>
                                        <textarea name="AlamatNPWP" id="AlamatNPWP" cols="30" rows="10">{{ $model->AlamatNPWP }}</textarea>
                                    </div>
                                    <div class="acs-div-filter">
                                        <label for="NITKU">NITKU</label>
                                        <input type="text" name="NITKU" id="NITKU"
                                            value="{{ $model->NITKU }}" placeholder="NITKU" class="input">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="acs-div-btn">
                            <button id="submit_btn" class="btn btn-primary">
                                <span>Submit</span></button>
                        </div>
                    </form>
                    <div id="qr-code-uji-coba">
                        <input id="text-content" type="text" value="https://kertarajasa.co.id/"
                            style="width:80%" /><br />
                        <div id="qrcode" style="width:200px; height:200px; margin-top:15px;">
                        </div>
                        <span id="text-qr"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript" src="{{ asset('js/Sales/Customer.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/qrcode.js') }}"></script>
<style>
    #qr-code-uji-coba {
        display: none;
    }

    @media print {
        .permohonan-do-form {
            display: none !important;
        }

        #text-content {
            display: none;
        }

        #qrcode {
            display: block !important;
        }

        #text-qr {
            display: block;
            font-size: 18px;
        }
    }
</style>
<script type="text/javascript">
    var qrcode = new QRCode(document.getElementById("qrcode"), {
        width: 200,
        height: 200,
        colorDark: "#000000",
        colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.H
    });

    function makeCode() {
        var elText = document.getElementById("text-content");
        var textqr = document.getElementById("text-qr");
        if (!elText.value) {
            alert("Input a text");
            elText.focus();
            return;
        }
        textqr.innerHTML = elText.value;
        qrcode.makeCode(elText.value);
    }

    makeCode();

    $("#text-content").
    on("blur", function() {
        makeCode();
    }).
    on("keydown", function(e) {
        if (e.keyCode == 13) {
            makeCode();
        }
    });
</script>
