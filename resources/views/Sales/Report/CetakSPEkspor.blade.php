@extends('layouts.appSales')
@section('content')
@section('title', 'Cetak SP Ekspor')
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/cetakSPEkspor.css') }}" rel="stylesheet">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10 RDZMobilePaddingLR0">
                <div class="acs-div-filter">
                    <label for="tanggal_sp">Tanggal:</label>
                    <div class="acs-div-filter3">
                        <input type="date" name="tanggal_sp" id="tanggal_sp" class="input">
                        <button id="lihat_sp" class="btn" style="display: inline-block">Lihat Surat Pesanan</button>
                    </div>
                </div>
                <div class="acs-div-filter1">
                    <label for="no_sp">Nomor SP:</label>
                    <div>
                        <select name="no_spSelect" id="no_spSelect" class="input">
                            <option disabled selected value>-- Pilih Nomor SP --</option>
                            @foreach ($nosp as $data)
                                <option value="{{ $data->NO_SP }}">{{ $data->NO_SP }} |
                                    {{ $data->NamaCust }}
                                </option>
                            @endforeach
                        </select>
                        <input type="text" name="no_spText" id="no_spText" class="input">
                    </div>
                </div>
                <div class="acs-div-filter2">
                    <label for="jenis_sp">Jenis SP:</label>
                    <input type="text" name="jenis_sp" id="jenis_sp" class="input" readonly>
                </div>
                <button id="print_button" class="btn btn-info" style="font-color: white"><span>&#128462;</span> View
                    Print</button>
                <button id="export_pdf" class="btn btn-primary"><span>&#11123;</span> Export PDF</button>
                <button id="print_pdf" class="btn btn-success"><span>&#128438;</span> Print Surat Pesanan</button>
                <hr>
                <label for="contoh_print" id="contoh_print">Contoh Print:</label>
                <div class="acs-div-container" id="contoh_printDiv" style="display: block">
                    {{-- nanti kalau sudah selesai bakal dibuat display none --}}

                    <body>
                        <div class="cetak-sppdf-container">
                            <div class="cetak-sppdf-container01">
                                <div class="cetak-sppdf-container02">
                                    <div class="cetak-sppdf-container03">
                                        <div class="cetak-sppdf-container04">
                                            <h2 style="margin-bottom: 0px;font-size:28px">
                                                <span>PT. KERTA RAJASA RAYA</span>
                                            </h2>
                                            <h3 style="margin-bottom: 0px">
                                                <span>JL. Raya Tropodo No. 1</span>
                                                <br>
                                                <span>Waru - Sidoarjo</span>
                                                <br>
                                            </h3>
                                            <hr style="border:1px solid black;margin-left: 3px;margin: 0px">
                                            <h3 style="margin-bottom: 0px">
                                                <span>SURAT PESANAN</span>
                                                <br />
                                            </h3>
                                            <h3>
                                                <span id="no_spKolom">No. </span>
                                                <br />
                                            </h3>
                                        </div>
                                        <br>
                                        <div class="cetak-sppdf-container05">
                                            <span>Telah pesan barang-barang di bawah ini:</span>
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td>PI NO</td>
                                                        <td>:</td>
                                                        <td id="no_piKolom"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>PO NO</td>
                                                        <td>:</td>
                                                        <td id="no_poKolom"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="cetak-sppdf-container06">
                                        <div class="cetak-sppdf-container07">
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td>Tanggal Pesanan</td>
                                                        <td>:&nbsp;</td>
                                                        <td id="tgl_pesanKolom"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Nama Langganan</td>
                                                        <td>:&nbsp;</td>
                                                        <td id="nama_customerKolom"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="white-space: nowrap;vertical-align:top;">Alamat Langganan
                                                        </td>
                                                        <td style="vertical-align:top;">:&nbsp;</td>
                                                        <td id="alamat_kantorKolom"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="vertical-align:top;">Destination</td>
                                                        <td style="vertical-align:top;">:&nbsp;</td>
                                                        <td id="destination_kolom"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="cetak-sppdf-container08">
                                    <table style="width=100%" id="table_sp">
                                        <thead>
                                            <tr>
                                                <th>No. </th>
                                                <th>GENERAL SPECIFICATION</th>
                                                <th>SIZE / CODE</th>
                                                <th>QUANTITY</th>
                                                <th>KODE BARANG</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="cetak-sppdf-container09">
                                    <table id="table_keterangan">
                                        <tr>
                                            <td>Remarks</td>
                                            <td>:&nbsp;</td>
                                            <td>
                                                <table>
                                                    <tr>
                                                        <td style="white-space: nowrap">1. Quantity</td>
                                                        <td>:&nbsp;</td>
                                                        <td id="remarks_quantityKolom"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>2. Packing</td>
                                                        <td>:&nbsp;</td>
                                                        <td id="remarks_packingKolom"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>3. Price</td>
                                                        <td>:&nbsp;</td>
                                                        <td id="remarks_priceKolom"></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="white-space: nowrap">Country of Origin</td>
                                            <td>:&nbsp;</td>
                                            <td>Indonesia</td>
                                        </tr>
                                        <tr>
                                            <td>Port of Loading</td>
                                            <td>:&nbsp;</td>
                                            <td>Tanjung Perak, Surabaya - Indonesia</td>
                                        </tr>
                                        <tr>
                                            <td>Destination Port</td>
                                            <td>:&nbsp;</td>
                                            <td id="destination_portKolom" contenteditable="true"></td>
                                        </tr>
                                        <tr>
                                            <td>Cargo Ready</td>
                                            <td>:&nbsp;</td>
                                            <td id="cargo_readyKolom"></td>
                                        </tr>
                                        <tr id="item_conditionKolom" style="display: none">
                                            <td>Condition</td>
                                            <td>:</td>
                                            <td>Quantity and Amount ± 10%</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="cetak-sppdf-container10">
                                    {{-- <span>If you accept with the above terms and conditions, please sign and fax by return.</span>
                                    <br>
                                    <span>Confirmed by:</span> --}}
                                    <div class="cetak-sppdf-container-tanda-tangan">
                                        <div class="cetak-sppdf-tanda-tangan">
                                            <span>Penerima Order</span>
                                            <br>
                                            <br>
                                            <br>
                                            <br>
                                            <br>
                                            <input type="text" class="signature" id="nama_penerimaOrderKolom">
                                        </div>
                                        <div class="cetak-sppdf-tanda-tangan2">
                                            <span style="white-space: nowrap">Sales Manager</span>
                                            <br>
                                            <br>
                                            <br>
                                            <br>
                                            <br>
                                            <span class="signature">Rudy Santoso</span>
                                        </div>
                                        <div class="cetak-sppdf-tanda-tangan1">
                                            <span>Pimpinan</span>
                                            <br>
                                            <br>
                                            <br>
                                            <br>
                                            <br>
                                            <span contenteditable="true" class="signature">Tjahyo Santoso</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </body>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('js/Sales/CetakSPEkspor.js') }}"></script>
@endsection
