<?php

namespace App\Http\Controllers\Sales\Transaksi\SuratJalan;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\HakAksesController;
use DB;
use Auth;

class BatalSuratJalanController extends Controller
{
    public function index()
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('Sales');
        return view('Sales.Transaksi.SuratJalan.BatalSJ', compact('access'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $idCust = $request->input('idCustomer');
        $noSP = $request->input('surat_pesanan');
        $ket = $request->input('alasan_batal');
        $idUser = Auth::user()->NomorUser;
        $idJnsSJ = $request->input('idJenisSuratJalan');
        $noSJ = $request->input('surat_jalan');
        try {
            DB::connection('ConnSales')->statement('exec SP_5409_SLS_BATAL_SJ @kode =?,
	        @idCust =?,
	        @noSP =?,
	        @ket =?,
	        @idUser =?,
	        @idJnsSJ =?,
	        @noSJ =?',
                [
                    1,
                    $idCust,
                    $noSP,
                    $ket,
                    $idUser,
                    $idJnsSJ,
                    $noSJ,
                ]
            );
            return response()->json(['success' => 'Data dengan nomor SJ: ' . $noSJ . ' Sudah disimpan!']);
        } catch (Exception $ex) {
            return response()->json(['error' => $ex->getMessage()]);
        }
    }

    public function show($id, Request $request)
    {
        try {
            if ($id == 'getAllCustomer') {
                $data = DB::connection('ConnSales')->select('exec SP_1486_SLS_LIST_ALL_CUSTOMER @Kode = ?', [1]);
                $response = [];
                foreach ($data as $dataList) {
                    $response[] = [
                        'IDCust' => $dataList->IDCust,
                        'NamaCust' => $dataList->NamaCust,
                    ];
                }
                return datatables($response)->make(true);
            } else if ($id == 'getSPBasedOnCustomer') {
                $data = DB::connection('ConnSales')->select('exec SP_1486_SLS_LIST_SP_DO @IdCust = ?', [$request->input('IdCust')]);
                $response = [];
                foreach ($data as $dataList) {
                    $response[] = [
                        'IDSuratPesanan' => $dataList->IDSuratPesanan,
                    ];
                }
                return datatables($response)->make(true);
            } else if ($id == 'getJenisSJ') {
                $data = DB::connection('ConnSales')->select('exec SP_1486_SLS_LIST_JENIS_SJ');
                $response = [];
                foreach ($data as $dataList) {
                    $response[] = [
                        'NamaJnsSuratJalan' => $dataList->NamaJnsSuratJalan,
                        'IDJnsSuratJalan' => $dataList->IDJnsSuratJalan,
                    ];
                }
                return datatables($response)->make(true);
            }
        } catch (Exception $ex) {
            return response()->json(['error' => $ex->getMessage()]);
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
