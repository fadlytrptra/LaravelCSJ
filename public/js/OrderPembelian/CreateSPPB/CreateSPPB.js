jQuery(function ($) {
    //#region Variables
    let csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
    const enterEvent = new KeyboardEvent("keypress", {
        key: "Enter",
        code: "Enter",
        keyCode: 13,
        which: 13,
        bubbles: true,
    });
    let idUser = document.getElementById("idUser");
    let table_sppb = $("#table_sppb").DataTable({
        processing: true, // Optional, as processing is more relevant for server-side
        responsive: true,
        serverSide: true,
        order: [2, "desc"],
        ajax: {
            url: "/CreateSPPB/getDataSPPB",
            type: "GET",
        },
        columns: [
            { data: "No_sppb" },
            { data: "NM_SUP" },
            {
                data: "Tgl_sppb",
                render: function (data, type, full, meta) {
                    return moment(data).format("YYYY-MM-DD");
                },
            },
            {
                data: "No_sppb",
                render: function (data, type, full, meta) {
                    let buttonCetak =
                        '<button class="btn btn-success btn-print" data-id="' +
                        data +
                        '"data-div="' +
                        full.Kd_div +
                        '">Cetak PO</button>';
                    let buttonEdit =
                        '<button class="btn btn-primary btn-edit" data-id="' +
                        data +
                        '" data-toggle="modal" data-target="#modalSPPB">Edit</button>';
                    let buttonACC =
                        '<button class="btn btn-warning btn-acc" data-id="' +
                        data +
                        '">Submit</button>';
                    let buttonHapus =
                        '<button class="btn btn-danger btn-hapus" data-id="' +
                        data +
                        '">Hapus</button>';
                    if (full.Tgl_Direktur) {
                        return buttonCetak;
                    } else if (full.Tgl_acc) {
                        return buttonCetak + buttonEdit + buttonHapus;
                    } else {
                        return (
                            buttonCetak + buttonACC + buttonEdit + buttonHapus
                        );
                    }
                },
            },
        ],
    });
    let buttonTambahSPPB = document.getElementById("buttonTambahSPPB");
    let sppb_nomorSatuan = document.getElementById("sppb_nomorSatuan");
    let sppb_tanggal = document.getElementById("sppb_tanggal");
    let sppb_tanggalDibutuhkan = document.getElementById("sppb_tanggalDibutuhkan"); // prettier-ignore
    let sppb_divisi = $("#sppb_divisi");
    let sppb_jenisPembelian = $("#sppb_jenisPembelian");
    let sppb_supplier = $("#sppb_supplier");
    let sppb_pemesan = document.getElementById("sppb_pemesan");
    let sppb_mataUang = $("#sppb_mataUang");
    let sppb_kursRupiah = document.getElementById("sppb_kursRupiah");
    let sppb_jangkaWaktu = document.getElementById("sppb_jangkaWaktu");
    let sppb_pembayaran = document.getElementById("sppb_pembayaran");
    let sppb_tableOrderPembelian = $("#sppb_tableOrderPembelian").DataTable({
        searching: false,
        ordering: false,
        paging: false,
        info: false,
        autoWidth: false,
        columnDefs: [{ targets: [12, 13], visible: false }],
    });
    let sppb_golongan = $("#sppb_golongan");
    let sppb_kelompok = $("#sppb_kelompok");
    let sppb_kategoriUtama = $("#sppb_kategoriUtama");
    let sppb_kategori = $("#sppb_kategori");
    let sppb_subKategori = $("#sppb_subKategori");
    let sppb_namaBarang = $("#sppb_namaBarang");
    let sppb_kodeBarang = document.getElementById("sppb_kodeBarang");
    let sppb_keteranganKhusus = document.getElementById("sppb_keteranganKhusus"); //prettier-ignore
    let sppb_keteranganBarang = document.getElementById("sppb_keteranganBarang"); //prettier-ignore
    let sppb_quantityBarang = document.getElementById("sppb_quantityBarang");
    let sppb_KeteranganOrder = document.getElementById("sppb_KeteranganOrder");
    let sppb_hargaSatuan = document.getElementById("sppb_hargaSatuan");
    let sppb_discount = document.getElementById("sppb_discount");
    let sppb_ppn = document.getElementById("sppb_ppn");
    let sppb_divDppFull = document.getElementById("sppb_divDppFull");
    let sppb_dppFull = document.getElementById("sppb_dppFull");
    let sppb_DPPNilaiLain = document.getElementById("sppb_DPPNilaiLain");
    let sppb_hargaPPN = document.getElementById("sppb_hargaPPN");
    let sppb_subTotalHargaJual = document.getElementById("sppb_subTotalHargaJual"); // prettier-ignore
    let sppb_totalHarga = document.getElementById("sppb_totalHarga");
    let sppb_buttonAdd = document.getElementById("sppb_buttonAdd");
    let sppb_buttonUpdate = document.getElementById("sppb_buttonUpdate");
    let sppb_buttonDelete = document.getElementById("sppb_buttonDelete");
    let sppb_deliveryTerm = document.getElementById("sppb_deliveryTerm");
    let sppb_packing = document.getElementById("sppb_packing");
    let sppb_shippingMark = document.getElementById("sppb_shippingMark");
    let sppb_deliveryTime = document.getElementById("sppb_deliveryTime");
    let sppb_documentsRequired = document.getElementById("sppb_documentsRequired"); //prettier-ignore
    let sppb_partialShipmentTransit = document.getElementById("sppb_partialShipmentTransit"); //prettier-ignore
    let sppb_portOfLoading = document.getElementById("sppb_portOfLoading");
    let sppb_portOfDischarge = document.getElementById("sppb_portOfDischarge");
    let sppb_otherConditions = document.getElementById("sppb_otherConditions");
    let sppb_payments = document.getElementById("sppb_payments");
    let sppb_buttonSave = document.getElementById("sppb_buttonSave");
    let sppb_buttonSubmit = document.getElementById("sppb_buttonSubmit");
    let selectedDivisi;
    let selectedJenisPembelian;
    let selectedSupplier;
    let selectedMataUang;
    let selectedGolongan;
    let selectedKelompok;
    let selectedKategoriUtama;
    let selectedKategori;
    let selectedSubKategori;
    let selectedKodeBarang;
    let selectedNamaBarang;
    var selectedRowData;
    //#endregion

    //#region Load Form
    initializeSelect2();
    getDataDivisi();
    getDataJenisBeli();
    getDataMataUang();
    getDataSupplier();
    getDataKategoriUtama();
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

    function initializeSelect2() {
        sppb_divisi.select2({
            dropdownParent: $("#sppb_select2ParentDivisi"),
            placeholder: "Pilih Divisi",
        });

        sppb_jenisPembelian.select2({
            dropdownParent: $("#sppb_select2ParentPembelian"),
            placeholder: "Pilih Jenis Pembelian",
        });

        sppb_supplier.select2({
            dropdownParent: $("#sppb_select2ParentSupplier"),
            placeholder: "Pilih Supplier",
        });

        sppb_mataUang.select2({
            dropdownParent: $("#sppb_select2ParentMataUang"),
            placeholder: "Pilih Mata Uang",
        });

        sppb_golongan.select2({
            dropdownParent: $("#sppb_select2ParentGolongan"),
            placeholder: "Pilih Golongan",
        });

        sppb_kelompok.select2({
            dropdownParent: $("#sppb_select2ParentKelompok"),
            placeholder: "Pilih Kelompok Mesin",
        });

        sppb_kategoriUtama.select2({
            dropdownParent: $("#sppb_select2ParentKategoriUtama"),
            placeholder: "Pilih Kategori Utama",
        });

        sppb_kategori.select2({
            dropdownParent: $("#sppb_select2ParentKategori"),
            placeholder: "Pilih Kategori",
        });

        sppb_subKategori.select2({
            dropdownParent: $("#sppb_select2ParentSubKategori"),
            placeholder: "Pilih Sub Kategori",
        });

        sppb_namaBarang.select2({
            dropdownParent: $("#sppb_select2ParentNamaBarang"),
            placeholder: "Pilih Nama Barang",
        });

        $("#sppb_golongan").each(function () {
            $(this).next(".select2-container").css({
                flex: "1 1 auto",
                width: "100%",
            });
        });

        $("#sppb_kelompok").each(function () {
            $(this).next(".select2-container").css({
                flex: "1 1 auto",
                width: "100%",
            });
        });

        $("#sppb_kategori").each(function () {
            $(this).next(".select2-container").css({
                flex: "1 1 auto",
                width: "100%",
            });
        });

        $("#sppb_subKategori").each(function () {
            $(this).next(".select2-container").css({
                flex: "1 1 auto",
                width: "100%",
            });
        });

        $("#sppb_namaBarang").each(function () {
            $(this).next(".select2-container").css({
                flex: "1 1 auto",
                width: "100%",
            });
        });
    }

    function init(initType) {
        if (initType == "modal") {
            sppb_pemesan.value = idUser.value;
            sppb_tanggal.valueAsDate = new Date();
            sppb_tanggalDibutuhkan.valueAsDate = new Date();
            sppb_tanggal.readOnly = false;
            sppb_tanggalDibutuhkan.readOnly = false;
            sppb_divisi.val(null).prop("disabled", false).trigger("change");
            sppb_jenisPembelian
                .val(null)
                .prop("disabled", false)
                .trigger("change");
            sppb_supplier.val(null).prop("disabled", false).trigger("change");
            sppb_pemesan.readOnly = false;
            sppb_mataUang.val(null).prop("disabled", false).trigger("change");
            sppb_kursRupiah.readOnly = false;
            sppb_kursRupiah.value = 0;
            sppb_jangkaWaktu.value = 0;
            sppb_jangkaWaktu.readOnly = false;
            sppb_pembayaran.value = "TUNAI";
            sppb_golongan.empty().prop("disabled", true).trigger("change");
            sppb_kelompok.empty().prop("disabled", true).trigger("change");
            sppb_kategoriUtama
                .val(null)
                .prop("disabled", false)
                .trigger("change");
            sppb_kategori.empty().prop("disabled", true).trigger("change");
            sppb_subKategori.empty().prop("disabled", true).trigger("change");
            sppb_namaBarang.empty().prop("disabled", true).trigger("change");
            sppb_kodeBarang.value = "";
            sppb_keteranganBarang.value = "";
            sppb_keteranganKhusus.value = "";
            sppb_quantityBarang.value = 1;
            sppb_KeteranganOrder.value = "";
            sppb_hargaSatuan.value = 1;
            sppb_discount.value = 0;
            sppb_ppn.value = 11;
            sppb_divDppFull.style.display = "none";
            sppb_DPPNilaiLain.value = "";
            sppb_hargaPPN.value = "";
            sppb_subTotalHargaJual.value = "";
            sppb_totalHarga.value = "";
            sppb_deliveryTerm.value = "";
            sppb_packing.value = "";
            sppb_shippingMark.value = "";
            sppb_deliveryTime.value = "";
            sppb_documentsRequired.value = "";
            sppb_partialShipmentTransit.value = "";
            sppb_portOfLoading.value = "";
            sppb_portOfDischarge.value = "";
            sppb_otherConditions.value = "";
            sppb_payments.value = "";
            sppb_buttonAdd.disabled = false;
        } else if (initType == "resetOrder") {
            sppb_namaBarang.val(null).trigger("change");
            sppb_kodeBarang.value = "";
            sppb_keteranganBarang.value = "";
            sppb_keteranganKhusus.value = "";
            sppb_quantityBarang.value = 1;
            sppb_hargaSatuan.value = 1;
            sppb_discount.value = 0;
            sppb_ppn.value = 11;
            sppb_divDppFull.style.display = "none";
            sppb_DPPNilaiLain.value = "";
            sppb_hargaPPN.value = "";
            sppb_subTotalHargaJual.value = "";
            sppb_totalHarga.value = "";
            sppb_buttonAdd.disabled = false;
            $("#sppb_tableOrderPembelian tbody tr").removeClass("selected");
        } else if (initType == "disableHeader") {
            sppb_tanggal.readOnly = true;
            sppb_tanggalDibutuhkan.readOnly = true;
            sppb_divisi.prop("disabled", true).trigger("change");
            sppb_jenisPembelian.prop("disabled", true).trigger("change");
            sppb_supplier.prop("disabled", true).trigger("change");
            sppb_pemesan.readOnly = true;
            sppb_mataUang.prop("disabled", true).trigger("change");
            sppb_kursRupiah.readOnly = true;
        }
    }

    function getDataDivisi() {
        sppb_divisi
            .data("select2")
            .options.set("placeholder", "Loading Divisi...");
        sppb_divisi.empty().prop("disabled", true).trigger("change");

        $.ajax({
            url: "/CreateSPPB/getDivisi",
            method: "GET",
            data: {
                _token: csrfToken,
            },
            dataType: "json",
            success: function (data) {
                if (!data) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        showConfirmButton: false,
                        timer: 1000,
                        text: "fetching data Divisi failed ",
                        returnFocus: false,
                    });
                } else {
                    data.forEach(function (item) {
                        sppb_divisi.append(
                            new Option( item.NM_DIV.trim(), item.Kd_div.trim()) // prettier-ignore
                        );
                    });

                    sppb_divisi
                        .data("select2")
                        .options.set("placeholder", "Pilih Divisi");
                    sppb_divisi
                        .prop("disabled", false)
                        .val(null)
                        .trigger("change");

                    $("#sppb_divisi").each(function () {
                        $(this).next(".select2-container").css({
                            flex: "1 1 auto",
                            width: "100%",
                        });
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Failed to load Divisi.",
                });
            },
        });
    }

    function getDataJenisBeli() {
        sppb_jenisPembelian
            .data("select2")
            .options.set("placeholder", "Loading Jenis Pembelian...");
        sppb_jenisPembelian.empty().prop("disabled", true).trigger("change");
        $.ajax({
            url: "/CreateSPPB/getJenisBeli",
            method: "GET",
            data: {
                _token: csrfToken,
            },
            dataType: "json",
            success: function (data) {
                if (!data) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        showConfirmButton: false,
                        timer: 1000,
                        text: "fetching data Jenis Beli failed ",
                        returnFocus: false,
                    });
                } else {
                    data.forEach(function (item) {
                        sppb_jenisPembelian.append(
                            new Option(item.KET.trim(), item.NO_JNS.trim())
                        );
                    });

                    sppb_jenisPembelian
                        .data("select2")
                        .options.set("placeholder", "Pilih Jenis Pembelian");
                    sppb_jenisPembelian
                        .prop("disabled", false)
                        .val(null)
                        .trigger("change");

                    $("#sppb_jenisPembelian").each(function () {
                        $(this).next(".select2-container").css({
                            flex: "1 1 auto",
                            width: "100%",
                        });
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Failed to load Jenis Beli.",
                });
            },
        });
    }

    function getDataSupplier() {
        sppb_supplier
            .data("select2")
            .options.set("placeholder", "Loading Supplier...");
        sppb_supplier.empty().prop("disabled", true).trigger("change");
        $.ajax({
            url: "/CreateSPPB/getSupplier",
            method: "GET",
            data: {
                _token: csrfToken,
            },
            dataType: "json",
            success: function (data) {
                if (!data) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        showConfirmButton: false,
                        timer: 1000,
                        text: "fetching data Supplier failed ",
                        returnFocus: false,
                    });
                } else {
                    data.forEach(function (item) {
                        sppb_supplier.append(
                            new Option(item.NM_SUP.trim(), item.NO_SUP.trim())
                        );
                    });

                    sppb_supplier
                        .data("select2")
                        .options.set("placeholder", "Pilih Supplier");
                    sppb_supplier
                        .prop("disabled", false)
                        .val(null)
                        .trigger("change");

                    $("#sppb_supplier").each(function () {
                        $(this).next(".select2-container").css({
                            flex: "1 1 auto",
                            width: "100%",
                        });
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Failed to load Supplier.",
                });
            },
        });
    }

    function getDataMataUang() {
        sppb_mataUang
            .data("select2")
            .options.set("placeholder", "Loading Mata Uang...");
        sppb_mataUang.empty().prop("disabled", true).trigger("change");
        $.ajax({
            url: "/CreateSPPB/getMataUang",
            method: "GET",
            data: {
                _token: csrfToken,
            },
            dataType: "json",
            success: function (data) {
                if (!data) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        showConfirmButton: false,
                        timer: 1000,
                        text: "fetching data Mata Uang failed ",
                        returnFocus: false,
                    });
                } else {
                    data.forEach(function (item) {
                        sppb_mataUang.append(
                            new Option(
                                item.Nama_MataUang.trim(),
                                item.Id_MataUang.trim()
                            )
                        );
                    });

                    sppb_mataUang
                        .data("select2")
                        .options.set("placeholder", "Pilih Mata Uang");
                    sppb_mataUang
                        .prop("disabled", false)
                        .val(null)
                        .trigger("change");

                    $("#sppb_mataUang").each(function () {
                        $(this).next(".select2-container").css({
                            flex: "1 1 auto",
                            width: "100%",
                        });
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Failed to load Mata Uang.",
                });
            },
        });
    }

    function getDataGolongan() {
        sppb_golongan
            .data("select2")
            .options.set("placeholder", "Loading Golongan...");
        sppb_golongan.empty().prop("disabled", true).trigger("change");
        return $.ajax({
            url: "/CreateSPPB/getGolongan",
            method: "GET",
            data: {
                kd_div: sppb_divisi.val(),
                _token: csrfToken,
            },
            dataType: "json",
            success: function (data) {
                if (!data) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        showConfirmButton: false,
                        timer: 1000,
                        text: "fetching data Golongan failed ",
                        returnFocus: false,
                    });
                } else {
                    data.forEach(function (item) {
                        sppb_golongan.append(
                            new Option(item.NM_GOL.trim(), item.NO_GOL.trim())
                        );
                    });

                    sppb_golongan
                        .data("select2")
                        .options.set("placeholder", "Pilih Golongan");
                    sppb_golongan
                        .prop("disabled", false)
                        .val(null)
                        .trigger("change");

                    $("#sppb_golongan").each(function () {
                        $(this).next(".select2-container").css({
                            flex: "1 1 auto",
                            width: "100%",
                        });
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Failed to load Golongan.",
                });
            },
        });
    }

    function getDataKelompokMesin() {
        sppb_kelompok
            .data("select2")
            .options.set("placeholder", "Loading Kelompok Mesin...");
        sppb_kelompok.empty().prop("disabled", true).trigger("change");
        return $.ajax({
            url: "/CreateSPPB/getKelompokMesin",
            method: "GET",
            data: {
                golongan: sppb_golongan.val(),
                _token: csrfToken,
            },
            dataType: "json",
            success: function (data) {
                if (!data) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        showConfirmButton: false,
                        timer: 1000,
                        text: "fetching data Kelompok Mesin failed ",
                        returnFocus: false,
                    });
                } else {
                    data.forEach(function (item) {
                        sppb_kelompok.append(
                            new Option(item.NM_MSN.trim(), item.NO_MSN.trim())
                        );
                    });

                    sppb_kelompok
                        .data("select2")
                        .options.set("placeholder", "Pilih Kelompok Mesin");
                    sppb_kelompok
                        .prop("disabled", false)
                        .val(null)
                        .trigger("change");

                    $("#sppb_kelompok").each(function () {
                        $(this).next(".select2-container").css({
                            flex: "1 1 auto",
                            width: "100%",
                        });
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Failed to load Kelompok Mesin.",
                });
            },
        });
    }

    function getDataKategoriUtama() {
        sppb_kategoriUtama
            .data("select2")
            .options.set("placeholder", "Loading Kategori Utama...");
        sppb_kategoriUtama.empty().prop("disabled", true).trigger("change");
        $.ajax({
            url: "/CreateSPPB/getKategoriUtama",
            method: "GET",
            data: {
                _token: csrfToken,
            },
            dataType: "json",
            success: function (data) {
                if (!data) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        showConfirmButton: false,
                        timer: 1000,
                        text: "fetching data Kategori Utama failed ",
                        returnFocus: false,
                    });
                } else {
                    data.forEach(function (item) {
                        sppb_kategoriUtama.append(
                            new Option(
                                item.nama.trim(),
                                item.no_kat_utama.trim()
                            )
                        );
                    });

                    sppb_kategoriUtama
                        .data("select2")
                        .options.set("placeholder", "Pilih Kategori Utama");
                    sppb_kategoriUtama
                        .prop("disabled", false)
                        .val(null)
                        .trigger("change");

                    $("#sppb_kategoriUtama").each(function () {
                        $(this).next(".select2-container").css({
                            flex: "1 1 auto",
                            width: "100%",
                        });
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Failed to load Kategori Utama.",
                });
            },
        });
    }

    function getDataKategori() {
        sppb_kategori
            .data("select2")
            .options.set("placeholder", "Loading Kategori...");
        sppb_kategori.empty().prop("disabled", true).trigger("change");
        return $.ajax({
            url: "/CreateSPPB/getKategori",
            method: "GET",
            data: {
                kategoriUtama: sppb_kategoriUtama.val(),
                _token: csrfToken,
            },
            dataType: "json",
            success: function (data) {
                if (!data) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        showConfirmButton: false,
                        timer: 1000,
                        text: "fetching data Kategori failed ",
                        returnFocus: false,
                    });
                } else {
                    data.forEach(function (item) {
                        sppb_kategori.append(
                            new Option(
                                item.nama_kategori.trim(),
                                item.no_kategori.trim()
                            )
                        );
                    });

                    sppb_kategori
                        .data("select2")
                        .options.set("placeholder", "Pilih Kategori");
                    sppb_kategori
                        .prop("disabled", false)
                        .val(null)
                        .trigger("change");

                    $("#sppb_kategori").each(function () {
                        $(this).next(".select2-container").css({
                            flex: "1 1 auto",
                            width: "100%",
                        });
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Failed to load Kategori.",
                });
            },
        });
    }

    function getDataSubKategori() {
        sppb_subKategori
            .data("select2")
            .options.set("placeholder", "Loading Sub Kategori...");
        sppb_subKategori.empty().prop("disabled", true).trigger("change");
        return $.ajax({
            url: "/CreateSPPB/getSubKategori",
            method: "GET",
            data: {
                kategori: sppb_kategori.val(),
                _token: csrfToken,
            },
            dataType: "json",
            success: function (data) {
                if (!data) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        showConfirmButton: false,
                        timer: 1000,
                        text: "fetching data Sub Kategori failed ",
                        returnFocus: false,
                    });
                } else {
                    data.forEach(function (item) {
                        sppb_subKategori.append(
                            new Option(
                                item.nama_sub_kategori.trim(),
                                item.no_sub_kategori.trim()
                            )
                        );
                    });

                    sppb_subKategori
                        .data("select2")
                        .options.set("placeholder", "Pilih Sub Kategori");
                    sppb_subKategori
                        .prop("disabled", false)
                        .val(null)
                        .trigger("change");

                    $("#sppb_subKategori").each(function () {
                        $(this).next(".select2-container").css({
                            flex: "1 1 auto",
                            width: "100%",
                        });
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Failed to load Sub Kategori.",
                });
            },
        });
    }

    function getDataNamaBarang() {
        sppb_namaBarang
            .data("select2")
            .options.set("placeholder", "Loading Nama Barang...");
        sppb_namaBarang.empty().prop("disabled", true).trigger("change");
        return $.ajax({
            url: "/CreateSPPB/getNamaBarang",
            method: "GET",
            data: {
                subKategori: sppb_subKategori.val(),
                _token: csrfToken,
            },
            dataType: "json",
            success: function (data) {
                if (!data) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        showConfirmButton: false,
                        timer: 1000,
                        text: "fetching data Nama Barang failed ",
                        returnFocus: false,
                    });
                } else {
                    data.forEach(function (item) {
                        sppb_namaBarang.append(
                            new Option(item.NAMA_BRG.trim(), item.KD_BRG.trim())
                        );
                    });

                    sppb_namaBarang
                        .data("select2")
                        .options.set("placeholder", "Pilih Nama Barang");
                    sppb_namaBarang
                        .prop("disabled", false)
                        .val(null)
                        .trigger("change");

                    $("#sppb_namaBarang").each(function () {
                        $(this).next(".select2-container").css({
                            flex: "1 1 auto",
                            width: "100%",
                        });
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Failed to load Nama Barang.",
                });
            },
        });
    }

    function getDataDetailBarang(jenisInput) {
        return $.ajax({
            url: "/CreateSPPB/getDetailBarang",
            method: "GET",
            data: {
                kodeBrg: sppb_kodeBarang.value,
                _token: csrfToken,
            },
            dataType: "json",
            success: function (data) {
                console.log(data);

                if (data.length < 1) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        showConfirmButton: false,
                        timer: 1000,
                        text: "fetching data Detail Barang failed ",
                        returnFocus: false,
                    });
                } else {
                    sppb_keteranganKhusus.value = data[0].KET_KHUSUS;
                    sppb_keteranganBarang.value = data[0].KET;
                    sppb_nomorSatuan.value = data[0].ST_TRI;
                    if (jenisInput == "manual") {
                        // mungkin akan ada tambahan
                    } else if (jenisInput == "auto") {
                        sppb_kategoriUtama
                            .val(data[0].no_kat_utama)
                            .trigger("change");
                        getDataKategori().then(function () {
                            sppb_kategori
                                .val(data[0].no_kategori)
                                .trigger("change");
                            getDataSubKategori().then(function () {
                                sppb_subKategori
                                    .val(data[0].no_sub_kategori)
                                    .trigger("change");
                                getDataNamaBarang().then(function () {
                                    sppb_namaBarang
                                        .val(sppb_kodeBarang.value)
                                        .trigger("change");
                                    let selectedOption =
                                        sppb_namaBarang.select2("data")[0];
                                    selectedKodeBarang = selectedOption.id; // Get selected Kode Barang
                                    selectedNamaBarang = selectedOption.text; // Get selected Nama Barang
                                });
                            });
                        });
                    }
                }
            },
            error: function () {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Failed to load Detail Barang.",
                });
            },
        });
    }

    function hitungHarga() {
        let hargaDisc = 0.0;
        if (!sppb_kursRupiah.value) {
            sppb_kursRupiah.value = 0;
        }
        if (!sppb_quantityBarang.value) {
            sppb_quantityBarang.value = 1;
        }
        if (!sppb_hargaSatuan.value) {
            sppb_hargaSatuan.value = 1;
        }
        if (!sppb_discount.value) {
            sppb_discount.value = 0;
        }
        if (!sppb_ppn.value) {
            sppb_ppn.value = 11;
        }
        sppb_subTotalHargaJual.value =
            numeral(sppb_hargaSatuan.value).value() *
            numeral(sppb_quantityBarang.value).value();
        hargaDisc =
            numeral(sppb_subTotalHargaJual.value).value() -
            (numeral(sppb_subTotalHargaJual.value).value() *
                numeral(sppb_discount.value).value()) /
                100;

        if (sppb_ppn.value == "12" && sppb_dppFull.checked) {
            sppb_DPPNilaiLain.value = (hargaDisc * 11) / 12;
        } else {
            sppb_DPPNilaiLain.value = hargaDisc;
        }

        sppb_hargaPPN.value =
            (numeral(sppb_DPPNilaiLain.value).value() *
                numeral(sppb_ppn.value).value()) /
            100;
        sppb_totalHarga.value =
            hargaDisc + numeral(sppb_hargaPPN.value).value();
    }
    //#endregion

    //#region Event Listener
    buttonTambahSPPB.addEventListener("click", function (e) {
        $("#sppb_buttonSave").data("id", null);
        $("#sppb_buttonSubmit").data("id", null);
    });

    $("#modalSPPB").on("shown.bs.modal", function (event) {
        let nomorSPPB = $("#sppb_buttonSubmit").data("id");
        if (nomorSPPB) {
            $.ajax({
                url: "/CreateSPPB/getDetailPO",
                method: "GET",
                data: {
                    _token: csrfToken,
                    no_sppb: nomorSPPB,
                },
                dataType: "json",
                success: function (data) {
                    if (!data) {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            showConfirmButton: false,
                            timer: 1000,
                            text: "fetching data Divisi failed ",
                            returnFocus: false,
                        });
                    } else {
                        sppb_tanggal.value = moment(data[0].Tgl_sppb).format("YYYY-MM-DD"); //prettier-ignore
                        sppb_tanggalDibutuhkan.value = moment(data[0].Tgl_Dibutuhkan).format("YYYY-MM-DD"); //prettier-ignore
                        sppb_divisi.val(data[0].Kd_div).trigger("change");
                        getDataGolongan().then;
                        init("resetOrder");
                        init("disableHeader");
                        sppb_jenisPembelian
                            .val(data[0].Jenis.trim())
                            .trigger("change");
                        sppb_supplier.val(data[0].No_sup).trigger("change");
                        sppb_pemesan.value = data[0].Pemesan;
                        sppb_mataUang.val(data[0].IdMataUang).trigger("change");
                        sppb_kursRupiah.value = numeral(
                            data[0].Kurs_Rp
                        ).value();
                        sppb_jangkaWaktu.value = numeral(data[0].Waktu).value();
                        sppb_jangkaWaktu.dispatchEvent(enterEvent);
                        data.forEach((orderPembelian) => {
                            let totalHarga =
                                numeral(orderPembelian.hrg_murni).value() +
                                numeral(orderPembelian.hrg_ppn).value();
                            sppb_tableOrderPembelian.row
                                .add([
                                    orderPembelian.NAMA_BRG,
                                    orderPembelian.Kd_brg,
                                    numeral(orderPembelian.Qty).format(
                                        "0,0.00"
                                    ),
                                    orderPembelian.keterangan,
                                    numeral(orderPembelian.Hrg_trm).format(
                                        "0,0.00"
                                    ),
                                    numeral(orderPembelian.Disc_trm).format(
                                        "0.00"
                                    ),
                                    numeral(orderPembelian.Ppn_trm).format(
                                        "0.00"
                                    ),
                                    numeral(
                                        orderPembelian.dpp_nilai_lain
                                    ).format("0,0.00"),
                                    numeral(orderPembelian.hrg_ppn).format(
                                        "0,0.00"
                                    ),
                                    numeral(orderPembelian.hrg_murni).format(
                                        "0,0.00"
                                    ),
                                    numeral(totalHarga).format("0,0.00"),
                                    orderPembelian.No_trans,
                                    orderPembelian.No_gol,
                                    orderPembelian.No_msn,
                                ])
                                .draw();
                        });
                        sppb_deliveryTerm.value = "";
                        sppb_packing.value = "";
                        sppb_shippingMark.value = "";
                        sppb_deliveryTime.value = "";
                        sppb_documentsRequired.value = "";
                        sppb_partialShipmentTransit.value = "";
                        sppb_portOfLoading.value = "";
                        sppb_portOfDischarge.value = "";
                        sppb_otherConditions.value = "";
                        sppb_payments.value = "";
                        if (data[0].Informasi_Cetak) {
                            let deliveryTerm = data[0].Informasi_Cetak.split(" | ")[0]; //prettier-ignore
                            let packing = data[0].Informasi_Cetak.split(" | ")[1]; //prettier-ignore
                            let shippingMark = data[0].Informasi_Cetak.split(" | ")[2]; //prettier-ignore
                            let deliveryTime = data[0].Informasi_Cetak.split(" | ")[3]; //prettier-ignore
                            let documentsRequired = data[0].Informasi_Cetak.split(" | ")[4]; //prettier-ignore
                            let partialShipmentTransit = data[0].Informasi_Cetak.split(" | ")[5]; //prettier-ignore
                            let portOfLoading = data[0].Informasi_Cetak.split(" | ")[6]; //prettier-ignore
                            let portOfDischarge = data[0].Informasi_Cetak.split(" | ")[7]; //prettier-ignore
                            let otherConditions = data[0].Informasi_Cetak.split(" | ")[8]; //prettier-ignore
                            let payment = data[0].Informasi_Cetak.split(" | ")[9]; //prettier-ignore
                            sppb_deliveryTerm.value = deliveryTerm;
                            sppb_packing.value = packing;
                            sppb_shippingMark.value = shippingMark;
                            sppb_deliveryTime.value = deliveryTime;
                            sppb_documentsRequired.value = documentsRequired;
                            sppb_partialShipmentTransit.value = partialShipmentTransit; //prettier-ignore
                            sppb_portOfLoading.value = portOfLoading;
                            sppb_portOfDischarge.value = portOfDischarge;
                            sppb_otherConditions.value = otherConditions;
                            sppb_payments.value = payment;
                        }
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Failed to load Divisi.",
                    });
                },
            });
        } else {
            sppb_tanggal.focus();
            init("modal");
            sppb_tableOrderPembelian.clear().draw();
        }
    });

    sppb_tanggal.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            sppb_tanggalDibutuhkan.focus();
        }
    });

    sppb_tanggalDibutuhkan.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            sppb_divisi.select2("open");
        }
    });

    sppb_divisi.on("select2:select", function () {
        selectedDivisi = $(this).val(); // Get selected Divisi
        sppb_kelompok.empty().prop("disabled", true).trigger("change");
        getDataGolongan().then(function () {
            sppb_jenisPembelian.select2("open");
        });
    });

    sppb_jenisPembelian.on("select2:select", function () {
        selectedJenisPembelian = $(this).val(); // Get selected Jenis Pembelian
        sppb_supplier.select2("open");
    });

    sppb_supplier.on("select2:select", function () {
        selectedSupplier = $(this).val(); // Get selected Supplier
        sppb_pemesan.select();
    });

    sppb_pemesan.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            sppb_mataUang.select2("open");
        }
    });

    sppb_mataUang.on("select2:select", function () {
        selectedMataUang = $(this).val(); // Get selected Mata Uang
        if (selectedMataUang == 1) {
            sppb_kursRupiah.value = 1;
            sppb_jangkaWaktu.select();
        } else {
            sppb_kursRupiah.value = 0;
            sppb_kursRupiah.select();
        }
    });

    sppb_kursRupiah.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            sppb_jangkaWaktu.focus();
            hitungHarga();
        }
    });

    sppb_jangkaWaktu.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            if (sppb_jangkaWaktu.value > 0) {
                sppb_pembayaran.value = "KREDIT";
            } else {
                sppb_pembayaran.value = "TUNAI";
            }
            sppb_golongan.select2("open");
        }
    });

    sppb_golongan.on("select2:select", function () {
        selectedGolongan = $(this).val(); // Get selected Golongan
        getDataKelompokMesin().then(function () {
            sppb_kelompok.select2("open");
        });
    });

    sppb_kelompok.on("select2:select", function () {
        selectedKelompok = $(this).val(); // Get selected Kelompok
        sppb_kategoriUtama.select2("open");
    });

    sppb_kategoriUtama.on("select2:select", function () {
        selectedKategoriUtama = $(this).val(); // Get selected Kategori Utama
        sppb_subKategori.empty().prop("disabled", true).trigger("change");
        sppb_namaBarang.empty().prop("disabled", true).trigger("change");
        sppb_kodeBarang.value = "";
        sppb_keteranganKhusus.value = "";
        sppb_keteranganBarang.value = "";
        getDataKategori().then(function () {
            sppb_kategori.select2("open");
        });
    });

    sppb_kategori.on("select2:select", function () {
        selectedKategori = $(this).val(); // Get selected Kategori
        sppb_namaBarang.empty().prop("disabled", true).trigger("change");
        sppb_kodeBarang.value = "";
        sppb_keteranganKhusus.value = "";
        sppb_keteranganBarang.value = "";
        getDataSubKategori().then(function () {
            sppb_subKategori.select2("open");
        });
    });

    sppb_subKategori.on("select2:select", function () {
        selectedSubKategori = $(this).val(); // Get selected Sub Kategori
        sppb_kodeBarang.value = "";
        sppb_keteranganKhusus.value = "";
        sppb_keteranganBarang.value = "";
        getDataNamaBarang().then(function () {
            sppb_namaBarang.select2("open");
        });
    });

    sppb_namaBarang.on("select2:select", function () {
        let selectedOption = sppb_namaBarang.select2("data")[0];
        selectedKodeBarang = selectedOption.id; // Get selected Kode Barang
        selectedNamaBarang = selectedOption.text; // Get selected Nama Barang
        sppb_kodeBarang.value = sppb_namaBarang.val();
        getDataDetailBarang("manual").then(function () {
            sppb_quantityBarang.select();
        });
    });

    sppb_kodeBarang.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();

            let val = sppb_kodeBarang.value.trim();

            // 1️⃣ Check digits only
            if (!/^\d+$/.test(val)) {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Kode Barang harus berupa angka",
                    timer: 1500,
                    showConfirmButton: false,
                });
                sppb_kodeBarang.focus();
                return;
            }

            // 2️⃣ str_pad left with 0 (example: length 6)
            val = val.padStart(9, "0");
            sppb_kodeBarang.value = val;

            getDataDetailBarang("auto").then(function () {
                sppb_quantityBarang.select();
            });
        }
    });

    sppb_quantityBarang.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            sppb_KeteranganOrder.focus();
            hitungHarga();
        }
    });

    sppb_KeteranganOrder.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            sppb_hargaSatuan.focus();
        }
    });

    sppb_hargaSatuan.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            sppb_discount.focus();
            hitungHarga();
        }
    });

    sppb_discount.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            sppb_ppn.focus();
            hitungHarga();
        }
    });

    sppb_ppn.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            if (sppb_ppn.value == "12") {
                sppb_divDppFull.style.display = "block";
                sppb_dppFull.checked = true;
                sppb_dppFull.focus();
            } else {
                sppb_divDppFull.style.display = "none";
                sppb_dppFull.checked = false;
                if (selectedRowData) {
                    sppb_buttonUpdate.focus();
                } else {
                    sppb_buttonAdd.focus();
                }
            }
            hitungHarga();
        }
    });

    sppb_dppFull.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            if (selectedRowData) {
                sppb_buttonUpdate.focus();
            } else {
                sppb_buttonAdd.focus();
            }
            hitungHarga();
        }
    });

    sppb_deliveryTerm.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            sppb_packing.focus();
        }
    });
    sppb_packing.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            sppb_shippingMark.focus();
        }
    });
    sppb_shippingMark.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            sppb_deliveryTime.focus();
        }
    });
    sppb_deliveryTime.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            sppb_documentsRequired.focus();
        }
    });
    sppb_documentsRequired.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            sppb_partialShipmentTransit.focus();
        }
    });
    sppb_partialShipmentTransit.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            sppb_portOfLoading.focus();
        }
    });
    sppb_portOfLoading.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            sppb_portOfDischarge.focus();
        }
    });
    sppb_portOfDischarge.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            sppb_otherConditions.focus();
        }
    });
    sppb_otherConditions.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            sppb_payments.focus();
        }
    });
    sppb_payments.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            sppb_buttonSave.focus();
        }
    });

    $("#sppb_tableOrderPembelian tbody").on("click", "tr", function () {
        // Get data from the clicked row
        selectedRowData = sppb_tableOrderPembelian.row(this).data();
        if (!selectedRowData) {
            return;
        }

        // Remove the 'selected' class from any previously selected row
        $("#sppb_tableOrderPembelian tbody tr").removeClass("selected");

        // Add the 'selected' class to the clicked row
        $(this).addClass("selected");
        console.log(selectedRowData);

        sppb_kodeBarang.value = selectedRowData[1];
        sppb_quantityBarang.value = numeral(selectedRowData[2]).value();
        sppb_KeteranganOrder.value = selectedRowData[3];
        sppb_hargaSatuan.value = numeral(selectedRowData[4]).value();
        sppb_discount.value = numeral(selectedRowData[5]).value();
        sppb_ppn.value = numeral(selectedRowData[6]).value();
        sppb_DPPNilaiLain.value = numeral(selectedRowData[7]).value();
        sppb_hargaPPN.value = numeral(selectedRowData[8]).value();
        sppb_subTotalHargaJual.value = numeral(selectedRowData[9]).value();
        sppb_totalHarga.value = numeral(selectedRowData[10]).value();
        sppb_golongan.val(selectedRowData[12]).trigger("change");
        getDataKelompokMesin().then(function () {
            sppb_kelompok.val(selectedRowData[13]).trigger("change");
        });
        selectedGolongan = selectedRowData[12];
        selectedKelompok = selectedRowData[13];
        getDataDetailBarang("auto");
        sppb_buttonAdd.disabled = true;
    });

    sppb_buttonAdd.addEventListener("click", function (e) {
        if (!sppb_kelompok.val()) {
            Swal.fire({
                icon: "error",
                title: "Error",
                showConfirmButton: false,
                timer: 1000,
                text: "Kelompok harus dipilih",
                returnFocus: false,
            });
            return;
        }
        if (!sppb_kodeBarang.value) {
            Swal.fire({
                icon: "error",
                title: "Error",
                showConfirmButton: false,
                timer: 1000,
                text: "Barang harus dipilih",
                returnFocus: false,
            });
            return;
        }
        if (!sppb_totalHarga.value || sppb_totalHarga.value < 1) {
            Swal.fire({
                icon: "error",
                title: "Error",
                showConfirmButton: false,
                timer: 1000,
                text: "Harga harus diisi",
                returnFocus: false,
            });
            return;
        }
        let duplicateData = sppb_tableOrderPembelian.rows(function (idx, data) {
            return data[1] == selectedKodeBarang;
        });
        console.log(duplicateData);

        if (duplicateData.count() > 0) {
            Swal.fire({
                icon: "error",
                title: "Error",
                showConfirmButton: false,
                timer: 1000,
                text:
                    "Kode Barang " +
                    selectedKodeBarang +
                    " sudah pernah diinput",
                returnFocus: false,
            });
            return;
        }

        let hargaMurni =
            numeral(sppb_hargaSatuan.value).value() *
            numeral(sppb_quantityBarang.value).value();
        let hargaMurniRupiah =
            hargaMurni * numeral(sppb_kursRupiah.value).value();
        let hargaDisc =
            hargaMurni -
            (hargaMurni * numeral(sppb_discount.value).value()) / 100;
        let hargaDiscRupiah =
            hargaDisc * numeral(sppb_kursRupiah.value).value();
        let hargaNego = hargaMurni - hargaDisc;
        let hargaNegoRupiah = hargaMurniRupiah - hargaDiscRupiah;
        let hargaPPN = (hargaNego * numeral(sppb_ppn.value).value()) / 100;
        let hargaPPNRupiah = hargaPPN * numeral(sppb_kursRupiah.value).value();
        let dppNilaiLain = numeral(sppb_DPPNilaiLain.value).value();
        let dppNilaiLainRupiah =
            dppNilaiLain * numeral(sppb_kursRupiah.value).value();
        $.ajax({
            url: "/CreateSPPB",
            method: "POST",
            data: {
                _token: csrfToken,
                jenisStore: "addOrderPembelian",
                Kd_div: sppb_divisi.val(),
                Kd_brg: sppb_kodeBarang.value,
                keterangan: sppb_KeteranganOrder.value,
                Qty: sppb_quantityBarang.value,
                NoSatuan: sppb_nomorSatuan.value,
                Pemesan: sppb_pemesan.value,
                No_gol: sppb_golongan.val(),
                No_msn: sppb_kelompok.val(),
                Operator: idUser.value,
                Jenis: sppb_jenisPembelian.val(),
                Tgl_sppb: sppb_tanggal.value,
                Tgl_Dibutuhkan: sppb_tanggalDibutuhkan.value,
                No_sup: sppb_supplier.val(),
                IdMataUang: sppb_mataUang.val(),
                Kurs_Rp: sppb_kursRupiah.value,
                Hrg_trm: sppb_hargaSatuan.value,
                Disc_trm: sppb_discount.value,
                Ppn_trm: sppb_ppn.value,
                Waktu: sppb_jangkaWaktu.value,
                hrg_murni: hargaMurni,
                hrg_murni_rp: hargaMurniRupiah,
                hrg_disc: hargaDisc,
                hrg_disc_rp: hargaDiscRupiah,
                hrg_nego: hargaNego,
                hrg_nego_rp: hargaNegoRupiah,
                hrg_ppn: hargaPPN,
                kurs_ppn: sppb_kursRupiah.value,
                hrg_ppn_rp: hargaPPNRupiah,
                dpp_nilai_lain: dppNilaiLain,
                dpp_nilai_lain_rp: dppNilaiLainRupiah,
            },
            dataType: "json",
            success: function (response) {
                if (!response) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        showConfirmButton: false,
                        timer: 1000,
                        text: "fetching data Nomor Order failed ",
                        returnFocus: false,
                    });
                } else {
                    console.log(response);
                    console.log(selectedNamaBarang, selectedKodeBarang);

                    sppb_tableOrderPembelian.row
                        .add([
                            selectedNamaBarang,
                            selectedKodeBarang,
                            numeral(sppb_quantityBarang.value).format("0,0.00"),
                            sppb_KeteranganOrder.value,
                            numeral(sppb_hargaSatuan.value).format("0,0.00"),
                            numeral(sppb_discount.value).format("0.00"),
                            numeral(sppb_ppn.value).format("0.00"),
                            numeral(sppb_DPPNilaiLain.value).format("0,0.00"),
                            numeral(sppb_hargaPPN.value).format("0,0.00"),
                            numeral(sppb_subTotalHargaJual.value).format(
                                "0,0.00"
                            ),
                            numeral(sppb_totalHarga.value).format("0,0.00"),
                            response.data,
                            selectedGolongan,
                            selectedKelompok,
                        ])
                        .draw();

                    init("disableHeader");
                    init("resetOrder");
                }
            },
            error: function () {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Failed to load Nomor Order.",
                });
            },
        });
    });

    sppb_buttonUpdate.addEventListener("click", function (e) {
        if (!selectedRowData) {
            Swal.fire({
                icon: "error",
                title: "Error",
                showConfirmButton: false,
                timer: 1000,
                text: "Pilih data yang ingin diedit pada tabel ",
                returnFocus: false,
            });
        }
        if (!sppb_kelompok.val()) {
            Swal.fire({
                icon: "error",
                title: "Error",
                showConfirmButton: false,
                timer: 1000,
                text: "Kelompok harus dipilih",
                returnFocus: false,
            });
            return;
        }
        if (!sppb_kodeBarang.value) {
            Swal.fire({
                icon: "error",
                title: "Error",
                showConfirmButton: false,
                timer: 1000,
                text: "Barang harus dipilih",
                returnFocus: false,
            });
            return;
        }
        if (!sppb_totalHarga.value || sppb_totalHarga.value < 1) {
            Swal.fire({
                icon: "error",
                title: "Error",
                showConfirmButton: false,
                timer: 1000,
                text: "Harga harus diisi",
                returnFocus: false,
            });
            return;
        }
        let hargaMurni =
            numeral(sppb_hargaSatuan.value).value() *
            numeral(sppb_quantityBarang.value).value();
        let hargaMurniRupiah =
            hargaMurni * numeral(sppb_kursRupiah.value).value();
        let hargaDisc =
            hargaMurni -
            (hargaMurni * numeral(sppb_discount.value).value()) / 100;
        let hargaDiscRupiah =
            hargaDisc * numeral(sppb_kursRupiah.value).value();
        let hargaNego = hargaMurni - hargaDisc;
        let hargaNegoRupiah = hargaMurniRupiah - hargaDiscRupiah;
        let hargaPPN = (hargaNego * numeral(sppb_ppn.value).value()) / 100;
        let hargaPPNRupiah = hargaPPN * numeral(sppb_kursRupiah.value).value();
        let dppNilaiLain = numeral(sppb_DPPNilaiLain.value).value();
        let dppNilaiLainRupiah =
            dppNilaiLain * numeral(sppb_kursRupiah.value).value();
        $.ajax({
            url: "/CreateSPPB",
            method: "POST",
            data: {
                _token: csrfToken,
                jenisStore: "editOrderPembelian",
                No_trans: selectedRowData[11],
                Kd_div: sppb_divisi.val(),
                Kd_brg: sppb_kodeBarang.value,
                keterangan: sppb_KeteranganOrder.value,
                Qty: sppb_quantityBarang.value,
                NoSatuan: sppb_nomorSatuan.value,
                Pemesan: sppb_pemesan.value,
                No_gol: sppb_golongan.val(),
                No_msn: sppb_kelompok.val(),
                Operator: idUser.value,
                Jenis: sppb_jenisPembelian.val(),
                Tgl_sppb: sppb_tanggal.value,
                Tgl_Dibutuhkan: sppb_tanggalDibutuhkan.value,
                No_sup: sppb_supplier.val(),
                IdMataUang: sppb_mataUang.val(),
                Kurs_Rp: sppb_kursRupiah.value,
                Hrg_trm: sppb_hargaSatuan.value,
                Disc_trm: sppb_discount.value,
                Ppn_trm: sppb_ppn.value,
                Waktu: sppb_jangkaWaktu.value,
                hrg_murni: hargaMurni,
                hrg_murni_rp: hargaMurniRupiah,
                hrg_disc: hargaDisc,
                hrg_disc_rp: hargaDiscRupiah,
                hrg_nego: hargaNego,
                hrg_nego_rp: hargaNegoRupiah,
                hrg_ppn: hargaPPN,
                kurs_ppn: sppb_kursRupiah.value,
                hrg_ppn_rp: hargaPPNRupiah,
                dpp_nilai_lain: dppNilaiLain,
                dpp_nilai_lain_rp: dppNilaiLainRupiah,
            },
            dataType: "json",
            success: function (response) {
                if (!response) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        showConfirmButton: false,
                        timer: 1000,
                        text: "fetching data Nomor Order failed ",
                        returnFocus: false,
                    });
                } else {
                    console.log(response);
                    sppb_tableOrderPembelian
                        .rows(function (idx, data) {
                            return data[11] == selectedRowData[11];
                        })
                        .every(function () {
                            this.data([
                                selectedNamaBarang,
                                selectedKodeBarang,
                                numeral(sppb_quantityBarang.value).format(
                                    "0,0.00"
                                ),
                                sppb_KeteranganOrder.value,
                                numeral(sppb_hargaSatuan.value).format(
                                    "0,0.00"
                                ),
                                numeral(sppb_discount.value).format("0.00"),
                                numeral(sppb_ppn.value).format("0.00"),
                                numeral(sppb_DPPNilaiLain.value).format(
                                    "0,0.00"
                                ),
                                numeral(sppb_hargaPPN.value).format("0,0.00"),
                                numeral(sppb_subTotalHargaJual.value).format(
                                    "0,0.00"
                                ),
                                numeral(sppb_totalHarga.value).format("0,0.00"),
                                response.data,
                                selectedGolongan,
                                selectedKelompok,
                            ]);
                        })
                        .draw();
                    selectedRowData = null;

                    init("disableHeader");
                    init("resetOrder");
                }
            },
            error: function () {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Failed to load Nomor Order.",
                });
            },
        });
    });

    sppb_buttonDelete.addEventListener("click", function (e) {
        if (!selectedRowData) {
            Swal.fire({
                icon: "error",
                title: "Error",
                showConfirmButton: false,
                timer: 1000,
                text: "Pilih data yang ingin dihapus pada tabel ",
                returnFocus: false,
            });
        }
        $.ajax({
            url: "/CreateSPPB",
            method: "POST",
            data: {
                _token: csrfToken,
                jenisStore: "deleteOrderPembelian",
                No_trans: selectedRowData[11],
            },
            dataType: "json",
            success: function (response) {
                if (!response) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        showConfirmButton: false,
                        timer: 1000,
                        text: "Delete Order Pembelian failed ",
                        returnFocus: false,
                    });
                } else {
                    console.log(response);
                    Swal.fire({
                        icon: "success",
                        title: "Error",
                        showConfirmButton: false,
                        timer: 1000,
                        text: response.message,
                        returnFocus: false,
                    });
                    sppb_tableOrderPembelian
                        .rows(function (idx, data, node) {
                            return data[11] === selectedRowData[11];
                        })
                        .remove()
                        .draw();
                    selectedRowData = null;
                    init("resetOrder");
                }
            },
            error: function () {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Failed to Delete Order Pembelian.",
                });
            },
        });
    });

    sppb_buttonSave.addEventListener("click", function (e) {
        let nomorSPPB = $(this).data("id");
        let keteranganCetak =
            sppb_deliveryTerm.value +
            " | " +
            sppb_packing.value +
            " | " +
            sppb_shippingMark.value +
            " | " +
            sppb_deliveryTime.value +
            " | " +
            sppb_documentsRequired.value +
            " | " +
            sppb_partialShipmentTransit.value +
            " | " +
            sppb_portOfLoading.value +
            " | " +
            sppb_portOfDischarge.value +
            " | " +
            sppb_otherConditions.value +
            " | " +
            sppb_payments.value;
        $.ajax({
            url: "/CreateSPPB",
            method: "POST",
            data: {
                _token: csrfToken,
                jenisStore: "savePO",
                table_orderPembelian: sppb_tableOrderPembelian
                    .rows()
                    .data()
                    .toArray(),
                idDivisi: sppb_divisi.val(),
                Tgl_sppb: sppb_tanggal.value,
                No_sppb: nomorSPPB,
                keteranganCetak: keteranganCetak,
            },
            dataType: "json",
            success: function (response) {
                if (!response) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        showConfirmButton: false,
                        timer: 1000,
                        text: "Save PO failed ",
                        returnFocus: false,
                    });
                } else {
                    console.log(response);
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        showConfirmButton: false,
                        timer: 1000,
                        text: response.message,
                        returnFocus: false,
                    });
                    selectedRowData = null;
                    table_sppb.ajax.reload(function () {
                        table_sppb.columns.adjust().draw(false);
                    }, false);
                    $("#modalSPPB").modal("hide");
                }
            },
            error: function () {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Failed to Save PO.",
                });
            },
        });
    });

    sppb_buttonSubmit.addEventListener("click", function (e) {
        let nomorSPPB = $(this).data("id");
        let keteranganCetak =
            sppb_deliveryTerm.value +
            " | " +
            sppb_packing.value +
            " | " +
            sppb_shippingMark.value +
            " | " +
            sppb_deliveryTime.value +
            " | " +
            sppb_documentsRequired.value +
            " | " +
            sppb_partialShipmentTransit.value +
            " | " +
            sppb_portOfLoading.value +
            " | " +
            sppb_portOfDischarge.value +
            " | " +
            sppb_otherConditions.value +
            " | " +
            sppb_payments.value;
        $.ajax({
            url: "/CreateSPPB",
            method: "POST",
            data: {
                _token: csrfToken,
                jenisStore: "sumbitPO",
                table_orderPembelian: sppb_tableOrderPembelian
                    .rows()
                    .data()
                    .toArray(),
                idDivisi: sppb_divisi.val(),
                No_sppb: nomorSPPB,
                keteranganCetak: keteranganCetak,
            },
            dataType: "json",
            success: function (response) {
                if (!response) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        showConfirmButton: false,
                        timer: 1000,
                        text: "Save PO failed ",
                        returnFocus: false,
                    });
                } else {
                    console.log(response);
                    Swal.fire({
                        icon: "success",
                        title: "Error",
                        showConfirmButton: false,
                        timer: 1000,
                        text: response.message,
                        returnFocus: false,
                    });
                    selectedRowData = null;
                    table_sppb.ajax.reload();
                    $("#modalSPPB").modal("hide");
                }
            },
            error: function () {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Failed to Save PO.",
                });
            },
        });
    });

    $(document).on("click", ".btn-print", function (e) {
        let nomorSPPB = $(this).data("id");
        let urlEncodedNomorSPPB = encodeURIComponent(nomorSPPB);
        let kdDiv = $(this).data("div");

        window.open(
            `/CetakSPPBBTTB/print?divisi=` +
                kdDiv +
                `&jenisCetak=SPPBBaru&sppb=` +
                urlEncodedNomorSPPB +
                `&noTerima=`,
            "_blank"
        );
    });

    $(document).on("click", ".btn-acc", function (e) {
        let nomorSPPB = $(this).data("id");

        $.ajax({
            url: "/CreateSPPB",
            method: "POST",
            data: {
                _token: csrfToken,
                jenisStore: "accPO",
                nomorSPPB: nomorSPPB,
            },
            dataType: "json",
            success: function (response) {
                if (!response) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        showConfirmButton: false,
                        timer: 1000,
                        text: "ACC PO failed ",
                        returnFocus: false,
                    });
                } else {
                    console.log(response);
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        showConfirmButton: false,
                        timer: 1000,
                        text: response.message,
                        returnFocus: false,
                    });
                    table_sppb.ajax.reload(function () {
                        table_sppb.columns.adjust().draw(false);
                    }, false);
                }
            },
            error: function () {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Failed to ACC PO.",
                });
            },
        });
    });

    $(document).on("click", ".btn-edit", function (e) {
        let nomorSPPB = $(this).data("id");
        $("#sppb_buttonSave").data("id", nomorSPPB);
        $("#sppb_buttonSubmit").data("id", nomorSPPB);
        sppb_tableOrderPembelian.clear().draw();
    });

    $(document).on("click", ".btn-hapus", function (e) {
        let nomorSPPB = $(this).data("id");
        $.ajax({
            url: "/CreateSPPB",
            method: "POST",
            data: {
                _token: csrfToken,
                jenisStore: "deletePO",
                nomorSPPB: nomorSPPB,
            },
            dataType: "json",
            success: function (response) {
                if (!response) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        showConfirmButton: false,
                        timer: 1000,
                        text: "Delete PO failed ",
                        returnFocus: false,
                    });
                } else {
                    console.log(response);
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        showConfirmButton: false,
                        timer: 1000,
                        text: response.message,
                        returnFocus: false,
                    });
                    table_sppb.ajax.reload(function () {
                        table_sppb.columns.adjust().draw(false);
                    }, false);
                }
            },
            error: function () {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Failed to Delete PO.",
                });
            },
        });
    });
    //#endregion
});
