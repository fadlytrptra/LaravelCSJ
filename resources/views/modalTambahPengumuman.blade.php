<style>
    #tambahPengumumanModal .modal-dialog {
        max-height: 90vh;
    }

    #tambahPengumumanModal .modal-body {
        max-height: 70vh;
        overflow-y: auto;
    }
</style>
<!-- Modal Tambah Pengumuman -->
<div class="modal fade" id="tambahPengumumanModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Tambah Pengumuman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>

            <form method="POST" action="{{ route('pengumuman.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Tanggal Akhir Berlaku</label>
                            <input type="date" name="tgl_akhir" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Penulis</label>
                        <input type="text" class="form-control" value="{{ Auth::user()->NamaUser }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label>Judul</label>
                        <input type="text" name="judul_pesan" maxlength="100" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Isi Pengumuman</label>
                        <textarea name="isi_pesan" rows="4" class="form-control" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="lampiran" class="form-label">Lampiran</label>
                        {{-- 📎 --}}
                        <div class="input-group">
                            <button type="button" class="btn btn-primary"
                                onclick="document.getElementById('lampiran').click()">
                                Pilih File
                            </button>

                            <input type="text" class="form-control" id="fileNameDisplay"
                                value="Belum ada file dipilih" readonly>

                            <input type="file" id="lampiran" accept=".pdf,.jpg,.jpeg,.png" hidden>
                        </div>

                        <input type="hidden" id="lampiran_base64" name="lampiran">

                        <small class="text-muted">
                            Format: PDF, JPG, JPEG, PNG (Max 3MB)
                        </small>

                        <div class="mt-2">
                            <img id="previewImage" class="img-thumbnail d-none" style="max-width:100px;">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kirim Pesan WhatsApp</label>

                        <div class="form-check">
                            <input type="hidden" name="grup_pengumuman" value="0">

                            <input class="form-check-input" type="checkbox" name="grup_pengumuman" value="1"
                                id="grupPengumuman">

                            <label class="form-check-label" for="grupPengumuman">
                                KRR Pengumuman
                            </label>
                        </div>

                        <div class="form-check">
                            <input type="hidden" name="grup_staff" value="0">

                            <input class="form-check-input" type="checkbox" name="grup_staff" value="1"
                                id="grupStaff">

                            <label class="form-check-label" for="grupStaff">
                                KRR Staff
                            </label>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
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
<script type="text/javascript" src="{{ asset('js/EDP/Pengumuman.js') }}"></script>
{{-- <script>
    document.addEventListener("DOMContentLoaded", function() {
        const tambahModal = document.getElementById("tambahPengumumanModal");
        const pengumumanModal = document.getElementById("modalPengumuman");

        tambahModal.addEventListener("hidden.bs.modal", function() {
            const modal = new bootstrap.Modal(pengumumanModal);
            modal.show();
        });
    });
</script> --}}
