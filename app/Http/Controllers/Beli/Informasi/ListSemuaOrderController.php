<?php

namespace App\Http\Controllers\Beli\Informasi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HakAksesController;
use DB;
use Session;

class ListSemuaOrderController extends Controller
{
    public function index()
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('Beli');
        $result = (new HakAksesController)->HakAksesFitur('List Semua Order');
        // dd($result);
        if ($result > 0) {
            return view('Beli.Informasi.ListSemuaOrder', compact('access'));
        } else {
            abort(403);
        }
    }

    public function create(Request $request)
    {
        $totalData = DB::connection('ConnPurchase')->table('VW_5409_ORDER_MOVEMENT')
            ->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $maxRecords = $request->input('maximumRecords');

        $query = DB::connection('ConnPurchase')->table('VW_5409_ORDER_MOVEMENT')
            ->select(
                'NO_ORDER',
                'STATUS_PO',
                'TglAprMGR',
                'STATUS_BELI',
                'NO_PO',
                'TGL_PO',
                'KODE_BARANG',
                'NM_BARANG',
                'SUB_KATEGORI',
                'SUPPLIER',
                'PriceUnit',
                'PPN',
                'QTY_PO',
                'SATUAN',
                'PAY_TERM',
                'NM_USER',
                'NM_DIVISI',
                'No_BTTB',
                'TGL_DATANG',
                'NOTELINE',
                'Ket_Internal',
            );

        $filters = $request->input('custom_filters', []);
        foreach ($filters as $filter) {
            $column = $filter['column'];
            $operator = $filter['operator'];
            $value = $filter['value'];

            if ($operator === 'like') {
                $query->where($column, 'LIKE', '%' . $value . '%');
            } else if ($operator === '=' or $operator === '!=') {
                if ($column == 'TglAprMGR' || $column == 'TGL_PO' || $column == 'TGL_DATANG') {
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
                $nestedData['NO_ORDER'] = $dataorder->NO_ORDER ?? null;
                $nestedData['STATUS_PO'] = $dataorder->STATUS_PO ?? null;
                $nestedData['TglAprMGR'] = $dataorder->TglAprMGR ?? null;
                $nestedData['STATUS_BELI'] = $dataorder->STATUS_BELI ?? null;
                $nestedData['NO_PO'] = $dataorder->NO_PO ?? null;
                $nestedData['TGL_PO'] = $dataorder->TGL_PO ?? null;
                $nestedData['KODE_BARANG'] = $dataorder->KODE_BARANG ?? null;
                $nestedData['NM_BARANG'] = $dataorder->NM_BARANG ?? null;
                $nestedData['SUB_KATEGORI'] = $dataorder->SUB_KATEGORI ?? null;
                $nestedData['SUPPLIER'] = $dataorder->SUPPLIER ?? null;
                $nestedData['PriceUnit'] = $dataorder->PriceUnit ?? null;
                $nestedData['PPN'] = $dataorder->PPN ?? null;
                $nestedData['QTY_PO'] = $dataorder->QTY_PO ?? null;
                $nestedData['SATUAN'] = $dataorder->SATUAN ?? null;
                $nestedData['PAY_TERM'] = $dataorder->PAY_TERM ?? null;
                $nestedData['NM_USER'] = $dataorder->NM_USER ?? null;
                $nestedData['NM_DIVISI'] = $dataorder->NM_DIVISI ?? null;
                $nestedData['No_BTTB'] = $dataorder->No_BTTB ?? null;
                $nestedData['TGL_DATANG'] = $dataorder->TGL_DATANG ?? null;
                $nestedData['NOTELINE'] = $dataorder->NOTELINE ?? null;
                $nestedData['Ket_Internal'] = $dataorder->Ket_Internal ?? null;
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

    public function store(Request $request)
    {
        $jenisStore = $request->input('jenisStore');
        if ($jenisStore == 'exportToExcel') {
            $query = DB::connection('ConnPurchase')->table('VW_5409_ORDER_MOVEMENT')
                ->select(
                    'NO_ORDER',
                    'STATUS_PO',
                    'TglAprMGR',
                    'STATUS_BELI',
                    'NO_PO',
                    'TGL_PO',
                    'KODE_BARANG',
                    'NM_BARANG',
                    'SUB_KATEGORI',
                    'SUPPLIER',
                    'PriceUnit',
                    'PPN',
                    'QTY_PO',
                    'SATUAN',
                    'PAY_TERM',
                    'NM_USER',
                    'NM_DIVISI',
                    'No_BTTB',
                    'TGL_DATANG',
                    'NOTELINE',
                    'Ket_Internal',
                );

            $filters = $request->input('custom_filters', []);
            foreach ($filters as $filter) {
                $column = $filter['column'];
                $operator = $filter['operator'];
                $value = $filter['value'];

                if ($operator === 'like') {
                    $query->where($column, 'LIKE', '%' . $value . '%');
                } else if ($operator === '=' or $operator === '!=') {
                    if ($column == 'TglAprMGR' || $column == 'TGL_PO' || $column == 'TGL_DATANG') {
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

    public function show()
    {
        dd('show');
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
