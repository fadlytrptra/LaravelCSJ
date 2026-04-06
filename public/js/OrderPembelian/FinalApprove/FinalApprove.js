jQuery(function ($) {
    //#region Variables
    let csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
    let table = $("#table_Approve").DataTable({
        processing: true,
        responsive: true,
        serverSide: false,
        order: [[2, "desc"]], // index 2 = kolom Tanggal
        ajax: {
            url: "/FinalApprove/getAllSPPB",
            type: "GET",
        },
        columns: [
            {
                data: "No_trans",
                render: function (data, type, full, meta) {
                    return (
                        `<input
                            type="checkbox"
                            class="checkboxNoTrans"
                            value="` +
                        data +
                        `" data-no-sppb="` +
                        full.No_sppb +
                        `"
                            id="checkboxNoTrans` +
                        data +
                        `"
                            style="width:20px;height:20px;"
                        />`
                    );
                },
            },
            { data: "Kd_div" },
            {
                data: "Tgl_order",
                render: function (data, type, full, meta) {
                    return moment(data).format("MM-DD-YYYY");
                },
            },
            { data: "nama_sub_kategori" },
            { data: "NAMA_BRG" },
            {
                data: "Qty",
                render: function (data, type, full, meta) {
                    return (
                        numeral(data).format("0,0.00") + " " + full.Nama_satuan
                    );
                },
            },
            {
                data: "hrg_nego",
                render: function (data, type, full, meta) {
                    return (
                        full.Id_MataUang_BC +
                        " " +
                        numeral(data).format("0,0.0000")
                    );
                },
            },
            { data: "No_sppb" },
            {
                data: "keterangan",
                render: function (data, type, full, meta) {
                    return (
                        data +
                        '</br><span style="white-space: nowrap">Jenis Beli: ' +
                        full.KET +
                        "</span>"
                    );
                },
            },
            { data: "NM_SUP" },
            {
                data: "Direktur",
                render: function (data, type, full, meta) {
                    if (data) {
                        return `<span class="lbl_approved">Approved</span>`;
                    } else {
                        return `<span class="lbl_pending">Pending</span>`;
                    }
                },
            },
        ],
        columnDefs: [
            {
                orderable: false,
                targets: 0,
            },
            {
                targets: [5, 6, 7, 2],
                className: "nowrap",
            },
        ],
        rowCallback: function (row, data) {
            let checked = listChecked.some((x) => x.No_trans === data.No_trans);

            if (checked) {
                $(row).find(".checkboxNoTrans").prop("checked", true);
            }
        },
    });
    let listChecked = [];

    //#endregion

    //#region Functions
    //#endregion

    //#region Event Listener
    $(document).on("click", ".checkboxNoTrans", function (e) {
        let noTrans = $(this).val();
        let noSppb = $(this).data("no-sppb");

        if ($(this).is(":checked")) {
            // prevent duplicate No_trans
            let exists = listChecked.some((item) => item.No_trans === noTrans);

            if (!exists) {
                listChecked.push({
                    No_trans: noTrans,
                    No_sppb: noSppb,
                });
            }
        } else {
            listChecked = listChecked.filter(
                (item) => item.No_trans !== noTrans,
            );
        }
    });

    $(document).on("click", ".checkedAll", function () {
        //proses checked all
        $.ajax({
            url: "/FinalApprove/getAllNoTrans", // 🔥 new endpoint
            type: "GET",
            data: table.ajax.params(), // send filters/search/order
            success: function (res) {
                // res = [{ No_trans, No_sppb }, ...]
                listChecked = res;

                // update current page checkboxes
                table.rows({ page: "current" }).every(function () {
                    let data = this.data();
                    let checked = listChecked.some(
                        (x) => x.No_trans === data.No_trans,
                    );

                    if (checked) {
                        $(this.node())
                            .find(".checkboxNoTrans")
                            .prop("checked", true);
                    }
                });
            },
        });
    });

    $(document).on("click", ".btn_approve", function (e) {
        e.preventDefault();

        if (listChecked.length === 0) {
            Swal.fire({
                icon: "warning",
                title: "Tidak ada data dipilih",
                text: "Silakan pilih data yang ingin di-approve terlebih dahulu.",
            });
            return;
        }

        Swal.fire({
            title: "Konfirmasi Approve",
            text: "Data ini akan diproses sebagai Final Approve. Lanjutkan?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Ya, Approve",
            cancelButtonText: "Batal",
            confirmButtonColor: "#28a745",
            cancelButtonColor: "#6c757d",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/FinalApprove",
                    method: "POST",
                    data: {
                        _token: csrfToken,
                        action: "Approve",
                        checkedBOX: listChecked,
                    },
                    dataType: "json",
                    success: function (response) {
                        if (!response) {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                showConfirmButton: false,
                                timer: 1000,
                                text: "Approve Order failed ",
                                returnFocus: false,
                            });
                        } else {
                            table.ajax.reload();
                            console.log(response);
                            Swal.fire({
                                icon: "success",
                                title: "Success",
                                showConfirmButton: false,
                                timer: 1000,
                                text: response.success,
                                returnFocus: false,
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "Failed to Approve Order.",
                        });
                    },
                });
            }
        });
    });

    $(document).on("click", ".btn_batal", function (e) {
        e.preventDefault();
        if (listChecked.length === 0) {
            Swal.fire({
                icon: "warning",
                title: "Tidak ada data dipilih",
                text: "Silakan pilih data yang ingin dibatalkan terlebih dahulu.",
            });
            return;
        }

        Swal.fire({
            title: "Konfirmasi Pembatalan",
            text: "Data yang dibatalkan tidak akan ditampilkan lagi di Final Approve.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, Batalkan",
            cancelButtonText: "Batal",
        }).then((result) => {
            if (result.isConfirmed) {
                // document.getElementById("actionInput").value = "Dibatalkan";
                // this.closest("form").submit();
                $.ajax({
                    url: "/FinalApprove",
                    method: "POST",
                    data: {
                        _token: csrfToken,
                        action: "Dibatalkan",
                        checkedBOX: listChecked,
                    },
                    dataType: "json",
                    success: function (response) {
                        if (!response) {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                showConfirmButton: false,
                                timer: 1000,
                                text: "Deny Order failed ",
                                returnFocus: false,
                            });
                        } else {
                            console.log(response);
                            table.ajax.reload();
                            Swal.fire({
                                icon: "success",
                                title: "Success",
                                showConfirmButton: false,
                                timer: 1000,
                                text: response.success,
                                returnFocus: false,
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "Failed to Deny Order.",
                        });
                    },
                });
            }
        });
    });
    //#endregion
});
