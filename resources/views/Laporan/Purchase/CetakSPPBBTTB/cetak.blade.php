    @if ($jenisCetak == 'SPPB')
        @php
            $tanggalSPPB = date('m/d/Y', strtotime($dataCetak[0]->tanggal_sppb));
            $sumTotalHarga = 0;
        @endphp
    @endif
    @if ($jenisCetak == 'SPPBBaru')
        @php
            $tanggalSPPB = date('d M Y', strtotime($dataCetak[0]->tanggal_sppb));
            $EstDate = date('d M Y', strtotime($dataCetak[0]->Tgl_Dibutuhkan));
            $sumAmount = 0;
            $ppn = 0;
            $amountDPP = 0;
        @endphp
        @if ($dataCetak[0]->Informasi_Cetak)
            @php
                $deliveryTerm = explode(' | ', $dataCetak[0]->Informasi_Cetak)[0];
                $packing = explode(' | ', $dataCetak[0]->Informasi_Cetak)[1];
                $shippingMark = explode(' | ', $dataCetak[0]->Informasi_Cetak)[2];
                $deliveryTime = explode(' | ', $dataCetak[0]->Informasi_Cetak)[3];
                $documentsRequired = explode(' | ', $dataCetak[0]->Informasi_Cetak)[4];
                $partialShipmentTransit = explode(' | ', $dataCetak[0]->Informasi_Cetak)[5];
                $portOfLoading = explode(' | ', $dataCetak[0]->Informasi_Cetak)[6];
                $portOfDischarge = explode(' | ', $dataCetak[0]->Informasi_Cetak)[7];
                $otherConditions = explode(' | ', $dataCetak[0]->Informasi_Cetak)[8];
                $payment = explode(' | ', $dataCetak[0]->Informasi_Cetak)[9];
            @endphp
        @endif
    @endif
    @php
        // dd($dataCetak);
    @endphp

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1" />
        @if ($jenisCetak == 'SPPB')
            <title>Cetak SPPB {{ $dataCetak[0]->nomor_sppb }}</title>
        @elseif ($jenisCetak == 'BTTB')
            <title>Cetak BTTB {{ $dataCetak[0]->nomor_terima }}</title>
        @endif
        <style>
            body {
                font-family: Tahoma, Arial, Helvetica, sans-serif;
                color: #111;
            }
        </style>
    </head>

    <body>
        <div style="height: 20cm; overflow: overflow;gap: 5px;">
            @if ($jenisCetak == 'SPPB')
                <div style="display: flex;flex-direction: column;text-align: right;">
                    <label>{{ $dataCetak[0]->kode_divisi }} {{ $dataCetak[0]->nomor_sppb }}</label>
                    <label>{{ $tanggalSPPB }}</label>
                </div>
                <div style="display: flex;flex-direction: column;text-align: left;">
                    <label style="font-style: italic">Cetakan ke: {{ $dataCetak[0]->Kounter_Cetak }} (
                        {{ $dataCetak[0]->Alasan }} ) </label>
                </div>
                <div style="display: flex;flex-direction: column;">
                    <table style="width: 100%;border-collapse: collapse;margin-top: 10px;border:1px solid #000;"">
                        <tr style="white-space: nowrap">
                            <td style="padding: 10px 5px 10px 5px; text-align: center;border:1px solid #000;">No</td>
                            <td style="padding: 10px 5px 10px 5px; text-align: center;border:1px solid #000;">Quantity
                            </td>
                            <td style="padding: 10px 5px 10px 5px; text-align: center;border:1px solid #000;">Satuan
                            </td>
                            <td style="padding: 10px 5px 10px 5px; text-align: center;border:1px solid #000;">
                                Spesifikasi</td>
                            <td style="padding: 10px 5px 10px 5px; text-align: center;border:1px solid #000;">Harga Sat
                            </td>
                            <td style="padding: 10px 5px 10px 5px; text-align: center;border:1px solid #000;">PPN</td>
                            <td style="padding: 10px 5px 10px 5px; text-align: center;border:1px solid #000;">Harga</td>
                        </tr>
                        @foreach ($dataCetak as $index => $item)
                            @php
                                $hargaSatFormatted = number_format($item->Hrg_trm, 2, '.', ',');
                                $hargaFormatted = number_format($item->TotalHarga, 2, '.', ',');
                                $sumTotalHarga += (float) $item->TotalHarga;
                            @endphp
                            <tr>
                                <td style="padding: 4px; font-size: 10px;border:1px solid #000;">{{ $index + 1 }}
                                </td>
                                <td style="padding: 4px; font-size: 10px;border:1px solid #000;">
                                    {{ number_format($item->quantity, 2, '.', ',') }}</td>
                                <td style="padding: 4px; font-size: 10px;border:1px solid #000;">
                                    {{ trim($item->Nama_satuan) }}</td>
                                <td style="padding: 4px; font-size: 10px;border:1px solid #000;">
                                    <div style="display: flex;flex-direction: row;">
                                        <div style="display: flex;flex-direction: column;flex:0.2;">
                                            <label>
                                                <{{ $item->kode_barang }}>
                                            </label>
                                        </div>
                                        <div style="display: flex;flex-direction: column;flex:0.8;">
                                            <label>{{ $item->NAMA_BRG }}</label>
                                            <label>( {{ $item->KET }} )</label>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding: 4px; font-size: 10px;border:1px solid #000;">
                                    {{ $hargaSatFormatted }}
                                </td>
                                <td style="padding: 4px; font-size: 10px;border:1px solid #000;">
                                    @if ($item->PPN > 0)
                                        {{ number_format($item->PPN, 2, '.', ',') }}
                                    @else
                                        0
                                    @endif
                                </td>
                                <td style="padding: 4px; font-size: 10px;border:1px solid #000;">
                                    {{ $hargaFormatted }}
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    <div
                        style="display: flex;flex-direction: row;border-bottom: solid 3px grey;margin: 10px 0 5px 0;gap: 5px;font-size: 12px;">
                        <div style="display: flex;flex-direction: column;flex:0.15;margin: 0 0 10px 0;">
                            <label>Supplier</label>
                        </div>
                        <div style="display: flex;flex-direction: column;flex:0.59;margin: 0 0 10px 0;">
                            <label>{{ $dataCetak[0]->NM_SUP }}</label>
                        </div>
                        <div style="display: flex;flex-direction: column;flex:0.13;margin: 0 0 10px 0;">
                            <label>Total</label>
                        </div>
                        <div
                            style="display: flex;flex-direction: column;flex:0.005;margin: 0 0 10px 0;font-weight: bold;">
                            <label>{{ $dataCetak[0]->Symbol }}</label>
                        </div>
                        <div
                            style="display: flex;flex-direction: column;flex:0.07;margin: 0 0 10px 0;font-weight: bold;">
                            <label>{{ number_format($sumTotalHarga, 2, '.', ',') }}</label>
                        </div>
                    </div>
                </div>
            @elseif ($jenisCetak == 'BTTB')
                <div style="display: flex;flex-direction: row;">
                    <div style="display: flex;flex-direction: column;flex: 0.5;text-align: left;">
                        <label style="font-weight: bold">PT. CAHAYA SANTOSO JAYA</label>
                        <label>Jl. Raya Tropodo No. 1</label>
                        <label>Waru - Sidoarjo</label>
                    </div>
                    <div style="display: flex;flex-direction: column;flex: 0.5;text-align: right;">
                        <label style="font-weight: bold">BUKTI TANDA TERIMA BARANG</label>
                    </div>
                </div>
                <div style="display: flex;flex-direction: row;margin-top: 10px;font-size: 14px">
                    <div style="display: flex;flex-direction: column;flex: 0.17;">
                        <label>NAMA PENGIRIM</label>
                        <label>GDG. PENERIMA</label>
                    </div>
                    <div style="display: flex;flex-direction: column;flex: 0.005;">
                        <label>:</label>
                        <label>:</label>
                    </div>
                    <div style="display: flex;flex-direction: column;flex: 0.60;">
                        <label>{{ $dataCetak[0]->nama_supplier }}</label>
                        <label>{{ $dataCetak[0]->nama_kategori }}</label>
                    </div>
                    <div style="display: flex;flex-direction: column;flex: 0.14;">
                        <label>NOMOR SPPB</label>
                        <label>TANGGAL</label>
                    </div>
                    <div style="display: flex;flex-direction: column;flex: 0.005;">
                        <label>:</label>
                        <label>:</label>
                    </div>
                    <div style="display: flex;flex-direction: column;flex: 0.08;">
                        <label>{{ $dataCetak[0]->nomor_sppb }}</label>
                        <label>{{ date('m/d/Y', strtotime($dataCetak[0]->tanggal_datang)) }}</label>
                    </div>
                </div>
                <table style="width: 100%;border-collapse: collapse;margin-top: 10px;font-size: 14px;" border="1">
                    <tr style="white-space: nowrap">
                        <td style="padding: 10px 5px 10px 5px; text-align: center;">NO</td>
                        <td style="padding: 10px 5px 10px 5px; text-align: center;">QUANTITY</td>
                        <td style="padding: 10px 5px 10px 5px; text-align: center;">SATUAN</td>
                        <td style="padding: 10px 5px 10px 5px; text-align: center;">JENIS BARANG</td>
                        <td style="padding: 10px 5px 10px 5px; text-align: center;">TYPE BARANG</td>
                        <td style="padding: 10px 5px 10px 5px; text-align: center;">HARGA</td>
                    </tr>
                    @foreach ($dataCetak as $index => $item)
                        <tr>
                            <td style="padding: 0 0 0 5px">{{ $index + 1 }}</td>
                            <td style="padding: 0 0 0 5px">{{ number_format($item->quantity, 2, '.', ',') }}</td>
                            <td style="padding: 0 0 0 5px">{{ trim($item->Nama_satuan) }}</td>
                            <td style="padding: 0 0 0 5px">{{ $item->nama_sub_kategori }}</td>
                            <td style="padding: 0 0 0 5px">{{ $item->NAMA_BRG }}</td>
                            <td style="padding: 0 0 0 5px">
                                {{ $item->Symbol }}{{ number_format($item->hrg_murni, 2, '.', ',') }}</td>
                        </tr>
                    @endforeach
                </table>
                <div
                    style="display: flex;
                            flex-direction: column;
                            border-top: 0;
                            border-right: 1px solid grey;
                            border-bottom: 1px solid grey;
                            border-left: 1px solid grey;
                            font-size: 10px;
                            gap: 2px;">
                    <div style="display: flex;flex-direction: row;">
                        <div style="display: flex;flex-direction: column;flex: 0.245;padding: 0 0 0 5px;gap: 2px;">
                            <label>NO FAKTUR</label>
                            <label>NO SURAT JALAN</label>
                            <label>KETERANGAN PEMBELIAN</label>
                        </div>
                        <div style="display: flex;flex-direction: column;flex: 0.005;gap: 2px;">
                            <label>:</label>
                            <label>:</label>
                            <label>:</label>
                        </div>
                        <div style="display: flex;flex-direction: column;flex: 0.25;gap: 2px;">
                            <label>{{ $dataCetak[0]->Faktur }}</label>
                            <label>{{ $dataCetak[0]->No_SuratJalan }}</label>
                            <label>{{ $dataCetak[0]->ket_beli }}</label>
                        </div>
                        <div style="display: flex;flex-direction: column;flex: 0.245;gap: 2px;">
                            <label>KODE BARANG</label>
                            <label>NO TERIMA</label>
                            <label>NO PIB</label>
                        </div>
                        <div style="display: flex;flex-direction: column;flex: 0.005;gap: 2px;">
                            <label>:</label>
                            <label>:</label>
                            <label>:</label>
                        </div>
                        <div style="display: flex;flex-direction: column;flex: 0.25;gap: 2px;">
                            <label>{{ $dataCetak[0]->kode_barang }}</label>
                            <label>{{ $dataCetak[0]->nomor_terima }}</label>
                            <label>{{ $dataCetak[0]->No_PIB_External }}</label>
                        </div>
                    </div>
                    <div style="display: flex;flex-direction: row;">
                        <div style="display: flex;flex-direction: column;flex: 0.28;padding: 0 0 0 5px;gap: 2px;">
                            <label>TANGGAL PERMOHONAN</label>
                            <label>TANGGAL ACC MANAGER</label>
                            <label>TANGGAL PEMBUATAN SPPB</label>
                        </div>
                        <div style="display: flex;flex-direction: column;flex: 0.005;gap: 2px;">
                            <label>:</label>
                            <label>:</label>
                            <label>:</label>
                        </div>
                        <div style="display: flex;flex-direction: column;flex: 0.115;gap: 2px;">
                            <label>{{ date('m/d/Y', strtotime($dataCetak[0]->tanggal_order)) }}</label>
                            <label>{{ date('m/d/Y', strtotime($dataCetak[0]->tanggal_acc)) }}</label>
                            <label>{{ date('m/d/Y', strtotime($dataCetak[0]->tanggal_sppb)) }}</label>
                        </div>
                        <div style="display: flex;flex-direction: column;flex: 0.1;gap: 2px;">
                            <label>PEMOHON</label>
                            <label>MANAGER</label>
                            <label>PEMBUAT</label>
                        </div>
                        <div style="display: flex;flex-direction: column;flex: 0.005;gap: 2px;">
                            <label>:</label>
                            <label>:</label>
                            <label>:</label>
                        </div>
                        <div style="display: flex;flex-direction: column;flex: 0.28;gap: 2px;">
                            <label>{{ ucfirst(trim($dataCetak[0]->Pemesan)) }}</label>
                            <label>{{ ucfirst(trim($dataCetak[0]->Manager)) }}</label>
                            <label>{{ ucfirst(trim($dataCetak[0]->Operator_SPPB)) }}</label>
                        </div>
                        <div style="display: flex;flex-direction: column;flex: 0.28;">
                            <label>&nbsp;</label>
                            <label>&nbsp;</label>
                            <label>TANGGAL BARANG DATANG</label>
                        </div>
                        <div style="display: flex;flex-direction: column;flex: 0.005;">
                            <label>&nbsp;</label>
                            <label>&nbsp;</label>
                            <label>:</label>
                        </div>
                        <div style="display: flex;flex-direction: column;flex: 0.115;">
                            <label>&nbsp;</label>
                            <label>&nbsp;</label>
                            <label>{{ date('m/d/Y', strtotime($dataCetak[0]->tanggal_datang)) }}</label>
                        </div>
                    </div>
                </div>
                <div style="display: flex;flex-direction: row;margin-top: 10px;font-size: 12px;">
                    <div style="display: flex;flex-direction: column;flex: 0.25;text-align: center;">
                        <label>PEMESAN,</label>
                        <br>
                        <br>
                        <br>
                        <br>
                        <label>{{ ucfirst($dataCetak[0]->Pemesan) }}</label>
                    </div>
                    <div style="display: flex;flex-direction: column;flex: 0.25;text-align: center;">
                        <label>PENERIMA,</label>
                        <br>
                        <br>
                        <br>
                        <br>
                        <label>( . . . . . . . . . . . . . . .)</label>
                    </div>
                    <div style="display: flex;flex-direction: column;flex: 0.25;text-align: center;">
                        <label>MENGETAHUI,</label>
                        <br>
                        <br>
                        <br>
                        <br>
                        <label>( . . . . . . . . . . . . . . .)</label>
                    </div>
                    <div style="display: flex;flex-direction: column;flex: 0.25;text-align: center;">
                        <label>PEMBERI,</label>
                        <br>
                        <br>
                        <br>
                        <br>
                        <label>( . . . . . . . . . . . . . . .)</label>
                    </div>
                </div>
            @elseif ($jenisCetak == 'SPPBBaru')
                @php
                    $chunkSize = 5;
                    $chunks = array_chunk($dataCetak, $chunkSize);

                    $sumAmount = collect($dataCetak)->sum('TotalHarga');
                    $ppn = collect($dataCetak)->sum('Ppn_trm');
                    $amountDPP = collect($dataCetak)->sum('dpp_nilai_lain');
                @endphp
                <style>
                    body {
                        margin: 0;
                        padding: 0;
                    }
                </style>
                @foreach ($chunks as $pageIndex => $items)
                    <div
                        style="
                                width: 19.5cm;
                                height: 27.94cm;
                                padding: 10px 10px 0px 10px;
                                margin: 0;
                                background: #FFFFFF;
                                box-sizing: border-box;
                                page-break-after: {{ $pageIndex < count($chunks) - 1 ? 'always' : 'avoid' }};">
                        <div style="width: 100%; height : 15%;"></div>
                        <main style="width: 100%; height : 70%;">
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
                                    <br>
                                    <h1
                                        style="font-size: 13px;font-family: Helvetica; font-weight: bold; margin-top: 10px; margin-bottom: 2px;">
                                        Delivery To:</h1>
                                    <p style="font-size: 13px;font-family: Helvetica; margin: 2px 0;">PT. Cahaya Santoso
                                        Jaya
                                        Raya</p>
                                    <p style="font-size: 13px;font-family: Helvetica; margin: 2px 0;">Jl. Raya Tropodo
                                        No. 1</p>
                                    <p style="font-size: 13px;font-family: Helvetica; margin: 2px 0;">Waru - Sidoarjo
                                        61256 East Java, Indonesia</p>
                                </div>
                                <div style="width: 50%; height: auto; margin-left: 20px;">
                                    <div style="width: 100%; display: flex;">
                                        <div style="width: 30%; height: auto;">
                                            <h1
                                                style="font-size: 13px;font-family: Helvetica; font-weight: bold; margin: 2px 0;">
                                                Number
                                            </h1>
                                        </div>
                                        <div style="width: 70%; height: auto;">
                                            <p style="font-size: 13px;font-family: Helvetica; margin: 2px 0;">:
                                                {{ $dataCetak[0]->nomor_sppb }}
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
                                                Delivery Date</h1>
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
                                                    Payment Term</h1>
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
                                                Divisi</h1>
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
                                                Requester</h1>
                                        </div>
                                        <div style="width: 70%; height: auto;">
                                            <p style="font-size: 13px;font-family: Helvetica; margin: 2px 0;">:
                                                {{ ucwords(strtolower(trim($dataCetak[0]->Operator))) }}
                                            </p>
                                        </div>
                                    </div>
                                    <div style="width: 100%; display: flex;">
                                        <div style="width: 30%; height: auto;">
                                            <h1
                                                style="font-size: 13px;font-family: Helvetica; font-weight: bold; margin: 2px 0;">
                                                Page</h1>
                                        </div>
                                        <div style="width: 70%; height: auto;">
                                            <p style="font-size: 13px;font-family: Helvetica; margin: 2px 0;">: Page
                                                {{ $pageIndex + 1 }}
                                                of {{ count($chunks) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="details" style="margin-top: 20px;">
                                <table style="width: 100%; border-collapse: collapse;">
                                    <thead>
                                        <tr>
                                            <th>
                                                <h1
                                                    style="font-size: 13px;font-family: Helvetica; font-weight: bold; line-height: 13.8px">
                                                    No.</h1>
                                            </th>
                                            <th style="text-align: center;">
                                                <h1
                                                    style="font-size: 13px;font-family: Helvetica; font-weight: bold; line-height: 13.8px">
                                                    Item Number</h1>
                                            </th>
                                            <th style="text-align: center;">
                                                <h1
                                                    style="font-size: 13px;font-family: Helvetica; font-weight: bold; line-height: 13.8px">
                                                    Description</h1>
                                            </th>
                                            <th style="text-align: center;">
                                                <h1
                                                    style="font-size: 13px;font-family: Helvetica; font-weight: bold; line-height: 13.8px">
                                                    Qty</h1>
                                            </th>
                                            <th style="text-align: center;">
                                                <h1
                                                    style="font-size: 13px;font-family: Helvetica; font-weight: bold; line-height: 13.8px">
                                                    Unit</h1>
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
                                                        style="line-height: 13.8px; font-size: 12px;font-family: Helvetica;padding-right:8px">
                                                        {{ str_replace('<', '&lt;', $item->NAMA_BRG) }}
                                                        <br>
                                                        {{ $item->KET ?? '-' }}
                                                        <br>
                                                        {{ $item->nama_sub_kategori }}
                                                        <br>
                                                        {{ $item->nama_kategori }}
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
                                                        {{ number_format($item->TotalHarga, 2, '.', ',') }}
                                                    </p>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div style="width: 100%; display: flex;">
                                <div style="width: 70%;">
                                    {{-- <h1
                                        style="font-size: 13px;font-family: Helvetica; font-weight: bold;margin-top:50px">
                                        Document Copy of {{ $dataCetak[0]->Kounter_Cetak }}</h1> --}}
                                </div>
                                <div style="width: 30%;">
                                    @if ((float) $dataCetak[0]->PPN > 0)
                                        <div style="width: 100%; display: flex;">
                                            <div style="width: 55%; margin-right: 10%;">
                                                <h1
                                                    style="font-size: 13px;font-family: Helvetica; font-weight: bold; margin: 2px 0;">
                                                    Sub Total</h1>
                                            </div>
                                            <div style="width: 60%; border-bottom: 1px solid; text-align: right;">
                                                <p
                                                    style="line-height: 13.8px; font-size: 13px;font-family: Helvetica; margin: 2px 0;">
                                                    {{ $dataCetak[0]->Symbol }}{{ number_format($sumAmount, 2, '.', ',') }}
                                                </p>
                                            </div>
                                        </div>
                                        <div style="width: 100%; display: flex;">
                                            <div style="width: 55%; margin-right: 10%;">
                                                <h1
                                                    style="font-size: 13px;font-family: Helvetica; font-weight: bold; margin: 2px 0;">
                                                    DPP Nilai Lain</h1>
                                            </div>
                                            <div style="width: 60%; border-bottom: 1px solid; text-align: right;">
                                                <p
                                                    style="line-height: 13.8px; font-size: 13px;font-family: Helvetica; margin: 2px 0;">
                                                    {{ $dataCetak[0]->Symbol }}{{ number_format($amountDPP, 2, '.', ',') }}
                                                </p>
                                            </div>
                                        </div>
                                        <div style="width: 100%; display: flex;">
                                            <div style="width: 55%; margin-right: 10%;">
                                                <h1
                                                    style="font-size: 13px;font-family: Helvetica; font-weight: bold; margin: 2px 0;">
                                                    VAT</h1>
                                            </div>
                                            <div style="width: 60%; border-bottom: 1px solid; text-align: right;">
                                                <p
                                                    style="line-height: 13.8px; font-size: 13px;font-family: Helvetica; margin: 2px 0;">
                                                    {{ $dataCetak[0]->Symbol }}{{ number_format($ppn, 2, '.', ',') }}
                                                </p>
                                            </div>
                                        </div>
                                    @endif

                                    <div style="width: 100%; display: flex;">
                                        <div style="width: 55%; margin-right: 10%;">
                                            <h1
                                                style="font-size: 13px;font-family: Helvetica; font-weight: bold; margin: 2px 0;">
                                                Total</h1>
                                        </div>
                                        <div style="width: 60%; border-bottom: 1px solid; text-align: right;">
                                            <p
                                                style="line-height: 13.8px; font-size: 13px;font-family: Helvetica; margin: 2px 0;">
                                                @if ((float) $dataCetak[0]->PPN > 0)
                                                    {{ $dataCetak[0]->Symbol }}{{ number_format($ppn + $sumAmount, 2, '.', ',') }}
                                                @else
                                                    {{ $dataCetak[0]->Symbol }}{{ number_format($sumAmount, 2, '.', ',') }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                            <p style="font-size: 12px;font-family: Helvetica; margin: 2px 0;">:</p>
                                        </div>
                                        <div style="width: 69%; height: auto;">
                                            <p style="font-size: 12px;font-family: Helvetica; margin: 2px 0;">
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
                                            <p style="font-size: 12px;font-family: Helvetica; margin: 2px 0;">:</p>
                                        </div>
                                        <div style="width: 69%; height: auto;">
                                            <p style="font-size: 12px;font-family: Helvetica; margin: 2px 0;">
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
                                            <p style="font-size: 12px;font-family: Helvetica; margin: 2px 0;">:</p>
                                        </div>
                                        <div style="width: 69%; height: auto;">
                                            <p style="font-size: 12px;font-family: Helvetica; margin: 2px 0;">
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
                                            <p style="font-size: 12px;font-family: Helvetica; margin: 2px 0;">:</p>
                                        </div>
                                        <div style="width: 69%; height: auto;">
                                            <p style="font-size: 12px;font-family: Helvetica; margin: 2px 0;">
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
                                            <p style="font-size: 12px;font-family: Helvetica; margin: 2px 0;">:</p>
                                        </div>
                                        <div style="width: 69%; height: auto;">
                                            <p style="font-size: 12px;font-family: Helvetica; margin: 2px 0;">
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
                                            <p style="font-size: 12px;font-family: Helvetica; margin: 2px 0;">:</p>
                                        </div>
                                        <div style="width: 69%; height: auto;">
                                            <p style="font-size: 12px;font-family: Helvetica; margin: 2px 0;">
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
                                            <p style="font-size: 12px;font-family: Helvetica; margin: 2px 0;">:</p>
                                        </div>
                                        <div style="width: 69%; height: auto;">
                                            <p style="font-size: 12px;font-family: Helvetica; margin: 2px 0;">
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
                                            <p style="font-size: 12px;font-family: Helvetica; margin: 2px 0;">:</p>
                                        </div>
                                        <div style="width: 69%; height: auto;">
                                            <p style="font-size: 12px;font-family: Helvetica; margin: 2px 0;">
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
                                            <p style="font-size: 12px;font-family: Helvetica; margin: 2px 0;">:</p>
                                        </div>
                                        <div style="width: 69%; height: auto;">
                                            <p style="font-size: 12px;font-family: Helvetica; margin: 2px 0;">
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
                                            <p style="font-size: 12px;font-family: Helvetica; margin: 2px 0;">:</p>
                                        </div>
                                        <div style="width: 69%; height: auto;">
                                            <p style="font-size: 12px;font-family: Helvetica; margin: 2px 0;">
                                                {{ $payment }} </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div style="width: 100%; display: flex;">
                                <div style="width: 70%;">
                                    <h1
                                        style="font-size: 13px;font-family: Helvetica; font-weight: bold;margin-top:50px">
                                        Document Copy of {{ $dataCetak[0]->Kounter_Cetak }}</h1>
                                </div>
                            </div>
                        </main>
                    </div>
                @endforeach
            @endif
        </div>
    </body>
