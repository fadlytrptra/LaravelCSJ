let tanggal = document.getElementById('tanggal');
let idBKK = document.getElementById('idBKK');
let mataUangSelect = document.getElementById('mataUangSelect');
let jumlahUang = document.getElementById('jumlahUang');
let namaBankSelect = document.getElementById('namaBankSelect');
let jenisPembayaranSelect  = document.getElementById('jenisPembayaranSelect');
let idKodePerkiraan = document.getElementById('idKodePerkiraan');
let kodePerkiraanSelect = document.getElementById('kodePerkiraanSelect');
let uraian = document.getElementById('uraian');
let idBankBKK = document.getElementById('idBankBKK');
let jenisBank = document.getElementById('jenisBank');
let idJenisPembayaran = document.getElementById('idJenisPembayaran');
let btnTambahBiaya = document.getElementById('btnTambahBiaya');
let cardBKM = document.getElementById('cardBKM');
let kodePerkiraanTambahBiayaSelect = document.getElementById('kodePerkiraanTambahBiayaSelect');
let idKodePerkiraanTambahBiaya = document.getElementById('idKodePerkiraanTambahBiaya');
let btnProsesTambahBiaya = document.getElementById('btnProsesTambahBiaya');
let jumlahBiaya = document.getElementById('jumlahBiaya');
let keterangan = document.getElementById('keterangan');
let idMataUang = document.getElementById('idMataUang');
let btnDetailBG = document.getElementById('btnDetailBG');
let namaJenisPembayaran = document.getElementById('namaJenisPembayaran');

//untuk card BKM
let tanggalBKM = document.getElementById('tanggalBKM');
let idBKM = document.getElementById('idBKM');
let mataUangBKMSelect = document.getElementById('mataUangBKMSelect');
let kurs = document.getElementById('kurs');
let jumlahUangBKM = document.getElementById('jumlahUangBKM');
let namaBankBKMSelect = document.getElementById('namaBankBKMSelect');
let jenisPembayaranBKMSelect = document.getElementById('jenisPembayaranBKMSelect');
let btnTambahBiayaBKM = document.getElementById('btnTambahBiayaBKM');
let kodePerkiraanBKMSelect = document.getElementById('kodePerkiraanBKMSelect');
let idKodePerkiraanBKMSelect = document.getElementById('idKodePerkiraanBKMSelect');
let uraianBKM = document.getElementById('uraianBKM');
let idBankBKM = document.getElementById('idBankBKM');
let jenisBankBKM = document.getElementById('jenisBankBKM');
let idJenisPembayaranBKM = document.getElementById('idJenisPembayaranBKM');
let idMataUangBKM = document.getElementById('idMataUangBKM');
let btnProsesDetailBG = document.getElementById('btnProsesDetailBG');

//MODAL TAMBAH BIAYA BKM
let methodTambahBiayaBKM = document.getElementById('methodTambahBiayaBKM');
let formTambahBiayaBKM = document.getElementById('formTambahBiayaBKM');
let modalTambahBiayaBKM = document.getElementById('modalTambahBiayaBKM');
let btnProsesTambahBiayaBKM = document.getElementById('btnProsesTambahBiayaBKM');
let jumlahBiayaBKM = document.getElementById('jumlahBiayaBKM');
let kodePerkiraanBKMTSelect = document.getElementById('kodePerkiraanBKMTSelect');
let keteranganBKM = document.getElementById('keteranganBKM');
let idKodePerkiraanBKMT = document.getElementById('idKodePerkiraanBKMT');

let tabelDetailBiayaBKK = document.getElementById('tabelDetailBiayaBKK');
let tabelDetailBG = document.getElementById('tabelDetailBG');
let tabelDetailBiayaBKM = document.getElementById('tabelDetailBiayaBKM');
let selectedRowsDetailBiayaBKK = [];
let selectedRowsDetailBG = [];
let selectedRowsDetailBiayaBKM = [];
let methodDetailBG = document.getElementById('methodDetailBG');
let formDetailBG = document.getElementById('formDetailBG');
let proses;

//MODAL DETAIL BG
let bank = document.getElementById('bank');
let jenisPembayaran = document.getElementById('jenisPembayaran');
let nomor = document.getElementById('nomor');
let jatuhTempo = document.getElementById('jatuhTempo');
let statusCetak = document.getElementById('statusCetak');

let btnKoreksiBiayaBKK = document.getElementById('btnKoreksiBiayaBKK');
let btnKoreksiDetailBG = document.getElementById('btnKoreksiDetailBG');
let btnKoreksiBiayaBKM = document.getElementById('btnKoreksiBiayaBKM');

//BUTTON BAWAH
let btnBatal = document.getElementById('btnBatal');
let btnOkTampilBKM = document.getElementById('btnOkTampilBKM');
let btnOkTampilBKK = document.getElementById('btnOkTampilBKK');

//TAMPIL BKM
let tanggalInputTampilBKM = document.getElementById('tanggalInputTampilBKM');
let tanggalInputTampilBKM2 = document.getElementById('tanggalInputTampilBKM2');
let idTampilBKM = document.getElementById('idTampilBKM');
let btnCetakBKM = document.getElementById('btnCetakBKM');
let formTampilBKM =  document.getElementById('formTampilBKM');
let methodTampilBKM = document.getElementById('methodTampilBKM')

//TAMPIL BKK
let tanggalInputTampilBKK = document.getElementById('tanggalInputTampilBKK');
let tanggalInputTampilBKK2 = document.getElementById('tanggalInputTampilBKK2');
let idTampilBKK = document.getElementById('idTampilBKK');
let btnCetakBKK = document.getElementById('btnCetakBKK');
let tglCetakBKK = document.getElementById('tglCetakBKK');
let formTampilBKK = document.getElementById('formTampilBKK');
let methodTampilBKK = document.getElementById('methodTampilBKK');

const tgl = new Date();
const formattedDate = tgl.toISOString().substring(0, 10);
tanggal.value = formattedDate;

const tglbkm = new Date();
const formattedDate2 = tglbkm.toISOString().substring(0, 10);
tanggalBKM.value = formattedDate2;

const tgljatuhtempo = new Date();
const formattedDate3 = tgljatuhtempo.toISOString().substring(0, 10);
jatuhTempo.value = formattedDate3;

btnBatal.addEventListener('click', function(event) {
    event.preventDefault();

    tanggal.value = "";
    idBKK.value = "";
    mataUangSelect.selectedIndex = 0;
    idMataUang.value = "";
    jumlahUang.value = "";
    namaBankSelect.selectedIndex = 0;
    idBankBKK.value = "";
    jenisBank.value = "";
    jenisPembayaranSelect.selectedIndex = 0;
    idJenisPembayaran.value = "";
    namaJenisPembayaran.value = "";
    kodePerkiraanSelect.selectedIndex = 0;
    idKodePerkiraan.value = "";
    uraian.value = "";

    //CARD BKM
    tanggalBKM.value = "";
    idBKM.value = "";
    mataUangSelect.selectedIndex = 0;
    idMataUangBKM.value = "";
    kurs.value = "";
    jumlahUangBKM.value = "";
    namaBankBKMSelect.selectedIndex = 0;
    idBankBKM.value = "";
    jenisBankBKM.value = "";
    jenisPembayaranBKMSelect.selectedIndex = 0;
    idJenisPembayaranBKM.value = "";
    kodePerkiraanBKMSelect.selectedIndex = 0;
    idKodePerkiraanBKMSelect.value = "";
    uraianBKM.value = "";

})

tanggal.addEventListener('keypress', function (event) {
    event.preventDefault();
    mataUangSelect.focus();
});

mataUangSelect.addEventListener('click', function (event) {
    event.preventDefault();
});;

kodePerkiraanSelect.addEventListener('click', function (event) {
    event.preventDefault();
});

kodePerkiraanSelect.addEventListener("change", function (event) {
    event.preventDefault();
    const selectedOption = kodePerkiraanSelect.options[kodePerkiraanSelect.selectedIndex];
    if (selectedOption) {
        const selectedValue = selectedOption.value; // Nilai dari opsi yang dipilih (format: "id | nama")
        const idBank = selectedValue.split(" | ")[0];
        idKodePerkiraan.value = idBank;
    }
});

//#region ambil list mata uang
fetch("/getmatauang/")
        .then((response) => response.json())
        .then((options) => {
            console.log(options);
            mataUangSelect.innerHTML="";

            const defaultOption = document.createElement("option");
            defaultOption.disabled = true;
            defaultOption.selected = true;
            defaultOption.innerText = "Mata Uang";
            mataUangSelect.appendChild(defaultOption);

            options.forEach((entry) => {
                const option = document.createElement("option");
                option.value = entry.Id_MataUang;
                option.innerText = entry.Id_MataUang + "|" + entry.Nama_MataUang;
                mataUangSelect.appendChild(option);
            });
        });
//#endregion

//#region ambil list bank
fetch("/getbank/")
    .then((response) => response.json())
    .then((options) => {
        console.log(options);
        namaBankSelect.innerHTML = "";

        const defaultOption = document.createElement("option");
        defaultOption.disabled = true;
        defaultOption.selected = true;
        defaultOption.innerText = "Bank";
        namaBankSelect.appendChild(defaultOption);

        options.forEach((entry) => {
            const option = document.createElement("option");
            option.value = entry.Id_Bank;
            option.innerText = entry.Id_Bank + "|" + entry.Nama_Bank;
            namaBankSelect.appendChild(option);
        });

});
//#endregion

//#region ambil list jenis bayar
fetch("/getjenispembayaran/")
    .then((response) => response.json())
    .then((options) => {
        console.log(options);
        jenisPembayaranSelect.innerHTML = "";

        const defaultOption = document.createElement("option");
        defaultOption.disabled = true;
        defaultOption.selected = true;
        defaultOption.innerText = "Jenis Pembayaran";
        jenisPembayaranSelect.appendChild(defaultOption);

        options.forEach((entry) => {
            const option = document.createElement("option");
            option.value = entry.Id_Jenis_Bayar;
            option.innerText = entry.Id_Jenis_Bayar + "|" + entry.Jenis_Pembayaran;
            jenisPembayaranSelect.appendChild(option);
        });

});
//#endregion

//#region ambil list kode perkiraan
fetch("/getkodeperkiraan/")
    .then((response) => response.json())
    .then((options) => {
        console.log(options);
        kodePerkiraanSelect.innerHTML = "";

        const defaultOption = document.createElement("option");
        defaultOption.disabled = true;
        defaultOption.selected = true;
        defaultOption.innerText = "Kode Perkiraan";
        kodePerkiraanSelect.appendChild(defaultOption);

        options.forEach((entry) => {
            const option = document.createElement("option");
            option.value = entry.NoKodePerkiraan;
            option.innerText = entry.NoKodePerkiraan + "|" + entry.Keterangan;
            kodePerkiraanSelect.appendChild(option);
        });
});
//#endregion

mataUangSelect.addEventListener("change", function (event) {
    event.preventDefault();
    const selectedOption = mataUangSelect.options[mataUangSelect.selectedIndex];
    if (selectedOption) {
        const idKodeInput = document.getElementById('idMataUang');
        const selectedValue = selectedOption.textContent;
        const idMU = selectedValue.split("|")[0];
        idKodeInput.value = idMU;
    }
});

jumlahUang.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        let jumlah = parseFloat(jumlahUang.value);
        // let kurs = parseFloat(kursRupiah.value);

        if (jumlah === '0.00') {
            alert('Jumlah Uang TIDAK BOLEH = 0 !');
            jumlahUang.focus();
        } else {
            let formattedJumlah = jumlah.toFixed(2);
            jumlahUang.value = formattedJumlah;
        }
    }
});

namaBankSelect.addEventListener("change", function (event) {
    event.preventDefault();
    // console.log(idBank.value);
    const selectedOption = namaBankSelect.options[namaBankSelect.selectedIndex];
    if (selectedOption) {
        //const idJenisInput = document.getElementById('idBank');
        const selectedValue = selectedOption.value; // Nilai dari opsi yang dipilih (format: "id | nama")
        const idJenis = selectedValue.split("|")[0];
        idBankBKK.value = idJenis;
        //console.log(idBank.value);
        fetch("/detailjenisbank/" + idBankBKK.value)
            .then((response) => response.json())
            .then((options) => {
                jenisBank.value = options[0].jenis;
                console.log(options);
            });
    }
});

jenisPembayaranSelect.addEventListener("change", function (event) {
    event.preventDefault();
    // console.log(idBank.value);
    const selectedOption = jenisPembayaranSelect.options[jenisPembayaranSelect.selectedIndex];
    if (selectedOption) {
        const idJenisInput = document.getElementById('idJenisPembayaran');
        const selectedValue = selectedOption.textContent; // Nilai dari opsi yang dipilih (format: "id | nama")
        const idJenis = selectedValue.split("|")[0];
        const namaJenis = selectedValue.split("|")[1];
        idJenisInput.value = idJenis;
        namaJenisPembayaran.value = namaJenis;
    }
});

uraian.addEventListener("keypress", function (event) {
    if (event.key == "Enter") {
        event.preventDefault();
        jenis = 'P';

        if (idBKK.value === "") {
            if (idBankBKK.value == "KRR1") {
                idBankBKK.value = "KI";
            }
            else if (idBankBKK.value == "KRR2") {
                idBankBKK.value = "KKM";
            }
        } else {
            idBankBKK = idBankBKK.value;
        }

        fetch("/getidbkk/" + idBankBKK.value + "/" + tanggal.value)
            .then((response) => response.json())
            .then((options) => {
                console.log(options);
                idBKK.value = options;
            });

            var adaBiaya = confirm('Apakah ada BIAYA?');
            if (adaBiaya) {
                btnTambahBiaya.disabled = false; // Aktifkan tombol jika ada biaya
            } else {
                btnTambahBiaya.disabled = true;  // Nonaktifkan tombol jika tidak ada biaya
                if (cardBKM.classList.contains('disabled')) {
                    cardBKM.classList.remove('disabled'); // Mengaktifkan card
                }
            }
    }
});

kodePerkiraanTambahBiayaSelect.addEventListener("change", function (event) {
    event.preventDefault();
    const selectedOption = kodePerkiraanTambahBiayaSelect.options[kodePerkiraanTambahBiayaSelect.selectedIndex];
    if (selectedOption) {
        const selectedValue = selectedOption.value; // Nilai dari opsi yang dipilih (format: "id | nama")
        const idkp = selectedValue.split(" | ")[0];
        idKodePerkiraanTambahBiaya.value = idkp;
    }
});

btnTambahBiaya.addEventListener('click', function (event) {
    event.preventDefault();
    modalTambahBiaya = $("#modalTambahBiaya");
    modalTambahBiaya.modal('show');
    proses = 1;

    fetch("/getkodeperkiraan/")
    .then((response) => response.json())
    .then((options) => {
        console.log(options);
        kodePerkiraanTambahBiayaSelect.innerHTML = "";

        const defaultOption = document.createElement("option");
        defaultOption.disabled = true;
        defaultOption.selected = true;
        defaultOption.innerText = "Kode Perkiraan";
        kodePerkiraanTambahBiayaSelect.appendChild(defaultOption);

        options.forEach((entry) => {
            const option = document.createElement("option");
            option.value = entry.NoKodePerkiraan;
            option.innerText = entry.NoKodePerkiraan + "|" + entry.Keterangan;
            kodePerkiraanTambahBiayaSelect.appendChild(option);
        });
    });
})

btnDetailBG.addEventListener('click', function (event) {
    event.preventDefault();
    modalDetailBG = $("#modalDetailBG");
    modalDetailBG.modal('show');
    proses = 3;

    bank.value = namaBankSelect.value;
    jenisPembayaran.value = namaJenisPembayaran.value;
});

tabelDetailBiayaBKK = $('#tabelDetailBiayaBKK').DataTable({
    // Opsi kolom yang ditampilkan
    columns: [
        {
            title: 'Keterangan',
            render: function (data, type, row) {
                return `<input type="checkbox" class="row-checkbox" /> ${row[0]}`;
            },
        },
        { title: 'Biaya' },
        { title: 'Kode Perkiraan' }
    ],
});

tabelDetailBG = $('#tabelDetailBG').DataTable({
    // Opsi kolom yang ditampilkan
    columns: [
        {
            title: 'Nomor',
            render: function (data, type, row) {
                return `<input type="checkbox" class="row-checkbox" /> ${row[0]}`;
            },
        },
        { title: 'Jatuh Tempo' },
        { title: 'Status Cetak' }
    ],
});

//#region BTN PROSES DI MODAL TAMBAH BIAYA / KOREKSI DETAIL BKK
btnProsesTambahBiaya.addEventListener ("click", function (event) {
    event.preventDefault();
    if (proses == 1) {
        // console.log("masuk isi");

        const Keterangan = keterangan.value;
        console.log(keterangan.value);
        const Biaya = jumlahBiaya.value;
        const KodePerkiraan = idKodePerkiraanTambahBiaya.value;

        // Tambahkan data ke dalam DataTable
        tabelDetailBiayaBKK.row.add([
            Keterangan,
            Biaya,
            KodePerkiraan
        ]).draw();
        modalTambahBiaya = $("#modalTambahBiaya");
        modalTambahBiaya.modal('hide');

    } else if (proses == 2) {
        const Keterangan = $('#keterangan').val();
        const Biaya = $('#jumlahBiaya').val();
        const KodePerkiraan = idKodePerkiraanTambahBiaya.value;

        const selectedRow = selectedRowsDetailBiayaBKK[selectedRowsDetailBiayaBKK.length - 1];
        selectedRow[0] = Keterangan;
        selectedRow[1] = Biaya;
        selectedRow[2] = KodePerkiraan;

        // Dapatkan indeks baris terpilih di tabel dan ubah nilai kolomnya
        const rowIndex = selectedRowsDetailBiayaBKK.length - 1;
        const tableRow = tabelDetailBiayaBKK.row(rowIndex).node();
        $(tableRow).find('td:eq(1)').text(Biaya);
        $(tableRow).find('td:eq(2)').text(KodePerkiraan);
        $(tableRow).find('.row-checkbox').data('keterangan', Keterangan);

        modalTambahBiaya.modal('hide');
        }
});

//#endregion

//#region BUTTON PROSES TABEL DETAIL BG
btnProsesDetailBG.addEventListener('click', function(event) {
    event.preventDefault();
    if (proses == 3) {
        // console.log("masuk isi");
        const Nomor = nomor.value;
        const JatuhTempo = jatuhTempo.value;
        const StatusCetak = statusCetak.value;

        // Tambahkan data ke dalam DataTable
        tabelDetailBG.row.add([
            Nomor,
            JatuhTempo,
            StatusCetak
        ]).draw();
        modalDetailBG = $("#modalDetailBG");
        modalDetailBG.modal('hide');

    } else if (proses == 4) {
        const Nomor = $('#nomor').val();
        const JatuhTempo = $('#jatuhTempo').val();
        const StatusCetak = $('#statusCetak').val();

        const selectedRow = selectedRowsDetailBG[selectedRowsDetailBG.length - 1];
        selectedRow[0] = Nomor;
        selectedRow[1] = JatuhTempo;
        selectedRow[2] = StatusCetak;

        // Dapatkan indeks baris terpilih di tabel dan ubah nilai kolomnya
        const rowIndex = selectedRowsDetailBG.length - 1;
        const tableRow = tabelDetailBG.row(rowIndex).node();
        $(tableRow).find('td:eq(1)').text(JatuhTempo);
        $(tableRow).find('td:eq(2)').text(StatusCetak);
        $(tableRow).find('.row-checkbox').data('keterangan', Nomor);

        modalDetailBG.modal('hide');
        }
});
//#endregion


// UNTUK CARD BKM

//#region untuk ambil liat mata uang untuk BKM
fetch("/getmatauang/")
        .then((response) => response.json())
        .then((options) => {
            console.log(options);
            mataUangBKMSelect.innerHTML="";

            const defaultOption = document.createElement("option");
            defaultOption.disabled = true;
            defaultOption.selected = true;
            defaultOption.innerText = "Mata Uang";
            mataUangBKMSelect.appendChild(defaultOption);

            options.forEach((entry) => {
                const option = document.createElement("option");
                option.value = entry.Id_MataUang;
                option.innerText = entry.Id_MataUang + "|" + entry.Nama_MataUang;
                mataUangBKMSelect.appendChild(option);
            });

        });
//#endregion

//#region ambil list bank (BKM)
fetch("/getbank/")
    .then((response) => response.json())
    .then((options) => {
        console.log(options);
        namaBankBKMSelect.innerHTML = "";

        const defaultOption = document.createElement("option");
        defaultOption.disabled = true;
        defaultOption.selected = true;
        defaultOption.innerText = "Bank";
        namaBankBKMSelect.appendChild(defaultOption);

        options.forEach((entry) => {
            const option = document.createElement("option");
            option.value = entry.Id_Bank;
            option.innerText = entry.Id_Bank + "|" + entry.Nama_Bank;
            namaBankBKMSelect.appendChild(option);
        });

});
//#endregion

//#region ambil jenis bayar BKM
fetch("/getjenispembayaran/")
    .then((response) => response.json())
    .then((options) => {
        console.log(options);
        jenisPembayaranBKMSelect.innerHTML = "";

        const defaultOption = document.createElement("option");
        defaultOption.disabled = true;
        defaultOption.selected = true;
        defaultOption.innerText = "Jenis Pembayaran";
        jenisPembayaranBKMSelect.appendChild(defaultOption);

        options.forEach((entry) => {
            const option = document.createElement("option");
            option.value = entry.Id_Jenis_Bayar;
            option.innerText = entry.Id_Jenis_Bayar + "|" + entry.Jenis_Pembayaran;
            jenisPembayaranBKMSelect.appendChild(option);
        });

});
//#endregion

//#region ambil kodeperkiraan
fetch("/getkodeperkiraan/")
    .then((response) => response.json())
    .then((options) => {
        console.log(options);
        kodePerkiraanBKMSelect.innerHTML = "";

        const defaultOption = document.createElement("option");
        defaultOption.disabled = true;
        defaultOption.selected = true;
        defaultOption.innerText = "Kode Perkiraan";
        kodePerkiraanBKMSelect.appendChild(defaultOption);

        options.forEach((entry) => {
            const option = document.createElement("option");
            option.value = entry.NoKodePerkiraan;
            option.innerText = entry.NoKodePerkiraan + "|" + entry.Keterangan;
            kodePerkiraanBKMSelect.appendChild(option);
        });
});
//#endregion

kodePerkiraanBKMTSelect.addEventListener("change", function (event) {
    event.preventDefault();
    const selectedOption = kodePerkiraanBKMTSelect.options[kodePerkiraanBKMTSelect.selectedIndex];
    if (selectedOption) {
        const selectedValue = selectedOption.value; // Nilai dari opsi yang dipilih (format: "id | nama")
        const idkp = selectedValue.split(" | ")[0];
        idKodePerkiraanBKMT.value = idkp;
    }
});

tanggalBKM.addEventListener('keypress', function (event) {
    event.preventDefault();
    mataUangBKMSelect.focus();
});

namaBankBKMSelect.addEventListener("change", function (event) {
    event.preventDefault();
    // console.log(idBank.value);
    const selectedOption = namaBankBKMSelect.options[namaBankBKMSelect.selectedIndex];
    if (selectedOption) {
        //const idJenisInput = document.getElementById('idBank');
        const selectedValue = selectedOption.value; // Nilai dari opsi yang dipilih (format: "id | nama")
        const idJenis = selectedValue.split("|")[0];
        idBankBKM.value = idJenis;
        //console.log(idBank.value);
        fetch("/detailjenisbank/" + idBankBKM.value)
            .then((response) => response.json())
            .then((options) => {
                jenisBankBKM.value = options[0].jenis;
                console.log(options);
            });
    }
});

mataUangBKMSelect.addEventListener('change', function (event) {
    event.preventDefault();
});

mataUangBKMSelect.addEventListener("change", function (event) {
    event.preventDefault();
    const selectedOption = mataUangBKMSelect.options[mataUangBKMSelect.selectedIndex];
    if (selectedOption) {
        const idKodeInput = document.getElementById('idMataUangBKM');
        const selectedValue = selectedOption.textContent;
        const idMU = selectedValue.split("|")[0];
        idKodeInput.value = idMU;
    }
});

jenisPembayaranBKMSelect.addEventListener("change", function (event) {
    event.preventDefault();
    // console.log(idBank.value);
    const selectedOption = jenisPembayaranBKMSelect.options[jenisPembayaranBKMSelect.selectedIndex];
    if (selectedOption) {
        const idJenisInput = document.getElementById('idJenisPembayaranBKM');
        const selectedValue = selectedOption.textContent; // Nilai dari opsi yang dipilih (format: "id | nama")
        const idJenis = selectedValue.split("|")[0];
        idJenisInput.value = idJenis;
    }
});

kodePerkiraanBKMSelect.addEventListener('click', function (event) {
    event.preventDefault();
});

kodePerkiraanBKMSelect.addEventListener("change", function (event) {
    event.preventDefault();
    const selectedOption = kodePerkiraanBKMSelect.options[kodePerkiraanBKMSelect.selectedIndex];
    if (selectedOption) {
        const selectedValue = selectedOption.value; // Nilai dari opsi yang dipilih (format: "id | nama")
        const idBank = selectedValue.split(" | ")[0];
        idKodePerkiraanBKMSelect.value = idBank;
    }
});

kurs.addEventListener("keypress", function (event) {
    if (event.key == "Enter") {
        event.preventDefault();
        if (parseFloat(kurs.value) > 0) {
            if (idMataUang.value === "1" && idMataUangBKM.value !== "1") {
                let total = parseFloat(jumlahUang.value.replace(/,/g, "")) / parseFloat(kurs.value.replace(/,/g, ""));
                jumlahUangBKM.value = formatNumber(total, "###,###,##0.00");
            } else if (idMataUang.value !== "1" && idMataUangBKM.value === "1") {
                let total = parseFloat(jumlahUang.value.replace(/,/g, "")) * parseFloat(kurs.value.replace(/,/g, ""));
                jumlahUangBKM.value = formatNumber(total, "###,###,##0.00");
            }

        } else {
            alert('Nilai kurs Rupiah harus lebih besar dari 0!');
        }
    }
});

btnTambahBiayaBKM.addEventListener('click', function(event) {
    event.preventDefault();
    modalTambahBiayaBKM = $("#modalTambahBiayaBKM");
    modalTambahBiayaBKM.modal('show');
    proses = 5;

    fetch("/getkodeperkiraan/")
    .then((response) => response.json())
    .then((options) => {
        console.log(options);
        kodePerkiraanBKMTSelect.innerHTML = "";

        const defaultOption = document.createElement("option");
        defaultOption.disabled = true;
        defaultOption.selected = true;
        defaultOption.innerText = "Kode Perkiraan";
        kodePerkiraanBKMTSelect.appendChild(defaultOption);

        options.forEach((entry) => {
            const option = document.createElement("option");
            option.value = entry.NoKodePerkiraan;
            option.innerText = entry.NoKodePerkiraan + "|" + entry.Keterangan;
            kodePerkiraanBKMTSelect.appendChild(option);
        });
    });
});

uraianBKM.addEventListener("keypress", function (event) {
    if (event.key == "Enter") {
        event.preventDefault();
        jenis = 'P';

        if (idBKM.value === "") {
            if (idBankBKM.value == "KRR1") {
                idBankBKM.value = "KI";
            }
            else if (idBankBKM.value == "KRR2") {
                idBankBKM.value = "KKM";
            }
        } else {
            idBankBKM = idBankBKM.value;
        }

        fetch("/getidbkmtransitoris/" + idBankBKM.value + "/" + tanggalBKM.value)
            .then((response) => response.json())
            .then((options) => {
                console.log(options);
                idBKM.value = options;
            });

            var adaBiaya = confirm('Apakah ada BIAYA?');
            if (adaBiaya) {
                btnTambahBiayaBKM.disabled = false; // Aktifkan tombol jika ada biaya
            } else {
                btnTambahBiayaBKM.disabled = true;
            }
    }
});


function formatNumber(number, format) {
    return number.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,");
}

//TABEL KANAN
$("#tabelDetailBiayaBKK tbody").off("click", "input[type='checkbox'");
$("#tabelDetailBiayaBKK tbody").off("change", "input[type='checkbox']");
$("#tabelDetailBiayaBKK tbody").on("change", "input[type='checkbox']", function () {
});
$("#tabelDetailBiayaBKK").on('change', '.row-checkbox', function () {
    const isChecked = $(this).is(':checked');
    const row = $(this).closest('tr');
    const rowData = [];

    row.find('td').each(function () {
        rowData.push($(this).text());
    });

    if (isChecked) {
        // Checkbox dicentang
        console.log('Checkbox dicentang pada baris:', rowData);
        selectedRowsDetailBiayaBKK.push(rowData);
    } else {
        // Checkbox tidak dicentang
        console.log('Checkbox tidak dicentang pada baris:', rowData);
        selectedRowsDetailBiayaBKK = selectedRowsDetailBiayaBKK.filter(data => data[0] !== rowData[0]);
    }
});

$("#tabelDetailBG tbody").off("click", "input[type='checkbox'");
$("#tabelDetailBG tbody").off("change", "input[type='checkbox']");
$("#tabelDetailBG tbody").on("change", "input[type='checkbox']", function () {
});
$("#tabelDetailBG").on('change', '.row-checkbox', function () {
    const isChecked = $(this).is(':checked');
    const row = $(this).closest('tr');
    const rowData = [];

    row.find('td').each(function () {
        rowData.push($(this).text());
    });

    if (isChecked) {
        // Checkbox dicentang
        console.log('Checkbox dicentang pada baris:', rowData);
        selectedRowsDetailBG.push(rowData);
    } else {
        // Checkbox tidak dicentang
        console.log('Checkbox tidak dicentang pada baris:', rowData);
        selectedRowsDetailBG = selectedRowsDetailBG.filter(data => data[0] !== rowData[0]);
    }
});

$("#tabelDetailBiayaBKM tbody").off("click", "input[type='checkbox'");
$("#tabelDetailBiayaBKM tbody").off("change", "input[type='checkbox']");
$("#tabelDetailBiayaBKM tbody").on("change", "input[type='checkbox']", function () {
});
$("#tabelDetailBiayaBKM").on('change', '.row-checkbox', function () {
    const isChecked = $(this).is(':checked');
    const row = $(this).closest('tr');
    const rowData = [];

    row.find('td').each(function () {
        rowData.push($(this).text());
    });

    if (isChecked) {
        // Checkbox dicentang
        console.log('Checkbox dicentang pada baris:', rowData);
        selectedRowsDetailBiayaBKM.push(rowData);
    } else {
        // Checkbox tidak dicentang
        console.log('Checkbox tidak dicentang pada baris:', rowData);
        selectedRowsDetailBiayaBKM = selectedRowsDetailBiayaBKM.filter(data => data[0] !== rowData[0]);
    }
});

btnKoreksiBiayaBKK.addEventListener('click', function(event) {
    event.preventDefault();
    modalTambahBiaya = $("#modalTambahBiaya");
    modalTambahBiaya.modal('show');
    proses = 2;

    if (selectedRowsDetailBiayaBKK.length > 0) {
        const lastSelectedRow = selectedRowsDetailBiayaBKK[selectedRowsDetailBiayaBKK.length - 1];
        console.log(lastSelectedRow);
        $('#keterangan').val(lastSelectedRow[0]);
        $('#jumlahBiaya').val(lastSelectedRow[1]);

        const kodePerkiraan = lastSelectedRow[2];
        const options2 = kodePerkiraanTambahBiayaSelect.options;
        for (let i = 0; i < options2.length; i++) {
            if (options2[i].value === kodePerkiraan) {
                // Setel select option jenisPembayaranSelect sesuai dengan opsi yang cocok
                kodePerkiraanTambahBiayaSelect.selectedIndex = i;
                const selectedOption = kodePerkiraanTambahBiayaSelect.options[kodePerkiraanTambahBiayaSelect.selectedIndex];
                if (selectedOption) {
                    const selectedValue = selectedOption.value; // Nilai dari opsi yang dipilih (format: "id | nama")
                    const idBank = selectedValue.split(" | ")[0];
                    idKodePerkiraanTambahBiaya.value = idBank;
                }
                break;
            }}
        }
})

btnKoreksiBiayaBKM.addEventListener('click', function(event) {
    event.preventDefault();
    modalTambahBiayaBKM = $("#modalTambahBiayaBKM");
    modalTambahBiayaBKM.modal('show');
    proses = 6;

    if (selectedRowsDetailBiayaBKM.length > 0) {
        const lastSelectedRow = selectedRowsDetailBiayaBKM[selectedRowsDetailBiayaBKM.length - 1];
        console.log(lastSelectedRow);
        $('#jumlahBiayaBKM').val(lastSelectedRow[1]);
        $('#keteranganBKM').val(lastSelectedRow[0]);
        const kodePerkiraan = lastSelectedRow[2];
        const options2 = kodePerkiraanBKMTSelect.options;
        for (let i = 0; i < options2.length; i++) {
            if (options2[i].value === kodePerkiraan) {
                // Setel select option jenisPembayaranSelect sesuai dengan opsi yang cocok
                kodePerkiraanBKMTSelect.selectedIndex = i;
                const selectedOption = kodePerkiraanBKMTSelect.options[kodePerkiraanBKMTSelect.selectedIndex];
                if (selectedOption) {
                    const selectedValue = selectedOption.value; // Nilai dari opsi yang dipilih (format: "id | nama")
                    const idBank = selectedValue.split(" | ")[0];
                    idKodePerkiraanBKMT.value = idBank;
                }
                break;
            }}

    }
})

btnKoreksiDetailBG.addEventListener('click', function(event) {
    event.preventDefault();
    modalDetailBG = $("#modalDetailBG");
    modalDetailBG.modal('show');
    proses = 4;

    if (selectedRowsDetailBG.length > 0) {
        const lastSelectedRow = selectedRowsDetailBG[selectedRowsDetailBG.length - 1];
        console.log(lastSelectedRow);
        $('#nomor').val(lastSelectedRow[0]);
        $('#jatuhTempo').val(lastSelectedRow[1]);
        $('#statusCetak').val(lastSelectedRow[2]);
    }
})

tabelDetailBiayaBKM = $('#tabelDetailBiayaBKM').DataTable({
    // Opsi kolom yang ditampilkan
    columns: [
        {
            title: 'Keterangan',
            render: function (data, type, row) {
                return `<input type="checkbox" class="row-checkbox" /> ${row[0]}`;
            },
        },
        { title: 'Biaya' },
        { title: 'Kode Perkiraan' }
    ],
});

btnProsesTambahBiayaBKM.addEventListener ("click", function (event) {
    event.preventDefault();
    if (proses == 5) {
        // console.log("masuk isi");

        const Keterangan = keteranganBKM.value;
        console.log(keteranganBKM.value);
        const Biaya = jumlahBiayaBKM.value;
        const KodePerkiraan = idKodePerkiraanBKMT.value;

        // Tambahkan data ke dalam DataTable
        tabelDetailBiayaBKM.row.add([
            Keterangan,
            Biaya,
            KodePerkiraan
        ]).draw();
        modalTambahBiayaBKM = $("#modalTambahBiayaBKM");
        modalTambahBiayaBKM.modal('hide');

    } else if (proses == 6) {
        const Keterangan = $('#keteranganBKM').val();
        const Biaya = $('#jumlahBiayaBKM').val();
        const KodePerkiraan = idKodePerkiraanBKMT.value;

        const selectedRow = selectedRowsDetailBiayaBKM[selectedRowsDetailBiayaBKM.length - 1];
        selectedRow[0] = Keterangan;
        selectedRow[1] = Biaya;
        selectedRow[2] = KodePerkiraan;

        // Dapatkan indeks baris terpilih di tabel dan ubah nilai kolomnya
        const rowIndex = selectedRowsDetailBiayaBKM.length - 1;
        const tableRow = tabelDetailBiayaBKM.row(rowIndex).node();
        $(tableRow).find('td:eq(1)').text(Biaya);
        $(tableRow).find('td:eq(2)').text(KodePerkiraan);
        $(tableRow).find('.row-checkbox').data('keterangan', Keterangan);

        modalTambahBiayaBKM.modal('hide');
        }
});

//#region UNTUK MODAL TAMPIL BKM
btnTampilBKM.addEventListener('click', function(event) {
    event.preventDefault();
    modalTampilBKM = $("#modalTampilBKM");
    modalTampilBKM.modal('show');

    const tglbkm = new Date();
    const formattedDate4 = tglbkm.toISOString().substring(0, 10);
    tanggalInputTampilBKM.value = formattedDate4;

    const tglbkm2 = new Date();
    const formattedDate5 = tglbkm2.toISOString().substring(0, 10);
    tanggalInputTampilBKM2.value = formattedDate5;
});

btnOkTampilBKM.addEventListener('click', function(event) {
    event.preventDefault();
    fetch("/tabeltampilbkmtransitoris/" + tanggalInputTampilBKM.value + "/" + tanggalInputTampilBKM2.value)
        .then((response) => response.json())
        .then((options) => {
            console.log(options);
            tabelTampilBKM = $("#tabelTampilBKM").DataTable({
                data: options,
                columns: [
                    {
                        title: "Tgl. Input", data: "Tgl_Input",
                        render: function (data) {
                            var date = new Date(data);
                            var formattedDate = date.toLocaleDateString();

                            return `<div>
                                        <input type="checkbox" name="dataCheckbox" value="${formattedDate}" />
                                        <span>${formattedDate}</span>
                                    </div>`;
                        }
                    },
                    { title: "Id. BKM", data: "Id_BKM" },
                    { title: "Nilai Pelunasan", data: "Nilai_Pelunasan" },
                    { title: "Terjemahan", data: "Terjemahan" },
                ]
            });

            let lastCheckedCheckbox = null;

            tabelTampilBKM.on('change', 'input[name="dataCheckbox"]', function() {
                if (lastCheckedCheckbox && lastCheckedCheckbox !== this) {
                    lastCheckedCheckbox.checked = false;
                }
                lastCheckedCheckbox = this;

                const checkedCheckbox = tabelTampilBKM.row($(this).closest('tr')).data();
                const idTampilBKM = document.getElementById("idTampilBKM");

                if ($(this).prop("checked")) {
                    idTampilBKM.value = checkedCheckbox.Id_BKM;
                } else {
                    idTampilBKM.value = "";
                }
            });
        });
});

btnCetakBKM.addEventListener('click', function(event) {
    event.preventDefault();

    methodTampilBKM.value="PUT";
    formTampilBKM.action = "/BKMTransitorisBank/" + idTampilBKM.value;
    console.log(idTampilBKM.value);
    formTampilBKM.submit();

});
//#endregion

//#region UNTUK MODAL TAMPIL BKK
btnTampilBKK.addEventListener('click', function(event) {
    event.preventDefault();
    modalTampilBKK = $("#modalTampilBKK");
    modalTampilBKK.modal('show');

    const tglbkk = new Date();
    const formattedDate4 = tglbkk.toISOString().substring(0, 10);
    tanggalInputTampilBKK.value = formattedDate4;

    const tglbkk2 = new Date();
    const formattedDate5 = tglbkk2.toISOString().substring(0, 10);
    tanggalInputTampilBKK2.value = formattedDate5;
});

btnOkTampilBKK.addEventListener('click', function(event) {
    event.preventDefault();
    fetch("/tabeltampilbkktransitoris/" + tanggalInputTampilBKK.value + "/" + tanggalInputTampilBKK2.value)
        .then((response) => response.json())
        .then((options) => {
            console.log(options);
            tabelTampilBKK = $("#tabelTampilBKK").DataTable({
                data: options,
                columns: [
                    {
                        title: "Tgl. Input", data: "Tgl_Input",
                        render: function (data) {
                            var date = new Date(data);
                            var formattedDate = date.toLocaleDateString();

                            return `<div>
                                        <input type="checkbox" name="dataCheckbox" value="${formattedDate}" />
                                        <span>${formattedDate}</span>
                                    </div>`;
                        }
                    },
                    { title: "Id. BKK", data: "Id_BKK" },
                    { title: "Nilai Pelunasan", data: "Nilai_Pembulatan" },
                    { title: "Terjemahan", data: "Terjemahan" },
                ]
            });

            let lastCheckedCheckbox = null;

            tabelTampilBKK.on('change', 'input[name="dataCheckbox"]', function() {
                if (lastCheckedCheckbox && lastCheckedCheckbox !== this) {
                    lastCheckedCheckbox.checked = false;
                }
                lastCheckedCheckbox = this;

                const checkedCheckbox = tabelTampilBKK.row($(this).closest('tr')).data();
                const idTampilBKK = document.getElementById("idTampilBKK");

                if ($(this).prop("checked")) {
                    idTampilBKK.value = checkedCheckbox.Id_BKK;
                } else {
                    idTampilBKK.value = "";
                }
            });
        });
});

btnCetakBKK.addEventListener('click', function(event) {
    event.preventDefault();

    methodTampilBKK.value="PUT";
    formTampilBKK.action = "/BKMTransitorisBank/" + idTampilBKK.value;
    console.log(idTampilBKK.value);
    formTampilBKK.submit();

})
//#endregion


