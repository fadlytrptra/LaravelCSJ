<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransBL;
use App\User;
use DB;
use Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $AccessProgram = DB::connection('ConnEDP')->table('User_Fitur')
            ->select('NamaProgram', 'RouteProgram')
            ->join('FiturMaster', 'Id_Fitur', 'IdFitur')
            ->join('MenuMaster', 'Id_Menu', 'IdMenu')
            ->join('ProgramMaster', 'Id_Program', 'IdProgram')
            ->groupBy('NamaProgram', 'RouteProgram')
            ->where('Id_User', Auth::user()->IDUser)
            ->OrWhere('Id_User', 218)->get();
        return view('home', compact('AccessProgram'));
    }
    public function Sales()
    {
        $result = (new HakAksesController)->HakAksesProgram('Sales');
        $access = (new HakAksesController)->HakAksesFiturMaster('Sales');
        if ($result > 0) {
            return view('layouts.appSales', compact('access'));
        } else {
            return redirect('home')->with('status', 'Anda Tidak Memiliki Hak Akses Program Sales!');

        }
    }
    public function Beli()
    {
        $result = (new HakAksesController)->HakAksesProgram('Beli');
        $access = (new HakAksesController)->HakAksesFiturMaster('Beli');
        if ($result > 0) {
            return view('layouts.appOrderPembelian', compact('access'));
        } else {
            // abort(403);
            return redirect('home')->with('status', 'Anda Tidak Memiliki Hak Akses Program Beli!');
        }
    }
    public function EDP()
    {
        $result = (new HakAksesController)->HakAksesProgram('EDP');
        $access = (new HakAksesController)->HakAksesFiturMaster('EDP');
        if ($result > 0) {
            return view('layouts.appEDP', compact('access'));
        } else {
            // abort(403);
            return redirect('home')->with('status', 'Anda Tidak Memiliki Hak Akses Program EDP!');
        }
    }
    public function GPS()
    {
        $result = (new HakAksesController)->HakAksesProgram('Workshop');
        $access = (new HakAksesController)->HakAksesFiturMaster('Workshop');
        if ($result > 0) {
            return view('layouts.appGPS', compact('access'));
        } else {
            // abort(403);
            return redirect('home')->with('status', 'Anda Tidak Memiliki Hak Akses!');
        }
    }
    public function Workshop()
    {
        $result = (new HakAksesController)->HakAksesProgram('Workshop'); //belum diatur
        $access = (new HakAksesController)->HakAksesFiturMaster('Workshop'); //belum diatur
        if ($result > 0) {
            return view('layouts.appWorkshop', compact('access'));
        } else {
            // abort(403);
            return redirect('home')->with('status', 'Anda Tidak Memiliki Hak Akses Program Workshop!');
        }
    }
    public function Utility()
    {
        $result = (new HakAksesController)->HakAksesProgram('Utility');
        $access = (new HakAksesController)->HakAksesFiturMaster('Utility');
        // dd($result,$access);
        if ($result > 0) {
            return view('layouts.appUtility', compact('access'));
        } else {
            return redirect('home')->with('status', 'Anda Tidak Memiliki Hak Akses Program Utlity!');

        }
    }
    public function WovenBag()
    {
        $result = (new HakAksesController)->HakAksesProgram('Woven Bag');
        $access = (new HakAksesController)->HakAksesFiturMaster('Woven Bag');
        // dd($result,$access);
        if ($result > 0) {
            return view('layouts.appWovenBag', compact('access'));
        } else {
            return redirect('home')->with('status', 'Anda Tidak Memiliki Hak Akses Program Woven Bag!');

        }
    }
    public function JumboBag()
    {
        $result = (new HakAksesController)->HakAksesProgram('Jumbo Bag');
        $access = (new HakAksesController)->HakAksesFiturMaster('Jumbo Bag');
        // dd($result,$access);
        if ($result > 0) {
            return view('layouts.appJumboBag', compact('access'));
        } else {
            return redirect('home')->with('status', 'Anda Tidak Memiliki Hak Akses Program Jumbo Bag!');
        }
    }
    function Accounting()
    {
        $result = (new HakAksesController)->HakAksesProgram('Accounting');
        $access = (new HakAksesController)->HakAksesFiturMaster('Accounting');
        // dd($access);
        if ($result > 0) {
            return view('layouts.appAccounting', compact('access'));
        } else {
            return redirect('home')->with('status', 'Anda Tidak Memiliki Hak Akses Program Accounting!');
        }
    }

    public function Circular()
    {
        $result = (new HakAksesController)->HakAksesProgram('Circular');
        $access = (new HakAksesController)->HakAksesFiturMaster('Circular');
        if ($result > 0) {
            return view('Circular.home', compact('access'));
        } else {
            return redirect('home')->with('status', 'Anda Tidak Memiliki Hak Akses Program Circular!');
        }
    }
    public function CircularB()
    {
        $result = (new HakAksesController)->HakAksesProgram('Circular B');
        $access = (new HakAksesController)->HakAksesFiturMaster('Circular B');
        if ($result > 0) {
            return view('CircularB.home', compact('access'));
        } else {
            return redirect('home')->with('status', 'Anda Tidak Memiliki Hak Akses Program Circular Gedung B!');
        }
    }
    public function CircularD()
    {
        $result = (new HakAksesController)->HakAksesProgram('Circular D');
        $access = (new HakAksesController)->HakAksesFiturMaster('Circular D');
        if ($result > 0) {
            return view('CircularD.home', compact('access'));
        } else {
            return redirect('home')->with('status', 'Anda Tidak Memiliki Hak Akses Program Circular Gedung D!');
        }
    }
    public function Inventory()
    {
        $result = (new HakAksesController)->HakAksesProgram('Inventory');
        $access = (new HakAksesController)->HakAksesFiturMaster('Inventory');
        if ($result > 0) {
            return view('layouts.appInventory', compact('access'));
        } else {
            return redirect('home')->with('status', 'Anda Tidak Memiliki Hak Akses Program Inventory!');
        }
    }

    public function ABM()
    {
        $result = (new HakAksesController)->HakAksesProgram('ABM');
        $access = (new HakAksesController)->HakAksesFiturMaster('ABM');
        if ($result > 0) {
            return view('layouts.appABM', compact('access'));
        } else {
            return redirect('home')->with('status', 'Anda Tidak Memiliki Hak Akses Program ABM!');
        }
    }

    public function ADS()
    {
        $result = (new HakAksesController)->HakAksesProgram('AD Star');
        $access = (new HakAksesController)->HakAksesFiturMaster('AD Star');
        // $counterBrg = DB::connection('ConnPurchase')->table('YCOUNTER')->select('Y_BARANG')->get();
        // dd(intval($counterBrg[0]->Y_BARANG) + 1);
        if ($result) {
            return view('layouts.appAdStar', compact('access'));
        } else {
            return redirect('home')->with('status', 'Anda Tidak Memiliki Hak Akses Program Ad Star!');
        }
    }
    public function Laporan()
    {
        $result = (new HakAksesController)->HakAksesProgram('Laporan');
        $access = (new HakAksesController)->HakAksesFiturMaster('Laporan');
        if ($result > 0) {
            return view('layouts.appLaporan', compact('access'));
        } else {
            // abort(403);
            return redirect('home')->with('status', 'Anda Tidak Memiliki Hak Akses Program Laporan!');
        }
    }
}
