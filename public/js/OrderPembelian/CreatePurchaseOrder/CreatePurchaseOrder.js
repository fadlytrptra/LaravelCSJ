// CreatePurchaseOrder.js
// Full consolidated file: Data loaders, UI mode, mata_uang behavior, price computation,
// DataTable handling, and "Tambah Harga" which saves to YTRANSBL via POST /purchaseorder/tambah-harga
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
    let hrg_ppn = document.getElementById("harga_ppn");
    let subtotal_harga_jual = document.getElementById("subtotal_harga_jual");
    let jangka_waktu = document.getElementById("jangka_waktu");
    let total_harga = document.getElementById("total_harga");
    let pembayaran = document.getElementById("pembayaran");
    let supplier = document.getElementById("supplier");
    let jenis_pembelian = document.getElementById("jenis_pembelian");
    let alasan_hapus = document.getElementById("alasan_hapus");
    let no_sppb = document.getElementById("no_sppb");
    let kd_div = document.getElementById("kd_div");
    let hrg_disc = document.getElementById("hrg_disc");
    let btn_tambah_harga = document.getElementById("btn_tambah_harga");
    let btn_proses = document.getElementById("btn_proses");
    //#endregion

    //#region Utility functions
    function safeText(v) {
        return v === null || typeof v === "undefined" ? "" : String(v);
    }

    function parseNumber(v) {
        if (typeof v === "number") return isFinite(v) ? v : 0;
        if (!v && v !== 0) return 0;
        let s = (v || "").toString().replace(/,/g, "").trim();
        let n = parseFloat(s);
        return isFinite(n) ? n : 0;
    }

    function formatNumber(v, decimals = 4) {
        if (!isFinite(v)) return "";
        return Number(v).toFixed(decimals);
    }

    // clear form + table
    function clearDetailSppb(jenisClear) {
        if (tgl_datang) tgl_datang.value = "";
        if (no_trans) no_trans.value = "";
        if (kd_brg) kd_brg.value = "";
        if (nama_brg) nama_brg.value = "";
        if (ket_brg) ket_brg.value = "";
        if (kat_utama) kat_utama.value = "";
        if (kategori) kategori.value = "";
        if (sub_kategori) sub_kategori.value = "";
        if (ket_pembelian) ket_pembelian.value = "";
        if (satuan) satuan.value = "";
        if (qty) qty.value = "";
        if (mata_uang) mata_uang.value = "";
        if (hrg_murni) hrg_murni.value = "";
        if (kurs) kurs.value = "0";
        if (disc) disc.value = "";
        if (ppn) ppn.value = "";
        if (dpp_nilai_lain) dpp_nilai_lain.value = "";
        if (hrg_ppn) hrg_ppn.value = "";
        if (subtotal_harga_jual) subtotal_harga_jual.value = "";
        if (jangka_waktu) jangka_waktu.value = "";
        if (total_harga) total_harga.value = "";
        if (pembayaran) pembayaran.value = "";

        if (supplier) {
            supplier.value = "";
            // supplier.disabled = false;
        }

        if (jenis_pembelian) jenis_pembelian.value = "";

        if (alasan_hapus) alasan_hapus.value = "";

        if (no_sppb) {
            if (mode === "") {
                no_sppb.innerHTML =
                    '<option value="">-- Pilih No SPPB --</option>';
                no_sppb.disabled = true;
            }
        }
        if (jenisClear == "gantiDivisi") {
            if (detailTable) detailTable.clear().draw();
        }
    }
    //#endregion

    //#region Data loaders
    function loadNoSppbByDivisi() {
        let noSppbEl = document.getElementById("no_sppb");
        let kdDivEl = document.getElementById("kd_div");

        if (!noSppbEl || !kdDivEl) {
            console.error("Element no_sppb atau kd_div tidak ditemukan");
            return Promise.reject(new Error("missing elements"));
        }

        let kdDiv = (kdDivEl.value || "").trim();
        noSppbEl.innerHTML = '<option value="">-- Pilih No SPPB --</option>';
        noSppbEl.disabled = true;

        if (!kdDiv) return Promise.resolve([]);

        let url = "/PurchaseOrder/no-sppb?kd_div=" + encodeURIComponent(kdDiv);
        return fetch(url)
            .then((res) => {
                let ct = (res.headers.get("content-type") || "").toLowerCase();
                if (!res.ok) {
                    return res.text().then((txt) => {
                        throw new Error(
                            "Server " +
                                res.status +
                                " while loading No SPPB. Preview: " +
                                txt.slice(0, 1000)
                        );
                    });
                }
                if (!ct.includes("application/json")) {
                    return res.text().then((txt) => {
                        throw new Error(
                            "Unexpected content-type for No SPPB: " +
                                ct +
                                ". Preview: " +
                                txt.slice(0, 1000)
                        );
                    });
                }
                return res.json();
            })
            .then((data) => {
                noSppbEl.innerHTML =
                    '<option value="">-- Pilih No SPPB --</option>';
                if (Array.isArray(data) && data.length > 0) {
                    data.forEach((item) => {
                        let val =
                            item.No_sppb ??
                            item.NoSPPB ??
                            item.no_sppb ??
                            item.noSPPB ??
                            "";
                        if (!val) return;
                        let opt = document.createElement("option");
                        opt.value = val;
                        opt.textContent = val;
                        noSppbEl.appendChild(opt);
                    });
                    noSppbEl.disabled = false;
                } else {
                    noSppbEl.innerHTML =
                        '<option value="">(tidak ada No SPPB)</option>';
                    noSppbEl.disabled = true;
                }
                return data;
            })
            .catch((err) => {
                console.error("loadNoSppbByDivisi error:", err);
                noSppbEl.innerHTML =
                    '<option value="">-- Error memuat --</option>';
                noSppbEl.disabled = true;
                throw err;
            });
    }

    function loadDetailSppbSingle() {
        let kdDivEl = document.getElementById("kd_div");
        let noSppbEl = document.getElementById("no_sppb");
        if (!kdDivEl || !noSppbEl) {
            console.error("Element kd_div atau no_sppb tidak ditemukan.");
            return;
        }

        let kdDiv = (kdDivEl.value || "").trim();
        let noSppb = (noSppbEl.value || "").trim();

        if (!kdDiv) {
            alert("Silakan pilih Nama Divisi terlebih dahulu.");
            return;
        }
        if (!noSppb) {
            alert("Silakan pilih No SPPB.");
            return;
        }

        if (typeof clearDetailSppb === "function")
            clearDetailSppb("gantiDivisi");
        noSppbEl.disabled = true;

        let url =
            "/PurchaseOrder/detail-sppb?kd_div=" +
            encodeURIComponent(kdDiv) +
            "&no_sppb=" +
            encodeURIComponent(noSppb);
        return fetch(url)
            .then((res) => {
                let ct = (res.headers.get("content-type") || "").toLowerCase();
                if (!res.ok) {
                    return res.text().then((txt) => {
                        throw new Error(
                            "Server responded " +
                                res.status +
                                ". Body preview:\n" +
                                txt.slice(0, 2000)
                        );
                    });
                }
                if (!ct.includes("application/json")) {
                    return res.text().then((txt) => {
                        throw new Error(
                            "Unexpected response type: " +
                                ct +
                                ". Body preview:\n" +
                                txt.slice(0, 2000)
                        );
                    });
                }
                return res.json();
            })
            .then((data) => {
                try {
                    noSppbEl.disabled = false;
                } catch (e) {}
                if (!Array.isArray(data) || data.length === 0) {
                    alert("Data SPPB tidak tersedia.");
                    return;
                }

                let row = data[0] || {};
                if (tgl_sppb)
                    tgl_sppb.value = row.Tgl_sppb
                        ? row.Tgl_sppb.substr
                            ? row.Tgl_sppb.substr(0, 10)
                            : row.Tgl_sppb
                        : "";
                if (tgl_datang)
                    tgl_datang.value = row.Tgl_dtg
                        ? row.Tgl_dtg.substr
                            ? row.Tgl_dtg.substr(0, 10)
                            : row.Tgl_dtg
                        : "";

                if (detailTable) {
                    detailTable.clear();
                    data.forEach((item) => {
                        let qtyVal = item.Qty ?? item.qty ?? "";
                        let tglOrder = item.Tgl_order ?? item.TglOrder ?? "";
                        let tglDtg = item.Tgl_dtg ?? item.TglDtg ?? "";
                        let noTrans = item.No_trans ?? item.NoTrans ?? "";
                        let hrgMurni =
                            item.hrg_murni ??
                            item.Hrg_trm ??
                            item.PriceUnit ??
                            0;
                        let discVal =
                            item.Disc_trm ?? item.hrg_disc ?? item.Disc ?? 0;
                        let dpp = item.dpp_nilai_lain ?? item.DppNilaiLain ?? 0;
                        let ppnVal =
                            item.Ppn_trm ?? item.hrg_ppn ?? item.PPN ?? 0;
                        let total = item.hrg_nego_rp ?? item.TotalHarga ?? 0;

                        let checkboxHtml = `
                            <input type="checkbox" class="row-select-isi"
                                data-no-trans="${safeText(noTrans)}"
                                data-kd-brg="${safeText(item.Kd_brg ?? "")}"
                                data-nama-brg="${
                                    (item.NAMA_BRG ?? "").replace
                                        ? (item.NAMA_BRG ?? "").replace(
                                              /"/g,
                                              "&quot;"
                                          )
                                        : item.NAMA_BRG ?? ""
                                }"
                                data-ket-brg="${
                                    (item.KET ?? "").replace
                                        ? (item.KET ?? "").replace(
                                              /"/g,
                                              "&quot;"
                                          )
                                        : item.KET ?? ""
                                }"
                                data-no-sppb="${safeText(
                                    item.No_sppb ?? item.NoSPPB ?? ""
                                )}"
                                data-tgl-sppb="${safeText(
                                    item.Tgl_sppb
                                        ? item.Tgl_sppb.substr
                                            ? item.Tgl_sppb.substr(0, 10)
                                            : item.Tgl_sppb
                                        : ""
                                )}"
                                data-qty="${safeText(qtyVal)}"
                                data-hrg-murni="${safeText(hrgMurni)}"
                                data-disc="${safeText(discVal)}"
                                data-ppn="${safeText(ppnVal)}"
                                data-kurs="${safeText(
                                    item.Kurs_Rp ?? item.kurs_ppn ?? 0
                                )}"
                                data-no-sup="${safeText(
                                    item.No_sup ??
                                        item.IdSup ??
                                        item.Supplier ??
                                        ""
                                )}"
                                data-no-satuan="${safeText(
                                    item.NoSatuan ?? item.No_satuan ?? ""
                                )}"
                                />
                        `;

                        detailTable.row.add([
                            checkboxHtml,
                            tglOrder
                                ? tglOrder.substr
                                    ? tglOrder.substr(0, 10)
                                    : tglOrder
                                : "",
                            qtyVal,
                            item.Pemesan ?? item.pemesan ?? "",
                            item.NM_MSN ?? "",
                            item.NM_GOL ?? "",
                            noTrans,
                            tglDtg
                                ? tglDtg.substr
                                    ? tglDtg.substr(0, 10)
                                    : tglDtg
                                : "",
                            item.Retur ?? "",
                            item.Direktur ?? "",
                            hrgMurni,
                            discVal,
                            dpp,
                            ppnVal,
                            total,
                        ]);
                    });
                    detailTable.draw();
                } else {
                    console.warn("detailTable belum terinit");
                }
            })
            .catch((err) => {
                try {
                    noSppbEl.disabled = false;
                } catch (e) {}
                console.error("Error load detail SPPB (LIHAT):", err);
                alert(
                    "Terjadi kesalahan saat mengambil data SPPB. Cek console/network untuk detail."
                );
            });
    }

    //divisi isi
    function loadDataByDivisiIsi() {
        let kdDiv = (
            document.getElementById("kd_div")
                ? document.getElementById("kd_div").value
                : ""
        ).trim();
        if (!kdDiv || mode !== "ISI") {
            if (detailTable) detailTable.clear().draw();
            return;
        }

        fetch(
            "/PurchaseOrder/detail-sppb" +
                "?kd_div=" +
                encodeURIComponent(kdDiv) +
                "&no_sppb="
        )
            .then((res) => {
                let ct = (res.headers.get("content-type") || "").toLowerCase();
                if (!res.ok)
                    return res.text().then((txt) => {
                        throw new Error(
                            "Server " +
                                res.status +
                                ". Preview: " +
                                txt.slice(0, 1000)
                        );
                    });
                if (!ct.includes("application/json"))
                    return res.text().then((txt) => {
                        throw new Error(
                            "Unexpected content-type: " +
                                ct +
                                ". Preview: " +
                                txt.slice(0, 1000)
                        );
                    });
                return res.json();
            })
            .then((data) => {
                if (!detailTable) return;
                detailTable.clear();
                if (Array.isArray(data) && data.length > 0) {
                    data.forEach((item) => {
                        let checkboxHtml = `
                        <input type="checkbox" class="row-select-isi"
                            data-no-trans="${safeText(item.No_trans ?? "")}"
                            data-kd-brg="${safeText(item.Kd_brg ?? "")}"
                            data-nama-brg="${
                                (item.NAMA_BRG ?? "").replace
                                    ? (item.NAMA_BRG ?? "").replace(
                                          /"/g,
                                          "&quot;"
                                      )
                                    : item.NAMA_BRG ?? ""
                            }"
                            data-ket-brg="${
                                (item.KET ?? "").replace
                                    ? (item.KET ?? "").replace(/"/g, "&quot;")
                                    : item.KET ?? ""
                            }"
                            data-kat-utama="${safeText(item.nama ?? "")}"
                            data-kategori="${safeText(
                                item.nama_kategori ?? ""
                            )}"
                            data-sub-kategori="${safeText(
                                item.nama_sub_kategori ?? ""
                            )}"
                            data-ket-pembelian="${
                                (item.keterangan ?? "").replace
                                    ? (item.keterangan ?? "").replace(
                                          /"/g,
                                          "&quot;"
                                      )
                                    : item.keterangan ?? ""
                            }"
                            data-no-satuan="${safeText(
                                item.NoSatuan ?? item.No_satuan ?? ""
                            )}"
                            data-qty="${safeText(item.Qty ?? "")}"
                            data-tgl-sppb="${safeText(
                                item.Tgl_sppb
                                    ? item.Tgl_sppb.substr
                                        ? item.Tgl_sppb.substr(0, 10)
                                        : item.Tgl_sppb
                                    : ""
                            )}"
                            data-no-sppb="${safeText(item.No_sppb ?? "")}"
                            data-tgl-datang="${safeText(
                                item.Tgl_dtg
                                    ? item.Tgl_dtg.substr
                                        ? item.Tgl_dtg.substr(0, 10)
                                        : item.Tgl_dtg
                                    : ""
                            )}"
                            data-id-mata-uang="${safeText(
                                item.IdMataUang ?? item.Id_MataUang ?? ""
                            )}"
                            data-kurs="${safeText(
                                item.Kurs_Rp ?? item.kurs_ppn ?? 0
                            )}"
                            data-hrg-murni="${safeText(
                                item.hrg_murni ??
                                    item.Hrg_trm ??
                                    item.PriceUnit ??
                                    0
                            )}"
                            data-disc="${safeText(
                                item.Disc_trm ?? item.hrg_disc ?? item.Disc ?? 0
                            )}"
                            data-ppn="${safeText(
                                item.Ppn_trm ?? item.hrg_ppn ?? item.PPN ?? 0
                            )}"
                            data-dpp-nilai-lain="${safeText(
                                item.dpp_nilai_lain ?? item.DppNilaiLain ?? 0
                            )}"
                            data-harga-ppn="${safeText(
                                item.hrg_ppn ?? item.HargaPpn ?? 0
                            )}"
                            data-subtotal-harga="${safeText(
                                item.hrg_nego ?? item.SubTotalHargaJual ?? 0
                            )}"
                            data-total-harga="${safeText(
                                item.hrg_nego_rp ?? item.TotalHarga ?? 0
                            )}"
                            data-waktu="${safeText(item.Waktu ?? 0)}"
                            data-no-sup="${safeText(
                                item.No_sup ?? item.IdSup ?? item.Supplier ?? ""
                            )}"
                            data-pembayaran="${safeText(
                                item.Pembayaran ?? item.PersetujuanBayar ?? ""
                            )}"
                            data-satuan="${safeText(item.Nama_satuan ?? "")}"
                        />
                        `;
                        let show = (field) => {
                            if (
                                !Object.prototype.hasOwnProperty.call(
                                    item,
                                    field
                                )
                            )
                                return "";
                            let val = item[field];
                            return val === null || val === "" ? "-" : val;
                        };

                        detailTable.row.add([
                            checkboxHtml,
                            item.Tgl_order
                                ? item.Tgl_order.substr
                                    ? item.Tgl_order.substr(0, 10)
                                    : item.Tgl_order
                                : "",
                            show("Qty"),
                            show("Pemesan"),
                            show("NM_MSN"),
                            show("NM_GOL"),
                            show("No_trans"),
                            item.Tgl_dtg
                                ? item.Tgl_dtg.substr
                                    ? item.Tgl_dtg.substr(0, 10)
                                    : item.Tgl_dtg
                                : "",
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
                alert(
                    "Terjadi kesalahan saat memuat data. Cek console/network untuk detail."
                );
            });
    }
    //#endregion

    //#region Reference loaders
    function loadMataUang() {
        if (!mata_uang) return;
        let sel = mata_uang;
        fetch("/PurchaseOrder/mata-uang")
            .then((res) => res.json())
            .then((data) => {
                sel.innerHTML = '<option value="">Pilih Mata Uang</option>';
                (data || []).forEach((row) => {
                    let opt = document.createElement("option");
                    opt.value = row.Id_MataUang;
                    opt.textContent = row.Nama_MataUang;
                    sel.appendChild(opt);
                });
            })
            .catch((err) => console.error("Error load mata uang:", err));
    }

    function loadSupplier() {
        let sel = document.getElementById("supplier");
        if (!sel) return;
        sel.innerHTML =
            '<option value="" disabled selected>Pilih Supplier</option>';
        fetch("/PurchaseOrder/supplier")
            .then((res) => res.text())
            .then((text) => {
                try {
                    let data = JSON.parse(text);
                    if (!Array.isArray(data) || data.length === 0) {
                        sel.innerHTML =
                            '<option value="" disabled>(tidak ada supplier)</option>';
                        sel.disabled = true;
                        return;
                    }
                    sel.innerHTML =
                        '<option value="" disabled selected>Pilih Supplier</option>';
                    data.forEach((row) => {
                        let noSup =
                            row.No_sup ??
                            row.NO_SUP ??
                            row.NoSup ??
                            row.IdSup ??
                            row.Id_Sup ??
                            row.no_sup ??
                            "";
                        let nama = (
                            row.NM_SUP ??
                            row.nm_sup ??
                            row.nama ??
                            row.name ??
                            ""
                        )
                            .toString()
                            .trim();
                        let value = noSup || row.IdSup || nama || "";
                        let opt = document.createElement("option");
                        opt.value = value;
                        opt.textContent = noSup
                            ? `${noSup} - ${nama || value}`
                            : nama || value;
                        opt.style.color = "#000";
                        opt.style.backgroundColor = "#fff";
                        opt.classList.add("text-dark");
                        sel.appendChild(opt);
                    });
                    sel.disabled = false;
                } catch (e) {
                    console.error(
                        "Gagal parse supplier response as JSON. Body preview:",
                        text.slice(0, 2000)
                    );
                    sel.innerHTML =
                        '<option value="" disabled>(error memuat supplier)</option>';
                    sel.disabled = true;
                }
            })
            .catch((err) => {
                console.error("Error load supplier:", err);
                sel.innerHTML =
                    '<option value="" disabled>(error koneksi)</option>';
                sel.disabled = true;
            });
    }
    //#endregion

    //#region Mode
    function applyMode(newMode) {
        if (typeof newMode !== "undefined") mode = newMode;
        let isIsi = mode === "ISI";
        let isLihat = mode === "LIHAT";
        let isNoMode = !isIsi && !isLihat;

        let allowedIsi = [
            "kd_div",
            "tgl_sppb",
            "mata_uang",
            "kurs",
            "hrg_murni",
            "disc",
            "ppn",
            "jangka_waktu",
            "pembayaran",
            "tgl_datang",
            "jenis_pembelian",
            "supplier",
            "alasan_hapus",
        ];
        let allowedLihat = allowedIsi.concat(["no_sppb"]);

        document
            .querySelectorAll("form input, form select, form textarea")
            .forEach((el) => {
                if (el.closest && el.closest(".dataTables_wrapper")) return;
                if (el.type === "hidden") {
                    el.disabled = false;
                    return;
                }
                if (isIsi) el.disabled = !allowedIsi.includes(el.id);
                else if (isLihat) el.disabled = !allowedLihat.includes(el.id);
                else el.disabled = true;
            });

        document
            .querySelectorAll(
                "#tbl_detail_order tbody .row-select-isi, #tbl_detail_order tbody input[type='checkbox']"
            )
            .forEach((cb) => {
                cb.disabled = isNoMode;
                if (isNoMode) cb.checked = false;
            });

        let btnIsi = document.getElementById("btn-isi");
        let btnLihat = document.getElementById("btn-lihat");
        let btnExitCancel = document.getElementById("btn-exit-cancel");

        if (btnIsi) {
            btnIsi.disabled = isIsi || isLihat;
            btnIsi.classList.toggle("btn-primary", isIsi);
            btnIsi.classList.toggle("btn-outline-secondary", !isIsi);
        }
        if (btnLihat) {
            btnLihat.disabled = isIsi || isLihat;
            btnLihat.classList.toggle("btn-primary", isLihat);
            btnLihat.classList.toggle("btn-outline-secondary", !isLihat);
        }
        if (btnExitCancel)
            btnExitCancel.textContent = isIsi || isLihat ? "BATAL" : "KELUAR";

        if (isIsi) {
            ensureTodayDatesIfEmpty();
            if (typeof loadDataByDivisiIsi === "function")
                loadDataByDivisiIsi();
        } else if (isLihat) {
            if (typeof loadNoSppbByDivisi === "function")
                loadNoSppbByDivisi().catch(() => {});
        } else {
            if (typeof clearDetailSppb === "function")
                clearDetailSppb("gantiDivisi");
        }
    }

    function setMode(newMode) {
        mode =
            typeof newMode === "undefined" || newMode === null ? "" : newMode;
        if (typeof clearDetailSppb === "function")
            clearDetailSppb("gantiDivisi");
        applyMode();
    }

    //#endregion

    //#region Mata Uang behavior
    function initMataUangBehavior() {
        if (!mata_uang) return;

        function selectedIsRupiah() {
            let idx = mata_uang.selectedIndex;
            if (idx < 0) return false;
            let txt = (mata_uang.options[idx].text || "").toLowerCase().trim();
            return txt.includes("rupiah");
        }

        mata_uang.addEventListener("change", function () {
            if (selectedIsRupiah()) {
                if (kurs) {
                    kurs.value = "1";
                    kurs.disabled = false;
                }
                if (hrg_murni) hrg_murni.focus();
            } else {
                if (kurs) {
                    let current = parseFloat(kurs.value || "0");
                    if (!isFinite(current) || current === 0) kurs.value = "0";
                    kurs.disabled = false;
                    kurs.focus();
                } else if (hrg_murni) hrg_murni.blur();
            }
        });
        if (kurs && hrg_murni) {
            kurs.addEventListener("blur", function () {
                let v = parseFloat(kurs.value || "0");
                if (isFinite(v) && v > 0) hrg_murni.focus();
            });
        }
        mata_uang.addEventListener("keydown", function (e) {
            if (e.key === "Enter") {
                e.preventDefault();
                mata_uang.dispatchEvent(new Event("change", { bubbles: true }));
            }
        });
    }

    initMataUangBehavior();

    function totalHarga() {
        let qtyValue = parseNumber(qty?.value);
        let hrgValue = parseNumber(hrg_murni?.value);
        let discPct = parseNumber(disc?.value);
        let ppnPct = parseNumber(ppn?.value);

        // subtotal awal
        let subtotal = qtyValue * hrgValue;

        // diskon (tidak ditampilkan dalam UI)
        let diskonRp = subtotal * (discPct / 100);

        // subtotal setelah diskon
        let setelahDisc = subtotal - diskonRp;

        // DPP nilai lain
        let dppValue = setelahDisc * (11 / 12);

        // PPN (Rp)
        let ppnRp = dppValue * (ppnPct / 100);

        // total harga
        let totalValue = setelahDisc + ppnRp;

        //tampilan
        subtotal_harga_jual.value = formatNumber(subtotal, 2);
        dpp_nilai_lain.value = formatNumber(dppValue, 2);
        hrg_ppn.value = formatNumber(ppnRp, 2);
        total_harga.value = formatNumber(totalValue, 2);

        return {
            subtotal,
            diskonRp,
            setelahDisc,
            dppValue,
            ppnRp,
            totalValue,
        };
    }
    //#endregion

    //#region DataTable init
    if (window.jQuery && $.fn.DataTable) {
        detailTable = $("#tbl_detail_order").DataTable({
            paging: true,
            pageLength: 5,
            lengthMenu: [5, 10, 25, 50, 100],
            searching: true,
            info: true,
            ordering: false,
            scrollX: true,
            autoWidth: false,
            language: { emptyTable: "Tidak ada data detail." },
            // columnDefs: [
            //     {
            //         visible: false,
            //         targets: 0,
            //     },
            // ],
        });

        $("#tbl_detail_order tbody").on(
            "change",
            ".row-select-isi",
            function () {
                if (mode !== "ISI" && mode !== "LIHAT") return;
                $("#tbl_detail_order tbody .row-select-isi")
                    .not(this)
                    .prop("checked", false);
                clearDetailSppb("clearBiasa");
                if (!this.checked) {
                    if (no_trans) no_trans.value = "";
                    if (kd_brg) kd_brg.value = "";
                    if (nama_brg) nama_brg.value = "";
                    if (ket_brg) ket_brg.value = "";
                    if (kat_utama) kat_utama.value = "";
                    if (kategori) categoria = "";
                    if (sub_kategori) sub_kategori.value = "";
                    if (ket_pembelian) ket_pembelian.value = "";
                    if (satuan) satuan.value = "";
                    if (qty) qty.value = "";
                    if (hrg_murni) hrg_murni.value = "";
                    if (dpp_nilai_lain) dpp_nilai_lain.value = "";
                    if (hrg_ppn) hrg_ppn.value = "";
                    if (subtotal_harga_jual) subtotal_harga_jual.value = "";
                    if (total_harga) total_harga.value = "";
                    if (satuan) satuan.value = "";
                    return;
                }

                let d = this.dataset;
                if (no_trans)
                    no_trans.value =
                        d.notrans || d.notransaksi || d.noTrans || "";
                if (kd_brg) kd_brg.value = d.kdbrg || d.kdBrg || "";
                if (nama_brg) nama_brg.value = d.namabrg || d.namaBrg || "";
                if (ket_brg) ket_brg.value = d.ketbrg || d.ketBrg || "";
                if (kat_utama) kat_utama.value = d.katutama || d.katUtama || "";
                if (kategori) kategori.value = d.kategori || "";
                if (sub_kategori)
                    sub_kategori.value = d.subKategori || d.sub_kategori || "";
                if (ket_pembelian)
                    ket_pembelian.value =
                        d.ketpembelian || d.ketPembelian || "";
                if (satuan) satuan.value = d.satuan || "";
                if (qty) qty.value = d.qty || d.qtyVal || "";
                if (jangka_waktu) jangka_waktu.value = d.waktu || "";
                if (pembayaran) pembayaran.value = d.pembayaran || "";

                if (d.tgldatang && tgl_datang)
                    tgl_datang.value = d.tgldatang || d.tglDatang || "";
                if (d.tglsppb && tgl_sppb)
                    tgl_sppb.value = d.tglsppb || d.tglSppb || "";

                if (d.noSppb && no_sppb) {
                    let opt = Array.from(no_sppb.options).find(
                        (o) => o.value === d.noSppb
                    );
                    if (!opt) {
                        opt = new Option(d.noSppb, d.noSppb, true, true);
                        no_sppb.appendChild(opt);
                    } else no_sppb.value = d.noSppb;
                }

                if (mata_uang)
                    mata_uang.value =
                        d.idMatauang || d.idMataUang || d.idMata || "";
                if (kurs) kurs.value = d.kurs || d.kurs_rp || "0";
                if (hrg_murni)
                    hrg_murni.value =
                        d.hrgmurni || d.hrg_murni || d.hargaSatuan || "";
                if (disc) disc.value = d.disc || "";
                if (ppn) ppn.value = d.ppn || "";

                if (d.dppnilailain && dpp_nilai_lain)
                    dpp_nilai_lain.value = d.dppnilailain || "";
                if (d.hargappn && hrg_ppn) hrg_ppn.value = d.hargappn || "";
                if (satuan) satuan.value = d.satuan;
            }
        );
    }
    //#endregion

    //#region Buttons, mode switches
    let btnIsi = document.getElementById("btn-isi");
    let btnLihat = document.getElementById("btn-lihat");
    let btnExitCancel = document.getElementById("btn-exit-cancel");

    if (btnIsi)
        btnIsi.addEventListener("click", (e) => {
            e.preventDefault();
            setMode("ISI");
            applyMode();
            loadDataByDivisiIsi();
        });
    if (btnLihat)
        btnLihat.addEventListener("click", (e) => {
            e.preventDefault();
            setMode("LIHAT");
            applyMode();
            if (typeof loadNoSppbByDivisi === "function")
                loadNoSppbByDivisi().catch(() => {});
        });

    document.body.addEventListener(
        "click",
        function (ev) {
            let t = ev.target;
            if (!(t instanceof Element)) return;
            let btn =
                t.closest &&
                t.closest("#btn-isi, #btn-lihat, #btn-exit-cancel, .btn-mode");
            if (!btn) return;
            ev.preventDefault();
            if (btn.id === "btn-isi") {
                setMode("ISI");
                applyMode();
                return;
            } else if (btn.id === "btn-lihat") {
                setMode("LIHAT");
                applyMode();
                if (typeof loadNoSppbByDivisi === "function")
                    loadNoSppbByDivisi().catch(() => {});
                return;
            }
            if (btn.id === "btn-exit-cancel") {
                if (mode === "ISI" || mode === "LIHAT") {
                    setMode("");
                    applyMode();
                    return;
                }
                let targetUrl = btn.dataset.href;
                if (targetUrl) window.location.href = targetUrl;
                return;
            }
        },
        true
    );

    if (kd_div)
        kd_div.addEventListener("change", function () {
            if (mode === "ISI") {
                loadDataByDivisiIsi();
            } else if (mode === "LIHAT") {
                if (typeof loadDetailSppbSingle === "function")
                    loadDetailSppbSingle().catch(() => {});
            }
        });

    let noSppbSelect = document.getElementById("no_sppb");
    if (noSppbSelect)
        noSppbSelect.addEventListener("change", function () {
            if (mode === "LIHAT" && this.value) {
                if (typeof loadDetailSppbSingle === "function")
                    loadDetailSppbSingle();
            }
        });

    let jwInput = document.getElementById("jangka_waktu");
    if (jwInput) {
        jwInput.addEventListener("change", applyPembayaranFromJangkaWaktu);
        jwInput.addEventListener("blur", applyPembayaranFromJangkaWaktu);
    }

    function todayISO() {
        let d = new Date();
        let yyyy = d.getFullYear();
        let mm = String(d.getMonth() + 1).padStart(2, "0");
        let dd = String(d.getDate()).padStart(2, "0");
        return `${yyyy}-${mm}-${dd}`;
    }
    function ensureTodayDatesIfEmpty() {
        try {
            let today = todayISO();
            if (typeof tgl_sppb !== "undefined" && tgl_sppb && !tgl_sppb.value)
                tgl_sppb.value = today;
            if (
                typeof tgl_datang !== "undefined" &&
                tgl_datang &&
                !tgl_datang.value
            )
                tgl_datang.value = today;
        } catch (e) {
            console.error("Error setting today dates:", e);
        }
    }
    function applyPembayaranFromJangkaWaktu() {
        let jw = document.getElementById("jangka_waktu");
        let byr = document.getElementById("pembayaran");
        if (!jw || !byr) return;
        let n = parseInt(jw.value || "0", 10);
        if (isNaN(n)) {
            byr.value = "";
            return;
        }
        if (n === 0) byr.value = "TUNAI";
        else if (n > 0) byr.value = "KREDIT";
        else byr.value = "";
    }
    window.applyPembayaranFromJangkaWaktu = applyPembayaranFromJangkaWaktu;

    //#region initial loaders
    tgl_sppb.valueAsDate = new Date();
    loadMataUang();
    loadSupplier();
    applyMode();
    ensureTodayDatesIfEmpty();
    //#endregion

    function gatherPricePayload() {
        let row = getSelectedRowDataset();

        return {
            id_mata_uang: (mata_uang && mata_uang.value) || null,
            kurs: parseNumber((kurs && kurs.value) || 0),
            harga_satuan: parseNumber((hrg_murni && hrg_murni.value) || 0),
            disc_pct: parseNumber((disc && disc.value) || 0),
            ppn_pct: parseNumber((ppn && ppn.value) || 0),
            jenis: (jenis_pembelian && jenis_pembelian.value) || null,
            supplier_id: (supplier && supplier.value) || null,
            jangka_waktu: (jangka_waktu && jangka_waktu.value) || null,
            computed: totalHarga(),
        };
    }

    function getSelectedRowDataset() {
        return (
            document.querySelector(".row-select-isi:checked")?.dataset || null
        );
    }

    ppn.addEventListener("keydown", function (e) {
        if (e.key === "Enter") {
            e.preventDefault();
            totalHarga();
        }
    });

    hrg_murni.addEventListener("keydown", function (e) {
        if (e.key === "Enter") {
            e.preventDefault();
            disc.focus();
        }
    });

    disc.addEventListener("keydown", function (e) {
        if (e.key === "Enter") {
            e.preventDefault();
            ppn.focus();
        }
    });

    ppn.addEventListener("keydown", function (e) {
        if (e.key === "Enter") {
            e.preventDefault();
            jangka_waktu.focus();
        }
    });

    jangka_waktu.addEventListener("keydown", function (e) {
        if (e.key === "Enter") {
            e.preventDefault();
            btn_tambah_harga.focus();
        }
    });

    btn_tambah_harga.addEventListener("click", function (e) {
        e.preventDefault();

        let payload = gatherPricePayload();
        console.log(payload);

        if (!detailTable) {
            console.error("detailTable belum diinisialisasi");
            alert("Tabel belum siap.");
            return;
        }

        let $checked = $("#tbl_detail_order tbody .row-select-isi:checked");
        if (!$checked || $checked.length === 0) {
            alert("Pilih satu baris pada tabel sebelum menambah harga.");
            return;
        }

        let checkboxEl = $checked.get(0);
        let tr = checkboxEl.closest("tr");
        let row = detailTable.row(tr);
        let rowData = row.data();

        console.log("DEBUG - rowData (current):", rowData);

        let comp = payload.computed;
        if (!comp) {
            console.warn(
                "payload.computed undefined — pastikan totalHarga() mengembalikan object hasil perhitungan."
            );
            alert("Perhitungan belum tersedia. Periksa fungsi perhitungan.");
            return;
        }



        let ok = confirm(
            "Preview perhitungan ditampilkan di console.\nTekan OK untuk menerapkan ke baris yang dipilih, Cancel untuk membatalkan."
        );
        if (!ok) {
            console.log("Update dibatalkan user.");
            return;
        }

        //masuk dataTable
        let newRow = Array.isArray(rowData)
            ? rowData.slice()
            : Object.assign({}, rowData);

        let tgl_datang = payload.Tgl_dtg || 0;
        let hargaSatuanVal = payload.harga_satuan || 0;
        let discPctVal = payload.disc_pct || 0;
        let dppVal = comp.dppNilaiLain ?? comp.dppValue ?? 0;
        let ppnPctVal = payload.ppn_pct || 0;
        let totalVal = comp.totalHarga ?? comp.totalValue ?? 0;

        if (Array.isArray(newRow)) {
            newRow[10] = numeral(hargaSatuanVal).format("0,0.00");
            newRow[11] = discPctVal;
            newRow[12] = numeral(dppVal).format("0,0.00");
            newRow[13] = ppnPctVal;
            newRow[14] = numeral(totalVal).format("0,0.00");
        } else {
            newRow.harga_satuan = hargaSatuanVal;
            newRow.disc = discPctVal;
            newRow.dpp_nilai_lain = dppVal;
            newRow.ppn = ppnPctVal;
            newRow.total_harga = totalVal;
        }

        let $cb = $($checked.get(0));
        let wasChecked = $cb.prop("checked");

        row.data(newRow).draw(false);

        try {
            let node = row.node();
            let $newCb = $(node).find(".row-select-isi").first();
            if ($newCb && $newCb.length) {
                $newCb.prop("checked", wasChecked);
                $newCb.attr("data-tgl-datang", String(tgl_datang));
                $newCb.attr("data-hrg-murni", String(hargaSatuanVal));
                $newCb.attr("data-disc", String(discPctVal));
                $newCb.attr("data-dpp-nilai-lain", String(dppVal));
                $newCb.attr("data-ppn", String(ppnPctVal));
                $newCb.attr("data-total-harga", String(totalVal));
            }
        } catch (err) {
            console.warn("Gagal re-apply checkbox state:", err);
        }

    });

    btn_proses.addEventListener("click", function (e) {
        e.preventDefault();
    });



    // end jQuery init
});
