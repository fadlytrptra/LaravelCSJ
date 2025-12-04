<?php

namespace App\Http\Controllers\Sales\Transaksi\SuratJalan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\HakAksesController;

class PascaKirimController extends Controller
{
    //Display a listing of the resource.
    public function index()
    {
        $customer = db::connection('ConnSales')->select('exec SP_1486_SLS_LIST_ALL_CUSTOMER @Kode = ?', [1]);
        // dd($customer);
        $access = (new HakAksesController)->HakAksesFiturMaster('Sales');
        return view('Sales.Transaksi.SuratJalan.PascaKirim', compact('customer', 'access'));
    }

    public function getSuratPesanan($customer)
    {
        $suratPesanan = db::connection('ConnSales')->select('exec SP_1486_SLS_LIST_SP_PASCA_KIRIM @IDCust = ?', [$customer]);
        return response()->json($suratPesanan);
    }

    public function getBarangPesanan($suratPesanan, $suratJalan)
    {
        if (strpos($suratPesanan, '.')) {
            $suratPesanan = str_replace('.', '/', $suratPesanan);
            // dd($suratPesanan);
        }
        $barang = db::connection('ConnSales')->select('exec SP_1486_SLS_LIST_ITEM_PASCA_KIRIM @SP = ?, @SJ = ?', [$suratPesanan, $suratJalan]);

        return response()->json($barang);
    }
    public function getReturKirim($kodeBarang)
    {
        $displayRetur = db::connection('ConnSales')->select('exec SP_1486_SLS_LIST_RETUR_PASCA_KIRIM @IdDetail = ?', [$kodeBarang]);
        $displayKirim = db::connection('ConnSales')->select('exec SP_1486_SLS_LIST_KIRIM_PASCA_KIRIM @IdDetail = ?', [$kodeBarang]);
        $responseData = ['retur' => $displayRetur, 'kirim' => $displayKirim];
        return response()->json($responseData);
    }
    //Show the form for creating a new resource.
    public function create()
    {
        //
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        // $data = $request->all();
        // dd($data);
        $user = Auth::user()->NomorUser;
        $jenis_pasca = $request->jenis_pasca;
        // dd($jenis_pasca);
        $customer = $request->customer;
        $surat_pesanan = $request->surat_pesanan;
        $surat_jalan = $request->surat_jalan;
        $barang_pesanan = $request->barang_pesanan;
        $barang_pesananArray = explode("|", $barang_pesanan);
        $tanggal_diterima = $request->tanggal_diterima;
        $bttb = $request->bttb ?? NULL;
        $qty_konversiDiterimaCustomer = $request->qty_konversiDiterimaCustomer ?? NULL;
        $qty_primerDiterimaCustomer = (float) $request->qty_primerDiterimaCustomer;
        $qty_sekunderDiterimaCustomer = (float) $request->qty_sekunderDiterimaCustomer;
        $qty_tritierDiterimaCustomer = (float) $request->qty_tritierDiterimaCustomer;
        // dd($qty_primerDiterimaCustomer, $qty_sekunderDiterimaCustomer, $qty_tritierDiterimaCustomer);
        $penerima = $request->penerima;
        $alasan_kembali = $request->alasan_kembali;
        // dd($request->all());
        $invoiceCheck = db::connection('ConnAccounting')->select('exec SP_1486_SLS_CEK_INVOICE @Id_cust = ?, @SJ = ?', [$customer, $surat_jalan]);
        // dd($barang_pesananArray);
        if (count($invoiceCheck) > 0) {
            // $invoiceCheck has a value
            return response()->json(['error' => 'Invoice already exists!']);
        }
        $pascaKirimCheck = db::connection('ConnSales')->select('exec SP_1486_SLS_CEK_PASCA_KIRIM @IdPengiriman = ?, @IDDetailKirim = ?', [$surat_jalan, $barang_pesananArray[1]]);
        // dd($pascaKirimCheck[0]->StatusPasca);
        if ($pascaKirimCheck[0]->StatusPasca == "Pengembalian" && $jenis_pasca == "Pengembalian") {
            return response()->json(['error' => 'Pasca Kirim Pengembalian already exists!']);
        } else if ($pascaKirimCheck[0]->StatusPasca == "Kurang/Lebih" && $jenis_pasca == "Kurang/Lebih") {
            return response()->json(['error' => 'Pasca Kirim Kelebihan/Kekurangan Pengiriman already exists!']);
        }
        db::connection('ConnSales')->statement('exec SP_1486_SLS_MAINT_PASCA_KIRIM1 @NoBTTB = ?,
        @JmlTerimaPrimer = ?,
        @JmlTerimaTritier = ?,
        @JmlTerimaSekunder = ?,
        @JmlKonversi = ?,
        @StatusKirim = ?,
        @IDDetailKirim = ?,
        @NoSJ = ?,
        @Tanggal = ?,
        @UserPasca = ?,
        @IdHeaderKirim = ?,
        @Alasan = ?,
        @StatusPasca = ?',
            [
                $bttb,
                $qty_primerDiterimaCustomer,
                $qty_tritierDiterimaCustomer,
                $qty_sekunderDiterimaCustomer,
                $qty_konversiDiterimaCustomer,
                "Y",
                $barang_pesananArray[1],
                $surat_jalan,
                $tanggal_diterima,
                $user,
                $barang_pesananArray[0],
                $alasan_kembali,
                $jenis_pasca
            ]
        );
        return response()->json(['message' => 'Pasca Kirim Sudah Dibuat!']);
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
