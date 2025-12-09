jQuery(function ($) {
    //#region Variable
    let detailTable = null;
    let mode = "";
    let tgl_sppb = document.getElementById("tgl_sppb");
    let tgl_datang = document.getElementById("tgl_datang");
    let no_trans = document.getElementById("no_trans");
    let kd_brg = document.getElementById("kd_brg");
    let nama_brg = document.getElementById("nama_brg");
    let ket_brg = document.getElementById("ket_brg");
    let kat_utama = document.getElementById("kat_utama");
    let kategori = document.getElementById("kategori");
    let sub_kategori = document.getElementById("sub_kategori");
    let ket_pembelian = document.getElementById("ket_pembelian");
    let satuan = document.getElementById("satuan");
    let qty = document.getElementById("qty");
    let mata_uang = document.getElementById("mata_uang");
    let hrg_murni = document.getElementById("hrg_murni");
    let kurs = document.getElementById("kurs");
    let disc = document.getElementById("disc");
    let ppn = document.getElementById("ppn");
    let dpp_nilai_lain = document.getElementById("dpp_nilai_lain");
    let harga_ppn = document.getElementById("harga_ppn");
    let subtotal_harga_jual = document.getElementById("subtotal_harga_jual");
    let jangka_waktu = document.getElementById("jangka_waktu");
    let total_harga = document.getElementById("total_harga");
    let pembayaran = document.getElementById("pembayaran");
    let supplier = document.getElementById("supplier");
    let jenis_pembelian = document.getElementById("jenis_pembelian");
    let alasan_hapus = document.getElementById("alasan_hapus");
    let no_sppb = document.getElementById("no_sppb");

    //#endregion

    //#region Load Form

    //#endregion

    //#region Function

    //#region

    //#region Event Listener

    //#endregion

    // --- UTILITAS CLEAR FORM + TABLE ---
    function clearDetailSppb() {
        tgl_sppb.value = "";
        tgl_datang.value = "";
        no_trans.value = "";
        kd_brg.value = "";
        nama_brg.value = "";
        ket_brg.value = "";
        kat_utama.value = "";
        kategori.value = "";
        sub_kategori.value = "";
        ket_pembelian.value = "";
        satuan.value = "";
        qty.value = "";
        mata_uang.value = "";
        hrg_murni.value = "";
        kurs.value = "0";
        disc.value = "";
        ppn.value = "";
        dpp_nilai_lain.value = "";
        harga_ppn.value = "";
        subtotal_harga_jual.value = "";
        jangka_waktu.value = "";
        total_harga.value = "";
        pembayaran.value = "";

        if (supplier) {
            supplier.value = "";
            supplier.disabled = false;
        }

        if (jenis_pembelian) jenis_pembelian.value = "";

        if (alasan_hapus) alasan_hapus.value = "";

        if (no_sppb) {
            if (mode === "") {
                no_sppb.innerHTML =
                    '<option value="">-- Pilih No SPPB --</option>';
            }
        }

        if (detailTable) detailTable.clear().draw();
    }

    /* =========================================================
           MODE ISI  → semua transaksi per divisi (MyType = 1)
           ========================================================= */
    function loadDataByDivisiIsi() {
        const kdDiv = document.getElementById("kd_div").value;

        if (!kdDiv || mode !== "ISI") {
            if (detailTable) detailTable.clear().draw();
            return;
        }

        fetch(
            "{{ route('purchaseorder.detail_sppb') }}" +
                "?kd_div=" +
                encodeURIComponent(kdDiv) +
                "&no_sppb="
        )
            .then((res) => res.json())
            .then((data) => {
                if (!detailTable) return;

                detailTable.clear();

                if (Array.isArray(data) && data.length > 0) {
                    data.forEach((item) => {
                        // *** PENTING: mapping langsung ke kolom YTRANSBL ***
                        const checkboxHtml = `
                        <input type="checkbox"
                            class="row-select-isi"

                            data-no-trans="${item.No_trans ?? ""}"
                            data-kd-brg="${item.Kd_brg ?? ""}"
                            data-nama-brg="${(item.NAMA_BRG ?? "").replace(
                                /"/g,
                                "&quot;"
                            )}"
                            data-ket-brg="${(item.KET ?? "").replace(
                                /"/g,
                                "&quot;"
                            )}"
                            data-kat-utama="${(item.nama ?? "").replace(
                                /"/g,
                                "&quot;"
                            )}"
                            data-kategori="${(item.nama_kategori ?? "").replace(
                                /"/g,
                                "&quot;"
                            )}"
                            data-sub-kategori="${(
                                item.nama_sub_kategori ?? ""
                            ).replace(/"/g, "&quot;")}"
                            data-ket-pembelian="${(
                                item.keterangan ?? ""
                            ).replace(/"/g, "&quot;")}"
                            data-satuan="${(item.Nama_satuan ?? "").replace(
                                /"/g,
                                "&quot;"
                            )}"
                            data-qty="${item.Qty ?? ""}"

                            data-tgl-sppb="${
                                item.Tgl_sppb ? item.Tgl_sppb.substr(0, 10) : ""
                            }"
                            data-no-sppb="${item.No_sppb ?? ""}"
                            data-tgl-datang="${
                                item.Tgl_dtg ? item.Tgl_dtg.substr(0, 10) : ""
                            }"

                            data-id-mata-uang="${
                                item.IdMataUang ?? item.Id_MataUang ?? ""
                            }"
                            data-kurs="${item.Kurs_Rp ?? item.kurs_ppn ?? 0}"

                            data-hrg-murni="${
                                item.hrg_murni ??
                                item.Hrg_trm ??
                                item.PriceUnit ??
                                0
                            }"

                            data-disc="${
                                item.Disc_trm ?? item.hrg_disc ?? item.Disc ?? 0
                            }"

                            data-ppn="${
                                item.Ppn_trm ?? item.hrg_ppn ?? item.PPN ?? 0
                            }"

                            data-dpp-nilai-lain="${
                                item.dpp_nilai_lain ?? item.DppNilaiLain ?? 0
                            }"

                            data-harga-ppn="${
                                item.hrg_ppn ?? item.HargaPpn ?? 0
                            }"

                            data-subtotal-harga="${
                                item.hrg_nego ?? item.SubTotalHargaJual ?? 0
                            }"

                            data-total-harga="${
                                item.hrg_nego_rp ?? item.TotalHarga ?? 0
                            }"

                            data-waktu="${item.Waktu ?? 0}"

                            data-no-sup="${
                                item.No_sup ?? item.IdSup ?? item.Supplier ?? ""
                            }"
                            data-pembayaran="${
                                item.Pembayaran ?? item.PersetujuanBayar ?? ""
                            }"
                        />
                    `;

                        const show = (field) => {
                            if (
                                !Object.prototype.hasOwnProperty.call(
                                    item,
                                    field
                                )
                            )
                                return "";
                            const val = item[field];
                            return val === null || val === "" ? "-" : val;
                        };

                        detailTable.row.add([
                            checkboxHtml,
                            item.Tgl_order ? item.Tgl_order.substr(0, 10) : "",
                            show("Qty"),
                            show("Pemesan"),
                            show("NM_MSN"),
                            show("NM_GOL"),
                            show("No_trans"),
                            item.Tgl_dtg ? item.Tgl_dtg.substr(0, 10) : "",
                            show("Retur"),
                            show("Direktur"),
                            item.hrg_murni ??
                                item.Hrg_trm ??
                                item.PriceUnit ??
                                0,
                            item.Disc_trm ?? item.hrg_disc ?? item.Disc ?? 0,
                            item.dpp_nilai_lain ?? item.DppNilaiLain ?? 0,
                            item.Ppn_trm ?? item.hrg_ppn ?? item.PPN ?? 0,
                            item.hrg_nego_rp ?? item.TotalHarga ?? 0,
                        ]);
                    });
                }

                detailTable.draw();
            })
            .catch((err) => {
                console.error("Error load data by divisi (ISI):", err);
            });
    }

    /* =========================================================
           MODE LIHAT  → detail 1 SPPB (MyType = 2)
           ========================================================= */
    function loadDetailSppbSingle() {
        const kdDiv = document.getElementById("kd_div").value;
        const noSppb = document.getElementById("no_sppb").value.trim();

        if (!kdDiv) {
            alert("Silakan pilih Nama Divisi terlebih dahulu.");
            return;
        }
        if (!noSppb) {
            alert("Silakan pilih No SPPB.");
            return;
        }

        fetch(
            "{{ route('purchaseorder.detail_sppb') }}" +
                "?kd_div=" +
                encodeURIComponent(kdDiv) +
                "&no_sppb=" +
                encodeURIComponent(noSppb)
        )
            .then((res) => res.json())
            .then((data) => {
                clearDetailSppb();

                if (!Array.isArray(data) || data.length === 0) {
                    alert("Data SPPB tidak tersedia.");
                    return;
                }

                const row = data[0];

                document.getElementById("tgl_sppb").value = row.Tgl_sppb
                    ? row.Tgl_sppb.substr(0, 10)
                    : "";

                document.getElementById("tgl_datang").value = row.Tgl_dtg
                    ? row.Tgl_dtg.substr(0, 10)
                    : "";

                if (detailTable) {
                    detailTable.clear();

                    data.forEach((item) => {
                        const checkboxHtml = `
                        <input type="checkbox"
                            class="row-select-isi"

                            data-no-trans="${item.No_trans ?? ""}"
                            data-kd-brg="${item.Kd_brg ?? ""}"
                            data-nama-brg="${(item.NAMA_BRG ?? "").replace(
                                /"/g,
                                "&quot;"
                            )}"
                            data-ket-brg="${(item.KET ?? "").replace(
                                /"/g,
                                "&quot;"
                            )}"
                            data-kat-utama="${(item.nama ?? "").replace(
                                /"/g,
                                "&quot;"
                            )}"
                            data-kategori="${(item.nama_kategori ?? "").replace(
                                /"/g,
                                "&quot;"
                            )}"
                            data-sub-kategori="${(
                                item.nama_sub_kategori ?? ""
                            ).replace(/"/g, "&quot;")}"
                            data-ket-pembelian="${(
                                item.keterangan ?? ""
                            ).replace(/"/g, "&quot;")}"
                            data-satuan="${(item.Nama_satuan ?? "").replace(
                                /"/g,
                                "&quot;"
                            )}"
                            data-qty="${item.Qty ?? ""}"

                            data-tgl-sppb="${
                                item.Tgl_sppb ? item.Tgl_sppb.substr(0, 10) : ""
                            }"
                            data-no-sppb="${item.No_sppb ?? ""}"
                            data-tgl-datang="${
                                item.Tgl_dtg ? item.Tgl_dtg.substr(0, 10) : ""
                            }"

                            data-id-mata-uang="${
                                item.IdMataUang ?? item.Id_MataUang ?? ""
                            }"
                            data-kurs="${item.Kurs_Rp ?? item.kurs_ppn ?? 0}"

                            data-harga-satuan="${
                                item.hrg_murni ??
                                item.Hrg_trm ??
                                item.PriceUnit ??
                                0
                            }"

                            data-disc="${
                                item.Disc_trm ?? item.hrg_disc ?? item.Disc ?? 0
                            }"

                            data-ppn="${
                                item.Ppn_trm ?? item.hrg_ppn ?? item.PPN ?? 0
                            }"

                            data-dpp-nilai-lain="${
                                item.dpp_nilai_lain ?? item.DppNilaiLain ?? 0
                            }"

                            data-harga-ppn="${
                                item.hrg_ppn ?? item.HargaPpn ?? 0
                            }"

                            data-subtotal-harga="${
                                item.hrg_nego ?? item.SubTotalHargaJual ?? 0
                            }"

                            data-total-harga="${
                                item.hrg_nego_rp ?? item.TotalHarga ?? 0
                            }"

                            data-waktu="${item.Waktu ?? 0}"

                            data-no-sup="${
                                item.No_sup ?? item.IdSup ?? item.Supplier ?? ""
                            }"
                            data-pembayaran="${
                                item.Pembayaran ?? item.PersetujuanBayar ?? ""
                            }"
                        />
                    `;

                        detailTable.row.add([
                            checkboxHtml,
                            item.Tgl_order ? item.Tgl_order.substr(0, 10) : "",
                            item.Qty ?? "",
                            item.Pemesan ?? "",
                            item.NM_MSN ?? "",
                            item.NM_GOL ?? "",
                            item.No_trans ?? "",
                            item.Tgl_dtg ? item.Tgl_dtg.substr(0, 10) : "",
                            item.Retur ?? "",
                            item.Direktur ?? "",
                            item.hrg_murni ??
                                item.Hrg_trm ??
                                item.PriceUnit ??
                                0,
                            item.Disc_trm ?? item.hrg_disc ?? item.Disc ?? 0,
                            item.dpp_nilai_lain ?? item.DppNilaiLain ?? 0,
                            item.Ppn_trm ?? item.hrg_ppn ?? item.PPN ?? 0,
                            item.hrg_nego_rp ?? item.TotalHarga ?? 0,
                        ]);
                    });

                    detailTable.draw();
                }
            })
            .catch((err) => {
                console.error("Error load detail SPPB (LIHAT):", err);
                alert("Terjadi kesalahan saat mengambil data SPPB.");
            });
    }

    // --- REFERENSI ---
    function loadMataUang() {
        if (!mata_uang) return;

        fetch("{{ route('purchaseorder.mata_uang') }}")
            .then((res) => res.json())
            .then((data) => {
                sel.innerHTML = '<option value="">Pilih Mata Uang</option>';
                data.forEach((row) => {
                    const opt = document.createElement("option");
                    opt.value = row.Id_MataUang;
                    opt.textContent = row.Nama_MataUang;
                    sel.appendChild(opt);
                });
            })
            .catch((err) => console.error("Error load mata uang:", err));
    }

    function loadSupplier() {
        const sel = document.getElementById("supplier");
        if (!sel) return;

        fetch("{{ route('purchaseorder.supplier') }}")
            .then((res) => res.json())
            .then((data) => {
                sel.innerHTML = '<option value="">Pilih Supplier</option>';
                data.forEach((row) => {
                    const opt = document.createElement("option");
                    opt.value = row.NO_SUP ?? row.IdSup ?? "";
                    opt.textContent = (row.NM_SUP || "").trim();
                    sel.appendChild(opt);
                });
            })
            .catch((err) => console.error("Error load supplier:", err));
    }

    // --- MODE HANDLER ---
    function applyMode() {
        const isIsi = mode === "ISI";
        const isLihat = mode === "LIHAT";

        const allowedIsi = [
            "kd_div",
            "tgl_sppb",
            "mata_uang",
            "kurs",
            "hrg_murni",
            "disc",
            "ppn",
            "dpp_nilai_lain",
            "harga_ppn",
            "subtotal_harga_jual",
            "total_harga",
            "jangka_waktu",
            "pembayaran",
            "tgl_datang",
            "jenis_pembelian",
            "supplier",
            "alasan_hapus",
        ];

        const allowedLihat = allowedIsi.concat(["no_sppb"]);

        document
            .querySelectorAll("form input, form select, form textarea")
            .forEach((el) => {
                if (el.closest(".dataTables_wrapper")) {
                    return;
                }
                if (el.type === "hidden") {
                    el.disabled = false;
                    return;
                }
                if (isIsi) {
                    el.disabled = !allowedIsi.includes(el.id);
                } else if (isLihat) {
                    el.disabled = !allowedLihat.includes(el.id);
                } else {
                    el.disabled = el.id !== "kd_div";
                }
            });

        if (isIsi || isLihat) {
            document.getElementById("btn-isi").disabled = true;
            document.getElementById("btn-lihat").disabled = true;
        } else {
            document.getElementById("btn-isi").disabled = false;
            document.getElementById("btn-lihat").disabled = false;
        }

        document
            .getElementById("btn-isi")
            .classList.toggle("btn-primary", isIsi);
        document
            .getElementById("btn-lihat")
            .classList.toggle("btn-primary", isLihat);
        document
            .getElementById("btn-isi")
            .classList.toggle("btn-outline-secondary", !isIsi);
        document
            .getElementById("btn-lihat")
            .classList.toggle("btn-outline-secondary", !isLihat);

        const btnExitCancel = document.getElementById("btn-exit-cancel");
        if (btnExitCancel) {
            btnExitCancel.textContent = isIsi || isLihat ? "BATAL" : "KELUAR";
        }

        if (isIsi) {
            loadDataByDivisiIsi();
        } else if (isLihat) {
            loadNoSppbByDivisi();
        } else {
            clearDetailSppb();
        }
    }

    function setMode(newMode) {
        mode = newMode;
        clearDetailSppb();
        applyMode();
    }

    // --- Auto set Pembayaran dari Jangka Waktu ---
    function applyPembayaranFromJangkaWaktu() {
        const jw = document.getElementById("jangka_waktu");
        const byr = document.getElementById("pembayaran");
        if (!jw || !byr) return;

        const n = parseInt(jw.value || "0", 10);
        if (isNaN(n)) {
            byr.value = "";
            return;
        }

        if (n === 0) {
            byr.value = "KREDIT";
        } else if (n > 0) {
            byr.value = "TRANSFER";
        } else {
            byr.value = "";
        }
    }

    // --- INIT ---
    document.addEventListener("DOMContentLoaded", function () {
        loadMataUang();
        loadSupplier();

        if (window.jQuery && $.fn.DataTable) {
            detailTable = $("#tbl-detail-order").DataTable({
                paging: true,
                pageLength: 5,
                lengthMenu: [5, 10, 25, 50, 100],
                searching: true,
                info: true,
                ordering: false,
                scrollX: true,
                autoWidth: false,
                language: {
                    emptyTable: "Tidak ada data detail.",
                },
            });

            $("#tbl-detail-order tbody").on(
                "change",
                ".row-select-isi",
                function () {
                    if (mode !== "ISI" && mode !== "LIHAT") return;

                    $("#tbl-detail-order tbody .row-select-isi")
                        .not(this)
                        .prop("checked", false);

                    if (!this.checked) {
                        document.getElementById("no_trans").value = "";
                        document.getElementById("kd_brg").value = "";
                        document.getElementById("nama_brg").value = "";
                        document.getElementById("ket_brg").value = "";
                        document.getElementById("kat_utama").value = "";
                        document.getElementById("kategori").value = "";
                        document.getElementById("sub_kategori").value = "";
                        document.getElementById("ket_pembelian").value = "";
                        document.getElementById("satuan").value = "";
                        document.getElementById("qty").value = "";
                        document.getElementById("hrg_murni").value = "";
                        document.getElementById("dpp_nilai_lain").value = "";
                        document.getElementById("harga_ppn").value = "";
                        document.getElementById("subtotal_harga_jual").value =
                            "";
                        document.getElementById("total_harga").value = "";
                        return;
                    }

                    const d = this.dataset;

                    document.getElementById("no_trans").value = d.noTrans || "";
                    document.getElementById("kd_brg").value = d.kdBrg || "";
                    document.getElementById("nama_brg").value = d.namaBrg || "";
                    document.getElementById("ket_brg").value = d.ketBrg || "";
                    document.getElementById("kat_utama").value =
                        d.katUtama || "";
                    document.getElementById("kategori").value =
                        d.kategori || "";
                    document.getElementById("sub_kategori").value =
                        d.subKategori || "";
                    document.getElementById("ket_pembelian").value =
                        d.ketPembelian || "";
                    document.getElementById("satuan").value = d.satuan || "";
                    document.getElementById("qty").value = d.qty || "";
                    document.getElementById("jangka_waktu").value =
                        d.waktu || "";
                    document.getElementById("pembayaran").value =
                        d.pembayaran || "";

                    if (d.tglDatang) {
                        document.getElementById("tgl_datang").value =
                            d.tglDatang;
                    }

                    if (d.tglSppb) {
                        document.getElementById("tgl_sppb").value = d.tglSppb;
                    }

                    if (d.noSppb) {
                        const noSppbSelect = document.getElementById("no_sppb");
                        let opt = Array.from(noSppbSelect.options).find(
                            (o) => o.value === d.noSppb
                        );
                        if (!opt) {
                            opt = new Option(d.noSppb, d.noSppb, true, true);
                            noSppbSelect.appendChild(opt);
                        } else {
                            noSppbSelect.value = d.noSppb;
                        }
                    }

                    if (mata_uang) {
                        mata_uang.value = d.idMataUang || "";
                    }

                    if (!d.pembayaran) {
                        applyPembayaranFromJangkaWaktu();
                    }

                    document.getElementById("kurs").value = d.kurs || "0";
                    document.getElementById("hrg_murni").value =
                        d.hrgMurni || "";
                    document.getElementById("disc").value = d.disc || "";
                    document.getElementById("ppn").value = d.ppn || "";

                    document.getElementById("dpp_nilai_lain").value =
                        d.dppNilaiLain || "";
                    document.getElementById("harga_ppn").value =
                        d.hargaPpn || "";

                    const qtyVal = parseFloat(d.qty || "0");
                    const hrgVal = parseFloat(d.hargaSatuan || "0");
                    const subtotal = qtyVal * hrgVal;

                    const discPct = parseFloat(d.disc || "0");
                    const ppnPct = parseFloat(d.ppn || "0");

                    let hargaDisc;
                    if (ppnPct > 0) {
                        hargaDisc = subtotal - (subtotal * discPct) / 100;
                    } else {
                        hargaDisc = subtotal;
                    }

                    const cbDppEl = document.getElementById("cbDPP");
                    const cbDppValue = cbDppEl ? cbDppEl.value : "0";

                    let dppNilaiLain;
                    if (ppnPct === 12 && cbDppValue === "0") {
                        dppNilaiLain = (hargaDisc * 11) / 12;
                    } else {
                        dppNilaiLain = hargaDisc;
                    }

                    const hargaPpn = dppNilaiLain * (ppnPct / 100);
                    const totalHarga = hargaDisc + hargaPpn;

                    document.getElementById("subtotal_harga_jual").value =
                        isFinite(hargaDisc) ? hargaDisc.toFixed(4) : "";

                    document.getElementById("dpp_nilai_lain").value = isFinite(
                        dppNilaiLain
                    )
                        ? dppNilaiLain.toFixed(4)
                        : "";

                    document.getElementById("harga_ppn").value = isFinite(
                        hargaPpn
                    )
                        ? hargaPpn.toFixed(4)
                        : "";

                    document.getElementById("total_harga").value = isFinite(
                        totalHarga
                    )
                        ? totalHarga.toFixed(4)
                        : "";

                    const supplierSelect = document.getElementById("supplier");
                    if (supplierSelect) {
                        if (d.noSup) {
                            supplierSelect.value = d.noSup;
                            supplierSelect.disabled = true;
                        } else {
                            supplierSelect.disabled = false;
                            supplierSelect.value = "";
                        }
                    }
                }
            );
        }

        const btnIsi = document.getElementById("btn-isi");
        const btnLihat = document.getElementById("btn-lihat");
        const btnExitCancel = document.getElementById("btn-exit-cancel");

        if (btnIsi) {
            btnIsi.addEventListener("click", function () {
                setMode("ISI");
            });
        }

        if (btnLihat) {
            btnLihat.addEventListener("click", function () {
                setMode("LIHAT");
            });
        }

        if (btnExitCancel) {
            btnExitCancel.addEventListener("click", function () {
                if (mode === "") {
                    window.location.href = "{{ url('/Beli') }}";
                } else {
                    setMode("");
                }
            });
        }

        const kdDiv = document.getElementById("kd_div");
        if (kdDiv) {
            kdDiv.addEventListener("change", function () {
                if (mode === "ISI") {
                    loadDataByDivisiIsi();
                } else if (mode === "LIHAT") {
                    loadNoSppbByDivisi();
                }
            });
        }

        const noSppbSelect = document.getElementById("no_sppb");
        if (noSppbSelect) {
            noSppbSelect.addEventListener("change", function () {
                if (mode === "LIHAT" && this.value) {
                    loadDetailSppbSingle();
                }
            });
        }

        const jwInput = document.getElementById("jangka_waktu");
        if (jwInput) {
            jwInput.addEventListener("change", applyPembayaranFromJangkaWaktu);
            jwInput.addEventListener("blur", applyPembayaranFromJangkaWaktu);
        }
        setMode("");
    });

    mata_uang.addEventListener("keypress", function (e) {
        if (e.key == "Enter") {
            e.preventDefault();
            if (this.value == "Rupiah") {
                kurs.value = "1";
                hrg_murni.focus();
            } else {
                kurs.value = "0";
                kurs.focus();
            }
        }
    });
});
