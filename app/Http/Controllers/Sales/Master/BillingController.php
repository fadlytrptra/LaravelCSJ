<?php

namespace App\Http\Controllers\Sales\Master;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Sales\Billing;
use App\Http\Controllers\Controller;
use DB;
use App\Http\Controllers\HakAksesController;

class BillingController extends Controller
{

    //Display a listing of the resource.
    public function index()
    {
        $data = Billing::get()->where('IsActive', 1);
        $access = (new HakAksesController)->HakAksesFiturMaster('Sales');
        return view('Sales.Master.Billing.Index', compact('data', 'access'));
    }

    //Show the form for creating a new resource.
    public function create()
    {
        $model = new Billing;
        $access = (new HakAksesController)->HakAksesFiturMaster('Sales');
        return view('Sales.Master.Billing.Create', compact('model', 'access'));
    }

    //Store a newly created resource in storage.
    public function store(Request $request)
    {
        $request->validate([
            'NamaBill' => 'required',
        ]);
        $User = Auth::user()->NomorUser;
        $NamaBill = $request->NamaBill ?? NULL;
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
        $noTelex = $request->noTelex ?? NULL;
        $email = $request->email ?? NULL;

        DB::connection('ConnSales')->statement('exec SP_1486_SLS_PROSES_INS_BILLING @NamaBill = ?,
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
        @noTelex = ?,
        @email = ?', [
            $NamaBill,
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
            $noTelex,
            $email
        ]);
        echo "<script type='text/javascript'>alert('Data Berhasil disimpan') ;</script>";
        echo "<script type='text/javascript'>window.close() ;</script>";
        //echo "<script type='text/javascript'>alert('Data Berhasil di Simpan') ;</script>";

    }

    //Display the specified resource.
    public function show($id)
    {
        $data = Billing::select('*')->where('IDBill', $id)->first();
        $access = (new HakAksesController)->HakAksesFiturMaster('Sales');
        return compact('data', 'access');
    }

    //Show the form for editing the specified resource.
    public function edit($id)
    {
        $model = Billing::find($id);
        $access = (new HakAksesController)->HakAksesFiturMaster('Sales');
        return view('Sales.Master.Billing.edit', compact('model', 'access'));
    }

    //Update the specified resource in storage.
    public function update(Request $request, $id)
    {
        $request->validate([
            'NamaBill' => 'required',
        ]);
        $User = Auth::user()->NomorUser;
        $NamaBill = $request->NamaBill ?? NULL;
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
        $noTelex = $request->noTelex ?? NULL;
        $email = $request->email ?? NULL;

        DB::connection('ConnSales')->statement('exec SP_1486_SLS_UDT_BILLING @IDBill = ?,
        @NamaBill = ?,
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
        @noTelex = ?,
        @email = ?', [
            $id,
            $NamaBill,
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
            $noTelex,
            $email
        ]);
        echo "<script type='text/javascript'>alert('Data Berhasil diubah') ;</script>";
        echo "<script type='text/javascript'>window.close() ;</script>";
    }

    //Remove the specified resource from storage.
    public function destroy($id)
    {
        DB::connection('ConnSales')->statement('exec SP_4384_SLS_MASTER @XKode = ?,
        @XIDBill = ?', [3, $id]);
        echo "<script type='text/javascript'>alert('Data Berhasil dihapus') ;</script>";
        return redirect()->route('Billing.index'); //->with(['success' => 'Data berhasil dihapus!']);
    }
}
