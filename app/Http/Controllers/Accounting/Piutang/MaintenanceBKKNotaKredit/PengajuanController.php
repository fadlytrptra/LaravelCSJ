<?php

namespace App\Http\Controllers\Accounting\Piutang\MaintenanceBKKNotaKredit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Log;
use App\Http\Controllers\HakAksesController;
use Exception;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Auth;

class PengajuanController extends Controller
{
    public function index()
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('Accounting');
        return view('Accounting.Piutang.MaintenanceBKKNotaKredit.Pengajuan', compact('access'));
    }

    // public function loadDataNotaK()
    // {
    //     $tabel =  DB::connection('ConnAccounting')->select('exec [sp_list_nota_kredit1]');
    //     return response()->json($tabel);
    // }

    // public function getJenisBayarPenagajuan()
    // {
    //     $tabel =  DB::connection('ConnAccounting')->select('exec [sp_jenis_dok]');
    //     return response()->json($tabel);
    // }

    // //SP NYA SALAH
    // public function getBankPengajuan()
    // {
    //     $tabel =  DB::connection('ConnAccounting')->select('exec [E-sp_Bank]');
    //     return response()->json($tabel);
    // }

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
    public function show(Request $request, $id)
    {
        if ($id == 'getNotaKredit') {
            // Execute the stored procedure 'sp_list_nota_kredit1'
            $results = DB::connection('ConnAccounting')->select('exec sp_list_nota_kredit1');
            // dd($results);
            $response = [];
            foreach ($results as $row) {
                $response[] = [
                    'Tanggal' => \Carbon\Carbon::parse($row->Tanggal)->format('m/d/Y'),
                    'Id_NotaKredit' => $row->Id_NotaKredit,
                    'Id_Penagihan' => $row->Id_Penagihan,
                    'NamaCust' => $row->NamaCust,
                    'Nama_MataUang' => $row->Nama_MataUang,
                    'Nilai' => number_format($row->Nilai, 2, '.', ','),
                    'Id_Bank' => $row->Id_Bank ?? '',
                    'Jenis_Pembayaran' => $row->Jenis_Pembayaran ?? '',
                    'Rincian_Bayar' => $row->Rincian_Bayar ?? ''
                ];
            }

            return datatables($response)->make(true);
        } else if ($id == 'getJenisBayar') {
            // Execute the stored procedure
            $results = DB::connection('ConnAccounting')
                ->select('exec sp_jenis_dok');
            // dd($results);

            $response = [];
            foreach ($results as $row) {
                $response[] = [
                    'Id_Jenis_Bayar' => $row->Id_Jenis_Bayar,
                    'Jenis_Pembayaran' => $row->Jenis_Pembayaran,
                ];
            }

            return datatables($response)->make(true);
        }
    }

    // Show the form for editing the specified resource.
    public function edit($id)
    {
        //
    }

    //Update the specified resource in storage.
    public function update(Request $request)
    {
        //
    }

    //Remove the specified resource from storage.
    public function destroy($id)
    {

    }
}
