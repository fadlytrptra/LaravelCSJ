<?php

namespace App\Http\Controllers\Beli\TransaksiBeli;

use App\Http\Controllers\Controller;
use App\Http\Controllers\HakAksesController;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use League\CommonMark\Extension\SmartPunct\EllipsesParser;
use Log;


class CreateBTTBController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('Beli');
        $result = (new HakAksesController)->HakAksesFitur('Create BTTB');
        if ($result > 0) {
            return view('Beli.TransaksiBeli.BTTB.CreateBTTB', compact('access'));
        } else {
            abort(403);
        }
    }

    //Show the form for creating a new resource.
    public function create()
    {
        //
    }

    //Store a newly created resource in storage.
    public function store(Request $request)
    {
        $jenisProses = $request->jenisProses;
        $datang = $request->datang;
        $qty = $request->qty;
        $QtyTerima = $request->QtyTerima;
        $SatuanTerima = $request->SatuanTerima;
        $faktur = $request->faktur;
        $no_sup = $request->no_sup;
        $min_ord = $request->min_ord;
        $hrg_trm = $request->hrg_trm;
        $disc_trm = $request->disc_trm;
        $ppn_trm = $request->ppn_trm;
        $waktu = $request->waktu;
        $no_ket = $request->no_ket;
        $ket_trm = $request->ket_trm;
        $no_sppb = $request->no_sppb;
        $no_trans = $request->no_trans;
        $kd_div = $request->kd_div;
        $IdMataUang = $request->IdMataUang;
        $Kurs = $request->Kurs;
        $TglFaktur = $request->TglFaktur;
        $NoSJ = $request->NoSJ;
        $hrg_murni = $request->hrg_murni;
        $hrg_murni_rp = $request->hrg_murni_rp;
        $hrg_disc = $request->hrg_disc;
        $hrg_disc_rp = $request->hrg_disc_rp;
        $hrg_nego = $request->hrg_nego;
        $hrg_nego_rp = $request->hrg_nego_rp;
        $hrg_ppn = $request->hrg_ppn;
        $hrg_ppn_rp = $request->hrg_ppn_rp;
        $Jenis_Dokumen = $request->Jenis_Dokumen;
        $No_Seri_Barang = $request->No_Seri_Barang;
        $No_PIB_KRR = $request->No_PIB_KRR;
        $No_PIB_External = $request->No_PIB_External;
        $Tgl_PIB_External = $request->Tgl_PIB_External;
        $No_Registration_PIB = $request->No_Registration_PIB;
        $Tgl_Registration_PIB = $request->Tgl_Registration_PIB;
        $No_BL = $request->No_BL;
        $Tgl_BL = $request->Tgl_BL;
        $No_Kontrak = $request->No_Kontrak;
        $Tgl_Kontrak = $request->Tgl_Kontrak;
        $No_SPPB_BC = $request->No_SPPB_BC;
        $Tgl_SPPB_BC = $request->Tgl_SPPB_BC;
        if ($jenisProses == 'isiBTTB') {
            try {
                $Counter = DB::connection('ConnPurchase')->select('exec SP_1273_PRG_LIST_COUNTER');
                $NewCounter = $Counter[0]->YTERIMA + 1;
                $NoTerima = str_pad($NewCounter, 10, "0", STR_PAD_LEFT);

                DB::connection('ConnPurchase')->statement('exec SP_1273_PRG_INSERT_YTERIMA_IMPOR
                @no_terima_1 = ?,
                @datang_2 = ?,
                @qty_3 = ?,
                @QtyTerima = ?,
                @SatuanTerima = ?,
                @faktur_4 = ?,
                @no_sup_5 = ?,
                @min_ord_6 = ?,
                @hrg_trm_7 = ?,
                @disc_trm_8 = ?,
                @ppn_trm_9 = ?,
                @waktu_10 = ?,
                @no_ket_11 = ?,
                @ket_trm_12 = ?,
                @no_sppb_13 = ?,
                @no_trans_14 = ?,
                @kd_div_15 = ?,
                @IdMataUang = ?,
                @Kurs = ?,
                @TglFaktur = ?,
                @NoSJ = ?,
                @hrg_murni = ?,
                @hrg_murni_rp = ?,
                @hrg_disc = ?,
                @hrg_disc_rp = ?,
                @hrg_nego = ?,
                @hrg_nego_rp = ?,
                @hrg_ppn = ?,
                @hrg_ppn_rp = ?,
                @Jenis_Dokumen = ?,
                @No_Seri_Barang = ?,
                @No_PIB_KRR = ?,
                @No_PIB_External = ?,
                @Tgl_PIB_External = ?,
                @No_Registration_PIB = ?,
                @Tgl_Registration_PIB = ?,
                @No_BL = ?,
                @Tgl_BL = ?,
                @No_Kontrak = ?,
                @Tgl_Kontrak = ?,
                @No_SPPB_BC = ?,
                @Tgl_SPPB_BC = ?',
                    [
                        $NoTerima,
                        $datang,
                        $qty,
                        $QtyTerima,
                        $SatuanTerima,
                        $faktur,
                        $no_sup,
                        $min_ord,
                        $hrg_trm,
                        $disc_trm,
                        $ppn_trm,
                        $waktu,
                        $no_ket,
                        $ket_trm,
                        $no_sppb,
                        $no_trans,
                        $kd_div,
                        $IdMataUang,
                        $Kurs,
                        $TglFaktur,
                        $NoSJ,
                        $hrg_murni,
                        $hrg_murni_rp,
                        $hrg_disc,
                        $hrg_disc_rp,
                        $hrg_nego,
                        $hrg_nego_rp,
                        $hrg_ppn,
                        $hrg_ppn_rp,
                        $Jenis_Dokumen,
                        $No_Seri_Barang,
                        $No_PIB_KRR,
                        $No_PIB_External,
                        $Tgl_PIB_External,
                        $No_Registration_PIB,
                        $Tgl_Registration_PIB,
                        $No_BL,
                        $Tgl_BL,
                        $No_Kontrak,
                        $Tgl_Kontrak,
                        $No_SPPB_BC,
                        $Tgl_SPPB_BC,
                    ]
                );

                DB::connection('ConnPurchase')->statement('exec SP_1273_PRG_UPDATE_COUNTER_TERIMA
                @yterima_1 = ?', [
                    intval($NewCounter)
                ]);

                return response()->json(['success' => true], 200);
            } catch (Exception $e) {
                return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
            }
        } else if ($jenisProses == 'koreksiBTTB') {
            $no_terima = $request->no_terima;
            $qty_koreksi = $request->qty_koreksi;
            $QtyTerimakoreksi = $request->QtyTerimakoreksi;

            DB::connection('ConnPurchase')->statement(
        'exec SP_1273_PRG_UPDATE_YTERIMA_IMPOR
            @no_terima_1 = ?,
            @tgl_terima = ?,
            @qty_2 = ?,
            @QtyTerima = ?,
            @qty_2koreksi = ?,
            @QtyTerimakoreksi = ?,
            @SatuanTerima = ?,
            @faktur_3 = ?,
            @hrg_trm_4 = ?,
            @disc_trm_5 = ?,
            @ppn_trm_6 = ?,
            @min_ord_7 = ?,
            @no_sup_8 = ?,
            @waktu_9 = ?,
            @no_ket_10 = ?,
            @ket_trm_11 = ?,
            @IdMataUang = ?,
            @Kurs = ?,
            @TglFaktur = ?,
            @NoSJ = ?,
            @hrg_murni = ?,
            @hrg_murni_rp = ?,
            @hrg_disc = ?,
            @hrg_disc_rp = ?,
            @hrg_nego = ?,
            @hrg_nego_rp = ?,
            @hrg_ppn = ?,
            @hrg_ppn_rp = ?,
            @Jenis_Dokumen = ?,
            @No_Seri_Barang = ?,
            @No_PIB_KRR = ?,
            @No_PIB_External = ?,
            @Tgl_PIB_External = ?,
            @No_Registration_PIB = ?,
            @Tgl_Registration_PIB = ?,
            @No_BL = ?,
            @Tgl_BL = ?,
            @No_Kontrak = ?,
            @Tgl_Kontrak = ?,
            @No_SPPB_BC = ?,
            @Tgl_SPPB_BC = ?,
            @no_trans_14 = ?',
        [
            $no_terima,              // 1
            $datang,                 // 2
            $qty,                    // 3
            $QtyTerima,              // 4
            $qty_koreksi,            // 5
            $QtyTerimakoreksi,       // 6
            $SatuanTerima,           // 7
            $faktur,                 // 8
            $hrg_trm,                // 9
            $disc_trm,               // 10
            $ppn_trm,                // 11
            $min_ord,                // 12
            $no_sup,                 // 13
            $waktu,                  // 14
            $no_ket,                 // 15
            $ket_trm,                // 16
            $IdMataUang,             // 17
            $Kurs,                   // 18
            $TglFaktur,              // 19
            $NoSJ,                   // 20
            $hrg_murni,              // 21
            $hrg_murni_rp,           // 22
            $hrg_disc,               // 23
            $hrg_disc_rp,            // 24
            $hrg_nego,               // 25
            $hrg_nego_rp,            // 26
            $hrg_ppn,                // 27
            $hrg_ppn_rp,             // 28
            $Jenis_Dokumen,          // 29
            $No_Seri_Barang,         // 30
            $No_PIB_KRR,             // 31
            $No_PIB_External,        // 32
            $Tgl_PIB_External,       // 33
            $No_Registration_PIB,    // 34
            $Tgl_Registration_PIB,   // 35
            $No_BL,                  // 36
            $Tgl_BL,                 // 37
            $No_Kontrak,             // 38
            $Tgl_Kontrak,            // 39
            $No_SPPB_BC,             // 40
            $Tgl_SPPB_BC,            // 41
            $no_trans                // 42
        ]
    );

        }
    }

    public function show(Request $request, $id)
    {
        if ($id == 'getDivisi') {
            try {
                $divisi = DB::connection('ConnPurchase')->select('exec SP_1273_Prg_LIST_DIVISI');
                return response()->json($divisi);
            } catch (Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        } else if ($id == 'getMataUang') {
            try {
                $mataUang = DB::connection('ConnAccounting')->select('exec SP_1273_PBL_LIST_MATA_UANG');
                return response()->json($mataUang);
            } catch (Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        } else if ($id == 'getDataDetailTerima') {
            try {
                $noTerima = $request->noTerima;
                $detailTerima = DB::connection('ConnPurchase')->select('exec SP_1273_PRG_LIST_PIB @NoTerima = ?', [$noTerima]);
                return response()->json($detailTerima);
            } catch (Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        } else if ($id == 'getDataSPPB') {
            $idDivisi = $request->input('idDivisi');
            try {
                $dataSPPB = DB::connection('ConnPurchase')->select('exec SP_1273_PRG_SLC_NOMOR_SPPB @KdDivisi = ?', [$idDivisi]);
                return response()->json(['dataSPPB' => $dataSPPB], 200);
            } catch (Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        } else if ($id == 'getDataSPPBKoreksi') {
            $idDivisi = $request->idDivisi;

            try {
                // PAKAI SP YANG SAMA
                $dataSPPB = DB::connection('ConnPurchase')->select(
                    'exec SP_1273_PRG_SLC_NOMOR_SPPB @XKode = ?, @KdDivisi = ?',
                    [0, $idDivisi]
                );

                return response()->json([
                    'dataSPPB' => $dataSPPB
                ], 200);

            } catch (Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        }  else if ($id == 'cekSPPBKoreksi') {
            $idDivisi = $request->idDivisi;
            $noSPPB = $request->noSPPB;

            try {
                $data = DB::connection('ConnPurchase')->select(
                    'exec SP_1273_PRG_SLC_NOMOR_SPPB_KOREKSI
                    @KdDivisi = ?, @NoSPPB = ?',
                    [$idDivisi, $noSPPB]
                );

                if (count($data) === 0) {
                    return response()->json([
                        'valid' => false,
                        'message' => 'SPPB tidak valid untuk koreksi'
                    ]);
                }

                return response()->json([
                    'valid' => true,
                    'data' => $data[0]
                ]);

            } catch (Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }  else if ($id == 'getDataDetailSPPB') {
            $idDivisi = $request->input('idDivisi');
            $noSPPB = $request->input('noSPPB');
            try {
                $dataListBarang = DB::connection('ConnPurchase')->select('exec SP_1273_PRG_SLC_DATA_SPPB @KdDivisi = ?, @NoSPPB = ?', [$idDivisi, $noSPPB]);
                $dataListTerima = DB::connection('ConnPurchase')->select('exec SP_1273_PRG_SLC_TERIMA_BARANG @XKode = ?, @XNoSPPB = ?', [1, $noSPPB]);
                return response()->json(['ListBarang' => $dataListBarang, 'ListTerima' => $dataListTerima], 200);
            } catch (Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        } else if ($id == 'loadHarga') {
            $NoTrans = $request->input('NoTrans');
            try {
                $dataHarga = DB::connection('ConnPurchase')->select('exec SP_1273_PRG_LIST_HARGA @NoTrans = ?', [$NoTrans]);
                return response()->json(['dataHarga' => $dataHarga], 200);
            } catch (Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        } else if ($id == 'getListSPPBKoreksiKurs') {
            try {
                $noSPPB = $request->NoSPPB;
                $ada = DB::connection('ConnPurchase')->select('exec SP_1273_PRG_LIST_SPPB_HARGA_TERIMA @Kode = ?, @NoSPPB = ?', [2, $noSPPB]);
                if ($ada[0]->Ada < 1) {
                    return response()->json(['error' => (string) 'Nomor Faktur ' . $noSPPB . ' tidak ditemukan']);
                }
                $dataSPPB = DB::connection('ConnPurchase')->select('exec SP_1273_PRG_LIST_SPPB_HARGA_TERIMA @Kode = ?, @NoSPPB = ?', [3, $noSPPB]);
                return response()->json($dataSPPB);
            } catch (Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        } else {
            return response()->json(['error' => 'Invalid request'], 400);
        }
    }

    //Show the form for editing the specified resource.
    public function edit($id)
    {
        //
    }

    //Update the specified resource in storage.
    public function update(Request $request, $id)
    {
        if ($id == 'UpdateFlag') {
            $no_trans_1 = $request->no_trans_1;
            $sFlag = $request->sFlag;
            try {
                DB::connection('ConnPurchase')->statement('exec SP_1273_PRG_UPDATE_FLAG @no_trans_1 = ?, @sFlag = ?', [$no_trans_1, $sFlag]);
                return response()->json(['success' => true]);
            } catch (Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        } else if ($id == 'ProsesKoreksiKurs') {
            $NoSPPB = $request->NoSPPB;
            $Kurs = $request->Kurs;
            $KodeBarang = $request->KodeBarang;
            try {
                DB::connection('ConnPurchase')->statement('exec SP_1273_PRG_UPDATE_HARGA_YTERIMA @Kode = ?, @NoSPPB = ?, @Kurs = ?', [1, $NoSPPB, $Kurs]);
                $ada = DB::connection('ConnSales')->select('exec SP_1273_PRG_LIST_HARGASATUAN @Kode = ?, @KodeBarang = ?', [1, $KodeBarang]);
                if ($ada[0]->Ada > 0) {
                    $qtyJual = DB::connection('ConnPurchase')->select('exec SP_1273_PRG_CEK_QTY_JUAL @Kode = ?, @KodeBarang = ?', [1, $KodeBarang])[0]->QtyJual;
                    $saldoInv = DB::connection('ConnInventory')->select('exec SP_1273_PRG_CEK_SALDO @Kode = ?, @KodeBarang = ?', [1, $KodeBarang])[0]->Saldo;
                    dd($qtyJual, $saldoInv);
                    if ($qtyJual <> $saldoInv) {
                        return response()->json(['error' => 'Hubungi EDP untuk cek harga satuan qtyJual <> saldoInv']);
                    } else {
                        $qtyTritier = DB::connection('ConnSales')->select('exec SP_1273_PRG_LIST_HARGASATUAN @Kode = ?, @KodeBarang = ?', [2, $KodeBarang])[0]->QtyTritier;
                        $qtyJual2 = DB::connection('ConnSales')->select('exec SP_1273_PRG_CEK_QTY_JUAL @Kode = ?, @KodeBarang = ?', [2, $KodeBarang])[0]->QtyJual2;
                        if ($qtyTritier <> $qtyJual2) {
                            return response()->json(['error' => 'Hubungi EDP untuk cek harga satuan qtyJual2 <> qtyTritier']);
                        } else {
                            $listSales = DB::connection('ConnSales')->select('exec SP_1273_PRG_LIST_HARGASATUAN @Kode = ?, @KodeBarang = ?', [3, $KodeBarang]);
                            $listJual = DB::connection('ConnSales')->select('exec SP_1273_PRG_LIST_SPPB_KURS_TERIMA @Kode = ?, @KodeBarang = ?', [3, $KodeBarang]);
                            for ($i = 0; $i < count($listSales); $i++) {
                                $qtyJual1 = $listSales[$i]->QtyTritier;
                                $totalHargaBeli1 = 0.0;
                                $HargaBeli2 = 0.0;
                                $noPIBBeli = (string) "";
                                for ($j = 0; $j < count($listJual); $j++) {
                                    if ($qtyJual1 > $listJual[$j]->Qty_Jual2) {
                                        $qtyJual3 = $listJual[$j]->Qty_Jual2;
                                        $hargaBeli = $listJual[$j]->Hrg_trm;
                                        $kursBeli = $listJual[$j]->Kurs_Rp;
                                        $totalHargaBeli = $qtyJual3 * $kursBeli * $hargaBeli;
                                        $totalHargaBeli1 += $totalHargaBeli;
                                        $qtyJual1 -= $listJual[$j]->Qty_Jual2;
                                        $noPIBBeli = (string) $noPIBBeli . trim($listJual[$j]->No_PIB_External) . "(" . $qtyJual3 . "), ";
                                        $listJual[$j]->Qty_Jual2 = 0;
                                    } else if ($qtyJual1 < $listJual[$j]->Qty_Jual2) {
                                        $qtyJual3 = $qtyJual1;
                                        $hargaBeli = $listJual[$j]->Hrg_trm;
                                        $kursBeli = $listJual[$j]->Kurs_Rp;
                                        $totalHargaBeli = $qtyJual3 * $kursBeli * $hargaBeli;
                                        $totalHargaBeli1 += $totalHargaBeli;
                                        $noPIBBeli = (string) $noPIBBeli . trim($listJual[$j]->No_PIB_External) . "(" . $qtyJual3 . ")";
                                        $listJual[$j]->Qty_Jual2 -= $qtyJual1;
                                        $qtyJual1 = 0;
                                        break;
                                    } else if ($qtyJual1 == $listJual[$j]->Qty_Jual2) {
                                        $qtyJual3 = $listJual[$j]->Qty_Jual2;
                                        $hargaBeli = $listJual[$j]->Hrg_trm;
                                        $kursBeli = $listJual[$j]->Kurs_Rp;
                                        $totalHargaBeli = $qtyJual3 * $kursBeli * $hargaBeli;
                                        $totalHargaBeli1 += $totalHargaBeli;
                                        $noPIBBeli = (string) $noPIBBeli . trim($listJual[$j]->No_PIB_External) . "(" . $qtyJual3 . ")";
                                        $qtyJual1 = 0;
                                        $listJual[$j]->Qty_Jual2 = 0;
                                        break;
                                    }
                                }
                                $HargaBeli2 = $totalHargaBeli1 / $listSales[$i]->QtyTritier;
                                DB::connection('ConnSales')->statement(
                                    'exec SP_1273_PRG_UDT_PENJUALAN
                                        @IdTrans = ?,
                                        @Harga = ?,
                                        @NoPIBBeli = ?',
                                    [
                                        $listSales[$i]->IdTransTmp,
                                        $HargaBeli2,
                                        $noPIBBeli
                                    ]
                                );
                                for ($j = 0; $j < count($listJual); $j++) {
                                    DB::connection('ConnPurchase')->statement(
                                        'exec SP_1273_PRG_UPDATE_HARGA_YTERIMA
                                        @Kode = ?,
                                        @NoTerima = ?,
                                        @Qty = ?',
                                        [
                                            5,
                                            $listJual[$j]->No_terima,
                                            $listJual[$j]->Qty_Jual2
                                        ]
                                    );
                                }
                            }
                            return response()->json(['success' => (string) 'Proses Koreksi Kurs Selesai.']);
                        }
                    }
                } else {
                    return response()->json(['success' => (string) 'Tidak ada data hargasatuan2 yang 0 menurut kode barang: ' . $KodeBarang]);
                }
                return response()->json(['success' => true]);
            } catch (Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }

        }
    }

    //Remove the specified resource from storage.
    public function destroy($id)
    {
        //
    }
}
