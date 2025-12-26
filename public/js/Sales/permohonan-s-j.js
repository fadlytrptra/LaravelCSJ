//#region get element by id

// let submit = document.getElementById("submit");
let add_item = document.getElementById("add_item");
let biaya = document.getElementById("biaya");
let customer = document.getElementById("customer");
let div_suratJalan = document.getElementById("div_suratJalan");
let edit_button = document.getElementById("edit_button");
let expeditor = document.getElementById("expeditor");
let hapus_button = document.getElementById("hapus_button");
let isi_button = document.getElementById("isi_button");
let jenis_pengiriman = document.getElementById("jenis_pengiriman");
let keterangan = document.getElementById("keterangan");
let nomor_do = document.getElementById("nomor_do");
let hidden_kodeBarang = document.getElementById("hidden_kodeBarang");
let hidden_transTmp = document.getElementById("hidden_transTmp");
let hidden_qty = document.getElementById("hidden_qty");
let nomor_container = document.getElementById("nomor_container");
let nomor_seal = document.getElementById("nomor_seal");
let nomor_bl = document.getElementById("nomor_bl");
let proses = 0;
let id_kirimSelect = document.getElementById("id_kirimSelect");
let id_kirimText = document.getElementById("id_kirimText");
let list_sjButton = document.getElementById("list_sjButton");
let remove_item = document.getElementById("remove_item");
let surat_jalan = document.getElementById("surat_jalan");
let surat_pesanan = document.getElementById("surat_pesanan");
let tanggal = document.getElementById("tanggal");
let truk_nopol = document.getElementById("truk_nopol");
let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content"); // prettier-ignore
// let uraian = document.getElementById("uraian");
let divisi = document.getElementById("divisi");
let objek = document.getElementById("objek");
let kelut = document.getElementById("kelut");
let idtrans = document.getElementById("idtrans");
let kelompok = document.getElementById("kelompok");
let subkelompok = document.getElementById("subkelompok");
let min_do = document.getElementById("min_do");
let min_doSatuan = document.getElementById("min_doSatuan");
let max_do = document.getElementById("max_do");
let max_doSatuan = document.getElementById("max_doSatuan");
let tgl_mohonDO = document.getElementById("tgl_mohonDO");
let saldo_akhirPrimer = document.getElementById("saldo_akhirPrimer");
let saldo_akhirSekunder = document.getElementById("saldo_akhirSekunder");
let saldo_akhirTritier = document.getElementById("saldo_akhirTritier");
let jumlah_dikeluarkanPrimer = document.getElementById("jumlah_dikeluarkanPrimer"); // prettier-ignore
let jumlah_dikeluarkanPrimerSatuan = document.getElementById("jumlah_dikeluarkanPrimerSatuan"); // prettier-ignore
let jumlah_dikeluarkanSekunder = document.getElementById("jumlah_dikeluarkanSekunder"); // prettier-ignore
let jumlah_dikeluarkanSekunderSatuan = document.getElementById("jumlah_dikeluarkanSekunderSatuan"); // prettier-ignore
let jumlah_dikeluarkanTritier = document.getElementById("jumlah_dikeluarkanTritier"); // prettier-ignore
let jumlah_dikeluarkanTritierSatuan = document.getElementById("jumlah_dikeluarkanTritierSatuan"); // prettier-ignore
let no_sp = document.getElementById("no_sp");
let customerDO = document.getElementById("customerDO");
let nama_barang = document.getElementById("nama_barang");
let isiQty_button = document.getElementById("isiQty_button");
let hidden_idTypeDO = document.getElementById("hidden_idTypeDO");
let hidden_kodeBarangDO = document.getElementById("hidden_kodeBarangDO");
let no_pibQtyDO = document.getElementById("no_pibQtyDO");
let primer_qtyDO = document.getElementById("primer_qtyDO");
let button_isiQtyDO = document.getElementById("button_isiQtyDO");
let id_typeQtyDO = document.getElementById("id_typeQtyDO");
let sekunder_qtyDO = document.getElementById("sekunder_qtyDO");
let kode_barangQtyDO = document.getElementById("kode_barangQtyDO");
let tritier_qtyDO = document.getElementById("tritier_qtyDO");
let form_suratJalan = document.getElementById("form_suratJalan");
const table_listStok = $("#table_listStok").DataTable({
    ordering: false,
    info: false,
    searching: false,
    paging: false,
    lengthChange: false,
});
const table_listJual = $("#table_listJual").DataTable({
    ordering: false,
    info: false,
    searching: false,
    paging: false,
    lengthChange: false,
});
const table = document.getElementById("list_view");

//#endregion

//#region input filter

setInputFilter(
    document.getElementById("biaya"),
    function (value) {
        return /^-?\d*$/.test(value);
    },
    "Harus diisi dengan angka!"
);

//#endregion

//#region load form

isi_button.focus();
tanggal.valueAsDate = new Date();
div_suratJalan.classList.toggle("disabled");
//fetch loading screen
window.fetch = ((originalFetch) => {
    return function (url, options) {
        $("#loading-screen").css("display", "flex");

        return originalFetch(url, options).finally(() => {
            $("#loading-screen").css("display", "none");
        });
    };
})(window.fetch);

//#endregion

//#region Add event listener

customer.addEventListener("change", function () {
    let customer = this.value;
    fetch("/options/suratpesanan/" + customer)
        .then((response) => response.json())
        .then((options) => {
            surat_pesanan.innerHTML =
                "<option disabled selected>-- Pilih Surat Pesanan --</option>";
            options.forEach((option) => {
                let optionTag = document.createElement("option");
                optionTag.value = option.IDSuratPesanan;
                optionTag.text = option.IDSuratPesanan;
                surat_pesanan.appendChild(optionTag);
            });
        });
});
surat_pesanan.addEventListener("change", function () {
    let surat_pesanan = "";
    if (this.value.includes("/")) {
        surat_pesanan = this.value.replace(/\//g, ".");
    } else {
        surat_pesanan = this.value;
    }
    // console.log(surat_pesanan);
    fetch("/options/deliveryorder/" + surat_pesanan)
        .then((response) => response.json())
        .then((options) => {
            // console.log(options);
            nomor_do.innerHTML =
                "<option disabled selected>-- Pilih Delivery Order --</option>";
            options.forEach((option) => {
                let optionTag = document.createElement("option");
                optionTag.value = option.IDDO;
                // let string = option.Uraian;
                // let NamaBarang = string.substring(0, string.indexOf(" Qty Primer"));
                // optionTag.text = NamaBarang;
                optionTag.text = option.IDDO;
                nomor_do.appendChild(optionTag);
            });
        });
});

nomor_do.addEventListener("change", function () {
    // Get the selected option element
    var selectedOption = this.options[this.selectedIndex];

    // Get the text content of the selected option
    var selectedText = selectedOption.textContent;
    fetch("/options/selecteddeliveryorder/" + selectedText)
        .then((response) => response.json())
        .then((options) => {
            // console.log(options);
            hidden_kodeBarang.value = options[0].IDBarang;
            hidden_transTmp.value = options[0].IdTransTmp;
            hidden_qty.value = numeral(options[0].QtyTritier).format("0,0");
        });
});

id_kirimSelect.addEventListener("change", function (event) {
    if (this.selectedIndex !== 0) {
        this.classList.add("input-error");
        this.setCustomValidity("Tekan Enter!");
        this.reportValidity();
    }
    // console.log(id_kirimText.value)
});

id_kirimSelect.addEventListener("keypress", function (event) {
    if (event.key == "Enter") {
        event.preventDefault();
        if (this.selectedIndex !== 0) {
            id_kirimText.value = this.value;
            this.disabled = true;
            const enterEvent = new KeyboardEvent("keypress", { key: "Enter" });
            id_kirimText.dispatchEvent(enterEvent);
            // console.log(id_kirimText.value);
        }
    }
});

id_kirimText.addEventListener("keypress", function (event) {
    if (event.key == "Enter") {
        // console.log("masuk enter");
        let id_pengiriman = id_kirimSelect.options[
            id_kirimSelect.selectedIndex
        ].textContent
            .split("-")[0]
            .trim();
        event.preventDefault();
        fetch("/options/editSJ/" + id_pengiriman)
            .then((response) => response.json())
            .then((data) => {
                // console.log(data);
                biaya.value = parseFloat(data[0][0].Biaya);
                const optionjenis_pengiriman = jenis_pengiriman.options;

                for (let i = 0; i < optionjenis_pengiriman.length; i++) {
                    const option = optionjenis_pengiriman[i];
                    if (option.value === data[0][0].JnsIdPengiriman) {
                        option.selected = true;
                        break;
                    }
                }

                surat_jalan.value = data[0][0].IDPengiriman;
                tanggal.value = data[0][0].Tanggal.split(" ")[0];
                keterangan.value = data[0][0].Ket;
                customer.innerHTML = "<option> -- Pilih Customer -- </option>";
                data[2].forEach((option) => {
                    let optionTagValue = option.IdCust.split("-");
                    // console.log(optionTagValue);
                    let optionTag = document.createElement("option");
                    optionTag.value = optionTagValue[0].trim();
                    optionTag.text = option.NamaCust;
                    customer.appendChild(optionTag);
                });

                let optionTag = document.createElement("option");
                optionTag.value = data[0][0].IDCust;
                optionTag.text = id_kirimSelect.options[
                    id_kirimSelect.selectedIndex
                ].textContent
                    .split("-")[1]
                    .trim();
                customer.appendChild(optionTag);
                const optioncustomer = customer.options;

                for (let i = 0; i < optioncustomer.length; i++) {
                    const option = optioncustomer[i];
                    if (option.value === data[0][0].IDCust) {
                        option.selected = true;
                        break;
                    }
                }

                const optionexpeditor = expeditor.options;

                for (let i = 0; i < optionexpeditor.length; i++) {
                    const option = optionexpeditor[i];
                    if (option.value === data[0][0].IDExpeditor) {
                        option.selected = true;
                        break;
                    }
                }

                truk_nopol.value = data[0][0].TrukNopol;
                let arrayDetail = [];

                for (let i = 0; i < data[1].length; i++) {
                    arrayDetail.push(data[1][i].IDDO);
                    arrayDetail.push("");
                    arrayDetail.push(data[1][i].IDDetailKirim);
                    arrayDetail.push(data[1][i].IDSuratPesanan);
                }
                // console.log(arrayDetail);
                funcInsertRow(arrayDetail);
            });
        list_sjButton.disabled = true;
    }
});

truk_nopol.addEventListener("change", function () {
    truk_nopol.value = this.value.toUpperCase();
});
//#endregion

//#region enter-enter

surat_pesanan.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        nomor_do.focus();
    }
});

nomor_do.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        add_item.focus();
    }
});

jenis_pengiriman.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        surat_jalan.focus();
    }
});

surat_jalan.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        tanggal.focus();
    }
});

tanggal.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        expeditor.focus();
    }
});

expeditor.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        customer.focus();
    }
});

customer.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        keterangan.focus();
    }
});

// keterangan.addEventListener("keypress", function (event) {
//     if (event.key === "Enter") {
//         event.preventDefault();
//         // truk_nopol.focus();
//     }
// });

truk_nopol.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        // biaya.focus();
        nomor_container.focus();
    }
});

biaya.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        nomor_container.focus();
    }
});

nomor_container.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        nomor_seal.focus();
    }
});

nomor_seal.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        nomor_bl.focus();
    }
});

nomor_bl.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        surat_pesanan.focus();
    }
});
//#endregion

//#region Table-table

add_item.addEventListener("click", function () {
    if (nomor_do.selectedIndex === 0) {
        alert("Isi DO dulu!");
        return;
    } else {
        const arraydata = [
            nomor_do.options[nomor_do.selectedIndex].value,
            // uraian.value,
            "",
            surat_pesanan.options[surat_pesanan.selectedIndex].text,
            hidden_kodeBarang.value,
            hidden_transTmp.value,
            hidden_qty.value,
        ];
        funcInsertRow(arraydata);
        funcClearDataInput();
        funcClearTableHighlight();
    }
    const confirmation = confirm("Apakah mau menambah DO lagi?");
    if (confirmation === true) {
        surat_pesanan.focus();
    } else {
        isi_button.focus();
    }
});

remove_item.addEventListener("click", function (event) {
    event.preventDefault();
    const highlightedRow = table.querySelector("tr.highlighted");
    if (highlightedRow) {
        table.deleteRow(highlightedRow.rowIndex);
        funcClearTableHighlight();
        alert("Data sudah terhapus!");
    } else {
        alert("Tidak ada data yang dihapus");
    }
});

function funcInsertRow(array) {
    const dataToCheck = array[1];
    let isDataInTable = false;

    if (table.rows.length > 0) {
        const cellValue = table.querySelectorAll("input");

        for (let i = 1; i < cellValue.length; i++) {
            if (cellValue[i].value === dataToCheck) {
                isDataInTable = true;
            }
        }
    }
    if (isDataInTable) {
        alert("Data sudah ada di table");
    } else {
        const newRow = table.insertRow(-1);
        newRow.setAttribute("class", "acs-tr-hover");

        for (let i = 0; i < array.length; i++) {
            const cell = newRow.insertCell(i);
            cell.innerHTML = array[i];
            cell.setAttribute("class", "acs-tr-hover");
            const input = document.createElement("input");
            input.setAttribute("type", "text");
            input.setAttribute("readonly", "true");
            input.setAttribute("value", array[i]);
            input.setAttribute("class", "acs-input-table");
            input.setAttribute("name", "barang" + i + "[]");
            input.style.backgroundColor = table.style.backgroundColor;
            cell.innerHTML = "";
            cell.appendChild(input);
        }
        newRow.addEventListener("click", () => {
            // remove highlight from previously selected row
            funcClearTableHighlight();

            // highlight current row
            newRow.classList.add("highlighted");

            // add the "highlighted" class to all input elements in the row
            let selectedRow = table.querySelector("tr.highlighted");
            let selectedOption = selectedRow.cells[4].querySelector("input");

            // Get the text content of the selected option
            var selectedText = selectedOption.value;

            fetch("/options/getdatadeliveryorder/" + selectedText)
                .then((response) => response.json())
                .then((options) => {
                    // console.log(options);
                    divisi.value = options[0].NamaDivisi;
                    objek.value = options[0].NamaObjek;
                    kelut.value = options[0].NamaKelompokUtama;
                    idtrans.value = options[0].IdTransaksi;
                    kelompok.value = options[0].NamaKelompok;
                    subkelompok.value = options[0].NamaSubKelompok;
                    min_do.value = numeral(options[0].MinKirimDO).format("0,0");
                    min_doSatuan.value = options[0].SatuanJual.trim();
                    max_do.value = numeral(options[0].MaxKirimDO).format("0,0");
                    max_doSatuan.value = options[0].SatuanJual.trim();
                    tgl_mohonDO.value = options[0].TglDO.split(" ")[0];
                    saldo_akhirPrimer.value = numeral(options[0].SaldoPrimer).format("0,0"); //prettier-ignore
                    saldo_akhirSekunder.value = numeral(options[0].SaldoSekunder).format("0,0"); //prettier-ignore
                    saldo_akhirTritier.value = numeral(options[0].SaldoTritier).format("0,0"); //prettier-ignore
                    jumlah_dikeluarkanPrimer.value = numeral(options[0].Primer).format("0,0"); //prettier-ignore
                    jumlah_dikeluarkanPrimerSatuan.value = options[0].satuanPrimer.trim(); // prettier-ignore
                    jumlah_dikeluarkanSekunder.value = numeral(options[0].Sekunder).format("0,0"); //prettier-ignore
                    jumlah_dikeluarkanSekunderSatuan.value = options[0].satuanSekunder.trim(); // prettier-ignore
                    jumlah_dikeluarkanTritier.value = numeral(options[0].Tritier).format("0,0"); //prettier-ignore
                    jumlah_dikeluarkanTritierSatuan.value = options[0].SatuanTritier.trim(); // prettier-ignore
                    no_sp.value = options[0].IDSuratPesanan;
                    customerDO.value = options[0].NamaCust;
                    nama_barang.value = options[0].NamaType;
                    hidden_idTypeDO.value = options[0].IdType;
                    hidden_kodeBarangDO.value = options[0].KodeBarang.trim();
                });
        });
    }
}

function funcClearDataInput() {
    // surat_pesanan.selectedIndex = 0;
    nomor_do.selectedIndex = 0;
    // uraian.value = "";
}

function funcClearTableHighlight() {
    // remove highlight from previously selected row
    const highlightedRow = table.querySelector("tr.highlighted");
    if (highlightedRow) {
        highlightedRow.classList.remove("highlighted");
    }
    divisi.value = "";
    objek.value = "";
    kelut.value = "";
    idtrans.value = "";
    kelompok.value = "";
    subkelompok.value = "";
    min_do.value = "";
    max_do.value = "";
    tgl_mohonDO.value = "";
    saldo_akhirPrimer.value = "";
    saldo_akhirSekunder.value = "";
    saldo_akhirTritier.value = "";
    jumlah_dikeluarkanPrimer.value = "";
    jumlah_dikeluarkanPrimerSatuan.value = "";
    jumlah_dikeluarkanSekunder.value = "";
    jumlah_dikeluarkanSekunderSatuan.value = "";
    jumlah_dikeluarkanTritier.value = "";
    jumlah_dikeluarkanTritierSatuan.value = "";
    no_sp.value = "";
    customerDO.value = "";
    nama_barang.value = "";
}

function loadListStokListJual() {
    table_listStok.clear().draw();
    table_listJual.clear().draw();
    fetch("/options/loadliststokqtydo/" + id_typeQtyDO.value)
        .then((responseliststok) => responseliststok.json())
        .then((liststok) => {
            // console.log(liststok);
            if (liststok.length > 0) {
                liststok.forEach((item) => {
                    table_listStok.row.add([
                        item.NoPIB, // kolom 1
                        numeral(item.Qty_Primer).format("0,0"), // kolom 2
                        numeral(item.Qty_sekunder).format("0,0"), // kolom 3
                        numeral(item.Qty).format("0,0"), // kolom 4
                    ]);
                });

                table_listStok.draw();
            }
            fetch("/options/loadlistjualqtydo/" + idtrans.value)
                .then((responselistjual) => responselistjual.json())
                .then((listjual) => {
                    // console.log(listjual);
                    if (listjual.length > 0) {
                        listjual.forEach((item) => {
                            table_listJual.row.add([
                                item.NoPIB, // kolom 1
                                numeral(item.QtyPrimer).format("0,0"), // kolom 2
                                numeral(item.QtySekunder).format("0,0"), // kolom 3
                                numeral(item.QtyTritier).format("0,0"), // kolom 4
                            ]);
                        });
                        table_listJual.draw();
                    }
                    $("#isiQtyModal").modal("show");
                });
        });
}

isiQty_button.addEventListener("click", function (e) {
    e.preventDefault();
    isiQty_button.disabled = true;
    setTimeout(() => {
        isiQty_button.disabled = false;
    }, 300);
    if (!idtrans.value) {
        Swal.fire({
            icon: "error",
            title: "Terjadi Kesalahan!",
            text: "Pilih Id Transaksi Penjualan Terlebih Dahulu!",
        });
        return;
    }
    no_pibQtyDO.value = "";
    id_typeQtyDO.value = hidden_idTypeDO.value;
    kode_barangQtyDO.value = hidden_kodeBarangDO.value;
    primer_qtyDO.value = 0;
    primer_qtyDO.readOnly = true;
    sekunder_qtyDO.value = 0;
    sekunder_qtyDO.readOnly = true;
    tritier_qtyDO.value = 0;
    tritier_qtyDO.readOnly = true;
    loadListStokListJual();
});

$("#table_listStok tbody").on("click", "tr", function () {
    const data = table_listStok.row(this).data();
    // remove highlight from all rows
    $("#table_listStok tbody tr").removeClass("row-selected");

    // highlight the clicked row
    $(this).addClass("row-selected");
    // console.log("SELECTED:", data);
    no_pibQtyDO.value = data[0];
    primer_qtyDO.value = numeral(data[1]).value();
    primer_qtyDO.readOnly = false;
    sekunder_qtyDO.value = numeral(data[2]).value();
    sekunder_qtyDO.readOnly = false;
    tritier_qtyDO.value = numeral(data[3]).value();
    tritier_qtyDO.readOnly = false;
    if (sekunder_qtyDO.value < 1) {
        sekunder_qtyDO.readOnly = true;
    }
    if (primer_qtyDO.value < 1) {
        primer_qtyDO.readOnly = true;
    }
});

button_isiQtyDO.addEventListener("click", function (e) {
    e.preventDefault();
    if (!no_pibQtyDO.value) {
        Swal.fire({
            icon: "error",
            title: "Terjadi Kesalahan!",
            text: "Pilih Data PIB Terlebih Dahulu!",
        });
        return;
    }
    const selectedRow = table_listStok.row(".row-selected");
    const rowData = selectedRow.data();

    let maxPrimer = numeral(rowData[1]).value();
    let maxSekunder = numeral(rowData[2]).value();
    let maxTritier = numeral(rowData[3]).value();

    if (primer_qtyDO.value > maxPrimer) {
        Swal.fire({
            icon: "error",
            title: "Terjadi Kesalahan!",
            text: "Cek Quantity Primer Yang Anda Inputkan!",
            returnFocus: false,
        });
        primer_qtyDO.focus();
        return;
    }
    if (sekunder_qtyDO.value > maxSekunder) {
        Swal.fire({
            icon: "error",
            title: "Terjadi Kesalahan!",
            text: "Cek Quantity Sekunder Yang Anda Inputkan!",
            returnFocus: false,
        });
        sekunder_qtyDO.focus();
        return;
    }
    if (tritier_qtyDO.value > maxTritier) {
        Swal.fire({
            icon: "error",
            title: "Terjadi Kesalahan!",
            text: "Cek Quantity Tritier Yang Anda Inputkan!",
            returnFocus: false,
        });
        tritier_qtyDO.focus();
        return;
    }

    $.ajax({
        url: "/isi/qtyDO",
        type: "POST",
        data: {
            KodeBarang: kode_barangQtyDO.value,
            IdType: id_typeQtyDO.value,
            NoPIB: no_pibQtyDO.value,
            Primer: primer_qtyDO.value,
            Sekunder: sekunder_qtyDO.value,
            Tritier: tritier_qtyDO.value,
            IdTransaksi: idtrans.value,
            _token: csrfToken,
        },
        success: function (response) {
            if (response.success) {
                Swal.fire({
                    icon: "success",
                    title: "Berhasil",
                    text: "Data berhasil ditambahkan",
                }).then(() => {
                    loadListStokListJual();
                });
            } else if (response.error) {
                Swal.fire({
                    icon: "error",
                    title: "Terjadi Kesalahan",
                    text: response.error,
                });
            }
        },
        error: function (xhr, status, error) {
            console.error("Error adding data: ", error);
        },
    });
});

$("#isiQtyModal").on("hidden.bs.modal", function (event) {
    fetch("/options/qtyDO/" + idtrans.value)
        .then((response) => response.json())
        .then((options) => {
            // console.log(options);
            jumlah_dikeluarkanPrimer.value =
                numeral(options[0].Primer).format("0,0") ?? 0;
            jumlah_dikeluarkanSekunder.value =
                numeral(options[0].Sekunder).format("0,0") ?? 0;
            jumlah_dikeluarkanTritier.value =
                numeral(options[0].Tritier).format("0,0") ?? 0;
        });
});

//#endregion

//#region Button-button

isi_button.addEventListener("click", function (event) {
    event.preventDefault();
    if (proses == 0) {
        proses = 1;
        this.innerHTML = "Proses";
        edit_button.innerHTML = "Batal";
        hapus_button.style.display = "none";
        jenis_pengiriman.focus();
    } else if (proses == 1) {
        if (idtrans.value == "") {
            Swal.fire({
                icon: "error",
                title: "Terjadi Kesalahan!",
                text: "Tidak ada data yang akan diproses!",
                returnFocus: false,
            });
            idtrans.focus();
            return;
        }

        if (min_doSatuan.value == jumlah_dikeluarkanPrimerSatuan.value) {
            if (
                numeral(jumlah_dikeluarkanPrimer.value).value() <
                    numeral(min_do.value).value() ||
                numeral(jumlah_dikeluarkanPrimer.value).value() >
                    numeral(max_do.value).value()
            ) {
                Swal.fire({
                    icon: "error",
                    title: "Terjadi Kesalahan!",
                    text: "Jumlah primer yang dikeluarkan kurang dari MinDo atau melebihi MaxDO!",
                    returnFocus: false,
                });
                jumlah_dikeluarkanPrimer.focus();
                return;
            }
        } else if (
            min_doSatuan.value == jumlah_dikeluarkanSekunderSatuan.value
        ) {
            if (
                numeral(jumlah_dikeluarkanSekunder.value).value() <
                    numeral(min_do.value).value() ||
                numeral(jumlah_dikeluarkanSekunder.value).value() >
                    numeral(max_do.value).value()
            ) {
                Swal.fire({
                    icon: "error",
                    title: "Terjadi Kesalahan!",
                    text: "Jumlah sekunder yang dikeluarkan kurang dari MinDo atau melebihi MaxDO!",
                    returnFocus: false,
                });
                jumlah_dikeluarkanSekunder.focus();
                return;
            }
        } else if (
            min_doSatuan.value == jumlah_dikeluarkanTritierSatuan.value
        ) {
            if (
                numeral(jumlah_dikeluarkanTritier.value).value() <
                    numeral(min_do.value).value() ||
                numeral(jumlah_dikeluarkanTritier.value).value() >
                    numeral(max_do.value).value()
            ) {
                Swal.fire({
                    icon: "error",
                    title: "Terjadi Kesalahan!",
                    text: "Jumlah tritier yang dikeluarkan kurang dari MinDo atau melebihi MaxDO!",
                    returnFocus: false,
                });
                jumlah_dikeluarkanTritier.focus();
                return;
            }
        }

        if (
            (jumlah_dikeluarkanPrimerSatuan.value !== "Null" &&
                numeral(jumlah_dikeluarkanPrimer.value).value() == 0) ||
            (jumlah_dikeluarkanPrimerSatuan.value == "Null" &&
                numeral(jumlah_dikeluarkanPrimer.value).value() !== 0)
        ) {
            Swal.fire({
                icon: "error",
                title: "Terjadi Kesalahan!",
                text: "Cek jumlah primer dan satuan yang dikeluarkan",
                returnFocus: false,
            });
            jumlah_dikeluarkanPrimer.focus();
            return;
        } else if (
            (jumlah_dikeluarkanSekunderSatuan.value !== "Null" &&
                numeral(jumlah_dikeluarkanSekunder.value).value() == 0) ||
            (jumlah_dikeluarkanSekunderSatuan.value == "Null" &&
                numeral(jumlah_dikeluarkanSekunder.value).value() !== 0)
        ) {
            Swal.fire({
                icon: "error",
                title: "Terjadi Kesalahan!",
                text: "Cek jumlah sekunder dan satuan yang dikeluarkan",
                returnFocus: false,
            });
            jumlah_dikeluarkanSekunder.focus();
            return;
        } else if (
            (jumlah_dikeluarkanTritierSatuan.value !== "Null" &&
                numeral(jumlah_dikeluarkanTritier.value).value() == 0) ||
            (jumlah_dikeluarkanTritierSatuan.value == "Null" &&
                numeral(jumlah_dikeluarkanTritier.value).value() !== 0)
        ) {
            Swal.fire({
                icon: "error",
                title: "Terjadi Kesalahan!",
                text: "Cek jumlah tritier dan satuan yang dikeluarkan",
                returnFocus: false,
            });
            jumlah_dikeluarkanTritier.focus();
            return;
        }

        form_suratJalan.submit();
        proses = 0;
        this.innerHTML = "Isi";
        edit_button.innerHTML = "Koreksi";
        hapus_button.style.display = "block";
    } else if (proses == 2) {
        proses = 0;
        this.innerHTML = "Isi";
        edit_button.innerHTML = "Koreksi";
        hapus_button.style.display = "block";
        form_suratJalan.action = "/SuratJalan/" + id_kirimText.value + "/up";
        form_suratJalan.submit();
    } else if (proses == 3) {
        proses = 0;
        this.innerHTML = "Isi";
        edit_button.innerHTML = "Koreksi";
        hapus_button.style.display = "block";
        form_suratJalan.action = "/SuratJalan/" + id_kirimText.value;
        form_suratJalan.submit();
    }
    div_suratJalan.classList.toggle("disabled");
});

edit_button.addEventListener("click", function (event) {
    event.preventDefault();
    if (proses == 0) {
        proses = 2;
        isi_button.innerHTML = "Proses";
        this.innerHTML = "Batal";
        hapus_button.style.display = "none";
        list_sjButton.disabled = false;
        list_sjButton.focus();
    } else {
        proses = 0;
        isi_button.innerHTML = "Isi";
        this.innerHTML = "Koreksi";
        hapus_button.style.display = "block";
        id_kirimSelect.style.display = "none";
        id_kirimText.style.display = "block";
        list_sjButton.disabled = true;
    }
    div_suratJalan.classList.toggle("disabled");
});

hapus_button.addEventListener("click", function (event) {
    event.preventDefault();
    proses = 3;
    isi_button.innerHTML = "Proses";
    edit_button.innerHTML = "Batal";
    this.style.display = "none";
    list_sjButton.disabled = false;
    div_suratJalan.classList.toggle("disabled");
});

list_sjButton.addEventListener("click", function (event) {
    event.preventDefault();
    id_kirimSelect.style.display = "block";
    id_kirimText.style.display = "none";

    fetch("/options/nomorSJ/")
        .then((response) => response.json())
        .then((options) => {
            // console.log(options);
            id_kirimSelect.innerHTML =
                "<option disabled selected value>-- Pilih Nomor Surat Jalan --</option>";
            options.forEach((option) => {
                let optionTag = document.createElement("option");
                optionTag.value = option.IdHeaderKirim;
                optionTag.text = option.IDPengiriman + " - " + option.NamaCust;
                id_kirimSelect.appendChild(optionTag);
            });
        });
    id_kirimSelect.focus();
});

//#endregion
