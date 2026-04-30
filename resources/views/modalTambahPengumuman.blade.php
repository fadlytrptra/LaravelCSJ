<!-- Modal Tambah Pengumuman -->
<div class="modal fade" id="tambahPengumumanModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Tambah Pengumuman</h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>
            </div>

            <form method="POST" action="{{ route('pengumuman.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Tanggal Akhir Berlaku</label>
                            <input
                                type="date"
                                name="tgl_akhir"
                                class="form-control"
                                required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Penulis</label>
                        <input
                            type="text"
                            class="form-control"
                            value="{{ Auth::user()->NamaUser }}"
                            readonly>
                    </div>

                    <div class="mb-3">
                        <label>Judul</label>
                        <input
                            type="text"
                            name="judul_pesan"
                            maxlength="100"
                            class="form-control"
                            required>
                    </div>

                    <div class="mb-3">
                        <label>Isi Pengumuman</label>
                        <textarea
                            name="isi_pesan"
                            rows="4"
                            class="form-control"
                            required></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                        Batal
                    </button>

                    <button class="btn btn-success">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const tambahModal = document.getElementById("tambahPengumumanModal");
    const pengumumanModal = document.getElementById("modalPengumuman");

    tambahModal.addEventListener("hidden.bs.modal", function () {
        const modal = new bootstrap.Modal(pengumumanModal);
        modal.show();
    });
});
</script>
