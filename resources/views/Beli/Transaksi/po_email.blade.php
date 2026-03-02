<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <style>
        @page {
            size: 21cm 30cm;
            margin-top: 1.5cm;
            margin-left: 1.5cm;
            margin-right: 1.5cm;
            margin-bottom: 0cm;
        }

        body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            padding: 2px;
            font-size: 11px;
            font-weight: bold;
            text-align: center;
        }

        td {
            padding: 4px;
            vertical-align: top;
        }

        .box {
            border: 1.5px solid #000;
            padding: 0 12px 12px 12px;
            min-height: 19cm;
        }

        .right {
            text-align: right;
        }

        .center {
            text-align: center;
        }

        .left {
            text-align: left;
        }


        table.po_table thead th {
            border-bottom: 1px solid #000;
            vertical-align: bottom;
            line-height: 1.15;
        }

        table.po_table td {
            vertical-align: top;
            line-height: 1.35;
        }

        table.po_table tbody tr:last-child td {
            border-bottom: 1px solid #000;
        }

        .th_sub {
            display: block;
            font-size: 10px;
            font-weight: normal;
            margin-top: 2px;
        }
/*
        .footer {
            position: fixed;
            bottom: 1.5cm;
            left: 0cm;
            right: 1.5cm;
        } */

        .signature_box {
            height: 30px;
            text-align: center;
            padding-bottom: 0.80cm;
        }

        .signature_img {
            max-height: 80px;
            margin-top: -14px;
        }
        /* .signature_imgCanvas {
            max-height: 120px;
        } */
    </style>
</head>



<body>
    {{-- HEADER TEMPLATE --}}
    <table>
        <tr>

            <td width="50%" valign="top">
                <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                    <tr>
                        <td valign="top" style="padding:0 0 0 0;">
                            <img src="{{ public_path('images/csj.png') }}" width="65">
                        </td>

                        <td valign="top" style="padding-left:10px; text-align:center; white-space:nowrap;">
                            <div
                                style="color:#0713c5; font-size:18px; font-weight:bold; margin-top: -5px; line-height:1.1;">
                                PT. CAHAYA SANTOSO JAYA
                            </div>
                            <div style="font-size:11px; line-height:1.2; letter-spacing:4px;">
                                <span style="margin-right:1px;">YOUR</span>
                                <span style="margin-right:1px;">BUSINESS</span>
                                <span>PARTNER</span>
                            </div>
                        </td>
                        <td style="width:100%"></td>
                    </tr>

                    <!-- Detail perusahaan di row baru -->
                    <tr>
                        <td colspan="3"
                            style="font-size:12px; line-height:1.25; padding-top:5px; padding-left: 9px;">
                            Raya Tropodo No. 1, Waru, Sidoarjo 61256<br>
                            East Java, Indonesia<br>
                            ph. +62-31 866 9595<br>
                            fax. +62-31 866 6425<br>
                            <img src="{{ public_path('images/envelope.png') }}" width="13"
                                style="vertical-align:middle; margin-right: 3px">cahayasjaya@gmail.com
                        </td>
                    </tr>
                </table>
            </td>


            <td width="50%" valign="top">
                <table width="100%" cellpadding="0" cellspacing="0"
                    style="border-collapse:collapse; padding-right:10px;">
                    <tr>
                        <td valign="top" style="padding-left:10px; text-align:center; white-space:nowrap;">
                            <div
                                style="color:#000000; font-size:18px; font-weight:bold; margin-top: -5px; line-height:1.1;">
                                PURCHASE ORDER (P.O.)
                            </div>
                        </td>
                    </tr>
                </table>
            </td>

        </tr>
    </table>

    <br>

    @php
        if (!empty($dataCetak)) {
            $tanggalSPPB = date('d M Y', strtotime($dataCetak[0]->Tgl_sppb));
            $EstDate = date('d M Y', strtotime($dataCetak[0]->Tgl_Dibutuhkan ?? $dataCetak[0]->Tgl_Dibutuhkan));
            $payment = $dataCetak[0]->Waktu ?? null;
        } else {
            $tanggalSPPB = '-';
            $EstDate = '-';
            $payment = null;
        }
        $sumAmount = 0;
        $totalDisc = $dataCetak->sum('Disc_trm');
        $chunkSize = 5;
        $chunks = $dataCetak->chunk($chunkSize);
        $ppn = collect($dataCetak)->sum('PPN');
        $amountDPP = collect($dataCetak)->sum('dpp_nilai_lain');

        if (!empty($dataCetak)) {
            $infoCetak = $dataCetak[0]->Informasi_Cetak ?? null;

            if ($infoCetak) {
                $arr = explode(' | ', $infoCetak);
                $deliveryTerm = $arr[0] ?? '';
                $packing = $arr[1] ?? '';
                $shippingMark = $arr[2] ?? '';
                $deliveryTime = $arr[3] ?? '';
                $documentsRequired = $arr[4] ?? '';
                $partialShipmentTransit = $arr[5] ?? '';
                $portOfLoading = $arr[6] ?? '';
                $portOfDischarge = $arr[7] ?? '';
                $otherConditions = $arr[8] ?? '';
                $payment = $arr[9] ?? '';
            } else {
                $deliveryTerm = $packing = $shippingMark = $deliveryTime = '';
                $documentsRequired = $partialShipmentTransit = $portOfLoading = '';
                $portOfDischarge = $otherConditions = $payment = '';
            }
        } else {
            $deliveryTerm = $packing = $shippingMark = $deliveryTime = '';
            $documentsRequired = $partialShipmentTransit = $portOfLoading = '';
            $portOfDischarge = $otherConditions = $payment = '';
        }
    @endphp


    {{--  ISI CONTENT  --}}
    <div class="box">
        <table width="100%">
            <tr>
                <!-- ================= LEFT COLUMN ================= -->
                <td width="55%" valign="top">

                    <b style="font-size:12px; margin-top: 5px;">Issued To:</b><br>

                    <div style="font-size:10px; line-height:1.4;">
                        {{ $dataCetak[0]->NM_SUP }}<br>
                        {{ $dataCetak[0]->ALAMAT1 }}<br>
                        {{ $dataCetak[0]->KOTA1 }}<br>
                        {{ $dataCetak[0]->NEGARA1 }}
                    </div>

                    <br>

                    <b style="font-size:12px;">Delivery To:</b><br>

                    <div style="font-size:11px; line-height:1.4;">
                        PT. Cahaya Santoso Jaya Raya<br>
                        Jl. Raya Tropodo No. 1<br>
                        Waru - Sidoarjo 61256 East Java, Indonesia
                    </div>

                </td>

                <!-- ================= RIGHT COLUMN ================= -->
                <td width="45%" valign="top">
                    <table width="100%">

                        <tr>
                            <td width="40%"><b>Number</b></td>
                            <td width="60%">
                                @php
                                    $nomorSppb = $dataCetak[0]->No_sppb;
                                    $nomorSppbFormatted = preg_replace('/\bREV\d+\b/i', '<b>$0</b>', e($nomorSppb));
                                @endphp
                                : {!! $nomorSppbFormatted !!}
                            </td>
                        </tr>

                        <tr>
                            <td><b>Date</b></td>
                            <td>: {{ $tanggalSPPB }}</td>
                        </tr>

                        <tr>
                            <td><b>Delivery Date</b></td>
                            <td>: {{ $EstDate }}</td>
                        </tr>

                        @if (!$payment)
                        <tr>
                            <td><b>Payment Term</b></td>
                            <td>: {{ $dataCetak[0]->Waktu }} Days</td>
                        </tr>
                        @endif

                        <tr>
                            <td><b>Divisi</b></td>
                            <td>: {{ trim($dataCetak[0]->Kd_div) }} - {{ trim($dataCetak[0]->NM_DIV) }}</td>
                        </tr>

                        <tr>
                            <td><b>Requester</b></td>
                            <td>: {{ ucwords(strtolower(trim($dataCetak[0]->Operator))) }}</td>
                        </tr>

                        <tr>
                            <td><b>Page</b></td>
                            <td>
                                @foreach ($chunks as $pageIndex => $items)
                                    : Page {{ $pageIndex + 1 }} of {{ count($chunks) }}
                                @endforeach
                            </td>
                        </tr>

                    </table>

                </td>
            </tr>
        </table>

        {{-- Tabel Barang --}}
        <div class="details" style="margin-top: 0px;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th>
                            <h1 style="font-size: 11px;font-family: Helvetica; font-weight: bold; line-height: 13.8px">
                                No.
                            </h1>
                        </th>
                        <th style="text-align: center;">
                            <h1 style="font-size: 11px;font-family: Helvetica; font-weight: bold; line-height: 13.8px">
                                Item Number
                            </h1>
                        </th>
                        <th style="text-align: center;">
                            <h1 style="font-size: 11px;font-family: Helvetica; font-weight: bold; line-height: 13.8px">
                                Description
                            </h1>
                        </th>
                        <th style="text-align: center;">
                            <h1 style="font-size: 11px;font-family: Helvetica; font-weight: bold; line-height: 13.8px">
                                Qty
                            </h1>
                        </th>
                        <th style="text-align: center;">
                            <h1 style="font-size: 11px;font-family: Helvetica; font-weight: bold; line-height: 13.8px">
                                Unit
                            </h1>
                        </th>
                        <th style="text-align: center;">
                            <h1 style="font-size: 11px;font-family: Helvetica; font-weight: bold; line-height: 13.8px">
                                Unit Price<br> {{ $dataCetak[0]->Symbol2 }}
                            </h1>
                        </th>
                        @php
                            $totalDisc = $dataCetak->sum('Disc_trm');
                        @endphp
                        @if ((float) $totalDisc > 1)
                            <th style="text-align: center;">
                                <h1
                                    style="font-size: 11px;font-family: Helvetica; font-weight: bold; line-height: 13.8px">
                                    Disc.<br> {{ $dataCetak[0]->Symbol2 }}
                                </h1>
                            </th>
                        @endif
                        <th style="text-align: center;">
                            <h1 style="font-size: 11px;font-family: Helvetica; font-weight: bold; line-height: 13.8px">
                                Amount<br> {{ $dataCetak[0]->Symbol2 }}
                            </h1>
                        </th>
                    </tr>
                </thead>

                <tbody style="border-top: 1px solid black; border-bottom: 1px solid black;">
                    @foreach ($dataCetak as $index => $item)
                        @php
                            // $amountPerRow = ((float) $item->quantity * (float) $item->Hrg_trm) - (float) $item->hrg_disc;
                            $amountPerRow = (float) $item->Qty * (float) $item->Hrg_trm;
                            $sumAmount += $amountPerRow;
                        @endphp
                        <tr>
                            <td style="text-align: center;vertical-align: top;">
                                <p style="margin:0;font-size: 11px;font-family: Helvetica;">
                                    {{ $index + 1 }}
                                </p>
                            </td>
                            <td style="text-align: center;vertical-align: top;">
                                <p style="margin:0;font-size: 11px;font-family: Helvetica;">
                                    {{ $item->Kd_brg }}
                                </p>
                            </td>
                            <td>
                                <p
                                    style="line-height: 13.8px; margin:0;padding:0; font-size: 11px;font-family: Helvetica;padding-right:8px;">
                                    {{ $item->NAMA_BRG }}
                                    <br>
                                    {{ $item->keterangan }}
                                    <br>
                                    {{ $item->No_trans }}
                                </p>
                            </td>
                            <td style="text-align: center;vertical-align: top;">
                                <p style="margin:0;font-size: 11px;font-family: Helvetica;">
                                    {{ number_format($item->Qty, 2, '.', ',') }}
                                </p>
                            </td>
                            <td style="text-align: center;vertical-align: top;">
                                <p style="margin:0;font-size: 11px;font-family: Helvetica;">
                                    {{ trim($item->Nama_satuan) }}
                                </p>
                            </td>
                            <td style="text-align: center;vertical-align: top;">
                                <p style="margin:0;font-size: 11px;font-family: Helvetica;">
                                    {{ number_format($item->Hrg_trm, 4, '.', ',') }}
                                </p>
                            </td>
                            @if ((float) $item->Disc_trm > 1)
                                <td style="text-align: center;vertical-align: top;">
                                    <p style="margin:0;font-size: 11px;font-family: Helvetica;">
                                        {{ number_format($item->hrg_disc, 2, '.', ',') }}
                                        <br>
                                        ({{ number_format($item->Disc_trm, 2, '.', ',') }}%)
                                    </p>
                                </td>
                            @endif
                            <td style="text-align: center;vertical-align: top;">
                                <p style="margin:0;font-size: 11px;font-family: Helvetica;">
                                    {{ number_format($amountPerRow, 2, '.', ',') }}
                                </p>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!--Perhitungan Harga-->
        <table width="100%" style="margin-top:10px;">
            <tr>
                <td width="55%"></td>
                <td width="45%">
                    <table width="100%">

                        @if ((float) $dataCetak[0]->Ppn_trm > 0)

                            @if (count($dataCetak) > 1)
                            <tr>
                                <td width="60%"><b>Sub Total</b></td>
                                <td width="40%" style="border-bottom:1px solid #000; text-align:right;">
                                    {{ $dataCetak[0]->Symbol }}
                                    {{ number_format($sumAmount, 2, '.', ',') }}
                                </td>
                            </tr>
                            @endif

                            <tr>
                                <td><b>DPP Nilai Lain</b></td>
                                <td style="border-bottom:1px solid #000; text-align:right;">
                                    {{ $dataCetak[0]->Symbol }}
                                    {{ number_format($amountDPP, 2, '.', ',') }}
                                </td>
                            </tr>

                            <tr>
                                <td><b>VAT</b></td>
                                <td style="border-bottom:1px solid #000; text-align:right;">
                                    {{ $dataCetak[0]->Symbol }}
                                    {{ number_format($ppn, 2, '.', ',') }}
                                </td>
                            </tr>

                        @endif

                        <tr>
                            <td><b>Total</b></td>
                            <td style="border-bottom:1px solid #000; text-align:right;">
                                @if ((float) $dataCetak[0]->Ppn_trm > 0)
                                    {{ $dataCetak[0]->Symbol }}
                                    {{ number_format($ppn + $sumAmount, 2, '.', ',') }}
                                @else
                                    {{ $dataCetak[0]->Symbol }}
                                    {{ number_format($sumAmount, 2, '.', ',') }}
                                @endif
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <br>
        {{-- Informasi Cetak --}}
        <table width="100%" style="margin-top:10px;">
        <tr>
            <td width="45%">
                <table width="100%"
                    style="font-size:9px; border-collapse:collapse; line-height:1.1;">

                    @php
                        $rows = [
                            'Delivery Term' => $deliveryTerm,
                            'Packing' => $packing,
                            'Shipping Mark' => $shippingMark,
                            'Delivery Time' => $deliveryTime,
                            'Documents Required' => $documentsRequired,
                            'Partial Shipment Transit' => $partialShipmentTransit,
                            'Port of Loading' => $portOfLoading,
                            'Port Of Discharge' => $portOfDischarge,
                            'Other Conditions' => $otherConditions,
                            'Payment' => $payment,
                        ];
                    @endphp

                    @foreach ($rows as $label => $value)
                        <tr>
                            <td width="10%" style="padding-top:4px; padding-bottom:0; line-height:1.1; vertical-align:top;">
                                <span style="font-weight:bold;">{{ $label }}</span>
                            </td>
                            <td width="1%" style="padding-top:4px; padding-bottom:0; line-height:1.1; vertical-align:top;">
                                :
                            </td>
                            <td width="40%" style="padding-top:4px; padding-bottom:0; line-height:1.1; vertical-align:top;">
                                {{ $value ?: ' ' }}
                            </td>
                        </tr>
                    @endforeach

                </table>
            </td>
        </tr>
    </table>

        {{-- @php
            $itemCount = count($dataCetak);
            if ($itemCount <= 1) {
                $spacerHeight = '50mm';
            } elseif ($itemCount == 2) {
                $spacerHeight = '39mm';
            } elseif ($itemCount == 3) {
                $spacerHeight = '26mm';
            } elseif ($itemCount == 4) {
                $spacerHeight = '13mm';
            } else {
                $spacerHeight = '10mm';
            }
        @endphp

        <!-- Spacer untuk menjaga footer tetap di bawah -->
        <table style="width:100%;">
            <tr>
                <td style="height:{{ $spacerHeight }};"></td>
            </tr>
        </table> --}}

    </div>
    {{-- FOOTER --}}
    {{-- <div class="footer"> --}}
        <table width="100%" style="text-align:center; margin-top:8px; font-size:11px;">
            <tr>
                <td width="33%">MENYETUJUI,</td>
                {{-- <td width="33%">PEMESAN,</td>
            <td width="33%">PELAKSANA,</td> --}}
            </tr>
            <tr>
                <td>
                    <div class="signature_box">
                        @if (!empty($ttdDirektur?->FotoTtd))
                            <img src="data:image/png;base64,{{ $ttdDirektur->FotoTtd }}" class="signature_img"><br>
                            <b style="font-size:12px;">RUDY SANTOSO</b>
                        @endif
                    </div>
                </td>
                {{-- <td><div class="signature_box"></div></td>
            <td><div class="signature_box"></div></td> --}}
            </tr>

            <tr>
                <td>(................................)</td>
                {{-- <td>(................................)</td>
            <td>(................................)</td> --}}
            </tr>
        </table>

        <p style="font-size:11px;margin-top:5px;">
            <b>PERHATIAN:</b> UNTUK PENAGIHAN YANG TIDAK DILENGKAPI LEMBAR INI TIDAK DAPAT KAMI LAYANI
        </p>
    {{-- </div> --}}


    <!--Dokumentasi-->
    @php
        $dok = DB::connection('ConnPurchase')
            ->table('YTRANSBL')
            ->select('Dokumentasi', 'DokumentasiFile')
            ->whereRaw('RTRIM(No_sppb) = ?', [trim($nomorSppb)])
            ->first();
    @endphp

    @if(!empty($dok?->Dokumentasi))
        <div style="page-break-before: always;"></div>
        {{-- <h2 style="text-align:center;">DOKUMENTASI</h2> --}}

        <div style="text-align:center; margin-top:20px;">
            <img src="data:image/jpeg;base64,{{ $dok->Dokumentasi }}"
                style="width:75%; height:auto;">
        </div>
    @endif

</body>

</html>
