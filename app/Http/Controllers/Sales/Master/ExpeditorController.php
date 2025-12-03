<?php

namespace App\Http\Controllers\Sales\Master;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Sales\Expeditor;
use DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HakAksesController;

class ExpeditorController extends Controller
{

    //Display a listing of the resource.
    public function index()
    {
        //get all data active expeditor
        $data = Expeditor::get()->where('IsActive', 1);
        $access = (new HakAksesController)->HakAksesFiturMaster('Sales');
        // return to view
        return view('Sales.Master.Expeditor.Index', compact('data', 'access'));
    }

    //Show the form for creating a new resource.
    public function create()
    {
        $model = new Expeditor;
        $access = (new HakAksesController)->HakAksesFiturMaster('Sales');
        return view('Sales.Master.Expeditor.Create', compact('model', 'access'));
    }

    //Store a newly created resource in storage.
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'NamaExpeditor' => 'required',
        ]);
        $User = Auth::user()->NomorUser;
        $Kode = 1;
        $NamaExpeditor = $request->NamaExpeditor ?? NULL;
        $ContactPerson = $request->ContactPerson ?? NULL;
        $Alamat = $request->Alamat ?? NULL;
        $Kota = $request->Kota ?? NULL;
        $Propinsi = $request->Propinsi ?? NULL;
        $Negara = $request->Negara ?? NULL;
        $KodePos = $request->KodePos ?? NULL;
        $NoTelp1 = $request->NoTelp1 ?? NULL;
        $NoTelp2 = $request->NoTelp2 ?? NULL;
        $NoFax1 = $request->NoFax1 ?? NULL;
        $NoFax2 = $request->NoFax2 ?? NULL;
        $NoHp1 = $request->NoHp1 ?? NULL;
        $NoHp2 = $request->NoHp2 ?? NULL;
        $NoTelex = $request->NoTelex ?? NULL;
        $Email = $request->Email ?? NULL;

        DB::connection('ConnSales')->statement('exec SP_1486_SLS_MAINT_EXPEDITOR
            @Kode = ?,
            @NamaExpeditor = ?,
            @ContactPerson = ?,
            @Alamat = ?,
            @Kota = ?,
            @Propinsi = ?,
            @Negara = ?,
            @KodePos = ?,
            @NoTelp1 = ?,
            @NoTelp2 = ?,
            @NoFax1 = ?,
            @NoFax2 = ?,
            @NoHp1 = ?,
            @NoHp2 = ?,
            @NoTelex = ?,
            @Email = ?',
            [
                $Kode,
                $NamaExpeditor,
                $ContactPerson,
                $Alamat,
                $Kota,
                $Propinsi,
                $Negara,
                $KodePos,
                $NoTelp1,
                $NoTelp2,
                $NoFax1,
                $NoFax2,
                $NoHp1,
                $NoHp2,
                $NoTelex,
                $Email
            ]
        );
        echo "<script type='text/javascript'>alert('Data Berhasil disimpan') ;</script>";
        echo "<script type='text/javascript'>window.close() ;</script>";
    }

    //Display the specified resource.
    public function show($id)
    {
        $data = Expeditor::select('*')->where('IDBill', $id)->first();

        return compact('data');
    }

    //Show the form for editing the specified resource.
    public function edit($id)
    {
        $model = Expeditor::find($id);
        // dd($model);
        $access = (new HakAksesController)->HakAksesFiturMaster('Sales');
        return view('Sales.Master.Expeditor.edit', compact('model', 'access'));
    }

    //Update the specified resource in storage.
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'NamaExpeditor' => 'required',
        ]);
        $User = Auth::user()->NomorUser;
        $Kode = 2;
        $NamaExpeditor = $request->NamaExpeditor ?? NULL;
        $IDExpeditor = $request->KodeExpeditor ?? NULL;
        $ContactPerson = $request->ContactPerson ?? NULL;
        $Alamat = $request->Alamat ?? NULL;
        $Kota = $request->Kota ?? NULL;
        $Propinsi = $request->Propinsi ?? NULL;
        $Negara = $request->Negara ?? NULL;
        $KodePos = $request->KodePos ?? NULL;
        $NoTelp1 = $request->NoTelp1 ?? NULL;
        $NoTelp2 = $request->NoTelp2 ?? NULL;
        $NoFax1 = $request->NoFax1 ?? NULL;
        $NoFax2 = $request->NoFax2 ?? NULL;
        $NoHp1 = $request->NoHp1 ?? NULL;
        $NoHp2 = $request->NoHp2 ?? NULL;
        $NoTelex = $request->NoTelex ?? NULL;
        $Email = $request->Email ?? NULL;

        DB::connection('ConnSales')->statement('exec SP_1486_SLS_MAINT_EXPEDITOR
            @Kode = ?,
            @IDExpeditor = ?,
            @NamaExpeditor = ?,
            @ContactPerson = ?,
            @Alamat = ?,
            @Kota = ?,
            @Propinsi = ?,
            @Negara = ?,
            @KodePos = ?,
            @NoTelp1 = ?,
            @NoTelp2 = ?,
            @NoFax1 = ?,
            @NoFax2 = ?,
            @NoHp1 = ?,
            @NoHp2 = ?,
            @NoTelex = ?,
            @Email = ?',
            [
                $Kode,
                $IDExpeditor,
                $NamaExpeditor,
                $ContactPerson,
                $Alamat,
                $Kota,
                $Propinsi,
                $Negara,
                $KodePos,
                $NoTelp1,
                $NoTelp2,
                $NoFax1,
                $NoFax2,
                $NoHp1,
                $NoHp2,
                $NoTelex,
                $Email
            ]
        );
        echo "<script type='text/javascript'>alert('Data Berhasil diubah') ;</script>";
        echo "<script type='text/javascript'>window.close() ;</script>";
    }

    //Remove the specified resource from storage.
    public function destroy($id)
    {
        DB::connection('ConnSales')->statement('exec SP_4384_SLS_MASTER @XKode = ?,
        @XIDExpeditor = ?', [5, $id]);
        echo "<script type='text/javascript'>alert('Data Berhasil dihapus') ;</script>";
        return redirect()->route('Expeditor.index');
    }
}
