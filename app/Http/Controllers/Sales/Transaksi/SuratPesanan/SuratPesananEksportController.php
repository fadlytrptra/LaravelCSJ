<?php

namespace App\Http\Controllers\Sales\Transaksi\SuratPesanan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use Session;
use App\Http\Controllers\HakAksesController;


class SuratPesananEksportController extends Controller
{
    public function index()
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('Sales');
        return view('Sales.Transaksi.SuratPesanan.IndexEkspor', compact('access'));
    }
    function spekspor(Request $request)
    {
        $columns = array(
            0 => 'IDSuratPesanan',
            1 => 'NamaCust',
            2 => 'Tgl_Pesan'
        );

        $totalData = DB::connection('ConnSales')
            ->table('T_HeaderPesanan')
            ->select('IDSuratPesanan', 'Tgl_Pesan', 'NamaCust')
            ->leftJoin('T_Customer', 'T_HeaderPesanan.IDCust', '=', 'T_Customer.IDCust')
            ->where('IDJnsSuratPesanan', '=', 3)
            ->whereNotNull('AccManager')
            ->whereNull('Deleted')
            ->orderBy('Tgl_Pesan', 'Desc')
            ->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $sp = DB::connection('ConnSales')
                ->table('T_HeaderPesanan')
                ->select('IDSuratPesanan', 'Tgl_Pesan', 'NamaCust')
                ->leftJoin('T_Customer', 'T_HeaderPesanan.IDCust', '=', 'T_Customer.IDCust')
                ->where('IDJnsSuratPesanan', '=', 3)
                ->whereNotNull('AccManager')
                ->whereNull('Deleted')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            // $posts = Post::offset($start)
            //     ->limit($limit)
            //     ->orderBy($order, $dir)
            //     ->get();
        } else {
            $search = $request->input('search.value');
            $sp = DB::connection('ConnSales')
                ->table('T_HeaderPesanan')
                ->select('IDSuratPesanan', 'Tgl_Pesan', 'NamaCust')
                ->leftJoin('T_Customer', 'T_HeaderPesanan.IDCust', '=', 'T_Customer.IDCust')
                ->where('IDJnsSuratPesanan', '=', 3)
                ->whereNotNull('AccManager')
                ->whereNull('Deleted')
                ->where('IDSuratPesanan', 'LIKE', "%{$search}%")
                ->orWhere('Tgl_Pesan', 'LIKE', "%{$search}%")
                ->orWhere('NamaCust', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = DB::connection('ConnSales')
                ->table('T_HeaderPesanan')
                ->select('IDSuratPesanan', 'Tgl_Pesan', 'NamaCust')
                ->leftJoin('T_Customer', 'T_HeaderPesanan.IDCust', '=', 'T_Customer.IDCust')
                ->where('IDJnsSuratPesanan', '=', 3)
                ->whereNotNull('AccManager')
                ->whereNull('Deleted')
                ->where('IDSuratPesanan', 'LIKE', "%{$search}%")
                ->orWhere('Tgl_Pesan', 'LIKE', "%{$search}%")
                ->orWhere('NamaCust', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($sp)) {
            foreach ($sp as $datasp) {
                $nestedData['IDSuratPesanan'] = $datasp->IDSuratPesanan;
                $nestedData['NamaCust'] = $datasp->NamaCust;
                $nestedData['Tgl_Pesan'] = substr($datasp->Tgl_Pesan, 0, 10);
                if (strstr($datasp->IDSuratPesanan, '/')) {
                    $no_spValue = str_replace('/', '.', $datasp->IDSuratPesanan);
                } else {
                    $no_spValue = $datasp->IDSuratPesanan;
                }
                $csrfToken = Session::get('_token');
                $nestedData['Actions'] = "<button class=\"btn btn-sm btn-info\" onclick=\"openNewWindow('/penyesuaian/" . $no_spValue . "')\">&#x270E; Penyesuaian</button>
                <br> <form onsubmit=\"return confirm('Apakah Anda Yakin ?');\"
                action=\"" . url('/batalSPEkspor/' . $no_spValue) . "\" method=\"POST\"
                                        enctype=\"multipart/form-data\"> <button type=\"submit\"
                                            class=\"btn btn-sm btn-danger\"><span>&#x1F5D1;</span>Batal SP</button>
                                            <input type=\"hidden\" name=\"_token\" value=\"" . $csrfToken . "\">
                                    </form>";

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
        //ga dipake
        // $jenis_sp = DB::connection('ConnSales')->select('exec SP_1486_SLS_LIST_SP @Kode = ?', [1]);
        // $jenis_bayar = DB::connection('ConnSales')->select('exec SP_1486_SLS_LIST_JNSBAYAR');

        //dipake
        $list_sp = DB::connection('ConnSales')->select('exec SP_1486_SLS_LIST_SP_BLM_ACC');
        $mata_uang = DB::connection('ConnSales')->select('exec SP_1486_SLS_LIST_MATAUANG');
        $jenis_harga = DB::connection('ConnSales')->table('T_JenisHargaBarangEksport')->select('*')->get();
        $list_billing = DB::connection('ConnSales')->select('exec SP_1486_SLS_LIST_BILLING');
        $list_customer = DB::connection('ConnSales')->select('exec SP_1486_SLS_LIST_ALL_CUSTOMER @Kode = ?', [1]);
        $list_sales = DB::connection('ConnSales')->select('exec SP_1486_SLS_LIST_SALES');
        $jenis_brg = DB::connection('ConnSales')->select('exec SP_1486_SLS_LIST_JNSBRG');
        $kelompok_utama = DB::connection('ConnInventory')->select('exec SP_1486_SLS_LIST_TYPEBARANG');
        $list_satuan = DB::connection('ConnSales')->select('exec SP_1486_SLS_LIST_SATUAN');
        $access = (new HakAksesController)->HakAksesFiturMaster('Sales');
        // dd($kelompok_utama);
        return view('Sales.Transaksi.SuratPesanan.CreateEkspor', compact('access', 'mata_uang', 'list_customer', 'list_sales', 'jenis_brg', 'kelompok_utama', 'list_satuan', 'list_sp', 'jenis_harga', 'list_billing'));
    }

    public function getKelompok($kelompokUtama)
    {
        $secondOptions = DB::connection('ConnInventory')->select('exec SP_1486_SLS_LIST_KELOMPOK @idKelUt = ?', [$kelompokUtama]);
        // Return the options as JSON data
        return response()->json($secondOptions);
    }
    public function getSubKelompok($kelompok)
    {
        $thirdOptions = DB::connection('ConnInventory')->select('exec SP_1486_SLS_LIST_SUBKEL @idKel = ?', [$kelompok]);
        // dd($thirdOptions);
        // Return the options as JSON data
        return response()->json($thirdOptions);
    }
    public function getKodeBarang($kodeBarang)
    {
        // dd($subKategori);
        $fourthOptions = DB::connection('ConnSales')->select('exec SP_4384_SELECT_KODE_BARANG @XKodeBarang = ?', [$kodeBarang]);
        // dd($fourthOptions);
        return response()->json($fourthOptions);
    }

    public function getNamaBarang($subKelompok)
    {
        // dd($subKategori);
        $fourthOptions = DB::connection('ConnSales')->select('exec SP_1486_SLS_LIST_BARANG @idCorak = ?', [$subKelompok]);
        // dd($fourthOptions);
        return response()->json($fourthOptions);
    }
    function cekNoSP($no_sp)
    {
        $no_spValue = str_replace('.', '/', $no_sp);
        $cek_sp = DB::connection('ConnSales')->select('exec SP_1486_SLS_CEK_NO_SP @IdSuratPesanan = ?', [$no_spValue]);
        return response()->json($cek_sp);
    }
    function isiSatuanInv($idtype)
    {
        $satuan = DB::connection('ConnInventory')->select('exec SP_1486_SLS_LIST_TYPE @Kode = ?, @IdType = ?', [1, $idtype]);
        return response()->json($satuan);
    }
    function getDisplayBarangEkspor($idtype)
    {
        // $data = DB::connection('ConnSales')->select('exec SP_1486_SLS_LIST_DETAIL_SP @IDBarang = ?, @Kode = ?', [$idtype, 2]);
        $data = DB::connection('ConnInventory')->table('VW_TYPE')->select('*')->where('IdType', '=', $idtype)->get();
        return response()->json($data);
    }
    function deleteDetailBarangEksport($idPesanan)
    {
        DB::connection('ConnSales')->statement('exec SP_1486_SLS_MAINT_DETAILPESANAN @Kode = ?, @IDPesanan = ?', [3, $idPesanan]);
        return response()->json("Id Pesanan " . $idPesanan . " sudah dihapus dari database!");
    }
    public function store(Request $request)
    {
        // dd($request->all(), "Masuk Store");
        $user = Auth::user()->NomorUser;
        $noteKirim = ($request->note_kirim == null) ? 0 : 1;
        $jenis_sp = 3;
        $tgl_pesan = $request->tgl_pesan;
        $no_sp = $request->no_spText;
        $no_po = $request->no_po ?? "";
        $tgl_po = $request->tgl_po;
        $no_pi = $request->no_pi ?? "";
        $jenis_hargaBarang = $request->jenis_harga;
        $mata_uang = $request->mata_uang;
        $id_customer = explode(" -", $request->customer);
        $id_sales = $request->sales;
        $id_billing = $request->billing;
        $cargo_ready = $request->cargo_ready ?? "";
        $destination_port = $request->destination_port ?? "";
        $payment_terms = $request->payment_terms ?? "";
        $remarks_quantity = $request->remarks_quantity ?? "";
        $remarks_packing = $request->remarks_packing ?? "";
        $remarks_price = $request->remarks_price ?? "";
        $keterangan =
            $cargo_ready . " | " .
            $payment_terms . " | " .
            $remarks_quantity . " | " .
            $remarks_packing . " | " .
            $remarks_price . " | " .
            $destination_port . " | ".
            $noteKirim;
        $nomor_urut = $request->barang0;
        $nama_barang = $request->barang1;
        $nama_jenisPesanan = $request->barang2;
        $harga_satuan = $request->barang3;
        $qty_pesan = $request->barang4;
        $satuan_jual = $request->barang5;
        // $satuan_jualPI = $request->barang6;
        $general_specificationPI = $request->barang6;
        $general_specificationSP = $request->barang7;
        $keterangan_barang = $request->barang8;
        $size_code = $request->barang9;
        $rencana_kirim = $request->barang10;
        $ppn = $request->barang11;
        $id_jenisPesanan = $request->barang12;
        $kode_barang = $request->barang13;
        $id_type = $request->barang14;
        $id_pesanan = $request->barang15;
        $rencana_kirimCargoReady = $request->barang16;
        $ket_qty = $request->barang17;
        // Combine the individual arrays into a single array
        $combinedArray = [$general_specificationPI, $general_specificationSP, $keterangan_barang, $size_code, $rencana_kirimCargoReady, $nomor_urut, $ket_qty];
        $uraian_pesanan = [];

        foreach ($combinedArray as $values) {
            foreach ($values as $index => $value) {
                if (!isset($uraian_pesanan[$index])) {
                    $uraian_pesanan[$index] = '';
                }
                $uraian_pesanan[$index] .= ($uraian_pesanan[$index] === '' ? '' : ' | ') . $value;
            }
        }

        $uraian_pesanan = array_values($uraian_pesanan); // Reindex the array to start from 0

        // dd($rencana_kirim);
        $Lunas = null;
        $jenis_bayar = 2;
        $syarat_bayar = 0;
        $faktur_pjk = null;
        $kode = 1;

        //maintenance header dulu yaw..
        DB::connection('ConnSales')->statement(
            'exec SP_1486_SLS_MAINT_HEADERPESANAN
        @Kode = ?,
        @IdSuratPesanan = ?,
        @IdJnsSuratPesanan = ?,
        @Tgl_Pesan = ?,
        @IdCust = ?,
        @No_PO = ?,
        @Tgl_PO = ?,
        @No_PI = ?,
        @IdPembayaran = ?,
        @IdSales = ?,
        @IdBill = ?,
        @IdMataUang = ?,
        @SyaratBayar = ?,
        @User_id = ?,
        @Ket = ?,
        @JnsFakturPjk = ?,
        @JenisHargaBarang = ?',
            [$kode, $no_sp, 3, $tgl_pesan, $id_customer[1], $no_po, $tgl_po, $no_pi, $jenis_bayar, $id_sales, $id_billing, $mata_uang, $syarat_bayar, $user, $keterangan, $faktur_pjk, $jenis_hargaBarang],
        );

        // kemudian beralih ke maintenance detail pesanan nich...
        for ($i = 0; $i < count($kode_barang); $i++) {
            DB::connection('ConnSales')->statement(
                'exec SP_1486_SLS_MAINT_DETAILPESANAN @Kode = ?,
            @IDSuratPesanan = ?,
            @KodeBarang = ?,
            @IdBarang = ?,
            @IdJnsBarang = ?,
            @Qty = ?,
            @Satuan = ?,
            @HargaSatuan = ?,
            @Discount = ?,
            @UraianPesanan = ?,
            @TglRencanaKirim = ?,
            @Lunas = ?,
            @PPN = ?,
            @indek = ?',
                [$kode, $no_sp, $kode_barang[$i], $id_type[$i], $id_jenisPesanan[$i], $qty_pesan[$i], $satuan_jual[$i], $harga_satuan[$i], 0.0, $uraian_pesanan[$i], $rencana_kirim[$i], $Lunas ?? null, $ppn[$i], 0.00],
            );
        }
        DB::connection('ConnSales')->statement('exec SP_1486_SLS_ACC_SURATPESANAN @AccManager = ?, @IDSuratPesanan = ?', [$user, $no_sp]);
        return redirect()->back()->with('success', 'Surat Pesanan ' . $no_sp . ' Sudah Dibuat!');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $no_spValue = str_replace('.', '/', $id);
        $header_suratPesanan = DB::connection('ConnSales')->select('exec SP_1486_SLS_LIST_SP_BLM_ACC @IDSURATPESANAN = ?, @Kode = ?', [$no_spValue, 1]);
        $detail_suratPesanan = DB::connection('ConnSales')->select('exec SP_1486_SLS_LIST_DETAIL_SP @IDSURATPESANAN = ?, @Kode = ?', [$no_spValue, 1]);
        $data = [$header_suratPesanan, $detail_suratPesanan];
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        // dd($request->all(), $id, "Masuk Update");
        $no_spValue = str_replace('.', '/', $id);
        $user = Auth::user()->NomorUser;
        $jenis_sp = 3;
        $tgl_pesan = $request->tgl_pesan;
        $no_sp = $request->no_spText;
        $no_po = $request->no_po ?? "";
        $tgl_po = $request->tgl_po;
        $no_pi = $request->no_pi ?? "";
        $jenis_hargaBarang = $request->jenis_harga;
        $mata_uang = $request->mata_uang;
        $id_customer = explode(" -", $request->customer);
        $id_sales = $request->sales;
        $id_billing = $request->billing;
        $cargo_ready = $request->cargo_ready ?? "";
        $destination_port = $request->destination_port ?? "";
        $payment_terms = $request->payment_terms ?? "";
        $remarks_quantity = $request->remarks_quantity ?? "";
        $remarks_packing = $request->remarks_packing ?? "";
        $remarks_price = $request->remarks_price ?? "";
        $keterangan =
            $cargo_ready . " | " .
            $payment_terms . " | " .
            $remarks_quantity . " | " .
            $remarks_packing . " | " .
            $remarks_price . " | " .
            $destination_port;
        $nama_barang = $request->barang0;
        $nama_jenisPesanan = $request->barang1;
        $harga_satuan = $request->barang2;
        $qty_pesan = $request->barang3;
        $satuan_jual = $request->barang4;
        $general_specificationPI = $request->barang5;
        $general_specificationSP = $request->barang6;
        $keterangan_barang = $request->barang7;
        $size_code = $request->barang8;
        $rencana_kirim = $request->barang9;
        $ppn = $request->barang10;
        $id_jenisPesanan = $request->barang11;
        $kode_barang = $request->barang12;
        $id_type = $request->barang13;
        $id_pesanan = $request->barang14;
        $rencana_kirimCargoReady = $request->barang15;
        // Combine the individual arrays into a single array
        $combinedArray = [$general_specificationPI, $general_specificationSP, $keterangan_barang, $size_code, $rencana_kirimCargoReady];
        $uraian_pesanan = [];

        foreach ($combinedArray as $values) {
            foreach ($values as $index => $value) {
                if (!isset($uraian_pesanan[$index])) {
                    $uraian_pesanan[$index] = '';
                }
                $uraian_pesanan[$index] .= ($uraian_pesanan[$index] === '' ? '' : ' | ') . $value;
            }
        }

        $uraian_pesanan = array_values($uraian_pesanan); // Reindex the array to start from 0

        // dd($rencana_kirim);
        $Lunas = null;
        $jenis_bayar = 2;
        $syarat_bayar = 0;
        $faktur_pjk = null;
        $kode = 2;

        //maintenance header dulu yaw..
        DB::connection('ConnSales')->statement(
            'exec SP_1486_SLS_MAINT_HEADERPESANAN
        @Kode = ?,
        @IdSuratPesanan = ?,
        @IdJnsSuratPesanan = ?,
        @Tgl_Pesan = ?,
        @IdCust = ?,
        @No_PO = ?,
        @Tgl_PO = ?,
        @No_PI = ?,
        @IdPembayaran = ?,
        @IdSales = ?,
        @IdBill = ?,
        @IdMataUang = ?,
        @SyaratBayar = ?,
        @User_id = ?,
        @Ket = ?,
        @JnsFakturPjk = ?,
        @JenisHargaBarang = ?',
            [$kode, $no_sp, 3, $tgl_pesan, $id_customer[1], $no_po, $tgl_po, $no_pi, $jenis_bayar, $id_sales, $id_billing, $mata_uang, $syarat_bayar, $user, $keterangan, $faktur_pjk, $jenis_hargaBarang],
        );

        // kemudian beralih ke maintenance detail pesanan nich...
        for ($i = 0; $i < count($kode_barang); $i++) {
            if (is_null($id_pesanan[$i])) {
                DB::connection('ConnSales')->statement(
                    'exec SP_1486_SLS_MAINT_DETAILPESANAN @Kode = ?,
                @IDSuratPesanan = ?,
                @KodeBarang = ?,
                @IdBarang = ?,
                @IdJnsBarang = ?,
                @Qty = ?,
                @Satuan = ?,
                @HargaSatuan = ?,
                @Discount = ?,
                @UraianPesanan = ?,
                @TglRencanaKirim = ?,
                @Lunas = ?,
                @PPN = ?,
                @indek = ?',
                    [1, $no_sp, $kode_barang[$i], $id_type[$i], $id_jenisPesanan[$i], $qty_pesan[$i], $satuan_jual[$i], $harga_satuan[$i], 0.0, $uraian_pesanan[$i], $rencana_kirim[$i], $Lunas ?? null, $ppn[$i], 0.00],
                );
            } else {
                DB::connection('ConnSales')->statement(
                    'exec SP_1486_SLS_MAINT_DETAILPESANAN @Kode = ?,
                @IDSuratPesanan = ?,
                @IDPesanan = ?,
                @KodeBarang = ?,
                @IdBarang = ?,
                @IdJnsBarang = ?,
                @Qty = ?,
                @Satuan = ?,
                @HargaSatuan = ?,
                @Discount = ?,
                @UraianPesanan = ?,
                @TglRencanaKirim = ?,
                @Lunas = ?,
                @PPN = ?,
                @indek = ?',
                    [$kode, $no_sp, $id_pesanan[$i], $kode_barang[$i], $id_type[$i], $id_jenisPesanan[$i], $qty_pesan[$i], $satuan_jual[$i], $harga_satuan[$i], 0.0, $uraian_pesanan[$i], $rencana_kirim[$i], $Lunas ?? null, $ppn[$i], 0.00],
                );
            }

        }
        return redirect()->back()->with('success', 'Surat Pesanan ' . $no_sp . ' Sudah Diubah!');
    }

    public function destroy($id)
    {
        // dd($id, "Masuk Destroy");
        $no_spValue = str_replace('.', '/', $id);
        DB::connection('ConnSales')->statement('exec SP_1486_SLS_DEL_HEADER_DETAIL_PESANAN @IdSuratPesanan = ?', [$no_spValue]);
        return redirect()->back()->with('success', 'Surat Pesanan ' . $id . ' Sudah Dihapus!'); //->with(['success' => 'Data berhasil dihapus!']);
    }

    function penyesuaian(Request $request, $id)
    {
        $kode = 2;
        $no_spValue = str_replace('.', '/', $id);
        // dd('Masuk Penyesuaian SP Ekspor', $id, $request->all(), $no_spValue);
        $user = Auth::user()->NomorUser;
        $jenis_sp = 3;
        $tgl_pesan = $request->tgl_pesan;
        $no_sp = $request->no_spText;
        $no_po = $request->no_po ?? "";
        $tgl_po = $request->tgl_po;
        $no_pi = $request->no_pi ?? "";
        $jenis_hargaBarang = $request->jenis_harga;
        $mata_uang = $request->mata_uang;
        $id_customer = explode(" -", $request->customer);
        $id_sales = $request->sales;
        $id_billing = $request->billing;
        $cargo_ready = $request->cargo_ready ?? "";
        $destination_port = $request->destination_port ?? "";
        $payment_terms = $request->payment_terms ?? "";
        $remarks_quantity = $request->remarks_quantity ?? "";
        $remarks_packing = $request->remarks_packing ?? "";
        $remarks_price = $request->remarks_price ?? "";
        $keterangan =
            $cargo_ready . " | " .
            $payment_terms . " | " .
            $remarks_quantity . " | " .
            $remarks_packing . " | " .
            $remarks_price . " | " .
            $destination_port;
        $nomor_urut = $request->barang0;
        $nama_barang = $request->barang1;
        $nama_jenisPesanan = $request->barang2;
        $harga_satuan = $request->barang3;
        $qty_pesan = $request->barang4;
        $satuan_jual = $request->barang5;
        // $satuan_jualPI = $request->barang6;
        $general_specificationPI = $request->barang6;
        $general_specificationSP = $request->barang7;
        $keterangan_barang = $request->barang8;
        $size_code = $request->barang9;
        $rencana_kirim = $request->barang10;
        $ppn = $request->barang11;
        $id_jenisPesanan = $request->barang12;
        $kode_barang = $request->barang13;
        $id_type = $request->barang14;
        $id_pesanan = $request->barang15;
        $rencana_kirimCargoReady = $request->barang16;
        $ket_qty = $request->barang20;
        // Combine the individual arrays into a single array
        $combinedArray = [$general_specificationPI, $general_specificationSP, $keterangan_barang, $size_code, $rencana_kirimCargoReady, $nomor_urut, $ket_qty];
        $uraian_pesanan = [];

        foreach ($combinedArray as $values) {
            foreach ($values as $index => $value) {
                if (!isset($uraian_pesanan[$index])) {
                    $uraian_pesanan[$index] = '';
                }
                $uraian_pesanan[$index] .= ($uraian_pesanan[$index] === '' ? '' : ' | ') . $value;
            }
        }

        $uraian_pesanan = array_values($uraian_pesanan); // Reindex the array to start from 0

        // dd($uraian_pesanan);
        $Lunas = $request->barang17;
        $jenis_bayar = 2;
        $syarat_bayar = 0;
        $faktur_pjk = null;


        DB::connection('ConnSales')->statement(
            'exec SP_1486_SLS_MAINT_HEADERPESANAN
        @Kode = ?,
        @IdSuratPesanan = ?,
        @IdJnsSuratPesanan = ?,
        @Tgl_Pesan = ?,
        @IdCust = ?,
        @No_PO = ?,
        @Tgl_PO = ?,
        @No_PI = ?,
        @IdPembayaran = ?,
        @IdSales = ?,
        @IdBill = ?,
        @IdMataUang = ?,
        @SyaratBayar = ?,
        @User_id = ?,
        @Ket = ?,
        @JnsFakturPjk = ?,
        @JenisHargaBarang = ?',
            [$kode, $no_spValue, 3, $tgl_pesan, $id_customer[1], $no_po, $tgl_po, $no_pi, $jenis_bayar, $id_sales, $id_billing, $mata_uang, $syarat_bayar, $user, $keterangan, $faktur_pjk, $jenis_hargaBarang],
        );

        // kemudian beralih ke maintenance detail pesanan nich...
        for ($i = 0; $i < count($kode_barang); $i++) {
            if (is_null($id_pesanan[$i])) {
                DB::connection('ConnSales')->statement(
                    'exec SP_1486_SLS_MAINT_DETAILPESANAN @Kode = ?,
                @IDSuratPesanan = ?,
                @KodeBarang = ?,
                @IdBarang = ?,
                @IdJnsBarang = ?,
                @Qty = ?,
                @Satuan = ?,
                @HargaSatuan = ?,
                @Discount = ?,
                @UraianPesanan = ?,
                @TglRencanaKirim = ?,
                @Lunas = ?,
                @PPN = ?,
                @indek = ?',
                    [1, $no_sp, $kode_barang[$i], $id_type[$i], $id_jenisPesanan[$i], $qty_pesan[$i], $satuan_jual[$i], $harga_satuan[$i], 0.0, $uraian_pesanan[$i], $rencana_kirim[$i], $Lunas[$i] ?? null, $ppn[$i], 0.00],
                );
            } else {
                DB::connection('ConnSales')->statement(
                    'exec SP_1486_SLS_MAINT_DETAILPESANAN @Kode = ?,
                @IDSuratPesanan = ?,
                @IDPesanan = ?,
                @KodeBarang = ?,
                @IdBarang = ?,
                @IdJnsBarang = ?,
                @Qty = ?,
                @Satuan = ?,
                @HargaSatuan = ?,
                @Discount = ?,
                @UraianPesanan = ?,
                @TglRencanaKirim = ?,
                @Lunas = ?,
                @PPN = ?,
                @indek = ?',
                    [$kode, $no_sp, $id_pesanan[$i], $kode_barang[$i], $id_type[$i], $id_jenisPesanan[$i], $qty_pesan[$i], $satuan_jual[$i], $harga_satuan[$i], 0.0, $uraian_pesanan[$i], $rencana_kirim[$i], $Lunas[$i] ?? null, $ppn[$i], 0.00],
                );
            }
        }
        return redirect()->route('SuratPesananEkspor.index')->with('success', 'Surat Pesanan ' . $no_sp . ' Sudah Diubah!');
    }

    function batalSP($id)
    {
        // dd('Masuk Batal SP Ekspor', $id);
        $user = Auth::user()->NomorUser;
        $no_spValue = str_replace('.', '/', $id);

        $date = date('m/d/Y', strtotime('now'));
        $do1 = db::connection('ConnSales')->select('SELECT COUNT(dbo.T_DeliveryOrder.IDDO)
					                                FROM         dbo.T_DeliveryOrder INNER JOIN
					                                                      dbo.T_DetailPesanan ON dbo.T_DeliveryOrder.IDPesanan = dbo.T_DetailPesanan.IDPesanan INNER JOIN
					                                                      dbo.vw_prg_barang ON dbo.T_DetailPesanan.IDBarang = dbo.vw_prg_barang.IDBarang
					                                WHERE     (dbo.T_DeliveryOrder.Dikeluarkan IS NOT NULL OR
					                                                dbo.T_DeliveryOrder.Dikeluarkan IS NULL) AND (dbo.T_DetailPesanan.IDSuratPesanan = \'' . $no_spValue . '\')
						                                    AND (dbo.T_DeliveryOrder.KetBatal IS NULL)');

        $do2 = db::connection('ConnSales')->select('SELECT COUNT(T_DeliveryOrder.IDDO)
                                                    FROM         T_DeliveryOrder INNER JOIN
                                                                          T_DetailPesanan ON T_DeliveryOrder.IDPesanan = T_DetailPesanan.IDPesanan INNER JOIN
                                                                          VW_PRG_BARANG ON T_DetailPesanan.IDBarang = VW_PRG_BARANG.KodeBarang AND T_DeliveryOrder.IdType = VW_PRG_BARANG.IDBarang
                                                    WHERE     (T_DeliveryOrder.Dikeluarkan IS NOT NULL OR
                              T_DeliveryOrder.Dikeluarkan IS NULL) AND (LEN(T_DetailPesanan.IDBarang) = \'9\') AND (T_DeliveryOrder.KetBatal IS NULL)  AND (dbo.T_DetailPesanan.IDSuratPesanan = \'' . $no_spValue . '\')');
        $formula = db::connection('ConnSales')->select('SELECT COUNT(*)
                                    FROM   T_FormulaSP_KITE
                                    GROUP BY NoSP
                                    HAVING (NoSP = \'' . $no_spValue . '\')');
        // dd($do1[0]->{""}, $do2[0]->{""}, $formula);
        if ($do1[0]->{""} == 0 || $do2[0]->{""} == 0) {
            db::connection('ConnSales')->statement('UPDATE 	T_HEADERPESANAN
                                                            SET deleted = \'' . trim(Auth::user()->NomorUser) . '\' +\' - \'+ \'' . $date . '\'
                                                            WHERE IdSuratPesanan = \'' . $no_spValue . '\'');
            if (!empty($formula)) {
                $pp = db::connection('ConnSales')->select('SELECT SUM(BahanPP) + SUM(AfalanPP)
                                                            FROM         T_FormulaSP_KITE
                                                            WHERE     (NoSP = \'' . $no_spValue . '\')');
                $pe = db::connection('ConnSales')->select('SELECT SUM(BahanPE) + SUM(AfalanPE)
                                                            FROM         T_FormulaSP_KITE
                                                            WHERE     (NoSP = \'' . $no_spValue . '\')');
                $mb = db::connection('ConnSales')->select('SELECT SUM(BahanMB) + SUM(AfalanMB)
                                                            FROM         T_FormulaSP_KITE
                                                            WHERE     (NoSP = \'' . $no_spValue . '\')');
                db::connection('ConnInventory')->statement('UPDATE SaldoKITE
                                                            set SaldoPP = SaldoPP + ' . $pp . ',
                                                                SaldoPE = SaldoPE + ' . $pe . ',
                                                                SaldoMB = SaldoMB + ' . $mb . '');
                db::connection('ConnInventory')->statement('DELETE FROM T_FormulaSP_KITE
                                                            WHERE     (NoSP = \'' . $no_spValue . '\')');
            }
            return redirect()->back()->with('success', 'Surat Pesanan ' . $no_spValue . ' Sudah Dibatalkan!');
        } else {
            return redirect()->back()->with('error', 'Surat Pesanan ' . $no_spValue . 'Tidak Bisa Di Batalkan Karena Sudah Ada DO Yang Di ACC Maupun Permohonan DO!');
        }
    }
}
