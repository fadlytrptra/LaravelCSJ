//#region get element by id
let addButton = document.getElementById("add_button");
let beratIndexInner = document.getElementById("berat_indexInner");
let beratIndexKarung = document.getElementById("berat_indexKarung");
let beratIndexKertas = document.getElementById("berat_indexKertas");
let beratIndexLami = document.getElementById("berat_indexLami");
let beratInner = document.getElementById("berat_inner");
let beratInnerMeter = document.getElementById("berat_innerMeter");
let beratKarung = document.getElementById("berat_karung");
let beratKarungMeter = document.getElementById("berat_karungMeter");
let beratKertas = document.getElementById("berat_kertas");
let beratKertasMeter = document.getElementById("berat_kertasMeter");
let beratLami = document.getElementById("berat_lami");
let beratLamiMeter = document.getElementById("berat_lamiMeter");
let beratStandard = document.getElementById("berat_standard"); //untuk div berat standard (KGM)
let beratStandardMeter = document.getElementById("berat_standardMeter"); //untuk div berat standard (MTR)
let beratStandardTotal = document.getElementById("berat_standardTotal");
let beratStandardTotalMeter = document.getElementById(
    "berat_standardTotalMeter"
);
let biayaLain = document.getElementById("biaya_lain");
let deleteButton = document.getElementById("delete_button");
let enterKodeBarang = document.getElementById("enter_kodeBarang");
let fakturPjk = document.getElementById("faktur_pjk");
let hargaSatuan = document.getElementById("harga_satuan");
let indexInner = document.getElementById("index_inner");
let indexKarung = document.getElementById("index_karung");
let indexKertas = document.getElementById("index_kertas");
let indexLami = document.getElementById("index_lami");
let jenisBarang = document.getElementById("jenis_brg");
let jenisBayar = document.getElementById("jenis_bayar");
let jenisSp = document.getElementById("jenis_sp");
let kategori = document.getElementById("kategori");
let kategoriUtama = document.getElementById("kategori_utama"); // if '011' then checkBS()
let keterangan = document.getElementById("keterangan");
let kodeBarang = document.getElementById("kode_barang");
let kodeStJual;
let kodeStPrim;
let kodeStSek;
let kodeStTri;
let listSales = document.getElementById("list_sales");
let listView = document.getElementById("list_view");
let mataUang = document.getElementById("mata_uang");
let namaBarang = document.getElementById("nama_barang");
let noPi = document.getElementById("no_pi");
let noPo = document.getElementById("no_po");
let ppn = document.getElementById("ppn");
let qtyPesan = document.getElementById("qty_pesan");
let rencanaKirim = document.getElementById("rencana_kirim");
let satuanJual = document.getElementById("satuan_jual");
let satuanPrimer = document.getElementById("satuan_primer");
let satuanSekunder = document.getElementById("satuan_sekunder");
let satuanTritier = document.getElementById("satuan_tritier");
let subKategori = document.getElementById("sub_kategori");
let submitButton = document.getElementById("submit_button");
let syaratBayar = document.getElementById("syarat_bayar");
let tglPesan = document.getElementById("tgl_pesan");
let tglPo = document.getElementById("tgl_po");
let totalCost = document.getElementById("total_cost");
let updateButton = document.getElementById("update_button");
//#endregion

//#region input filter
//Penjelasan setinputfilter function: https://jsfiddle.net/KarmaProd/tgn9d1uL/4/
function setInputFilter(textbox, inputFilter, errMsg) {
    [
        "input",
        "keydown",
        "keyup",
        "mousedown",
        "mouseup",
        "select",
        "contextmenu",
        "drop",
        "focusout",
    ].forEach(function (event) {
        textbox.addEventListener(event, function (e) {
            if (inputFilter(this.value)) {
                // Accepted value
                if (["keydown", "mousedown", "focusout"].indexOf(e.type) >= 0) {
                    this.classList.remove("input-error");
                    this.setCustomValidity("");
                }
                this.oldValue = this.value;
                this.oldSelectionStart = this.selectionStart;
                this.oldSelectionEnd = this.selectionEnd;
            } else if (this.hasOwnProperty("oldValue")) {
                // Rejected value - restore the previous one
                this.classList.add("input-error");
                this.setCustomValidity(errMsg);
                this.reportValidity();
                this.value = this.oldValue;
                this.setSelectionRange(
                    this.oldSelectionStart,
                    this.oldSelectionEnd
                );
            } else {
                // Rejected value - nothing to restore
                this.value = "";
            }
        });
    });
}

setInputFilter(
    document.getElementById("qty_pesan"),
    function (value) {
        return /^-?\d*$/.test(value);
    },
    "Harus diisi dengan angka!"
);
setInputFilter(
    document.getElementById("harga_satuan"),
    function (value) {
        return /^-?\d*$/.test(value);
    },
    "Harus diisi dengan angka!"
);
setInputFilter(
    document.getElementById("syarat_bayar"),
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
    document.getElementById("berat_karung"),
    function (value) {
        return /^-?\d*[.]?\d*$/.test(value);
    },
    "Must be a floating (real) number"
);
setInputFilter(
    document.getElementById("berat_inner"),
    function (value) {
        return /^-?\d*[.]?\d*$/.test(value);
    },
    "Must be a floating (real) number"
);
setInputFilter(
    document.getElementById("berat_lami"),
    function (value) {
        return /^-?\d*[.]?\d*$/.test(value);
    },
    "Must be a floating (real) number"
);
setInputFilter(
    document.getElementById("berat_kertas"),
    function (value) {
        return /^-?\d*[.]?\d*$/.test(value);
    },
    "Must be a floating (real) number"
);
//#endregion

//#region load form

rencanaKirim.valueAsDate = new Date();

//#endregion

jenisBarang.addEventListener("change", function () {
    if (ppn.value === "EXCLUDE") {
        return;
    }
    kodeBarang.readOnly = false;
    kodeBarang.focus();
    enterKodeBarang.style.display = "block";
    satuanPrimer.value = "";
    satuanSekunder.value = "";
    satuanTritier.value = "";
    satuanJual.selectedIndex = "0";
    kategoriUtama.selectedIndex = "0";
    kategori.innerHTML = "";
    subKategori.innerHTML = "";
    namaBarang.innerHTML = "";
});

//#region enter-enter
noPo.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        tglPo.focus();
    }
});

noPi.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        listSales.focus();
    }
});

mataUang.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        jenisBayar.focus();
    }
});

syaratBayar.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        fakturPjk.focus();
    }
});

fakturPjk.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        keterangan.focus();
    }
});

keterangan.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        jenisBarang.focus();
    }
});

qtyPesan.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        hargaSatuan.focus();
    }
});

hargaSatuan.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        satuanJual.focus();
    }
});

satuanJual.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        rencanaKirim.focus();
    }
});

rencanaKirim.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        beratKarung.focus();
    }
});

beratKarung.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        beratInner.focus();
    }
});

beratInner.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        beratLami.focus();
    }
});

beratLami.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        beratKertas.focus();
    }
});

beratKertas.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        indexKarung.focus();
    }
});

indexKarung.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        indexInner.focus();
    }
});

indexInner.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        indexLami.focus();
    }
});

indexLami.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        indexKertas.focus();
    }
});

indexKertas.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        biayaLain.focus();
    }
});

beratIndexKarung.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        beratIndexInner.focus();
    }
});

beratIndexInner.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        beratIndexLami.focus();
    }
});

beratIndexLami.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        beratIndexKertas.focus();
    }
});

beratIndexKertas.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        biayaLain.focus();
    }
});

biayaLain.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        addButton.focus();
    }
});
//#endregion

kodeBarang.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        let kodeBarang9digit;
        kodeBarang9digit = document.getElementById("kode_barang");
        // console.log(kodeBarang9digit.value);
        // alert('Kode barang dienter');
        if (kodeBarang9digit.value.length < 9) {
            // alert("kode barang tidak sesuai");
            kodeBarang9digit.value = kodeBarang.value.padStart(9, "0");
            // console.log(kodeBarang9digit.value);
        }
        kodeBarang.value = kodeBarang9digit.value;
        fetch("/satuan1/" + kodeBarang.value)
            .then((response) => response.json())
            .then((data) => {
                // console.log(data[0]);
                const optionKategoriUtama = kategoriUtama.options;
                for (let i = 0; i < optionKategoriUtama.length; i++) {
                    const option = optionKategoriUtama[i];
                    if (option.value === data[0].no_kat_utama) {
                        option.selected = true;
                        break;
                    }
                }
                //disable dulu karena ndak ada isi optionnya hehe
                kategori.disabled = true;
                subKategori.disabled = true;
                namaBarang.disabled = true;
                //add option kategori sampai nama barang
                let optionKategori = document.createElement("option");
                optionKategori.value = data[0].no_kategori;
                optionKategori.text = data[0].nama_kategori;
                kategori.appendChild(optionKategori);
                let optionSubKategori = document.createElement("option");
                optionSubKategori.value = data[0].no_sub_kategori;
                optionSubKategori.text = data[0].nama_sub_kategori;
                subKategori.appendChild(optionSubKategori);
                let optionNamaBarang = document.createElement("option");
                optionNamaBarang.value = data[0].KodeBarang;
                optionNamaBarang.text = data[0].NAMA_BRG;
                namaBarang.appendChild(optionNamaBarang);
                //Isi data satuan
                const optionSatuanJual = satuanJual.options;
                for (let i = 0; i < optionSatuanJual.length; i++) {
                    const option = optionSatuanJual[i];
                    // console.log(option);
                    if (option.value === data[0].NO_SATUAN_UMUM) {
                        option.selected = true;
                        break;
                    }
                }
                ppn.value = "EXCLUDE";
                ppn.readOnly = true;
                rencanaKirim.valueAsDate = new Date();
                satuanPrimer.value = data[0].SatPrimer;
                satuanSekunder.value = data[0].SatSekunder;
                satuanTritier.value = data[0].Nama_satuan;
                funcBeratStandard(kategoriUtama, kodeBarang.value);
            });
        qtyPesan.focus();
    }
});

kategoriUtama.addEventListener("change", function () {
    // Code to retrieve options for the second select input based on the selected value of the first select input
    let kategoriUtama = this.value; // Use the value of the first select input as the firstValue variable
    enterKodeBarang.style.display = "none";
    kategori.disabled = false;
    subKategori.disabled = false;
    namaBarang.disabled = false;
    kategori.focus();
    fetch("/options/kategori/" + kategoriUtama)
        .then((response) => response.json())
        .then((options) => {
            kategori.innerHTML =
                "<option disabled selected value>-- Pilih Kategori --</option>";
            options.forEach((option) => {
                let optionTag = document.createElement("option");
                optionTag.value = option.no_kategori;
                optionTag.text = option.nama_kategori;
                kategori.appendChild(optionTag);
            });
            subKategori.innerHTML =
                "<option disabled selected value>-- Pilih Sub Kategori --</option>";
            namaBarang.innerHTML =
                "<option disabled selected value>-- Pilih Nama Barang --</option>";
            satuanJual.disabled = false;
            fetch("/listsatuan/")
                .then((response) => response.json())
                .then((options) => {
                    satuanJual.innerHTML =
                        "<option selected value>-- Pilih Satuan Jual --</option>";
                    options.forEach((option) => {
                        let optionTag = document.createElement("option");
                        optionTag.value = option.No_satuan;
                        optionTag.text = option.Nama_satuan;
                        satuanJual.appendChild(optionTag);
                        satuanJual.selectedIndex = 0;
                    });
                });
            funcClearInputBarang();
            // berat_standardMeter.style.display = "block"; //untuk menampilkan kolom berat standard (MTR)
        });
});

kategori.addEventListener("change", function () {
    // Code to retrieve options for the second select input based on the selected value of the first select input
    let kategori = this.value; // Use the value of the first select input as the firstValue variable
    subKategori.focus();
    fetch("/options/subKategori/" + kategori)
        .then((response) => response.json())
        .then((options) => {
            subKategori.innerHTML =
                "<option disabled selected value>-- Pilih Sub Kategori --</option>";
            options.forEach((option) => {
                let optionTag = document.createElement("option");
                optionTag.value = option.no_sub_kategori;
                optionTag.text = option.nama_sub_kategori;
                subKategori.appendChild(optionTag);
            });
        });
});

subKategori.addEventListener("change", function () {
    // Code to retrieve options for the second select input based on the selected value of the first select input
    let subKategori = this.value; // Use the value of the first select input as the firstValue variable
    namaBarang.focus();
    fetch("/options/namaBarang/" + subKategori)
        .then((response) => response.json())
        .then((options) => {
            namaBarang.innerHTML =
                "<option disabled selected value>-- Pilih Nama Barang --</option>";
            options.forEach((option) => {
                let optionTag = document.createElement("option");
                optionTag.value = option.KD_BRG;
                optionTag.text = option.NAMA_BRG;
                namaBarang.appendChild(optionTag);
            });
        });
});

namaBarang.addEventListener("change", function () {
    let namaBarang = this.value;
    kodeBarang.value = namaBarang;
    qtyPesan.focus();
    ppn.value = "EXCLUDE";
    ppn.readOnly = true;
    document.getElementById("kode_barang").readOnly = true;

    //Isi Satuan INV
    fetch("/satuan/" + namaBarang)
        .then((response) => response.json())
        .then((data) => {
            // console.log(data[0]);
            satuanPrimer.value =
                data[0].SatPrimer.trim() +
                " (Primer)               -" +
                data[0].ST_PRIM;
            satuanSekunder.value =
                data[0].SatSekunder.trim() +
                " (Sekunder)               -" +
                data[0].ST_SEK;
            satuanTritier.value =
                data[0].Nama_satuan.trim() +
                " (Tritier)               -" +
                data[0].ST_TRI;
            kodeStPrim = satuanPrimer.value.split("-").pop();
            kodeStSek = satuanSekunder.value.split("-").pop();
            kodeStTri = satuanTritier.value.split("-").pop();
            // kodeStJual = data[0].NO_SATUAN_UMUM + ' - ' + data[0].SatUmum;
            // console.log(kodeStJual);
            const options = satuanJual.options;
            for (let i = 0; i < options.length; i++) {
                const option = options[i];
                // console.log(option);
                if (option.value === data[0].NO_SATUAN_UMUM) {
                    option.selected = true;
                    break;
                }
            }
            document.getElementById("satuan_primer").readOnly = true;
            document.getElementById("satuan_sekunder").readOnly = true;
            document.getElementById("satuan_tritier").readOnly = true;
        });
    // console.log(kategoriUtama.value);

    //Jika kategori utama berasal dari KRR-Hasil Produksi, isi Berat Standard
    funcBeratStandard(kategoriUtama, namaBarang);
});

function funcBeratStandard(kategoriUtama, namaBarang) {
    // console.log("kategori utama: " + kategoriUtama.value);
    // console.log('kode barang: ' + namaBarang);
    if (kategoriUtama.value === "011") {
        fetch("/beratstandard/" + namaBarang)
            .then((response) => response.json())
            .then((data) => {
                beratStandard.style.display = "block";
                // console.log(data[0]);
                //ambil data dari database masuk ke input text
                beratKarung.value = data[0].Berat_Karung;
                beratInner.value = data[0].Berat_Inner;
                beratLami.value = data[0].Berat_Lami;
                beratKertas.value = data[0].Berat_Conductive;
                beratStandardTotal.value = data[0].Berat_Total;
                beratKarung.readOnly = false;
                beratInner.readOnly = false;
                beratLami.readOnly = false;
                beratKertas.readOnly = false;
                indexKarung.readOnly = false;
                indexInner.readOnly = false;
                indexLami.readOnly = false;
                indexKertas.readOnly = false;
                biayaLain.readOnly = false;
                indexKarung.value = 0;
                indexInner.value = 0;
                indexLami.value = 0;
                indexKertas.value = 0;
                biayaLain.value = 0;
                beratIndexInner.value = 0;
                beratIndexKarung.value = 0;
                beratIndexLami.value = 0;
                beratIndexKertas.value = 0;
                totalCost.value = 0;
            });
    } else {
        beratStandard.style.display = "none";
    }
}

[
    beratKarung,
    beratInner,
    beratKertas,
    beratLami,
    indexKarung,
    indexInner,
    indexKertas,
    indexLami,
    biayaLain,
].forEach(function (element) {
    element.addEventListener("input", function () {
        beratIndexKarung.value =
            parseFloat(beratKarung.value) * parseFloat(indexKarung.value);
        beratIndexInner.value =
            parseFloat(beratInner.value) * parseFloat(indexInner.value);
        beratIndexLami.value =
            parseFloat(beratLami.value) * parseFloat(indexLami.value);
        beratIndexKertas.value =
            parseFloat(beratKertas.value) * parseFloat(indexKertas.value);
        beratStandardTotal.value =
            parseFloat(beratKarung.value) +
            parseFloat(beratInner.value) +
            parseFloat(beratLami.value) +
            parseFloat(beratKertas.value);
        totalCost.value =
            parseFloat(biayaLain.value) +
            parseFloat(beratIndexKarung.value) +
            parseFloat(beratIndexInner.value) +
            parseFloat(beratIndexKertas.value) +
            parseFloat(beratIndexLami.value);
    });
});

addButton.addEventListener("click", function (event) {
    event.preventDefault();
    // Making array for new row
    // console.log(kodeBarang);
    // console.log(kodeBarang.value);
    if (kodeBarang.value === "") {
        alert("Tidak ada barang yang dimasukan");
        return;
    } else if (
        jenisBarang.selectedIndex === -1 ||
        jenisBarang.selectedIndex === 0
    ) {
        alert("Pilih jenis barang!");
        jenisBarang.focus();
        return;
    } else if (totalCost.value <= 0) {
        alert("Berat standard harap diisi!");
        beratKarung.focus();
        return;
    } else if (qtyPesan.value <= 0) {
        alert("Quantity pesan harap diisi!");
        qtyPesan.focus();
        return;
    } else if (hargaSatuan.value <= 0) {
        alert("Harga satuan harap diisi");
        hargaSatuan.focus();
        return;
    }
    // if buat value validation / form validation untuk masuk ke arraydata dan table

    if (beratKarungMeter.value === NaN) {
        beratKarungMeter.value === 0;
    }
    const arraydata = [
        namaBarang.options[namaBarang.selectedIndex].text,
        kodeBarang.value,
        jenisBarang.value,
        parseInt(qtyPesan.value),
        satuanJual.options[satuanJual.selectedIndex].text,
        parseInt(hargaSatuan.value),
        rencanaKirim.value,
        "",
        ppn.value,
        // Index,
        parseFloat(beratKarung.value),
        parseFloat(indexKarung.value),
        parseFloat(beratIndexKarung.value),
        parseFloat(beratInner.value),
        parseFloat(indexInner.value),
        parseFloat(beratIndexInner.value),
        parseFloat(beratLami.value),
        parseFloat(indexLami.value),
        parseFloat(beratIndexLami.value),
        parseFloat(beratKertas.value),
        parseFloat(indexKertas.value),
        parseFloat(beratIndexKertas.value),
        parseInt(biayaLain.value),
        parseFloat(beratStandardTotal.value),
        parseInt(totalCost.value),
        parseFloat(beratKarungMeter.value),
        parseFloat(beratInnerMeter.value),
        parseFloat(beratLamiMeter.value),
        parseFloat(beratKertasMeter.value),
        parseFloat(beratStandardTotalMeter.value),
        null
    ];
    // Insert array into a new row
    funcInsertRow(arraydata);
    funcClearInputBarang();
    jenisBarang.selectedIndex = 0;
    kategoriUtama.selectedIndex = 0;
    kategori.innerHTML = "";
    kategori.disabled = false;
    subKategori.innerHTML = "";
    subKategori.disabled = false;
    namaBarang.innerHTML = "";
    namaBarang.disabled = false;
    enterKodeBarang.style.display = "none";
    qtyPesan.value = "";
    hargaSatuan.value = "";
    jenisBarang.focus();
});

function funcInsertRow(array) {
    // console.log(array);
    const table = document.getElementById("list_view");
    const dataToCheck = array[1];
    let isDataInTable = false;
    //cek apakah data sudah ada di table
    if (table.rows.length > 0) {
        const cellValue = table.querySelectorAll("input");
        // console.log(cellValue.length);
        for (let i = 1; i < cellValue.length; i += 29) {
            if (cellValue[i].value === dataToCheck) {
                isDataInTable = true;
            }
        }
    }
    // console.log(isDataInTable);
    // console.log(dataToCheck);
    if (isDataInTable) {
        alert("Data sudah ada di table");
        listView.focus();
    } else {
        //add new row ke table
        // let rowid = table.rows.length;

        const newRow = table.insertRow(-1);
        newRow.setAttribute("class", "acs-tr-hover");

        for (let i = 0; i < array.length; i++) {
            const cell = newRow.insertCell(i);
            cell.innerHTML = array[i];
            cell.setAttribute("class", "acs-tr-hover");
            // exclude first cell
            const input = document.createElement("input");
            input.setAttribute("type", "text");
            input.setAttribute("readonly", "true");
            input.setAttribute("value", array[i]);
            input.setAttribute("class", "acs-input-table");
            input.setAttribute("name", "barang" + i + "[]");
            input.style.backgroundColor = table.style.backgroundColor;
            cell.innerHTML = "";
            cell.appendChild(input);
            if (i === 29) {
                cell.setAttribute("style", "display: none");
            }
        }
        //add click event listener to new row
        newRow.addEventListener("click", () => {
            // remove highlight from previously selected row
            const highlightedRow = table.querySelector("tr.highlighted");
            const inputs = newRow.querySelectorAll("input");
            if (highlightedRow) {
                highlightedRow.classList.remove("highlighted");
            }
            // highlight current row
            newRow.classList.add("highlighted");
            // add the "highlighted" class to all input elements in the row
            inputs.forEach((input) => {
                const highlightedInput =
                    table.querySelector("input.highlighted");
                if (highlightedInput) {
                    highlightedInput.classList.remove("highlighted");
                }
                input.classList.add("highlighted");
            });
            // masukin ke input
            kodeBarang.value = inputs[1].value;
            jenisBarang.value = inputs[2].value;
            qtyPesan.value = inputs[3].value;
            hargaSatuan.value = inputs[5].value;
            let optionNamaBarang = document.createElement("option");
            optionNamaBarang.value = inputs[1].value;
            optionNamaBarang.text = inputs[0].value;
            namaBarang.appendChild(optionNamaBarang);
            funcDisplayDataBrg(inputs[1].value);
            // console.log(satuanJual.length);
            satuanJual.selectedIndex = 0;
            for (let i = 0; i < satuanJual.length; i++) {
                // console.log(satuanJual.selectedIndex);
                satuanJual.selectedIndex += 1;
                if (
                    satuanJual.options[satuanJual.selectedIndex].text ===
                    inputs[4].value
                ) {
                    break;
                }
            }
            beratKarung.readOnly = false;
            beratInner.readOnly = false;
            beratLami.readOnly = false;
            beratKertas.readOnly = false;
            indexKarung.readOnly = false;
            indexInner.readOnly = false;
            indexLami.readOnly = false;
            indexKertas.readOnly = false;
            biayaLain.readOnly = false;
            ppn.value = inputs[8].value;
            rencanaKirim.value = inputs[6].value;
            beratKarung.value = inputs[9].value;
            indexKarung.value = inputs[10].value;
            beratIndexKarung.value = inputs[11].value;
            beratInner.value = inputs[12].value;
            indexInner.value = inputs[13].value;
            beratIndexInner.value = inputs[14].value;
            beratLami.value = inputs[15].value;
            indexLami.value = inputs[16].value;
            beratIndexLami.value = inputs[17].value;
            beratKertas.value = inputs[18].value;
            indexKertas.value = inputs[19].value;
            beratIndexKertas.value = inputs[20].value;
            biayaLain.value = inputs[21].value;
            beratStandardTotal.value = inputs[22].value;
            totalCost.value = inputs[23].value;
        });
    }
}

let listViewRows = listView.rows;
// console.log(listViewRows);
for (let i = 0; i < listViewRows.length; i++) {
    const listViewRow = listViewRows[i];

    listViewRow.addEventListener("click", () => {
        // remove highlight from previously selected row
        // const table = document.getElementById("list_view");
        const highlightedRow = listView.querySelector("tr.highlighted");
        const inputs = listViewRow.querySelectorAll("input");
        if (highlightedRow) {
            highlightedRow.classList.remove("highlighted");
        }
        // highlight current row
        listViewRow.classList.add("highlighted");
        // add the "highlighted" class to all input elements in the row
        inputs.forEach((input) => {
            const highlightedInput =
                listView.querySelector("input.highlighted");
            if (highlightedInput) {
                highlightedInput.classList.remove("highlighted");
            }
            // input.classList.add("highlighted");
        });
        // masukin ke input
        kodeBarang.value = inputs[1].value;
        jenisBarang.value = inputs[2].value;
        qtyPesan.value = inputs[3].value;
        hargaSatuan.value = inputs[5].value;
        let optionNamaBarang = document.createElement("option");
        optionNamaBarang.value = inputs[1].value;
        optionNamaBarang.text = inputs[0].value;
        namaBarang.appendChild(optionNamaBarang);
        funcDisplayDataBrg(inputs[1].value);
        // console.log(satuanJual.length);
        satuanJual.selectedIndex = 0;
        if (satuanJual.options.length > 0) {
            for (let i = 0; i < satuanJual.length; i++) {
                // console.log(inputs[4].value);
                // console.log(satuanJual.options);
                satuanJual.selectedIndex += 1;
                if (
                    satuanJual.options[satuanJual.selectedIndex].text ===
                    inputs[4].value
                ) {
                    break;
                }
            }
        }

        beratKarung.readOnly = false;
        beratInner.readOnly = false;
        beratLami.readOnly = false;
        beratKertas.readOnly = false;
        indexKarung.readOnly = false;
        indexInner.readOnly = false;
        indexLami.readOnly = false;
        indexKertas.readOnly = false;
        biayaLain.readOnly = false;
        ppn.value = inputs[8].value;
        rencanaKirim.value = inputs[6].value.substr(0, 10);
        beratKarung.value = inputs[9].value;
        indexKarung.value = inputs[10].value;
        beratIndexKarung.value = inputs[11].value;
        beratInner.value = inputs[12].value;
        indexInner.value = inputs[13].value;
        beratIndexInner.value = inputs[14].value;
        beratLami.value = inputs[15].value;
        indexLami.value = inputs[16].value;
        beratIndexLami.value = inputs[17].value;
        beratKertas.value = inputs[18].value;
        indexKertas.value = inputs[19].value;
        beratIndexKertas.value = inputs[20].value;
        biayaLain.value = inputs[21].value;
        beratStandardTotal.value = inputs[22].value;
        totalCost.value = inputs[23].value;
    });
}

function funcDisplayDataBrg(kodeBarangParameter) {
    // console.log(kodeBarangParameter);
    fetch("/displaybarang/" + kodeBarangParameter)
        .then((response) => response.json())
        .then((data) => {
            // console.log(data);
            let optionTagKategori = document.createElement("option");
            let optionTagSubKategori = document.createElement("option");
            const optionKategoriUtama = kategoriUtama.options;

            for (let i = 0; i < optionKategoriUtama.length; i++) {
                const option = optionKategoriUtama[i];
                if (option.value === data[0].IdKelompokUtama) {
                    option.selected = true;
                    break;
                }
            }
            //disable dulu karena ndak ada isi optionnya hehe
            kategori.disabled = true;
            subKategori.disabled = true;
            namaBarang.disabled = true;
            //ngisi optionnya hehe
            optionTagKategori.value = data[0].IdKelompok;
            optionTagKategori.text = data[0].NamaKelompok;
            optionTagSubKategori.value = data[0].IdCorak;
            optionTagSubKategori.text = data[0].Corak;
            kategori.appendChild(optionTagKategori);
            subKategori.appendChild(optionTagSubKategori);
            //ngisi sisanya hehe
            satuanPrimer.value = data[0].SatuanPrimer;
            satuanSekunder.value = data[0].SatuanSekunder;
            satuanTritier.value = data[0].SatuanTritier;
        });
}
function funcClearInputBarang() {
    satuanJual.selectedIndex = 0;
    ppn.value = "";
    satuanPrimer.value = "";
    satuanSekunder.value = "";
    satuanTritier.value = "";
    kodeBarang.readOnly = true;
    kodeBarang.value = "";
    beratKarung.value = "";
    beratKarung.readOnly = true;
    beratInner.value = "";
    beratInner.readOnly = true;
    beratLami.value = "";
    beratLami.readOnly = true;
    beratKertas.value = "";
    beratKertas.readOnly = true;
    indexKarung.value = "";
    indexKarung.readOnly = true;
    indexInner.value = "";
    indexInner.readOnly = true;
    indexLami.value = "";
    indexLami.readOnly = true;
    indexKertas.value = "";
    indexKertas.readOnly = true;
    beratIndexKarung.value = "";
    beratIndexKarung.readOnly = true;
    beratIndexInner.value = "";
    beratIndexInner.readOnly = true;
    beratIndexLami.value = "";
    beratIndexLami.readOnly = true;
    beratIndexKertas.value = "";
    beratIndexKertas.readOnly = true;
    biayaLain.value = "";
    biayaLain.readOnly = true;
    totalCost.value = "";
    beratStandardTotal.value = "";
}
updateButton.addEventListener("click", function (event) {
    event.preventDefault();
    const table = document.getElementById("list_view");
    const highlightedRow = table.querySelector("tr.highlighted");
    const inputs = highlightedRow.querySelectorAll("input");
    // console.log(highlightedRow.cells.length);
    if (highlightedRow) {
        // update data in selected row
        inputs[3].value = parseInt(qtyPesan.value);
        inputs[4].value = satuanJual.options[satuanJual.selectedIndex].text;
        inputs[5].value = parseInt(hargaSatuan.value);
        inputs[6].value = rencanaKirim.value;
        inputs[9].value = parseFloat(beratKarung.value);
        inputs[10].value = parseFloat(indexKarung.value);
        inputs[11].value = parseFloat(beratIndexKarung.value);
        inputs[12].value = parseFloat(beratInner.value);
        inputs[13].value = parseFloat(indexInner.value);
        inputs[14].value = parseFloat(beratIndexInner.value);
        inputs[15].value = parseFloat(beratLami.value);
        inputs[16].value = parseFloat(indexLami.value);
        inputs[17].value = parseFloat(beratIndexLami.value);
        inputs[18].value = parseFloat(beratKertas.value);
        inputs[19].value = parseFloat(indexKertas.value);
        inputs[20].value = parseFloat(beratIndexKertas.value);
        inputs[21].value = parseInt(biayaLain.value);
        inputs[22].value = parseFloat(beratStandardTotal.value);
        inputs[23].value = parseInt(totalCost.value);
        inputs[24].value = parseFloat(beratKarungMeter.value);
        inputs[25].value = parseFloat(beratInnerMeter.value);
        inputs[26].value = parseFloat(beratLamiMeter.value);
        inputs[27].value = parseFloat(beratKertasMeter.value);
        inputs[28].value = parseFloat(beratStandardTotalMeter.value);
        // remove highlight from selected row
        highlightedRow.classList.remove("highlighted");
        // clear input fields
        funcClearInputBarang();
        jenisBarang.selectedIndex = 0;
        kategoriUtama.selectedIndex = 0;
        kategori.innerHTML = "";
        kategori.disabled = false;
        subKategori.innerHTML = "";
        subKategori.disabled = false;
        namaBarang.innerHTML = "";
        namaBarang.disabled = false;
        enterKodeBarang.style.display = "none";
        qtyPesan.value = "";
        hargaSatuan.value = "";
        jenisBarang.focus();
    }
});

deleteButton.addEventListener("click", function (event) {
    event.preventDefault();
    const table = document.getElementById("list_view");
    const highlightedRow = table.querySelector("tr.highlighted");
    const input = highlightedRow.querySelectorAll("input");
    // console.log(input[29].value);

    if (highlightedRow) {
        if (input[29].value) {
            // console.log(input[29].value);
            fetch("/deletedetail/" + input[29].value)
            .then((response)=> response.json())
            .then((data) => {
                alert(data);
            });
            table.deleteRow(highlightedRow.rowIndex);
        }
        else{
            table.deleteRow(highlightedRow.rowIndex);
        }
        alert("Data sudah terhapus dari tabel!");
    } else {
        alert("Tidak ada data yang dihapus");
    }
    funcClearInputBarang();
    jenisBarang.selectedIndex = 0;
    kategoriUtama.selectedIndex = 0;
    kategori.innerHTML = "";
    kategori.disabled = false;
    subKategori.innerHTML = "";
    subKategori.disabled = false;
    namaBarang.innerHTML = "";
    namaBarang.disabled = false;
    enterKodeBarang.style.display = "none";
    qtyPesan.value = "";
    hargaSatuan.value = "";
    jenisBarang.focus();
});

jenisSp.addEventListener("change", function () {
    if (jenisSp.value != 1) {
        alert(
            "Untuk sementara hanya jenis pesanan lokal (SP 1) yang bisa diproses"
        );
        jenisSp.value = 1;
        // fakturPjk.value = NULL; //kalau bukan SP 1 maka FakturPJK pasti null
    }
});
// const form = document.getElementById("form_suratPesanan");

// form.addEventListener("submit", (event) => {
//     event.preventDefault();

//     const formData = new FormData(form);
//     formData.append("_token", "{{ csrf_token() }}"); // This adds the CSRF token value

//     fetch("/submit-form", {
//         method: "POST",
//         body: formData,
//     })
//         .then((response) => {
//             console.log("Form submitted successfully!");
//             console.log(formData);
//             console.log(response);
//         })
//         .catch((error) => {
//             console.error("Error submitting form:", error);
//         });
// });
// console.log(kodeStPrim);

//wih 1000 dong
