jQuery(function ($) {
    //#region Variable
    let tgl_awal = document.getElementById("tgl_awal");
    let tgl_akhir = document.getElementById("tgl_akhir");
    let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content"); // prettier-ignore
    let select_divisi = $("#select_divisi");
    let button_redisplay = document.getElementById("button_redisplay");
    let radio_warehouseTropodo = document.getElementById('radio_warehouseTropodo'); //prettier-ignore
    let radio_warehouseTambakSawah = document.getElementById('radio_warehouseTambakSawah'); //prettier-ignore
    let radio_warehouseKletek = document.getElementById('radio_warehouseKletek'); //prettier-ignore
    let radio_warehouseMojosari = document.getElementById('radio_warehouseMojosari'); //prettier-ignore
    let terima_divisi = document.getElementById("terima_divisi");
    let terima_objek = document.getElementById("terima_objek");
    let terima_kelompok = document.getElementById("terima_kelompok");
    let terima_kodeBarang = document.getElementById("terima_kodeBarang");
    let terima_PIB = document.getElementById("terima_PIB");
    let terima_kelompokUtama = document.getElementById("terima_kelompokUtama");
    let terima_subKelompok = document.getElementById("terima_subKelompok");
    let terima_idSubKelompok = document.getElementById("terima_idSubKelompok");
    let terima_idType = document.getElementById("terima_idType");
    let terima_namaType = document.getElementById("terima_namaType");
    let terima_qtyPesan = document.getElementById("terima_qtyPesan");
    let terima_satQtyPesan = document.getElementById("terima_satQtyPesan");
    let terima_qtyTerima = document.getElementById("terima_qtyTerima");
    let terima_satQtyTerima = document.getElementById("terima_satQtyTerima");
    let terima_saldoAkhirPrimer = document.getElementById("terima_saldoAkhirPrimer"); // prettier-ignore
    let terima_satSaldoAkhirPrimer = document.getElementById("terima_satSaldoAkhirPrimer"); // prettier-ignore
    let terima_saldoAkhirSekunder = document.getElementById("terima_saldoAkhirSekunder"); // prettier-ignore
    let terima_satSaldoAkhirSekunder = document.getElementById("terima_satSaldoAkhirSekunder"); // prettier-ignore
    let terima_saldoAkhirTritier = document.getElementById("terima_saldoAkhirTritier"); // prettier-ignore
    let terima_satSaldoAkhirTritier = document.getElementById("terima_satSaldoAkhirTritier"); // prettier-ignore
    let terima_jumlahTerimaPrimer = document.getElementById("terima_jumlahTerimaPrimer"); // prettier-ignore
    let terima_satJumlahTerimaPrimer = document.getElementById("terima_satJumlahTerimaPrimer"); // prettier-ignore
    let terima_jumlahTerimaSekunder = document.getElementById("terima_jumlahTerimaSekunder"); // prettier-ignore
    let terima_satJumlahTerimaSekunder = document.getElementById("terima_satJumlahTerimaSekunder"); // prettier-ignore
    let terima_jumlahTerimaTritier = document.getElementById("terima_jumlahTerimaTritier"); // prettier-ignore
    let terima_satJumlahTerimaTritier = document.getElementById("terima_satJumlahTerimaTritier"); // prettier-ignore
    let terima_noSatPrimer = document.getElementById("terima_noSatPrimer");
    let terima_noSatSekunder = document.getElementById("terima_noSatSekunder");
    let terima_noSatTritier = document.getElementById("terima_noSatTritier");
    let button_transfer = document.getElementById("button_transfer"); // prettier-ignore
    let table_trasferBarang = $("#table_trasferBarang").DataTable({
        info: false,
        searching: false,
        paging: false,
        ordering: false,
    });
    //#endregion

    //#region Load Form
    init();
    getDivisi();
    //#endregion

    //#region Function
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

    function getDivisi() {
        $.ajax({
            url: "/TransferBarang/getDivisi",
            type: "GET",
            data: {
                _token: csrfToken,
            },
            success: function (data) {
                if (data.error || data.length == 0) {
                    errorHandling("ajaxGetDataResponse", data.error);
                } else {
                    select_divisi.empty();
                    data.forEach(function (item) {
                        select_divisi.append(
                            new Option(item.NM_DIV.trim(), item.KD_DIV) // prettier-ignore
                        );
                    });
                    select_divisi.val(null).trigger("change");
                }
            },
            error: function (xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.error(err.Message);
            },
        });
    }

    function getRadioValue(radioName) {
        // Selects the input with the given name that is currently checked
        const selector = `input[name="${radioName}"]:checked`;
        const checkedElement = document.querySelector(selector);

        // Return the value if an element is found, otherwise return null or an empty string
        return checkedElement ? checkedElement.value : null;
    }

    function init() {
        tgl_awal.valueAsDate = new Date();
        tgl_akhir.valueAsDate = new Date();

        select_divisi.select2({
            dropdownParent: $("#select2DropdownParent"),
            allowClear: true,
            placeholder: "Pilih Divisi",
        });

        $("#select_divisi").each(function () {
            $(this).next(".select2-container").css({
                flex: "1 1 auto",
                width: "100%",
            });
        });
        select_divisi.val(null).trigger("change");
        radio_warehouseTropodo.checked = true;
        tgl_awal.focus();
    }

    function errorHandling(jenisError, data) {
        if (jenisError == "invalidInput") {
            Swal.fire({
                icon: "error",
                title: "Terjadi Kesalahan!",
                text: data,
                showConfirmButton: false,
                timer: 1500,
            });
        } else if (jenisError == "ajaxGetDataResponse") {
            Swal.fire({
                icon: "error",
                title: "Error!",
                text: data,
                showConfirmButton: false,
                timer: 1500,
            });
        }
    }

    function loadBTTB() {
        $.ajax({
            url: "/TransferBarang/getDataBTTB",
            type: "GET",
            data: {
                idDivisi: select_divisi.val(),
                tglAkhir: tgl_akhir.value,
                tglAwal: tgl_awal.value,
                _token: csrfToken,
            },
            success: function (data) {
                if (data.error || data.length == 0) {
                    errorHandling(
                        "ajaxGetDataResponse",
                        data.error ?? "Tidak ada data BTTB"
                    );
                } else {
                    table_trasferBarang.clear();

                    // Insert ListBarang
                    data.forEach(function (item) {
                        table_trasferBarang.row.add([
                            moment(item.Datang).format("MM/DD/YYYY"),
                            item.kategori.trim(),
                            item.sub_kategori.trim(),
                            item.Kd_brg,
                            item.NAMA_BRG,
                            numeral(item.Qty).format("0,0"),
                            item.Nama_satuan.trim(),
                            item.Kd_div,
                            item.No_terima,
                            numeral(item.Hrg_trm).format("0,0.00"),
                            item.NoSatuan,
                            numeral(item.Qty_Terima).format("0,0"),
                            item.Satuan_Terima,
                            item.IdMataUang,
                            numeral(item.Kurs_Rp).format("0,0.00"),
                            item.nmSatTerima.trim(),
                            item.No_PIB_External,
                            item.No_sppb,
                        ]);
                    });
                    clearTerima();
                    // Redraw
                    table_trasferBarang.draw();
                }
            },
            error: function (xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.error(err.Message);
            },
        });
    }

    function clearTerima() {
        terima_divisi.value = "";
        terima_objek.value = "";
        terima_kelompok.value = "";
        terima_kodeBarang.value = "";
        terima_PIB.value = "";
        terima_kelompokUtama.value = "";
        terima_subKelompok.value = "";
        terima_idSubKelompok.value = "";
        terima_idType.value = "";
        terima_namaType.value = "";
        terima_qtyPesan.value = "";
        terima_satQtyPesan.value = "";
        terima_qtyTerima.value = "";
        terima_satQtyTerima.value = "";
        terima_saldoAkhirPrimer.value = "";
        terima_satSaldoAkhirPrimer.value = "";
        terima_saldoAkhirSekunder.value = "";
        terima_satSaldoAkhirSekunder.value = "";
        terima_saldoAkhirTritier.value = "";
        terima_satSaldoAkhirTritier.value = "";
        terima_satJumlahTerimaPrimer.value = "";
        terima_satJumlahTerimaSekunder.value = "";
        terima_satJumlahTerimaTritier.value = "";
        terima_noSatPrimer.value = "";
        terima_noSatSekunder.value = "";
        terima_noSatTritier.value = "";
        terima_jumlahTerimaPrimer.readOnly = false;
        terima_jumlahTerimaSekunder.readOnly = false;
    }

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
    //#endregion

    //#region Event Listener
    tgl_awal.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            tgl_akhir.focus();
        }
    });

    tgl_akhir.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            select_divisi.select2("open");
        }
    });

    select_divisi.on("select2:select", function () {
        button_redisplay.focus();
    });

    button_redisplay.addEventListener("click", function (e) {
        if (tgl_awal.value > tgl_akhir.value) {
            errorHandling("invalidInput", "Silahkan cek Tanggal Terima Barang");
            return;
        }

        if (select_divisi.val() == null) {
            errorHandling("invalidInput", "Divisi belum dipilih");
            return;
        }
        loadBTTB();
    });

    $("input[name='radio_warehouse']").on("change", function () {
        clearTerima();
        $("#table_trasferBarang tbody tr").removeClass("selected");
    });

    $("#table_trasferBarang tbody").on("click", "tr", function () {
        let rowData = table_trasferBarang.row(this).data();

        if (!rowData) {
            return;
        }

        // remove highlight from other rows
        $("#table_trasferBarang tbody tr").removeClass("selected");
        // add highlight to clicked row
        $(this).addClass("selected");

        let id_divisi = getRadioValue("radio_warehouse");
        console.log(rowData);
        clearTerima();
        // Cek id type
        $.ajax({
            url: "/TransferBarang/cekIdType",
            type: "GET",
            data: {
                idDivisi: id_divisi,
                kodeBarang: rowData[3],
                _token: csrfToken,
            },
            success: function (data) {
                console.log(data);
                if (data.error || data.length == 0) {
                    errorHandling(
                        "ajaxGetDataResponse",
                        data.error ??
                            "Kode barang " +
                                rowData[3] +
                                " belum ada di divisi " +
                                id_divisi
                    );
                } else {
                    if (data.length == 1) {
                        terima_divisi.value = data[0].NamaDivisi;
                        terima_objek.value = data[0].NamaObjek;
                        terima_kelompok.value = data[0].NamaKelompok;
                        terima_kodeBarang.value = data[0].KodeBarang;
                        terima_PIB.value = rowData[16];
                        terima_kelompokUtama.value = data[0].NamaKelompokUtama;
                        terima_subKelompok.value = data[0].NamaSubKelompok;
                        terima_idSubKelompok.value = data[0].IdSubkelompok;
                        terima_idType.value = data[0].IdType;
                        terima_namaType.value = data[0].NamaType;
                        terima_qtyPesan.value = rowData[5];
                        terima_satQtyPesan.value = rowData[6];
                        terima_qtyTerima.value = rowData[11];
                        terima_satQtyTerima.value = rowData[6];
                        terima_saldoAkhirPrimer.value = numeral(data[0].SaldoPrimer).format("0,0"); // prettier-ignore
                        terima_satSaldoAkhirPrimer.value =
                            data[0].Primer.trim();
                        terima_saldoAkhirSekunder.value = numeral(data[0].SaldoSekunder).format("0,0"); // prettier-ignore
                        terima_satSaldoAkhirSekunder.value = data[0].Sekunder.trim(); // prettier-ignore
                        terima_saldoAkhirTritier.value = numeral(data[0].SaldoTritier).format("0,0"); // prettier-ignore
                        terima_satSaldoAkhirTritier.value =
                            data[0].Tritier.trim();
                        terima_satJumlahTerimaPrimer.value =
                            data[0].Primer.trim();
                        terima_satJumlahTerimaSekunder.value = data[0].Sekunder.trim(); // prettier-ignore
                        terima_satJumlahTerimaTritier.value = data[0].Tritier.trim(); // prettier-ignore
                        terima_noSatPrimer.value = data[0].UnitPrimer;
                        terima_noSatSekunder.value = data[0].UnitSekunder;
                        terima_noSatTritier.value = data[0].UnitTritier;
                        if (
                            terima_satJumlahTerimaPrimer.value.toLowerCase() ==
                            "null"
                        ) {
                            terima_jumlahTerimaPrimer.value = 0;
                            terima_jumlahTerimaPrimer.readOnly = true;
                        }
                        if (
                            terima_satJumlahTerimaSekunder.value.toLowerCase() ==
                            "null"
                        ) {
                            terima_jumlahTerimaSekunder.value = 0;
                            terima_jumlahTerimaSekunder.readOnly = true;
                        } else {
                            terima_jumlahTerimaSekunder.value =
                                numeral(rowData[11]).value() / 25;
                        }
                        terima_jumlahTerimaTritier.value = numeral(
                            rowData[11]
                        ).value();

                        if (!terima_jumlahTerimaPrimer.readOnly) {
                            terima_jumlahTerimaPrimer.select();
                        } else if (!terima_jumlahTerimaSekunder.readOnly) {
                            terima_jumlahTerimaSekunder.select();
                        } else {
                            terima_jumlahTerimaTritier.select();
                        }
                    } else {
                        Swal.fire({
                            title: "Pilih Tujuan",
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
                                    Swal.showValidationMessage(
                                        "Please select a row"
                                    );
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
                                        paging: false,
                                        scrollY: "400px",
                                        scrollCollapse: true,
                                        order: [1, "asc"],
                                        data: data,
                                        columns: [
                                            {
                                                data: "IdSubkelompok",
                                                title: "ID Sub Kelompok",
                                            },
                                            {
                                                data: "NamaSubKelompok",
                                                title: "Nama Sub Kelompok",
                                            },
                                        ],
                                        columnDefs: [
                                            {
                                                targets: 0,
                                                width: "100px",
                                            },
                                        ],
                                    });
                                    $("#table_list tbody").on(
                                        "click",
                                        "tr",
                                        function () {
                                            table
                                                .$("tr.selected")
                                                .removeClass("selected");
                                            $(this).addClass("selected");
                                            scrollRowIntoView(this);
                                        }
                                    );
                                    const searchInput = $(
                                        "#table_list_filter input"
                                    );
                                    if (searchInput.length > 0) {
                                        searchInput.focus();
                                    }
                                    currentIndex = null;
                                    Swal.getPopup().addEventListener(
                                        "keydown",
                                        (e) =>
                                            handleTableKeydown(e, "table_list")
                                    );
                                });
                            },
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const filteredData = data.filter(
                                    (item) =>
                                        item.IdSubkelompok ==
                                        result.value.IdSubkelompok
                                );
                                terima_divisi.value = filteredData[0].NamaDivisi; // prettier-ignore
                                terima_objek.value = filteredData[0].NamaObjek;
                                terima_kelompok.value = filteredData[0].NamaKelompok; // prettier-ignore
                                terima_kodeBarang.value = filteredData[0].KodeBarang; // prettier-ignore
                                terima_PIB.value = rowData[16];
                                terima_kelompokUtama.value = filteredData[0].NamaKelompokUtama; // prettier-ignore
                                terima_subKelompok.value = filteredData[0].NamaSubKelompok; // prettier-ignore
                                terima_idSubKelompok.value = filteredData[0].IdSubkelompok; // prettier-ignore
                                terima_idType.value = filteredData[0].IdType;
                                terima_namaType.value = filteredData[0].NamaType; // prettier-ignore
                                terima_qtyPesan.value = rowData[5];
                                terima_satQtyPesan.value = rowData[6];
                                terima_qtyTerima.value = rowData[11];
                                terima_satQtyTerima.value = rowData[6];
                                terima_saldoAkhirPrimer.value = numeral(filteredData[0].SaldoPrimer).format("0,0"); // prettier-ignore
                                terima_satSaldoAkhirPrimer.value = filteredData[0].Primer.trim(); // prettier-ignore
                                terima_saldoAkhirSekunder.value = numeral(filteredData[0].SaldoSekunder).format("0,0"); // prettier-ignore
                                terima_satSaldoAkhirSekunder.value = filteredData[0].Sekunder.trim(); // prettier-ignore
                                terima_saldoAkhirTritier.value = numeral(filteredData[0].SaldoTritier).format("0,0"); // prettier-ignore
                                terima_satSaldoAkhirTritier.value = filteredData[0].Tritier.trim(); // prettier-ignore
                                terima_satJumlahTerimaPrimer.value = filteredData[0].Primer.trim(); // prettier-ignore
                                terima_satJumlahTerimaSekunder.value = filteredData[0].Sekunder.trim(); // prettier-ignore
                                terima_satJumlahTerimaTritier.value = filteredData[0].Tritier.trim(); // prettier-ignore
                                terima_noSatPrimer.value = filteredData[0].UnitPrimer; // prettier-ignore
                                terima_noSatSekunder.value = filteredData[0].UnitSekunder; // prettier-ignore
                                terima_noSatTritier.value = filteredData[0].UnitTritier; // prettier-ignore

                                if (
                                    terima_satJumlahTerimaPrimer.value.toLowerCase() ==
                                    "null"
                                ) {
                                    terima_jumlahTerimaPrimer.value = 0;
                                    terima_jumlahTerimaPrimer.readOnly = true;
                                }
                                if (
                                    terima_satJumlahTerimaSekunder.value.toLowerCase() ==
                                    "null"
                                ) {
                                    terima_jumlahTerimaSekunder.value = 0;
                                    terima_jumlahTerimaSekunder.readOnly = true;
                                } else {
                                    terima_jumlahTerimaSekunder.value =
                                        numeral(rowData[11]).value() / 25;
                                }
                                terima_jumlahTerimaTritier.value = numeral(
                                    rowData[11]
                                ).value();

                                if (!terima_jumlahTerimaPrimer.readOnly) {
                                    terima_jumlahTerimaPrimer.select();
                                } else if (
                                    !terima_jumlahTerimaSekunder.readOnly
                                ) {
                                    terima_jumlahTerimaSekunder.select();
                                } else {
                                    terima_jumlahTerimaTritier.select();
                                }
                            }
                        });
                    }
                }
            },
            error: function (xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.error(err.Message);
            },
        });
    });

    terima_jumlahTerimaPrimer.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            terima_jumlahTerimaPrimer.value = numeral(this.value).value();
            terima_jumlahTerimaSekunder.select();
        }
    });

    terima_jumlahTerimaSekunder.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            terima_jumlahTerimaSekunder.value = numeral(this.value).value();
            terima_jumlahTerimaTritier.select();
        }
    });

    terima_jumlahTerimaTritier.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            terima_jumlahTerimaTritier.value = numeral(this.value).value();
            button_transfer.focus();
        }
    });

    button_transfer.addEventListener("click", function (e) {
        let selectedRow = $("#table_trasferBarang tbody tr.selected");

        if (!selectedRow.length) {
            errorHandling(
                "invalidInput",
                "Tidak ada barang untuk ditransfer. Anda harus memilih barang yang akan ditransfer"
            );
            return;
        }

        let rowData = table_trasferBarang.row(selectedRow).data();

        if (
            terima_kodeBarang.value.startsWith("11") ||
            terima_kodeBarang.value.startsWith("00")
        ) {
            terima_PIB.value = "-";
        } else if (terima_PIB.value == "") {
            errorHandling("invalidInput", "Input PIB Terlebih Dahulu");
        }

        function isValidNumber(val) {
            const num = numeral(val).value();
            return Number.isFinite(num);
        }

        if (
            !isValidNumber(terima_jumlahTerimaPrimer.value) ||
            !isValidNumber(terima_jumlahTerimaSekunder.value) ||
            !isValidNumber(terima_jumlahTerimaTritier.value)
        ) {
            errorHandling(
                "invalidInput",
                "Jumlah terima harus berupa angka yang valid"
            );
            return;
        }

        Swal.fire({
            title: "Data Yang Akan Ditransfer Sudah Benar?",
            confirmButtonText: "Ya",
            showDenyButton: true,
            denyButtonText: "Tidak",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/TransferBarang/",
                    type: "POST",
                    data: {
                        IdType: terima_idType.value,
                        NoSPPB: rowData[17],
                        NoPIB: terima_PIB.value,
                        MasukPrimer: numeral(
                            terima_jumlahTerimaPrimer.value
                        ).value(),
                        MasukSekunder: numeral(
                            terima_jumlahTerimaSekunder.value
                        ).value(),
                        MasukTritier: numeral(
                            terima_jumlahTerimaTritier.value
                        ).value(),
                        SubKel: terima_idSubKelompok.value,
                        NoTerima: rowData[8],
                        KdBarang: terima_kodeBarang.value,
                        NoSatuan: terima_noSatTritier.value,
                        SatuanPrimer: terima_noSatPrimer.value,
                        SatuanSekunder: terima_noSatSekunder.value,
                        _token: csrfToken,
                    },
                    success: function (data) {
                        if (data.error || data.length == 0) {
                            errorHandling("ajaxGetDataResponse", data.error);
                        } else {
                            loadBTTB();
                        }
                    },
                    error: function (xhr, status, error) {
                        errorHandling(
                            "ajaxGetDataResponse",
                            xhr.responseJSON.error
                        );
                    },
                });
            }
        });
    });
    //#endregion
});
