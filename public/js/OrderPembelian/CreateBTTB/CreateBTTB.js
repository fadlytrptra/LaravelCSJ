jQuery(function ($) {
    //#region Variables
    let select_divisi = $("#select_divisi");
    let select_noSPPB = $("#select_noSPPB");
    let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content"); // prettier-ignore
    let table_barang = $("#table_barang").DataTable({
        searching: false,
        info: false,
        paging: false,
        ordering: false,
    });
    let table_terima = $("#table_terima").DataTable({
        searching: false,
        info: false,
        paging: false,
        ordering: false,
    });
    let enterKeyboardEvent = new KeyboardEvent("keypress", {
        key: "Enter",
        code: "Enter",
        keyCode: 13,
        which: 13,
        bubbles: true,
    });
    let changeEvent = new Event("change", { bubbles: true });
    let total_terima = document.getElementById("total_terima");
    let btn_koreksiKurs = document.getElementById("btn_koreksiKurs");
    let btn_isi = document.getElementById("btn_isi");
    let btn_koreksi = document.getElementById("btn_koreksi");
    let createBTTBModalLabel = document.getElementById("createBTTBModalLabel");
    let bttb_noTerima = document.getElementById("bttb_noTerima");
    let bttb_kodeBarang = document.getElementById("bttb_kodeBarang");
    let bttb_namaBarang = document.getElementById("bttb_namaBarang");
    let bttb_tanggal = document.getElementById("bttb_tanggal");
    let bttb_qtyTerima = document.getElementById("bttb_qtyTerima");
    let bttb_qtyTerimaKoreksi = document.getElementById("bttb_qtyTerimaKoreksi"); //prettier-ignore
    let bttb_satTerima = document.getElementById("bttb_satTerima");
    let bttb_noSatTerima = document.getElementById("bttb_noSatTerima");
    let bttb_qtyTerimaActual = document.getElementById("bttb_qtyTerimaActual");
    let bttb_qtyTerimaActualKoreksi = document.getElementById("bttb_qtyTerimaActualKoreksi"); //prettier-ignore
    let bttb_satTerimaActual = document.getElementById("bttb_satTerimaActual");
    let bttb_tanggalFaktur = document.getElementById("bttb_tanggalFaktur");
    let bttb_noFaktur = document.getElementById("bttb_noFaktur");
    let bttb_nomorSJ = document.getElementById("bttb_nomorSJ");
    let bttb_selectMataUang = $("#bttb_selectMataUang");
    let bttb_kursRupiah = document.getElementById("bttb_kursRupiah");
    let bttb_harga = document.getElementById("bttb_harga");
    let bttb_discount = document.getElementById("bttb_discount");
    let bttb_ppn = document.getElementById("bttb_ppn");
    let bttb_divCbDPP = document.getElementById("bttb_divCbDPP");
    let bttb_checkboxDPP = document.getElementById("bttb_checkboxDPP");
    let bttb_hargaPer = document.getElementById("bttb_hargaPer");
    let bttb_nilaiTrans = document.getElementById("bttb_nilaiTrans");
    let bttb_supplier = document.getElementById("bttb_supplier");
    let bttb_noSupplier = document.getElementById("bttb_noSupplier");
    let bttb_jangkaWaktu = document.getElementById("bttb_jangkaWaktu");
    let bttb_pembayaran = document.getElementById("bttb_pembayaran");
    let bttb_keterangan = document.getElementById("bttb_keterangan");
    let bttb_jenisDokumen = document.getElementById("bttb_jenisDokumen");
    let bttb_noSeriBarang = document.getElementById("bttb_noSeriBarang");
    let bttb_noPIBKRR = document.getElementById("bttb_noPIBKRR");
    let bttb_noPIBExternal = document.getElementById("bttb_noPIBExternal");
    let bttb_noRegisPIB = document.getElementById("bttb_noRegisPIB");
    let bttb_noBL = document.getElementById("bttb_noBL");
    let bttb_noKontrak = document.getElementById("bttb_noKontrak");
    let bttb_noSPPBBC = document.getElementById("bttb_noSPPBBC");
    let bttb_tglPIBExternal = document.getElementById("bttb_tglPIBExternal");
    let bttb_tglRegisPIB = document.getElementById("bttb_tglRegisPIB");
    let bttb_tglBL = document.getElementById("bttb_tglBL");
    let bttb_tglKontrak = document.getElementById("bttb_tglKontrak");
    let bttb_tglSPPBBC = document.getElementById("bttb_tglSPPBBC");
    let button_modalProses = document.getElementById("button_modalProses");
    let koreksiKurs_noFaktur = document.getElementById("koreksiKurs_noFaktur");
    let koreksiKurs_tableBarang = $("#koreksiKurs_tableBarang").DataTable({
        searching: false,
        info: false,
        paging: false,
        ordering: false,
    });
    let koreksiKurs_tableKurs = $("#koreksiKurs_tableKurs").DataTable({
        searching: false,
        info: false,
        paging: false,
        ordering: false,
    });
    let koreksiKurs_tableSales = $("#koreksiKurs_tableSales").DataTable({
        searching: false,
        info: false,
        paging: false,
        ordering: false,
    });
    let koreksiKurs_tableJual = $("#koreksiKurs_tableJual").DataTable({
        searching: false,
        info: false,
        paging: false,
        ordering: false,
    });
    let koreksiKurs_nomorTerima = document.getElementById("koreksiKurs_nomorTerima"); // prettier-ignore
    let koreksiKurs_kodeBarang = document.getElementById("koreksiKurs_kodeBarang"); //prettier-ignore
    let koreksiKurs_namaBarang = document.getElementById("koreksiKurs_namaBarang"); //prettier-ignore
    let koreksiKurs_harga = document.getElementById("koreksiKurs_harga");
    let koreksiKurs_kurs = document.getElementById("koreksiKurs_kurs");
    let koreksiKurs_totalBayar = document.getElementById("koreksiKurs_totalBayar"); //prettier-ignore
    let koreksiKurs_Proses = document.getElementById("koreksiKurs_Proses");
    let dppNilaiLain = 0.0;
    let selectedBarangRow = null;
    let proses;
    //#endregion

    //#region Load Form
    init();
    clearModal();
    getDivisi();
    getMataUang();
    //#endregion

    //#region Functions
    $.ajaxSetup({
        beforeSend: function () {
            // Show the loading screen before the AJAX request
            $("#loading-screen").css("display", "flex");
        },
        complete: function () {
            // Hide the loading screen after the AJAX request completes
            $("#loading-screen").css("display", "none");
        },
    });

    function getDivisi() {
        $.ajax({
            url: "/CreateBTTB/getDivisi",
            type: "GET",
            data: {
                _token: csrfToken,
            },
            success: function (data) {
                if (data.error || data.length == 0) {
                    errorHandling("ajaxGetDataResponse", data.error);
                } else {
                    select_divisi.empty();
                    data.forEach(function (item) {
                        select_divisi.append(
                            new Option(item.NM_DIV.trim(), item.KD_DIV) // prettier-ignore
                        );
                    });
                    select_divisi.val(null).trigger("change");
                }
            },
            error: function (xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.error(err.Message);
            },
        });
    }

    function getMataUang() {
        $.ajax({
            url: "/CreateBTTB/getMataUang",
            type: "GET",
            data: {
                _token: csrfToken,
            },
            success: function (data) {
                if (data.error || data.length == 0) {
                    errorHandling("ajaxGetDataResponse", data.error);
                } else {
                    bttb_selectMataUang.empty();
                    data.forEach(function (item) {
                        bttb_selectMataUang.append(
                            new Option(item.Nama_MataUang.trim(), item.Id_MataUang) // prettier-ignore
                        );
                    });
                    bttb_selectMataUang.val(null).trigger("change");
                }
            },
            error: function (xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.error(err.Message);
            },
        });
    }

    function init() {
        select_divisi.select2({
            dropdownParent: $("#dropdownParent1"),
            allowClear: true,
            placeholder: "Pilih Divisi",
        });

        select_noSPPB.select2({
            dropdownParent: $("#dropdownParent1"),
            allowClear: true,
            placeholder: "Pilih Nomor SPPB",
        });

        bttb_selectMataUang.select2({
            dropdownParent: $("#select2DropdownParent"),
            allowClear: true,
            placeholder: "Pilih Mata Uang",
        });

        $("#select_divisi").each(function () {
            $(this).next(".select2-container").css({
                flex: "1 1 auto",
                width: "100%",
            });
        });

        $("#select_noSPPB").each(function () {
            $(this).next(".select2-container").css({
                flex: "1 1 auto",
                width: "100%",
            });
        });

        $("#bttb_selectMataUang").each(function () {
            $(this).next(".select2-container").css({
                flex: "1 1 auto",
                width: "100%",
            });
        });

        select_divisi.val(null).trigger("change");
        select_noSPPB.val(null).trigger("change");
        bttb_selectMataUang.val(null).trigger("change");
    }

    function errorHandling(jenisError, data) {
        if (jenisError == "sppbKosong") {
            Swal.fire({
                icon: "error",
                title: "Kolom No. SPPB kosong!",
                text: data,
                showConfirmButton: false,
                timer: 1500,
            });
        } else if (jenisError == "ajaxGetDataResponse") {
            Swal.fire({
                icon: "error",
                title: "Error!",
                text: data,
                showConfirmButton: false,
                timer: 1500,
            });
        } else if (jenisError == "qtyTerimaKosong") {
            Swal.fire({
                icon: "error",
                title: "Kolom Qty Terima kosong!",
                text: data,
                showConfirmButton: false,
                timer: 1500,
            });
        } else if (jenisError == "qtyTerimaKosongActual") {
            Swal.fire({
                icon: "error",
                title: "Kolom Qty Terima Actual kosong!",
                text: data,
                showConfirmButton: false,
                timer: 1500,
            });
        } else if (jenisError == "table_terimaBelumDipilih") {
            Swal.fire({
                icon: "error",
                title: "Data pada tabel belum dipilih!",
                text: data,
                showConfirmButton: false,
                timer: 1500,
            });
        }
    }

    function clearModal() {
        bttb_kodeBarang.value = "";
        bttb_namaBarang.value = "";
        bttb_tanggal.valueAsDate = new Date();
        bttb_qtyTerima.value = "";
        bttb_satTerima.value = "";
        bttb_qtyTerimaActual.value = "";
        bttb_satTerimaActual.value = "";
        bttb_tanggalFaktur.valueAsDate = new Date();
        bttb_noFaktur.value = "";
        bttb_nomorSJ.value = "";
        bttb_selectMataUang.val(null).trigger("change");
        bttb_kursRupiah.value = "";
        bttb_harga.value = "";
        bttb_discount.value = "";
        bttb_ppn.value = "";
        bttb_hargaPer.value = "";
        bttb_nilaiTrans.value = "";
        bttb_supplier.value = "";
        bttb_jangkaWaktu.value = "";
        bttb_pembayaran.value = "";
        bttb_keterangan.value = "";
        bttb_jenisDokumen.value = "";
        bttb_noSeriBarang.value = "";
        bttb_noPIBKRR.value = "";
        bttb_noPIBExternal.value = "";
        bttb_noRegisPIB.value = "";
        bttb_noBL.value = "";
        bttb_noKontrak.value = "";
        bttb_noSPPBBC.value = "";
        bttb_tglPIBExternal.valueAsDate = new Date();
        bttb_tglRegisPIB.valueAsDate = new Date();
        bttb_tglBL.valueAsDate = new Date();
        bttb_tglKontrak.valueAsDate = new Date();
        bttb_tglSPPBBC.valueAsDate = new Date();
    }

    function loadTerima() {
        $.ajax({
            url: "/CreateBTTB/getDataDetailSPPB",
            type: "GET",
            data: {
                idDivisi: select_divisi.val(),
                noSPPB: select_noSPPB.val(),
                _token: csrfToken,
            },
            success: function (data) {
                if (data.error || data.length == 0) {
                    errorHandling("ajaxGetDataResponse", data.error);
                } else {
                    selectedBarangRow = null;
                    $("#table_barang tbody tr").removeClass("selected");

                    table_barang.clear();
                    table_terima.clear();

                    // Insert ListBarang
                    data.ListBarang.forEach(function (item) {
                        table_barang.row.add([
                            item.keterangan ?? "",
                            item.Kd_brg ?? "",
                            item.NAMA_BRG ?? "",
                            item.nama_kategori ?? "",
                            item.nama_sub_kategori ?? "",
                            numeral(item.Qty).format("0,0"),
                            (item.Nama_satuan ?? "").trim(),
                            item.Tgl_order
                                ? moment(item.Tgl_order).format("MM/DD/YYYY")
                                : "",
                            item.No_trans ?? "",
                            item.Flag ?? "N",
                        ]);
                    });

                    let lngQty = 0.0;
                    let satuanQtyTerima;
                    // Insert ListTerima
                    data.ListTerima.forEach(function (item, index) {
                        let Hrg_Trm = parseFloat(item.Hrg_Trm);
                        let Disc_trm = parseFloat(item.Disc_trm);
                        let Ppn_trm = parseFloat(item.Ppn_trm);
                        let Min_ord = parseFloat(item.Min_ord);
                        let Qty_Terima = parseFloat(item.Qty_Terima);

                        let TNlTrans = Hrg_Trm - Hrg_Trm * (Disc_trm / 100);
                        let NilaiTrans =
                            (TNlTrans +
                                (TNlTrans * (Ppn_trm / 100)) / Min_ord) *
                            Qty_Terima;
                        if (!item.TglRetur) {
                            lngQty += numeral(item.Qty).value();
                            satuanQtyTerima = item.Sat_Terima.trim();
                        }

                        table_terima.row.add([
                            index + 1,
                            item.Datang
                                ? moment(item.Datang).format("MM/DD/YYYY")
                                : "",
                            numeral(item.Qty).format("0,0"),
                            (item.Sat_Pesan ?? "").trim(),
                            numeral(Qty_Terima).format("0,0"),
                            (item.Sat_Terima ?? "").trim(),
                            numeral(Hrg_Trm).format("0,0.00"),
                            numeral(Disc_trm).format("0.00"),
                            numeral(Ppn_trm).format("0,0.00"),
                            numeral(Min_ord).format("0,0"),
                            numeral(NilaiTrans).format("0,0.00"),
                            (item.NM_SUP ?? "").trim(),
                            (item.Waktu ?? "").trim(),
                            (item.Faktur ?? "").trim(),
                            (item.Ket_trm ?? "").trim(),
                            (item.No_terima ?? "").trim(),
                            (item.No_sup ?? "").trim(),
                            item.TglRetur
                                ? moment(item.TglRetur).format("MM/DD/YYYY")
                                : "",
                            (item.Nama_MataUang ?? "").trim(),
                            numeral(item.Kurs_Rp).format("0,0.00"),
                            item.Tgl_Faktur
                                ? moment(item.Tgl_Faktur).format("MM/DD/YYYY")
                                : "",
                            (item.No_SuratJalan ?? "").trim(),
                            (item.Satuan_Terima ?? "").trim(),
                            (item.Kd_brg ?? "").trim(),
                        ]);
                    });

                    // Redraw
                    table_barang.draw();
                    table_terima.draw();

                    total_terima.value =
                        numeral(lngQty).format("0,0") + " " + satuanQtyTerima;
                }
            },
            error: function (xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.error(err.Message);
            },
        });
    }

    function updateFlag(noTrans, flag, ask) {
        $.ajax({
            url: "/CreateBTTB/UpdateFlag",
            type: "PUT",
            data: {
                no_trans_1: noTrans,
                sFlag: flag,
                _token: csrfToken,
            },
            success: function (data) {
                if (data.error || data.length == 0) {
                    errorHandling("ajaxGetDataResponse", data.error);
                } else {
                    if (ask === 1) {
                        Swal.fire({
                            icon: "success",
                            title: "Data sudah diterima.",
                            timer: 2000,
                            showConfirmButton: false,
                        }).then(loadTerima);
                    } else {
                        Swal.fire({
                            icon: "info",
                            title: "Pesanan selesai",
                            text:
                                "No. Trans: " +
                                noTrans +
                                " sudah memenuhi kuota pesanan",
                            timer: 1500,
                            showConfirmButton: false,
                        }).then(loadTerima);
                    }
                }
            },
        });
    }

    function getTotalQtyTerimaExisting(KodeBarang) {
        let total = 0;
        table_terima.rows().every(function () {
            let row = this.data();
            let kodeBarangTerima = row[23];
            console.log(kodeBarangTerima);
            if (KodeBarang && kodeBarangTerima == KodeBarang) {
                total += numeral(row[4]).value();
            }
        });
        return total;
    }

    //#endregion

    //#region Event Listener

    select_divisi.on("select2:select", function () {
        let selectedIdDivisi = select_divisi.val();
        table_barang.clear();
        table_terima.clear();
        $.ajax({
            url: "/CreateBTTB/getDataSPPB",
            type: "GET",
            data: {
                idDivisi: selectedIdDivisi,
                _token: csrfToken,
            },
            success: function (data) {
                if (data.error || data.length == 0) {
                    errorHandling("ajaxGetDataResponse", data.error);
                } else {
                    select_noSPPB.empty();
                    data.dataSPPB.forEach(function (item) {
                        select_noSPPB.append(
                            new Option(item.no_sppb, item.no_sppb) // prettier-ignore
                        );
                    });
                    select_noSPPB.val(null).trigger("change");
                    select_noSPPB.select2("open");
                }
            },
            error: function (xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.error(err.Message);
            },
        });
    });

    select_divisi.on("select2:clear", function () {
        select_noSPPB.empty();
        table_barang.clear().draw();
        table_terima.clear().draw();
        total_terima.value = "";
    });

    select_noSPPB.on("select2:select", function () {
        loadTerima();
    });

    select_noSPPB.on("select2:clear", function () {
        table_barang.clear().draw();
        table_terima.clear().draw();
        total_terima.value = "";
    });

    $("#createBTTBModal").on("shown.bs.modal", function (event) {
        if (proses == "isiBTTB") {
            bttb_qtyTerima.select();
            bttb_hargaPer.value = 0;
            bttb_nilaiTrans.value = 0;
            bttb_hargaPer.value = 0;
            bttb_nilaiTrans.value = 0;
            bttb_qtyTerima.value = 0;
            bttb_qtyTerimaActual.value = 0;
            bttb_qtyTerimaKoreksi.value = 0;
            bttb_qtyTerimaActualKoreksi.value = 0;
        } else if (proses == "koreksiBTTB") {
            bttb_noFaktur.select();
        }
    });

    btn_isi.addEventListener("click", function (e) {
        if (!select_noSPPB.val()) {
            errorHandling(
                "sppbKosong",
                "Silahkan pilih nomor sppb yang ingin diproses"
            );
            return;
        }

        if (!selectedBarangRow) {
            Swal.fire({
                icon: "error",
                title: "Barang belum dipilih!",
                text: "Silahkan pilih barang pada tabel terlebih dahulu",
                showConfirmButton: false,
                timer: 1500,
            });
            return;
        }

        if (selectedBarangRow[9] == "Y") {
            Swal.fire({
                icon: "error",
                title: "BTTB Sudah Selesai!",
                text: "Silahkan pilih barang dengan kolom selesai 'N'",
                showConfirmButton: false,
                timer: 1500,
            });
            return;
        }

        // gunakan row yang dipilih user
        bttb_kodeBarang.value = selectedBarangRow[1];
        bttb_namaBarang.value = selectedBarangRow[2];
        bttb_satTerima.value = selectedBarangRow[6];
        bttb_satTerimaActual.value = selectedBarangRow[6];

        $.ajax({
            url: "/CreateBTTB/loadHarga",
            type: "GET",
            data: {
                NoTrans: selectedBarangRow[8],
                _token: csrfToken,
            },
            success: function (data) {
                if (data.error || data.length == 0) {
                    errorHandling("ajaxGetDataResponse", data.error);
                } else {
                    bttb_noSatTerima.value = data.dataHarga[0].NoSatuan.trim();
                    bttb_supplier.value = data.dataHarga[0].NM_SUP?.trim();
                    bttb_noSupplier.value = data.dataHarga[0].No_sup?.trim();
                    bttb_harga.value = numeral(
                        data.dataHarga[0].Hrg_trm
                    ).value();
                    bttb_selectMataUang
                        .val(data.dataHarga[0].IdMataUang)
                        .trigger("change");
                    bttb_discount.value = numeral(
                        data.dataHarga[0].Disc_trm
                    ).value();
                    bttb_ppn.value = numeral(data.dataHarga[0].Ppn_trm).value();
                    bttb_kursRupiah.value = numeral(
                        data.dataHarga[0].Kurs_Rp
                    ).value();
                    bttb_jangkaWaktu.value = numeral(
                        data.dataHarga[0].Waktu
                    ).value();
                    bttb_jangkaWaktu.dispatchEvent(enterKeyboardEvent);

                    proses = "isiBTTB";
                    bttb_qtyTerima.readOnly = false;
                    bttb_qtyTerimaActual.readOnly = false;

                    $("#createBTTBModal").modal("show");
                }
            },
        });
    });

    btn_koreksi.addEventListener("click", function (e) {
        if (select_noSPPB.val()) {
            proses = "koreksiBTTB";

            let selectedRow = $("#table_terima tbody tr.selected");
            if (!selectedRow.length) {
                errorHandling(
                    "table_terimaBelumDipilih",
                    "Silahkan pilih data"
                );
                return;
            }

            let rowData = table_terima.row(selectedRow).data();

            let kodeBarangTerima = rowData[23];

            let barangRow = null;
            table_barang.rows().every(function () {
                let data = this.data();
                if (data[1] === kodeBarangTerima) {
                    barangRow = data;
                    return false;
                }
            });

            if (!barangRow) {
                Swal.fire("Error", "Barang tidak ditemukan", "error");
                return;
            }

            bttb_noTerima.value = rowData[15];
            bttb_noSupplier.value = rowData[16];
            bttb_kodeBarang.value = barangRow[1];
            bttb_namaBarang.value = barangRow[2];
            bttb_satTerima.value = barangRow[6];
            bttb_satTerimaActual.value = barangRow[6];
            bttb_tanggal.value = moment(rowData[1]).format("YYYY-MM-DD");
            bttb_qtyTerima.value = numeral(rowData[2]).value();
            bttb_qtyTerimaKoreksi.value = numeral(rowData[2]).value();
            bttb_qtyTerimaActual.value = numeral(rowData[4]).value();
            bttb_qtyTerimaActualKoreksi.value = numeral(rowData[4]).value();
            bttb_tanggalFaktur.value = moment(rowData[20]).format("YYYY-MM-DD");
            bttb_noFaktur.value = rowData[13];
            bttb_nomorSJ.value = rowData[21];

            let option = bttb_selectMataUang.find("option").filter(function () {
                return (
                    $(this).text().trim().toLowerCase() ===
                    rowData[18].toLowerCase()
                );
            });

            if (option.length) {
                bttb_selectMataUang
                    .val(option.val())
                    .trigger("change")
                    .trigger("select2:select");
            }

            // bttb_selectMataUang.val(rowData[18]).trigger("change");
            bttb_kursRupiah.value = numeral(rowData[19]).value();
            bttb_harga.value = numeral(rowData[6]).value();
            bttb_discount.value = numeral(rowData[7]).value();
            bttb_ppn.value = numeral(rowData[8]).value();
            bttb_hargaPer.value = numeral(rowData[9]).value();
            bttb_nilaiTrans.value = numeral(rowData[10]).value();
            bttb_supplier.value = rowData[11].trim();
            bttb_jangkaWaktu.value = numeral(rowData[12]).value();
            bttb_pembayaran.value = rowData[12] == 0 ? "TUNAI" : "KREDIT";
            bttb_keterangan.value = rowData[14];
            bttb_qtyTerima.readOnly = true;
            bttb_qtyTerimaActual.readOnly = true;

            $.ajax({
                url: "/CreateBTTB/getDataDetailTerima",
                type: "GET",
                data: {
                    noTerima: rowData[15],
                    _token: csrfToken,
                },
                success: function (data) {
                    console.log(data);

                    if (data.error || data.length == 0) {
                        errorHandling(
                            "ajaxGetDataResponse",
                            data.error ?? "Tidak ada data detail terima"
                        );
                        return;
                    } else {
                        bttb_jenisDokumen.value = data[0].Jenis_Dokumen ?? "";
                        bttb_noSeriBarang.value = data[0].No_Seri_Barang ?? "";
                        bttb_noPIBKRR.value = data[0].No_PIB_KRR ?? "";
                        bttb_noPIBExternal.value =
                            data[0].No_PIB_External ?? "";
                        bttb_tglPIBExternal.value = moment(
                            data[0].Tgl_PIB_External
                        ).format("YYYY-MM-DD");
                        bttb_noRegisPIB.value =
                            data[0].No_Registration_PIB ?? "";
                        bttb_tglRegisPIB.value = moment(
                            data[0].Tgl_Registration_PIB
                        ).format("YYYY-MM-DD");
                        bttb_noBL.value = data[0].No_BL ?? "";
                        bttb_tglBL.value = moment(data[0].Tgl_BL).format(
                            "YYYY-MM-DD"
                        );
                        bttb_noKontrak.value = data[0].No_Kontrak ?? "";
                        bttb_tglKontrak.value = moment(
                            data[0].Tgl_Kontrak
                        ).format("YYYY-MM-DD");
                        bttb_noSPPBBC.value = data[0].No_SPPB_BC ?? "";
                        bttb_tglSPPBBC.value = moment(
                            data[0].Tgl_SPPB_BC
                        ).format("YYYY-MM-DD");
                        $("#createBTTBModal").modal("show");
                    }
                },
                error: function (xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    console.error(err.Message);
                },
            });
        } else {
            errorHandling(
                "sppbKosong",
                "Silahkan pilih nomor sppb yang ingin diproses"
            );
        }
    });

    bttb_tanggal.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            bttb_qtyTerima.focus();
        }
    });

    bttb_qtyTerima.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            bttb_qtyTerimaActual.select();
        }
    });

    bttb_qtyTerimaActual.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            bttb_tanggalFaktur.focus();
        }
    });

    bttb_tanggalFaktur.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            bttb_noFaktur.focus();
        }
    });

    bttb_noFaktur.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            bttb_nomorSJ.focus();
        }
    });

    bttb_nomorSJ.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            bttb_selectMataUang.select2("open");
        }
    });

    bttb_selectMataUang.on("select2:select", function () {
        let selectedIdMataUang = bttb_selectMataUang.val();
        if (selectedIdMataUang == 1) {
            bttb_kursRupiah.value = 1;
            bttb_kursRupiah.readOnly = true;
            bttb_harga.select();
        } else {
            bttb_kursRupiah.readOnly = false;
            bttb_kursRupiah.select();
        }
    });

    bttb_kursRupiah.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            bttb_harga.select();
        }
    });

    bttb_harga.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            bttb_discount.select();
        }
    });

    bttb_discount.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            bttb_ppn.select();
        }
    });

    bttb_ppn.addEventListener("keyup", function (e) {
        if (this.value == "12") {
            bttb_divCbDPP.style.display = "block";
        } else {
            bttb_checkboxDPP.checked = false;
            bttb_divCbDPP.style.display = "none";
        }
    });

    bttb_ppn.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            bttb_hargaPer.select();
        }
    });

    bttb_hargaPer.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();

            let hargaDiscount =
                parseFloat(bttb_harga.value) -
                (parseFloat(bttb_harga.value) *
                    parseFloat(bttb_discount.value)) /
                    100.0;

            if (parseFloat(bttb_ppn.value) == 12 && bttb_checkboxDPP.checked) {
                dppNilaiLain = (hargaDiscount * 11) / 12;
            } else {
                dppNilaiLain = hargaDiscount;
            }

            let nilaiTrans =
                hargaDiscount +
                (dppNilaiLain * parseFloat(bttb_ppn.value)) / 100;

            let nilaiTrans2 =
                (nilaiTrans / parseFloat(bttb_hargaPer.value)) *
                parseFloat(bttb_qtyTerimaActual.value);

            bttb_nilaiTrans.value = nilaiTrans2.toFixed(5);
            bttb_jangkaWaktu.select();
        }
    });

    bttb_jangkaWaktu.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            if (this.value == 0) {
                bttb_pembayaran.value = "TUNAI";
            } else {
                bttb_pembayaran.value = "KREDIT";
            }
            bttb_keterangan.focus();
        }
    });

    bttb_keterangan.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            bttb_jenisDokumen.focus();
        }
    });

    bttb_jenisDokumen.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            bttb_noSeriBarang.focus();
        }
    });

    bttb_noSeriBarang.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            bttb_noPIBKRR.focus();
        }
    });

    bttb_noPIBKRR.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            bttb_noPIBExternal.focus();
        }
    });

    bttb_noPIBExternal.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            bttb_noRegisPIB.focus();
        }
    });

    bttb_noRegisPIB.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            bttb_noBL.focus();
        }
    });

    bttb_noBL.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            bttb_noKontrak.focus();
        }
    });

    bttb_noKontrak.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            bttb_noSPPBBC.focus();
        }
    });

    bttb_noSPPBBC.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            bttb_tglPIBExternal.focus();
        }
    });

    bttb_tglPIBExternal.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            bttb_tglRegisPIB.focus();
        }
    });

    bttb_tglRegisPIB.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            bttb_tglBL.focus();
        }
    });

    bttb_tglBL.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            bttb_tglKontrak.focus();
        }
    });

    bttb_tglKontrak.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            bttb_tglSPPBBC.focus();
        }
    });

    bttb_tglSPPBBC.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            button_modalProses.focus();
        }
    });

    button_modalProses.addEventListener("click", function (e) {
        if (bttb_qtyTerima.value == 0 || !bttb_qtyTerima.value) {
            errorHandling(
                "qtyTerimaKosong",
                "Quantity Terima tidak boleh kosong"
            );
            return;
        }

        let no_trans = selectedBarangRow[8];
        let qtyPesan = numeral(selectedBarangRow[5]).value();
        let qtyTerimaExisting = getTotalQtyTerimaExisting(selectedBarangRow[1]);
        let qtyTerimaInput = numeral(bttb_qtyTerima.value).value();
        let sisaQty = qtyPesan - qtyTerimaExisting - qtyTerimaInput;

        // console.log(qtyPesan, qtyTerimaExisting, qtyTerimaInput, sisaQty);

        if (sisaQty < 0) {
            Swal.fire({
                icon: "error",
                title: "Qty Terima melebihi sisa Qty Pesan!",
                html: `
                    Qty Pesan : <b>${numeral(qtyPesan).format("0,0")}</b><br>
                    Qty Terima : <b>${numeral(qtyTerimaExisting).format(
                        "0,0"
                    )}</b><br>
                    Sisa : <b>${numeral(sisaQty).format("0,0")}</b><br>
                `,
                showConfirmButton: true,
            });
            return;
        }

        if (bttb_keterangan.value == "") {
            bttb_keterangan.value = "-";
        }

        if (bttb_qtyTerimaActual.value == 0 || !bttb_qtyTerimaActual.value) {
            errorHandling(
                "qtyTerimaKosongActual",
                "Quantity Terima Actual tidak boleh kosong"
            );
            return;
        }

        let hrg_murni = 0.0;
        let hrg_murni_rp = 0.0;
        let hrg_disc = 0.0;
        let hrg_disc_rp = 0.0;
        let hrg_nego = 0.0;
        let hrg_nego_rp = 0.0;
        let hrg_ppn = 0.0;
        let hrg_ppn_rp = 0.0;
        console.log(
            hrg_murni,
            hrg_murni_rp,
            hrg_disc,
            hrg_disc_rp,
            hrg_nego,
            hrg_nego_rp,
            hrg_ppn,
            hrg_ppn_rp
        );

        hrg_murni =
            parseFloat(bttb_qtyTerimaActual.value) *
            parseFloat(bttb_harga.value);
        hrg_murni_rp = hrg_murni * parseFloat(bttb_kursRupiah.value);
        hrg_disc = (parseFloat(bttb_discount.value) / 100) * hrg_murni;
        hrg_disc_rp = hrg_disc * parseFloat(bttb_kursRupiah.value);
        hrg_nego = hrg_murni - hrg_disc;
        hrg_nego_rp = hrg_murni_rp - hrg_disc_rp;
        hrg_ppn = hrg_nego * (parseFloat(bttb_ppn.value) / 100);
        hrg_ppn_rp = hrg_ppn * parseFloat(bttb_kursRupiah.value);

        const formData = new FormData();

        formData.append("_token", csrfToken);
        formData.append("jenisProses", proses);
        formData.append("no_terima", bttb_noTerima.value ?? "");
        formData.append("datang", bttb_tanggal.value);
        formData.append("qty", bttb_qtyTerima.value);
        formData.append("QtyTerima", bttb_qtyTerimaActual.value);
        formData.append("SatuanTerima", bttb_noSatTerima.value);
        formData.append("faktur", bttb_noFaktur.value);
        formData.append("no_sup", bttb_noSupplier.value);
        formData.append("min_ord", bttb_hargaPer.value);
        formData.append("hrg_trm", bttb_harga.value);
        formData.append("disc_trm", bttb_discount.value);
        formData.append("ppn_trm", bttb_ppn.value);
        formData.append("waktu", bttb_jangkaWaktu.value);
        formData.append("no_ket", bttb_jangkaWaktu.value == 0 ? "001" : "002");
        formData.append("no_sppb", select_noSPPB.val());
        formData.append("no_trans", no_trans);
        formData.append("kd_div", select_divisi.val());
        formData.append("IdMataUang", bttb_selectMataUang.val());
        formData.append("Kurs", bttb_kursRupiah.value);
        formData.append("TglFaktur", bttb_tanggalFaktur.value);
        formData.append("NoSJ", bttb_nomorSJ.value);
        formData.append("hrg_murni", hrg_murni);
        formData.append("hrg_murni_rp", hrg_murni_rp);
        formData.append("hrg_disc", hrg_disc);
        formData.append("hrg_disc_rp", hrg_disc_rp);
        formData.append("hrg_nego", hrg_nego);
        formData.append("hrg_nego_rp", hrg_nego_rp);
        formData.append("hrg_ppn", hrg_ppn);
        formData.append("hrg_ppn_rp", hrg_ppn_rp);
        formData.append("Jenis_Dokumen", bttb_jenisDokumen.value);
        formData.append("No_Seri_Barang", bttb_noSeriBarang.value);
        formData.append("No_PIB_KRR", bttb_noPIBKRR.value);
        formData.append("No_PIB_External", bttb_noPIBExternal.value);
        formData.append("Tgl_PIB_External", bttb_tglPIBExternal.value);
        formData.append("No_Registration_PIB", bttb_noRegisPIB.value);
        formData.append("Tgl_Registration_PIB", bttb_tglRegisPIB.value);
        formData.append("No_BL", bttb_noBL.value);
        formData.append("Tgl_BL", bttb_tglBL.value);
        formData.append("No_Kontrak", bttb_noKontrak.value);
        formData.append("Tgl_Kontrak", bttb_tglKontrak.value);
        formData.append("No_SPPB_BC", bttb_noSPPBBC.value);
        formData.append("Tgl_SPPB_BC", bttb_tglSPPBBC.value);
        formData.append("qty_koreksi", bttb_qtyTerimaKoreksi.value ?? 0);
        formData.append(
            "QtyTerimakoreksi",
            bttb_qtyTerimaActualKoreksi.value ?? 0
        );

        $.ajax({
            url: "/CreateBTTB",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if (data.error || data.length == 0) {
                    errorHandling("ajaxGetDataResponse", data.error);
                } else {
                    loadTerima();
                    let jumlahTerima = parseFloat(
                        bttb_qtyTerima.value
                    );
                    let jumlahPesan = numeral(
                        table_barang.data()[0][5]
                    ).value();
                    let selisih = jumlahPesan - jumlahTerima;

                    if (selisih <= 0) {
                        updateFlag(no_trans, "Y", 0);
                        loadTerima();
                    } else {
                        Swal.fire({
                            title: "Are you sure?",
                            text: "Qty Terima yang dimasukkan belum memenuhi Qty Pesan yang dibutuhkan. Apakah ingin melanjutkan?",
                            icon: "question",
                            confirmButtonText: "Yes",
                            cancelButtonText: "No",
                            showCancelButton: true,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                updateFlag(no_trans, "Y", 1);
                            }
                            loadTerima();
                            $("#createBTTBModal").modal("hide");
                        });
                    }
                }
            },
            error: function (xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.error(err.Message);
            },
        });
    });

    $("#table_terima tbody").on("click", "tr", function () {
        let rowData = table_terima.row(this).data();

        if (!rowData) {
            return;
        }

        // remove highlight from other rows
        $("#table_terima tbody tr").removeClass("selected");
        // add highlight to clicked row
        $(this).addClass("selected");
        // console.log(rowData);
    });

    btn_koreksiKurs.addEventListener("click", function (e) {
        e.preventDefault();
        $("#koreksiKursModal").modal("show");
        koreksiKurs_tableBarang.clear().draw();
        koreksiKurs_tableKurs.clear().draw();
        koreksiKurs_tableSales.clear().draw();
        koreksiKurs_tableJual.clear().draw();
    });

    $("#koreksiKursModal").on("shown.bs.modal", function (event) {
        koreksiKurs_noFaktur.value = "";
        koreksiKurs_kodeBarang.value = "";
        koreksiKurs_namaBarang.value = "";
        koreksiKurs_harga.value = 0;
        koreksiKurs_kurs.value = 0;
        koreksiKurs_totalBayar.value = 0;
        koreksiKurs_Proses.disabled = true;
    });

    koreksiKurs_noFaktur.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            $.ajax({
                url: "/CreateBTTB/getListSPPBKoreksiKurs",
                type: "GET",
                data: {
                    NoSPPB: this.value,
                    _token: csrfToken,
                },
                success: function (data) {
                    console.log(data);

                    if (data.error || data.length == 0) {
                        errorHandling("ajaxGetDataResponse", data.error);
                    } else {
                        koreksiKurs_tableBarang.clear();
                        // Insert ListBarang
                        data.forEach(function (item) {
                            koreksiKurs_tableBarang.row.add([
                                moment(item.Datang).format("MM/DD/YYYY"),
                                item.Kd_brg,
                                item.NAMA_BRG,
                                numeral(item.Hrg_trm).format("0,0.0000"),
                                numeral(item.Kurs_Rp).format("0,0.00"),
                                item.No_terima,
                            ]);
                        });
                        koreksiKurs_tableBarang.draw();
                    }
                },
                error: function (xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    console.error(err.Message);
                },
            });
        }
    });

    $("#koreksiKurs_tableBarang tbody").on("click", "tr", function () {
        let rowData = koreksiKurs_tableBarang.row(this).data();

        if (!rowData) {
            return;
        }

        // remove highlight from other rows
        $("#koreksiKurs_tableBarang tbody tr").removeClass("selected");
        // add highlight to clicked row
        $(this).addClass("selected");
        // console.log(rowData);

        koreksiKurs_harga.value = numeral(rowData[3]).value();
        koreksiKurs_kodeBarang.value = rowData[1];
        koreksiKurs_namaBarang.value = rowData[2];
        koreksiKurs_kurs.value = numeral(rowData[4]).value();
        koreksiKurs_nomorTerima.value = rowData[5];
        if (koreksiKurs_kurs.value > 0 && koreksiKurs_harga.value > 0) {
            koreksiKurs_kurs.dispatchEvent(enterKeyboardEvent);
        }
        koreksiKurs_kurs.select();
    });

    koreksiKurs_kurs.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            this.value = numeral(this.value).value();
            let harga = parseFloat(koreksiKurs_harga.value);
            let kurs = parseFloat(this.value);
            koreksiKurs_totalBayar.value = numeral(harga * kurs).format(
                "0.000"
            );
            koreksiKurs_Proses.disabled = false;
            koreksiKurs_Proses.focus();
        }
    });

    koreksiKurs_Proses.addEventListener("click", function (e) {
        $.ajax({
            url: "/CreateBTTB/ProsesKoreksiKurs",
            type: "PUT",
            data: {
                NoSPPB: koreksiKurs_nomorTerima.value,
                Kurs: koreksiKurs_kurs.value,
                KodeBarang: koreksiKurs_kodeBarang.value,
                _token: csrfToken,
            },
            success: function (data) {
                console.log(data);
                if (data.error || data.length == 0) {
                    errorHandling("ajaxGetDataResponse", data.error);
                } else {
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil!",
                        text: data.success,
                        showConfirmButton: false,
                        timer: 2500,
                    }).then(() => {
                        $("#koreksiKurs_tableBarang tbody tr").removeClass(
                            "selected"
                        );
                        koreksiKurs_noFaktur.value = "";
                        koreksiKurs_kodeBarang.value = "";
                        koreksiKurs_namaBarang.value = "";
                        koreksiKurs_harga.value = 0;
                        koreksiKurs_kurs.value = 0;
                        koreksiKurs_totalBayar.value = 0;
                        koreksiKurs_Proses.disabled = true;
                    });
                }
            },
            error: function (xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.error(err.Message);
            },
        });
    });

    $("#table_barang tbody").on("click", "tr", function () {
        let rowData = table_barang.row(this).data();

        if (!rowData) return;
        $("#table_barang tbody tr").removeClass("selected");
        $(this).addClass("selected");
        selectedBarangRow = rowData;
    });
    //#endregion
});
