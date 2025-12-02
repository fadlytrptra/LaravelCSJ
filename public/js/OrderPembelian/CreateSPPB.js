$(document).ready(function () {
    //#region Variable
    let alasan_reject = document.getElementById("alasan_reject");
    let btn_post = document.getElementById("btn_post");
    let btn_reject = document.getElementById("btn_reject");
    let btn_remove = document.getElementById("btn_remove");
    let btn_update = document.getElementById("btn_update");
    let csrfToken = $('meta[name="csrf-token"]').attr("content");
    let disc = document.getElementById("disc");
    let dpp_nilaiLain = document.getElementById("dpp_nilaiLain");
    let fixValueQTYOrder;
    let formIsi = document.getElementById("formIsi");
    let harga_sub_total = document.getElementById("harga_sub_total");
    let harga_total = document.getElementById("harga_total");
    let harga_unit = document.getElementById("harga_unit");
    let idr_dpp = document.getElementById("idr_dpp");
    let idr_harga_total = document.getElementById("idr_harga_total");
    let idr_ppn = document.getElementById("idr_ppn");
    let idr_sub_total = document.getElementById("idr_sub_total");
    let idr_total_disc = document.getElementById("idr_total_disc");
    let idr_unit = document.getElementById("idr_unit");
    let jenisSupplier;
    let keterangan_internal = document.getElementById("keterangan_internal");
    let keterangan_order = document.getElementById("keterangan_order");
    let kode_barang = document.getElementById("kode_barang");
    let kurs = document.getElementById("kurs");
    let label_idr_harga_total = document.getElementById("label_idr_harga_total"); // prettier-ignore
    let label_idr_ppn = document.getElementById("label_idr_ppn");
    let label_idr_sub_total = document.getElementById("label_idr_sub_total");
    let label_idr_unit = document.getElementById("label_idr_unit");
    let matauang_select = document.getElementById("matauang_select");
    let nama_barang = document.getElementById("nama_barang");
    let no_po = document.getElementById("no_po");
    let nomor_purchaseOrder = document.getElementById("nomor_purchaseOrder");
    let paymentTerm_select = document.getElementById("paymentTerm_select");
    let ppn = document.getElementById("ppn");
    let ppn_select = document.getElementById("ppn_select");
    let qty_delay = document.getElementById("qty_delay");
    let qty_order = document.getElementById("qty_order");
    let sub_kategori = document.getElementById("sub_kategori");
    let supplier_select = document.getElementById("supplier_select");
    let table_CreatePurchaseOrder = document.getElementById("table_CreatePurchaseOrder"); // prettier-ignore
    let tanggal_dibutuhkan = document.getElementById("tanggal_dibutuhkan");
    let tanggal_mohonKirim = document.getElementById("tanggal_mohonKirim");
    let tanggal_purchaseOrder = document.getElementById("tanggal_purchaseOrder"); // prettier-ignore
    let total_disc = document.getElementById("total_disc");

    //#endregion
    //#region Load Form
    LoadPermohonan(loadPermohonanData);
    tanggal_purchaseOrder.valueAsDate = new Date();
    tanggal_mohonKirim.valueAsDate = new Date();
    btn_update.disabled = true;
    btn_remove.disabled = true;
    btn_reject.disabled = true;
    btn_post.disabled = true;
    $("#matauang_select").val(loadPermohonanData[0].ID_MATAUANG);

    $("#supplier_select option").each(function () {
        if ($(this).text() === loadPermohonanData[0].NM_SUP) {
            $("#supplier_select").val($(this).val());
            return false;
        }
    });

    setInputFilter(
        document.getElementById("qty_delay"),
        function (value) {
            var numericValue = parseFloat(value);
            return (
                value === "" ||
                (!isNaN(numericValue) &&
                    numericValue >= 0 &&
                    numericValue <= fixValueQTYOrder)
            );
        },
        "Tidak boleh ketik karakter dan angka di bawah 0, harus angka di atas 0 dan tidak boleh lebih dari angka awal."
    );
    // console.log(loadPermohonanData);
    // console.log(loadHeaderData);
    //#endregion
    //#region Function

    function clearData() {
        tanggal_purchaseOrder.valueAsDate = new Date();
        tanggal_mohonKirim.valueAsDate = new Date();
        no_po.value = "";
        kode_barang.value = "";
        nama_barang.value = "";
        sub_kategori.value = "";
        keterangan_order.value = "-";
        keterangan_internal.value = "-";
        qty_delay.value = 0;
        qty_order.value = 0;
        harga_unit.value = 0;
        idr_unit.value = 0;
        harga_sub_total.value = 0;
        idr_sub_total.value = 0;
        dpp_nilaiLain.value = 0;
        idr_dpp.value = 0;
        ppn_select.value = "";
        ppn.value = 0;
        idr_ppn.value = 0;
        harga_total.value = "";
        idr_harga_total.value = "";
        kurs.value = 1;
        disc.value = 0;
        total_disc.value = 0;
        idr_total_disc.value = 0;
        btn_update.disabled = true;
        btn_remove.disabled = true;
        btn_reject.disabled = true;
        alasan_reject.value = "";
    }

    function submit(nomor, qtydelay) {
        $.ajax({
            url: "/openFormCreateSPPB/create/Submit",
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            data: {
                noTrans: nomor,
                QtyDelay: qtydelay,
            },
            success: function (response) {},
            error: function (error) {
                console.error("Error Send Data:", error);
            },
        });
    }

    function LoadPermohonan(data) {
        $("#table_CreatePurchaseOrder").DataTable().destroy();
        let table = $("#table_CreatePurchaseOrder").DataTable({
            responsive: true,
            scrollX: true,
            searching: false,
            scrollY: "300px",
            paging: false,
            data: data,
            columns: [
                {
                    data: "No_trans",
                },
                {
                    data: "Kd_brg",
                },
                {
                    data: "NAMA_BRG",
                    render: function (data) {
                        return data.replace(/</g, "&lt;");
                    },
                },
                {
                    data: "Qty",
                    render: function (data) {
                        return numeral(parseFloat(data)).format("0,0.00");
                    },
                },
                {
                    data: "Nama_satuan",
                },
                {
                    data: "QtyCancel",
                    render: function (data) {
                        return numeral(parseFloat(data)).format("0.00");
                    },
                },
                {
                    data: "PriceUnit",
                    render: function (data) {
                        return numeral(parseFloat(data)).format("0,0.0000");
                    },
                },
                {
                    data: "PriceSub",
                    render: function (data) {
                        return numeral(parseFloat(data)).format("0,0.0000");
                    },
                },
                {
                    data: "PriceDPP",
                    render: function (data) {
                        if (data === null) {
                            return numeral(0).format("0,0.0000");
                        }
                        return numeral(parseFloat(data)).format("0,0.0000");
                    },
                },
                {
                    data: "PPN",
                    render: function (data) {
                        return numeral(parseFloat(data)).format("0,0.0000");
                    },
                },
                {
                    data: "PriceExt",
                    render: function (data) {
                        return numeral(parseFloat(data)).format("0,0.0000");
                    },
                },
                {
                    data: "NmUser",
                },
                {
                    data: "nama_sub_kategori",
                },
                {
                    data: "keterangan",
                    render: function (data) {
                        return data == "-"
                            ? '<p style="text-align:center;font-size: 14px;">-</p>'
                            : data ||
                                  '<p style="text-align:center;font-size: 14px;">-</p>';
                    },
                },
                {
                    data: "Ket_Internal",
                    render: function (data) {
                        return data == "-"
                            ? '<p style="text-align:center;font-size: 14px;">-</p>'
                            : data ||
                                  '<p style="text-align:center;font-size: 14px;">-</p>';
                    },
                },
                {
                    data: "Kurs",
                    render: function (data) {
                        return numeral(parseFloat(data)).format("0.0000");
                    },
                },
                {
                    data: "PriceUnitIDR",
                    render: function (data) {
                        if (data === null) {
                            return numeral(0).format("0,0.0000");
                        }
                        return numeral(parseFloat(data)).format("0,0.0000");
                    },
                },
                {
                    data: "PriceSubIDR",
                    render: function (data) {
                        return numeral(parseFloat(data)).format("0,0.0000");
                    },
                },
                {
                    data: "PriceDPP_IDR",
                    render: function (data) {
                        if (data === null) {
                            return numeral(0).format("0,0.0000");
                        }
                        return numeral(parseFloat(data)).format("0,0.0000");
                    },
                },
                {
                    data: "PriceUnitIDR_PPN",
                    render: function (data) {
                        return numeral(parseFloat(data)).format("0,0.0000");
                    },
                },
                {
                    data: "PriceExtIDR",
                    render: function (data) {
                        return numeral(parseFloat(data)).format("0,0.0000");
                    },
                },
                {
                    data: "Disc",
                    render: function (data) {
                        return numeral(parseFloat(data)).format("0.00");
                    },
                },
                {
                    data: "harga_disc",
                    render: function (data) {
                        return numeral(parseFloat(data)).format("0,0.0000");
                    },
                },
                {
                    data: "DiscIDR",
                    render: function (data) {
                        return numeral(parseFloat(data)).format("0,0.0000");
                    },
                },
            ],
            rowCallback: function (row, data) {
                $(row).on("dblclick", function (event) {
                    clearData();
                    // console.log(data);
                    no_po.value = data.No_trans;
                    kode_barang.value = data.Kd_brg;
                    nama_barang.value = data.NAMA_BRG;
                    sub_kategori.value = data.nama_sub_kategori;
                    qty_order.value = numeral(parseFloat(data.Qty)).format("0,0.00"); // prettier-ignore
                    keterangan_order.value = data.keterangan || "-";
                    keterangan_internal.value = data.Ket_Internal || "-";
                    qty_delay.value = parseFloat(data.QtyCancel).toFixed(4);
                    harga_unit.value = numeral(parseFloat(data.PriceUnit)).format("0,0.0000"); // prettier-ignore
                    idr_unit.value = numeral(parseFloat(data.PriceUnitIDR)).format("0,0.0000"); // prettier-ignore
                    harga_sub_total.value = numeral(parseFloat(data.PriceSub)).format("0,0.0000"); // prettier-ignore
                    idr_sub_total.value = numeral(parseFloat(data.PriceSubIDR)).format("0,0.0000"); // prettier-ignore
                    harga_total.value = numeral(parseFloat(data.PriceExt)).format("0,0.0000"); // prettier-ignore
                    idr_harga_total.value = numeral(parseFloat(data.PriceExtIDR)).format("0,0.0000"); // prettier-ignore
                    dpp_nilaiLain.value = numeral(parseFloat(data.PriceDPP)).format("0,0.0000"); // prettier-ignore
                    ppn.value = numeral(parseFloat(data.PPN)).format("0,0.0000"); // prettier-ignore
                    idr_dpp.value = numeral(parseFloat(data.PriceDPP_IDR)).format("0,0.0000"); // prettier-ignore
                    idr_ppn.value = numeral(parseFloat(data.PPN)).format("0,0.0000"); // prettier-ignore
                    disc.value = numeral(parseFloat(data.Disc)).format("0,0.0000"); // prettier-ignore
                    total_disc.value = numeral(parseFloat(data.harga_disc)).format("0,0.0000"); // prettier-ignore
                    idr_total_disc.value = numeral(parseFloat(data.DiscIDR)).format("0,0.0000"); // prettier-ignore
                    kurs.value = parseFloat(data.Kurs).toFixed(4);
                    $("#ppn_select").val(data.IdPPN);
                    fixValueQTYOrder = data.Qty;
                    btn_update.disabled = false;
                    btn_remove.disabled = false;

                    alasan_reject.addEventListener("input", function (event) {
                        if (alasan_reject.value.trim() !== "") {
                            btn_reject.disabled = false;
                        } else {
                            btn_reject.disabled = true;
                        }
                    });
                });
            },
        });
        table.on("dblclick", "tbody tr", (e) => {
            const classList = e.currentTarget.classList;

            if (classList.contains("selected")) {
                classList.remove("selected");
            } else {
                table
                    .rows(".selected")
                    .nodes()
                    .each((row) => row.classList.remove("selected"));
                classList.add("selected");
            }
        });
    }

    function dataPrint() {
        $.ajax({
            url: "/openFormCreateSPPB/create/Print",
            type: "GET",
            data: {
                noPO: nomor_purchaseOrder.value.trim(),
            },
            success: function (response) {
                print(response);
            },
            error: function (error) {
                console.error("Error Get Data:", error);
            },
        });
    }

    function print(data) {
        const printContentDiv = document.createElement("div");
        let tableRows = "";

        let sumAmount = 0;
        let ppn = 0;
        let No = 0;
        let Page = 0;
        let amountDPP = 0;
        let DPPFix = 0;

        for (let i = 0; i < data.print.length; i++) {
            sumAmount += parseFloat(data.print[i].PriceSub);
            ppn += parseFloat(data.print[i].PPN);
            amountDPP += parseFloat(data.print[i].PriceDPP);
        }

        const sumAmountFix = !sumAmount
            .toLocaleString("en-US", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            })
            .includes(".")
            ? sumAmount.toLocaleString("en-US", {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2,
              }) + ".00"
            : sumAmount.toLocaleString("en-US", {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2,
              });

        const ppnFix = !ppn
            .toLocaleString("en-US", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            })
            .includes(".")
            ? ppn.toLocaleString("en-US", {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2,
              }) + ".00"
            : ppn.toLocaleString("en-US", {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2,
              });

        DPPFix = !amountDPP
            .toLocaleString("en-US", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            })
            .includes(".")
            ? amountDPP.toLocaleString("en-US", {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2,
              }) + ".00"
            : amountDPP.toLocaleString("en-US", {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2,
              });

        const chunkSize = 5;
        const chunkedData = [];
        for (let i = 0; i < data.print.length; i += chunkSize) {
            chunkedData.push(data.print.slice(i, i + chunkSize));
        }

        chunkedData.forEach((chunk, chunkIndex) => {
            chunk.forEach((item, index) => {
                tableRows += `
                <tr>
                    <td style="text-align: center;vertical-align: top;"><p style="margin:0;font-size: 12px;font-family: Helvetica;">${
                        No + 1
                    }</p></td>
                    <td style="text-align: center;vertical-align: top;"><p style="margin:0;font-size: 12px;font-family: Helvetica;">${
                        item.Kd_brg
                    }</p></td>
                    <td><p style="line-height: 13.8px; font-size: 12px;font-family: Helvetica;">
                    ${item.NAMA_BRG.replace(/</g, "&lt;")}
                    <br>
                    ${item.keterangan || "-"}
                    <br>
                    ${item.nama_kategori}
                    <br>
                    ${item.nama_sub_kategori}
                    <br>
                    ${item.No_trans}</p>
                    </td>
                    <td style="text-align: center;vertical-align: top;"><p style="margin:0;font-size: 12px;font-family: Helvetica;">${
                        !parseFloat(item.Qty)
                            .toLocaleString("en-US")
                            .includes(".")
                            ? parseFloat(item.Qty).toLocaleString("en-US") +
                              ".00"
                            : parseFloat(item.Qty).toLocaleString("en-US")
                    }</p></td>
                    <td style="text-align: center;vertical-align: top;">
                    <p style="margin:0;font-size: 12px;font-family: Helvetica;">${item.Nama_satuan.trim()}</p>
                    </td>
                    <td style="text-align: center;vertical-align: top;"><p style="margin:0;font-size: 12px;font-family: Helvetica;">${
                        !parseFloat(item.PriceUnit)
                            .toLocaleString("en-US", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2,
                            })
                            .includes(".")
                            ? parseFloat(item.PriceUnit).toLocaleString(
                                  "en-US",
                                  {
                                      minimumFractionDigits: 2,
                                      maximumFractionDigits: 2,
                                  }
                              ) + ".00"
                            : parseFloat(item.PriceUnit).toLocaleString(
                                  "en-US",
                                  {
                                      minimumFractionDigits: 2,
                                      maximumFractionDigits: 2,
                                  }
                              )
                    }</p></td>
                    <td style="text-align: center;vertical-align: top;"><p style="margin:0;font-size: 12px;font-family: Helvetica;">${
                        !parseFloat(
                            item.harga_disc == null ? 0 : item.harga_disc
                        )
                            .toLocaleString("en-US", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2,
                            })
                            .includes(".")
                            ? parseFloat(
                                  item.harga_disc == null ? 0 : item.harga_disc
                              ).toLocaleString("en-US", {
                                  minimumFractionDigits: 2,
                                  maximumFractionDigits: 2,
                              }) + ".00"
                            : parseFloat(
                                  item.harga_disc == null ? 0 : item.harga_disc
                              ).toLocaleString("en-US", {
                                  minimumFractionDigits: 2,
                                  maximumFractionDigits: 2,
                              })
                    }
                    <br>
                    (${
                        !parseFloat(
                            item.disc == null ? 0 : item.disc
                        )
                            .toLocaleString("en-US", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2,
                            })
                            .includes(".")
                            ? parseFloat(
                                  item.disc == null ? 0 : item.disc
                              ).toLocaleString("en-US", {
                                  minimumFractionDigits: 2,
                                  maximumFractionDigits: 2,
                              }) + ".00"
                            : parseFloat(
                                  item.disc == null ? 0 : item.disc
                              ).toLocaleString("en-US", {
                                  minimumFractionDigits: 2,
                                  maximumFractionDigits: 2,
                              })
                    }%)</p></td>
                    <td style="text-align: right;vertical-align: top;"><p style="margin:0;font-size: 12px;font-family: Helvetica;">${
                        !parseFloat(item.PriceSub)
                            .toLocaleString("en-US", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2,
                            })
                            .includes(".")
                            ? parseFloat(item.PriceSub).toLocaleString(
                                  "en-US",
                                  {
                                      minimumFractionDigits: 2,
                                      maximumFractionDigits: 2,
                                  }
                              ) + ".00"
                            : parseFloat(item.PriceSub).toLocaleString(
                                  "en-US",
                                  {
                                      minimumFractionDigits: 2,
                                      maximumFractionDigits: 2,
                                  }
                              )
                    }</p></td>
                </tr>
            `;
                No += 1;
            });

            const print = `
        <div style="width: 20.5cm; height: 27.94cm; padding: 10px 10px 0px 10px; margin: 0; background: #FFFFFF; box-sizing: border-box; page-break-after: ${
            chunkIndex < chunkedData.length - 1 ? `always` : `avoid`
        };">
            <div style="width: 100%; height : 15%;">
            </div>
            <main style="width: 100%; height : 70%;">
                <div style="width: 100%; height: auto; display: flex;">
                    <div style="width: 50%; height: auto; margin-right: 20px;">
                        <h1 style="font-size: 13px;font-family: Helvetica; font-weight: bold; margin:2px 0 10px 0;">Issued To:</h1>
                        <p style="font-size: 13px;font-family: Helvetica; margin: 2px 0;">${
                            data.printHeader[0].NM_SUP
                        }</p>
                        <p style="font-size: 13px;font-family: Helvetica; margin: 2px 0;">${
                            data.printHeader[0].ALAMAT1
                        }</p>
                        <p style="font-size: 13px;font-family: Helvetica; margin: 2px 0;">${
                            data.printHeader[0].KOTA1
                        }</p>
                        <p style="font-size: 13px;font-family: Helvetica; margin: 2px 0;">${
                            data.printHeader[0].NEGARA1
                        }</p>
                        <br>
                        <h1 style="font-size: 13px;font-family: Helvetica; font-weight: bold; margin-top: 10px; margin-bottom: 2px;">Delivery To:</h1>
                        <p style="font-size: 13px;font-family: Helvetica; margin: 2px 0;">PT. Kerta Rajasa Raya</p>
                        <p style="font-size: 13px;font-family: Helvetica; margin: 2px 0;">Jl. Raya Tropodo No. 1</p>
                        <p style="font-size: 13px;font-family: Helvetica; margin: 2px 0;">Waru - Sidoarjo 61256 East Java, Indonesia</p>
                    </div>
                    <div style="width: 50%; height: auto; margin-left: 20px;">
                        <div style="width: 100%; display: flex;">
                            <div style="width: 30%; height: auto;">
                                <h1 style="font-size: 13px;font-family: Helvetica; font-weight: bold; margin: 2px 0;">Number</h1>
                            </div>
                            <div style="width: 70%; height: auto;">
                                <p style="font-size: 13px;font-family: Helvetica; margin: 2px 0;">: ${
                                    data.printHeader[0].NO_PO
                                }</p>
                            </div>
                        </div>
                        <div style="width: 100%; display: flex;">
                            <div style="width: 30%; height: auto;">
                                <h1 style="font-size: 13px;font-family: Helvetica; font-weight: bold; margin: 2px 0;">Date</h1>
                            </div>
                            <div style="width: 70%; height: auto;">
                                <p style="font-size: 13px;font-family: Helvetica; margin: 2px 0;">: ${
                                    data.printHeader[0].Tgl_sppb
                                }</p>
                            </div>
                        </div>
                        <div style="width: 100%; display: flex;">
                            <div style="width: 30%; height: auto;">
                                <h1 style="font-size: 13px;font-family: Helvetica; font-weight: bold; margin: 2px 0;">Delivery Date</h1>
                            </div>
                            <div style="width: 70%; height: auto;">
                                <p style="font-size: 13px;font-family: Helvetica; margin: 2px 0;">: ${
                                    data.printHeader[0].Est_Date
                                }</p>
                            </div>
                        </div>
                        <div style="width: 100%; display: flex;">
                            <div style="width: 30%; height: auto;">
                                <h1 style="font-size: 13px;font-family: Helvetica; font-weight: bold; margin: 2px 0;">Payment Term</h1>
                            </div>
                            <div style="width: 70%; height: auto;">
                                <p style="font-size: 13px;font-family: Helvetica; margin: 2px 0;">: ${
                                    data.printHeader[0].Pembayaran
                                }</p>
                            </div>
                        </div>
                        <div style="width: 100%; display: flex;">
                            <div style="width: 30%; height: auto;">
                                <h1 style="font-size: 13px;font-family: Helvetica; font-weight: bold; margin: 2px 0;">Divisi</h1>
                            </div>
                            <div style="width: 70%; height: auto;">
                                <div  style="font-size: 13px;font-family: Helvetica; margin: 2px 0; display:flex"><span>:</span> <p style="font-size: 13px;font-family: Helvetica; margin: 0 0 0 4px">${data.printHeader[0].Kd_div.trim()} - ${data.printHeader[0].NM_DIV.trim()}</p></div>
                            </div>
                        </div>
                        <div style="width: 100%; display: flex;">
                            <div style="width: 30%; height: auto;">
                                <h1 style="font-size: 13px;font-family: Helvetica; font-weight: bold; margin: 2px 0;">Requester</h1>
                            </div>
                            <div style="width: 70%; height: auto;">
                                <p style="font-size: 13px;font-family: Helvetica; margin: 2px 0;">: ${
                                    data.printHeader[0].Nama
                                }</p>
                            </div>
                        </div>
                        <div style="width: 100%; display: flex;">
                            <div style="width: 30%; height: auto;">
                                <h1 style="font-size: 13px;font-family: Helvetica; font-weight: bold; margin: 2px 0;">Page</h1>
                            </div>
                            <div style="width: 70%; height: auto;">
                                <p style="font-size: 13px;font-family: Helvetica; margin: 2px 0;">: Page ${
                                    Page + 1
                                } of ${chunkedData.length}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="details" style="margin-top: 20px;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th><h1 style="font-size: 13px;font-family: Helvetica; font-weight: bold; line-height: 13.8px">No.</h1></th>
                                <th style="text-align: center;"><h1 style="font-size: 13px;font-family: Helvetica; font-weight: bold; line-height: 13.8px">Item Number</h1></th>
                                <th style="text-align: center;"><h1 style="font-size: 13px;font-family: Helvetica; font-weight: bold; line-height: 13.8px">Description</h1></th>
                                <th style="text-align: center;"><h1 style="font-size: 13px;font-family: Helvetica; font-weight: bold; line-height: 13.8px">Qty</h1></th>
                                <th style="text-align: center;"><h1 style="font-size: 13px;font-family: Helvetica; font-weight: bold; line-height: 13.8px">Unit</h1></th>
                                <th style="text-align: center;"><h1 style="font-size: 13px;font-family: Helvetica; font-weight: bold; line-height: 13.8px">Unit Price ${
                                    data.printHeader[0].Id_MataUang_BC
                                }</h1></th>
                                <th style="text-align: center;"><h1 style="font-size: 13px;font-family: Helvetica; font-weight: bold; line-height: 13.8px">Disc. ${
                                    data.printHeader[0].Id_MataUang_BC
                                }</h1></th>
                                <th style="text-align: center;"><h1 style="font-size: 13px;font-family: Helvetica; font-weight: bold; line-height: 13.8px">Amount ${
                                    data.printHeader[0].Id_MataUang_BC
                                }</h1></th>
                            </tr>
                        </thead>
                        <tbody style="border-top: 1px solid black; border-bottom: 1px solid black;">
                            ${tableRows}
                        </tbody>
                    </table>
                </div>
                <div style="width: 100%; display: flex;">
                    <div style="width: 70%;">
                        <h1 style="font-size: 13px;font-family: Helvetica; font-weight: bold;margin-top:50px">Document Copy of ${
                            data.print[0].JumCetak
                        }</h1>
                    </div>
                    <div style="width: 30%;">
                        <div style="width: 100%; display: flex;">
                            <div style="width: 55%; margin-right: 10%;">
                                <h1 style="font-size: 13px;font-family: Helvetica; font-weight: bold; margin: 2px 0;">Sub Total</h1>
                            </div>
                            <div style="width: 60%; border-bottom: 1px solid; text-align: right;">
                                <p style="line-height: 13.8px; font-size: 13px;font-family: Helvetica; margin: 2px 0;">${sumAmountFix}</p>
                            </div>
                        </div>
                        <div style="width: 100%; display: flex;">
                            <div style="width: 55%; margin-right: 10%;">
                                <h1 style="font-size: 13px;font-family: Helvetica; font-weight: bold; margin: 2px 0;">DPP Nilai Lain</h1>
                            </div>
                            <div style="width: 60%; border-bottom: 1px solid; text-align: right;">
                                <p style="line-height: 13.8px; font-size: 13px;font-family: Helvetica; margin: 2px 0;">${DPPFix}</p>
                            </div>
                        </div>
                        <div style="width: 100%; display: flex;">
                            <div style="width: 55%; margin-right: 10%;">
                                <h1 style="font-size: 13px;font-family: Helvetica; font-weight: bold; margin: 2px 0;">VAT</h1>
                            </div>
                            <div style="width: 60%; border-bottom: 1px solid; text-align: right;">
                                <p style="line-height: 13.8px; font-size: 13px;font-family: Helvetica; margin: 2px 0;">${ppnFix}</p>
                            </div>
                        </div>
                        <div style="width: 100%; display: flex;">
                            <div style="width: 55%; margin-right: 10%;">
                                <h1 style="font-size: 13px;font-family: Helvetica; font-weight: bold; margin: 2px 0;">Total</h1>
                            </div>
                            <div style="width: 60%; border-bottom: 1px solid; text-align: right;">
                                <p style="line-height: 13.8px; font-size: 13px;font-family: Helvetica; margin: 2px 0;">${
                                    !(sumAmount + ppn)
                                        .toLocaleString("en-US", {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2,
                                        })
                                        .includes(".")
                                        ? (sumAmount + ppn).toLocaleString(
                                              "en-US",
                                              {
                                                  minimumFractionDigits: 2,
                                                  maximumFractionDigits: 2,
                                              }
                                          ) + ".00"
                                        : (sumAmount + ppn).toLocaleString(
                                              "en-US",
                                              {
                                                  minimumFractionDigits: 2,
                                                  maximumFractionDigits: 2,
                                              }
                                          )
                                }</p>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    `;

            printContentDiv.innerHTML += print;
            tableRows = "";
            Page += 1;
        });
        console.log(printContentDiv);
        const printWindow = window.open("", "_blank");
        const style = document.createElement("style");
        style.textContent = `
    body {
        margin: 0;
        padding: 0;
    }
    `;
        window.location.href = "/PurchaseOrder/create";
        printWindow.document.head.appendChild(style);
        printWindow.document.body.appendChild(printContentDiv);
        printWindow.print();
    }

    function updateIdrUnit() {
        let kurs = numeral(document.getElementById("kurs").value).value();
        let hargaUnit = numeral(
            document.getElementById("harga_unit").value
        ).value();
        if (!isNaN(kurs) && !isNaN(hargaUnit)) {
            let idrUnitValue = hargaUnit * kurs;
            idr_unit.value = numeral(idrUnitValue).format("0,0.0000");
        }
    }

    function updateSubTotal() {
        let qty_order = numeral(
            document.getElementById("qty_order").value
        ).value();
        let hargaUnit = numeral(
            document.getElementById("harga_unit").value
        ).value();
        let disc = numeral(document.getElementById("disc").value).value();
        if (!isNaN(qty_order) && !isNaN(hargaUnit) && !isNaN(disc)) {
            let SubTotalValue = hargaUnit * qty_order;
            let discount = (SubTotalValue * disc) / 100;
            let hargaSubTotal = SubTotalValue - discount;

            harga_sub_total.value = numeral(hargaSubTotal).format("0,0.0000");
        }
    }

    function updateIDRSubTotal() {
        let kurs = numeral(document.getElementById("kurs").value).value();
        let hargaSubTotal = numeral(
            document.getElementById("harga_sub_total").value
        ).value();

        if (!isNaN(kurs) && !isNaN(hargaSubTotal)) {
            let idrSubTotalValue = hargaSubTotal * kurs;
            idr_sub_total.value = numeral(idrSubTotalValue).format("0,0.0000");
        }
    }

    function updateSubTotalDisc() {
        let qty_order = numeral(
            document.getElementById("qty_order").value
        ).value();
        let hargaUnit = numeral(
            document.getElementById("harga_unit").value
        ).value();
        let total_disc = numeral(
            document.getElementById("total_disc").value
        ).value();
        if (!isNaN(qty_order) && !isNaN(hargaUnit) && !isNaN(total_disc)) {
            let SubTotalValue = hargaUnit * qty_order;
            let hargaSubTotal = SubTotalValue - total_disc;
            harga_sub_total.value = numeral(hargaSubTotal).format("0,0.0000");
        }
    }

    function updateDPPNilaiLain() {
        let harga_subTotal = numeral(harga_sub_total.value).value();
        let DPPValue = 0;
        if (!isNaN(harga_subTotal) && ppn_select.value == "15") {
            DPPValue = (harga_subTotal * 11) / 12;
            dpp_nilaiLain.value = numeral(DPPValue).format("0,0.0000");
        } else if (ppn_select.value == "18") {
            DPPValue = harga_subTotal / 10;
            dpp_nilaiLain.value = numeral(DPPValue).format("0,0.0000");
        } else if (ppn_select.value == "19") {
            DPPValue = harga_subTotal;
            dpp_nilaiLain.value = numeral(DPPValue).format("0,0.0000");
        } else if (ppn_select.value == "16" || ppn_select.value == "6") {
            dpp_nilaiLain.value = numeral(DPPValue).format("0,0.0000");
        } else {
            dpp_nilaiLain.value = numeral(harga_subTotal).format("0,0.0000");
        }
    }

    function updateIDRDPPNilaiLain() {
        let idr_hargaSubTotal = numeral(idr_sub_total.value).value();
        let IDRDPPValue = 0;
        if (!isNaN(idr_hargaSubTotal) && ppn_select.value == "15") {
            IDRDPPValue = (idr_hargaSubTotal * 11) / 12;
            idr_dpp.value = numeral(IDRDPPValue).format("0,0.0000");
        } else if (ppn_select.value == "18") {
            IDRDPPValue = idr_hargaSubTotal / 10;
            idr_dpp.value = numeral(IDRDPPValue).format("0,0.0000");
        } else if (ppn_select.value == "19") {
            IDRDPPValue = idr_hargaSubTotal;
            idr_dpp.value = numeral(IDRDPPValue).format("0,0.0000");
        } else if (ppn_select.value == "16" || ppn_select.value == "6") {
            idr_dpp.value = numeral(IDRDPPValue).format("0,0.0000");
        } else {
            idr_dpp.value = numeral(idr_hargaSubTotal).format("0,0.0000");
        }
    }

    function updatePPN() {
        let selectedOptionText = ppn_select.options[ppn_select.selectedIndex].text; // prettier-ignore
        let numericPart = selectedOptionText.split(" ")[0]; // Extract the numeric part
        let textPart = selectedOptionText.split(" (")[1]; // Extract the text part

        if (textPart) {
            textPart = textPart.replace(")", ""); // Remove the closing parenthesis
        }
        let selectedPPN = numeral(numericPart).value();
        let DPPValue = numeral(dpp_nilaiLain.value).value();

        if (!isNaN(selectedPPN) && !isNaN(DPPValue)) {
            if (ppn_select.value == "18") {
                //untuk ppn 1.2%
                selectedPPN = 12;
            }
            let jumPPN = (DPPValue * selectedPPN) / 100;
            ppn.value = numeral(jumPPN).format("0,0.0000");
        }
    }

    function updateIDRPPN() {
        let selectedOptionText =
            ppn_select.options[ppn_select.selectedIndex].text;
        let numericPart = selectedOptionText.split(" ")[0]; // Extract the numeric part
        let textPart = selectedOptionText.split(" (")[1]; // Extract the text part

        if (textPart) {
            textPart = textPart.replace(")", ""); // Remove the closing parenthesis
        }
        let selectedPPN = numeral(numericPart).value();
        let kurs = numeral(document.getElementById("kurs").value).value();
        let IDRDPPValue = numeral(idr_dpp.value).value();

        if (!isNaN(selectedPPN) && !isNaN(IDRDPPValue)) {
            if (ppn_select.value == "18") {
                //untuk ppn 1.2%
                selectedPPN = 12;
            }
            let jumPPN = (IDRDPPValue * selectedPPN) / 100;
            let idrPPNValue = jumPPN * kurs;
            idr_ppn.value = numeral(idrPPNValue).format("0,0.0000");
        }
    }

    function updateHargaTotal() {
        let ppn = numeral(document.getElementById("ppn").value).value();
        let hargaSubTotal = numeral(
            document.getElementById("harga_sub_total").value
        ).value();
        if (!isNaN(ppn) && !isNaN(hargaSubTotal)) {
            let hargaTotalValue = hargaSubTotal + ppn;
            harga_total.value = numeral(hargaTotalValue).format("0,0.0000");
        }
    }

    function updateIDRHargaTotal() {
        let kurs = numeral(document.getElementById("kurs").value).value();
        let hargaTotal = numeral(
            document.getElementById("harga_total").value
        ).value();
        if (!isNaN(kurs) && !isNaN(hargaTotal)) {
            let IDRHargaTotalValue = hargaTotal * kurs;
            idr_harga_total.value =
                numeral(IDRHargaTotalValue).format("0,0.0000");
        }
    }

    function updateDisc() {
        let qty_order = numeral(
            document.getElementById("qty_order").value
        ).value();
        let hargaUnit = numeral(
            document.getElementById("harga_unit").value
        ).value();
        let disc = numeral(document.getElementById("disc").value).value();
        if (!isNaN(hargaUnit) && !isNaN(qty_order) && !isNaN(disc)) {
            let SubTotalValue = hargaUnit * qty_order;
            let discount = (SubTotalValue * disc) / 100;
            total_disc.value = numeral(discount).format("0,0.0000");
        }
    }

    function updateTotalDisc() {
        let qty_order = numeral(
            document.getElementById("qty_order").value
        ).value();
        let hargaUnit = numeral(
            document.getElementById("harga_unit").value
        ).value();
        let total_disc = numeral(
            document.getElementById("total_disc").value
        ).value();
        if (!isNaN(hargaUnit) && !isNaN(qty_order) && !isNaN(total_disc)) {
            let SubTotalValue = hargaUnit * qty_order;
            let discount = (total_disc / SubTotalValue) * 100;
            disc.value = numeral(discount).format("0,0.00");
        }
    }

    function updateIDRDisc() {
        let qty_order = numeral(
            document.getElementById("qty_order").value
        ).value();
        let hargaUnit = numeral(
            document.getElementById("harga_unit").value
        ).value();
        let disc = numeral(document.getElementById("disc").value).value();
        let kurs = numeral(document.getElementById("kurs").value).value();

        if (
            !isNaN(hargaUnit) &&
            !isNaN(qty_order) &&
            !isNaN(disc) &&
            !isNaN(kurs)
        ) {
            let SubTotalValue = hargaUnit * qty_order;
            let discount = (SubTotalValue * disc) / 100;
            let totalIDRDiscValue = discount * kurs;
            idr_total_disc.value =
                numeral(totalIDRDiscValue).format("0,0.0000");
        }
    }

    function updateIDRDiscTotal() {
        let total_disc = numeral(
            document.getElementById("total_disc").value
        ).value();
        let kurs = numeral(document.getElementById("kurs").value).value();

        if (!isNaN(total_disc) && !isNaN(kurs)) {
            let totalIDRDiscValue = total_disc * kurs;
            idr_total_disc.value =
                numeral(totalIDRDiscValue).format("0,0.0000");
        }
    }
    //#endregion

    //#region Event Listener
    alasan_reject.addEventListener("change", function () {
        btn_reject.focus();
    });

    paymentTerm_select.addEventListener("change", function (event) {
        if (paymentTerm_select.selectedIndex !== 0) {
            btn_post.disabled = false;
        } else {
            btn_post.disabled = true;
        }
    });

    btn_update.addEventListener("click", function (event) {
        btn_update.disabled = true;
        const nomor = no_po.value;
        const qtydelay = numeral(qty_delay.value).value();
        console.log(qtydelay);

        if (
            qty_order.value == 0 &&
            (isNaN(parseFloat(disc.value)) || !isFinite(parseFloat(disc.value)))
        ) {
            alert(
                "Data Tidak Bisa DiUpdate Karena Qty Order = 0. Jika ingin Mengupdate Qty Order = 0 Maka Disc% Harus 0"
            );
        } else {
            $.ajax({
                url: "/openFormCreateSPPB/create/Update",
                type: "PUT",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
                data: {
                    No_PO: nomor_purchaseOrder.value,
                    Qty: numeral(qty_order.value).value(),
                    QtyCancel: numeral(qty_delay.value).value(),
                    kurs: kurs.value,
                    pUnit: numeral(harga_unit.value).value(),
                    pSub: numeral(harga_sub_total.value).value(),
                    pDPP: numeral(dpp_nilaiLain.value).value(),
                    pIDRDPP: numeral(idr_dpp.value).value(),
                    idPPN: ppn_select.value,
                    pPPN: numeral(ppn.value).value(),
                    pTot: numeral(harga_total.value).value(),
                    pIDRUnit: numeral(idr_unit.value).value(),
                    pIDRSub: numeral(idr_sub_total.value).value(),
                    pIDRPPN: numeral(idr_ppn.value).value(),
                    pIDRTot: numeral(idr_harga_total.value).value(),
                    persen: numeral(disc.value).value(),
                    disc: numeral(total_disc.value).value(),
                    discIDR: numeral(idr_total_disc.value).value(),
                    noTrans: no_po.value,
                },
                beforeSend: function () {
                    // Show loading screen
                    $("#loading-screen").css("display", "flex");
                },
                success: function (response) {
                    Swal.fire({
                        icon: "success",
                        title: "Data Berhasil DiUpdate!",
                        showConfirmButton: false,
                        timer: "2000",
                    });
                    if (qtydelay > 0) {
                        submit(nomor, qtydelay); //untuk bikin nomor order baru saat qty delay > 0
                    } else {
                    }
                    if (loadPermohonanData.length == 0) {
                        window.location.href = "/PurchaseOrder/create";
                    } else {
                        clearData();
                        loadPermohonanData = response.data;
                        LoadPermohonan(loadPermohonanData);
                    }
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
                complete: function () {
                    // Hide loading screen
                    $("#loading-screen").css("display", "none");
                },
            });
        }
    });

    btn_remove.addEventListener("click", function (event) {
        btn_remove.disabled = true;
        $.ajax({
            url: "/openFormCreateSPPB/create/Remove",
            type: "PUT",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            data: {
                noTrans: no_po.value,
            },
            beforeSend: function () {
                // Show loading screen
                $("#loading-screen").css("display", "flex");
            },
            success: function (response) {
                Swal.fire({
                    icon: "success",
                    title: "Data Berhasil DiRemove!",
                    showConfirmButton: false,
                    timer: "2000",
                });
                clearData();
                location.reload(true);
            },
            error: function (error) {
                Swal.fire({
                    icon: "error",
                    title: "Data Tidak Berhasil DiRemove!",
                    showConfirmButton: false,
                    timer: "2000",
                });
                console.error("Error Send Data:", error);
            },
            complete: function () {
                // Hide loading screen
                $("#loading-screen").css("display", "none");
            },
        });
    });

    btn_reject.addEventListener("click", function (event) {
        this.disabled = true;
        setTimeout(function () {
            this.disabled = false;
        }, 2500);
        $.ajax({
            url: "/openFormCreateSPPB/create/Reject",
            type: "PUT",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            data: {
                noTrans: no_po.value,
                alasan: alasan_reject.value,
            },
            beforeSend: function () {
                // Show loading screen
                $("#loading-screen").css("display", "flex");
            },
            success: function (response) {
                Swal.fire({
                    icon: "success",
                    title: "Data Berhasil DiReject!",
                    showConfirmButton: false,
                    timer: "2000",
                });
                let noOrder = no_po.value;
                let objekDitemukan = loadPermohonanData.filter(
                    (obj) => obj.No_trans !== noOrder
                );
                loadPermohonanData = objekDitemukan;
                if (loadPermohonanData.length == 0) {
                    window.location.href = "/PurchaseOrder/create";
                } else {
                    LoadPermohonan(loadPermohonanData);
                    clearData();
                }
            },
            error: function (error) {
                Swal.fire({
                    icon: "error",
                    title: "Data Tidak Berhasil DiReject!",
                    showConfirmButton: false,
                    timer: "2000",
                });
                console.error("Error Send Data:", error);
            },
            complete: function () {
                // Hide loading screen
                $("#loading-screen").css("display", "none");
            },
        });
    });

    btn_post.addEventListener("click", function (event) {
        this.disabled = true;
        setTimeout(function () {
            btn_post.disabled = false;
        }, 2500);
        if (loadPermohonanData.length == 0) {
            alert("Data Yang Akan Dipost Tidak Ada");
        } else {
            for (let i = 0; i < loadPermohonanData.length; i++) {
                $.ajax({
                    url: "/openFormCreateSPPB/create/Post",
                    type: "PUT",
                    headers: {
                        "X-CSRF-TOKEN": csrfToken,
                    },
                    data: {
                        noTrans: loadPermohonanData[i].No_trans,
                        mtUang: matauang_select.value,
                        tglPO: tanggal_purchaseOrder.value,
                        idpay: paymentTerm_select.value,
                        Tgl_Dibutuhkan: tanggal_mohonKirim.value,
                        idSup: supplier_select.value,
                    },
                    beforeSend: function () {
                        // Show loading screen
                        $("#loading-screen").css("display", "flex");
                    },
                    success: function (response) {
                        if (i == loadPermohonanData.length - 1) {
                            Swal.fire({
                                icon: "success",
                                title: "Data Berhasil DiPost!",
                                showConfirmButton: false,
                                timer: "2000",
                            });
                            dataPrint();
                        }
                    },
                    error: function (error) {
                        Swal.fire({
                            icon: "error",
                            title: "Data Tidak Berhasil DiPost!",
                            showConfirmButton: false,
                            timer: "2000",
                        });
                        console.error("Error Send Data:", error);
                    },
                    complete: function () {
                        // Hide loading screen
                        $("#loading-screen").css("display", "none");
                    },
                });
            }
        }
    });

    supplier_select.addEventListener("change", function (event) {
        if (supplier_select.selectedIndex !== 0) {
            $.ajax({
                url: "/openFormCreateSPPB/create/DaftarSupplier",
                type: "GET",
                data: {
                    idsup: supplier_select.value,
                },
                success: function (response) {
                    for (let i = 0; i < matauang_select.options.length; i++) {
                        if (
                            matauang_select.options[i].value.replace(
                                /\s/g,
                                ""
                            ) === response[0].Id_MataUang.replace(/\s/g, "")
                        ) {
                            matauang_select.selectedIndex = i;
                            console.log("aman");
                        }
                    }
                    jenisSupplier = response[0].JNS_SUP;
                },
                error: function (error) {
                    console.error("Error Send Data:", error);
                },
            });
        }
    });

    paymentTerm_select.addEventListener("change", function (event) {
        btn_post.focus();
    });

    qty_delay.addEventListener("input", function (event) {
        let qtyDelay = parseFloat(fixValueQTYOrder - qty_delay.value);

        if (qtyDelay <= fixValueQTYOrder && qtyDelay >= 0) {
            qty_order.value = parseFloat(qtyDelay.toFixed(2)).toLocaleString(
                "en-US",
                { minimumFractionDigits: 2, maximumFractionDigits: 2 }
            );
        }
        updateIdrUnit();
        // updateSubTotal();
        updateSubTotalDisc();
        updateIDRSubTotal();
        updateDPPNilaiLain();
        updateIDRDPPNilaiLain();
        updateIDRPPN();
        updatePPN();
        updateHargaTotal();
        updateIDRHargaTotal();
        // updateDisc();
        updateTotalDisc();
        updateIDRDiscTotal();
        // updateIDRDisc();
    });

    qty_order.addEventListener("input", function (event) {
        let qtyOrder = parseFloat(fixValueQTYOrder - qty_order.value);
        if (qtyOrder <= fixValueQTYOrder && qtyOrder >= 0) {
            qty_delay.value = parseFloat(qtyOrder.toFixed(2)).toLocaleString(
                "en-US",
                { minimumFractionDigits: 2, maximumFractionDigits: 2 }
            );
        }
        updateIdrUnit();
        // updateSubTotal();
        updateSubTotalDisc();
        updateIDRSubTotal();
        updateDPPNilaiLain();
        updateIDRDPPNilaiLain();
        updateIDRPPN();
        updatePPN();
        updateHargaTotal();
        updateIDRHargaTotal();
        // updateDisc();
        updateTotalDisc();
        updateIDRDiscTotal();
        // updateIDRDisc();
    });

    kurs.addEventListener("input", function (event) {
        setInputFilter(
            document.getElementById("kurs"),
            function (value) {
                return /^-?\d*[.,]?\d*$/.test(value);
            },
            "Tidak boleh character, harus angka"
        );
        updateIdrUnit();
        // updateSubTotal();
        updateSubTotalDisc();
        updateIDRSubTotal();
        updateDPPNilaiLain();
        updateIDRDPPNilaiLain();
        updateIDRPPN();
        updatePPN();
        updateHargaTotal();
        updateIDRHargaTotal();
        // updateIDRDisc();
        updateTotalDisc();
        updateIDRDiscTotal();
        // updateDisc();
    });

    harga_unit.addEventListener("input", function (event) {
        setInputFilter(
            document.getElementById("harga_unit"),
            function (value) {
                return /^-?\d*([.,]\d*)*$/.test(value);
            },
            "Tidak boleh character, harus angka"
        );
        updateIdrUnit();
        // updateSubTotal();
        updateSubTotalDisc();
        updateIDRSubTotal();
        updateDPPNilaiLain();
        updateIDRDPPNilaiLain();
        updateIDRPPN();
        updatePPN();
        updateHargaTotal();
        updateIDRHargaTotal();
        // updateDisc();
        updateTotalDisc();
        updateIDRDiscTotal();
        // updateIDRDisc();
    });

    ppn_select.addEventListener("change", function (event) {
        updateDPPNilaiLain();
        updateIDRDPPNilaiLain();
        updatePPN();
        updateIDRPPN();
        updateHargaTotal();
        updateIDRHargaTotal();
        btn_update.focus();
    });
    disc.addEventListener("input", function (event) {
        setInputFilter(
            document.getElementById("disc"),
            function (value) {
                return /^-?\d*([.,]\d*)*$/.test(value);
            },
            "Tidak boleh character, harus angka"
        );
        updateIdrUnit();
        updateSubTotal();
        updateIDRSubTotal();
        updateDPPNilaiLain();
        updateIDRDPPNilaiLain();
        updateIDRPPN();
        updatePPN();
        updateHargaTotal();
        updateIDRHargaTotal();
        updateDisc();
        updateIDRDisc();
    });
    total_disc.addEventListener("input", function (event) {
        setInputFilter(
            document.getElementById("total_disc"),
            function (value) {
                return /^-?\d*([.,]\d*)*$/.test(value);
            },
            "Tidak boleh character, harus angka"
        );
        updateIdrUnit();
        updateSubTotalDisc();
        updateIDRSubTotal();
        updateIDRPPN();
        updatePPN();
        updateHargaTotal();
        updateIDRHargaTotal();
        updateTotalDisc();
        updateIDRDiscTotal();
    });

    qty_order.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            // qty_order.value = parseFloat(qty_order.value).toFixed(2);
            let numeralValue = numeral(qty_order.value).value();
            this.value = numeral(numeralValue).format("0,0.00");
            qty_delay.focus();
            qty_delay.select();
        }
    });

    qty_delay.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            let numeralValue = numeral(qty_delay.value).value();
            this.value = numeral(numeralValue).format("0,0.00");
            kurs.focus();
            kurs.select();
        }
    });

    kurs.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            kurs.value = parseFloat(kurs.value).toFixed(4);
            disc.focus();
            disc.select();
        }
    });

    harga_unit.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            const data = numeral(harga_unit.value).value();
            harga_unit.value = numeral(data).format("0,0.0000");
            ppn_select.focus();
        }
    });

    disc.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            disc.value = numeral(disc.value).format("0,0.00");
            total_disc.focus();
            total_disc.select();
        }
    });

    total_disc.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            const data = numeral(total_disc.value).value();
            total_disc.value = numeral(data).format("0,0.0000");
            harga_unit.focus();
            harga_unit.select();
        }
    });
    //#endregion
});
