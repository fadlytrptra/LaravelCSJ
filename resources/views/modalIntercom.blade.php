<div class="modal fade" id="modalIntercom" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header intercom-header">
                <h5 class="modal-title">INTERCOM</h5>

                <button
                    type="button"
                    class="btn-close-intercom"
                    data-bs-dismiss="modal"
                    aria-label="Close">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        width="20"
                        height="20"
                        fill="currentColor"
                        viewBox="0 0 24 24">
                        <path d="m7.76 14.83-2.83 2.83 1.41 1.41 2.83-2.83 2.12-2.12.71-.71.71.71 1.41 1.42 3.54 3.53 1.41-1.41-3.53-3.54-1.42-1.41-.71-.71 5.66-5.66-1.41-1.41L12 10.59 6.34 4.93 4.93 6.34 10.59 12l-.71.71z"></path>
                    </svg>

                </button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <input
                        type="text"
                        id="searchIntercom"
                        class="form-control"
                        placeholder="Cari Nama atau Divisi...">
                </div>

                <div class="table-wrapper">
                    <table class="table table-bordered" id="tableIntercom">
                        <thead class="table-dark">
                            <tr>
                                <th width="120">Ext</th>
                                <th width="200">Divisi</th>
                                <th>Nama</th>
                            </tr>
                        </thead>

                        <tbody id="intercomBody">
                            <tr>
                                <td colspan="4" class="text-center">Loading...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
</div>


<style>

.intercom-header{
    display:flex;
    align-items:center;
    justify-content:space-between;
}

.modal-title{
    margin:0;
}

.btn-close-intercom{
    border:none;
    background:none;
    cursor:pointer;
    padding:6px;
    display:flex;
    align-items:center;
}

.btn-close-intercom svg{
    color:#333;
}

.btn-close-intercom:hover svg{
    color:#dc3545;
}
.table-wrapper{
    max-height:700px;
    overflow-y:auto;
    border:1px solid #dee2e6;
}

#tableIntercom{
    margin:0;
}

#tableIntercom thead th{
    position: sticky;
    top: 0;
    background:#212529;
    color:white;
    z-index:10;
}
</style>

<script src="{{ asset('js/intercom.js') }}"></script>
