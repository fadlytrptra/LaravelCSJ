$(document).ready(function () {
    //#region Variables
    let csrfToken = $('meta[name="csrf-token"]').attr("content");
    let button_tambahKodePerkiraan = document.getElementById("button_tambahKodePerkiraan"); // prettier-ignore
    var table_kodePerkiraan = $("#table_kodePerkiraan").DataTable({
        serverSide: true,
        responsive: true,
        processing: true,
        ajax: {
            url: "KodePerkiraan/getAllKodePerkiraan",
            type: "GET",
            beforeSend: function () {
                // Show loading screen
                $("#loading-screen").css("display", "flex");
            },
            complete: function () {
                // Hide loading screen
                $("#loading-screen").css("display", "none");
            },
            error: function () {
                // Hide loading screen and show error message
                $("#loading-screen").css("display", "none");
                Swal.fire({
                    icon: "error",
                    title: "Data Tidak Berhasil Diload!",
                });
            },
        },
        columns: [
            { data: "NoKodePerkiraan" },
            { data: "Keterangan" },
            // { data: "IdUserMaster" },
            {
                data: "NoKodePerkiraan",
                render: function (data, type, full, meta) {
                    return (
                        '<button id="editButton' +
                        data +
                        '" class="btn btn-primary btn-edit" data-id="' +
                        data +
                        '" data-bs-toggle="modal" data-bs-target="#modalKodePerkiraan" type="button">Edit</button>' +
                        '<button class="btn btn-danger btn-hapus" data-id="' +
                        data +
                        '">Hapus</button>'
                    );
                },
            },
        ],
    });
    let kp_nomorKodePerkiraan = document.getElementById("kp_nomorKodePerkiraan"); // prettier-ignore
    let kp_keterangan = document.getElementById("kp_keterangan");
    let kp_buttonProses = document.getElementById("kp_buttonProses");
    //#endregion

    //#region Functions
    $.ajaxSetup({
        beforeSend: function () {
            // Show the loading screen before the AJAX request
            $("#loading-screen").css("display", "flex");
        },
        complete: function () {
            // Hide the loading screen after the AJAX request completes
            $("#loading-screen").css("display", "none");
        },
    });

    function init(initType) {
        if (initType == "modal") {
            kp_nomorKodePerkiraan.value = "";
            kp_keterangan.value = "";
        }
    }
    //#endregion

    //#region Event Listener
    button_tambahKodePerkiraan.addEventListener("click", function (e) {
        modalLabelKodePerkiraan.innerHTML = "Tambah Kode Perkiraan";
        $("#kp_buttonProses").data("id", null);
        kp_nomorKodePerkiraan.readOnly = false;
    });

    $("#modalKodePerkiraan").on("shown.bs.modal", function (event) {
        let nomorKodePerkiraan = $("#kp_buttonProses").data("id");
        console.log(nomorKodePerkiraan);

        if (nomorKodePerkiraan) {
            $.ajax({
                url: "/KodePerkiraan/getDetailPerkiraan",
                method: "GET",
                data: {
                    _token: csrfToken,
                    no_kp: nomorKodePerkiraan,
                },
                dataType: "json",
                success: function (data) {
                    console.log(data);

                    if (!data) {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            showConfirmButton: false,
                            timer: 1000,
                            text: "fetching data Kode Perkiraan failed ",
                            returnFocus: false,
                        });
                    } else {
                        kp_nomorKodePerkiraan.value = data[0].NoKodePerkiraan;
                        kp_keterangan.value = data[0].Keterangan;
                        kp_keterangan.select();
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Failed to load Kode Perkiraan.",
                    });
                },
            });
        } else {
            kp_nomorKodePerkiraan.focus();
            init("modal");
        }
    });

    $(document).on("click", ".btn-edit", function (e) {
        let nomorKodePerkiraan = $(this).data("id");
        $("#kp_buttonProses").data("id", nomorKodePerkiraan);
        modalLabelKodePerkiraan.innerHTML = "Edit Kode Perkiraan";
        kp_nomorKodePerkiraan.readOnly = true;
    });

    $(document).on("click", ".btn-hapus", function (e) {
        let nomorKodePerkiraan = $(this).data("id");
        $.ajax({
            url: "/KodePerkiraan",
            method: "POST",
            data: {
                _token: csrfToken,
                jenisStore: "deleteKP",
                no_kp: nomorKodePerkiraan,
            },
            dataType: "json",
            success: function (response) {
                if (!response) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        showConfirmButton: false,
                        timer: 1000,
                        text: "Delete Kode Perkiraan failed ",
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
                    table_kodePerkiraan.ajax.reload(function () {
                        table_kodePerkiraan.columns.adjust().draw(false);
                    }, false);
                }
            },
            error: function () {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Failed to Delete Kode Perkiraan.",
                });
            },
        });
    });

    kp_nomorKodePerkiraan.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            kp_keterangan.select();
        }
    });

    kp_keterangan.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            kp_buttonProses.focus();
        }
    });

    kp_buttonProses.addEventListener("click", function (e) {
        let nomorKodePerkiraan = $(this).data("id");
        $.ajax({
            url: "/KodePerkiraan",
            method: "POST",
            data: {
                _token: csrfToken,
                jenisStore: nomorKodePerkiraan ? "EditKP" : "TambahKP",
                keterangan: kp_keterangan.value,
                no_kp: kp_nomorKodePerkiraan.value,
            },
            dataType: "json",
            success: function (response) {
                if (!response) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        showConfirmButton: false,
                        timer: 1000,
                        text: "Process Kode Perkiraan failed ",
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
                    table_kodePerkiraan.ajax.reload(function () {
                        table_kodePerkiraan.columns.adjust().draw(false);
                    }, false);
                    $("#modalKodePerkiraan").modal("hide");
                }
            },
            error: function () {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Failed to Process Kode Perkiraan.",
                });
            },
        });
    });
    //#endregion
});
