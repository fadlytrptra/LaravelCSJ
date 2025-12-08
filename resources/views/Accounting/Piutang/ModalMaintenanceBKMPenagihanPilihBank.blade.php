<div class="modal fade" id="pilihBank" tabindex="-1" role="dialog" aria-labelledby="pilihBankModal" aria-hidden="true">
    <div class="modal-dialog custom-modal-width">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pilihBankModal">Maintenance Pilih Bank BKM</h5>
            </div>
            <div class="modal-body">
                <div class="form-container col-md-12">
                    <div style="display: flex;flex-direction:row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="idPelunasan" style="width: 51%">Id Pelunasan</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" style="width: 100%" id="idPelunasan"
                                        name="idPelunasan" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tanggalInput" style="width: 51%">Tanggal Input</label>
                                <div class="input-group">
                                    <input type="date" id="tanggalInput" name="tanggalInput" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tanggalTagih" style="width: 51%">Tanggal Tagih</label>
                                <div class="input-group">
                                    <input type="date" name="tanggalTagih" id="tanggalTagih" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="jenisBayar" style="width: 51%">Jenis Bayar</label>
                                <div class="input-group">
                                    <input type="date" name="jenisBayar" id="jenisBayar" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="bankSelect" style="width: 100%;">Bank</label>
                                <div class="input-group" style="display: flex; align-items: center;">
                                    <input type="hidden" id="idBank" name="idBank" class="form-control">
                                    <select name="namaBankSelect" id="namaBankSelect" class="form-control"
                                        style="width: auto">
                                        <option disabled selected>-- Pilih Bank --</option>
                                        {{-- @foreach ($kodePerkiraan as $kp)
                                            <option value="{{ $kp->NoKodePerkiraan }}">{{ $kp->NoKodePerkiraan }} |
                                                {{ $kp->Keterangan }}</option>
                                        @endforeach --}}
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mataUang" style="width: 51%">Mata Uang</label>
                                    <div class="input-group">
                                        <input type="text" name="mataUang" id="mataUang" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nilaiPelunasan" style="width: 51%">Nilai Pelunasan</label>
                                    <div class="input-group">
                                        <input type="text" name="nilaiPelunasan" id="nilaiPelunasan"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="noBukti" style="width: 51%">No. Bukti</label>
                                    <div class="input-group">
                                        <input type="text" name="noBukti" id="noBukti" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="person" style="width: 51%">Person</label>
                                    <div class="input-group">
                                        <input type="text" name="person" id="person" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="hp" style="width: 51%">HP</label>
                                    <div class="input-group">
                                        <input type="text" name="hp" id="hp" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary" id="prosesButtonModal">Proses</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Keluar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
