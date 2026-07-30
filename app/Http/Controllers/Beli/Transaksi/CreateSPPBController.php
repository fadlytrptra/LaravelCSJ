<?php

namespace App\Http\Controllers\Beli\Transaksi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\HakAksesController;
use Auth;
use Exception;
use DB;

class CreateSPPBController extends Controller
{
    public function index(Request $request)
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('Beli');
        $result = (new HakAksesController)->HakAksesFitur('Create SPPB');
        $user_id = trim(Auth::user()->NomorUser);
        $noTransRevisi = $request->query('no_trans');

        if ($result > 0) {
            return view('Beli.Transaksi.CreateSPPB.index', compact('access', 'user_id', 'noTransRevisi'));
        } else {
            abort(403);
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $jenisStore = $request->jenisStore;
        if ($jenisStore == 'addOrderPembelian') {
            $Kd_div = $request->Kd_div;
            $Kd_brg = $request->Kd_brg;
            $keterangan = $request->keterangan;
            $Qty = $request->Qty;
            $NoSatuan = $request->NoSatuan;
            $Pemesan = $request->Pemesan;
            $No_gol = $request->No_gol;
            $No_msn = $request->No_msn;
            $Operator = $request->Operator;
            $Tgl_sppb = $request->Tgl_sppb;
            $Jenis = $request->Jenis;
            $Tgl_Dibutuhkan = $request->Tgl_Dibutuhkan;
            $No_sup = $request->No_sup;
            $IdMataUang = $request->IdMataUang;
            $Kurs_Rp = $request->Kurs_Rp;
            $Hrg_trm = $request->Hrg_trm;
            $Disc_trm = $request->Disc_trm;
            $Ppn_trm = $request->Ppn_trm;
            $Waktu = $request->Waktu;
            $hrg_murni = $request->hrg_murni;
            $hrg_murni_rp = $request->hrg_murni_rp;
            $hrg_disc = $request->hrg_disc;
            $hrg_disc_rp = $request->hrg_disc_rp;
            $hrg_nego = $request->hrg_nego;
            $hrg_nego_rp = $request->hrg_nego_rp;
            $hrg_ppn = $request->hrg_ppn;
            $kurs_ppn = $request->kurs_ppn;
            $hrg_ppn_rp = $request->hrg_ppn_rp;
            $dpp_nilai_lain = $request->dpp_nilai_lain;
            $dpp_nilai_lain_rp = $request->dpp_nilai_lain_rp;
            if ($Kd_div != null && $Kd_brg != null && $NoSatuan != null && $Tgl_Dibutuhkan != null) {
                try {
                    $mValue = DB::connection('ConnPurchase')->table('YCounter')->value('YTRANSBL') + 1;
                    $No_trans = '00000000' . str_pad($mValue, 8, '0', STR_PAD_LEFT);
                    $No_trans = substr($No_trans, -8);
                    //update table counter dilakukan oleh trigger table ytransbl
                    DB::connection('ConnPurchase')->statement('exec SP_4384_PRG_Maintenance_Order_Pembelian
                    @XKode = ?, @Kd_div = ?,  @Kd_brg = ?, @keterangan = ?, @Qty = ?,
                    @NoSatuan = ?, @Pemesan = ?, @No_gol = ?, @No_msn = ?, @Operator = ?, @Tgl_sppb = ?, @Jenis = ?,
                    @Tgl_Dibutuhkan = ?, @No_trans = ?, @No_sup = ?, @IdMataUang = ?, @Kurs_Rp = ?,
                    @Hrg_trm = ?, @Disc_trm  = ?, @Ppn_trm  = ?, @Waktu  = ?, @hrg_murni = ?,
                    @hrg_murni_rp = ?, @hrg_disc = ?, @hrg_disc_rp = ?, @hrg_nego = ?, @hrg_nego_rp = ?,
                    @hrg_ppn = ?, @kurs_ppn = ?, @hrg_ppn_rp = ?, @dpp_nilai_lain = ?, @dpp_nilai_lain_rp = ?',
                        [
                            0,
                            $Kd_div,
                            $Kd_brg,
                            $keterangan,
                            $Qty,
                            $NoSatuan,
                            $Pemesan,
                            $No_gol,
                            $No_msn,
                            $Operator,
                            $Tgl_sppb,
                            $Jenis,
                            $Tgl_Dibutuhkan,
                            $No_trans,
                            $No_sup,
                            $IdMataUang,
                            $Kurs_Rp,
                            $Hrg_trm,
                            $Disc_trm,
                            $Ppn_trm,
                            $Waktu,
                            $hrg_murni,
                            $hrg_murni_rp,
                            $hrg_disc,
                            $hrg_disc_rp,
                            $hrg_nego,
                            $hrg_nego_rp,
                            $hrg_ppn,
                            $kurs_ppn,
                            $hrg_ppn_rp,
                            $dpp_nilai_lain,
                            $dpp_nilai_lain_rp
                        ]
                    );
                    return response()->json(['message' => 'Data Berhasil DiTambahkan!', "data" => $No_trans]);

                } catch (Exception $Ex) {
                    return response()->json($Ex->getMessage());
                }
            } else {
                return response()->json('Parameter harus diisi');
            }
        } else if ($jenisStore == 'editOrderPembelian') {
            $No_trans = $request->No_trans;
            $Kd_div = $request->Kd_div;
            $Kd_brg = $request->Kd_brg;
            $keterangan = $request->keterangan;
            $Qty = $request->Qty;
            $NoSatuan = $request->NoSatuan;
            $Pemesan = $request->Pemesan;
            $No_gol = $request->No_gol;
            $No_msn = $request->No_msn;
            $Operator = $request->Operator;
            $Tgl_sppb = $request->Tgl_sppb;
            $Jenis = $request->Jenis;
            $Tgl_Dibutuhkan = $request->Tgl_Dibutuhkan;
            $No_sup = $request->No_sup;
            $IdMataUang = $request->IdMataUang;
            $Kurs_Rp = $request->Kurs_Rp;
            $Hrg_trm = $request->Hrg_trm;
            $Disc_trm = $request->Disc_trm;
            $Ppn_trm = $request->Ppn_trm;
            $Waktu = $request->Waktu;
            $hrg_murni = $request->hrg_murni;
            $hrg_murni_rp = $request->hrg_murni_rp;
            $hrg_disc = $request->hrg_disc;
            $hrg_disc_rp = $request->hrg_disc_rp;
            $hrg_nego = $request->hrg_nego;
            $hrg_nego_rp = $request->hrg_nego_rp;
            $hrg_ppn = $request->hrg_ppn;
            $kurs_ppn = $request->kurs_ppn;
            $hrg_ppn_rp = $request->hrg_ppn_rp;
            $dpp_nilai_lain = $request->dpp_nilai_lain;
            $dpp_nilai_lain_rp = $request->dpp_nilai_lain_rp;
            if ($Kd_div != null && $Kd_brg != null && $NoSatuan != null && $Tgl_Dibutuhkan != null) {
                try {
                    DB::connection('ConnPurchase')->statement('exec SP_4384_PRG_Maintenance_Order_Pembelian
                    @XKode = ?, @Kd_div = ?,  @Kd_brg = ?, @keterangan = ?, @Qty = ?,
                    @NoSatuan = ?, @Pemesan = ?, @No_gol = ?, @No_msn = ?, @Operator = ?, @Tgl_sppb = ?, @Jenis = ?,
                    @Tgl_Dibutuhkan = ?, @No_trans = ?, @No_sup = ?, @IdMataUang = ?, @Kurs_Rp = ?,
                    @Hrg_trm = ?, @Disc_trm  = ?, @Ppn_trm  = ?, @Waktu  = ?, @hrg_murni = ?,
                    @hrg_murni_rp = ?, @hrg_disc = ?, @hrg_disc_rp = ?, @hrg_nego = ?, @hrg_nego_rp = ?,
                    @hrg_ppn = ?, @kurs_ppn = ?, @hrg_ppn_rp = ?, @dpp_nilai_lain = ?, @dpp_nilai_lain_rp = ?', [
                        1,
                        $Kd_div,
                        $Kd_brg,
                        $keterangan,
                        $Qty,
                        $NoSatuan,
                        $Pemesan,
                        $No_gol,
                        $No_msn,
                        $Operator,
                        $Tgl_sppb,
                        $Jenis,
                        $Tgl_Dibutuhkan,
                        $No_trans,
                        $No_sup,
                        $IdMataUang,
                        $Kurs_Rp,
                        $Hrg_trm,
                        $Disc_trm,
                        $Ppn_trm,
                        $Waktu,
                        $hrg_murni,
                        $hrg_murni_rp,
                        $hrg_disc,
                        $hrg_disc_rp,
                        $hrg_nego,
                        $hrg_nego_rp,
                        $hrg_ppn,
                        $kurs_ppn,
                        $hrg_ppn_rp,
                        $dpp_nilai_lain,
                        $dpp_nilai_lain_rp,
                    ]);
                    return response()->json(['message' => 'Data Berhasil DiEdit!', "data" => $No_trans]);

                } catch (Exception $Ex) {
                    return response()->json($Ex->getMessage());
                }
            } else {
                return response()->json('Parameter harus diisi');
            }
        } else if ($jenisStore == 'deleteOrderPembelian') {
            $No_trans = $request->No_trans;

            if ($No_trans != null) {
                try {
                    DB::connection('ConnPurchase')->statement('exec SP_4384_PRG_Maintenance_Order_Pembelian
                    @XKode = ?, @No_trans = ?', [
                        2,
                        $No_trans,
                    ]);
                    return response()->json(['message' => 'Data Berhasil DiHapus!', "data" => $No_trans]);

                } catch (Exception $Ex) {
                    return response()->json($Ex->getMessage());
                }
            } else {
                return response()->json('Parameter harus diisi');
            }

        } else if ($jenisStore == 'savePO') {

            $rows = $request->table_orderPembelian;
            $idDivisi = $request->idDivisi;
            $jenis = $request->jenis;
            $mataUang = $request->mataUang;
            $Tgl_sppb = $request->Tgl_sppb;
            $No_sppb = $request->No_sppb; // dari frontend
            $keteranganCetak = $request->keteranganCetak;
            // dd($request->all());
            if (empty($rows)) {
                return response()->json('Data order kosong', 422);
            }

            DB::beginTransaction();
            try {

                /**
                 * =========================
                 * 1. TENTUKAN No_sppb
                 * =========================
                 */
                if (!$No_sppb) {
                    $No_sppb = $this->generateNoSppbBaru();
                }

                /**
                 * =========================
                 * 2. VALIDASI DATA
                 * =========================
                 */
                foreach ($rows as $row) {
                    if (!isset($row[11])) {
                        throw new \Exception('No_trans tidak valid');
                    }
                }

                /**
                 * =========================
                 * 3. SIMPAN KE SPPB
                 * =========================
                 */
                $isRevisi = str_contains($No_sppb, 'REV');
                $XKodeSave = $isRevisi ? 14 : 4;

                foreach ($rows as $row) {
                    $No_trans = $row[11];

                    DB::connection('ConnPurchase')->statement(
                        'EXEC SP_4384_PRG_Maintenance_Order_Pembelian
                        @XKode = ?, @No_trans = ?, @No_sppb = ?, @Informasi_Cetak = ?',
                        [
                            $XKodeSave,
                            $No_trans,
                            $No_sppb,
                            $keteranganCetak
                        ]
                    );
                }

                DB::connection('ConnPurchase')->table('YTRANSBL')
                    ->where('No_sppb', $No_sppb)
                    ->update([
                        'Kd_div' => $idDivisi,
                        'Jenis' => $jenis,
                        'IdMataUang' => $mataUang
                    ]);

                DB::commit();

                return response()->json([
                    'message' => 'Sudah Berhasil Save PO!',
                    'data' => $No_sppb
                ]);

            } catch (\Throwable $e) {
                DB::rollBack();
                return response()->json([
                    'message' => 'Save PO gagal',
                    'error' => $e->getMessage()
                ], 500);
            }
        } else if ($jenisStore == 'submitPO') {

            DB::beginTransaction();
            try {

                $rows = $request->table_orderPembelian;
                $keteranganCetak = $request->keteranganCetak;
                $operator = trim(Auth::user()->NomorUser);

                if (empty($rows)) {
                    return response()->json('Data order kosong', 422);
                }

                $firstRow = $rows[0];
                $noTrans = $firstRow[11];

                $lastNoSppb = $this->getLastNoSppbByTrans($noTrans);

                if (!empty($lastNoSppb)) {
                    $No_sppb = $lastNoSppb;
                } else {
                    $No_sppb = $this->generateNoSppbBaru();
                }

                foreach ($rows as $row) {

                    if (!isset($row[11]))
                        continue;
                    $No_trans = $row[11];

                    // SAVE
                    DB::connection('ConnPurchase')->statement(
                        'exec SP_4384_PRG_Maintenance_Order_Pembelian
                        @XKode = ?,
                        @No_trans = ?,
                        @No_sppb = ?,
                        @Informasi_Cetak = ?,
                        @Operator = ?',
                        [
                            4,
                            $No_trans,
                            $No_sppb,
                            $keteranganCetak,
                            $operator
                        ]
                    );

                    // SUBMIT
                    DB::connection('ConnPurchase')->statement(
                        'exec SP_4384_PRG_Maintenance_Order_Pembelian
                        @XKode = ?,
                        @No_trans = ?,
                        @No_sppb = ?,
                        @Informasi_Cetak = ?,
                        @Operator = ?',
                        [
                            5,
                            $No_trans,
                            $No_sppb,
                            $keteranganCetak,
                            $operator
                        ]
                    );
                }

                DB::commit();

                return response()->json([
                    'message' => 'SPPB berhasil disubmit',
                    'no_sppb' => $No_sppb
                ]);

            } catch (\Throwable $e) {
                DB::rollBack();
                return response()->json([
                    'message' => 'Submit gagal',
                    'error' => $e->getMessage()
                ], 500);
            }
        } else if ($jenisStore == 'accPO') {
            $nomorSPPB = $request->nomorSPPB;
            $user_id = trim(Auth::user()->NomorUser);
            try {
                DB::connection('ConnPurchase')->statement('exec SP_4384_Maintenance_SPPB @XKode= ?, @XNoSPPB = ?, @XOperator = ?', [1, $nomorSPPB, $user_id]);
                return response()->json(['message' => 'Sudah Berhasil ACC PO!', "data" => $nomorSPPB]);
            } catch (Exception $ex) {
                return response()->json($ex->getMessage());
            }
        } else if ($jenisStore == 'deletePO') {
            $nomorSPPB = $request->nomorSPPB;
            try {
                DB::connection('ConnPurchase')->statement('exec SP_4384_Maintenance_SPPB @XKode= ?, @XNoSPPB = ?', [2, $nomorSPPB]);
                return response()->json(['message' => 'Sudah Berhasil Delete PO!', "data" => $nomorSPPB]);
            } catch (Exception $ex) {
                return response()->json($ex->getMessage());
            }
        }

        //Revisi
        else {
            return response()->json('Invalid request', 405);
        }

    }

    public function show($id, Request $request)
    {
        if ($id == 'getDataSPPB') {
            $listSPPB = DB::connection('ConnPurchase')
                ->select('exec SP_4384_Maintenance_SPPB @XKode= ?', [0]);
            $dataSPPB = [];
            $uniqueSPPB = [];

            foreach ($listSPPB as $SPPB) {
                if (isset($uniqueSPPB[$SPPB->No_sppb])) {
                    continue;
                }
                $uniqueSPPB[$SPPB->No_sppb] = true;
                $dataSPPB[] = [
                    'No_sppb' => $SPPB->No_sppb,
                    'NM_SUP' => $SPPB->NM_SUP,
                    'Tgl_sppb' => $SPPB->Tgl_sppb,
                    'Tgl_acc' => $SPPB->Tgl_acc,
                    'Tgl_Direktur' => $SPPB->Tgl_Direktur,
                    'Kd_div' => $SPPB->Kd_div,
                    'HasFile' => $SPPB->HasFile,
                ];
            }
            return datatables($dataSPPB)->make(true);
        } else if ($id == 'getDivisi') {
            $idUser = trim(Auth::user()->NomorUser);
            $dataDiv = DB::connection('ConnPurchase')->select('exec SP_1273_PRG_User_Divisi @Operator = ' . rtrim($idUser) . '');
            return response()->json($dataDiv, 200);
        } else if ($id == 'getJenisBeli') {
            $jenisList = DB::connection('ConnPurchase')
                ->table('YJN_BL')
                ->orderBy('NO_JNS')
                ->get();
            return response()->json($jenisList, 200);
        } else if ($id == 'getSupplier') {
            $supplierList = DB::connection('ConnPurchase')
                ->select('exec SP_1273_PRG_LIST_SUPPLIER');
            return response()->json($supplierList, 200);
        } else if ($id == 'getMataUang') {
            $mataUang = DB::connection('ConnPurchase')
                ->table('ACCOUNTING.dbo.T_MATAUANG')
                ->select('Id_MataUang', 'Nama_MataUang')
                ->orderBy('Id_MataUang')
                ->get();
            return response()->json($mataUang);
        } else if ($id == 'getGolongan') {
            $kd_div = $request->kd_div;
            $golonganList = DB::connection('ConnPurchase')
                ->select('exec SP_1273_PRG_Select_GolonganByDivisi @kd_div = ?', [$kd_div]);
            return response()->json($golonganList, 200);
        } else if ($id == 'getKelompokMesin') {
            $golongan = $request->golongan;
            $kelompokMesinList = DB::connection('ConnPurchase')
                ->select('exec SP_1273_PRG_Select_MesinByGolongan @no_gol = ?', [$golongan]);
            return response()->json($kelompokMesinList, 200);
        } else if ($id == 'getKategoriUtama') {
            $kategoriUtamaList = DB::connection('ConnPurchase')
                ->select('exec SP_1273_PRG_Select_HirarkiTypeBarang @MyType = ?', [1]);
            return response()->json($kategoriUtamaList, 200);
        } else if ($id == 'getKategori') {
            $kategoriUtama = $request->kategoriUtama;
            $kategoriList = DB::connection('ConnPurchase')
                ->select('exec SP_1273_PRG_Select_HirarkiTypeBarang @MyType = ?, @MyValue = ?', [2, $kategoriUtama]);
            return response()->json($kategoriList, 200);
        } else if ($id == 'getSubKategori') {
            $kategori = $request->kategori;
            $subKategoriList = DB::connection('ConnPurchase')
                ->select('exec SP_1273_PRG_Select_HirarkiTypeBarang @MyType = ?, @MyValue = ?', [3, $kategori]);
            return response()->json($subKategoriList, 200);
        } else if ($id == 'getNamaBarang') {
            $subKategori = $request->subKategori;
            $namaBarangList = DB::connection('ConnPurchase')
                ->select('exec SP_1273_PRG_Select_HirarkiTypeBarang @MyType = ?, @MyValue = ?', [5, $subKategori]);
            return response()->json($namaBarangList, 200);
        } else if ($id == 'getDetailBarang') {
            $kodeBrg = $request->kodeBrg;
            $dataDetailBarang = DB::connection('ConnPurchase')
                ->select('exec SP_1273_PRG_Select_Barang @KdBarang = ?', [$kodeBrg]);
            return response()->json($dataDetailBarang, 200);
        } else if ($id == 'getDetailPO') {
            $no_sppb = $request->no_sppb;
            $dataDetailPO = DB::connection('ConnPurchase')
                ->select('exec SP_4384_Maintenance_SPPB @XKode = ?, @XNoSPPB = ?', [3, $no_sppb]);
            return response()->json($dataDetailPO, 200);
        } else if ($id == 'getDraftSPPB') {
            $listSPPB = DB::connection('ConnPurchase')
                ->select('exec SP_4384_Maintenance_SPPB @XKode = ?', [4]);
            $dataSPPB = [];
            $uniqueSPPB = [];

            foreach ($listSPPB as $SPPB) {
                if (isset($uniqueSPPB[$SPPB->No_sppb])) {
                    continue;
                }
                $uniqueSPPB[$SPPB->No_sppb] = true;

                $dataSPPB[] = [
                    'No_sppb' => $SPPB->No_sppb,
                    'NM_SUP' => $SPPB->NM_SUP,
                    'Tgl_sppb' => $SPPB->Tgl_sppb,
                    'Tgl_acc' => $SPPB->Tgl_acc,
                    'Tgl_Direktur' => $SPPB->Tgl_Direktur,
                    'Kd_div' => $SPPB->Kd_div,
                ];
            }

            return datatables($dataSPPB)->make(true);
        } else if ($id == 'getAllSPPB') {
            //menggabungkan @XKode 0 dan 4
            $dataLama = DB::connection('ConnPurchase')
                ->select('exec SP_4384_Maintenance_SPPB @XKode = ?', [5]);
            $dataDraft = DB::connection('ConnPurchase')
                ->select('exec SP_4384_Maintenance_SPPB @XKode = ?', [6]);

            $merged = array_merge($dataDraft, $dataLama);
            $unique = [];
            $final = [];

            foreach ($merged as $row) {
                if (!isset($unique[$row->No_sppb])) {
                    $unique[$row->No_sppb] = true;
                    $final[] = [
                        'No_sppb' => $row->No_sppb,
                        'NM_SUP' => $row->NM_SUP,
                        'Keterangan' => $row->Keterangan,
                        'Tgl_sppb' => $row->Tgl_sppb,
                        'Tgl_acc' => $row->Tgl_acc,
                        'Tgl_Direktur' => $row->Tgl_Direktur,
                        'Kd_div' => $row->Kd_div,
                        'HasFile' => $row->HasFile,
                    ];
                }
            }

            return datatables($final)->make(true);
        } else {
            return response()->json('Invalid request', 405);
        }
    }

    public function generateNoSppbBaru(): string
    {
        $tahun = date('y');
        $prefix = "PO-{$tahun}CSJ";

        $last = DB::connection('ConnPurchase')
            ->table('YTRANSBL')
            ->lockForUpdate()
            ->whereRaw('LTRIM(RTRIM(No_sppb)) LIKE ?', [$prefix . '%'])
            ->whereRaw('LTRIM(RTRIM(No_sppb)) NOT LIKE ?', ['%REV%'])
            ->selectRaw("
                MAX(
                    CAST(
                        RIGHT(LTRIM(RTRIM(No_sppb)), 4) AS INT
                    )
                ) AS max_no
            ")
            ->value('max_no');

        $next = ($last ?? 0) + 1;

        return $prefix . str_pad($next, 4, '0', STR_PAD_LEFT);
    }

    public function generateNoSppbRevisi(string $oldNo): string
    {
        $base = trim($oldNo);

        if (preg_match('/REV(\d+)$/', $base, $m)) {
            $next = str_pad(((int) $m[1]) + 1, 2, '0', STR_PAD_LEFT);
            return preg_replace('/REV\d+$/', ' REV' . $next, $base);
        }

        return $base . ' REV01';
    }

    public function getLastNoSppbByTrans(string $noTrans): ?string
    {
        return DB::connection('ConnPurchase')
            ->table('YTRANSBL')
            ->where('No_trans', $noTrans)
            ->value('No_sppb');
    }


    public function uploadDokumentasi(Request $request)
    {
        $request->validate([
            'noSppb' => 'required|string',
            'attach_file' => 'required|file|max:2560|mimes:jpg,jpeg,png,pdf'
        ]);

        $noSppb = trim($request->noSppb);
        $conn = DB::connection('ConnPurchase');

        $conn->beginTransaction();

        try {
            $rows = $conn->table('YTRANSBL')
                ->whereRaw('RTRIM(No_sppb) = ?', [$noSppb])
                ->lockForUpdate()
                ->get();

            if ($rows->isEmpty()) {
                throw new \Exception('No SPPB tidak ditemukan');
            }

            //cek no sppb
            $alreadyExists = $rows->contains(function ($row) {
                return !is_null($row->Dokumentasi) || !is_null($row->DokumentasiFile);
            });

            if ($alreadyExists) {
                throw new \Exception('Dokumentasi untuk No SPPB ini sudah ada.');
            }

            //upload file
            $file = $request->file('attach_file');
            $extension = strtolower($file->getClientOriginalExtension());

            // pdf
            if ($extension === 'pdf') {
                $binary = $file->get();
                $hex = '0x' . bin2hex($binary);

                $conn->statement("
                    UPDATE YTRANSBL
                    SET Dokumentasi = NULL,
                        DokumentasiFile = $hex
                    WHERE RTRIM(No_sppb) = ?
                ", [$noSppb]);

            }

            // Image
            else {
                $base64 = base64_encode($file->get());
                $conn->statement("
                    UPDATE YTRANSBL
                    SET Dokumentasi = ?,
                        DokumentasiFile = NULL
                    WHERE RTRIM(No_sppb) = ?
                ", [$base64, $noSppb]);
            }

            $conn->commit();

            return response()->json([
                'success' => true,
                'message' => 'Dokumentasi berhasil diupload'
            ]);

        } catch (\Throwable $e) {

            $conn->rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getDokumentasi($noSppb)
    {
        $row = DB::connection('ConnPurchase')
            ->table('YTRANSBL')
            ->select('Dokumentasi', 'DokumentasiFile')
            ->whereRaw('RTRIM(No_sppb) = ?', [trim($noSppb)])
            ->where(function ($q) {
                $q->whereNotNull('Dokumentasi')
                    ->orWhereNotNull('DokumentasiFile');
            })
            ->first();

        if (!$row) {
            return response()->json([
                'success' => false,
                'message' => 'File tidak ditemukan'
            ], 404);
        }

        // Jika PDF (VARBINARY)
        if (!empty($row->DokumentasiFile)) {

            return response($row->DokumentasiFile)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="Dokumentasi_' . $noSppb . '.pdf"')
                ->header('Content-Length', strlen($row->DokumentasiFile));
        }

        // Jika Image (Base64)
        if (!empty($row->Dokumentasi)) {

            $binary = base64_decode($row->Dokumentasi);

            return response($binary)
                ->header('Content-Type', 'image/jpeg')
                ->header('Content-Disposition', 'attachment; filename="Dokumentasi_' . $noSppb . '.jpg"')
                ->header('Content-Length', strlen($binary));
        }

        return response()->json([
            'success' => false,
            'message' => 'File kosong'
        ], 404);
    }

    public function deleteDokumentasi($noSppb)
    {
        $noSppb = trim($noSppb);

        $affected = DB::connection('ConnPurchase')
            ->table('YTRANSBL')
            ->whereRaw('RTRIM(No_sppb) = ?', [$noSppb])
            ->update([
                'Dokumentasi' => DB::raw('NULL'),
                'DokumentasiFile' => DB::raw('NULL')
            ]);

        if ($affected > 0) {
            return response()->json([
                'success' => true,
                'message' => 'Dokumentasi berhasil dihapus'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Data tidak ditemukan atau sudah kosong'
        ]);
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
