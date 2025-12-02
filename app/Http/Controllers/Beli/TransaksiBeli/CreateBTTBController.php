<?php

namespace App\Http\Controllers\Beli\TransaksiBeli;

use App\Http\Controllers\Controller;
use App\Http\Controllers\HakAksesController;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Log;


class CreateBTTBController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {

        $access = (new HakAksesController)->HakAksesFiturMaster('Beli');
        $result = (new HakAksesController)->HakAksesFitur('Create BTTB');
        if ($result > 0) {
            $nosup = DB::connection('ConnPurchase')->select('exec SP_4384_PBL_Maintenance_Supplier @XKode = 0');
            $po = DB::connection('ConnPurchase')->select('exec SP_4384_PBL_Maintenance_Supplier @XKode = 0');
            $ppn = DB::connection('ConnPurchase')->select('exec SP_5409_LIST_PPN');
            return view('Beli.TransaksiBeli.CreateBTTB', compact('nosup', 'po', 'ppn', 'access'));
        } else {
            abort(403);
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

    public function createbttb(Request $request)
    {
        $noPO = $request->input('noPO');
        $kd = 16;

        $createbttb = DB::connection('ConnPurchase')->select('exec SP_5409_LIST_ORDER @kd=?, @noPO=?', [$kd, $noPO]);

        return response()->json($createbttb);
    }

    public function drop1(Request $request)
    {
        $idSup = $request->input('idSup');
        $kd = 15;

        $purchaseorder = DB::connection('ConnPurchase')->select('exec SP_5409_LIST_ORDER @kd =?, @idSup =?', [$kd, $idSup]);

        return response()->json($purchaseorder);
    }


    public function dropdown(Request $request)
    {
        $NM_SUP = $request->input('NM_SUP');

        $purchaseorder = DB::connection('ConnPurchase')->select('exec SP_4384_PBL_Maintenance_Supplier @XKode =?, @NM_SUP =?', [0, $NM_SUP]);
        return response()->json($purchaseorder);
    }
    public function createNoBTTB()
    {
        $kd = 7;
        try {
            $tahun = date('y');
            $value = DB::connection('ConnPurchase')->table('YCounter')->value('NO_BTTB');
            $NoBTTB = '0000000000000' . $value;
            $NoBTTB = 'BTTB-' . $tahun . substr($NoBTTB, -6);
            $update = DB::connection('ConnPurchase')->statement('exec SP_5409_MAINT_PO @kd = ?', [$kd]);
            return Response()->json(['data' => $NoBTTB, 'status' => $update]);
        } catch (\Throwable $Error) {
            return Response()->json($Error);
        }
    }

    public function setStatusPO(Request $request)
    {
        $kd = 9;
        $NoPO = $request->input('NoPO');
        try {
            $data = DB::connection('ConnPurchase')->statement('exec SP_5409_MAINT_PO @kd = ? , @NoPO = ?', [$kd, $NoPO]);
            return Response()->json($data);
        } catch (\Throwable $Error) {
            return Response()->json($Error);
        }
    }
    public function post(Request $request)
    {
        // Record the start time
        $startTime = microtime(true);

        set_time_limit(300); // Increase execution time limit to 300 seconds

        $data = $request->input('data');
        try {
            $tahun = date('y');
            $value = DB::connection('ConnPurchase')->table('YCounter')->value('NO_BTTB');
            $BTTB = '0000000000000' . $value;
            $BTTB = 'BTTB-' . $tahun . substr($BTTB, -6);
            DB::connection('ConnPurchase')->statement('exec SP_5409_MAINT_PO @kd = ?', [7]); // update counter bttb

            foreach ($data as $item) {
                $tglDatang = Carbon::parse($item['tglDatang']);
                $Qty = $item['Qty'];
                $qtyShip = $item['qtyShip'];
                $qtyRcv = $item['qtyRcv'];
                $qtyremain = $item['qtyremain'];
                $NoSatuan = $item['NoSatuan'];
                $SJ = $item['SJ'];
                $idSup = $item['idSup'];
                $pUnit = $item['pUnit'];
                $pPPN = $item['pPPN'];
                $noTrans = $item['noTrans'];
                $Kd_div = 'PBL';
                $kurs = $item['kurs'];
                $Operator = trim(Auth::user()->NomorUser);
                $pIDRUnit = $item['pIDRUnit'];
                $pIDRPPN = $item['pIDRPPN'];
                $NoPIB = $item['NoPIB'];
                $NoPO = $item['NoPO'];
                $pSub = $item['pSub'];
                $pIDRSub = $item['pIDRSub'];
                $pTot = $item['pTot'];
                $pIDRTot = $item['pIDRTot'];
                $NoPIBExt = $item['NoPIBExt'];
                $TglPIB = Carbon::parse($item['TglPIB']);
                $NoSPPBBC = $item['NoSPPBBC'];
                $TglSPPBBC = Carbon::parse($item['TglSPPBBC']);
                $NoSKBM = $item['NoSKBM'];
                $TglSKBM = Carbon::parse($item['TglSKBM']);
                $NoReg = $item['NoReg'];
                $TglReg = Carbon::parse($item['TglReg']);
                $idPPN = $item['idPPN'];
                $jumPPN = $item['jumPPN'];
                $persen = $item['persen'];
                $disc = $item['disc'] ?? 0;
                $discIDR = $item['discIDR'];
                $mtUang = $item['mtUang'];
                $KodeHS = $item['KodeHS'];
                $noTrTmp = $item['noTrTmp'] ?? null;
                $pDPP = $item['pDPP'];
                $pIDRDPP = $item['pIDRDPP'];
                try {
                    DB::connection('ConnPurchase')->statement('exec SP_5409_MAINT_PO
                    @kd = ?,@tglDatang = ?,@Qty = ?,@qtyShip = ?,@qtyRcv = ?,
                    @qtyremain = ?,@NoSatuan = ?,@SJ = ?,@idSup = ?,@pUnit = ?,
                    @pPPN = ?,@noTrans = ?,@Kd_div = ?,@kurs = ?,@Operator = ?,
                    @pIDRUnit = ?,@pIDRPPN = ?,@NoPIB = ?,@NoPO = ?, @BTTB = ?,
                    @pSub = ?,@pIDRSub = ?,@pTot = ?,@pIDRTot = ?,@NoPIBExt = ?,
                    @TglPIB = ?,@NoSPPBBC = ?,@TglSPPBBC = ?,@NoSKBM = ?,@TglSKBM = ?,
                    @NoReg = ?,@TglReg = ?,@idPPN = ?,@jumPPN = ?,@persen = ?,@disc = ?,
                    @discIDR = ?,@mtUang = ?,@KodeHS = ?,@noTrTmp = ?, @pDPP = ?, @pIDRDPP = ?',
                        [
                            8,
                            $tglDatang,
                            $Qty,
                            $qtyShip,
                            $qtyRcv,
                            $qtyremain,
                            $NoSatuan,
                            $SJ,
                            $idSup,
                            $pUnit,
                            $pPPN,
                            $noTrans,
                            $Kd_div,
                            $kurs,
                            $Operator,
                            $pIDRUnit,
                            $pIDRPPN,
                            $NoPIB,
                            $NoPO,
                            $BTTB,
                            $pSub,
                            $pIDRSub,
                            $pTot,
                            $pIDRTot,
                            $NoPIBExt,
                            $TglPIB,
                            $NoSPPBBC,
                            $TglSPPBBC,
                            $NoSKBM,
                            $TglSKBM,
                            $NoReg,
                            $TglReg,
                            $idPPN,
                            $jumPPN,
                            $persen,
                            $disc,
                            $discIDR,
                            $mtUang,
                            $KodeHS,
                            $noTrTmp,
                            $pDPP,
                            $pIDRDPP
                        ]
                    );
                    // Calculate the elapsed time
                    $endTime = microtime(true);
                    $elapsedTime = $endTime - $startTime;
                    Log::info((string) 'Elapsed Time for post BTTB: ' . $elapsedTime . ' | NoTrans: ' . $noTrans);
                    Log::info((string) 'exec SP_5409_MAINT_PO @kd = 8, @tglDatang = ' . '\'' . $tglDatang . '\'' . ', @Qty = ' . $Qty .
                        ', @qtyShip = ' . $qtyShip . ', @qtyRcv = ' . $qtyRcv . ', @qtyremain = ' . $qtyremain .
                        ', @NoSatuan = ' . '\'' . $NoSatuan . '\'' . ', @SJ = ' . '\'' . $SJ . '\'' . ', @idSup = ' . '\'' . $idSup . '\'' .
                        ', @pUnit = ' . $pUnit . ', @pPPN = ' . $pPPN . ', @noTrans = ' . '\'' . $noTrans . '\'' .
                        ', @Kd_div = ' . '\'' . $Kd_div . '\'' . ', @kurs = ' . $kurs . ', @Operator = ' . '\'' . $Operator . '\'' .
                        ', @pIDRUnit = ' . $pIDRUnit . ', @pIDRPPN = ' . $pIDRPPN . ', @NoPIB = ' . '\'' . $NoPIB . '\'' . ', @NoPO = ' . '\'' . $NoPO . '\'' .
                        ', @BTTB = ' . '\'' . $BTTB . '\'' . ', @pSub = ' . $pSub . ', @pIDRSub = ' . $pIDRSub . ', @pTot = ' . $pTot .
                        ', @pIDRTot = ' . $pIDRTot . ', @NoPIBExt = ' . '\'' . $NoPIBExt . '\'' . ', @TglPIB = ' . '\'' . $TglPIB . '\'' .
                        ', @NoSPPBBC = ' . '\'' . $NoSPPBBC . '\'' . ', @TglSPPBBC = ' . '\'' . $TglSPPBBC . '\'' . ', @NoSKBM = ' . '\'' . $NoSKBM . '\'' .
                        ', @TglSKBM = ' . '\'' . $TglSKBM . '\'' . ', @NoReg = ' . '\'' . $NoReg . '\'' . ', @TglReg = ' . '\'' . $TglReg . '\'' .
                        ', @idPPN = ' . $idPPN . ', @jumPPN = ' . $jumPPN . ', @persen = ' . $persen . ', @disc = ' . $disc . ', @discIDR = ' . $discIDR .
                        ', @mtUang = ' . $mtUang . ', @KodeHS = ' . '\'' . $KodeHS . '\'' . ', @noTrTmp = ' . ($noTrTmp !== null ? $noTrTmp : 'NULL') .
                        ', @pDPP = ' . $pDPP . ', @pIDRDPP = ' . $pIDRDPP);
                } catch (\Exception $e) {
                    Log::error('Error: SP_5409_MAINT_PO failed for NoTrans: ' . $item['NoPO'], [
                        'error' => $e->getMessage(),
                    ]);
                    // Calculate the elapsed time
                    $endTime = microtime(true);
                    $elapsedTime = $endTime - $startTime;
                    Log::error((string) 'Elapsed Time for post BTTB: ' . $elapsedTime . ' | NoTrans: ' . $noTrans);
                    Log::error((string) 'exec SP_5409_MAINT_PO @kd = 8, @tglDatang = ' . '\'' . $tglDatang . '\'' . ', @Qty = ' . $Qty .
                        ', @qtyShip = ' . $qtyShip . ', @qtyRcv = ' . $qtyRcv . ', @qtyremain = ' . $qtyremain .
                        ', @NoSatuan = ' . '\'' . $NoSatuan . '\'' . ', @SJ = ' . '\'' . $SJ . '\'' . ', @idSup = ' . '\'' . $idSup . '\'' .
                        ', @pUnit = ' . $pUnit . ', @pPPN = ' . $pPPN . ', @noTrans = ' . '\'' . $noTrans . '\'' .
                        ', @Kd_div = ' . '\'' . $Kd_div . '\'' . ', @kurs = ' . $kurs . ', @Operator = ' . '\'' . $Operator . '\'' .
                        ', @pIDRUnit = ' . $pIDRUnit . ', @pIDRPPN = ' . $pIDRPPN . ', @NoPIB = ' . '\'' . $NoPIB . '\'' . ', @NoPO = ' . '\'' . $NoPO . '\'' .
                        ', @BTTB = ' . '\'' . $BTTB . '\'' . ', @pSub = ' . $pSub . ', @pIDRSub = ' . $pIDRSub . ', @pTot = ' . $pTot .
                        ', @pIDRTot = ' . $pIDRTot . ', @NoPIBExt = ' . '\'' . $NoPIBExt . '\'' . ', @TglPIB = ' . '\'' . $TglPIB . '\'' .
                        ', @NoSPPBBC = ' . '\'' . $NoSPPBBC . '\'' . ', @TglSPPBBC = ' . '\'' . $TglSPPBBC . '\'' . ', @NoSKBM = ' . '\'' . $NoSKBM . '\'' .
                        ', @TglSKBM = ' . '\'' . $TglSKBM . '\'' . ', @NoReg = ' . '\'' . $NoReg . '\'' . ', @TglReg = ' . '\'' . $TglReg . '\'' .
                        ', @idPPN = ' . $idPPN . ', @jumPPN = ' . $jumPPN . ', @persen = ' . $persen . ', @disc = ' . $disc . ', @discIDR = ' . $discIDR .
                        ', @mtUang = ' . $mtUang . ', @KodeHS = ' . '\'' . $KodeHS . '\'' . ', @noTrTmp = ' . ($noTrTmp !== null ? $noTrTmp : 'NULL') .
                        ', @pDPP = ' . $pDPP . ', @pIDRDPP = ' . $pIDRDPP);
                    continue; // continue with next item
                }
                // try {
                //     DB::connection('ConnPurchaseTrial')->statement('exec SP_5409_MAINT_PO
                //     @kd = ?,@tglDatang = ?,@Qty = ?,@qtyShip = ?,@qtyRcv = ?,
                //     @qtyremain = ?,@NoSatuan = ?,@SJ = ?,@idSup = ?,@pUnit = ?,
                //     @pPPN = ?,@noTrans = ?,@Kd_div = ?,@kurs = ?,@Operator = ?,
                //     @pIDRUnit = ?,@pIDRPPN = ?,@NoPIB = ?,@NoPO = ?, @BTTB = ?,
                //     @pSub = ?,@pIDRSub = ?,@pTot = ?,@pIDRTot = ?,@NoPIBExt = ?,
                //     @TglPIB = ?,@NoSPPBBC = ?,@TglSPPBBC = ?,@NoSKBM = ?,@TglSKBM = ?,
                //     @NoReg = ?,@TglReg = ?,@idPPN = ?,@jumPPN = ?,@persen = ?,@disc = ?,
                //     @discIDR = ?,@mtUang = ?,@KodeHS = ?,@noTrTmp = ?, @pDPP = ?, @pIDRDPP = ?',
                //         [
                //             8,
                //             $tglDatang,
                //             $Qty,
                //             $qtyShip,
                //             $qtyRcv,
                //             $qtyremain,
                //             $NoSatuan,
                //             $SJ,
                //             $idSup,
                //             $pUnit,
                //             $pPPN,
                //             $noTrans,
                //             $Kd_div,
                //             $kurs,
                //             $Operator,
                //             $pIDRUnit,
                //             $pIDRPPN,
                //             $NoPIB,
                //             $NoPO,
                //             $BTTB,
                //             $pSub,
                //             $pIDRSub,
                //             $pTot,
                //             $pIDRTot,
                //             $NoPIBExt,
                //             $TglPIB,
                //             $NoSPPBBC,
                //             $TglSPPBBC,
                //             $NoSKBM,
                //             $TglSKBM,
                //             $NoReg,
                //             $TglReg,
                //             $idPPN,
                //             $jumPPN,
                //             $persen,
                //             $disc,
                //             $discIDR,
                //             $mtUang,
                //             $KodeHS,
                //             $noTrTmp,
                //             $pDPP,
                //             $pIDRDPP
                //         ]
                //     );
                //     // Calculate the elapsed time
                //     $endTime = microtime(true);
                //     $elapsedTime = $endTime - $startTime;
                //     Log::info((string) 'Elapsed Time for post BTTB: ' . $elapsedTime . ' | NoTrans: ' . $noTrans);
                //     Log::info((string) 'exec PURCHASETRIAL SP_5409_MAINT_PO @kd = 8, @tglDatang = ' . '\'' . $tglDatang . '\'' . ', @Qty = ' . $Qty .
                //         ', @qtyShip = ' . $qtyShip . ', @qtyRcv = ' . $qtyRcv . ', @qtyremain = ' . $qtyremain .
                //         ', @NoSatuan = ' . '\'' . $NoSatuan . '\'' . ', @SJ = ' . '\'' . $SJ . '\'' . ', @idSup = ' . '\'' . $idSup . '\'' .
                //         ', @pUnit = ' . $pUnit . ', @pPPN = ' . $pPPN . ', @noTrans = ' . '\'' . $noTrans . '\'' .
                //         ', @Kd_div = ' . '\'' . $Kd_div . '\'' . ', @kurs = ' . $kurs . ', @Operator = ' . '\'' . $Operator . '\'' .
                //         ', @pIDRUnit = ' . $pIDRUnit . ', @pIDRPPN = ' . $pIDRPPN . ', @NoPIB = ' . '\'' . $NoPIB . '\'' . ', @NoPO = ' . '\'' . $NoPO . '\'' .
                //         ', @BTTB = ' . '\'' . $BTTB . '\'' . ', @pSub = ' . $pSub . ', @pIDRSub = ' . $pIDRSub . ', @pTot = ' . $pTot .
                //         ', @pIDRTot = ' . $pIDRTot . ', @NoPIBExt = ' . '\'' . $NoPIBExt . '\'' . ', @TglPIB = ' . '\'' . $TglPIB . '\'' .
                //         ', @NoSPPBBC = ' . '\'' . $NoSPPBBC . '\'' . ', @TglSPPBBC = ' . '\'' . $TglSPPBBC . '\'' . ', @NoSKBM = ' . '\'' . $NoSKBM . '\'' .
                //         ', @TglSKBM = ' . '\'' . $TglSKBM . '\'' . ', @NoReg = ' . '\'' . $NoReg . '\'' . ', @TglReg = ' . '\'' . $TglReg . '\'' .
                //         ', @idPPN = ' . $idPPN . ', @jumPPN = ' . $jumPPN . ', @persen = ' . $persen . ', @disc = ' . $disc . ', @discIDR = ' . $discIDR .
                //         ', @mtUang = ' . $mtUang . ', @KodeHS = ' . '\'' . $KodeHS . '\'' . ', @noTrTmp = ' . ($noTrTmp !== null ? $noTrTmp : 'NULL') .
                //         ', @pDPP = ' . $pDPP . ', @pIDRDPP = ' . $pIDRDPP);
                // } catch (\Exception $e) {
                //     Log::error('Error: SP_5409_MAINT_PO failed for NoTrans: ' . $item['NoPO'], [
                //         'error' => $e->getMessage(),
                //     ]);
                //     // Calculate the elapsed time
                //     $endTime = microtime(true);
                //     $elapsedTime = $endTime - $startTime;
                //     Log::error((string) 'Elapsed Time for post BTTB: ' . $elapsedTime . ' | NoTrans: ' . $noTrans);
                //     Log::error((string) 'exec PURCHASETRIAL SP_5409_MAINT_PO @kd = 8, @tglDatang = ' . '\'' . $tglDatang . '\'' . ', @Qty = ' . $Qty .
                //         ', @qtyShip = ' . $qtyShip . ', @qtyRcv = ' . $qtyRcv . ', @qtyremain = ' . $qtyremain .
                //         ', @NoSatuan = ' . '\'' . $NoSatuan . '\'' . ', @SJ = ' . '\'' . $SJ . '\'' . ', @idSup = ' . '\'' . $idSup . '\'' .
                //         ', @pUnit = ' . $pUnit . ', @pPPN = ' . $pPPN . ', @noTrans = ' . '\'' . $noTrans . '\'' .
                //         ', @Kd_div = ' . '\'' . $Kd_div . '\'' . ', @kurs = ' . $kurs . ', @Operator = ' . '\'' . $Operator . '\'' .
                //         ', @pIDRUnit = ' . $pIDRUnit . ', @pIDRPPN = ' . $pIDRPPN . ', @NoPIB = ' . '\'' . $NoPIB . '\'' . ', @NoPO = ' . '\'' . $NoPO . '\'' .
                //         ', @BTTB = ' . '\'' . $BTTB . '\'' . ', @pSub = ' . $pSub . ', @pIDRSub = ' . $pIDRSub . ', @pTot = ' . $pTot .
                //         ', @pIDRTot = ' . $pIDRTot . ', @NoPIBExt = ' . '\'' . $NoPIBExt . '\'' . ', @TglPIB = ' . '\'' . $TglPIB . '\'' .
                //         ', @NoSPPBBC = ' . '\'' . $NoSPPBBC . '\'' . ', @TglSPPBBC = ' . '\'' . $TglSPPBBC . '\'' . ', @NoSKBM = ' . '\'' . $NoSKBM . '\'' .
                //         ', @TglSKBM = ' . '\'' . $TglSKBM . '\'' . ', @NoReg = ' . '\'' . $NoReg . '\'' . ', @TglReg = ' . '\'' . $TglReg . '\'' .
                //         ', @idPPN = ' . $idPPN . ', @jumPPN = ' . $jumPPN . ', @persen = ' . $persen . ', @disc = ' . $disc . ', @discIDR = ' . $discIDR .
                //         ', @mtUang = ' . $mtUang . ', @KodeHS = ' . '\'' . $KodeHS . '\'' . ', @noTrTmp = ' . ($noTrTmp !== null ? $noTrTmp : 'NULL') .
                //         ', @pDPP = ' . $pDPP . ', @pIDRDPP = ' . $pIDRDPP);
                //     continue; // continue with next item
                // }
            }
            return Response()->json(['message' => 'Data Sudah Diproses', 'BTTB' => $BTTB]);
        } catch (\Exception $e) {
            Log::info($e);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function print(Request $request)
    {
        $No_BTTB = $request->input('No_BTTB');
        if (($No_BTTB !== null)) {
            try {
                $print = DB::connection('ConnPurchase')
                    ->table('VW_5409_PRINT_BTTB')
                    ->where('VW_5409_PRINT_BTTB.No_BTTB', $No_BTTB)
                    ->whereNull('VW_5409_PRINT_BTTB.TglRetur')
                    ->get();
                $printHeader = DB::connection('ConnPurchase')->table('VW_5409_PRINT_HEADER_BTTB')->where('VW_5409_PRINT_HEADER_BTTB.No_BTTB', $No_BTTB)->get();

                return Response()->json(["print" => $print, "printHeader" => $printHeader]);
            } catch (\Throwable $Error) {
                return Response()->json($Error);
            }
        } else {
            return Response()->json('Parameter harus di isi');
        }
    }
    public function show(Request $request, $id)
    {
        if ($id == 'setToleransi') {
            $kodeBarang = $request->input('kode_barang');
            $input = $request->input('inputValue');

            // Validate the input to ensure it is numeric
            if (!is_numeric($input)) {
                return response()->json(['error' => 'Invalid input'], 400);
            }

            // Convert input to a float and format it to two decimal places
            $formattedInput = number_format((float) $input, 2, '.', '');

            // Ensure the formatted input does not exceed the decimal(4,2) limit
            if ($formattedInput > 9999.99) {
                return response()->json(['error' => 'Input exceeds allowed range for decimal(4,2)'], 400);
            }

            // Update the 'Toleransi' column in the 'Y_BARANG' table
            try {
                DB::connection('ConnPurchase')->table('Y_BARANG')
                    ->where('KD_BRG', (string) $kodeBarang) // Ensure this matches the column name in your table
                    ->update(['Toleransi' => (float) $formattedInput]);

                // Retrieve the updated 'Toleransi' value
                $updatedToleransi = DB::connection('ConnPurchase')->table('Y_BARANG')
                    ->where('KD_BRG', (string) $kodeBarang)
                    ->value('Toleransi');

                // Return a success response with the updated value
                return response()->json([
                    'success' => 'Toleransi updated successfully',
                    'toleransi' => $updatedToleransi,
                ]);
            } catch (\Exception $e) {
                // Return error response in case of a database error
                return response()->json(['error' => 'Database error: ' . $e->getMessage()], 500);
            }
        } else if ($id == 'getToleransi') {
            $kodeBarang = $request->input('kode_barang');
            $updatedToleransi = DB::connection('ConnPurchase')->table('Y_BARANG')
                ->where('KD_BRG', (string) $kodeBarang)
                ->value('Toleransi');
            return response()->json([
                'success' => 'Toleransi updated successfully',
                'toleransi' => $updatedToleransi,
            ]);
        }

        // Return an error response if the id does not match 'setToleransi'
        return response()->json(['error' => 'Invalid request'], 400);
    }

    //Show the form for editing the specified resource.
    public function edit($id)
    {
        //
    }

    //Update the specified resource in storage.
    public function update(Request $request, $id)
    {
        //
    }

    //Remove the specified resource from storage.
    public function destroy($id)
    {
        //
    }
}
