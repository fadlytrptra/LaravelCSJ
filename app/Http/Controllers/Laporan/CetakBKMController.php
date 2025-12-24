<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Http\Controllers\HakAksesController;
use Illuminate\Http\Request;
use Exception;
use Auth;
use DB;

class CetakBKMController extends Controller
{
    public function index()
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('Accounting');
        $result = (new HakAksesController)->HakAksesFitur('Cetak BKM');
        if ($result > 0) {
            return view('Laporan.Accounting.CetakBKM.index', compact('access'));
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
        if ($id === 'getDataBKM') {
            $jenisCetak = $request->jenisCetak;
            $tanggal = $request->tanggal;

            if ($jenisCetak == 'Penagihan') {
                $dataBKM = DB::connection('ConnAccounting')->select('exec SP_1273_PRG_LIST_BKM_TAGIH_PERTGL @tgl1 = ?, @tgl2 = ?', [$tanggal, $tanggal]);
            } else if ($jenisCetak == 'Cash Advance') {
                $dataBKM = DB::connection('ConnAccounting')->select('exec SP_1273_PRG_LIST_BKM_CASHADV_1_PERTGL @tgl1 = ?, @tgl2 = ?', [$tanggal, $tanggal]);
            } else if ($jenisCetak == 'DP Pelunasan') {
                $dataBKM = DB::connection('ConnAccounting')->select('exec SP_1273_PRG_LIST_BKM_DP_PERTGL @tgl1 = ?, @tgl2 = ?', [$tanggal, $tanggal]);
            }
            // $data_BKM = [];
            // foreach ($dataBKM as $detail_BKM) {
            //     $data_BKM[] = [
            //         'Id_BKM' => $detail_BKM->Id_BKM,
            //         'Nilai_Pelunasan' => $detail_BKM->Nilai_Pelunasan
            //     ];
            // }
            return datatables($dataBKM)->make(true);
        } else if ($id == 'printBKM') {
            $idbkm = $request->idbkm;
            $jenisCetak = $request->jenisCetak;
            $tanggal = $request->tanggal;
            try {
                if ($jenisCetak == 'Penagihan') {
                    $dataBKM = DB::connection('ConnAccounting')->select('SELECT * FROM VW_PRG_5298_ACC_CETAK_BKM_TAGIH WHERE Id_BKM = ?', [$idbkm]);
                    if (count($dataBKM) > 0) {
                        DB::connection('ConnAccounting')->statement('exec SP_1273_PRG_UPDATE_TGLCETAK_BKM @IdBKM = ?', [$idbkm]);
                        return view('Laporan.Accounting.CetakBKM.cetakPenagihan', compact('dataBKM', 'idbkm', 'jenisCetak'));
                    } else {
                        return redirect()->back()
                            ->with('error', 'Data BKM tidak ditemukan');
                    }
                } else if ($jenisCetak == 'Cash Advance') {
                    $dataBKM = DB::connection('ConnAccounting')->select('SELECT * FROM VW_PRG_5298_ACC_CETAK_BKM_NOTAGIH_1 WHERE Id_BKM = ?', [$idbkm]);
                    if (count($dataBKM) > 0) {
                        DB::connection('ConnAccounting')->statement('exec SP_1273_PRG_UPDATE_TGLCETAK_BKM @IdBKM = ?', [$idbkm]);
                        return view('Laporan.Accounting.CetakBKM.cetakCashAdvance', compact('dataBKM', 'idbkm', 'jenisCetak'));
                    } else {
                        return redirect()->back()
                            ->with('error', 'Data BKM tidak ditemukan');
                    }
                } else if ($jenisCetak == 'DP Pelunasan') {
                    $dataBKM = DB::connection('ConnAccounting')->select('SELECT * FROM VW_PRG_5298_ACC_CETAK_BKM_DP WHERE Id_BKM = ?', [$idbkm]);
                    if (count($dataBKM) > 0) {
                        DB::connection('ConnAccounting')->statement('exec SP_1273_PRG_UPDATE_TGLCETAK_BKM @IdBKM = ?', [$idbkm]);
                        return view('Laporan.Accounting.CetakBKM.cetakDPPelunasan', compact('dataBKM', 'idbkm', 'jenisCetak'));
                    } else {
                        return redirect()->back()
                            ->with('error', 'Data BKM tidak ditemukan');
                    }
                }

            } catch (Exception $e) {
                abort(404, $e->getMessage());
            }
        } else {
            return response()->json(['error' => 'Invalid request'], 400);
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
