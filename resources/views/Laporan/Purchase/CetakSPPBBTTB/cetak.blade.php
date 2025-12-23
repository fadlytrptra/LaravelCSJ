    @if ($jenisCetak == 'SPPB')
        @php
            $tanggalSPPB = date('m/d/Y', strtotime($dataCetak[0]->tanggal_sppb));
            $sumTotalHarga = 0;
        @endphp
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
                                <td style="padding: 4px; font-size: 10px;border:1px solid #000;">{{ $index + 1 }}</td>
                                <td style="padding: 4px; font-size: 10px;border:1px solid #000;">
                                    {{ number_format($item->quantity, 2, '.', ',') }}</td>
                                <td style="padding: 4px; font-size: 10px;border:1px solid #000;">{{ trim($item->Nama_satuan) }}</td>
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
            @endif
        </div>
    </body>
