<?php

namespace App\Http\Controllers\Accounting\Informasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\HakAksesController;


class CetakNotaKreditController extends Controller
{
    public function index()
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('Accounting');
        return view('Accounting.Informasi.CetakNotaKredit', compact('access'));
    }

    public function getListCetakNotaKredit($tanggal)
    {
        $tabel =  DB::connection('ConnAccounting')->select('exec [SP_LIST_CETAK_NotaKredit] @Kode = ?, @Tanggal = ?', [5, $tanggal]);
        return response()->json($tabel);
    }

    public function getIdSuratJalanNotaKredit($notaKredit)
    {
        $tabel =  DB::connection('ConnAccounting')->select('exec [SP_LIST_CETAK_NotaKredit] @Kode = ?, @ID_NOTAKREDIT = ?', [6, $notaKredit]);
        return response()->json($tabel);
    }

    public function getDisplayDetailNotaKredit($notaKredit)
    {
        $tabel =  DB::connection('ConnAccounting')->select('exec [SP_LIST_CETAK_NOTAKREDIT] @Kode = ?, @ID_NOTAKREDIT = ?', [12, $notaKredit]);
        return response()->json($tabel);
    }

    public function getSFilter1($notaKredit)
    {
        //dd($idBKM);
        $data = DB::connection('ConnAccounting')->table('vw_prg_cetak_nota_kredit')
            ->where('Id_NotaKredit', $notaKredit)
            ->get();
        return $data;
    }

    public function getSFilter2($notaKredit)
    {
        //dd($idBKM);
        $data = DB::connection('ConnAccounting')->table('vw_Prg_Cetak_Pot_Harga')
            ->where('Id_NotaKredit', $notaKredit)
            ->get();
        return $data;
    }

    public function getSFilter3($notaKredit)
    {
        //dd($idBKM);
        $data = DB::connection('ConnAccounting')->table('vw_prg_Cetak_Nota_Kredit_Free')
            ->where('Id_NotaKredit', $notaKredit)
            ->get();
        return $data;
    }

    public function getSFilter4($notaKredit)
    {
        //dd($idBKM);
        $data = DB::connection('ConnAccounting')->table('vw_prg_Cetak_Selisih_Timbang')
            ->where('Id_NotaKredit', $notaKredit)
            ->get();
        return $data;
    }

    //Show the form for creating a new resource.
    public function create()
    {
        //
    }

    //Store a newly created resource in storage.
    public function store(Request $request)
    {
        //
    }

    //Display the specified resource.
    public function show($id, Request $request)
    {
        $id_penagihan = trim($request->input('id_penagihan'));
        // dd($request->all());

        if ($id === 'getCustomer') {
            $tanggal = trim($request->input('tanggal'));

            $data = DB::connection('ConnAccounting')->select('exec [SP_LIST_CETAK_NotaKredit] @Kode = 5, @Tanggal = ?', [$tanggal]);
            // dd($data);
            $data_isi = [];
            foreach ($data as $detail_isi) {
                $data_isi[] = [
                    'Id_NotaKredit' => $detail_isi->Id_NotaKredit,
                    'NamaCust' => $detail_isi->NamaCust
                ];
            }
            return datatables($data_isi)->make(true);

        } else if ($id === 'getSuratJalan') {
            $data =  DB::connection('ConnAccounting')->select('exec [SP_LIST_CETAK_NOTAKREDIT] @Kode = 6, @ID_NOTAKREDIT = ?', [$id_penagihan]);
            // dd($data);
            return response()->json($data);

        } else if ($id === 'getDetil') {
            $data =  DB::connection('ConnAccounting')->select('exec [SP_LIST_CETAK_NOTAKREDIT] @Kode = 12, @ID_NOTAKREDIT = ?', [$id_penagihan]);
            // dd($data);

            $data_isi = [];
            foreach ($data as $detail_isi) {
                $data_isi[] = [
                    'Status_PPN' => $detail_isi->Status_PPN,
                    'JnsNotaKredit' => $detail_isi->JnsNotaKredit
                ];
            }
            return response()->json($data);
        }

        else if ($id === 'notaKreditPPN') {
            $data = DB::connection('ConnAccounting')->select("SELECT * FROM vw_prg_cetak_nota_kredit WHERE Id_NotaKredit = ?", [$id_penagihan]);
            // dd($data);

            $data_isi = [];
            foreach ($data as $detail_isi) {
                $data_isi[] = [
                    'Id_NotaKredit' => $detail_isi->Id_NotaKredit,
                    'Tanggal' => $detail_isi->Tanggal,
                    'NamaNPWP' => $detail_isi->NamaNPWP,
                    'AlamatNPWP' => $detail_isi->AlamatNPWP,
                    'NPWP' => $detail_isi->NPWP,
                    'NamaCust' => $detail_isi->NamaCust,
                    'Alamat' => $detail_isi->Alamat,
                    'Kota' => $detail_isi->Kota,
                    'Id_Penagihan' => $detail_isi->Id_Penagihan,
                    'IdFakturPajak' => $detail_isi->IdFakturPajak,
                    'IDSuratPesanan' => $detail_isi->IDSuratPesanan,
                    'NamaBarang' => $detail_isi->NamaBarang,
                    'QTyKonversi' => $detail_isi->QTyKonversi,
                    'SatuanJual' => $detail_isi->SatuanJual,
                    'HargaSatuan' => $detail_isi->HargaSatuan,
                    'NO_PO' => $detail_isi->NO_PO,
                    'NAMATYPEBARANG' => $detail_isi->NAMATYPEBARANG,
                    'Tgl_Penagihan' => $detail_isi->Tgl_Penagihan,
                    'NilaiKurs' => $detail_isi->NilaiKurs,
                    'Terbilang' => $detail_isi->Terbilang,
                    'Nilai' => $detail_isi->Nilai,
                    'SuratJalan' => $detail_isi->SuratJalan,
                    'TglFakturPajak' => $detail_isi->TglFakturPajak
                ];
            }

            return response()->json($data);
        }

        else if ($id === 'notaPotHargaPPN') {
            // VIEW TIDAK DAPAT DI AKSES
            $data = DB::connection('ConnAccounting')->select("SELECT * FROM vw_Prg_Cetak_Pot_Harga} WHERE Id_NotaKredit = ?", [$id_penagihan]);
            dd($data);

            $data_isi = [];
            foreach ($data as $detail_isi) {
                $data_isi[] = [
                    'Status_PPN' => $detail_isi->Status_PPN,
                    'JnsNotaKredit' => $detail_isi->JnsNotaKredit
                ];
            }
            return response()->json($data);
        }


        else if ($id === 'notaFreePPN') {
            // VIEW TIDAK DAPAT DI AKSES
            $data = DB::connection('ConnAccounting')->select("SELECT * FROM vw_prg_Cetak_Nota_Kredit_Free} WHERE Id_NotaKredit = ?", [$id_penagihan]);
            dd($data);

            $data_isi = [];
            foreach ($data as $detail_isi) {
                $data_isi[] = [
                    'Status_PPN' => $detail_isi->Status_PPN,
                    'JnsNotaKredit' => $detail_isi->JnsNotaKredit
                ];
            }
            return response()->json($data);
        }

        else if ($id === 'notaSelisihPPN') {
            $data = DB::connection('ConnAccounting')->select("SELECT * FROM vw_prg_Cetak_Selisih_Timbang} WHERE Id_NotaKredit = ?", [$id_penagihan]);
            dd($data);

            $data_isi = [];
            foreach ($data as $detail_isi) {
                $data_isi[] = [
                    'Status_PPN' => $detail_isi->Status_PPN,
                    'JnsNotaKredit' => $detail_isi->JnsNotaKredit
                ];
            }
            return response()->json($data);
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
        //
    }

    //Remove the specified resource from storage.
    public function destroy($id)
    {
        //
    }
}
