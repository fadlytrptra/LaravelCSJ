<div class="modal fade" id="modalDetail_ListOrder" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="judul_ListOrder"></h5>
            </div>
            <div class="panel-body">
                <div id="loading_ListOrder">
                    <br>
                    <div class="loader" style="text-align: center;margin-left: 35%;"></div>
                    <br>
                </div>
                <div class="modal-body" id="DivDetailData_ListOrder">
                    <p class="RDZCard" id="NamaBarang_ListOrder"
                        onclick="Detail('Kategori_Barang','iconKategoriBarang');"></p>
                    <div id="Kategori_Barang" style="display: none;border: 1px solid;padding-left: 10px">
                        <p class="RDZCard2" id="KategoriUtama_ListOrder"></p>
                        <p class="RDZCard2" id="Kategori_ListOrder"></p>
                        <p class="RDZCard2" id="SubKategori_ListOrder"></p>
                    </div>
                    <p class="RDZCard" id="Pemesan_ListOrder"></p>
                    <p class="RDZCard" id="Status_ListOrder"></p>
                    <p class="RDZCard" id="TglButuh_ListOrder"></p>
                    <p class="RDZCard" id="keterangan" onclick="Detail('Detail_Ket','iconKet');">Keterangan : <text
                            class='material-symbols-outlined' style='font-size:20px;cursor:pointer' id='iconKet'>expand_more</text>
                    </p>
                    <div id="Detail_Ket" style="display: none;border: 1px solid;padding-left: 10px">
                        <p class="RDZCard" id="KetBarang_ListOrder"></p>
                        <p class="RDZCard" id="KetOrder_ListOrder"></p>
                        <p class="RDZCard" id="KetInternal_ListOrder"></p>
                    </div>
                    <p class="RDZCard" id="AccManager_ListOrder"></p>
                    <p class="RDZCard" id="Offered_ListOrder"></p>
                    <p class="RDZCard" id="AccDireksi_ListOrder"></p>
                    <p class="RDZCard" id="CreatePO_ListOrder"></p>
                    <p class="RDZCard" id="TotalPrice_ListOrder" onclick="Detail('Detail_Harga','iconHarga');"></p>
                    <div id="Detail_Harga" style="display: none;border: 1px solid;padding-left: 10px">
                        <p class="RDZCard" id="Currency_ListOrder"></p>
                        <p class="RDZCard" id="UnitPrice_ListOrder"></p>
                        <p class="RDZCard" id="Discount_ListOrder"></p>
                        <p class="RDZCard" id="PPN_ListOrder"></p>
                    </div>
                    <p class="RDZCard" id="ReceiveBTTB_ListOrder"></p>
                    <p class="RDZCard" id="TransferInventory_ListOrder"></p>
                    <p class="RDZCard" id="StatusOrder_ListOrder"></p>

                    <button type="button" class="btn btn-sm btn-default RDZButtonCard" data-bs-dismiss="modal"
                        style="background-color:gray;color: white;">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>
