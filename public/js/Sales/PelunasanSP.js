$(document).ready(function () {
    let csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
    let checkbox_all = document.getElementById("checkbox_all");
    let btn_submitSelected = document.getElementById("btn_submitSelected");
    let table_SP = $("#table_SP").DataTable({
        columnDefs: [{ targets: [0], visible: false }],
    });
    let selectedIDs = new Set();

    table_SP = $("#table_SP").DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        scrollX: true,
        ajax: {
            url: "getDataPelunasanSP",
            dataType: "json",
            type: "GET",
            data: function (d) {
                return $.extend({}, d, {
                    _token: csrfToken,
                });
            },
        },
        columns: [
            {
                data: "IDPesanan",
            },
            {
                data: "IDSuratPesanan",
                render: function (data) {
                    return `<input type="checkbox" name="penerimaCheckbox" value="${data}" /> ${data}`;
                },
            },
            {
                data: "NamaCust",
            },
            {
                data: "NamaType",
            },
            {
                data: "Tgl_Pesan",
                render: function (data, type, row) {
                    if (!data) return "";

                    let dateObj = new Date(data);
                    if (isNaN(dateObj)) return ""; // Handle invalid dates

                    let day = String(dateObj.getDate()).padStart(2, "0");
                    let month = String(dateObj.getMonth() + 1).padStart(2, "0");
                    let year = dateObj.getFullYear();

                    return `${month}-${day}-${year}`; // Format MM-DD-YYYY
                },
            },
            {
                data: "NamaSales",
            },
            {
                data: "Qty",
                render: function (data, type, row) {
                    return data ? numeral(data).format("0") : "0";
                },
            },
            {
                data: "SisaOrder",
                render: function (data) {
                    return data && data !== ".00"
                        ? parseFloat(data).toString()
                        : "0";
                },
            },
            {
                data: "SaldoPrimer",
                render: function (data, type, row) {
                    return numeral(data).format("0.00");
                },
            },
            {
                data: "SaldoSekunder",
                render: function (data, type, row) {
                    return numeral(data).format("0.00");
                },
            },
            {
                data: "SaldoTritier",
                render: function (data, type, row) {
                    return numeral(data).format("0.00");
                },
            },
        ],
        paging: false,
        scrollY: "400px",
        scrollCollapse: true,
        order: [[4, "desc"]],
        // columnDefs: [{ targets: [0], visible: false }],
        columnDefs: [
            {
                targets: 0,
                className: "RDZPaddingTable RDZCenterTable",
                orderable: false,
            },
            {
                targets: 1,
                className: "RDZPaddingTable RDZCenterTable",
            },
            {
                targets: 2,
                className: "RDZPaddingTable RDZCenterTable",
            },
            {
                targets: 3,
                className: "RDZPaddingTable RDZCenterTable",
            },
            { targets: [0], visible: false },
        ],
        drawCallback: function () {
            // Terapkan kembali checkbox yang telah dicentang
            $('input[name="penerimaCheckbox"]').each(function () {
                let rowData = table_SP.row($(this).closest("tr")).data();
                if (selectedIDs.has(rowData.IDPesanan)) {
                    $(this).prop("checked", true);
                }
            });
        },
    });

    let rowDataPertama;
    let rowDataArray = [];
    // Handle checkbox change events
    $("#table_SP tbody").off("change", 'input[name="penerimaCheckbox"]');
    $("#table_SP tbody").on(
        "change",
        'input[name="penerimaCheckbox"]',
        function () {
            rowDataPertama = table_SP.row($(this).closest("tr")).data();

            if (this.checked) {
                selectedIDs.add(rowDataPertama.IDPesanan); // Simpan ID yang dicentang

                // Tambahkan ke array jika belum ada
                if (
                    !rowDataArray.some(
                        (row) => row.IDPesanan === rowDataPertama.IDPesanan
                    )
                ) {
                    rowDataArray.push(rowDataPertama);
                }

                console.log(rowDataArray);
                console.log(rowDataPertama, this, table_SP);
            } else {
                selectedIDs.delete(rowDataPertama.IDPesanan); // Hapus dari daftar

                // Hapus dari array berdasarkan IDPesanan
                rowDataArray = rowDataArray.filter(
                    (row) => row.IDPesanan !== rowDataPertama.IDPesanan
                );

                console.log(rowDataArray);
                console.log(rowDataPertama, this, table_SP);
            }
        }
    );

    // checkbox_all.addEventListener("change", function () {
    //     // Cek apakah checkbox_all dicentang
    //     let isChecked = this.checked;

    //     // Centang atau hilangkan centang semua checkbox penerima
    //     $('input[name="penerimaCheckbox"]').each(function () {
    //         $(this).prop("checked", isChecked).trigger("change");
    //     });
    // });

    btn_submitSelected.addEventListener("click", async function (event) {
        event.preventDefault();
        console.log(rowDataArray);
        let idPesananString = rowDataArray
            .map((item) => item.IDPesanan)
            .join(",");
        console.log(idPesananString);
        // let adaSisaOrder = rowDataArray.some(
        //     (item) => item.SisaOrder !== ".00"
        // );
        // if (adaSisaOrder) {
        //     Swal.fire({
        //         icon: "info",
        //         title: "Info!",
        //         text: "Semua Sisa Order harus 0 (nol).",
        //         showConfirmButton: false,
        //     });
        //     return;
        // }
        if (rowDataArray.length === 0) {
            Swal.fire({
                icon: "info",
                title: "Info!",
                text: "Pilih minimal satu Surat Pesanan untuk dilunasi.",
                showConfirmButton: false,
            });
            return;
        } else {
            Swal.fire({
                title: `Apakah Anda yakin melunasi ${rowDataArray.length} Surat Pesanan?`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya",
                cancelButtonText: "Tidak",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "prosesLunasSP",
                        type: "GET",
                        data: {
                            _token: csrfToken,
                            idPesananString: idPesananString,
                        },
                        success: function (response) {
                            console.log(response);

                            if (response.message) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Success!",
                                    text: response.message,
                                    showConfirmButton: true,
                                }).then(() => {
                                    location.reload();
                                    // document
                                    //     .querySelectorAll("input")
                                    //     .forEach((input) => (input.value = ""));
                                    // $("#table_atas").DataTable().ajax.reload();
                                });
                            } else if (response.error) {
                                Swal.fire({
                                    icon: "info",
                                    title: "Info!",
                                    text: response.error,
                                    showConfirmButton: false,
                                });
                            }
                        },
                        error: function (xhr) {
                            alert(xhr.responseJSON.message);
                        },
                    });
                }
            });
        }
    });
});
