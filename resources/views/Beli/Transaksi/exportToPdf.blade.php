<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <style>
        @page {
            size: 21cm 30cm;
            margin: 1.5cm;
        }

        body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 13px;
            color: #000;
            padding-right: 50px;
            padding-top: 25px;
            padding-left: 50px;
            padding-bottom: 25px;
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
            padding: 12px;
        }

        .right { text-align: right; }
        .center { text-align: center; }
        .left { text-align: left;}


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

        .signature_box {
            height: 55px;
            text-align: center;
        }

        .signature_img {
            max-height: 75px;
            max-width: 100%;
            margin-top: -18px;
        }

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
                    <img src="{{ asset('images/csj.png') }}" width="65" style="display:block;">
                </td>

                <td valign="top" style="padding-left:10px; text-align:center; white-space:nowrap;">
                    <div style="color:#0713c5; font-size:18px; font-weight:bold; margin-top: -5px; line-height:1.1;">
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
                <td colspan="3" style="font-size:12px; line-height:1.25; padding-top:5px; padding-left: 9px;">
                    Raya Tropodo No. 1, Waru, Sidoarjo 61256<br>
                    East Java, Indonesia<br>
                    ph. +62-31 866 9595<br>
                    fax. +62-31 866 6425<br>
                    <img src="{{ asset('images/envelope.png') }}" width="13" style="vertical-align:middle; margin-right: 3px">cahayasjaya@gmail.com
                </td>
            </tr>
        </table>
    </td>


    <td width="50%" valign="top">
        <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse; padding-right:10px;">
            <tr>
                <td valign="top" style="padding-left:10px; text-align:center; white-space:nowrap;">
                    <div style="color:#000000; font-size:18px; font-weight:bold; margin-top: -5px; line-height:1.1;">
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
            $tanggalSPPB = date('d M Y', strtotime($dataCetak[0]->tanggal_sppb));
            $EstDate = date('d M Y', strtotime($dataCetak[0]->Tgl_Dibutuhkan ?? $dataCetak[0]->Tgl_Dibutuhkan));
            $payment = $dataCetak[0]->Waktu ?? null;
        } else {
            $tanggalSPPB = '-';
            $EstDate = '-';
            $payment = null;
        }
        $sumAmount = 0;
        $totalDisc = !empty($dataCetak)
            ? array_sum(array_map(fn($row) => (float) $row->Disc_trm, $dataCetak))
            : 0;
        $chunkSize = 5;
        $chunks = !empty($dataCetak)
            ? array_chunk($dataCetak, $chunkSize)
            : [];

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
    <div style="width: 100%; height: auto; display: flex;">
        <div style="width: 50%; height: auto; margin-right: 20px;">
            <h1
                style="font-size: 13px;font-family: Helvetica; font-weight: bold; margin:2px 0 10px 0;">
                Issued To:
            </h1>
            <p style="font-size: 13px;font-family: Helvetica; margin: 2px 0;">
                {{ $dataCetak[0]->NM_SUP }}
            </p>
            <p style="font-size: 13px;font-family: Helvetica; margin: 2px 0;">
                {{ $dataCetak[0]->ALAMAT1 }}
            </p>
            <p style="font-size: 13px;font-family: Helvetica; margin: 2px 0;">
                {{ $dataCetak[0]->KOTA1 }}
            </p>
            <p style="font-size: 13px;font-family: Helvetica; margin: 2px 0;">
                {{ $dataCetak[0]->NEGARA1 }}
            </p>

            <h1
                style="font-size: 13px;font-family: Helvetica; font-weight: bold; margin-top: 10px; margin-bottom: 2px;">
                Delivery To:
            </h1>
            <p style="font-size: 13px;font-family: Helvetica; margin: 2px 0;">PT. Cahaya Santoso
                Jaya
                Raya
            </p>
            <p style="font-size: 13px;font-family: Helvetica; margin: 2px 0;">Jl. Raya Tropodo
                No. 1
            </p>
            <p style="font-size: 13px;font-family: Helvetica; margin: 2px 0;">Waru - Sidoarjo
                61256 East Java, Indonesia
            </p>
        </div>
        <div style="width: 50%; height: auto; margin-left: 20px;">
            <div style="width: 100%; display: flex;">
                <div style="width: 30%; height: auto;">
                    <h1
                        style="font-size: 13px;font-family: Helvetica; font-weight: bold; margin: 2px 0;">
                        Number
                    </h1>
                </div>
                @php
                    $nomorSppb = $dataCetak[0]->nomor_sppb;

                    // Bold REV + angka (REV01, REV02, dst)
                    $nomorSppbFormatted = preg_replace(
                        '/\bREV\d+\b/i',
                        '<b>$0</b>',
                        e($nomorSppb),
                    );
                @endphp
                <div style="width: 70%; height: auto;">
                    <p style="font-size: 13px;font-family: Helvetica; margin: 2px 0;">:
                        {!! $nomorSppbFormatted !!}
                    </p>
                </div>
            </div>
            <div style="width: 100%; display: flex;">
                <div style="width: 30%; height: auto;">
                    <h1
                        style="font-size: 13px;font-family: Helvetica; font-weight: bold; margin: 2px 0;">
                        Date</h1>
                </div>
                <div style="width: 70%; height: auto;">
                    <p style="font-size: 13px;font-family: Helvetica; margin: 2px 0;">:
                        {{ $tanggalSPPB }}
                    </p>
                </div>
            </div>
            <div style="width: 100%; display: flex;">
                <div style="width: 30%; height: auto;">
                    <h1
                        style="font-size: 13px;font-family: Helvetica; font-weight: bold; margin: 2px 0;">
                        Delivery Date
                    </h1>
                </div>
                <div style="width: 70%; height: auto;">
                    <p style="font-size: 13px;font-family: Helvetica; margin: 2px 0;">:
                        {{ $EstDate }}
                    </p>
                </div>
            </div>

            @if (!$payment)
                <div style="width: 100%; display: flex;">
                    <div style="width: 30%; height: auto;">
                        <h1
                            style="font-size: 13px;font-family: Helvetica; font-weight: bold; margin: 2px 0;">
                            Payment Term
                        </h1>
                    </div>
                    <div style="width: 70%; height: auto;">
                        <p style="font-size: 13px;font-family: Helvetica; margin: 2px 0;">:
                            {{ $dataCetak[0]->Waktu }} Days
                        </p>
                    </div>
                </div>
            @endif


            <div style="width: 100%; display: flex;">
                <div style="width: 30%; height: auto;">
                    <h1
                        style="font-size: 13px;font-family: Helvetica; font-weight: bold; margin: 2px 0;">
                        Divisi
                    </h1>
                </div>
                <div style="width: 70%; height: auto;">
                    <div
                        style="font-size: 13px;font-family: Helvetica; margin: 2px 0; display:flex">
                        <span>:</span>
                        <p style="font-size: 13px;font-family: Helvetica; margin: 0 0 0 4px">
                            {{ trim($dataCetak[0]->kode_divisi) }} -
                            {{ trim($dataCetak[0]->nama_divisi) }}
                        </p>
                    </div>
                </div>
            </div>
            <div style="width: 100%; display: flex;">
                <div style="width: 30%; height: auto;">
                    <h1
                        style="font-size: 13px;font-family: Helvetica; font-weight: bold; margin: 2px 0;">
                        Requester
                    </h1>
                </div>
                <div style="width: 70%; height: auto;">
                    <p style="font-size: 13px;font-family: Helvetica; margin: 2px 0;">:
                        {{ ucwords(strtolower(trim($dataCetak[0]->Operator))) }}
                    </p>
                </div>
            </div>
            @foreach ($chunks as $pageIndex => $items)
            <div style="{{ $pageIndex < count($chunks) - 1 ? 'always' : 'avoid' }};">
                <div style="width: 100%; display: flex;">
                    <div style="width: 30%; height: auto;">
                        <h1 style="font-size: 13px;font-family: Helvetica; font-weight: bold; margin: 2px 0;">
                            Page
                        </h1>
                    </div>
                    <div style="width: 70%; height: auto;">
                        <p style="font-size: 13px;font-family: Helvetica; margin: 2px 0;">
                        : Page {{ $pageIndex + 1 }} of {{ count($chunks) }}
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Tabel Barang --}}
    <div class="details" style="margin-top: 0px;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>
                        <h1
                            style="font-size: 13px;font-family: Helvetica; font-weight: bold; line-height: 13.8px">
                            No.
                        </h1>
                    </th>
                    <th style="text-align: center;">
                        <h1
                            style="font-size: 13px;font-family: Helvetica; font-weight: bold; line-height: 13.8px">
                            Item Number
                        </h1>
                    </th>
                    <th style="text-align: center;">
                        <h1
                            style="font-size: 13px;font-family: Helvetica; font-weight: bold; line-height: 13.8px">
                            Description
                        </h1>
                    </th>
                    <th style="text-align: center;">
                        <h1
                            style="font-size: 13px;font-family: Helvetica; font-weight: bold; line-height: 13.8px">
                            Qty
                        </h1>
                    </th>
                    <th style="text-align: center;">
                        <h1
                            style="font-size: 13px;font-family: Helvetica; font-weight: bold; line-height: 13.8px">
                            Unit
                        </h1>
                    </th>
                    <th style="text-align: center;">
                        <h1
                            style="font-size: 13px;font-family: Helvetica; font-weight: bold; line-height: 13.8px">
                            Unit Price<br> {{ $dataCetak[0]->Symbol2 }}
                        </h1>
                    </th>
                    @php
                        $totalDisc = array_sum(
                            array_map(fn($row) => (float) $row->Disc_trm, $dataCetak),
                        );
                    @endphp
                    @if ((float) $totalDisc > 1)
                        <th style="text-align: center;">
                            <h1
                                style="font-size: 13px;font-family: Helvetica; font-weight: bold; line-height: 13.8px">
                                Disc.<br> {{ $dataCetak[0]->Symbol2 }}
                            </h1>
                        </th>
                    @endif
                    <th style="text-align: center;">
                        <h1
                            style="font-size: 13px;font-family: Helvetica; font-weight: bold; line-height: 13.8px">
                            Amount<br> {{ $dataCetak[0]->Symbol2 }}
                        </h1>
                    </th>
                </tr>
            </thead>

            <tbody style="border-top: 1px solid black; border-bottom: 1px solid black;">
                @foreach ($dataCetak as $index => $item)
                    @php
                        $amountPerRow = (float) $item->quantity * (float) $item->Hrg_trm;
                        $sumAmount += $amountPerRow;
                    @endphp
                    <tr>
                        <td style="text-align: center;vertical-align: top;">
                            <p style="margin:0;font-size: 12px;font-family: Helvetica;">
                                {{ $index + 1 }}
                            </p>
                        </td>
                        <td style="text-align: center;vertical-align: top;">
                            <p style="margin:0;font-size: 12px;font-family: Helvetica;">
                                {{ $item->kode_barang }}
                            </p>
                        </td>
                        <td>
                            <p
                                style="line-height: 13.8px; margin:0;padding:0; font-size: 12px;font-family: Helvetica;padding-right:8px;">
                                {{ str_replace('<', '&lt;', $item->NAMA_BRG) }}
                                <br>
                                {{ $item->No_trans }}
                            </p>
                        </td>
                        <td style="text-align: center;vertical-align: top;">
                            <p style="margin:0;font-size: 12px;font-family: Helvetica;">
                                {{ number_format($item->quantity, 2, '.', ',') }}
                            </p>
                        </td>
                        <td style="text-align: center;vertical-align: top;">
                            <p style="margin:0;font-size: 12px;font-family: Helvetica;">
                                {{ trim($item->Nama_satuan) }}
                            </p>
                        </td>
                        <td style="text-align: center;vertical-align: top;">
                            <p style="margin:0;font-size: 12px;font-family: Helvetica;">
                                {{ number_format($item->Hrg_trm, 4, '.', ',') }}
                            </p>
                        </td>
                        @if ((float) $item->Disc_trm > 1)
                            <td style="text-align: center;vertical-align: top;">
                                <p style="margin:0;font-size: 12px;font-family: Helvetica;">
                                    {{ number_format($item->hrg_disc, 2, '.', ',') }}
                                    <br>
                                    ({{ number_format($item->Disc_trm, 2, '.', ',') }}%)
                                </p>
                            </td>
                        @endif
                        <td style="text-align: center;vertical-align: top;">
                            <p style="margin:0;font-size: 12px;font-family: Helvetica;">
                                {{ number_format($amountPerRow, 2, '.', ',') }}
                            </p>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
<br>
    {{-- Informasi Cetak --}}
    @if ($deliveryTerm)
        <div style="width: 80%; height: auto; margin-left: 20px;">
            <div style="width: 100%; display: flex;">
                <div style="width: 30%; height: auto;">
                    <h1
                        style="font-size: 12px;font-family: Helvetica; font-weight: bold; margin: 2px 0;">
                        Delivery Term
                    </h1>
                </div>
                <div style="width: 1%; height: auto;">
                    <p style="font-size: 11px;font-family: Helvetica; margin: 2px 0;">:</p>
                </div>
                <div style="width: 69%; height: auto;">
                    <p style="font-size: 11px;font-family: Helvetica; margin: 2px 0;">
                        {{ $deliveryTerm }}
                    </p>
                </div>
            </div>
        </div>
    @endif
    @if ($packing)
        <div style="width: 80%; height: auto; margin-left: 20px;">
            <div style="width: 100%; display: flex;">
                <div style="width: 30%; height: auto;">
                    <h1
                        style="font-size: 12px;font-family: Helvetica; font-weight: bold; margin: 2px 0;">
                        Packing
                    </h1>
                </div>
                <div style="width: 1%; height: auto;">
                    <p style="font-size: 11px;font-family: Helvetica; margin: 2px 0;">:</p>
                </div>
                <div style="width: 69%; height: auto;">
                    <p style="font-size: 11px;font-family: Helvetica; margin: 2px 0;">
                        {{ $packing }}
                    </p>
                </div>
            </div>
        </div>
    @endif
    @if ($shippingMark)
        <div style="width: 80%; height: auto; margin-left: 20px;">
            <div style="width: 100%; display: flex;">
                <div style="width: 30%; height: auto;">
                    <h1
                        style="font-size: 12px;font-family: Helvetica; font-weight: bold; margin: 2px 0;">
                        Shipping Mark
                    </h1>
                </div>
                <div style="width: 1%; height: auto;">
                    <p style="font-size: 11px;font-family: Helvetica; margin: 2px 0;">:</p>
                </div>
                <div style="width: 69%; height: auto;">
                    <p style="font-size: 11px;font-family: Helvetica; margin: 2px 0;">
                        {{ $shippingMark }}
                    </p>
                </div>
            </div>
        </div>
    @endif
    @if ($deliveryTime)
        <div style="width: 80%; height: auto; margin-left: 20px;">
            <div style="width: 100%; display: flex;">
                <div style="width: 30%; height: auto;">
                    <h1
                        style="font-size: 12px;font-family: Helvetica; font-weight: bold; margin: 2px 0;">
                        Delivery Time
                    </h1>
                </div>
                <div style="width: 1%; height: auto;">
                    <p style="font-size: 11px;font-family: Helvetica; margin: 2px 0;">:</p>
                </div>
                <div style="width: 69%; height: auto;">
                    <p style="font-size: 11px;font-family: Helvetica; margin: 2px 0;">
                        {{ $deliveryTime }}
                    </p>
                </div>
            </div>
        </div>
    @endif
    @if ($documentsRequired)
        <div style="width: 80%; height: auto; margin-left: 20px;">
            <div style="width: 100%; display: flex;">
                <div style="width: 30%; height: auto;">
                    <h1
                        style="font-size: 12px;font-family: Helvetica; font-weight: bold; margin: 2px 0;">
                        Documents Required
                    </h1>
                </div>
                <div style="width: 1%; height: auto;">
                    <p style="font-size: 11px;font-family: Helvetica; margin: 2px 0;">:</p>
                </div>
                <div style="width: 69%; height: auto;">
                    <p style="font-size: 11px;font-family: Helvetica; margin: 2px 0;">
                        {{ $documentsRequired }}
                    </p>
                </div>
            </div>
        </div>
    @endif
    @if ($partialShipmentTransit)
        <div style="width: 80%; height: auto; margin-left: 20px;">
            <div style="width: 100%; display: flex;">
                <div style="width: 30%; height: auto;">
                    <h1
                        style="font-size: 12px;font-family: Helvetica; font-weight: bold; margin: 2px 0;">
                        Partial Shipment Transit
                    </h1>
                </div>
                <div style="width: 1%; height: auto;">
                    <p style="font-size: 11px;font-family: Helvetica; margin: 2px 0;">:</p>
                </div>
                <div style="width: 69%; height: auto;">
                    <p style="font-size: 11px;font-family: Helvetica; margin: 2px 0;">
                        {{ $partialShipmentTransit }}
                    </p>
                </div>
            </div>
        </div>
    @endif
    @if ($portOfLoading)
        <div style="width: 80%; height: auto; margin-left: 20px;">
            <div style="width: 100%; display: flex;">
                <div style="width: 30%; height: auto;">
                    <h1
                        style="font-size: 12px;font-family: Helvetica; font-weight: bold; margin: 2px 0;">
                        Port of Loading
                    </h1>
                </div>
                <div style="width: 1%; height: auto;">
                    <p style="font-size: 11px;font-family: Helvetica; margin: 2px 0;">:</p>
                </div>
                <div style="width: 69%; height: auto;">
                    <p style="font-size: 11px;font-family: Helvetica; margin: 2px 0;">
                        {{ $portOfLoading }}
                    </p>
                </div>
            </div>
        </div>
    @endif
    @if ($portOfDischarge)
        <div style="width: 80%; height: auto; margin-left: 20px;">
            <div style="width: 100%; display: flex;">
                <div style="width: 30%; height: auto;">
                    <h1
                        style="font-size: 12px;font-family: Helvetica; font-weight: bold; margin: 2px 0;">
                        Port Of Discharge
                    </h1>
                </div>
                <div style="width: 1%; height: auto;">
                    <p style="font-size: 11px;font-family: Helvetica; margin: 2px 0;">:</p>
                </div>
                <div style="width: 69%; height: auto;">
                    <p style="font-size: 11px;font-family: Helvetica; margin: 2px 0;">
                        {{ $portOfDischarge }}
                    </p>
                </div>
            </div>
        </div>
    @endif
    @if ($otherConditions)
        <div style="width: 80%; height: auto; margin-left: 20px;">
            <div style="width: 100%; display: flex;">
                <div style="width: 30%; height: auto;">
                    <h1
                        style="font-size: 12px;font-family: Helvetica; font-weight: bold; margin: 2px 0;">
                        Other Conditions
                    </h1>
                </div>
                <div style="width: 1%; height: auto;">
                    <p style="font-size: 11px;font-family: Helvetica; margin: 2px 0;">:</p>
                </div>
                <div style="width: 69%; height: auto;">
                    <p style="font-size: 11px;font-family: Helvetica; margin: 2px 0;">
                        {{ $otherConditions }}
                    </p>
                </div>
            </div>
        </div>
    @endif
    @if ($payment)
        <div style="width: 80%; height: auto; margin-left: 20px;">
            <div style="width: 100%; display: flex;">
                <div style="width: 30%; height: auto;">
                    <h1
                        style="font-size: 12px;font-family: Helvetica; font-weight: bold; margin: 2px 0;">
                        Payment
                    </h1>
                </div>
                <div style="width: 1%; height: auto;">
                    <p style="font-size: 11px;font-family: Helvetica; margin: 2px 0;">:</p>
                </div>
                <div style="width: 69%; height: auto;">
                    <p style="font-size: 11px;font-family: Helvetica; margin: 2px 0;">
                        {{ $payment }}
                    </p>
                </div>
            </div>
        </div>
    @endif

@php
    $itemCount = count($dataCetak);
    if ($itemCount <= 1) {
        $spacerHeight = '56mm';
    } elseif ($itemCount == 2) {
        $spacerHeight = '44mm';
    } elseif ($itemCount == 3) {
        $spacerHeight = '31mm';
    } elseif ($itemCount == 4) {
        $spacerHeight = '18mm';
    } else {
        $spacerHeight = '17mm';
    }
@endphp

<!-- Spacer untuk menjaga footer tetap di bawah -->
<table style="width:100%;">
    <tr>
        <td style="height:{{ $spacerHeight }};"></td>
    </tr>
</table>


</div>



{{-- FOOTER --}}
<table width="100%" style="text-align:center; margin-top:8px; font-size:11px;">
    <tr>
        <td width="33%">MENYETUJUI,</td>
        <td width="33%">PEMESAN,</td>
        <td width="33%">PELAKSANA,</td>
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
        <td><div class="signature_box"></div></td>
        <td><div class="signature_box"></div></td>
    </tr>

    <tr>
        <td>(................................)</td>
        <td>(................................)</td>
        <td>(................................)</td>
    </tr>
</table>




<p style="font-size:11px;margin-top:5px;">
    <b>PERHATIAN:</b> UNTUK PENAGIHAN YANG TIDAK DILENGKAPI LEMBAR INI TIDAK DAPAT KAMI LAYANI
</p>

</body>

</html>

