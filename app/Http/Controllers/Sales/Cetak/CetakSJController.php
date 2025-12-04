<?php

namespace App\Http\Controllers\Sales\Cetak;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;
use App\Http\Controllers\HakAksesController;

class CetakSJController extends Controller
{
    //Display a listing of the resource.
    public function index()
    {
        // $customer = db::connection('sqlsrv2')->select('exec SP_1486_SLS_LIST_ALL_CUSTOMER @Kode = ?', [1]);
        // dd($customer);
        $access = (new HakAksesController)->HakAksesFiturMaster('Sales');
        return view('Sales.Report.CetakSJ', compact('access'));
    }

    public function getSuratJalan($tanggal)
    {
        $data = db::connection('ConnSales')->select('exec SP_1486_SLS_LIST_CETAK_SJ @TglKirim = ?, @XKode = ?', [$tanggal, 1]);
        return response()->json($data);
    }
    public function getDataCetakSuratJalan($tanggal, $nosj, $jenissj)
    {
        // $data = db::connection('ConnInventory')->select('select * from VW_PRG_1486_SLS_CETAK_SJ where tglkirim = ? and IDPengiriman = ?',[$request->TanggalSJ, $request->NomorSJ]);
        if ($jenissj == 'suratjalanppn') {
            $data = db::connection('ConnSales')->select('select * from VW_PRG_1486_SLS_CETAK_SJ where tglkirim = ? and IDPengiriman = ?', [$tanggal, $nosj]);
            return response()->json($data);
        } elseif ($jenissj == 'suratjalanexport') {
            $data = db::connection('ConnSales')->select('select * from VW_PRG_1486_SLS_CETAK_SJ where tglkirim = ? and IDPengiriman = ?', [$tanggal, $nosj]);
            return response()->json($data);
        } else {
            //error handling untuk jenis sj selain suratjalanexport dan suratjalanppn
            return response()->json('Jenis SJ ' . $jenissj . ' belum disetting');
        }
    }

    //Show the form for creating a new resource.
    public function create()
    {
        //
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {

    }

    //Display the specified resource.
    public function show($id)
    {
        //
    }

    //Show the form for editing the specified resource.
    public function edit($id)
    {
        //
    }

    //Update the specified resource in storage.
    public function update($id)
    {

    }

    //Remove the specified resource from storage.
    public function destroy($id)
    {
        //
    }
}
