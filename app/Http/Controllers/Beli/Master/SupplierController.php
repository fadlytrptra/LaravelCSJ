<?php

namespace App\Http\Controllers\Beli\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Exception;
use Session;
use App\Http\Controllers\HakAksesController;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        $matauang = DB::connection('ConnPurchase')->select('exec SP_7775_PBL_LIST_MATA_UANG');
        $access = (new HakAksesController)->HakAksesFiturMaster('Beli');
        return view('Beli.Master.Supplier.Index', compact('access', 'matauang'));
    }

    public function getSupplier($id)
    {
        $data = DB::connection('ConnPurchase')->select('exec SP_1273_PBL_LIST_SUPPLIER @kd = ?, @idSup = ?', [1, $id]);
        return response()->json($data);
    }

    //Show the form for creating a new resource.
    public function create()
    {
        $supplier = DB::connection('ConnPurchase')->select('exec SP_4384_PBL_Maintenance_Supplier @XKode = ?', [0]);
        $matauang = DB::connection('ConnPurchase')->select('exec SP_7775_PBL_LIST_MATA_UANG');
        $access = (new HakAksesController)->HakAksesFiturMaster('Beli');
        return view('Beli.Master.Supplier.Create', compact('supplier', 'matauang', 'access'));
    }

    //Store a newly created resource in storage.
    public function store(Request $request)
    {
        //     $data = [
        //         'kd' => $request->kode ?? NULL,
        //         'Xno_sup' => $request->supplier_id ?? NULL,
        //         'Xnm_sup' => $request->supplier_text ?? NULL,
        //         'Xperson1' => $request->contact_person1 ?? NULL,
        //         'Xperson2' => $request->contact_person2 ?? NULL,
        //         'Xtlp1' => $request->phone1 ?? NULL,
        //         'Xtlp2' => $request->phone2 ?? NULL,
        //         'Xhphone1' => $request->mobile_phone1 ?? NULL,
        //         'Xhphone2' => $request->mobile_phone2 ?? NULL,
        //         'Xtelex1' => $request->email1 ?? NULL,
        //         'Xtelex2' => $request->email2 ?? NULL,
        //         'Xalamat1' => $request->alamat1 ?? NULL,
        //         'Xalamat2' => $request->alamat2 ?? NULL,
        //         'Xkota1' => $request->kota1 ?? NULL,
        //         'Xkota2' => $request->kota2 ?? NULL,
        //         'Xfax1' => $request->fax1 ?? NULL,
        //         'Xfax2' => $request->fax2 ?? NULL,
        //         'Xnegara1' => $request->negara1 ?? NULL,
        //         'Xnegara2' => $request->negara2 ?? NULL,
        //         'IdUang' => $request->mata_uang ?? 0,
        //         'jnSup' => ($request->mata_uang ?? 0) == 1 ? '01' : '02',
        //     ];

        //     DB::connection('ConnPurchase')->statement("
        //     EXEC SP_5409_PBL_SUPPLIER
        //         @kd = :kd,
        //         @Xno_sup = :Xno_sup,
        //         @Xnm_sup = :Xnm_sup,
        //         @Xperson1 = :Xperson1,
        //         @Xperson2 = :Xperson2,
        //         @Xtlp1 = :Xtlp1,
        //         @Xtlp2 = :Xtlp2,
        //         @Xhphone1 = :Xhphone1,
        //         @Xhphone2 = :Xhphone2,
        //         @Xtelex1 = :Xtelex1,
        //         @Xtelex2 = :Xtelex2,
        //         @Xalamat1 = :Xalamat1,
        //         @Xalamat2 = :Xalamat2,
        //         @Xkota1 = :Xkota1,
        //         @Xkota2 = :Xkota2,
        //         @Xfax1 = :Xfax1,
        //         @Xfax2 = :Xfax2,
        //         @Xnegara1 = :Xnegara1,
        //         @Xnegara2 = :Xnegara2,
        //         @IdUang = :IdUang,
        //         @jnSup = :jnSup
        // ", $data);

        //     $kd = $data['kd'];
        //     $supplier_id = $data['Xno_sup'];

        //     if ($kd == 2) {
        //         return redirect()->back()->with('success', 'Data sudah tersimpan.');
        //     } else if ($kd == 3) {
        //         return redirect()->back()->with('success', 'Data Id Supplier ' . $supplier_id . ' sudah disimpan.');
        //     } else {
        //         return redirect()->back()->with('success', 'Data Id Supplier ' . $supplier_id . ' sudah dihapus.');
        //     }
        $jenis = $request->input('jenis');
        if ($jenis == 'tambahSupplier') {
            $NM_SUP = $request->input('NM_SUP');
            $PERSON1 = $request->input('PERSON1');
            $PERSON2 = $request->input('PERSON2');
            $TLP1 = $request->input('TLP1');
            $TLP2 = $request->input('TLP2');
            $HPHONE1 = $request->input('HPHONE1');
            $HPHONE2 = $request->input('HPHONE2');
            $TELEX1 = $request->input('TELEX1');
            $TELEX2 = $request->input('TELEX2');
            $PAGER1 = NULL; //$request->input('PAGER1');
            $PAGER2 = NULL; //$request->input('PAGER2');
            $ALAMAT1 = $request->input('ALAMAT1');
            $ALAMAT2 = $request->input('ALAMAT2');
            $KOMPLEK1 = $request->input('KOMPLEK1');
            $KOMPLEK2 = $request->input('KOMPLEK2');
            $KOTA1 = $request->input('KOTA1');
            $KOTA2 = $request->input('KOTA2');
            $FAX1 = $request->input('FAX1');
            $FAX2 = $request->input('FAX2');
            $NEGARA1 = $request->input('NEGARA1');
            $NEGARA2 = $request->input('NEGARA2');
            $COUNTER_TRANS = 0;
            $SALDO_HUTANG = 0;
            $SALDO_HUTANG_Rp = 0;
            $ID_MATAUANG = $request->input('ID_MATAUANG');
            $STATUS = NULL; //$request->input('STATUS');
            $JNS_SUP = ($request->input('ID_MATAUANG') ?? 0) == 1 ? '01' : '02';
            $IsActive = 1;
            try {
                DB::connection('ConnPurchase')->statement(
                    'EXEC SP_4384_PBL_Maintenance_Supplier @XKode = ?, @XNM_SUP = ?, @XPERSON1 = ?, @XPERSON2 = ?, @XTLP1 = ?, @XTLP2 = ?, @XHPHONE1 = ?,
                            @XHPHONE2 = ?, @XTELEX1 = ?, @XTELEX2 = ?, @XPAGER1 = ?, @XPAGER2 = ?, @XALAMAT1 = ?, @XALAMAT2 = ?, @XKOMPLEK1 = ?, @XKOMPLEK2 = ?, @XKOTA1 = ?,
                            @XKOTA2 = ?, @XFAX1 = ?, @XFAX2 = ?, @XNEGARA1 = ?, @XNEGARA2 = ?, @XCOUNTER_TRANS = ?, @XSALDO_HUTANG = ?, @XSALDO_HUTANG_Rp = ?, @XID_MATAUANG = ?,
                            @XSTATUS = ?, @XJNS_SUP = ?, @XIsActive = ?'
                    ,
                    [
                        2,
                        $NM_SUP,
                        $PERSON1,
                        $PERSON2,
                        $TLP1,
                        $TLP2,
                        $HPHONE1,
                        $HPHONE2,
                        $TELEX1,
                        $TELEX2,
                        $PAGER1,
                        $PAGER2,
                        $ALAMAT1,
                        $ALAMAT2,
                        $KOMPLEK1,
                        $KOMPLEK2,
                        $KOTA1,
                        $KOTA2,
                        $FAX1,
                        $FAX2,
                        $NEGARA1,
                        $NEGARA2,
                        $COUNTER_TRANS,
                        $SALDO_HUTANG,
                        $SALDO_HUTANG_Rp,
                        $ID_MATAUANG,
                        $STATUS,
                        $JNS_SUP,
                        $IsActive,
                    ]
                );
                return response()->json(['success' => true]);
            } catch (Exception $e) {
                return response()->json(['error' => 'Failed to insert data: ' . $e->getMessage()], 500);
            }
        } else if ($jenis == 'editSupplier') {
            try {
                $NM_SUP = $request->input('NM_SUP');
                $PERSON1 = $request->input('PERSON1');
                $PERSON2 = $request->input('PERSON2');
                $TLP1 = $request->input('TLP1');
                $TLP2 = $request->input('TLP2');
                $HPHONE1 = $request->input('HPHONE1');
                $HPHONE2 = $request->input('HPHONE2');
                $TELEX1 = $request->input('TELEX1');
                $TELEX2 = $request->input('TELEX2');
                $ALAMAT1 = $request->input('ALAMAT1');
                $ALAMAT2 = $request->input('ALAMAT2');
                $KOTA1 = $request->input('KOTA1');
                $KOTA2 = $request->input('KOTA2');
                $FAX1 = $request->input('FAX1');
                $FAX2 = $request->input('FAX2');
                $NEGARA1 = $request->input('NEGARA1');
                $NEGARA2 = $request->input('NEGARA2');
                $ID_MATAUANG = $request->input('ID_MATAUANG');
                $JNS_SUP = $request->input('JNS_SUP');
                $NO_SUP = $request->input('NO_SUP');
                DB::connection('ConnPurchase')->statement(
                    'EXEC SP_4384_PBL_Maintenance_Supplier @XKode = ?, @XNM_SUP = ?, @XPERSON1 = ?, @XPERSON2 = ?, @XTLP1 = ?, @XTLP2 = ?, @XHPHONE1 = ?,
                            @XHPHONE2 = ?, @XTELEX1 = ?, @XTELEX2 = ?, @XALAMAT1 = ?, @XALAMAT2 = ?, @XKOTA1 = ?, @XKOTA2 = ?, @XFAX1 = ?, @XFAX2 = ?,
                            @XNEGARA1 = ?, @XNEGARA2 = ?, @XID_MATAUANG = ?, @XJNS_SUP = ?, @XNO_SUP = ?'
                    ,
                    [
                        3,
                        $NM_SUP,
                        $PERSON1,
                        $PERSON2,
                        $TLP1,
                        $TLP2,
                        $HPHONE1,
                        $HPHONE2,
                        $TELEX1,
                        $TELEX2,
                        $ALAMAT1,
                        $ALAMAT2,
                        $KOTA1,
                        $KOTA2,
                        $FAX1,
                        $FAX2,
                        $NEGARA1,
                        $NEGARA2,
                        $ID_MATAUANG,
                        $JNS_SUP,
                        $NO_SUP,
                    ]
                );
                return response()->json(['success' => true]);
            } catch (Exception $e) {
                return response()->json(['error' => 'Failed to insert data: ' . $e->getMessage()], 500);
            }
        } else if ($jenis == 'hapusSupplier') {
            $idSupplier = $request->input('idSupplier');
            try {
                DB::connection('ConnPurchase')->statement('EXEC SP_4384_PBL_Maintenance_Supplier @XKode = ?, @XNO_SUP = ?', [4, $idSupplier]);
                return response()->json(['success' => true]);
            } catch (Exception $e) {
                return response()->json(['error' => 'Failed to insert data: ' . $e->getMessage()], 500);
            }
        } else if ($jenis == 'getAllSupplier') {
            $listSupplier = DB::connection('ConnPurchase')->select('EXEC SP_4384_PBL_Maintenance_Supplier @XKode = ?', [0]);

            return DataTables::of($listSupplier)->make(true);
        } else {
            return response()->json(['error' => 'Invalid request type'], 400);
        }

    }


    //Display the specified resource.
    public function show($id, Request $request)
    {
        if ($id == 'getSupplierById') {
            $idSupplier = $request->input('idSupplier');
            try {
                $supplierById = DB::connection('ConnPurchase')->select('EXEC SP_4384_PBL_Maintenance_Supplier @XKode = ?, @XNO_SUP = ?', [1, $idSupplier]);
                return response()->json($supplierById, 200);
            } catch (Exception $e) {
                return response()->json(['error' => 'Failed to insert data: ' . $e->getMessage()], 500);
            }
        } else {
            return response()->json(['error' => (string) 'Invalid ID: ' . $id], 400);
        }
    }

    //Show the form for editing the specified resource.
    public function edit($id)
    {
        $data = DB::connection('ConnPurchase')->select('exec SP_1273_PBL_LIST_SUPPLIER @kd = ?, @idSup = ?', [1, $id]);
        $access = (new HakAksesController)->HakAksesFiturMaster('Beli');
        $matauang = DB::connection('ConnPurchase')->select('exec SP_7775_PBL_LIST_MATA_UANG');
        // dd($data, $matauang);
        return view('Beli.Master.Supplier.Edit', compact('data', 'access', 'matauang'));
    }

    //Update the specified resource in storage.
    public function update(Request $request, $id)
    {
        //
    }

    //Remove the specified resource from storage.
    public function destroy($id)
    {

    }
}
