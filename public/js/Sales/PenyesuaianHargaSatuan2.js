jQuery(function ($) {
    //#region Variables
    let csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
    let id_pengiriman = document.getElementById("id_pengiriman");
    let button_updateHargaSatuan2 = document.getElementById("button_updateHargaSatuan2"); // prettier-ignore
    //#endregion

    //#region Event Listeners
    id_pengiriman.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            button_updateHargaSatuan2.focus();
        }
    });

    button_updateHargaSatuan2.addEventListener("click", function (e) {
        Swal.fire({
            title: "Konfirmasi",
            text: "Apakah Anda yakin ingin mengupdate Harga Satuan 2 untuk ID Pengiriman yang tertera?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Ya, Update",
            cancelButtonText: "Batal",
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
        }).then((result) => {
            if (result.isConfirmed) {
                // Regex validasi format: 0001, 0002, 0003
                let regex = /^\d+(,\s\d+)*$/;

                if (!regex.test(id_pengiriman.value.trim())) {
                    Swal.fire({
                        icon: "warning",
                        title: "Format Salah",
                        text: "Format harus: 0000006500, 0000006501 (dipisahkan koma dan spasi).",
                    });
                    return;
                }

                $.ajax({
                    url: "/PenyesuaianHargaSatuan2",
                    method: "POST",
                    data: {
                        _token: csrfToken,
                        idPengiriman: id_pengiriman.value.trim(),
                    },
                    dataType: "json",
                    success: function (data) {
                        console.log(data);
                        if (!data || data.error) {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                showConfirmButton: false,
                                timer: 1000,
                                text:
                                    data.error ??
                                    "Penyesuaian Harga Satuan 2 failed code unknown.",
                                returnFocus: false,
                            });
                        } else {
                            let htmlResult = "";

                            data.success.forEach((item) => {
                                let statusIcon =
                                    item.DifferenceMade === "TRUE"
                                        ? "🟢"
                                        : "⚪";
                                let statusText =
                                    item.DifferenceMade === "TRUE"
                                        ? "Berubah"
                                        : "Tidak Berubah";

                                htmlResult += `
                                    <div style="text-align:left; margin-bottom:8px;">
                                        ${statusIcon}
                                        <b>ID Pengiriman:</b> ${item.IDPengiriman}<br>
                                        <b>Status Berubah:</b> ${item.DifferenceMade}<br>
                                        <b>Harga Satuan 2:</b> ${item.HargaSatuan2}
                                    </div>
                                    <hr>
                                `;
                            });
                            Swal.fire({
                                icon: "success",
                                title: "Success",
                                html: htmlResult,
                                returnFocus: false,
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "Failed to Penyesuaian Harga Satuan 2.",
                        });
                    },
                });
            }
        });
    });
    //#endregion
});
