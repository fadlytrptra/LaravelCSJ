<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Http\Controllers\HakAksesController;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Exception;
use Auth;
use DB;

class CetakSPPBBTTBController extends Controller
{
    public function index()
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('Beli');
        $result = (new HakAksesController)->HakAksesFitur('Cetak SPPB / BTTB');
        $user = trim(Auth::user()->NomorUser);
        if ($result > 0) {
            return view('Laporan.Purchase.CetakSPPBBTTB.index', compact('access', 'user'));
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
        if ($jenisStore == 'Email') {
            $noSPPB = $request->noSPPB;
            $idDivisi = $request->idDivisi;
            $deliveryTerm = $request->deliveryTerm;
            $packing = $request->packing;
            $shippingMark = $request->shippingMark;
            $deliveryTime = $request->deliveryTime;
            $documentsRequired = $request->documentsRequired;
            $partialShipmentTransit = $request->partialShipmentTransit;
            $portOfLoading = $request->portOfLoading;
            $portOfDischarge = $request->portOfDischarge;
            $otherConditions = $request->otherConditions;
            $payments = $request->payments;
            $informasiCetak =
                $deliveryTerm . ' | ' . $packing . ' | ' . $shippingMark . ' | ' .
                $deliveryTime . ' | ' . $documentsRequired . ' | ' .
                $partialShipmentTransit . ' | ' . $portOfLoading . ' | ' .
                $portOfDischarge . ' | ' . $otherConditions . ' | ' . $payments;
            DB::connection('ConnPurchase')->statement('exec SP_1273_PRG_PROSES_CETAK_PO @Kode = ?, @NoSppb = ?, @InformasiCetak = ?', [5, $noSPPB, $informasiCetak]);
            $dataCetak = DB::connection('ConnPurchase')->select('SELECT * FROM VW_PRG_1273_SPPB_NEW WHERE kode_divisi = ? AND nomor_sppb = ?', [$idDivisi, $noSPPB]);
            dd($dataCetak);

        } else {
            return response()->json('Request Invalid', 400);
        }
    }


    public function show($id, Request $request)
    {
        if ($id == 'getDataDivisi') {
            $dataDivisi = DB::connection('ConnPurchase')->select('exec SP_1273_PRG_LIST_DIVISI');

            return datatables($dataDivisi)->make(true);
        } else if ($id == 'getDataSPPB') {
            $kd_div_1 = $request->kd_div_1;
            $dataSPPB = DB::connection('ConnPurchase')->select('exec SP_1273_PRG_LIST_DIVISI_CETAK_PO @kd_div_1 = ?, @XKode = ?', [$kd_div_1, 1]);

            return datatables($dataSPPB)->make(true);
        } else if ($id == 'getDataTerima') {
            $NoSPPB = $request->NoSPPB;
            // $KdDivisi = $request->KdDivisi;
            $dataTerima = DB::connection('ConnPurchase')->select('SELECT nomor_terima, tanggal_datang FROM View_terima_new WHERE nomor_sppb = ?',[$NoSPPB]);

            return datatables($dataTerima)->make(true);
        } else if ($id == 'print') {
            $divisi = $request->divisi;
            $jenisCetak = $request->jenisCetak;
            $sppb = $request->sppb;

            if ($jenisCetak == 'SPPB') {
                $ada = DB::connection('ConnPurchase')->select('exec SP_1273_PRG_PROSES_CETAK_PO @Kode = ?, @KdDiv = ?, @NoSppb = ?', [2, $divisi, $sppb]);
                if ($ada[0]->Ada == 0) {
                    DB::connection('ConnPurchase')->statement('exec SP_1273_PRG_PROSES_CETAK_PO @Kode = ?, @KdDiv = ?, @NoSppb = ?', [1, $divisi, $sppb]);
                } else {
                    DB::connection('ConnPurchase')->statement('exec SP_1273_PRG_PROSES_CETAK_PO @Kode = ?, @KdDiv = ?, @NoSppb = ?, @Alasan = \'Cetak Ulang\'', [4, $divisi, $sppb]);
                }
                $dataCetak = DB::connection('ConnPurchase')->select('SELECT * FROM VW_PRG_1273_SPPB_NEW WHERE kode_divisi = ? AND nomor_sppb = ?', [$divisi, $sppb]);
            } else if ($jenisCetak == 'BTTB') {
                $noTerima = $request->noTerima;
                if ($noTerima) {
                    $dataCetak = DB::connection('ConnPurchase')->select('SELECT * FROM View_terima_new WHERE nomor_terima = ?', [$noTerima]);
                } else {
                    return redirect()->back()->with('error', 'Data tidak ditemukan');
                }
            } else if ($jenisCetak == 'SPPBBaru') {
                $ada = DB::connection('ConnPurchase')->select('exec SP_1273_PRG_PROSES_CETAK_PO @Kode = ?, @KdDiv = ?, @NoSppb = ?', [2, $divisi, $sppb]);
                if ($ada[0]->Ada == 0) {
                    DB::connection('ConnPurchase')->statement('exec SP_1273_PRG_PROSES_CETAK_PO @Kode = ?, @KdDiv = ?, @NoSppb = ?', [1, $divisi, $sppb]);
                } else {
                    DB::connection('ConnPurchase')->statement('exec SP_1273_PRG_PROSES_CETAK_PO @Kode = ?, @KdDiv = ?, @NoSppb = ?, @Alasan = \'Cetak Ulang\'', [4, $divisi, $sppb]);
                }
                $dataCetak = DB::connection('ConnPurchase')->select('SELECT * FROM VW_PRG_1273_SPPB_NEW WHERE kode_divisi = ? AND nomor_sppb = ?', [$divisi, $sppb]);
            }
            if (count($dataCetak) > 0) {

                $ttdDirektur = DB::connection('ConnEDP')
                ->table('dbo.UserMaster')
                ->select('NamaUser', 'FotoTtd')
                ->where('NomorUser', 'rudy')
                ->first();

                return view('Laporan.Purchase.CetakSPPBBTTB.cetak', compact('dataCetak', 'jenisCetak', 'ttdDirektur'));
            } else {
                return redirect()->back()->with('error', 'Data tidak ditemukan');
            }
        } else if ($id == "exportPdf") {
            $divisi = $request->divisi;
            $jenisCetak = $request->jenisCetak;
            $sppb = $request->sppb;

            if ($jenisCetak == 'SPPB') {
                $ada = DB::connection('ConnPurchase')->select('exec SP_1273_PRG_PROSES_CETAK_PO @Kode = ?, @KdDiv = ?, @NoSppb = ?', [2, $divisi, $sppb]);
                if ($ada[0]->Ada == 0) {
                    DB::connection('ConnPurchase')->statement('exec SP_1273_PRG_PROSES_CETAK_PO @Kode = ?, @KdDiv = ?, @NoSppb = ?', [1, $divisi, $sppb]);
                } else {
                    DB::connection('ConnPurchase')->statement('exec SP_1273_PRG_PROSES_CETAK_PO @Kode = ?, @KdDiv = ?, @NoSppb = ?, @Alasan = \'Cetak Ulang\'', [4, $divisi, $sppb]);
                }
                $dataCetak = DB::connection('ConnPurchase')->select('SELECT * FROM VW_PRG_1273_SPPB_NEW WHERE kode_divisi = ? AND nomor_sppb = ?', [$divisi, $sppb]);
            } else if ($jenisCetak == 'BTTB') {
                $noTerima = $request->noTerima;
                if ($noTerima) {
                    $dataCetak = DB::connection('ConnPurchase')->select('SELECT * FROM View_terima_new WHERE nomor_terima = ?', [$noTerima]);
                } else {
                    return redirect()->back()->with('error', 'Data tidak ditemukan');
                }
            } else if ($jenisCetak == 'SPPBBaru') {
                $ada = DB::connection('ConnPurchase')->select('exec SP_1273_PRG_PROSES_CETAK_PO @Kode = ?, @KdDiv = ?, @NoSppb = ?', [2, $divisi, $sppb]);
                if ($ada[0]->Ada == 0) {
                    DB::connection('ConnPurchase')->statement('exec SP_1273_PRG_PROSES_CETAK_PO @Kode = ?, @KdDiv = ?, @NoSppb = ?', [1, $divisi, $sppb]);
                } else {
                    DB::connection('ConnPurchase')->statement('exec SP_1273_PRG_PROSES_CETAK_PO @Kode = ?, @KdDiv = ?, @NoSppb = ?, @Alasan = \'Cetak Ulang\'', [4, $divisi, $sppb]);
                }
                $dataCetak = DB::connection('ConnPurchase')->select('SELECT * FROM VW_PRG_1273_SPPB_NEW WHERE kode_divisi = ? AND nomor_sppb = ?', [$divisi, $sppb]);
            }

            if (count($dataCetak) > 0) {
                $direktur = $dataCetak[0]->Direktur ?? null;
                $showTtd = !empty($direktur);

                $ttdDirektur = null;
                if ($showTtd) {
                    $ttdDirektur = DB::connection('ConnEDP')
                        ->table('dbo.UserMaster')
                        ->select('NamaUser', 'FotoTtd')
                        ->where('NomorUser', 'rudy')
                        ->first();
                }

                // Ambil nomor SPPB
                $nomorSppb = $dataCetak[0]->nomor_sppb ?? null;

                // Ambil dokumentasi jika ada
                $dok = null;

                if ($nomorSppb) {
                    $dok = DB::connection('ConnPurchase')
                        ->table('YTRANSBL')
                        ->select('Dokumentasi', 'DokumentasiFile')
                        ->whereRaw('RTRIM(No_sppb) = ?', [trim($nomorSppb)])
                        ->first();
                }

                return view(
                    'Beli.Transaksi.exportToPdf',
                    compact('dataCetak', 'jenisCetak', 'ttdDirektur', 'showTtd')
                );
            } else {
                return redirect()->back()->with('error', 'Data tidak ditemukan');
            }
        } else if ($id == "emailSupplier") {
            $divisi = $request->divisi;
            $jenisCetak = $request->jenisCetak;
            $sppb = $request->sppb;

            if ($jenisCetak == 'SPPB') {
                $ada = DB::connection('ConnPurchase')->select('exec SP_1273_PRG_PROSES_CETAK_PO @Kode = ?, @KdDiv = ?, @NoSppb = ?', [2, $divisi, $sppb]);
                if ($ada[0]->Ada == 0) {
                    DB::connection('ConnPurchase')->statement('exec SP_1273_PRG_PROSES_CETAK_PO @Kode = ?, @KdDiv = ?, @NoSppb = ?', [1, $divisi, $sppb]);
                } else {
                    DB::connection('ConnPurchase')->statement('exec SP_1273_PRG_PROSES_CETAK_PO @Kode = ?, @KdDiv = ?, @NoSppb = ?, @Alasan = \'Cetak Ulang\'', [4, $divisi, $sppb]);
                }
                $dataCetak = DB::connection('ConnPurchase')->select('SELECT * FROM VW_PRG_1273_SPPB_NEW WHERE kode_divisi = ? AND nomor_sppb = ?', [$divisi, $sppb]);
            } else if ($jenisCetak == 'BTTB') {
                $noTerima = $request->noTerima;
                if ($noTerima) {
                    $dataCetak = DB::connection('ConnPurchase')->select('SELECT * FROM View_terima_new WHERE nomor_terima = ?', [$noTerima]);
                } else {
                    return redirect()->back()->with('error', 'Data tidak ditemukan');
                }
            } else if ($jenisCetak == 'SPPBBaru') {
                $ada = DB::connection('ConnPurchase')->select('exec SP_1273_PRG_PROSES_CETAK_PO @Kode = ?, @KdDiv = ?, @NoSppb = ?', [2, $divisi, $sppb]);
                if ($ada[0]->Ada == 0) {
                    DB::connection('ConnPurchase')->statement('exec SP_1273_PRG_PROSES_CETAK_PO @Kode = ?, @KdDiv = ?, @NoSppb = ?', [1, $divisi, $sppb]);
                } else {
                    DB::connection('ConnPurchase')->statement('exec SP_1273_PRG_PROSES_CETAK_PO @Kode = ?, @KdDiv = ?, @NoSppb = ?, @Alasan = \'Cetak Ulang\'', [4, $divisi, $sppb]);
                }
                $dataCetak = DB::connection('ConnPurchase')->select('SELECT * FROM VW_PRG_1273_SPPB_NEW WHERE kode_divisi = ? AND nomor_sppb = ?', [$divisi, $sppb]);
            }

               if (count($dataCetak) > 0) {
                $direktur = $dataCetak[0]->Direktur ?? null;
                $showTtd = !empty($direktur);

                $ttdDirektur = null;
                if ($showTtd) {
                    $ttdDirektur = DB::connection('ConnEDP')
                        ->table('dbo.UserMaster')
                        ->select('NamaUser', 'FotoTtd')
                        ->where('NomorUser', 'rudy')
                        ->first();
                }

                return view(
                    'Beli.Transaksi.po_email',
                    compact('dataCetak', 'jenisCetak', 'ttdDirektur', 'showTtd')
                );
            } else {
                return redirect()->back()->with('error', 'Data tidak ditemukan');
            }
        }
        else {
            return response()->json(['error' => 'Invalid request'], 404);
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


    public function getEmailSupplier(Request $request)
    {
        $noSPPB = $request->no_sppb;

        $data = DB::connection('ConnPurchase')
            ->table('YTRANSBL as t')
            ->join('YSUPPLIER as s', 't.No_sup', '=', 's.NO_SUP')
            ->select('s.NM_SUP', 's.TELEX1', 's.TELEX2')
            ->where('t.No_sppb', $noSPPB)
            ->first();

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Supplier tidak ditemukan'
            ]);
        }

        $email1 = trim($data->TELEX1 ?? '');
        $email2 = trim($data->TELEX2 ?? '');

        $email = null;

        if (!empty($email1) && $email1 !== '00') {
            $email = $email1;
        } elseif (!empty($email2) && $email2 !== '00') {
            $email = $email2;
        }

        if (!$email) {
            return response()->json([
                'success' => true,
                'type'    => 'info',
                'title'   => 'Email Supplier belum ada!',
                'message' => 'Daftarkan email Supplier terlebih dahulu.'
            ]);
        }

        return response()->json([
            'success' => true,
            'nama_supplier' => $data->NM_SUP,
            'email' => $email
        ]);
    }

    public function sendEmailSupplier(Request $request)
    {
        $request->validate([
            'No_sppb' => 'required'
        ]);

        $noSPPB = trim($request->No_sppb);

        // Ambil data SPPB + Supplier
        $data = DB::connection('ConnPurchase')
            ->table('YTRANSBL as t')
            ->join('YSUPPLIER as s', 't.No_sup', '=', 's.NO_SUP')
            ->leftJoin('YDIVISI as d', 't.Kd_div', '=', 'd.KD_DIV')
            ->leftJoin('Y_BARANG as b', 't.Kd_brg', '=', 'b.KD_BRG')
            ->leftJoin('YSATUAN as n', 't.NoSatuan', '=', 'n.No_satuan')
            ->where('t.No_sppb', $noSPPB)
            ->select(
                't.*',
                's.NM_SUP',
                's.ALAMAT1',
                's.KOTA1',
                's.NEGARA1',
                's.ALAMAT2',
                's.KOTA2',
                's.NEGARA2',
                'd.NM_DIV',
                'b.KD_BRG',
                'b.NAMA_BRG',
                'n.Nama_satuan',
                's.TELEX1',
                's.TELEX2'
            )
            ->get();

        if ($data->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Data SPPB tidak ditemukan'
            ]);
        }

        $firstRow = $data->first();
        $emails = [];
        // Ambil TELEX1
        if (!empty($firstRow->TELEX1) && filter_var(trim($firstRow->TELEX1), FILTER_VALIDATE_EMAIL)) {
            $emails[] = trim($firstRow->TELEX1);
        }
        // Ambil TELEX2
        if (!empty($firstRow->TELEX2) && filter_var(trim($firstRow->TELEX2), FILTER_VALIDATE_EMAIL)) {
            $emails[] = trim($firstRow->TELEX2);
        }
        // Jika dua-duanya kosong
        if (empty($emails)) {
            return response()->json([
                'success' => false,
                'message' => 'Email supplier tidak valid / tidak tersedia'
            ]);
        }

        $idMataUang = $data->first()->IdMataUang ?? null;

        $mataUang = null;

        if ($idMataUang) {
            $mataUang = DB::connection('ConnAccounting')
                ->table('T_MATAUANG')
                ->where('Id_MataUang', $idMataUang)
                ->first();
        }

        $data = $data->map(function ($item) use ($mataUang) {
            $item->Symbol  = $mataUang->Symbol  ?? null;
            $item->Symbol2 = $mataUang->Symbol2 ?? null;
            return $item;
        });

        // gambar tanda tangan
        $nomorDirektur = $data->first()->Direktur ?? null;
        $ttdDirektur = null;
        if ($nomorDirektur) {
            $ttdDirektur = DB::connection('ConnEDP')
                ->table('UserMaster')
                ->where('NomorUser', $nomorDirektur)
                ->select('FotoTtd', 'NamaUser')
                ->first();
        }

        // pdf email
        $pdf = Pdf::loadView('Beli.Transaksi.po_email', [
            'dataCetak' => $data,
            'ttdDirektur' => $ttdDirektur
        ])->setPaper('A4', 'portrait');

        // Ambil nomor SPPB
        $nomorSppb = $data->first()->No_sppb ?? null;
        $dok = null;

        if ($nomorSppb) {
            $dok = DB::connection('ConnPurchase')
                ->table('YTRANSBL')
                ->select('Dokumentasi', 'DokumentasiFile')
                ->whereRaw('RTRIM(No_sppb) = ?', [trim($nomorSppb)])
                ->first();
        }

        // dd("Dokumentasi:", $dok);

        //RECIPIENTS
        $recipients = array_unique(array_merge(
            ['cahayasjaya@gmail.com'],
            $emails
        ));

        try {
            Mail::send([], [], function ($message) use ($recipients, $noSPPB, $pdf, $dok, $data) {
                $keteranganOrder  =$data->first()->keterangan ?? '-';
                $message->to($recipients)
                    ->subject("Purchase Order Cahaya Santoso Jaya - {$noSPPB}")
                    ->html("
                        <p>Dear Supplier,</p>
                        <p>
                            Attached signed of SC (" . ($data->first()->keterangan ?? '-') . ")
                            and {$noSPPB}
                        </p>
                        <br>
                        <p>
                            Thank you<br>
                            Best Regards,
                        </p>
                        <br>
                        <p>
                            <strong>PT. Cahaya Santoso Jaya</strong><br>
                            Raya Tropodo No. 1 Waru | Sidoarjo 61256, East Java - Indonesia<br>
                            PH: +62 31 8669935 | email: cahayasjaya@gmail.com
                        </p>"
                        )
                    ->attachData(
                        $pdf->output(),
                        "{$noSPPB}.pdf",
                        ['mime' => 'application/pdf']
                    );

                // ATTACH DOKUMENTASI FILE (PDF)
                if (!empty($dok->DokumentasiFile)) {
                    $message->attachData(
                        $dok->DokumentasiFile,
                        "Dokumentasi_{$noSPPB}.pdf",
                        ['mime' => 'application/pdf']
                    );
                }
            });

            return response()->json([
                'success' => true,
                'message' => "Email berhasil dikirim ke " . implode(', ', $recipients)
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Gagal kirim email: ' . $e->getMessage()
            ]);
        }
    }
}
