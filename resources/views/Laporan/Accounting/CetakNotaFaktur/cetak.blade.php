    @php
        // $tanggalInput = date('d F Y', timestamp: strtotime($dataBKK[0]->Tgl_Input));
        // $tanggalHariIni = date('d F Y');
        // dd($dataCetak);
        $total = 0;
    @endphp

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1" />
        <title>Cetak Faktur Penjualan {{ $idPenagihan }}</title>
        <style>
            body {
                font-family: Arial, Helvetica, sans-serif;
                color: #111;
            }

            @media print {
                .no-print {
                    display: none;
                }
            }
        </style>
    </head>

    <body>
        <div style="height: 27cm; overflow: overflow;">
            <div style="left: 16.5cm;top: 3cm; position: absolute;font-size:12px;">{{ $idPenagihan }}</div>
            <div style="left: 13.5cm;top: 4cm; position: absolute;font-size:12px;">No Seri Faktur Pajak:
                {{ $dataCetak[0]->NoSeri_FakturPajak }}</div>
            <div style="left: 6cm;top: 9cm; position: absolute;font-size:12px;font-weight: bold;">
                {{ $dataCetak[0]->NamaNPWP }}</div>
            <div style="left: 6cm;top: 9.6cm; position: absolute;font-size:10px;">{{ $dataCetak[0]->AlamatNPWP }}</div>
            <div style="left: 6cm;top: 10.2cm; position: absolute;font-size:12px;font-weight: bold;">
                {{ implode(' ', str_split(str_pad($dataCetak[0]->NPWP, 16, '0', STR_PAD_LEFT), 4)) }}
            </div>
            @foreach ($dataCetak as $index => $item)
                @php
                    $top = 12 + $index * 0.6;
                    $total += (float) $item->Jml * (float) $item->HargaSatuan;
                @endphp
                <div style="position:absolute; top:{{ $top }}cm; left:0;">
                    <span style="position:absolute; left:1cm; font-size:10px;">{{ $index + 1 }}</span>
                    <span style="position:absolute; left:2cm; font-size:10px;width: 8.5cm;">{{ $item->NamaType }}</span>
                    <span style="position:absolute; left:10.5cm; font-size:10px;width: 3cm;">
                        {{ number_format($item->Jml, 2, '.', ',') }} {{ $item->Satuan }}
                    </span>
                    <span style="position:absolute; left:13.5cm; font-size:10px;width: 3.5cm;">
                        {{ $item->Symbol2 }} {{ number_format($item->HargaSatuan, 2, '.', ',') }}
                    </span>
                    <span style="position:absolute; left:17.2cm; font-size:10px;width: 3.5cm;">
                        {{ $item->Symbol2 }}
                        {{ number_format((float) $item->Jml * (float) $item->HargaSatuan, 2, '.', ',') }}
                    </span>
                </div>
            @endforeach
            <div style="position:absolute; top:{{ $top + 0.6 }}cm; left:0;">
                <span style="position:absolute; left:2.5cm; font-size:10px;width: 3.5cm;">
                    P O
                    {{ $dataCetak[0]->NO_PO }}
                </span>
            </div>
            <div style="position:absolute; top:{{ $top + 4.5 }}cm; left:0;">
                <span style="position:absolute; left:2.5cm; font-size:10px;width: 5cm;">
                    Pembayaran Harap Ditranfer ke :<br />
                    @if ($bank == 'BCA1')
                        Bank BCA Cab. Galaxy, Surabaya<br />
                        a/c: 788.083.3639<br />
                        a/n: PT. CAHAYA SANTOSO JAYA
                    @elseif ($bank == 'OCBC')
                        Bank OCBC Cab. Pemuda, Surabaya<br />
                        a/c: 788.083.3639<br />
                        a/n: PT. CAHAYA SANTOSO JAYA
                    @endif
                </span>
            </div>
            @php
                $nilaiUM = (float) $dataCetak[0]->Nilai_UM ?? 0;
                $ppn = (float) $dataCetak[0]->PersenPPN;
                if ($ppn == 0.12) {
                    $dpp = (($total - $nilaiUM) * 11) / 12;
                } else {
                    $dpp = $total - $nilaiUM;
                }
                $pajak = round($dpp * $ppn, 2);
                $terbayar = $pajak + $total;
            @endphp
            <div style="left: 17.2cm;top: 20.5cm; position: absolute;font-size:12px;">
                {{ $dataCetak[0]->Symbol2 }}
                {{ number_format($total, 2, '.', ',') }}
            </div>
            <div style="left: 17.2cm;top: 21.1cm; position: absolute;font-size:12px;">
                {{ $dataCetak[0]->Symbol2 }}
                {{ number_format($nilaiUM, 2, '.', ',') }}
            </div>
            <div style="left: 5cm;top: 21.7cm; position: absolute;font-size:12px;">
                Nilai Lain
            </div>
            <div style="left: 17.2cm;top: 21.7cm; position: absolute;font-size:12px;">
                {{ $dataCetak[0]->Symbol2 }}
                {{ number_format($dpp, 2, '.', ',') }}
            </div>
            <div style="left: 2cm;top: 22.3cm; position: absolute;font-size:12px;">12%</div>
            <div style="left: 17.2cm;top: 22.3cm; position: absolute;font-size:12px;">
                {{ $dataCetak[0]->Symbol2 }}
                {{ number_format($pajak, 2, '.', ',') }}
            </div>
            <div style="left: 2cm;top: 22.9cm; position: absolute;font-size:12px;">
                {{ $dataCetak[0]->Terbilang }}
            </div>
            <div style="left: 17.2cm;top: 22.9cm; position: absolute;font-size:12px;">
                {{ $dataCetak[0]->Symbol2 }}
                {{ number_format($terbayar, 2, '.', ',') }}
            </div>
            <div style="left: 13.2cm;top: 24.5cm; position: absolute;font-size:12px;">
                Sidoarjo
            </div>
            <div style="left: 16.5cm;top: 24.5cm; position: absolute;font-size:12px;">
                {{ date('d') }}
            </div>
            <div style="left: 19.7cm;top: 24.5cm; position: absolute;font-size:12px;">
                {{ date('y') }}
            </div>
            <div style="left: 14.5cm;top: 26.6cm; position: absolute;font-size:12px;">
                {{ $ttd }}
            </div>
        </div>
        <div class="no-print" style="color: red;font-weight: bold;">
            <label>Saat print harap pastikan sudah sesuai dengan settingan berikut: </label>
            <br>
            <label>-Margin: None</label>
            <br>
            <label>-Scale: Default</label>
        </div>
    </body>
