<?php

namespace App\Http\Controllers\Beli\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\HakAksesController;
use Auth;
use DB;
use Exception;

class MaintenanceGolonganDanMesinController extends Controller
{
    public function index()
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('Beli');
        $result = (new HakAksesController)->HakAksesFitur('Maintenance Golongan Dan Mesin');
        if ($result > 0) {
            return view('Beli.Master.MaintenanceGolonganDanMesin.index', compact('access'));
        } else {
            abort(404);
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $jenisProses = $request->jenisProses;
        $idDivisi = $request->idDivisi;
        $namaGolongan = $request->namaGolongan;
        $namaMesin = $request->namaMesin;
        $noGolongan = $request->noGolongan;
        $noMesin = $request->noMesin;
        try {
            if ($jenisProses == 'insertGolongan') {
                DB::connection('ConnPurchase')
                    ->statement('exec SP_4384_PRG_MaintenanceGolonganDanMesin @XKode= ?, @XNoGol = ?, @XNamaGol = ?, @XIdDivisi = ?', [1, $noGolongan, $namaGolongan, $idDivisi]);
            } else if ($jenisProses == 'insertMesin') {
                DB::connection('ConnPurchase')
                    ->statement('exec SP_4384_PRG_MaintenanceGolonganDanMesin @XKode= ?, @XNoGol = ?, @XNoMesin = ?, @XNamaMesin = ?', [2, $noGolongan, $noMesin, $namaMesin]);
            } else if ($jenisProses == 'koreksiGolongan') {
                DB::connection('ConnPurchase')
                    ->statement('exec SP_4384_PRG_MaintenanceGolonganDanMesin @XKode= ?, @XNoGol = ?, @XNamaGol = ?', [3, $noGolongan, $namaGolongan]);
            } else if ($jenisProses == 'koreksiMesin') {
                DB::connection('ConnPurchase')
                    ->statement('exec SP_4384_PRG_MaintenanceGolonganDanMesin @XKode= ?, @XNoMesin = ?, @XNamaMesin = ?', [4, $noMesin, $namaMesin]);
            }
            return response()->json(['success' => 'Proses selesai']);
        } catch (Exception $ex) {
            return response()->json(['error' => $ex->getMessage()]);
        }
    }

    public function show($id, Request $request)
    {
        if ($id == 'getUserDivisi') {

            $UserInput = Auth::user()->NomorUser;
            $UserInput = trim($UserInput);

            $listUserDivisi = DB::connection('ConnPurchase')
                ->select('exec SP_1273_PRG_User_Divisi @Operator= ?', [$UserInput]);
            $userDivisiArr = [];
            foreach ($listUserDivisi as $userDivisi) {
                $userDivisiArr[] = [
                    'IdDivisi' => $userDivisi->Kd_div,
                    'NamaDivisi' => trim($userDivisi->NM_DIV),
                ];
            }
            return datatables($userDivisiArr)->make(true);
        } else if ($id == 'getGolongan') {
            $idDivisi = $request->idDivisi;

            $listUserGolongan = DB::connection('ConnPurchase')
                ->select('exec SP_1273_PRG_Select_GolonganByDivisi @kd_div= ?', [$idDivisi]);
            $userGolonganArr = [];
            foreach ($listUserGolongan as $userGolongan) {
                $userGolonganArr[] = [
                    'IdGolongan' => $userGolongan->NO_GOL,
                    'NamaGolongan' => $userGolongan->NM_GOL,
                ];
            }
            return datatables($userGolonganArr)->make(true);
        } else if ($id == 'getMesin') {
            $idGolongan = $request->idGolongan;

            $listUserMesin = DB::connection('ConnPurchase')
                ->select('exec SP_1273_PRG_LIST_MESIN @no_gol = ?', [$idGolongan]);
            $userMesinArr = [];
            foreach ($listUserMesin as $userMesin) {
                $userMesinArr[] = [
                    'IdMesin' => $userMesin->NO_MSN,
                    'NamaMesin' => $userMesin->NM_MSN,
                ];
            }
            return datatables($userMesinArr)->make(true);
        }
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
