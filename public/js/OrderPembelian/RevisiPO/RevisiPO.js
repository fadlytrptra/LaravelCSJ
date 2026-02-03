jQuery(function ($) {
    //#region Variables
    let csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
    let table = $("#table_Revisi").DataTable({
        processing: true,
        responsive: true,
        serverSide: true,
        order: [[2, "desc"]], // index 2 = kolom Tanggal
        ajax: {
            url: "/RevisiPO/getAllSPPB",
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
                    return numeral(data).format("0,0.00");
                },
            },
            { data: "Nama_satuan" },
            {
                data: "HargaPerkiraan",
                render: function (data, type, full, meta) {
                    return numeral(data).format("0,0.0000");
                },
            },
            { data: "No_sppb" },
            { data: "keterangan" },
            { data: "Kd_brg" },
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
                targets: [8, 2],
                className: "nowrap",
            },
        ],
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

        console.log(noTrans);
        console.log(listChecked);
    });

    $(document).on("click", ".btn_revisi", function (e) {
        e.preventDefault();
        console.log(listChecked);

        if (listChecked.length === 0) {
            Swal.fire({
                icon: "warning",
                title: "Tidak ada data dipilih",
                text: "Silakan pilih data yang ingin di-revisi terlebih dahulu.",
            });
            return;
        }

        // ambil No_sppb pertama sebagai pembanding
        const firstNoSppb = listChecked[0].No_sppb;

        // cek apakah ada yang berbeda
        const hasDifferentNoSppb = listChecked.some(
            (item) => item.No_sppb !== firstNoSppb,
        );

        if (hasDifferentNoSppb) {
            Swal.fire({
                icon: "warning",
                title: "Nomor PO berbeda.",
                text: "Silahkan memilih data dengan nomor PO yang sama untuk direvisi.",
            });
            return;
        }
        console.log(listChecked);
        const noTransList = listChecked.map((item) => item.No_trans);

        Swal.fire({
            title: "Konfirmasi Revisi",
            text:
                "Sistem akan membuat SPPB baru untuk nomor transaksi " +
                noTransList +
                " dengan Purchase Order " +
                firstNoSppb.trim() +
                ". Lanjutkan?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Ya, Revisi",
            cancelButtonText: "Batal",
            confirmButtonColor: "#f0ad4e",
            cancelButtonColor: "#6c757d",
        }).then((result) => {
            if (result.isConfirmed) {
                // proses revisi masuk controller final approve
                $.ajax({
                    url: "/FinalApprove",
                    method: "POST",
                    data: {
                        _token: csrfToken,
                        action: "Revisi",
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
                                text: "Revise Order failed ",
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
                            text: "Failed to Revise Order.",
                        });
                    },
                });
            }
        });
    });
    //#endregion
});
