<?php

namespace App\Http\Controllers\Beli\TransaksiBeli;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HakAksesController;
use DB;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TransferBarangController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('Beli');
        $result = (new HakAksesController)->HakAksesFitur('Transfer Barang');
        if ($result > 0) {
            return view('Beli.TransaksiBeli.TransferBarang.TransferBarang', compact('access'));
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
        $IdType = $request->IdType;
        $NoSPPB = $request->NoSPPB;
        $NoPIB = $request->NoPIB;
        $MasukPrimer = $request->MasukPrimer;
        $MasukSekunder = $request->MasukSekunder;
        $MasukTritier = $request->MasukTritier;
        $user = trim(Auth::user()->NomorUser);
        $SubKel = $request->SubKel;
        $NoTerima = $request->NoTerima;
        $KdBarang = $request->KdBarang;
        $NoSatuan = $request->NoSatuan;
        $SatuanPrimer = $request->SatuanPrimer;
        $SatuanSekunder = $request->SatuanSekunder;
        try {
            DB::connection('ConnPurchase')->statement(
                'exec SP_1273_PRG_TRANSFER_TMPTRANSAKSI
                            @IdType = ?,
                            @NoSPPB = ?,
                            @NoPIB = ?,
                            @MasukPrimer = ?,
                            @MasukSekunder = ?,
                            @MasukTritier = ?,
                            @user_id = ?,
                            @SubKel = ?,
                            @NoTerima = ?',
                [
                    $IdType,
                    $NoSPPB,
                    $NoPIB,
                    $MasukPrimer,
                    $MasukSekunder,
                    $MasukTritier,
                    $user,
                    $SubKel,
                    $NoTerima,
                ]
            );
            $noTempTrans = DB::connection('ConnPurchase')->select('exec SP_1273_PRG_CEK_TMPTRANSAKSI @NoTerima = ?', [$NoTerima]);

            DB::connection('ConnInventory')->statement(
                'exec SP_1273_PBL_DISPRESIASI_TEMP
                            @NoTempTrans = ?,
                            @NoPIB = ?,
                            @KdBarang = ?,
                            @IdType = ?,
                            @Quantity = ?,
                            @Satuan = ?,
                            @QuantityPrimer = ?,
                            @SatuanPrimer = ?,
                            @QuantitySekunder = ?,
                            @SatuanSekunder = ?',
                [
                    $noTempTrans,
                    $NoPIB,
                    $KdBarang,
                    $IdType,
                    $MasukTritier,
                    $NoSatuan,
                    $MasukPrimer,
                    $SatuanPrimer,
                    $$MasukSekunder,
                    $SatuanSekunder,
                ]
            );
            return response()->json(['success' => true], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show(Request $request, $id)
    {
        if ($id == 'getDivisi') {
            try {
                $divisi = DB::connection('ConnPurchase')->select('exec SP_1273_Prg_LIST_DIVISI');
                return response()->json($divisi);
            } catch (Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        } else if ($id == 'getDataBTTB') {
            try {
                $idDivisi = $request->idDivisi;
                $tglAkhir = $request->tglAkhir;
                $tglAwal = $request->tglAwal;
                $dataBTTB = DB::connection('ConnPurchase')->select(
                    'exec SP_1273_PRG_SLC_BELUM_TRANSFER
                            @terima_1 = ?,
                            @terima_2 = ?,
                            @kd_div_3 = ?',
                    [
                        $tglAwal,
                        $tglAkhir,
                        $idDivisi
                    ]
                );
                return response()->json($dataBTTB);
            } catch (Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        } else if ($id == 'cekIdType') {
            try {
                $idDivisi = $request->idDivisi;
                $kodeBarang = $request->kodeBarang;
                $dataType = DB::connection('ConnPurchase')->select(
                    'exec SP_4384_TRANSFER_PEMBELIAN
                    @Kode = ?,
                    @KdBrg = ?,
                    @IdDivisi = ?',
                    [
                        1,
                        $kodeBarang,
                        $idDivisi
                    ]
                );

                if (count($dataType) >= 1) {
                    return response()->json($dataType);
                } else {
                    return response()->json(['error' => (string) 'Kode barang ' . $kodeBarang . ' belum ada di divisi ' . $idDivisi]);
                }
            } catch (Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        } else {
            return response()->json(['error' => 'Invalid request'], 400);
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
