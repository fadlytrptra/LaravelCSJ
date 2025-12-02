<?php
namespace APP\Http\Controllers\Beli\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HakAksesController;
use DB;

class HistoryPembelianMasterController extends Controller
{
    public function index()
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('Beli');
        $result = (new HakAksesController)->HakAksesFitur('History Pembelian');
        if ($result > 0) {
            return view('Beli.Master.HistoryPembelian', compact('access'));
        } else {
            abort(404);
        }
    }

    //Show the form for creating a new resource.
    public function create(Request $request)
    {
        $totalData = DB::connection('ConnPurchase')->table('YTRANSBL')
            ->join('Y_BARANG', 'YTRANSBL.Kd_brg', '=', 'Y_BARANG.KD_BRG')
            ->join('YTERIMA', 'YTRANSBL.No_trans', '=', 'YTERIMA.No_trans')
            ->join('YSATUAN', 'YTRANSBL.NoSatuan', '=', 'YSATUAN.No_satuan')
            ->join('ACCOUNTING.dbo.T_MATAUANG', 'YTERIMA.IdMataUang', '=', 'ACCOUNTING.dbo.T_MATAUANG.Id_MataUang')
            ->join('YUSER', 'YTRANSBL.Operator', '=', 'YUSER.kd_user')
            ->join('YSUPPLIER', 'YTERIMA.No_sup', '=', 'YSUPPLIER.NO_SUP')
            ->join('STATUS_ORDER', 'YTRANSBL.StatusOrder', '=', 'STATUS_ORDER.KdStatus')
            ->join('Y_KATEGORI_SUB', 'Y_KATEGORI_SUB.no_sub_kategori', '=', 'Y_BARANG.NO_SUB_KATEGORI')
            ->join('YDIVISI', 'YDIVISI.KD_DIV', '=', 'YTRANSBL.Kd_div')
            ->select(
                'STATUS_ORDER.Status',
                'YTRANSBL.NO_PO',
                'YTRANSBL.Tgl_sppb',
                'YTRANSBL.Kd_div',
                'YTRANSBL.Kd_brg',
                'YTRANSBL.Tgl_order',
                'YTRANSBL.PriceUnit',
                'YTRANSBL.Qty',
                'Y_BARANG.NAMA_BRG',
                'YSATUAN.Nama_satuan',
                'YSUPPLIER.NM_SUP',
                'YSUPPLIER.KOTA1',
                'YSUPPLIER.NEGARA1',
                'YTERIMA.Hrg_trm',
                'ACCOUNTING.dbo.T_MATAUANG.Id_MataUang_BC',
                'YUSER.Nama',
                'YTERIMA.No_trans',
                'YTRANSBL.StatusBeli',
                'Y_KATEGORI_SUB.nama_sub_kategori',
                'YDIVISI.NM_DIV'
            )->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $maxRecords = $request->input('maximumRecords');

        $query = DB::connection('ConnPurchase')->table('YTRANSBL')
            ->join('Y_BARANG', 'YTRANSBL.Kd_brg', '=', 'Y_BARANG.KD_BRG')
            ->join('YTERIMA', 'YTRANSBL.No_trans', '=', 'YTERIMA.No_trans')
            ->join('YSATUAN', 'YTRANSBL.NoSatuan', '=', 'YSATUAN.No_satuan')
            ->join('ACCOUNTING.dbo.T_MATAUANG', 'YTERIMA.IdMataUang', '=', 'ACCOUNTING.dbo.T_MATAUANG.Id_MataUang')
            ->join('YUSER', 'YTRANSBL.Operator', '=', 'YUSER.kd_user')
            ->join('YSUPPLIER', 'YTERIMA.No_sup', '=', 'YSUPPLIER.NO_SUP')
            ->join('STATUS_ORDER', 'YTRANSBL.StatusOrder', '=', 'STATUS_ORDER.KdStatus')
            ->join('Y_KATEGORI_SUB', 'Y_KATEGORI_SUB.no_sub_kategori', '=', 'Y_BARANG.NO_SUB_KATEGORI')
            ->join('YDIVISI', 'YDIVISI.KD_DIV', '=', 'YTRANSBL.Kd_div')
            ->select(
                'STATUS_ORDER.Status',
                'YTRANSBL.NO_PO',
                'YTRANSBL.Tgl_sppb',
                'YTRANSBL.Kd_div',
                'YTRANSBL.Kd_brg',
                'YTRANSBL.Tgl_order',
                'YTRANSBL.PriceUnit',
                'YTRANSBL.Qty',
                'Y_BARANG.NAMA_BRG',
                'YSATUAN.Nama_satuan',
                'YSUPPLIER.NM_SUP',
                'YSUPPLIER.KOTA1',
                'YSUPPLIER.NEGARA1',
                'YTERIMA.Hrg_trm',
                'ACCOUNTING.dbo.T_MATAUANG.Id_MataUang_BC',
                'YUSER.Nama',
                'YTERIMA.No_trans',
                'YTRANSBL.StatusBeli',
                'Y_KATEGORI_SUB.nama_sub_kategori',
                'YDIVISI.NM_DIV'
            );
        $filters = $request->input('custom_filters', []);
        $columnMap = [
            'No_trans' => 'YTERIMA.No_trans',
            'Status' => 'STATUS_ORDER.Status',
            'NO_PO' => 'YTRANSBL.NO_PO',
            'Kd_div' => 'YTRANSBL.Kd_div',
            'Kd_brg' => 'YTRANSBL.Kd_brg',
            'Qty' => 'YTRANSBL.Qty',
        ];
        foreach ($filters as $filter) {
            $rawColumn = $filter['column'];
            $column = $columnMap[$rawColumn] ?? $rawColumn; // Use mapped column if exists
            $operator = $filter['operator'];
            $value = $filter['value'];

            if ($operator === 'like') {
                $query->where($column, 'LIKE', '%' . $value . '%');
            } else if ($operator === '=' or $operator === '!=') {
                if ($column == 'Tgl_sppb' || $column == 'Tgl_order') {
                    $query->whereRaw('CAST([' . $column . '] AS DATE) = ?', [$value]);
                } else {
                    $query->where($column, $operator, $value);
                }
            } else if ($operator === 'isbetween') {
                $value = is_array($value) ? $value : array_map('trim', explode(',', $value));
                if (is_array($value) && count($value) === 2) {
                    $query->whereBetween($column, [$value[0], $value[1]]);
                }
            } else if ($operator === 'notbetween') {
                $value = is_array($value) ? $value : array_map('trim', explode(',', $value));
                if (is_array($value) && count($value) === 2) {
                    $query->whereNotBetween($column, [$value[0], $value[1]]);
                }
            } else if ($operator === 'in') {
                $query->whereIn($column, $value);
            } else if ($operator === 'notin') {
                $query->whereNotIn($column, $value);
            } else if ($operator === 'isnull') {
                $query->whereNull($column);
            } else if ($operator === 'isnotnull') {
                $query->whereNotNull($column);
            }
        }

        // Apply sorting (optional)
        foreach ($filters as $filter) {
            if (!empty($filter['sort'])) {
                $query->orderBy($filter['column'], $filter['sort']);
            }
        }
        $totalFilteredBeforeCap = (clone $query)->count(); // real filtered count

        $maxRecords = $request->input('maximumRecords'); // e.g., 1000
        $limitMaxRecords = intval($maxRecords) - intval($start);
        // Cap the filtered count
        $totalFiltered = ($maxRecords && $totalFilteredBeforeCap > $maxRecords)
            ? $maxRecords
            : $totalFilteredBeforeCap;

        // Then apply page offset + limit
        $query->offset($start);
        if ($limitMaxRecords && $limit > $limitMaxRecords) {
            $query->limit($limitMaxRecords);
        } else {
            $query->limit($limit); // page size (10)
        }

        $data = $query->get();
        if (!empty($order)) {
            foreach ($order as $dataorder) {
                $nestedData['No_trans'] = $dataorder->No_trans ?? NULL;
                $nestedData['Status'] = $dataorder->Status ?? NULL;
                $nestedData['Tgl_sppb'] = $dataorder->Tgl_sppb ?? NULL;
                $nestedData['Kd_brg'] = $dataorder->Kd_brg ?? NULL;
                $nestedData['NAMA_BRG'] = $dataorder->NAMA_BRG ?? NULL;
                $nestedData['Hrg_trm'] = $dataorder->Hrg_trm ?? NULL;
                $nestedData['Nama_satuan'] = $dataorder->Nama_satuan ?? NULL;
                $nestedData['NM_SUP'] = $dataorder->NM_SUP ?? NULL;
                $nestedData['Nama'] = $dataorder->Nama ?? NULL;
                $nestedData['NM_DIV'] = $dataorder->NM_DIV ?? NULL;
                $nestedData['nama_sub_kategori'] = $dataorder->nama_sub_kategori ?? NULL;
                $nestedData['StatusBeli'] = $dataorder->StatusBeli ?? NULL;
                $nestedData['Qty'] = $dataorder->Qty ?? NULL;
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        return response()->json($json_data);
    }

    // public function redisplay(Request $request)
    // {
    //     $nm_brg = $request->input('nm_brg');
    //     $kd = 3;
    //     $req = $request->input('req');
    //     $sup = $request->input('sup');
    //     $kdbrg = $request->input('kdbrg');
    //     if (($nm_brg != null) || ($req != null) || ($sup != null) || ($kdbrg != null)) {
    //         try {
    //             $redisplay = DB::connection('ConnPurchase')->select('exec spSelect_CariTypeBarang_dotNet @nm_brg = ?, @kd = ?, @req = ?, @sup = ?, @kdbrg = ?', [$nm_brg, $kd, $req, $sup, $kdbrg]);
    //             return datatables($redisplay)->make(true);
    //         } catch (\Throwable $Error) {
    //             return Response()->json($Error);
    //         }
    //     } else {
    //         return Response()->json('Parameter harus di isi');
    //     }
    // }
    //Store a newly created resource in storage.
    public function store(Request $request)
    {
        $jenisStore = $request->input('jenisStore');
        if ($jenisStore == 'exportToExcel') {
            $query = DB::connection('ConnPurchase')->table('YTRANSBL')
                ->join('Y_BARANG', 'YTRANSBL.Kd_brg', '=', 'Y_BARANG.KD_BRG')
                ->join('YTERIMA', 'YTRANSBL.No_trans', '=', 'YTERIMA.No_trans')
                ->join('YSATUAN', 'YTRANSBL.NoSatuan', '=', 'YSATUAN.No_satuan')
                ->join('ACCOUNTING.dbo.T_MATAUANG', 'YTERIMA.IdMataUang', '=', 'ACCOUNTING.dbo.T_MATAUANG.Id_MataUang')
                ->join('YUSER', 'YTRANSBL.Operator', '=', 'YUSER.kd_user')
                ->join('YSUPPLIER', 'YTERIMA.No_sup', '=', 'YSUPPLIER.NO_SUP')
                ->join('STATUS_ORDER', 'YTRANSBL.StatusOrder', '=', 'STATUS_ORDER.KdStatus')
                ->join('Y_KATEGORI_SUB', 'Y_KATEGORI_SUB.no_sub_kategori', '=', 'Y_BARANG.NO_SUB_KATEGORI')
                ->join('YDIVISI', 'YDIVISI.KD_DIV', '=', 'YTRANSBL.Kd_div')
                ->select(
                    'STATUS_ORDER.Status',
                    'YTRANSBL.NO_PO',
                    'YTRANSBL.Tgl_sppb',
                    'YTRANSBL.Kd_div',
                    'YTRANSBL.Kd_brg',
                    'YTRANSBL.Tgl_order',
                    'YTRANSBL.PriceUnit',
                    'YTRANSBL.Qty',
                    'Y_BARANG.NAMA_BRG',
                    'YSATUAN.Nama_satuan',
                    'YSUPPLIER.NM_SUP',
                    'YSUPPLIER.KOTA1',
                    'YSUPPLIER.NEGARA1',
                    'YTERIMA.Hrg_trm',
                    'ACCOUNTING.dbo.T_MATAUANG.Id_MataUang_BC',
                    'YUSER.Nama',
                    'YTERIMA.No_trans',
                    'YTRANSBL.StatusBeli',
                    'Y_KATEGORI_SUB.nama_sub_kategori',
                    'YDIVISI.NM_DIV'
                );

            $filters = $request->input('custom_filters', []);
            $columnMap = [
                'No_trans' => 'YTERIMA.No_trans',
                'Status' => 'STATUS_ORDER.Status',
                'NO_PO' => 'YTRANSBL.NO_PO',
                'Kd_div' => 'YTRANSBL.Kd_div',
                'Kd_brg' => 'YTRANSBL.Kd_brg',
                'Qty' => 'YTRANSBL.Qty',
            ];

            foreach ($filters as $filter) {
                $rawColumn = $filter['column'];
                $column = $columnMap[$rawColumn] ?? $rawColumn; // Use mapped column if exists
                $operator = $filter['operator'];
                $value = $filter['value'];

                if ($operator === 'like') {
                    $query->where($column, 'LIKE', '%' . $value . '%');
                } else if ($operator === '=' or $operator === '!=') {
                    if ($column == 'Tgl_sppb' || $column == 'Tgl_order') {
                        $query->whereRaw('CAST([TglAprMGR] AS DATE) = ?', [$value]);
                    } else {
                        $query->where($column, $operator, $value);
                    }
                } else if ($operator === 'isbetween') {
                    $value = is_array($value) ? $value : array_map('trim', explode(',', $value));
                    if (is_array($value) && count($value) === 2) {
                        $query->whereBetween($column, [$value[0], $value[1]]);
                    }
                } else if ($operator === 'notbetween') {
                    $value = is_array($value) ? $value : array_map('trim', explode(',', $value));
                    if (is_array($value) && count($value) === 2) {
                        $query->whereNotBetween($column, [$value[0], $value[1]]);
                    }
                } else if ($operator === 'in') {
                    $query->whereIn($column, $value);
                } else if ($operator === 'notin') {
                    $query->whereNotIn($column, $value);
                } else if ($operator === 'isnull') {
                    $query->whereNull($column);
                } else if ($operator === 'isnotnull') {
                    $query->whereNotNull($column);
                }
            }

            // Apply sorting (optional)
            foreach ($filters as $filter) {
                if (!empty($filter['sort'])) {
                    $query->orderBy($filter['column'], $filter['sort']);
                }
            }

            $maximumRecords = $request->input('maximumRecords');
            if ($maximumRecords) {
                $query->limit($maximumRecords);
            }

            $results = $query->get();

            return response()->json(['data' => $results]);
        } else {
            return response()->json(['error' => 'Invalid store type'], 400);
        }
    }

    //Display the specified resource.
    public function show($id, Request $request)
    {
        if ($id == 'HistoryPembelianAllData') {
            dd('hehe');
        } else {
            response()->json(['error' => 'Invalid ID'], 404);
        }
    }

    //Show the form for editing the specified resource.
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
