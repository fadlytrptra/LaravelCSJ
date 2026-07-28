document.addEventListener("DOMContentLoaded", function () {

    const lampiran = document.getElementById("lampiran");
    const lampiranBase64 = document.getElementById("lampiran_base64");
    const previewImage = document.getElementById("previewImage");
    const modalTambah = document.getElementById("tambahPengumumanModal");
    const fileNameDisplay = document.getElementById("fileNameDisplay");
    const pengumumanModal = document.getElementById("modalPengumuman");

    modalTambah.addEventListener("hidden.bs.modal", function () {

        lampiran.value = "";
        lampiranBase64.value = "";

        if (fileNameDisplay) {
            fileNameDisplay.value = "Belum ada file dipilih";
        }

        previewImage.src = "";
        previewImage.removeAttribute("src");
        previewImage.classList.add("d-none");

        if (pengumumanModal) {
            let modal = new bootstrap.Modal(pengumumanModal);
            modal.show();
        }
    });

    lampiran.addEventListener("change", function () {

        if (this.files.length === 0) {

            lampiranBase64.value = "";

            if (fileNameDisplay) {
                fileNameDisplay.value = "Belum ada file dipilih";
            }

            previewImage.src = "";
            previewImage.classList.add("d-none");

            return;
        }

        const file = this.files[0];

        // tampilkan nama file
        if (fileNameDisplay) {
            fileNameDisplay.value = file.name;
        }

        // validasi ukuran maksimal 3 MB
        if (file.size > 3 * 1024 * 1024) {

            alert("Ukuran file maksimal 3 MB.");

            this.value = "";
            lampiranBase64.value = "";

            if (fileNameDisplay) {
                fileNameDisplay.value = "Belum ada file dipilih";
            }

            previewImage.src = "";
            previewImage.classList.add("d-none");

            return;
        }

        const reader = new FileReader();

        reader.onload = function (e) {

            lampiranBase64.value = e.target.result;

            // preview hanya untuk gambar
            if (file.type.startsWith("image/")) {

                previewImage.src = e.target.result;
                previewImage.classList.remove("d-none");

            } else {

                previewImage.src = "";
                previewImage.classList.add("d-none");
            }
        };

        reader.readAsDataURL(file);
    });

});