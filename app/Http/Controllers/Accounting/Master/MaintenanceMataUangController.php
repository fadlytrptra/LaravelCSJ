<?php

namespace App\Http\Controllers\Accounting\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\HakAksesController;
use Exception;

class MaintenanceMataUangController extends Controller
{
    //Display a listing of the resource.
    public function index()
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('Accounting');
        $maintenanceMataUang = DB::connection('ConnAccounting')->select('exec [SP_1273_ACC_LIST_UANG_ALL_TMATAUANG]');
        // dd($maintenanceMataUang);
        return view('Accounting.Master.MaintenanceMataUang', compact(['maintenanceMataUang', 'access']));
    }

    //Show the form for creating a new resource.
    public function create()
    {
        //
    }

    //Store a newly created resource in storage.
    public function store(Request $request)
    {
        try {
            $NamaMataUang = $request->NamaMataUang;
            $Symbol = $request->Symbol;
            $IdMataUangBC = $request->IdMataUangBC;

            DB::connection('ConnAccounting')->statement('exec [SP_1273_ACC_UDT_UANG_TMATAUANG]
            @Kode = ?,
            @Nama_MataUang = ?,
            @Symbol = ?,
            @IdMataUangBC = ?',
                [
                    1,
                    $NamaMataUang,
                    $Symbol,
                    $IdMataUangBC
                ]
            );
            return response()->json(['success' => 'Data Mata Uang berhasil ditambahkan!']);
        } catch (Exception $ex) {
            return response()->json(['error' => $ex->getMessage()]);
        }
    }

    //Display the specified resource.
    public function show($id, Request $request)
    {
        try {
            if ($id == 'getAllMataUang') {
                $listMataUang = DB::connection('ConnAccounting')->select('exec [SP_1273_ACC_LIST_UANG_ALL_TMATAUANG]'); //Get All data Bank where aktif == 'Y'
                return datatables($listMataUang)->make(true);
            } else if ($id == 'getCertainMataUang') {
                $data = DB::connection('ConnAccounting')->select('exec [SP_1273_ACC_LIST_UANG_ID_TMATAUANG] @IdMataUang = ?', [$request->idMataUang]);
                return response()->json($data);
            }
        } catch (Exception $ex) {
            return response()->json(['error' => $ex->getMessage()]);
        }
    }

    // Show the form for editing the specified resource.
    public function edit($id)
    {
        //
    }

    //Update the specified resource in storage.
    public function update(Request $request)
    {
        try {
            $IdMataUang = $request->IdMataUang;
            $IdMataUangBC = $request->IdMataUangBC;
            $NamaMataUang = $request->NamaMataUang;
            $Symbol = $request->Symbol;

            DB::connection('ConnAccounting')->statement('exec [SP_1273_ACC_UDT_UANG_TMATAUANG]
            @Kode = ?,
            @IdMataUang = ?,
            @IdMataUangBC = ?,
            @Nama_MataUang = ?,
            @Symbol = ?',
                [
                    2,
                    $IdMataUang,
                    $IdMataUangBC,
                    $NamaMataUang,
                    $Symbol
                ]
            );
            return response()->json(['success' => 'Data Mata Uang berhasil diubah!']);
        } catch (Exception $ex) {
            return response()->json(['error' => $ex->getMessage()]);
        }
    }

    //Remove the specified resource from storage.
    public function destroy($idMataUang)
    {
        try {
            DB::connection('ConnAccounting')->statement('exec [SP_1273_ACC_UDT_UANG_TMATAUANG]
            @Kode = ?,
            @IdMataUang = ?', [
                3,
                $idMataUang
            ]);
            return response()->json(['success' => 'Data Mata Uang berhasil dihapus!']);
        } catch (Exception $ex) {
            return response()->json(['error' => $ex->getMessage()]);
        }
    }
}
