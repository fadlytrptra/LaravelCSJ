<?php

namespace App\Http\Controllers\Accounting\Informasi;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HakAksesController;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Str;


class SoplangController extends Controller
{
    public function index()
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('Accounting');
        return view('Accounting.Informasi.Soplang', compact('access'));
    }

    //Show the form for creating a new resource.
    public function create()
    {
        //
    }

    //Store a newly created resource in storage.
    public function store(Request $request)
    {
        set_time_limit(1000);
        $tglAkhir = Carbon::parse($request->input('tglAkhirLaporan'));
        $bln = (int) $tglAkhir->format('m');
        $thn = (int) $tglAkhir->format('Y');
        $periode = $tglAkhir->format('mY');

        DB::connection('ConnAccounting')->beginTransaction();
        try {
            // 1. Reset data saldo
            DB::connection('ConnAccounting')->table('T_Saldo_Piutang')->delete();

            // 2. Ambil data penagihan
            $penagihans = DB::connection('ConnAccounting')
                ->table('vw_prg_Penagihan_SJ')
                ->select('Id_Customer', 'NamaCust', 'Id_Penagihan', 'Tgl_Penagihan', 'Nama_MataUang', 'NilaiKurs', 'Nilai_Penagihan', 'Nama_Dokumen')
                ->where(function ($q) use ($bln, $thn, $tglAkhir) {
                    $q->whereRaw('MONTH(Tgl_lunas)=? AND YEAR(Tgl_lunas)=?', [$bln, $thn])
                        ->orWhere(fn($q2) => $q2->where('Lunas', 'N')->where('Tgl_Penagihan', '<=', $tglAkhir))
                        ->orWhere(fn($q3) => $q3->where('Lunas', 'Y')->where('Tgl_Penagihan', '<=', $tglAkhir)->where('Tgl_Lunas', '>', $tglAkhir));
                })
                ->orderBy('NamaCust')
                ->orderBy('Tgl_Penagihan')
                ->get();

            foreach ($penagihans as $p) {
                $syarat = DB::connection('ConnAccounting')
                    ->table('sales.dbo.vw_prg_penagihan')
                    ->where('idPenagihan', $p->Id_Penagihan)
                    ->value('SyaratBayar');

                $jatuhTempo = $syarat
                    ? Carbon::parse($p->Tgl_Penagihan)->addDays($syarat)
                    : null;

                $sisaTerakhir = null;
                $sw = 0;
                $nilai_penagihan_asli = $p->Nilai_Penagihan;

                // Ambil detail pelunasan
                $details = DB::connection('ConnAccounting')
                    ->table('VW_PRG_1486_ACC_BAYAR_TAGIHAN')
                    ->where('Bulan', $bln)
                    ->where('Tahun', $thn)
                    ->where('ID_Penagihan', $p->Id_Penagihan)
                    ->orderBy('ID_Detail_Pelunasan')
                    ->get();

                foreach ($details as $d) {
                    $sw++;
                    $tglCair = $tunai = $bgCair = $bgMundur = $idBkm = $sisa = $tglPelunasan = null;
                    $saldoPenagihan = 0;
                    $det = DB::connection('ConnAccounting')
                        ->table('vw_prg_t_detail_pelunasan_tagihan1')
                        ->where('ID_Detail_Pelunasan', $d->ID_Detail_Pelunasan)
                        ->first();

                    // dd($det);
                    $pel = $det->Pelunasan_Curency;
                    $sisa = $det->Sisa_Nilai_Tagihan;
                    $sisaTerakhir = $sisa;
                    $tglCair = $det->TglCair;
                    $idPel = $det->ID_Pelunasan;
                    $idBkm = $det->Id_BKM;
                    // dd($sisa >= 0);
                    // dd($pel, $sisa, $sisaTerakhir, $tglCair, $idPel, $idBkm);
                    $pelInfo = DB::connection('ConnAccounting')
                        ->table('vw_prg_t_pelunasan_tagihan')
                        ->where('Id_Pelunasan', $idPel)
                        ->first();

                    // dd($pelInfo);
                    $idBayar = $pelInfo->Id_Jenis_Bayar;
                    $tglPelunasan = $pelInfo->Tgl_Pelunasan;
                    $noBukti = $pelInfo->No_Bukti;
                    // dd($idBayar, $tglPelunasan, $noBukti);
                    // dd($bln);
                    // dd(Carbon::parse($tglCair)->month);
                    // dd(in_array($idBayar, [1, 4]) && $tglCair && Carbon::parse($tglCair)->month == $bln && Carbon::parse($tglCair)->year == $thn);

                    if (in_array($idBayar, [1, 4]) && $tglCair && Carbon::parse($tglCair)->month == $bln && Carbon::parse($tglCair)->year == $thn) {
                        $tunai = $pel;
                    } elseif (in_array($idBayar, [2, 3]) && $tglCair && Carbon::parse($tglCair)->month == $bln && Carbon::parse($tglCair)->year == $thn) {
                        $bgCair = $pel;
                    } else {
                        $bgMundur = $pel;
                        $tglCair = null;
                        $idBkm = null;
                    }

                    if (trim($p->Nama_MataUang) != 'RUPIAH') {
                        $sisa = $sisa / $p->NilaiKurs;
                    }

                    $saldoPenagihan = ($sisa >= 0) ? ($sisa + $pel) : $nilai_penagihan_asli;
                    $nilaiPen = ($sw > 1) ? 0 : $nilai_penagihan_asli;

                    DB::connection('ConnAccounting')
                        ->table('T_Saldo_Piutang')
                        ->insert([
                            'Periode' => $periode,
                            'Customer' => $p->NamaCust,
                            'Dokumen' => $p->Nama_Dokumen,
                            'IdPenagihan' => trim($p->Id_Penagihan),
                            'TglPenagihan' => $p->Tgl_Penagihan,
                            'Syarat' => $syarat,
                            'JatuhTempo' => $jatuhTempo,
                            'MataUang' => $p->Nama_MataUang,
                            'NilaiPenagihan' => $nilaiPen,
                            'TglCair' => $tglCair,
                            'Tunai' => $tunai,
                            'BGCair' => $bgCair,
                            'BGMundur' => $bgMundur,
                            'BClaim' => null,
                            'Pembulatan' => null,
                            'NilaiSisa' => $sisa,
                            'IDBKM' => $idBkm,
                            'TglPelunasan' => $tglPelunasan,
                            'SaldoPenagihan' => $saldoPenagihan,
                            'NilaiKurs' => $p->NilaiKurs,
                            'Id_Customer' => $p->Id_Customer
                        ]);
                }

                // Logika ketika lebih dari 1 pelunasan
                if ($sw > 1) {
                    $rows = DB::connection('ConnAccounting')
                        ->table('T_Saldo_Piutang')
                        ->where('IdPenagihan', $p->Id_Penagihan)
                        ->get();

                    foreach ($rows as $r) {
                        $ttl = ($r->Tunai ?? 0) + ($r->BGCair ?? 0);
                        DB::connection('ConnAccounting')
                            ->table('T_Saldo_Piutang')->where('Id', $r->Id)
                            ->update([
                                'SaldoPenagihan' => $ttl,
                                'NilaiSisa' => $ttl - (($r->Tunai ?? 0) + ($r->BGCair ?? 0))
                            ]);
                    }

                    if ($sisa > 0) {
                        DB::connection('ConnAccounting')->table('T_Saldo_Piutang')->insert([
                            'Periode' => $periode,
                            'Customer' => $p->NamaCust,
                            'Dokumen' => $p->Nama_Dokumen,
                            'IdPenagihan' => trim($p->Id_Penagihan),
                            'TglPenagihan' => $p->Tgl_Penagihan,
                            'Syarat' => $syarat,
                            'JatuhTempo' => $jatuhTempo,
                            'MataUang' => $p->Nama_MataUang,
                            'NilaiPenagihan' => 0,
                            'TglCair' => null,
                            'Tunai' => 0,
                            'BGCair' => 0,
                            'BGMundur' => 0,
                            'BClaim' => null,
                            'Pembulatan' => null,
                            'NilaiSisa' => $sisa,
                            'IDBKM' => null,
                            'TglPelunasan' => $tglPelunasan ?? null,
                            'SaldoPenagihan' => $sisa,
                            'NilaiKurs' => $p->NilaiKurs,
                            'Id_Customer' => $p->Id_Customer
                        ]);
                    }
                }

                if ($sw == 0) {
                    // Ambil saldo terakhir
                    $sisa = DB::connection('ConnAccounting')
                        ->table('T_DETAIL_PELUNASAN_TAGIHAN as dpt')
                        ->join('T_PELUNASAN_TAGIHAN as pt', 'dpt.ID_Pelunasan', '=', 'pt.Id_Pelunasan')
                        ->join('T_PELUNASAN as p', 'pt.Id_BKM', '=', 'p.Id_BKM')
                        ->where('dpt.ID_Penagihan', $p->Id_Penagihan)
                        ->where('p.Tgl_Input', '<', $tglAkhir)
                        ->min('dpt.Sisa_Nilai_Tagihan');

                    if (trim($p->Nama_MataUang) !== 'RUPIAH') {
                        $sisa = $sisa / $p->NilaiKurs;
                    }

                    if ($sisa >= 0) {
                        $saldoPenagihan = $sisa;
                    } else {
                        $saldoPenagihan = $p->Nilai_Penagihan;
                    }

                    DB::connection('ConnAccounting')->table('T_SALDO_PIUTANG')->insert([
                        'Periode' => $periode,
                        'Customer' => $p->NamaCust,
                        'Dokumen' => $p->Nama_Dokumen,
                        'IdPenagihan' => trim($p->Id_Penagihan),
                        'TglPenagihan' => $p->Tgl_Penagihan,
                        'Syarat' => $syarat,
                        'JatuhTempo' => $jatuhTempo,
                        'MataUang' => $p->Nama_MataUang,
                        'NilaiPenagihan' => $p->Nilai_Penagihan,
                        'TglCair' => $tglCair ?? null,
                        'Tunai' => $tunai ?? 0,
                        'BGCair' => $bgCair ?? 0,
                        'BGMundur' => $bgMundur ?? 0,
                        'BClaim' => null,
                        'Pembulatan' => null,
                        'NilaiSisa' => $saldoPenagihan,
                        'IDBKM' => $p->Id_BKM ?? null,
                        'TglPelunasan' => $tglPelunasan ?? null,
                        'SaldoPenagihan' => $saldoPenagihan,
                        'NilaiKurs' => $p->NilaiKurs,
                        'Id_Customer' => $p->Id_Customer
                    ]);
                }

                // Ambil ID terakhir dari T_SALDO_PIUTANG
                $idSaldo = DB::connection('ConnAccounting')->table('T_SALDO_PIUTANG')
                    ->where('IdPenagihan', $p->Id_Penagihan)
                    ->orderByDesc('Id')
                    ->value('Id');
                // dd($idSaldo);
                // Hitung Pembulatan
                $pembulatan = DB::connection('ConnAccounting')
                    ->table('VW_PRG_1486_ACC_PEMBULATAN_KRG')
                    ->where('ID_Penagihan_Pembulatan', $p->Id_Penagihan)
                    ->where('Bulan', $bln)
                    ->where('Tahun', $thn)
                    ->sum('KurangLebih');
                // dd($pembulatan);
                // Hitung Retur (JnsNotaKredit = 1)
                $retur = DB::connection('ConnAccounting')
                    ->table('VW_PRG_1486_ACC_BAYAR_NOTA_KREDIT')
                    ->where('ID_Penagihan', $p->Id_Penagihan)
                    ->where('Bulan', $bln)
                    ->where('Tahun', $thn)
                    ->where('JnsNotaKredit', 1)
                    ->sum('Pelunasan_Curency');
                // dd($retur);
                // Hitung Potongan (JnsNotaKredit = 2)
                $potongan = DB::connection('ConnAccounting')
                    ->table('VW_PRG_1486_ACC_BAYAR_NOTA_KREDIT')
                    ->where('ID_Penagihan', $p->Id_Penagihan)
                    ->where('Bulan', $bln)
                    ->where('Tahun', $thn)
                    ->where('JnsNotaKredit', 2)
                    ->sum('Pelunasan_Curency');
                // dd($potongan);
                // Update T_SALDO_PIUTANG
                DB::connection('ConnAccounting')->table('T_SALDO_PIUTANG')
                    ->where('Id', $idSaldo)
                    ->update([
                        'Retur' => $retur,
                        'Pembulatan' => $pembulatan,
                        'BClaim' => $potongan,
                        'NilaiSisa' => DB::raw("NilaiSisa - " . ((float) $retur + (float) $pembulatan + (float) $potongan))
                    ]);
                // dd($sw);
                // Jika pembulatan ada dan sw = 0
                if ($pembulatan > 0 && $sw == 0) {
                    $dataBulat = DB::connection('ConnAccounting')
                        ->table('VW_PRG_1486_ACC_PEMBULATAN_KRG')
                        ->select('Tgl_Input', 'Id_BKM')
                        ->where('ID_Penagihan_Pembulatan', $p->Id_Penagihan)
                        ->where('Bulan', $bln)
                        ->where('Tahun', $thn)
                        ->first();

                    if ($dataBulat) {
                        DB::connection('ConnAccounting')->table('T_SALDO_PIUTANG')
                            ->where('Id', $idSaldo)
                            ->update([
                                'IDBKM' => $dataBulat->Id_BKM,
                                'TglPelunasan' => $dataBulat->Tgl_Input
                            ]);
                    }
                }

                // Jika retur atau potongan ada dan sw = 0
                if (($potongan > 0 || $retur > 0) && $sw == 0) {
                    $dataKredit = DB::connection('ConnAccounting')
                        ->table('VW_PRG_1486_ACC_BAYAR_NOTA_KREDIT')
                        ->select('Tgl_Input', 'Id_BKM')
                        ->where('ID_Penagihan', $p->Id_Penagihan)
                        ->where('Bulan', $bln)
                        ->where('Tahun', $thn)
                        ->first();

                    if ($dataKredit) {
                        DB::connection('ConnAccounting')->table('T_SALDO_PIUTANG')
                            ->where('Id', $idSaldo)
                            ->update([
                                'IDBKM' => $dataKredit->Id_BKM,
                                'TglPelunasan' => $dataKredit->Tgl_Input
                            ]);
                    }
                }
            }

            DB::connection('ConnAccounting')->commit();
            return response()->json(['success' => 'Data Selesai Diproses. Silakan Lihat Di Excel']);
        } catch (\Throwable $e) {
            DB::connection('ConnAccounting')->rollBack();
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    //Display the specified resource.
    public function show($id, Request $request)
    {
        $tglAkhir = $request->input('tglAkhir');
        $date = Carbon::parse($tglAkhir);

        if ($id === 'lihat') {
            $results = DB::connection('ConnAccounting')->select('exec [SP_PROSES_SALDOPIUTANG2] @TglAkhir = ?', [$date]);

            $response = [];
            foreach ($results as $row) {
                $response[] = [
                    'Id_Customer' => $row->Id_Customer,    // Map @idcust
                    'NamaCust' => $row->NamaCust,       // Map @NamaCust
                    'Id_Penagihan' => $row->Id_Penagihan,   // Map @IdPenagihan
                    'Tgl_Penagihan' => $row->Tgl_Penagihan,  // Map @TglPenagihan
                    'Nama_MataUang' => $row->Nama_MataUang,  // Map @Nama_MataUang
                    'NilaiKurs' => $row->NilaiKurs,      // Map @NilaiKurs
                    'Nilai_Penagihan' => $row->Nilai_Penagihan, // Map @Nilai_Penagihan
                    'Dokumen' => $row->Nama_Dokumen,   // Map @Dokumen
                    'Id_Detail_Pelunasan' => $row->Id_Detail_Pelunasan,  // Map @IdDetail
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
    public function update(Request $request, $id)
    {
        set_time_limit(1000);
        $tglAkhirLaporan = $request->input('tglAkhirLaporan');
        $date = Carbon::parse($tglAkhirLaporan);
        $bln = $date->format('m');
        $thn = $date->format('Y');
        $periode = $bln . $thn;

        // $startTime = microtime(true);

        // set_time_limit(300); // Increase execution time limit to 300 seconds

        // $endTime = microtime(true);
        // $elapsedTime = $endTime - $startTime;
        // Log::info((string) 'Elapsed Time for post BTTB: ' . $elapsedTime . ' | NoTrans: ');

        if ($id === 'proses') {
            try {
                $listDataSoplang = DB::connection('ConnAccounting')
                    // ->statement('exec [SP_Proses_SaldoPiutang] @TglAkhir = ?', [$tglAkhirLaporan]);
                    ->statement('exec [SP_4451_ACC_GetDataProsesSaldoPiutang] @TglAkhir = ?', [$tglAkhirLaporan]);

                // dd($listDataSoplang);
                return response()->json(['success' => 'Data Selesai Diproses. Silakan Lihat Di Excell'], 200);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Data gagal diSIMPAN: ' . $e->getMessage()], 500);
            }
        }
    }


    //Remove the specified resource from storage.
    public function destroy($id)
    {
        //
    }
}
