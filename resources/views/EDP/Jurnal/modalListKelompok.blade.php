<div class="modal fade" id="ListKelompok">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">List Kelompok</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="panel-body">
                <div class="modal-body">
                    <table class="table table-bordered table-striped" style="width:100%;">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Kelompok</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kelompok as $item)
                                <tr>
                                    <td class="RDZPaddingTable">{{$item['Kelompok']}}</td>
                                    <td class="RDZPaddingTable">
                                        <a class="EditKelompok btn btn-warning btn-xs"
                                            href="{{route('kelompok.update',$item->IdKelompok)}}" data-kelompok="{{$item->Kelompok}}">Edit</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                    </table>
                    <br>
                    <a href="" class="AddKelompok btn btn-primary btn-xs RDZButtonCard">Tambah Kelompok</a>
                    <button type="button" class="btn btn-sm btn-default RDZButtonCard" data-dismiss="modal" style="background-color:gray;color: white;">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>
