<!--MODAL MAINTENANCE KURANG/LEBIH BKM-->
                <div class="modal fade" id="modalDetailKurangLebih" tabindex="-1" role="dialog"
                    aria-labelledby="pilihBankModal" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="pilihBankModal">Maintenance Kurang/Lebih BKM</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ url('MaintenanceBKMPenagihan') }}" id="formDetailKurangLebih"
                                method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" id="methodkuranglebih">
                                <div class="d-flex">
                                    <div class="col-md-3">
                                        <label for="jumlahUang" style="margin-right: 10px;">Jumlah Uang</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" id="jumlahUang" name="jumlahUang" class="form-control"
                                            style="width: 100%">
                                    </div>
                                    <input type="hidden" name="idcoba" id="idcoba" value="idcoba">
                                </div>
                                <div class="d-flex">
                                    <div class="col-md-3">
                                        <label for="kodePerkiraan" style="margin-right: 10px;">Kode
                                            Perkiraan</label>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" id="idKodePerkiraanKrgLbh" name="idKodePerkiraanKrgLbh"
                                            class="form-control" style="width: 100%">
                                    </div>
                                    <div class="col-md-7">
                                        <select name="kodePerkiraanKrgLbhSelect" id="kodePerkiraanKrgLbhSelect"
                                            class="form-control">

                                        </select>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="col-md-3">
                                        <label for="keterangan" style="margin-right: 10px;">Keterangan</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" id="keterangan" name="keterangan" class="form-control"
                                            style="width: 100%">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-5">
                                        <input type="submit" id="btnProsesKurangLebih" name="btnProsesKurangLebih"
                                            value="Proses" class="btn btn-primary">
                                    </div>
                                    <div class="col-3">
                                    </div>
                                    <div class="col-4">
                                        <input type="submit" id="btnTutupModal" name="btnTutupModal" value="Tutup"
                                            class="btn btn-primary">
                                    </div>
                                </div>
                                <input type="hidden" name="detpelunasan" id="detpelunasan" value="detkuranglebih">

                        </div>
                        </form>
                    </div>
                </div>
