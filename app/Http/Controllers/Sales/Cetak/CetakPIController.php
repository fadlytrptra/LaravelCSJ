<?php

namespace App\Http\Controllers\Sales\Cetak;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\HakAksesController;
use DB;

class CetakPIController extends Controller
{
    public function index()
    {
        $date = now()->format('Y-m-d');
        $nosp = db::connection('ConnSales')->select('exec SP_1486_SLS_LIST_SP_CETAK @Kode = ?, @Tanggal = ?', [4, $date]);
        // dd($nosp);
        $access = (new HakAksesController)->HakAksesFiturMaster('Sales');
        return view('Sales.Report.CetakPI', compact('access', 'nosp'));
    }
    public function getSuratPesananSelect($tanggal)
    {
        $nosp = db::connection('ConnSales')->select('exec SP_1486_SLS_LIST_SP_CETAK @Kode =?, @Tanggal =?', [4, $tanggal]);
        return response()->json($nosp);
    }

    public function getSuratPesananText($no_spValue)
    {
        $no_sp = str_replace('.', '/', $no_spValue);
        $data = db::connection('ConnSales')->select('exec SP_1486_SLS_LIST_SP_CETAK @Kode = ?, @IdSuratPesanan = ?', [2, $no_sp]);
        return response()->json($data);
    }
    public function getViewPrint($no_spValue)
    {
        $no_sp = str_replace('.', '/', $no_spValue);
        $data = DB::connection('ConnSales')->table('VW_SLS_4384_CETAK_SP_EKSPORT_LARAVEL')->select('*')->where('NO_SP', '=', $no_sp)->get();

        // Split uraianPesanan into an array using " | " as the delimiter
        $data = $data->map(function ($item) {
            $item->uraianPesananArray = explode(" | ", $item->UraianPesanan);
            return $item;
        });

        // Convert the Collection to a PHP array
        $dataArray = $data->toArray();

        // Sort the array based on the 6th element of uraianPesananArray
        usort($dataArray, function ($a, $b) {
            $uraianA = $a->uraianPesananArray;
            $uraianB = $b->uraianPesananArray;

            if (count($uraianA) >= 6 && count($uraianB) >= 6) {
                return strcmp($uraianA[5], $uraianB[5]);
            } else {
                // Handle cases where there are not enough elements in the array
                return 0; // No change in order
            }
        });

        // Convert the sorted array back to a Collection (optional)
        $data = collect($dataArray);

        // Return the sorted data as JSON response
        return response()->json($data);
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        //
    }
    public function show($id)
    {
        //
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
