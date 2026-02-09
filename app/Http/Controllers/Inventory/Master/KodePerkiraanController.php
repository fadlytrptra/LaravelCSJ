<?php

namespace App\Http\Controllers\Inventory\Master;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HakAksesController;
use Exception;

class KodePerkiraanController extends Controller
{
    //Display a listing of the resource.
    public function index()
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('Inventory'); //tidak perlu menu di navbar
        return view('Inventory.Master.KodePerkiraan.index', compact('access'));
    }

    //Show the form for creating a new resource.
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $jenisStore = $request->jenisStore;
        if ($jenisStore == 'TambahKP') {
            try {
                $keterangan = $request->keterangan;
                $no_kp = $request->no_kp;

                DB::connection('ConnInventory')->statement('exec SP_4384_Maintenance_KodePerkiraan
                    @XKode = ?, @XKeterangan = ?, @XNoKodePerkiraan = ?',
                    [
                        3,
                        $keterangan,
                        $no_kp
                    ]
                );
                return response()->json(['message' => 'Data Berhasil Ditambahkan!']);

            } catch (Exception $Ex) {
                return response()->json($Ex->getMessage());
            }
        } else if ($jenisStore == 'EditKP') {
            try {
                $keterangan = $request->keterangan;
                $no_kp = $request->no_kp;

                DB::connection('ConnInventory')->statement('exec SP_4384_Maintenance_KodePerkiraan
                    @XKode = ?, @XKeterangan = ?, @XNoKodePerkiraan = ?',
                    [
                        4,
                        $keterangan,
                        $no_kp
                    ]
                );
                return response()->json(['message' => 'Data Berhasil Diedit!']);

            } catch (Exception $Ex) {
                return response()->json($Ex->getMessage());
            }
        } else if ($jenisStore == 'deleteKP') {
            try {
                $no_kp = $request->no_kp;

                DB::connection('ConnInventory')->statement('exec SP_4384_Maintenance_KodePerkiraan
                    @XKode = ?, @XNoKodePerkiraan = ?',
                    [
                        5,
                        $no_kp,
                    ]
                );
                return response()->json(['message' => 'Data Berhasil Dihapus!']);

            } catch (Exception $Ex) {
                return response()->json($Ex->getMessage());
            }
        } else {
            return response()->json('Invalid request', 405);
        }
    }

    public function show($id, Request $request)
    {
        if ($id == 'getAllKodePerkiraan') {
            $listKodePerkiraan = DB::connection('ConnInventory')->select('exec SP_4384_Maintenance_KodePerkiraan @XKode = ?', [1]);
            return datatables($listKodePerkiraan)->make(true);
        } else if ($id == 'getDetailPerkiraan') {
            $NoKodePerkiraan = $request->no_kp;
            $dataKodePerkiraan = DB::connection('ConnInventory')->select('exec SP_4384_Maintenance_KodePerkiraan @XKode = ?, @XNoKodePerkiraan = ?', [2, $NoKodePerkiraan]);
            return response()->json($dataKodePerkiraan, 200);
        } else {
            return response()->json('Invalid request', 405);
        }
    }

    // Show the form for editing the specified resource.
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
    public function destroy(Request $request)
    {
        //
    }
}
