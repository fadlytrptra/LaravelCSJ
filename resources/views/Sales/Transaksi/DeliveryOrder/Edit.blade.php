@extends('layouts.app') @section('content')
@section('title', 'Edit DO')
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/permohonan-do.css') }}" rel="stylesheet">
    @php
        $data_encode = json_encode($data);
        $data_array = json_decode($data_encode, true);
    @endphp
    <div class="col-md-10 RDZMobilePaddingLR0">
        <div class="permohonan-do-container">
            <form class="permohonan-do-form" id="form_deliveryOrder" method="POST"
                action="{{ route('deliveryorder.update',$data_array[0]['IDDO']) }}">
                {{ csrf_field() }}
                {!! Form::hidden('id_pesanan', null, ['id' => 'id_pesanan_hidden']) !!}
                {!! Form::hidden('nomor_sp', $data_array[0]['IDSuratPesanan'], ['id' => 'nomor_sp_edit']) !!}
                {!! Form::hidden('id_pesanan', $data_array[0]['IDPesanan'], ['id' => 'id_pesanan_edit']) !!}
                {!! Form::hidden('kelompok_utama', $data_array[0]['IdKelompokUtama'], ['id' => 'kelompok_utama_edit']) !!}
                {!! Form::hidden('kelompok', $data_array[0]['IdKelompok'], ['id' => 'kelompok_edit']) !!}
                {!! Form::hidden('sub_kelompok', $data_array[0]['IdSubkelompok'], ['id' => 'sub_kelompok_edit']) !!}
                <div class="permohonan-do-container01">
                    <span class="permohonan-do-text">Tgl DO</span>
                    <input type="date" id="tgl_do" name="tgl_do" placeholder="placeholder"
                        class="permohonan-do-textinput input" />
                </div>
                <div class="permohonan-do-container02">
                    <span class="permohonan-do-text02">Customer</span>
                    <select id="customer" name="customer" class="permohonan-do-select1 input" disabled>
                        <option disabled selected>-- Pilih Customer --</option>
                        @foreach ($customer as $data)
                            @php
                                $IDCust = trim(substr($data->IDCust, strpos($data->IDCust, '-') + 1));
                            @endphp
                            <option value="{{ $IDCust }}" {{ $data_array[0]['IDCust'] == $IDCust ? 'selected' : '' }}>
                                {{ $data->NamaCust }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="permohonan-do-container03">
                    <span class="permohonan-do-text03">No SP</span>
                    <select id="nomor_sp" name="nomor_sp" class="permohonan-do-select2 input">
                        <option disabled selected>--Pilih Nomor Surat Pesanan--</option>
                    </select>
                </div>
                <div class="permohonan-do-container04">
                    <span class="permohonan-do-text04">ID Pesanan</span>
                    <select id="id_pesanan" name="id_pesanan" class="permohonan-do-select3 input">
                        <option disabled selected>--Pilih ID Pesanan--</option>
                    </select>
                </div>
                <div class="permohonan-do-container05">
                    <span class="permohonan-do-text05">Kode Barang</span>
                    <input type="text" id="kode_barang" name="kode_barang" placeholder="Kode Barang"
                        value="{{ $data_array[0]['IDBarang'] }}" class="permohonan-do-input input" />
                    <span class="permohonan-do-text06" id="text_idTypeBarang" style="display: none">ID Type Barang</span>
                    <input type="text" id="id_typeBarang" name="id_typeBarang" placeholder="ID Type Barang"
                        value="{{ $data_array[0]['IdType'] }}" class="permohonan-do-textinput01 input" />
                </div>
                <div class="permohonan-do-container06">
                    <span class="permohonan-do-text07">Uraian</span>
                    <input type="text" id="uraian" name="uraian" placeholder="Uraian"
                        value="{{ $data_array[0]['NamaType'] }}" class="permohonan-do-textarea textarea"></textarea>
                </div>
                <div class="permohonan-do-container07">
                    <span class="permohonan-do-text08">Kel. Utama</span>
                    <select id="kelompok_utama" name="kelompok_utama" class="permohonan-do-select4 input">
                        <option disabled selected>--Pilih Kelompok Utama--</option>
                    </select>
                </div>
                <div class="permohonan-do-container08">
                    <span class="permohonan-do-text09">Kelompok</span>
                    <select id="kelompok" name="kelompok" class="permohonan-do-select5 input">
                        <option disabled selected>--Pilih Kelompok--</option>
                    </select>
                </div>
                <div class="permohonan-do-container09">
                    <span class="permohonan-do-text10">Sub. Kel.</span>
                    <select id="sub_kelompok" name="sub_kelompok" class="permohonan-do-select6 input">
                        <option disabled selected>--Pilih Sub Kelompok--</option>
                    </select>
                </div>
                <div class="permohonan-do-container10">
                    <div class="permohonan-do-container11">
                        <div class="permohonan-do-container12">
                            <span class="permohonan-do-text11">Qty Primer</span>
                            <input type="text" id="qty_primer" name="qty_primer" placeholder="Qty Primer"
                                class="permohonan-do-textinput02 input" value="{{ $data_array[0]['QtyPrimer'] }}" />
                            {{-- <span class="permohonan-do-text12">Qty Order</span>
                            <input type="text" id="qty_order" name="qty_order" placeholder="Qty Order"
                                class="permohonan-do-textinput03 input" /> --}}
                        </div>
                        <div class="permohonan-do-container13">
                            <span class="permohonan-do-text13">Qty Sekunder</span>
                            <input type="text" id="qty_sekunder" name="qty_sekunder" placeholder="Qty Sekunder"
                                class="permohonan-do-textinput04 input" value="{{ $data_array[0]['QtySekunder'] }}" />
                            <span class="permohonan-do-text14">Qty Order</span>
                            <input type="text" id="qty_order" name="qty_order" placeholder="Qty Order"
                                class="permohonan-do-textinput05 input" value="{{ $data_array[0]['Qty'] }}" />
                        </div>
                        <div class="permohonan-do-container13">
                            <span class="permohonan-do-text13">Qty Tritier</span>
                            <input type="text" id="qty_tritier" name="qty_tritier" placeholder="Qty Tritier"
                                class="input" style="margin-left: 40px" value="{{ $data_array[0]['QtyTritier'] }}" />
                            <span class="permohonan-do-text14">Qty Kirim</span>
                            <input type="text" id="qty_kirim" name="qty_kirim" placeholder="Qty Kirim"
                                class="input" value="{{ $data_array[0]['TerKirim'] }}" />
                        </div>
                        <div class="permohonan-do-container14">
                            <span class="permohonan-do-text15">Max Kirim</span>
                            <input type="text" id="max_kirim" name="max_kirim" placeholder="Max Kirim"
                                class="permohonan-do-textinput06 input" value="{{ $data_array[0]['MaxKirimDO'] }}" />
                        </div>
                        <div class="permohonan-do-container15">
                            <span class="permohonan-do-text16">Min Kirim</span>
                            <input type="text" id="min_kirim" name="min_kirim" placeholder="Min Kirim"
                                class="permohonan-do-textinput07 input" value="{{ $data_array[0]['MinKirimDO'] }}" />
                        </div>
                    </div>
                    <div class="permohonan-do-container16">
                        <div class="permohonan-do-container17">
                            <span class="permohonan-do-text17">Qty Primer</span>
                            <input type="text" id="qty_primerGudang" name="qty_primerGudang"
                                placeholder="Qty Primer Gudang" class="permohonan-do-textinput08 input"
                                value="{{ $data_array[0]['SaldoPrimer'] }}" readonly />
                            <input type="text" placeholder="Satuan Primer" id="satuan_primer"
                                class="permohonan-do-textinput09 input" value="{{ $data_array[0]['SatPrimer'] }}" />
                        </div>
                        <div class="permohonan-do-container18">
                            <span class="permohonan-do-text18">Qty Sekunder</span>
                            <input type="text" placeholder="Qty Sekunder Gudang" id="qty_sekunderGudang"
                                class="permohonan-do-textinput10 input" value="{{ $data_array[0]['SaldoSekunder'] }}"
                                readonly />
                            <input type="text" placeholder="Satuan Sekunder" id="satuan_sekunder"
                                class="permohonan-do-textinput11 input" value="{{ $data_array[0]['SatSekunder'] }}" />
                        </div>
                        <div class="permohonan-do-container19">
                            <span class="permohonan-do-text19">Qty Tritier</span>
                            <input type="text" id="qty_tritierGudang" name="qty_tritierGudang"
                                placeholder="Qty Tritier Gudang" class="permohonan-do-textinput12 input"
                                value="{{ $data_array[0]['SaldoTritier'] }}" readonly />
                            <input type="text" placeholder="Satuan Tritier" id="satuan_tritier"
                                class="permohonan-do-textinput13 input" value="{{ $data_array[0]['SatTritier'] }}" />
                        </div>
                        <div class="permohonan-do-container20">
                            <span class="permohonan-do-text20">Divisi</span>
                            <input type="text" id="divisi" name="divisi" placeholder="Divisi"
                                class="permohonan-do-textinput14 input" readonly />
                        </div>
                    </div>
                </div>
                <div class="permohonan-do-container21">
                    <span class="permohonan-do-text21">
                        <span>Alamat Kirim</span>
                        <br />
                        <br />
                    </span>
                    <textarea id="alamat_kirim" name="alamat_kirim" placeholder="Alamat Kirim" class="permohonan-do-textarea1 textarea">{{ $data_array[0]['AlamatKirim'] }}</textarea>
                </div>
                <div class="permohonan-do-container22">
                    <span class="permohonan-do-text25">
                        <span>Kota Kirim</span>
                        <br />
                        <br />
                    </span>
                    <input type="text" id="kota_kirim" name="kota_kirim" placeholder="Kota Kirim"
                        class="permohonan-do-input1 input" value="{{ $data_array[0]['KotaKirim'] }}" />
                </div>
                <div class="permohonan-do-container23" style="display: none">
                    <div class="permohonan-do-container24">
                        <span class="permohonan-do-text29">
                            <span>Vessel</span>
                            <br />
                        </span>
                        <input type="text" id="vessel" name="vessel" placeholder="Vessel"
                            class="permohonan-do-input2 input" />
                    </div>
                    <div class="permohonan-do-container25">
                        <span class="permohonan-do-text32">
                            <span>ETD</span>
                            <br />
                        </span>
                        <input type="date" id="etd" name="etd" placeholder="placeholder"
                            class="permohonan-do-textinput15 input" />
                    </div>
                    <div class="permohonan-do-container26">
                        <span class="permohonan-do-text35">
                            <span>CC</span>
                            <br />
                        </span>
                        <input type="date" id="cc" name="cc" placeholder="placeholder"
                            class="permohonan-do-textinput16 input" />
                    </div>
                </div>
                <button class="permohonan-do-button button">Submit</button>
            </form>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('js/Sales/permohonan-do edit.js') }}"></script>
@endsection
