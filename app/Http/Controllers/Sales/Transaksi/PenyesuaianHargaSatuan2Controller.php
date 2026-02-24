<?php

namespace App\Http\Controllers\Sales\Transaksi;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\HakAksesController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenyesuaianHargaSatuan2Controller extends Controller
{
    public function index()
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('Sales');
        $result = (new HakAksesController)->HakAksesFitur('Penyesuaian Harga Satuan 2');
        $user = trim(Auth::user()->NomorUser);
        if ($result > 0) {
            return view('Sales.Transaksi.PenyesuaianHargaSatuan2.index', compact('access', 'user'));
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
        //0000008851, 0000008848 4626.3250
        $listIdPengiriman = explode(', ', $request->idPengiriman);
        $resultData = [];
        try {
            foreach ($listIdPengiriman as $idPengiriman) {
                $data = DB::connection('ConnSales')->select('EXEC SP_4384_PENYESUAIAN_HARGA_SATUAN2 @IDPengiriman = ?', [$idPengiriman]);
                if (!empty($data)) {

                    $resultData[] = [
                        'IDPengiriman' => $idPengiriman,
                        'DifferenceMade' => $data[0]->DifferenceMade,
                        'HargaSatuan2' => $data[0]->HargaSatuan2
                    ];
                }
            }
            return response()->json(['success' => $resultData]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        //
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
