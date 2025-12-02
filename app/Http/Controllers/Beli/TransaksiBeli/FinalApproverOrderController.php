<?php

namespace APP\HTTP\Controllers\Beli\TransaksiBeli;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HakAksesController;
use App\Models\Beli\TransBL;
use DB;

class FinalApproverOrderController extends Controller
{
    public function index()
    {
        $kd = 36;
        $operator = '1001';
        $access = (new HakAksesController)->HakAksesFiturMaster('Beli');
        $result = (new HakAksesController)->HakAksesFitur('Final Approve');
        if ($result > 0) {
            $data = DB::connection('ConnPurchase')->select('exec SP_5409_LIST_ORDER @kd = ?, @Operator=?', [$kd, $operator]);
            // dd($data);
            return view('Beli.TransaksiBeli.FinalApproveOrder.List', compact('data', 'access'));
        } else {
            abort(403);
        }
    }

    public function store(Request $request)
    {
        $Checked = $request->input('checkedBOX');
        $date = date("Y-m-d H:i:s");
        if (empty($Checked)) {
            echo 'kosong';
            return back()->with('danger', 'Gagal Approve/Reject, Karena Tidak Ada Data yang Dipilih');
        }
        switch ($request->input('action')) {
            case 'Approve':
                foreach ($Checked as $item) {
                    TransBL::where('No_trans', $item)->update(['Tgl_Direktur' => $date, 'Direktur' => Auth::user()->kd_user, 'StatusOrder' => '4']);
                }
                return back();

            case 'Reject':
                foreach ($Checked as $item) {
                    TransBL::where('No_trans', $item)->update(['Tgl_Batal_acc' => $date, 'Batal_acc' => Auth::user()->kd_user, 'StatusOrder' => '0']);
                }
                return back();
        }
    }
    public function show($id)
    {
        $data = TransBL::select('Y_KATEGORI_UTAMA.nama as KatUtama', 'Y_KATEGORY.nama_kategori as kategori', 'Y_KATEGORI_SUB.nama_sub_kategori as SubKat', 'Y_BARANG.NAMA_BRG as NamaBarang', 'Qty', 'Nama_satuan', 'Pemesan', 'YUSER.Nama as User', 'StatusBeli', 'Tgl_Dibutuhkan', 'Ket_Internal', 'keterangan', 'YSUPPLIER.NM_SUP as supplier', 'YSUPPLIER.KOTA1 as kota', 'YSUPPLIER.NEGARA1 as negara', 'PriceUnit', 'PriceSub', 'PriceExt', 'Currency', 'PPN', 'YUSER_ACC.Nama as Manager', 'Tgl_acc', 'offered.Nama as Offered', 'Tgl_PBL_Acc', 'Kd_div')->leftjoin('Y_BARANG', 'Y_BARANG.KD_BRG', 'YTRANSBL.Kd_brg')->leftjoin('YUSER', 'YUSER.kd_user', 'YTRANSBL.Operator')->leftjoin('YSATUAN', 'YSATUAN.No_satuan', 'YTRANSBL.NoSatuan')->leftjoin('STATUS_ORDER', 'STATUS_ORDER.KdStatus', 'YTRANSBL.StatusOrder')->leftjoin('Y_KATEGORI_SUB', 'Y_KATEGORI_SUB.no_sub_kategori', 'Y_BARANG.NO_SUB_KATEGORI')->leftjoin('Y_KATEGORY', 'Y_KATEGORY.no_kategori', 'Y_KATEGORI_SUB.no_kategori')->leftjoin('Y_KATEGORI_UTAMA', 'Y_KATEGORI_UTAMA.no_kat_utama', 'Y_KATEGORY.no_kat_utama')->leftjoin('YSUPPLIER', 'YSUPPLIER.NO_SUP', 'YTRANSBL.supplier')->leftjoin('YUSER_ACC', 'YUSER_ACC.Kd_user', 'YTRANSBL.Manager')->leftjoin('YUSER as offered', 'offered.kd_user', 'YTRANSBL.PBL_Acc')->where('No_trans', $id)->first();

        $getKD_Barang = TransBL::select('Kd_brg')->where('No_trans', $id)->first();
        $dataBeliTerakhir = TransBL::select()->leftjoin('YSUPPLIER', 'YSUPPLIER.NO_SUP', 'YTRANSBL.supplier')->where('Kd_brg', $getKD_Barang->Kd_brg)->wherein('StatusOrder', [4, 5, 8, 10, 11])->orderBy('No_trans', 'desc')->offset(0)->limit(1)->get();

        return compact('data', 'dataBeliTerakhir', 'getKD_Barang');
    }

    public function update(Request $request, $id)
    {
        switch ($request->input('action')) {
            case 'Approve':
                $date = date("Y-m-d H:i:s");
                TransBL::where('No_trans', $id)->update(['Tgl_Direktur' => $date, 'Direktur' => Auth::user()->kd_user, 'StatusOrder' => '4']);
                return back();

            case 'Reject':
                $date = date("Y-m-d H:i:s");
                TransBL::where('No_trans', $id)->update(['Tgl_Batal_acc' => $date, 'Batal_acc' => Auth::user()->kd_user, 'StatusOrder' => '0']);
                return back();
        }
    }

    // public function destroy($id)
    // {
    //     $HapusBarang = Barang::find($id);
    //     $HapusBarang->status = "Dihapus";
    //     $HapusBarang->save();



    //     return back();
    // }
}
