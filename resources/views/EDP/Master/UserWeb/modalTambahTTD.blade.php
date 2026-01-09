<div class="modal fade" id="modalTambahTTD" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabelTambahTTD">Tambah TTD</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span>x</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="py-2">
                    <label for="mmu_gambarTTD">Upload Gambar TTD</label>
                    <div class="input-group">
                        <input type="file" class="form-control-file" id="mmu_gambarTTD" name="mmu_gambarTTD"
                            accept="image/*" readonly>
                    </div>
                </div>
                <div class="py-2">
                    <label>Preview Gambar TTD</label>
                    <div id="imagePreview" style="padding: 10px;">
                        <img id="previewImg" src="#" alt="Preview Image"
                            style="width: 100%; border: 1px solid black;display:none;">
                    </div>
                    <br>
                    <button type="button" class="btn btn-secondary" id="clearImage" style="width:100px">Clear</button>
                </div>
                <div class="d-flex" style="justify-content: end;width: 100%">
                    <button class="btn btn-info" id="mmu_buttonSave">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
