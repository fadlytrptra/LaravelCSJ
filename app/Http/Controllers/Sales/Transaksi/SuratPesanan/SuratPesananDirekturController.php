<?php

namespace App\Http\Controllers\Sales\Transaksi\SuratPesanan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\HakAksesController;

class SuratPesananDirekturController extends Controller
{
    //Display a listing of the resource.
    public function index()
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('Sales');
        $result = (new HakAksesController)->HakAksesFitur('Acc Direktur');
        $user = trim(Auth::user()->NomorUser);
        if ($result > 0) {
            return view('Sales.Transaksi.SuratPesanan.AccDirektur.AccDirektur', compact('access', 'user'));
        } else {
            abort(403);
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
        $jenisProses = $request->jenisProses;
        if ($jenisProses == 'ACC Direktur') {
            $suratPesananIds = $request->suratPesananIds;
            $user = trim(Auth::user()->NomorUser);
            foreach ($suratPesananIds as $idSP) {
                DB::connection('ConnSales')
                    ->statement('exec SP_1273_PRG_ACC_SURATPESANAN_DIREKTUR @IDSuratPesanan = ?, @AccDir = ?', [
                        $idSP,
                        $user
                    ]);
            }
            return response()->json(['message' => 'Surat Pesanan ' . implode(', ', $suratPesananIds) . ' berhasil di-ACC oleh Direktur.'], 200);
        } else {
            return response()->json(['error' => 'Invalid request'], 404);
        }
    }

    //Display the specified resource.
    public function show($id, Request $request)
    {
        if ($id == 'getDataJenisSP') {
            $dataJenisSP = DB::connection('ConnSales')->select('exec SP_1273_PRG_LIST_SP @Kode = ?', [1]);
            return datatables($dataJenisSP)->make(true);
        } else if ($id == 'getDataSuratPesanan') {
            $idJenisSP = $request->idJenisSP;
            $dataSuratPesanan = DB::connection('ConnSales')
                ->select('exec SP_1273_PRG_LIST_SP_ACC_DIREKTUR @IDJnsSuratPesanan = ?, @XKode = ?', [$idJenisSP, 1]);
            return response()->json($dataSuratPesanan, 200);
        } else if ($id == 'getDetailSP') {
            $no_spValue = $request->no_spValue;
            $dataSuratPesanan = DB::connection('ConnSales')
                ->select('exec SP_1273_PRG_LIST_DETAIL_PESANAN_ACC_DIREKTUR @IDSuratPesanan = ?', [$no_spValue]);
            return response()->json($dataSuratPesanan, 200);
        } else {
            return response()->json(['error' => 'Invalid request'], 404);
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
