<?php

namespace App\Http\Controllers\Accounting\Hutang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MPIsiDetailController extends Controller
{
    public function index()
    {
        $divisi =  DB::connection('ConnAccounting')->select('exec [SP_1273_ACC_LIST_TT_DIVISI]');
        return view('Accounting.Hutang.MPIsiDetail', compact(['divisi']));
    }

    function getTabelPO($noPO)
    {
        $tabel =  DB::connection('ConnAccounting')->select('exec [SP_1273_ACC_LIST_TT_TERIMABRG_BELI] @SPPB = ?', [$noPO]);
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
    public function destroy($id)
    {
        //
    }

}
