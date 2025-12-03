<?php

namespace App\Http\Controllers\Sales\ToolPenjualan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\HakAksesController;

class CariBarcodeController extends Controller
{
    //Display a listing of the resource.
    public function index()
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('Sales');
        return view('Sales.ToolPenjualan.CariBarcode', compact('access'));
    }

    public function getIdTypeDispresiasi($kodeBarang)
    {
        $data = db::connection('ConnInventory')->select('select id_type_tujuan, count(noindeks) from dispresiasi where kode_barang = ' . $kodeBarang . ' group by id_type_tujuan having count(noindeks) > 0');
        return response()->json($data);
    }

    public function getIdTypeTmpGudang($kodeBarang)
    {
        $data = db::connection('ConnInventory')->select('select idtype, count(noindeks) from tmp_gudang where kode_barang = ' . $kodeBarang . ' and aktif = \'Y\' and typetransaksi = \'09\' group by idtype having count(noindeks) > 0');
        return response()->json($data);
    }

    public function cariBarcodeFilter(Request $request)
    {
        // $data = $request->all();
        $Group_Radio_Button_Cari_Barcode = $request->input('Group_Radio_Button_Cari_Barcode');

        $Kode_barang = $request->input('Kode_barang');
        $Kode_filter = $request->input('Kode_filter');
        $query = "";

        if ($Group_Radio_Button_Cari_Barcode == 'Dispresiasi') {
            $query = 'select Dispresiasi.NoIndeks, Dispresiasi.Qty_Primer, Dispresiasi.Qty_sekunder, Dispresiasi.Qty, Dispresiasi.Id_type_tujuan, Dispresiasi.Tgl_mutasi, Dispresiasi.Status, Dispresiasi.Type_Transaksi,VW_TYPE.IdDivisi, VW_TYPE.NamaKelompokUtama, VW_TYPE.NamaKelompok, VW_TYPE.NamaSubKelompok from Dispresiasi INNER JOIN VW_TYPE ON Dispresiasi.Id_type_tujuan = VW_TYPE.IdType where kode_barang = \'' . $Kode_barang . '\' and noindeks not in(select noindeks from tmp_gudang where kode_barang = \'' . $Kode_barang . '\' and aktif = \'Y\' and typetransaksi = \'09\')and qty_primer is not null and (status = \'3\' or status is null)';
        } else {
            $query = 'select noindeks, idtype, tgl_mutasi, aktif, typetransaksi, iddo from tmp_gudang where kode_barang = \'' . $Kode_barang . '\' and aktif = \'Y\' and typetransaksi = \'09\'';
        }

        if (strpos($Kode_filter, "D") !== false) {
            $Tanggal = $request->input('Tanggal');
            $query .= ' and tgl_mutasi = \''.$Tanggal.'\'';
        }
        if (strpos($Kode_filter, "T") !== false) {
            $Id_Type = $request->input('Id_Type');
            if ($Group_Radio_Button_Cari_Barcode == 'Dispresiasi') {
                $query .= 'and id_type_tujuan = \''.$Id_Type.'\'';
            } else {
                $query .= ' and idtype =  \''.$Id_Type.'\'';
            }
        }
        if (strpos($Kode_filter, "S") !== false) {
            $Lembar = $request->input('Lembar');
            $query .= ' and qty_sekunder = \''.$Lembar.'\'';
        }
        if (strpos($Kode_filter, "K") !== false) {
            $Kg = $request->input('Kg');
            $query .= ' and qty = \''.$Kg.'\'';
        }
        $data = db::connection('ConnInventory')->select($query);
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
    public function update($id)
    {

    }

    //Remove the specified resource from storage.
    public function destroy($id)
    {
        //
    }
}
