<?php

namespace App\Http\Controllers\Beli\TransaksiBeli;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HakAksesController;
use DB;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Auth;

class IsiSupplierHargaController extends Controller
{
    //Display the specified resource.
    public function show($id)
    {
        if ($id == 0) {
            $result = (new HakAksesController)->HakAksesFitur('Beli Sendiri');
        } else if ($id == 1) {
            $result = (new HakAksesController)->HakAksesFitur('Pengadaan Pembelian');
        }
        if ($result > 0) {
            $access = (new HakAksesController)->HakAksesFiturMaster('Beli');
            return view('Beli.TransaksiBeli.IsiSupplierHarga', compact('id', 'access'));
        } else {
            abort(403);
        }
    }
    public function redisplay(Request $request, $id)
    {
        $noTrans = $request->input('noTrans');
        $kd = $request->input('kd');
        $requester = $request->input('requester');

        if (($noTrans != null) || ($kd != null) || ($requester != null)) {
            try {
                if ($kd == 11) {
                    $redisplay = DB::connection('ConnPurchase')->select('exec SP_5409_LIST_ORDER @noTrans = ?, @kd = ?, @stBeli = ?', [$noTrans, $kd, $id]);
                } else if ($kd == 23) {
                    $redisplay = DB::connection('ConnPurchase')->select('exec SP_5409_LIST_ORDER @requester = ?, @kd = ?, @stBeli = ?', [$requester, $kd, $id]);
                } else if ($kd == 24) {
                    $redisplay = DB::connection('ConnPurchase')->select('exec SP_5409_LIST_ORDER @kd = ?, @stBeli = ?', [$kd, $id]);
                }
                return datatables($redisplay)->make(true);
            } catch (\Throwable $Error) {
                return Response()->json($Error);
            }
        } else {
            return Response()->json('Parameter harus di isi');
        }
    }
    public function daftarData($id)
    {
        try {
            $supplier = DB::connection('ConnPurchase')->select('exec SP_4384_PBL_Maintenance_Supplier @XKode = ?', [0]);
            $matauang = DB::connection('ConnPurchase')->select('exec SP_7775_PBL_LIST_MATA_UANG');
            $ppn = DB::connection('ConnPurchase')->select('exec SP_5409_LIST_PPN');
            return Response()->json([
                'matauang' => $matauang,
                'supplier' => $supplier,
                'ppn' => $ppn
            ]);
        } catch (\Throwable $Error) {
            return Response()->json($Error);
        }
    }
    public function daftarSupplier(Request $request, $id)
    {
        $kd = 1;
        $idsup = $request->input('idsup');
        try {
            $supplier = DB::connection('ConnPurchase')->select('exec SP_1273_PBL_LIST_SUPPLIER @kd = ?, @idsup = ?', [$kd, $idsup]);
            // dd($supplier);
            return Response()->json($supplier);
        } catch (\Throwable $Error) {
            return Response()->json($Error);
        }
    }
    public function approve(Request $request, $id)
    {
        $Operator = trim(Auth::user()->NomorUser);
        $kd = 3;
        $Qty = $request->input('Qty');
        $QtyDelay = $request->input('QtyDelay');
        $idsup = $request->input('idsup');
        $kurs = $request->input('kurs');
        $pUnit = $request->input('pUnit');
        $pSub = $request->input('pSub');
        $idPPN = $request->input('idPPN');
        $pPPN = $request->input('pPPN');
        $pTOT = $request->input('pTOT') ?? 0;
        $pIDRUnit = $request->input('pIDRUnit');
        $pIDRSub = $request->input('pIDRSub');
        $pIDRPPN = $request->input('pIDRPPN');
        $pIDRTot = $request->input('pIDRTot');
        $jns_beli = $request->input('jns_beli');
        $mtUang = $request->input('mtUang');
        $noTrans = $request->input('noTrans');
        if (($noTrans != null) || ($kd != null) || ($Qty != null) || ($QtyDelay != null) || ($idsup != null) || ($mtUang != null) || ($kurs != null) || ($pUnit != null) || ($pSub != null) || ($idPPN != null) || ($pPPN != null) || ($pTOT != null) || ($pIDRUnit != null) || ($pIDRSub != null) || ($pIDRPPN != null) || ($pIDRTot != null) || ($jns_beli != null)) {
            try {
                DB::connection('ConnPurchase')
                    ->statement('exec SP_5409_SAVE_ORDER @Operator = ?, @kd = ?, @Qty = ?, @QtyDelay = ?, @idsup = ?,
                                         @kurs = ?, @pUnit = ?, @pSub = ?, @idPPN = ?, @pPPN = ?, @pTOT = ?, @pIDRUnit = ?,
                                         @pIDRSub = ?, @pIDRPPN = ?, @pIDRTot = ?, @jns_beli = ?, @mtUang = ?, @noTrans = ?',
                        [
                            $Operator,
                            $kd,
                            $Qty,
                            $QtyDelay,
                            $idsup,
                            $kurs,
                            $pUnit,
                            $pSub,
                            $idPPN,
                            $pPPN,
                            $pTOT,
                            $pIDRUnit,
                            $pIDRSub,
                            $pIDRPPN,
                            $pIDRTot,
                            $jns_beli,
                            $mtUang,
                            $noTrans,
                        ]
                    );
                if ($QtyDelay > 0) {
                    DB::connection('ConnPurchase')->statement('exec SP_5409_SAVE_ORDER @kd = ?, @noTrans = ?, @QtyDelay = ?', [14, $noTrans, $QtyDelay]);
                    return Response()->json(['message' => 'Data Berhasil DiApprove dan order baru sudah dibuat untuk quantity delay sebanyak ' . $QtyDelay]);
                }
                return Response()->json(['message' => 'Data Berhasil DiApprove']);
            } catch (\Throwable $Error) {
                return Response()->json($Error);
            }
        } else {
            return Response()->json('Parameter harus di isi');
        }
    }

    public function reject(Request $request, $id)
    {
        $kd = 16;
        $noTrans = $request->input('noTrans');
        $alasan = $request->input('alasan');
        $Operator = trim(Auth::user()->NomorUser);
        if (($noTrans != null) || ($alasan != null)) {
            try {
                $reject = DB::connection('ConnPurchase')->statement('exec SP_5409_SAVE_ORDER @Operator = ?, @kd = ?, @noTrans = ?, @alasan = ?', [$Operator, $kd, $noTrans, $alasan]);
                return Response()->json(['message' => 'Data Berhasil DiReject']);
            } catch (\Throwable $Error) {
                return Response()->json($Error);
            }
        } else {
            return Response()->json('Parameter harus di isi');
        }
    }

    public function edit($id)
    {
        dd("masuk edit");
    }

    //Update the specified resource in storage.
    public function update(Request $request, $id)
    {
        dd("masuk update");
    }

    //Remove the specified resource from storage.
    public function destroy($id)
    {
        dd("masuk destroy");
    }
}
