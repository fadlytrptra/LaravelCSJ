<?php

namespace App\Http\Controllers\Accounting\Piutang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BatalBKMTransitorisController extends Controller
{
    public function index()
    {
        $data = 'Accounting';
        return view('Accounting.Piutang.BatalBKMTransitoris', compact('data'));
    }

    public function getIdBKM3($bulanTahun)
    {
        $tabel =  DB::connection('ConnAccounting')->select('exec [SP_1273_ACC_LIST_IDBKK_BTLBKK] @Kode = ?, @BlnThn = ?', [3, $bulanTahun]);
        return response()->json($tabel);
    }
    public function getIdBKM4($bulanTahun)
    {
        $tabel =  DB::connection('ConnAccounting')->select('exec [SP_1273_ACC_LIST_IDBKK_BTLBKK] @Kode = ?, @BlnThn = ?', [4, $bulanTahun]);
        return response()->json($tabel);
    }

    function getDataBKM($idBKM)
    {
        //dd("masuk");
        $tabel =  DB::connection('ConnAccounting')->select('exec [SP_1273_ACC_LIST_BKK_BTLBKK] @BKK = ?, @kd = ?', [$idBKM, 1]);
        return response()->json($tabel);

    }

    public function cekBatalBKK($idBKM)
    {
        //dd('Ada');
        $penyesuaian = db::connection('ConnAccounting')->select('exec [SP_1273_ACC_CHECK_BTLBKK] @BKK = ?', [$idBKM]);
        // dd($penyesuaian);
        return response()->json($penyesuaian);
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
        //
    }

    //Remove the specified resource from storage.
    public function hapus($idBKMSelect, $alasan)
    {
        //dd("masuk");
        DB::connection('ConnAccounting')->statement('exec [SP_1273_ACC_BATAL_BKM]
        @BKM = ?,
        @Alasan = ?,
        @User = ?', [
            $idBKMSelect,
            $alasan,
            null
        ]);
        return redirect()->back()->with('success', 'Data BKK sudah diBATALkan!!');
    }
}
