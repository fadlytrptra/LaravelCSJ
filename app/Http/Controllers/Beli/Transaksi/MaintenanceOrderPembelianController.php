<?php

namespace App\Http\Controllers\Beli\Transaksi;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HakAksesController;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Auth;

class MaintenanceOrderPembelianController extends Controller
{
    // Display a listing of the resource.
    public function index(Request $request)
    {
        $idUser = trim(Auth::user()->NomorUser);
        $data = $request->query('d');
        $statusKoreksi = $request->query('s');
        $result = (new HakAksesController)->HakAksesFitur('Maintenance Order Pembelian');
        $access = (new HakAksesController)->HakAksesFiturMaster('Beli');
        return view('Beli.Transaksi.MaintenanceOrderPembelian', compact('access', 'idUser', 'data', 'statusKoreksi'));

    }

    public function cekNoTrans(Request $request)
    {
        $No_trans = $request->input('No_trans');
        if ($No_trans != null) {
            try {
                $data = DB::connection('ConnPurchase')->table('YTRANSBL')->where('YTRANSBL.No_trans', $No_trans)->get();
                return Response()->json($data);
            } catch (\Throwable $Error) {
                return Response()->json($Error);
            }
        } else {
            return Response()->json('Parameter harus di isi');
        }
    }

    public function kodeBarang(Request $request)
    {
        $KdBarang = $request->input('KdBarang');
        if ($KdBarang != null) {
            try {
                $data = DB::connection('ConnPurchase')->select('exec SP_1273_PRG_Select_Barang @KdBarang = ?', [$KdBarang]);
                $imageContent = null;
                if (!empty($data[0]->FOTO)) {
                    $imageContent = base64_encode($data[0]->FOTO);
                }
                foreach ($data as $item) {
                    unset($item->FOTO);
                }
                return response()->json([
                    'data' => $data,
                    'image' => $imageContent
                ]);
            } catch (\Throwable $Error) {
                return Response()->json($Error);
            }
        } else {
            return Response()->json('Parameter harus di isi');
        }
    }
    public function data()
    {
        $MyType = 1;
        try {
            $kategoriUtama = DB::connection('ConnPurchase')->select('exec SP_1273_PRG_Select_HirarkiTypeBarang @MyType = ?', [$MyType]);
            $satuanList = DB::connection('ConnPurchase')->select('exec SP_1273_PRG_LIST_STRI');
            $divisi = DB::connection('ConnPurchase')->select('exec SP_1273_PRG_User_Divisi @Operator = ?', [trim(Auth::user()->NomorUser)]);
            return Response()->json(["kategoriUtama" => $kategoriUtama, "satuanList" => $satuanList, "divisi" => $divisi]);
        } catch (\Throwable $Error) {
            return Response()->json($Error);
        }
    }
    public function kategori(Request $request)
    {
        $MyType = 2;
        $MyValue = $request->input('MyValue');
        if ($MyValue != null) {
            try {
                $data = DB::connection('ConnPurchase')->select('exec SP_1273_PRG_Select_HirarkiTypeBarang @MyType = ?, @MyValue = ?', [$MyType, $MyValue]);
                return Response()->json($data);
            } catch (\Throwable $Error) {
                return Response()->json($Error);
            }
        } else {
            return Response()->json('Parameter harus di isi');
        }
    }
    public function subKategori(Request $request)
    {
        $MyType = 3;
        $MyValue = $request->input('MyValue');
        if ($MyValue != null) {
            try {
                $data = DB::connection('ConnPurchase')->select('exec SP_1273_PRG_Select_HirarkiTypeBarang @MyType = ?, @MyValue = ?', [$MyType, $MyValue]);
                return Response()->json($data);
            } catch (\Throwable $Error) {
                return Response()->json($Error);
            }
        } else {
            return Response()->json('Parameter harus di isi');
        }
    }
    public function namaBarang(Request $request)
    {
        $MyType = 5;
        $MyValue = $request->input('MyValue');
        if ($MyValue != null) {
            try {
                $data = DB::connection('ConnPurchase')->select('exec SP_1273_PRG_Select_HirarkiTypeBarang @MyType = ?, @MyValue = ?', [$MyType, $MyValue]);
                return Response()->json($data);
            } catch (\Throwable $Error) {
                return Response()->json($Error);
            }
        } else {
            return Response()->json('Parameter harus di isi');
        }
    }
    public function golongan(Request $request)
    {
        $kd_div = $request->input('kd_div');
        if ($kd_div != null) {
            try {
                $data = DB::connection('ConnPurchase')->select('exec SP_1273_PRG_Select_GolonganByDivisi @kd_div = ?', [$kd_div]);
                return Response()->json($data);
            } catch (\Throwable $Error) {
                return Response()->json($Error);
            }
        } else {
            return Response()->json('Parameter harus di isi');
        }
    }
    public function saldo(Request $request)
    {
        $Kode = 10;
        $KodeBarang = $request->input('KodeBarang');
        if ($KodeBarang != null) {
            try {
                $data = DB::connection('ConnInventory')->select('exec SP_1003_INV_LIST_TYPE @Kode = ?, @KodeBarang = ?', [$Kode, $KodeBarang]);
                return datatables($data)->make(true);
            } catch (\Throwable $Error) {
                return Response()->json($Error);
            }
        } else {
            return Response()->json('Parameter harus di isi');
        }
    }
    public function mesinGolongan(Request $request)
    {
        $no_gol = $request->input('no_gol');
        if ($no_gol != null) {
            try {
                $data = DB::connection('ConnPurchase')->select('exec SP_1273_PRG_Select_MesinByGolongan @no_gol = ?', [$no_gol]);
                return Response()->json($data);
            } catch (\Throwable $Error) {
                return Response()->json($Error);
            }
        } else {
            return Response()->json('Parameter harus di isi');
        }
    }
    public function save(Request $request)
    {
        $Operator = trim(Auth::user()->NomorUser);
        $kd = $request->input('kd');
        $Kd_div = $request->input('Kd_div');
        $Kd_brg = $request->input('Kd_brg');
        $keterangan = $request->input('keterangan');
        $Qty = $request->input('Qty');
        $Pemesan = $request->input('Pemesan');
        $NoSatuan = $request->input('NoSatuan');
        $kodeGolongan = $request->input('kodeGolongan');
        $kodeMesin = $request->input('kodeMesin');
        $Tgl_Dibutuhkan = Carbon::parse($request->input('Tgl_Dibutuhkan'));
        if ($kd != null && $Kd_div != null && $Kd_brg != null && $NoSatuan != null && $Tgl_Dibutuhkan != null) {
            try {
                $mValue = DB::connection('ConnPurchase')->table('YCounter')->value('YTRANSBL') + 1;
                $No_trans = '00000000' . str_pad($mValue, 8, '0', STR_PAD_LEFT);
                $No_trans = substr($No_trans, -8);
                DB::connection('ConnPurchase')->statement('exec SP_4384_PRG_Insert_Permohonan
                    @Kd_div = ?, @Kd_brg = ?, @keterangan = ?, @Qty = ?, @NoSatuan = ?,
                    @Pemesan = ?, @No_gol = ?, @No_msn = ?, @Operator = ?, @Tgl_Dibutuhkan = ?,
                    @No_trans = ?', [
                    $Kd_div,
                    $Kd_brg,
                    $keterangan,
                    $Qty,
                    $NoSatuan,
                    $Pemesan,
                    $kodeGolongan,
                    $kodeMesin,
                    $Operator,
                    $Tgl_Dibutuhkan,
                    $No_trans,
                ]);
                return response()->json(['message' => 'Data Berhasil DiTambahkan!', "data" => $No_trans]);

            } catch (Exception $Ex) {
                return response()->json($Ex->getMessage());
            }
        } else {
            return response()->json('Parameter harus diisi');
        }
    }
    public function submit(Request $request)
    {
        $Operator = trim(Auth::user()->NomorUser);
        $kd = $request->input('kd');
        $Kd_div = $request->input('Kd_div');
        $Kd_brg = $request->input('Kd_brg');
        $keterangan = $request->input('keterangan');
        $Qty = $request->input('Qty');
        $Pemesan = $request->input('Pemesan');
        $NoSatuan = $request->input('NoSatuan');
        $Tgl_Dibutuhkan = Carbon::parse($request->input('Tgl_Dibutuhkan'));
        $noTrans = $request->input('noTrans');
        $kodeGolongan = $request->input('kodeGolongan');
        $kodeMesin = $request->input('kodeMesin');
        if ($kd != null && $Kd_div != null && $Kd_brg != null && $NoSatuan != null && $Tgl_Dibutuhkan != null && $noTrans != null) {
            try {
                $data = DB::connection('ConnPurchase')->statement('exec SP_1273_PRG_Update_Permohonan
                @Kd_brg = ?,
                @keterangan = ?,
                @Qty = ?,
                @NoSatuan = ?,
                @Pemesan = ?,
                @No_gol = ?,
                @No_msn = ?,
                @Operator = ?,
                @Tgl_Dibutuhkan = ?,
                @No_trans = ?', [
                    $Kd_brg,
                    $keterangan,
                    $Qty,
                    $NoSatuan,
                    $Pemesan,
                    $Qty,
                    $Pemesan,
                    $kodeGolongan,
                    $kodeMesin,
                    $Tgl_Dibutuhkan,
                    $noTrans
                ]);

                return response()->json(['message' => 'Data Berhasil DiUpdate!']);
            } catch (\Throwable $Error) {
                return response()->json($Error);
            }
        } else {
            return response()->json('Parameter harus diisi');
        }
    }
    public function delete(Request $request)
    {
        $kd = 7;
        $noTrans = $request->input('noTrans');
        if ($noTrans != null) {
            try {
                $data = DB::connection('ConnPurchase')->statement('exec SP_5409_SAVE_ORDER @kd =?, @noTrans = ?', [
                    $kd,
                    $noTrans
                ]);
                return response()->json(['message' => 'Berhasil DiDelete!']);
            } catch (\Throwable $Error) {
                return response()->json($Error);
            }
        } else {
            return response()->json('Parameter harus diisi');
        }
    }

    public function uploadDokumentasi(Request $request)
    {
        $request->validate([
            'noTrans' => 'required|string',
            'attach_file' => 'required|file|max:1536'
        ]);

        $noTrans = trim($request->noTrans);
        $conn = DB::connection('ConnPurchase');

        $conn->beginTransaction();

        try {
            $existing = $conn->table('YTRANSBL')
                ->where('No_trans', $noTrans)
                ->first();

            if (!$existing) {
                $conn->rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'No Trans tidak ditemukan'
                ], 404);
            }

            // hanya boleh 1 dokumentasi
            if (!is_null($existing->Dokumentasi) || !is_null($existing->DokumentasiFile)) {
                $conn->rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Dokumentasi sudah ada. Hapus terlebih dahulu.'
                ], 400);
            }

            $file = $request->file('attach_file');
            $extension = strtolower($file->getClientOriginalExtension());

            if ($extension === 'pdf') {

                // 🔴 VARBINARY
                $binary = $file->get();
                $hex = '0x' . bin2hex($binary);

                $conn->statement("
                    UPDATE YTRANSBL
                    SET DokumentasiFile = $hex
                    WHERE No_trans = ?
                ", [$noTrans]);

            } else {

                // 🔵 VARCHAR (BASE64)
                $base64 = base64_encode($file->get());

                $conn->table('YTRANSBL')
                    ->where('No_trans', $noTrans)
                    ->update([
                        'Dokumentasi' => $base64
                    ]);
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

    public function getDokumentasi($noTrans)
    {
        $data = DB::connection('ConnPurchase')
            ->table('YTRANSBL')
            ->select('Dokumentasi', 'DokumentasiFile')
            ->where('No_trans', $noTrans)
            ->first();

        if (!$data) {
            return response('', 204);
        }

        // PDF (binary)
        if (!is_null($data->DokumentasiFile)) {
            return response($data->DokumentasiFile)
                ->header('Content-Type', 'application/pdf');
        }

        // Image (base64)
        if (!is_null($data->Dokumentasi)) {
            return response(base64_decode($data->Dokumentasi))
                ->header('Content-Type', 'image/jpeg');
        }

        return response('', 204);
    }

    public function deleteDokumentasi(Request $request)
    {
        $request->validate([
            'noTrans' => 'required|string'
        ]);

        $noTrans = trim($request->noTrans);
        $conn = DB::connection('ConnPurchase');

        $conn->beginTransaction();
        try {
            $existing = $conn->table('YTRANSBL')
                ->where('No_trans', $noTrans)
                ->first();

            if (!$existing) {
                $conn->rollBack();

                return response()->json([
                    'success' => false,
                    'message' => 'No Trans tidak ditemukan'
                ], 404);
            }

            // Tidak ada dokumentasi
            if (is_null($existing->Dokumentasi) && is_null($existing->DokumentasiFile)) {
                $conn->rollBack();

                return response()->json([
                    'success' => false,
                    'message' => 'Dokumentasi tidak ditemukan'
                ], 400);
            }

            $conn->table('YTRANSBL')
                ->where('No_trans', $noTrans)
                ->update([
                    'Dokumentasi' => null,
                    'DokumentasiFile' => null
                ]);

            $conn->commit();

            return response()->json([
                'success' => true,
                'message' => 'Dokumentasi berhasil dihapus'
            ]);

        } catch (\Throwable $e) {

            $conn->rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
