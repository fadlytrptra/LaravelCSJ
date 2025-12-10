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
    let harga_ppn = document.getElementById("harga_ppn");
    let subtotal_harga_jual = document.getElementById("subtotal_harga_jual");
    let jangka_waktu = document.getElementById("jangka_waktu");
    let total_harga = document.getElementById("total_harga");
    let pembayaran = document.getElementById("pembayaran");
    let supplier = document.getElementById("supplier");
    let jenis_pembelian = document.getElementById("jenis_pembelian");
    let alasan_hapus = document.getElementById("alasan_hapus");
    let no_sppb = document.getElementById("no_sppb");
    let kd_div = document.getElementById("kd_div");
    //#endregion

    //#region Utility functions
    function safeText(v) {
        return v === null || typeof v === "undefined" ? "" : String(v);
    }

    function parseNumber(v) {
        if (typeof v === "number") return isFinite(v) ? v : 0;
        if (!v && v !== 0) return 0;
        const s = (v || "").toString().replace(/,/g, "").trim();
        const n = parseFloat(s);
        return isFinite(n) ? n : 0;
    }

    function formatNumber(v, decimals = 4) {
        if (!isFinite(v)) return "";
        return Number(v).toFixed(decimals);
    }

    // clear form + table
    function clearDetailSppb() {
        if (tgl_sppb) tgl_sppb.value = "";
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
        if (harga_ppn) harga_ppn.value = "";
        if (subtotal_harga_jual) subtotal_harga_jual.value = "";
        if (jangka_waktu) jangka_waktu.value = "";
        if (total_harga) total_harga.value = "";
        if (pembayaran) pembayaran.value = "";

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
                no_sppb.disabled = true;
            }
        }

        if (detailTable) detailTable.clear().draw();
    }
    //#endregion

    //#region Data loaders (AJAX)
    function loadNoSppbByDivisi() {
        const noSppbEl = document.getElementById("no_sppb");
        const kdDivEl = document.getElementById("kd_div");

        if (!noSppbEl || !kdDivEl) {
            console.error("Element no_sppb atau kd_div tidak ditemukan");
            return Promise.reject(new Error("missing elements"));
        }

        const kdDiv = (kdDivEl.value || "").trim();
        noSppbEl.innerHTML = '<option value="">-- Pilih No SPPB --</option>';
        noSppbEl.disabled = true;

        if (!kdDiv) return Promise.resolve([]);

        const url =
            "/PurchaseOrder/no-sppb?kd_div=" + encodeURIComponent(kdDiv);
        return fetch(url)
            .then((res) => {
                const ct = (
                    res.headers.get("content-type") || ""
                ).toLowerCase();
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
                        const val =
                            item.No_sppb ??
                            item.NoSPPB ??
                            item.no_sppb ??
                            item.noSPPB ??
                            "";
                        if (!val) return;
                        const opt = document.createElement("option");
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
        const kdDivEl = document.getElementById("kd_div");
        const noSppbEl = document.getElementById("no_sppb");
        if (!kdDivEl || !noSppbEl) {
            console.error("Element kd_div atau no_sppb tidak ditemukan.");
            return;
        }

        const kdDiv = (kdDivEl.value || "").trim();
        const noSppb = (noSppbEl.value || "").trim();

        if (!kdDiv) {
            alert("Silakan pilih Nama Divisi terlebih dahulu.");
            return;
        }
        if (!noSppb) {
            alert("Silakan pilih No SPPB.");
            return;
        }

        if (typeof clearDetailSppb === "function") clearDetailSppb();
        noSppbEl.disabled = true;

        const url =
            "/PurchaseOrder/detail-sppb?kd_div=" +
            encodeURIComponent(kdDiv) +
            "&no_sppb=" +
            encodeURIComponent(noSppb);
        fetch(url)
            .then((res) => {
                const ct = (
                    res.headers.get("content-type") || ""
                ).toLowerCase();
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

                const row = data[0] || {};
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
                        const qtyVal = item.Qty ?? item.qty ?? "";
                        const tglOrder = item.Tgl_order ?? item.TglOrder ?? "";
                        const tglDtg = item.Tgl_dtg ?? item.TglDtg ?? "";
                        const noTrans = item.No_trans ?? item.NoTrans ?? "";
                        const hrgMurni =
                            item.hrg_murni ??
                            item.Hrg_trm ??
                            item.PriceUnit ??
                            0;
                        const discVal =
                            item.Disc_trm ?? item.hrg_disc ?? item.Disc ?? 0;
                        const dpp =
                            item.dpp_nilai_lain ?? item.DppNilaiLain ?? 0;
                        const ppnVal =
                            item.Ppn_trm ?? item.hrg_ppn ?? item.PPN ?? 0;
                        const total = item.hrg_nego_rp ?? item.TotalHarga ?? 0;

                        const checkboxHtml = `
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

    function loadDataByDivisiIsi() {
        const kdDiv = (
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
                const ct = (
                    res.headers.get("content-type") || ""
                ).toLowerCase();
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
                        const checkboxHtml = `
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
                            data-satuan="${safeText(
                                item.Nama_satuan ?? ""
                            )}"
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
        const sel = mata_uang;
        fetch("/PurchaseOrder/mata-uang")
            .then((res) => res.json())
            .then((data) => {
                sel.innerHTML = '<option value="">Pilih Mata Uang</option>';
                (data || []).forEach((row) => {
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
        sel.innerHTML =
            '<option value="" disabled selected>Pilih Supplier</option>';
        fetch("/PurchaseOrder/supplier")
            .then((res) => res.text())
            .then((text) => {
                try {
                    const data = JSON.parse(text);
                    if (!Array.isArray(data) || data.length === 0) {
                        sel.innerHTML =
                            '<option value="" disabled>(tidak ada supplier)</option>';
                        sel.disabled = true;
                        return;
                    }
                    sel.innerHTML =
                        '<option value="" disabled selected>Pilih Supplier</option>';
                    data.forEach((row) => {
                        const noSup =
                            row.No_sup ??
                            row.NO_SUP ??
                            row.NoSup ??
                            row.IdSup ??
                            row.Id_Sup ??
                            row.no_sup ??
                            "";
                        const nama = (
                            row.NM_SUP ??
                            row.nm_sup ??
                            row.nama ??
                            row.name ??
                            ""
                        )
                            .toString()
                            .trim();
                        const value = noSup || row.IdSup || nama || "";
                        const opt = document.createElement("option");
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
        const isIsi = mode === "ISI";
        const isLihat = mode === "LIHAT";
        const isNoMode = !isIsi && !isLihat;

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

        const btnIsi = document.getElementById("btn-isi");
        const btnLihat = document.getElementById("btn-lihat");
        const btnExitCancel = document.getElementById("btn-exit-cancel");

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
            if (typeof clearDetailSppb === "function") clearDetailSppb();
        }
    }

    function setMode(newMode) {
        mode =
            typeof newMode === "undefined" || newMode === null ? "" : newMode;
        if (typeof clearDetailSppb === "function") clearDetailSppb();
        applyMode();
    }
    //#endregion

    //#region Mata Uang behavior
    function initMataUangBehavior() {
        if (!mata_uang) return;
        function selectedIsRupiah() {
            const idx = mata_uang.selectedIndex;
            if (idx < 0) return false;
            const txt = (mata_uang.options[idx].text || "")
                .toLowerCase()
                .trim();
            return txt.includes("rupiah");
        }
        mata_uang.addEventListener("change", function () {
            if (selectedIsRupiah()) {
                if (kurs) {
                    kurs.value = "1";
                    kurs.disabled = true;
                }
                if (hrg_murni) hrg_murni.focus();
            } else {
                if (kurs) {
                    const current = parseFloat(kurs.value || "0");
                    if (!isFinite(current) || current === 0) kurs.value = "0";
                    kurs.disabled = false;
                    kurs.focus();
                } else if (hrg_murni) hrg_murni.blur();
            }
        });
        if (kurs && hrg_murni) {
            kurs.addEventListener("blur", function () {
                const v = parseFloat(kurs.value || "0");
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
    //#endregion

    //#region DataTable init and row select handling
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
                    if (harga_ppn) harga_ppn.value = "";
                    if (subtotal_harga_jual) subtotal_harga_jual.value = "";
                    if (total_harga) total_harga.value = "";
                    if (satuan) satuan.value = "";
                    return;
                }

                const d = this.dataset;
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
                if (d.hargappn && harga_ppn) harga_ppn.value = d.hargappn || "";
                if (satuan) satuan.value = d.satuan;
            }
        );
    }
    //#endregion

    //#region Buttons, mode switches
    const btnIsi = document.getElementById("btn-isi");
    const btnLihat = document.getElementById("btn-lihat");
    const btnExitCancel = document.getElementById("btn-exit-cancel");

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
            const t = ev.target;
            if (!(t instanceof Element)) return;
            const btn =
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
                const targetUrl = btn.dataset.href;
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

    const noSppbSelect = document.getElementById("no_sppb");
    if (noSppbSelect)
        noSppbSelect.addEventListener("change", function () {
            if (mode === "LIHAT" && this.value) {
                if (typeof loadDetailSppbSingle === "function")
                    loadDetailSppbSingle();
            }
        });

    const jwInput = document.getElementById("jangka_waktu");
    if (jwInput) {
        jwInput.addEventListener("change", applyPembayaranFromJangkaWaktu);
        jwInput.addEventListener("blur", applyPembayaranFromJangkaWaktu);
    }

    function todayISO() {
        const d = new Date();
        const yyyy = d.getFullYear();
        const mm = String(d.getMonth() + 1).padStart(2, "0");
        const dd = String(d.getDate()).padStart(2, "0");
        return `${yyyy}-${mm}-${dd}`;
    }
    function ensureTodayDatesIfEmpty() {
        try {
            const today = todayISO();
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
        const jw = document.getElementById("jangka_waktu");
        const byr = document.getElementById("pembayaran");
        if (!jw || !byr) return;
        const n = parseInt(jw.value || "0", 10);
        if (isNaN(n)) {
            byr.value = "";
            return;
        }
        if (n === 0) byr.value = "KREDIT";
        else if (n > 0) byr.value = "TRANSFER";
        else byr.value = "";
    }
    window.applyPembayaranFromJangkaWaktu = applyPembayaranFromJangkaWaktu;

    // initial loaders
    loadMataUang();
    loadSupplier();
    applyMode();
    ensureTodayDatesIfEmpty();
    //#endregion

    //#region Tambah Harga -> insert to DataTable and send to server (YTRANSBL)
    function gatherPricePayload() {
        const row = getSelectedRowDataset();

        return {
            no_trans: (no_trans && no_trans.value) || null,
            kd_brg: (kd_brg && kd_brg.value) || null,
            nama_brg: (nama_brg && nama_brg.value) || null,
            ket_brg: (ket_brg && ket_brg.value) || null,
            kat_utama: (kat_utama && kat_utama.value) || null,
            kategori: (kategori && kategori.value) || null,
            sub_kategori: (sub_kategori && sub_kategori.value) || null,
            satuan: (satuan && satuan.value) || null,
            no_satuan: (satuan && satuan.value) || null,
            qty: parseNumber((qty && qty.value) || 0),
            id_mata_uang: (mata_uang && mata_uang.value) || null,
            kurs: parseNumber((kurs && kurs.value) || 0),
            harga_satuan: parseNumber((hrg_murni && hrg_murni.value) || 0),
            disc_pct: parseNumber((disc && disc.value) || 0),
            ppn_pct: parseNumber((ppn && ppn.value) || 0),
            jenis: (jenis_pembelian && jenis_pembelian.value) || null,
            supplier_id: (supplier && supplier.value) || null,
            tgl_sppb:
                tgl_sppb && tgl_sppb.value
                    ? new Date(tgl_sppb.value).toISOString().slice(0, 10)
                    : null,
            tgl_datang:
                tgl_datang && tgl_datang.value
                    ? new Date(tgl_datang.value).toISOString().slice(0, 10)
                    : null,
            jangka_waktu: (jangka_waktu && jangka_waktu.value) || null,
            computed: computePrices(),
        };
    }

    function validatePayloadForServer(p) {
        const errors = [];
        if (!p.kd_brg) errors.push("Kode barang kosong");
        if (!isFinite(p.harga_satuan) || p.harga_satuan <= 0)
            errors.push("Harga Satuan harus > 0");
        if (!isFinite(p.qty) || p.qty <= 0) errors.push("Qty harus > 0");
        if (!p.supplier_id) errors.push("Supplier harus dipilih");
        if (!p.no_satuan) errors.push("Satuan (kode) harus tersedia");
        return errors;
    }

    function getSelectedRowDataset() {
        return (
            document.querySelector(".row-select-isi:checked")?.dataset || null
        );
    }

    let btn_tambah_harga = document.getElementById("btn_tambah_harga");

    btn_tambah_harga.addEventListener("click", function (e) {
        e.preventDefault();
        const payload = gatherPricePayload();
        const errs = validatePayloadForServer(payload);
        if (errs.length) {
            alert("Perbaiki input:\n- " + errs.join("\n- "));
            return;
        }

        // optimistic add to DataTable
        // let addedRow = null;
        // console.log(detailTable);

        // if (detailTable) {
        //     const checkboxHtml = `<input type="checkbox" class="row-select-isi" data-no-trans="${safeText(
        //         payload.no_trans
        //     )}" />`;
        //     console.log(checkboxHtml);

        //     addedRow = detailTable.row
        //         .add([
        //             checkboxHtml,
        //             "", // Tgl_order
        //             payload.qty,
        //             "",
        //             "",
        //             "",
        //             payload.no_trans || "",
        //             payload.tgl_datang || "",
        //             "",
        //             "",
        //             payload.harga_satuan,
        //             payload.disc_pct,
        //             payload.computed.dppNilaiLain,
        //             payload.ppn_pct,
        //             payload.computed.totalHarga,
        //         ])
        //         .draw(false)
        //         .node();
        //     if (addedRow) addedRow.dataset.clientAdded = "1";
        // }
    });
    //#endregion

    // end jQuery init
});
