<?php

namespace App\Http\Controllers\Sales\ToolPenjualan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\HakAksesController;

class BatalJualController extends Controller
{
    //Display a listing of the resource.
    public function index()
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('Sales');
        return view('Sales.ToolPenjualan.BatalJual',compact('access'));
    }

    public function getInputBarcode($kodeBarang)
    {
        $data = db::connection('ConnInventory')->select('SELECT Tmp_Gudang.Tgl_Mutasi, Tmp_Gudang.NoIndeks, Tmp_Gudang.Kode_barang, Tmp_Gudang.IdType, VW_TYPE.IdDivisi FROM Tmp_Gudang INNER JOIN VW_TYPE ON Tmp_Gudang.IdType = VW_TYPE.IdType WHERE (Kode_barang = \'' . $kodeBarang . '\') and (Aktif = \'Y\') AND (typetransaksi = \'09\') AND (IDDO IS NULL)');
        return response()->json($data);
    }
    //Show the form for creating a new resource.
    public function create()
    {
        //
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {

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
        $nomor_indeks = $request->nomorIndeks;
        $nomor_indeksAll = implode(", ", $nomor_indeks);
        $kode_barang = $request->kodeBarang;
        // dd($nomor_indeks);
        for ($i = 0; $i < count($nomor_indeks); $i++) {
            DB::connection('ConnInventory')->statement('UPDATE Tmp_Gudang SET Aktif = \'N\' WHERE Aktif = \'Y\' AND typetransaksi = 09 AND IDDO IS NULL AND Kode_barang = \'' . $kode_barang . '\' AND NoIndeks = \'' . $nomor_indeks[$i] . '\'');
        }
        // dd('UPDATE Tmp_Gudang SET Aktif = \'N\' WHERE Aktif = \'Y\' AND typetransaksi = 09 AND IDDO IS NULL AND Kode_barang = ? AND NoIndeks IN(?)', [$kode_barang, $nomor_indeksAll]);
        return redirect()->back()->with('success', 'Kode Barang ' . $kode_barang . ' dengan Nomor Indeks ' . $nomor_indeksAll . ' Sudah Dibatalkan!');
    }

    //Remove the specified resource from storage.
    public function destroy($id)
    {
        //
    }
}
