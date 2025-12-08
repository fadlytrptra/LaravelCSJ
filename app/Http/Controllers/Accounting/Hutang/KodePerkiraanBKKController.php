<?php

namespace App\Http\Controllers\Accounting\Hutang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\HakAksesController;
use Exception;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Auth;

class KodePerkiraanBKKController extends Controller
{
    public function index()
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('Accounting');
        return view('Accounting.Hutang.KodePerkiraanBKK', compact('access'));
    }

    public function getIdBKKKdPrk($BlnThn)
    {
        $tabel = DB::connection('ConnAccounting')->select('exec [SP_1273_ACC_UDT_BKK_KDKIRA] @Kode = ?, @BlnThn = ?', [2, $BlnThn]);
        return response()->json($tabel);
    }
    public function getIdBKKKdPrk2($BlnThn)
    {
        $tabel = DB::connection('ConnAccounting')->select('exec [SP_1273_ACC_UDT_BKK_KDKIRA] @Kode = ?, @BlnThn = ?', [3, $BlnThn]);
        return response()->json($tabel);
    }

    public function getTabelRincianBKK($idBKK)
    {
        $tabel = DB::connection('ConnAccounting')->select('exec [SP_1273_ACC_LIST_BKK_KDKIRA] @IdBKK = ?', [$idBKK]);
        // return datatables($tabel)->make(true);
        return response()->json($tabel);
    }

    //Show the form for creating a new resource.
    public function create()
    {
        //
    }

    //Store a newly created resource in storage.
    public function store(Request $request)
    {
        $idDetail = $request->idDetail;
        $idKodePerkiraan = $request->idKodePerkiraan;
        try {
            DB::connection('ConnAccounting')->statement("EXEC SP_1273_ACC_UDT_BKK_KDKIRA_DETAIL @IdDetailBayar = ?, @Perkiraan = ?", [
                $idDetail,
                $idKodePerkiraan,
            ]);

            return response()->json([
                'message' => 'Data sudah diKOREKSI!!..'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    //Display the specified resource.
    public function show($cr)
    {
        //
    }

    // Show the form for editing the specified resource.
    public function edit($id)
    {
        //
    }

    //Update the specified resource in storage.
    public function update(Request $request)
    {
        // dd($request->all());
        $idDetail = $request->idDetail;
        $idKodePerkiraan = $request->idKodePerkiraan;

        DB::connection('ConnAccounting')->statement('exec [SP_1273_ACC_UDT_BKK_KDKIRA_DETAIL]
            @IdDetailBayar = ?,
            @Perkiraan = ?', [
            $idDetail,
            $idKodePerkiraan
        ]);

        return redirect()->back()->with('success', 'Data sudah diKOREKSI');
    }

    //Remove the specified resource from storage.
    public function destroy($id)
    {
        //
    }
}
