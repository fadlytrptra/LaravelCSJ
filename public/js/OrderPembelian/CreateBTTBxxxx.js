let supplier = document.getElementById("supplier");
let po = document.getElementById("po");
let nobttb = document.getElementById("nobttb");
let nosj = document.getElementById("nosj");
let sppb = document.getElementById("sppb");
let registrasi = document.getElementById("registrasi");
let tglbttb = document.getElementById("tglbttb");
let nopib = document.getElementById("nopib");
let tglsppb = document.getElementById("tglsppb");
let tglregis = document.getElementById("tglregis");
let nopibext = document.getElementById("nopibext");
let skbm = document.getElementById("skbm");
let kodehs = document.getElementById("kodehs");
let tglpib = document.getElementById("tglpib");
let tglskbm = document.getElementById("tglskbm");
let no_po = document.getElementById("no_po");
let kode_barang = document.getElementById("kode_barang");
let nama_barang = document.getElementById("nama_barang");
let sub_kategori = document.getElementById("sub_kategori");
let qty_ordered = document.getElementById("qty_ordered");
let qty_ship = document.getElementById("qty_ship");
let ordered_satuan = document.getElementById("ordered_satuan");
let qty_received = document.getElementById("qty_received");
let qty_remaining = document.getElementById("qty_remaining");
let kurs = document.getElementById("kurs");
let mata_uang = document.getElementById("mata_uang");
let disc = document.getElementById("disc");
let total_disc = document.getElementById("total_disc");
let idr_total_disc = document.getElementById("idr_total_disc");
let harga_unit = document.getElementById("harga_unit");
let idr_unit = document.getElementById("idr_unit");
let harga_sub_total = document.getElementById("harga_sub_total");
let idr_sub_total = document.getElementById("idr_sub_total");
let ppn_select = document.getElementById("ppn_select");
let ppn = document.getElementById("ppn");
let idr_ppn = document.getElementById("idr_ppn");
let harga_total = document.getElementById("harga_total");
let idr_harga_total = document.getElementById("idr_harga_total");

let post_btn = document.getElementById("post_btn");

let fixValueQTYOrder;
let fixValueQTYShip;
let fixValueQTYReceived;
let fixValueQTYRemain;

let csrfToken = $('meta[name="csrf-token"]').attr("content");
let tabelData = $("#tabelcreate").DataTable({
    responsive: true,
    scrollX: true,
    searching: false,
    scrollY: "200px",
    paging: false,
});
let data;

function clearOptions(selectElement) {
    let length = selectElement.options.length;

    for (let i = length - 1; i > 0; i--) {
        selectElement.remove(i);
    }
}

function clearHeader() {
    nobttb.value = "";
    nosj.value = "";
    sppb.value = "";
    registrasi.value = "";
    tglbttb.valueAsDate = new Date();
    nopib.value = "";
    tglsppb.valueAsDate = new Date();
    tglregis.valueAsDate = new Date();
    nopibext.value = "";
    skbm.value = "";
    kodehs.value = "";
    tglpib.valueAsDate = new Date();
    tglskbm.valueAsDate = new Date();
}

function clear() {
    no_po.value = "";
    kode_barang.value = "";
    nama_barang.value = "";
    sub_kategori.value = "";
    qty_ordered.value = "";
    ordered_satuan.value = "";
    qty_received.value = "";
    qty_remaining.value = "";
    kurs.value = "1";
    mata_uang.value = "IDR";
    disc.value = "0";
    total_disc.value = "0";
    idr_total_disc.value = "0";
    harga_unit.value = "0";
    idr_unit.value = "0";
    harga_sub_total.value = "0";
    idr_sub_total.value = "0";
    ppn_select.selectedIndex = 0;
    ppn.value = "0";
    idr_ppn.value = "0";
    harga_total.value = "";
    idr_harga_total.value = "";
    qty_ship.value = "";
}
function setStatusPO() {
    $.ajax({
        url: "/CCreateBTTB/SetStatusPO",
        type: "GET",
        data: {
            NoPO: po.value.trim(),
        },
        success: function (response) {
            console.log(response);
        },
        error: function (error) {
            console.error("Error Send Data:", error);
        },
    });
}

function post(bttb) {
    for (let i = 0; i < data.length; i++) {
        let noTrTmp = null;
        if (data[i].no_kat_utama == "009") {
            noTrTmp = 1;
        }
        $.ajax({
            url: "/CCreateBTTB/PostData",
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            data: {
                tglDatang: tglbttb.value,
                Qty: data[i].Qty,
                qtyShip: data[i].QtyShipped || 0,
                qtyRcv: data[i].QtyRcv || 0,
                qtyremain: data[i].QtyRemain || 0,
                NoSatuan: data[i].NoSatuan,
                SJ: nosj.value,
                idSup: supplier.value,
                pUnit: data[i].PriceUnit,
                pPPN: data[i].PPN,
                noTrans: data[i].No_trans,
                kurs: data[i].Kurs,
                pIDRUnit: data[i].PriceUnitIDR,
                pIDRPPN: data[i].PriceUnitIDR_PPN,
                NoPIB: nopib.value,
                NoPO: po.value.trim(),
                BTTB: bttb,
                pSub: data[i].PriceSub,
                pIDRSub: data[i].PriceSubIDR,
                pTot: data[i].PriceExt,
                pIDRTot: data[i].PriceExtIDR,
                NoPIBExt: nopibext.value,
                TglPIB: tglpib.value,
                NoSPPBBC: sppb.value,
                TglSPPBBC: tglsppb.value,
                NoSKBM: skbm.value,
                TglSKBM: tglskbm.value,
                NoReg: registrasi.value,
                TglReg: tglregis.value,
                idPPN: data[i].IdPPN,
                jumPPN: data[i].JumPPN,
                persen: data[i].disc,
                disc: data[i].Harga_disc,
                discIDR: data[i].DiscIDR,
                mtUang: data[i].ID_MATAUANG,
                KodeHS: kodehs.value,
                noTrTmp: noTrTmp,
            },
            beforeSend: function () {
                // Show loading screen
                $("#loading-screen").css("display", "flex");
            },
            success: function (response) {
                console.log(response);
                Swal.fire({
                    icon: "success",
                    title: "Data Berhasil DiPost!",
                    showConfirmButton: false,
                    timer: "2000",
                });
                if (i == data.length - 1) {
                    console.log("print");
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
function dataPrint() {
    $.ajax({
        url: "/CCreateBTTB/Print",
        type: "GET",
        data: {
            No_BTTB: nobttb.value,
        },
        success: function (response) {
            console.log(response);
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

    let No = 0;
    let Page = 0;

    const chunkSize = 5;
    const chunkedData = [];
    for (let i = 0; i < data.print.length; i += chunkSize) {
        chunkedData.push(data.print.slice(i, i + chunkSize));
    }

    chunkedData.forEach((chunk, chunkIndex) => {
        chunk.forEach((item, index) => {
            tableRows += `
                <tr>
                    <td sty><p style="line-height: 13.8px; font-size: 12px; text-align: center">${
                        No + 1
                    }</p></td>
                    <td style="text-align: center;"><p style="line-height: 13.8px; font-size: 12px;">${
                        item.Kd_brg
                    }</p></td>
                    <td><p style="line-height: 13.8px; font-size: 12px;">
                    ${item.NAMA_BRG}
                    </td>
                    <td style="text-align: center;"><p style="line-height: 13.8px; font-size: 12px;">${
                        !parseFloat(item.Qty)
                            .toLocaleString("en-US")
                            .includes(".")
                            ? parseFloat(item.Qty).toLocaleString("en-US") +
                              ".00"
                            : parseFloat(item.Qty).toLocaleString("en-US")
                    }</p></td>
                    <td style="text-align: center;"><p style="line-height: 13.8px; font-size: 12px;">${item.Nama_satuan.trim()}</p></td>
                    <td style="text-align: center;"><p style="line-height: 13.8px; font-size: 12px;">${
                        !parseFloat(item.Qty_Terima)
                            .toLocaleString("en-US")
                            .includes(".")
                            ? parseFloat(item.Qty_Terima).toLocaleString(
                                  "en-US"
                              ) + ".00"
                            : parseFloat(item.Qty_Terima).toLocaleString(
                                  "en-US"
                              )
                    }</p></td>
                    <td style="text-align: center;">
    <p style="line-height: 13.8px; font-size: 12px;">
        ${
            isNaN(parseFloat(item.QtyRemain)) ||
            parseFloat(item.QtyRemain) === 0
                ? "0.00"
                : parseFloat(item.QtyRemain).toLocaleString("en-US", {
                      minimumFractionDigits: 2,
                      maximumFractionDigits: 2,
                  })
        }
    </p>
</td>
                </tr>
            `;
            No += 1;
        });

        const print = `
        <style>
            table.styled-table {
                border-collapse: collapse;
                width: 100%;
                margin: 20px 0;
                font-size: 18px;
                text-align: left;
            }

            table.styled-table th,
            table.styled-table td {
                padding: 12px 15px;
            }

            table.styled-table thead tr {
                border-bottom: 2px solid #333;
            }

            table.styled-table tbody tr {
                border-bottom: none;
            }

            table.styled-table tbody tr:last-of-type {
                border-bottom: none;
            }

            table.styled-table tbody tr+tr {
                margin-top: 10px;
            }
        </style>
        <div style="width: 21.59cm; height: 27.94cm; padding: 0 0.5cm; margin: 0 auto; background: #FFFFFF; box-sizing: border-box; page-break-after: ${
            chunkIndex < chunkedData.length - 1 ? `always` : `avoid`
        };">
            <div style="width: 100%; height : 15%;">
            </div>
            <main style="width: 100%; height : 70%;">
                <div style="width: 100%; height: auto; display: flex;">
                    <div style="width: 50%; height: auto; margin-right: 20px;">
                        <h1 style="font-size: 12px; font-weight: bold; margin-top: 10px; margin-bottom: 5px;">PT. Kerta Rajasa Raya</h1>
                        <p style="font-size: 12px; margin: 2px 0;">Jl. Raya Tropodo No. 1</p>
                        <p style="font-size: 12px; margin: 2px 0;">Waru - Sidoarjo 61256 East Java, Indonesia</p>
                        <br>
                        <p style="font-size: 12px; margin: 2px 0;">${
                            data.printHeader[0].NM_SUP
                        }</p>
                        <p style="font-size: 12px; margin: 2px 0;">${
                            data.printHeader[0].ALAMAT1
                        }</p>
                        <p style="font-size: 12px; margin: 2px 0;">${
                            data.printHeader[0].KOTA1
                        }</p>
                        <p style="font-size: 12px; margin: 2px 0;">${
                            data.printHeader[0].NEGARA1
                        }</p>
                    </div>
                    <div style="width: 50%; height: auto; margin-left: 20px;">
                    <div style="width: 100%; display: flex;">
                            <div style="width: 30%; height: auto;">
                                <h1 style="font-size: 12px; font-weight: bold; margin: 2px 0;">Telephone</h1>
                            </div>
                            <div style="width: 70%; height: auto;">
                                <p style="font-size: 12px; margin: 2px 0;">: (031)8669595</p>
                            </div>
                        </div>
                        <div style="width: 100%; display: flex;">
                            <div style="width: 30%; height: auto;">
                                <h1 style="font-size: 12px; font-weight: bold; margin: 2px 0;">Fax</h1>
                            </div>
                            <div style="width: 70%; height: auto;">
                                <p style="font-size: 12px; margin: 2px 0;">: (031)8669989</p>
                            </div>
                        </div>
                        <div style="width: 100%; display: flex;">
                            <div style="width: 30%; height: auto;">
                                <h1 style="font-size: 12px; font-weight: bold; margin: 2px 0;">Giro</h1>
                            </div>
                            <div style="width: 70%; height: auto;">
                                <p style="font-size: 12px; margin: 2px 0;">: </p>
                            </div>
                        </div>
                        <div style="width: 100%; display: flex;">
                            <div style="width: 30%; height: auto;">
                                <h1 style="font-size: 12px; font-weight: bold; margin: 2px 0;">Tax Registration Number</h1>
                            </div>
                            <div style="width: 70%; height: auto;">
                                <p style="font-size: 12px; margin: 2px 0;">: 01.140.897.8-641.000</p>
                            </div>
                        </div>
                        <br>
                        <div style="width: 100%; display: flex;">
                            <div style="width: 30%; height: auto;">
                                <h1 style="font-size: 12px; font-weight: bold; margin: 2px 0;">Page</h1>
                            </div>
                            <div style="width: 70%; height: auto;">
                                <p style="font-size: 12px; margin: 2px 0;">: Page ${
                                    Page + 1
                                } of ${chunkedData.length}</p>
                            </div>
                        </div>
                        <div style="width: 100%; display: flex;">
                            <div style="width: 30%; height: auto;">
                                <h1 style="font-size: 12px; font-weight: bold; margin: 2px 0;">Number</h1>
                            </div>
                            <div style="width: 70%; height: auto;">
                                <p style="font-size: 12px; margin: 2px 0;">: ${
                                    data.printHeader[0].No_PO
                                }</p>
                            </div>
                        </div>
                        <div style="width: 100%; display: flex;">
                            <div style="width: 30%; height: auto;">
                                <h1 style="font-size: 12px; font-weight: bold; margin: 2px 0;">Date</h1>
                            </div>
                            <div style="width: 70%; height: auto;">
                                <p style="font-size: 12px; margin: 2px 0;">: ${
                                    data.printHeader[0].Datang.split(" ")[0]
                                }</p>
                            </div>
                        </div>
                        <div style="width: 100%; display: flex;">
                            <div style="width: 30%; height: auto;">
                                <h1 style="font-size: 12px; font-weight: bold; margin: 2px 0;">Packing Slip</h1>
                            </div>
                            <div style="width: 70%; height: auto;">
                                <p style="font-size: 12px; margin: 2px 0;">: ${
                                    data.printHeader[0].No_SuratJalan || ""
                                }</p>
                            </div>
                        </div>
                        <div style="width: 100%; display: flex;">
                            <div style="width: 30%; height: auto;">
                                <h1 style="font-size: 12px; font-weight: bold; margin: 2px 0;">Internal Product Receipt</h1>
                            </div>
                            <div style="width: 70%; height: auto;">
                                <p style="font-size: 12px; margin: 2px 0;">: ${
                                    data.printHeader[0].No_BTTB
                                }</p>
                            </div>
                        </div>
                        <br>
                        <h1 style="font-size: 12px; font-weight: bold; margin-top: 10px; margin-bottom: 5px;">Delivery To:</h1>
                        <p style="font-size: 12px; margin: 2px 0;">Jl. Raya Tropodo No. 1</p>
                        <p style="font-size: 12px; margin: 2px 0;">Waru - Sidoarjo 61256 East Java, Indonesia</p>
                    </div>
                </div>
                <div class="details" style="margin-top: 20px;">
                    <table style="width: 100%;">
                        <thead>
                            <tr>
                                <th><h1 style="font-size: 12px; font-weight: bold; line-height: 13.8px">No.</h1></th>
                                <th style="text-align: center;"><h1 style="font-size: 12px; font-weight: bold; line-height: 13.8px">Item Number</h1></th>
                                <th style="text-align: center;"><h1 style="font-size: 12px; font-weight: bold; line-height: 13.8px">Description</h1></th>
                                <th style="text-align: center;"><h1 style="font-size: 12px; font-weight: bold; line-height: 13.8px">Qty</h1></th>
                                <th style="text-align: center;"><h1 style="font-size: 12px; font-weight: bold; line-height: 13.8px">Unit</h1></th>
                                <th style="text-align: center;"><h1 style="font-size: 12px; font-weight: bold; line-height: 13.8px">Received</h1></th>
                                <th style="text-align: center;"><h1 style="font-size: 12px; font-weight: bold; line-height: 13.8px">Remaining</h1></th>
                            </tr>
                        </thead>
                        <tbody>
                            ${tableRows}
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    `;

        printContentDiv.innerHTML += print;
        tableRows = "";
        Page += 1;
    });
    const printWindow = window.open("", "_blank");
    window.location.href = "/CreateBTTB";
    printWindow.document.body.appendChild(printContentDiv);
    printWindow.print();
}

post_btn.addEventListener("click", function (event) {
    this.disabled = true;
    if (data.length != 0) {
        $.ajax({
            url: "/CCreateBTTB/CreateNoBTTB",
            type: "GET",
            beforeSend: function () {
                // Show loading screen
                $("#loading-screen").css("display", "flex");
            },
            success: function (response) {
                nobttb.value = response.data;
                post(response.data);
                setStatusPO();
            },
            error: function (error) {
                console.error("Error Send Data:", error);
            },
            complete: function () {
                // Hide loading screen
                $("#loading-screen").css("display", "none");
            },
        });
    } else {
        alert("Data tidak ada");
    }
});

po.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        $("#tabelcreate").DataTable().clear().draw();
        clear();
        $.ajax({
            url: "/Create",
            type: "GET",
            data: {
                noPO: po.value.trim(),
            },
            beforeSend: function () {
                // Show loading screen
                $("#loading-screen").css("display", "flex");
            },
            success: function (response) {
                if (response.length == 0) {
                    alert("Data Tidak Ada");
                } else {
                    for (let i = 0; i < supplier.options.length; i++) {
                        if (
                            supplier.options[i].text.replace(/\s/g, "") ===
                            response[0].NM_SUP.replace(/\s/g, "")
                        ) {
                            supplier.selectedIndex = i;
                        }
                    }
                    responseData(response);
                }
                // console.log(response);
            },
            error: function (error) {
                console.error("Error Fetch Data:", error);
            },
            complete: function () {
                // Hide loading screen
                $("#loading-screen").css("display", "none");
            },
        });
    }
});

$("#tabelcreate").on("dblclick", "tr", function () {
    $("#tabelcreate tr.selected").not(this).removeClass("selected");
    clear();
    $(this).toggleClass("selected");

    let rowData = tabelData.row(this).data();
    no_po.value = rowData[0];
    kode_barang.value = rowData[1];
    nama_barang.value = rowData[2];
    sub_kategori.value = rowData[3];
    qty_ordered.value = parseFloat(rowData[4]).toFixed(2);

    ordered_satuan.value = rowData[5];
    qty_ship.value = parseFloat(rowData[6]).toFixed(2) || 0;
    qty_remaining.value = parseFloat(rowData[7]).toFixed(2) || 0;
    harga_unit.value = numeral(parseFloat(rowData[8])).format("0,0.0000");
    harga_sub_total.value = numeral(parseFloat(rowData[9])).format("0,0.0000");
    ppn.value = numeral(parseFloat(rowData[10])).format("0,0.0000");
    harga_total.value = numeral(parseFloat(rowData[11])).format("0,0.0000");
    kurs.value = parseFloat(rowData[12]).toFixed(4);
    idr_unit.value = numeral(parseFloat(rowData[13])).format("0,0.0000");
    idr_sub_total.value = numeral(parseFloat(rowData[14])).format("0,0.0000");
    idr_ppn.value = numeral(parseFloat(rowData[15])).format("0,0.0000");
    idr_harga_total.value = numeral(parseFloat(rowData[16])).format("0,0.0000");
    mata_uang.value = rowData[17];
    disc.value = numeral(parseFloat(rowData[18])).format("0,0.00");
    total_disc.value = numeral(parseFloat(rowData[19])).format("0,0.0000");
    idr_total_disc.value = numeral(parseFloat(rowData[20])).format("0,0.0000");
    qty_received.value = parseFloat(rowData[21]).toFixed(2);
    fixValueQTYOrder = parseFloat(rowData[4]);
    fixValueQTYReceived = parseFloat(rowData[21]);
    fixValueQTYRemain = parseFloat(rowData[7]) || 0;
    fixValueQTYShip = parseFloat(rowData[6]) || 0;
    // console.log(fixValueQTYShip);
    let noOrder = rowData[0];
    let objekDitemukan = data.filter((obj) => obj.No_trans === noOrder);
    for (let i = 0; i < ppn_select.options.length; i++) {
        if (
            ppn_select.options[i].value.replace(/\s/g, "") ===
            objekDitemukan[0].IdPPN.replace(/\s/g, "")
        ) {
            ppn_select.selectedIndex = i;
        }
    }
});

function removeData() {
    let noOrder = no_po.value;
    let objekDitemukan = data.filter((obj) => obj.No_trans !== noOrder);
    data = objekDitemukan;
    responseData(data);
    clear();
}

$("#removebutton").on("click", function () {
    removeData();
});

$("#updatebutton").on("click", function () {
    updateData();
});

function updateData() {
    let selectedRow = $("#tabelcreate tr.selected");

    if (selectedRow.length > 0) {
        let noOrder = no_po.value;
        let datas = data.filter((obj) => obj.No_trans === noOrder);
        datas[0].Qty = qty_ordered.value;
        datas[0].QtyShipped = parseFloat(qty_ship.value).toFixed(2) || 0;
        datas[0].QtyRemain = parseFloat(qty_remaining.value).toFixed(2) || 0;
        datas[0].PriceUnit = harga_unit.value.replace(/,/g, "") || 0;
        datas[0].PriceSub = harga_sub_total.value.replace(/,/g, "") || 0;
        datas[0].PPN = ppn.value.replace(/,/g, "") || 0;
        datas[0].PriceExt = harga_total.value.replace(/,/g, "") || 0;
        datas[0].PriceUnitIDR = idr_unit.value.replace(/,/g, "") || 0;
        datas[0].PriceSubIDR = idr_sub_total.value.replace(/,/g, "") || 0;
        datas[0].PriceUnitIDR_PPN = idr_ppn.value.replace(/,/g, "") || 0;
        datas[0].PriceExtIDR = idr_harga_total.value.replace(/,/g, "") || 0;
        datas[0].disc = disc.value.replace(/,/g, "") || 0;
        datas[0].Harga_disc = total_disc.value.replace(/,/g, "") || 0;
        datas[0].DiscIDR = idr_total_disc.value.replace(/,/g, "") || 0;
        datas[0].QtyRcv = parseFloat(qty_received.value).toFixed(2) || 0;
        datas[0].Kurs = parseFloat(kurs.value).toFixed(4) || 0;
        post_btn.disabled = false;
        responseData(data);
        clear();
    } else {
        alert("Pilih baris untuk diperbarui.");
    }
}

function responseData(datas) {
    data = datas;
    console.log(data);
    tabelData.clear().draw();
    data.forEach(function (data) {
        tabelData.row
            .add([
                data.No_trans,
                data.Kd_brg,
                data.NAMA_BRG,
                data.nama_sub_kategori,
                data.Qty || 0,
                data.Nama_satuan,
                data.QtyShipped || 0,
                data.QtyRemain || 0,
                data.PriceUnit || 0,
                data.PriceSub || 0,
                data.PPN || 0,
                data.PriceExt || 0,
                data.Kurs || 0,
                data.PriceUnitIDR || 0,
                data.PriceSubIDR || 0,
                data.PriceUnitIDR_PPN || 0,
                data.PriceExtIDR || 0,
                data.Curr,
                data.disc || 0,
                data.Harga_disc || 0,
                data.DiscIDR || 0,
                data.QtyRcv || 0,
            ])
            .draw();
    });
}

$(document).ready(function () {
    qty_received.addEventListener("input", function (event) {
        let sisa = parseFloat(
            fixValueQTYOrder -
                (parseFloat(qty_received.value) - fixValueQTYReceived) -
                fixValueQTYShip
        );
        setInputFilter(
            document.getElementById("qty_received"),
            function (value) {
                return (
                    /^-?\d*[.,]?\d*$/.test(value) &&
                    (value === "" ||
                        parseFloat(value) <=
                            fixValueQTYReceived +
                                (fixValueQTYOrder - fixValueQTYShip))
                );
            },
            `Tidak boleh ketik character dan angka dibawah 0, harus angka diatas 0 dan tidak boleh lebih dari QTY Ordered`
        );
        if (
            sisa <= fixValueQTYOrder &&
            sisa >= 0 &&
            qty_received.value !== ""
        ) {
            qty_remaining.value = sisa.toFixed(2);
            if (qty_received.value != "") {
                qty_ship.value = (
                    fixValueQTYShip +
                    parseFloat(qty_received.value - fixValueQTYReceived)
                ).toFixed(2);
            }
        } else if (sisa < 0) {
            qty_remaining.value = "0.00";
            if (qty_received.value != "") {
                qty_ship.value = parseFloat(
                    qty_received.value - fixValueQTYReceived
                ).toFixed(2);
            }
        }
        updateIdrUnit();
        // updateSubTotal();
        updateSubTotalDisc();
        updateIDRSubTotal();
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
        updatePPN();
        updateIDRPPN();
        updateHargaTotal();
        updateIDRHargaTotal();
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
    qty_received.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            qty_received.value = parseFloat(qty_received.value).toFixed(2);
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
});

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
    let qty_received = numeral(
        document.getElementById("qty_received").value
    ).value();
    let hargaUnit = numeral(
        document.getElementById("harga_unit").value
    ).value();
    let disc = numeral(document.getElementById("disc").value).value();
    if (!isNaN(qty_received) && !isNaN(hargaUnit) && !isNaN(disc)) {
        let SubTotalValue = hargaUnit * qty_received;
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
    let qty_received = numeral(
        document.getElementById("qty_received").value
    ).value();
    let hargaUnit = numeral(
        document.getElementById("harga_unit").value
    ).value();
    let total_disc = numeral(
        document.getElementById("total_disc").value
    ).value();
    if (!isNaN(qty_received) && !isNaN(hargaUnit) && !isNaN(total_disc)) {
        let SubTotalValue = hargaUnit * qty_received;
        let hargaSubTotal = SubTotalValue - total_disc;
        harga_sub_total.value = numeral(hargaSubTotal).format("0,0.0000");
    }
}

function updatePPN() {
    let selectedPPN = numeral(
        ppn_select.options[ppn_select.selectedIndex].text
    ).value();
    let hargaSubTotal = numeral(
        document.getElementById("harga_sub_total").value
    ).value();
    if (!isNaN(selectedPPN) && !isNaN(hargaSubTotal)) {
        let jumPPN = (hargaSubTotal * selectedPPN) / 100;
        ppn.value = numeral(jumPPN).format("0,0.0000");
    }
}

function updateIDRPPN() {
    let selectedPPN = numeral(
        ppn_select.options[ppn_select.selectedIndex].text
    ).value();
    let hargaSubTotal = numeral(
        document.getElementById("harga_sub_total").value
    ).value();
    let kurs = numeral(document.getElementById("kurs").value).value();
    if (!isNaN(selectedPPN) && !isNaN(hargaSubTotal) && !isNaN(kurs)) {
        let jumPPN = (hargaSubTotal * selectedPPN) / 100;
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
        idr_harga_total.value = numeral(IDRHargaTotalValue).format("0,0.0000");
    }
}

function updateDisc() {
    let qty_received = numeral(
        document.getElementById("qty_received").value
    ).value();
    let hargaUnit = numeral(
        document.getElementById("harga_unit").value
    ).value();
    let disc = numeral(document.getElementById("disc").value).value();
    if (!isNaN(hargaUnit) && !isNaN(qty_received) && !isNaN(disc)) {
        let SubTotalValue = hargaUnit * qty_received;
        let discount = (SubTotalValue * disc) / 100;
        total_disc.value = numeral(discount).format("0,0.0000");
    }
}

function updateTotalDisc() {
    let qty_received = numeral(
        document.getElementById("qty_received").value
    ).value();
    let hargaUnit = numeral(
        document.getElementById("harga_unit").value
    ).value();
    let total_disc = numeral(
        document.getElementById("total_disc").value
    ).value();
    if (!isNaN(hargaUnit) && !isNaN(qty_received) && !isNaN(total_disc)) {
        let SubTotalValue = hargaUnit * qty_received;
        let discount = (total_disc / SubTotalValue) * 100;
        disc.value = numeral(discount).format("0,0.00");
    }
}

function updateIDRDisc() {
    let qty_received = numeral(
        document.getElementById("qty_received").value
    ).value();
    let hargaUnit = numeral(
        document.getElementById("harga_unit").value
    ).value();
    let disc = numeral(document.getElementById("disc").value).value();
    let kurs = numeral(document.getElementById("kurs").value).value();

    if (
        !isNaN(hargaUnit) &&
        !isNaN(qty_received) &&
        !isNaN(disc) &&
        !isNaN(kurs)
    ) {
        let SubTotalValue = hargaUnit * qty_received;
        let discount = (SubTotalValue * disc) / 100;
        let totalIDRDiscValue = discount * kurs;
        idr_total_disc.value = numeral(totalIDRDiscValue).format("0,0.0000");
    }
}

function updateIDRDiscTotal() {
    let total_disc = numeral(
        document.getElementById("total_disc").value
    ).value();
    let kurs = numeral(document.getElementById("kurs").value).value();

    if (!isNaN(total_disc) && !isNaN(kurs)) {
        let totalIDRDiscValue = total_disc * kurs;
        idr_total_disc.value = numeral(totalIDRDiscValue).format("0,0.0000");
    }
}
