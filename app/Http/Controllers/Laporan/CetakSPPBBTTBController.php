<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Http\Controllers\HakAksesController;
use Illuminate\Http\Request;
use Exception;
use Auth;
use DB;

class CetakSPPBBTTBController extends Controller
{
    public function index()
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('Laporan');
        $result = (new HakAksesController)->HakAksesFitur('Cetak SPPB / BTTB');
        if ($result > 0) {
            return view('Laporan.Purchase.CetakSPPBBTTB.index', compact('access'));
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
        //
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
