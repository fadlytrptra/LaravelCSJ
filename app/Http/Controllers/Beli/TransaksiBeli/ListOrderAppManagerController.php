<?php

namespace App\Http\Controllers\Beli\TransaksiBeli;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HakAksesController;
use DB;
use Illuminate\Support\Facades\Auth;

class ListOrderAppManagerController extends Controller
{
    public function index()
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('Beli');
        $result = (new HakAksesController)->HakAksesFitur('List Order Sudah App Manager');
        if ($result > 0) {
            return view('Beli.TransaksiBeli.ListOrderAppManager.List', compact('access'));
        } else {
            abort(403);
        }
    }
    public function redisplayNoOrder(Request $request)
    {
        $noOrder = $request->input('noOrder');
        if (($noOrder != null)) {
            try {
                $redisplay = DB::connection('ConnPurchase')->table('YTRANSBL')
                    ->select(
                        'YTRANSBL.Tgl_acc',
                        'YTRANSBL.No_trans',
                        DB::raw("CASE WHEN YTRANSBL.StatusBeli = 1 THEN 'Pengadaan Pembelian' ELSE 'Beli Sendiri' END AS StatusBeli"),
                        'YTRANSBL.Kd_brg',
                        'Y_BARANG.NAMA_BRG',
                        'Y_KATEGORI_SUB.nama_sub_kategori',
                        'YTRANSBL.Qty',
                        'YSATUAN.Nama_satuan',
                        'YUSER.Nama',
                        'YTRANSBL.Kd_div',
                        'YTRANSBL.Tgl_Dibutuhkan',
                        'YTRANSBL.keterangan',
                        'YTRANSBL.Ket_Internal',
                        'STATUS_ORDER.Status',
                        'YTRANSBL.Operator',
                        'YTRANSBL.StatusOrder',
                        'YDIVISI.NM_DIV'
                    )
                    ->join('Y_BARANG', 'YTRANSBL.Kd_brg', '=', 'Y_BARANG.KD_BRG')
                    ->join('STATUS_ORDER', 'YTRANSBL.StatusOrder', '=', 'STATUS_ORDER.KdStatus')
                    ->join('YUSER', 'YTRANSBL.Operator', '=', 'YUSER.kd_user')
                    ->join('YSATUAN', 'YTRANSBL.NoSatuan', '=', 'YSATUAN.No_satuan')
                    ->join('Y_KATEGORI_SUB', 'Y_BARANG.NO_SUB_KATEGORI', '=', 'Y_KATEGORI_SUB.no_sub_kategori')
                    ->join('YDIVISI', 'YTRANSBL.Kd_div', '=', 'YDIVISI.KD_DIV')
                    ->where('YTRANSBL.StatusOrder', 2)
                    ->where('YTRANSBL.No_trans', $noOrder)
                    ->get();
                return datatables($redisplay)->make(true);
            } catch (\Throwable $Error) {
                return Response()->json($Error);
            }
        } else {
            return Response()->json('Parameter harus di isi');
        }
    }
    public function redisplay(Request $request)
    {
        $kd = 10;
        $Kd_Div = $request->input('Kd_Div');
        $stBeli = $request->input('stBeli');
        $MinDate = $request->input('MinDate');
        $MaxDate = $request->input('MaxDate');
        if (($Kd_Div != null) && ($stBeli != null) && ($MinDate != null) && ($MaxDate != null)) {
            try {
                $redisplay = DB::connection('ConnPurchase')->select('exec SP_5409_LIST_ORDER @stBeli=?, @Kd_Div = ?, @kd = ?, @MinDate = ?, @MaxDate = ?', [$stBeli, $Kd_Div, $kd, $MinDate, $MaxDate]);
                return datatables($redisplay)->make(true);
            } catch (\Throwable $Error) {
                return Response()->json($Error);
            }
        } else {
            return Response()->json('Parameter harus di isi');
        }
    }
    public function divisi()
    {
        $Operator = trim(Auth::user()->NomorUser);
        try {
            $data = DB::connection('ConnPurchase')->select('exec spSelect_UserDivisi_dotNet @Operator = ?, @kd = ?', [$Operator, 1]);
            return Response()->json($data);
        } catch (\Throwable $Error) {
            return Response()->json($Error);
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
    }

    //Remove the specified resource from storage.
    public function destroy($id)
    {
        //
    }
}
