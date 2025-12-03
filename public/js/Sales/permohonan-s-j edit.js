//#region get element by id

let jenis_pengiriman = document.getElementById("jenis_pengiriman");
let keterangan = document.getElementById("keterangan");
let surat_jalan = document.getElementById("surat_jalan");
let truk_nopol = document.getElementById("truk_nopol");
let tanggal = document.getElementById("tanggal");
let biaya = document.getElementById("biaya");
let tanggal_actual = document.getElementById("tanggal_actual");
let nomor_container = document.getElementById("nomor_container");
let customer = document.getElementById("customer");
let nomor_seal = document.getElementById("nomor_seal");
let expeditor = document.getElementById("expeditor");
let list_view = document.getElementById("list_view");
let surat_pesanan = document.getElementById("surat_pesanan");
let surat_pesanan_edit = document.getElementById("surat_pesanan_edit");
let nomor_do = document.getElementById("nomor_do");
let uraian = document.getElementById("uraian");
let add_item = document.getElementById("add_item");
let remove_item = document.getElementById("remove_item");
let submit = document.getElementById("submit");
let customer_edit = document.getElementById("customer_edit");

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
    document.getElementById("biaya"),
    function (value) {
        return /^-?\d*$/.test(value);
    },
    "Harus diisi dengan angka!"
);

//#endregion

//#region input filter

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
//#endregion

//#region load form

jenis_pengiriman.focus();
tanggal.valueAsDate = new Date();
tanggal.setAttribute("disabled", true);
tanggal_actual.valueAsDate = new Date();
// console.log(customer_edit.value);
//buat isi select customer
fetch("/options/customer/" + customer_edit.value)
    .then((response) => response.json())
    .then((options) => {
        // customer.innerHTML =
        //     "<option disabled selected value>-- Pilih Nomor Surat Pesanan --</option>";
        options.forEach((option) => {
            // let optionTag = document.createElement("option");
            // optionTag.value = option.IDCust;
            // optionTag.text = option.NamaCust;
            // customer.appendChild(optionTag);
            // optionTag.setAttribute("selected", true);
            let optionExists = false;
            for (let i = 0; i < customer.options.length; i++) {
                if (customer.options[i].value === option.IDCust) {
                    optionExists = true;
                    customer.options[i].setAttribute("selected",true);
                    break;
                }
            }

            if (!optionExists) {
                let optionTag = document.createElement("option");
                optionTag.value = option.IDCust;
                optionTag.text = option.NamaCust;
                optionTag.setAttribute("selected", true);
                customer.appendChild(optionTag);
            }
        });
    });
//buat isi select Surat Pesanan
// fetch("/options/suratpesanan/" + customer.value)
//     .then((response) => response.json())
//     .then((options) => {
//         nomor_sp.innerHTML =
//             "<option disabled selected value>-- Pilih Nomor Surat Pesanan --</option>";
//         options.forEach((option) => {
//             let optionTag = document.createElement("option");
//             optionTag.value = option.IDSuratPesanan;
//             optionTag.text =
//                 option.IDSuratPesanan + " | " + option.JnsSuratPesanan;
//             nomor_sp.appendChild(optionTag);
//             if (option.IDSuratPesanan === nomor_sp_edit.value) {
//                 nomor_sp.value = option.IDSuratPesanan;
//             }
//         });
//     });

// fetch("/options/suratpesanan/" + customer_edit.value)
//     .then((response) => response.json())
//     .then((options) => {
//         console.log(options);
//         // surat_pesanan.innerHTML =
//         //     "<option disabled selected>-- Pilih Surat Pesanan --</option>";
//         options.forEach((option) => {
//             console.log(option);
//             let optionTag = document.createElement("option");
//             optionTag.value = option.IDSuratPesanan;
//             optionTag.text = option.IDSuratPesanan;
//             surat_pesanan.appendChild(optionTag);
//         });
//     });

//#endregion

//#region Input Select Change

customer.addEventListener("change", function () {
    let customer = this.value;
    expeditor.focus();
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
    let surat_pesanan = this.value;
    // console.log(surat_pesanan);
    nomor_do.focus();
    fetch("/options/deliveryorder/" + surat_pesanan)
        .then((response) => response.json())
        .then((options) => {
            nomor_do.innerHTML =
                "<option disabled selected>-- Pilih Delivery Order --</option>";
            options.forEach((option) => {
                let optionTag = document.createElement("option");
                optionTag.value = option.IDDO;
                // let string = option.Uraian;
                // let NamaBarang = string.substring(0, string.indexOf(" Qty Primer"));
                // optionTag.text = NamaBarang;
                optionTag.text = option.Uraian;
                nomor_do.appendChild(optionTag);
            });
        });
});

nomor_do.addEventListener("change", function () {
    // Get the selected option element
    var selectedOption = this.options[this.selectedIndex];

    // Get the text content of the selected option
    var selectedText = selectedOption.textContent;

    // Set the value of the textarea to the selected text
    uraian.value = selectedText;
    add_item.focus();
});

expeditor.addEventListener("change", function () {
    keterangan.focus();
});

//#endregion

//#region enter-enter

jenis_pengiriman.addEventListener("change", function () {
    surat_jalan.focus();
});

tanggal.addEventListener("change", function () {
    tanggal_actual.focus();
});

tanggal_actual.addEventListener("change", function () {
    customer.focus();
});

customer.addEventListener("change", function () {
    expeditor.focus();
});

expeditor.addEventListener("change", function () {
    keterangan.focus();
});

surat_jalan.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        tanggal.focus();
    }
});

keterangan.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        truk_nopol.focus();
    }
});

truk_nopol.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        biaya.focus();
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
        surat_pesanan.focus();
    }
});
//#endregion

//#region Table-table

add_item.addEventListener("click", function () {
    if (uraian.value === "" || nomor_do.selectedIndex === 0) {
        alert("Isi DO dulu!");
    } else {
        const arraydata = [
            nomor_do.options[nomor_do.selectedIndex].value,
            uraian.value,
            "",
            surat_pesanan.options[surat_pesanan.selectedIndex].text,
        ];
        funcInsertRow(arraydata);
        funcClearDataInput();
    }
});

function funcInsertRow(array) {
    const table = document.getElementById("list_view");
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
            const highlightedRow = table.querySelector("tr.highlighted");
            const inputs = newRow.querySelectorAll("input");
            if (highlightedRow) {
                highlightedRow.classList.remove("highlighted");
            }
            // highlight current row
            newRow.classList.add("highlighted");
            // add the "highlighted" class to all input elements in the row
        });
    }
}

function funcClearDataInput() {
    surat_pesanan.selectedIndex = 0;
    nomor_do.selectedIndex = 0;
    uraian.value = "";
}

remove_item.addEventListener("click", function (event) {
    event.preventDefault();
    const table = document.getElementById("list_view");
    const highlightedRow = table.querySelector("tr.highlighted");
    if (highlightedRow) {
        table.deleteRow(highlightedRow.rowIndex);
        alert("Data sudah terhapus!");
    } else {
        alert("Tidak ada data yang dihapus");
    }
});

let list_viewRows = list_view.rows;
for (let i = 0; i < list_viewRows.length; i++) {
    const listViewRow = list_viewRows[i];
    listViewRow.addEventListener("click", () => {
        // remove highlight from previously selected row
        const highlightedRow = list_view.querySelector("tr.highlighted");
        const inputs = listViewRow.querySelectorAll("input");
        if (highlightedRow) {
            highlightedRow.classList.remove("highlighted");
        }
        // highlight current row
        listViewRow.classList.add("highlighted");
        // add the "highlighted" class to all input elements in the row
    });
}


//#endregion
