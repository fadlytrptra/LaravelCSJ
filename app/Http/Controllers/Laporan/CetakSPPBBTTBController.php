<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Http\Controllers\HakAksesController;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Exception;
use Auth;
use DB;

class CetakSPPBBTTBController extends Controller
{
    public function index()
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('Beli');
        $result = (new HakAksesController)->HakAksesFitur('Cetak SPPB / BTTB');
        $user = trim(Auth::user()->NomorUser);
        if ($result > 0) {
            return view('Laporan.Purchase.CetakSPPBBTTB.index', compact('access', 'user'));
        } else {
            abort(403);
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $jenisStore = $request->jenisStore;
        if ($jenisStore == 'Email') {
            $noSPPB = $request->noSPPB;
            $idDivisi = $request->idDivisi;
            $deliveryTerm = $request->deliveryTerm;
            $packing = $request->packing;
            $shippingMark = $request->shippingMark;
            $deliveryTime = $request->deliveryTime;
            $documentsRequired = $request->documentsRequired;
            $partialShipmentTransit = $request->partialShipmentTransit;
            $portOfLoading = $request->portOfLoading;
            $portOfDischarge = $request->portOfDischarge;
            $otherConditions = $request->otherConditions;
            $payments = $request->payments;
            $informasiCetak =
                $deliveryTerm . ' | ' . $packing . ' | ' . $shippingMark . ' | ' .
                $deliveryTime . ' | ' . $documentsRequired . ' | ' .
                $partialShipmentTransit . ' | ' . $portOfLoading . ' | ' .
                $portOfDischarge . ' | ' . $otherConditions . ' | ' . $payments;
            DB::connection('ConnPurchase')->statement('exec SP_1273_PRG_PROSES_CETAK_PO @Kode = ?, @NoSppb = ?, @InformasiCetak = ?', [5, $noSPPB, $informasiCetak]);
            $dataCetak = DB::connection('ConnPurchase')->select('SELECT * FROM VW_PRG_1273_SPPB_NEW WHERE kode_divisi = ? AND nomor_sppb = ?', [$idDivisi, $noSPPB]);
            dd($dataCetak);

        } else {
            return response()->json('Request Invalid', 400);
        }
    }


    public function show($id, Request $request)
    {
        if ($id == 'getDataDivisi') {
            $dataDivisi = DB::connection('ConnPurchase')->select('exec SP_1273_PRG_LIST_DIVISI');

            return datatables($dataDivisi)->make(true);
        } else if ($id == 'getDataSPPB') {
            $kd_div_1 = $request->kd_div_1;
            $dataSPPB = DB::connection('ConnPurchase')->select('exec SP_1273_PRG_LIST_DIVISI_CETAK_PO @kd_div_1 = ?', [$kd_div_1]);

            return datatables($dataSPPB)->make(true);
        } else if ($id == 'getDataTerima') {
            $NoSPPB = $request->NoSPPB;
            $KdDivisi = $request->KdDivisi;
            $dataTerima = DB::connection('ConnPurchase')->select('exec SP_1273_PRG_DATA_BTTB @NoSPPB = ?, @KdDivisi = ?', [$NoSPPB, $KdDivisi]);

            return datatables($dataTerima)->make(true);
        } else if ($id == 'print') {
            $divisi = $request->divisi;
            $jenisCetak = $request->jenisCetak;
            $sppb = $request->sppb;

            if ($jenisCetak == 'SPPB') {
                $ada = DB::connection('ConnPurchase')->select('exec SP_1273_PRG_PROSES_CETAK_PO @Kode = ?, @KdDiv = ?, @NoSppb = ?', [2, $divisi, $sppb]);
                if ($ada[0]->Ada == 0) {
                    DB::connection('ConnPurchase')->statement('exec SP_1273_PRG_PROSES_CETAK_PO @Kode = ?, @KdDiv = ?, @NoSppb = ?', [1, $divisi, $sppb]);
                } else {
                    DB::connection('ConnPurchase')->statement('exec SP_1273_PRG_PROSES_CETAK_PO @Kode = ?, @KdDiv = ?, @NoSppb = ?, @Alasan = \'Cetak Ulang\'', [4, $divisi, $sppb]);
                }
                $dataCetak = DB::connection('ConnPurchase')->select('SELECT * FROM VW_PRG_1273_SPPB_NEW WHERE kode_divisi = ? AND nomor_sppb = ?', [$divisi, $sppb]);
            } else if ($jenisCetak == 'BTTB') {
                $noTerima = $request->noTerima;
                if ($noTerima) {
                    $dataCetak = DB::connection('ConnPurchase')->select('SELECT * FROM View_terima_new WHERE nomor_terima = ?', [$noTerima]);
                } else {
                    return redirect()->back()->with('error', 'Data tidak ditemukan');
                }
            } else if ($jenisCetak == 'SPPBBaru') {
                $ada = DB::connection('ConnPurchase')->select('exec SP_1273_PRG_PROSES_CETAK_PO @Kode = ?, @KdDiv = ?, @NoSppb = ?', [2, $divisi, $sppb]);
                if ($ada[0]->Ada == 0) {
                    DB::connection('ConnPurchase')->statement('exec SP_1273_PRG_PROSES_CETAK_PO @Kode = ?, @KdDiv = ?, @NoSppb = ?', [1, $divisi, $sppb]);
                } else {
                    DB::connection('ConnPurchase')->statement('exec SP_1273_PRG_PROSES_CETAK_PO @Kode = ?, @KdDiv = ?, @NoSppb = ?, @Alasan = \'Cetak Ulang\'', [4, $divisi, $sppb]);
                }
                $dataCetak = DB::connection('ConnPurchase')->select('SELECT * FROM VW_PRG_1273_SPPB_NEW WHERE kode_divisi = ? AND nomor_sppb = ?', [$divisi, $sppb]);
            }
            if (count($dataCetak) > 0) {
                return view('Laporan.Purchase.CetakSPPBBTTB.cetak', compact('dataCetak', 'jenisCetak'));
            } else {
                return redirect()->back()->with('error', 'Data tidak ditemukan');
            }
        } else {
            return response()->json(['error' => 'Invalid request'], 404);
        }
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
