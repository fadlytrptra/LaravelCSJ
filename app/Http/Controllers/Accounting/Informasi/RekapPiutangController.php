<?php

namespace App\Http\Controllers\Accounting\Informasi;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HakAksesController;

class RekapPiutangController extends Controller
{
    public function index()
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('Accounting');

        return view('Accounting.Informasi.RekapPiutang', compact('access'));
    }

    public function getCekRekPiutang($tglAkhirLaporan)
    {
        $tabel =  DB::connection('ConnAccounting')->select('exec [SP_CEK_REKPIUTANG] @Tanggal = ?', [$tglAkhirLaporan]);
        return response()->json($tabel);
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
    public function show(cr $cr)
    {
        //
    }

    // Show the form for editing the specified resource.
    public function edit($id)
    {
        //
    }

    //Update the specified resource in storage.
    public function update(Request $request)
    {
        $tglAkhirLaporan = $request->tglAkhirLaporan;
        DB::connection('ConnAccounting')->statement('exec [SP_PROSES_REKPIUTANG]
        @TglAkhir = ?', [
            $tglAkhirLaporan
            // Log::info('Request Data: ' .json_encode($ketDariBank));
        ]);
        return redirect()->back()->with('success', 'Data Selesai Diproses. Silakan Lihat di view INF_REKAP_PIUTANG');
    }

    //Remove the specified resource from storage.
    public function destroy($id)
    {
        //
    }
}
