<?php

namespace App\Http\Controllers\Beli\TransaksiBeli;

use App\Http\Controllers\Controller;
use App\Http\Controllers\HakAksesController;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PurchaseOrderController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('Beli');
        return view('Beli.TransaksiBeli.PurchaseOrder.ListPO.List', compact('access'));
    }

    //Show the form for creating a new resource.
    public function create()
    {
        $divisi = db::connection('ConnPurchase')->select('exec spSelect_UserDivisi_dotNet @kd = ?, @Operator = ?', [1, trim(Auth::user()->NomorUser)]);
        $access = (new HakAksesController)->HakAksesFiturMaster('Beli');
        // dd($divisi,Auth::user()->NomorUser);
        return view('Beli.TransaksiBeli.PurchaseOrder.Create', compact('divisi', 'access'));
    }

    public function getPermohonanDivisi($stBeli, $Kd_Div)
    {
        if ($Kd_Div == 'ALL') {
            $data = db::connection('ConnPurchase')->table('Ytransbl')->select(
                'Y_KATEGORI_UTAMA.no_kat_utama',
                'Y_KATEGORI_UTAMA.nama',
                'Y_KATEGORY.no_kategori',
                'Y_KATEGORY.nama_kategori',
                'Y_KATEGORI_SUB.no_sub_kategori',
                'Y_KATEGORI_SUB.nama_sub_kategori',
                'Y_BARANG.KET',
                'YTRANSBL.keterangan',
                'YTRANSBL.Pemesan',
                'YTRANSBL.Tgl_acc',
                'YTRANSBL.Manager',
                'YTRANSBL.Operator',
                'YTRANSBL.Batal_acc',
                'YTRANSBL.Batal_sppb',
                'YTRANSBL.No_sppb',
                'YTRANSBL.Direktur',
                'YTRANSBL.Tgl_Dibutuhkan',
                'YTRANSBL.StatusBeli',
                'Y_BARANG.NAMA_BRG',
                'YTRANSBL.Qty',
                'YTRANSBL.QtyCancel',
                'YTRANSBL.PriceUnit',
                'YTRANSBL.PriceSub',
                'YTRANSBL.PPN',
                'YTRANSBL.PriceExt',
                'YTRANSBL.Currency',
                'YSUPPLIER.NM_SUP',
                'YSUPPLIER.KOTA1',
                'YSUPPLIER.NEGARA1',
                'YSUPPLIER.ID_MATAUANG',
                'YUSER.Nama AS NmUser',
                'YTRANSBL.Ket_Internal',
                'YUSER_1.Nama AS AppMan',
                'YTRANSBL.Tgl_Direktur',
                'YTRANSBL.Tgl_PBL_Acc',
                'YUSER_2.Nama AS AppPBL',
                'ACCOUNTING.dbo.T_MATAUANG.Id_MataUang_BC AS Curr',
                'YUSER_3.Nama AS AppDir',
                'YTRANSBL.StatusBeli AS StBeli',
                'YTRANSBL.Kd_div',
                'YTRANSBL.Tgl_order',
                'YTRANSBL.No_trans',
                'YTRANSBL.Kd_brg',
                'YSATUAN.Nama_satuan',
                'YTRANSBL.Supplier as IdSup'
            )
                ->join('Y_BARANG', 'YTRANSBL.Kd_brg', '=', 'Y_BARANG.KD_BRG')
                ->join('Y_KATEGORI_SUB', 'Y_BARANG.NO_SUB_KATEGORI', '=', 'Y_KATEGORI_SUB.no_sub_kategori')
                ->join('Y_KATEGORY', function ($join) {
                    $join->on('Y_KATEGORI_SUB.no_kategori', '=', 'Y_KATEGORY.no_kategori')
                        ->orWhere('Y_KATEGORI_SUB.no_kategori', '=', 'Y_KATEGORY.no_kategori');
                })
                ->join('Y_KATEGORI_UTAMA', 'Y_KATEGORY.no_kat_utama', '=', 'Y_KATEGORI_UTAMA.no_kat_utama')
                ->join('YSUPPLIER', 'YTRANSBL.Supplier', '=', 'YSUPPLIER.NO_SUP')
                ->join('YUSER', 'YTRANSBL.Operator', '=', 'YUSER.kd_user')
                ->join('YUSER as YUSER_1', 'YTRANSBL.Manager', '=', 'YUSER_1.kd_user')
                ->join('YUSER as YUSER_2', 'YTRANSBL.PBL_Acc', '=', 'YUSER_2.kd_user')
                ->join('ACCOUNTING.dbo.T_MATAUANG', 'YTRANSBL.Currency', '=', 'ACCOUNTING.dbo.T_MATAUANG.Id_MataUang')
                ->join('YUSER as YUSER_3', 'YTRANSBL.Direktur', '=', 'YUSER_3.kd_user')
                ->join('YSATUAN', 'YTRANSBL.NoSatuan', '=', 'YSATUAN.No_satuan')
                ->where('YTRANSBL.StatusOrder', 4)
                ->where('YTRANSBL.StatusBeli', $stBeli)
                ->orderBy('YSUPPLIER.NM_SUP')
                ->get();
        } else {
            $data = db::connection('ConnPurchase')->table('Ytransbl')->select(
                'Y_KATEGORI_UTAMA.no_kat_utama',
                'Y_KATEGORI_UTAMA.nama',
                'Y_KATEGORY.no_kategori',
                'Y_KATEGORY.nama_kategori',
                'Y_KATEGORI_SUB.no_sub_kategori',
                'Y_KATEGORI_SUB.nama_sub_kategori',
                'Y_BARANG.KET',
                'YTRANSBL.keterangan',
                'YTRANSBL.Pemesan',
                'YTRANSBL.Tgl_acc',
                'YTRANSBL.Manager',
                'YTRANSBL.Operator',
                'YTRANSBL.Batal_acc',
                'YTRANSBL.Batal_sppb',
                'YTRANSBL.No_sppb',
                'YTRANSBL.Direktur',
                'YTRANSBL.Tgl_Dibutuhkan',
                'YTRANSBL.StatusBeli',
                'Y_BARANG.NAMA_BRG',
                'YTRANSBL.Qty',
                'YTRANSBL.QtyCancel',
                'YTRANSBL.PriceUnit',
                'YTRANSBL.PriceSub',
                'YTRANSBL.PPN',
                'YTRANSBL.PriceExt',
                'YTRANSBL.Currency',
                'YSUPPLIER.NM_SUP',
                'YSUPPLIER.KOTA1',
                'YSUPPLIER.NEGARA1',
                'YSUPPLIER.ID_MATAUANG',
                'YUSER.Nama AS NmUser',
                'YTRANSBL.Ket_Internal',
                'YUSER_1.Nama AS AppMan',
                'YTRANSBL.Tgl_Direktur',
                'YTRANSBL.Tgl_PBL_Acc',
                'YUSER_2.Nama AS AppPBL',
                'ACCOUNTING.dbo.T_MATAUANG.Id_MataUang_BC AS Curr',
                'YUSER_3.Nama AS AppDir',
                'YTRANSBL.StatusBeli AS StBeli',
                'YTRANSBL.Kd_div',
                'YTRANSBL.Tgl_order',
                'YTRANSBL.No_trans',
                'YTRANSBL.Kd_brg',
                'YSATUAN.Nama_satuan',
                'YTRANSBL.Supplier as IdSup'
            )
                ->join('Y_BARANG', 'YTRANSBL.Kd_brg', '=', 'Y_BARANG.KD_BRG')
                ->join('Y_KATEGORI_SUB', 'Y_BARANG.NO_SUB_KATEGORI', '=', 'Y_KATEGORI_SUB.no_sub_kategori')
                ->join('Y_KATEGORY', function ($join) {
                    $join->on('Y_KATEGORI_SUB.no_kategori', '=', 'Y_KATEGORY.no_kategori')
                        ->orWhere('Y_KATEGORI_SUB.no_kategori', '=', 'Y_KATEGORY.no_kategori');
                })
                ->join('Y_KATEGORI_UTAMA', 'Y_KATEGORY.no_kat_utama', '=', 'Y_KATEGORI_UTAMA.no_kat_utama')
                ->join('YSUPPLIER', 'YTRANSBL.Supplier', '=', 'YSUPPLIER.NO_SUP')
                ->join('YUSER', 'YTRANSBL.Operator', '=', 'YUSER.kd_user')
                ->join('YUSER as YUSER_1', 'YTRANSBL.Manager', '=', 'YUSER_1.kd_user')
                ->join('YUSER as YUSER_2', 'YTRANSBL.PBL_Acc', '=', 'YUSER_2.kd_user')
                ->join('ACCOUNTING.dbo.T_MATAUANG', 'YTRANSBL.Currency', '=', 'ACCOUNTING.dbo.T_MATAUANG.Id_MataUang')
                ->join('YUSER as YUSER_3', 'YTRANSBL.Direktur', '=', 'YUSER_3.kd_user')
                ->join('YSATUAN', 'YTRANSBL.NoSatuan', '=', 'YSATUAN.No_satuan')
                ->where('YTRANSBL.StatusOrder', 4)
                ->where('YTRANSBL.StatusBeli', $stBeli)
                ->where('YTRANSBL.Kd_div', $Kd_Div)
                ->orderBy('YSUPPLIER.NM_SUP')
                ->get();
        }


        // $data = db::connection('ConnPurchase')->select('exec SP_5409_LIST_ORDER @kd = ?, @stBeli = ?, @Kd_Div = ?', [12, $stBeli, $Kd_Div]);
        return response()->json($data);
    }

    public function getPermohonanUser($requester)
    {
        $data = db::connection('ConnPurchase')->table('Ytransbl')->select(
            'Y_KATEGORI_UTAMA.no_kat_utama',
            'Y_KATEGORI_UTAMA.nama',
            'Y_KATEGORY.no_kategori',
            'Y_KATEGORY.nama_kategori',
            'Y_KATEGORI_SUB.no_sub_kategori',
            'Y_KATEGORI_SUB.nama_sub_kategori',
            'Y_BARANG.KET',
            'YTRANSBL.keterangan',
            'YTRANSBL.Pemesan',
            'YTRANSBL.Tgl_acc',
            'YTRANSBL.Manager',
            'YTRANSBL.Operator',
            'YTRANSBL.Batal_acc',
            'YTRANSBL.Batal_sppb',
            'YTRANSBL.No_sppb',
            'YTRANSBL.Direktur',
            'YTRANSBL.Tgl_Dibutuhkan',
            'YTRANSBL.StatusBeli',
            'Y_BARANG.NAMA_BRG',
            'YTRANSBL.Qty',
            'YTRANSBL.QtyCancel',
            'YTRANSBL.PriceUnit',
            'YTRANSBL.PriceSub',
            'YTRANSBL.PPN',
            'YTRANSBL.PriceExt',
            'YTRANSBL.Currency',
            'YSUPPLIER.NM_SUP',
            'YSUPPLIER.KOTA1',
            'YSUPPLIER.NEGARA1',
            'YSUPPLIER.ID_MATAUANG',
            'YUSER.Nama AS NmUser',
            'YTRANSBL.Ket_Internal',
            'YUSER_1.Nama AS AppMan',
            'YTRANSBL.Tgl_Direktur',
            'YTRANSBL.Tgl_PBL_Acc',
            'YUSER_2.Nama AS AppPBL',
            'ACCOUNTING.dbo.T_MATAUANG.Id_MataUang_BC AS Curr',
            'YUSER_3.Nama AS AppDir',
            'YTRANSBL.StatusBeli AS StBeli',
            'YTRANSBL.Kd_div',
            'YTRANSBL.Tgl_order',
            'YTRANSBL.No_trans',
            'YTRANSBL.Kd_brg',
            'YSATUAN.Nama_satuan',
            'YTRANSBL.Supplier as IdSup'
        )
            ->join('Y_BARANG', 'YTRANSBL.Kd_brg', '=', 'Y_BARANG.KD_BRG')
            ->join('Y_KATEGORI_SUB', 'Y_BARANG.NO_SUB_KATEGORI', '=', 'Y_KATEGORI_SUB.no_sub_kategori')
            ->join('Y_KATEGORY', function ($join) {
                $join->on('Y_KATEGORI_SUB.no_kategori', '=', 'Y_KATEGORY.no_kategori')
                    ->orWhere('Y_KATEGORI_SUB.no_kategori', '=', 'Y_KATEGORY.no_kategori');
            })
            ->join('Y_KATEGORI_UTAMA', 'Y_KATEGORY.no_kat_utama', '=', 'Y_KATEGORI_UTAMA.no_kat_utama')
            ->join('YSUPPLIER', 'YTRANSBL.Supplier', '=', 'YSUPPLIER.NO_SUP')
            ->join('YUSER', 'YTRANSBL.Operator', '=', 'YUSER.kd_user')
            ->join('YUSER as YUSER_1', 'YTRANSBL.Manager', '=', 'YUSER_1.kd_user')
            ->join('YUSER as YUSER_2', 'YTRANSBL.PBL_Acc', '=', 'YUSER_2.kd_user')
            ->join('ACCOUNTING.dbo.T_MATAUANG', 'YTRANSBL.Currency', '=', 'ACCOUNTING.dbo.T_MATAUANG.Id_MataUang')
            ->join('YUSER as YUSER_3', 'YTRANSBL.Direktur', '=', 'YUSER_3.kd_user')
            ->join('YSATUAN', 'YTRANSBL.NoSatuan', '=', 'YSATUAN.No_satuan')
            ->where('YTRANSBL.StatusOrder', 4)
            ->where('YUSER.Nama', 'like', '%' . $requester . '%')
            ->get();
        // $data = db::connection('ConnPurchase')->select('exec SP_5409_LIST_ORDER @kd = ?, @requester = ?', [29, $requester]);
        return response()->json($data);
    }

    public function getPermohonanOrder($noTrans)
    {
        $data = db::connection('ConnPurchase')->table('Ytransbl')->select(
            'Y_KATEGORI_UTAMA.no_kat_utama',
            'Y_KATEGORI_UTAMA.nama',
            'Y_KATEGORY.no_kategori',
            'Y_KATEGORY.nama_kategori',
            'Y_KATEGORI_SUB.no_sub_kategori',
            'Y_KATEGORI_SUB.nama_sub_kategori',
            'Y_BARANG.KET',
            'YTRANSBL.keterangan',
            'YTRANSBL.Pemesan',
            'YTRANSBL.Tgl_acc',
            'YTRANSBL.Manager',
            'YTRANSBL.Operator',
            'YTRANSBL.Batal_acc',
            'YTRANSBL.Batal_sppb',
            'YTRANSBL.No_sppb',
            'YTRANSBL.Direktur',
            'YTRANSBL.Tgl_Dibutuhkan',
            'YTRANSBL.StatusBeli',
            'Y_BARANG.NAMA_BRG',
            'YTRANSBL.Qty',
            'YTRANSBL.QtyCancel',
            'YTRANSBL.PriceUnit',
            'YTRANSBL.PriceSub',
            'YTRANSBL.PPN',
            'YTRANSBL.PriceExt',
            'YTRANSBL.Currency',
            'YSUPPLIER.NM_SUP',
            'YSUPPLIER.KOTA1',
            'YSUPPLIER.NEGARA1',
            'YSUPPLIER.ID_MATAUANG',
            'YUSER.Nama AS NmUser',
            'YTRANSBL.Ket_Internal',
            'YUSER_1.Nama AS AppMan',
            'YTRANSBL.Tgl_Direktur',
            'YTRANSBL.Tgl_PBL_Acc',
            'YUSER_2.Nama AS AppPBL',
            'ACCOUNTING.dbo.T_MATAUANG.Id_MataUang_BC AS Curr',
            'YUSER_3.Nama AS AppDir',
            'YTRANSBL.StatusBeli AS StBeli',
            'YTRANSBL.Kd_div',
            'YTRANSBL.Tgl_order',
            'YTRANSBL.No_trans',
            'YTRANSBL.Kd_brg',
            'YSATUAN.Nama_satuan',
            'YTRANSBL.Supplier as IdSup'
        )
            ->join('Y_BARANG', 'YTRANSBL.Kd_brg', '=', 'Y_BARANG.KD_BRG')
            ->join('Y_KATEGORI_SUB', 'Y_BARANG.NO_SUB_KATEGORI', '=', 'Y_KATEGORI_SUB.no_sub_kategori')
            ->join('Y_KATEGORY', function ($join) {
                $join->on('Y_KATEGORI_SUB.no_kategori', '=', 'Y_KATEGORY.no_kategori')
                    ->orWhere('Y_KATEGORI_SUB.no_kategori', '=', 'Y_KATEGORY.no_kategori');
            })
            ->join('Y_KATEGORI_UTAMA', 'Y_KATEGORY.no_kat_utama', '=', 'Y_KATEGORI_UTAMA.no_kat_utama')
            ->join('YSUPPLIER', 'YTRANSBL.Supplier', '=', 'YSUPPLIER.NO_SUP')
            ->join('YUSER', 'YTRANSBL.Operator', '=', 'YUSER.kd_user')
            ->join('YUSER as YUSER_1', 'YTRANSBL.Manager', '=', 'YUSER_1.kd_user')
            ->join('YUSER as YUSER_2', 'YTRANSBL.PBL_Acc', '=', 'YUSER_2.kd_user')
            ->join('ACCOUNTING.dbo.T_MATAUANG', 'YTRANSBL.Currency', '=', 'ACCOUNTING.dbo.T_MATAUANG.Id_MataUang')
            ->join('YUSER as YUSER_3', 'YTRANSBL.Direktur', '=', 'YUSER_3.kd_user')
            ->join('YSATUAN', 'YTRANSBL.NoSatuan', '=', 'YSATUAN.No_satuan')
            ->where('YTRANSBL.StatusOrder', 4)
            ->where('YTRANSBL.No_trans', $noTrans)
            ->get();
        // $data = db::connection('ConnPurchase')->select('exec SP_5409_LIST_ORDER @kd = ?, @noTrans = ?', [30, $noTrans]);
        return response()->json($data);
    }

    public function getPermohonanDivisiNyantol($stBeli, $Kd_Div)
    {
        if ($Kd_Div == 'ALL') {
            $data = db::connection('ConnPurchase')->table('Ytransbl')->select(
                'Y_KATEGORI_UTAMA.no_kat_utama',
                'Y_KATEGORI_UTAMA.nama',
                'Y_KATEGORY.no_kategori',
                'Y_KATEGORY.nama_kategori',
                'Y_KATEGORI_SUB.no_sub_kategori',
                'Y_KATEGORI_SUB.nama_sub_kategori',
                'Y_BARANG.KET',
                'YTRANSBL.keterangan',
                'YTRANSBL.Pemesan',
                'YTRANSBL.Tgl_acc',
                'YTRANSBL.Manager',
                'YTRANSBL.Operator',
                'YTRANSBL.Batal_acc',
                'YTRANSBL.Batal_sppb',
                'YTRANSBL.No_sppb',
                'YTRANSBL.Direktur',
                'YTRANSBL.Tgl_Dibutuhkan',
                'YTRANSBL.StatusBeli',
                'Y_BARANG.NAMA_BRG',
                'YTRANSBL.Qty',
                'YTRANSBL.QtyCancel',
                'YTRANSBL.PriceUnit',
                'YTRANSBL.PriceSub',
                'YTRANSBL.PPN',
                'YTRANSBL.PriceExt',
                'YTRANSBL.Currency',
                'YSUPPLIER.NM_SUP',
                'YSUPPLIER.KOTA1',
                'YSUPPLIER.NEGARA1',
                'YSUPPLIER.ID_MATAUANG',
                'YUSER.Nama AS NmUser',
                'YTRANSBL.Ket_Internal',
                'YUSER_1.Nama AS AppMan',
                'YTRANSBL.Tgl_Direktur',
                'YTRANSBL.Tgl_PBL_Acc',
                'YUSER_2.Nama AS AppPBL',
                'ACCOUNTING.dbo.T_MATAUANG.Id_MataUang_BC AS Curr',
                'YUSER_3.Nama AS AppDir',
                'YTRANSBL.StatusBeli AS StBeli',
                'YTRANSBL.Kd_div',
                'YTRANSBL.Tgl_order',
                'YTRANSBL.No_trans',
                'YTRANSBL.Kd_brg',
                'YSATUAN.Nama_satuan',
                'YTRANSBL.Supplier as IdSup'
            )
                ->join('Y_BARANG', 'YTRANSBL.Kd_brg', '=', 'Y_BARANG.KD_BRG')
                ->join('Y_KATEGORI_SUB', 'Y_BARANG.NO_SUB_KATEGORI', '=', 'Y_KATEGORI_SUB.no_sub_kategori')
                ->join('Y_KATEGORY', function ($join) {
                    $join->on('Y_KATEGORI_SUB.no_kategori', '=', 'Y_KATEGORY.no_kategori')
                        ->orWhere('Y_KATEGORI_SUB.no_kategori', '=', 'Y_KATEGORY.no_kategori');
                })
                ->join('Y_KATEGORI_UTAMA', 'Y_KATEGORY.no_kat_utama', '=', 'Y_KATEGORI_UTAMA.no_kat_utama')
                ->join('YSUPPLIER', 'YTRANSBL.Supplier', '=', 'YSUPPLIER.NO_SUP')
                ->join('YUSER', 'YTRANSBL.Operator', '=', 'YUSER.kd_user')
                ->join('YUSER as YUSER_1', 'YTRANSBL.Manager', '=', 'YUSER_1.kd_user')
                ->join('YUSER as YUSER_2', 'YTRANSBL.PBL_Acc', '=', 'YUSER_2.kd_user')
                ->join('ACCOUNTING.dbo.T_MATAUANG', 'YTRANSBL.Currency', '=', 'ACCOUNTING.dbo.T_MATAUANG.Id_MataUang')
                ->join('YUSER as YUSER_3', 'YTRANSBL.Direktur', '=', 'YUSER_3.kd_user')
                ->join('YSATUAN', 'YTRANSBL.NoSatuan', '=', 'YSATUAN.No_satuan')
                ->where('YTRANSBL.StatusOrder', 5)
                ->where('YTRANSBL.StatusBeli', $stBeli)
                ->orderBy('YSUPPLIER.NM_SUP')
                ->get();
        } else {
            $data = db::connection('ConnPurchase')->table('Ytransbl')->select(
                'Y_KATEGORI_UTAMA.no_kat_utama',
                'Y_KATEGORI_UTAMA.nama',
                'Y_KATEGORY.no_kategori',
                'Y_KATEGORY.nama_kategori',
                'Y_KATEGORI_SUB.no_sub_kategori',
                'Y_KATEGORI_SUB.nama_sub_kategori',
                'Y_BARANG.KET',
                'YTRANSBL.keterangan',
                'YTRANSBL.Pemesan',
                'YTRANSBL.Tgl_acc',
                'YTRANSBL.Manager',
                'YTRANSBL.Operator',
                'YTRANSBL.Batal_acc',
                'YTRANSBL.Batal_sppb',
                'YTRANSBL.No_sppb',
                'YTRANSBL.Direktur',
                'YTRANSBL.Tgl_Dibutuhkan',
                'YTRANSBL.StatusBeli',
                'Y_BARANG.NAMA_BRG',
                'YTRANSBL.Qty',
                'YTRANSBL.QtyCancel',
                'YTRANSBL.PriceUnit',
                'YTRANSBL.PriceSub',
                'YTRANSBL.PPN',
                'YTRANSBL.PriceExt',
                'YTRANSBL.Currency',
                'YSUPPLIER.NM_SUP',
                'YSUPPLIER.KOTA1',
                'YSUPPLIER.NEGARA1',
                'YSUPPLIER.ID_MATAUANG',
                'YUSER.Nama AS NmUser',
                'YTRANSBL.Ket_Internal',
                'YUSER_1.Nama AS AppMan',
                'YTRANSBL.Tgl_Direktur',
                'YTRANSBL.Tgl_PBL_Acc',
                'YUSER_2.Nama AS AppPBL',
                'ACCOUNTING.dbo.T_MATAUANG.Id_MataUang_BC AS Curr',
                'YUSER_3.Nama AS AppDir',
                'YTRANSBL.StatusBeli AS StBeli',
                'YTRANSBL.Kd_div',
                'YTRANSBL.Tgl_order',
                'YTRANSBL.No_trans',
                'YTRANSBL.Kd_brg',
                'YSATUAN.Nama_satuan',
                'YTRANSBL.Supplier as IdSup'
            )
                ->join('Y_BARANG', 'YTRANSBL.Kd_brg', '=', 'Y_BARANG.KD_BRG')
                ->join('Y_KATEGORI_SUB', 'Y_BARANG.NO_SUB_KATEGORI', '=', 'Y_KATEGORI_SUB.no_sub_kategori')
                ->join('Y_KATEGORY', function ($join) {
                    $join->on('Y_KATEGORI_SUB.no_kategori', '=', 'Y_KATEGORY.no_kategori')
                        ->orWhere('Y_KATEGORI_SUB.no_kategori', '=', 'Y_KATEGORY.no_kategori');
                })
                ->join('Y_KATEGORI_UTAMA', 'Y_KATEGORY.no_kat_utama', '=', 'Y_KATEGORI_UTAMA.no_kat_utama')
                ->join('YSUPPLIER', 'YTRANSBL.Supplier', '=', 'YSUPPLIER.NO_SUP')
                ->join('YUSER', 'YTRANSBL.Operator', '=', 'YUSER.kd_user')
                ->join('YUSER as YUSER_1', 'YTRANSBL.Manager', '=', 'YUSER_1.kd_user')
                ->join('YUSER as YUSER_2', 'YTRANSBL.PBL_Acc', '=', 'YUSER_2.kd_user')
                ->join('ACCOUNTING.dbo.T_MATAUANG', 'YTRANSBL.Currency', '=', 'ACCOUNTING.dbo.T_MATAUANG.Id_MataUang')
                ->join('YUSER as YUSER_3', 'YTRANSBL.Direktur', '=', 'YUSER_3.kd_user')
                ->join('YSATUAN', 'YTRANSBL.NoSatuan', '=', 'YSATUAN.No_satuan')
                ->where('YTRANSBL.StatusOrder', 5)
                ->where('YTRANSBL.StatusBeli', $stBeli)
                ->where('YTRANSBL.Kd_div', $Kd_Div)
                ->orderBy('YSUPPLIER.NM_SUP')
                ->get();
        }

        // $data = db::connection('ConnPurchase')->select('exec SP_5409_LIST_ORDER @kd = ?, @stBeli = ?, @Kd_Div = ?', [38, $stBeli, $Kd_Div]);
        return response()->json($data);
    }

    public function getPermohonanUserNyantol($requester)
    {
        $data = db::connection('ConnPurchase')->table('Ytransbl')->select(
            'Y_KATEGORI_UTAMA.no_kat_utama',
            'Y_KATEGORI_UTAMA.nama',
            'Y_KATEGORY.no_kategori',
            'Y_KATEGORY.nama_kategori',
            'Y_KATEGORI_SUB.no_sub_kategori',
            'Y_KATEGORI_SUB.nama_sub_kategori',
            'Y_BARANG.KET',
            'YTRANSBL.keterangan',
            'YTRANSBL.Pemesan',
            'YTRANSBL.Tgl_acc',
            'YTRANSBL.Manager',
            'YTRANSBL.Operator',
            'YTRANSBL.Batal_acc',
            'YTRANSBL.Batal_sppb',
            'YTRANSBL.No_sppb',
            'YTRANSBL.Direktur',
            'YTRANSBL.Tgl_Dibutuhkan',
            'YTRANSBL.StatusBeli',
            'Y_BARANG.NAMA_BRG',
            'YTRANSBL.Qty',
            'YTRANSBL.QtyCancel',
            'YTRANSBL.PriceUnit',
            'YTRANSBL.PriceSub',
            'YTRANSBL.PPN',
            'YTRANSBL.PriceExt',
            'YTRANSBL.Currency',
            'YSUPPLIER.NM_SUP',
            'YSUPPLIER.KOTA1',
            'YSUPPLIER.NEGARA1',
            'YSUPPLIER.ID_MATAUANG',
            'YUSER.Nama AS NmUser',
            'YTRANSBL.Ket_Internal',
            'YUSER_1.Nama AS AppMan',
            'YTRANSBL.Tgl_Direktur',
            'YTRANSBL.Tgl_PBL_Acc',
            'YUSER_2.Nama AS AppPBL',
            'ACCOUNTING.dbo.T_MATAUANG.Id_MataUang_BC AS Curr',
            'YUSER_3.Nama AS AppDir',
            'YTRANSBL.StatusBeli AS StBeli',
            'YTRANSBL.Kd_div',
            'YTRANSBL.Tgl_order',
            'YTRANSBL.No_trans',
            'YTRANSBL.Kd_brg',
            'YSATUAN.Nama_satuan',
            'YTRANSBL.Supplier as IdSup'
        )
            ->join('Y_BARANG', 'YTRANSBL.Kd_brg', '=', 'Y_BARANG.KD_BRG')
            ->join('Y_KATEGORI_SUB', 'Y_BARANG.NO_SUB_KATEGORI', '=', 'Y_KATEGORI_SUB.no_sub_kategori')
            ->join('Y_KATEGORY', function ($join) {
                $join->on('Y_KATEGORI_SUB.no_kategori', '=', 'Y_KATEGORY.no_kategori')
                    ->orWhere('Y_KATEGORI_SUB.no_kategori', '=', 'Y_KATEGORY.no_kategori');
            })
            ->join('Y_KATEGORI_UTAMA', 'Y_KATEGORY.no_kat_utama', '=', 'Y_KATEGORI_UTAMA.no_kat_utama')
            ->join('YSUPPLIER', 'YTRANSBL.Supplier', '=', 'YSUPPLIER.NO_SUP')
            ->join('YUSER', 'YTRANSBL.Operator', '=', 'YUSER.kd_user')
            ->join('YUSER as YUSER_1', 'YTRANSBL.Manager', '=', 'YUSER_1.kd_user')
            ->join('YUSER as YUSER_2', 'YTRANSBL.PBL_Acc', '=', 'YUSER_2.kd_user')
            ->join('ACCOUNTING.dbo.T_MATAUANG', 'YTRANSBL.Currency', '=', 'ACCOUNTING.dbo.T_MATAUANG.Id_MataUang')
            ->join('YUSER as YUSER_3', 'YTRANSBL.Direktur', '=', 'YUSER_3.kd_user')
            ->join('YSATUAN', 'YTRANSBL.NoSatuan', '=', 'YSATUAN.No_satuan')
            ->where('YTRANSBL.StatusOrder', 5)
            ->where('YUSER.Nama', 'like', '%' . $requester . '%')
            ->get();
        // $data = db::connection('ConnPurchase')->select('exec SP_5409_LIST_ORDER @kd = ?, @requester = ?', [39, $requester]);
        return response()->json($data);
    }

    public function getPermohonanOrderNyantol($noTrans)
    {
        $data = db::connection('ConnPurchase')->table('Ytransbl')->select(
            'Y_KATEGORI_UTAMA.no_kat_utama',
            'Y_KATEGORI_UTAMA.nama',
            'Y_KATEGORY.no_kategori',
            'Y_KATEGORY.nama_kategori',
            'Y_KATEGORI_SUB.no_sub_kategori',
            'Y_KATEGORI_SUB.nama_sub_kategori',
            'Y_BARANG.KET',
            'YTRANSBL.keterangan',
            'YTRANSBL.Pemesan',
            'YTRANSBL.Tgl_acc',
            'YTRANSBL.Manager',
            'YTRANSBL.Operator',
            'YTRANSBL.Batal_acc',
            'YTRANSBL.Batal_sppb',
            'YTRANSBL.No_sppb',
            'YTRANSBL.Direktur',
            'YTRANSBL.Tgl_Dibutuhkan',
            'YTRANSBL.StatusBeli',
            'Y_BARANG.NAMA_BRG',
            'YTRANSBL.Qty',
            'YTRANSBL.QtyCancel',
            'YTRANSBL.PriceUnit',
            'YTRANSBL.PriceSub',
            'YTRANSBL.PPN',
            'YTRANSBL.PriceExt',
            'YTRANSBL.Currency',
            'YSUPPLIER.NM_SUP',
            'YSUPPLIER.KOTA1',
            'YSUPPLIER.NEGARA1',
            'YSUPPLIER.ID_MATAUANG',
            'YUSER.Nama AS NmUser',
            'YTRANSBL.Ket_Internal',
            'YUSER_1.Nama AS AppMan',
            'YTRANSBL.Tgl_Direktur',
            'YTRANSBL.Tgl_PBL_Acc',
            'YUSER_2.Nama AS AppPBL',
            'ACCOUNTING.dbo.T_MATAUANG.Id_MataUang_BC AS Curr',
            'YUSER_3.Nama AS AppDir',
            'YTRANSBL.StatusBeli AS StBeli',
            'YTRANSBL.Kd_div',
            'YTRANSBL.Tgl_order',
            'YTRANSBL.No_trans',
            'YTRANSBL.Kd_brg',
            'YSATUAN.Nama_satuan',
            'YTRANSBL.Supplier as IdSup'
        )
            ->join('Y_BARANG', 'YTRANSBL.Kd_brg', '=', 'Y_BARANG.KD_BRG')
            ->join('Y_KATEGORI_SUB', 'Y_BARANG.NO_SUB_KATEGORI', '=', 'Y_KATEGORI_SUB.no_sub_kategori')
            ->join('Y_KATEGORY', function ($join) {
                $join->on('Y_KATEGORI_SUB.no_kategori', '=', 'Y_KATEGORY.no_kategori')
                    ->orWhere('Y_KATEGORI_SUB.no_kategori', '=', 'Y_KATEGORY.no_kategori');
            })
            ->join('Y_KATEGORI_UTAMA', 'Y_KATEGORY.no_kat_utama', '=', 'Y_KATEGORI_UTAMA.no_kat_utama')
            ->join('YSUPPLIER', 'YTRANSBL.Supplier', '=', 'YSUPPLIER.NO_SUP')
            ->join('YUSER', 'YTRANSBL.Operator', '=', 'YUSER.kd_user')
            ->join('YUSER as YUSER_1', 'YTRANSBL.Manager', '=', 'YUSER_1.kd_user')
            ->join('YUSER as YUSER_2', 'YTRANSBL.PBL_Acc', '=', 'YUSER_2.kd_user')
            ->join('ACCOUNTING.dbo.T_MATAUANG', 'YTRANSBL.Currency', '=', 'ACCOUNTING.dbo.T_MATAUANG.Id_MataUang')
            ->join('YUSER as YUSER_3', 'YTRANSBL.Direktur', '=', 'YUSER_3.kd_user')
            ->join('YSATUAN', 'YTRANSBL.NoSatuan', '=', 'YSATUAN.No_satuan')
            ->where('YTRANSBL.StatusOrder', 5)
            ->where('YTRANSBL.No_trans', $noTrans)
            ->get();
        // $data = db::connection('ConnPurchase')->select('exec SP_5409_LIST_ORDER @kd = ?, @noTrans = ?', [40, $noTrans]);
        return response()->json($data);
    }

    public function closeOrder(Request $request)
    {
        $kd = 16;
        $noTrans = $request->input('noTrans');
        $QtyCancel = $request->input('QtyCancel');
        $alasan = $request->input('alasan');
        $Operator = trim(Auth::user()->NomorUser);
        if (($noTrans != null) || ($QtyCancel != null)) {
            try {
                $data = DB::connection('ConnPurchase')->statement('exec SP_5409_MAINT_PO @Operator = ?, @kd = ?, @noTrans = ?, @alasan = ?, @QtyCancel = ?', [$Operator, $kd, $noTrans, $alasan, $QtyCancel]);
                return Response()->json(['message' => 'Data Berhasil DiClose Order', "data" => $data]);
            } catch (\Throwable $Error) {
                return Response()->json($Error);
            }
        } else {
            return Response()->json('Parameter harus di isi');
        }
    }
    public function backCreatePO(Request $request)
    {
        $kd = 15;
        $noTrans = $request->input('noTrans');
        if (($noTrans != null)) {
            try {
                $data = DB::connection('ConnPurchase')->statement('exec SP_5409_MAINT_PO @kd = ?, @noTrans = ?', [$kd, $noTrans]);
                return Response()->json(['message' => 'Data Berhasil DiBack Create PO', "data" => $data]);
            } catch (\Throwable $Error) {
                return Response()->json($Error);
            }
        } else {
            return Response()->json('Parameter harus di isi');
        }
    }
    public function openFormCreateSPPB(Request $request)
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('Beli');
        $noTrans = explode(',', $request->noTrans);
        $tahun = date('y', time());
        $mValue = DB::connection('ConnPurchase')->select('SELECT NO_SPPB FROM YCounter');
        $No_PO = '000000' . strval($mValue[0]->NO_SPPB);
        $No_PO = 'PO-' . $tahun . substr($No_PO, -6);
        DB::connection('ConnPurchase')->statement('update ycounter set NO_SPPB =' . $mValue[0]->NO_SPPB . '+ 1');
        // dd($noTrans);

        for ($i = 0; $i < count($noTrans); $i++) {
            db::connection('ConnPurchase')->statement(
                'exec SP_5409_MAINT_PO
            @kd = ?,
            @noTrans = ?,
            @NoPO = ?,
            @Operator = ?',
                [
                    2,
                    $noTrans[$i],
                    $No_PO,
                    trim(Auth::user()->NomorUser),
                ]
            );
        }

        $loadHeader = db::connection('ConnPurchase')->select('exec SP_5409_LIST_ORDER @kd = ?, @noPO = ?', [14, $No_PO]);
        $loadPermohonan = db::connection('ConnPurchase')->select('exec SP_5409_LIST_ORDER @kd = ?, @noPO = ?', [13, $No_PO]);
        // dd($loadPermohonan);
        $namaDiv = db::connection('ConnPurchase')->table("YDIVISI")->select("YDIVISI.NM_DIV")->where("YDIVISI.KD_DIV", trim($loadPermohonan[0]->Kd_div))->get();
        $supplier = db::connection('ConnPurchase')->select('exec SP_4384_PBL_Maintenance_Supplier @XKode = ?', [0]);
        // dd($supplier);
        $listPayment = db::connection('ConnPurchase')->select('exec SP_5409_LIST_PAYMENT');
        $mataUang = db::connection('ConnPurchase')->select('exec SP_7775_PBL_LIST_MATA_UANG');
        $ppn = db::connection('ConnPurchase')->select('exec SP_5409_LIST_PPN');
        // dd($loadHeader, $loadPermohonan);
        return view('Beli.TransaksiBeli.PurchaseOrder.CreateSPPB', compact('access', 'supplier', 'listPayment', 'mataUang', 'ppn', 'No_PO', 'loadPermohonan', 'loadHeader', 'namaDiv'));
    }
    public function daftarSupplier(Request $request)
    {
        $kd = 1;
        $idsup = $request->input('idsup');
        try {
            $supplier = DB::connection('ConnPurchase')->select('exec SP_1273_PBL_LIST_SUPPLIER @kd = ?, @idsup = ?', [$kd, $idsup]);
            return Response()->json($supplier);
        } catch (\Throwable $Error) {
            return Response()->json($Error);
        }
    }
    public function print(Request $request)
    {
        $noPO = $request->input('noPO');
        if (($noPO !== null)) {
            try {
                $print = DB::connection('ConnPurchase')
                    ->table('VW_5409_PRINT_PO')
                    ->where('VW_5409_PRINT_PO.NO_PO', $noPO)
                    ->orderBy('No_trans', 'asc')->get();
                $printHeader = DB::connection('ConnPurchase')->table('VW_5409_PRINT_HEADER_PO')->where('VW_5409_PRINT_HEADER_PO.NO_PO', $noPO)->get();
                return Response()->json(["print" => $print, "printHeader" => $printHeader]);
            } catch (\Throwable $Error) {
                return Response()->json($Error);
            }
        } else {
            return Response()->json('Parameter harus di isi');
        }
    }
    public function submit(Request $request)
    {
        //untuk qty delay
        $kd = 15;
        $noTrans = $request->input('noTrans');
        $QtyDelay = $request->input('QtyDelay');
        if (($noTrans !== null && $QtyDelay !== null)) {
            try {
                $submit = DB::connection('ConnPurchase')->statement('exec SP_5409_SAVE_ORDER @kd = ?, @noTrans = ?, @QtyDelay = ?', [$kd, $noTrans, $QtyDelay]);
                return Response()->json(['message' => 'Data Berhasil Ditambahkan']);
            } catch (\Throwable $Error) {
                return Response()->json($Error);
            }
        } else {
            return Response()->json('Parameter harus di isi');
        }
    }
    public function update(Request $request)
    {
        $No_PO = $request->input('No_PO');
        $kd = 3;
        $Qty = $request->input('Qty');
        $QtyCancel = $request->input('QtyCancel');
        $kurs = $request->input('kurs');
        $pUnit = $request->input('pUnit');
        $pSub = $request->input('pSub');
        $pDPP = $request->input('pDPP');
        $pIDRDPP = $request->input('pIDRDPP');
        $idPPN = $request->input('idPPN');
        $pPPN = $request->input('pPPN');
        $pTot = $request->input('pTot');
        $pIDRUnit = $request->input('pIDRUnit');
        $pIDRSub = $request->input('pIDRSub');
        $pIDRPPN = $request->input('pIDRPPN');
        $pIDRTot = $request->input('pIDRTot');
        $Operator = trim(Auth::user()->NomorUser);
        $persen = $request->input('persen');
        $disc = $request->input('disc');
        $discIDR = $request->input('discIDR');
        $noTrans = $request->input('noTrans');
        if (
            ($Qty !== null) ||
            ($QtyCancel !== null) ||
            ($kurs !== null) ||
            ($pUnit !== null) ||
            ($pSub !== null) ||
            ($idPPN !== null) ||
            ($pPPN !== null) ||
            ($pTot !== null) ||
            ($pIDRUnit !== null) ||
            ($pIDRSub !== null) ||
            ($pIDRPPN !== null) ||
            ($pIDRTot !== null) ||
            ($persen !== null) ||
            ($disc !== null) ||
            ($discIDR !== null) ||
            ($noTrans !== null)
        ) {
            try {
                $update = DB::connection('ConnPurchase')
                    ->statement('exec SP_5409_MAINT_PO @kd = ?, @Qty = ?, @QtyCancel = ?, @kurs = ?, @pUnit = ?, @pSub = ?, @idPPN = ?,
                        @pPPN = ?, @pTot = ?, @pIDRUnit = ?, @pIDRSub = ?, @pIDRPPN = ?, @pIDRTot = ?, @Operator = ?, @persen = ?, @disc = ?,
                        @discIDR = ?, @noTrans = ?, @pDPP = ?, @pIDRDPP = ?',
                        [
                            $kd,
                            $Qty,
                            $QtyCancel,
                            $kurs,
                            $pUnit,
                            $pSub,
                            $idPPN,
                            $pPPN,
                            $pTot,
                            $pIDRUnit,
                            $pIDRSub,
                            $pIDRPPN,
                            $pIDRTot,
                            $Operator,
                            $persen,
                            $disc,
                            $discIDR,
                            $noTrans,
                            $pDPP,
                            $pIDRDPP
                        ]
                    );
                $loadPermohonan = db::connection('ConnPurchase')->select('exec SP_5409_LIST_ORDER @kd = ?, @noPO = ?', [13, $No_PO]);
                // if ($QtyCancel > 0) {
                //     DB::connection('ConnPurchase')->statement('exec SP_5409_SAVE_ORDER @kd = ?, @noTrans = ?, @QtyDelay = ?', [15, $noTrans, $QtyCancel]);
                //     return Response()->json(['message' => 'Data Berhasil DiApprove dan order baru sudah dibuat untuk quantity delay sebanyak ' . $QtyCancel, 'data' => $loadPermohonan]);
                // }
                return Response()->json(['message' => 'Data Berhasil diupdate', 'data' => $loadPermohonan]);
            } catch (\Throwable $Error) {
                return Response()->json($Error);
            }
        } else {
            return Response()->json('Parameter harus di isi');
        }
    }
    public function remove(Request $request)
    {
        $kd = 6;
        $noTrans = $request->input('noTrans');
        if (($noTrans !== null)) {
            try {
                $remove = DB::connection('ConnPurchase')->statement('exec SP_5409_MAINT_PO @kd = ?, @noTrans = ?', [$kd, $noTrans]);
                return Response()->json(['message' => 'Data Berhasil Remove']);
            } catch (\Throwable $Error) {
                return Response()->json($Error);
            }
        } else {
            return Response()->json('Parameter harus di isi');
        }
    }
    public function reject(Request $request)
    {
        $kd = 4;
        $noTrans = $request->input('noTrans');
        $alasan = $request->input('alasan');
        $Operator = trim(Auth::user()->NomorUser);

        if (
            ($noTrans !== null) &&
            ($alasan !== null)
        ) {
            try {
                $reject = DB::connection('ConnPurchase')->statement('exec SP_5409_MAINT_PO @kd = ?, @noTrans = ?, @alasan = ?, @Operator = ?', [$kd, $noTrans, $alasan, $Operator]);
                return Response()->json(['message' => 'Data Berhasil Reject']);
            } catch (\Throwable $Error) {
                return Response()->json($Error);
            }
        } else {
            return Response()->json('Parameter harus di isi');
        }
    }
    public function post(Request $request)
    {
        $kd = 5;
        $noTrans = $request->input('noTrans');
        $mtUang = $request->input('mtUang');
        $tglPO = Carbon::parse($request->input('tglPO'));
        $tglPO->setTimeFrom(Carbon::now()->setTimezone('Asia/Jakarta'));
        $Operator = trim(Auth::user()->NomorUser);
        $idpay = $request->input('idpay');
        $jumCetak = 1;
        $Tgl_Dibutuhkan = Carbon::parse($request->input('Tgl_Dibutuhkan'));
        $idSup = $request->input('idSup');

        if (
            ($noTrans !== null) ||
            ($mtUang !== null) ||
            ($tglPO !== null) ||
            ($idpay !== null) ||
            ($Tgl_Dibutuhkan !== null) ||
            ($idSup !== null)
        ) {
            try {
                $post = DB::connection('ConnPurchase')
                    ->statement('exec SP_5409_MAINT_PO @kd = ?, @noTrans = ?, @mtUang =?, @tglPO =? , @idpay = ? , @jumCetak =?, @Tgl_Dibutuhkan = ?,
                                        @idsup = ?, @Operator = ?',
                        [$kd, $noTrans, $mtUang, $tglPO, $idpay, $jumCetak, $Tgl_Dibutuhkan, $idSup, $Operator]
                    );
                return Response()->json(['message' => 'Data Berhasil Post']);
            } catch (\Throwable $Error) {
                return Response()->json($Error);
            }
        } else {
            return Response()->json('Parameter harus di isi');
        }
    }

    //Store a newly created resource in storage.
    public function store(Request $request)
    {
    }
    public function show($id)
    {
        $sup = DB::connection('ConnPurchase')->select('exec SP_4384_PBL_Maintenance_Supplier @XKode = ?', [0]);
        $access = (new HakAksesController)->HakAksesFiturMaster('Beli');
        $result = (new HakAksesController)->HakAksesFitur('Close / Cancel PO');
        if ($result > 0) {
            return view('Beli.TransaksiBeli.PurchaseOrder.CancelPO', compact('sup', 'access', 'result'));
        } else {
            abort(404);
        }
    }

    public function show1(Request $request)
    {
        $idSup = $request->input('idSup');
        $kd = 15;

        $purchaseorder = DB::connection('ConnPurchase')->select('exec SP_5409_LIST_ORDER @kd =?, @idSup =?', [$kd, $idSup]);

        return response()->json($purchaseorder);
    }

    public function showtbl(Request $request)
    {
        $noPO = $request->input('noPO');
        $kd = 16;

        $purchaseorder = DB::connection('ConnPurchase')->select('exec SP_5409_LIST_ORDER @kd =?, @noPO =?', [$kd, $noPO]);
        $supp = DB::connection('ConnPurchase')->table('YTRANSBL')->select('Supplier')->where('NO_PO', '=', $noPO)->get();
        return Response()->json(['data' => $purchaseorder, 'supplier' => $supp]);

        // return response()->json($purchaseorder);
    }


    public function cancel(Request $request) //remove
    {
        $noTrans = $request->input('noTrans');
        $kd = 17;
        $QtyCancel = $request->input('QtyCancel');
        $alasan = $request->input('alasan');

        $purchaseorder = DB::connection('ConnPurchase')->statement('exec SP_5409_MAINT_PO @kd=?, @noTrans=?, @QtyCancel=?, @alasan=?', [$kd, $noTrans, $QtyCancel, $alasan]);

        return response()->json($purchaseorder);
    }

    public function cancel1(Request $request) //cancel PO
    {
        $Operator = trim(Auth::user()->NomorUser);
        $QtyCancel = $request->input('QtyCancel');
        $alasan = $request->input('alasan');
        $noTrans = $request->input('noTrans');
        $kd = 16;

        $purchaseorder = DB::connection('ConnPurchase')->statement('exec SP_5409_MAINT_PO @kd=?, @Operator=?, @QtyCancel=?, @alasan=?, @noTrans=?', [$kd, $Operator, $QtyCancel, $alasan, $noTrans]);

        return response()->json($purchaseorder);
    }


    //Display the specified resource.
    public function redisplay(Request $request)
    {
        $MinDate = Carbon::parse($request->input('MinDate'));
        $MaxDate = Carbon::parse($request->input('MaxDate'));
        $MaxDate->setTimeFrom(Carbon::now()->setTimezone('Asia/Jakarta'));
        $noPO = $request->input('noPO');
        if (
            ($MinDate !== null) ||
            ($MaxDate !== null) ||
            ($noPO !== null)
        ) {
            try {
                if ($noPO == null) {
                    $purchaseorder = DB::connection('ConnPurchase')->select('exec SP_5409_LIST_ORDER @kd =?, @MinDate=?, @MaxDate=?', [22, $MinDate, $MaxDate]);
                } else {
                    $purchaseorder = DB::connection('ConnPurchase')->select('exec SP_5409_LIST_ORDER @kd =?, @noPO =?', [21, $noPO]);
                }
                return datatables($purchaseorder)->make(true);
            } catch (\Throwable $Error) {
                return Response()->json($Error);
            }
        } else {
            return Response()->json('Parameter harus di isi');
        }
        // return response()->json($purchaseorder);
    }

    public function display(Request $request)
    {
        $noPO = $request->input('noPO');
        $kd = 21;

        $purchaseorder = DB::connection('ConnPurchase')->select('exec SP_5409_LIST_ORDER @kd =?, @noPO =?', [$kd, $noPO]);

        return response()->json($purchaseorder);
    }

    public function reviewPO(Request $request)
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('Beli');
        $No_PO = $request->query('No_PO');
        $loadPermohonan = DB::connection('ConnPurchase')->select('exec SP_5409_LIST_ORDER @kd =?, @noPO =?', [26, $No_PO]);
        $loadHeader = DB::connection('ConnPurchase')->select('exec SP_5409_LIST_ORDER @kd =?, @noPO =?', [25, $No_PO]);
        // dd($No_PO);
        return view('Beli.TransaksiBeli.PurchaseOrder.ListPO.ReviewPO', compact('access', 'No_PO', 'loadPermohonan', 'loadHeader'));
    }

    public function printReviewPO(Request $request)
    {
        $kd = 12;
        $NoPO = $request->input('NoPO');
        $tglPO = Carbon::parse($request->input('tglPO'));
        $tglPO->setTimeFrom(Carbon::now()->setTimezone('Asia/Jakarta'));
        $Tgl_Dibutuhkan = Carbon::parse($request->input('Tgl_Dibutuhkan'));

        if (
            ($NoPO !== null) ||
            ($tglPO !== null) ||
            ($Tgl_Dibutuhkan !== null)
        ) {
            try {
                $post = DB::connection('ConnPurchase')->statement('exec SP_5409_MAINT_PO @kd = ?, @NoPO = ?,  @tglPO =?, @Tgl_Dibutuhkan = ?', [$kd, $NoPO, $tglPO, $Tgl_Dibutuhkan]);
                return Response()->json(['message' => 'Data Berhasil Post', 'status' => $post]);
            } catch (\Throwable $Error) {
                return Response()->json($Error);
            }
        } else {
            return Response()->json('Parameter harus di isi');
        }
    }
    public function reviewBTTB(Request $request)
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('Beli');
        $No_BTTB = $request->query('No_BTTB');
        $loadPermohonan = DB::connection('ConnPurchase')->select('exec SP_5409_LIST_ORDER @kd =?, @noBTTB =?', [28, $No_BTTB]);
        $loadHeader = DB::connection('ConnPurchase')->select('exec SP_5409_LIST_ORDER @kd =?, @noBTTB =?', [31, $No_BTTB]);
        // dd($No_BTTB);
        return view('Beli.TransaksiBeli.PurchaseOrder.ListPO.ReviewBTTB', compact('access', 'No_BTTB', 'loadPermohonan', 'loadHeader'));
    }
    public function printReviewBTTB(Request $request)
    {
        $kd = 13;
        $tglDatang = Carbon::parse($request->input('tglDatang'));
        $SJ = $request->input('SJ');
        $NoPIB = $request->input('NoPIB');
        $BTTB = $request->input('BTTB');
        $NoPIBExt = $request->input('NoPIBExt');
        $TglPIB = Carbon::parse($request->input('TglPIB'));
        $NoSPPBBC = $request->input('NoSPPBBC');
        $TglSPPBBC = Carbon::parse($request->input('TglSPPBBC'));
        $NoSKBM = $request->input('NoSKBM');
        $TglSKBM = Carbon::parse($request->input('TglSKBM'));
        $NoReg = $request->input('NoReg');
        $TglReg = Carbon::parse($request->input('TglReg'));

        if (($BTTB !== null)) {
            try {
                $post = DB::connection('ConnPurchase')->statement('exec SP_5409_MAINT_PO @kd = ?,@tglDatang = ?, @SJ = ?, @NoPIB = ?, @BTTB = ?,@NoPIBExt = ?,@TglPIB = ?,@NoSPPBBC = ?,@TglSPPBBC = ?,@NoSKBM = ?,@TglSKBM = ?,@NoReg = ?,@TglReg = ?', [
                    $kd,
                    $tglDatang,
                    $SJ,
                    $NoPIB,
                    $BTTB,
                    $NoPIBExt,
                    $TglPIB,
                    $NoSPPBBC,
                    $TglSPPBBC,
                    $NoSKBM,
                    $TglSKBM,
                    $NoReg,
                    $TglReg
                ]);
                return Response()->json(['message' => 'Data Berhasil Post', 'status' => $post]);
            } catch (\Throwable $Error) {
                return Response()->json($Error);
            }
        } else {
            return Response()->json('Parameter harus di isi');
        }
    }
    //Show the form for editing the specified resource.
    public function edit($id)
    {
        //
    }



    //Remove the specified resource from storage.
    public function destroy($id)
    {
        //
    }
}
