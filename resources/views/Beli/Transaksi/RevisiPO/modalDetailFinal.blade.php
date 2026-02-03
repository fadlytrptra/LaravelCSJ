<div class="modal fade" id="modalDetailFinal" tabindex="-1" data-bs-keyboard="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="judulFinal"></h5>
            </div>
            <div class="panel-body">
                <div id="loadingFinal">
                    <br>
                    <div class="loader" style="text-align: center;margin-left: 35%;"></div>
                    <br>
                </div>

                <form class="formDetailFinal" method="POST" enctype="multipart/form-data" action="">
                    {{ csrf_field() }}
                    <div class="modal-body bordered" id="DivDetailDataFinal">
                        <p class="RDZCard" id="NamaBarangFinal"
                            onclick="Detail('Kategori_Barang','iconKategoriBarang');"></p>
                        <div id="Kategori_Barang" style="display: none;border: 1px solid;padding-left: 10px;">
                            <p class="RDZCard2" id="KategoriUtamaFinal"></p>
                            <p class="RDZCard2" id="KategoriFinal"></p>
                            <p class="RDZCard2" id="SubKategoriFinal"></p>
                        </div>
                        <p class="RDZCard" id="QtyFinal"></p>
                        <p class="RDZCard" id="DivisiFinal"></p>
                        <p class="RDZCard" id="PemesanFinal"></p>
                        <p class="RDZCard" id="UserFinal"></p>
                        <p class="RDZCard" id="StatusFinal"></p>
                        <p class="RDZCard" id="TglButuhFinal"></p>
                        <p class="RDZCard" id="KetOrderFinal"></p>
                        <p class="RDZCard" id="KetInternalFinal"></p>
                        <p class="RDZCard" id="Supplier" onclick="Detail('Detail_Supplier','iconSupplier');"></p>
                        <div id="Detail_Supplier" style="display: none;border: 1px solid;padding-left: 10px">
                            <p class="RDZCard2" id="Kota"></p>
                        </div>
                        <p class="RDZCard" id="Total" onclick="Detail('Detail_Harga','iconHarga');"></p>
                        <div id="Detail_Harga" style="display: none;border: 1px solid;padding-left: 10px">
                            <p class="RDZCard2" id="Harga"></p>
                            <p class="RDZCard2" id="Subtotal"></p>
                            <p class="RDZCard2" id="PPN"></p>
                        </div>
                        <p class="RDZCard" id="AccManager"></p>
                        <p class="RDZCard" id="Offered"></p>
                        <p class="RDZCard" id="History" onclick="Detail('Detail_History','iconHistory');">Pembelian
                            Terakhir <text class='material-symbols-outlined' style='font-size:20px'
                                id='iconHistory'>expand_more</text> <i class="icofont-simple-up"></i></p>
                        <div id="Detail_History" style="display: none;border: 1px solid;padding-left: 10px">
                            <p class="RDZCard2" id="PembelianTerakhirFinal"></p>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-sm btn-default RDZButtonCard"
                            style="background-color:#007bff;color: white;" name="action" value="Approve">Final
                            Approve</button>

                        <button type="button" class="btn btn-sm btn-default RDZButtonCard" data-bs-dismiss="modal"
                            style="background-color:gray;color: white;">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
