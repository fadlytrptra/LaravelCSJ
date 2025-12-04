<?php

namespace App\Http\Controllers\Sales\Cetak;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\HakAksesController;
use Exception;

class CetakBonKasController extends Controller
{
    public function index()
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('Sales');
        return view('Sales.Report.CetakBonKas', compact('access'));
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
        if ($id == 'getNomorSJ') {
            // mendapatkan daftar nomor surat jalan
            $tglKirim = $request->input('tglKirim');
            $nomorsj = DB::connection('ConnSales')->select('exec SP_1486_SLS_LIST_CETAK_SJ @TglKirim = ?', [$tglKirim]);
            return datatables($nomorsj)->make(true);
        } else if ($id == 'getDataBonKas') {
            // mendapatkan data bon kas
            $nomorsj = $request->input('nomorsj');
            try {
                $dataBonKas = DB::connection('ConnSales')->table('VW_PRG_1486_SLS_CETAK_SJ')->where('IdPengiriman', '=', $nomorsj)->get();
                return response()->json(['success' => 'Data found', 'dataBonKas' => $dataBonKas], 200);
            } catch (Exception $e) {
                return response()->json(['error' => 'Data not found', 'message' => $e->getMessage()], 500);
            }
        } else {
            response()->json(['error' => 'Invalid ID'], 400);
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
