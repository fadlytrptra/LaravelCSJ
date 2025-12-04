jQuery(function ($) {
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content"); // prettier-ignore
    let tanggal_bonKas = document.getElementById("tanggal_bonKas");
    let no_sjButton = document.getElementById("no_sjButton");
    let no_sj = document.getElementById("no_sj");
    let no_sp = document.getElementById("no_sp");
    let print_button = document.getElementById("print_button");
    let print_view = document.getElementById("print_view");
    let contoh_print = document.getElementById("contoh_print");
    let contoh_printDiv = document.getElementById("contoh_printDiv");

    //#region Functions

    // Function to handle keydown events for table navigation
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

    // fungsi unk menampilkan '&'
    function decodeHtmlEntities(str) {
        var textArea = document.createElement("textarea");
        textArea.innerHTML = str;
        return textArea.value;
    }

    //#endregion

    //#region Form Load

    tanggal_bonKas.valueAsDate = new Date();
    tanggal_bonKas.focus();

    //#endregion

    //#region  event listeners

    tanggal_bonKas.addEventListener("keypress", function (e) {
        e.preventDefault();
        if (e.key == "Enter") {
            no_sjButton.focus();
        }
    });

    no_sjButton.addEventListener("click", function (e) {
        try {
            Swal.fire({
                title: "Nomor Surat Jalan",
                html: `
                <table id="table_list" class="table">
                    <thead>
                        <tr>
                            <th scope="col">Jenis SJ</th>
                            <th scope="col">Nomor SJ</th>
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
                                url: "CetakBonKas/getNomorSJ",
                                dataType: "json",
                                type: "GET",
                                data: {
                                    _token: csrfToken,
                                    tglKirim: tanggal_bonKas.value,
                                },
                            },
                            columns: [
                                { data: "NamaJnsSuratJalan" },
                                { data: "SuratJalan" },
                            ],
                            columnDefs: [
                                {
                                    targets: 0,
                                    width: "100px",
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
                    no_sj.value = result.value.SuratJalan;
                    print_view.focus();
                }
            });
        } catch (error) {
            console.error(error);
        }
    });

    print_view.addEventListener("click", function (e) {
        e.preventDefault();
        if (no_sj.value === "") {
            Swal.fire({
                icon: "warning",
                title: "Warning",
                text: "Nomor Surat Jalan tidak boleh kosong!",
                returnFocus: false,
            }).then(() => {
                no_sjButton.focus();
            });
            return;
        }

        $.ajax({
            url: "CetakBonKas/getDataBonKas",
            type: "GET",
            data: {
                _token: csrfToken,
                nomorsj: no_sj.value,
            },
            dataType: "json",
            success: function (response) {
                console.log(response);
                if (response.success) {
                    print_id_pengiriman.innerHTML = response.dataBonKas[0].IDPengiriman; // prettier-ignore
                    print_nama_customer.innerHTML = response.dataBonKas[0].NamaCust; // prettier-ignore
                    print_tgl_kirim.innerHTML = moment(response.dataBonKas[0].TglKirim).format("DD/MM/YYYY"); // prettier-ignore
                    print_kota.innerHTML = response.dataBonKas[0].Kota;
                    print_truk_nopol.innerHTML = response.dataBonKas[0].TrukNopol; // prettier-ignore
                    print_nama_typeBarang.innerHTML = response.dataBonKas[0].NAMATYPEBARANG; // prettier-ignore
                    print_nama_type.innerHTML = response.dataBonKas[0].NamaType;
                    print_qty_primer.innerHTML = numeral(response.dataBonKas[0].QtyPrimer).format('0,0.00') + ' ' + response.dataBonKas[0].satPrimer?.trim() || ''; // prettier-ignore
                    print_no_po.innerHTML = response.dataBonKas[0].NO_PO;
                    print_qty_sekunder.innerHTML = numeral(response.dataBonKas[0].QtySekunder).format('0,0.00') + ' ' + response.dataBonKas[0].satSekunder?.trim() || ''; // prettier-ignore
                    print_qty_tritier.innerHTML = numeral(response.dataBonKas[0].QtyTritier).format('0,0.00') + ' ' + response.dataBonKas[0].SatTRitier?.trim() || ''; // prettier-ignore
                    print_button.focus();
                }
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Terjadi kesalahan saat mengambil data Bon Kas.",
                });
            },
        });

        contoh_print.style.display = "block";
        contoh_printDiv.style.display = "block";
        print_button.style.display = "inline-block";
    });

    print_button.addEventListener("click", function (e) {
        e.preventDefault();
        window.print();
    });

    //#endregion
});
