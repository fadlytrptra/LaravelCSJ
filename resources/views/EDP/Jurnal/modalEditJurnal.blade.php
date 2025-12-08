<div class="modal fade" id="EditJurnal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="panel-body">
            <form class="formEditJurnal" method="POST" enctype="multipart/form-data" action="" >
                {{ csrf_field() }}
            <div class="modal-body">
                <label>Tgl. Lapor</label>
                <input class="form-control" type="date" id="EditTglLapor" name="EditTglLapor" value="" require>
                <br>
                <label>Tgl. Selesai</label>
                <input class="form-control" type="date" id="EditTglSelesai" name="EditTglSelesai" value="" require>
                <br>
                <label>Pelapor</label>
                <select class="form-control" id="EditPelapor" name="EditPelapor" value="" required>
                @foreach($user as $item)
                    <option value="{{trim($item->IDUser)}}">{{$item->NamaUser}}</option>
                @endforeach
                </select>
                <br>
                <label>Kategori</label>
                <input class="form-control" type="text" id="EditKategori" name="EditKategori" value="" onkeyup="filterFunction('EditKategori','DropdownEditKategori')" required>
                <div id="DropdownEditKategori">
                    @foreach($kategori as $item)
                        <p style="border:1px solid black;margin-bottom: 0px;display: none" class="form-control RDZpointer" id="itemEditKategori" name="{{$item->Kategori}}" onclick="ChangeValue('EditKategori','DropdownEditKategori','{{$item->Kategori}}')">{{$item['Kategori']}}</p>
                    @endforeach
                </div>
                <br>
                <label>Detail Masalah</label>
                <textarea class="form-control" id="EditDetailMasalah" name="EditDetailMasalah" rows="4" cols="50" maxlength="500" require></textarea>
                <br>
                <label>Solusi</label>
                <textarea class="form-control" id="EditSolusi" name="EditSolusi" rows="4" cols="50" maxlength="500" require></textarea>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-primary"  name="submit">Edit</button>
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </form>
    </div>
        </div>
    </div>
</div>
