<div class="modal" id="EditNota">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Nota</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form class="form" method="POST" enctype="multipart/form-data" action="{{route('perbaikancartridge.update',$id)}}" >
            {{ csrf_field() }}
                <div class="modal-body">
                    <label>Tanggal</label>
                    <input class="form-control" type="date" id="EditTglRefill" name="EditTglRefill" value="{{$Nota->Tanggal}}">
                    <br>
                    <label>No. Nota</label>
                    <input class="form-control" type="text" id="EditNoNota" name="EditNoNota" value="{{$Nota->NoNota}}">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-warning"  name="submit">EDIT</button>
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
