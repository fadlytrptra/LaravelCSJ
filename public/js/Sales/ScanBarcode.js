let kode_barcode = document.getElementById("kode_barcode");
let div_tableBarcodeDetail = document.getElementById("div_tableBarcodeDetail");
let div_tableBarcodeData = document.getElementById("div_tableBarcodeData");
let jumlah = document.getElementById("jumlah");
let tanggal_input = document.getElementById("tanggal_input");
let lihat_data = document.getElementById("lihat_data");
let form_scanBarcode = document.getElementById("form_scanBarcode");
let selectedRows = [];

//#region Load Form

div_tableBarcodeDetail.style.display = "none";
tanggal_input.valueAsDate = new Date();
kode_barcode.focus();
// div_tableBarcodeData.style.display = "none";

$(document).ready(function () {
    $("#table_dataBarcode").DataTable();
});

let table = $("#table_dataBarcode").DataTable({
    processing: true,
    data: data_kodeBarang,
    columns: [
        { data: null },
        { data: "NamaType" },
        { data: "IdType" },
        { data: "Kode_barang" },
        { data: "Qty_Primer" },
        { data: "Qty_Sekunder" },
        { data: "Qty" },
        { data: "Tgl_mutasi" },
    ],
    columnDefs: [
        {
            searchable: false,
            orderable: false,
            targets: 0,
            render: function (data, type, row, meta) {
                return meta.row + 1;
            },
        },
    ],
});

$("#table_dataBarcode tbody").on("click", "tr", function () {
    const table = $("#table_dataBarcode").DataTable();
    table.$("tr.selected").removeClass("selected");
    $(this).addClass("selected");
    const selectedRowData = table.rows(".selected").data().toArray()[0];
    const idType = selectedRowData.IdType;
    const kodeBarang = selectedRowData.Kode_barang;
    const tglMutasi = selectedRowData.Tgl_mutasi;

    fetch(
        "/scanBarcodeDetailData/" + idType + "/" + kodeBarang + "/" + tglMutasi
    )
        .then((response) => response.json())
        .then((data) => {
            // console.log(data);
            div_tableBarcodeDetail.style.display = "block";

            let table = $("#table_detailBarcode").DataTable();
            table.destroy();

            table = $("#table_detailBarcode").DataTable({
                data: data,
                columns: [
                    { data: null },
                    { data: "NoIndeks" },
                    { data: "KodeBarang" },
                    { data: "NamaType" },
                ],
                columnDefs: [
                    {
                        searchable: false,
                        orderable: false,
                        targets: 0,
                        render: function (data, type, row, meta) {
                            return meta.row + 1;
                        },
                    },
                ],
            });
            table.draw();
        });
});

table.draw();

//#endregion

//#region Add Event Listener

kode_barcode.addEventListener("keypress", function (event) {
    if (event.key == "Enter") {
        event.preventDefault();
        if (kode_barcode.value == "") {
            alert("Isi kode barcode lebih dulu!");
            kode_barcode.focus();
        } else {
            // const kode_barcodeParts = kode_barcode.value.split("-");
            // let kodeBarang = kode_barcodeParts[1].padStart(9, "0");
            // let nomorindeks9digit = kode_barcodeParts[0].padStart(9, "0");
            // let nomorIndeks = parseInt(nomorindeks9digit);
            // // console.log(kodeBarang);
            // // console.log(nomorIndeks);

            // let inputKodeBarang = document.createElement("input");
            // inputKodeBarang.type = "hidden";
            // inputKodeBarang.name = "kode_barang";
            // inputKodeBarang.value = kodeBarang;

            // let inputNomorIndeks = document.createElement("input");
            // inputNomorIndeks.type = "hidden";
            // inputNomorIndeks.name = "nomor_indeks";
            // inputNomorIndeks.value = nomorIndeks;

            // form_scanBarcode.appendChild(inputKodeBarang);
            // form_scanBarcode.appendChild(inputNomorIndeks);
            // form_scanBarcode.submit();

            this.value = this.value.replace(/\n/g, ', ');
            form_scanBarcode.submit();
            // console.log(stringWithCommas);
        }
    }
});

lihat_data.addEventListener("click", function (event) {
    event.preventDefault();
    if (tanggal_input.value == "") {
        alert("Isi tanggal terlebih dahulu!");
        tanggal_input.focus();
    } else {
        fetch("/scanBarcodeLihatData/" + tanggal_input.value)
            .then((response) => response.json())
            .then((data) => {
                // console.log(data);
                jumlah.innerHTML = "Jumlah data Barcode: " + data[0][0].total;
                let table = $("#table_dataBarcode").DataTable();
                table.destroy();

                table = $("#table_dataBarcode").DataTable({
                    data: data[1],
                    columns: [
                        { data: null },
                        { data: "NamaType" },
                        { data: "IdType" },
                        { data: "Kode_barang" },
                        { data: "Qty_Primer" },
                        { data: "Qty_Sekunder" },
                        { data: "Qty" },
                        {
                            data: "Tgl_mutasi",
                            render: function (data) {
                                // Get the first 10 characters from the Tgl_mutasi column
                                return data.substring(0, 10);
                            },
                        },
                    ],
                    columnDefs: [
                        {
                            searchable: false,
                            orderable: false,
                            targets: [0, 7],
                            render: function (data, type, row, meta) {
                                return meta.row + 1;
                            }
                        },
                        { targets: [7], className: "nowrap" }, // Apply the "nowrap" class to the 7th (index 6) column (Tgl_mutasi)
                    ],
                });
            });
    }
});
//#endregion
