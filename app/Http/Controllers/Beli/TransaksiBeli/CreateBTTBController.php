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
        //
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
        } else if ($id == 'getDataSPPB') {
            $idDivisi = $request->input('idDivisi');
            try {
                $dataSPPB = DB::connection('ConnPurchase')->select('exec SP_1273_PRG_SLC_NOMOR_SPPB @KdDivisi = ?', [$idDivisi]);
                return response()->json(['dataSPPB' => $dataSPPB], 200);
            } catch (Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        } else if ($id == 'getDataDetailSPPB') {
            $idDivisi = $request->input('idDivisi');
            $noSPPB = $request->input('noSPPB');
            try {
                $dataListBarang = DB::connection('ConnPurchase')->select('exec SP_1273_PRG_SLC_DATA_SPPB @KdDivisi = ?, @NoSPPB = ?', [$idDivisi, $noSPPB]);
                $noTrans = (string) $dataListBarang[0]->No_trans;
                $dataListTerima = DB::connection('ConnPurchase')->select('exec SP_1273_PRG_SLC_TERIMA_BARANG @NoTrans = ?', [$noTrans]);
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
        //
    }

    //Remove the specified resource from storage.
    public function destroy($id)
    {
        //
    }
}
