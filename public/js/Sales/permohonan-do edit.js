//#region get element by id

let alamat_kirim = document.getElementById("alamat_kirim");
let cc = document.getElementById("cc");
let customer = document.getElementById("customer");
let divisi = document.getElementById("divisi");
let etd = document.getElementById("etd");
let id_pesanan = document.getElementById("id_pesanan");
let id_pesanan_hidden = document.getElementById("id_pesanan_hidden");
let id_pesanan_edit = document.getElementById("id_pesanan_edit");
let id_typeBarang = document.getElementById("id_typeBarang");
let kelompok = document.getElementById("kelompok");
let kelompok_edit = document.getElementById("kelompok_edit");
let kelompok_utama = document.getElementById("kelompok_utama");
let kelompok_utama_edit = document.getElementById("kelompok_utama_edit");
let kode_barang = document.getElementById("kode_barang");
let kota_kirim = document.getElementById("kota_kirim");
let max_kirim = document.getElementById("max_kirim");
let min_kirim = document.getElementById("min_kirim");
let nomor_sp = document.getElementById("nomor_sp");
let nomor_sp_edit = document.getElementById("nomor_sp_edit");
let qty_kirim = document.getElementById("qty_kirim");
let qty_order = document.getElementById("qty_order");
let qty_primer = document.getElementById("qty_primer");
let qty_primerGudang = document.getElementById("qty_primerGudang");
let qty_sekunder = document.getElementById("qty_sekunder");
let qty_sekunderGudang = document.getElementById("qty_sekunderGudang");
let qty_tritier = document.getElementById("qty_tritier");
let qty_tritierGudang = document.getElementById("qty_tritierGudang");
let satuan_primer = document.getElementById("satuan_primer");
let satuan_sekunder = document.getElementById("satuan_sekunder");
let satuan_tritier = document.getElementById("satuan_tritier");
let sub_kelompok = document.getElementById("sub_kelompok");
let sub_kelompok_edit = document.getElementById("sub_kelompok_edit");
let text_idTypeBarang = document.getElementById("text_idTypeBarang");
let tgl_do = document.getElementById("tgl_do");
let uraian = document.getElementById("uraian");

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

setInputFilter(
    document.getElementById("qty_primer"),
    function (value) {
        return /^-?\d*$/.test(value);
    },
    "Harus diisi dengan angka!"
);
setInputFilter(
    document.getElementById("qty_sekunder"),
    function (value) {
        return /^-?\d*$/.test(value);
    },
    "Harus diisi dengan angka!"
);
setInputFilter(
    document.getElementById("qty_tritier"),
    function (value) {
        return /^-?\d*$/.test(value);
    },
    "Harus diisi dengan angka!"
);
setInputFilter(
    document.getElementById("qty_order"),
    function (value) {
        return /^-?\d*$/.test(value);
    },
    "Harus diisi dengan angka!"
);
setInputFilter(
    document.getElementById("qty_kirim"),
    function (value) {
        return /^-?\d*$/.test(value);
    },
    "Harus diisi dengan angka!"
);
setInputFilter(
    document.getElementById("max_kirim"),
    function (value) {
        return /^-?\d*$/.test(value);
    },
    "Harus diisi dengan angka!"
);
setInputFilter(
    document.getElementById("min_kirim"),
    function (value) {
        return /^-?\d*$/.test(value);
    },
    "Harus diisi dengan angka!"
);
//#endregion

//#region enter-enter

max_kirim.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        min_kirim.focus();
    }
});

min_kirim.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        alamat_kirim.focus();
    }
});

alamat_kirim.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        kota_kirim.focus();
    }
});

//#endregion

//#region load form

customer.focus();
etd.valueAsDate = new Date();
cc.valueAsDate = new Date();
tgl_do.valueAsDate = new Date();

// console.log(nomor_sp_edit.value);
//buat isi select value nomor SP
fetch("/options/nomorsp/" + customer.value)
    .then((response) => response.json())
    .then((options) => {
        nomor_sp.innerHTML =
            "<option disabled selected value>-- Pilih Nomor Surat Pesanan --</option>";
        options.forEach((option) => {
            let optionTag = document.createElement("option");
            optionTag.value = option.IDSuratPesanan;
            optionTag.text =
                option.IDSuratPesanan + " | " + option.JnsSuratPesanan;
            nomor_sp.appendChild(optionTag);
            if (option.IDSuratPesanan === nomor_sp_edit.value) {
                nomor_sp.value = option.IDSuratPesanan;
            }
        });
    });
//buat isi select value ID Pesanan
fetch("/options/id_pesanan/" + nomor_sp_edit.value)
    .then((response) => response.json())
    .then((options) => {
        id_pesanan.innerHTML =
            "<option disabled selected value>-- Pilih ID Pesanan --</option>";
        options.forEach((option) => {
            let optionTag = document.createElement("option");
            optionTag.value = option.IDPesanan;
            optionTag.text = option.IDPesanan + "-" + option.Uraian;
            id_pesanan.appendChild(optionTag);
            if (option.IDPesanan === id_pesanan_edit.value) {
                id_pesanan.value = option.IDPesanan;
            }
        });
    });
//buat isi select value Kelompok utama
fetch("/options/kelompokutama/" + kode_barang.value)
    .then((response) => response.json())
    .then((options) => {
        kelompok_utama.innerHTML =
            "<option disabled selected value>-- Pilih Kelompok Utama --</option>";
        options.forEach((option) => {
            let optionTag = document.createElement("option");
            optionTag.value = option.IDTYPEBARANG;
            optionTag.text =
                option.NAMATYPEBARANG +
                " | " +
                option.IDTYPEBARANG +
                " | " +
                option.ObjekDivisi;
            kelompok_utama.appendChild(optionTag);
            // console.log(kelompok_utama_edit.value);
            // console.log(option.IDTYPEBARANG);
            if (option.IDTYPEBARANG === kelompok_utama_edit.value) {
                kelompok_utama.value = option.IDTYPEBARANG;
            }
        });
    });
//buat isi select value Kelompok
fetch("/options/kelompok/" + kelompok_utama_edit.value + "/" + kode_barang.value)
    .then((response) => response.json())
    .then((options) => {
        kelompok.innerHTML =
            "<option disabled selected value>-- Pilih Kelompok --</option>";
        options.forEach((option) => {
            let optionTag = document.createElement("option");
            optionTag.value = option.IdKelompok;
            optionTag.text = option.NamaKelompok;
            kelompok.appendChild(optionTag);
            if (option.IdKelompok === kelompok_edit.value) {
                kelompok.value = option.IdKelompok;
            }
        });
    });
//buat isi select value Sub Kelompok
fetch("/options/subkelompok/" + kelompok_edit.value + "/" + kode_barang.value)
    .then((response) => response.json())
    .then((options) => {
        sub_kelompok.innerHTML =
            "<option disabled selected value>-- Pilih Sub Kelompok --</option>";
        options.forEach((option) => {
            let optionTag = document.createElement("option");
            optionTag.value = option.IDCorak;
            optionTag.text = option.Corak;
            sub_kelompok.appendChild(optionTag);
            if (option.IDCorak === sub_kelompok_edit.value) {
                sub_kelompok.value = option.IDCorak;
            }
        });
    });
//#endregion

//#region get value option using ajax

customer.addEventListener("change", function () {
    let customer = this.value;
    nomor_sp.focus();
    fetch("/options/nomorsp/" + customer)
        .then((response) => response.json())
        .then((options) => {
            nomor_sp.innerHTML =
                "<option disabled selected value>-- Pilih Nomor Surat Pesanan --</option>";
            options.forEach((option) => {
                let optionTag = document.createElement("option");
                optionTag.value = option.IDSuratPesanan;
                optionTag.text =
                    option.IDSuratPesanan + " | " + option.JnsSuratPesanan;
                nomor_sp.appendChild(optionTag);
            });
        });
});

nomor_sp.addEventListener("change", function () {
    let nomor_sp = this.value;
    id_pesanan.focus();
    fetch("/options/id_pesanan/" + nomor_sp)
        .then((response) => response.json())
        .then((options) => {
            id_pesanan.innerHTML =
                "<option disabled selected value>-- Pilih ID Pesanan --</option>";
            options.forEach((option) => {
                let optionTag = document.createElement("option");
                optionTag.value = option.IDPesanan;
                optionTag.text = option.IDPesanan + "-" + option.Uraian;
                id_pesanan.appendChild(optionTag);
            });
        });
});

id_pesanan.addEventListener("change", function () {
    let id_pesanan = this.value;
    let selectedOption = this.options[this.selectedIndex];
    let text = selectedOption.text;
    let parts = text.split("-");
    selectedOption.text = parts[0];
    kode_barang.value = parts[2];
    uraian.value = parts[1];
    id_pesanan_hidden.value = parts[0];
    // console.log(parts[0]);
    kelompok_utama.focus();
    fetch("/options/barang/" + id_pesanan)
        .then((response) => response.json())
        .then((data) => {
            // console.log(data);
            document.getElementById("id_pesanan").disabled = true;
            kode_barang.readOnly = true;
            uraian.readOnly = true;
            qty_kirim.readOnly = true;
            qty_kirim.value = data[0].TerKirim;
            qty_order.readOnly = true;
            qty_order.value = data[0].Qty;
            satuan_primer.readOnly = true;
            satuan_primer.value = data[0].SatuanPrimer;
            satuan_sekunder.readOnly = true;
            satuan_sekunder.value = data[0].SatuanSekunder;
            satuan_tritier.readOnly = true;
            satuan_tritier.value = data[0].SatuanTritier;
        });
    // console.log(kode_barang.value);
    fetch("/options/kelompokutama/" + kode_barang.value)
        .then((response) => response.json())
        .then((options) => {
            kelompok_utama.innerHTML =
                "<option disabled selected value>-- Pilih Kelompok Utama --</option>";
            options.forEach((option) => {
                let optionTag = document.createElement("option");
                optionTag.value = option.IDTYPEBARANG;
                optionTag.text =
                    option.NAMATYPEBARANG +
                    " | " +
                    option.IDTYPEBARANG +
                    " | " +
                    option.ObjekDivisi;
                kelompok_utama.appendChild(optionTag);
            });
        });
});

kelompok_utama.addEventListener("change", function () {
    let kelompok_utama = this.value;
    let selectedOption = this.options[this.selectedIndex];
    let text = selectedOption.text;
    let parts = text.split(" | ");
    // console.log(parts);
    divisi.value = parts[2];
    kelompok.focus();
    fetch("/options/kelompok/" + kelompok_utama + "/" + kode_barang.value)
        .then((response) => response.json())
        .then((options) => {
            kelompok.innerHTML =
                "<option disabled selected value>-- Pilih Kelompok --</option>";
            options.forEach((option) => {
                let optionTag = document.createElement("option");
                optionTag.value = option.IdKelompok;
                optionTag.text = option.NamaKelompok;
                kelompok.appendChild(optionTag);
            });
        });
});

kelompok.addEventListener("change", function () {
    let kelompok = this.value;
    sub_kelompok.focus();
    fetch("/options/subkelompok/" + kelompok + "/" + kode_barang.value)
        .then((response) => response.json())
        .then((options) => {
            sub_kelompok.innerHTML =
                "<option disabled selected value>-- Pilih Sub Kelompok --</option>";
            options.forEach((option) => {
                let optionTag = document.createElement("option");
                optionTag.value = option.IDCorak;
                optionTag.text = option.Corak;
                sub_kelompok.appendChild(optionTag);
            });
        });
});

sub_kelompok.addEventListener("change", function () {
    let sub_kelompok = this.value;
    qty_primer.focus();
    fetch("/options/saldo/" + sub_kelompok + "/" + kode_barang.value)
        .then((response) => response.json())
        .then((data) => {
            text_idTypeBarang.style.display = "block";
            id_typeBarang.style.display = "block";
            id_typeBarang.readOnly = true;
            id_typeBarang.value = data[0].IdType;
            qty_primerGudang.value = data[0].SaldoPrimer;
            qty_sekunderGudang.value = data[0].SaldoSekunder;
            qty_tritierGudang.value = data[0].SaldoTritier;
            max_kirim.focus();
            qty_primer.value = 0;
            qty_sekunder.value = 0;
            qty_tritier.value = 0;
        });
});
//#endregion
