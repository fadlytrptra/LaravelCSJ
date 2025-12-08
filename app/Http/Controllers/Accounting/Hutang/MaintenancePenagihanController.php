<?php

namespace App\Http\Controllers\Accounting\Hutang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\HakAksesController;
use Exception;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Auth;

class MaintenancePenagihanController extends Controller
{
    public function index()
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('Accounting');
        return view('Accounting.Hutang.MaintenancePenagihan', compact('access'));
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
    public function show(Request $request, $id)
    {
        if ($id == 'getSupplier') {
            $supplierDetails = DB::connection('ConnAccounting')
                ->select('exec SP_1273_ACC_LIST_SUPPLIER');
            $response = [];
            foreach ($supplierDetails as $row) {
                $response[] = [
                    'NM_SUP' => trim($row->NM_SUP),
                    'NO_SUP' => trim($row->NO_SUP),
                ];
            }
            return datatables($response)->make(true);
        } else if ($id == 'getDisplay') {
            try {
                $no_sup = trim($request->input('supplier_1'));
                // dd($no_sup);
                $query = DB::connection('ConnAccounting')
                    ->select('exec SP_5409_ACC_PENAGIHAN_PEMBELIAN ?, ?', [1, $no_sup]);
                // dd($query);
                $response = [];
                foreach ($query as $row) {
                    $response[] = [
                        'No_BTTB' => $row->No_BTTB,
                        'No_SuratJalan' => $row->No_SuratJalan ?? '',
                        'No_PO' => $row->No_PO,
                        'SubTotal' => number_format($row->SubTotal, 2, '.', ','),
                        'JumPPN' => intval($row->JumPPN),
                        'PPN_Price' => number_format($row->PPN_Price, 2, '.', ','),
                        'TotalPrice' => number_format($row->TotalPrice, 2, '.', ','),
                        'IdMataUang' => $row->IdMataUang,
                        'Nama_MataUang' => $row->Nama_MataUang,
                        'Kurs_Rp' => intval($row->Kurs_Rp),
                    ];
                }
                return datatables($response)->make(true);
            } catch (Exception $e) {
                return response()->json(['error' => $e->getMessage()]);
            }
        } else if ($id == 'getBTTB') {
            $noBTTB = $request->input('No_BTTB');
            $response = [];

            try {
                $result = DB::connection('ConnAccounting')->select('exec SP_5409_ACC_PENAGIHAN_PEMBELIAN @Kode = ?, @noBTTB = ?', [2, $noBTTB]);

                foreach ($result as $row) {
                    $response[] = [
                        'No_BTTB' => $row->No_BTTB,
                        'No_terima' => $row->No_terima,
                        'Kd_brg' => $row->Kd_brg,
                        'nama_brg' => $row->nama_brg,
                        'Qty_Terima' => number_format($row->Qty_Terima, 2, '.', ','),
                        'hrg_trm' => number_format($row->hrg_trm, 2, '.', ','),
                        'Hrg_sub_bttb' => number_format($row->Hrg_sub_bttb, 2, '.', ','),
                        'JumPPN' => intval($row->JumPPN),
                        'hrg_ppn' => number_format($row->hrg_ppn, 2, '.', ','),
                        'Harga_Terbayar' => number_format($row->Harga_Terbayar, 2, '.', ','),
                        'IdMataUang' => $row->IdMataUang,
                        'Nama_MataUang' => $row->Nama_MataUang,
                        'Kurs_Rp' => number_format($row->Kurs_Rp, 2, '.', ','),
                    ];
                }
            } catch (Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }

            return datatables($response)->make(true);
        } else if ($id == 'getJenisPPH') {
            $pphDetails = DB::connection('ConnAccounting')
                ->select('exec SP_5409_ACC_PENAGIHAN_PEMBELIAN @Kode = ?', [3]);
            // dd($pphDetails);
            $response = [];
            foreach ($pphDetails as $row) {
                $response[] = [
                    'IdPPH' => trim($row->IdPPH),
                    'JenisPPH' => trim($row->JenisPPH),
                ];
            }
            return datatables($response)->make(true);
        } else if ($id == 'getPPH') {
            $pphDetails = DB::connection('ConnAccounting')
                ->select('exec SP_5409_ACC_PENAGIHAN_PEMBELIAN @Kode = ?', [4]);
            // dd($pphDetails);
            $response = [];
            foreach ($pphDetails as $row) {
                $response[] = [
                    'IdPersen' => trim($row->IdPersen),
                    'Persen' => trim($row->Persen),
                ];
            }
            return datatables($response)->make(true);
        } else if ($id == 'getPenagihan') {
            $supplier_1 = $request->input('supplier_1');
            // dd($supplier_1);
            $result = DB::connection('ConnAccounting')
                ->select('exec SP_1273_ACC_LIST_TT_IDTT_1 @IdSupplier = ?', [$supplier_1]);
            // dd($result);
            $response = [];
            foreach ($result as $row) {
                $response[] = [
                    'Nm_Sup' => trim($row->Nm_Sup),
                    'Id_Penagihan' => trim($row->Id_Penagihan),
                ];
            }
            return datatables($response)->make(true);
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
        //
    }

    //Remove the specified resource from storage.
    public function destroy($id)
    {
        //
    }
}
