<?php

namespace App\Http\Controllers\EDP;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\HakAksesController;
use DB;

class MaintenanceUserWebController extends Controller
{
    public function index()
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('EDP');
        $result = (new HakAksesController)->HakAksesFitur('Maintenance User');

        if ($result > 0) {
            return view('EDP.Master.UserWeb.index', compact('access'));
        } else {
            abort(403);
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $jenisStore = $request->jenisStore;
        if ($jenisStore == 'tambahTTD') {
            $gambarTTD = $request->file('gambarTTD');
            $gambarTTDBase64 = base64_encode(file_get_contents($gambarTTD->getRealPath()));
            $idUser = $request->idUser;
            try {
                DB::connection('ConnEDP')->statement(
                    'exec SP_4384_EDP_MaintenanceUserWeb @XKode = ?, @XIdUser = ?, @XFotoTtd = ?',
                    [
                        1,
                        $idUser,
                        $gambarTTD ? $gambarTTDBase64 : null
                    ]
                );
                return response()->json(['message' => 'Data Berhasil DiTambahkan!', "data" => $idUser]);
            } catch (Exception $Ex) {
                return response()->json($Ex->getMessage());
            }
        } else {
            return response()->json(['error' => 'Invalid request'], 404);
        }
    }

    public function show($id)
    {
        if ($id == 'getDataUser') {
            $dataUser = DB::connection('ConnEDP')->select('exec SP_4384_EDP_MaintenanceUserWeb @XKode = ?', [0]);
            return datatables($dataUser)->make(true);
        } else {
            return response()->json(['error' => 'Invalid request'], 404);
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
