<?php

namespace App\Http\Controllers\Accounting\Piutang\InformasiBank;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Log;
use App\Http\Controllers\HakAksesController;
use Exception;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Auth;

class AnalisaInformasiBankController extends Controller
{
    public function index()
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('Accounting');
        return view('Accounting.Piutang.InformasiBank.AnalisaInformasiBank', compact('access'));
    }

    public function getTabelAnalisis($tanggal, $tanggal2, $radiogrup)
    {
        if ($radiogrup == 0) {
            // Handle ketika radio button "Belum Analisa" dipilih
            $tabel = DB::connection('ConnAccounting')->select(
                'exec [SP_1273_PRG_LIST_REFERENSI_BANK] @Kode = ?, @Tanggal = ?, @Tanggal1 = ?, @analisa = ?',
                [
                    8,
                    $tanggal,
                    $tanggal2,
                    0 // Menggunakan nilai "belum"
                ]
            );
            return response()->json($tabel);
        } elseif ($radiogrup == 1) {
            // Handle ketika radio button "Sudah Analisa" dipilih
            $tabel = DB::connection('ConnAccounting')->select(
                'exec [SP_1273_PRG_LIST_REFERENSI_BANK] @Kode = ?, @Tanggal = ?, @Tanggal1 = ?, @analisa = ?',
                [
                    8,
                    $tanggal,
                    $tanggal2,
                    1 // Menggunakan nilai "sudah"
                ]
            );
            return response()->json($tabel);
        }
        ;
    }

    //Show the form for creating a new resource.
    public function create()
    {
        //
    }

    //Store a newly created resource in storage.
    public function store(Request $request)
    {
        // dd($request->all());
        try {
            $radiogrup2 = $request->input('radiogrup2');

            if ($radiogrup2 == "T") {
                $OptPiutang = true;
                $OptTitip = false;
            } else if ($radiogrup2 == "K") {
                $OptPiutang = false;
                $OptTitip = false;
            } else if ($radiogrup2 == "U") {
                $OptTitip = true;
                $OptPiutang = false;
            }

            $referensi = DB::connection('ConnAccounting')
                ->select('exec SP_1273_PRG_LIST_REFERENSI_BANK @Kode = ?, @IdReferensi = ?', [2, $request->input('noReferensi')]);

            if (!empty($referensi) && isset($referensi[0]->Id_Pelunasan) && $referensi[0]->Id_Pelunasan != '') {
                return response()->json([
                    'error' => 'Tidak Dapat Dikoreksi Karena Sudah ada Pelunasan'
                ]);
            }

            DB::connection('ConnAccounting')
                ->statement('exec SP_1273_PRG_UPDATE_REFERENSI_BANK ?, ?, ?, ?, ?, ?', [
                    1, // @Kode
                    $request->input('idCustomer'), // @Id_Cust
                    $OptPiutang ? 'Y' : 'N', // @Status_tagihan
                    $request->input('noReferensi'), // @IdReferensi
                    trim(Auth::user()->NomorUser), // @UserId
                    $OptTitip ? 'Uang Titipan' : null
                    // $OptTitip ? 'Uang Titipan' : $request->input('ketDariBank') // @Ket jika OptTitip bernilai true
                ]);

            $listData = [
                'Customer' => $request->input('nama_customer'),
                'Id_Cust' => $request->input('idCustomer'),
                'Status_Tagihan' => $OptPiutang ? 'Y' : 'N'
            ];

            return response()->json([
                'message' => 'Data Telah Tersimpan',
                'listData' => $listData
            ]);

        } catch (Exception $e) {
            return response()->json([
                'error' => 'Error: ' . $e->getMessage(),
            ]);
        }
    }

    //Display the specified resource.
    public function show(Request $request, $id)
    {
        if ($id == 'getCustomer') {
            // Menjalankan stored procedure untuk mendapatkan data customer
            $customers = DB::connection('ConnSales')
                ->select('exec SP_1273_PRG_LIST_ALL_CUSTOMER ?', [1]);
            // dd($customers);
            // Mempersiapkan response data
            $response = [];
            foreach ($customers as $customer) {
                $response[] = [
                    'NAMACUST' => $customer->NAMACUST,
                    'IDCust' => substr($customer->IDCust, -5),
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
        //dd($request->all());
        $noReferensi = $request->noReferensi;
        $idCustomer = $request->idCustomer;
        $radiogrup2 = $request->radiogrup2;
        $ketDariBank = $request->ketDariBank;
        $statusPenagihan = $request->statusPenagihan;
        // dd($ketDariBank);

        $selectedValue = $request->input('radiogrup2');

        if ($selectedValue == 'T') {
            $statusPenagihan = $statusPenagihan;
        } elseif ($selectedValue == 'U') {
            $ketDariBank = 'Uang Titipan'; // Atau nilai yang sesuai untuk 'U'
        }
        ;

        DB::connection('ConnAccounting')->statement('exec [SP_1273_PRG_LIST_REFERENSI_BANK]
        @Kode = ?,
        @IdReferensi = ?', [
            2,
            $noReferensi
        ]);
        // Log::info('Request Data: ' .json_encode($ketDariBank));
        DB::connection('ConnAccounting')->statement('exec SP_1273_PRG_UPDATE_REFERENSI_BANK
        @Kode = ?,
        @Id_Cust = ?,
        @Status_tagihan = ?,
        @IdReferensi = ?,
        @UserId = ?,
        @Ket = ?', [
            1,
            $idCustomer,
            $statusPenagihan,
            $noReferensi,
            1,
            $ketDariBank
            // Log::info('Request Data: ' .json_encode($ketDariBank));
        ]);
        return response()->json('Data Telah Terupdate');
    }

    //Remove the specified resource from storage.
    public function destroy($id)
    {
        //
    }
}
