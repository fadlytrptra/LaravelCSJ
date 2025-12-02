let no_order = document.getElementById("no_order");
let foto = document.getElementById("foto");
let tgl_mohonKirim = document.getElementById("tgl_mohonKirim");
let divisi = document.getElementById("divisi");
let select_divisi = document.getElementById("select_divisi");
let select_golongan = document.getElementById("select_golongan");
let select_mesinGolongan = document.getElementById("select_mesinGolongan");
let pemesan = document.getElementById("pemesan");
let kd_barang = document.getElementById("kd_barang");
let select_kategori_utama = document.getElementById("select_kategori_utama");
let select_kategori = document.getElementById("select_kategori");
let select_subKategori = document.getElementById("select_subKategori");
let ket_khusus = document.getElementById("ket_khusus");
let select_namaBarang = document.getElementById("select_namaBarang");
let ket_barang = document.getElementById("ket_barang");
let ket_order = document.getElementById("ket_order");
let ket_internal = document.getElementById("ket_internal");
let qty_order = document.getElementById("qty_order");
let ketStatusOrder = document.getElementById("ketStatusOrder");
let select_satuanUmum = document.getElementById("select_satuanUmum");
let btn_clear = document.getElementById("btn_clear");
let btn_save = document.getElementById("btn_save");
let btn_submit = document.getElementById("btn_submit");
let btn_delete = document.getElementById("btn_delete");

let data;
let statusKoreksi;
let csrfToken = $('meta[name="csrf-token"]').attr("content");
let kdBarangAslinya = "";
select_kategori.disabled = true;
select_subKategori.disabled = true;
select_namaBarang.disabled = true;
tgl_mohonKirim.valueAsDate = new Date();
foto.style.display = "none";

btn_save.addEventListener("click", function (event) {
    let stBeli = 1;
    if (
        document.getElementById("status_beliPengadaanPembelian").checked == true
    ) {
        stBeli = 1;
    } else {
        stBeli = 0;
    }
    if (statusKoreksi == null) {
        $.ajax({
            url: "/MaintenanceOrderPembeliann/Save",
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            data: {
                kd: 0,
                Kd_div: divisi.value.trim(),
                Kd_brg: kd_barang.value,
                keterangan: ket_order.value,
                Qty: qty_order.value,
                Pemesan: pemesan.value,
                NoSatuan: select_satuanUmum.value.trim(),
                Tgl_Dibutuhkan: tgl_mohonKirim.value,
                stBeli: stBeli,
                ketIn: ket_internal.value,
            },
            success: function (response) {
                Swal.fire({
                    icon: "success",
                    title:
                        response.message +
                        " Silahkan dicatat No. Order berikut: " +
                        response.data,
                    showConfirmButton: false,
                });
                no_order.value = response.data;
                btn_save.disabled = true;
                btn_submit.disabled = true;
            },
            error: function (error) {
                Swal.fire({
                    icon: "error",
                    title: "Data Tidak Berhasil DiTambahkan!",
                    showConfirmButton: false,
                    timer: "2000",
                });
                console.error("Error Send Data:", error);
            },
        });
    } else {
        $.ajax({
            url: "/MaintenanceOrderPembeliann/Submit",
            type: "PUT",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            data: {
                kd: 0,
                Kd_div: divisi.value.trim(),
                Kd_brg: kd_barang.value,
                keterangan: ket_order.value,
                Qty: qty_order.value,
                Pemesan: pemesan.value,
                NoSatuan: select_satuanUmum.value.trim(),
                Tgl_Dibutuhkan: tgl_mohonKirim.value,
                stBeli: stBeli,
                ketIn: ket_internal.value,
                noTrans: no_order.value.trim(),
            },
            success: function (response) {
                Swal.fire({
                    icon: "success",
                    title: response.message,
                    showConfirmButton: false,
                    timer: "2000",
                });
                btn_save.disabled = true;
                btn_submit.disabled = true;
                btn_delete.disabled = true;
            },
            error: function (error) {
                Swal.fire({
                    icon: "error",
                    title: "Data Tidak Berhasil DiUpdate!",
                    showConfirmButton: false,
                    timer: "2000",
                });
                console.error("Error Send Data:", error);
            },
        });
    }
});

btn_submit.addEventListener("click", function (event) {
    let stBeli = 1;
    if (
        document.getElementById("status_beliPengadaanPembelian").checked == true
    ) {
        stBeli = 1;
    } else {
        stBeli = 0;
    }
    if (statusKoreksi == null) {
        $.ajax({
            url: "/MaintenanceOrderPembeliann/Save",
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            data: {
                kd: 1,
                Kd_div: divisi.value.trim(),
                Kd_brg: kd_barang.value,
                keterangan: ket_order.value,
                Qty: qty_order.value,
                Pemesan: pemesan.value,
                NoSatuan: select_satuanUmum.value.trim(),
                Tgl_Dibutuhkan: tgl_mohonKirim.value,
                stBeli: stBeli,
                ketIn: ket_internal.value,
            },
            success: function (response) {
                Swal.fire({
                    icon: "success",
                    title:
                        response.message + " Dengan No. Order " + response.data,
                    showConfirmButton: false,
                    timer: "2000",
                });
                // console.log()
                no_order.value = response.data;
                btn_save.disabled = true;
                btn_submit.disabled = true;
            },
            error: function (error) {
                Swal.fire({
                    icon: "error",
                    title: "Data Tidak Berhasil DiTambahkan!",
                    showConfirmButton: false,
                    timer: "2000",
                });
                console.error("Error Send Data:", error);
            },
        });
    } else {
        $.ajax({
            url: "/MaintenanceOrderPembeliann/Submit",
            type: "PUT",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            data: {
                kd: 1,
                Kd_div: divisi.value.trim(),
                Kd_brg: kd_barang.value,
                keterangan: ket_order.value,
                Qty: qty_order.value,
                Pemesan: pemesan.value,
                NoSatuan: select_satuanUmum.value.trim(),
                Tgl_Dibutuhkan: tgl_mohonKirim.value,
                stBeli: stBeli,
                ketIn: ket_internal.value,
                noTrans: no_order.value.trim(),
            },
            success: function (response) {
                Swal.fire({
                    icon: "success",
                    title: response.message,
                    showConfirmButton: false,
                    timer: "2000",
                });
                btn_save.disabled = true;
                btn_submit.disabled = true;
                btn_delete.disabled = true;
            },
            error: function (error) {
                Swal.fire({
                    icon: "error",
                    title: "Data Tidak Berhasil DiUpdate!",
                    showConfirmButton: false,
                    timer: "2000",
                });
                console.error("Error Send Data:", error);
            },
        });
    }
});

btn_delete.addEventListener("click", function (event) {
    $.ajax({
        url: "/MaintenanceOrderPembeliann/Delete",
        type: "DELETE",
        headers: {
            "X-CSRF-TOKEN": csrfToken,
        },
        data: {
            noTrans: no_order.value.trim(),
        },
        success: function (response) {
            Swal.fire({
                icon: "success",
                title: "No. Order " + data + response.message,
                showConfirmButton: false,
                timer: "3000",
            });
            setTimeout(function () {
                window.location.href = "/ListOrder";
            }, 4000);
        },
        error: function (error) {
            Swal.fire({
                icon: "error",
                title: "Data Tidak Berhasil DiHapus!",
                showConfirmButton: false,
                timer: "2000",
            });
            console.error("Error Send Data:", error);
        },
    });
});

select_divisi.addEventListener("change", function (event) {
    if (select_divisi.selectedIndex != 0) {
        clearOptions(select_golongan);
        select_golongan.selectedIndex = 0;
        clearOptions(select_mesinGolongan);
        select_mesinGolongan.selectedIndex = 0;
        divisi.value = select_divisi.value;
        $.ajax({
            url: "/MaintenanceOrderPembeliann/Golongan",
            type: "GET",
            data: {
                kd_div: select_divisi.value.trim(),
            },
            success: function (response) {
                response.forEach(function (data) {
                    let option = document.createElement("option");
                    option.value = data.NO_GOL;
                    option.text = data.NM_GOL;
                    select_golongan.add(option);
                });
            },
            error: function (error) {
                console.error("Error Fetch Data:", error);
            },
        });
    }
});

select_golongan.addEventListener("change", function (event) {
    if (select_golongan.selectedIndex != 0) {
        clearOptions(select_mesinGolongan);
        select_mesinGolongan.selectedIndex = 0;
        $.ajax({
            url: "/MaintenanceOrderPembeliann/MesinGolongan",
            type: "GET",
            data: {
                no_gol: select_golongan.value.trim(),
            },
            success: function (response) {
                response.forEach(function (data) {
                    let option = document.createElement("option");
                    option.value = data.NO_MSN;
                    option.text = data.NM_MSN;
                    select_mesinGolongan.add(option);
                });
            },
            error: function (error) {
                console.error("Error Fetch Data:", error);
            },
        });
    }
});

qty_order.addEventListener("input", function (event) {
    setInputFilter(
        document.getElementById("qty_order"),
        function (value) {
            return /^-?\d*[.,]?\d*$/.test(value);
        },
        "Tidak boleh character, harus angka"
    );
});

kd_barang.addEventListener("input", function (event) {
    setInputFilter(
        document.getElementById("kd_barang"),
        function (value) {
            return /^\d*$/.test(value);
        },
        "Tidak boleh character, harus angka"
    );
});

kd_barang.addEventListener("change", function (event) {
    btn_cari_kdBarang.focus();
});

btn_cari_kdBarang.addEventListener("click", function (event) {
    cariKodeBarang(kd_barang.value.replace(/\s/g, ""));
    kd_barang.value = kdBarangAslinya;
});

btn_clear.addEventListener("click", function (event) {
    clearData();
});

select_kategori_utama.addEventListener("change", function (event) {
    optionClr();
    let myValue = select_kategori_utama.value;
    kategori(myValue, function () {
        select_kategori.disabled = false;
        select_subKategori.disabled = true;
        select_namaBarang.disabled = true;
    });
});

select_kategori.addEventListener("change", function (event) {
    select_subKategori.selectedIndex = 0;
    clearOptions(select_subKategori);
    select_namaBarang.selectedIndex = 0;
    clearOptions(select_namaBarang);
    let myValue = select_kategori.value;
    subKategori(myValue, function () {
        select_subKategori.disabled = false;
        select_namaBarang.disabled = true;
    });
});

select_subKategori.addEventListener("change", function (event) {
    select_namaBarang.selectedIndex = 0;
    clearOptions(select_namaBarang);
    let myValue = select_subKategori.value;
    namaBarang(myValue, function () {
        select_namaBarang.disabled = false;
    });
});

function clearOptions(selectElement) {
    let length = selectElement.options.length;

    for (let i = length - 1; i > 0; i--) {
        selectElement.remove(i);
    }
}
function optionClr() {
    select_kategori.selectedIndex = 0;
    clearOptions(select_kategori);
    select_subKategori.selectedIndex = 0;
    clearOptions(select_subKategori);
    select_namaBarang.selectedIndex = 0;
    clearOptions(select_namaBarang);
}
function clearData() {
    $("#table_listSaldo").DataTable().clear().destroy();
    foto.src = "";
    foto.style.display = "none";
    kd_barang.value = "";
    ket_khusus.value = "";
    ket_barang.value = "";
    ketStatusOrder.value = "PC";
    // ket_order.value = "";
    // ket_internal.value = "";
    qty_order.value = "1";
    document.getElementById("status_beliPengadaanPembelian").checked = true;
    tgl_mohonKirim.valueAsDate = new Date();
    pemesan.value = "";
    no_order.value = "";
    // select_divisi.selectedIndex = 0;
    select_kategori_utama.selectedIndex = 0;
    select_kategori.disabled = true;
    select_subKategori.disabled = true;
    select_namaBarang.disabled = true;
    optionClr();
    select_satuanUmum.selectedIndex = 0;
    if (statusKoreksi == null) {
        btn_save.disabled = false;
        btn_submit.disabled = false;
    }
    if (statusKoreksi == "u") {
        btn_save.disabled = false;
        btn_submit.disabled = false;
        btn_delete.disabled = false;
    }
}

function cariKodeBarang(kd_barang) {
    while (kd_barang.length < 9) {
        kd_barang = "0" + kd_barang;
    }
    kdBarangAslinya = kd_barang;
    $("#table_listSaldo").DataTable().clear().destroy();
    $.ajax({
        url: "/MaintenanceOrderPembeliann/KodeBarang",
        type: "GET",
        data: {
            KdBarang: kd_barang,
        },
        success: function (response) {
            console.log(response);
            if (response.data.length == 0) {
                alert(`Kode barang ${kd_barang} tidak dapat ditemukan`);
            } else {
                console.log(response);
                saldo(kd_barang);
                if (response.image != null) {
                    foto.style.display = "block";
                    foto.src = "data:image/jpeg;base64," + response.image;
                } else {
                    foto.style.display = "none";
                    foto.src = "";
                }
                kategori(response.data[0].no_kat_utama, function () {
                    for (let i = 0; i < select_kategori.options.length; i++) {
                        if (
                            select_kategori.options[i].text.replace(
                                /\s/g,
                                ""
                            ) ===
                            response.data[0].nama_kategori.replace(/\s/g, "")
                        ) {
                            select_kategori.selectedIndex = i;
                        }
                    }
                });

                subKategori(response.data[0].no_kategori, function () {
                    for (
                        let i = 0;
                        i < select_subKategori.options.length;
                        i++
                    ) {
                        if (
                            select_subKategori.options[i].value.replace(
                                /\s/g,
                                ""
                            ) ===
                            response.data[0].no_sub_kategori.replace(/\s/g, "")
                        ) {
                            select_subKategori.selectedIndex = i;
                        }
                    }
                });

                namaBarang(response.data[0].no_sub_kategori, function () {
                    for (let i = 0; i < select_namaBarang.options.length; i++) {
                        if (
                            select_namaBarang.options[i].text.replace(
                                /\s/g,
                                ""
                            ) === response.data[0].NAMA_BRG.replace(/\s/g, "")
                        ) {
                            select_namaBarang.selectedIndex = i;
                        }
                    }
                });

                for (let i = 0; i < select_kategori_utama.options.length; i++) {
                    if (
                        select_kategori_utama.options[i].value.replace(
                            /\s/g,
                            ""
                        ) === response.data[0].no_kat_utama.replace(/\s/g, "")
                    ) {
                        select_kategori_utama.selectedIndex = i;
                    }
                }

                ket_khusus.value = response.data[0].KET_KHUSUS;
                ket_barang.value = response.data[0].KET;
                ketStatusOrder.value = response.data[0].Nama_satuan.trim();
                for (let i = 0; i < select_satuanUmum.options.length; i++) {
                    if (
                        select_satuanUmum.options[i].value ===
                        response.data[0].NO_SATUAN_UMUM
                    ) {
                        select_satuanUmum.selectedIndex = i;
                    }
                }
            }
        },
        error: function (error) {
            console.error("Error Fetch Data:", error);
        },
    });
    select_kategori.disabled = false;
    select_subKategori.disabled = false;
    select_namaBarang.disabled = false;
}

function saldo(kdBarang) {
    let table = $("#table_listSaldo").DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        searching: false,
        ajax: {
            url: "/MaintenanceOrderPembeliann/Saldo",
            type: "GET",
            data: function (data) {
                data.KodeBarang = kdBarang;
            },
        },
        columns: [
            { data: "NamaDivisi" },
            {
                data: "SaldoTritier",
                render: function (data) {
                    return numeral(parseFloat(data)).format("0.00");
                },
            },
            { data: "satTertier" },
            {
                data: "SaldoSekunder",
                render: function (data) {
                    return numeral(parseFloat(data)).format("0.00");
                },
            },
            { data: "satSekunder" },
            {
                data: "SaldoPrimer",
                render: function (data) {
                    return numeral(parseFloat(data)).format("0.00");
                },
            },
            { data: "satPrimer" },
            { data: "NamaObjek" },
            { data: "NamaKelompokUtama" },
            { data: "NamaKelompok" },
            { data: "NamaSubKelompok" },
        ],
    });
}

function kategori(MyValue, callback) {
    $.ajax({
        url: "/MaintenanceOrderPembeliann/Kategori",
        type: "GET",
        data: {
            MyValue: MyValue,
        },
        success: function (response) {
            response.forEach(function (data) {
                let option = document.createElement("option");
                option.value = data.no_kategori;
                option.text = data.nama_kategori;
                select_kategori.add(option);
            });
            if (typeof callback === "function") {
                callback();
            }
        },
        error: function (error) {
            console.error("Error Fetch Data:", error);
        },
    });
}
function subKategori(MyValue, callback) {
    $.ajax({
        url: "/MaintenanceOrderPembeliann/SubKategori",
        type: "GET",
        data: {
            MyValue: MyValue,
        },
        success: function (response) {
            response.forEach(function (data) {
                let option = document.createElement("option");
                option.value = data.no_sub_kategori;
                option.text = data.nama_sub_kategori;
                select_subKategori.add(option);
            });
            if (typeof callback === "function") {
                callback();
            }
        },
        error: function (error) {
            console.error("Error Fetch Data:", error);
        },
    });
}
function namaBarang(MyValue, callback) {
    $.ajax({
        url: "/MaintenanceOrderPembeliann/NamaBarang",
        type: "GET",
        data: {
            MyValue: MyValue,
        },
        success: function (response) {
            response.forEach(function (data) {
                let option = document.createElement("option");
                option.value = data.KD_BRG;
                option.text = data.NAMA_BRG;
                select_namaBarang.add(option);
            });
            if (typeof callback === "function") {
                callback();
            }
        },
        error: function (error) {
            console.error("Error Fetch Data:", error);
        },
    });
}

$(document).ready(function () {
    $.ajax({
        url: "/MaintenanceOrderPembeliann/Data",
        type: "GET",
        success: function (response) {
            let kategoriUtama = response.kategoriUtama;
            let divisi = response.divisi;
            let satuanList = response.satuanList;
            kategoriUtama.forEach(function (data) {
                let option = document.createElement("option");
                option.value = data.no_kat_utama;
                option.text = data.nama;
                select_kategori_utama.add(option);
            });
            satuanList.forEach(function (data) {
                let option = document.createElement("option");
                option.value = data.No_satuan;
                option.text = data.Nama_satuan;
                select_satuanUmum.add(option);
            });
            divisi.forEach(function (data) {
                let option = document.createElement("option");
                option.value = data.Kd_div;
                option.text = data.NM_DIV;
                select_divisi.add(option);
            });
        },
        error: function (error) {
            console.error("Error Fetch Data:", error);
        },
    });
    // console.log(statusKoreksi, idUser, data, statusKoreksi != null);
    if (statusKoreksi != null) {
        $.ajax({
            url: "/MaintenanceOrderPembeliann/CekNoTrans",
            type: "GET",
            data: {
                No_trans: data.trim(),
            },
            success: function (response) {
                if (response.length != 0) {
                    console.log("tes", response);
                    pemesan.value = response[0].Pemesan;
                    no_order.value = data.trim();
                    if (response[0].StatusBeli == 1) {
                        document.getElementById(
                            "status_beliPengadaanPembelian"
                        ).checked = true;
                    } else {
                        document.getElementById(
                            "status_beliBeliSendiri"
                        ).checked = true;
                    }
                    divisi.value = response[0].Kd_div.trim();
                    for (let i = 0; i < select_divisi.options.length; i++) {
                        if (
                            select_divisi.options[i].value.replace(
                                /\s/g,
                                ""
                            ) === response[0].Kd_div.replace(/\s/g, "")
                        ) {
                            select_divisi.selectedIndex = i;
                        }
                    }

                    tgl_mohonKirim.value =
                        response[0].Tgl_Dibutuhkan.split(" ")[0];

                    kd_barang.value = response[0].Kd_brg.trim();
                    ket_internal.value = response[0].Ket_Internal;
                    ket_order.value = response[0].keterangan;
                    qty_order.value = parseFloat(response[0].Qty);
                    cariKodeBarang(response[0].Kd_brg.trim());

                    if (statusKoreksi == "u") {
                        btn_submit.disabled = false;
                        btn_save.disabled = false;
                        btn_delete.disabled = false;
                    } else {
                        btn_submit.disabled = true;
                        btn_save.disabled = true;
                        btn_delete.disabled = true;
                    }
                } else {
                    Swal.fire({
                        title: "No Trans Tidak Ditemukan",
                    });
                }
                btn_delete.disabled = false;
                btn_save.disabled = false;
                btn_submit.disabled = false;
                btn_clear.disabled = true;
            },
            error: function (error) {
                Swal.fire({
                    title: "Error Send Data:" + error,
                    icon: error,
                });
            },
        });
    } else {
        btn_delete.disabled = true;
    }
});
