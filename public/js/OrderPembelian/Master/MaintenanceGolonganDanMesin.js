jQuery(function ($) {
    //#region Variables
    let csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
    let divisi = document.getElementById("divisi");
    let namaDivisi = document.getElementById("namaDivisi");
    let btnDivisi = document.getElementById("btnDivisi");
    let golongan = document.getElementById("golongan");
    let namaGolongan = document.getElementById("namaGolongan");
    let btnGolongan = document.getElementById("btnGolongan");
    let mesin = document.getElementById("mesin");
    let namaMesin = document.getElementById("namaMesin");
    let btnMesin = document.getElementById("btnMesin");
    let btnIsi = document.getElementById("btnIsi");
    let btnKoreksi = document.getElementById("btnKoreksi");
    let btnHapus = document.getElementById("btnHapus");
    let btnProses = document.getElementById("btnProses");
    let btnBatal = document.getElementById("btnBatal");
    var nomorButton = 0;
    //#endregion

    //#region function
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
                            "selected",
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
                            "selected",
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

    function decodeHtmlEntities(str) {
        let textarea = document.createElement("textarea");
        textarea.innerHTML = str;
        return textarea.value;
    }

    function enableInputs() {
        btnDivisi.disabled = false;
        btnGolongan.disabled = false;
        btnMesin.disabled = false;

        namaGolongan.removeAttribute("readonly");
        namaMesin.removeAttribute("readonly");

        btnIsi.disabled = true;
        btnKoreksi.disabled = true;
        btnHapus.disabled = true;
        btnProses.disabled = false;
        btnBatal.disabled = false;
    }

    function disableInputs() {
        btnDivisi.disabled = true;
        btnGolongan.disabled = true;
        btnMesin.disabled = true;

        namaDivisi.setAttribute("readonly", true);
        namaGolongan.setAttribute("readonly", true);
        namaMesin.setAttribute("readonly", true);

        btnIsi.disabled = false;
        btnKoreksi.disabled = false;
        btnHapus.disabled = false;
        btnProses.disabled = true;
        btnBatal.disabled = true;
    }

    function clearInput() {
        divisi.value = "";
        namaDivisi.value = "";
        golongan.value = "";
        namaGolongan.value = "";
        mesin.value = "";
        namaMesin.value = "";
    }

    function proses(jenisProses) {
        return $.ajax({
            type: "POST",
            url: "MaintenanceGolonganDanMesin",
            data: {
                _token: csrfToken,
                jenisProses: jenisProses,
                idDivisi: divisi.value,
                noGolongan: golongan.value,
                namaGolongan: namaGolongan.value,
                noMesin: mesin.value,
                namaMesin: namaMesin.value,
            },
            success: function (result) {
                if (result.success) {
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil!",
                        text: result.success,
                    });
                } else if (result.error) {
                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        text: result.error,
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
            },
        });
    }
    //#endregion

    //#region Event Listener
    btnDivisi.addEventListener("click", function (e) {
        try {
            Swal.fire({
                title: "Pilih Divisi",
                html: `<table id="table_divisi" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Id Divisi</th>
                                <th>Nama Divisi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>`,
                width: "40%",
                showCancelButton: true,
                confirmButtonText: "Pilih",
                cancelButtonText: "Close",
                returnFocus: false,
                preConfirm: () => {
                    const table = $("#table_divisi").DataTable();
                    const selectedData = table.row(".selected").data();
                    if (!selectedData) {
                        Swal.showValidationMessage("Please select a row");
                        return false;
                    }
                    return selectedData;
                },
                didOpen: () => {
                    $(document).ready(function () {
                        const table = $("#table_divisi").DataTable({
                            responsive: true,
                            processing: true,
                            serverSide: true,
                            paging: false,
                            scrollY: "400px",
                            scrollCollapse: true,
                            order: [[1, "asc"]],
                            ajax: {
                                url: "MaintenanceGolonganDanMesin/getUserDivisi",
                                dataType: "json",
                                type: "GET",
                                error: function (xhr, error, thrown) {
                                    console.error(
                                        "Error fetching data: ",
                                        thrown,
                                    );
                                },
                                data: {
                                    _token: csrfToken,
                                },
                            },
                            columns: [
                                {
                                    data: "IdDivisi",
                                },
                                {
                                    data: "NamaDivisi",
                                },
                            ],
                            columnDefs: [
                                {
                                    targets: 0,
                                    width: "100px",
                                },
                            ],
                        });

                        // Use the correct ID selector for the table body
                        $("#table_divisi tbody").on("click", "tr", function () {
                            table.$("tr.selected").removeClass("selected");
                            $(this).addClass("selected");
                            scrollRowIntoView(this);
                        });

                        const searchInput = $("#table_divisi_filter input");
                        if (searchInput.length > 0) {
                            searchInput.focus();
                        }

                        currentIndex = null;
                        Swal.getPopup().addEventListener("keydown", (e) =>
                            handleTableKeydown(e, "table_divisi"),
                        );
                    });
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    const selectedRow = result.value;
                    namaDivisi.value = selectedRow.NamaDivisi
                        ? decodeHtmlEntities(selectedRow.NamaDivisi.trim())
                        : "";
                    divisi.value = selectedRow.IdDivisi
                        ? decodeHtmlEntities(selectedRow.IdDivisi.trim())
                        : "";
                    btnGolongan.focus();
                }
            });
        } catch (error) {
            console.error("An error occurred:", error);
        }
    });

    btnGolongan.addEventListener("click", function (e) {
        try {
            Swal.fire({
                title: "Pilih Kelompok Utama",
                html: `<table id="table_golongan" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Id Golongan</th>
                                <th>Nama Golongan</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>`,
                width: "40%",
                showCancelButton: true,
                confirmButtonText: "Pilih",
                cancelButtonText: "Close",
                returnFocus: false,
                preConfirm: () => {
                    const table = $("#table_golongan").DataTable();
                    const selectedData = table.row(".selected").data();
                    if (!selectedData) {
                        Swal.showValidationMessage("Please select a row");
                        return false;
                    }
                    return selectedData;
                },
                didOpen: () => {
                    $(document).ready(function () {
                        const table = $("#table_golongan").DataTable({
                            responsive: true,
                            processing: true,
                            serverSide: true,
                            paging: false,
                            scrollY: "400px",
                            scrollCollapse: true,
                            order: [[1, "asc"]],
                            ajax: {
                                url: "MaintenanceGolonganDanMesin/getGolongan",
                                dataType: "json",
                                type: "GET",
                                error: function (xhr, error, thrown) {
                                    console.error(
                                        "Error fetching data: ",
                                        thrown,
                                    );
                                },
                                data: {
                                    _token: csrfToken,
                                    idDivisi: divisi.value,
                                },
                            },
                            columns: [
                                {
                                    data: "IdGolongan",
                                },
                                {
                                    data: "NamaGolongan",
                                },
                            ],
                            columnDefs: [
                                {
                                    targets: 0,
                                    width: "100px",
                                },
                            ],
                        });

                        // Use the correct ID selector for the table body
                        $("#table_golongan tbody").on(
                            "click",
                            "tr",
                            function () {
                                table.$("tr.selected").removeClass("selected");
                                $(this).addClass("selected");
                                scrollRowIntoView(this);
                            },
                        );

                        const searchInput = $("#table_golongan_filter input");
                        if (searchInput.length > 0) {
                            searchInput.focus();
                        }

                        currentIndex = null;
                        Swal.getPopup().addEventListener("keydown", (e) =>
                            handleTableKeydown(e, "table_golongan"),
                        );
                    });
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    const selectedRow = result.value;
                    namaGolongan.value = selectedRow.NamaGolongan
                        ? decodeHtmlEntities(selectedRow.NamaGolongan.trim())
                        : "";
                    golongan.value = selectedRow.IdGolongan
                        ? decodeHtmlEntities(selectedRow.IdGolongan.trim())
                        : "";
                    btnMesin.focus();
                }
            });
        } catch (error) {
            console.error("An error occurred:", error);
        }
    });

    btnMesin.addEventListener("click", function (e) {
        try {
            Swal.fire({
                title: "Pilih Kelompok",
                html: `<table id="table_mesin" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Id Mesin</th>
                                <th>Nama Mesin</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>`,
                width: "40%",
                showCancelButton: true,
                confirmButtonText: "Pilih",
                cancelButtonText: "Close",
                returnFocus: false,
                preConfirm: () => {
                    const table = $("#table_mesin").DataTable();
                    const selectedData = table.row(".selected").data();
                    if (!selectedData) {
                        Swal.showValidationMessage("Please select a row");
                        return false;
                    }
                    return selectedData;
                },
                didOpen: () => {
                    $(document).ready(function () {
                        const table = $("#table_mesin").DataTable({
                            responsive: true,
                            processing: true,
                            serverSide: true,
                            paging: false,
                            scrollY: "400px",
                            scrollCollapse: true,
                            order: [[1, "asc"]],
                            ajax: {
                                url: "MaintenanceGolonganDanMesin/getMesin",
                                dataType: "json",
                                type: "GET",
                                error: function (xhr, error, thrown) {
                                    console.error(
                                        "Error fetching data: ",
                                        thrown,
                                    );
                                },
                                data: {
                                    _token: csrfToken,
                                    idGolongan: golongan.value,
                                },
                            },
                            columns: [
                                {
                                    data: "IdMesin",
                                },
                                {
                                    data: "NamaMesin",
                                },
                            ],
                            columnDefs: [
                                {
                                    targets: 0,
                                    width: "100px",
                                },
                            ],
                        });

                        // Use the correct ID selector for the table body
                        $("#table_mesin tbody").on("click", "tr", function () {
                            table.$("tr.selected").removeClass("selected");
                            $(this).addClass("selected");
                            scrollRowIntoView(this);
                        });

                        const searchInput = $("#table_mesin_filter input");
                        if (searchInput.length > 0) {
                            searchInput.focus();
                        }

                        currentIndex = null;
                        Swal.getPopup().addEventListener("keydown", (e) =>
                            handleTableKeydown(e, "table_mesin"),
                        );
                    });
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    const selectedRow = result.value;
                    namaMesin.value = selectedRow.NamaMesin
                        ? decodeHtmlEntities(selectedRow.NamaMesin.trim())
                        : "";
                    mesin.value = selectedRow.IdMesin
                        ? decodeHtmlEntities(selectedRow.IdMesin.trim())
                        : "";
                    btnProses.focus();
                }
            });
        } catch (error) {
            console.error("An error occurred:", error);
        }
    });

    btnIsi.addEventListener("click", async () => {
        nomorButton = 1;
        enableInputs();
        btnDivisi.focus();
    });

    btnKoreksi.addEventListener("click", async () => {
        nomorButton = 2;
        enableInputs();
        btnDivisi.focus();
    });

    btnHapus.addEventListener("click", async () => {
        // nomorButton = 3;
        // enableInputs();
        // btnDivisi.focus();
        Swal.fire({
            icon: "error",
            title: "Tidak boleh delete",
            text: "Proses delete hanya melalui EDP",
        });
    });

    btnBatal.addEventListener("click", async () => {
        nomorButton = 0;
        disableInputs();
        clearInput();
        btnIsi.focus();
    });

    btnProses.addEventListener("click", async () => {
        btnProses.disabled = true;
        setTimeout(() => {
            btnProses.disabled = false;
        }, 5000);
        if (!divisi.value) {
            Swal.fire({
                icon: "error",
                title: "Divisi Kosong!",
                text: "Data Tidak Dapat Di Proses!!...",
            });
            return;
        }

        //proses ISI
        if (nomorButton == 1) {
            if (!namaMesin.value) {
                Swal.fire({
                    icon: "error",
                    title: "Mesin Kosong!",
                    text: "Data Tidak Dapat Di Proses!!...",
                });
                return;
            }
            if (!namaGolongan.value) {
                Swal.fire({
                    icon: "error",
                    title: "Golongan Kosong!",
                    text: "Data Tidak Dapat Di Proses!!...",
                });
                return;
            }
            if (golongan.value) {
                proses("insertMesin");
                disableInputs();
                clearInput();
            } else {
                proses("insertGolongan").then(() => {
                    proses("insertMesin");
                    disableInputs();
                    clearInput();
                });
            }
        }

        //proses KOREKSI
        else if (nomorButton == 2) {
            if (!namaMesin.value && mesin.value) {
                Swal.fire({
                    icon: "error",
                    title: "Mesin Kosong!",
                    text: "Data Tidak Dapat Di Proses!!...",
                });
                return;
            }
            if (!namaGolongan.value && golongan.value) {
                Swal.fire({
                    icon: "error",
                    title: "Golongan Kosong!",
                    text: "Data Tidak Dapat Di Proses!!...",
                });
                return;
            }
            proses("koreksiGolongan").then(() => {
                proses("koreksiMesin");
                disableInputs();
                clearInput();
            });
            //edit golongan saja
            //edit mesin dan golongan
        }

        //proses HAPUS
        else if (nomorButton === 3) {
        }
    });
    //#endregion
});
