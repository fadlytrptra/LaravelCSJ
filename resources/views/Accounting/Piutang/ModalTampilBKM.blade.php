<!--MODAL TAMPIL BKM-->
<div
  class="modal fade"
  id="modalTampilBKM"
  tabindex="-1"
  role="dialog"
  aria-labelledby="pilihBankModal"
  aria-hidden="true"
>
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="padding: 25px">
      <div class="modal-header">
        <h5 class="modal-title">Maintenance Kurang/Lebih BKM</h5>
        <button
          type="button"
          class="close"
          data-dismiss="modal"
          aria-label="Close"
        >
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form
        action="{{ url('MaintenanceBKMPenagihan') }}"
        id="formTampilBKM"
        method="POST"
      >
        {{ csrf_field() }}
        <input type="hidden" name="_method" id="methodTampilBKM" />
        <div class="d-flex">
          <div class="col-md-3">
            <label for="tanggalInputTampil" style="margin-right: 10px"
              >Tanggal Input</label
            >
          </div>
          <div class="col-md-3">
            <input
              type="date"
              id="tanggalInputTampil"
              name="tanggalInputTampil"
              class="form-control"
              style="width: 100%"
            />
          </div>
          <div class="col-md-1">S/D</div>
          <div class="col-md-3">
            <input
              type="date"
              id="tanggalInputTampil2"
              name="tanggalInputTampil2"
              class="form-control"
              style="width: 100%"
            />
          </div>
          <div class="col-md-3">
            <button id="btnOkTampil" name="btnOkTampil">OK</button>
          </div>
        </div>
        <div class="d-flex">
          <div class="col-md-3">
            <label for="idBKM" style="margin-right: 10px">Id. BKM</label>
          </div>
          <div class="col-md-2">
            <input
              type="text"
              id="idBKM"
              name="idBKM"
              class="form-control"
              style="width: 100%"
            />
          </div>
          <div class="col-md-3">
            <button id="btnCETAK" name="btnCETAK">CETAK</button>
          </div>
        </div>
        <div style="overflow-x: auto; overflow-y: auto; max-height: 250px">
          <table style="width: 120%; table-layout: fixed" id="tabelTampilBKM">
            <colgroup>
              <col style="width: 30%" />
              <col style="width: 30%" />
              <col style="width: 30%" />
              <col style="width: 30%" />
            </colgroup>
            <thead class="table-dark">
              <tr>
                <th>Tgl. Input</th>
                <th>Id. BKM</th>
                <th>Nilai Pelunasan</th>
                <th>Terjemahan</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
        <input
          type="hidden"
          name="detpelunasan"
          id="detpelunasan"
          value="dettampilbkm"
        />
      </form>
    </div>
  </div>
</div>
