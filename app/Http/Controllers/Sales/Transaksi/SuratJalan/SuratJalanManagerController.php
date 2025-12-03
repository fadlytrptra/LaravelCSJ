<?php

namespace App\Http\Controllers\Sales\Transaksi\SuratJalan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\HakAksesController;

class SuratJalanManagerController extends Controller
{
    //Display a listing of the resource.
    public function index()
    {
        $data = db::connection('ConnSales')->select('exec SP_1486_SLS_LIST_HEADERKIRIM_BLMACC');
        $access = (new HakAksesController)->HakAksesFiturMaster('Sales');
        // dd($LoadHeaderPengiriman);
        return view('Sales.Transaksi.SuratJalan.AccPermohonan', compact('data','access'));
    }

    //Show the form for creating a new resource.
    public function create()
    {
        //
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        //
    }

    //Display the specified resource.
    public function show($id)
    {
        $data = db::connection('ConnSales')->select('exec SP_1486_SLS_LIST_DETAILKIRIM_BLMACC @IDHeaderKirim = ?', [$id]);
        return response()->json($data);
    }

    //Show the form for editing the specified resource.
    public function edit($id)
    {
        //
    }

    //Update the specified resource in storage.
    public function update(Request $request)
    {
        $user = auth::user()->NomorUser;
        $nomorSJs = $request->nomorSJs;
        // dd($request->all());
        for ($i = 0; $i < count($nomorSJs); $i++) {
            db::connection('ConnSales')->statement('exec SP_1486_SLS_ACC_PENGIRIMAN @IdManager = ?, @IdHeaderKirim = ?', [$user, $nomorSJs[$i]]);
        }
        return redirect()->back()->with('success', 'Surat Jalan yang Dipilih Sudah Disetujui!');
    }

    //Remove the specified resource from storage.
    public function destroy($id)
    {
        //
    }
}
