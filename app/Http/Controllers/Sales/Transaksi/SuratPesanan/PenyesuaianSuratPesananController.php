<?php

namespace App\Http\Controllers\Sales\Transaksi\SuratPesanan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenyesuaianSuratPesananController extends Controller
{
    //Display a listing of the resource.
    public function index($suratPesanan)
    {
        $jenis_sp = DB::connection('ConnSales')->select('exec SP_1486_SLS_LIST_SP @Kode = ?', [1]);
        $list_customer = DB::connection('ConnSales')->select('exec SP_1486_SLS_LIST_ALL_CUSTOMER @Kode = ?', [1]);
        $list_sales = DB::connection('ConnSales')->select('exec SP_1486_SLS_LIST_SALES');
        $jenis_bayar = DB::connection('ConnSales')->select('exec SP_1486_SLS_LIST_JNSBAYAR');
        $jenis_brg = DB::connection('ConnSales')->select('exec SP_1486_SLS_LIST_JNSBRG');
        $kategori_utama = DB::connection('ConnPurchase')->select('exec SP_1273_PRG_KATEGORI_UTAMA');
        $list_satuan = DB::connection('ConnSales')->select('exec SP_1486_SLS_LIST_SATUAN');
        $header_pesanan = DB::connection('ConnSales')->select('exec SP_1486_SLS_LIST_SP_SDH_ACC @IDSURATPESANAN = ?, @Kode = ?', [$suratPesanan, 1]);
        $detail_pesanan = DB::connection('ConnSales')->select('exec SP_1486_SLS_LIST_SESUAI_SP @IDSURATPESANAN = ?, @Kode = ?', [$suratPesanan, 2]);
        dd($list_customer);
        return view('Sales.Transaksi.SuratPesanan.Penyesuaian', compact('header_pesanan', 'detail_pesanan', 'id', 'jenis_sp', 'list_customer', 'list_sales', 'jenis_bayar', 'jenis_brg', 'kategori_utama', 'list_satuan'));
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
    public function show(Request $request)
    {
        //
    }

    // Show the form for editing the specified resource.
    public function edit($id)
    {
        $jenis_sp = DB::connection('ConnSales')->select('exec SP_1486_SLS_LIST_SP @Kode = ?', [1]);
        $list_customer = DB::connection('ConnSales')->select('exec SP_1486_SLS_LIST_ALL_CUSTOMER @Kode = ?', [1]);
        $list_sales = DB::connection('ConnSales')->select('exec SP_1486_SLS_LIST_SALES');
        $jenis_bayar = DB::connection('ConnSales')->select('exec SP_1486_SLS_LIST_JNSBAYAR');
        $jenis_brg = DB::connection('ConnSales')->select('exec SP_1486_SLS_LIST_JNSBRG');
        $kategori_utama = DB::connection('ConnPurchase')->select('exec SP_1273_PRG_KATEGORI_UTAMA');
        $list_satuan = DB::connection('ConnSales')->select('exec SP_1486_SLS_LIST_SATUAN');
        if (strstr($id, '.')) { //ekspor
            $no_spValue = str_replace('.', '/', $id);
            $header_pesanan = DB::connection('ConnSales')->select('exec SP_1486_SLS_LIST_SP_SDH_ACC @IDSURATPESANAN = ?, @Kode = ?', [$no_spValue, 1]);
            $detail_pesanan = DB::connection('ConnSales')->select('exec SP_1486_SLS_LIST_SESUAI_SP @IDSURATPESANAN = ?, @Kode = ?', [$no_spValue, 3]);
            return view('Sales.Transaksi.SuratPesanan.PenyesuaianEkspor', compact('header_pesanan', 'detail_pesanan', 'id', 'jenis_sp', 'list_customer', 'list_sales', 'jenis_bayar', 'jenis_brg', 'kategori_utama', 'list_satuan'));
        } else { //lokal
            $no_spValue = $id;
            $header_pesanan = DB::connection('ConnSales')->select('exec SP_1486_SLS_LIST_SP_SDH_ACC @IDSURATPESANAN = ?, @Kode = ?', [$no_spValue, 1]);
            $detail_pesanan = DB::connection('ConnSales')->select('exec SP_1486_SLS_LIST_SESUAI_SP @IDSURATPESANAN = ?, @Kode = ?', [$no_spValue, 2]);
            return view('Sales.Transaksi.SuratPesanan.PenyesuaianLokal', compact('header_pesanan', 'detail_pesanan', 'id', 'jenis_sp', 'list_customer', 'list_sales', 'jenis_bayar', 'jenis_brg', 'kategori_utama', 'list_satuan'));
        }
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
