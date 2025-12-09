// Inisialisasi elemen-elemen ke dalam variabel
var tanggal1 = document.getElementById('tanggal1');
var tanggal2 = document.getElementById('tanggal2');
var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

var idSupplier = document.getElementById('idSupplier');
var supplier = document.getElementById('supplier');
var btnSupplier = document.getElementById('btnSupplier');

var btnProses = document.getElementById('btnProses');
var btnPerbaiki = document.getElementById('btnPerbaiki');
var btnKeluar = document.getElementById('btnKeluar');

const tanggalPenagihan = new Date();
const formattedDate2 = tanggalPenagihan.toISOString().substring(0, 10);
tanggal1.value = formattedDate2;
tanggal2.value = formattedDate2;

function handleTableKeydown(e, tableId) {
    const table = $(`#${tableId}`).DataTable();
    const rows = $(`#${tableId} tbody tr`);
    const rowCount = rows.length;

    if (e.key === "Enter") {
        e.preventDefault();
        const selectedRow = table.row(".selected").data();
        if (selectedRow) {
            Swal.getConfirmButton().click();
        } else {
            const firstRow = $(`#${tableId} tbody tr:first-child`);
            if (firstRow.length) {
                firstRow.click();
                Swal.getConfirmButton().click();
            }
        }
    }
    else if (e.key === "ArrowDown") {
        e.preventDefault();
        if (currentIndex === null || currentIndex >= rowCount - 1) {
            currentIndex = 0;
        } else {
            currentIndex++;
        }
        rows.removeClass("selected");
        const selectedRow = $(rows[currentIndex]).addClass("selected");
        scrollRowIntoView(selectedRow[0]);
    }
    else if (e.key === "ArrowUp") {
        e.preventDefault();
        if (currentIndex === null || currentIndex <= 0) {
            currentIndex = rowCount - 1;
        } else {
            currentIndex--;
        }
        rows.removeClass("selected");
        const selectedRow = $(rows[currentIndex]).addClass("selected");
        scrollRowIntoView(selectedRow[0]);
    }
    else if (e.key === "ArrowRight") {
        e.preventDefault();
        const pageInfo = table.page.info();
        if (pageInfo.page < pageInfo.pages - 1) {
            table.page('next').draw('page').on('draw', function () {
                currentIndex = 0;
                const newRows = $(`#${tableId} tbody tr`);
                const selectedRow = $(newRows[currentIndex]).addClass("selected");
                scrollRowIntoView(selectedRow[0]);
            });
        }
    }
    else if (e.key === "ArrowLeft") {
        e.preventDefault();
        const pageInfo = table.page.info();
        if (pageInfo.page > 0) {
            table.page('previous').draw('page').on('draw', function () {
                currentIndex = 0;
                const newRows = $(`#${tableId} tbody tr`);
                const selectedRow = $(newRows[currentIndex]).addClass("selected");
                scrollRowIntoView(selectedRow[0]);
            });
        }
    }
}

// Helper function to scroll selected row into view
function scrollRowIntoView(rowElement) {
    rowElement.scrollIntoView({ block: 'nearest' });
}

function formatDateToMMDDYYYY(date) {
    let dateObj = new Date(date);
    if (isNaN(dateObj)) {
        return '';
    }

    let month = (dateObj.getMonth() + 1).toString().padStart(2, '0');
    let day = dateObj.getDate().toString().padStart(2, '0');
    let year = dateObj.getFullYear();

    return `${month}/${day}/${year}`;
}

function decodeHtmlEntities(text) {
    var txt = document.createElement("textarea");
    txt.innerHTML = text;
    return txt.value;
}

function escapeHtml(text) {
    var map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, function (m) { return map[m]; });
}

btnSupplier.addEventListener("click", function (e) {
    try {
        Swal.fire({
            title: 'Supplier',
            html: `
                <table id="table_list" class="table">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            `,
            preConfirm: () => {
                const selectedData = $("#table_list")
                    .DataTable()
                    .row(".selected")
                    .data();
                if (!selectedData) {
                    Swal.showValidationMessage("Please select a row");
                    return false;
                }
                return selectedData;
            },
            width: '40%',
            returnFocus: false,
            showCloseButton: true,
            showConfirmButton: true,
            confirmButtonText: 'Select',
            didOpen: () => {
                $(document).ready(function () {
                    const table = $("#table_list").DataTable({
                        responsive: true,
                        processing: true,
                        serverSide: true,
                        paging: false,
                        scrollY: '400px',
                        scrollCollapse: true,
                        order: [0, "asc"],
                        ajax: {
                            url: "KartuHutang/getSupplier",
                            dataType: "json",
                            type: "GET",
                            data: {
                                _token: csrfToken
                            }
                        },
                        columns: [
                            { data: "NM_SUP" },
                            { data: "NO_SUP" },
                        ],
                        // columnDefs: [
                        //     {
                        //         targets: 0,
                        //         width: '100px',
                        //     }
                        // ]
                    });

                    $("#table_list tbody").on("click", "tr", function () {
                        table.$("tr.selected").removeClass("selected");
                        $(this).addClass("selected");
                        scrollRowIntoView(this);
                    });

                    const searchInput = $('#table_list_filter input');
                    if (searchInput.length > 0) {
                        searchInput.focus();
                    }

                    currentIndex = null;
                    Swal.getPopup().addEventListener('keydown', (e) => handleTableKeydown(e, 'table_list'));
                });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                idSupplier.value = decodeHtmlEntities(result.value.NO_SUP.trim());
                supplier.value = decodeHtmlEntities(result.value.NM_SUP.trim());
            }
        });
    } catch (error) {
        console.error(error);
    }
});

btnPerbaiki.addEventListener("click", function (e) {
    $.ajax({
        type: 'PUT',
        url: 'KartuHutang/perbaiki',
        data: {
            _token: csrfToken,
            tanggal_awal: tanggal1.value,
            id_supplier: idSupplier.value
        },
        success: function (response) {
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    text: "sudah selesai",
                    returnFocus: false
                });
            }
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
        }
    });
});

btnProses.addEventListener("click", function (e) {
    $.ajax({
        type: 'PUT',
        url: 'KartuHutang/proses',
        data: {
            _token: csrfToken,
            IdSupp: idSupplier.value,
            Tgl1: tanggal1.value,
            Tgl2: tanggal2.value
        },
        success: function (response) {
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    text: "sudah selesai",
                    returnFocus: false
                });
            }
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
        }
    });
});