@extends('layouts.appSales')
@section('content')
@section('title', 'Cetak PI')
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
<link href="{{ asset('css/cetakPI.css') }}" rel="stylesheet">
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
                <input type="text" name="jenis_sp" id="jenis_sp" class="input">
            </div>
            <button id="print_button" class="btn btn-info" style="font-color: white"><span>&#128462;</span> View
                Print</button>
            <button id="export_pdf" class="btn btn-primary"><span>&#11123;</span> Export PDF</button>
            <button id="print_pdf" class="btn btn-success"><span>&#128438;</span> Print Surat Pesanan</button>
            <hr>
            <label for="contoh_print" id="contoh_print">Contoh Print:</label>
            <div class="acs-div-container" id="contoh_printDiv">

                <body>
                    <div class="cetak-sppdf-container">
                        <div class="cetak-sppdf-container01">
                            <div class="cetak-sppdf-container02">
                                <img src="{{ asset('images/Header Cetak PI.jpg') }}" alt="" style="width: 100%">
                                <div class="header"></div>
                                {{-- <div class="cetak-sppdf-container03">
                                        <img src="{{ asset('/images/KRR.png') }}" alt="Logo KRR" style="position: absolute">
                                        <div style="width: 100%; text-align: center">
                                            <h1 style="font-weight: 900">PT. KERTA RAJASA RAYA</h1>
                                            <h3 style="font-weight: 700">Woven Bag - Jumbo Bag. Industrial</h3>
                                        </div>
                                    </div>
                                    <div class="cetak-sppdf-container04">
                                        <div class="cetak-sppdf-container05">
                                            <span style="font-weight: 600">MFG & OFFICE</span>
                                            <br>
                                            <p style="font-size: small;margin-bottom:0;">Jl. Raya Tropodo No.1 Waru -
                                                Sidoarjo 61256
                                                <br>
                                                East Java, Indonesia
                                                <br>
                                                Phone: 62-31 8669595, 8669966 (12 Lines)
                                            </p>
                                        </div>
                                        <div class="cetak-sppdf-container06">
                                            <p style="font-size: small;margin-bottom:0;">Fax: 62-31 8669989, 8668952
                                                <br>
                                                https://www.kertarajasa.co.id
                                                <br>
                                                Email: kerta88@kertarajasa.co.id
                                            </p>
                                        </div>
                                    </div>
                                    <hr style="border: double 3px black; width: 100%;margin-top:0">
                                    <div class="cetak-sppdf-container07">
                                        <div class="cetak-header-pi">
                                            <h6 style="font-weight: 700;text-decoration: underline; margin-bottom: 0;">PROFORMA INVOICE</h6>
                                            <span id="no_piKolom" style="font-size: small"></span>
                                            <div style="text-align: left">
                                                <span id="no_poKolom" style="font-size: 12px">Buyer Reference contract
                                                    number:</span>
                                            </div>
                                            <hr style="border: 1px solid black; width:100%;margin-top: 0;margin-bottom: 0">
                                        </div>
                                    </div> --}}
                            </div>
                            <div id="headerMargin"></div>
                            <div class="cetak-sppdf-container08">
                                <div style="width:100%">
                                    <div style="width: 100%; text-align: center;line-height: 1">
                                        <span
                                            style="text-align: center;text-decoration: underline;font-size: 18px;font-weight: 600">PROFORMA
                                            INVOICE</span>
                                        <br>
                                        <span style="font-weight: 600" id="no_piKolom">111/coba/111</span>
                                    </div>
                                    <span id="no_poKolom">Buyer Reference contract number: </span>
                                    <hr style="border: 1px solid black; width:100%;margin-top: 0;margin-bottom: 0">
                                </div>
                                <div class="cetak-sppdf-container11">
                                    <div class="cetak-sppdf-subcontainer1">
                                        <table>
                                            <tr>
                                                <td>Buyer</td>
                                                <td>:</td>
                                                <td id="nama_perusahaanKolom" contenteditable="true">xxxxx</td>
                                            </tr>
                                            <tr>
                                                <td>Attn</td>
                                                <td>:</td>
                                                <td id="nama_customerKolom" contenteditable="true">xxxxxx</td>
                                            </tr>
                                            <tr>
                                                <td>Phone</td>
                                                <td>:</td>
                                                <td contenteditable="true" id="fax_customerKolom">xxxxxx</td>
                                            </tr>
                                        </table>
                                        <div class="cetak-sppdf-container12">
                                            <span id="tgl_pesanKolom">Sidoarjo, July 15, 2023</span>
                                        </div>
                                    </div>
                                    <hr style="border: 1px solid black; width:100%;margin-top: 0;margin-bottom: 0">
                                    <span id="pernyataan_pesananKolom" contenteditable="true">We hereby confirmed your
                                        order of xxxxxx with specifications, terms, and
                                        conditions as mentioned
                                        below :</span>
                                </div>
                                <table id="table_sp" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>No. </th>
                                            <th>GENERAL SPECIFICATION</th>
                                            <th>SIZE / CODE</th>
                                            <th>QUANTITY</th>
                                            <th id="price_forKolom">PRICE FOB <br>(USD)</th>
                                            <th id="price_amountKolom">AMOUNT <br>(USD)</th>
                                            {{-- <th>ADDITIONAL INFORMATION</th> --}}
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
                                                    <td>1. Quantity</td>
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
                                        <td>Payment by</td>
                                        <td>:</td>
                                        <td>
                                            <span id="payment_byKolom"></span>
                                            <table>
                                                <tr>
                                                    <td>A/C no</td>
                                                    <td>:&nbsp;</td>
                                                    <td>788-076-0399</td>
                                                </tr>
                                                <tr>
                                                    <td>Beneficiary</td>
                                                    <td>:&nbsp;</td>
                                                    <td>PT. KERTA RAJASA RAYA</td>
                                                </tr>
                                                <tr>
                                                    <td>SWIFT CODE</td>
                                                    <td>:&nbsp;</td>
                                                    <td>CENAIDJA</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Country of Origin</td>
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
                                    <tr id="noteKolom" style="display: none">
                                        <td>Note</td>
                                        <td>:</td>
                                        <td contenteditable="true">ETA is tentative. Shipping schedule might change during time depend on shipping company schedule.</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="cetak-sppdf-container10">
                                <span>If you accept with the above terms and conditions, please sign and fax by
                                    return.</span>
                                <br>
                                <span>Confirmed by:</span>
                                <div class="cetak-sppdf-container-tanda-tangan">
                                    <span style="align-self: flex-start; width: 100%;text-align: end"
                                        id="tgl_ttKolom">Sidoarjo, July 15, 2023</span>
                                    <div class="cetak-sppdf-tanda-tangan">
                                        <input type="text" class="signature1" id="ttd_namaContactPersonKolom">
                                        <br>
                                        <span id="ttd_perusahaanKolom" contenteditable="true">PT. KERTA RAJASA RAYA</span>
                                    </div>
                                    <div class="cetak-sppdf-tanda-tangan1">
                                        {{-- <span id="nama_salesKolom" class="kolom-nama-tt">Mr. Rudy Santoso</span> --}}
                                        <input type="text" class="signature" id="nama_salesKolom" readonly>
                                        <br>
                                        <span>PT. KERTA RAJASA RAYA</span>
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
<script type="text/javascript" src="{{ asset('js/Sales/CetakPI.js') }}"></script>
@endsection
