<div class="modal fade" id="EditKategori">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="panel-body">
            <form class="formEditKategori" method="POST" enctype="multipart/form-data" action="" >
                {{ csrf_field() }}
            <div class="modal-body">
                <label>Kategori</label>
                <input class="form-control" type="text" id="EditKategori1" name="EditKategori1" required>
                <br>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-warning"  name="submit">Edit</button>
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </form>
    </div>
        </div>
    </div>
</div>
