<?php

namespace App\Http\Controllers\Beli\Transaksi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HakAksesController;
use Exception;
use Auth;
use DB;

class RevisiPOController extends Controller
{
    public function index()
    {
        $kdUser = trim(Auth::user()->NomorUser);
        $access = (new HakAksesController)->HakAksesFiturMaster('Beli');
        $result = (new HakAksesController)->HakAksesFitur('Revisi PO');

        return view('Beli.Transaksi.RevisiPO.List', compact('access'));
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        // proses revisi masuk controller final approve
    }
    public function show($id, Request $request)
    {
        if ($id == 'getAllSPPB') {
            $kdUser = trim(Auth::user()->NomorUser);
            $data = DB::connection('ConnPurchase')->select(
                'EXEC dbo.SP_1273_PRG_Select_AccPermohonan @XKode = ?, @kd_user = ?',
                [0, $kdUser]
            );
            return datatables(source: $data)->make(true);
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
