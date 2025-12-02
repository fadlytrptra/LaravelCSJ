let nomor_purchaseOrder = document.getElementById("nomor_purchaseOrder");
let supplier_select = document.getElementById("supplier_select");
let matauang_select = document.getElementById("matauang_select");
let paymentTerm_select = document.getElementById("paymentTerm_select");
let btn_post = document.getElementById("btn_post");

let csrfToken = $('meta[name="csrf-token"]').attr("content");

let tanggal_mohonKirim = document.getElementById("tanggal_mohonKirim");
let tanggal_purchaseOrder = document.getElementById("tanggal_purchaseOrder");

tanggal_purchaseOrder.valueAsDate = new Date();
tanggal_mohonKirim.valueAsDate = new Date();

function LoadPermohonan(data) {
    $("#table_CreatePurchaseOrder").DataTable().destroy();
    let table = $("#table_CreatePurchaseOrder").DataTable({
        processing: true,
        responsive: true,
        scrollX: true,
        searching: false,
        scrollY: "auto",
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
                data: "nama_sub_kategori",
            },
            {
                data: "keterangan",
            },
            {
                data: "Ket_Internal",
            },
            {
                data: "NmUser",
            },
            {
                data: "Qty",
                render: function (data) {
                    return numeral(parseFloat(data)).format("0.00");
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
                data: "Kurs",
                render: function (data) {
                    return numeral(parseFloat(data)).format("0.0000");
                },
            },
            {
                data: "PriceUnitIDR",
                render: function (data) {
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
                data: "DiscHarga",
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
    });
}

btn_post.addEventListener("click", function (event) {
    if (loadPermohonanData.length == 0) {
        alert("Data Yang Akan Dipost Tidak Ada");
    } else {
        for (let i = 0; i < loadPermohonanData.length; i++) {
            $.ajax({
                url: "/OpenReviewPO/Print",
                type: "PUT",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
                data: {
                    NoPO: nomor_purchaseOrder.value.trim(),
                    tglPO: tanggal_purchaseOrder.value,
                    Tgl_Dibutuhkan: tanggal_mohonKirim.value,
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
                    <td><p style="line-height: 13.8px; font-size: 12px;font-family: Helvetica;padding-right:8px">
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
                                  "en-US"
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
                                  "en-US"
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
                                <th style="text-align: center;"><h1 style="font-size: 13px;font-family: Helvetica; font-weight: bold; line-height: 13.8px">Unit Price<br> ${
                                    data.printHeader[0].Id_MataUang_BC
                                }</h1></th>
                                <th style="text-align: center;"><h1 style="font-size: 13px;font-family: Helvetica; font-weight: bold; line-height: 13.8px">Disc.<br> ${
                                    data.printHeader[0].Id_MataUang_BC
                                }</h1></th>
                                <th style="text-align: center;"><h1 style="font-size: 13px;font-family: Helvetica; font-weight: bold; line-height: 13.8px">Amount<br> ${
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
    const printWindow = window.open("", "_blank");
    const style = document.createElement("style");
    style.textContent = `
    body {
        margin: 0;
        padding: 0;
    }
    `;
    window.location.href = "/PurchaseOrder";
    printWindow.document.head.appendChild(style);
    printWindow.document.body.appendChild(printContentDiv);
    printWindow.print();
}

$(document).ready(function () {
    LoadPermohonan(loadPermohonanData);
    supplier_select.value = loadHeaderData[0].NM_SUP;
    paymentTerm_select.value = loadHeaderData[0].Pembayaran;
    matauang_select.value = loadHeaderData[0].Curr;
    tanggal_mohonKirim.value = loadHeaderData[0].Est_Date.split(" ")[0];
    tanggal_purchaseOrder.value = loadHeaderData[0].Tgl_sppb.split(" ")[0];
});
