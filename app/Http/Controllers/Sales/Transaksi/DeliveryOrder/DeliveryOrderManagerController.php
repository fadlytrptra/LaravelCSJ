<?php

namespace App\Http\Controllers\Sales\Transaksi\DeliveryOrder;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Redirector;
use App\Http\Controllers\HakAksesController;

class DeliveryOrderManagerController extends Controller
{
    //Display a listing of the resource.
    public function index()
    {
        $data = DB::connection('ConnSales')->select('exec SP_4384_SLS_LIST_DO_ACC_WEB');
        // dd($data);
        $access = (new HakAksesController)->HakAksesFiturMaster('Sales');
        return view('Sales.Transaksi.DeliveryOrder.AccManager', compact('data', 'access'));
    }

    //Show the form for creating a new resource.
    public function create()
    {
        //
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        //
    }

    //Display the specified resource.
    public function show($id)
    {
        //
    }

    //Show the form for editing the specified resource.
    public function edit($id)
    {
        //
    }

    //Update the specified resource in storage.
    public function update(Request $request)
    {
        // dd($request->all());
        $idManager = Auth::user()->NomorUser;
        $nomorDO = $request->nomorDOs;
        for ($i = 0; $i < count($nomorDO); $i++) {
            DB::connection('ConnSales')->select('exec SP_1486_SLS_ACC_DO1 @IdManager = ?, @IdDO = ?', [$idManager, $nomorDO[$i]]);
        }
        return redirect()->back()->with('success', 'Delivery Order dengan Nomor DO' . implode(", ", $nomorDO) . ' Sudah Disetujui!');
    }

    public function indexDestroy()
    {
        $data = DB::connection('ConnSales')->select('exec SP_4384_SLS_LIST_DO_WEB');
        // dd($data);
        $access = (new HakAksesController)->HakAksesFiturMaster('Sales');
        return view('Sales.Transaksi.DeliveryOrder.BatalManager', compact('data', 'access'));
    }
    //Remove the specified resource from storage.

    public function destroy(Request $request)
    {
        // dd($id);
        // $data = $request->all();
        // dd($data);
        $nomorTransTmps = $request->nomorTransTmps;
        $nomorDOs = $request->nomorDOs;
        $value = $request->value;
        $user = Auth::user()->NomorUser;
        $errors = [];
        for ($i = 0; $i < count($nomorDOs); $i++) {
            $accManager = DB::connection('ConnSales')->select('exec SP_1486_SLS_DO_BATAL @Kode = ?, @IDDO = ?', [1, $nomorDOs[$i]]);
            // dd($accManager);
            if ($accManager[0]->AccManager == $user) {
                DB::connection('ConnSales')->statement('exec SP_1486_SLS_DO_BATAL @Kode = ?, @IdDO = ?, @IDManager = ?, @KetBatal = ?, @IdTransTmp = ?', [2, $nomorDOs[$i], $user, $value, $nomorTransTmps[$i]]);
            } else {
                $errors[] = 'Anda tidak berhak untuk menghapus Delivery Order ' . $nomorDOs[$i] . '. Coba hubungi pemilik login: ' . $accManager[0]->AccManager;
            }
        }
        if (count($errors) > 0) {
            return redirect()->back()->with('error', $errors);
        } else {
            return redirect()->back()->with('success', 'Delivery Order yang Dipilih Sudah Dihapus!');
        }
    }
}
