//#region Document get element by id

let add_button = document.getElementById("add_button");
let cargo_ready = document.getElementById("cargo_ready");
let cargo_readySuratPesanan = document.getElementById(
    "cargo_readySuratPesanan"
);
let customer = document.getElementById("customer");
let delete_button = document.getElementById("delete_button");
let destination_port = document.getElementById("destination_port");
let div_detailSuratPesanan = document.getElementById("div_detailSuratPesanan");
let div_tabelSuratPesanan = document.getElementById("div_tabelSuratPesanan");
let edit_button = document.getElementById("edit_button");
let general_specificationButton = document.getElementById(
    "general_specificationButton"
);
let general_specificationProformaInvoice = document.getElementById(
    "general_specificationProformaInvoice"
);
let general_specificationSuratPesanan = document.getElementById(
    "general_specificationSuratPesanan"
);
let hapus_button = document.getElementById("hapus_button");
let harga_satuan = document.getElementById("harga_satuan");
let isi_button = document.getElementById("isi_button");
let isiGeneralSpecification = 0;
let jenis_barang = document.getElementById("jenis_barang");
let jenis_harga = document.getElementById("jenis_harga");
let kelompok = document.getElementById("kelompok");
let kelompok_utama = document.getElementById("kelompok_utama");
let keterangan_barang = document.getElementById("keterangan_barang");
let ket_qty = document.getElementById("ket_qty");
let kode_barang = document.getElementById("kode_barang");
let lihat_spButton = document.getElementById("lihat_spButton");
let list_view = $("#list_view").DataTable();
let mata_uang = document.getElementById("mata_uang");
let methodForm = document.getElementById("methodForm");
let nama_barang = document.getElementById("nama_barang");
let no_pi = document.getElementById("no_pi");
let no_po = document.getElementById("no_po");
let no_spSelect = document.getElementById("no_spSelect");
let no_spText = document.getElementById("no_spText");
let nomor_urutCetak = document.getElementById("nomor_urutCetak");
let payment_terms = document.getElementById("payment_terms");
let ppn = document.getElementById("ppn");
let proses = 0;
let qty_pesan = document.getElementById("qty_pesan");
let remarks_packing = document.getElementById("remarks_packing");
let remarks_price = document.getElementById("remarks_price");
let remarks_quantity = document.getElementById("remarks_quantity");
let rencana_kirim = document.getElementById("rencana_kirim");
let saldo_awal = document.getElementById("saldo_awal");
let sales = document.getElementById("sales");
let satuan_gudangPrimer = document.getElementById("satuan_gudangPrimer");
let satuan_gudangSekunder = document.getElementById("satuan_gudangSekunder");
let satuan_gudangTritier = document.getElementById("satuan_gudangTritier");
let satuan_jual = document.getElementById("satuan_jual");
// let satuan_jualPI = document.getElementById("satuan_jualPI");
let size_code = document.getElementById("size_code");
let sub_kelompok = document.getElementById("sub_kelompok");
let table_listView = document.getElementById("list_view");
let tgl_pesan = document.getElementById("tgl_pesan");
let tgl_po = document.getElementById("tgl_po");
let update_button = document.getElementById("update_button");
var cekSP;

//#endregion

//#region Load Form

rencana_kirim.valueAsDate = new Date();
tgl_pesan.valueAsDate = new Date();
tgl_po.valueAsDate = new Date();
// Get the month, day, and year from the tgl_pesan
let month = (rencana_kirim.valueAsDate.getMonth() + 1)
    .toString()
    .padStart(2, "0"); // Adding 1 because getMonth() is zero-based
let day = rencana_kirim.valueAsDate.getDate().toString().padStart(2, "0");
let year = rencana_kirim.valueAsDate.getFullYear();
let formattedDate = month + "-" + day + "-" + year;
console.log(rencana_kirim.valueAsDate);
cargo_readySuratPesanan.value = formatDate(rencana_kirim.valueAsDate);
no_spText.focus();
edit_button.style.display = "none";
hapus_button.style.display = "none";
lihat_spButton.style.display = "none";
proses = 1;
billing.selectedIndex = 10;
mata_uang.selectedIndex = 3;
ppn.selectedIndex = 1;
nomor_urutCetak.value = 1;

// disableInputs();

//#endregion

//#region Set Input Filter

setInputFilter(
    document.getElementById("qty_pesan"),
    function (value) {
        return /^-?\d*$/.test(value);
    },
    "Harus diisi dengan angka!"
);

setInputFilter(
    document.getElementById("kode_barang"),
    function (value) {
        return /^-?\d*$/.test(value);
    },
    "Harus diisi dengan angka!"
);

setInputFilter(
    document.getElementById("harga_satuan"),
    function (value) {
        return /^-?\d*[.]?\d*$/.test(value);
    },
    "Must be a floating (real) number"
);

//#endregion

//#region Add Event Listener

isi_button.addEventListener("click", async function (event) {
    event.preventDefault();
    if (no_spText.value.trim() !== "") {
        let no_spData = no_spText.value.replace(/\//g, ".");
        var cekSP = await cek_No_SP(no_spData); // Wait for the result of the async function
    }

    // console.log(checkInputs());
    if (checkInputs()) {
        return; //Pengecekan karakter "|" pada beberapa kolom isian untuk proses data
    }

    if (list_view.length < 0) {
        alert("Surat pesanan harus berisi barang yang dipesan!");
        kelompok_utama.focus();
        return;
    }

    if (jenis_harga.selectedIndex == 0) {
        alert("Jenis harga harus dipilih!");
        jenis_harga.focus();
        return;
    }
    // console.log(checkInputs(inputIds));

    if (proses == 0) {
        //proses isi
        enableInputs();
        hapus_button.innerHTML = "Batal";
        edit_button.style.display = "none";
        this.innerHTML = "Proses";
        tgl_pesan.focus();
        mata_uang.selectedIndex = 3;
        billing.selectedIndex = 10;
        ppn.selectedIndex = 1;
        proses = 1;
    } else if (proses == 1) {
        // console.log(cekSP);
        if (cekSP >= 1) {
            // console.log("nomor sp sudah ada!");
            alert(
                "NOMER SP SUDAH PERNAH ADA.. , KLIK JENIS SURAT PESANANNYA LAGI"
            );
            no_spText.focus();
            return;
        } else {
            funcDatatablesIntoInput();
            form_suratPesanan.submit(); //Untuk Store// Perform the action when cekSP === 0
        }
    } else if (proses == 2) {
        if (cekSP >= 1) {
            let no_spData = no_spText.value.replace(/\//g, ".");
            methodForm.value = "PUT";
            form_suratPesanan.action = "/SuratPesananEkspor/" + no_spData;
            funcDatatablesIntoInput();
            form_suratPesanan.submit(); //Untuk Update
        } else {
            alert("NOMER SP TIDAK DITEMUKAN");
            no_spText.focus();
            return;
        }
    } else if (proses == 3) {
        if (cekSP >= 1) {
            let no_spData = no_spText.value.replace(/\//g, ".");
            methodForm.value = "DELETE";
            form_suratPesanan.action = "/SuratPesananEkspor/" + no_spData;
            form_suratPesanan.submit(); //Untuk Destroy
        } else {
            alert("NOMER SP TIDAK DITEMUKAN");
            no_spText.focus();
            return;
        }
    }
});

edit_button.addEventListener("click", function (event) {
    event.preventDefault();
    enableInputs();
    hapus_button.innerHTML = "Batal";
    isi_button.innerHTML = "Proses";
    edit_button.style.display = "none";
    lihat_spButton.focus();
    proses = 2; //proses edit
});

hapus_button.addEventListener("click", function (event) {
    event.preventDefault();
    if (proses == 0) {
        enableInputs();
        hapus_button.innerHTML = "Batal";
        isi_button.innerHTML = "Proses";
        edit_button.style.display = "none";
        lihat_spButton.focus();
        proses = 3; //proses hapus
    } else {
        disableInputs();
        clearDetailBarang();
        clearHeader();
        list_view.clear().draw();
        this.innerHTML = "Hapus";
        isi_button.innerHTML = "Isi";
        edit_button.style.display = "block";
        isi_button.focus();
        no_spSelect.style.display = "none";
        no_spText.style.display = "inline-block";
        proses = 0; //proses belum ada
    }
});

// no_spSelect.addEventListener("change", function () {
//     if (this.selectedIndex !== 0) {
//         this.setCustomValidity("Tekan Enter!");
//         this.reportValidity();
//     }
// });

// no_spSelect.addEventListener("keypress", function (event) {
//     if (event.key == "Enter") {
//         event.preventDefault();
//         if (this.selectedIndex !== 0) {
//             no_spText.value = this.value;
//             this.disabled = true;
//             const enterEvent = new KeyboardEvent("keypress", { key: "Enter" });
//             no_spText.dispatchEvent(enterEvent);
//         }
//     }
// });

// no_spText.addEventListener("keypress", function (event) {
//     if (event.key === "Enter") {
//         event.preventDefault();
//         if (proses !== 1 && no_spText.value.trim() !== "") {
//             var no_spData = no_spText.value.replace(/\//g, ".");
//             fetch("/SuratPesananEkspor/" + no_spData + "/edit")
//                 .then((response) => response.json())
//                 .then((data) => {
//                     console.log(data);
//                     tgl_pesan.value = data[0][0].Tgl_Pesan.substr(0, 10);
//                     no_po.value = data[0][0].NO_PO;
//                     no_pi.value = data[0][0].NO_PI;
//                     let keteranganSplit = data[0][0].Ket.split(" | ");
//                     cargo_ready.value = keteranganSplit[0] ?? "";
//                     payment_terms.value = keteranganSplit[1] ?? "";
//                     remarks_quantity.value = keteranganSplit[2] ?? "";
//                     remarks_packing.value = keteranganSplit[3] ?? "";
//                     remarks_price.value = keteranganSplit[4] ?? "";
//                     destination_port.value = keteranganSplit[5] ?? "";
//                     mata_uang.selectedIndex = 0;
//                     for (let i = 0; i < mata_uang.length - 1; i++) {
//                         mata_uang.selectedIndex += 1;
//                         if (mata_uang.value === data[0][0].IDMataUang) {
//                             break;
//                         }
//                     }
//                     customer.selectedIndex = 0;
//                     for (let i = 0; i < customer.length - 1; i++) {
//                         customer.selectedIndex += 1;
//                         if (
//                             customer.value.split(" -")[1] === data[0][0].IDCust
//                         ) {
//                             break;
//                         }
//                     }
//                     sales.selectedIndex = 0;
//                     for (let i = 0; i < sales.length - 1; i++) {
//                         sales.selectedIndex += 1;
//                         if (sales.value === data[0][0].IDSales) {
//                             break;
//                         }
//                     }
//                     billing.selectedIndex = 0;
//                     for (let i = 0; i < billing.length - 1; i++) {
//                         billing.selectedIndex += 1;
//                         if (billing.value === data[0][0].IDBill) {
//                             break;
//                         }
//                     }
//                     jenis_harga.selectedIndex = 0;
//                     for (let i = 0; i < jenis_harga.length - 1; i++) {
//                         jenis_harga.selectedIndex += 1;
//                         if (jenis_harga.value === data[0][0].JenisHargaBarang) {
//                             break;
//                         }
//                     }
//                     for (let i = 0; i < data[1].length; i++) {
//                         let uraianPesananArray =
//                             data[1][i].UraianPesanan.split(" | ");
//                         console.log(data[1][i].UraianPesanan.split(" | ")[0]);
//                         const arraydata = [
//                             data[1][i].NamaBarang,
//                             data[1][i].NamaJnsBrg,
//                             formatangka(parseFloat(data[1][i].HargaSatuan)),
//                             formatangka(parseFloat(data[1][i].Qty)),
//                             data[1][i].Satuan,
//                             data[1][i].UraianPesanan.split(" | ")[0],
//                             data[1][i].UraianPesanan.split(" | ")[1],
//                             data[1][i].UraianPesanan.split(" | ")[2],
//                             data[1][i].TglRencanaKirim.substr(0, 10),
//                             data[1][i].PPN,
//                             data[1][i].IDJnsBarang,
//                             data[1][i].KodeBarang,
//                             data[1][i].IDBarang,
//                             data[1][i].IDPesanan,
//                             data[1][i].UraianPesanan.split(" | ")[3],
//                         ];
//                         // Insert array into a new row
//                         funcInsertRow(arraydata);
//                     }
//                 });
//             tgl_pesan.focus();
//             if (proses == 3) {
//                 isi_button.focus();
//             }
//             if (proses == 1) {
//                 no_po.focus();
//             }
//         }
//     }
// });

no_spText.addEventListener("keyup", function () {
    no_pi.value = no_spText.value;
});

general_specificationButton.addEventListener("click", function (event) {
    event.preventDefault();
    general_specificationSuratPesanan.value =
        general_specificationProformaInvoice.value;
});

rencana_kirim.addEventListener("change", function () {
    // Get the month, day, and year from the tgl_pesan
    // month = (rencana_kirim.valueAsDate.getMonth() + 1)
    //     .toString()
    //     .padStart(2, "0"); // Adding 1 because getMonth() is zero-based
    // day = rencana_kirim.valueAsDate.getDate().toString().padStart(2, "0");
    // year = rencana_kirim.valueAsDate.getFullYear();
    // formattedDate = month + "-" + day + "-" + year;
    cargo_readySuratPesanan.value = formatDate(this.valueAsDate);
});

add_button.addEventListener("click", function (event) {
    event.preventDefault();
    if (kode_barang.value == "") {
        alert("Tidak Ada Barang yang Ditambahkan!");
        kelompok_utama.focus();
        return;
    }
    if (parseFloat(qty_pesan.value) < 0 || qty_pesan.value == "") {
        alert("Koreksi jumlah barang!");
        qty_pesan.focus();
        return;
    }
    if (jenis_barang.selectedIndex === -1 || jenis_barang.selectedIndex === 0) {
        alert("Pilih jenis barang!");
        jenis_barang.focus();
        return;
    }
    if (harga_satuan.value < 0 || harga_satuan.value == "") {
        alert("Harga satuan harap diisi");
        harga_satuan.focus();
        return;
    }
    const arraydata = [
        nomor_urutCetak.value,
        nama_barang.options[nama_barang.selectedIndex].text,
        jenis_barang.options[jenis_barang.selectedIndex].text,
        formatangka(parseFloat(harga_satuan.value)),
        formatangka(parseInt(qty_pesan.value)),
        satuan_jual.options[satuan_jual.selectedIndex].text,
        // satuan_jualPI.options[satuan_jualPI.selectedIndex].text,
        general_specificationProformaInvoice.value,
        general_specificationSuratPesanan.value,
        keterangan_barang.value,
        size_code.value,
        rencana_kirim.value,
        ppn.value,
        jenis_barang.value,
        kode_barang.value,
        nama_barang.value,
        "",
        cargo_readySuratPesanan.value,
        ket_qty.value,
    ];
    funcInsertRow(arraydata);
    clearDetailBarang();
    let confirmation = confirm("Apakah ingin menambah barang?");

    if (confirmation) {
        kelompok_utama.focus();
    } else {
        isi_button.focus();
    }
});

update_button.addEventListener("click", function (event) {
    event.preventDefault();
    let selectedRow = $("#list_view tbody tr.selected");

    if (selectedRow.length > 0) {
        let table = $("#list_view").DataTable();
        let rowData = table.row(selectedRow).data();
        console.log(rowData);
        // Update the values in the rowData array
        rowData[0] = nomor_urutCetak.value;
        rowData[1] = nama_barang.options[nama_barang.selectedIndex].text;
        rowData[2] = jenis_barang.options[jenis_barang.selectedIndex].text;
        rowData[3] = formatangka(parseFloat(harga_satuan.value));
        rowData[4] = formatangka(parseInt(qty_pesan.value));
        rowData[5] = satuan_jual.options[satuan_jual.selectedIndex].text;
        // rowData[6] = satuan_jualPI.options[satuan_jualPI.selectedIndex].text;
        rowData[6] = general_specificationProformaInvoice.value;
        rowData[7] = general_specificationSuratPesanan.value;
        rowData[8] = keterangan_barang.value;
        rowData[9] = size_code.value;
        rowData[10] = rencana_kirim.value;
        rowData[11] = ppn.value;
        rowData[12] = jenis_barang.value;
        rowData[13] = kode_barang.value;
        rowData[14] = nama_barang.value;
        rowData[16] = cargo_readySuratPesanan.value;
        rowData[17] = ket_qty.value;

        // Update the data in the DataTable
        table.row(selectedRow).data(rowData).draw();
        // remove highlight from selected row
        selectedRow.toggleClass("selected");
        // clear input fields
        clearDetailBarang();
        // Update the table display
        $("#list_view").DataTable().draw();
    }
});

delete_button.addEventListener("click", function (event) {
    event.preventDefault();
    proses = 1; //karena ini pasti create
    let selectedRow = $("#list_view tbody tr.selected");
    // console.log(selectedRow.find("td").eq(17).text() !== "");
    let table = $("#list_view").DataTable();
    if (proses == 1) {
        if (selectedRow.length > 0) {
            let rowIndex = table.row(selectedRow).index();

            // Remove the selected row from the DataTable
            table.row(selectedRow).remove().draw();
            alert("Data sudah terhapus dari tabel!");
        } else {
            alert("Tidak ada data yang dihapus");
        }
    } else if (proses == 2) {
        if (selectedRow.length > 0) {
            if (selectedRow.find("td").eq(17).text() !== "") {
                // console.log(input[7].value);
                let confirmation = confirm(
                    "Anda yakin akan menghapus data ini dari server?"
                );

                if (confirmation) {
                    fetch(
                        "/deleteDetailBarangEksport/" +
                            selectedRow.find("td").eq(17).text()
                    )
                        .then((response) => response.json())
                        .then((data) => {
                            alert(data); //Id Pesanan xxxx sudah dihapus dari database!
                        });
                    table.row(selectedRow).remove().draw();
                } else {
                    return;
                }
            } else {
                table.row(selectedRow).remove().draw();
                alert("Data sudah terhapus dari tabel!");
            }
        } else {
            alert("Tidak ada data yang dihapus");
        }
    }
    clearDetailBarang();
});

lihat_spButton.addEventListener("click", function (event) {
    event.preventDefault();
    // console.log(proses);
    if (proses <= 1) {
        return;
    } else if (proses > 1) {
        if (no_spSelect.style.display == "inline-block") {
            no_spSelect.style.display = "none";
            no_spText.style.display = "inline-block";
            no_spText.focus();
        } else if (no_spSelect.style.display == "none") {
            no_spSelect.style.display = "inline-block";
            no_spText.style.display = "none";
            no_spSelect.focus();
        }
    }
});

kelompok_utama.addEventListener("change", function () {
    if (this.selectedIndex !== 0) {
        this.setCustomValidity("Tekan Enter!");
        this.reportValidity();
    }
});

kelompok_utama.addEventListener("keypress", function (event) {
    // console.log(event.key);
    if (event.key == "Enter") {
        event.preventDefault();
        if (this.selectedIndex !== 0) {
            fetch("/options/spekspor/kelompok/" + this.value)
                .then((response) => response.json())
                .then((data) => {
                    // console.log(data);
                    kelompok.innerHTML =
                        "<option disabled selected value>-- Pilih Kelompok --</option>";
                    data.forEach((option) => {
                        let optionTag = document.createElement("option");
                        optionTag.value = option.IdKelompok;
                        optionTag.text = option.NamaKelompok.trim();
                        kelompok.appendChild(optionTag);
                    });
                    kelompok.focus();
                });
        }
    }
    // console.log(this.value);
});

kelompok.addEventListener("change", function () {
    if (this.selectedIndex !== 0) {
        this.setCustomValidity("Tekan Enter!");
        this.reportValidity();
    }
});

kelompok.addEventListener("keypress", function (event) {
    // console.log(event.key);
    if (event.key == "Enter") {
        event.preventDefault();
        if (this.selectedIndex !== 0) {
            fetch("/options/spekspor/subKelompok/" + this.value)
                .then((response) => response.json())
                .then((data) => {
                    // console.log(data);
                    sub_kelompok.innerHTML =
                        "<option disabled selected value>-- Pilih Sub Kelompok --</option>";
                    data.forEach((option) => {
                        let optionTag = document.createElement("option");
                        optionTag.value = option.IDCorak;
                        optionTag.text = option.Corak;
                        sub_kelompok.appendChild(optionTag);
                    });
                    sub_kelompok.focus();
                });
        }
    }
});

sub_kelompok.addEventListener("change", function () {
    if (this.selectedIndex !== 0) {
        this.setCustomValidity("Tekan Enter!");
        this.reportValidity();
    }
});

sub_kelompok.addEventListener("keypress", function (event) {
    // console.log(event.key);
    if (event.key == "Enter") {
        event.preventDefault();
        if (this.selectedIndex !== 0) {
            fetch("/options/spekspor/namaBarang/" + this.value)
                .then((response) => response.json())
                .then((data) => {
                    // console.log(data);
                    nama_barang.innerHTML =
                        "<option disabled selected value>-- Pilih Nama Barang --</option>";
                    data.forEach((option) => {
                        let optionTag = document.createElement("option");
                        optionTag.value = option.IDBarang;
                        optionTag.text =
                            option.KodeBarang + " | " + option.NamaBarang;
                        nama_barang.appendChild(optionTag);
                    });
                    nama_barang.focus();
                });
        }
    }
});

nama_barang.addEventListener("change", function () {
    if (this.selectedIndex !== 0) {
        this.setCustomValidity("Tekan Enter!");
        this.reportValidity();
    }
});

nama_barang.addEventListener("keypress", function (event) {
    // console.log(event.key);
    if (event.key == "Enter") {
        event.preventDefault();
        if (this.selectedIndex !== 0) {
            IsiSatuanInv(this.value);
        }
        jenis_barang.focus();
    }
});

kode_barang.addEventListener("keypress", function (event) {
    if (event.key == "Enter") {
        event.preventDefault();
        if (this.value == "") {
            this.setCustomValidity("Tidak boleh kosong!");
            this.reportValidity();
        } else {
            let kodeBarang9digit;
            kodeBarang9digit = document.getElementById("kode_barang");
            // console.log(kodeBarang9digit.value);
            // alert('Kode barang dienter');
            if (kodeBarang9digit.value.length < 9) {
                // alert("kode barang tidak sesuai");
                kodeBarang9digit.value = kode_barang.value.padStart(9, "0");
                // console.log(kodeBarang9digit.value);
            }
            kode_barang.value = kodeBarang9digit.value;
            fetch("/options/spekspor/kodeBarang/" + this.value.trim())
                .then((response) => response.json())
                .then((data) => {
                    console.log(data, data.length);
                    for (let i = 0; i < kelompok_utama.options.length; i++) {
                        const option = kelompok_utama.options[i];
                        if (option.value === data[0].IdKelompokUtama) {
                            option.selected = true;
                            break;
                        }
                    }
                    kelompok.innerHTML = "";
                    sub_kelompok.innerHTML = "";
                    nama_barang.innerHTML = "";

                    //add option kelompok sampai nama barang
                    let optionKelompok = document.createElement("option");
                    optionKelompok.value = data[0].IdKelompok;
                    optionKelompok.text = data[0].NamaKelompok;
                    kelompok.appendChild(optionKelompok);
                    let optionSubKelompok = document.createElement("option");
                    optionSubKelompok.value = data[0].IdSubkelompok;
                    optionSubKelompok.text = data[0].NamaSubKelompok;
                    sub_kelompok.appendChild(optionSubKelompok);
                    let optionNamaBarang = document.createElement("option");
                    optionNamaBarang.value = data[0].IdType;
                    optionNamaBarang.text = data[0].NamaType;
                    nama_barang.appendChild(optionNamaBarang);

                    IsiSatuanInv(nama_barang.value);
                    jenis_barang.focus();
                });
        }
    }
});

jenis_barang.addEventListener("change", function () {
    if (this.selectedIndex !== 0) {
        this.setCustomValidity("Tekan Enter!");
        this.reportValidity();
    }
});

//#endregion

//#region function-function

function enterToTab(event) {
    const target = event.target;
    const keyCode = event.keyCode || event.which;

    if (keyCode === 13) {
        event.preventDefault();
        const inputs = Array.from(
            document.querySelectorAll("input, select, textarea")
        );
        const currentIndex = inputs.indexOf(target);

        if (currentIndex !== -1) {
            const nextIndex = currentIndex + 1;
            if (nextIndex < inputs.length) {
                inputs[nextIndex].focus();
            } else {
                // If we reached the last input field, you can also choose to focus on the first one instead
                inputs[0].focus();
            }
        }
    }
}

function disableInputs() {
    const disabledDivs = document.querySelectorAll(".toggle-group");

    disabledDivs.forEach((disabledDiv) => {
        const inputs = disabledDiv.querySelectorAll("input, select, textarea");

        inputs.forEach((input) => {
            input.disabled = true;
        });

        disabledDiv.classList.add("disabled");
    });
}

function enableInputs() {
    const disabledDivs = document.querySelectorAll(".toggle-group");

    disabledDivs.forEach((disabledDiv) => {
        const inputs = disabledDiv.querySelectorAll("input, select, textarea");

        inputs.forEach((input) => {
            input.disabled = false;
        });

        disabledDiv.classList.remove("disabled");
    });
}

async function cek_No_SP(no_sp) {
    try {
        const response = await fetch("/cekNoSPEkspor/" + no_sp);
        const data = await response.json();
        // console.log(data[0].Jumlah);
        if (data[0].Jumlah >= 1) {
            return 1;
        } else {
            return 0;
        }
    } catch (error) {
        console.error("Error fetching data:", error);
        return -1; // Handle any error case appropriately
    }
}

function containsPipe(inputString) {
    return inputString.includes("|");
}

function checkInputs() {
    let hasInvalidInput = false;
    let inputIds = [
        "payment_terms",
        "cargo_ready",
        "remarks_packing",
        "remarks_price",
        "remarks_quantity",
        "ket_qty",
    ];
    inputIds.forEach((inputId) => {
        const inputValue = document.getElementById(inputId).value;
        if (containsPipe(inputValue)) {
            hasInvalidInput = true;
            alert(`Invalid input: "${inputValue}" contains the "|" character.`);
            document.getElementById(inputId).focus();
        }
    });
    if (hasInvalidInput) {
        return true;
    } else {
        return false;
    }
}

function IsiSatuanInv(idtype) {
    fetch("/options/spekspor/isiSatuan/" + idtype)
        .then((response) => response.json())
        .then((data) => {
            // console.log(data);
            kode_barang.value = data[0].KodeBarang;
            satuan_gudangPrimer.value = data[0].satPrimer.trim();
            satuan_gudangSekunder.value = data[0].satSekunder.trim();
            satuan_gudangTritier.value = data[0].nama_satuan.trim();
            satuan_jual.selectedIndex = 0;
            // satuan_jualPI.selectedIndex = 0;
            if (
                kelompok_utama.value == "0406" ||
                kelompok_utama.value == "0405" ||
                kelompok_utama.value == "0700"
            ) {
                for (let i = 0; i < satuan_jual.length - 1; i++) {
                    satuan_jual.selectedIndex += 1;
                    if (
                        satuan_jual.options[satuan_jual.selectedIndex].text ===
                        satuan_gudangSekunder.value
                    ) {
                        break;
                    }
                }
            } else {
                for (let i = 0; i < satuan_jual.length - 1; i++) {
                    satuan_jual.selectedIndex += 1;
                    if (
                        satuan_jual.options[satuan_jual.selectedIndex].text ===
                        satuan_gudangPrimer.value
                    ) {
                        break;
                    }
                }
            }
        });
}

function funcInsertRow(array) {
    let isDataInTable = false;
    const table = $("#list_view").DataTable();
    // console.log(table.rows.length);
    if (table.data().length > 0) {
        table.rows().every(function () {
            const rowData = this.data();
            const columnValue = rowData[11]; // Assuming you want to compare the second column
            // Compare the column value with your desired value
            if (columnValue === kode_barang.value) {
                // Perform your desired action here
                isDataInTable = true;
            }
        });
    }
    // table.clear();
    if (isDataInTable) {
        alert("Data barang sudah ada");
        table_listView.focus();
    } else {
        table.row.add(array);
        table.draw();
        $("#list_view tbody").off("click", "tr");
        $("#list_view tbody").on("click", "tr", function () {
            let checkSelectedRows = $("#list_view tbody tr.selected");

            if (checkSelectedRows.length > 0) {
                // Remove "selected" class from previously selected rows
                checkSelectedRows.removeClass("selected");
            }
            $(this).toggleClass("selected");
            let selectedRows = table.rows(".selected").data().toArray();
            // console.log(selectedRows);
            nomor_urutCetak.value = selectedRows[0][0];
            harga_satuan.value = parseFloat(
                selectedRows[0][3].replace(/,/g, "")
            );
            qty_pesan.value = parseInt(selectedRows[0][4].replace(/,/g, ""));
            satuan_jual.selectedIndex = 0;
            for (let i = 0; i < satuan_jual.length; i++) {
                // console.log(satuanJual.selectedIndex);
                satuan_jual.selectedIndex += 1;
                if (
                    satuan_jual.options[satuan_jual.selectedIndex].text ===
                    selectedRows[0][5].trim()
                ) {
                    break;
                }
            }
            // satuan_jualPI.selectedIndex = 0;
            // for (let i = 0; i < satuan_jualPI.length; i++) {
            //     // console.log(satuanJual.selectedIndex);
            //     satuan_jualPI.selectedIndex += 1;
            //     if (
            //         satuan_jualPI.options[satuan_jualPI.selectedIndex].text ===
            //         selectedRows[0][6].trim()
            //     ) {
            //         break;
            //     }
            // }
            general_specificationProformaInvoice.value = selectedRows[0][6];
            general_specificationSuratPesanan.value = selectedRows[0][7];
            keterangan_barang.value = selectedRows[0][8];
            size_code.value = selectedRows[0][9];
            rencana_kirim.value = selectedRows[0][10];
            ppn.selectedIndex = 0;
            for (let i = 0; i < ppn.length; i++) {
                // console.log(satuanJual.selectedIndex);
                ppn.selectedIndex += 1;
                if (
                    ppn.options[ppn.selectedIndex].text ===
                    selectedRows[0][11].trim()
                ) {
                    break;
                }
            }
            for (let i = 0; i < jenis_barang.length; i++) {
                console.log(
                    jenis_barang.options[jenis_barang.selectedIndex].text,
                    selectedRows[0][2].trim()
                );
                jenis_barang.selectedIndex += 1;
                if (
                    jenis_barang.options[jenis_barang.selectedIndex].text ===
                    selectedRows[0][2].trim()
                ) {
                    break;
                }
            }
            let optionNamaBarang = document.createElement("option");
            optionNamaBarang.value = selectedRows[0][14];
            optionNamaBarang.text = selectedRows[0][1];
            nama_barang.appendChild(optionNamaBarang);
            kode_barang.value = selectedRows[0][13];
            funcDisplayDataBrg(selectedRows[0][14]);
            cargo_readySuratPesanan.value = selectedRows[0][16];
            ket_qty.value = selectedRows[0][17];
            // funcTampilInv(selectedRows[0][1]);
        });
    }
}

function funcDisplayDataBrg(idtype) {
    // console.log(kodeBarangParameter);
    fetch("/displaybarangekspor/" + idtype)
        .then((response) => response.json())
        .then((data) => {
            // console.log(data);
            let optionTagKelompok = document.createElement("option");
            let optionTagSubKelompok = document.createElement("option");
            const optionKelompokUtama = kelompok_utama.options;

            for (let i = 0; i < optionKelompokUtama.length; i++) {
                const option = optionKelompokUtama[i];
                if (option.value === data[0].IdKelompokUtama) {
                    option.selected = true;
                    break;
                }
            }
            //disable dulu karena ndak
            // kelompok.disabled = true;
            // sub_kelompok.disabled = true;
            // nama_barang.disabled = true;
            //ngisi optionnya hehe
            optionTagKelompok.value = data[0].IdKelompok;
            optionTagKelompok.text = data[0].NamaKelompok;
            optionTagSubKelompok.value = data[0].IdSubkelompok;
            optionTagSubKelompok.text = data[0].NamaSubKelompok;
            kelompok.appendChild(optionTagKelompok);
            sub_kelompok.appendChild(optionTagSubKelompok);
            //ngisi sisanya hehe
            satuan_gudangPrimer.value = data[0].satPrimer.trim();
            satuan_gudangSekunder.value = data[0].satSekunder.trim();
            satuan_gudangTritier.value = data[0].nama_satuan.trim();
        });
}

function formatangka(objek) {
    // console.log(objek); // Output the provided number for debugging purposes

    // Check if the number has decimal places
    if (Number.isInteger(objek)) {
        return objek.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    } else {
        let parts = objek.toFixed(4).split(".");
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return parts.join(".").replace(/\.?0+$/, "");
    }
}

function clearDetailBarang() {
    kelompok_utama.selectedIndex = 0;
    kelompok.innerHTML = "";
    sub_kelompok.innerHTML = "";
    nama_barang.innerHTML = "";
    kode_barang.value = "";
    jenis_barang.selectedIndex = 0;
    qty_pesan.value = "";
    harga_satuan.value = "";
    general_specificationProformaInvoice.value = "";
    general_specificationSuratPesanan.value = "";
    keterangan_barang.value = "";
    size_code.value = "";
    ppn.selectedIndex = 1;
    satuan_jual.selectedIndex = 0;
    // satuan_jualPI.selectedIndex = 0;
    satuan_gudangPrimer.value = "";
    satuan_gudangSekunder.value = "";
    satuan_gudangTritier.value = "";
    rencana_kirim.valueAsDate = new Date();
    nomor_urutCetak.value =
        Math.max(...list_view.rows().column(0).data().toArray().map(Number)) +
        1;

    cargo_readySuratPesanan.value = formatDate(rencana_kirim.valueAsDate);
    ket_qty.value = "";
}

function clearHeader() {
    tgl_pesan.valueAsDate = new Date();
    no_spSelect.selectedIndex = 0;
    no_spText.value = "";
    no_pi.value = "";
    no_po.value = "";
    tgl_po.valueAsDate = new Date();
    jenis_harga.selectedIndex = 0;
    mata_uang.selectedIndex = 0;
    customer.selectedIndex = 0;
    sales.selectedIndex = 0;
    billing.selectedIndex = 0;
    cargo_ready.value = "";
    destination_port.value = "";
    payment_terms.value = "";
    remarks_quantity.value = "";
    remarks_packing.value = "";
    remarks_price.value = "";
}

function funcDatatablesIntoInput() {
    let dataArray = [];
    let value = "";
    dataArray = list_view.data().toArray();
    // console.log(dataArray);
    // Create a hidden input element
    for (let i = 0; i < dataArray.length; i++) {
        let row = dataArray[i];
        for (let j = 0; j < dataArray[i].length; j++) {
            value = "";
            if (j === 3 || j === 4) {
                value = row[j].replace(/,/g, "").trim().replace(/\s+/g, " ");
            } else {
                value = row[j].trim().replace(/[^\S\r\n]+/g, " ");
            }
            let hiddenInput = document.createElement("input");
            hiddenInput.type = "hidden";
            hiddenInput.name = "barang" + j + "[]"; // Set the name attribute as desired
            hiddenInput.multiple = true;
            hiddenInput.value = value;
            // Append the hidden input to the document body or any other element
            form_suratPesanan.appendChild(hiddenInput);
        }
    }
}

function formatDate(date) {
    var day = date.getDate();
    var month = date.toLocaleString("id-ID", { month: "long" });
    var year = date.getFullYear();
    return day + " " + month + " " + year;
}

//#endregion
