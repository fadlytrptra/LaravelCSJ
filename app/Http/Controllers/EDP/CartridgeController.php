<?php

namespace App\Http\Controllers\EDP;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\EDP\Cartridge;
use App\User;
use App\Http\Controllers\HakAksesController;
use App\Http\Controllers\Controller;


class CartridgeController extends Controller
{
    public function index()
    {
        $data = Cartridge::select()->get();
        $maxid = Cartridge::max('id') + 1;
        $User = Cartridge::select('User')->groupBy('User')->get();
        $Type = Cartridge::select('Type')->groupBy('Type')->get();
        $access = (new HakAksesController)->HakAksesFiturMaster('EDP');
        return view('EDP.Master.Cartridge.List', compact('data', 'maxid', 'User', 'Type', 'access'));
    }

    public function store(Request $request)
    {
        $AddCartridge = new Cartridge([
            'User' => strtoupper($request->get('user')),
            'Type' => strtoupper($request->get('type')),
        ]);
        $AddCartridge->save();

        return Back();
    }
    public function show($id)
    {

    }

    public function update(Request $request, $id)
    {
        $UpdateCartridge = Cartridge::find($id);

        $UpdateCartridge->User = strtoupper($request->get('userEdit'));
        $UpdateCartridge->Type = strtoupper($request->get('typeEdit'));
        $UpdateCartridge->save();

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
