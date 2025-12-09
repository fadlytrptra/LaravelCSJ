<div class="modal fade" id="AddInputKelompok">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Masukkan Kelompok</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="panel-body">
            <form class="formInputKelompok" method="POST" enctype="multipart/form-data" action="" >
                {{ csrf_field() }}
            <div class="modal-body">
                <label>Kelompok</label>
                <select class="form-control" name="EditKelompok" id="EditKelompok">
                @foreach($kelompok as $item)
                    <option value="{{$item->IdKelompok}}">{{$item->Kelompok}}</option>
                    @endforeach
                </select>
                <br>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-primary"  name="submit">Masukkan</button>
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </form>
    </div>
        </div>
    </div>
</div>
