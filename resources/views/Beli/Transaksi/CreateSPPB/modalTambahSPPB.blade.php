<div class="modal fade" id="modalSPPB" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog" style="max-width: 90%">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabelSPPB">Tambah SPPB</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span>x</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="sppb_nomorSatuan" id="sppb_nomorSatuan">
                <div class="d-flex" style="gap: 0.5%;width: 100%">
                    <div class="form-group" style="flex: 0.1">
                        <label for="sppb_tanggal">Tanggal SPPB</label>
                        <div class="input-group">
                            <input type="date" class="form-control" id="sppb_tanggal" name="sppb_tanggal">
                        </div>
                    </div>
                    <div class="form-group" style="flex: 0.1">
                        <label for="sppb_tanggalDibutuhkan">Tanggal Dibutuhkan</label>
                        <div class="input-group">
                            <input type="date" class="form-control" id="sppb_tanggalDibutuhkan"
                                name="sppb_tanggalDibutuhkan">
                        </div>
                    </div>
                    <div class="form-group"style="flex: 0.2" id="sppb_select2ParentDivisi">
                        <label for="sppb_divisi">Divisi</label>
                        <div class="input-group">
                            <select name="sppb_divisi" id="sppb_divisi"></select>
                        </div>
                    </div>
                    <div class="form-group"style="flex: 0.2" id="sppb_select2ParentPembelian">
                        <label for="sppb_jenisPembelian">Jenis Pembelian</label>
                        <div class="input-group">
                            <select name="sppb_jenisPembelian" id="sppb_jenisPembelian"></select>
                        </div>
                    </div>
                    <div class="form-group"style="flex: 0.3" id="sppb_select2ParentSupplier">
                        <label for="sppb_supplier">Supplier</label>
                        <div class="input-group">
                            <select name="sppb_supplier" id="sppb_supplier"></select>
                        </div>
                    </div>
                    <div class="form-group" style="flex: 0.1">
                        <label for="sppb_pemesan">Pemesan</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="sppb_pemesan" name="sppb_pemesan">
                        </div>
                    </div>
                </div>
                <div class="d-flex" style="gap: 0.5%;width: 100%" id="sppb_select2ParentMataUang">
                    <div class="form-group"style="flex: 0.3">
                        <label for="sppb_mataUang">Mata Uang</label>
                        <div class="input-group">
                            <select name="sppb_mataUang" id="sppb_mataUang"></select>
                        </div>
                    </div>
                    <div class="form-group" style="flex: 0.2">
                        <label for="sppb_kursRupiah">Kurs Rupiah</label>
                        <div class="input-group"style="align-items: center">
                            <input type="number" class="form-control" id="sppb_kursRupiah" name="sppb_kursRupiah"
                                min=1>
                        </div>
                    </div>
                    <div class="form-group" style="flex: 0.2">
                        <label for="sppb_jangkaWaktu">Jangka Waktu</label>
                        <div class="input-group"style="align-items: center">
                            <input type="number" class="form-control" id="sppb_jangkaWaktu" name="sppb_jangkaWaktu">
                            &nbsp; Hari
                        </div>
                    </div>
                    <div class="form-group" style="flex: 0.2">
                        <label for="sppb_pembayaran">Pembayaran</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="sppb_pembayaran" name="sppb_pembayaran"
                                readonly>
                        </div>
                    </div>
                </div>
                <div style="overflow-x: auto">
                    <table id="sppb_tableOrderPembelian" class="table table-bordered" style="min-width:100%">
                        <thead class="thead-light" style="white-space: nowrap;">
                            <tr>
                                <th>Nama Barang</th>
                                <th>Kode Barang</th>
                                <th>Qty</th>
                                <th>Keterangan</th>
                                <th>Harga Satuan</th>
                                <th>Discount</th>
                                <th>PPN(%)</th>
                                <th>DPP Nilai Lain</th>
                                <th>Harga PPN</th>
                                <th>SubTotal Harga Jual</th>
                                <th>Total Harga</th>
                                <th>Nomor Order</th>
                                <th>No. Mesin</th>
                                <th>No. Golongan</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex pt-2" style="gap: 0.5%;width: 100%" id="sppb_select2ParentGolongan">
                    <div class="form-group"style="flex: 0.2">
                        <label for="sppb_golongan">Golongan</label>
                        <div class="input-group">
                            <select name="sppb_golongan" id="sppb_golongan"></select>
                        </div>
                    </div>
                    <div class="form-group"style="flex: 0.2" id="sppb_select2ParentKelompok">
                        <label for="sppb_kelompok">Kelompok</label>
                        <div class="input-group">
                            <select name="sppb_kelompok" id="sppb_kelompok"></select>
                        </div>
                    </div>
                    <div class="form-group"style="flex: 0.2" id="sppb_select2ParentKategoriUtama">
                        <label for="sppb_kategoriUtama">Kategori Utama</label>
                        <div class="input-group">
                            <select name="sppb_kategoriUtama" id="sppb_kategoriUtama"></select>
                        </div>
                    </div>
                    <div class="form-group"style="flex: 0.2" id="sppb_select2ParentKategori">
                        <label for="sppb_kategori">Kategori</label>
                        <div class="input-group">
                            <select name="sppb_kategori" id="sppb_kategori"></select>
                        </div>
                    </div>
                    <div class="form-group"style="flex: 0.2" id="sppb_select2ParentSubKategori">
                        <label for="sppb_subKategori">Sub Kategori</label>
                        <div class="input-group">
                            <select name="sppb_subKategori" id="sppb_subKategori"></select>
                        </div>
                    </div>
                </div>
                <div class="d-flex" style="gap: 0.5%;width: 100%" id="sppb_select2ParentNamaBarang">
                    <div class="form-group"style="flex: 0.4">
                        <label for="sppb_namaBarang">Nama Barang</label>
                        <div class="input-group">
                            <select name="sppb_namaBarang" id="sppb_namaBarang"></select>
                        </div>
                    </div>
                    <div class="form-group"style="flex: 0.2">
                        <label for="sppb_kodeBarang">Kode Barang</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="sppb_kodeBarang" id="sppb_kodeBarang"
                                placeholder="Enter untuk cari Barang">
                        </div>
                    </div>
                    <div class="form-group"style="flex: 0.2">
                        <label for="sppb_keteranganKhusus">Keterangan Khusus</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="sppb_keteranganKhusus"
                                id="sppb_keteranganKhusus" readonly>
                        </div>
                    </div>
                    <div class="form-group"style="flex: 0.2">
                        <label for="sppb_keteranganBarang">Keterangan Barang</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="sppb_keteranganBarang"
                                id="sppb_keteranganBarang" readonly>
                        </div>
                    </div>
                </div>
                <div class="d-flex" style="gap: 0.5%;width: 100%">
                    <div class="form-group" style="flex: 0.1">
                        <label for="sppb_quantityBarang">Quantity</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="sppb_quantityBarang"
                                id="sppb_quantityBarang" min="1">
                        </div>
                    </div>
                    <div class="form-group" style="flex: 0.475">
                        <label for="sppb_KeteranganOrder">Keterangan Order</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="sppb_KeteranganOrder"
                                id="sppb_KeteranganOrder">
                        </div>
                    </div>
                    <div class="form-group" style="flex: 0.2">
                        <label for="sppb_hargaSatuan">Harga Satuan</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="sppb_hargaSatuan"
                                id="sppb_hargaSatuan">
                        </div>
                    </div>
                    <div class="form-group"style="flex: 0.07">
                        <label for="sppb_satuanBarang">Satuan</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="sppb_satuanBarang"
                                id="sppb_satuanBarang" readonly>
                        </div>
                    </div>
                    <div class="form-group" style="flex: 0.05">
                        <label for="sppb_ppn">PPN(%)</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="sppb_ppn" id="sppb_ppn">
                        </div>
                    </div>
                    <div class="form-group" id="sppb_divDppFull"
                        style="flex: 0.075;align-content: end;display: none;">
                        <input type="checkbox" name="sppb_dppFull" id="sppb_dppFull" style="display: inline">
                        <label for="sppb_dppFull" style="display: inline">DPP 11/12</label>
                    </div>
                </div>
                <div class="d-flex" style="gap: 0.5%;width: 100%">
                    <div class="form-group" style="flex: 0.2">
                        <label for="sppb_DPPNilaiLain">DPP Nilai Lain</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="sppb_DPPNilaiLain"
                                id="sppb_DPPNilaiLain" readonly>
                        </div>
                    </div>
                    <div class="form-group" style="flex: 0.2">
                        <label for="sppb_hargaPPN">Harga PPN</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="sppb_hargaPPN" id="sppb_hargaPPN"
                                readonly>
                        </div>
                    </div>
                    <div class="form-group" style="flex: 0.2">
                        <label for="sppb_subTotalHargaJual">SubTotal Harga Jual</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="sppb_subTotalHargaJual"
                                id="sppb_subTotalHargaJual" readonly>
                        </div>
                    </div>
                    <div class="form-group" style="flex: 0.2">
                        <label for="sppb_totalHarga">Total Harga</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="sppb_totalHarga" id="sppb_totalHarga"
                                readonly>
                        </div>
                    </div>
                    <div class="form-group" style="flex: 0.1">
                        <label for="sppb_discount">Discount</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="sppb_discount" id="sppb_discount">
                        </div>
                    </div>
                </div>
                <div style="display:block;align-content: center;flex: 0.2;width: 100%;">
                    <button class="btn btn-primary" id="sppb_buttonAdd">Add</button>
                    <button class="btn btn-warning" id="sppb_buttonUpdate">Update</button>
                    <button class="btn btn-danger" id="sppb_buttonDelete">Delete</button>
                </div>

                <br>

                <!--Informasi Cetak-->
                <div class="d-flex mt-2" style="gap: 0.5%;width: 100%">
                    <div class="form-group" style="flex: 1.0">
                        <label for="sppb_deliveryTerm">Delivery Term</label>
                        <input type="text" name="sppb_deliveryTerm" id="sppb_deliveryTerm" class="form-control">
                    </div>
                </div>
                <div class="d-flex mt-2" style="gap: 0.5%;width: 100%">
                    <div class="form-group" style="flex: 1.0">
                        <label for="sppb_packing">Packing</label>
                        <input type="text" name="sppb_packing" id="sppb_packing" class="form-control">
                    </div>
                </div>
                <div class="d-flex mt-2" style="gap: 0.5%;width: 100%">
                    <div class="form-group" style="flex: 1.0">
                        <label for="sppb_shippingMark">Shipping Mark</label>
                        <input type="text" name="sppb_shippingMark" id="sppb_shippingMark" class="form-control">
                    </div>
                </div>
                <div class="d-flex" style="gap: 0.5%;width: 100%">
                    <div class="form-group" style="flex: 1.0">
                        <label for="sppb_deliveryTime">Delivery Time</label>
                        <input type="text" name="sppb_deliveryTime" id="sppb_deliveryTime" class="form-control">
                    </div>
                </div>
                <div class="d-flex mt-2" style="gap: 0.5%;width: 100%">
                    <div class="form-group" style="flex: 1.0">
                        <label for="sppb_documentsRequired">Documents Required</label>
                        <textarea type="text" name="sppb_documentsRequired" id="sppb_documentsRequired"
                            class="form-control"></textarea>
                    </div>
                </div>
                <div class="d-flex mt-2" style="gap: 0.5%;width: 100%">
                    <div class="form-group" style="flex: 1.0">
                        <label for="sppb_partialShipmentTransit">Partial Shipment / Transit</label>
                        <input type="text" name="sppb_partialShipmentTransit" id="sppb_partialShipmentTransit"
                            class="form-control">
                    </div>
                </div>
                <div class="d-flex" style="gap: 0.5%;width: 100%">
                    <div class="form-group" style="flex: 1.0">
                        <label for="sppb_portOfLoading">Port of Loading</label>
                        <input type="text" name="sppb_portOfLoading" id="sppb_portOfLoading"
                            class="form-control">
                    </div>
                </div>

                <div class="d-flex mt-2" style="gap: 0.5%;width: 100%">
                    <div class="form-group" style="flex: 1.0">
                        <label for="sppb_portOfDischarge">Port of Discharge</label>
                        <input type="text" name="sppb_portOfDischarge" id="sppb_portOfDischarge"
                            class="form-control">
                    </div>
                </div>
                <div class="d-flex mt-2" style="gap: 0.5%;width: 100%">
                    <div class="form-group" style="flex: 1.0">
                        <label for="sppb_otherConditions">Other Conditions</label>
                        <input type="text" name="sppb_otherConditions" id="sppb_otherConditions"
                            class="form-control">
                    </div>
                </div>

                <div class="d-flex mt-2" style="gap: 0.5%;width: 100%">
                    <div class="form-group" style="flex: 1.0">
                        <label for="sppb_payments">Payments</label>
                        <textarea type="text" name="sppb_payments" id="sppb_payments" class="form-control"></textarea>
                    </div>
                </div>


                <div class="d-flex" style="justify-content: end;width: 100%">
                    <button class="btn btn-info" id="sppb_buttonSave">Save</button>
                    <button class="btn btn-success" id="sppb_buttonSubmit">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>
