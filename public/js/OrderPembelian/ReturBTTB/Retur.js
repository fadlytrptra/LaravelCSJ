let nomor_po = document.getElementById("nomor_po");
let idsuplier = document.getElementById("idsuplier");
let suplier = document.getElementById("suplier");
let payment = document.getElementById("payment");
let tanggal_po = document.getElementById("tanggal_po");
let tanggalkirim = document.getElementById("tanggalkirim");
let matauang = document.getElementById("matauang");
let kdbarang = document.getElementById("kdbarang");
let tanggalretur = document.getElementById("tanggalretur");
let namabarang = document.getElementById("namabarang");
let type = document.getElementById("type");
let kelompok = document.getElementById("kelompok");
let subkategori = document.getElementById("subkategori");
let returprimer = document.getElementById("returprimer");
let sekunder = document.getElementById("sekunder");
let tertier = document.getElementById("tertier");
let bttb = document.getElementById("bttb");
let alasan = document.getElementById("alasan");
let sj = document.getElementById("sj");
let id_terima = document.getElementById("id_terima");
let qty_terima = document.getElementById("qty_terima");
let returbutton = document.getElementById("returbutton");
let batalbutton = document.getElementById("batalbutton");
let keterangan = document.getElementById("keterangan");

let jenisTrans;
let data;
let dataInv;
let idterima;
let unitMode = 0;
returbutton.style.display = "block";
batalbutton.style.display = "none";
returbutton.disabled = true;
batalbutton.disabled = true;
let tabelretur = $("#tabelretur").DataTable({
    paging: false,
    responsive: true,
    scrollY: "100px",
    searching: false,
    scrollX: true,
});
let tabelretur1 = $("#tabelretur1").DataTable({
    paging: false,
    responsive: true,
    scrollY: "100px",
    searching: false,
    scrollX: true,
});
let csrfToken = $('meta[name="csrf-token"]').attr("content");

alasan.addEventListener("input", function (event) {
    if (alasan.value.trim() != "") {
        returbutton.disabled = false;
    } else {
        returbutton.disabled = true;
    }
});
qty_terima.addEventListener("input", function (event) {
    setInputFilter(
        document.getElementById("qty_terima"),
        function (value) {
            return /^-?\d*[.,]?\d*$/.test(value);
        },
        "Tidak boleh character, harus angka"
    );
});
returprimer.addEventListener("input", function (event) {
    setInputFilter(
        document.getElementById("returprimer"),
        function (value) {
            return /^-?\d*[.,]?\d*$/.test(value);
        },
        "Tidak boleh character, harus angka"
    );
});
sekunder.addEventListener("input", function (event) {
    setInputFilter(
        document.getElementById("sekunder"),
        function (value) {
            return /^-?\d*[.,]?\d*$/.test(value);
        },
        "Tidak boleh character, harus angka"
    );
});
tertier.addEventListener("input", function (event) {
    setInputFilter(
        document.getElementById("tertier"),
        function (value) {
            return /^-?\d*[.,]?\d*$/.test(value);
        },
        "Tidak boleh character, harus angka"
    );
});
tanggalretur.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        returprimer.focus();
        returprimer.select();
    }
});
qty_terima.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        qty_terima.value = parseFloat(qty_terima.value).toFixed(4);
        tanggalretur.focus();
    }
});
returprimer.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        returprimer.value = parseFloat(returprimer.value).toFixed(2);
        sekunder.focus();
        sekunder.select();
    }
});
sekunder.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        sekunder.value = parseFloat(sekunder.value).toFixed(2);
        tertier.focus();
        tertier.select();
    }
});
tertier.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        tertier.value = parseFloat(tertier.value).toFixed(2);
        alasan.select();
    }
});

function clearHeader() {
    suplier.value = "";
    payment.value = "";
    tanggal_po.valueAsDate = new Date();
    tanggalkirim.valueAsDate = new Date();
    matauang.value = "";
}

function clearRetur() {
    kdbarang.value = "";
    tanggalretur.valueAsDate = new Date();
    namabarang.value = "";
    subkategori.value = "";
    bttb.value = "";
    alasan.value = "";
    sj.value = "";
    id_terima.value = "";
    qty_terima.value = "";
    keterangan.value = "";
}
function clearInv() {
    type.value = "";
    kelompok.value = "";
    returprimer.value = "";
    sekunder.value = "";
    tertier.value = "";
}

function hangusInv() {
    $.ajax({
        method: "GET",
        url: "/RReturBTTB/checkInvPenyesuaian",
        data: {
            IdType: type.value.trim(),
        },
        beforeSend: function () {
            // Show loading screen
            $("#loading-screen").css("display", "flex");
        },
        success: function (response) {
            console.log(response);
            if (response[0].jumlah >= 1) {
                alert(
                    "Tidak Bisa DiAcc !!!. Karena Ada Transaksi Penyesuaian yang Belum Diacc untuk type " +
                        type.value
                );
            } else {
                invInsertTmp();
            }
        },
        error: function (error) {
            console.error("Error sending data to the server:", error);
        },
        complete: function () {
            // Hide loading screen
            $("#loading-screen").css("display", "none");
        },
    });
}

function invInsertTmp() {
    let objekDitemukan = dataInv.filter((obj) => obj.IdType === type.value);
    $.ajax({
        method: "POST",
        url: "/RReturBTTB/InvInsertTmp",
        headers: {
            "X-CSRF-TOKEN": csrfToken,
        },
        data: {
            XIdType: type.value.trim(),
            XSaatawalTransaksi: tanggalretur.value,
            XJumlahPengeluaranPrimer: returprimer.value,
            XJumlahPengeluaranSekunder: sekunder.value,
            XJumlahPengeluaranTritier: tertier.value,
            XAsalIdSubKelompok: objekDitemukan[0].IdSubkelompok,
            XTujuanIdSubKelompok: objekDitemukan[0].IdSubkelompok,
            XUraianDetailTransaksi: alasan.value,
        },
        beforeSend: function () {
            // Show loading screen
            $("#loading-screen").css("display", "flex");
        },
        success: function (response) {
            console.log(response);
            if (response.status == true) {
                accHangus(response.data);
            } else {
                alert("Insert Inv Gagal");
            }
        },
        error: function (error) {
            console.error("Error sending data to the server:", error);
        },
        complete: function () {
            // Hide loading screen
            $("#loading-screen").css("display", "none");
        },
    });
}

function accHangus(data) {
    $.ajax({
        method: "POST",
        url: "/RReturBTTB/AccHangus",
        headers: {
            "X-CSRF-TOKEN": csrfToken,
        },
        data: {
            IdTransaksi: data,
            JumlahKeluarPrimer: returprimer.value,
            JumlahKeluarSekunder: sekunder.value,
            JumlahKeluarTritier: tertier.value,
        },
        beforeSend: function () {
            // Show loading screen
            $("#loading-screen").css("display", "flex");
        },
        success: function (response) {
            alert("Data Sudah Tersimpan");
            retur(unitMode);
        },
        error: function (error) {
            console.error("Error sending data to the server:", error);
        },
        complete: function () {
            // Hide loading screen
            $("#loading-screen").css("display", "none");
        },
    });
}

returbutton.addEventListener("click", function (event) {
    if (alasan.value == "") {
        returbutton.disabled = true;
        alert("Alasan Tidak Boleh Kosong");
    } else {
        if (unitMode == 1) {
            if (parseFloat(qty_terima.value) >= parseFloat(returprimer.value)) {
                if (
                    confirm(
                        "Yang akan diretur adalah quantity primer. Jumlah qty retur lebih kecil atau sama dengan jumlah qty terima. Lanjutkan proses retur?"
                    )
                ) {
                    hangusInv();
                }
            } else if (
                parseFloat(qty_terima.value) < parseFloat(returprimer.value)
            ) {
                alert(
                    "Yang akan diretur adalah quantity primer. Jumlah qty retur lebih besar dari jumlah qty terima. Retur tidak dapat diproses. Jumlah retur harus lebih kecil atau sama dengan jumlah terima."
                );
            }
        } else if (unitMode == 2) {
            if (parseFloat(qty_terima.value) >= parseFloat(sekunder.value)) {
                if (
                    confirm(
                        "Yang akan diretur adalah quantity sekunder. Jumlah qty retur lebih kecil atau sama dengan jumlah qty terima. Lanjutkan proses retur?"
                    )
                ) {
                    hangusInv();
                }
            } else if (
                parseFloat(qty_terima.value) < parseFloat(sekunder.value)
            ) {
                alert(
                    "Yang akan diretur adalah quantity sekunder. Jumlah qty retur lebih besar dari jumlah qty terima. Retur tidak dapat diproses. Jumlah retur harus lebih kecil atau sama dengan jumlah terima."
                );
            }
        } else if (unitMode == 3) {
            if (parseFloat(qty_terima.value) >= parseFloat(tertier.value)) {
                if (
                    confirm(
                        "Yang akan diretur adalah quantity tritier. Jumlah qty retur lebih kecil atau sama dengan jumlah qty terima. Lanjutkan proses retur?"
                    )
                ) {
                    hangusInv();
                }
            } else if (
                parseFloat(qty_terima.value) < parseFloat(tertier.value)
            ) {
                alert(
                    "Yang akan diretur adalah quantity tritier. Jumlah qty retur lebih besar dari jumlah qty terima. Retur tidak dapat diproses. Jumlah retur harus lebih kecil atau sama dengan jumlah terima."
                );
            }
        }
    }
});

function retur(mode) {
    let qtyRetur;
    if (mode == 1) {
        qtyRetur = returprimer.value;
    } else if (mode == 2) {
        qtyRetur = sekunder.value;
    } else if (mode == 3) {
        qtyRetur = tertier.value;
    }
    $.ajax({
        method: "PUT",
        url: "/RReturBTTB/Retur",
        headers: {
            "X-CSRF-TOKEN": csrfToken,
        },
        data: {
            Terima: id_terima.value.trim(),
            tglRetur: tanggalretur.value,
            alasan: alasan.value,
            qtyRetur: qtyRetur,
        },
        beforeSend: function () {
            // Show loading screen
            $("#loading-screen").css("display", "flex");
        },
        success: function (response) {
            console.log("retur", response);
            Swal.fire({
                icon: "success",
                title: "Data Berhasil DiRetur!",
                showConfirmButton: false,
                timer: "2000",
            });
            clearRetur();
            clearInv();
            tabelretur1.clear().draw();
            loadPermohonan();
        },
        error: function (error) {
            Swal.fire({
                icon: "error",
                title: "Data Tidak Berhasil DiRetur!",
                showConfirmButton: false,
                timer: "2000",
            });
            console.error("Error sending data to the server:", error);
        },
        complete: function () {
            // Hide loading screen
            $("#loading-screen").css("display", "none");
        },
    });
}

batalbutton.addEventListener("click", function (event) {
    $.ajax({
        method: "PUT",
        url: "/RReturBTTB/Batal",
        headers: {
            "X-CSRF-TOKEN": csrfToken,
        },
        data: {
            Terima: id_terima.value.trim(),
            tglRetur: tanggalretur.value,
            alasan: alasan.value,
        },
        beforeSend: function () {
            // Show loading screen
            $("#loading-screen").css("display", "flex");
        },
        success: function (response) {
            console.log(response);
            Swal.fire({
                icon: "success",
                title: "Data Berhasil DiBatalkan!",
                showConfirmButton: false,
                timer: "2000",
            });
            clearRetur();
            clearInv();
            loadPermohonan();
        },
        error: function (error) {
            Swal.fire({
                icon: "error",
                title: "Data Tidak Berhasil DiBatalkan",
                showConfirmButton: false,
                timer: "2000",
            });
            console.error("Error sending data to the server:", error);
        },
        complete: function () {
            // Hide loading screen
            $("#loading-screen").css("display", "none");
        },
    });
});

function loadPermohonan() {
    $.ajax({
        method: "GET",
        url: "/RReturBTTB/Display",
        data: {
            noPO: nomor_po.value.trim(),
        },
        beforeSend: function () {
            // Show loading screen
            $("#loading-screen").css("display", "flex");
        },
        success: function (response) {
            tabelretur.clear().draw();
            tabelretur1.clear().draw();
            batalbutton.disabled = true;
            returbutton.disabled = true;
            if (response.tabel.length == 0 || response.input.length == 0) {
                alert("Data Yang Akan Anda Retur Tidak Ada");
                clearRetur();
                clearInv();
                clearHeader();
                data = [];
                unitMode = 0;
            } else {
                clearRetur();
                clearHeader();
                clearInv();
                unitMode = 0;
                data = response.tabel;
                suplier.value = response.input[0].NM_SUP;
                payment.value = response.input[0].Pembayaran || "-";
                tanggal_po.value = response.input[0].Tgl_sppb.split(" ")[0];
                tanggalkirim.value = response.input[0].Est_Date.split(" ")[0];
                matauang.value = response.input[0].Curr;
                idsuplier.value = response.input[0].Supplier;
                responseData(response.tabel);
            }
        },
        error: function (error) {
            console.error("Error sending data to the server:", error);
        },
        complete: function () {
            // Hide loading screen
            $("#loading-screen").css("display", "none");
        },
    });
}

nomor_po.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        loadPermohonan();
    }
});

$("#tabelretur tbody").on("dblclick", "tr", function () {
    $("#tabelretur tr.selected").not(this).removeClass("selected");
    clearRetur();
    clearInv();
    tabelretur1.clear().draw();
    $(this).toggleClass("selected");
    batalbutton.disabled = true;
    returbutton.disabled = true;
    jenisTrans = 0;
    unitMode = 0;
    let rowData = tabelretur.row(this).data();
    idterima = rowData[2];
    kdbarang.value = rowData[3] || "";
    namabarang.value = rowData[4].replace(/&lt;/g, "<").replace(
        /&gt;/g,
        ">"
    ) || "";
    subkategori.value = rowData[5] || "";
    bttb.value = rowData[0] || "";
    alasan.value = rowData[13] || "";
    sj.value = rowData[1] || "";
    id_terima.value = rowData[2] || "";
    qty_terima.value = parseFloat(rowData[6]).toFixed(4) || "";
    if (rowData[13]) {
        returbutton.disabled = false;
    }
    console.log(id_terima);
    if (rowData[12]) {
        tanggalretur.value = rowData[12].split(" ")[0];
    }
    if (rowData[14]) {
        alert(
            "BTTB yang dipilih sudah melalui proses penagihan. Data tidak dapat dibatalkan."
        );
    } else {
        if (
            (rowData[8] == null && rowData[9] == null) ||
            (rowData[8] == "" && rowData[9] == "") ||
            (rowData[8] == "" && rowData[9] == null) ||
            (rowData[8] == null && rowData[9] == "")
        ) {
            keterangan.innerHTML =
                "Data belum ditransfer ke inventory/Data adalah berupa jasa.<br>Silahkan diproses batal BTTB.";
            jenisTrans = 1; //hapus BTTB, update YTRANSBL jadi 8 atau 9
            returbutton.style.display = "none";
            batalbutton.style.display = "block";
            batalbutton.disabled = false;
        } else if (
            (rowData[8] && rowData[9] == null) ||
            (rowData[8] && rowData[9] == "")
        ) {
            keterangan.innerHTML =
                "Data sudah ditransfer ke inventory,<br>tetapi belum diproses terima oleh gudang/divisi/Data adalah berupa jasa.<br>Silahkan diproses batal BTTB.";
            jenisTrans = 2; //update status tmp trans inv jadi 1, hapus BTTB, update YTRANSBL jadi 8 atau 9
            returbutton.style.display = "none";
            batalbutton.style.display = "block";
            batalbutton.disabled = false;
        } else if (rowData[9]) {
            keterangan.innerHTML =
                "Data sudah ditransfer ke inventory dan<br>sudah diterima oleh gudang/divisi.<br>Sebelum proses retur, pastikan barang<br>sudah dimutasi ke PBL terlebih dahulu.";
            checkInn(rowData[3]);
        }
    }
});

$("#tabelretur1 tbody").on("dblclick", "tr", function () {
    $("#tabelretur1 tr.selected").not(this).removeClass("selected");
    clearInv();
    $(this).toggleClass("selected");
    unitMode = 0;
    let rowData = tabelretur1.row(this).data();
    type.value = rowData[0];
    kelompok.value = rowData[10];
    returprimer.value = parseFloat(rowData[3]).toFixed(2);
    sekunder.value = parseFloat(rowData[5]).toFixed(2);
    tertier.value = parseFloat(rowData[7]).toFixed(2);

    let No_terima = idterima;
    let returDitemukan = data.filter((obj) => obj.No_terima === No_terima);

    let invDitemukan = dataInv.filter((obj) => obj.IdType === rowData[0]);
    if (returDitemukan[0].Satuan_Terima == invDitemukan[0].UnitPrimer) {
        unitMode = 1;
    } else if (
        returDitemukan[0].Satuan_Terima == invDitemukan[0].UnitSekunder
    ) {
        unitMode = 2;
    } else if (returDitemukan[0].Satuan_Terima == invDitemukan[0].UnitTritier) {
        unitMode = 3;
    }
});

function checkInn(data) {
    $.ajax({
        method: "GET",
        url: "/RReturBTTB/GETRetur",
        data: {
            kodebarang: data,
        },
        beforeSend: function () {
            // Show loading screen
            $("#loading-screen").css("display", "flex");
        },
        success: function (response) {
            console.log(response);
            if (response.length != 0) {
                jenisTrans = 3;
                returbutton.style.display = "block";
                batalbutton.style.display = "none";
                dataInv = response;
                responseDataTabelRetur1(response);
            } else {
                returbutton.style.display = "block";
                batalbutton.style.display = "none";
                dataInv = [];
                alert(
                    "Belum dapat dilakukan proses retur karena barang belum kembali ke inventory PBL."
                );
            }
        },
        error: function (error) {
            console.error("Error sending data to the server:", error);
        },
        complete: function () {
            // Hide loading screen
            $("#loading-screen").css("display", "none");
        },
    });
}

function responseData(datas) {
    tabelretur.clear().draw();
    datas.forEach(function (data) {
        tabelretur.row
            .add([
                data.No_BTTB,
                data.No_SuratJalan,
                data.No_terima,
                data.Kd_brg,
                data.NAMA_BRG.replace(/</g, "&lt;"),
                data.nama_sub_kategori,
                numeral(parseFloat(data.Qty_Terima)).format("0.0000"),
                data.Nama_satuan,
                data.NoTransaksiTmp,
                data.NoTransaksiInv,
                data.No_trans,
                numeral(parseFloat(data.JmlRetur)).format("0.00"),
                data.TglRetur,
                data.KetRetur,
                data.Id_Penagihan,
            ])
            .draw();
    });
}

function responseDataTabelRetur1(datas) {
    tabelretur1.clear().draw();
    datas.forEach(function (data) {
        tabelretur1.row
            .add([
                data.IdType,
                data.KodeBarang,
                data.NamaType.replace(/</g, "&lt;"),
                numeral(parseFloat(data.SaldoPrimer)).format("0.00") || 0,
                data.satPrimer,
                numeral(parseFloat(data.SaldoSekunder)).format("0.00") || 0,
                data.satSekunder,
                numeral(parseFloat(data.SaldoTritier)).format("0.00") || 0,
                data.nama_satuan,
                data.NamaSubKelompok,
                data.NamaKelompok,
                data.NamaKelompokUtama,
                data.NamaObjek,
            ])
            .draw();
    });
}
