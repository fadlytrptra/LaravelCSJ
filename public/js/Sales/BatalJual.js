let kode_barang = document.getElementById("kode_barang");
let button_proses = document.getElementById("button_proses");
let table_Barcode = document.getElementById("table_Barcode");
let div_proses = document.getElementById("div_proses");
let selectedRows = [];

//#region  Load Form
kode_barang.focus();
div_proses.style.display = "none";
//#endregion

//#region Set Input Filter
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

//#endregion

//#region Add Event Listener
kode_barang.addEventListener("keypress", function (event) {
    if (event.key == "Enter") {
        event.preventDefault();
        $("#loading-screen").css("display", "flex");
        if (kode_barang.value == "") {
            alert("Isi kode barang lebih dulu!");
            kode_barang.focus();
        } else {
            let kodeBarang9digit;
            kodeBarang9digit = document.getElementById("kode_barang");
            if (kodeBarang9digit.value.length < 9) {
                kodeBarang9digit.value = kode_barang.value.padStart(9, "0");
            }
            kode_barang.value = kodeBarang9digit.value;
            fetch("/batalJualInputBarcode/" + kode_barang.value)
                .then((response) => response.json())
                .then((data) => {
                    // console.log(data);
                    const tbody = document.querySelector(
                        "#table_Barcode tbody"
                    );
                    const rows = data.map((item) => {
                        return [
                            item.Tgl_Mutasi.trim(),
                            item.NoIndeks.trim(),
                            item.Kode_barang.trim(),
                            item.IdType.trim(),
                            item.IdDivisi.trim(),
                        ];
                    });

                    const table = $("#table_Barcode").DataTable();
                    table.clear();
                    table.rows.add(rows);
                    table.draw();
                    $("#table_Barcode tbody").on("click", "tr", function () {
                        const table = $("#table_Barcode").DataTable();
                        $(this).toggleClass("selected");
                        selectedRows = table.rows(".selected").data().toArray();
                    });
                }).finally(() => {
                    $("#loading-screen").css("display", "none");
                });
            div_proses.style.display = "block";
        }
    }
});

button_proses.addEventListener("click", function (event) {
    // console.log(selectedRows);
    event.preventDefault();

    let kodeBarang = selectedRows[0][2];
    let kode_barang = document.createElement("input");
    kode_barang.type = "hidden";
    kode_barang.name = "kodeBarang";
    kode_barang.value = kodeBarang;
    form_submitSelected.appendChild(kode_barang);

    for (let i = 0; i < selectedRows.length; i++) {
        let nomorIndeks = selectedRows[i][1];
        // console.log(selectedRows[i]);

        let nomor_indeks = document.createElement("input");
        nomor_indeks.type = "hidden";
        nomor_indeks.name = "nomorIndeks[]";
        nomor_indeks.value = nomorIndeks;
        form_submitSelected.appendChild(nomor_indeks);
    }
    form_submitSelected.submit();
    // console.log(form_submitSelected);
});
//#endregion
