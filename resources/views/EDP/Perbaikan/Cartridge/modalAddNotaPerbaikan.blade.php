<div class="modal" id="AddNota">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form class="form" method="POST" enctype="multipart/form-data" action="{{ url('/PerbaikanCartridge') }}" >
            {{ csrf_field() }}
                <div class="modal-body">
                    <label>Tanggal</label>
                    <input class="form-control" type="date" id="TglRefill" name="TglRefill" value="">
                    <br>
                    <label>No. Nota</label>
                    <input class="form-control" type="text" id="NoNota" name="NoNota" value="">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary"  name="submit">Add</button>
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
