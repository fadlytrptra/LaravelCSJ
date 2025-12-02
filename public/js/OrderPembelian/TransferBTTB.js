let nomor_purchaseOrder = document.getElementById("nomor_purchaseOrder");
let no_bttb = document.getElementById("no_bttb");
let tanggal = document.getElementById("tanggal");
let table_transferBTTB = document.getElementById("table_transferBTTB");
let no_terima = document.getElementById("no_terima");
let kode_barang = document.getElementById("kode_barang");
let nama_barang = document.getElementById("nama_barang");
let no_pib = document.getElementById("no_pib");
let keterangan = document.getElementById("keterangan");
let qty_terima = document.getElementById("qty_terima");
let ket_qtyTerima = document.getElementById("ket_qtyTerima");
let qty_premier = document.getElementById("qty_premier");
let ket_qtyPremier = document.getElementById("ket_qtyPremier");
let qty_sekunder = document.getElementById("qty_sekunder");
let ket_qtySekunder = document.getElementById("ket_qtySekunder");
let qty_tertier = document.getElementById("qty_tertier");
let ket_qtyTertier = document.getElementById("ket_qtyTertier");
let divisi_select = document.getElementById("divisi_select");
let ket_divisi = document.getElementById("ket_divisi");
let objek_select = document.getElementById("objek_select");
let ket_objek = document.getElementById("ket_objek");
let kelompok_utama = document.getElementById("kelompok_utama");
let ket_kelompokUtama = document.getElementById("ket_kelompokUtama");
let kelompok = document.getElementById("kelompok");
let ket_kelompok = document.getElementById("ket_kelompok");
let sub_kelompok = document.getElementById("sub_kelompok");
let ket_subKelompok = document.getElementById("ket_subKelompok");
let idType = document.getElementById("idType");
let saldo_premier = document.getElementById("saldo_premier");
let ket_saldoPremier = document.getElementById("ket_saldoPremier");
let saldo_sekunder = document.getElementById("saldo_sekunder");
let ket_saldoSekunder = document.getElementById("ket_saldoSekunder");
let saldo_tertier = document.getElementById("saldo_tertier");
let ket_saldoTertier = document.getElementById("ket_saldoTertier");
let btn_transfer = document.getElementById("btn_transfer");
let btn_koreksi = document.getElementById("btn_koreksi");
let btn_kelompokUtama = document.getElementById("btn_kelompokUtama");
let btn_kelompok = document.getElementById("btn_kelompok");
let btn_subKelompok = document.getElementById("btn_subKelompok");
let btn_idType = document.getElementById("btn_idType");
let btn_divisi = document.getElementById("btn_divisi");
let btn_objek = document.getElementById("btn_objek");
let divisi_tb = document.getElementById("divisi_tb");
let objek_tb = document.getElementById("objek_tb");
const container = document.getElementById("formContainer");
const elements = Array.from(
    container.querySelectorAll("input, select, button")
);

let csrfToken = $('meta[name="csrf-token"]').attr("content");
let NoTransTmp;

// tanggal.valueAsDate = new Date();
btn_koreksi.disabled = true;
btn_kelompokUtama.disabled = true;
btn_kelompok.disabled = true;
btn_subKelompok.disabled = true;
btn_idType.disabled = true;
btn_divisi.disabled = true;
btn_objek.disabled = true;

// function clearOptions(selectElement) {
//     let length = selectElement.options.length;

//     for (let i = length - 1; i > 0; i--) {
//         selectElement.remove(i);
//     }
// }
// function optionClr() {
//     divisi_select.selectedIndex = 0;
//     clearOptions(divisi_select);
//     objek_select.selectedIndex = 0;
//     clearOptions(objek_select);
// }
// objek_select.addEventListener("change", function (event) {
//     ket_objek.value = objek_select.value;
//     if (objek_select.selectedIndex != 0) {
//         let noPIBs = "";
//         if (no_pib.value !== "") {
//             noPIBs = no_pib.value.trim();
//         }
//         $.ajax({
//             url: "/TransferBarang/TransferBTTB/LoadKelomDLL",
//             type: "GET",
//             data: {
//                 KodeBarang: kode_barang.value.trim(),
//                 idObjek: ket_objek.value.trim(),
//                 noPIB: noPIBs ?? null,
//             },
//             success: function (response) {
//                 console.log(response);

//                 kelompok_utama.value = response[0].NamaKelompokUtama;
//                 ket_kelompokUtama.value = response[0].IdKelompokUtama;
//                 kelompok.value = response[0].NamaKelompok;
//                 ket_kelompok.value = response[0].IdKelompok;
//                 sub_kelompok.value = response[0].NamaSubKelompok;
//                 ket_subKelompok.value = response[0].IdSubkelompok;
//                 idType.value = response[0].IdType;
//                 saldo_premier.value = parseFloat(response[0].SaldoPrimer);
//                 saldo_sekunder.value = parseFloat(response[0].SaldoSekunder);
//                 saldo_tertier.value = parseFloat(response[0].SaldoTritier);
//                 ket_saldoPremier.value = response[0].SatPrimer;
//                 ket_saldoSekunder.value = response[0].SatSekunder;
//                 ket_saldoTertier.value = response[0].SatTritier;
//                 if (idType.value == "") {
//                     alert(
//                         "Kode barang" +
//                             kode_barang.value +
//                             " belum ada di Subkelompok: Item Pembelian divisi: " +
//                             ket_divisi.value +
//                             ". Hubungi admin divisi terkait untuk maintenance type terlebih dahulu di program Inventory."
//                     );
//                 }
//                 btn_koreksi.disabled = false;
//                 btn_transfer.disabled = false;
//             },
//             error: function (error) {
//                 console.error("Error Fetch Data:", error);
//             },
//         });
//     }
// });

// divisi_select.addEventListener("change", function (event) {
//     ket_divisi.value = divisi_select.value;
//     objek_select.selectedIndex = 0;
//     clearOptions(objek_select);

//     if (divisi_select.selectedIndex != 0) {
//         $.ajax({
//             url: "/TransferBarang/TransferBTTB/DataObjek",
//             type: "GET",
//             data: {
//                 KodeBarang: kode_barang.value.trim(),
//                 XIdDivisi: ket_divisi.value.trim(),
//             },
//             success: function (response) {
//                 if (response.length != 0) {
//                     response.forEach(function (data) {
//                         let option = document.createElement("option");
//                         option.value = data.IdObjek;
//                         option.text = data.NamaObjek;
//                         objek_select.add(option);
//                     });
//                 } else {
//                     alert(
//                         "Kode Barang Belum di Maintenance Type Pada Divisi Tersebut !"
//                     );
//                 }
//             },
//             error: function (error) {
//                 console.error("Error Fetch Data:", error);
//             },
//         });
//     }
// });

btn_koreksi.addEventListener("click", function (event) {
    $.ajax({
        url: "/TransferBarang/TransferBTTB/Koreksi",
        type: "PUT",
        headers: {
            "X-CSRF-TOKEN": csrfToken,
        },
        data: {
            IdType: idType.value.trim(),
            MasukPrimer: qty_premier.value,
            MasukSekunder: qty_sekunder.value,
            MasukTritier: qty_tertier.value,
            SubKel: ket_subKelompok.value,
            NoTransTmp: NoTransTmp,
            ket: keterangan.value,
            tanggal: tanggal.value,
        },
        beforeSend: function () {
            // Show loading screen
            $("#loading-screen").css("display", "flex");
        },
        success: function (response) {
            Swal.fire({
                icon: "success",
                title: "Data Berhasil DiKoreksi!",
                showConfirmButton: false,
                timer: "2000",
            });
            console.log(response);
        },
        error: function (error) {
            Swal.fire({
                icon: "error",
                title: "Data Tidak Berhasil DiKoreksi!",
                showConfirmButton: false,
                timer: "2000",
            });
            console.error("Error Send Data:", error);
        },
        complete: function () {
            // Hide loading screen
            $("#loading-screen").css("display", "none");
        },
    });
});

btn_transfer.addEventListener("click", function (event) {
    if (ket_qtyTertier.value.trim() == ket_qtyTerima.value.trim()) {
        if (
            numeral(qty_tertier.value).value() >
            numeral(qty_terima.value).value()
        ) {
            Swal.fire({
                icon: "info",
                title: "Info",
                text: "Tidak boleh lebih besar dari qty terima!",
                showConfirmButton: true,
            });
            qty_tertier.focus();
        } else {
            $.ajax({
                url: "/TransferBarang/TransferBTTB/Transfer",
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
                data: {
                    IdType: idType.value.trim(),
                    MasukPrimer: numeral(qty_premier.value).value(),
                    MasukSekunder: numeral(qty_sekunder.value).value(),
                    MasukTritier: numeral(qty_tertier.value).value(),
                    SubKel: ket_subKelompok.value,
                    NoTerima: no_terima.value,
                    ket: keterangan.value,
                    YTanggal: tanggal.value,
                    NoPib: no_pib.value,
                },
                beforeSend: function () {
                    // Show loading screen
                    $("#loading-screen").css("display", "flex");
                },
                success: function (response) {
                    Swal.fire({
                        icon: "success",
                        title: "Data Berhasil DiTransfer!",
                        showConfirmButton: false,
                        timer: "2000",
                    }).then(() => {
                        // Redirect after the timer expires
                        window.close();
                    });
                },
                error: function (error) {
                    Swal.fire({
                        icon: "error",
                        title: "Data Tidak Berhasil DiTransfer!",
                        showConfirmButton: false,
                        timer: "2000",
                    });
                    console.error("Error Send Data:", error);
                },
                complete: function () {
                    // Hide loading screen
                    $("#loading-screen").css("display", "none");
                },
            });
        }
    } else {
        $.ajax({
            url: "/TransferBarang/TransferBTTB/Transfer",
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            data: {
                IdType: idType.value.trim(),
                MasukPrimer: numeral(qty_premier.value).value(),
                MasukSekunder: numeral(qty_sekunder.value).value(),
                MasukTritier: numeral(qty_tertier.value).value(),
                SubKel: ket_subKelompok.value,
                NoTerima: no_terima.value,
                ket: keterangan.value,
                YTanggal: tanggal.value,
                NoPib: no_pib.value,
            },
            beforeSend: function () {
                // Show loading screen
                $("#loading-screen").css("display", "flex");
            },
            success: function (response) {
                Swal.fire({
                    icon: "success",
                    title: "Data Berhasil DiTransfer!",
                    showConfirmButton: false,
                    timer: "2000",
                }).then(() => {
                    // Redirect after the timer expires
                    window.close();
                });
            },
            error: function (error) {
                Swal.fire({
                    icon: "error",
                    title: "Data Tidak Berhasil DiTransfer!",
                    showConfirmButton: false,
                    timer: "2000",
                });
                console.error("Error Send Data:", error);
            },
            complete: function () {
                // Hide loading screen
                $("#loading-screen").css("display", "none");
            },
        });
    }
});

container.addEventListener("keydown", function (event) {
    if (event.key === "Tab") {
        event.preventDefault();
        const currentIndex = elements.indexOf(document.activeElement);
        let nextIndex = currentIndex;

        do {
            nextIndex = (nextIndex + 1) % elements.length;
        } while (
            elements[nextIndex].hasAttribute("readonly") ||
            elements[nextIndex].disabled
        );

        elements[nextIndex].focus();
    }
});

function clearData() {
    // tanggal.valueAsDate = new Date();
    no_terima.value = "";
    kode_barang.value = "";
    nama_barang.value = "";
    keterangan.value = "";
    qty_terima.value = "0";
    ket_qtyTerima.value = "";
    qty_premier.value = "";
    ket_qtyPremier.value = "";
    qty_sekunder.value = "";
    ket_qtySekunder.value = "";
    qty_tertier.value = "";
    ket_qtyTertier.value = "";
    // optionClr();
    kelompok_utama.value = "";
    kelompok.value = "";
    sub_kelompok.value = "";
    idType.value = "";
    saldo_premier.value = "";
    ket_saldoPremier.value = "";
    saldo_sekunder.value = "";
    ket_saldoSekunder.value = "";
    saldo_tertier.value = "";
    ket_saldoTertier.value = "";
}

// function divisi(KodeBarang) {
//     $.ajax({
//         url: "/TransferBarang/TransferBTTB/DataDivisi",
//         type: "GET",
//         data: {
//             KodeBarang: KodeBarang,
//         },
//         success: function (response) {
//             if (response.length != 0) {
//                 optionClr();
//                 response.forEach(function (data) {
//                     let option = document.createElement("option");
//                     option.value = data.IdDivisi;
//                     option.text = data.NamaDivisi;
//                     divisi_select.add(option);
//                 });
//             } else {
//                 alert("Kode Barang Belum di Maintenance Type Oleh User Order");
//             }
//         },
//         error: function (error) {
//             console.error("Error Fetch Data:", error);
//         },
//     });
// }

function loadSatuan(KodeBarang) {
    $.ajax({
        url: "/TransferBarang/TransferBTTB/LoadSatuan",
        type: "GET",
        data: {
            kdbrg: KodeBarang,
        },
        success: function (response) {
            console.log(response);
            qty_premier.value = "";
            qty_sekunder.value = "";
            ket_qtyPremier.value = response[0].Primer.replace(/\s/g, "");
            ket_qtySekunder.value = response[0].Sekunder.replace(/\s/g, "");
            ket_qtyTertier.value = response[0].Tertier.replace(/\s/g, "");

            if (response[0].Primer.replace(/\s/g, "") != "NULL") {
                qty_premier.readOnly = false;
            }
            if (response[0].Sekunder.replace(/\s/g, "") != "NULL") {
                qty_sekunder.readOnly = false;
            }
            if (response[0].Tertier.replace(/\s/g, "") != "NULL") {
                qty_tertier.readOnly = false;
            }
        },
        error: function (error) {
            console.error("Error Fetch Data:", error);
        },
    });
}
$(document).ready(function () {
    if (koreksi == 0) {
        btn_koreksi.style.display = "none";
    } else {
        btn_transfer.style.display = "none";
    }
    let table = $("#table_transferBTTB").DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        searching: false,
        scrollY: "200px",
        paging: false,
        scrollX: true,
        ajax: {
            url: "/TransferBarang/TransferBTTB/LoadData",
            type: "GET",
            data: function (data) {
                (data.noBTTB = no_bttb.value), (data.koreksi = koreksi);
            },
        },
        columns: [
            { data: "No_terima" },
            { data: "nama_kategori" },
            { data: "nama_sub_kategori" },
            { data: "Kd_brg" },
            { data: "NAMA_BRG" },
            { data: "Qty_Terima" },
            { data: "Nama_satuan" },
            { data: "NoPIBExt" },
        ],
        rowCallback: function (row, data) {
            console.log(data);

            $(row).on("dblclick", function (event) {
                clearData();
                no_terima.value = data.No_terima;
                kode_barang.value = data.Kd_brg;
                nama_barang.value = escapeHTML(data.NAMA_BRG);
                qty_terima.value = numeral(
                    numeral(data.Qty_Terima).value()
                ).format("0,0.00");
                ket_qtyTerima.value = data.Nama_satuan;
                no_pib.value = data.NoPIBExt;
                // divisi(data.Kd_brg.trim());
                loadSatuan(data.Kd_brg.trim());
                if (koreksi == 1) {
                    NoTransTmp = data.NoTransaksiTmp;
                }
            });
        },
    });

    qty_tertier.addEventListener("keypress", function (event) {
        if (event.key == "Enter") {
            let numeralValue = numeral(qty_tertier.value).value();
            this.value = numeral(numeralValue).format("0,0.00");
            // supplier_select.focus();
        }
    });

    qty_sekunder.addEventListener("keypress", function (event) {
        if (event.key == "Enter") {
            let numeralValue = numeral(qty_sekunder.value).value();
            this.value = numeral(numeralValue).format("0,0.00");
            // supplier_select.focus();
        }
    });

    qty_premier.addEventListener("keypress", function (event) {
        if (event.key == "Enter") {
            let numeralValue = numeral(qty_premier.value).value();
            this.value = numeral(numeralValue).format("0,0.00");
            // supplier_select.focus();
        }
    });

    table.on("dblclick", "tbody tr", (e) => {
        const classList = e.currentTarget.classList;

        if (classList.contains("selected")) {
            classList.remove("selected");

            if (table.rows(".selected").nodes().length === 0) {
                btn_kelompokUtama.disabled = true;
                btn_kelompok.disabled = true;
                btn_subKelompok.disabled = true;
                btn_idType.disabled = true;
                btn_divisi.disabled = true;
                btn_objek.disabled = true;
            }
        } else {
            table
                .rows(".selected")
                .nodes()
                .each((row) => row.classList.remove("selected"));
            classList.add("selected");

            let prefix_kode = kode_barang.value.substring(0, 2);
            let validPrefixes = [
                "12",
                "13",
                "14",
                "15",
                "16",
                "17",
                "42",
                "43",
                "44",
                "45",
            ];

            if (validPrefixes.includes(prefix_kode)) {
                btn_divisi.disabled = false;
                btn_objek.disabled = false;
                btn_kelompokUtama.disabled = false;
                btn_kelompok.disabled = false;
                btn_subKelompok.disabled = false;
                btn_idType.disabled = false;
            } else {
                btn_divisi.disabled = false;
                btn_objek.disabled = false;
                btn_kelompokUtama.disabled = false;
                btn_kelompok.disabled = false;
                btn_subKelompok.disabled = false;
                btn_idType.disabled = false;
            }
            btn_divisi.focus();
        }
    });

    btn_divisi.addEventListener("click", async function (event) {
        event.preventDefault();
        try {
            const result = await Swal.fire({
                title: "Select a Divisi",
                html: '<table id="tableDivisi" class="display" style="width:100%"><thead><tr><th>Divisi</th><th>ID. Divisi</th></tr></thead><tbody></tbody></table>',
                showCancelButton: true,
                width: "50%",
                preConfirm: () => {
                    const selectedData = $("#tableDivisi")
                        .DataTable()
                        .row(".selected")
                        .data();
                    if (!selectedData) {
                        Swal.showValidationMessage("Please select a row");
                        return false;
                    }
                    return selectedData;
                },
                didOpen: () => {
                    $(document).ready(function () {
                        const table = $("#tableDivisi").DataTable({
                            responsive: true,
                            processing: true,
                            serverSide: true,
                            ajax: {
                                url: "/TransferBrg/Tampil/getDivisiBTTB",
                                dataType: "json",
                                type: "GET",
                                data: {
                                    _token: csrfToken,
                                    KodeBarang: kode_barang.value.trim(),
                                },
                            },
                            columns: [
                                { data: "NamaDivisi" },
                                { data: "IdDivisi" },
                            ],
                        });
                        $("#tableDivisi tbody").on("click", "tr", function () {
                            table.$("tr.selected").removeClass("selected");
                            $(this).addClass("selected");
                        });
                        currentIndex = null;
                        Swal.getPopup().addEventListener("keydown", (e) =>
                            handleTableKeydownInSwal(e, "tableDivisi")
                        );
                    });
                },
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    const selectedRow = result.value;
                    // sub_kelompok.value = escapeHTML(
                    //     selectedRow.NamaSubKelompok.trim()
                    // );
                    divisi_tb.value = escapeHTML(selectedRow.NamaDivisi.trim());
                    ket_divisi.value = selectedRow.IdDivisi.trim();
                    setTimeout(() => {
                        btn_objek.focus();
                    }, 300);
                }
            });
        } catch (error) {
            console.error("An error occurred:", error);
        }
    });

    btn_objek.addEventListener("click", async function (event) {
        event.preventDefault();
        try {
            const result = await Swal.fire({
                title: "Select a Objek",
                html: '<table id="tableObjek" class="display" style="width:100%"><thead><tr><th>Objek</th><th>ID. Objek</th></tr></thead><tbody></tbody></table>',
                showCancelButton: true,
                width: "50%",
                preConfirm: () => {
                    const selectedData = $("#tableObjek")
                        .DataTable()
                        .row(".selected")
                        .data();
                    if (!selectedData) {
                        Swal.showValidationMessage("Please select a row");
                        return false;
                    }
                    return selectedData;
                },
                didOpen: () => {
                    $(document).ready(function () {
                        const table = $("#tableObjek").DataTable({
                            responsive: true,
                            processing: true,
                            serverSide: true,
                            ajax: {
                                url: "/TransferBrg/Tampil/getObjek",
                                dataType: "json",
                                type: "GET",
                                data: {
                                    _token: csrfToken,
                                    KodeBarang: kode_barang.value.trim(),
                                    XIdDivisi: ket_divisi.value.trim(),
                                },
                            },
                            columns: [
                                { data: "NamaObjek" },
                                { data: "IdObjek" },
                            ],
                        });
                        $("#tableObjek tbody").on("click", "tr", function () {
                            table.$("tr.selected").removeClass("selected");
                            $(this).addClass("selected");
                        });
                        currentIndex = null;
                        Swal.getPopup().addEventListener("keydown", (e) =>
                            handleTableKeydownInSwal(e, "tableObjek")
                        );
                    });
                },
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    const selectedRow = result.value;
                    objek_tb.value = escapeHTML(selectedRow.NamaObjek.trim());
                    ket_objek.value = selectedRow.IdObjek.trim();

                    let noPIBs = "";
                    if (no_pib.value !== "") {
                        noPIBs = no_pib.value.trim();
                    }

                    let prefix_kode = kode_barang.value.substring(0, 2);
                    let validPrefixes = [
                        "12",
                        "13",
                        "14",
                        "15",
                        "16",
                        "17",
                        "42",
                        "43",
                        "44",
                        "45",
                    ];

                    if (!validPrefixes.includes(prefix_kode)) {
                        $.ajax({
                            url: "/TransferBarang/TransferBTTB/LoadKelomDLL",
                            type: "GET",
                            data: {
                                KodeBarang: kode_barang.value.trim(),
                                idObjek: ket_objek.value.trim(),
                                noPIB: noPIBs ?? null,
                            },
                            beforeSend: function () {
                                $("#loading-screen").css("display", "flex");
                            },
                            success: function (response) {
                                console.log(response);

                                kelompok_utama.value =
                                    response[0].NamaKelompokUtama;
                                ket_kelompokUtama.value =
                                    response[0].IdKelompokUtama;
                                kelompok.value = response[0].NamaKelompok;
                                ket_kelompok.value = response[0].IdKelompok;
                                sub_kelompok.value =
                                    response[0].NamaSubKelompok;
                                ket_subKelompok.value =
                                    response[0].IdSubkelompok;
                                idType.value = response[0].IdType;
                                saldo_premier.value = parseFloat(
                                    response[0].SaldoPrimer
                                );
                                saldo_sekunder.value = parseFloat(
                                    response[0].SaldoSekunder
                                );
                                saldo_tertier.value = parseFloat(
                                    response[0].SaldoTritier
                                );
                                ket_saldoPremier.value = response[0].SatPrimer;
                                ket_saldoSekunder.value =
                                    response[0].SatSekunder;
                                ket_saldoTertier.value = response[0].SatTritier;
                                if (idType.value == "") {
                                    alert(
                                        "Kode barang" +
                                            kode_barang.value +
                                            " belum ada di Subkelompok: Item Pembelian divisi: " +
                                            ket_divisi.value +
                                            ". Hubungi admin divisi terkait untuk maintenance type terlebih dahulu di program Inventory."
                                    );
                                }
                                btn_koreksi.disabled = false;
                                btn_transfer.disabled = false;
                            },
                            error: function (error) {
                                console.error("Error Fetch Data:", error);
                            },
                            complete: function () {
                                // Hide loading screen
                                $("#loading-screen").css("display", "none");
                            },
                        });
                    } else {
                        $.ajax({
                            url: "/TransferBarang/TransferBTTB/LoadKelomDLL",
                            type: "GET",
                            data: {
                                KodeBarang: kode_barang.value.trim(),
                                idObjek: ket_objek.value.trim(),
                                noPIB: noPIBs ?? null,
                            },
                            beforeSend: function () {
                                // Show loading screen
                                $("#loading-screen").css("display", "flex");
                            },
                            success: function (response) {
                                console.log(response);

                                // kelompok_utama.value =
                                //     response[0].NamaKelompokUtama;
                                // ket_kelompokUtama.value =
                                //     response[0].IdKelompokUtama;
                                // kelompok.value = response[0].NamaKelompok;
                                // ket_kelompok.value = response[0].IdKelompok;
                                // sub_kelompok.value =
                                //     response[0].NamaSubKelompok;
                                // ket_subKelompok.value =
                                //     response[0].IdSubkelompok;
                                // idType.value = response[0].IdType;
                                saldo_premier.value = parseFloat(
                                    response[0].SaldoPrimer
                                );
                                saldo_sekunder.value = parseFloat(
                                    response[0].SaldoSekunder
                                );
                                saldo_tertier.value = parseFloat(
                                    response[0].SaldoTritier
                                );
                                ket_saldoPremier.value = response[0].SatPrimer;
                                ket_saldoSekunder.value =
                                    response[0].SatSekunder;
                                ket_saldoTertier.value = response[0].SatTritier;
                                // if (idType.value == "") {
                                //     alert(
                                //         "Kode barang" +
                                //             kode_barang.value +
                                //             " belum ada di Subkelompok: Item Pembelian divisi: " +
                                //             ket_divisi.value +
                                //             ". Hubungi admin divisi terkait untuk maintenance type terlebih dahulu di program Inventory."
                                //     );
                                // }
                                btn_koreksi.disabled = false;
                                btn_transfer.disabled = false;
                            },
                            error: function (error) {
                                console.error("Error Fetch Data:", error);
                            },
                            complete: function () {
                                // Hide loading screen
                                $("#loading-screen").css("display", "none");
                            },
                        });
                    }

                    if (btn_kelompokUtama.disabled == true) {
                        setTimeout(() => {
                            keterangan.focus();
                        }, 300);
                    } else {
                        setTimeout(() => {
                            btn_kelompokUtama.focus();
                        }, 300);
                    }
                }
            });
        } catch (error) {
            console.error("An error occurred:", error);
        }
    });

    btn_kelompokUtama.addEventListener("click", async function (event) {
        event.preventDefault();
        try {
            const result = await Swal.fire({
                title: "Select a Kelompok Utama",
                html: '<table id="tableKelompokUtama" class="display" style="width:100%"><thead><tr><th>Nama Kelompok Utama</th><th>ID. Kelompok Utama</th></tr></thead><tbody></tbody></table>',
                showCancelButton: true,
                width: "50%",
                preConfirm: () => {
                    const selectedData = $("#tableKelompokUtama")
                        .DataTable()
                        .row(".selected")
                        .data();
                    if (!selectedData) {
                        Swal.showValidationMessage("Please select a row");
                        return false;
                    }
                    return selectedData;
                },
                didOpen: () => {
                    $(document).ready(function () {
                        const table = $("#tableKelompokUtama").DataTable({
                            responsive: true,
                            processing: true,
                            serverSide: true,
                            ajax: {
                                url: "/TransferBrg/Tampil/getKelompokUtama",
                                dataType: "json",
                                type: "GET",
                                data: {
                                    _token: csrfToken,
                                    ket_objek: ket_objek.value.trim(),
                                    KodeBarang: kode_barang.value.trim(),
                                },
                            },
                            columns: [
                                { data: "NamaKelompokUtama" },
                                { data: "IdKelompokUtama" },
                            ],
                        });
                        $("#tableKelompokUtama tbody").on(
                            "click",
                            "tr",
                            function () {
                                table.$("tr.selected").removeClass("selected");
                                $(this).addClass("selected");
                            }
                        );
                        currentIndex = null;
                        Swal.getPopup().addEventListener("keydown", (e) =>
                            handleTableKeydownInSwal(e, "tableKelompokUtama")
                        );
                    });
                },
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    const selectedRow = result.value;
                    kelompok_utama.value = escapeHTML(
                        selectedRow.NamaKelompokUtama.trim()
                    );
                    ket_kelompokUtama.value =
                        selectedRow.IdKelompokUtama.trim();
                    setTimeout(() => {
                        btn_kelompok.focus();
                    }, 300);
                }
            });
        } catch (error) {
            console.error("An error occurred:", error);
        }
    });

    btn_kelompok.addEventListener("click", async function (event) {
        event.preventDefault();
        try {
            const result = await Swal.fire({
                title: "Select a Kelompok Utama",
                html: '<table id="tableKelompok" class="display" style="width:100%"><thead><tr><th>Kelompok</th><th>ID. Kelompok</th></tr></thead><tbody></tbody></table>',
                showCancelButton: true,
                width: "50%",
                preConfirm: () => {
                    const selectedData = $("#tableKelompok")
                        .DataTable()
                        .row(".selected")
                        .data();
                    if (!selectedData) {
                        Swal.showValidationMessage("Please select a row");
                        return false;
                    }
                    return selectedData;
                },
                didOpen: () => {
                    $(document).ready(function () {
                        const table = $("#tableKelompok").DataTable({
                            responsive: true,
                            processing: true,
                            serverSide: true,
                            ajax: {
                                url: "/TransferBrg/Tampil/getKelompok",
                                dataType: "json",
                                type: "GET",
                                data: {
                                    _token: csrfToken,
                                    ket_kelompokUtama:
                                        ket_kelompokUtama.value.trim(),
                                    KodeBarang: kode_barang.value.trim(),
                                },
                            },
                            columns: [
                                { data: "NamaKelompok" },
                                { data: "IdKelompok" },
                            ],
                        });
                        $("#tableKelompok tbody").on(
                            "click",
                            "tr",
                            function () {
                                table.$("tr.selected").removeClass("selected");
                                $(this).addClass("selected");
                            }
                        );
                        currentIndex = null;
                        Swal.getPopup().addEventListener("keydown", (e) =>
                            handleTableKeydownInSwal(e, "tableKelompok")
                        );
                    });
                },
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    const selectedRow = result.value;
                    kelompok.value = escapeHTML(
                        selectedRow.NamaKelompok.trim()
                    );
                    ket_kelompok.value = selectedRow.IdKelompok.trim();
                    setTimeout(() => {
                        btn_subKelompok.focus();
                    }, 300);
                }
            });
        } catch (error) {
            console.error("An error occurred:", error);
        }
    });

    btn_subKelompok.addEventListener("click", async function (event) {
        event.preventDefault();
        try {
            const result = await Swal.fire({
                title: "Select a Sub Kelompok",
                html: '<table id="tableSubKelompok" class="display" style="width:100%"><thead><tr><th>Sub Kelompok</th><th>ID. Sub Kelompok</th></tr></thead><tbody></tbody></table>',
                showCancelButton: true,
                width: "50%",
                preConfirm: () => {
                    const selectedData = $("#tableSubKelompok")
                        .DataTable()
                        .row(".selected")
                        .data();
                    if (!selectedData) {
                        Swal.showValidationMessage("Please select a row");
                        return false;
                    }
                    return selectedData;
                },
                didOpen: () => {
                    $(document).ready(function () {
                        const table = $("#tableSubKelompok").DataTable({
                            responsive: true,
                            processing: true,
                            serverSide: true,
                            ajax: {
                                url: "/TransferBrg/Tampil/getSubKelompok",
                                dataType: "json",
                                type: "GET",
                                data: {
                                    _token: csrfToken,
                                    ket_kelompok: ket_kelompok.value.trim(),
                                    KodeBarang: kode_barang.value.trim(),
                                },
                            },
                            columns: [
                                { data: "NamaSubKelompok" },
                                { data: "IdSubKelompok" },
                            ],
                        });
                        $("#tableSubKelompok tbody").on(
                            "click",
                            "tr",
                            function () {
                                table.$("tr.selected").removeClass("selected");
                                $(this).addClass("selected");
                            }
                        );
                        currentIndex = null;
                        Swal.getPopup().addEventListener("keydown", (e) =>
                            handleTableKeydownInSwal(e, "tableSubKelompok")
                        );
                    });
                },
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    const selectedRow = result.value;
                    sub_kelompok.value = escapeHTML(
                        selectedRow.NamaSubKelompok.trim()
                    );
                    ket_subKelompok.value = selectedRow.IdSubKelompok.trim();
                    setTimeout(() => {
                        btn_idType.focus();
                    }, 300);
                }
            });
        } catch (error) {
            console.error("An error occurred:", error);
        }
    });

    btn_idType.addEventListener("click", async function (event) {
        event.preventDefault();
        try {
            const result = await Swal.fire({
                title: "Select a ID Type",
                html: '<table id="tableIdType" class="display" style="width:100%"><thead><tr><th>ID. Type</th><th>Nama Type</th></tr></thead><tbody></tbody></table>',
                showCancelButton: true,
                width: "50%",
                preConfirm: () => {
                    const selectedData = $("#tableIdType")
                        .DataTable()
                        .row(".selected")
                        .data();
                    if (!selectedData) {
                        Swal.showValidationMessage("Please select a row");
                        return false;
                    }
                    return selectedData;
                },
                didOpen: () => {
                    $(document).ready(function () {
                        const table = $("#tableIdType").DataTable({
                            responsive: true,
                            processing: true,
                            serverSide: true,
                            ajax: {
                                url: "/TransferBrg/Tampil/getType",
                                dataType: "json",
                                type: "GET",
                                data: {
                                    _token: csrfToken,
                                    ket_subKelompok:
                                        ket_subKelompok.value.trim(),
                                    KodeBarang: kode_barang.value.trim(),
                                },
                            },
                            columns: [{ data: "IdType" }, { data: "NamaType" }],
                        });
                        $("#tableIdType tbody").on("click", "tr", function () {
                            table.$("tr.selected").removeClass("selected");
                            $(this).addClass("selected");
                        });
                        currentIndex = null;
                        Swal.getPopup().addEventListener("keydown", (e) =>
                            handleTableKeydownInSwal(e, "tableIdType")
                        );
                    });
                },
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    const selectedRow = result.value;
                    // sub_kelompok.value = escapeHTML(
                    //     selectedRow.NamaSubKelompok.trim()
                    // );
                    idType.value = selectedRow.IdType.trim();
                    setTimeout(() => {
                        keterangan.focus();
                    }, 300);
                }
            });
        } catch (error) {
            console.error("An error occurred:", error);
        }
    });

    keterangan.addEventListener("keydown", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
            btn_transfer.focus();
        }
    });
});
