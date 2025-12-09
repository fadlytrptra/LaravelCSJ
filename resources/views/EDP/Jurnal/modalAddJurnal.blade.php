<!-- <script>
    $(document).ready(function() {
    $('#Pelapor').select2();
});
</script> -->
<div class="modal fade" id="AddJurnal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ADD</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="panel-body">
            <form class="form" method="POST" enctype="multipart/form-data" action="{{ url('/Jurnal') }}" >
                {{ csrf_field() }}
            <div class="modal-body">
                <label>Tgl. Lapor</label>
                <input class="form-control" type="date" id="TglLapor" name="TglLapor" value="{{ old('TglLapor', now()->format('Y-m-d')) }}" required>
                <br>
                <label>Tgl. Selesai</label>
                <input class="form-control" type="date" id="TglSelesai" name="TglSelesai" value="" required>
                <br>
                <label>Pelapor</label>
                <select class="form-control" id="Pelapor" name="Pelapor" value="" required>
                @foreach($user as $item)
                    <option value="{{$item->IDUser}}">{{$item->NamaUser}}</option>
                @endforeach
                </select>
                <br>
                <label>Kategori</label>
                <select class="form-control" name="Kategori" id="Kategori">
                @foreach($kategori as $item)
                    <option value="{{$item->IdKategori}}">{{$item->Kategori}}</option>
                    @endforeach
                </select>
                <br>
                <label>Detail Masalah</label>
                <textarea class="form-control" id="DetailMasalah" name="DetailMasalah" rows="4" cols="50" maxlength="500" required></textarea>
                <br>
                <label>Solusi</label>
                <textarea class="form-control" id="Solusi" name="Solusi" rows="4" cols="50" maxlength="500" required></textarea>

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
