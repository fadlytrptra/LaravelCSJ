<div class="modal fade" id="ModalEditKelompok">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Kelompok</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="panel-body">
            <form class="formEditKelompok" method="POST" enctype="multipart/form-data" action="" >
                {{ csrf_field() }}
            <div class="modal-body">
                <label>Kelompok</label>
                <input class="form-control" type="text" id="EditKelompok1" name="EditKelompok1" required>
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
