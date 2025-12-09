<div class="modal" id="AddCartridge">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ADD</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="panel-body">
            <form class="form" method="POST" enctype="multipart/form-data" action="{{ url('/Cartridge') }}" >
                {{ csrf_field() }}
            <div class="modal-body">
                <label>Number</label>
                <input id="number" type="text" class="form-control" name="number" value="{{ $maxid }}" required readonly>
                <br>
                <label>User</label>
                <input id="user" type="text" class="form-control" name="user" value="{{ old('user') }}" onkeyup="filterFunction('user','DropdownUser')" required>
                <div id="DropdownUser">
                    @foreach($User as $item)
                        <p style="border:1px solid black;margin-bottom: 0px;display: none" class="form-control RDZpointer" id="itemUser" name="{{$item->User}}" onclick="ChangeValue('user','DropdownUser','{{$item->User}}')">{{$item['User']}}</p>
                    @endforeach
                </div>
                <br>
                <label>Type</label>
                <input id="type" type="text" class="form-control" name="type" value="{{ old('type') }}" onkeyup="filterFunction('type','DropdownTable')" required>
                <div id="DropdownTable">
                    @foreach($Type as $item)
                        <p style="border:1px solid black;margin-bottom: 0px;display: none" class="form-control RDZpointer" id="itemUser" name="{{$item->Type}}" onclick="ChangeValue('type','DropdownTable','{{$item->Type}}')">{{$item['Type']}}</p>
                    @endforeach
                </div>
                <br><br>
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
