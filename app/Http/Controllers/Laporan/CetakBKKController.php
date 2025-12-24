<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Http\Controllers\HakAksesController;
use Illuminate\Http\Request;
use Exception;
use Auth;
use DB;

class CetakBKKController extends Controller
{
    public function index()
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('Accounting');
        $result = (new HakAksesController)->HakAksesFitur('Cetak BKM');
        if ($result > 0) {
            return view('Laporan.Accounting.CetakBKK.index', compact('access'));
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
        if ($id === 'getDataBKK') {
            $jenisCetak = $request->jenisCetak;
            $tanggal = $request->tanggal;

            if ($jenisCetak == 'DP Pelunasan') {
                $dataBKK = DB::connection('ConnAccounting')->select('exec SP_1273_PRG_LIST_BKK_DP_PERTGL @tgl1 = ?, @tgl2 = ?', [$tanggal, $tanggal]);
            }

            return datatables($dataBKK)->make(true);
        } else if ($id == 'printBKK') {
            $idbkk = $request->idbkk;
            $jenisCetak = $request->jenisCetak;
            $tanggal = $request->tanggal;
            try {
                if ($jenisCetak == 'DP Pelunasan') {
                    $dataBKK = DB::connection('ConnAccounting')->select('SELECT * FROM VW_PRG_5298_ACC_CETAK_BKK_DP WHERE Id_BKK = ?', [$idbkk]);
                }
                if (count($dataBKK) > 0) {
                    DB::connection('ConnAccounting')->statement('exec SP_1273_PRG_UPDATE_TGLCETAK_BKk @IdBKK = ?', [$idbkk]);
                    return view('Laporan.Accounting.CetakBKK.cetak', compact('dataBKK', 'idbkk', 'jenisCetak'));
                } else {
                    return redirect()->back()->with('error', 'Data tidak ditemukan');
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
