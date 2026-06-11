<?php

namespace App\Http\Controllers\Beli\Transaksi;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Beli\TransBL;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HakAksesController;
use DateTime;
use DateTimeZone;
use DB;

class ApproveController extends Controller
{
    public function index(Request $request)
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('Beli');
        $result = (new HakAksesController)->HakAksesFitur('Approve');
        if ($result <= 0) {
            abort(403);
        }

        $kdUser = trim(Auth::user()->NomorUser);

        $data = DB::connection('ConnPurchase')->select(
            "EXEC dbo.SP_1273_PRG_Select_AccPermohonan @kd_user = ?",
            [$kdUser]
        );

        return view(
            'Beli.Transaksi.Approve.List',
            compact('data', 'access',)
        );
    }

    public function store(Request $request)
    {
        $checked = $request->input('checkedBOX');
        $kdUser = trim(Auth::user()->NomorUser);

        if (empty($checked)) {
            return back()->with(
                'danger',
                'Gagal Proses, Karena Tidak Ada Data yang Dipilih'
            );
        }

        switch ($request->action) {

            // ==================================
            // ACC PERMOHONAN
            // ==================================
            case 'ACC_PERMOHONAN':

                foreach ($checked as $item) {

                    DB::connection('ConnPurchase')->statement(
                        "EXEC dbo.SP_1273_PRG_Update_AccPermohonan
                            @no_trans = ?,
                            @manager = ?",
                        [
                            $item,
                            $kdUser
                        ]
                    );
                }

                // data tetap ada
                return back();

            // ==================================
            // BATAL ACC
            // ==================================
            case 'BATAL_ACC':

                foreach ($checked as $item) {

                \Log::info('BATAL_ACC EXEC', [
                    'No_trans' => $item,
                    'kdUser' => $kdUser
                ]);

                    DB::connection('ConnPurchase')->statement(
                        "EXEC dbo.SP_1273_PRG_Update_BatalAccPermohonan
                            @no_trans = ?,
                            @batal_acc = ?",
                        [
                            $item,
                            $kdUser
                        ]
                    );
                }

                // data hilang setelah reload
                return back();
        }
    }

    public function show($id)
    {
        $data = TransBL::select(
            'Y_KATEGORI_UTAMA.nama as KatUtama',
            'Y_KATEGORY.nama_kategori as kategori',
            'Y_KATEGORI_SUB.nama_sub_kategori as SubKat',
            'Y_BARANG.NAMA_BRG as NamaBarang',
            'Qty',
            'Nama_satuan',
            'Pemesan',
            'YUSER.Nama as User',
            'Tgl_Dibutuhkan',
            'Ket_Internal',
            'keterangan',
            'Kd_div'
        )
            ->leftJoin(
                'Y_BARANG',
                'Y_BARANG.KD_BRG',
                'YTRANSBL.Kd_brg'
            )
            ->leftJoin(
                'YUSER',
                'YUSER.kd_user',
                'YTRANSBL.Operator'
            )
            ->leftJoin(
                'YSATUAN',
                'YSATUAN.No_satuan',
                'YTRANSBL.NoSatuan'
            )
            ->leftJoin(
                'Y_KATEGORI_SUB',
                'Y_KATEGORI_SUB.no_sub_kategori',
                'Y_BARANG.NO_SUB_KATEGORI'
            )
            ->leftJoin(
                'Y_KATEGORY',
                'Y_KATEGORY.no_kategori',
                'Y_KATEGORI_SUB.no_kategori'
            )
            ->leftJoin(
                'Y_KATEGORI_UTAMA',
                'Y_KATEGORI_UTAMA.no_kat_utama',
                'Y_KATEGORY.no_kat_utama'
            )
            ->where('No_trans', $id)
            ->first();

        $getKD_Barang = TransBL::select('Kd_brg')
            ->where('No_trans', $id)
            ->first();

        $dataBeliTerakhir = TransBL::select()
            ->leftJoin(
                'YSUPPLIER',
                'YSUPPLIER.NO_SUP',
                'YTRANSBL.supplier'
            )
            ->where('Kd_brg', $getKD_Barang->Kd_brg)
            ->orderBy('No_trans', 'desc')
            ->limit(1)
            ->get();

        return compact(
            'data',
            'dataBeliTerakhir',
            'getKD_Barang'
        );
    }

    public function update(Request $request, $id)
    {
        $date = new DateTime(
            'now',
            new DateTimeZone('Asia/Jakarta')
        );

        switch ($request->input('action')) {

            case 'Approve':

                TransBL::where('No_trans', $id)
                    ->update([
                        'Tgl_acc' => $date,
                        'Manager' => trim(Auth::user()->NomorUser),
                    ]);

                return back();

            case 'Reject':

                TransBL::where('No_trans', $id)
                    ->update([
                        'Tgl_Batal_acc' => $date,
                        'Batal_acc'     => trim(Auth::user()->NomorUser),
                    ]);

                return back();
        }
    }
}
