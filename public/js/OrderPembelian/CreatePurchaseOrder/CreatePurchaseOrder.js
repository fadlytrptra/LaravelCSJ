//#region Variable
let backGroup = document.getElementById("backGroup");
let btn_backCreatePO = document.getElementById("btn_backCreatePO");
let btn_close = document.getElementById("btn_close");
let check_nyantol = document.getElementById("check_nyantol");
let checkbox_centangSemuaBaris = document.getElementById("checkbox_centangSemuaBaris"); // prettier-ignore
let checkedAll = document.getElementById("CheckedAll");
let create_po = document.getElementById("create_po");
let csrfToken = $('meta[name="csrf-token"]').attr("content");
let div_tablePO = document.getElementById("div_tablePO");
let divisi_select = document.getElementById("divisi_select");
let filter_divisiRadioButton1 = document.getElementById("filter_divisiRadioButton1"); // prettier-ignore
let filter_divisiRadioButton2 = document.getElementById("filter_divisiRadioButton2"); // prettier-ignore
let filter_radioButton1 = document.getElementById("filter_radioButton1");
let filter_radioButton2 = document.getElementById("filter_radioButton2");
let filter_radioButton3 = document.getElementById("filter_radioButton3");
let filter_radioButtonOrderInput = document.getElementById("filter_radioButtonOrderInput"); // prettier-ignore
let filter_radioButtonUserInput = document.getElementById("filter_radioButtonUserInput"); // prettier-ignore
let form_createSPPB = document.getElementById("form_createSPPB");
let jnsBeli = 0;
let modeLoad = 0;
let proses = 0;
let redisplay = document.getElementById("redisplay");
let selectedRows = [];
let table_PurchaseOrder = document.getElementById("table_PurchaseOrder");

let table = $("#table_PurchaseOrder").DataTable({
    responsive: true,
    scrollX: true,
    searching: false,
    scrollY: "400px",
    paging: false,
    columnDefs: [{ orderable: false, targets: 0 }],
});

//#region Load Form

backGroup.style.display = "none";

//#endregion

//#region Function

function LoadPermohonan(proses, stbeli) {
    if (proses == 1) {
        fetch(
            "/get/dataPermohonanDivisi/" +
                stbeli +
                "/" +
                divisi_select.options[divisi_select.selectedIndex].value
        )
            .then((response) => response.json())
            .then((data) => {
                const rows = data.map((item) => {
                    const tglDibutuhkan = new Date(item.Tgl_Dibutuhkan);
                    // Format the date
                    const tglDibutuhkanformattedDate =
                        ("0" + tglDibutuhkan.getDate()).slice(-2) +
                        "-" +
                        ("0" + (tglDibutuhkan.getMonth() + 1)).slice(-2) +
                        "-" +
                        tglDibutuhkan.getFullYear();

                    // Modify the item in the data array
                    item.Tgl_Dibutuhkan = tglDibutuhkanformattedDate;

                    const tglDirektur = new Date(item.Tgl_Direktur);
                    // Format the date
                    const tglDirekturformattedDate =
                        ("0" + tglDirektur.getDate()).slice(-2) +
                        "-" +
                        ("0" + (tglDirektur.getMonth() + 1)).slice(-2) +
                        "-" +
                        tglDirektur.getFullYear() +
                        " " +
                        tglDirektur.getHours() +
                        ":" +
                        tglDirektur.getMinutes() +
                        ":" +
                        tglDirektur.getSeconds();

                    // Modify the item in the data array
                    item.Tgl_Direktur = tglDirekturformattedDate;

                    return [
                        `<input type="checkbox" name="checked" value="${item.No_trans.trim()}" id="${item.No_trans.trim()}" style="width: 20px;height: 20px;" />`,
                        item.NM_SUP.trim(),
                        item.Kd_div.trim(),
                        item.NmUser.trim(),
                        item.StBeli.trim() == 1
                            ? "Pengadaan Pembelian"
                            : "Beli Sendiri",
                        item.No_trans.trim(),
                        item.Kd_brg.trim(),
                        item.NAMA_BRG.trim().replace(/</g, "&lt;"),
                        item.nama_sub_kategori.trim(),
                        numeral(parseFloat(item.Qty.trim())).format("0,0.00"),
                        item.Nama_satuan.trim(),
                        numeral(parseFloat(item.PriceUnit.trim())).format(
                            "0,0.0000"
                        ),
                        numeral(parseFloat(item.PriceSub.trim())).format(
                            "0,0.0000"
                        ),
                        numeral(parseFloat(item.PPN.trim())).format("0,0.0000"),
                        numeral(
                            parseFloat((item.PriceExt ?? "0").trim())
                        ).format("0,0.0000"),
                        item.Curr.trim(),
                        item.Tgl_Dibutuhkan.trim(),
                        item.keterangan == null ? "-" : item.keterangan.trim(),
                        item.Ket_Internal == null
                            ? "-"
                            : item.Ket_Internal.trim(),
                        item.AppMan.trim(),
                        item.AppPBL.trim(),
                        item.AppDir.trim() + " " + item.Tgl_Direktur.trim(),
                    ];
                });
                table.clear();
                table.rows.add(rows);
                table.draw();
                $("#table_PurchaseOrder tbody").off("dblclick", "tr");
                $("#table_PurchaseOrder tbody").on(
                    "dblclick",
                    "tr",
                    function () {
                        let checkbox = $(this).find('input[type="checkbox"]');
                        checkbox.prop("checked", !checkbox.prop("checked"));
                        let checkedCount = $(
                            '#table_PurchaseOrder tbody input[type="checkbox"]:checked'
                        ).length;

                        $("#checkedCount").text(
                            `Jumlah Data Yang TerCentang ${checkedCount}`
                        );
                        selectedRows = [];
                        $(
                            '#table_PurchaseOrder tbody input[type="checkbox"]:checked'
                        ).each(function () {
                            let row = $(this).closest("tr");
                            let rowData = table.row(row).data();
                            selectedRows.push(rowData);
                        });
                        // console.log(selectedRows);
                    }
                );
                $("#table_PurchaseOrder tbody").on(
                    "click",
                    'input[type="checkbox"]',
                    function () {
                        let checkedCount = $(
                            '#table_PurchaseOrder tbody input[type="checkbox"]:checked'
                        ).length;

                        $("#checkedCount").text(
                            `Jumlah Data Yang TerCentang ${checkedCount}`
                        );
                        selectedRows = [];

                        $(
                            '#table_PurchaseOrder tbody input[type="checkbox"]:checked'
                        ).each(function () {
                            let row = $(this).closest("tr");
                            let rowData = table.row(row).data();
                            selectedRows.push(rowData);
                        });
                        // console.log(selectedRows);
                    }
                );
            });
    } else if (proses == 2) {
        fetch("/get/dataPermohonanUser/" + filter_radioButtonUserInput.value)
            .then((response) => response.json())
            .then((data) => {
                const rows = data.map((item) => {
                    return [
                        `<input type="checkbox" name="checked" value="${item.No_trans.trim()}" id="${item.No_trans.trim()}" style="width: 20px;height: 20px;" />`,
                        item.NM_SUP.trim(),
                        item.Kd_div.trim(),
                        item.NmUser.trim(),
                        item.StBeli.trim() == 1
                            ? "Pengadaan Pembelian"
                            : "Beli Sendiri",
                        item.No_trans.trim(),
                        item.Kd_brg.trim(),
                        item.NAMA_BRG.trim().replace(/</g, "&lt;"),
                        item.nama_sub_kategori.trim(),
                        numeral(parseFloat(item.Qty.trim())).format("0,0.00"),
                        item.Nama_satuan.trim(),
                        numeral(parseFloat(item.PriceUnit.trim())).format(
                            "0,0.0000"
                        ),
                        numeral(parseFloat(item.PriceSub.trim())).format(
                            "0,0.0000"
                        ),
                        numeral(parseFloat(item.PPN.trim())).format("0,0.0000"),
                        numeral(parseFloat(item.PriceExt.trim())).format(
                            "0,0.0000"
                        ),
                        item.Curr.trim(),
                        item.Tgl_Dibutuhkan.trim(),
                        item.keterangan == null ? "-" : item.keterangan.trim(),
                        item.Ket_Internal == null
                            ? "-"
                            : item.Ket_Internal.trim(),
                        item.AppMan.trim(),
                        item.AppPBL.trim(),
                        item.AppDir.trim() + " " + item.Tgl_Direktur,
                    ];
                });
                table.clear();
                table.rows.add(rows);
                table.draw();
                $("#table_PurchaseOrder tbody").off("dblclick", "tr");
                $("#table_PurchaseOrder tbody").on(
                    "dblclick",
                    "tr",
                    function () {
                        let checkbox = $(this).find('input[type="checkbox"]');
                        checkbox.prop("checked", !checkbox.prop("checked"));
                        let checkedCount = $(
                            '#table_PurchaseOrder tbody input[type="checkbox"]:checked'
                        ).length;

                        $("#checkedCount").text(
                            `Jumlah Data Yang TerCentang ${checkedCount}`
                        );
                        selectedRows = [];
                        $(
                            '#table_PurchaseOrder tbody input[type="checkbox"]:checked'
                        ).each(function () {
                            let row = $(this).closest("tr");
                            let rowData = table.row(row).data();
                            selectedRows.push(rowData);
                        });
                        // console.log(selectedRows);
                    }
                );
                $("#table_PurchaseOrder tbody").on(
                    "click",
                    'input[type="checkbox"]',
                    function () {
                        let checkedCount = $(
                            '#table_PurchaseOrder tbody input[type="checkbox"]:checked'
                        ).length;

                        $("#checkedCount").text(
                            `Jumlah Data Yang TerCentang ${checkedCount}`
                        );
                        selectedRows = [];

                        $(
                            '#table_PurchaseOrder tbody input[type="checkbox"]:checked'
                        ).each(function () {
                            let row = $(this).closest("tr");
                            let rowData = table.row(row).data();
                            selectedRows.push(rowData);
                        });
                        // console.log(selectedRows);
                    }
                );
            });
    } else if (proses == 3) {
        fetch("/get/dataPermohonanOrder/" + filter_radioButtonOrderInput.value)
            .then((response) => response.json())
            .then((data) => {
                const rows = data.map((item) => {
                    return [
                        `<input type="checkbox" name="checked" value="${item.No_trans.trim()}" id="${item.No_trans.trim()}" style="width: 20px;height: 20px;" />`,
                        item.NM_SUP.trim(),
                        item.Kd_div.trim(),
                        item.NmUser.trim(),
                        item.StBeli.trim() == 1
                            ? "Pengadaan Pembelian"
                            : "Beli Sendiri",
                        item.No_trans.trim(),
                        item.Kd_brg.trim(),
                        item.NAMA_BRG.trim().replace(/</g, "&lt;"),
                        item.nama_sub_kategori.trim(),
                        numeral(parseFloat(item.Qty.trim())).format("0,0.00"),
                        item.Nama_satuan.trim(),
                        numeral(parseFloat(item.PriceUnit.trim())).format(
                            "0,0.0000"
                        ),
                        numeral(parseFloat(item.PriceSub.trim())).format(
                            "0,0.0000"
                        ),
                        numeral(parseFloat(item.PPN.trim())).format("0,0.0000"),
                        numeral(parseFloat(item.PriceExt.trim())).format(
                            "0,0.0000"
                        ),
                        item.Curr.trim(),
                        item.Tgl_Dibutuhkan.trim(),
                        item.keterangan == null ? "-" : item.keterangan.trim(),
                        item.Ket_Internal == null
                            ? "-"
                            : item.Ket_Internal.trim(),
                        item.AppMan.trim(),
                        item.AppPBL.trim(),
                        item.AppDir.trim() + " " + item.Tgl_Direktur.trim(),
                    ];
                });
                table.clear();
                table.rows.add(rows);
                table.draw();
                $("#table_PurchaseOrder tbody").off("dblclick", "tr");
                $("#table_PurchaseOrder tbody").on(
                    "dblclick",
                    "tr",
                    function () {
                        let checkbox = $(this).find('input[type="checkbox"]');
                        checkbox.prop("checked", !checkbox.prop("checked"));
                        let checkedCount = $(
                            '#table_PurchaseOrder tbody input[type="checkbox"]:checked'
                        ).length;

                        $("#checkedCount").text(
                            `Jumlah Data Yang TerCentang ${checkedCount}`
                        );
                        selectedRows = [];
                        $(
                            '#table_PurchaseOrder tbody input[type="checkbox"]:checked'
                        ).each(function () {
                            let row = $(this).closest("tr");
                            let rowData = table.row(row).data();
                            selectedRows.push(rowData);
                        });
                        // console.log(selectedRows);
                    }
                );
                $("#table_PurchaseOrder tbody").on(
                    "click",
                    'input[type="checkbox"]',
                    function () {
                        let checkedCount = $(
                            '#table_PurchaseOrder tbody input[type="checkbox"]:checked'
                        ).length;

                        $("#checkedCount").text(
                            `Jumlah Data Yang TerCentang ${checkedCount}`
                        );
                        selectedRows = [];

                        $(
                            '#table_PurchaseOrder tbody input[type="checkbox"]:checked'
                        ).each(function () {
                            let row = $(this).closest("tr");
                            let rowData = table.row(row).data();
                            selectedRows.push(rowData);
                        });
                        // console.log(selectedRows);
                    }
                );
            });
    }
}

function LoadPermohonanNyantol(proses, stbeli) {
    if (proses == 1) {
        fetch(
            "/get/dataPermohonanDivisiNyantol/" +
                stbeli +
                "/" +
                divisi_select.options[divisi_select.selectedIndex].value
        )
            .then((response) => response.json())
            .then((data) => {
                //
                const rows = data.map((item) => {
                    return [
                        `<input type="checkbox" name="checked" value="${item.No_trans.trim()}" id="${item.No_trans.trim()}" style="width: 20px;height: 20px;" />`,
                        item.NM_SUP.trim(),
                        item.Kd_div.trim(),
                        item.NmUser.trim(),
                        item.StBeli.trim() == 1
                            ? "Pengadaan Pembelian"
                            : "Beli Sendiri",
                        item.No_trans.trim(),
                        item.Kd_brg.trim(),
                        item.NAMA_BRG.trim().replace(/</g, "&lt;"),
                        item.nama_sub_kategori.trim(),
                        numeral(parseFloat(item.Qty.trim())).format("0,0.00"),
                        item.Nama_satuan.trim(),
                        numeral(parseFloat(item.PriceUnit.trim())).format(
                            "0,0.0000"
                        ),
                        numeral(parseFloat(item.PriceSub.trim())).format(
                            "0,0.0000"
                        ),
                        numeral(parseFloat(item.PPN.trim())).format("0,0.0000"),
                        numeral(parseFloat(item.PriceExt.trim())).format(
                            "0,0.0000"
                        ),
                        item.Curr.trim(),
                        item.Tgl_Dibutuhkan.trim(),
                        item.keterangan == null ? "-" : item.keterangan.trim(),
                        item.Ket_Internal == null
                            ? "-"
                            : item.Ket_Internal.trim(),
                        item.AppMan.trim(),
                        item.AppPBL.trim(),
                        item.AppDir.trim() + " " + item.Tgl_Direktur.trim(),
                    ];
                });
                table.clear();
                table.rows.add(rows);
                table.draw();
                $("#table_PurchaseOrder tbody").off("dblclick", "tr");
                $("#table_PurchaseOrder tbody").on(
                    "dblclick",
                    "tr",
                    function () {
                        let checkbox = $(this).find('input[type="checkbox"]');
                        checkbox.prop("checked", !checkbox.prop("checked"));
                        let checkedCount = $(
                            '#table_PurchaseOrder tbody input[type="checkbox"]:checked'
                        ).length;

                        $("#checkedCount").text(
                            `Jumlah Data Yang TerCentang ${checkedCount}`
                        );
                        selectedRows = [];
                        $(
                            '#table_PurchaseOrder tbody input[type="checkbox"]:checked'
                        ).each(function () {
                            let row = $(this).closest("tr");
                            let rowData = table.row(row).data();
                            selectedRows.push(rowData);
                        });
                        // console.log(selectedRows);
                    }
                );
                $("#table_PurchaseOrder tbody").on(
                    "click",
                    'input[type="checkbox"]',
                    function () {
                        let checkedCount = $(
                            '#table_PurchaseOrder tbody input[type="checkbox"]:checked'
                        ).length;

                        $("#checkedCount").text(
                            `Jumlah Data Yang TerCentang ${checkedCount}`
                        );
                        selectedRows = [];

                        $(
                            '#table_PurchaseOrder tbody input[type="checkbox"]:checked'
                        ).each(function () {
                            let row = $(this).closest("tr");
                            let rowData = table.row(row).data();
                            selectedRows.push(rowData);
                        });
                        // console.log(selectedRows);
                    }
                );
            });
    } else if (proses == 2) {
        fetch(
            "/get/dataPermohonanUserNyantol/" +
                filter_radioButtonUserInput.value
        )
            .then((response) => response.json())
            .then((data) => {
                const rows = data.map((item) => {
                    return [
                        `<input type="checkbox" name="checked" value="${item.No_trans.trim()}" id="${item.No_trans.trim()}" style="width: 20px;height: 20px;" />`,
                        item.NM_SUP.trim(),
                        item.Kd_div.trim(),
                        item.NmUser.trim(),
                        item.StBeli.trim() == 1
                            ? "Pengadaan Pembelian"
                            : "Beli Sendiri",
                        item.No_trans.trim(),
                        item.Kd_brg.trim(),
                        item.NAMA_BRG.trim().replace(/</g, "&lt;"),
                        item.nama_sub_kategori.trim(),
                        numeral(parseFloat(item.Qty.trim())).format("0,0.00"),
                        item.Nama_satuan.trim(),
                        numeral(parseFloat(item.PriceUnit.trim())).format(
                            "0,0.0000"
                        ),
                        numeral(parseFloat(item.PriceSub.trim())).format(
                            "0,0.0000"
                        ),
                        numeral(parseFloat(item.PPN.trim())).format("0,0.0000"),
                        numeral(parseFloat(item.PriceExt.trim())).format(
                            "0,0.0000"
                        ),
                        item.Curr.trim(),
                        item.Tgl_Dibutuhkan.trim(),
                        item.keterangan == null ? "-" : item.keterangan.trim(),
                        item.Ket_Internal == null
                            ? "-"
                            : item.Ket_Internal.trim(),
                        item.AppMan.trim(),
                        item.AppPBL.trim(),
                        item.AppDir.trim() + " " + item.Tgl_Direktur.trim(),
                    ];
                });
                table.clear();
                table.rows.add(rows);
                table.draw();
                $("#table_PurchaseOrder tbody").off("dblclick", "tr");
                $("#table_PurchaseOrder tbody").on(
                    "dblclick",
                    "tr",
                    function () {
                        let checkbox = $(this).find('input[type="checkbox"]');
                        checkbox.prop("checked", !checkbox.prop("checked"));
                        let checkedCount = $(
                            '#table_PurchaseOrder tbody input[type="checkbox"]:checked'
                        ).length;

                        $("#checkedCount").text(
                            `Jumlah Data Yang TerCentang ${checkedCount}`
                        );
                        selectedRows = [];
                        $(
                            '#table_PurchaseOrder tbody input[type="checkbox"]:checked'
                        ).each(function () {
                            let row = $(this).closest("tr");
                            let rowData = table.row(row).data();
                            selectedRows.push(rowData);
                        });
                        // console.log(selectedRows);
                    }
                );
                $("#table_PurchaseOrder tbody").on(
                    "click",
                    'input[type="checkbox"]',
                    function () {
                        let checkedCount = $(
                            '#table_PurchaseOrder tbody input[type="checkbox"]:checked'
                        ).length;

                        $("#checkedCount").text(
                            `Jumlah Data Yang TerCentang ${checkedCount}`
                        );
                        selectedRows = [];

                        $(
                            '#table_PurchaseOrder tbody input[type="checkbox"]:checked'
                        ).each(function () {
                            let row = $(this).closest("tr");
                            let rowData = table.row(row).data();
                            selectedRows.push(rowData);
                        });

                        // console.log(selectedRows);
                    }
                );
            });
    } else if (proses == 3) {
        fetch(
            "/get/dataPermohonanOrderNyantol/" +
                filter_radioButtonOrderInput.value
        )
            .then((response) => response.json())
            .then((data) => {
                const rows = data.map((item) => {
                    return [
                        `<input type="checkbox" name="checked" value="${item.No_trans.trim()}" id="${item.No_trans.trim()}" style="width: 20px;height: 20px;" />`,
                        item.NM_SUP.trim(),
                        item.Kd_div.trim(),
                        item.NmUser.trim(),
                        item.StBeli.trim() == 1
                            ? "Pengadaan Pembelian"
                            : "Beli Sendiri",
                        item.No_trans.trim(),
                        item.Kd_brg.trim(),
                        item.NAMA_BRG.trim().replace(/</g, "&lt;"),
                        item.nama_sub_kategori.trim(),
                        numeral(parseFloat(item.Qty.trim())).format("0,0.00"),
                        item.Nama_satuan.trim(),
                        numeral(parseFloat(item.PriceUnit.trim())).format(
                            "0,0.0000"
                        ),
                        numeral(parseFloat(item.PriceSub.trim())).format(
                            "0,0.0000"
                        ),
                        numeral(parseFloat(item.PPN.trim())).format("0,0.0000"),
                        numeral(parseFloat(item.PriceExt.trim())).format(
                            "0,0.0000"
                        ),
                        item.Curr.trim(),
                        item.Tgl_Dibutuhkan.trim(),
                        item.keterangan == null ? "-" : item.keterangan.trim(),
                        item.Ket_Internal == null
                            ? "-"
                            : item.Ket_Internal.trim(),
                        item.AppMan.trim(),
                        item.AppPBL.trim(),
                        item.AppDir.trim() + " " + item.Tgl_Direktur.trim(),
                    ];
                });

                table.clear();
                table.rows.add(rows);
                table.draw();
                $("#table_PurchaseOrder tbody").off("dblclick", "tr");
                $("#table_PurchaseOrder tbody").on(
                    "dblclick",
                    "tr",
                    function () {
                        let checkbox = $(this).find('input[type="checkbox"]');
                        checkbox.prop("checked", !checkbox.prop("checked"));
                        let checkedCount = $(
                            '#table_PurchaseOrder tbody input[type="checkbox"]:checked'
                        ).length;

                        $("#checkedCount").text(
                            `Jumlah Data Yang TerCentang ${checkedCount}`
                        );
                        selectedRows = [];
                        $(
                            '#table_PurchaseOrder tbody input[type="checkbox"]:checked'
                        ).each(function () {
                            let row = $(this).closest("tr");
                            let rowData = table.row(row).data();
                            selectedRows.push(rowData);
                        });
                        // console.log(selectedRows);
                    }
                );
                $("#table_PurchaseOrder tbody").on(
                    "click",
                    'input[type="checkbox"]',
                    function () {
                        let checkedCount = $(
                            '#table_PurchaseOrder tbody input[type="checkbox"]:checked'
                        ).length;

                        $("#checkedCount").text(
                            `Jumlah Data Yang TerCentang ${checkedCount}`
                        );
                        selectedRows = [];

                        $(
                            '#table_PurchaseOrder tbody input[type="checkbox"]:checked'
                        ).each(function () {
                            let row = $(this).closest("tr");
                            let rowData = table.row(row).data();
                            selectedRows.push(rowData);
                        });
                        // console.log(selectedRows);
                    }
                );
            });
    }
}

function handleReload() {
    if (modeLoad == 1) {
        proses = 1;
        jnsBeli = filter_divisiRadioButton1.checked ? 1 : 0;
        LoadPermohonanNyantol(proses, jnsBeli);
    } else if (modeLoad == 2) {
        proses = 2;
        LoadPermohonanNyantol(proses, 2);
    } else if (modeLoad == 3) {
        proses = 3;
        LoadPermohonanNyantol(proses, 3);
    } else if (modeLoad == 4) {
        proses = 1;
        jnsBeli = filter_divisiRadioButton1.checked ? 1 : 0;
        LoadPermohonan(proses, jnsBeli);
    } else if (modeLoad == 5) {
        proses = 2;
        LoadPermohonan(proses, 2);
    } else if (modeLoad == 6) {
        proses = 3;
        LoadPermohonan(proses, 3);
    }
}

//#region

//#region Event Listener

check_nyantol.addEventListener("click", function (event) {
    if (check_nyantol.checked == true) {
        backGroup.style.display = "block";
        form_createSPPB.style.display = "none";
    } else {
        backGroup.style.display = "none";
        form_createSPPB.style.display = "block";
    }
});

checkedAll.addEventListener("click", function (event) {
    let rows = table
        .rows({
            search: "applied",
        })
        .nodes();
    if (checkedAll.checked == true) {
        $('input[type="checkbox"]', rows).prop("checked", true);
        let checkbox = $(this).find('input[type="checkbox"]');
        checkbox.prop("checked", !checkbox.prop("checked"));
        let checkedCount = $(
            '#table_PurchaseOrder tbody input[type="checkbox"]:checked'
        ).length;

        $("#checkedCount").text(`Jumlah Data Yang TerCentang ${checkedCount}`);
        selectedRows = table.rows().data().toArray();
    } else {
        $('input[type="checkbox"]', rows).prop("checked", false);
        selectedRows = [];
        let checkedCount = $(
            '#table_PurchaseOrder tbody input[type="checkbox"]:checked'
        ).length;

        $("#checkedCount").text(`Jumlah Data Yang TerCentang ${checkedCount}`);
    }
    // console.log(selectedRows, "checkedAll clicked");
});

btn_backCreatePO.addEventListener("click", function (event) {
    if (selectedRows.length == 0) {
        alert("Pilih Dulu Data Yang Mau DiBack Create PO");
    } else {
        for (let i = 0; i < selectedRows.length; i++) {
            $.ajax({
                url: "/PurchaseOrderr/create/BackCreatePO",
                type: "PUT",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
                data: {
                    noTrans: selectedRows[i][5].trim(),
                },
                beforeSend: function () {
                    // Show loading screen
                    $("#loading-screen").css("display", "flex");
                },
                success: function (response) {
                    Swal.fire({
                        icon: "success",
                        title: response.message,
                        showConfirmButton: false,
                        timer: "2000",
                    });
                    if (modeLoad == 1) {
                        proses = 1;
                        if (filter_divisiRadioButton1.checked == true) {
                            jnsBeli = 1;
                        } else if (filter_divisiRadioButton2.checked == true) {
                            jnsBeli = 0;
                        }
                        modeLoad = 1;
                        LoadPermohonanNyantol(proses, jnsBeli);
                    } else if (modeLoad == 2) {
                        proses = 2;
                        modeLoad = 2;
                        LoadPermohonanNyantol(proses, 2);
                    } else if (modeLoad == 3) {
                        proses = 3;
                        modeLoad = 3;
                        LoadPermohonanNyantol(proses, 3);
                    } else if (modeLoad == 4) {
                        proses = 1;
                        if (filter_divisiRadioButton1.checked == true) {
                            jnsBeli = 1;
                        } else if (filter_divisiRadioButton2.checked == true) {
                            jnsBeli = 0;
                        }
                        modeLoad = 4;
                        LoadPermohonan(proses, jnsBeli);
                    } else if (modeLoad == 5) {
                        proses = 2;
                        modeLoad = 5;
                        LoadPermohonan(proses, 2);
                    } else if (modeLoad == 6) {
                        proses = 3;
                        modeLoad = 6;
                        LoadPermohonan(proses, 3);
                    }
                },
                error: function (error) {
                    Swal.fire({
                        icon: "error",
                        title: "Data Tidak Berhasil DiBack To Create!",
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

btn_close.addEventListener("click", function (event) {
    if (selectedRows.length == 0) {
        alert("Pilih Dulu Data Yang Mau DiClose Order");
    } else {
        // Ask for alasan first
        Swal.fire({
            title: "Masukkan Alasan",
            input: "text",
            inputPlaceholder: "Tulis alasan di sini...",
            showCancelButton: true,
            confirmButtonText: "Lanjutkan",
            cancelButtonText: "Batal",
        }).then((result) => {
            if (result.isConfirmed && result.value.trim() !== "") {
                let alasan = result.value.trim();

                for (let i = 0; i < selectedRows.length; i++) {
                    $.ajax({
                        url: "/PurchaseOrderr/create/CloseOrder",
                        type: "PUT",
                        headers: {
                            "X-CSRF-TOKEN": csrfToken,
                        },
                        data: {
                            noTrans: selectedRows[i][5].trim(),
                            QtyCancel: parseFloat(selectedRows[i][9]),
                            alasan: alasan,
                        },
                        beforeSend: function () {
                            $("#loading-screen").css("display", "flex");
                        },
                        success: function (response) {
                            Swal.fire({
                                icon: "success",
                                title: response.message,
                                showConfirmButton: false,
                                timer: 2000,
                            });
                            handleReload();
                        },
                        error: function (error) {
                            Swal.fire({
                                icon: "error",
                                title: "Data Tidak Berhasil DiClose!",
                                showConfirmButton: false,
                                timer: 2000,
                            });
                            console.error("Error Send Data:", error);
                        },
                        complete: function () {
                            $("#loading-screen").css("display", "none");
                        },
                    });
                }
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire("Tidak Dibatalkan", "Order tidak jadi dibatalkan.", "info");
            }
        });
    }
});

filter_radioButtonOrderInput.addEventListener("change", function (event) {
    redisplay.focus();
});

filter_radioButtonUserInput.addEventListener("change", function (event) {
    redisplay.focus();
});

redisplay.addEventListener("click", function (event) {
    event.preventDefault();
    let nyantol = false;
    if (check_nyantol.checked == true) {
        nyantol = true;
    } else {
        nyantol = false;
    }
    // console.log(nyantol);
    $('input[type="checkbox"]:checked').prop("checked", false);
    $("#checkedCount").text(`Jumlah Data Yang TerCentang 0`);
    if (nyantol == true) {
        check_nyantol.checked = true;
    } else {
        check_nyantol.checked = false;
    }
    if (check_nyantol.checked == true) {
        if (filter_radioButton1.checked == true) {
            proses = 1;
            if (filter_divisiRadioButton1.checked == true) {
                jnsBeli = 1;
            } else if (filter_divisiRadioButton2.checked == true) {
                jnsBeli = 0;
            }
            modeLoad = 1;
            LoadPermohonanNyantol(proses, jnsBeli);
        } else if (filter_radioButton2.checked == true) {
            proses = 2;
            modeLoad = 2;
            LoadPermohonanNyantol(proses, 2);
        } else if (filter_radioButton3.checked == true) {
            proses = 3;
            modeLoad = 3;
            LoadPermohonanNyantol(proses, 3);
        }
    } else {
        if (filter_radioButton1.checked == true) {
            proses = 1;
            if (filter_divisiRadioButton1.checked == true) {
                jnsBeli = 1;
            } else if (filter_divisiRadioButton2.checked == true) {
                jnsBeli = 0;
            }
            modeLoad = 4;
            LoadPermohonan(proses, jnsBeli);
        } else if (filter_radioButton2.checked == true) {
            proses = 2;
            modeLoad = 5;
            LoadPermohonan(proses, 2);
        } else if (filter_radioButton3.checked == true) {
            proses = 3;
            modeLoad = 6;
            LoadPermohonan(proses, 3);
        }
    }
});

create_po.addEventListener("click", function (event) {
    event.preventDefault();
    let isDifferent = false;
    let totalRows = selectedRows.length;

    // Loop untuk memeriksa kolom ke-3 (index 2) dari semua baris
    let firstValue = selectedRows[0][2]; // Nilai referensi dari array pertama

    // Bandingkan dengan semua baris lainnya
    for (let row = 1; row < totalRows; row++) {
        if (selectedRows[row][2] !== firstValue) {
            isDifferent = true;
            break;
        }
    }

    // Jika ada perbedaan, tampilkan peringatan
    if (isDifferent) {
        Swal.fire({
            icon: "warning",
            title: "Peringatan",
            text: "Terdapat data divisi yang tidak sama di antara baris yang dipilih!",
        });
    } else {
        Swal.fire({
            title: "Yakin akan memproses order ini?",
            text: "Pastikan kembali bahwa order yang dicentang adalah milik divisi yang sama. 1 PO, 1 Supplier, 1 Divisi.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No",
        }).then((result) => {
            if (result.isConfirmed && selectedRows.length > 0) {
                let sameValues = true; // Ensure your condition is correctly set
                if (sameValues) {
                    let noTrans = [];
                    for (let index = 0; index < selectedRows.length; index++) {
                        noTrans.push(selectedRows[index][5]);
                        // console.log(noTrans);
                    }
                    let input = document.createElement("input");
                    input.type = "hidden";
                    input.name = "noTrans";
                    input.value = noTrans;
                    form_createSPPB.target = "_blank";
                    form_createSPPB.appendChild(input);
                    // console.log(form_createSPPB);
                    form_createSPPB.submit();
                }
            } else {
                return;
            }
        });
    }

    // if (
    //     confirm(
    //         "Pastikan kembali bahwa order yang dicentang adalah milik divisi yang sama. 1 PO, 1 Supplier, 1 Divisi. Yakin akan memproses order ini?"
    //     ) &&
    //     selectedRows.length > 0
    // ) {
    //     let sameValues = true;
    //     if (sameValues == true) {
    //         let noTrans = [];
    //         for (let index = 0; index < selectedRows.length; index++) {
    //             noTrans.push(selectedRows[index][5]);
    //             console.log(noTrans);
    //         }
    //         let input = document.createElement("input");
    //         input.type = "hidden";
    //         input.name = "noTrans";
    //         input.value = noTrans;
    //         form_createSPPB.target = "_blank";
    //         form_createSPPB.appendChild(input);
    //         console.log(form_createSPPB);
    //         form_createSPPB.submit();
    //     }
    // } else {
    //     return;
    // }
});

//#endregion
