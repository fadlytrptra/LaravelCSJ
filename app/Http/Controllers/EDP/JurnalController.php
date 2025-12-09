<?php

namespace App\Http\Controllers\EDP;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\EDP\Jurnal;
use App\Models\EDP\JurnalKategori;
use App\Models\EDP\JurnalKelompok;
use App\Models\EDP\PersonilEDP;
use App\User;
use DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HakAksesController;

class JurnalController extends Controller
{
     public function index()
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('EDP');
        $result = (new HakAksesController)->HakAksesFitur('Jurnal');
        if($result==true)
        {
            $data = Jurnal::select()->join('UserMaster','Pelapor','IDUser')->join('Jurnal_Kategori','IdKategori','Id_Kategori')->join('Personil_EDP','Id_Personil','Id_PersonilJurnal')->where('KodeUser',Auth::user()->NomorUser)->get();
            $user = DB::connection('ConnEDP')->table('UserMaster')->get();
            $kategori = JurnalKategori::select()->get();
            return view('EDP.Jurnal.List',compact('data','user','kategori','access'));
        }
        else
        {
            $result = (new HakAksesController)->HakAksesFitur('JurnalMaster');
            if($result==true)
            {
                $data = Jurnal::select()->join('UserMaster','Pelapor','IDUser')->join('Jurnal_Kategori','IdKategori','Id_Kategori')->join('Personil_EDP','Id_Personil','Id_PersonilJurnal')->where('Id_Kelompok',null)->get();
                $dataKelompok = Jurnal::select()->join('UserMaster','Pelapor','IDUser')->join('Jurnal_Kategori','IdKategori','Id_Kategori')->join('Personil_EDP','Id_Personil','Id_PersonilJurnal')->where('Id_Kelompok','!=',null)->get();
                $user = DB::connection('ConnEDP')->table('UserMaster')->get();
                $kategori = JurnalKategori::select()->get();
                $kelompok = JurnalKelompok::select()->get();
                $personil = PersonilEDP::select()->where('IsActive','true')->get();
                return view('EDP.Jurnal.ListMaster',compact('data','user','kategori','kelompok','personil','dataKelompok','access'));
            }
            else
            {
                abort(403);
            }
        }

    }

    public function store(Request $request)
    {
        $getIdUser=DB::connection('ConnEDP')->table('Personil_EDP')->where('KodeUser',Auth::user()->NomorUser)->value('Id_Personil');


        $AddJurnal = new Jurnal([
            'Id_PersonilJurnal' => $getIdUser,
            'Tgl_Lapor' => $request->get('TglLapor'),
            'Tgl_Selesai' => $request->get('TglSelesai'),
            'Pelapor' => "".strtoupper($request->get('Pelapor'))."",
            'Id_Kategori' => $request->get('Kategori'),
            'Id_Kelompok' => $request->get('Kelompok'),
            'DetailPermasalahan' => "".strtoupper($request->get('DetailMasalah'))."",
            'Solusi' => "".strtoupper($request->get('Solusi'))."",
          ]);
          $AddJurnal->save();

          return Back();
    }

    public function storeKelompok(Request $request)
    {
        $AddKelompok = new JurnalKelompok([
            'Kelompok' => strtoupper($request->get('Kelompok')),
          ]);
          $AddKelompok->save();

          return Back();
    }

    public function storeKategori(Request $request)
    {
        $AddKategori = new JurnalKategori([
            'Kategori' => strtoupper($request->get('Kategori')),
          ]);
          $AddKategori->save();

          return Back();
    }

    public function show($id)
    {
        $data = Jurnal::select()->join('UserMaster','Pelapor','IDUser')->join('Jurnal_Kategori','IdKategori','Id_Kategori')->join('Personil_EDP','Id_Personil','Id_PersonilJurnal')->where('IdJurnal',$id)->first();
        return compact('data');
    }

    public function update(Request $request, $id)
    {
        $CheckKategori=JurnalKategori::select()->where('Kategori',"".strtoupper($request->get('EditKategori'))."")->count();
        if($CheckKategori==0)
        {
            $AddJurnalKategori = new JurnalKategori([
                'Kategori' => "".strtoupper($request->get('EditKategori'))."",
            ]);
            $AddJurnalKategori->save();
        }

        $getIdUser=DB::connection('ConnEDP')->table('Personil_EDP')->where('KodeUser',Auth::user()->NomorUser)->value('Id_Personil');
        $getIdKategori=JurnalKategori::select()->where('Kategori',"".strtoupper($request->get('EditKategori'))."")->value('IdKategori');

        $UpdateJurnal = Jurnal::find($id);
        $UpdateJurnal->Tgl_Lapor = $request->get('EditTglLapor');
        $UpdateJurnal->Tgl_Selesai = $request->get('EditTglSelesai');
        $UpdateJurnal->Pelapor = "".strtoupper($request->get('EditPelapor'))."";
        $UpdateJurnal->Id_Kategori = $getIdKategori;
        $UpdateJurnal->DetailPermasalahan = "".strtoupper($request->get('EditDetailMasalah'))."";
        $UpdateJurnal->Solusi = "".strtoupper($request->get('EditSolusi'))."";

        $UpdateJurnal->save();

        return back();
    }

    public function updateKategori(Request $request, $id)
    {
        // dd($request->get('EditKategori1'));
        $UpdateKategori = JurnalKategori::find($id);
        $UpdateKategori->Kategori = "".strtoupper($request->get('EditKategori1'))."";
        $UpdateKategori->save();

        return back();
    }

    public function updateKelompok(Request $request, $id)
    {
        // dd($request->get('EditKategori1'));
        $UpdateKelompok = JurnalKelompok::find($id);
        $UpdateKelompok->Kelompok = "".strtoupper($request->get('EditKelompok1'))."";
        $UpdateKelompok->save();

        return back();
    }

    public function InputKelompok(Request $request, $id)
    {
        $UpdateJurnal = Jurnal::find($id);
        $UpdateJurnal->Id_Kelompok = $request->get('EditKelompok');

        $UpdateJurnal->save();

        return back();
    }

    public function destroy($id)
    {
        $DestroyJurnal=Jurnal::find($id);
        $DestroyJurnal->delete();

        return back();
    }

    public function Filter($tglAwal,$tglAkhir)
    {
        // $dataKelompok = Jurnal::select('Id_Kelompok')->where('Id_Kelompok','!=',null)->where('Tgl_Lapor','>=',$tglAwal)->where('Tgl_Lapor','<=',$tglAkhir)->groupby("Id_Kelompok")->get();
        $kelompok = JurnalKelompok::select()->get();
        $data = Jurnal::select()->join('UserMaster','Pelapor','IDUser')->join('Jurnal_Kategori','IdKategori','Id_Kategori')->join('Personil_EDP','Id_Personil','Id_PersonilJurnal')->where('Id_Kelompok','!=',null)->where('Tgl_Lapor','>=',$tglAwal)->where('Tgl_Lapor','<=',$tglAkhir)->get();
        return compact('data','kelompok');
    }

}
