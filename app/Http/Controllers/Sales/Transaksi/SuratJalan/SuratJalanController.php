<?php

namespace App\Http\Controllers\Sales\Transaksi\SuratJalan;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\HakAksesController;

class SuratJalanController extends Controller
{
    //Display a listing of the resource.
    public function index()
    {
        $data = DB::connection('ConnSales')->select('exec SP_1486_SLS_LIST_KIRIM_BLM_ACC');
        $access = (new HakAksesController)->HakAksesFiturMaster('Sales');
        // dd($data);
        return view('Sales.Transaksi.SuratJalan.Index', compact('data', 'access'));
    }

    //Show the form for creating a new resource.
    public function create()
    {
        $jenisPengiriman = db::connection('ConnSales')->select('exec SP_1273_PRG_LIST_JENIS_SJ');
        $customer = db::connection('ConnSales')->select('exec SP_1273_PRG_LIST_CUSTOMER_KIRIM');
        $expeditor = db::connection('ConnSales')->select('exec SP_1273_PRG_LIST_EXPEDITOR @Kode = ?', [1]);
        $access = (new HakAksesController)->HakAksesFiturMaster('Sales');
        // dd($customer);
        return view('Sales.Transaksi.SuratJalan.Create', compact('jenisPengiriman', 'customer', 'expeditor', 'access'));
    }

    public function getSuratPesanan($customer)
    {
        $suratPesanan = db::connection('ConnSales')->select('exec SP_1273_PRG_LIST_SP_KIRIM @IdCust = ?', [$customer]);
        return response()->json($suratPesanan);
    }

    public function getDeliveryOrder($suratPesanan)
    {
        if (strstr($suratPesanan, '.')) { //ekspor
            $no_spValue = str_replace('.', '/', $suratPesanan);
            $deliveryOrder = db::connection('ConnSales')->select('exec SP_1273_PRG_LIST_DO_KIRIM @IdSP = ?', [$no_spValue]);
        } else { //lokal
            $no_spValue = $suratPesanan;
            $deliveryOrder = db::connection('ConnSales')->select('exec SP_1273_PRG_LIST_DO_KIRIM @IdSP = ?', [$no_spValue]);
        }
        return response()->json($deliveryOrder);
    }

    public function getDataDeliveryOrder($deliveryOrder)
    {
        $dataDeliveryOrder = db::connection('ConnSales')->select('exec SP_1273_PRG_LIST_KODEBARANG_DO @IdDO = ?', [$deliveryOrder]);
        return response()->json($dataDeliveryOrder);
    }

    public function getDetailDataDeliveryOrder($idtransaksi)
    {
        $user = trim(Auth::user()->NomorUser);
        $dataDeliveryOrder = db::connection('ConnInventory')->select('exec SP_1273_PRG_LIST_JUAL_TMPTRANSAKSI @IDTransaksi = ?, @User = ?', [$idtransaksi, $user]);
        return response()->json($dataDeliveryOrder);
    }

    public function getDataListStokQtyDO($idtype)
    {
        $dataDeliveryOrder = db::connection('ConnInventory')->select('exec SP_1273_PRG_TypePIB @IdType = ?, @Kode = ?', [$idtype, 9]);
        return response()->json($dataDeliveryOrder);
    }

    public function getDataListJualQtyDO($idtransaksi)
    {
        $dataDeliveryOrder = db::connection('ConnInventory')->select('exec SP_1273_PRG_LIST_TMPGUDANG @IDTransaksi = ?, @Kode = ?', [$idtransaksi, 2]);
        return response()->json($dataDeliveryOrder);
    }

    public function getDataQtyDeliveryOrder($idtransaksi)
    {
        $dataDeliveryOrder = db::connection('ConnInventory')->select('exec SP_1273_PRG_LIST_TMPGUDANG @idtransaksi = ?, @Kode = ?', [$idtransaksi, 1]);
        return response()->json($dataDeliveryOrder);
    }

    public function postQtyDO(Request $request)
    {

        $KodeBarang = $request->KodeBarang;
        $IdType = $request->IdType;
        $NoPIB = $request->NoPIB;
        $Primer = $request->Primer;
        $Sekunder = $request->Sekunder;
        $Tritier = $request->Tritier;
        $IdTransaksi = $request->IdTransaksi;
        try {
            db::connection('ConnInventory')->statement('exec SP_1273_PRG_Insert_TmpGudang
                @KodeBarang = ?,
                @IdType = ?,
                @NoPIB = ?,
                @Primer = ?,
                @Sekunder = ?,
                @Tritier = ?,
                @IdTransaksi = ?
                ', [
                $KodeBarang,
                $IdType,
                $NoPIB,
                $Primer,
                $Sekunder,
                $Tritier,
                $IdTransaksi
            ]);
            return response()->json(['success' => 'Data berhasil diinput!']);
        } catch (Exception $ex) {
            return response()->json(['error' => 'Data gagal diinput!']);
        }

    }

    public function getNomorSuratJalan(Request $request)
    {
        $suratJalan = db::connection('ConnSales')->select('exec SP_1486_SLS_LIST_KIRIM_BLM_ACC');
        return response()->json($suratJalan);
    }

    function getDetailSuratJalan($id)
    {
        $headerPengiriman = db::connection('ConnSales')->select('exec SP_1486_SLS_LIST_HEADER_PENGIRIMAN @IdPengiriman = ?', [$id]);
        $detailPengiriman = db::connection('ConnSales')->select('exec SP_1486_SLS_LIST_DETAIL_PENGIRIMAN @IDHeaderKirim = ?', [$headerPengiriman[0]->IdHeaderKirim]);
        $customer = db::connection('ConnSales')->select('exec SP_1486_SLS_LIST_CUSTOMER_KIRIM');
        $data = [$headerPengiriman, $detailPengiriman, $customer];
        return response()->json($data);
    }
    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        // dd($request->all());
        $Mytype = 1;
        $JnsIdPengiriman = $request->jenis_pengiriman;
        $IDPengiriman = substr(trim($request->surat_jalan), 0, 10);
        // $IDPengiriman = str_pad($IDPengiriman1, 10, '0', STR_PAD_LEFT);
        // dd($IDPengiriman);
        $IDExpeditor = $request->expeditor;
        $IdCust = $request->customer;
        $TrukNopol = $request->truk_nopol ?? "";
        $Tanggal = $request->tanggal;
        $Biaya = $request->biaya ?? 0;
        $StatusBiaya = 'N';
        $Keterangan = $request->keterangan ?? "";
        $NoContainer = $request->nomor_container ?? NULL;
        $NoSeal = $request->nomor_seal ?? NULL;
        $NoBL = $request->nomor_bl ?? NULL;
        $TglActual = $request->tanggal_actual;
        $IdDO = $request->barang0;
        $IDSuratPesanan = $request->barang3;
        $AccMgr = trim(Auth::user()->NomorUser);
        $nama_barang = $request->nama_barang;
        $idtransaksi = $request->idtrans;
        $jumlah_dikeluarkanPrimer = (float) $request->jumlah_dikeluarkanPrimer;
        $jumlah_dikeluarkanSekunder = (float) $request->jumlah_dikeluarkanSekunder;
        $jumlah_dikeluarkanTritier = (float) $request->jumlah_dikeluarkanTritier;
        $surat_pesanan = $request->surat_pesanan;
        $KodeBarang = $request->hidden_kodeBarang;
        $idType = $request->hidden_idTypeDO;
        // dd($IdDO[0]);

        //Cek_Sesuai_Pemberi
        $pemberi = db::connection('ConnInventory')->select(
            'exec SP_1273_PRG_CHECK_PENYESUAIAN_TRANSAKSI
            @Kode = ?,
            @idtransaksi = ?,
            @idtypetransaksi = ?',
            [
                1,
                $idtransaksi,
                '06'
            ],
        );
        // dd($pemberi[0]->jumlah);
        if ($pemberi[0]->jumlah > 0) {
            return redirect()->back()->with('error', 'Tidak Bisa DiAcc !!!. Karena Ada Transaksi Penyesuaian yang Belum Diacc untuk type ' . $nama_barang . ' Pada divisi pemberi!');
        }

        //proses acc jual
        // db::connection('ConnInventory')->statement(
        //     'exec SP_1273_PRG_PROSES_ACC_JUAL
        //     @IDtransaksi = ?,
        //     @IDPemberi = ?,
        //     @JumlahKeluarPrimer = ?,
        //     @JumlahKeluarSekunder = ?,
        //     @JumlahKeluartritier = ?,
        //     @JumlahKonversi = ?,
        //     @NoSP = ?',
        //     [
        //         $idtransaksi,
        //         $AccMgr,
        //         $jumlah_dikeluarkanPrimer,
        //         $jumlah_dikeluarkanSekunder,
        //         $jumlah_dikeluarkanTritier,
        //         0,
        //         $surat_pesanan
        //     ],
        // );

        $type = db::connection('ConnInventory')->select(
            'exec SP_1273_PRG_LIST_TYPE
                    @Kode = ?,
                    @Idtype = ?',
            [
                7,
                $idType,
            ],
        );
        $saldo = $type[0]->SaldoTritier;

        if ($saldo > 0) {
            $listKurs = db::connection('ConnPurchase')->select(
                'exec SP_1273_PRG_LIST_SPPB_KURS_TERIMA
                        @Kode = ?,
                        @KodeBarang = ?',
                [
                    1,
                    $KodeBarang,
                ],
            );
            $saldo1 = $saldo;
            $totalKurs1 = 0;
            $totalHarga1 = 0;
            foreach ($listKurs as $row) {
                // Convert values to numbers
                $qtyTerima = (float) $row->Qty_Terima;
                $harga = (float) $row->Hrg_trm;
                $kurs = (float) $row->Kurs_Rp;

                // Reduce saldo
                $saldo -= $qtyTerima;

                if ($saldo > 0) {
                    // Case 1: saldo masih lebih besar → pakai qty penuh
                    $qty = $qtyTerima;
                } else {
                    // Case 2: saldo habis / minus → pakai sebagian
                    $qty = $saldo + $qtyTerima;  // sama seperti VB "Qty = Saldo + Qty_Terima"
                    if ($qty < 0)
                        $qty = 0;      // just in case
                }

                // Accumulate totals
                $totalKurs1 += $qty * $kurs;
                $totalHarga1 += $qty * $kurs * $harga;

                // If saldo habis / negative → break like VB: l = j
                if ($saldo <= 0) {
                    break;
                }
            }
            $kurs = $totalKurs1 / $saldo1;
            $harga = $totalHarga1 / $saldo1;

            // db::connection('ConnInventory')->statement(
            //     'exec SP_1273_PRG_Update_Kurs
            //             @KodeBarang = ?,
            //             @Kurs = ?,
            //             @Harga = ?',
            //     [
            //         $KodeBarang,
            //         $kurs,
            //         $harga,
            //     ],
            // );
        }

        //save data header duluu
        // db::connection('ConnSales')->statement(
        //     'exec SP_1273_PRG_MAINT_HEADERPENGIRIMAN @Mytype = ?,
        // @JnsIdPengiriman = ?,
        // @IDPengiriman = ?,
        // @IDExpeditor = ?,
        // @IdCust = ?,
        // @TrukNopol = ?,
        // @Tanggal = ?,
        // @Biaya = ?,
        // @StatusBiaya = ?,
        // @Keterangan = ?,
        // @NoContainer = ?,
        // @NoSeal = ?,
        // @NoBL = ?',
        //     [
        //         $Mytype,
        //         $JnsIdPengiriman,
        //         $IDPengiriman,
        //         $IDExpeditor,
        //         $IdCust,
        //         $TrukNopol,
        //         $Tanggal,
        //         $Biaya,
        //         $StatusBiaya,
        //         $Keterangan,
        //         $NoContainer,
        //         $NoSeal,
        //         $NoBL
        //     ],
        // );

        //kita cari Header kirim yang baru saja dibuat..
        $IDHeaderKirim = DB::connection('ConnSales')->select(
            'Select IdHeaderKirim
            from T_HeaderPengiriman
            where JnsIdPengiriman = ' . $JnsIdPengiriman . ' and
            IDPengiriman = \'' . $IDPengiriman . '\''
        );
        // dd($IDHeaderKirim[0]->IdHeaderKirim, $IdDO, $IDSuratPesanan);
        //save data detail duluu

        db::connection('ConnSales')->statement(
            'exec SP_1273_PRG_MAINT_DETAILPENGIRIMAN @Mytype = ?,
                        @IDHeaderKirim = ?,
                        @IdDO = ?,
                        @IDSuratPesanan = ?,
                        @AccMgr = ?',
            [
                $Mytype,
                $IDHeaderKirim[0]->IdHeaderKirim,
                $IdDO[0],
                $IDSuratPesanan[0],
                $AccMgr
            ],
        );

        $listJual = db::connection('ConnPurchase')->select(
            'exec SP_1273_PRG_LIST_SPPB_KURS_TERIMA
                        @Kode = ?,
                        @KodeBarang = ?',
            [
                2,
                $KodeBarang
            ],
        );

        $QtyJual1 = $jumlah_dikeluarkanTritier;
        $TotalHargaBeli1 = 0.0;
        $No_PIBBeli = "";

        foreach ($listJual as $row) {
            $rowQty = (float) $row->Qty_Jual;
            $HargaBeli = (float) $row->Hrg_trm;
            $KursBeli = (float) $row->Kurs_Rp;

            // Determine how much we take from this row
            $QtyJual = min($QtyJual1, $rowQty);

            // Calculate harga beli
            $TotalHargaBeli = $QtyJual * $HargaBeli * $KursBeli;
            $TotalHargaBeli1 += $TotalHargaBeli;

            // If total 0 → force all to 0
            if ($TotalHargaBeli == 0) {
                $TotalHargaBeli1 = 0;
            }

            // Update remaining qty on this row
            $row->Qty_Jual = $rowQty - $QtyJual;

            // Build PIB string
            $pib = !empty($row->No_PIB) ? $row->No_PIB_External : "-";
            $No_PIBBeli .= "{$pib}({$QtyJual})";

            // Add comma only if we continue
            if ($row->Qty_Jual > 0 && $QtyJual1 > $QtyJual) {
                $No_PIBBeli .= ", ";
            }

            // Reduce remaining need
            $QtyJual1 -= $QtyJual;

            // Stop if we've fulfilled the required qty
            if ($QtyJual1 <= 0) {
                break;
            }
        }

        $hargaBeliResult = $TotalHargaBeli1 / $jumlah_dikeluarkanTritier;
        $hargaBeliResult = number_format($hargaBeliResult, 4, '.', '');

        // db::connection('ConnSales')->statement(
        //     'exec SP_1273_PRG_UDT_PENJUALAN
        //     @IdTrans = ?,
        //     @Harga = ?,
        //     @NoPIBBeli = ?',
        //     [
        //         $idtransaksi,
        //         $hargaBeliResult,
        //         $No_PIBBeli
        //     ],
        // );

        // foreach ($listJual as $row) {
        //     db::connection('ConnPurchase')->statement(
        //         'exec SP_1273_PRG_UPDATE_HARGA_YTERIMA
        //     @Kode = ?,
        //     @NoTerima = ?,
        //     @Qty = ?',
        //         [
        //             4,
        //             $row->No_terima,
        //             $row->Qty_Terima
        //         ],
        //     );
        // }

        return redirect()->back()->with('success', 'Surat Jalan Sudah Dibuat!');
    }

    //Display the specified resource.
    public function show($id)
    {
        //
    }

    //Show the form for editing the specified resource.
    public function edit($id)
    {
        $jenisPengiriman = db::connection('ConnSales')->select('exec SP_1486_SLS_LIST_JENIS_SJ');
        $customer = db::connection('ConnSales')->select('exec SP_1486_SLS_LIST_CUSTOMER_KIRIM');
        $expeditor = db::connection('ConnSales')->select('exec SP_1486_SLS_LIST_EXPEDITOR @Kode = ?', [1]);
        $DisplayDataHeader = db::connection('ConnSales')->select('exec SP_1486_SLS_LIST_HEADER_PENGIRIMAN @IdPengiriman = ?', [$id]);
        // dd($DisplayDataHeader[0]->IdHeaderKirim);
        for ($i = 0; $i < count($DisplayDataHeader); $i++) {
            $IdHeaderKirim = $DisplayDataHeader[$i]->IdHeaderKirim;
            $DisplayDataDetail = db::connection('ConnSales')->select('exec SP_1486_SLS_LIST_DETAIL_PENGIRIMAN @IDHeaderKirim = ?', [$IdHeaderKirim]);
        }
        // dd($DisplayDataHeader);
        return view('Sales.Transaksi.SuratJalan.Edit', compact('jenisPengiriman', 'customer', 'expeditor', 'DisplayDataHeader', 'DisplayDataDetail'));
    }

    public function getCustomer($id)
    {
        $customer = db::connection('ConnSales')->select('Select * from T_Customer where IDCust = ?', [$id]);
        return response()->json($customer);
    }

    //Update the specified resource in storage.
    public function update(Request $request)
    {
        // dd($request->all(), $request->barang3[0]);
        $Mytype = 2;
        $IdHeaderKirim = $request->id_kirimText;
        $JnsIdPengiriman = $request->jenis_pengiriman;
        $IDPengiriman1 = $request->surat_jalan;
        $IDPengiriman = str_pad($IDPengiriman1, 10, '0', STR_PAD_LEFT);
        // dd($IDPengiriman);
        $IDExpeditor = $request->expeditor;
        $IdCust = $request->customer;
        $TrukNopol = $request->truk_nopol ?? "";
        $Tanggal = $request->tanggal;
        $Biaya = $request->biaya;
        $StatusBiaya = 'N';
        $Keterangan = $request->keterangan ?? "";
        $NoContainer = $request->nomor_container ?? NULL;
        $NoSeal = $request->nomor_seal ?? NULL;
        $NoBL = $request->nomor_bl ?? NULL;
        $TglActual = $request->tanggal_actual;
        $IdDO = $request->barang0;
        $IDSuratPesanan = $request->barang3;
        $AccMgr = trim(Auth::user()->NomorUser);
        //save data header duluu

        db::connection('ConnSales')->statement(
            'exec SP_1273_PRG_MAINT_HEADERPENGIRIMAN
            @Mytype = ?,
            @IdHeaderKirim = ?,
            @JnsIdPengiriman = ?,
            @IDPengiriman = ?,
            @IDExpeditor = ?,
            @IdCust = ?,
            @TrukNopol = ?,
            @Tanggal = ?,
            @Biaya = ?,
            @StatusBiaya = ?,
            @Keterangan = ?,
            @NoContainer = ?,
            @NoSeal = ?,
            @NoBL = ?',
            [
                $Mytype,
                $IdHeaderKirim,
                $JnsIdPengiriman,
                $IDPengiriman,
                $IDExpeditor,
                $IdCust,
                $TrukNopol,
                $Tanggal,
                $Biaya,
                $StatusBiaya,
                $Keterangan,
                $NoContainer,
                $NoSeal,
                $NoBL
            ],
        );

        //save data detail duluu

        for ($i = 0; $i < count($request->barang0); $i++) {
            if ($request->barang0[$i]) {
                db::connection('ConnSales')->statement(
                    'exec SP_1273_PRG_MAINT_DETAILPENGIRIMAN @Mytype = ?,
                @IDHeaderKirim = ?,
                @IdDO = ?,
                @IDSuratPesanan = ?,
                @AccMgr = ?',
                    [
                        $Mytype,
                        $IdHeaderKirim,
                        $IdDO[$i],
                        $IDSuratPesanan[$i],
                        $AccMgr
                    ],
                );
            }
        }
        return redirect()->back()->with('success', 'Surat Jalan ' . $IDPengiriman . ' Sudah Dikoreksi!');
    }

    //Remove the specified resource from storage.
    public function destroy($id)
    {
        // dd($id);
        db::connection('ConnSales')->statement('exec SP_1273_PRG_DEL_PENGIRIMAN @Mytype = ?, @IDHeaderKirim = ?', [1, $id]);
        return redirect()->back()->with('success', 'Surat Jalan ' . $id . ' Sudah Dihapus!');
    }
}
