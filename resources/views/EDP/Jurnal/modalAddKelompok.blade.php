<div class="modal fade" id="AddKelompok">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kelompok</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="panel-body">
            <form class="form" method="POST" enctype="multipart/form-data" action="{{ url('/Jurnal/AddKelompok') }}" >
                {{ csrf_field() }}
            <div class="modal-body">
                <label>Kelompok</label>
                <input class="form-control" type="text" id="Kelompok" name="Kelompok" value="{{ old('Kelompok') }}" required>
                <br>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-primary"  name="submit">Add</button>
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </form>
    </div>
        </div>
    </div>
</div>
