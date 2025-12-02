<?php

namespace App\Http\Controllers\Beli\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HakAksesController;
use DB;

class BatalTransferController extends Controller
{
    public function index()
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('Beli');
        $result = (new HakAksesController)->HakAksesFitur('Batal Transfer');
        if ($result > 0) {
            return view('Beli.Master.BatalTransfer', compact('access'));
        } else {
            abort(404);
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
    public function update(Request $request, $id)
    {
        //
    }
    public function batal(Request $request)
    {
        $No_Terima = $request->input("No_Terima");
        if($No_Terima != null){
            try {
                $batalTransfer = DB::connection('CON')->select('exec sp_proses_batal_transfer @No_Terima = ?',[$No_Terima]);
                return Response()->json($batalTransfer);
            } catch (\Throwable $Error) {
                return Response()->json($Error);
            }
        }
    }
    //Remove the specified resource from storage.
    public function destroy($id)
    {
        //
    }
}
