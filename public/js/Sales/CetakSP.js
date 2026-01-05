let tanggal_sp = document.getElementById("tanggal_sp");
let no_spText = document.getElementById("no_spText");
let no_spSelect = document.getElementById("no_spSelect");
let jenis_sp = document.getElementById("jenis_sp");
let print_button = document.getElementById("print_button");
let contoh_print = document.getElementById("contoh_print");
let contoh_printDiv = document.getElementById("contoh_printDiv");
let nomor_spSpan = document.getElementById("nomor_spSpan");
let no_poKolom = document.getElementById("no_poKolom");
let tgl_poKolom = document.getElementById("tgl_poKolom");
let tgl_pesanKolom = document.getElementById("tgl_pesanKolom");
let nama_customerKolom = document.getElementById("nama_customerKolom");
let kota_customerKolom = document.getElementById("kota_customerKolom");
let alamat_kantorKolom = document.getElementById("alamat_kantorKolom");
let alamat_kirimKolom = document.getElementById("alamat_kirimKolom");
let nomor_barangKolom = document.getElementById("nomor_barangKolom");
let nama_barangKolom = document.getElementById("nama_barangKolom");
let kode_barangKolom = document.getElementById("kode_barangKolom");
let quantity_barangKolom = document.getElementById("quantity_barangKolom");
let jenis_bayarKolom = document.getElementById("jenis_bayarKolom");
let rencana_kirimKolom = document.getElementById("rencana_kirimKolom");
let syarat_bayarKolom = document.getElementById("syarat_bayarKolom");
let keterangan_kolom = document.getElementById("keterangan_kolom");
let nama_salesKolom = document.getElementById("nama_salesKolom");
let nama_managerKolom = document.getElementById("nama_managerKolom");
let lihat_sp = document.getElementById("lihat_sp");
let print_pdf = document.getElementById("print_pdf");
let loading_screen = document.getElementById("loading-screen");
let table_sp = $("#table_sp").DataTable({
    searching: false,
    paging: false,
    info: false,
    ordering: false,
});
//#region Load Page

tanggal_sp.focus();
tanggal_sp.valueAsDate = new Date();
// contoh_printDiv.style.display = "none";
contoh_print.style.display = "none";
no_spSelect.style.display = "none";
print_pdf.style.display = "none";

//#endregion

//#region Add event listener

tanggal_sp.addEventListener("change", function () {
    fetch("/nosp/" + this.value)
        .then((response) => response.json())
        .then((options) => {
            no_spSelect.innerHTML =
                "<option disabled selected value>-- Pilih Nomor SP --</option>";
            options.forEach((option) => {
                let optionTag = document.createElement("option");
                optionTag.value = option.IDSuratPesanan;
                optionTag.text =
                    option.IDSuratPesanan + " | " + option.NamaCust;
                no_spSelect.appendChild(optionTag);
            });
        });
});

no_spSelect.addEventListener("change", function () {
    no_spText.value = no_spSelect.value;
    fetch("/options/jenissp/" + no_spSelect.value)
        .then((response) => response.json())
        .then((options) => {
            jenis_sp.value =
                options[0].IDJnsSuratPesanan +
                " | " +
                options[0].JnsSuratPesanan;
            jenis_sp.readOnly = true;
        });
});

no_spText.addEventListener("keypress", function (event) {
    if (event.key == "Enter") {
        event.preventDefault();
        fetch("/options/jenissp/" + no_spText.value.trim())
            .then((response) => response.json())
            .then((options) => {
                jenis_sp.value =
                    options[0].IDJnsSuratPesanan +
                    " | " +
                    options[0].JnsSuratPesanan;
                jenis_sp.readOnly = true;
            });
        print_button.focus();
    }
});

lihat_sp.addEventListener("click", function (event) {
    event.preventDefault();
    if (no_spSelect.style.display == "block") {
        no_spSelect.style.display = "none";
        no_spText.style.display = "block";
    } else if (no_spSelect.style.display == "none") {
        no_spSelect.style.display = "block";
        no_spText.style.display = "none";
    }
});

print_button.addEventListener("click", function (event) {
    event.preventDefault();
    $("#loading-screen").css("display", "flex");
    if (no_spText.value == "") {
        alert("Pilih Surat Pesanan dulu!");
        no_sp.focus();
    } else {
        contoh_print.style.display = "inline-block";
        print_pdf.style.display = "inline-block";
        contoh_printDiv.style.display = "block";
        fetch("/viewprint/" + no_spText.value)
            .then((response) => response.json())
            .then((data) => {
                console.log(data);
                console.log(data[0]["TGL_SP"]);
                tgl_pesanKolom.innerHTML = moment(data[0]["TGL_SP"]).format(
                    "DD-MM-YY"
                );
                nama_customerKolom.innerHTML = data[0]["NamaCust"];
                kota_customerKolom.innerHTML = data[0]["Kota"];
                no_poKolom.innerHTML = data[0]["NO_PO"];
                kode_barangKolom.innerHTML = data[0]["KodeBarang"];
                quantity_barangKolom.innerHTML = data[0]["JmlOrder"];
                nama_barangKolom.innerHTML = data[0]["NamaType"];
                syarat_bayarKolom.innerHTML =
                    "Rp. " +
                    numeral(data[0]["HargaSatuan"]).value() +
                    "/Kg + PPN <br>" +
                    "Term. " +
                    data[0]["SyaratBayar"] +
                    " Hari";
                nama_salesKolom.innerHTML = data[0]["NamaSales"];
                nama_managerKolom.innerHTML = data[0]["Manager"];
            })
            .finally(() => {
                $("#loading-screen").css("display", "none");
            });
    }
});

print_pdf.addEventListener("click", function (event) {
    event.preventDefault();
    window.print();
});

//#endregion

//#region function mantap-mantap

function formatDateToMMDDYYYY(dateString) {
    var formatted_date;
    if (dateString !== null) {
        var date = new Date(dateString);
        var year = date.getFullYear();
        var month = ("0" + (date.getMonth() + 1)).slice(-2);
        var day = ("0" + date.getDate()).slice(-2);
        formatted_date = month + "-" + day + "-" + year;
    } else {
        formatted_date = "";
    }
    return formatted_date;
}

function formatangka(objek) {
    console.log(objek);
    a = objek.toString().replace(/[^\d]/g, "");
    c = "";
    panjang = a.length;
    j = 0;
    for (i = panjang; i > 0; i--) {
        j = j + 1;
        if (j % 3 == 1 && j != 1) {
            c = a.substr(i - 1, 1) + "." + c;
        } else {
            c = a.substr(i - 1, 1) + c;
        }
    }
    return c;
}

//#endregion
