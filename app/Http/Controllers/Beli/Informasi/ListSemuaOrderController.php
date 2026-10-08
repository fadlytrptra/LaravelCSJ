<?php

namespace App\Http\Controllers\Beli\Informasi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HakAksesController;
use Illuminate\Support\Facades\DB;

class ListSemuaOrderController extends Controller
{
    public function index()
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('Beli');
        $result = (new HakAksesController)->HakAksesFitur('List Semua Order');

        if ($result > 0) {
            return view(
                'Beli.Informasi.ListSemuaOrder',
                compact('access')
            );
        }

        abort(403);
    }


    public function create(Request $request)
    {
        $connection = DB::connection('ConnPurchase');

        /*
        |--------------------------------------------------------------------------
        | Query dasar
        |--------------------------------------------------------------------------
        */

        $query = $connection
            ->table('VW_4496_ORDER_MOVEMENT')
            ->select(
                'NO_ORDER',
                'Tgl_order',
                'NM_USER',
                'ID_DIVISI',
                'NM_DIVISI',
                'NOTELINE',
                'KODE_BARANG',
                'NM_BARANG',
                'SUB_KATEGORI',
                'KATEGORI',
                'KATEGORI_UTAMA',
                'QTY_PO',
                'SATUAN',
                'IdSupplier',
                'SUPPLIER',
                'JENIS_PEMBELIAN',
                'No_terima',
                'TGL_DATANG',
                'QTY_RCV',
                'NO_SJ',
                'PRICE_RCV',
                'DISC_RCV',
                'PRICE_RCV_PPN',
                'TGL_TRANSFER',
                'Id_Penagihan',
                'No_PIB',
                'No_sppb',
                'Tgl_sppb',
                'Informasi_Cetak'
            );


        /*
        |--------------------------------------------------------------------------
        | Total seluruh data
        |--------------------------------------------------------------------------
        */

        $recordsTotal = (clone $query)->count();


        /*
        |--------------------------------------------------------------------------
        | Search bawaan DataTables
        |--------------------------------------------------------------------------
        */

        $search = $request->input('search.value');

        if ($search !== null && $search !== '') {

            $query->where(function ($q) use ($search) {

                $q->where('NO_ORDER', 'LIKE', "%{$search}%")
                    ->orWhere('NM_USER', 'LIKE', "%{$search}%")
                    ->orWhere('ID_DIVISI', 'LIKE', "%{$search}%")
                    ->orWhere('NM_DIVISI', 'LIKE', "%{$search}%")
                    ->orWhere('KODE_BARANG', 'LIKE', "%{$search}%")
                    ->orWhere('NM_BARANG', 'LIKE', "%{$search}%")
                    ->orWhere('SUB_KATEGORI', 'LIKE', "%{$search}%")
                    ->orWhere('KATEGORI', 'LIKE', "%{$search}%")
                    ->orWhere('KATEGORI_UTAMA', 'LIKE', "%{$search}%")
                    ->orWhere('SATUAN', 'LIKE', "%{$search}%")
                    ->orWhere('SUPPLIER', 'LIKE', "%{$search}%")
                    ->orWhere('JENIS_PEMBELIAN', 'LIKE', "%{$search}%")
                    ->orWhere('No_terima', 'LIKE', "%{$search}%")
                    ->orWhere('NO_SJ', 'LIKE', "%{$search}%")
                    ->orWhere('Id_Penagihan', 'LIKE', "%{$search}%")
                    ->orWhere('No_PIB', 'LIKE', "%{$search}%")
                    ->orWhere('No_sppb', 'LIKE', "%{$search}%");
            });
        }


        /*
        |--------------------------------------------------------------------------
        | Advanced Search
        |--------------------------------------------------------------------------
        */

        $filters = $request->input('custom_filters', []);

        /*
        |--------------------------------------------------------------------------
        | Kolom yang boleh difilter
        |--------------------------------------------------------------------------
        */

        $allowedColumns = [

            'NO_ORDER',
            'Tgl_order',
            'NM_USER',
            'ID_DIVISI',
            'NM_DIVISI',
            'NOTELINE',
            'KODE_BARANG',
            'NM_BARANG',
            'SUB_KATEGORI',
            'KATEGORI',
            'KATEGORI_UTAMA',
            'QTY_PO',
            'SATUAN',
            'IdSupplier',
            'SUPPLIER',
            'JENIS_PEMBELIAN',
            'No_terima',
            'TGL_DATANG',
            'QTY_RCV',
            'NO_SJ',
            'PRICE_RCV',
            'DISC_RCV',
            'PRICE_RCV_PPN',
            'TGL_TRANSFER',
            'Id_Penagihan',
            'No_PIB',
            'No_sppb',
            'Tgl_sppb',
        ];


        /*
        |--------------------------------------------------------------------------
        | Kolom tanggal
        |--------------------------------------------------------------------------
        */

        $dateColumns = [

            'Tgl_order',
            'TGL_DATANG',
            'TGL_TRANSFER',
            'Tgl_sppb',

        ];


        /*
        |--------------------------------------------------------------------------
        | Kolom angka
        |--------------------------------------------------------------------------
        */

        $numberColumns = [

            'QTY_PO',
            'QTY_RCV',
            'PRICE_RCV',
            'DISC_RCV',
            'PRICE_RCV_PPN',

        ];


        /*
        |--------------------------------------------------------------------------
        | Proses Advanced Search
        |--------------------------------------------------------------------------
        */

        if (is_array($filters)) {

            foreach ($filters as $filter) {

                $column = $filter['column'] ?? null;
                $operator = $filter['operator'] ?? null;
                $value = $filter['value'] ?? null;

                /*
                |--------------------------------------------------------------------------
                | Validasi kolom dan operator
                |--------------------------------------------------------------------------
                */

                if (
                    !$column ||
                    !$operator ||
                    !in_array($column, $allowedColumns, true)
                ) {
                    continue;
                }


                /*
                |--------------------------------------------------------------------------
                | IS NULL
                |--------------------------------------------------------------------------
                */

                if ($operator === 'isnull') {

                    $query->whereNull($column);

                    continue;
                }


                /*
                |--------------------------------------------------------------------------
                | IS NOT NULL
                |--------------------------------------------------------------------------
                */

                if ($operator === 'isnotnull') {

                    $query->whereNotNull($column);

                    continue;
                }


                /*
                |--------------------------------------------------------------------------
                | LIKE
                |--------------------------------------------------------------------------
                */

                if ($operator === 'like') {

                    /*
                    | Untuk kolom angka, CAST ke VARCHAR
                    | supaya SQL Server tidak error saat LIKE.
                    */

                    if (in_array($column, $numberColumns, true)) {

                        $query->whereRaw(
                            'CAST([' . $column . '] AS VARCHAR(255)) LIKE ?',
                            ['%' . $value . '%']
                        );

                    } else {

                        $query->where(
                            $column,
                            'LIKE',
                            '%' . $value . '%'
                        );
                    }

                    continue;
                }


                /*
                |--------------------------------------------------------------------------
                | = dan !=
                |--------------------------------------------------------------------------
                */

                if (
                    $operator === '=' ||
                    $operator === '!='
                ) {

                    /*
                    | Kolom tanggal
                    */

                    if (in_array($column, $dateColumns, true)) {

                        $query->whereRaw(
                            'CAST([' . $column . '] AS DATE) ' .
                            $operator .
                            ' ?',
                            [$value]
                        );

                    } else {

                        $query->where(
                            $column,
                            $operator,
                            $value
                        );
                    }

                    continue;
                }


                /*
                |--------------------------------------------------------------------------
                | IS BETWEEN
                |--------------------------------------------------------------------------
                */

                if ($operator === 'isbetween') {

                    $values = is_array($value)
                        ? $value
                        : array_map(
                            'trim',
                            explode(',', $value ?? '')
                        );

                    if (count($values) === 2) {

                        /*
                        | Date
                        */

                        if (in_array($column, $dateColumns, true)) {

                            $query->whereRaw(
                                'CAST([' . $column . '] AS DATE) BETWEEN ? AND ?',
                                [
                                    $values[0],
                                    $values[1]
                                ]
                            );

                        } else {

                            $query->whereBetween(
                                $column,
                                [
                                    $values[0],
                                    $values[1]
                                ]
                            );
                        }
                    }

                    continue;
                }


                /*
                |--------------------------------------------------------------------------
                | NOT BETWEEN
                |--------------------------------------------------------------------------
                */

                if ($operator === 'notbetween') {

                    $values = is_array($value)
                        ? $value
                        : array_map(
                            'trim',
                            explode(',', $value ?? '')
                        );

                    if (count($values) === 2) {

                        /*
                        | Date
                        */

                        if (in_array($column, $dateColumns, true)) {

                            $query->whereRaw(
                                'CAST([' . $column . '] AS DATE) NOT BETWEEN ? AND ?',
                                [
                                    $values[0],
                                    $values[1]
                                ]
                            );

                        } else {

                            $query->whereNotBetween(
                                $column,
                                [
                                    $values[0],
                                    $values[1]
                                ]
                            );
                        }
                    }

                    continue;
                }


                /*
                |--------------------------------------------------------------------------
                | IN
                |--------------------------------------------------------------------------
                */

                if ($operator === 'in') {

                    $values = is_array($value)
                        ? $value
                        : array_map(
                            'trim',
                            explode(',', $value ?? '')
                        );

                    /*
                    | Buang value kosong
                    */

                    $values = array_values(
                        array_filter(
                            $values,
                            function ($item) {
                                return $item !== '';
                            }
                        )
                    );

                    if (count($values) > 0) {

                        $query->whereIn(
                            $column,
                            $values
                        );
                    }

                    continue;
                }


                /*
                |--------------------------------------------------------------------------
                | NOT IN
                |--------------------------------------------------------------------------
                */

                if ($operator === 'notin') {

                    $values = is_array($value)
                        ? $value
                        : array_map(
                            'trim',
                            explode(',', $value ?? '')
                        );

                    /*
                    | Buang value kosong
                    */

                    $values = array_values(
                        array_filter(
                            $values,
                            function ($item) {
                                return $item !== '';
                            }
                        )
                    );

                    if (count($values) > 0) {

                        $query->whereNotIn(
                            $column,
                            $values
                        );
                    }

                    continue;
                }
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Hitung data setelah:
        |
        | 1. Search DataTables
        | 2. Advanced Search
        |--------------------------------------------------------------------------
        */

        $recordsFiltered = (clone $query)->count();


        /*
        |--------------------------------------------------------------------------
        | Mapping kolom DataTables
        |--------------------------------------------------------------------------
        */

        $columns = [

            0  => 'NO_ORDER',
            1  => 'Tgl_order',
            2  => 'NM_USER',
            3  => 'NM_DIVISI',
            4  => 'KODE_BARANG',
            5  => 'NM_BARANG',
            6  => 'SUB_KATEGORI',
            7  => 'KATEGORI',
            8  => 'KATEGORI_UTAMA',
            9  => 'QTY_PO',
            10 => 'SATUAN',
            11 => 'SUPPLIER',
            12 => 'JENIS_PEMBELIAN',
            13 => 'No_terima',
            14 => 'TGL_DATANG',
            15 => 'QTY_RCV',
            16 => 'NO_SJ',
            17 => 'PRICE_RCV',
            18 => 'DISC_RCV',
            19 => 'PRICE_RCV_PPN',
            20 => 'TGL_TRANSFER',
            21 => 'Id_Penagihan',
            22 => 'No_PIB',
            23 => 'No_sppb',
            24 => 'Tgl_sppb',

        ];


        /*
        |--------------------------------------------------------------------------
        | Sorting DataTables
        |--------------------------------------------------------------------------
        */

        $orderColumnIndex = $request->input(
            'order.0.column',
            1
        );

        $orderDirection = $request->input(
            'order.0.dir',
            'desc'
        );

        $orderColumn =
            $columns[$orderColumnIndex] ?? 'Tgl_order';

        $orderDirection =
            strtolower($orderDirection) === 'asc'
                ? 'asc'
                : 'desc';


        /*
        |--------------------------------------------------------------------------
        | Sorting dari Advanced Search
        |
        | Jika Advanced Search mempunyai sort,
        | kita jadikan sort Advanced Search sebagai
        | prioritas.
        |--------------------------------------------------------------------------
        */

        $advancedSortApplied = false;

        if (is_array($filters)) {

            foreach ($filters as $filter) {

                $column = $filter['column'] ?? null;
                $sort = $filter['sort'] ?? null;

                if (
                    !$column ||
                    !$sort ||
                    !in_array($column, $allowedColumns, true)
                ) {
                    continue;
                }

                $sortDirection =
                    strtolower($sort) === 'asc'
                        ? 'asc'
                        : 'desc';

                /*
                | Advanced Search sort menjadi sorting pertama
                */

                $query->orderBy(
                    $column,
                    $sortDirection
                );

                $advancedSortApplied = true;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Jika tidak ada sorting dari Advanced Search,
        | gunakan sorting DataTables.
        |--------------------------------------------------------------------------
        */

        if (!$advancedSortApplied) {

            $query->orderBy(
                $orderColumn,
                $orderDirection
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $start = intval(
            $request->input('start', 0)
        );

        $length = intval(
            $request->input('length', 10)
        );


        /*
        | Proteksi length
        */

        if ($length < 1) {
            $length = 10;
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil data
        |--------------------------------------------------------------------------
        */

        $results = $query
            ->offset($start)
            ->limit($length)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Response DataTables
        |--------------------------------------------------------------------------
        */

        $data = [];


        foreach ($results as $row) {

            $data[] = [

                'NO_ORDER' =>
                    $row->NO_ORDER,

                'Tgl_order' =>
                    $row->Tgl_order,

                'NM_USER' =>
                    $row->NM_USER,

                'ID_DIVISI' =>
                    $row->ID_DIVISI,

                'NM_DIVISI' =>
                    $row->NM_DIVISI,

                'NOTELINE' =>
                    $row->NOTELINE,

                'KODE_BARANG' =>
                    $row->KODE_BARANG,

                'NM_BARANG' =>
                    $row->NM_BARANG,

                'SUB_KATEGORI' =>
                    $row->SUB_KATEGORI,

                'KATEGORI' =>
                    $row->KATEGORI,

                'KATEGORI_UTAMA' =>
                    $row->KATEGORI_UTAMA,

                'QTY_PO' =>
                    $row->QTY_PO,

                'SATUAN' =>
                    $row->SATUAN,

                'IdSupplier' =>
                    $row->IdSupplier,

                'SUPPLIER' =>
                    $row->SUPPLIER,

                'JENIS_PEMBELIAN' =>
                    $row->JENIS_PEMBELIAN,

                'No_terima' =>
                    $row->No_terima,

                'TGL_DATANG' =>
                    $row->TGL_DATANG,

                'QTY_RCV' =>
                    $row->QTY_RCV,

                'NO_SJ' =>
                    $row->NO_SJ,

                'PRICE_RCV' =>
                    $row->PRICE_RCV,

                'DISC_RCV' =>
                    $row->DISC_RCV,

                'PRICE_RCV_PPN' =>
                    $row->PRICE_RCV_PPN,

                'TGL_TRANSFER' =>
                    $row->TGL_TRANSFER,

                'Id_Penagihan' =>
                    $row->Id_Penagihan,

                'No_PIB' =>
                    $row->No_PIB,

                'No_sppb' =>
                    $row->No_sppb,

                'Tgl_sppb' =>
                    $row->Tgl_sppb,

                /*
                | Tetap dikirim ke frontend
                | tetapi tidak ditampilkan
                */

                'Informasi_Cetak' =>
                    $row->Informasi_Cetak,
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | Return JSON
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'draw' =>
                intval(
                    $request->input('draw')
                ),

            'recordsTotal' =>
                $recordsTotal,

            'recordsFiltered' =>
                $recordsFiltered,

            'data' =>
                $data,

        ]);
    }


    public function store(Request $request)
    {
        if (
            $request->input('jenisStore') !==
            'exportToExcel'
        ) {

            return response()->json([
                'error' => 'Invalid store type'
            ], 400);
        }


        $connection = DB::connection('ConnPurchase');

        $query = $connection
            ->table('VW_4496_ORDER_MOVEMENT')
            ->select(
                'NO_ORDER',
                'Tgl_order',
                'NM_USER',
                'NM_DIVISI',
                'KODE_BARANG',
                'NM_BARANG',
                'SUB_KATEGORI',
                'KATEGORI',
                'KATEGORI_UTAMA',
                'QTY_PO',
                'SATUAN',
                'SUPPLIER',
                'JENIS_PEMBELIAN',
                'No_terima',
                'TGL_DATANG',
                'QTY_RCV',
                'NO_SJ',
                'PRICE_RCV',
                'DISC_RCV',
                'PRICE_RCV_PPN',
                'TGL_TRANSFER',
                'Id_Penagihan',
                'No_PIB',
                'No_sppb',
                'Tgl_sppb'
            );


        /*
        |--------------------------------------------------------------------------
        | Filter Export
        |--------------------------------------------------------------------------
        */

        $filters = $request->input('custom_filters', []);

        $allowedColumns = [
            'NO_ORDER',
            'Tgl_order',
            'NM_USER',
            'ID_DIVISI',
            'NM_DIVISI',
            'NOTELINE',
            'KODE_BARANG',
            'NM_BARANG',
            'SUB_KATEGORI',
            'KATEGORI',
            'KATEGORI_UTAMA',
            'QTY_PO',
            'SATUAN',
            'SUPPLIER',
            'JENIS_PEMBELIAN',
            'No_terima',
            'TGL_DATANG',
            'QTY_RCV',
            'NO_SJ',
            'PRICE_RCV',
            'DISC_RCV',
            'PRICE_RCV_PPN',
            'TGL_TRANSFER',
            'Id_Penagihan',
            'No_PIB',
            'No_sppb',
            'Tgl_sppb',
        ];

        $dateColumns = [
            'Tgl_order',
            'TGL_DATANG',
            'TGL_TRANSFER',
            'Tgl_sppb',
        ];


        foreach ($filters as $filter) {

            $column = $filter['column'] ?? null;
            $operator = $filter['operator'] ?? null;
            $value = $filter['value'] ?? null;

            if (
                !$column ||
                !$operator ||
                !in_array($column, $allowedColumns, true)
            ) {
                continue;
            }


            if ($operator === 'like') {

                $query->where(
                    $column,
                    'LIKE',
                    '%' . $value . '%'
                );
            }

            elseif (
                $operator === '=' ||
                $operator === '!='
            ) {

                if (in_array($column, $dateColumns, true)) {

                    $query->whereRaw(
                        'CAST([' . $column . '] AS DATE) ' .
                        $operator .
                        ' ?',
                        [$value]
                    );
                } else {

                    $query->where(
                        $column,
                        $operator,
                        $value
                    );
                }
            }

            elseif ($operator === 'isbetween') {

                $value = is_array($value)
                    ? $value
                    : array_map(
                        'trim',
                        explode(',', $value)
                    );

                if (count($value) === 2) {

                    if (in_array($column, $dateColumns, true)) {

                        $query->whereRaw(
                            'CAST([' . $column . '] AS DATE) BETWEEN ? AND ?',
                            [
                                $value[0],
                                $value[1]
                            ]
                        );
                    } else {

                        $query->whereBetween(
                            $column,
                            [
                                $value[0],
                                $value[1]
                            ]
                        );
                    }
                }
            }

            elseif ($operator === 'notbetween') {

                $value = is_array($value)
                    ? $value
                    : array_map(
                        'trim',
                        explode(',', $value)
                    );

                if (count($value) === 2) {

                    if (in_array($column, $dateColumns, true)) {

                        $query->whereRaw(
                            'CAST([' . $column . '] AS DATE) NOT BETWEEN ? AND ?',
                            [
                                $value[0],
                                $value[1]
                            ]
                        );
                    } else {

                        $query->whereNotBetween(
                            $column,
                            [
                                $value[0],
                                $value[1]
                            ]
                        );
                    }
                }
            }

            elseif ($operator === 'in') {

                $values = is_array($value)
                    ? $value
                    : array_map(
                        'trim',
                        explode(',', $value)
                    );

                $query->whereIn(
                    $column,
                    $values
                );
            }

            elseif ($operator === 'notin') {

                $values = is_array($value)
                    ? $value
                    : array_map(
                        'trim',
                        explode(',', $value)
                    );

                $query->whereNotIn(
                    $column,
                    $values
                );
            }

            elseif ($operator === 'isnull') {

                $query->whereNull($column);
            }

            elseif ($operator === 'isnotnull') {

                $query->whereNotNull($column);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Sorting Export
        |--------------------------------------------------------------------------
        */

        foreach ($filters as $filter) {

            $column = $filter['column'] ?? null;
            $sort = $filter['sort'] ?? null;

            if (
                $column &&
                $sort &&
                in_array($column, $allowedColumns, true) &&
                in_array(strtolower($sort), ['asc', 'desc'], true)
            ) {

                $query->orderBy(
                    $column,
                    strtolower($sort)
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Maximum records
        |--------------------------------------------------------------------------
        */

        $maximumRecords = intval(
            $request->input('maximumRecords', 1000)
        );

        if ($maximumRecords > 0) {
            $query->limit($maximumRecords);
        }


        $results = $query->get();

        return response()->json([
            'data' => $results
        ]);
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
