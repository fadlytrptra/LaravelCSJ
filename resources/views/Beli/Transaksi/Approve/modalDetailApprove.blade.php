<div class="modal fade" id="modalDetailApprove" tabindex="-1" data-bs-keyboard="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="judul"></h5>
            </div>
            <div class="panel-body">
                <div id="loading">
                    <br>
                    <div class="loader" style="text-align: center;margin-left: 35%;"></div>
                    <br>
                </div>

                <form class="formDetail" method="POST" enctype="multipart/form-data" action="">
                    {{ csrf_field() }}
                    <div class="modal-body bordered" id="DivDetailData">
                        <p class="RDZCard" id="NamaBarang" onclick="Detail('Kategori_Barang','iconKategoriBarang');">
                        </p>
                        <div id="Kategori_Barang" style="display: none;border: 1px solid;padding-left: 10px">
                            <p class="RDZCard2" id="KategoriUtama"></p>
                            <p class="RDZCard2" id="Kategori"></p>
                            <p class="RDZCard2" id="SubKategori"></p>
                        </div>
                        <p class="RDZCard" id="Qty"></p>
                        <p class="RDZCard" id="Divisi"></p>
                        <p class="RDZCard" id="Pemesan"></p>
                        <p class="RDZCard" id="User"></p>
                        <p class="RDZCard" id="Status"></p>
                        <p class="RDZCard" id="TglButuh"></p>
                        <p class="RDZCard" id="KetOrder"></p>
                        <p class="RDZCard" id="KetInternal"></p>
                        <p class="RDZCard" id="PembelianTerakhir"></p>
                        <button type="submit" class="btn btn-sm btn-default RDZButtonCard"
                            style="background-color:#007bff;color: white;" name="action"
                            value="Approve">Approve</button>

                        <button type="submit" class="btn btn-sm btn-default RDZButtonCard"
                            style="background-color:#dc3545;color: white;" name="action" value="Reject">Reject</button>

                        <button type="button" class="btn btn-sm btn-default RDZButtonCard" data-bs-dismiss="modal"
                            style="background-color:gray;color: white;">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
