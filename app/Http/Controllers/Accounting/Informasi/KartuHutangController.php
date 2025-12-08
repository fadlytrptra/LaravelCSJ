<?php

namespace App\Http\Controllers\Accounting\Informasi;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HakAksesController;

class KartuHutangController extends Controller
{
    public function KartuHutang()
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('Accounting');

        return view('Accounting.Informasi.KartuHutang', compact('access'));
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
    public function show($id, Request $request)
    {
        if ($id === 'getSupplier') {
            $divisi = DB::connection('ConnAccounting')->select('exec SP_1273_ACC_LIST_SUPPLIER');
            $data_divisi = [];
            foreach ($divisi as $detail_divisi) {
                $data_divisi[] = [
                    'NM_SUP' => $detail_divisi->NM_SUP,
                    'NO_SUP' => $detail_divisi->NO_SUP,
                ];
            }
            return datatables($divisi)->make(true);
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
        if ($id === 'perbaiki') {
            $tanggal_awal = $request->input('tanggal_awal');
            $id_supplier = $request->input('id_supplier');

            try {
                DB::connection('ConnAccounting')
                    ->statement('exec [SP_1003_ACC_PROSES_RUSMIATI]
                @tanggal_awal = ?,
                @id_supplier = ?', [
                        $tanggal_awal,
                        $id_supplier,
                    ]);

                return response()->json(['success' => 'Data sudah diSIMPAN'], 200);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Data gagal diSIMPAN: ' . $e->getMessage()], 500);
            }
        }

        // proises
        else if ($id === 'proses') {
            $IdSupp = $request->input('IdSupp');
            $Tgl1 = $request->input('Tgl1');
            $Tgl2 = $request->input('Tgl2');

            try {
                DB::connection('ConnAccounting')
                    ->statement('exec [Sp_1273_ACC_HISTORY_HUTANG]
                @IdSupp = ?,
                @Tgl2 = ?,
                @Tgl1 = ?', [
                        $IdSupp,
                        $Tgl2,
                        $Tgl1,
                    ]);

                return response()->json(['success' => 'Data sudah diSIMPAN'], 200);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Data gagal diSIMPAN: ' . $e->getMessage()], 500);
            }
        }
    }

    //Remove the specified resource from storage.
    public function destroy($id)
    {
        //
    }
}
