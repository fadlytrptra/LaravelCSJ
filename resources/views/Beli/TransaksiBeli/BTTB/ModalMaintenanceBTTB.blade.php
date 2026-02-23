<div class="modal fade" id="createBTTBModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog" style="max-width: 90%;">
        <div class="modal-content" id="select2DropdownParent">
            <div class="modal-header justify-content-center">
                <h5 class="modal-title" id="createBTTBModalLabel">Maintenance BTTB </h5>
                <button type="button" class="close" data-bs-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-7">
                        <div class="row">
                            <input type="hidden" name="bttb_noTerima" id="bttb_noTerima"
                                class="form-control font-weight-bold" readonly>
                            <div class="col-md-3 mb-3">
                                <label class="font-weight-bold" for="bttb_kodeBarang">Kode Barang</label>
                                <input type="text" name="bttb_kodeBarang" id="bttb_kodeBarang"
                                    class="form-control font-weight-bold" readonly>
                            </div>
                            <div class="col-md-9 mb-3">
                                <label class="font-weight-bold" for="bttb_namaBarang">Nama Barang</label>
                                <input type="text" name="bttb_namaBarang" id="bttb_namaBarang"
                                    class="form-control font-weight-bold" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="font-weight-bold" for="bttb_tanggal">Tanggal</label>
                                <input type="date" name="bttb_tanggal" id="bttb_tanggal"
                                    class="form-control font-weight-bold">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="font-weight-bold" for="bttb_qtyTerima">Qty Terima</label>
                                <div style="display: flex; flex-direction: row;gap: 1%">
                                    <input type="number" name="bttb_qtyTerima" id="bttb_qtyTerima"
                                        class="form-control font-weight-bold" style="width: 60%" min="0">
                                    <input type="text" name="bttb_satTerima" id="bttb_satTerima"
                                        class="form-control font-weight-bold" style="width: 40%" readonly>
                                    <input type="hidden" name="bttb_noSatTerima" id="bttb_noSatTerima"
                                        class="form-control font-weight-bold" style="width: 40%" readonly>
                                    <input type="hidden" name="bttb_qtyTerimaKoreksi" id="bttb_qtyTerimaKoreksi"
                                        class="form-control font-weight-bold" style="width: 60%" min="0">
                                </div>
                            </div>
                            <div class="col-md-5 mb-3">
                                <label class="font-weight-bold" for="bttb_qtyTerimaActual">Qty Terima (Actual)</label>
                                <div style="display: flex; flex-direction: row;gap: 1%">
                                    <input type="number" name="bttb_qtyTerimaActual" id="bttb_qtyTerimaActual"
                                        class="form-control font-weight-bold" style="width: 60%" min="0">
                                    <input type="text" name="bttb_satTerimaActual" id="bttb_satTerimaActual"
                                        class="form-control font-weight-bold" style="width: 40%" readonly>
                                    <input type="hidden" name="bttb_qtyTerimaActualKoreksi"
                                        id="bttb_qtyTerimaActualKoreksi" class="form-control font-weight-bold"
                                        style="width: 60%" min="0">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="font-weight-bold" for="bttb_tanggalFaktur">Tanggal Faktur</label>
                                <input type="date" name="bttb_tanggalFaktur" id="bttb_tanggalFaktur"
                                    class="form-control font-weight-bold">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="font-weight-bold" for="bttb_noFaktur">No. Faktur</label>
                                <input type="text" name="bttb_noFaktur" id="bttb_noFaktur"
                                    class="form-control font-weight-bold">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="font-weight-bold" for="bttb_nomorSJ">No. Surat Jalan</label>
                                <input type="text" name="bttb_nomorSJ" id="bttb_nomorSJ"
                                    class="form-control font-weight-bold">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="font-weight-bold" for="bttb_selectMataUang">Mata Uang</label>
                                <select class="form-control font-weight-bold" id="bttb_selectMataUang"
                                    name="bttb_selectMataUang"></select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="font-weight-bold" for="bttb_kursRupiah">Kurs Rupiah</label>
                                <input type="number" name="bttb_kursRupiah" id="bttb_kursRupiah"
                                    class="form-control font-weight-bold" min="0">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="font-weight-bold" for="bttb_harga">Harga</label>
                                <input type="number" name="bttb_harga" id="bttb_harga"
                                    class="form-control font-weight-bold" min="0">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="font-weight-bold" for="bttb_discount">Discount (%)</label>
                                <input type="number" name="bttb_discount" id="bttb_discount"
                                    class="form-control font-weight-bold" min="0">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="font-weight-bold" for="bttb_ppn">PPN (%)</label>
                                <input type="number" name="bttb_ppn" id="bttb_ppn"
                                    class="form-control font-weight-bold" min="0">
                                <div id="bttb_divCbDPP" style="display: none">
                                    <input type="checkbox" name="bttb_checkboxDPP" id="bttb_checkboxDPP">
                                    DPP 11/12
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="font-weight-bold" for="bttb_hargaPer">Harga Per</label>
                                <input type="number" name="bttb_hargaPer" id="bttb_hargaPer"
                                    class="form-control font-weight-bold" min="0">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="font-weight-bold" for="bttb_nilaiTrans">Nilai Trans</label>
                                <input type="number" name="bttb_nilaiTrans" id="bttb_nilaiTrans"
                                    class="form-control font-weight-bold" min="0" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold" for="bttb_supplier">Supplier</label>
                                <input type="text" name="bttb_supplier" id="bttb_supplier"
                                    class="form-control font-weight-bold" readonly>
                                <input type="hidden" name="bttb_noSupplier" id="bttb_noSupplier"
                                    class="form-control font-weight-bold" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <label class="font-weight-bold" for="bttb_jangkaWaktu">Jangka Waktu</label>
                                <div style="display: flex; flex-direction: row;gap: 1%; align-items: flex-end;">
                                    <input type="number" name="bttb_jangkaWaktu" id="bttb_jangkaWaktu"
                                        class="form-control font-weight-bold" style="width: 60%" min="0">
                                    <label class="font-weight-bold" for="bttb_jangkaWaktu">Hari</label>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="font-weight-bold" for="bttb_pembayaran">Pembayaran</label>
                                <input type="text" name="bttb_pembayaran" id="bttb_pembayaran"
                                    class="form-control font-weight-bold" readonly>
                            </div>
                            <div class="col-md-7 mb-3">
                                <label class="font-weight-bold" for="bttb_keterangan">Keterangan</label>
                                <textarea name="bttb_keterangan" id="bttb_keterangan"class="form-control font-weight-bold"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="font-weight-bold" for="bttb_jenisDokumen">Jenis Dokumen</label>
                                    <input type="text" name="bttb_jenisDokumen" id="bttb_jenisDokumen"
                                        class="form-control font-weight-bold">
                                </div>
                                <div class="mb-3">
                                    <label class="font-weight-bold" for="bttb_noSeriBarang">No. Seri Barang</label>
                                    <input type="text" name="bttb_noSeriBarang" id="bttb_noSeriBarang"
                                        class="form-control font-weight-bold">
                                </div>
                                <div class="mb-3">
                                    <label class="font-weight-bold" for="bttb_noPIBKRR">No. PIB KRR</label>
                                    <input type="text" name="bttb_noPIBKRR" id="bttb_noPIBKRR"
                                        class="form-control font-weight-bold">
                                </div>
                                <div class="mb-3">
                                    <label class="font-weight-bold" for="bttb_noPIBExternal">No. PIB External</label>
                                    <input type="text" name="bttb_noPIBExternal" id="bttb_noPIBExternal"
                                        class="form-control font-weight-bold">
                                </div>
                                <div class="mb-3">
                                    <label class="font-weight-bold" for="bttb_noRegisPIB">No. Registration PIB</label>
                                    <input type="text" name="bttb_noRegisPIB" id="bttb_noRegisPIB"
                                        class="form-control font-weight-bold">
                                </div>
                                <div class="mb-3">
                                    <label class="font-weight-bold" for="bttb_noBL">No. BL</label>
                                    <input type="text" name="bttb_noBL" id="bttb_noBL"
                                        class="form-control font-weight-bold">
                                </div>
                                <div class="mb-3">
                                    <label class="font-weight-bold" for="bttb_noKontrak">No. Kontrak</label>
                                    <input type="text" name="bttb_noKontrak" id="bttb_noKontrak"
                                        class="form-control font-weight-bold">
                                </div>
                                <div class="mb-3">
                                    <label class="font-weight-bold" for="bttb_noSPPBBC">No. SPPB BC</label>
                                    <input type="text" name="bttb_noSPPBBC" id="bttb_noSPPBBC"
                                        class="form-control font-weight-bold">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3" style="visibility: hidden">
                                    <label class="font-weight-bold" for="">Kolom Kosong</label>
                                    <input type="text" name="" id=""
                                        class="form-control font-weight-bold" readonly>
                                </div>
                                <div class="mb-3" style="visibility: hidden">
                                    <label class="font-weight-bold" for="">Kolom Kosong</label>
                                    <input type="text" name="" id=""
                                        class="form-control font-weight-bold" readonly>
                                </div>
                                <div class="mb-3" style="visibility: hidden">
                                    <label class="font-weight-bold" for="">Kolom Kosong</label>
                                    <input type="text" name="" id=""
                                        class="form-control font-weight-bold" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="font-weight-bold" for="bttb_tglPIBExternal">Tgl. PIB
                                        External</label>
                                    <input type="date" name="bttb_tglPIBExternal" id="bttb_tglPIBExternal"
                                        class="form-control font-weight-bold">
                                </div>
                                <div class="mb-3">
                                    <label class="font-weight-bold" for="bttb_tglRegisPIB">Tgl. Registration
                                        PIB</label>
                                    <input type="date" name="bttb_tglRegisPIB" id="bttb_tglRegisPIB"
                                        class="form-control font-weight-bold">
                                </div>
                                <div class="mb-3">
                                    <label class="font-weight-bold" for="bttb_tglBL">Tgl. BL</label>
                                    <input type="date" name="bttb_tglBL" id="bttb_tglBL"
                                        class="form-control font-weight-bold">
                                </div>
                                <div class="mb-3">
                                    <label class="font-weight-bold" for="bttb_tglKontrak">Tgl. Kontrak</label>
                                    <input type="date" name="bttb_tglKontrak" id="bttb_tglKontrak"
                                        class="form-control font-weight-bold">
                                </div>
                                <div class="mb-3">
                                    <label class="font-weight-bold" for="bttb_tglSPPBBC">Tgl. SPPB BC</label>
                                    <input type="date" name="bttb_tglSPPBBC" id="bttb_tglSPPBBC"
                                        class="form-control font-weight-bold">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mt-2">
                    <button type="submit" class="btn btn-success" id="button_modalProses">Proses</button>
                </div>
            </div>
        </div>
    </div>
</div>
