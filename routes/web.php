<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Beli\Transaksi\CreateSPPBController;
use App\Http\Controllers\Accounting\Piutang\BKMDPPelunasanController;
use App\Http\Controllers\Inventory\Master\StokBarangController;
use App\Http\Controllers\Inventory\Informasi\KartuStokController;
use App\Http\Controllers\Inventory\Master\KodePerkiraanController;
use App\Http\Controllers\Inventory\Master\MaintenanceTypeController;
use App\Http\Controllers\Inventory\Master\MaintenanceObjekController;
use App\Http\Controllers\Inventory\Informasi\CariKodeBarangController;
use App\Http\Controllers\Inventory\Informasi\LacakTransaksiController;
use App\Http\Controllers\Inventory\Transaksi\Hibah\AccHibahController;
use App\Http\Controllers\Inventory\Informasi\TransaksiHarianController;
use App\Http\Controllers\Inventory\Informasi\TransaksiBulananController;
use App\Http\Controllers\Inventory\Transaksi\TerimaPurchasingController;
use App\Http\Controllers\Inventory\Transaksi\Mutasi\MhnPemberiController;
use App\Http\Controllers\Inventory\Transaksi\Mutasi\MhnPenerimaController;
use App\Http\Controllers\Inventory\Informasi\ListDetailTransaksiController;
use App\Http\Controllers\Inventory\Transaksi\Hibah\PenerimaHibahController;
use App\Http\Controllers\Inventory\Transaksi\Mutasi\AccSatuDivisiController;
use App\Http\Controllers\Inventory\Transaksi\Mutasi\PemberiBarangController;
use App\Http\Controllers\Inventory\Transaksi\PemakaianGelondonganController;
use App\Http\Controllers\Inventory\Transaksi\Hibah\PermohonanHibahController;
use App\Http\Controllers\Inventory\Transaksi\Mutasi\AccMhnPenerimaController;
use App\Http\Controllers\Inventory\Transaksi\Mutasi\MhnMasukKeluarController;
use App\Http\Controllers\Inventory\Transaksi\Mutasi\ReturPenjualanController;
use App\Http\Controllers\Inventory\Transaksi\Konversi\KonversiBarangController;
use App\Http\Controllers\Inventory\Transaksi\Mutasi\AccPemberiBarangController;
use App\Http\Controllers\Inventory\Transaksi\Mutasi\PemberiBarangAssController;
use App\Http\Controllers\Inventory\Transaksi\Mutasi\AccMhnMasukKeluarController;
use App\Http\Controllers\Inventory\Transaksi\Mutasi\PermohonanPenerimaController;
use App\Http\Controllers\Inventory\Transaksi\Konversi\AccKonversiBarangController;
use App\Http\Controllers\Inventory\Transaksi\Mutasi\PermohonanSatuDivisiController;
use App\Http\Controllers\Inventory\Transaksi\Penyesuaian\PenyesuaianBarangController;
use App\Http\Controllers\Inventory\Transaksi\Mutasi\PermohonanPenerimaBenangController;
use App\Http\Controllers\Inventory\Transaksi\Penghangusan\PenghangusanBarangController;
use App\Http\Controllers\Inventory\Transaksi\Penyesuaian\AccPenyesuaianBarangController;
use App\Http\Controllers\Inventory\Transaksi\TerimaBenang\TerimaBenangGedungDController;
use App\Http\Controllers\Inventory\Transaksi\TerimaBenang\TerimaBenangTropodoController;
use App\Http\Controllers\Inventory\Transaksi\Mutasi\KeluarBarangUntukPenjualanController;
use App\Http\Controllers\Inventory\Transaksi\Mutasi\PengembalianPascaPenjualanController;
use App\Http\Controllers\Inventory\Transaksi\Penghangusan\AccPenghangusanBarangController;
use App\Http\Controllers\Accounting\Piutang\UpdateKursBKMController;
use App\Http\Controllers\Accounting\Piutang\BatalBKMTransistorisController;
use App\Http\Controllers\Accounting\Piutang\MaintenanceBKMTransistorisBankController;
use App\Http\Controllers\Accounting\Piutang\BKMBKKNotaKreditController;
use App\Http\Controllers\Accounting\Piutang\BKMBKKPembulatanController;
use App\Http\Controllers\Laporan\CetakBKMController;
use App\Http\Controllers\Laporan\CetakBKKController;
use App\Http\Controllers\Laporan\CetakNotaFakturController;
use App\Http\Controllers\Laporan\CetakSPPBBTTBController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\IntercomController;


$redirectIfAuthenticated = function () {
    if (Auth::guest())
        return view('auth.login');
    else
        return redirect('/home');
};

Route::get('/', $redirectIfAuthenticated);
Route::get('/logout', $redirectIfAuthenticated);

//Auth::routes();
Route::get('/refresh-csrf', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});

Route::get('/login', 'App\Http\Controllers\LoginController@index')->name('login');
Route::post('Register', 'App\Http\Controllers\LoginController@Register')->name('register');
Route::post('login', 'App\Http\Controllers\LoginController@login');
Route::post('/logout', 'App\Http\Controllers\LoginController@logout')->name('logout');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');
    Route::post('/pengumuman/store', [HomeController::class, 'store'])->name('pengumuman.store');
    Route::get('/meeting', [MeetingController::class, 'index'])->name('meeting.index');
    Route::get('/meeting/rekap', [MeetingController::class, 'rekapMeeting']);
    Route::get('/meeting/{id}', [MeetingController::class, 'show'])->name('meeting.show');
    Route::post('/meeting/room', [MeetingController::class, 'storeRoom']);
    Route::post('/meeting/storeMeeting', [MeetingController::class, 'storeMeeting']);
    Route::post('/meeting/update', [MeetingController::class, 'updateMeeting']);
    Route::post('/meeting/cancel', [MeetingController::class, 'cancelMeeting']);
    Route::post('/meeting/admin/store', [MeetingController::class, 'storeAdministrator']);
    Route::get('/meeting/monthly/{room}', [MeetingController::class, 'monthlyMeetings']);
    Route::resource('intercom', IntercomController::class);

    #region Beli
    Route::get('Beli', 'App\Http\Controllers\HomeController@Beli');

    Route::get('/PurchaseOrder/no-sppb', [App\Http\Controllers\Beli\TransaksiBeli\PurchaseOrderController::class, 'getNoSppbByDivisi'])->name('purchaseorder.no_sppb');
    Route::get('/PurchaseOrder/detail-sppb', [App\Http\Controllers\Beli\TransaksiBeli\PurchaseOrderController::class, 'getDetailSppb'])->name('purchaseorder.detail_sppb');
    Route::post('/purchaseorder/update-detail-sppb', [App\Http\Controllers\Beli\TransaksiBeli\PurchaseOrderController::class, 'updateDetailSppb']);

    Route::post('/purchaseorder/simpan-harga', [App\Http\Controllers\Beli\TransaksiBeli\PurchaseOrderController::class, 'simpanHarga'])->name('purchaseorder.simpanHarga');
    Route::get('/PurchaseOrder/mata-uang', [App\Http\Controllers\Beli\TransaksiBeli\PurchaseOrderController::class, 'listMataUang'])->name('purchaseorder.mata_uang');
    Route::get('/PurchaseOrder/supplier', [App\Http\Controllers\Beli\TransaksiBeli\PurchaseOrderController::class, 'listSupplier'])->name('purchaseorder.supplier');
    Route::get('/PurchaseOrder/supplier', [App\Http\Controllers\Beli\TransaksiBeli\PurchaseOrderController::class, 'supplier']);

    Route::resource('ListOrder', App\Http\Controllers\Beli\Transaksi\ListOrderController::class);
    Route::resource('DaftarHarga', App\Http\Controllers\Beli\Informasi\DaftarHargaController::class);
    Route::resource('Approve', App\Http\Controllers\Beli\Transaksi\ApproveController::class);
    Route::resource('FinalApprove', App\Http\Controllers\Beli\Transaksi\FinalApproveController::class);
    Route::resource('RevisiPO', App\Http\Controllers\Beli\Transaksi\RevisiPOController::class);
    Route::resource('MaintenanceOrderPembelian', App\Http\Controllers\Beli\Transaksi\MaintenanceOrderPembelianController::class);
    Route::resource('CariType', App\Http\Controllers\Beli\Informasi\CariTypeController::class);
    Route::resource('Supplier', App\Http\Controllers\Beli\Master\SupplierController::class);
    Route::resource('HistoryPembelianMaster', App\Http\Controllers\Beli\Master\HistoryPembelianMasterController::class);
    Route::resource('MaintenanceGolonganDanMesin', App\Http\Controllers\Beli\Master\MaintenanceGolonganDanMesinController::class);
    Route::resource('MaintenanceKodeBarang', App\Http\Controllers\Beli\Master\MaintenanceKodeBarangController::class);
    Route::resource('BatalTransfer', App\Http\Controllers\Beli\Master\BatalTransferController::class);
    Route::resource('PurchaseOrder', App\Http\Controllers\Beli\TransaksiBeli\PurchaseOrderController::class);
    Route::resource('IsiSupplierHarga', App\Http\Controllers\Beli\TransaksiBeli\IsiSupplierHargaController::class);
    Route::resource('ReturBTTB', App\Http\Controllers\Beli\TransaksiBeli\ReturBTTBController::class);
    Route::resource('IsiBeaImpor', App\Http\Controllers\Beli\TransaksiBeli\IsiBeaController::class);
    Route::resource('CreateBTTB', App\Http\Controllers\Beli\TransaksiBeli\CreateBTTBController::class);
    Route::resource('CreateSPPB', App\Http\Controllers\Beli\Transaksi\CreateSPPBController::class);
    Route::resource('KoreksiStatusBeli', App\Http\Controllers\Beli\TransaksiBeli\KoreksiStatusBeliController::class);
    Route::resource('ListOrderSudahAppManager', App\Http\Controllers\Beli\TransaksiBeli\ListOrderAppManagerController::class);
    Route::resource('TransferBarang', App\Http\Controllers\Beli\TransaksiBeli\TransferBarangController::class);
    Route::resource('ListSemuaOrder', App\Http\Controllers\Beli\Informasi\ListSemuaOrderController::class);
    Route::get('/ListOrder/{divisi}/{tglAwal}/{tglAkhir}/{Me}/Filter', 'App\Http\Controllers\Beli\Transaksi\ListOrderController@Filter')->name('listorder.filter');
    Route::get('/MaintenanceOrderPembeliann/CekNoTrans', 'App\Http\Controllers\Beli\Transaksi\MaintenanceOrderPembelianController@cekNoTrans')->name('maintenanceorderpembelian.ceknotrans');
    Route::get('/MaintenanceOrderPembeliann/KodeBarang', 'App\Http\Controllers\Beli\Transaksi\MaintenanceOrderPembelianController@kodeBarang')->name('maintenanceorderpembelian.kodebarang');
    Route::get('/MaintenanceOrderPembeliann/Data', 'App\Http\Controllers\Beli\Transaksi\MaintenanceOrderPembelianController@data')->name('maintenanceorderpembelian.data');
    Route::get('/MaintenanceOrderPembeliann/Kategori', 'App\Http\Controllers\Beli\Transaksi\MaintenanceOrderPembelianController@kategori')->name('maintenanceorderpembelian.kategori');
    Route::get('/MaintenanceOrderPembeliann/SubKategori', 'App\Http\Controllers\Beli\Transaksi\MaintenanceOrderPembelianController@subKategori')->name('maintenanceorderpembelian.subkategori');
    Route::get('/MaintenanceOrderPembeliann/KodeBarang', 'App\Http\Controllers\Beli\Transaksi\MaintenanceOrderPembelianController@kodeBarang')->name('maintenanceorderpembelian.kodebarang');
    Route::get('/MaintenanceOrderPembeliann/Kategori', 'App\Http\Controllers\Beli\Transaksi\MaintenanceOrderPembelianController@kategori')->name('maintenanceorderpembelian.kategori');
    Route::get('/MaintenanceOrderPembeliann/SubKategori', 'App\Http\Controllers\Beli\Transaksi\MaintenanceOrderPembelianController@subKategori')->name('maintenanceorderpembelian.subkategori');
    Route::get('/MaintenanceOrderPembeliann/NamaBarang', 'App\Http\Controllers\Beli\Transaksi\MaintenanceOrderPembelianController@namaBarang')->name('maintenanceorderpembelian.namabarang');
    Route::get('/MaintenanceOrderPembeliann/Golongan', 'App\Http\Controllers\Beli\Transaksi\MaintenanceOrderPembelianController@golongan')->name('maintenanceorderpembelian.golongan');
    Route::get('/MaintenanceOrderPembeliann/MesinGolongan', 'App\Http\Controllers\Beli\Transaksi\MaintenanceOrderPembelianController@mesinGolongan')->name('maintenanceorderpembelian.mesingolongan');
    Route::get('/MaintenanceOrderPembeliann/Saldo', 'App\Http\Controllers\Beli\Transaksi\MaintenanceOrderPembelianController@saldo')->name('maintenanceorderpembelian.saldo');
    Route::get('/MaintenanceOrderPembeliann/CekNoTrans', 'App\Http\Controllers\Beli\Transaksi\MaintenanceOrderPembelianController@cekNotrans')->name('maintenanceorderpembelian.ceknotrans');
    Route::post('/MaintenanceOrderPembeliann/Save', 'App\Http\Controllers\Beli\Transaksi\MaintenanceOrderPembelianController@save')->name('maintenanceorderpembelian.save');
    Route::put('/MaintenanceOrderPembeliann/Submit', 'App\Http\Controllers\Beli\Transaksi\MaintenanceOrderPembelianController@submit')->name('maintenanceorderpembelian.submit');
    Route::delete('/MaintenanceOrderPembeliann/Delete', 'App\Http\Controllers\Beli\Transaksi\MaintenanceOrderPembelianController@delete')->name('maintenanceorderpembelian.delete');
    Route::get('/Approve/{id}/show', 'App\Http\Controllers\Beli\Transaksi\ApproveController@show')->name('approve.show');
    Route::post('/Approve/{id}/up', 'App\Http\Controllers\Beli\Transaksi\ApproveController@update')->name('approve.update');
    Route::get('/FinalApprove/{id}/show', 'App\Http\Controllers\Beli\Transaksi\FinalApproveController@show')->name('finalapprove.show');
    Route::post('/FinalApprove/{id}/up', 'App\Http\Controllers\Beli\Transaksi\FinalApproveController@update')->name('finalapprove.update');
    Route::get('/exp-pdf', function () {return view('Beli.Transaksi.exportToPdf');});
    Route::post('/CreateSPPB/uploadDokumentasi', [CreateSPPBController::class, 'uploadDokumentasi'])->name('sppb.uploadDokumentasi');
    Route::get('/CreateSPPB/getDokumentasi/{noSppb}', [CreateSPPBController::class, 'getDokumentasi']);
    Route::delete('/CreateSPPB/deleteDokumentasi/{noSppb}', [CreateSPPBController::class, 'deleteDokumentasi']);


    #region Sales
    Route::get('Sales', 'App\Http\Controllers\HomeController@Sales');

    Route::resource('DeliveryOrder', App\Http\Controllers\Sales\Transaksi\DeliveryOrder\DeliveryOrderController::class);
    Route::resource('DeliveryOrderManager', App\Http\Controllers\Sales\Transaksi\DeliveryOrder\DeliveryOrderManagerController::class);
    Route::resource('InputPEB', App\Http\Controllers\Sales\Transaksi\DeliveryOrder\InputPEBController::class);
    Route::resource('SuratJalan', App\Http\Controllers\Sales\Transaksi\SuratJalan\SuratJalanController::class);
    Route::resource('BatalSJ', App\Http\Controllers\Sales\Transaksi\SuratJalan\BatalSuratJalanController::class);
    Route::resource('SuratJalanManager', App\Http\Controllers\Sales\Transaksi\SuratJalan\SuratJalanManagerController::class);
    Route::resource('PascaKirim', App\Http\Controllers\Sales\Transaksi\SuratJalan\PascaKirimController::class);
    Route::resource('CetakSP', App\Http\Controllers\Sales\Cetak\CetakSPController::class);
    Route::resource('CetakDO', App\Http\Controllers\Sales\Cetak\CetakDOController::class);
    Route::resource('CetakSJ', App\Http\Controllers\Sales\Cetak\CetakSJController::class);
    Route::resource('CetakSPEkspor', App\Http\Controllers\Sales\Cetak\CetakSPEksportController::class);
    Route::resource('CetakPI', App\Http\Controllers\Sales\Cetak\CetakPIController::class);
    Route::resource('CetakBonKas', App\Http\Controllers\Sales\Cetak\CetakBonKasController::class);
    Route::resource('Customer', App\Http\Controllers\Sales\Master\CustomerController::class);
    Route::resource('Billing', App\Http\Controllers\Sales\Master\BillingController::class);
    Route::resource('Expeditor', App\Http\Controllers\Sales\Master\ExpeditorController::class);
    Route::resource('CariBarcode', App\Http\Controllers\Sales\ToolPenjualan\CariBarcodeController::class);
    Route::resource('SuratPesananEkspor', App\Http\Controllers\Sales\Transaksi\SuratPesanan\SuratPesananEksportController::class);
    Route::resource('SuratPesanan', App\Http\Controllers\Sales\Transaksi\SuratPesanan\SuratPesananController::class);
    Route::resource('PenyesuaianHargaSatuan2', App\Http\Controllers\Sales\Transaksi\PenyesuaianHargaSatuan2Controller::class);
    Route::resource('SuratPesananManager', App\Http\Controllers\Sales\Transaksi\SuratPesanan\SuratPesananManagerController::class);
    Route::resource('SuratPesananDirektur', App\Http\Controllers\Sales\Transaksi\SuratPesanan\SuratPesananDirekturController::class);
    Route::resource('PenyesuaianSuratPesanan', App\Http\Controllers\Sales\Transaksi\SuratPesanan\PenyesuaianSuratPesananController::class);
    Route::resource('BarcodeKerta2', App\Http\Controllers\Sales\ToolPenjualan\BarcodeKerta2Controller::class);
    Route::resource('BatalJual', App\Http\Controllers\Sales\ToolPenjualan\BatalJualController::class);
    Route::resource('GantiRPM', App\Http\Controllers\Sales\ToolPenjualan\GantiRPMController::class);
    Route::resource('HapusCIR', App\Http\Controllers\Sales\ToolPenjualan\HapusCIRController::class);
    Route::resource('PenjualanBarcode', App\Http\Controllers\Sales\ToolPenjualan\PenjualanBarcodeController::class);
    Route::resource('PenjualanNyangkut', App\Http\Controllers\Sales\ToolPenjualan\PenjualanNyangkutController::class);
    Route::resource('SetengahJadiNyangkut', App\Http\Controllers\Sales\ToolPenjualan\SetengahJadiNyangkutController::class);
    Route::resource('ScanBarcode', App\Http\Controllers\Sales\Penjualan\ScanBarcodeController::class);
    Route::resource('BarcodeJual', App\Http\Controllers\Sales\Penjualan\BarcodeJualController::class);
    Route::resource('AccPenjualan', App\Http\Controllers\Sales\Penjualan\AccPenjualanController::class);
    Route::get('/Customer/{id}/show', 'App\Http\Controllers\Sales\Master\CustomerController@show')->name('customer.show');
    Route::post('/Customer/{id}/up', 'App\Http\Controllers\Sales\Master\CustomerController@update')->name('customer.update');
    // Route::get('Sales/Master/Customer/getDetail/{idcust}', 'ControllerCustomer@getDetail');
    // Route::get('Customer/{IDCust}', 'CustomerController@show');
    Route::post('/Customer/{id}', 'App\Http\Controllers\Sales\Master\CustomerController@destroy')->name('customer.destroy');
    Route::get('/Billing/{id}/show', 'App\Http\Controllers\Sales\Master\BillingController@show')->name('billing.show');
    Route::post('/Billing/{id}/up', 'App\Http\Controllers\Sales\Master\BillingController@update')->name('billing.update');
    // Route::get('Billing/{IDCust}', 'BillingController@show');
    Route::post('/Billing/{id}', 'App\Http\Controllers\Sales\Master\BillingController@destroy')->name('billing.destroy');
    Route::get('/Expeditor/{id}/show', 'App\Http\Controllers\Sales\Master\ExpeditorController@show')->name('expeditor.show');
    Route::post('/Expeditor/{id}/up', 'App\Http\Controllers\Sales\Master\ExpeditorController@update')->name('expeditor.update');
    // Route::get('Expeditor/{IDCust}', 'ExpeditorController@show');
    Route::post('/Expeditor/{id}', 'App\Http\Controllers\Sales\Master\ExpeditorController@destroy')->name('expeditor.destroy');
    //Route::get('SuratPesanan', [SuratPesananController::class, 'index'])->name('suratpesanan.index');
    Route::get('/SuratPesanan/{id}/show', 'App\Http\Controllers\Sales\Transaksi\SuratPesanan\SuratPesananController@show')->name('suratpesanan.show');
    Route::post('/SuratPesanan/{id}/up', 'App\Http\Controllers\Sales\Transaksi\SuratPesanan\SuratPesananController@update')->name('suratpesanan.update');
    Route::get('/editSP/{id}', 'App\Http\Controllers\Sales\Transaksi\SuratPesanan\SuratPesananController@edit')->name('suratpesanan.edit');
    Route::get('/SuratPesanan/createRobby', 'App\Http\Controllers\Sales\Transaksi\SuratPesanan\SuratPesananController@createRobby');
    // Route::get('SuratPesanan/{IDCust}', 'SuratPesananController@show');
    Route::post('/SuratPesanan/{id}', 'App\Http\Controllers\Sales\Transaksi\SuratPesanan\SuratPesananController@destroy')->name('suratpesanan.destroy');
    Route::post('/SuratPesananManager/{id}/up', 'App\Http\Controllers\Sales\Transaksi\SuratPesanan\SuratPesananManagerController@update')->name('suratpesananmanager.update');
    Route::post('/SuratPesananManager/{id}/del', 'App\Http\Controllers\Sales\Transaksi\SuratPesanan\SuratPesananManagerController@destroy')->name('suratpesananmanager.destroy');
    Route::post('/SuratPesananManager/upall', 'App\Http\Controllers\Sales\Transaksi\SuratPesanan\SuratPesananManagerController@updateAll');
    Route::get('/SuratPesananManager/penyesuaian/suratpesanan', 'App\Http\Controllers\Sales\Transaksi\SuratPesanan\SuratPesananManagerController@penyesuaian');
    Route::get('/penyesuaian/{suratPesanan}', 'App\Http\Controllers\Sales\Transaksi\SuratPesanan\SuratPesananManagerController@getPenyesuaianSP');
    Route::post('/penyesuaiansp/koreksi', 'App\Http\Controllers\Sales\Transaksi\SuratPesanan\SuratPesananManagerController@koreksiPenyesuaianSP');
    Route::post('/penyesuaiansp/batalsp', 'App\Http\Controllers\Sales\Transaksi\SuratPesanan\SuratPesananManagerController@batalspPenyesuaianSP');
    Route::post('/batalsplokal/{nosp}', 'App\Http\Controllers\Sales\Transaksi\SuratPesanan\SuratPesananManagerController@batalspPenyesuaianSP');
    Route::post('/SuratPesananManager/upPenyesuaian', 'App\Http\Controllers\Sales\Transaksi\SuratPesanan\SuratPesananManagerController@updatePenyesuaian');
    Route::get('/options/kategori/{kategoriUtama}', 'App\Http\Controllers\Sales\Transaksi\SuratPesanan\SuratPesananController@getKategori');
    Route::get('/options/subKategori/{kategori}', 'App\Http\Controllers\Sales\Transaksi\SuratPesanan\SuratPesananController@getSubKategori');
    Route::get('/options/namaBarang/{subKategori}', 'App\Http\Controllers\Sales\Transaksi\SuratPesanan\SuratPesananController@getNamaBarang');
    Route::get('/options/namaBarangExport/{subKategori}', 'App\Http\Controllers\Sales\Transaksi\SuratPesanan\SuratPesananController@getNamaBarangExport');
    Route::get('/satuan/{kode_barang}', 'App\Http\Controllers\Sales\Transaksi\SuratPesanan\SuratPesananController@getSatuanBarang');
    Route::get('/satuan1/{kode_barang}', 'App\Http\Controllers\Sales\Transaksi\SuratPesanan\SuratPesananController@getSatuanBarang1');
    Route::get('/displaybarang/{kode_barang}', 'App\Http\Controllers\Sales\Transaksi\SuratPesanan\SuratPesananController@getDisplayBarang');
    Route::get('/saldoinventory/{kode_barang}', 'App\Http\Controllers\Sales\Transaksi\SuratPesanan\SuratPesananController@getSaldoInventory');
    Route::get('/beratstandard/{kode_barang}', 'App\http\Controllers\Sales\Transaksi\SuratPesanan\SuratPesananController@getBeratStandard');
    Route::get('/deletedetail/{id_pesanan}', 'App\http\Controllers\Sales\Transaksi\SuratPesanan\SuratPesananController@deleteDetailPesanan');
    // Route::post('/tambahmantap', 'App\http\Controllers\Sales\Transaksi\SuratPesanan\SuratPesananController@store');
    // Route::post('/submit-form', [SuratPesananController::class, 'submitForm']);
    Route::post('splokal', 'App\Http\Controllers\Sales\Transaksi\SuratPesanan\SuratPesananController@splokal')->name('splokal');
    // Route::any('splokal', 'App\Http\Controllers\Sales\Transaksi\SuratPesanan\SuratPesananController@splokal')->name('splokal');
    Route::get('/options/spekspor/kelompok/{kelompokUtama}', 'App\Http\Controllers\Sales\Transaksi\SuratPesanan\SuratPesananEksportController@getKelompok');
    Route::get('/options/spekspor/subKelompok/{kelompok}', 'App\Http\Controllers\Sales\Transaksi\SuratPesanan\SuratPesananEksportController@getSubKelompok');
    Route::get('/options/spekspor/namaBarang/{subKelompok}', 'App\Http\Controllers\Sales\Transaksi\SuratPesanan\SuratPesananEksportController@getNamaBarang');
    Route::get('/options/spekspor/kodeBarang/{kodeBarang}', 'App\Http\Controllers\Sales\Transaksi\SuratPesanan\SuratPesananEksportController@getKodeBarang');
    Route::get('/options/spekspor/isiSatuan/{idtype}', 'App\Http\Controllers\Sales\Transaksi\SuratPesanan\SuratPesananEksportController@isiSatuanInv');
    Route::get('/cekNoSPEkspor/{noSp}', 'App\Http\Controllers\Sales\Transaksi\SuratPesanan\SuratPesananEksportController@cekNoSP');
    Route::get('/displaybarangekspor/{idtype}', 'App\Http\Controllers\Sales\Transaksi\SuratPesanan\SuratPesananEksportController@getDisplayBarangEkspor');
    Route::get('/deleteDetailBarangEksport/{idpesanan}', 'App\Http\Controllers\Sales\Transaksi\SuratPesanan\SuratPesananEksportController@deleteDetailBarangEksport');
    Route::post('spekspor', 'App\Http\Controllers\Sales\Transaksi\SuratPesanan\SuratPesananEksportController@spekspor')->name('spekspor');
    Route::post('penyesuaianEkspor/{noSp}', 'App\Http\Controllers\Sales\Transaksi\SuratPesanan\SuratPesananEksportController@penyesuaian')->name('penyesuaianEkspor');
    Route::post('batalSPEkspor/{noSp}', 'App\Http\Controllers\Sales\Transaksi\SuratPesanan\SuratPesananEksportController@batalSP')->name('batalSPEkspor');
    Route::post('/DeliveryOrder/{id}', 'App\Http\Controllers\Sales\Transaksi\DeliveryOrder\DeliveryOrderController@destroy')->name('deliveryorder.destroy');
    Route::post('/DeliveryOrder/{id}/up', 'App\Http\Controllers\Sales\Transaksi\DeliveryOrder\DeliveryOrderController@update')->name('deliveryorder.update');
    Route::post('/DeliveryOrderManager/up', 'App\Http\Controllers\Sales\Transaksi\DeliveryOrder\DeliveryOrderManagerController@update')->name('deliveryordermanager.update');
    Route::get('/DeliveryOrderManager/BatalDo/index', 'App\Http\Controllers\Sales\Transaksi\DeliveryOrder\DeliveryOrderManagerController@indexDestroy')->name('deliveryordermanager.destroy');
    Route::post('/DeliveryOrderManager/destroy', 'App\Http\Controllers\Sales\Transaksi\DeliveryOrder\DeliveryOrderManagerController@destroy');
    Route::get('/options/nomorsp/{customer}', 'App\Http\Controllers\Sales\Transaksi\DeliveryOrder\DeliveryOrderController@getSuratPesanan');
    Route::get('/options/id_pesanan/{nomor_sp}', 'App\Http\Controllers\Sales\Transaksi\DeliveryOrder\DeliveryOrderController@getIdPesanan');
    Route::get('/options/barang/{id_pesanan}', 'App\Http\Controllers\Sales\Transaksi\DeliveryOrder\DeliveryOrderController@getBarang');
    Route::get('/options/kelompokutama/{kodeBarang}', 'App\Http\Controllers\Sales\Transaksi\DeliveryOrder\DeliveryOrderController@getKelompokUtama');
    Route::get('/options/kelompok/{kelompokUtama}/{kodeBarang}', 'App\Http\Controllers\Sales\Transaksi\DeliveryOrder\DeliveryOrderController@getKelompok');
    Route::get('/options/subkelompok/{kelompokUtama}/{kodeBarang}', 'App\Http\Controllers\Sales\Transaksi\DeliveryOrder\DeliveryOrderController@getSubKelompok');
    Route::get('/options/saldo/{subKelompok}/{kodeBarang}', 'App\Http\Controllers\Sales\Transaksi\DeliveryOrder\DeliveryOrderController@getSaldo');
    Route::get('/options/nomorDO', 'App\Http\Controllers\Sales\Transaksi\DeliveryOrder\DeliveryOrderController@getNomorDeliveryOrder');
    Route::post('dopeb', 'App\Http\Controllers\Sales\Transaksi\DeliveryOrder\InputPEBController@dopeb')->name('dopeb');
    Route::post('/SuratJalan/{id}', 'App\Http\Controllers\Sales\Transaksi\SuratJalan\SuratJalanController@destroy')->name('suratjalan.destroy');
    Route::post('/SuratJalan/{id}/up', 'App\Http\Controllers\Sales\Transaksi\SuratJalan\SuratJalanController@update')->name('suratjalan.update');
    Route::post('/SuratJalanManager/up', 'App\Http\Controllers\Sales\Transaksi\SuratJalan\SuratJalanManagerController@update')->name('suratjalanmanager.update');
    Route::get('/options/suratpesanan/{customer}', 'App\Http\Controllers\Sales\Transaksi\SuratJalan\SuratJalanController@getSuratPesanan');
    Route::get('/options/deliveryorder/{suratpesanan}', 'App\Http\Controllers\Sales\Transaksi\SuratJalan\SuratJalanController@getDeliveryOrder');
    Route::get('/options/selecteddeliveryorder/{deliveryorder}', 'App\Http\Controllers\Sales\Transaksi\SuratJalan\SuratJalanController@getDataDeliveryOrder');
    Route::get('/options/getdatadeliveryorder/{idtransaksi}', 'App\Http\Controllers\Sales\Transaksi\SuratJalan\SuratJalanController@getDetailDataDeliveryOrder');
    Route::get('/options/loadliststokqtydo/{idtype}', 'App\Http\Controllers\Sales\Transaksi\SuratJalan\SuratJalanController@getDataListStokQtyDO');
    Route::get('/options/loadlistjualqtydo/{idtransaksi}', 'App\Http\Controllers\Sales\Transaksi\SuratJalan\SuratJalanController@getDataListJualQtyDO');
    Route::get('/options/qtyDO/{idtransaksi}', 'App\Http\Controllers\Sales\Transaksi\SuratJalan\SuratJalanController@getDataQtyDeliveryOrder');
    Route::post('/isi/qtyDO', 'App\Http\Controllers\Sales\Transaksi\SuratJalan\SuratJalanController@postQtyDO');
    Route::get('/options/customer/{id}', 'App\Http\Controllers\Sales\Transaksi\SuratJalan\SuratJalanController@getCustomer');
    Route::get('/options/pascakirimsp/{customer}', 'App\Http\Controllers\Sales\Transaksi\SuratJalan\PascaKirimController@getSuratPesanan');
    Route::get('/options/barangpesanan/{suratpesanan}/{suratjalan}', 'App\Http\Controllers\Sales\Transaksi\SuratJalan\PascaKirimController@getBarangPesanan');
    Route::get('/options/returkirim/{kodebarang}', 'App\Http\Controllers\Sales\Transaksi\SuratJalan\PascaKirimController@getReturKirim');
    Route::get('/options/nomorSJ', 'App\Http\Controllers\Sales\Transaksi\SuratJalan\SuratJalanController@getNomorSuratJalan');
    Route::get('/options/editSJ/{id}', 'App\Http\Controllers\Sales\Transaksi\SuratJalan\SuratJalanController@getDetailSuratJalan');
    Route::get('/nosp/{tanggal}', 'App\Http\Controllers\Sales\Cetak\CetakSPController@getSuratPesananSelect');
    Route::get('/nospeksport/{tanggal}', 'App\Http\Controllers\Sales\Cetak\CetakSPEksportController@getSuratPesananSelect');
    Route::get('/nopieksport/{tanggal}', 'App\Http\Controllers\Sales\Cetak\CetakPIController@getSuratPesananSelect');
    Route::get('/jenisspekspor/{no_spValue}', 'App\Http\Controllers\Sales\Cetak\CetakSPEksportController@getJenisSp');
    Route::get('/jenispiekspor/{no_spValue}', 'App\Http\Controllers\Sales\Cetak\CetakPIController@getJenisSp');
    Route::get('/options/jenissp/{nosp}', 'App\Http\Controllers\Sales\Cetak\CetakSPController@getJenisSp');
    Route::get('/viewprint/{nosp}', 'App\Http\Controllers\Sales\Cetak\CetakSPController@getViewPrint');
    Route::get('/viewprinteksport/{no_spValue}', 'App\Http\Controllers\Sales\Cetak\CetakSPEksportController@getViewPrint');
    Route::get('/viewprintpi/{no_spValue}', 'App\Http\Controllers\Sales\Cetak\CetakPIController@getViewPrint');
    // Route::get('/print/suratpesanan/{nosp}', 'App\Http\Controllers\Sales\Cetak\CetakSPController@printSuratPesanan');
    Route::get('/dosudahacc/{tanggal}', 'App\Http\Controllers\Sales\Cetak\CetakDOController@getDeliveryOrderSudahACC');
    Route::get('/dobelumacc/{tanggal}', 'App\Http\Controllers\Sales\Cetak\CetakDOController@getDeliveryOrderBelumACC');
    // Route::get('/print/deliveryorder/{nodo}', 'App\Http\Controllers\Sales\Cetak\CetakDOController@printDeliveryOrder');
    Route::get('/optionsCetakSuratJalan/{tanggal}', 'App\Http\Controllers\Sales\Cetak\CetakSJController@getSuratJalan');
    // Route::get('/print/suratjalan/{nosj}', 'App\Http\Controllers\Sales\Cetak\CetakSJController@printSuratJalan');
    Route::get('/cetakSuratJalanPPN/{tanggal}/{nosj}/{jenissj}', 'App\Http\Controllers\Sales\Cetak\CetakSJController@getDataCetakSuratJalan');
    Route::get('/cariBarcodeIdTypeDispresiasi/{kodeBarang}', 'App\Http\Controllers\Sales\ToolPenjualan\CariBarcodeController@getIdTypeDispresiasi');
    Route::get('/cariBarcodeIdTypeTmpGudang/{kodeBarang}', 'App\Http\Controllers\Sales\ToolPenjualan\CariBarcodeController@getIdTypeTmpGudang');
    Route::POST('/cariBarcodeFilter/action', 'App\Http\Controllers\Sales\ToolPenjualan\CariBarcodeController@cariBarcodeFilter');
    Route::get('/batalJualInputBarcode/{kodeBarang}', 'App\Http\Controllers\Sales\ToolPenjualan\BatalJualController@getInputBarcode');
    Route::post('/BatalJual/up', 'App\Http\Controllers\Sales\ToolPenjualan\BatalJualController@update')->name('bataljual.update');
    Route::get('/scanBarcodeLihatData/{date}', 'App\Http\Controllers\Sales\Penjualan\ScanBarcodeController@scanBarcodeLihatData');
    Route::get('/scanBarcodeDetailData/{idType}/{kodeBarang}/{tglMutasi}', 'App\Http\Controllers\Sales\Penjualan\ScanBarcodeController@scanBarcodeDetailData');
    Route::delete('AccPenjualan/{kodebarang}/{noindeks}', 'App\Http\Controllers\Sales\Penjualan\AccPenjualanController@destroy');
    Route::get('/accPenjualanTampilData/{idtransaksi}', 'App\Http\Controllers\Sales\Penjualan\AccPenjualanController@accPenjualanTampilData');
    Route::get('/accPenjualanTampilBarcode/{IdType}/{KodeBarang}', 'App\Http\Controllers\Sales\Penjualan\AccPenjualanController@accPenjualanTampilBarcode');
    Route::resource('AccPenjualanCloth', App\Http\Controllers\Sales\Penjualan\AccPenjualanClothController::class);
    #endregion

    #region EDP
    Route::get('/EDP', 'App\Http\Controllers\HomeController@EDP');
    Route::resource('MaintenanceHakAkses', App\Http\Controllers\EDP\MaintenanceHakAksesController::class);
    Route::resource('MaintenanceUserWeb', App\Http\Controllers\EDP\MaintenanceUserWebController::class);
    Route::get('/AllFitur/{IdProgram}/{NomorPegawai}', 'App\Http\Controllers\EDP\MaintenanceHakAksesController@getAllFitur');
    Route::post('/AllFitur/edit', 'App\Http\Controllers\EDP\MaintenanceHakAksesController@EditUserFitur');
    Route::resource('IsOnline', App\Http\Controllers\EDP\IsOnlineController::class);
    Route::post('/MaintenanceIsOnline/update', [App\Http\Controllers\EDP\IsOnlineController::class, 'updateIsOnline'])->name('maintenance.isonline.update');
    #endregion

    #region Accounting
    Route::get('Accounting', 'App\Http\Controllers\HomeController@Accounting');

    //Master
    Route::resource('MaintenanceBank', App\Http\Controllers\Accounting\Master\MaintenanceBankController::class);
    Route::resource('MaintenanceMataUang', App\Http\Controllers\Accounting\Master\MaintenanceMataUangController::class);
    Route::resource('MaintenanceStatusSupplier', App\Http\Controllers\Accounting\Master\MaintenanceStatusSupplierController::class);

    Route::resource('MPIsiDetail', App\Http\Controllers\Accounting\Hutang\MPIsiDetailController::class);
    // Route::post('handle_form_submission_faktur', 'IsiDeatilFakturPajak@handleFormSubmission');
    Route::get('detaildivisi/{idDivisi}', 'App\Http\Controllers\Accounting\Hutang\MPIsiDetailController@getDataDivisi');
    Route::get('detailtabelpo/{noPO}', 'App\Http\Controllers\Accounting\Hutang\MPIsiDetailController@getTabelPO');
    Route::resource('MaintenancePenagihan', App\Http\Controllers\Accounting\Hutang\MaintenancePenagihanController::class);

    Route::resource('BatalPenagihan', App\Http\Controllers\Accounting\Hutang\BatalPenagihanController::class);
    Route::get('detailpenagihan/{idPenagihan}', 'App\Http\Controllers\Accounting\Hutang\BatalPenagihanController@getDataPenagihan');

    Route::resource('UpdatePIB', App\Http\Controllers\Accounting\Hutang\UpdatePIBController::class);
    Route::resource('ACCSerahTerimaPenagihan', App\Http\Controllers\Accounting\Hutang\ACCSerahTerimaPenagihanController::class);
    Route::resource('MaintenancePenagihandiRETUR', App\Http\Controllers\Accounting\Hutang\PenagihandiRETURController::class);
    Route::resource('MaintenancePelunasanHutang', App\Http\Controllers\Accounting\Hutang\PelunasanHutangController::class);
    // Route::get('MaintenancePelunasanHutang', 'App\Http\Controllers\Accounting\Hutang\PelunasanHutangController@PelunasanHutang');
    Route::resource('MaintenanceJurnal', App\Http\Controllers\Accounting\Hutang\MaintenanceJurnalBeliController::class);
    Route::resource('RekapHutang', App\Http\Controllers\Accounting\Hutang\RekapHutangController::class);
    Route::resource('PenyesuaianSaldoSupplier', App\Http\Controllers\Accounting\Hutang\PenyesuaianSaldoSupplierController::class);
    Route::resource('MaintenancePengajuanBKK', App\Http\Controllers\Accounting\Hutang\PengajuanBKKController::class);
    Route::resource('MaintenanceACCBKK', App\Http\Controllers\Accounting\Hutang\ACCBKKController::class);
    Route::post('/MaintenanceBKKKRR2/getGroup', [App\Http\Controllers\Accounting\Hutang\MaintenanceBKKController::class, 'getGroup']);
    Route::resource('MaintenanceBKKKRR2', App\Http\Controllers\Accounting\Hutang\MaintenanceBKKController::class);
    Route::get('getBankSelect', 'App\Http\Controllers\Accounting\Hutang\MaintenanceBKKController@getBankSelect');
    Route::get('MaintenanceBKKKRR2Print', 'App\Http\Controllers\Accounting\Hutang\MaintenanceBKKController@print');

    Route::resource('MaintenanceKurs', App\Http\Controllers\Accounting\Hutang\MaintenanceKursController::class);

    Route::resource('MaintenanceTTKRR1', App\Http\Controllers\Accounting\Hutang\MaintenanceTTKRR1Controller::class);
    Route::resource('MaintenanceACCBayarTTKRR1', App\Http\Controllers\Accounting\Hutang\MaintenanceACCBayarTTKRR1Controller::class);
    Route::get('getSupplierTTKRR1', 'App\Http\Controllers\Accounting\Hutang\MaintenanceTTKRR1Controller@getSupplierTTKRR1');
    Route::get('getTabelListDetailBrg/{idSupplier}', 'App\Http\Controllers\Accounting\Hutang\MaintenanceTTKRR1Controller@getTabelListDetailBrg');

    Route::get('ACCBayarTT', 'App\Http\Controllers\Accounting\Hutang\ACCBayarTTController@ACCBayarTT');
    Route::resource('MaintenanceBKKKRR1', App\Http\Controllers\Accounting\Hutang\MaintenanceBKKKRR1Controller::class);
    Route::resource('MaintenanceBKMKRR1', App\Http\Controllers\Accounting\Hutang\MaintenanceBKMKRR1Controller::class);

    Route::resource('MaintenanceKodePerkiraanBKK', App\Http\Controllers\Accounting\Hutang\KodePerkiraanBKKController::class);
    Route::get('getIdBKKKdPrk/{BlnThn}', 'App\Http\Controllers\Accounting\Hutang\KodePerkiraanBKKController@getIdBKKKdPrk');
    Route::get('getIdBKKKdPrk2/{BlnThn}', 'App\Http\Controllers\Accounting\Hutang\KodePerkiraanBKKController@getIdBKKKdPrk2');
    Route::get('getTabelRincianBKK/{idBKK}', 'App\Http\Controllers\Accounting\Hutang\KodePerkiraanBKKController@getTabelRincianBKK');

    Route::resource('MaintenanceKursBKK', App\Http\Controllers\Accounting\Hutang\MaintenanceKursBKKController::class);

    Route::resource('BatalBKK', App\Http\Controllers\Accounting\Hutang\BatalBKKController::class);
    Route::get('getIdBKKBesar/{bulanTahun}', 'App\Http\Controllers\Accounting\Hutang\BatalBKKController@getIdBKKBesar');
    Route::get('getIdBKKKecil/{bulanTahun}', 'App\Http\Controllers\Accounting\Hutang\BatalBKKController@getIdBKKKecil');
    Route::get('getListBKKBtlBKK/{idBKKSelect}', 'App\Http\Controllers\Accounting\Hutang\BatalBKKController@getListBKKBtlBKK');
    Route::get('getCheckBtlBKK/{idBKKSelect}', 'App\Http\Controllers\Accounting\Hutang\BatalBKKController@getCheckBtlBKK');

    Route::resource('MaintenanceUraianBKK', App\Http\Controllers\Accounting\Hutang\UraianBKKController::class);
    Route::get('getCheckBKKIdBKK/{idBKK}', 'App\Http\Controllers\Accounting\Hutang\UraianBKKController@getCheckBKKIdBKK');
    Route::get('getListBKK/{idBKK}', 'App\Http\Controllers\Accounting\Hutang\UraianBKKController@getListBKK');
    Route::get('getListBKKTotalIdBKK/{idBKK}', 'App\Http\Controllers\Accounting\Hutang\UraianBKKController@getListBKKTotalIdBKK');

    //Piutang
    Route::resource('MaintenanceBKMTransistorisBank', MaintenanceBKMTransistorisBankController::class);
    Route::resource('BatalBKMTransistoris', BatalBKMTransistorisController::class);

    Route::resource('MaintenanceFakturPajakPenjualan', App\Http\Controllers\Accounting\Piutang\MaintenanceFakturPajakPenjualanController::class);
    Route::resource('MaintenanceBKMPenagihan', App\Http\Controllers\Accounting\Piutang\MaintenanceBKMPenagihanController::class);
    Route::get('detailtabelpenagihan/{bulan}/{tahun}', 'App\Http\Controllers\Accounting\Piutang\MaintenanceBKMPenagihanController@getTabelPelunasan');
    Route::get('detailbank', 'App\Http\Controllers\Accounting\Piutang\MaintenanceBKMPenagihanController@getDataBank');
    Route::get('tabeldetailpelunasan/{idPelunasan}', 'App\Http\Controllers\Accounting\Piutang\MaintenanceBKMPenagihanController@getTabelDetailPelunasan');
    Route::get('detailkodeperkiraan/{kode}', 'App\Http\Controllers\Accounting\Piutang\MaintenanceBKMPenagihanController@getKodePerkiraan');
    Route::get('tabelkuranglebih/{idPelunasan}', 'App\Http\Controllers\Accounting\Piutang\MaintenanceBKMPenagihanController@getTabelKurangLebih');
    Route::get('getTabelTampilBKMPenagihan/{tanggalInputTampil}/{tanggalInputTampil2}', 'App\Http\Controllers\Accounting\Piutang\MaintenanceBKMPenagihanController@getTabelTampilBKMPenagihan');
    Route::get('tabelbiaya/{idPelunasan}', 'App\Http\Controllers\Accounting\Piutang\MaintenanceBKMPenagihanController@getTabelBiaya');
    Route::get('cekNoPelunasanBKMPenagihan/{idPelunasan}/{idCustomer}', 'App\Http\Controllers\Accounting\Piutang\MaintenanceBKMPenagihanController@cekNoPelunasanBKMPenagihan');
    Route::get('cekJumlahRincianBKMPenagihan/{idPelunasan}', 'App\Http\Controllers\Accounting\Piutang\MaintenanceBKMPenagihanController@cekJumlahRincianBKMPenagihan');
    Route::post('insertUpdateBKMPenagihan/groupbkm', 'App\Http\Controllers\Accounting\Piutang\MaintenanceBKMPenagihanController@insertUpdateBKMPenagihan');
    Route::get('getCetakBKMNoPenagihan/{idBKMInput}', 'App\Http\Controllers\Accounting\Piutang\MaintenanceBKMPenagihanController@getCetakBKMNoPenagihan');
    Route::get('getCetakBKMJumlahPelunasan/{idBKMInput}', 'App\Http\Controllers\Accounting\Piutang\MaintenanceBKMPenagihanController@getCetakBKMJumlahPelunasan');
    // Route::get('prosesSisaPiutang/{idPelunasan}', 'App\Http\Controllers\Accounting\Piutang\MaintenanceBKMPenagihanController@prosesSisaPiutang');

    Route::resource('MaintenanceBKMNoPenagihan', App\Http\Controllers\Accounting\Piutang\BKMNoPenagihanController::class);
    Route::get('detailcustomer/{kode?}', 'App\Http\Controllers\Accounting\Piutang\BKMNoPenagihanController@getNamaCustomer');
    Route::get('detailmatauang/', 'App\Http\Controllers\Accounting\Piutang\BKMNoPenagihanController@getMataUang');
    Route::get('detailbank', 'App\Http\Controllers\Accounting\Piutang\BKMNoPenagihanController@getDataBank');
    Route::get('jenispembayaran', 'App\Http\Controllers\Accounting\Piutang\BKMNoPenagihanController@getJenisPembayaran');
    Route::get('detailkodeperkiraan/{kode}', 'App\Http\Controllers\Accounting\Piutang\BKMNoPenagihanController@getKodePerkiraan');
    Route::get('detailjenisbank/{idBank}', 'App\Http\Controllers\Accounting\Piutang\BKMNoPenagihanController@getJenisBank');
    Route::get('getidbkm/{idBank}/{tanggalInput}', 'App\Http\Controllers\Accounting\Piutang\BKMNoPenagihanController@getUraianEnter');
    Route::get('tabeltampilbkm/{tanggalInputTampil}/{tanggalInputTampil2}', 'App\Http\Controllers\Accounting\Piutang\BKMNoPenagihanController@getTabelTampilBKM');
    //Route::get('BKMNoPenagihan', 'App\Http\Controllers\Accounting\Piutang\BKMNoPenagihanController@BKMNoPenagihan');

    Route::resource('CreateBKM', App\Http\Controllers\Accounting\Piutang\BKMCashAdvance\CreateBKMController::class);
    Route::get('detailtabelpelunasan2/{bulan}/{tahun}', 'App\Http\Controllers\Accounting\Piutang\BKMCashAdvance\CreateBKMController@getTabelPelunasan');
    Route::get('detailkodeperkiraan/{kode}', 'App\Http\Controllers\Accounting\Piutang\BKMCashAdvance\CreateBKMController@getKodePerkiraan');
    Route::get('detailjenisbankk/{idBank}', 'App\Http\Controllers\Accounting\Piutang\BKMCashAdvance\CreateBKMController@getJenisBank');
    Route::get('tabeltampilbkm/{tanggalInputTampil}/{tanggalInputTampil2}', 'App\Http\Controllers\Accounting\Piutang\BKMCashAdvance\CreateBKMController@getTabelTampilBKM');
    Route::get('getJenisBankCreateBKM/{idBank}', 'App\Http\Controllers\Accounting\Piutang\BKMCashAdvance\CreateBKMController@getJenisBankCreateBKM');
    Route::post('insertUpdateCreateBKM', 'App\Http\Controllers\Accounting\Piutang\BKMCashAdvance\CreateBKMController@insertUpdateCreateBKM');
    Route::post('insertUpdateCreateBKM2', 'App\Http\Controllers\Accounting\Piutang\BKMCashAdvance\CreateBKMController@insertUpdateCreateBKM2');
    Route::get('getCetak/{idBKMInput}', 'App\Http\Controllers\Accounting\Piutang\BKMCashAdvance\CreateBKMController@getCetak');

    Route::resource('UpdateDetailBKM', App\Http\Controllers\Accounting\Piutang\BKMCashAdvance\UpdateDetailBKMController::class);
    Route::get('tabeldatapelunasan/{bulan}/{tahun}', 'App\Http\Controllers\Accounting\Piutang\BKMCashAdvance\UpdateDetailBKMController@getTabelPelunasan');
    Route::get('cektabelpelunasan/{idPelunasan}', 'App\Http\Controllers\Accounting\Piutang\BKMCashAdvance\UpdateDetailBKMController@cekTabelPelunasan');
    Route::get('tabeldetpelunasan/{idPelunasan}', 'App\Http\Controllers\Accounting\Piutang\BKMCashAdvance\UpdateDetailBKMController@getTabelDetailPelunasan');
    Route::get('tabeldetkuranglebih/{idPelunasan}', 'App\Http\Controllers\Accounting\Piutang\BKMCashAdvance\UpdateDetailBKMController@getTabelKurangLebih');
    Route::get('dettabelkuranglebih/{idPelunasan}', 'App\Http\Controllers\Accounting\Piutang\BKMCashAdvance\UpdateDetailBKMController@getTabelKurangLebih');
    Route::get('dettabelbiaya/{idPelunasan}', 'App\Http\Controllers\Accounting\Piutang\BKMCashAdvance\UpdateDetailBKMController@getTabelBiaya');
    Route::get('tabeltampilbkmcashadv/{tanggalInputTampil}/{tanggalInputTampil2}', 'App\Http\Controllers\Accounting\Piutang\BKMCashAdvance\UpdateDetailBKMController@getTabelTampilBKM');
    Route::get('getCetakUpdateDetailBKM/{idBKMInput}', 'App\Http\Controllers\Accounting\Piutang\BKMCashAdvance\UpdateDetailBKMController@getCetakUpdateDetailBKM');

    Route::resource('BKMTransitorisBank', App\Http\Controllers\Accounting\Piutang\BKMTransitorisBankController::class);
    Route::get('getmatauang', 'App\Http\Controllers\Accounting\Piutang\BKMTransitorisBankController@getMataUang');
    Route::get('getbank', 'App\Http\Controllers\Accounting\Piutang\BKMTransitorisBankController@getBank');
    Route::get('getjenispembayaran', 'App\Http\Controllers\Accounting\Piutang\BKMTransitorisBankController@getJenisPembayaran');
    Route::get('getkodeperkiraan', 'App\Http\Controllers\Accounting\Piutang\BKMTransitorisBankController@getKodePerkiraan');
    Route::get('getidbkk/{idBank}/{tanggal}', 'App\Http\Controllers\Accounting\Piutang\BKMTransitorisBankController@getUraianEnter');
    Route::get('getidbkmtransitoris/{idBank}/{tanggal}', 'App\Http\Controllers\Accounting\Piutang\BKMTransitorisBankController@getUraianEnterBKM');
    Route::get('tabeltampilbkmtransitoris/{tanggalInputTampilBKM}/{tanggalInputTampilBKM2}', 'App\Http\Controllers\Accounting\Piutang\BKMTransitorisBankController@getTabelTampilBKM');
    Route::get('tabeltampilbkktransitoris/{tanggalInputTampilBKK}/{tanggalInputTampilBKK2}', 'App\Http\Controllers\Accounting\Piutang\BKMTransitorisBankController@getTabelTampilBKK');

    Route::resource('BatalBKMTransitoris', App\Http\Controllers\Accounting\Piutang\BatalBKMTransitorisController::class);
    Route::get('getIdBKMBatal3/{bulanTahun}', 'App\Http\Controllers\Accounting\Piutang\BatalBKMTransitorisController@getIdBKM3');
    Route::get('getIdBKMBatal4/{bulanTahun}', 'App\Http\Controllers\Accounting\Piutang\BatalBKMTransitorisController@getIdBKM4');
    Route::get('getDataBatalBKM/{idBKM}', 'App\Http\Controllers\Accounting\Piutang\BatalBKMTransitorisController@getDataBKM');
    Route::get('cekBatalBKK/{idBKM}', 'App\Http\Controllers\Accounting\Piutang\BatalBKMTransitorisController@cekBatalBKK');
    Route::delete('deletedata/{idBKM}/{alasan}', 'App\Http\Controllers\Accounting\Piutang\BatalBKMTransitorisController@hapus');

    Route::resource('MaintenanceBKMxBKKPembulatan', BKMBKKPembulatanController::class);
    Route::get('tabeldetailbkmbkk/{bulan}/{tahun}', 'App\Http\Controllers\Accounting\Piutang\BKMBKKPembulatanController@getTabelPelunasan');
    Route::get('tabeldetbiayabkmbkk/{idBKM}', 'App\Http\Controllers\Accounting\Piutang\BKMBKKPembulatanController@getTabelDetailBiaya');
    Route::get('getBankPembulatan', 'App\Http\Controllers\Accounting\Piutang\BKMBKKPembulatanController@getBankPembulatan');
    Route::get('getJenisBankPembulatan/{idBank}', 'App\Http\Controllers\Accounting\Piutang\BKMBKKPembulatanController@getJenisBankPembulatan');
    Route::get('getIDBKK/{idBank}/{tanggal}', 'App\Http\Controllers\Accounting\Piutang\BKMBKKPembulatanController@getIDBKK');
    Route::get('getTabelTampilBKKPembulatan/{tanggalInputTampilBKK}/{tanggalInputTampilBKK2}', 'App\Http\Controllers\Accounting\Piutang\BKMBKKPembulatanController@getTabelTampilBKKPembulatan');
    Route::post('insertUpdate', 'App\Http\Controllers\Accounting\Piutang\BKMBKKPembulatanController@insertUpdate');
    Route::get('getCetakBKMBKKPembulatan/{idBKKTampil}', 'App\Http\Controllers\Accounting\Piutang\BKMBKKPembulatanController@getCetakBKMBKKPembulatan');

    Route::resource('MaintenanceBKMUntukDPPelunasan', BKMDPPelunasanController::class);
    Route::get('getcust/', 'App\Http\Controllers\Accounting\Piutang\BKMDPPelunasanController@getNamaCustomer');
    Route::get('getTabelPelunasanBKMDP/{idCustomer}', 'App\Http\Controllers\Accounting\Piutang\BKMDPPelunasanController@getTabelDataPelunasan');
    Route::get('getidbkmBKMDP/{idBank}/{tanggal}', 'App\Http\Controllers\Accounting\Piutang\BKMDPPelunasanController@getUraianEnterBKM');
    Route::get('getTabelTampilBKMDP/{tanggalTampilBKM}/{tanggalTampilBKM2}', 'App\Http\Controllers\Accounting\Piutang\BKMDPPelunasanController@getTabelTampilBKM');
    Route::get('getTabelTampilBKKDP/{tanggalTampilBKK}/{tanggalTampilBKK2}', 'App\Http\Controllers\Accounting\Piutang\BKMDPPelunasanController@getTabelTampilBKK');
    Route::get('getidbkmBKMDP/{idBank}/{tanggal}', 'App\Http\Controllers\Accounting\Piutang\BKMDPPelunasanController@getUraianEnterBKM');
    Route::get('getIdPembayaran', 'App\Http\Controllers\Accounting\Piutang\BKMDPPelunasanController@getIdPembayaran');
    Route::get('getIdPelunasan', 'App\Http\Controllers\Accounting\Piutang\BKMDPPelunasanController@getIdPelunasan');
    Route::get('getidbkmBKKDP/{idBankBKK}/{tanggal}', 'App\Http\Controllers\Accounting\Piutang\BKMDPPelunasanController@getUraianEnterBKK');

    Route::resource('MaintenanceBKMxBKKNotaKredit', BKMBKKNotaKreditController::class);
    Route::get('getmatauang', 'App\Http\Controllers\Accounting\Piutang\BKMBKKNotaKreditController@getMataUang');
    Route::get('getDataNotaKredit', 'App\Http\Controllers\Accounting\Piutang\BKMBKKNotaKreditController@getDataNotaKredit');
    // Route::get('getUraianEnterBKM/{idBank}/{tanggal}', 'App\Http\Controllers\Accounting\Piutang\BKMBKKNotaKreditController@getUraianEnterBKM');
    Route::get('getidBKKNota/{idBank}/{tanggal}', 'App\Http\Controllers\Accounting\Piutang\BKMBKKNotaKreditController@getUraianEnterBKK');
    Route::get('getTabelTampilBKKNota/{tanggalTampilBKK}/{tanggalTampilBKK2}', 'App\Http\Controllers\Accounting\Piutang\BKMBKKNotaKreditController@getTabelTampilBKK');
    Route::get('getTabelTampilBKMNota/{tanggalTampilBKM}/{tanggalTampilBKM2}', 'App\Http\Controllers\Accounting\Piutang\BKMBKKNotaKreditController@getTabelTampilBKM');
    Route::get('getIdPelunasanNota', 'App\Http\Controllers\Accounting\Piutang\BKMBKKNotaKreditController@getIdPelunasan');
    Route::get('getIdPembayaranNota', 'App\Http\Controllers\Accounting\Piutang\BKMBKKNotaKreditController@getIdPembayaran');
    Route::get('getCetakBKMBKKNotaKredit/{idBKMTampil}', 'App\Http\Controllers\Accounting\Piutang\BKMBKKNotaKreditController@getCetakBKMBKKNotaKredit');

    Route::resource('BKMLC', App\Http\Controllers\Accounting\Piutang\BKMLCController::class);
    Route::get('getListPelunasanDollar/{bulan}/{tahun}', 'App\Http\Controllers\Accounting\Piutang\BKMLCController@getListPelunasanDollar');

    Route::resource('BKMPengembalianKE', App\Http\Controllers\Accounting\Piutang\BKMPengembalianKEController::class);
    Route::get('getcustomer/', 'App\Http\Controllers\Accounting\Piutang\BKMPengembalianKEController@getNamaCustomer');
    Route::get('getjenispembayaran', 'App\Http\Controllers\Accounting\Piutang\BKMPengembalianKEController@getJenisPembayaran');
    Route::get('getidbkmke/{idBank}/{tanggalInput}', 'App\Http\Controllers\Accounting\Piutang\BKMPengembalianKEController@getUraianBKMEnter');
    Route::get('getidbkkke/{idBank}/{tanggalInput}', 'App\Http\Controllers\Accounting\Piutang\BKMPengembalianKEController@getUraianBKKEnter');
    Route::get('getTabelTampilBKMKE/{tanggalTampilBKM}/{tanggalTampilBKM2}', 'App\Http\Controllers\Accounting\Piutang\BKMPengembalianKEController@getTabelTampilBKM');
    Route::get('getTabelTampilBKKKE/{tanggalTampilBKK}/{tanggalTampilBKK2}', 'App\Http\Controllers\Accounting\Piutang\BKMPengembalianKEController@getTabelTampilBKK');
    Route::get('getIdPembayaranKE', 'App\Http\Controllers\Accounting\Piutang\BKMPengembalianKEController@getIdPembayaran');
    Route::get('getCetakPengembalianKE/{idBKMTampil}', 'App\Http\Controllers\Accounting\Piutang\BKMPengembalianKEController@getCetakPengembalianKE');

    Route::resource('MaintenanceUpdateKursBKM', UpdateKursBKMController::class);

    Route::resource('MaintenanceKodePerkiraanBKM', App\Http\Controllers\Accounting\Piutang\KodePerkiraanBKMController::class);
    Route::get('getIdBKMBatal5/{BlnThn}', 'App\Http\Controllers\Accounting\Piutang\KodePerkiraanBKMController@getIdBKM5');
    Route::get('getIdBKMBatal6/{BlnThn}', 'App\Http\Controllers\Accounting\Piutang\KodePerkiraanBKMController@getIdBKM6');
    Route::get('getlistrincian/{idBKM}', 'App\Http\Controllers\Accounting\Piutang\KodePerkiraanBKMController@getTabelRincian');

    Route::resource('MaintenanceInformasiBank', App\Http\Controllers\Accounting\Piutang\InformasiBank\MaintenanceInformasiBankController::class);
    Route::get('getTabelInformasiBank/{tanggal}', 'App\Http\Controllers\Accounting\Piutang\InformasiBank\MaintenanceInformasiBankController@getTabelInfoBank');

    Route::resource('AnalisaInformasiBank', App\Http\Controllers\Accounting\Piutang\InformasiBank\AnalisaInformasiBankController::class);
    Route::get('getTabelAnalisis/{tanggal}/{tanggal2}/{radiogrup}', 'App\Http\Controllers\Accounting\Piutang\InformasiBank\AnalisaInformasiBankController@getTabelAnalisis');

    Route::resource('FakturUangMuka', App\Http\Controllers\Accounting\Piutang\PenjualanLokal\FakturUangMukaController::class);
    Route::get('getNoPenagihan/{idCustomer}', 'App\Http\Controllers\Accounting\Piutang\PenjualanLokal\FakturUangMukaController@getNoPenagihan');
    Route::get('getJenisCustomer/{idJenisCustomer}', 'App\Http\Controllers\Accounting\Piutang\PenjualanLokal\FakturUangMukaController@getJenisCustomer');
    Route::get('getAlamatCust/{idCustomer}', 'App\Http\Controllers\Accounting\Piutang\PenjualanLokal\FakturUangMukaController@getAlamatCust');
    Route::get('getNoSP/{idCustomer}', 'App\Http\Controllers\Accounting\Piutang\PenjualanLokal\FakturUangMukaController@getNomorSP');
    Route::get('getNomorPO/{noSP}', 'App\Http\Controllers\Accounting\Piutang\PenjualanLokal\FakturUangMukaController@getNomorPO');
    Route::get('getUserPenagih', 'App\Http\Controllers\Accounting\Piutang\PenjualanLokal\FakturUangMukaController@getUserPenagih');
    Route::get('getJenisPajak', 'App\Http\Controllers\Accounting\Piutang\PenjualanLokal\FakturUangMukaController@getJenisPajak');
    Route::get('getDokumen/{kode}', 'App\Http\Controllers\Accounting\Piutang\PenjualanLokal\FakturUangMukaController@getDokumen');
    Route::get('DataPenagihanF/{IdPenagihan}', 'App\Http\Controllers\Accounting\Piutang\PenjualanLokal\FakturUangMukaController@getDataPenagihan');

    Route::resource('PenagihanPenjualanLokal', App\Http\Controllers\Accounting\Piutang\PenjualanLokal\PenagihanPenjualanController::class);
    Route::get('getCustomerr', 'App\Http\Controllers\Accounting\Piutang\PenjualanLokal\PenagihanPenjualanController@getCustomer');
    Route::get('getCustomer', 'App\Http\Controllers\Accounting\Piutang\PenjualanLokal\PenagihanPenjualanController@getCustomerKoreksi');
    Route::get('getNoPenagihanUM/{noSP}', 'App\Http\Controllers\Accounting\Piutang\PenjualanLokal\PenagihanPenjualanController@getNoPenagihanUM');
    Route::get('getSuratJalan/{noSP}', 'App\Http\Controllers\Accounting\Piutang\PenjualanLokal\PenagihanPenjualanController@getSuratJalan');
    Route::get('getNoPenagihanPenjualan/{idCustomer}', 'App\Http\Controllers\Accounting\Piutang\PenjualanLokal\PenagihanPenjualanController@getNoPenagihan');
    Route::get('DataPenagihanPenjualan/{IdPenagihan}', 'App\Http\Controllers\Accounting\Piutang\PenjualanLokal\PenagihanPenjualanController@getDataPenagihan');
    Route::get('LihatPenagihan/{idJenisPajak}/{IdPenagihan}', 'App\Http\Controllers\Accounting\Piutang\PenjualanLokal\PenagihanPenjualanController@LihatPenagihan');

    Route::resource('MaintenanceNotaPenjualanTunai', App\Http\Controllers\Accounting\Piutang\NotaPenjualanTunaiController::class);
    Route::get('getLihatPesanan/{noSP}', 'App\Http\Controllers\Accounting\Piutang\NotaPenjualanTunaiController@getLihatPesanan');
    Route::get('getNotaJualTunai/{noSP}', 'App\Http\Controllers\Accounting\Piutang\NotaPenjualanTunaiController@getNotaJualTunai');
    Route::get('getNotaJualTunai2/{noSP}', 'App\Http\Controllers\Accounting\Piutang\NotaPenjualanTunaiController@getNotaJualTunai2');
    Route::get('getUserPenagihNota', 'App\Http\Controllers\Accounting\Piutang\NotaPenjualanTunaiController@getUserPenagihNota');
    Route::get('getJenisPajakNota', 'App\Http\Controllers\Accounting\Piutang\NotaPenjualanTunaiController@getJenisPajakNota');
    Route::get('getNoPenagihanUMNota/{noSP}', 'App\Http\Controllers\Accounting\Piutang\NotaPenjualanTunaiController@getNoPenagihanUMNota');
    Route::get('getNoPenagihanNota', 'App\Http\Controllers\Accounting\Piutang\NotaPenjualanTunaiController@getNoPenagihan');
    Route::get('getJenisCust/{idCustomer}', 'App\Http\Controllers\Accounting\Piutang\NotaPenjualanTunaiController@getJenisCust');
    Route::get('getJnsCust/{idJenisCustomer}', 'App\Http\Controllers\Accounting\Piutang\NotaPenjualanTunaiController@getJnsCust');
    Route::get('getLihatSP/{idNoPenagihan}', 'App\Http\Controllers\Accounting\Piutang\NotaPenjualanTunaiController@getLihatSP');
    Route::get('getDataSP/{noSP}', 'App\Http\Controllers\Accounting\Piutang\NotaPenjualanTunaiController@getDataSP');
    Route::get('getLihatPenagihan/{idNoPenagihan}', 'App\Http\Controllers\Accounting\Piutang\NotaPenjualanTunaiController@getLihatPenagihan');

    Route::resource('UpdateSuratJalanUntukJualTunai', App\Http\Controllers\Accounting\Piutang\UpdateSuratJalanController::class);
    Route::get('getTabelSuratJalan', 'App\Http\Controllers\Accounting\Piutang\UpdateSuratJalanController@getTabelSuratJalan');

    Route::resource('ACCPenagihanPenjualan', App\Http\Controllers\Accounting\Piutang\ACCPenagihanPenjualanController::class);
    Route::get('getDisplayHeader', 'App\Http\Controllers\Accounting\Piutang\ACCPenagihanPenjualanController@getDisplayHeader');
    Route::get('getDisplayDetail/{idPenagihan}', 'App\Http\Controllers\Accounting\Piutang\ACCPenagihanPenjualanController@getDisplayDetail');
    Route::get('getDisplaySuratJalan/{idPenagihan}', 'App\Http\Controllers\Accounting\Piutang\ACCPenagihanPenjualanController@getDisplaySuratJalan');
    Route::get('accCheckCtkSJ/{idPenagihan}', 'App\Http\Controllers\Accounting\Piutang\ACCPenagihanPenjualanController@accCheckCtkSJ');
    Route::get('accCheckCtkSP/{idPenagihan}', 'App\Http\Controllers\Accounting\Piutang\ACCPenagihanPenjualanController@accCheckCtkSP');

    Route::resource('StatusDokumenTagihan', App\Http\Controllers\Accounting\Piutang\StatusDokumenTagihanController::class);
    Route::get('getCust', 'App\Http\Controllers\Accounting\Piutang\StatusDokumenTagihanController@getCust');
    Route::get('getTabelStatusDokumen/{idCustomer}', 'App\Http\Controllers\Accounting\Piutang\StatusDokumenTagihanController@getTabelStatusDokumen');
    Route::get('getDataStatusDokumen', 'App\Http\Controllers\Accounting\Piutang\StatusDokumenTagihanController@getDataStatusDokumen');

    Route::resource('ACCPenagihanPenjualanEksport', App\Http\Controllers\Accounting\Piutang\ACCPenagihanPenjualanExportController::class);
    Route::get('getTabelPenagihanEx', 'App\Http\Controllers\Accounting\Piutang\ACCPenagihanPenjualanExportController@getTabelPenagihanEx');
    Route::get('getDetailPenagihanEx/{idPenagihan}', 'App\Http\Controllers\Accounting\Piutang\ACCPenagihanPenjualanExportController@getDetailPenagihanEx');

    Route::resource('PenagihanPenjualanEksport', App\Http\Controllers\Accounting\Piutang\PenagihanPenjualanExportController::class);
    Route::get('getCustomerEx', 'App\Http\Controllers\Accounting\Piutang\PenagihanPenjualanExportController@getCustomerEx');
    Route::get('getSuratJalanEx/{idCustomer}', 'App\Http\Controllers\Accounting\Piutang\PenagihanPenjualanExportController@getSuratJalanEx');

    Route::resource('MaintenancePelunasanPenjualan', App\Http\Controllers\Accounting\Piutang\MaintenancePelunasanPenjualanController::class);
    Route::get('getCustIsi', 'App\Http\Controllers\Accounting\Piutang\MaintenancePelunasanPenjualanController@getCustIsi');
    Route::get('getCustKoreksi', 'App\Http\Controllers\Accounting\Piutang\MaintenancePelunasanPenjualanController@getCustKoreksi');
    Route::get('getJenisPembayaran', 'App\Http\Controllers\Accounting\Piutang\MaintenancePelunasanPenjualanController@getJenisPembayaran');
    Route::get('getReferensiBank/{idCustomer}', 'App\Http\Controllers\Accounting\Piutang\MaintenancePelunasanPenjualanController@getReferensiBank');
    Route::get('getDataRefBank/{idReferensi}', 'App\Http\Controllers\Accounting\Piutang\MaintenancePelunasanPenjualanController@getDataRefBank');
    Route::get('getListPenagihanSJ/{idCustomer}', 'App\Http\Controllers\Accounting\Piutang\MaintenancePelunasanPenjualanController@getListPenagihanSJ');
    Route::get('getListPelunasanTagihan/{noPen}', 'App\Http\Controllers\Accounting\Piutang\MaintenancePelunasanPenjualanController@getListPelunasanTagihan');
    Route::get('getKdPerkiraan', 'App\Http\Controllers\Accounting\Piutang\MaintenancePelunasanPenjualanController@getKdPerkiraan');
    Route::get('getListPelunasan/{idCustomer}', 'App\Http\Controllers\Accounting\Piutang\MaintenancePelunasanPenjualanController@getListPelunasan');
    Route::get('getDataPelunasanTagihan/{IdPelunasan}', 'App\Http\Controllers\Accounting\Piutang\MaintenancePelunasanPenjualanController@getDataPelunasanTagihan');
    Route::get('LihatDetailPelunasan/{IdPelunasan}', 'App\Http\Controllers\Accounting\Piutang\MaintenancePelunasanPenjualanController@LihatDetailPelunasan');
    Route::get('getCekReferensiPelunasan/{IdPelunasan}', 'App\Http\Controllers\Accounting\Piutang\MaintenancePelunasanPenjualanController@getCekReferensiPelunasan');

    Route::resource('PelunasanPenjualanCashAdvance', App\Http\Controllers\Accounting\Piutang\PelunasanPenjualanCashAdvanceController::class);
    Route::get('getCustIsiCashAdvance', 'App\Http\Controllers\Accounting\Piutang\PelunasanPenjualanCashAdvanceController@getCustIsiCashAdvance');
    Route::get('getNoPelunasanCashAdvance/{idCustomer}', 'App\Http\Controllers\Accounting\Piutang\PelunasanPenjualanCashAdvanceController@getNoPelunasanCashAdvance');
    Route::get('LihatHeaderPelunasanCashAdvance/{noPelunasan}', 'App\Http\Controllers\Accounting\Piutang\PelunasanPenjualanCashAdvanceController@LihatHeaderPelunasanCashAdvance');
    Route::get('LihatDetailPelunasanCashAdvance/{noPelunasan}', 'App\Http\Controllers\Accounting\Piutang\PelunasanPenjualanCashAdvanceController@LihatDetailPelunasanCashAdvance');
    // Route::get('getLihat_PenagihanCashAdvance/{noPen}', 'App\Http\Controllers\Accounting\Piutang\PelunasanPenjualanCashAdvanceController@getLihat_PenagihanCashAdvance');
    // Route::get('getLihat_PenagihanCashAdvance2/{noPen}', 'App\Http\Controllers\Accounting\Piutang\PelunasanPenjualanCashAdvanceController@getLihat_PenagihanCashAdvance2');
    Route::get('getNoPenagihanCashAdvance/{idCustomer}', 'App\Http\Controllers\Accounting\Piutang\MaintenancePelunasanPenjualanController@getListPenagihanSJ');

    Route::resource('AnalisaStatusPelunasan', App\Http\Controllers\Accounting\Piutang\AnalisaStatusPenjualanController::class);
    Route::get('getDisplaySuratJalan/{tanggal}/{tanggal2}', 'App\Http\Controllers\Accounting\Piutang\AnalisaStatusPenjualanController@getDisplaySuratJalan');

    Route::resource('NotaKreditRetur', App\Http\Controllers\Accounting\Piutang\MaintenanceNotaKredit\NotaKreditReturController::class);
    Route::get('getCustNotaKredit', 'App\Http\Controllers\Accounting\Piutang\MaintenanceNotaKredit\NotaKreditReturController@getCustNotaKredit');
    Route::get('getListSJNotaKredit/{idCustomer}', 'App\Http\Controllers\Accounting\Piutang\MaintenanceNotaKredit\NotaKreditReturController@getListSJNotaKredit');
    Route::get('getLihat_PenagihanNotaKredit/{idCustomer}/{MIdRetur}', 'App\Http\Controllers\Accounting\Piutang\MaintenanceNotaKredit\NotaKreditReturController@getLihat_PenagihanNotaKredit');

    Route::resource('PotHarga', App\Http\Controllers\Accounting\Piutang\MaintenanceNotaKredit\PotHargaController::class);
    Route::resource('Free', App\Http\Controllers\Accounting\Piutang\MaintenanceNotaKredit\FreeController::class);

    Route::resource('KelebihanBayarUntukJualTunai', App\Http\Controllers\Accounting\Piutang\MaintenanceNotaKredit\KelebihanBayarJualTunaiController::class); //Kode 9 SP
    Route::get('getCustKelebihanBayar', 'App\Http\Controllers\Accounting\Piutang\MaintenanceNotaKredit\KelebihanBayarJualTunaiController@getCustKelebihanBayar');
    Route::get('getListNotaKreditKelebihanBayar', 'App\Http\Controllers\Accounting\Piutang\MaintenanceNotaKredit\KelebihanBayarJualTunaiController@getListNotaKreditKelebihanBayar');

    Route::resource('SelisihTimbang', App\Http\Controllers\Accounting\Piutang\MaintenanceNotaKredit\SelisihTimbangController::class); //Kode 9 SP
    // Route::get('SelisihTimbang', 'App\Http\Controllers\Accounting\Piutang\MaintenanceNotaKredit\SelisihTimbangController@SelisihTimbang');

    Route::resource('ACCNotaKredit', App\Http\Controllers\Accounting\Piutang\ACCNotaKreditController::class);

    Route::get('getTabelHeaderACCNotaKredit', 'App\Http\Controllers\Accounting\Piutang\ACCNotaKreditController@getTabelHeaderACCNotaKredit');
    Route::get('getDetailHeaderACCNotaKredit/{idNotaKredit}', 'App\Http\Controllers\Accounting\Piutang\ACCNotaKreditController@getDetailHeaderACCNotaKredit');
    Route::get('getDetailHeaderACCNotaKredit2/{idNotaKredit}', 'App\Http\Controllers\Accounting\Piutang\ACCNotaKreditController@getDetailHeaderACCNotaKredit2');

    Route::resource('Pengajuan', App\Http\Controllers\Accounting\Piutang\MaintenanceBKKNotaKredit\PengajuanController::class); //sp bank gaada
    Route::get('loadDataNotaK', 'App\Http\Controllers\Accounting\Piutang\MaintenanceBKKNotaKredit\PengajuanController@loadDataNotaK');
    Route::get('getJenisBayarPenagajuan', 'App\Http\Controllers\Accounting\Piutang\MaintenanceBKKNotaKredit\PengajuanController@getJenisBayarPenagajuan');
    Route::get('getBankPengajuan', 'App\Http\Controllers\Accounting\Piutang\MaintenanceBKKNotaKredit\PengajuanController@getBankPengajuan');

    Route::resource('BKK', App\Http\Controllers\Accounting\TransBank\BKKController::class);
    Route::resource('BKM', App\Http\Controllers\Accounting\TransBank\BKMController::class);
    // Route::get('BKM', 'App\Http\Controllers\Accounting\TransBank\BKMController@BKM');

    // Route::get('CekNotadanFaktur', 'App\Http\Controllers\Accounting\Informasi\CekNotadanFakturController@CekNotadanFaktur');

    Route::resource('CetakNotaKredit', App\Http\Controllers\Accounting\Informasi\CetakNotaKreditController::class);
    Route::get('getListCetakNotaKredit/{tanggal}', 'App\Http\Controllers\Accounting\Informasi\CetakNotaKreditController@getListCetakNotaKredit');
    Route::get('getIdSuratJalanNotaKredit/{notaKredit}', 'App\Http\Controllers\Accounting\Informasi\CetakNotaKreditController@getIdSuratJalanNotaKredit');
    Route::get('getDisplayDetailNotaKredit/{notaKredit}', 'App\Http\Controllers\Accounting\Informasi\CetakNotaKreditController@getDisplayDetailNotaKredit');
    Route::get('getSFilter1/{notaKredit}', 'App\Http\Controllers\Accounting\Informasi\CetakNotaKreditController@getSFilter1');
    Route::get('getSFilter2/{notaKredit}', 'App\Http\Controllers\Accounting\Informasi\CetakNotaKreditController@getSFilter2');
    Route::get('getSFilter3/{notaKredit}', 'App\Http\Controllers\Accounting\Informasi\CetakNotaKreditController@getSFilter3');
    Route::get('getSFilter4/{notaKredit}', 'App\Http\Controllers\Accounting\Informasi\CetakNotaKreditController@getSFilter4');

    Route::resource('Soplang', App\Http\Controllers\Accounting\Informasi\SoplangController::class);

    Route::resource('RekapPiutang', App\Http\Controllers\Accounting\Informasi\RekapPiutangController::class);
    Route::get('getCekRekPiutang/{tglAkhirLaporan}', 'App\Http\Controllers\Accounting\Informasi\RekapPiutangController@getCekRekPiutang');

    Route::resource('KartuHutang', App\Http\Controllers\Accounting\Informasi\KartuHutangController::class);
    Route::get('KartuHutang', 'App\Http\Controllers\Accounting\Informasi\KartuHutangController@KartuHutang');

    Route::resource('CetakNotaDanFaktur', CetakNotaDanFakturController::class);
    Route::resource('CetakNotaKredit', CetakNotaKreditController::class);
    #endregion

    #region Inventory
    Route::get('Inventory', 'App\Http\Controllers\HomeController@Inventory');
    Route::resource('AccKeluarPenjualan', KeluarBarangUntukPenjualanController::class);
    Route::resource('AccKonversiBarang', AccKonversiBarangController::class);
    Route::resource('AccMhnMasukKeluar', AccMhnMasukKeluarController::class);
    Route::resource('AccMhnPenerima', AccMhnPenerimaController::class);
    Route::resource('AccPascaKirim', PengembalianPascaPenjualanController::class);
    Route::resource('AccPemberiBarang', AccPemberiBarangController::class);
    Route::resource('AccPenghangusanBarang', AccPenghangusanBarangController::class);
    Route::resource('AccPenyesuaianBarang', AccPenyesuaianBarangController::class);
    Route::resource('AccPermohonanHibah', AccHibahController::class);
    Route::resource('AccReturPenjualan', ReturPenjualanController::class);
    Route::resource('AccSatuDivisi', AccSatuDivisiController::class);
    Route::resource('CariKodeBarang', CariKodeBarangController::class);
    Route::resource('KartuStok', KartuStokController::class);
    Route::resource('KodePerkiraan', KodePerkiraanController::class);
    Route::resource('KonversiBarang', KonversiBarangController::class);
    Route::get('getObjekSelect/{divisi}', 'App\Http\Controllers\Inventory\Transaksi\Konversi\KonversiBarangController@getObjekSelect');
    Route::get('getKelompokUtamaSelect/{objek}', 'App\Http\Controllers\Inventory\Transaksi\Konversi\KonversiBarangController@getKelompokUtamaSelect');
    Route::get('getKelompokSelect/{kelompokUtama}', 'App\Http\Controllers\Inventory\Transaksi\Konversi\KonversiBarangController@getKelompokSelect');
    Route::get('getSubKelompokSelect/{kelompok}', 'App\Http\Controllers\Inventory\Transaksi\Konversi\KonversiBarangController@getSubKelompokSelect');
    Route::get('getIdTypeSelect/{subKelompok}', 'App\Http\Controllers\Inventory\Transaksi\Konversi\KonversiBarangController@getIdTypeSelect');
    Route::get('getTypeABMSelect/{subKelompok}', 'App\Http\Controllers\Inventory\Transaksi\Konversi\KonversiBarangController@getTypeABMSelect');
    Route::get('getTypeCIRSelect', 'App\Http\Controllers\Inventory\Transaksi\Konversi\KonversiBarangController@getTypeCIRSelect');
    Route::resource('LacakTransaksi', LacakTransaksiController::class);
    Route::resource('ListDetailTransaksi', ListDetailTransaksiController::class);
    Route::resource('MaintenanceObjek', MaintenanceObjekController::class);
    Route::resource('MaintenanceType', MaintenanceTypeController::class);
    Route::resource('MhnMasukKeluar', MhnMasukKeluarController::class);
    Route::resource('MhnPemberi', MhnPemberiController::class);
    Route::resource('MhnPenerima', MhnPenerimaController::class);
    Route::resource('PemakaianGelondongan', PemakaianGelondonganController::class);
    Route::resource('PemberiBarang', PemberiBarangController::class);
    Route::resource('PemberiBarangAss', PemberiBarangAssController::class);
    Route::resource('PenerimaHibah', PenerimaHibahController::class);
    Route::resource('PenghangusanBarang', PenghangusanBarangController::class);
    Route::resource('PenyesuaianBarang', PenyesuaianBarangController::class);
    Route::resource('PermohonanHibah', PermohonanHibahController::class);
    Route::resource('PermohonanPenerima', PermohonanPenerimaController::class);
    Route::resource('PermohonanPenerimaBenang', PermohonanPenerimaBenangController::class);
    Route::resource('PermohonanSatuDivisi', PermohonanSatuDivisiController::class);
    Route::resource('StokBarang', StokBarangController::class);
    Route::resource('TerimaBenangGedungD', TerimaBenangGedungDController::class);
    Route::resource('TerimaBenangTropodo', TerimaBenangTropodoController::class);
    Route::resource('TerimaPurchasing', TerimaPurchasingController::class);
    Route::resource('TransaksiBulanan', TransaksiBulananController::class);
    Route::resource('TransaksiHarian', TransaksiHarianController::class);
    #endregion

    #region Laporan
    Route::get('Laporan', 'App\Http\Controllers\HomeController@Laporan');
    Route::resource('CetakNotaFaktur', CetakNotaFakturController::class);
    Route::resource('CetakBKM', CetakBKMController::class);
    Route::resource('CetakBKK', CetakBKKController::class);
    Route::resource('CetakSPPBBTTB', CetakSPPBBTTBController::class);
    Route::get('/sppb/export-pdf', [CetakSPPBBTTBController::class, 'exportToPdf'])->name('sppb.export.pdf');
    Route::get('/getEmailSupplier', [CetakSPPBBTTBController::class, 'getEmailSupplier']);
    Route::post('/sendEmailSupplier', [CetakSPPBBTTBController::class, 'sendEmailSupplier']);



    Route::get('/test-email', function () {
        Mail::raw('Test email via company SMTP SSL', function ($message) {
            $message->to('adamchristianto@gmail.com')
                ->subject('SMTP SSL Test');
        });

        return 'Email sent (check inbox)';
    });

});
