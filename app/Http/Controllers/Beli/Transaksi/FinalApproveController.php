<?php

namespace App\Http\Controllers\Beli\Transaksi;

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

        $data = DB::connection('ConnPurchase')->select(
            'EXEC dbo.SP_1273_PRG_Select_AccPermohonan @kd_user = ?',
            [$kdUser]
        );

        return view('Beli.Transaksi.FinalApprove.List', compact('data', 'access'));
    }

    public function store(Request $request)
    {
        $checked = $request->input('checkedBOX', []);

        if (empty($checked)) {
            return back()->with('danger', 'Gagal Approve/Reject, Karena Tidak Ada Data yang Dipilih');
        }

        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $now  = $date->format('Y-m-d H:i:s');
        $user = trim(Auth::user()->NomorUser);

        switch ($request->input('action')) {

            case 'Approve':
                TransBL::whereIn('No_trans', $checked)->update([
                    'Tgl_Direktur' => $now,
                    'Direktur'     => $user,
                    'Dir_Agree'    => 1,
                ]);
                return back();

            // ⬇️ ini yang diubah
            case 'DownToManager':
                TransBL::whereIn('No_trans', $checked)->update([
                    // batalkan acc manager
                    'Tgl_acc'       => null,
                    'Manager'       => null,

                    // bersihkan jejak direktur
                    'Tgl_Direktur'  => null,
                    'Direktur'      => null,
                    'Dir_Agree'     => 0,

                    // tandai sebagai DITOLAK (oleh direktur)
                    'Tgl_Batal_acc' => $now,
                    'Batal_acc'     => $user,
                ]);
                return back();

            case 'Reject':
                TransBL::whereIn('No_trans', $checked)->update([
                    'Tgl_Direktur'  => $now,
                    'Direktur'      => $user,
                    'Tgl_Batal_acc' => $now,
                    'Batal_acc'     => $user,
                    'Dir_Agree'     => 0,
                ]);
                return back();

            default:
                return back();
        }
    }


    public function show($id)
    {
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
        $now  = $date->format('Y-m-d H:i:s');
        $user = trim(Auth::user()->NomorUser);

        switch ($request->input('action')) {
            case 'Approve':
                TransBL::where('No_trans', $id)->update([
                    'Tgl_Direktur' => $now,
                    'Direktur'     => $user,
                    'Dir_Agree'    => 1,
                ]);
                return back();

            case 'DownToManager':
                TransBL::where('No_trans', $id)->update([
                    'Tgl_acc'      => null,
                    'Manager'      => null,
                    'Tgl_Direktur' => null,
                    'Direktur'     => null,
                    'Dir_Agree'    => 0,
                ]);
                return back();

            case 'Reject':
                TransBL::where('No_trans', $id)->update([
                    'Tgl_Direktur'  => $now,
                    'Direktur'      => $user,
                    'Tgl_Batal_acc' => $now,
                    'Batal_acc'     => $user,
                    'Dir_Agree'     => 0,
                ]);
                return back();

            default:
                return back();
        }
    }
}
