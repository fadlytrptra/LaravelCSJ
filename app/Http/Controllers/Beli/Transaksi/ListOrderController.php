<?php

namespace App\Http\Controllers\Beli\Transaksi;

use Illuminate\Http\Request;
use App\Models\Beli\TransBL;
use App\User;
use App\UserDiv;
use Auth;
use Carbon\Carbon;
use DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HakAksesController;

class ListOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('Beli');
        $dateAwal = Carbon::now()->subMonth()->format('Y-m-d');
        $dateAkhir = Carbon::now()->format('Y-m-d');
        $idUser = trim(Auth::user()->NomorUser);
        $dataDiv = DB::connection('ConnPurchase')->select('exec SP_1273_PRG_User_Divisi @Operator = ' . rtrim($idUser) . '');
        $kategoriUtama = DB::connection('ConnPurchase')->select('exec SP_1273_PRG_Select_HirarkiTypeBarang @MyType = ?', [1]);
        $satuanList = DB::connection('ConnPurchase')->select('exec SP_1273_PRG_LIST_STRI');

        if (count($dataDiv) > 0) {
            $data = DB::connection('ConnPurchase')->select('exec SP_1273_PRG_Select_Permohonan @MinDate = ?, @MaxDate = ?, @Kd_Div = ?', [$dateAwal, $dateAkhir, trim($dataDiv[0]->Kd_div)]);
            return view('Beli.Transaksi.ListOrder.List', compact('data', 'dataDiv', 'access', 'idUser', 'kategoriUtama', 'satuanList', 'dateAwal', 'dateAkhir'));
        } else {
            return redirect('Beli')->with('status', (string) 'User anda: ' . $idUser . ' Belum terdaftar pada divisi manapun, silahkan hubungi EDP!');
        }
    }

    public function show($id)
    {
        if ($id != null) {
            try {
                $data = DB::connection('ConnPurchase')->select('exec SpSelect_Detail_Permohonan_dotNet @No_Trans = ?', [$id]);

                return Response()->json($data);
            } catch (\Throwable $Error) {
                return Response()->json($Error);
            }
        } else {
            return Response()->json('Parameter harus di isi');
        }
        ;
    }

    public function filter($divisi, $tglAwal, $tglAkhir, $Me)
    {
        // dd($divisi, $tglAwal, $tglAkhir, $Me);
        if ($Me == "true") {
            $data = DB::connection('ConnPurchase')
                ->select('exec SP_1273_PRG_Select_Permohonan
                @MinDate = ?,
                @MaxDate = ?,
                @Kd_Div = ?,
                @Operator = ?',
                    [
                        $tglAwal,
                        $tglAkhir,
                        trim($divisi),
                        trim(Auth::user()->NomorUser)
                    ]
                );
        } else {
            $data = DB::connection('ConnPurchase')
                ->select('exec SP_1273_PRG_Select_Permohonan
                @MinDate = ?,
                @MaxDate = ?,
                @Kd_Div = ?',
                    [
                        $tglAwal,
                        $tglAkhir,
                        trim($divisi),
                    ]
                );
        }

        return compact('data');
    }


}
