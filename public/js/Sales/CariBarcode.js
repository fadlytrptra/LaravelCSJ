let button_proses = document.getElementById("button_proses");
let button_tampilkanPilihan = document.getElementById(
    "button_tampilkanPilihan"
);
let checkbox_idType = document.getElementById("checkbox_idType");
let checkbox_Kg = document.getElementById("checkbox_Kg");
let checkbox_lembar = document.getElementById("checkbox_lembar");
let checkbox_Tanggal = document.getElementById("checkbox_Tanggal");
let div_tableBarcode = document.getElementById("div_tableBarcode");
let id_type = document.getElementById("id_type");
let id_typeText = document.getElementById("id_typeText");
let id_typeSelect = document.getElementById("id_typeSelect");
let jumlah_data = document.getElementById("jumlah_data");
let jumlah_dataKolom = document.getElementById("jumlah_dataKolom");
let Kg = document.getElementById("Kg");
let kode_barang = document.getElementById("kode_barang");
let lembar = document.getElementById("lembar");
let switch_idType = document.getElementById("switch_idType");
let table_Barcode = document.getElementById("table_Barcode");
let tanggal_cariBarcode = document.getElementById("tanggal_cariBarcode");
let tempat_dispresiasi = document.getElementById("tempat_dispresiasi");

//#region Load Form

tempat_dispresiasi.checked = true;
tanggal_cariBarcode.valueAsDate = new Date();
kode_barang.focus();

//#endregion

//#region Input Filter

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
    document.getElementById("kode_barang"),
    function (value) {
        return /^-?\d*$/.test(value);
    },
    "Harus diisi dengan angka!"
);
setInputFilter(
    document.getElementById("lembar"),
    function (value) {
        return /^-?\d*$/.test(value);
    },
    "Harus diisi dengan angka!"
);
setInputFilter(
    document.getElementById("id_typeText"),
    function (value) {
        return /^-?\d*$/.test(value);
    },
    "Harus diisi dengan angka!"
);
setInputFilter(
    document.getElementById("Kg"),
    function (value) {
        return /^-?\d*$/.test(value);
    },
    "Harus diisi dengan angka!"
);

//#endregion

//#region macam-macam add event listener

button_proses.addEventListener("click", function () {
    if (kode_barang.value == "") {
        alert("Isi kode barang lebih dulu!");
        kode_barang.focus();
    } else {
        $("#loading-screen").css("display", "flex");
        const form = new FormData();
        let kodeFilter = "";
        if (checkbox_Tanggal.checked == true) {
            form.append("Tanggal", tanggal_cariBarcode.value);
            kodeFilter += "D"; //Date
        }
        if (checkbox_idType.checked == true) {
            form.append("Id Type", id_typeText.value);
            kodeFilter += "T"; //Type
        }
        if (checkbox_lembar.checked == true) {
            form.append("Lembar", lembar.value);
            kodeFilter += "S"; //Sheet
        }
        if (checkbox_Kg.checked == true) {
            form.append("Kg", Kg.value);
            kodeFilter += "K"; //Kg
        }

        form.append("Kode barang", kode_barang.value);
        form.append("Kode filter", kodeFilter);

        if (tempat_dispresiasi.checked == true) {
            form.append("Group Radio Button Cari Barcode", "Dispresiasi");
        } else if (tempat_tmpGudang.checked == true) {
            form.append("Group Radio Button Cari Barcode", "Tmp_gudang");
        }
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");
        form.append("_token", csrfToken);

        fetch("/cariBarcodeFilter/action", {
            method: "POST",
            body: form,
        })
            .then((response) => response.json())
            .then((data) => {
                // console.log(data);
                const tbody = document.querySelector("#table_Barcode tbody");

                const rows = data.map((item) => {
                    return [
                        item.NoIndeks,
                        item.Qty_Primer,
                        item.Qty_sekunder,
                        item.Qty,
                        item.Id_type_tujuan,
                        item.Tgl_mutasi,
                        item.Status,
                        item.Type_Transaksi,
                        item.IdDivisi,
                        item.NamaKelompokUtama,
                        item.NamaKelompok,
                        item.NamaSubKelompok,
                    ];
                });

                const table = $("#table_Barcode").DataTable();
                table.clear();
                table.rows.add(rows);
                table.draw();
                $("#table_Barcode tbody").on("click", "tr", function () {
                    const table = $("#table_Barcode").DataTable();
                    $(this).toggleClass("selected");
                    var selectedRows = table.rows(".selected").data().toArray();
                    // console.log(selectedRows);
                });
                jumlah_data.innerHTML = data.length;
            })
            .catch((error) => console.error(error))
            .finally(() => {
                $("#loading-screen").css("display", "none");
            });
        div_tableBarcode.style.display = "block";
        jumlah_dataKolom.style.visibility = "visible";
    }
});

switch_idType.addEventListener("click", function () {
    if (id_typeSelect.style.display == "none") {
        id_typeText.style.display = "none";
        id_typeSelect.style.display = "inline-block";
        id_typeSelect.focus();
    } else if (id_typeSelect.style.display == "inline-block") {
        id_typeText.style.display = "inline-block";
        id_typeSelect.style.display = "none";
        id_typeText.focus();
    }
});

kode_barang.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        $("#loading-screen").css("display", "flex");
        let kodeBarang9digit;
        kodeBarang9digit = document.getElementById("kode_barang");
        if (kodeBarang9digit.value.length < 9) {
            kodeBarang9digit.value = kode_barang.value.padStart(9, "0");
        }
        kode_barang.value = kodeBarang9digit.value;
        if (tempat_dispresiasi.checked == true) {
            fetch("/cariBarcodeIdTypeDispresiasi/" + kode_barang.value)
                .then((response) => response.json())
                .then((options) => {
                    // console.log(options);
                    id_typeSelect.innerHTML =
                        "<option disabled selected value>-- Pilih Id Type --</option>";
                    id_type.innerHTML = "";
                    options
                        .forEach((option) => {
                            let optionTagSelect =
                                document.createElement("option");
                            optionTagSelect.value = option.id_type_tujuan;
                            optionTagSelect.text = option.id_type_tujuan;
                            id_typeSelect.appendChild(optionTagSelect);

                            let optionTag = document.createElement("option");
                            optionTag.value = option.id_type_tujuan;
                            id_type.appendChild(optionTag);
                        })
                        .finally(() => {
                            $("#loading-screen").css("display", "none");
                        });
                });
        } else {
            fetch("/cariBarcodeIdTypeTmpGudang/" + kode_barang.value)
                .then((response) => response.json())
                .then((data) => {
                    // console.log(data);
                    id_typeSelect.innerHTML =
                        "<option disabled selected value>-- Pilih Id Type --</option>";
                    id_type.innerHTML = "";
                    options
                        .forEach((option) => {
                            let optionTagSelect =
                                document.createElement("option");
                            optionTagSelect.value = option.id_type_tujuan;
                            optionTagSelect.text = option.id_type_tujuan;
                            id_typeSelect.appendChild(optionTagSelect);

                            let optionTag = document.createElement("option");
                            optionTag.value = option.id_type_tujuan;
                            id_type.appendChild(optionTag);
                        })
                        .finally(() => {
                            $("#loading-screen").css("display", "none");
                        });
                });
        }
        id_typeSelect.focus();
    }
});

id_typeSelect.addEventListener("change", function () {
    id_typeText.value = id_typeSelect.options[id_typeSelect.selectedIndex].text;
});
//#endregion

//#region Checkbox

checkbox_idType.addEventListener("click", function () {
    if (id_typeText.value == "") {
        alert("Isi Kolom Id Type dulu!");
        checkbox_idType.checked = false;
    }
});
checkbox_lembar.addEventListener("click", function () {
    if (lembar.value == "") {
        alert("Isi Kolom lembar dulu!");
        checkbox_lembar.checked = false;
    }
});
checkbox_Kg.addEventListener("click", function () {
    if (Kg.value == "") {
        alert("Isi Kolom Kg dulu!");
        checkbox_Kg.checked = false;
    }
});
//#endregion
