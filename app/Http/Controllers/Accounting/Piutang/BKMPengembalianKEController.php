<?php

namespace App\Http\Controllers\Accounting\Piutang;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HakAksesController;

class BKMPengembalianKEController extends Controller
{
    public function index()
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('Accounting');
        return view('Accounting.Piutang.BKMPengembalianKE', compact('access'));
    }

    //Show the form for creating a new resource.
    public function create()
    {
        //
    }

    //Store a newly created resource in storage.
    public function store(Request $request)
    {
        dd($request->all());
        $idBKK = $request->idBKK;
        $idBKM = $request->idBKM;
        $tanggal = $request->tanggal;
        $konversi = $request->konversi;
        $nilai1 = $request->nilai1;
        $nilai = $request->nilai;
        $idBankBKM = $request->idBankBKM;
        $idMataUangBKM = $request->idMataUangBKM;
        $idJenisPembayaranBKM = $request->idJenisPembayaranBKM;
        $idKodePerkiraanBKM = $request->idKodePerkiraanBKM;
        $uraianBKM = $request->uraianBKM;
        $kurs = $request->kurs;
        $idCustomer = $request->idCustomer;
        $jenisBankBKM = $request->jenisBankBKM;
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $idBankBKK = $request->idBankBKK;
        $idPembayaran = $request->idPembayaran;
        $uraianBKK = $request->uraianBKK;
        $idKodePerkiraanBKK = $request->idKodePerkiraanBKK;
        $jenisBankBKK = $request->jenisBankBKK;

        $tgl = $tahun . '-' . $bulan . '-01';

        $id_bkm = $request->id_bkm;
        $id_bkk = $request->id_bkk;
        $konversi1 = $request->konversi1;

        DB::connection('ConnAccounting')->statement('exec [SP_5298_ACC_INSERT_BKM_TPELUNASAN]
        @idBKM = ?,
        @tglinput = ?,
        @userinput = ?,
        @terjemahan = ?,
        @nilaipelunasan = ?,
        @IdBank= ?',
            [
                $idBKM,
                $tanggal,
                1,
                $konversi,
                $nilai1,
                $idBankBKM
            ]
        );

        DB::connection('ConnAccounting')->statement('exec [SP_5298_ACC_INSERT_BKM_TPELUNASAN_TAG]
        @idBKM = ?,
        @tgl = ?,
        @idUang = ?,
        @idJenis = ?,
        @idBank = ?,
        @kodeperkiraan = ?,
        @uraian = ?,
        @nilaipelunasan = ?,
        @user = ?,
        @Kurs = ?,
        @idCust = ?',
            [
                $idBKM,
                $tanggal,
                $idMataUangBKM,
                $idJenisPembayaranBKM,
                $idBankBKM,
                $idKodePerkiraanBKM,
                $uraianBKM,
                $nilai1,
                1,
                $kurs,
                $idCustomer
            ]
        );

        DB::connection('ConnAccounting')->statement('exec [SP_5298_ACC_UPDATE_COUNTER_IDBKM]
        @idbkm = ?,
        @idBank = ?,
        @jenis = ?,
        @tgl = ?',
            [
                $id_bkm,
                $idBankBKM,
                $jenisBankBKM,
                $tgl
            ]
        );

        DB::connection('ConnAccounting')->statement('exec [SP_5298_ACC_INSERT_BKK_TPEMBAYARAN]
        @idBKk = ?,
        @tgl = ?,
        @userinput = ?,
        @terjemahan = ?,
        @nilai = ?,
        @IdBank = ?',
            [
                $idBKK,
                $tanggal,
                1,
                $konversi1,
                $nilai,
                $idBankBKM
            ]
        );

        DB::connection('ConnAccounting')->statement('exec [SP_5298_ACC_INSERT_BKK_TPEMBAYARAN_TAG]
        @idBKk = ?,
        @idUang = ?,
        @idJenis = ?,
        @idBank = ?,
        @nilai = ?,
        @user = ?,
        @kurs = ?,
        @idBKM_acuan = ?',
            [
                $idBKK,
                $idMataUangBKM,
                $idJenisPembayaranBKM,
                $idBankBKK,
                $nilai,
                1,
                $kurs,
                $idBKM
            ]
        );

        DB::connection('ConnAccounting')->statement('exec [SP_5298_ACC_INSERT_BKK_TDETAILPEMB]
        @idpembayaran = ?,
        @keterangan = ?,
        @biaya = ?,
        @kodeperkiraan = ?',
            [
                $idPembayaran,
                $uraianBKK,
                $nilai,
                $idKodePerkiraanBKK
            ]
        );

        DB::connection('ConnAccounting')->statement('exec [SP_5298_ACC_UPDATE_COUNTER_IDBKK]
        @idbkk = ?,
        @idBank = ?,
        @jenis = ?,
        @tgl = ?',
            [
                $id_bkk,
                $idBankBKK,
                $jenisBankBKK,
                $tgl
            ]
        );

        return redirect()->back()->with('success', 'BKK No. ' . $idBKK . ' & BKM No. ' . $idBKM . ' Tersimpan');
    }

    //Display the specified resource.
    public function show($id, Request $request)
    {
        if ($id === 'getCust') {
            $divisi = DB::connection('ConnAccounting')->select('exec SP_5298_ACC_LIST_CUSTOMER');
            $data_divisi = [];
            foreach ($divisi as $detail_divisi) {
                $data_divisi[] = [
                    'NamaCust' => $detail_divisi->NamaCust,
                    'IdCust' => $detail_divisi->IdCust,
                ];
            }
            return datatables($divisi)->make(true);
        }

        // get divisi
        else if ($id === 'getMataUang') {
            $divisi = DB::connection('ConnAccounting')->select('exec SP_5298_ACC_LIST_MATA_UANG @kode = ?', [1]);
            $data_divisi = [];
            foreach ($divisi as $detail_divisi) {
                $data_divisi[] = [
                    'Id_MataUang' => $detail_divisi->Id_MataUang,
                    'Nama_MataUang' => $detail_divisi->Nama_MataUang,
                ];
            }
            return datatables($divisi)->make(true);
        }

        // get divisi
        else if ($id === 'getBank') {
            $divisi = DB::connection('ConnAccounting')->select('exec SP_5298_ACC_LIST_BANK');
            $data_divisi = [];
            foreach ($divisi as $detail_divisi) {
                $data_divisi[] = [
                    'Id_Bank' => $detail_divisi->Id_Bank,
                    'Nama_Bank' => $detail_divisi->Nama_Bank,
                ];
            }
            return datatables($divisi)->make(true);
        }

        // get divisi
        else if ($id === 'getAccBank') {
            $idBank = $request->input('idBank');

            $divisi = DB::connection('ConnAccounting')->select('exec SP_5298_ACC_LIST_BANK_1 @idBank = ?', [$idBank]);
            $data_divisi = [];
            foreach ($divisi as $detail_divisi) {
                $data_divisi[] = [
                    'jenis' => $detail_divisi->jenis,
                ];
            }
            return response()->json($data_divisi);
        }

        // get divisi
        else if ($id === 'getJenisBayar') {
            $divisi = DB::connection('ConnAccounting')->select('exec SP_5298_ACC_JENIS_DOK');
            $data_divisi = [];
            foreach ($divisi as $detail_divisi) {
                $data_divisi[] = [
                    'Id_Jenis_Bayar' => $detail_divisi->Id_Jenis_Bayar,
                    'Jenis_Pembayaran' => $detail_divisi->Jenis_Pembayaran,
                ];
            }
            return datatables($divisi)->make(true);
        }

        // get divisi
        else if ($id === 'getPerkiraan') {
            $divisi = DB::connection('ConnAccounting')->select('exec SP_5298_ACC_LIST_KODE_PERKIRAAN @Kode = ?', [1]);
            $data_divisi = [];
            foreach ($divisi as $detail_divisi) {
                $data_divisi[] = [
                    'NoKodePerkiraan' => $detail_divisi->NoKodePerkiraan,
                    'Keterangan' => $detail_divisi->Keterangan,
                ];
            }
            return datatables($divisi)->make(true);
        }

        // get idbkm
        else if ($id === 'getIdBKM') {
            $tahun = $request->input('tahun');
            $bank = $request->input('bank');

            $ada = DB::connection('ConnAccounting')
                ->table('T_Counter_BKM')
                ->where('Periode', $tahun)
                ->count();

            if ($ada === 1) {
                $noUrut = DB::connection('ConnAccounting')
                    ->table('T_Counter_BKM')
                    ->where('Periode', $tahun)
                    ->value('Id_BKM_E_Rp');

            } else if ($ada === 0) {
                $noUrut = 1;
                DB::connection('ConnAccounting')
                    ->table('T_Counter_BKM')
                    ->insert([
                        'Periode' => $tahun,
                        'Id_BKM_E_Rp' => $noUrut
                    ]);
            }

            $idBKM = str_pad($noUrut, 5, '0', STR_PAD_LEFT);
            $idBKM = $bank . '-R' . substr($tahun, -2) . substr($idBKM, -5);

            DB::connection('ConnAccounting')
                ->table('T_Counter_BKM')
                ->where('Periode', $tahun)
                ->update(['Id_BKM_E_Rp' => $noUrut + 1]);

            return response()->json(['IdBKM' => $idBKM]);
        }

        // id bkk
        else if ($id === 'getIdBKK') {
            $tahun = $request->input('tahun');
            $bank = $request->input('bank');

            $ada = DB::connection('ConnAccounting')
                ->table('T_COUNTER_BKK')
                ->where('Periode', $tahun)
                ->count();

            if ($ada === 1) {
                $noUrut = DB::connection('ConnAccounting')
                    ->table('T_COUNTER_BKK')
                    ->where('Periode', $tahun)
                    ->value('Id_BKK_E_Rp');

            } else if ($ada === 0) {
                $noUrut = 1;
                DB::connection('ConnAccounting')
                    ->table('T_COUNTER_BKK')
                    ->insert([
                        'Periode' => $tahun,
                        'Id_BKK_E_Rp' => $noUrut
                    ]);
            }

            $idBKK = str_pad($noUrut, 5, '0', STR_PAD_LEFT);
            $idBKK = $bank . '-P' . substr($tahun, -2) . substr($idBKK, -5);

            DB::connection('ConnAccounting')
                ->table('T_COUNTER_BKK')
                ->where('Periode', $tahun)
                ->update(['Id_BKK_E_Rp' => $noUrut + 1]);

            return response()->json(['IdBKK' => $idBKK]);
        }

        // get divisi
        else if ($id === 'getSymbol') {
            $nama = $request->input('nama');

            $divisi = DB::connection('ConnAccounting')->select('exec SP_5298_ACC_LIST_MATA_UANG
            @kode = ?, @nama = ?', [3, $nama]);
            $data_divisi = [];
            foreach ($divisi as $detail_divisi) {
                $data_divisi[] = [
                    'Symbol' => $detail_divisi->Symbol,
                ];
            }
            return response()->json($data_divisi);
        }

        // get        getListFullBKM
        else if ($id === 'getListFullBKM') {
            $divisi = DB::connection('ConnAccounting')->select('exec SP_5298_ACC_LIST_BKM_KE');
            $data_divisi = [];
            foreach ($divisi as $detail_divisi) {
                $data_divisi[] = [
                    'Tgl_Input' => $detail_divisi->Tgl_Input,
                    'Id_BKM' => $detail_divisi->Id_BKM,
                    'Nilai_Pelunasan' => $detail_divisi->Nilai_Pelunasan,
                    'Terjemahan' => $detail_divisi->Terjemahan,
                ];
            }
            return response()->json($data_divisi);
        }

        // list bkm
        else if ($id === 'getListBKM') {
            $tgl1 = $request->input('tgl1');
            $tgl2 = $request->input('tgl2');

            $divisi = DB::connection('ConnAccounting')->select('exec SP_5298_ACC_LIST_BKM_KE_PERTGL
                    @tgl1 = ?, @tgl2 = ?', [$tgl1, $tgl2]);
            $data_divisi = [];
            foreach ($divisi as $detail_divisi) {
                $data_divisi[] = [
                    'Tgl_Input' => $detail_divisi->Tgl_Input,
                    'Id_BKM' => $detail_divisi->Id_BKM,
                    'Nilai_Pelunasan' => $detail_divisi->Nilai_Pelunasan,
                    'Terjemahan' => $detail_divisi->Terjemahan,
                ];
            }
            return response()->json($data_divisi);
        }

        // detail bkm
        else if ($id === 'getCetakBKM') {
            $id_bkm = $request->input('id_bkm');

            $divisi = DB::connection('ConnAccounting')
                ->table('VW_PRG_5298_ACC_CETAK_BKM_NOTAGIH_1')
                ->where('Id_BKM', $id_bkm)
                ->get();

            $sumResult = DB::connection('ConnAccounting')
                ->table('VW_PRG_5298_ACC_CETAK_BKM_NOTAGIH_1')
                ->where('Id_BKM', $id_bkm)
                ->select(
                    DB::raw('SUM(Nilai_Rincian) as total_nilai_rincian')
                )
                ->first();

            $totalNilaiRincian = $sumResult->total_nilai_rincian;

            $data_divisi = [];
            foreach ($divisi as $detail_divisi) {
                $data_divisi[] = [
                    'Id_BKM' => $detail_divisi->Id_BKM,
                    'Tgl_Input' => $detail_divisi->Tgl_Input,
                    'Terjemahan' => $detail_divisi->Terjemahan,
                    'Nilai_Pelunasan' => $detail_divisi->Nilai_Pelunasan,
                    'Nilai_Rincian' => $detail_divisi->Nilai_Rincian,
                    'KodePerkiraan' => $detail_divisi->KodePerkiraan,
                    // 'Keterangan' => $detail_divisi->Keterangan,
                    'Uraian' => $detail_divisi->Uraian,
                    'Symbol' => $detail_divisi->Symbol,
                    'NamaCust' => $detail_divisi->NamaCust,
                    'Id_Bank' => $detail_divisi->Id_bank,
                    'totalNilaiRincian' => $totalNilaiRincian,
                ];
            }

            return response()->json($data_divisi);
        }

        // get        getListFullBKM
        else if ($id === 'getListFullBKK') {
            $divisi = DB::connection('ConnAccounting')->select('exec SP_5298_ACC_LIST_BKK_KE');
            $data_divisi = [];
            foreach ($divisi as $detail_divisi) {
                $data_divisi[] = [
                    'Tgl_Input' => $detail_divisi->Tgl_Input,
                    'Id_BKK' => $detail_divisi->Id_BKK,
                    'Nilai_Pembulatan' => $detail_divisi->Nilai_Pembulatan,
                    'Terjemahan' => $detail_divisi->Terjemahan,
                ];
            }
            return response()->json($data_divisi);
        }

        // list bkm
        else if ($id === 'getListBKK') {
            $tgl1 = $request->input('tgl1');
            $tgl2 = $request->input('tgl2');

            $divisi = DB::connection('ConnAccounting')->select('exec SP_5298_ACC_LIST_BKK_KE_PERTGL
                    @tgl1 = ?, @tgl2 = ?', [$tgl1, $tgl2]);
            $data_divisi = [];
            foreach ($divisi as $detail_divisi) {
                $data_divisi[] = [
                    'Tgl_Input' => $detail_divisi->Tgl_Input,
                    'Id_BKK' => $detail_divisi->Id_BKK,
                    'Nilai_Pembulatan' => $detail_divisi->Nilai_Pembulatan,
                    'Terjemahan' => $detail_divisi->Terjemahan,
                ];
            }
            return response()->json($data_divisi);
        }

        // cetak bkK
        else if ($id === 'getCetakBKK') {
            $id_bkk = $request->input('id_bkk');

            $divisi = DB::connection('ConnAccounting')
                ->table('VW_PRG_5298_ACC_CETAK_BKK')
                ->where('Id_BKK', $id_bkk)
                ->get();

            $data_divisi = [];
            foreach ($divisi as $detail_divisi) {
                $data_divisi[] = [
                    'Id_BKK' => $detail_divisi->Id_BKK,
                    'Tgl_Input' => $detail_divisi->Tgl_Input,
                    'Terjemahan' => $detail_divisi->Terjemahan,
                    'Nilai_Pembulatan' => $detail_divisi->Nilai_Pembulatan,
                    'Symbol' => $detail_divisi->Symbol,
                    'Rincian_Bayar' => $detail_divisi->Rincian_Bayar,
                    'Nilai_Rincian' => $detail_divisi->Nilai_Rincian,
                    'Kode_Perkiraan' => $detail_divisi->Kode_Perkiraan,
                    'Id_Detail_Bayar' => $detail_divisi->Id_Detail_Bayar,
                    'Id_Bank' => $detail_divisi->Id_Bank,
                    'Jenis_Pembayaran' => $detail_divisi->Jenis_Pembayaran,
                    'No_BGCek' => $detail_divisi->No_BGCek,
                    'Jatuh_Tempo' => $detail_divisi->Jatuh_Tempo
                ];
            }

            return response()->json($data_divisi);
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
        $user = Auth::user()->NomorUser;

        if ($id === 'insertBKM') {
            $idBKM = $request->input('idBKM');
            $tglinput = $request->input('tglinput');
            $terjemahan = $request->input('terjemahan');
            $nilaipelunasan = $request->input('nilaipelunasan');
            $IdBank = $request->input('IdBank');
            $idBank = $request->input('idBank');
            $tgl = $request->input('tgl');
            $idUang = $request->input('idUang');
            $idJenis = $request->input('idJenis');
            $kodeperkiraan = $request->input('kodeperkiraan');
            $uraian = $request->input('uraian');
            $Kurs = $request->input('Kurs');
            $idCust = $request->input('idCust');
            $idbkm = $request->input('idbkm');
            $jenis = $request->input('jenis');
            $tgl2 = $request->input('tgl2');

            // dd($request->all());

            try {
                DB::connection('ConnAccounting')
                    ->statement('exec [SP_5298_ACC_INSERT_BKM_TPELUNASAN]
                @idBKM = ?,
                @tglinput = ?,
                @terjemahan = ?,
                @nilaipelunasan = ?,
                @IdBank = ?,
                @userinput = ?', [
                        $idBKM,
                        $tglinput,
                        $terjemahan,
                        $nilaipelunasan,
                        $IdBank,
                        $user
                    ]);

                DB::connection('ConnAccounting')
                    ->statement('exec [SP_5298_ACC_INSERT_BKM_TPELUNASAN_TAG]
                @idBKM = ?,
                @tgl = ?,
                @idUang = ?,
                @idJenis = ?,
                @idBank = ?,
                @kodeperkiraan = ?,
                @uraian = ?,
                @nilaipelunasan = ?,
                @Kurs = ?,
                @idCust = ?,
                @user = ?', [
                        $idBKM,
                        $tgl,
                        $idUang,
                        $idJenis,
                        $IdBank,
                        $kodeperkiraan,
                        $uraian,
                        $nilaipelunasan,
                        $Kurs,
                        $idCust,
                        $user,
                    ]);

                DB::connection('ConnAccounting')
                    ->statement('exec [SP_5298_ACC_UPDATE_COUNTER_IDBKM]
                @idbkm = ?,
                @idBank = ?,
                @jenis = ?,
                @tgl = ?', [
                        $idbkm,
                        $idBank,
                        $jenis,
                        $tgl2,
                    ]);

                return response()->json(['success' => 'Data sudah diSIMPAN'], 200);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Data gagal diSIMPAN: ' . $e->getMessage()], 500);
            }
        }

        // bkk
        else if ($id === 'insertBKK') {
            $idBKK = $request->input('idBKK');
            $tgl = $request->input('tgl');
            $terjemahan = $request->input('terjemahan');
            $nilaipelunasan = $request->input('nilaipelunasan');
            $IdBank = $request->input('IdBank');
            $idUang = $request->input('idUang');
            $idJenis = $request->input('idJenis');
            $idBank = $request->input('idBank');
            $nilai = $request->input('nilai');
            $kurs = $request->input('kurs');
            $idBKM_acuan = $request->input('idBKM_acuan');
            $keterangan = $request->input('keterangan');
            $biaya = $request->input('biaya');
            $kodeperkiraan = $request->input('kodeperkiraan');
            $idbkk = $request->input('idbkk');
            $jenis = $request->input('jenis');
            // dd($request->all());

            try {
                DB::connection('ConnAccounting')
                    ->statement('exec [SP_5298_ACC_INSERT_BKK_TPEMBAYARAN]
                @idBKK = ?, @tgl = ?, @terjemahan = ?, @nilai = ?, @IdBank = ?, @userinput = ?', [
                        $idBKK,
                        $tgl,
                        $terjemahan,
                        $nilai,
                        $IdBank,
                        $user,
                    ]);

                DB::connection('ConnAccounting')
                    ->statement('exec [SP_5298_ACC_INSERT_BKK_TPEMBAYARAN_TAG]
                @idBKK = ?, @idUang = ?, @idJenis = ?, @idBank = ?, @nilai = ?, @user = ?, @kurs = ?, @idBKM_acuan = ?', [
                        $idBKK,
                        $idUang,
                        $idJenis,
                        $idBank,
                        $nilai,
                        $user,
                        $kurs,
                        $idBKM_acuan,
                    ]);

                $maxIdPembayaran = DB::connection('ConnAccounting')
                    ->select(DB::raw('SELECT MAX(Id_Pembayaran) AS id_pembayaran FROM T_Pembayaran_Tagihan'));


                $maxId = $maxIdPembayaran[0]->id_pembayaran;

                DB::connection('ConnAccounting')
                    ->statement('exec [SP_5298_ACC_INSERT_BKK_TDETAILPEMB]
            @idpembayaran = ?, @keterangan = ?, @biaya = ?, @kodeperkiraan = ?', [
                        $maxId,
                        $keterangan,
                        $biaya,
                        $kodeperkiraan,
                    ]);

                DB::connection('ConnAccounting')
                    ->statement('exec [SP_5298_ACC_UPDATE_COUNTER_IDBKK]
            @idbkk = ?, @idBank = ?, @jenis = ?, @tgl = ?', [
                        $idbkk,
                        $idBank,
                        $jenis,
                        $tgl,
                    ]);

                return response()->json(['success' => 'Data sudah diSIMPAN'], 200);
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
