<?php

namespace App\Http\Controllers\Beli\TransaksiBeli;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HakAksesController;
use DB;
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

    public function redisplay(Request $request)
    {
        $Kd_Div = $request->input('Kd_Div');
        $kd = $request->input('kd');
        $noBTTB = $request->input('noBTTB');
        if (($Kd_Div != null) || ($kd != null) || ($noBTTB != null)) {
            try {
                if ($kd == 32) {
                    $redisplay = DB::connection('ConnPurchase')->select('exec SP_5409_LIST_ORDER @Kd_Div = ?, @kd = ?', [$Kd_Div, $kd]);
                } else if ($kd == 33) {
                    $redisplay = DB::connection('ConnPurchase')->select('exec SP_5409_LIST_ORDER @noBTTB = ?, @kd = ?', [$noBTTB, $kd]);
                } else if ($kd == 18) {
                    $redisplay = DB::connection('ConnPurchase')->select('exec SP_5409_LIST_ORDER @Kd_Div = ?, @kd = ?', [$Kd_Div, $kd]);
                } else if ($kd == 27) {
                    $redisplay = DB::connection('ConnPurchase')->select('exec SP_5409_LIST_ORDER @noBTTB = ?, @kd = ?', [$noBTTB, $kd]);
                }
                return datatables($redisplay)->make(true);
            } catch (\Throwable $Error) {
                return Response()->json($Error);
            }
        } else {
            return Response()->json('Parameter harus di isi');
        }
    }
    public function divisi()
    {
        $Operator = trim(Auth::user()->NomorUser);
        try {
            $data = DB::connection('ConnPurchase')->select('exec spSelect_UserDivisi_dotNet @Operator = ?, @kd = ?', [$Operator, 1]);

            return Response()->json($data);
        } catch (\Throwable $Error) {
            return Response()->json($Error);
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

    //Display the specified resource.
    public function show(Request $request, $id)
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('Beli');
        $No_PO = $request->query('No_PO');
        $No_BTTB = $request->query('No_BTTB');
        $koreksi = $request->query('koreksi');
        $Tanggal = DB::connection('ConnPurchase')->table('YTERIMA')
            ->join('INVENTORY.dbo.Tmp_Transaksi', 'YTERIMA.NoTransaksiTmp', '=', 'INVENTORY.dbo.Tmp_Transaksi.IdTransaksi')
            ->where('YTERIMA.No_BTTB', $No_BTTB)
            ->select('INVENTORY.dbo.Tmp_Transaksi.SaatAwalTransaksi', 'YTERIMA.No_BTTB')
            ->first();
        $tanggalValue = isset($Tanggal) ? Carbon::parse($Tanggal->SaatAwalTransaksi)->format('Y-m-d') : Carbon::parse(now())->format('Y-m-d');
        // dd($tanggalValue);
        // dd($No_BTTB,$No_PO,$koreksi);
        return view('Beli.TransaksiBeli.TransferBarang.TransferBTTB', compact('access', 'No_PO', 'No_BTTB', 'koreksi', 'tanggalValue'));
    }

    public function loadData(Request $request)
    {
        $noBTTB = $request->input('noBTTB');
        $koreksi = $request->input('koreksi');
        if (($noBTTB != null) && ($koreksi != null)) {
            try {
                if ($koreksi == 1) {
                    $data = DB::connection('ConnPurchase')->select('exec SP_5409_LIST_ORDER @noBTTB = ?, @kd = ?', [$noBTTB, 34]);
                } else if ($koreksi == 0) {
                    // $data = DB::connection('ConnPurchase')->select('exec SP_5409_LIST_ORDER @noBTTB = ?, @kd = ?', [$noBTTB, 19]);
                    $data = DB::connection('ConnPurchase')
                        ->table('YTERIMA')
                        ->join('YTRANSBL', 'YTERIMA.No_trans', '=', 'YTRANSBL.No_trans')
                        ->join('Y_BARANG', 'YTRANSBL.Kd_brg', '=', 'Y_BARANG.KD_BRG')
                        ->join('Y_KATEGORI_SUB', 'Y_BARANG.NO_SUB_KATEGORI', '=', 'Y_KATEGORI_SUB.no_sub_kategori')
                        ->join('Y_KATEGORY', 'Y_KATEGORI_SUB.no_kategori', '=', 'Y_KATEGORY.no_kategori')
                        ->join('Y_KATEGORI_UTAMA', 'Y_KATEGORY.no_kat_utama', '=', 'Y_KATEGORI_UTAMA.no_kat_utama')
                        ->join('YSATUAN', 'YTRANSBL.NoSatuan', '=', 'YSATUAN.No_satuan')
                        ->select('YTERIMA.No_terima', 'Y_KATEGORY.nama_kategori', 'Y_KATEGORI_SUB.nama_sub_kategori', 'YTRANSBL.Kd_brg', 'Y_BARANG.NAMA_BRG', 'YTERIMA.Qty_Terima', 'YSATUAN.Nama_satuan', 'YTERIMA.No_BTTB', 'YTERIMA.NoPIBExt')
                        ->whereNull('YTERIMA.NoTransaksiTmp')
                        ->where('YTERIMA.No_BTTB', '=', $noBTTB)
                        ->where('YTERIMA.Qty_Terima', '>', 0)
                        ->get();
                    // dd($data);
                }

                return datatables($data)->make(true);
            } catch (\Throwable $Error) {
                return Response()->json($Error);
            }
        } else {
            return Response()->json('Parameter harus di isi');
        }
    }
    public function loadSatuan(Request $request)
    {
        $kd = 20;
        $kdbrg = $request->input('kdbrg');
        if ($kdbrg != null) {
            try {
                $data = DB::connection('ConnPurchase')->select('exec SP_5409_LIST_ORDER @kdbrg = ?, @kd = ?', [$kdbrg, $kd]);
                return Response()->json($data);
            } catch (\Throwable $Error) {
                return Response()->json($Error);
            }
        } else {
            return Response()->json('Parameter harus di isi');
        }
    }
    public function divisiBTTB(Request $request)
    {
        $Type = 12;
        $KodeBarang = $request->input('KodeBarang');
        if ($KodeBarang != null) {
            try {
                $data = DB::connection('ConnInventory')->select('exec SP_1003_INV_UserDivisi @KodeBarang = ?, @Type = ?', [$KodeBarang, $Type]);
                return Response()->json($data);
            } catch (\Throwable $Error) {
                return Response()->json($Error);
            }
        } else {
            return Response()->json('Parameter harus di isi');
        }
    }
    public function objek(Request $request)
    {
        $Type = 6;
        $KodeBarang = $request->input('KodeBarang');
        $XIdDivisi = $request->input('XIdDivisi');
        if (($KodeBarang != null) && ($XIdDivisi != null)) {
            try {
                $data = DB::connection('ConnInventory')->select('exec SP_1003_INV_User_Objek @KodeBarang = ?, @Type = ?,@XIdDivisi=?', [$KodeBarang, $Type, $XIdDivisi]);
                return Response()->json($data);
            } catch (\Throwable $Error) {
                return Response()->json($Error);
            }
        } else {
            return Response()->json('Parameter harus di isi');
        }
    }
    public function loadKelomDLL(Request $request)
    {
        $Type = 11;
        $KodeBarang = $request->input('KodeBarang');
        $idObjek = $request->input('idObjek');
        $noPIB = $request->input('noPIB');
        if (($KodeBarang != null) && ($idObjek != null)) {
            try {
                $data = DB::connection('ConnInventory')->select('exec SP_1003_INV_UserDivisi @KodeBarang = ?, @Type = ?,@idObjek=? , @noPIB = ?', [$KodeBarang, $Type, $idObjek, $noPIB]);
                return Response()->json($data);
            } catch (\Throwable $Error) {
                return Response()->json($Error);
            }
        } else {
            return Response()->json('Parameter harus di isi');
        }
    }

    public function koreksi(Request $request)
    {
        $IdType = $request->input('IdType');
        $MasukPrimer = (float) str_replace(',', '', $request->input('MasukPrimer')) ?? 0.00;
        $MasukSekunder = (float) str_replace(',', '', $request->input('MasukSekunder')) ?? 0.00;
        $MasukTritier = (float) str_replace(',', '', $request->input('MasukTritier'));
        $User_id = trim(Auth::user()->NomorUser);
        $SubKel = $request->input('SubKel');
        $NoTransTmp = $request->input('NoTransTmp');
        $ket = $request->input('ket');
        $tanggal = $request->input('tanggal');
        // dd($request->all());
        // dd($MasukPrimer, $MasukSekunder, $MasukTritier);
        if (
            $IdType !== null &&
            $MasukPrimer !== null &&
            $MasukSekunder !== null &&
            $MasukTritier !== null &&
            $SubKel !== null &&
            $NoTransTmp !== null
        ) {
            $data = DB::connection('ConnPurchase')->statement('exec SP_1273_PBL_KOREKSI_TRANSFER_TMPTRANSAKSI @IdType = ?, @MasukPrimer = ?,@MasukSekunder = ?, @MasukTritier = ?, @User_id = ?,@SubKel = ?,@NoTransTmp = ?, @ket = ?, @Tanggal = ?', [
                $IdType,
                $MasukPrimer,
                $MasukSekunder,
                $MasukTritier,
                $User_id,
                $SubKel,
                (int) $NoTransTmp,
                $ket,
                $tanggal
            ]);
            return Response()->json(['message' => 'Data Berhasil Di Koreksi']);
        } else {
            return Response()->json('Parameter harus di isi');
        }
    }
    public function transfer(Request $request)
    {
        // dd($request->all());
        $IdType = $request->input('IdType');
        $MasukPrimer = (float) str_replace(',', '', $request->input('MasukPrimer')) ?? 0.00;
        $MasukSekunder = (float) str_replace(',', '', $request->input('MasukSekunder')) ?? 0.00;
        $MasukTritier = (float) str_replace(',', '', $request->input('MasukTritier'));
        $User_id = trim(Auth::user()->NomorUser);
        $SubKel = $request->input('SubKel');
        $NoTerima = $request->input('NoTerima');
        $ket = $request->input('ket');
        $YTanggal = Carbon::parse($request->input('YTanggal'));
        $NoPib = $request->input('NoPib') ?? null;
        if (
            $IdType !== null &&
            $MasukPrimer !== null &&
            $MasukSekunder !== null &&
            $MasukTritier !== null &&
            $SubKel !== null &&
            $NoTerima !== null &&
            $YTanggal !== null
        ) {
            try {
                $data = DB::connection('ConnPurchase')
                    ->statement('exec SP_7775_PBL_TRANSFER_TMPTRANSAKSI @kd = ?, @IdType = ?, @MasukPrimer = ?,@MasukSekunder = ?, @MasukTritier = ?
                                                                                , @User_id = ?,@SubKel = ?,@NoTerima = ?, @ket = ? , @YTanggal = ?, @noPIB = ?'
                        ,
                        [
                            1,
                            $IdType,
                            $MasukPrimer,
                            $MasukSekunder,
                            $MasukTritier,
                            $User_id,
                            $SubKel,
                            $NoTerima,
                            $ket,
                            $YTanggal,
                            $NoPib,
                        ]
                    );
                return Response()->json(['message' => 'Data Berhasil Di Transfer']);
            } catch (\Throwable $Error) {
                return Response()->json($Error);
            }
        } else {
            return Response()->json('Parameter harus di isi');
        }
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

    public function tampil(Request $request, $id)
    {
        if ($id == 'getKelompokUtama') {
            // dd($request->all());
            $UserInput = trim(Auth::user()->NomorUser);
            $KodeBarang = $request->input('KodeBarang');
            $idObjek = $request->input('ket_objek');
            $KelompokUtamaConn = DB::connection('ConnInventory')
                ->select('exec SP_4451_TRANSFER_BTTB @XKode = ?, @IdObjek = ?, @KodeBarang = ?', [1, $idObjek, $KodeBarang]);
            // dd($KelompokUtamaConn);
            $KelompokUtamaArr = array_map(function ($KelompokUtamaList) {
                return [
                    'NamaKelompokUtama' => $KelompokUtamaList->NamaKelompokUtama,
                    'IdKelompokUtama' => $KelompokUtamaList->IdKelompokUtama,
                ];
            }, $KelompokUtamaConn);

            return datatables($KelompokUtamaArr)->make(true);
        } else if ($id == 'getKelompok') {
            $UserInput = trim(Auth::user()->NomorUser);
            $KodeBarang = $request->input('KodeBarang');
            $idKelompokUtama = $request->input('ket_kelompokUtama');
            $KelompokConn = DB::connection('ConnInventory')
                ->select('exec SP_4451_TRANSFER_BTTB @XKode = ?, @IdKelompokUtama = ?, @KodeBarang = ?', [2, $idKelompokUtama, $KodeBarang]);
            // dd($KelompokConn);
            $KelompokArr = array_map(function ($KelompokList) {
                return [
                    'NamaKelompok' => $KelompokList->NamaKelompok,
                    'IdKelompok' => $KelompokList->IdKelompok,
                ];
            }, $KelompokConn);

            return datatables($KelompokArr)->make(true);
        } else if ($id == 'getSubKelompok') {
            $UserInput = trim(Auth::user()->NomorUser);
            $KodeBarang = $request->input('KodeBarang');
            $idKelompok = $request->input('ket_kelompok');
            $SubKelompokConn = DB::connection('ConnInventory')
                ->select('exec SP_4451_TRANSFER_BTTB @XKode = ?, @IdKelompok = ?, @KodeBarang = ?', [3, $idKelompok, $KodeBarang]);

            $SubKelompokArr = array_map(function ($SubKelompokList) {
                return [
                    'NamaSubKelompok' => $SubKelompokList->NamaSubKelompok,
                    'IdSubKelompok' => $SubKelompokList->IdSubkelompok,
                ];
            }, $SubKelompokConn);

            return datatables($SubKelompokArr)->make(true);
        } else if ($id == 'getType') {
            $UserInput = trim(Auth::user()->NomorUser);
            $KodeBarang = $request->input('KodeBarang');
            $IdSubKelompok = $request->input('ket_subKelompok');
            $TypeConn = DB::connection('ConnInventory')
                ->select('exec SP_4451_TRANSFER_BTTB @XKode = ?, @IdSubKelompok = ?, @KodeBarang = ?', [4, $IdSubKelompok, $KodeBarang]);

            $TypeArr = array_map(function ($TypeList) {
                return [
                    'NamaType' => $TypeList->NamaType,
                    'IdType' => $TypeList->IdType,
                ];
            }, $TypeConn);

            return datatables($TypeArr)->make(true);
        } else if ($id == 'getDivisiBTTB') {
            $Type = 12;
            $KodeBarang = $request->input('KodeBarang');
            // dd($KodeBarang);
            if ($KodeBarang != null) {
                try {
                    $data = DB::connection('ConnInventory')->select('exec SP_1003_INV_UserDivisi @KodeBarang = ?, @Type = ?', [$KodeBarang, $Type]);
                    $result = [];
                    // dd($data);
                    foreach ($data as $item) {
                        $result[] = [
                            'NamaDivisi' => $item->NamaDivisi,
                            'IdDivisi' => $item->IdDivisi,
                        ];
                    }

                    return datatables($result)->make(true);
                } catch (\Throwable $Error) {
                    return Response()->json($Error);
                }
            } else {
                return Response()->json('Parameter harus di isi');
            }
        } else if ($id == 'getObjek') {
            $Type = 6;
            $KodeBarang = $request->input('KodeBarang');
            $XIdDivisi = $request->input('XIdDivisi');
            // dd($request->all());
            if (($KodeBarang != null) && ($XIdDivisi != null)) {
                try {
                    $data = DB::connection('ConnInventory')->select('exec SP_1003_INV_User_Objek @KodeBarang = ?, @Type = ?,@XIdDivisi=?', [$KodeBarang, $Type, $XIdDivisi]);
                    $result = [];
                    // dd($data);
                    foreach ($data as $item) {
                        $result[] = [
                            'NamaObjek' => $item->NamaObjek,
                            'IdObjek' => $item->IdObjek,
                        ];
                    }

                    return datatables($result)->make(true);
                } catch (\Throwable $Error) {
                    return Response()->json($Error);
                }
            } else {
                return Response()->json('Parameter harus di isi');
            }
        }
    }
}
