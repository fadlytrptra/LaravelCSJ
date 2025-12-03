<?php

namespace App\Http\Controllers\Sales\Transaksi\DeliveryOrder;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Html\Facades\Form;
use App\Http\Controllers\HakAksesController;

class DeliveryOrderController extends Controller
{
    //Display a listing of the resource.
    public function index()
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('Sales');
        $data = DB::connection('ConnSales')->select('exec SP_1486_SLS_LIST_DO_BLM_ACC1');
        // dd($data);
        return view('Sales.Transaksi.DeliveryOrder.Index', compact('data', 'access'));
    }

    // Show the form for creating a new resource.

    public function create()
    {
        $customer = DB::connection('ConnSales')->select('exec SP_1486_SLS_LIST_ALL_CUSTOMER @Kode = ?', [1]);
        $access = (new HakAksesController)->HakAksesFiturMaster('Sales');
        return view('Sales.Transaksi.DeliveryOrder.Create', compact('customer', 'access'));
    }

    public function getSuratPesanan($customer)
    {
        $suratPesanan = DB::connection('ConnSales')->select('exec SP_1486_SLS_LIST_SP_DO @IdCust = ?', [$customer]);
        return response()->json($suratPesanan);
    }

    public function getIdPesanan($nomor_sp)
    {
        if (strstr($nomor_sp, '.')) {
            $no_spValue = str_replace('.', '/', $nomor_sp);
            $idPesanan = DB::connection('ConnSales')->select('exec SP_1486_SLS_LIST_TYPE_DO1 @IDSuratPesanan = ?, @Kode = ?', [$no_spValue, 1]);
        } else {
            $no_spValue = $nomor_sp;
            $idPesanan = DB::connection('ConnSales')->select('exec SP_1486_SLS_LIST_TYPE_DO1 @IDSuratPesanan = ?', [$no_spValue]);
        }
        return response()->json($idPesanan);
    }

    public function getBarang($idPesanan)
    {
        if (strstr($idPesanan, '.Ekspor')) {
            $idPesananValue = str_replace('.Ekspor','',$idPesanan);
            $data = db::connection('ConnSales')->select('exec SP_1486_SLS_LIST_SALDO_TYPE_DO1 @IDPesanan = ?, @Kode = ?', [$idPesananValue, 1]);
        } else {
            $data = db::connection('ConnSales')->select('exec SP_1486_SLS_LIST_SALDO_TYPE_DO1 @IDPesanan = ?', [$idPesanan]);
        }
        return response()->json($data);
    }
    public function getKelompokUtama($kodeBarang)
    {
        // dd($kodeBarang);
        $kelompokUtama = db::connection('ConnInventory')->select('exec SP_1486_SLS_LIST_TYPEBARANG1 @KodeBarang = ?', [$kodeBarang]);
        return response()->json($kelompokUtama);
    }
    public function getKelompok($kelompokUtama, $kodeBarang)
    {
        $kelompok = db::connection('ConnInventory')->select('exec SP_1486_SLS_LIST_KELOMPOK1 @idKelUt = ?, @KodeBarang = ?', [$kelompokUtama, $kodeBarang]);
        return response()->json($kelompok);
    }
    public function getSubKelompok($kelompok, $kodeBarang)
    {
        $subKelompok = db::connection('ConnInventory')->select('exec SP_1486_SLS_LIST_SUBKEL1 @idKel = ?, @KodeBarang = ?', [$kelompok, $kodeBarang]);
        return response()->json($subKelompok);
    }
    public function getSaldo($subKelompok, $kodeBarang)
    {
        $data = db::connection('ConnInventory')->select('exec SP_1273_INV_ambil_idtype @XIdSubKelompok = ?, @XKodeBarang = ?', [$subKelompok, $kodeBarang]);
        return response()->json($data);
    }
    public function getNomorDeliveryOrder()
    {
        $data = db::connection('ConnSales')->select('exec SP_1486_SLS_LIST_DO_BLM_ACC1');
        return response()->json($data);
    }
    public function indexInputPEB(){
        
    }
    //Store a newly created resource in storage.
    public function store(Request $request)
    {
        // $data = $request->all();
        // dd($request->all());
        $MyType = 1;
        $Tanggal = $request->tgl_do;
        $IDPesanan = $request->id_pesanan;
        $QtyPrimer = $request->qty_primer;
        $QtySekunder = $request->qty_sekunder;
        $QtyTritier = $request->qty_tritier;
        $MaxKirim = $request->max_kirim;
        $MinKirim = $request->min_kirim;
        $AlamatKirim = $request->alamat_kirim ?? NULL;
        $KotaKirim = $request->kota_kirim;
        $IdType = $request->id_typeBarang;
        DB::connection('ConnSales')->statement('exec SP_1486_SLS_MAINT_DO1 @MyType = ?,
        @Tanggal = ?,
        @IDPesanan = ?,
        @QtyPrimer = ?,
        @QtySekunder = ?,
        @QtyTritier = ?,
        @MaxKirim = ?,
        @MinKirim = ?,
        @AlamatKirim = ?,
        @KotaKirim = ?,
        @IdType = ?',
            [
                $MyType,
                $Tanggal,
                $IDPesanan,
                $QtyPrimer,
                $QtySekunder,
                $QtyTritier,
                $MaxKirim,
                $MinKirim,
                $AlamatKirim,
                $KotaKirim,
                $IdType
            ]
        );
        // echo "<script type='text/javascript'>alert('Data Berhasil disimpan') ;</script>";
        // echo "<script type='text/javascript'>window.close();</script>";
        return redirect()->back()->with('success', 'Delivery Order Sudah Disimpan!');
    }

    //Display the specified resource.

    public function show($id)
    {
        //
    }

    //Show the form for editing the specified resource.

    public function edit($id)
    {
        // $customer = DB::connection('sqlsrv2')->select('exec SP_1486_SLS_LIST_ALL_CUSTOMER @Kode = ?', [1]);
        $detail = db::connection('ConnSales')->select('exec SP_1486_SLS_LIST_DETAIL_DO1 @IDDO = ?', [$id]);
        // $data = [$customer,$detail];
        // dd($data);
        return response()->json($detail);
        // return view('Sales.Transaksi.DeliveryOrder.Edit', compact('data', 'customer'));
    }

    //Update the specified resource in storage.

    public function update($id, Request $request)
    {
        // $data = $request->all();
        // dd($request->all());
        $MyType = 2;
        $Tanggal = $request->tgl_do;
        $IDPesanan = $request->id_pesanan;
        $QtyPrimer = $request->qty_primer;
        $QtySekunder = $request->qty_sekunder;
        $QtyTritier = $request->qty_tritier;
        $MaxKirim = $request->max_kirim;
        $MinKirim = $request->min_kirim;
        $AlamatKirim = $request->alamat_kirim;
        $KotaKirim = $request->kota_kirim;
        $IdType = $request->id_typeBarang;
        $IdDO = $id;
        DB::connection('ConnSales')->statement('exec SP_1486_SLS_MAINT_DO1 @MyType = ?,
        @IdDO = ?,
        @Tanggal = ?,
        @IDPesanan = ?,
        @QtyPrimer = ?,
        @QtySekunder = ?,
        @QtyTritier = ?,
        @MaxKirim = ?,
        @MinKirim = ?,
        @AlamatKirim = ?,
        @KotaKirim = ?,
        @IdType = ?',
            [
                $MyType,
                $IdDO,
                $Tanggal,
                $IDPesanan,
                $QtyPrimer,
                $QtySekunder,
                $QtyTritier,
                $MaxKirim,
                $MinKirim,
                $AlamatKirim,
                $KotaKirim,
                $IdType
            ]
        );
        // echo "<script type='text/javascript'>alert('Data Berhasil diubah') ;</script>";
        // echo "<script type='text/javascript'>window.close();</script>";
        return redirect()->back()->with('success', 'Delivery Order Sudah Diubah!');
    }

    //Remove the specified resource from storage.
    public function destroy($id)
    {
        // dd("DELETE");
        DB::connection('ConnSales')->statement('exec SP_1486_SLS_MAINT_DO1 @MyType = ?, @IdDO = ? ', [3, $id]);
        // return redirect()->route('DeliveryOrder.index');
        return redirect()->back()->with('success', 'Delivery Order Sudah Dihapus!');
    }
}
