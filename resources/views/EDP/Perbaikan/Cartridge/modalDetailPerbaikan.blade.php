<script>
    $(document).ready( function () {
    $('#TabelDetailRefill').DataTable({
        searching: false,
        paging: false,
        info: false
    });
} );
</script>

<div class="modal" id="DetailRefill">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="panel-body">
            <form class="formDetailRefill" method="POST" enctype="multipart/form-data" action="" >
                {{ csrf_field() }}
            <div class="modal-body bordered">
                    <table class="table table-borderless stripe" id="TabelDetailRefill">
                        <thead class="thead-dark">
                            <tr>
                                <th>Type</th>
                                <th>Service</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
            </div>
        </form>
    </div>
        </div>
    </div>
</div>
