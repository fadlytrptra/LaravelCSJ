<div class="modal fade" id="ListKategori">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">List Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="panel-body">
                <div class="modal-body">
                    <table class="table table-bordered table-striped" style="width:100%;">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Kategori</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kategori as $item)
                                <tr>
                                    <td class="RDZPaddingTable">{{$item['Kategori']}}</td>
                                    <td class="RDZPaddingTable">
                                        <a class="EditKategori btn btn-warning btn-xs"
                                            href="{{route('kategori.update',$item->IdKategori)}}" data-kategori="{{$item->Kategori}}">Edit</a>
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                    </table>
                    <br>
                    <a href="" class="AddKategori btn btn-primary btn-xs RDZButtonCard">Tambah Kategori</a>
                    <button type="button" class="btn btn-sm btn-default RDZButtonCard" data-dismiss="modal" style="background-color:gray;color: white;">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>
