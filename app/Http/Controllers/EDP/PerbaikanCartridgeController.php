<?php

namespace App\Http\Controllers\EDP;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\EDP\PerbaikanCartridge;
use App\Models\EDP\NotaPerbaikanCartridge;
use App\Models\EDP\JenisPerbaikanCartridge;
use App\User;
use DB;
use App\Http\Controllers\HakAksesController;
use App\Http\Controllers\Controller;


class PerbaikanCartridgeController extends Controller
{
     public function index()
    {
        $CartridgeService = NotaPerbaikanCartridge::select()->get();
        $Cartridge = PerbaikanCartridge::select()->join("ListCartridge","ListCartridge.id","=","IdCartridge")->get();
        $access = (new HakAksesController)->HakAksesFiturMaster('EDP');
        return view('EDP.Perbaikan.Cartridge.List',compact('CartridgeService','Cartridge', 'access'));
    }

    public function store(Request $request)
    {

        $AddNota = new NotaPerbaikanCartridge([
            'NoNota' => $request->get('NoNota'),
            'Tanggal' => $request->get('TglRefill'),
          ]);
          $AddNota->save();
          $id = NotaPerbaikanCartridge::where('NoNota',$request->get('NoNota'))->value('id');

          return redirect()->route('perbaikancartridge.show', [$id]);
    }
    public function AddRefill(Request $request, $id)
    {
        // dd($id);
        $AddRefill = new PerbaikanCartridge([
            'IdNotaCartridge' => $id,
            'IdCartridge' => $request->get('cartridge'),
            'IdPerbaikan' => $request->get('service'),
          ]);
          $AddRefill->save();

        return back();
    }
    public function AddService(Request $request)
    {
        $AddService = new JenisPerbaikanCartridge([
            'perbaikan' => $request->get('Service'),
          ]);
          $AddService->save();

          return back();
    }

    public function show($id)
    {
        $Cartridge = PerbaikanCartridge::select('ListCartridge.*','JenisPerbaikanCartridge.*','IdCartridge','IdPerbaikan')->join('ListCartridge','IdCartridge','ListCartridge.id')->join('JenisPerbaikanCartridge','IdPerbaikan','JenisPerbaikanCartridge.id')->where('IdNotaCartridge',$id)->get();
        $Nota = NotaPerbaikanCartridge::where('id',$id)->first();
        $Service = JenisPerbaikanCartridge::select()->get();
        $access = (new HakAksesController)->HakAksesFiturMaster('EDP');
        return view('EDP.Perbaikan.Cartridge.AddPerbaikan',compact('Nota','Service','id','Cartridge','access'));
    }

    public function DetailRefill($id)
    {
        $item=PerbaikanCartridge::select('Type','perbaikan',DB::raw('count(*) as total'))->join('ListCartridge','IdCartridge','ListCartridge.id')->join('JenisPerbaikanCartridge','IdPerbaikan','JenisPerbaikanCartridge.id')->where('IdNotaCartridge',$id)->groupby("Type")->groupby("perbaikan")->get();
        $Cartridge = PerbaikanCartridge::select('ListCartridge.*','JenisPerbaikanCartridge.*','IdCartridge','IdPerbaikan')->join('ListCartridge','IdCartridge','ListCartridge.id')->join('JenisPerbaikanCartridge','IdPerbaikan','JenisPerbaikanCartridge.id')->where('IdNotaCartridge',$id)->get();
        $Nota = NotaPerbaikanCartridge::where('id',$id)->first();
        //$Service = JenisPerbaikanCartridge::select()->get();

        return compact('item');
    }

    public function update(Request $request, $id)
    {
        NotaPerbaikanCartridge::where('id', $id)->update(['NoNota' => $request->get('EditNoNota'), 'Tanggal' => $request->get('EditTglRefill')]);
        return back();
    }


    public function DelCartridgeRefill($id,$IdCartridge,$IdPerbaikan)
    {
        //dd($id,$IdCartridge,$IdPerbaikan);
        PerbaikanCartridge::where('IdNotaCartridge', $id)->where('IdCartridge', $IdCartridge)->where('IdPerbaikan', $IdPerbaikan)->delete();

        return back();
    }

    public function destroy($id)
    {
        $HapusBarang = Barang::find($id);
        $HapusBarang->status = "Dihapus";
        $HapusBarang->save();



        return back();
    }
}
