<?php

namespace App\Http\Controllers\Sales\Transaksi\SuratJalan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\HakAksesController;

class SuratJalanManagerController extends Controller
{
    //Display a listing of the resource.
    public function index()
    {
        $data = db::connection('ConnSales')->select('exec SP_1273_PRG_LIST_HEADERKIRIM_BLMACC');
        // Ambil semua IdHeaderKirim dari hasil SP
        $idHeaderKirim = collect($data)
            ->pluck('IdHeaderKirim')
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        // Ambil Qty, HargaSatuan, Satuan
        $detailPengiriman = DB::connection('ConnSales')
            ->table('T_DetailPengiriman as TDP')
            ->join(
                'T_DetailPesanan as TDPesanan',
                'TDP.IDSuratPesanan',
                '=',
                'TDPesanan.IDSuratPesanan'
            )
            ->select(
                'TDP.IDHeaderKirim',
                'TDPesanan.Qty',
                'TDPesanan.HargaSatuan',
                'TDPesanan.Satuan'
            )
            ->whereIn('TDP.IDHeaderKirim', $idHeaderKirim)
            ->get()
            ->keyBy('IDHeaderKirim');

        foreach ($data as $item) {

            $detail = $detailPengiriman->get($item->IdHeaderKirim);

            $item->Qty = $detail->Qty ?? 0;
            $item->HargaSatuan = $detail->HargaSatuan ?? 0;
            $item->Satuan = trim($detail->Satuan ?? '-');
        }
        $access = (new HakAksesController)->HakAksesFiturMaster('Sales');
        // dd($LoadHeaderPengiriman);
        return view('Sales.Transaksi.SuratJalan.AccPermohonan', compact('data', 'access'));
    }

    //Show the form for creating a new resource.
    public function create()
    {
        //
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        //
    }

    //Display the specified resource.
    public function show($id, Request $request)
    {
        if ($id == 'getDataHeader') {
            $IdHeaderKirim = $request->IdHeaderKirim;
            $data = db::connection('ConnSales')->select('exec SP_1273_PRG_LIST_DETAILKIRIM_BLMACC @IDHeaderKirim = ?', [$IdHeaderKirim]);
            return response()->json(['message' => $data]);
        } else if ($id == '') {

        }
    }

    //Show the form for editing the specified resource.
    public function edit($id)
    {
        //
    }

    //Update the specified resource in storage.
    public function update(Request $request)
    {
        $user = trim(auth::user()->NomorUser);
        $nomorSJs = $request->nomorSJs;
        // dd($request->all());
        for ($i = 0; $i < count($nomorSJs); $i++) {
            db::connection('ConnSales')->statement('exec SP_1273_PRG_ACC_PENGIRIMAN @IdManager = ?, @IdHeaderKirim = ?', [$user, $nomorSJs[$i]]);
        }
        return redirect()->back()->with('success', 'Surat Jalan yang Dipilih Sudah Disetujui!');
    }

    //Remove the specified resource from storage.
    public function destroy($id)
    {
        //
    }
}
