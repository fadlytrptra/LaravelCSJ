<?php

namespace App\Http\Controllers\Sales\Penjualan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\HakAksesController;

class ScanBarcodeController extends Controller
{
    //Display a listing of the resource.
    public function index()
    {
        // dd(date('Y-m-d'));
        $date = date('Y-m-d');
        $jumlah = db::connection('ConnInventory')->select('exec SP_1273_INV_jumlah_tmpgudang @Tanggal = ?', [$date]);
        $data_kodeBarang = db::connection('ConnInventory')->select('exec SP_1273_INV_REKAP_YANG_DITEMBAK_DENI @Tanggal = ?', [$date]);
        // dd($date);
        $access = (new HakAksesController)->HakAksesFiturMaster('Sales');
        return view('Sales.Penjualan.ScanBarcode', compact('jumlah', 'data_kodeBarang', 'access'));
    }

    public function scanBarcodeLihatData($date)
    {
        $jumlah = db::connection('ConnInventory')->select('exec SP_1273_INV_jumlah_tmpgudang @Tanggal = ?', [$date]);
        $data_kodeBarang = db::connection('ConnInventory')->select('exec SP_1273_INV_REKAP_YANG_DITEMBAK_DENI @Tanggal = ?', [$date]);
        $data = [$jumlah, $data_kodeBarang];
        return response()->json($data);
    }

    public function scanBarcodeDetailData($idType, $kodeBarang, $tglMutasi)
    {
        $data = db::connection('ConnInventory')->select('exec SP_1273_INV_PERMINTAAN_DENI @IdType = ?, @kode_barang = ?, @Tanggal = ?', [$idType, $kodeBarang, $tglMutasi]);
        return response()->json($data);
    }

    //Show the form for creating a new resource.
    public function create()
    {
        //
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        $barcodeArray = explode(', ', $request->kode_barcode);
        // dd($request->all(), $barcodeArray);
        $barcodeScanBerhasil = [];
        $barcodeScanGagal = [];
        $sudahPernahScan = [];
        $returnAlert = '';

        for ($i = 0; $i < count($barcodeArray); $i++) {
            $kodeBarcode = explode('-', $barcodeArray[$i]);
            $data = db::connection('ConnInventory')->select('exec SP_1273_INV_cek_tmpgudang @indeks = ?, @kdbrg = ?', [(int) $kodeBarcode[0], $kodeBarcode[1]]);
            $status = db::connection('ConnInventory')->select('exec SP_1273_INV_cek_status_tmpgudang @indeks = ?, @kdbrg = ?', [(int) $kodeBarcode[0], $kodeBarcode[1]]);

            if (empty($status)) {
                $status = [(object) ["Status" => "3"]];
            }
            // if ($i == 0) {
            //     dd($i, $status[0]->Status, $data, empty($data));
            // }
            if (empty($data)) {
                if ($status[0]->Status !== "3") {
                    array_push($barcodeScanGagal, $barcodeArray[$i]);
                    continue;
                }
                // dd($kodeBarcode[0], trim($kodeBarcode[1]));

                // db::connection('ConnInventory')->statement('exec SP_1273_INV_insert_tmpgudang @indeks = ?, @kdbrg = \'?\'', [$kodeBarcode[0], trim($kodeBarcode[1])]);

                $indeks = $kodeBarcode[0];
                $kdbrg = trim($kodeBarcode[1]);

                $result = DB::connection('ConnInventory')
                    ->table('dispresiasi')
                    ->select('Id_type_tujuan')
                    ->where('NoIndeks', $indeks)
                    ->where('Kode_barang', $kdbrg)
                    ->first();

                // $result now contains the value of Id_type_tujuan from the dispresiasi table
                $idTypeTujuan = $result->Id_type_tujuan;
                $tglMutasi = now()->format('Y-m-d');

                DB::connection('ConnInventory')
                    ->table('Tmp_Gudang')
                    ->insert([
                        'NoIndeks' => $indeks,
                        'Kode_barang' => $kdbrg,
                        'Tgl_mutasi' => $tglMutasi,
                        'IdType' => $idTypeTujuan,
                        'aktif' => 'Y',
                        'TypeTransaksi' => '09'
                    ]);

                array_push($barcodeScanBerhasil, $barcodeArray[$i]);
            } else {
                array_push($sudahPernahScan, $barcodeArray[$i]);
            }
        }

        // dd($barcodeScanBerhasil, $barcodeScanGagal, $sudahPernahScan);
        if (!empty($barcodeScanBerhasil)) {
            $returnAlert .= "Barcode yang berhasil discan: " . implode(', ', $barcodeScanBerhasil) . "<br>";
        }
        if (!empty($barcodeScanGagal)) {
            $returnAlert .= "Barcode yang gagal discan: " . implode(', ', $barcodeScanGagal) . "<br>";
        }
        if (!empty($sudahPernahScan)) {
            $returnAlert .= "Barcode yang sudah discan: " . implode(',', $sudahPernahScan);
        }
        return redirect()->back()->with('success', $returnAlert);
        // $indeks = $request->nomor_indeks;
        // $kodeBarang = $request->kode_barang;
        // $data = db::connection('ConnInventory')->select('exec SP_1273_INV_cek_tmpgudang @indeks = ?, @kdbrg = ?', [$indeks, $kodeBarang]);
        // $status = db::connection('ConnInventory')->select('SP_1273_INV_cek_status_tmpgudang @indeks = ?, @kdbrg = ?', [$indeks, $kodeBarang]);
        // dd($status[0]->Status !== "3");
        // if (empty($status)) {
        //     $status = "3";
        // }
        // if (empty($data)) {
        //     if ($status[0]->Status !== "3") {
        //         return redirect()->back()->with('error', 'Barang Belum Diterima Gudang!');
        //     }
        //     db::connection('ConnInventory')->statement('exec SP_1273_INV_insert_tmpgudang @indeks = ?, @kdbrg = ?', [$indeks, $kodeBarang]);
        //     return redirect()->back()->with('success', 'Barcode Berhasil Diproses!');
        // } else {
        //     return redirect()->back()->with('success', 'Barang Sudah Masuk!');
        // }
    }

    //Display the specified resource.
    public function show($id)
    {
        //
    }

    //Show the form for editing the specified resource.
    public function edit($id)
    {
        //
    }

    //Update the specified resource in storage.
    public function update($id)
    {

    }

    //Remove the specified resource from storage.
    public function destroy($id)
    {
        //
    }
}
