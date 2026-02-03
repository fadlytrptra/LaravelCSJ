<?php

namespace App\Http\Controllers\Beli\Transaksi;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Beli\TransBL;
use App\User;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HakAksesController;
use DateTime;
use DateTimeZone;
use DB;

class FinalApproveController extends Controller
{
    public function index()
    {
        $kdUser = trim(Auth::user()->NomorUser);
        $access = (new HakAksesController)->HakAksesFiturMaster('Beli');
        $result = (new HakAksesController)->HakAksesFitur('Final Approve');

        return view('Beli.Transaksi.FinalApprove.List', compact('access'));
    }

    // public function store(Request $request)
    // {
    //     $checked = $request->input('checkedBOX', []);

    //     if (empty($checked)) {
    //         return back()->with('danger', 'Gagal Approve/Reject, Karena Tidak Ada Data yang Dipilih');
    //     }

    //     $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
    //     $now  = $date->format('Y-m-d H:i:s');
    //     $user = trim(Auth::user()->NomorUser);

    //     switch ($request->input('action')) {

    //         case 'Approve':
    //             TransBL::whereIn('No_trans', $checked)->update([
    //                 'Tgl_Direktur' => $now,
    //                 'Direktur'     => $user,
    //                 'Dir_Agree'    => 1,
    //             ]);
    //             return back();

    //         case 'DownToManager':
    //             TransBL::whereIn('No_trans', $checked)->update([
    //                 // batalkan acc manager
    //                 'Tgl_acc'       => null,
    //                 'Manager'       => null,
    //                 // bersihkan jejak direktur
    //                 'Tgl_Direktur'  => null,
    //                 'Direktur'      => null,
    //                 'Dir_Agree'     => 0,
    //                 // tandai sebagai DITOLAK (oleh direktur)
    //                 'Tgl_Batal_acc' => $now,
    //                 'Batal_acc'     => $user,
    //             ]);
    //             return back();
    //

    //         case 'Reject':
    //             TransBL::whereIn('No_trans', $checked)->update([
    //                 'Tgl_Direktur'  => $now,
    //                 'Direktur'      => $user,
    //                 'Tgl_Batal_acc' => $now,
    //                 'Batal_acc'     => $user,
    //                 'Dir_Agree'     => 0,
    //             ]);
    //             return back();

    //         case 'Revisi':
    //             $noTrans = $checked[0];
    //             $old = TransBL::where('No_trans', $noTrans)->firstOrFail();
    //             $noSppbBaru = $this->generateNoSppbRevisi($old->No_sppb);

    //             $new = $old->replicate();
    //             $new->No_sppb = $noSppbBaru;
    //             $new->Dir_Agree     = null;
    //             $new->Direktur      = null;
    //             $new->Tgl_Direktur  = null;
    //             $new->Manager       = null;
    //             $new->Tgl_acc       = null;
    //             $new->Batal_acc     = null;
    //             $new->Tgl_Batal_acc = null;

    //             $new->save();
    //             TransBL::where('No_trans', $noTrans)->update([
    //                 'Dir_Agree'     => 0,
    //                 'Batal_acc'     => $user,
    //                 'Tgl_Batal_acc' => $now,
    //             ]);

    //             return back()->with('success', 'Revisi berhasil: ' . $noSppbBaru);

    //         default:
    //             return back();
    //     }
    // }


    //TESTING FUNGSI ACCEPT, REVISI DAN DIBATALKAN
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $checked = array_column($request->input('checkedBOX', []), 'No_trans');
            if (empty($checked)) {
                DB::rollBack();
                return response()->json(['error' => 'Tidak ada data dipilih', 404]);
                // return back()->with('danger', 'Tidak ada data dipilih');
            }

            $now = now('Asia/Jakarta');
            $user = trim(Auth::user()->NomorUser);

            switch ($request->input('action')) {

                /* =========================
                 * APPROVE
                 * ========================= */
                case 'Approve':

                    TransBL::whereIn('No_trans', $checked)->update([
                        'Tgl_Direktur' => $now,
                        'Direktur' => $user,
                        'Dir_Agree' => 1,
                    ]);

                    DB::commit();
                    return response()->json(['success' => 'Data berhasil di-approve'], 200);
                // return back()->with('success', 'Data berhasil di-approve');


                /* =========================
                 * REVISI
                 * ========================= */
                case 'Revisi':
                    try {
                        //generate no_sppb rev
                        $noTrans = $checked[0];

                        $old = DB::table('YTRANSBL')
                            ->where('No_trans', $noTrans)
                            ->first();

                        if (!$old) {
                            DB::rollBack();
                            // return back()->with('danger', 'Data tidak ditemukan');
                            return response()->json(['error' => 'Data tidak ditemukan', 404]);
                        }
                        $noSPPB = substr(
                            rtrim($this->generateNoSppbRevisi($old->No_sppb)),
                            0,
                            25
                        );
                        foreach ($checked as $row) {
                            $noTrans = $row;

                            $old = DB::table('YTRANSBL')
                                ->where('No_trans', $noTrans)
                                ->first();

                            if (!$old) {
                                DB::rollBack();
                                return response()->json([
                                    'error' => "Data tidak ditemukan: {$noTrans}"
                                ], 404);
                            }

                            // 1️⃣ Batalkan data lama
                            DB::table('YTRANSBL')
                                ->where('No_trans', $noTrans)
                                ->update([
                                    'Dir_Agree' => 1,
                                    'Batal_acc' => $user,
                                    'Tgl_batal_Acc' => $now,
                                ]);

                            // 2️⃣ Duplikasi data untuk revisi
                            $newData = (array) $old;

                            $newData['No_trans'] = $this->generateNoTransBaru();
                            $newData['No_sppb'] = $noSPPB;
                            // reset approval fields
                            $newData['Dir_Agree'] = null;
                            $newData['Direktur'] = null;
                            $newData['Tgl_Direktur'] = null;
                            $newData['Manager'] = null;
                            $newData['Tgl_acc'] = null;
                            $newData['Batal_acc'] = null;
                            $newData['Tgl_batal_Acc'] = null;

                            DB::table('YTRANSBL')->insert($newData);
                        }

                        DB::commit();

                        return response()->json([
                            'success' => 'Data berhasil direvisi'
                        ], 200);

                    } catch (\Throwable $e) {
                        DB::rollBack();

                        return response()->json([
                            'error' => $e->getMessage()
                        ], 500);
                    }

                /* =========================
                 * DIBATALKAN
                 * ========================= */
                case 'Dibatalkan':

                    TransBL::whereIn('No_trans', $checked)->update([
                        'Dir_Agree' => 1,
                        'Batal_acc' => $user,
                        'Tgl_batal_Acc' => $now,
                    ]);

                    DB::commit();
                    return response()->json(['success' => 'Data berhasil dibatalkan'], 200);
                // return back()->with('success', 'Data berhasil dibatalkan');


                default:
                    DB::rollBack();
                    return response()->json(['error' => 'Request invalid'], 405);
                // return back()->with('danger', 'Aksi tidak valid');
            }

            // } catch (\Throwable $e) {

            //     DB::rollBack();

            //     // PENTING: simpan error detail
            //     \Log::error('FinalApprove Error', [
            //         'message' => $e->getMessage(),
            //         'trace'   => $e->getTraceAsString(),
            //     ]);

            //     return back()->with('danger', 'Terjadi kesalahan sistem');
            // }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e], 405);

            // dd([
            //     'ERROR_MESSAGE' => $e->getMessage(),
            //     'ERROR_FILE' => $e->getFile(),
            //     'ERROR_LINE' => $e->getLine(),
            //     'TRACE' => collect($e->getTrace())->take(5),
            // ]);
        }
    }

    public function show($id, Request $request)
    {
        if ($id == 'getAllSPPB') {
            $kdUser = trim(Auth::user()->NomorUser);
            $data = DB::connection('ConnPurchase')->select(
                'EXEC dbo.SP_1273_PRG_Select_AccPermohonan @XKode = ?, @kd_user = ?',
                [1, $kdUser]
            );
            return datatables(source: $data)->make(true);
        } else if ($id == 'getAllNoTrans') {

            $kdUser = trim(Auth::user()->NomorUser);

            // 1️⃣ Execute SP → ARRAY result
            $data = DB::connection('ConnPurchase')->select(
                'EXEC dbo.SP_1273_PRG_Select_AccPermohonan @XKode = ?, @kd_user = ?',
                [1, $kdUser]
            );

            // 2️⃣ Convert to Collection
            $collection = collect($data);

            // 3️⃣ Apply DataTables search filter (optional)
            if ($request->filled('search.value')) {
                $search = $request->input('search.value');

                $collection = $collection->filter(function ($row) use ($search) {
                    return str_contains(
                        strtoupper(trim($row->No_sppb)),
                        strtoupper($search)
                    );
                });
            }

            // 4️⃣ Return only needed fields
            return $collection
                ->map(function ($row) {
                    return [
                        'No_trans' => trim($row->No_trans),
                        'No_sppb' => trim($row->No_sppb),
                    ];
                })
                ->values(); // reset index
        }

        // PERINGATAN:
        // Di sini kamu MASIH punya join ke STATUS_ORDER dan whereIn(StatusOrder, ...)
        // Kalau tabel YTRANSBL saat ini benar-benar tidak punya StatusOrder,
        // bagian itu juga harus dibersihkan seperti di controller Manager.

        $data = TransBL::select(
            'Y_KATEGORI_UTAMA.nama as KatUtama',
            'Y_KATEGORY.nama_kategori as kategori',
            'Y_KATEGORI_SUB.nama_sub_kategori as SubKat',
            'Y_BARANG.NAMA_BRG as NamaBarang',
            'Qty',
            'Nama_satuan',
            'Pemesan',
            'YUSER.Nama as User',
            'StatusBeli',
            'Tgl_Dibutuhkan',
            'Ket_Internal',
            'keterangan',
            'Kd_div'
        )
            ->leftJoin('Y_BARANG', 'Y_BARANG.KD_BRG', 'YTRANSBL.Kd_brg')
            ->leftJoin('YUSER', 'YUSER.kd_user', 'YTRANSBL.Operator')
            ->leftJoin('YSATUAN', 'YSATUAN.No_satuan', 'YTRANSBL.NoSatuan')
            // ->leftJoin('STATUS_ORDER', 'STATUS_ORDER.KdStatus', 'YTRANSBL.StatusOrder')
            ->leftJoin('Y_KATEGORI_SUB', 'Y_KATEGORI_SUB.no_sub_kategori', 'Y_BARANG.NO_SUB_KATEGORI')
            ->leftJoin('Y_KATEGORY', 'Y_KATEGORY.no_kategori', 'Y_KATEGORI_SUB.no_kategori')
            ->leftJoin('Y_KATEGORI_UTAMA', 'Y_KATEGORI_UTAMA.no_kat_utama', 'Y_KATEGORY.no_kat_utama')
            ->where('No_trans', $id)
            ->first();

        $getKD_Barang = TransBL::select('Kd_brg')
            ->where('No_trans', $id)
            ->first();

        $dataBeliTerakhir = TransBL::select()
            ->leftJoin('YSUPPLIER', 'YSUPPLIER.NO_SUP', 'YTRANSBL.supplier')
            // ->whereIn('StatusOrder', [4, 5, 8, 10, 11])
            ->where('Kd_brg', $getKD_Barang->Kd_brg)
            ->orderBy('No_trans', 'desc')
            ->offset(0)
            ->limit(1)
            ->get();

        return compact('data', 'dataBeliTerakhir', 'getKD_Barang');
    }

    public function update(Request $request, $id)
    {
        // Versi single-row dari store()
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $now = $date->format('Y-m-d H:i:s');
        $user = trim(Auth::user()->NomorUser);

        switch ($request->input('action')) {
            case 'Approve':
                TransBL::where('No_trans', $id)->update([
                    'Tgl_Direktur' => $now,
                    'Direktur' => $user,
                    'Dir_Agree' => 1,
                ]);
                return back();

            case 'DownToManager':
                TransBL::where('No_trans', $id)->update([
                    'Tgl_acc' => null,
                    'Manager' => null,
                    'Tgl_Direktur' => null,
                    'Direktur' => null,
                    'Dir_Agree' => 0,
                ]);
                return back();

            case 'Reject':
                TransBL::where('No_trans', $id)->update([
                    'Tgl_Direktur' => $now,
                    'Direktur' => $user,
                    'Tgl_Batal_acc' => $now,
                    'Batal_acc' => $user,
                    'Dir_Agree' => 0,
                ]);
                return back();

            default:
                return back();
        }
    }

    public function generateNoSppbRevisi(string $oldNo): string
    {
        $base = trim($oldNo);

        // Jika sudah ada REVxx di akhir
        if (preg_match('/REV(\d+)$/', $base, $m)) {
            $next = str_pad(((int) $m[1]) + 1, 2, '0', STR_PAD_LEFT);

            return preg_replace(
                '/\sREV\d+$/',
                ' REV' . $next,
                $base
            );
        }

        // Jika belum pernah direvisi
        return $base . ' REV01';
    }




    public function generateNoTransBaru()
    {
        return DB::transaction(function () {

            // lock table agar tidak race condition
            $last = DB::table('YTRANSBL')
                ->lockForUpdate()
                ->selectRaw('MAX(CAST(No_trans AS INT)) as max_no')
                ->value('max_no');

            $next = ($last ?? 0) + 1;
            return str_pad($next, 8, '0', STR_PAD_LEFT);
        });
    }

}
