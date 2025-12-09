<?php

namespace App\Http\Controllers\Accounting\Piutang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\HakAksesController;


class UpdateKursBKMController extends Controller
{
    public function index()
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('Accounting');
        return view('Accounting.Piutang.UpdateKursBKM', compact('access'));
    }

    public function getTabelPelunasan($bulan, $tahun)
    {
        //dd($bulan, $tahun);
        $tabel =  DB::connection('ConnAccounting')->select('exec [SP_5298_ACC_LIST_BKM_TUNAI] @bln = ?, @thn = ?', [$bulan, $tahun]);
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
    public function show($id, Request $request)
    {
        if ($id === 'getDataPelunasan') {
            $bulan = $request->input('bulan');
            $tahun = $request->input('tahun');

            $lunasResults = DB::connection('ConnAccounting')
                ->select('exec SP_5298_ACC_LIST_BKM_TUNAI @bln = ?, @thn = ?', [$bulan, $tahun]);
            // dd($lunasResults);
            $response = [];
            $index = 0;

            if (!empty($lunasResults)) {
                foreach ($lunasResults as $data) {
                    $index++;
                    $response[] = [
                        'Tgl_Input' => \Carbon\Carbon::parse($data->Tgl_Input)->format('m/d/Y'),
                        'Id_BKM' => $data->Id_BKM,
                        'Id_bank' => $data->Id_bank,
                        'Nilai_Pelunasan' => number_format($data->Nilai_Pelunasan, 2, '.', ','),
                        'RincianPelunasan' => number_format($data->RincianPelunasan, 2, '.', ','),
                        'KodePerkiraan' => $data->KodePerkiraan,
                        'Uraian' => $data->Uraian,
                        'Id_Pelunasan' => $data->Id_Pelunasan
                    ];
                }
                return datatables($response)->make(true);
            } else {
                return datatables([])->make(true);
            }
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
        if ($id === 'proses') {
            $idPelunasan = $request->input('idPelunasan');
            $idbkm = $request->input('idbkm');
            $kursRupiah = $request->input('kursRupiah');

            // dd($request->all());

            DB::connection('ConnAccounting')->statement(
                'exec [SP_5298_ACC_UPDATE_KURS_BKM]
                @idPel = ?,
                @idBKM = ?,
                @kurs = ?',
                [
                    $idPelunasan,
                    $idbkm,
                    $kursRupiah
                ]
            );

            return response()->json(['success' => 'Data Tersimpan'], 200);
        }
    }

    //Remove the specified resource from storage.
    public function destroy($id)
    {
        //
    }
}
