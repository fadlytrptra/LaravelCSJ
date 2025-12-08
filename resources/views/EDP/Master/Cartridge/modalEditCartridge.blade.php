<div class="modal" id="EditCartridge">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="judulEditCatridge">EDIT</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="panel-body">
            <form class="formEditService" method="POST" enctype="multipart/form-data" action="" >
                {{ csrf_field() }}
            <div class="modal-body">

                <label>User</label>
                <input id="userEdit" type="text" class="form-control" name="userEdit" value="{{ old('user') }}" onkeyup="filterFunction('userEdit','DropdownUserEdit')" required>
                <div id="DropdownUserEdit">
                    @foreach($User as $item)
                        <p style="border:1px solid black;margin-bottom: 0px;display: none" class="form-control RDZpointer" id="itemUser" onclick="ChangeValue('userEdit','DropdownUserEdit','{{$item->User}}')">{{$item['User']}}</p>
                    @endforeach
                </div>
                <br>

                <label>Type</label>
                <input id="typeEdit" type="text" class="form-control" name="typeEdit" value="{{ old('type') }}" onkeyup="filterFunction('typeEdit','DropdownTableEdit')" required>
                <div id="DropdownTableEdit">
                    @foreach($Type as $item)
                        <p style="border:1px solid black;margin-bottom: 0px;display: none" class="form-control RDZpointer" id="itemUser" onclick="ChangeValue('typeEdit','DropdownTableEdit','{{$item->Type}}')">{{$item['Type']}}</p>
                    @endforeach
                </div>
                <br><br>
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
