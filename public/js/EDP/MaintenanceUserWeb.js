jQuery(function ($) {
    //#region Variables
    let csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
    let table_userWeb = $("#table_userWeb").DataTable({
        processing: true, // Optional, as processing is more relevant for server-side
        responsive: true,
        serverSide: true,
        order: [2, "desc"],
        ajax: {
            url: "/MaintenanceUserWeb/getDataUser",
            type: "GET",
        },
        columns: [
            { data: "NomorUser" },
            { data: "NamaUser" },
            {
                data: "IDUser",
                render: function (data, type, full, meta) {
                    let buttonTtd =
                        '<button class="btn btn-primary btn-ttd" data-id="' +
                        data +
                        '"data-bs-toggle="modal" data-bs-target="#modalTambahTTD">Input TTD</button>';
                    // let buttonEdit =
                    //     '<button class="btn btn-primary btn-edit" data-id="' +
                    //     data +
                    //     '" data-bs-toggle="modal" data-bs-target="#modalSPPB">Edit</button>';
                    // let buttonACC =
                    //     '<button class="btn btn-warning btn-acc" data-id="' +
                    //     data +
                    //     '">Submit</button>';
                    // let buttonHapus =
                    //     '<button class="btn btn-danger btn-hapus" data-id="' +
                    //     data +
                    //     '">Hapus</button>';
                    if (full.IsActive) {
                        return buttonTtd;
                    } else {
                        return "User tidak aktif";
                    }
                },
            },
            {
                data: "FotoTtd",
                render: function (data, type, full, meta) {
                    if (data) {
                        return `
                        <img
                            src="data:image/png;base64,${data}"
                            alt="TTD"
                            style="width:120px; height:auto;"
                        >
                    `;
                    } else {
                        return "-";
                    }
                },
            },
        ],
    });
    let mmu_gambarTTD = document.getElementById("mmu_gambarTTD");
    let imagePreview = document.getElementById("imagePreview");
    let previewImg = document.getElementById("previewImg");
    let clearImage = document.getElementById("clearImage");
    let mmu_buttonSave = document.getElementById("mmu_buttonSave");
    //#endregion
    //#region Load Form
    init();
    //#endregion
    //#region Functions
    function init() {
        previewImg.value = "";
    }
    //#endregion
    //#region Event Listener

    $(document).on("click", ".btn-ttd", function (e) {
        let IdUser = $(this).data("id");
        $("#mmu_buttonSave").data("id", IdUser);
    });

    mmu_gambarTTD.addEventListener("change", function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                previewImg.src = e.target.result;
                previewImg.style.display = "block";
                previewImg.dataset.base64 = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    mmu_gambarTTD.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            sisaSaldo.focus();
        }
    });

    clearImage.addEventListener("click", function () {
        mmu_gambarTTD.value = "";
        previewImg.src = "#";
        previewImg.style.display = "none";
    });

    mmu_buttonSave.addEventListener("click", function () {
        let IdUser = $(this).data("id");
        let formData = new FormData();
        formData.append("jenisStore", "tambahTTD");
        formData.append("gambarTTD", mmu_gambarTTD.files[0]);
        formData.append("_token", csrfToken);
        formData.append("idUser", IdUser);
        $.ajax({
            url: "/MaintenanceUserWeb",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (response) {
                if (!response) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        showConfirmButton: false,
                        timer: 1000,
                        text: "Tambah TTD failed ",
                        returnFocus: false,
                    });
                } else {
                    console.log(response);
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        showConfirmButton: false,
                        timer: 1000,
                        text: response.message,
                        returnFocus: false,
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Failed to Tambah TTD.",
                });
            },
        });
    });
    //#endregion
});
