jQuery(function ($) {
    //#region Variables
    let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content"); // prettier-ignore
    const radios = document.querySelectorAll('input[name="radio_jenisCetak"]');
    let radio_jenisSPPB = document.getElementById("radio_jenisSPPB");
    let radio_jenisBTTB = document.getElementById("radio_jenisBTTB");
    // let radio_jenisRetur = document.getElementById("radio_jenisRetur");
    let nama_divisi = document.getElementById("nama_divisi");
    let id_divisi = document.getElementById("id_divisi");
    let button_browseDataDivisi = document.getElementById("button_browseDataDivisi"); // prettier-ignore
    let sppb = document.getElementById("sppb");
    let no_trans = document.getElementById("no_trans");
    let button_browseDataSPPB = document.getElementById("button_browseDataSPPB"); // prettier-ignore
    let div_noTerima = document.getElementById("div_noTerima");
    let no_terima = document.getElementById("no_terima");
    let button_browseDataNomorTerima = document.getElementById("button_browseDataNomorTerima"); // prettier-ignore
    let button_cetak = document.getElementById("button_cetak");
    let div_emailPO = document.getElementById("div_emailPO");
    //#endregion

    //#region Load Form
    init();
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

    function init() {
        radio_jenisSPPB.checked = true;
        radio_jenisSPPB.focus();
    }

    // fungsi swal select pake arrow
    function handleTableKeydown(e, tableId) {
        const table = $(`#${tableId}`).DataTable();
        const rows = $(`#${tableId} tbody tr`);
        const rowCount = rows.length;

        if (e.key === "Enter") {
            e.preventDefault();
            const selectedRow = table.row(".selected").data();
            if (selectedRow) {
                Swal.getConfirmButton().click();
            } else {
                const firstRow = $(`#${tableId} tbody tr:first-child`);
                if (firstRow.length) {
                    firstRow.click();
                    Swal.getConfirmButton().click();
                }
            }
        } else if (e.key === "ArrowDown") {
            e.preventDefault();
            if (currentIndex === null || currentIndex >= rowCount - 1) {
                currentIndex = 0;
            } else {
                currentIndex++;
            }
            rows.removeClass("selected");
            const selectedRow = $(rows[currentIndex]).addClass("selected");
            scrollRowIntoView(selectedRow[0]);
        } else if (e.key === "ArrowUp") {
            e.preventDefault();
            if (currentIndex === null || currentIndex <= 0) {
                currentIndex = rowCount - 1;
            } else {
                currentIndex--;
            }
            rows.removeClass("selected");
            const selectedRow = $(rows[currentIndex]).addClass("selected");
            scrollRowIntoView(selectedRow[0]);
        } else if (e.key === "ArrowRight") {
            e.preventDefault();
            const pageInfo = table.page.info();
            if (pageInfo.page < pageInfo.pages - 1) {
                table
                    .page("next")
                    .draw("page")
                    .on("draw", function () {
                        currentIndex = 0;
                        const newRows = $(`#${tableId} tbody tr`);
                        const selectedRow = $(newRows[currentIndex]).addClass(
                            "selected"
                        );
                        scrollRowIntoView(selectedRow[0]);
                    });
            }
        } else if (e.key === "ArrowLeft") {
            e.preventDefault();
            const pageInfo = table.page.info();
            if (pageInfo.page > 0) {
                table
                    .page("previous")
                    .draw("page")
                    .on("draw", function () {
                        currentIndex = 0;
                        const newRows = $(`#${tableId} tbody tr`);
                        const selectedRow = $(newRows[currentIndex]).addClass(
                            "selected"
                        );
                        scrollRowIntoView(selectedRow[0]);
                    });
            }
        }
    }

    // Helper function to scroll selected row into view
    function scrollRowIntoView(rowElement) {
        rowElement.scrollIntoView({ block: "nearest" });
    }

    function validateEmpty(input, message, focusEl) {
        if (input.value === "") {
            Swal.fire({
                icon: "error",
                title: "Error!",
                text: message,
                showConfirmButton: false,
                timer: 1500,
                returnFocus: false,
            });
            focusEl.focus();
            return false;
        }
        return true;
    }

    function openPrintWindow(jenisCetak) {
        const params = new URLSearchParams({
            divisi: id_divisi.value,
            jenisCetak: jenisCetak,
            sppb: sppb.value,
            noTerima: no_terima.value || "",
        });

        window.open(`/CetakSPPBBTTB/print?${params.toString()}`, "_blank");
    }

    function sendEmail() {
        $.ajax({
            url: "/CetakSPPBBTTB",
            type: "POST",
            data: {
                jenisStore: "Email",
                deliveryTerm: email_deliveryTerm.value,
                packing: email_packing.value,
                shippingMark: email_shippingMark.value,
                deliveryTime: email_deliveryTime.value,
                documentsRequired: email_documentsRequired.value,
                partialShipmentTransit: email_partialShipmentTransit.value,
                portOfLoading: email_portOfLoading.value,
                portOfDischarge: email_portOfDischarge.value,
                otherConditions: email_otherConditions.value,
                payments: email_payments.value,
                noSPPB: sppb.value,
                idDivisi: id_divisi.value,
                _token: csrfToken,
            },
            success: function (response) {
                if (response.success) {
                    Swal.fire("Berhasil", "Email berhasil dikirim", "success");
                } else {
                    Swal.fire("Error", response.error, "error");
                }
            },
            error: function (xhr) {
                Swal.fire("Error", "Server error", "error");
                console.error(xhr.responseText);
            },
        });
    }

    //#endregion

    //#region Event Listener
    radios.forEach((radio) => {
        radio.addEventListener("change", function () {
            if (radio_jenisEmail.checked) {
                div_noTerima.style.display = "none";
                button_browseDataNomorTerima.style.display = "none";
                div_emailPO.style.display = "block";
                button_cetak.innerHTML = "Kirim";
            } else if (radio_jenisBTTB.checked) {
                div_noTerima.style.display = "flex";
                button_browseDataNomorTerima.style.display = "block";
                div_emailPO.style.display = "none";
                button_cetak.innerHTML = "Cetak";
            } else {
                div_noTerima.style.display = "none";
                button_browseDataNomorTerima.style.display = "none";
                div_emailPO.style.display = "none";
                button_cetak.innerHTML = "Cetak";
            }
        });
    });

    button_browseDataDivisi.addEventListener("click", function (e) {
        try {
            Swal.fire({
                title: "Pilih Divisi",
                html: `
                <table id="table_list" class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID Divisi</th>
                            <th scope="col">Nama Divisi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            `,
                preConfirm: () => {
                    const selectedData = $("#table_list")
                        .DataTable()
                        .row(".selected")
                        .data();
                    if (!selectedData) {
                        Swal.showValidationMessage("Please select a row");
                        return false;
                    }
                    return selectedData;
                },
                width: "40%",
                returnFocus: false,
                showCloseButton: true,
                showConfirmButton: true,
                confirmButtonText: "Select",
                didOpen: () => {
                    $(document).ready(function () {
                        const table = $("#table_list").DataTable({
                            responsive: true,
                            processing: true,
                            serverSide: true,
                            paging: false,
                            scrollY: "400px",
                            scrollCollapse: true,
                            order: [1, "asc"],
                            ajax: {
                                url: "CetakSPPBBTTB/getDataDivisi",
                                dataType: "json",
                                type: "GET",
                                data: {
                                    _token: csrfToken,
                                },
                            },
                            columns: [{ data: "KD_DIV" }, { data: "NM_DIV" }],
                            columnDefs: [
                                {
                                    targets: 0,
                                    width: "30%",
                                },
                            ],
                        });

                        $("#table_list tbody").on("click", "tr", function () {
                            table.$("tr.selected").removeClass("selected");
                            $(this).addClass("selected");
                            scrollRowIntoView(this);
                        });

                        const searchInput = $("#table_list_filter input");
                        if (searchInput.length > 0) {
                            searchInput.focus();
                        }

                        currentIndex = null;
                        Swal.getPopup().addEventListener("keydown", (e) =>
                            handleTableKeydown(e, "table_list")
                        );
                    });
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    nama_divisi.value = result.value.NM_DIV.trim();
                    id_divisi.value = result.value.KD_DIV.trim();
                    button_browseDataSPPB.focus();
                }
            });
        } catch (error) {
            console.error(error);
        }
    });

    button_browseDataSPPB.addEventListener("click", function (e) {
        try {
            Swal.fire({
                title: "Pilih SPPB",
                html: `
                <table id="table_list" class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID Divisi</th>
                            <th scope="col">Nama Divisi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            `,
                preConfirm: () => {
                    const selectedData = $("#table_list")
                        .DataTable()
                        .row(".selected")
                        .data();
                    if (!selectedData) {
                        Swal.showValidationMessage("Please select a row");
                        return false;
                    }
                    return selectedData;
                },
                width: "40%",
                returnFocus: false,
                showCloseButton: true,
                showConfirmButton: true,
                confirmButtonText: "Select",
                didOpen: () => {
                    $(document).ready(function () {
                        const table = $("#table_list").DataTable({
                            responsive: true,
                            processing: true,
                            serverSide: true,
                            paging: false,
                            scrollY: "400px",
                            scrollCollapse: true,
                            order: [1, "asc"],
                            ajax: {
                                url: "CetakSPPBBTTB/getDataSPPB",
                                dataType: "json",
                                type: "GET",
                                data: {
                                    kd_div_1: id_divisi.value,
                                    _token: csrfToken,
                                },
                            },
                            columns: [
                                { data: "No_sppb" },
                                { data: "No_trans" },
                            ],
                            columnDefs: [
                                {
                                    targets: 0,
                                    width: "50%",
                                },
                            ],
                        });

                        $("#table_list tbody").on("click", "tr", function () {
                            table.$("tr.selected").removeClass("selected");
                            $(this).addClass("selected");
                            scrollRowIntoView(this);
                        });

                        const searchInput = $("#table_list_filter input");
                        if (searchInput.length > 0) {
                            searchInput.focus();
                        }

                        currentIndex = null;
                        Swal.getPopup().addEventListener("keydown", (e) =>
                            handleTableKeydown(e, "table_list")
                        );
                    });
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    let checkedRadio = document.querySelector('input[name="radio_jenisCetak"]:checked'); // prettier-ignore
                    sppb.value = result.value.No_sppb;
                    no_trans.value = result.value.No_trans;
                    if (
                        checkedRadio.value == "SPPB" ||
                        checkedRadio.value == "SPPBBaru"
                    ) {
                        button_cetak.focus();
                    } else if (checkedRadio.value == "BTTB") {
                        button_browseDataNomorTerima.focus();
                    } else if (checkedRadio.value == "Email") {
                        email_deliveryTerm.focus();
                    }
                }
            });
        } catch (error) {
            console.error(error);
        }
    });

    button_browseDataNomorTerima.addEventListener("click", function (e) {
         if (!sppb.value) {
            Swal.fire({
                icon: 'warning',
                title: 'SPPB belum dipilih',
                text: 'Silakan pilih SPPB terlebih dahulu.',
            });
            button_browseDataSPPB.focus();
            return;
        }

        if (!id_divisi.value) {
            Swal.fire({
                icon: 'warning',
                title: 'Divisi belum dipilih',
                text: 'Silakan pilih Divisi terlebih dahulu.',
            });
            button_browseDataDivisi.focus();
            return;
        }

        try {
            Swal.fire({
                title: "No. Terima",
                html: `
                <table id="table_list" class="table">
                    <thead>
                        <tr>
                            <th scope="col">No. Terima</th>
                            <th scope="col">Datang</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            `,
                preConfirm: () => {
                    const selectedData = $("#table_list")
                        .DataTable()
                        .row(".selected")
                        .data();
                    if (!selectedData) {
                        Swal.showValidationMessage("Please select a row");
                        return false;
                    }
                    return selectedData;
                },
                width: "40%",
                returnFocus: false,
                showCloseButton: true,
                showConfirmButton: true,
                confirmButtonText: "Select",
                didOpen: () => {
                    $(document).ready(function () {
                        const table = $("#table_list").DataTable({
                            responsive: true,
                            processing: true,
                            serverSide: true,
                            paging: false,
                            scrollY: "400px",
                            scrollCollapse: true,
                            order: [1, "asc"],
                            ajax: {
                                url: "CetakSPPBBTTB/getDataTerima",
                                dataType: "json",
                                type: "GET",
                                data: {
                                    NoSPPB: sppb.value,
                                    KdDivisi: id_divisi.value,
                                    _token: csrfToken,
                                },
                            },
                            columns: [
                                { data: "nomor_terima" },
                                {
                                    data: "tanggal_datang",
                                    render: function (data, type, row) {
                                        return moment(data).format(
                                            "MM/DD/YYYY"
                                        );
                                    },
                                },
                            ],
                            columnDefs: [
                                {
                                    targets: 0,
                                    width: "30%",
                                },
                            ],
                        });

                        $("#table_list tbody").on("click", "tr", function () {
                            table.$("tr.selected").removeClass("selected");
                            $(this).addClass("selected");
                            scrollRowIntoView(this);
                        });

                        const searchInput = $("#table_list_filter input");
                        if (searchInput.length > 0) {
                            searchInput.focus();
                        }

                        currentIndex = null;
                        Swal.getPopup().addEventListener("keydown", (e) =>
                            handleTableKeydown(e, "table_list")
                        );
                    });
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log(result.value);
                    no_terima.value = result.value.nomor_terima;
                    tgl_datang.value = moment(result.value.tanggal_datang).format(
                        "YYYY-MM-DD"
                    );
                    button_cetak.focus();
                }
            });
        } catch (error) {
            console.error(error);
        }
    });

    button_cetak.addEventListener("click", function (e) {
        e.preventDefault();

        const jenisCetak = document.querySelector(
            'input[name="radio_jenisCetak"]:checked'
        ).value;

        // COMMON VALIDATION
        if (!validateEmpty(id_divisi, "Pilih Divisi!", button_browseDataDivisi))
            return;

        if (!validateEmpty(sppb, "Pilih SPPB!", button_browseDataSPPB)) return;

        // EMAIL MODE
        if (jenisCetak === "Email") {
            sendEmail();
            return;
        }

        // BTTB VALIDATION
        if (
            jenisCetak === "BTTB" &&
            !validateEmpty(
                no_terima,
                "Pilih Nomor Terima!",
                button_browseDataNomorTerima
            )
        ) {
            return;
        }

        // PRINT ACTION
        openPrintWindow(jenisCetak);
    });

    //#endregion
});
