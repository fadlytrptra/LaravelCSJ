<?php

namespace App\Http\Controllers\Sales\Transaksi\DeliveryOrder;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\HakAksesController;
use Session;
use Exception;


class InputPEBController extends Controller
{
    public function index()
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('Sales');
        // $data = DB::connection('ConnSales')->select('exec SP_4384_SLS_LIST_DO_IMPOR_DENGAN_TYPE_BARANG_PAKAI_PIB');
        // $data2 = DB::connection('ConnSales')->table('T_DeliveryOrder')
        //     ->select('T_DeliveryOrder.IDDO', 'T_DeliveryOrder.tanggal', 'T_DetailPesanan.IDSuratPesanan', 'INVENTORY.dbo.Type.NamaType', 'INVENTORY.dbo.Type.IdType', 'INVENTORY.dbo.Type.KodeBarang', 'T_DeliveryOrder.PEB')
        //     ->join('INVENTORY.dbo.Type', 'T_DeliveryOrder.IdType', '=', 'INVENTORY.dbo.Type.IdType')
        //     ->join('T_DetailPesanan', 'T_DeliveryOrder.IDPesanan', '=', 'T_DetailPesanan.IDPesanan')
        //     ->where(function ($query) {
        //         $query->whereNotNull('INVENTORY.dbo.Type.PIB')
        //             ->orWhere('INVENTORY.dbo.Type.PIB', '<>', '');
        //     })
        //     ->where('T_DeliveryOrder.tanggal', '>', '2024-01-01')
        //     ->orderByDesc('T_DeliveryOrder.tanggal')
        //     ->get();
        // ;
        // dd($data, $data2);
        return view('Sales.Transaksi.DeliveryOrder.IndexInputPEB', compact('access'));
    }
    function dopeb(Request $request)
    {
        $columns = array(
            0 => 'IDDO',
            1 => 'tanggal',
            2 => 'IDSuratPesanan',
            3 => 'NamaType',
            4 => 'IdType',
            5 => 'KodeBarang',
            6 => 'PEB'
        );

        $totalData = DB::connection('ConnSales')
            ->table('T_DeliveryOrder')
            ->select('T_DeliveryOrder.IDDO', 'T_DeliveryOrder.tanggal', 'T_DetailPesanan.IDSuratPesanan', 'INVENTORY.dbo.Type.NamaType', 'INVENTORY.dbo.Type.IdType', 'INVENTORY.dbo.Type.KodeBarang', 'T_DeliveryOrder.PEB')
            ->join('INVENTORY.dbo.Type', 'T_DeliveryOrder.IdType', '=', 'INVENTORY.dbo.Type.IdType')
            ->join('T_DetailPesanan', 'T_DeliveryOrder.IDPesanan', '=', 'T_DetailPesanan.IDPesanan')
            ->where(function ($query) {
                $query->whereNotNull('INVENTORY.dbo.Type.PIB')
                    ->orWhere('INVENTORY.dbo.Type.PIB', '<>', '');
            })
            ->where('T_DeliveryOrder.tanggal', '>', '2024-01-01')
            ->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $do = DB::connection('ConnSales')
                ->table('T_DeliveryOrder')
                ->select(
                    'T_DeliveryOrder.IDDO',
                    'T_DeliveryOrder.tanggal',
                    'T_DetailPesanan.IDSuratPesanan',
                    'INVENTORY.dbo.Type.NamaType',
                    'INVENTORY.dbo.Type.IdType',
                    'INVENTORY.dbo.Type.KodeBarang',
                    'T_DeliveryOrder.PEB'
                )
                ->join('INVENTORY.dbo.Type', 'T_DeliveryOrder.IdType', '=', 'INVENTORY.dbo.Type.IdType')
                ->join('T_DetailPesanan', 'T_DeliveryOrder.IDPesanan', '=', 'T_DetailPesanan.IDPesanan')
                ->where(function ($query) {
                    $query->whereNotNull('INVENTORY.dbo.Type.PIB')
                        ->orWhere('INVENTORY.dbo.Type.PIB', '<>', '');
                })
                ->where('T_DeliveryOrder.tanggal', '>', '2024-01-01')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $do = DB::connection('ConnSales')
                ->table('T_DeliveryOrder')
                ->select('T_DeliveryOrder.IDDO', 'T_DeliveryOrder.tanggal', 'T_DetailPesanan.IDSuratPesanan', 'INVENTORY.dbo.Type.NamaType', 'INVENTORY.dbo.Type.IdType', 'INVENTORY.dbo.Type.KodeBarang', 'T_DeliveryOrder.PEB')
                ->join('INVENTORY.dbo.Type', 'T_DeliveryOrder.IdType', '=', 'INVENTORY.dbo.Type.IdType')
                ->join('T_DetailPesanan', 'T_DeliveryOrder.IDPesanan', '=', 'T_DetailPesanan.IDPesanan')
                ->where(function ($query) {
                    $query->whereNotNull('INVENTORY.dbo.Type.PIB')
                        ->orWhere('INVENTORY.dbo.Type.PIB', '<>', '');
                })
                ->where('T_DeliveryOrder.tanggal', '>', '2024-01-01')
                ->orderByDesc('T_DeliveryOrder.tanggal')
                ->where('T_DeliveryOrder.IDDO', 'LIKE', "%{$search}%")
                ->orWhere('T_DeliveryOrder.tanggal', 'LIKE', "%{$search}%")
                ->orWhere('T_DetailPesanan.IDSuratPesanan', 'LIKE', "%{$search}%")
                ->orwhere('INVENTORY.dbo.Type.NamaType', 'LIKE', "%{$search}%")
                ->orWhere('INVENTORY.dbo.Type.IdType', 'LIKE', "%{$search}%")
                ->orWhere('INVENTORY.dbo.Type.KodeBarang', 'LIKE', "%{$search}%")
                ->orWhere('T_DeliveryOrder.PEB', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = DB::connection('ConnSales')
                ->table('T_DeliveryOrder')
                ->select('T_DeliveryOrder.IDDO', 'T_DeliveryOrder.tanggal', 'T_DetailPesanan.IDSuratPesanan', 'INVENTORY.dbo.Type.NamaType', 'INVENTORY.dbo.Type.IdType', 'INVENTORY.dbo.Type.KodeBarang', 'T_DeliveryOrder.PEB')
                ->join('INVENTORY.dbo.Type', 'T_DeliveryOrder.IdType', '=', 'INVENTORY.dbo.Type.IdType')
                ->join('T_DetailPesanan', 'T_DeliveryOrder.IDPesanan', '=', 'T_DetailPesanan.IDPesanan')
                ->where(function ($query) {
                    $query->whereNotNull('INVENTORY.dbo.Type.PIB')
                        ->orWhere('INVENTORY.dbo.Type.PIB', '<>', '');
                })
                ->where('T_DeliveryOrder.tanggal', '>', '2024-01-01')
                ->orderByDesc('T_DeliveryOrder.tanggal')
                ->where('T_DeliveryOrder.IDDO', 'LIKE', "%{$search}%")
                ->orWhere('T_DeliveryOrder.tanggal', 'LIKE', "%{$search}%")
                ->orWhere('T_DetailPesanan.IDSuratPesanan', 'LIKE', "%{$search}%")
                ->orwhere('INVENTORY.dbo.Type.NamaType', 'LIKE', "%{$search}%")
                ->orWhere('INVENTORY.dbo.Type.IdType', 'LIKE', "%{$search}%")
                ->orWhere('INVENTORY.dbo.Type.KodeBarang', 'LIKE', "%{$search}%")
                ->orWhere('T_DeliveryOrder.PEB', 'LIKE', "%{$search}%")
                ->count();
        }
        // dd($do);
        $data = array();
        if (!empty($do)) {
            foreach ($do as $datado) {
                $nestedData['ID DO'] = $datado->IDDO;
                $nestedData['Tanggal DO'] = substr($datado->tanggal, 0, 10);
                $nestedData['Nomor SP'] = $datado->IDSuratPesanan;
                $nestedData['Nama Type'] = $datado->NamaType;
                $nestedData['Id Type'] = $datado->IdType;
                $nestedData['Kode Barang'] = $datado->KodeBarang;
                $nestedData['PEB'] = $datado->PEB;
                // $nestedData['Nomor SP'] = substr($datado->Tgl_Pesan, 0, 10);
                // if (strstr($datado->IDSuratPesanan, '/')) {
                //     $no_doValue = str_replace('/', '.', $datado->IDSuratPesanan);
                // } else {
                //     $no_doValue = $datado->IDSuratPesanan;
                // }
                $nestedData['Actions'] = "<button class=\"btn btn-sm btn-primary\"
                onclick=\"showModal($datado->IDDO)\"><span>&#x270E;</span> Input/Edit
                PEB</button>";
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        // dd($sp);
        echo json_encode($json_data);
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        // Validate and process the request
        $peb = $request->input('peb');
        $iddo = $request->input('iddo');

        // Perform any necessary operations with $peb
        try {
            DB::connection('ConnSales')->table('T_DeliveryOrder')
                ->where('IDDO', '=', $iddo)
                ->update(['PEB' => $peb]);
            return response()->json('success');
        }
        //catch exception
        catch (Exception $e) {
            return response()->json('Message error: ' . $e->getMessage());
        }
    }
    public function show($id)
    {
        $data = DB::connection('ConnSales')->table('T_DeliveryOrder')
            ->where('IDDO', '=', $id)
            ->select('PEB')
            ->get();
        return $data;
    }
    public function edit($id)
    {
        //
    }
    public function update(Request $request, $id)
    {
        //
    }
    public function destroy($id)
    {
        //
    }
}
