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
    let btn_isi = document.getElementById("btn_isi");
    let btn_koreksi = document.getElementById("btn_koreksi");
    let createBTTBModalLabel = document.getElementById("createBTTBModalLabel");
    let bttb_kodeBarang = document.getElementById("bttb_kodeBarang");
    let bttb_namaBarang = document.getElementById("bttb_namaBarang");
    let bttb_tanggal = document.getElementById("bttb_tanggal");
    let bttb_qtyTerima = document.getElementById("bttb_qtyTerima");
    let bttb_satTerima = document.getElementById("bttb_satTerima");
    let bttb_qtyTerimaActual = document.getElementById("bttb_qtyTerimaActual");
    let bttb_satTerimaActual = document.getElementById("bttb_satTerimaActual");
    let bttb_tanggalFaktur = document.getElementById("bttb_tanggalFaktur");
    let bttb_noFaktur = document.getElementById("bttb_noFaktur");
    let bttb_nomorSJ = document.getElementById("bttb_nomorSJ");
    let bttb_selectMataUang = $("#bttb_selectMataUang");
    let bttb_kursRupiah = document.getElementById("bttb_kursRupiah");
    let bttb_harga = document.getElementById("bttb_harga");
    let bttb_discount = document.getElementById("bttb_discount");
    let bttb_ppn = document.getElementById("bttb_ppn");
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
                if (data.error) {
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
                if (data.error) {
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
                text: "Silahkan pilih nomor sppb yang ingin diproses",
                showConfirmButton: false,
                timer: 1500,
            });
        } else if (jenisError == "ajaxGetDataResponse") {
            Swal.fire({
                icon: "error",
                title: "Error!",
                text: data,
                showConfirmButton: false,
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
                if (data.error) {
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
        let selectedNoSPPB = select_noSPPB.val();
        $.ajax({
            url: "/CreateBTTB/getDataDetailSPPB",
            type: "GET",
            data: {
                idDivisi: select_divisi.val(),
                noSPPB: selectedNoSPPB,
                _token: csrfToken,
            },
            success: function (data) {
                if (data.error) {
                    errorHandling("ajaxGetDataResponse", data.error);
                } else {
                    table_barang.clear();
                    table_terima.clear();

                    // Insert ListBarang
                    data.ListBarang.forEach(function (item) {
                        table_barang.row.add([
                            item.keterangan,
                            item.Kd_brg,
                            item.NAMA_BRG,
                            item.nama_kategori,
                            item.nama_sub_kategori,
                            numeral(item.Qty).format("0,0"),
                            item.Nama_satuan.trim(),
                            item.Tgl_order
                                ? moment(item.Tgl_order).format("MM/DD/YYYY")
                                : "",
                            item.No_trans,
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
                            item.Sat_Pesan.trim(),
                            numeral(Qty_Terima).format("0,0"),
                            item.Sat_Terima.trim(),
                            numeral(Hrg_Trm).format("0,0.00"),
                            numeral(Disc_trm).format("0.00"),
                            numeral(Ppn_trm).format("0,0.00"),
                            numeral(Min_ord).format("0,0"),
                            numeral(NilaiTrans).format("0,0.00"),
                            item.NM_SUP.trim(),
                            item.Waktu.trim(),
                            item.Faktur.trim(),
                            item.Ket_trm.trim(),
                            item.No_terima.trim(),
                            item.No_sup.trim(),
                            item.TglRetur
                                ? moment(item.TglRetur).format("MM/DD/YYYY")
                                : "",
                            item.Nama_MataUang.trim(),
                            numeral(item.Kurs_Rp).format("0,0.00"),
                            item.Tgl_Faktur
                                ? moment(item.Tgl_Faktur).format("MM/DD/YYYY")
                                : "",
                            item.No_SuratJalan.trim(),
                            item.Satuan_Terima.trim(),
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
    });

    select_noSPPB.on("select2:clear", function () {
        table_barang.clear().draw();
        table_terima.clear().draw();
        total_terima.value = "";
    });

    $("#createBTTBModal").on("shown.bs.modal", function (event) {
        bttb_hargaPer.value = 0;
        bttb_nilaiTrans.value = 0;
        bttb_hargaPer.value = 0;
        bttb_nilaiTrans.value = 0;
        bttb_qtyTerima.value = 0;
        bttb_qtyTerimaActual.value = 0;
        bttb_qtyTerima.select();
    });

    btn_isi.addEventListener("click", function (e) {
        if (select_noSPPB.val()) {
            bttb_kodeBarang.value = table_barang.data()[0][1];
            bttb_namaBarang.value = table_barang.data()[0][2];
            bttb_satTerima.value = table_barang.data()[0][6];
            bttb_satTerimaActual.value = table_barang.data()[0][6];
            $.ajax({
                url: "/CreateBTTB/loadHarga",
                type: "GET",
                data: {
                    NoTrans: table_barang.data()[0][8],
                    _token: csrfToken,
                },
                success: function (data) {
                    console.log(data);
                    if (data.error) {
                        errorHandling("ajaxGetDataResponse", data.error);
                    } else {
                        bttb_supplier.value = data.dataHarga[0].NM_SUP?.trim();
                        bttb_noSupplier.value =
                            data.dataHarga[0].No_sup?.trim();
                        bttb_harga.value = numeral(data.dataHarga[0].Hrg_trm).value(); //prettier-ignore
                        bttb_selectMataUang
                            .val(data.dataHarga[0].IdMataUang)
                            .trigger("change");
                        bttb_discount.value = numeral(data.dataHarga[0].Disc_trm).value(); //prettier-ignore
                        bttb_ppn.value = numeral(data.dataHarga[0].Ppn_trm).value(); //prettier-ignore
                        bttb_kursRupiah.value = numeral(data.dataHarga[0].Kurs_Rp).value(); //prettier-ignore
                        bttb_jangkaWaktu.value = numeral(data.dataHarga[0].Waktu).value(); //prettier-ignore
                        bttb_jangkaWaktu.dispatchEvent(enterKeyboardEvent);
                        $("#createBTTBModal").modal("show");
                    }
                },
                error: function (xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    console.error(err.Message);
                },
            });
        } else {
            errorHandling("sppbKosong");
        }
    });

    btn_koreksi.addEventListener("click", function (e) {
        if (select_noSPPB.val()) {
            $("#createBTTBModal").modal("show");
        } else {
            errorHandling("sppbKosong");
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

    bttb_ppn.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            bttb_hargaPer.select();
        }
    });

    bttb_hargaPer.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
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

    button_modalProses.addEventListener("click", function (e) {});
    //#endregion
});
