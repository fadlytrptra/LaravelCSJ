<?php

namespace App\Http\Controllers\Sales\Master;

use Exception;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Sales\Customer;
use App\Models\JnsCust;
use App\Http\Controllers\HakAksesController;
use App\Http\Controllers\Controller;
use Session;

class CustomerController extends Controller
{

    // Display a listing of the resource.
    public function index()
    {
        $model = new Customer;
        $jnscust = db::connection('ConnSales')->select('select * from T_JnsCust');
        $access = (new HakAksesController)->HakAksesFiturMaster('Sales');
        // dd($model);
        //return data to view
        return view('Sales.Master.Customer.Index', compact('access', 'model', 'jnscust'));
    }

    // Show the form for creating a new resource.
    public function create()
    {
        $model = new Customer;
        $jnscust = db::connection('ConnSales')->select('select * from T_JnsCust');
        $access = (new HakAksesController)->HakAksesFiturMaster('Sales');
        // dd($jnscust);
        return view('Sales.Master.Customer.Create', compact('model', 'jnscust', 'access'));
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'KodeCust' => 'required',
            'NamaCust' => 'required',
            'JnsCust' => 'required'
        ]);

        $KodeCust = $request->KodeCust;
        $JnsCust = $request->JnsCust;
        $NamaCust = $request->NamaCust;

        // Check for existing customer
        $existing = DB::connection('ConnSales')
            ->table('T_Customer') // ← replace this with your actual table name
            ->where('KodeCust', $KodeCust)
            ->where('NamaCust', $NamaCust)
            ->where('JnsCust', $JnsCust)
            ->exists();

        if ($existing) {
            return response()->json(['error' => 'Data dengan kombinasi KodeCust, NamaCust, dan JnsCust sudah ada.'], 409);
        }

        $User = Auth::user()->NomorUser;
        $NPWP = $request->NPWP ?? NULL;
        $LimitBeli = $request->LimitBeli ?? 0;
        $ContactPerson = $request->ContactPerson ?? NULL;
        $AlamatKirim = $request->AlamatKirim ?? NULL;
        $Alamat = $request->Alamat ?? NULL;
        $Kota = $request->Kota ?? NULL;
        $Propinsi = $request->Province ?? NULL;
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
        $NamaNPWP = $request->NamaNPWP ?? NULL;
        $AlamatNPWP = $request->AlamatNPWP ?? NULL;
        $KotaKirim = $request->KotaKirim ?? NULL;
        $NITKU = $request->NITKU ?? NULL;

        // dd($request->all());

        try {
            DB::connection('ConnSales')->statement('exec SP_1486_SLS_PROSES_INS_CUSTOMER @KodeCust = ?,
                    @JnsCust = ? ,
                    @NamaCust = ? ,
                    @NPWP = ? ,
                    @LimitBeli = ?,
                    @ContactPerson = ?,
                    @AlamatKirim = ?,
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
                    @Email = ?,
                    @NamaNPWP = ?,
                    @AlamatNPWP = ?,
                    @KotaKirim = ?,
                    @User_id = ?,
                    @NITKU = ?',
                [
                    $KodeCust,
                    $JnsCust,
                    $NamaCust,
                    $NPWP,
                    $LimitBeli,
                    $ContactPerson,
                    $AlamatKirim,
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
                    $Email,
                    $NamaNPWP,
                    $AlamatNPWP,
                    $KotaKirim,
                    $User,
                    $NITKU
                ]
            );
            return response()->json(['success' => 'Data berhasil disimpan!']);
        } catch (Exception $ex) {
            return response()->json(['error' => (string) 'Data gagal disimpan: ' . $ex->getMessage()]);
        }
    }

    //Show the form for editing the specified resource.
    public function edit($id)
    {
        $model = Customer::find($id);
        $jnscust = JnsCust::get();
        // dd($model, $jnscust);
        $jnscust = db::connection('ConnSales')->select('select * from T_JnsCust');
        $access = (new HakAksesController)->HakAksesFiturMaster('Sales');
        return view('Sales.Master.Customer.ModalCustomer', compact('model', 'jnscust', 'access'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'KodeCust' => 'required',
            'NamaCust' => 'required',
        ]);

        // Mendapatkan data dari request dan memberikan nilai default jika null
        $User = Auth::user()->NomorUser;
        $JnsCust = $request->JnsCust ?? NULL;
        $NamaCust = $request->NamaCust;
        $NPWP = $request->NPWP ?? NULL;
        $LimitBeli = $request->LimitBeli ?? 0;
        $ContactPerson = $request->ContactPerson ?? NULL;
        $AlamatKirim = $request->AlamatKirim ?? NULL;
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
        $NamaNPWP = $request->NamaNPWP ?? NULL;
        $AlamatNPWP = $request->AlamatNPWP ?? NULL;
        $KotaKirim = $request->KotaKirim ?? " ";
        $NITKU = $request->NITKU ?? NULL;

        // Eksekusi stored procedure dengan parameter yang diberikan
        DB::connection('ConnSales')->statement('exec SP_1486_SLS_UDT_CUSTOMER
        @IdCust = ?,
        @NamaCust = ?,
        @NPWP = ?,
        @LimitBeli = ?,
        @ContactPerson = ?,
        @AlamatKirim = ?,
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
        @Email = ?,
        @NamaNPWP = ?,
        @AlamatNPWP = ?,
        @KotaKirim = ?,
        @User_id = ?,
        @NITKU = ?',
            [
                $id,
                $NamaCust,
                $NPWP,
                $LimitBeli,
                $ContactPerson,
                $AlamatKirim,
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
                $Email,
                $NamaNPWP,
                $AlamatNPWP,
                $KotaKirim,
                $User,
                $NITKU
            ]
        );

        // Redirect kembali ke halaman sebelumnya dengan pesan sukses
        return response()->json($User);
    }

    // Display the specified resource.
    public function show(Request $request, $id)
    {
        if ($id == 'getallcustomer') {
            $data = DB::connection('ConnSales')->select('exec SP_4384_SLS_MASTER @XKode = ?', [7]);
            return datatables($data)->make(true);
        } else if ($id == 'getCertainCustomer') {
            $idCust = trim(explode('-', $request->input('idCustomer'))[0]);
            $data = Customer::select('*')->join('T_JnsCust', 'IDJnsCust', 'JnsCust')->where('IDCust', $idCust)->first();
            return compact('data');
        }
    }

    // Remove the specified resource from storage.
    public function destroy($id)
    {
        //Update data IsActive
        DB::connection('ConnSales')->statement('exec SP_4384_SLS_MASTER @XKode = ?,
        @XIDCust = ?', [1, $id]);
        return redirect()->route('Customer.index'); //->with(['success' => 'Data berhasil dihapus!']);
    }
}
