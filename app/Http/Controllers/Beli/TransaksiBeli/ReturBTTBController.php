<?php

namespace App\Http\Controllers\Beli\TransaksiBeli;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HakAksesController;
use DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReturBTTBController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        $supplier = DB::connection('ConnPurchase')->select('exec SP_4384_PBL_Maintenance_Supplier @XKode = 0');
        $po = DB::connection('ConnPurchase')->select('exec SP_4384_PBL_Maintenance_Supplier @XKode = 0');
        $access = (new HakAksesController)->HakAksesFiturMaster('Beli');
        return view('Beli.TransaksiBeli.ReturBTTB', compact('supplier', 'access', 'po'));
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
    public function show($id)
    {
        //
    }

    //Show the form for editing the specified resource.

    public function po(Request $request)
    {
        $noPO = $request->input('noPO');
        try {
            $tabel = DB::connection('ConnPurchase')->select('exec SP_5409_LIST_ORDER @kd=?, @noPO=?', [37, $noPO]);
            $input = DB::connection('ConnPurchase')->select('exec SP_5409_LIST_ORDER @kd=?, @noPO=?', [25, $noPO]);
            return Response()->json(['tabel' => $tabel, 'input' => $input]);
        } catch (\Throwable $Error) {
            return Response()->json($Error);
        }
    }

    public function kdbrg(Request $request)
    {
        $kodebarang = $request->input('kodebarang');
        $kd = 11;
        try {
            $returbttb = DB::connection('ConnInventory')->select('exec SP_1003_INV_LIST_TYPE @Kode = ?, @kodebarang = ?', [$kd, $kodebarang]);
            return response()->json($returbttb);
        } catch (\Throwable $Error) {
            return Response()->json($Error);
        }
    }
    public function batal(request $request)
    {
        $Terima = $request->input('Terima');
        $TglRetur = Carbon::parse($request->input('tglRetur'));
        $alasan = $request->input('alasan');
        $Operator = trim(Auth::user()->NomorUser);
        $kd = 18;
        try {
            $returbttb = DB::connection('ConnPurchase')->statement('exec SP_5409_MAINT_PO @kd=?, @Terima=?, @TglRetur=?, @alasan=?, @Operator=?', [$kd, $Terima, $TglRetur, $alasan, $Operator]);
            return response()->json($returbttb);
        } catch (\Throwable $Error) {
            return Response()->json($Error);
        }
    }
    public function checkInvPenyesuaian(Request $request)
    {
        // dd($request->all());
        $IdType = $request->input('IdType');
        // dd($IdType);
        $IdTypeTransaksi = '06';
        try {
            $check = DB::connection('ConnInventory')->select('exec SP_1003_INV_check_penyesuaian_transaksi @idtype = ?, @idtypetransaksi = ?', [$IdType, $IdTypeTransaksi]);
            return response()->json($check);
        } catch (\Throwable $Error) {
            return Response()->json($Error);
        }
    }
    public function invInsertTmp(Request $request)
    {
        // dd($request->all());
        $XIdTypeTransaksi = '05';
        $XIdType = $request->input('XIdType');
        $XIdPenerima = trim(Auth::user()->NomorUser);
        $XIdPemberi = trim(Auth::user()->NomorUser);
        $XSaatawalTransaksi = Carbon::parse($request->input('XSaatawalTransaksi'));
        $XJumlahPengeluaranPrimer = $request->input('XJumlahPengeluaranPrimer');
        $XJumlahPengeluaranSekunder = $request->input('XJumlahPengeluaranSekunder');
        $XJumlahPengeluaranTritier = $request->input('XJumlahPengeluaranTritier');
        $XAsalIdSubKelompok = $request->input('XAsalIdSubKelompok');
        $XTujuanIdSubKelompok = $request->input('XTujuanIdSubKelompok');
        $XUraianDetailTransaksi = $request->input('XUraianDetailTransaksi');
        $kd = 1;
        try {
            $check = DB::connection('ConnInventory')->statement('exec SP_1003_INV_Insert_05_TmpTransaksi @XIdTypeTransaksi = ?, @XIdType = ?,@XIdPenerima = ?, @XIdPemberi = ?, @XSaatawalTransaksi = ?, @XJumlahPengeluaranPrimer = ?,@XJumlahPengeluaranSekunder = ?, @XJumlahPengeluaranTritier = ?,@XAsalIdSubKelompok = ?, @XTujuanIdSubKelompok = ?,@XUraianDetailTransaksi = ?, @kd = ?', [
                $XIdTypeTransaksi,
                $XIdType,
                $XIdPenerima,
                $XIdPemberi,
                $XSaatawalTransaksi,
                $XJumlahPengeluaranPrimer,
                $XJumlahPengeluaranSekunder,
                $XJumlahPengeluaranTritier,
                $XAsalIdSubKelompok,
                $XTujuanIdSubKelompok,
                $XUraianDetailTransaksi,
                $kd
            ]);
            // dd($check);
            $idTransaksi = DB::connection('ConnInventory')
                ->table('Tmp_Transaksi')
                ->select("IdTransaksi")
                ->where('IdType', $XIdType)
                ->where('IdTypeTransaksi', '05')
                ->where('IdPemberi', $XIdPemberi)
                ->where('SaatAwalTransaksi', $XSaatawalTransaksi)
                ->first();
            // dd($idTransaksi);
            return response()->json(['data' => $idTransaksi, "status" => $check]);
        } catch (\Throwable $Error) {
            return Response()->json($Error);
        }
    }
    public function accHangus(Request $request)
    {
        // dd($request->all());
        $IdTransaksi = $request->input('IdTransaksi');
        $idpenerima = trim(Auth::user()->NomorUser);
        $JumlahKeluarPrimer = $request->input('JumlahKeluarPrimer');
        $JumlahKeluarSekunder = $request->input('JumlahKeluarSekunder');
        $JumlahKeluarTritier = $request->input('JumlahKeluarTritier');
        // dd(
        //     $IdTransaksi['IdTransaksi'],
        //     $idpenerima,
        //     $JumlahKeluarPrimer,
        //     $JumlahKeluarSekunder,
        //     $JumlahKeluarTritier
        // );
        try {
            $data = DB::connection('ConnInventory')->statement('exec SP_1003_INV_Proses_ACC_Hangus @IdTransaksi = ?,@idpenerima = ?, @JumlahKeluarPrimer = ?,@JumlahKeluarSekunder = ?, @JumlahKeluarTritier = ?', [
                $IdTransaksi['IdTransaksi'],
                $idpenerima,
                $JumlahKeluarPrimer,
                $JumlahKeluarSekunder,
                $JumlahKeluarTritier,
            ]);
            return response()->json($data);
        } catch (\Throwable $Error) {
            return Response()->json($Error);
        }
    }
    public function retur(request $request)
    {
        // dd($request->all());
        $Terima = $request->input('Terima');
        $TglRetur = $request->input('tglRetur');
        $alasan = $request->input('alasan');
        $Operator = trim(Auth::user()->NomorUser);
        $kd = 14;
        $qtyRetur = (float) $request->input('qtyRetur');
        // dd($kd, $Terima, $TglRetur, $alasan, $Operator, $qtyRetur);
        try {
            $returbttb = DB::connection('ConnPurchase')->statement('exec SP_5409_MAINT_PO @kd=?, @Terima=?, @TglRetur=?, @alasan=?, @Operator=?, @qtyRetur=?', [$kd, $Terima, $TglRetur, $alasan, $Operator, $qtyRetur]);
            return response()->json($returbttb);
        } catch (\Throwable $Error) {
            return Response()->json($Error);
        }
    }
    public function edit($id)
    {
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
