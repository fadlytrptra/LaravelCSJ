@extends('layouts.appSales') @section('content')
@section('title', 'Pasca Kirim')
    <script>
        $(document).ready(function() {
            $('#table_SJ').DataTable({
                order: [
                    [0, 'desc']
                ],
            });
        });
    </script>
    <link href="{{ asset('css/pasca-kirim.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10 RDZMobilePaddingLR0"> {{-- button untuk munculin create DO --}} <div class="pasca-kirim-container">
                    <form class="pasca-kirim-form" id="form_pascaKirim" action="{{ url('PascaKirim') }}" method="POST">
                        {{ csrf_field() }}
                        @if (Session::has('error'))
                            <div class="alert alert-danger">
                                {{ Session::get('error') }}
                            </div>
                        @endif
                        @if (Session::has('success'))
                            <div class="alert alert-success">
                                {{ Session::get('success') }}
                            </div>
                        @endif
                        {{-- @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif --}}
                        <div class="pasca-kirim-container01">
                            <span>Jenis Pasca</span>
                            <div class="pasca-kirim-container02">
                                <input type="radio" name="jenis_pasca" id="jenis_pascaPengembalian" value="Pengembalian" checked />
                                <span>Pengembalian Barang</span>
                            </div>
                            <div class="pasca-kirim-container03">
                                <input type="radio" name="jenis_pasca" id="jenis_pascaKurangLebih" value="Kurang/Lebih" />
                                <span>Kelebihan / Kekurangan Barang</span>
                            </div>
                        </div>
                        <div class="pasca-kirim-container04">
                            <span>Customer</span>
                            <select id="customer" name="customer" class="pasca-kirim-select input">
                                <option disabled selected>--Pilih Customer--</option>
                                @foreach ($customer as $data)
                                    @php
                                        $IDCust = explode('-', $data->IDCust);
                                        // $IDCust = trim(substr($data->IdCust, strpos($data->IdCust, '-')));
                                    @endphp
                                    <option value="{{ $IDCust[1] }}">{{ $data->NamaCust }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="pasca-kirim-container05">
                            <span>Surat Pesanan</span>
                            <select id="surat_pesanan" name="surat_pesanan" class="pasca-kirim-select1 input">
                                <option disabled selected>--Pilih Surat Pesanan--</option>
                            </select>
                            <span>Surat Jalan</span>
                            <input type="text" id="surat_jalan" name="surat_jalan" placeholder="Surat Jalan"
                                class="pasca-kirim-textinput input" readonly />
                        </div>
                        <div class="pasca-kirim-container06">
                            <span>Item</span>
                            <select id="barang_pesanan" name="barang_pesanan" class="pasca-kirim-select2 input">
                                <option disabled selected>--Pilih Barang--</option>
                            </select>
                        </div>
                        <div class="pasca-kirim-container07">
                            <div class="pasca-kirim-container08">
                                <div class="pasca-kirim-container09">
                                    <div class="pasca-kirim-container10">
                                        <span>Qty Primer</span>
                                        <input type="text" id="qty_primerPengiriman" name="qty_primerPengiriman"
                                            placeholder="Qty Primer" class="pasca-kirim-textinput01 input" disabled />
                                    </div>
                                    <div class="pasca-kirim-container11">
                                        <span>Qty Sekunder</span>
                                        <input type="text" id="qty_sekunderPengiriman" name="qty_sekunderPengiriman"
                                            placeholder="Qty Sekunder" class="pasca-kirim-textinput02 input" disabled />
                                    </div>
                                    <div class="pasca-kirim-container12">
                                        <span>Qty Tritier</span>
                                        <input type="text" id="qty_tritierPengiriman" name="qty_tritierPengiriman"
                                            placeholder="Qty Tritier" class="pasca-kirim-textinput03 input" disabled />
                                    </div>
                                    <div class="pasca-kirim-container13">
                                        <span>Qty Konversi</span>
                                        <input type="text" id="qty_konversiPengiriman" name="qty_konversiPengiriman"
                                            placeholder="Qty Konversi" class="pasca-kirim-textinput04 input" disabled />
                                    </div>
                                </div>
                                <div class="pasca-kirim-container14">
                                    <div class="pasca-kirim-container15">
                                        <span>Qty Primer</span>
                                        <input type="text" id="qty_primerRetur" name="qty_primerRetur"
                                            placeholder="Qty Primer" class="pasca-kirim-textinput05 input" disabled />
                                    </div>
                                    <div class="pasca-kirim-container16">
                                        <span>Qty Sekunder</span>
                                        <input type="text" id="qty_sekunderRetur" name="qty_sekunderRetur"
                                            placeholder="Qty Sekunder" class="pasca-kirim-textinput06 input" disabled />
                                    </div>
                                    <div class="pasca-kirim-container17">
                                        <span>Qty Tritier</span>
                                        <input type="text" id="qty_tritierRetur" name="qty_tritierRetur"
                                            placeholder="Qty Tritier" class="pasca-kirim-textinput07 input" disabled />
                                    </div>
                                    <div class="pasca-kirim-container18">
                                        <span>Qty Konversi</span>
                                        <input type="text" id="qty_konversiRetur" name="qty_konversiRetur"
                                            placeholder="Qty Konversi" class="pasca-kirim-textinput08 input" disabled />
                                    </div>
                                </div>
                            </div>
                            <div class="pasca-kirim-container19">
                                <div class="pasca-kirim-container20">
                                    <span>Tanggal Diterima</span>
                                    <input type="date" id="tanggal_diterima" name="tanggal_diterima"
                                        class="pasca-kirim-textinput09 input" />
                                </div>
                                <div class="pasca-kirim-container21">
                                    <span>BTTB</span>
                                    <input type="text" id="bttb" name="bttb" placeholder="BTTB"
                                        class="pasca-kirim-textinput10 input" />
                                </div>
                                <div class="pasca-kirim-container22">
                                    <span>Qty Primer</span>
                                    <input type="text" id="qty_primerDiterimaCustomer"
                                        name="qty_primerDiterimaCustomer" placeholder="Qty Primer"
                                        class="pasca-kirim-textinput11 input" value="0" />
                                </div>
                                <div class="pasca-kirim-container23">
                                    <span>Qty Sekunder</span>
                                    <input type="text" id="qty_sekunderDiterimaCustomer"
                                        name="qty_sekunderDiterimaCustomer" placeholder="Qty Sekunder"
                                        class="pasca-kirim-textinput12 input" value="0" />
                                </div>
                                <div class="pasca-kirim-container24">
                                    <span>Qty Tritier</span>
                                    <input type="text" id="qty_tritierDiterimaCustomer"
                                        name="qty_tritierDiterimaCustomer" placeholder="Qty Tritier"
                                        class="pasca-kirim-textinput13 input" value="0" />
                                </div>
                                <div class="pasca-kirim-container25">
                                    <span>Qty Konversi</span>
                                    <input type="text" id="qty_konversiDiterimaCustomer" name="qty_konversi"
                                        placeholder="Qty Konversi" class="pasca-kirim-textinput14 input" disabled
                                        value="0" />
                                </div>
                                <div class="pasca-kirim-container26">
                                    <span>Penerima</span>
                                    <input type="text" id="penerima" name="penerima" placeholder="Penerima"
                                        class="pasca-kirim-textinput15 input" />
                                </div>
                                <div class="pasca-kirim-container27">
                                    <span>Alasan Kembali</span>
                                    <input type="text" id="alasan_kembali" name="alasan_kembali"
                                        placeholder="Alasan Kembali" class="pasca-kirim-textinput16 input" />
                                </div>
                            </div>
                        </div>
                        <button id="submit_button" class="acs-button-submit">
                            <span>Submit</span></button>
                    </form>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="{{ asset('js/Sales/pasca-kirim.js') }}"></script>
    @endsection
