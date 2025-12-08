var listBiaya1 = document.getElementById('listBiaya1');
var idUang = document.getElementById('idUang');
var symbol = document.getElementById('symbol');

var idCust = document.getElementById('idCust');
var jnsCust = document.getElementById('jnsCust');

var idBank = document.getElementById('idBank');
var jenisBank = document.getElementById('jenisBank');

var idJenisBayar = document.getElementById('idJenisBayar');

var listBiaya = document.getElementById('listBiaya');
var idUang1 = document.getElementById('idUang1');
var symbol1 = document.getElementById('symbol1');

var idBank1 = document.getElementById('idBank1');
var jenisBank1 = document.getElementById('jenisBank1');

var idJenisBayar1 = document.getElementById('idJenisBayar1');

var bln = document.getElementById('bln');
var thn = document.getElementById('thn');

var tgl = document.getElementById('tgl');
var idBKM = document.getElementById('idBKM');
var cust = document.getElementById('cust');
var btnCust = document.getElementById('btnCust');

var mataUang = document.getElementById('mataUang');
var btnMataUang = document.getElementById('btnMataUang');
var uang = document.getElementById('uang');
var kurs = document.getElementById('kurs');

var bank = document.getElementById('bank');
var btnBank = document.getElementById('btnBank');
var jenisBayar = document.getElementById('jenisBayar');
var btnJenisBayar = document.getElementById('btnJenisBayar');

var idPerkiraan = document.getElementById('idPerkiraan');
var perkiraan = document.getElementById('perkiraan');
var btnPerkiraan = document.getElementById('btnPerkiraan');
var uraian = document.getElementById('uraian');

var idBKK = document.getElementById('idBKK');
var mataUang1 = document.getElementById('mataUang1');
var uang1 = document.getElementById('uang1');
var bank1 = document.getElementById('bank1');
var jenisBayar1 = document.getElementById('jenisBayar1');
var btnJenisBayar1 = document.getElementById('btnJenisBayar1');

var idPerkiraan1 = document.getElementById('idPerkiraan1');
var perkiraan1 = document.getElementById('perkiraan1');
var btnPerkiraan1 = document.getElementById('btnPerkiraan1');
var uraian1 = document.getElementById('uraian1');

var btnProses = document.getElementById('btnProses');
var btnBatal = document.getElementById('btnBatal');
var btnTampilBKM = document.getElementById('btnTampilBKM');
var btnTampilBKK = document.getElementById('btnTampilBKK');

var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

var today = new Date().toISOString().slice(0, 10);
tgl.value = today;

document.addEventListener('DOMContentLoaded', function () {
    tgl.focus();
});

// Assign all IDs to variables
var namaCetakBKK = document.getElementById('namaCetakBKK');
var dateCetakBKK = document.getElementById('dateCetakBKK');
var voucherCetakBKK = document.getElementById('voucherCetakBKK');
var descriptionCetakBKK = document.getElementById('descriptionCetakBKK');
var paidCetakBKK = document.getElementById('paidCetakBKK');
var postedCetakBKK = document.getElementById('postedCetakBKK');
var amountBKK = document.getElementById('amountBKK');
var totalAmountBKK = document.getElementById('totalAmountBKK');
var batalNote = document.getElementById('batalNote');
var alasanNote = document.getElementById('alasanNote');

var ket1BKM = document.getElementById('ket1BKM');
var nomerBKM = document.getElementById('nomerBKM');
var tanggalBKM = document.getElementById('tanggalBKM');
var symbolBKM = document.getElementById('symbolBKM');
var nilaiBKM = document.getElementById('nilaiBKM');
var terbilangBKM = document.getElementById('terbilangBKM');
// var bkmDetailsContainer = document.getElementById('bkmDetailsContainer');
var symbolgtBKM = document.getElementById('symbolgtBKM');
var grandTotalBKM = document.getElementById('grandTotalBKM');
var sidoarjoBKM = document.getElementById('sidoarjoBKM');


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

$('#tgl').on('keydown', function (e) {
    if (e.key === 'Enter') {
        e.preventDefault();

        if (tgl.value > today) {
            Swal.fire({
                icon: 'error',
                text: 'Tanggal SALAH!',
            }).then(() => {
                tgl.focus();
            });
            return;
        } else {
            var dateValue = new Date(tgl.value);

            var month = String(dateValue.getMonth() + 1).padStart(2, '0');
            var year = String(dateValue.getFullYear()).slice(-2);

            bln.value = month;
            thn.value = year;
            btnCust.focus();
        }
    }
});

btnCust.addEventListener("click", function (e) {
    try {
        Swal.fire({
            title: 'Customer',
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
                            url: "BKMPengembalianKE/getCust",
                            dataType: "json",
                            type: "GET",
                            data: {
                                _token: csrfToken
                            }
                        },
                        columns: [
                            { data: "NamaCust" },
                            { data: "IdCust" },
                        ],
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
                cust.value = decodeHtmlEntities(result.value.NamaCust.trim());
                idCust.value = decodeHtmlEntities(result.value.IdCust.trim().slice(-5));

                btnMataUang.focus();
            }
        });
    } catch (error) {
        console.error(error);
    }
});

btnMataUang.addEventListener("click", function (e) {
    try {
        Swal.fire({
            title: 'Mata Uang',
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
                        order: [1, "asc"],
                        ajax: {
                            url: "BKMPengembalianKE/getMataUang",
                            dataType: "json",
                            type: "GET",
                            data: {
                                _token: csrfToken
                            }
                        },
                        columns: [
                            { data: "Nama_MataUang" },
                            { data: "Id_MataUang" },
                        ],
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
                idUang.value = decodeHtmlEntities(result.value.Id_MataUang.trim());
                mataUang.value = decodeHtmlEntities(result.value.Nama_MataUang.trim());

                $.ajax({
                    type: 'GET',
                    url: 'BKMPengembalianKE/getSymbol',
                    data: {
                        _token: csrfToken,
                        nama: mataUang.value.trim()
                    },
                    success: function (result) {
                        if (result.length !== 0) {
                            symbol.value = result[0].Symbol ? decodeHtmlEntities(result[0].Symbol) : '';
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error:', error);
                    }
                });

                if (parseInt(idUang.value) !== 1) {
                    kurs.readOnly = false;
                }
                else if (parseInt(idUang.value) === 1) {
                    kurs.readOnly = true;
                }

                uang.focus();
            }
        });
    } catch (error) {
        console.error(error);
    }
});

$('#uang').on('keydown', function (e) {
    if (e.key === 'Enter') {
        e.preventDefault();

        uang.value = numeral(uang.value).format("0,0.00");
        if (numeral(uang.value).value() === 0) {
            Swal.fire({
                icon: 'error',
                text: 'Jumlah Uang TIDAK BOLEH = 0 !',
                returnFocus: false,
            }).then(() => {
                uang.focus();
            });
            return;
        }
        else {
            if (kurs.readOnly === false) {
                kurs.focus();
            }
            else {
                btnBank.focus();
            }
        }
    }
});

$('#kurs').on('keydown', function (e) {
    if (e.key === 'Enter') {
        e.preventDefault();

        kurs.value = numeral(kurs.value).format("0,0.00");
        if (numeral(kurs.value).value() === 0) {
            Swal.fire({
                icon: 'error',
                text: 'Kurs TIDAK BOLEH = 0 !',
                returnFocus: false,
            }).then(() => {
                kurs.focus();
            });
            return;
        }
        else {
            btnBank.focus();
        }
    }
});

btnBank.addEventListener("click", function (e) {
    try {
        Swal.fire({
            title: 'Bank',
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
                            url: "BKMPengembalianKE/getBank",
                            dataType: "json",
                            type: "GET",
                            data: {
                                _token: csrfToken
                            }
                        },
                        columns: [
                            { data: "Id_Bank" },
                            { data: "Nama_Bank" },
                        ],
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
                idBank.value = decodeHtmlEntities(result.value.Id_Bank.trim());
                bank.value = decodeHtmlEntities(result.value.Nama_Bank.trim());

                if (idBank.value !== '') {
                    $.ajax({
                        type: 'GET',
                        url: 'BKMPengembalianKE/getAccBank',
                        data: {
                            _token: csrfToken,
                            idBank: idBank.value
                        },
                        success: function (result) {
                            if (result.length !== 0) {
                                jenisBank.value = result[0].jenis ? decodeHtmlEntities(result[0].jenis.trim()) : '';
                                btnJenisBayar.focus();
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('Error:', error);
                        }
                    });
                }
            }
        });
    } catch (error) {
        console.error(error);
    }
});

btnJenisBayar.addEventListener("click", function (e) {
    try {
        Swal.fire({
            title: 'Jenis Bayar',
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
                            url: "BKMPengembalianKE/getJenisBayar",
                            dataType: "json",
                            type: "GET",
                            data: {
                                _token: csrfToken
                            }
                        },
                        columns: [
                            { data: "Id_Jenis_Bayar" },
                            { data: "Jenis_Pembayaran" },
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
                idJenisBayar.value = decodeHtmlEntities(result.value.Id_Jenis_Bayar.trim());
                jenisBayar.value = decodeHtmlEntities(result.value.Jenis_Pembayaran.trim());

                btnPerkiraan.focus()
            }
        });
    } catch (error) {
        console.error(error);
    }
});

btnPerkiraan.addEventListener("click", function (e) {
    try {
        Swal.fire({
            title: 'Perkiraan',
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
                            url: "BKMPengembalianKE/getPerkiraan",
                            dataType: "json",
                            type: "GET",
                            data: {
                                _token: csrfToken
                            }
                        },
                        columns: [
                            { data: "NoKodePerkiraan" },
                            { data: "Keterangan" },
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
                idPerkiraan.value = decodeHtmlEntities(result.value.NoKodePerkiraan.trim());
                perkiraan.value = decodeHtmlEntities(result.value.Keterangan.trim());

                uraian.focus();
            }
        });
    } catch (error) {
        console.error(error);
    }
});

var IdBank;
$('#uraian').on('keydown', function (e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        if (idBKM.value === '') {
            if (idBank.value === 'KRR1' || idBank.value === 'KRR2') {
                if (idBank.value === 'KRR2') {
                    IdBank = 'KI';
                    pencetUraian(IdBank);
                }
                if (idBank.value = 'KRR1') {
                    IdBank = 'KKM';
                    pencetUraian(IdBank);
                }
            }
            else {
                IdBank = idBank.value;
                pencetUraian(IdBank);
            }

            function pencetUraian(IdBank) {
                $.ajax({
                    type: 'GET',
                    url: 'BKMPengembalianKE/getIdBKM',
                    data: {
                        _token: csrfToken,
                        bank: IdBank.trim(),
                        jenis: 'R',
                        tahun: new Date(tgl.value).getFullYear(),
                    },
                    success: function (result) {
                        if (result) {
                            idBKM.value = decodeHtmlEntities(result.IdBKM);

                            enableBKK();

                            mataUang1.value = mataUang.value;
                            uang1.value = uang.value;
                            bank1.value = bank.value;
                            idBank1.value = idBank.value;
                            jenisBank1.value = jenisBank.value;
                            jenisBayar1.value = jenisBayar.value;

                            btnPerkiraan1.focus();
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }
        }
    }
});

function enableBKK() {
    btnPerkiraan1.disabled = false;
    uraian1.readOnly = false;
}

function disableBKK() {
    btnPerkiraan1.disabled = true;
    uraian1.readOnly = true;
}

btnPerkiraan1.addEventListener("click", function (e) {
    try {
        Swal.fire({
            title: 'Perkiraan',
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
                            url: "BKMPengembalianKE/getPerkiraan",
                            dataType: "json",
                            type: "GET",
                            data: {
                                _token: csrfToken
                            }
                        },
                        columns: [
                            { data: "NoKodePerkiraan" },
                            { data: "Keterangan" },
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
                idPerkiraan1.value = decodeHtmlEntities(result.value.NoKodePerkiraan.trim());
                perkiraan1.value = decodeHtmlEntities(result.value.Keterangan.trim());

                uraian1.focus();
            }
        });
    } catch (error) {
        console.error(error);
    }
});

var IdBank1;
$('#uraian1').on('keydown', function (e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        if (idBKK.value === '') {
            if (idBank1.value === 'KRR1' || idBank1.value === 'KRR2') {
                if (idBank1.value === 'KRR2') {
                    IdBank1 = 'KI';
                    pencetUraian1(IdBank1);
                }
                if (idBank1.value = 'KRR1') {
                    IdBank1 = 'KKK';
                    pencetUraian1(IdBank1);
                }
            }
            else {
                IdBank1 = idBank1.value;
                pencetUraian1(IdBank1);
            }

            function pencetUraian1(IdBank1) {
                $.ajax({
                    type: 'GET',
                    url: 'BKMPengembalianKE/getIdBKK',
                    data: {
                        _token: csrfToken,
                        bank: IdBank1.trim(),
                        tahun: new Date(tgl.value).getFullYear(),
                    },
                    success: function (result) {
                        if (result) {
                            idBKK.value = decodeHtmlEntities(result.IdBKK);

                            btnProses.focus();
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }
        }
    }
});

function updateDateBKK() {
    $.ajax({
        type: 'PUT',
        url: 'BKMLC/updateDateBKK',
        data: {
            _token: csrfToken,
            idBKK: idCetakBKK.value.trim(),
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
        }
    });
}

function updateDateBKM() {
    $.ajax({
        type: 'PUT',
        url: 'BKMLC/updateDateBKM',
        data: {
            _token: csrfToken,
            idBKM: idCetakBKM.value.trim(),
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
        }
    });
}

function updateDataTable(data, angka) {

    if (angka === 1) {
        var tableData = $('#tableData').DataTable();
        tableData.clear();
        data.forEach(function (item) {
            tableData.row.add([
                `<div>
                <input type="checkbox" name="divisiCheckbox" value="${formatDateToMMDDYYYY(item.Tgl_Input)}" />
                <span>${formatDateToMMDDYYYY(item.Tgl_Input)}</span>
            </div>`,
                escapeHtml(item.Id_BKM),
                escapeHtml(item.Id_bank),
                escapeHtml(item.Bank),
                escapeHtml(item.MataUang),
                escapeHtml(item.NamaCust),
                numeral(parseFloat(item.Nilai_Pelunasan)).format("0,0.00"),
                numeral(parseFloat(item.SaldoPelunasan)).format("0,0.00"),
                escapeHtml(item.Id_Pelunasan),
                escapeHtml(item.Jenis_Bank),
                escapeHtml(item.Id_MataUang),
                escapeHtml(item.ID_Cust),
            ]);
        });
        tableData.draw();
    }
    else if (angka === 4) {
        var tableListBKM = $('#tableListBKM').DataTable();

        tableListBKM.clear();
        data.forEach(function (item) {
            tableListBKM.row.add([
                formatDateToMMDDYYYY(item.Tgl_Input),
                escapeHtml(item.Id_BKM),
                numeral(parseFloat(item.Nilai_Pelunasan)).format("0,0.00"),
                item.Terjemahan ? escapeHtml(item.Terjemahan) : '',
            ]);
        });
        tableListBKM.draw();
    }
    else if (angka === 5) {
        var tableListBKK = $('#tableListBKK').DataTable();

        tableListBKK.clear();
        data.forEach(function (item) {
            tableListBKK.row.add([
                formatDateToMMDDYYYY(item.Tgl_Input),
                escapeHtml(item.Id_BKK),
                numeral(parseFloat(item.Nilai_Pembulatan)).format("0,0.00"),
                escapeHtml(item.Terjemahan),
            ]);
        });
        tableListBKK.draw();
    }
}

function printPreview(previewClass) {
    // Hide all content first
    document.querySelectorAll('.preview, .preview2').forEach(function (preview) {
        preview.style.display = "none"; // Hide both previews
    });

    // Show the selected preview
    const previewToPrint = document.querySelector(`.${previewClass}`);
    previewToPrint.style.display = "block"; // Show the selected preview

    // Print the current view
    window.print();

    // Reset the display after printing
    previewToPrint.style.display = "none"; // Hide the preview again
}

let isTableListBKKInitialized = false; // Flag for BKK table
let isTableListBKMInitialized = false; // Flag for BKM table
// Function to initialize both tables
function initializeTables() {
    if (!isTableListBKKInitialized) {
        // Initialize tableListBKK
        $('#tableListBKK').DataTable({
            paging: false,
            searching: true,
            info: false,
            ordering: false,
            scrollY: '200px',
            scrollX: true,
            autoWidth: false,
            columns: [
                { title: 'Tgl. Input' },
                { title: 'Id. BKK' },
                { title: 'Nilai Pembulatan' },
                { title: 'Terbilang' },
            ],
            columnDefs: [
                { targets: [0, 1, 2, 3], width: '25%', className: 'fixed-width' }
            ]
        });
        isTableListBKKInitialized = true; // Mark as initialized
    }

    if (!isTableListBKMInitialized) {
        // Initialize tableListBKM
        $('#tableListBKM').DataTable({
            paging: false,
            searching: true,
            info: false,
            ordering: false,
            scrollY: '200px',
            scrollX: true,
            autoWidth: false,
            columns: [
                { title: 'Tgl. Input' },
                { title: 'Id. BKM' },
                { title: 'Nilai Pelunasan' },
                { title: 'Terbilang' },
            ],
            columnDefs: [
                { targets: [0, 1, 2, 3], width: '25%', className: 'fixed-width' }
            ]
        });
        isTableListBKMInitialized = true; // Mark as initialized
    }
}

// Event listener for displaying BKM modal
btnTampilBKM.addEventListener('click', function () {
    tglAwalBKM.value = today;
    tglAkhirBKM.value = today;
    idCetakBKM.value = '';

    $('#modalListBKM').on('shown.bs.modal', function () {
        // Initialize both tables if not done already
        initializeTables();

        $.ajax({
            type: 'GET',
            url: 'BKMPengembalianKE/getListFullBKM',
            data: {
                _token: csrfToken,
            },
            success: function (result) {
                if (result.length !== 0) {
                    updateDataTable(result, 4);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });

        // Clear the BKM table when opening the modal
        var tableBKM = $('#tableListBKM').DataTable();
        tableBKM.clear().draw();
        tglAwalBKM.focus();
    });

    $('#modalListBKM').modal('show');
});

btnOkBKM.addEventListener('click', function () {
    var table = $('#tableListBKM').DataTable();
    table.clear().draw();

    $.ajax({
        type: 'GET',
        url: 'BKMPengembalianKE/getListBKM',
        data: {
            _token: csrfToken,
            tgl1: tglAwalBKM.value,
            tgl2: tglAkhirBKM.value
        },
        success: function (result) {
            if (result.length !== 0) {
                updateDataTable(result, 4);
            }
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
        }
    });
});

$('#tableListBKM tbody').on('click', 'tr', function () {
    var table = $('#tableListBKM').DataTable();
    table.$('tr.selected').removeClass('selected');
    $(this).addClass('selected');

    var data = table.row(this).data();

    idCetakBKM.value = decodeHtmlEntities(data[1]);
});

btnCetakBKM.addEventListener('click', function () {
    if (idCetakBKM.value === '') {
        Swal.fire({
            icon: 'error',
            text: 'Pilih 1 Id.BKM Untuk DiCetak!',
            returnFocus: false
        });
        return;
    }
    else {
        $.ajax({
            type: 'GET',
            url: 'BKMPengembalianKE/getCetakBKM',
            data: {
                _token: csrfToken,
                id_bkm: idCetakBKM.value
            },
            success: function (result) {
                if (result.length !== 0) {
                    let totalBKM = 0;
                    var bkmDetailsContainer = document.getElementById("bkmDetailsContainer");

                    bkmDetailsContainer.innerHTML = "";

                    if (result[0].Id_Bank === 'KRR2' || result[0].Id_Bank === 'KRR1') {
                        ket1BKM.innerHTML = '<h5><b>BUKTI PENERIMAAN KAS</b></h5>';
                    }
                    else {
                        ket1BKM.innerHTML = '<h5><b>BUKTI PENERIMAAN BANK</b></h5>';
                    }

                    nomerBKM.innerHTML = '<h5><b>Nomer: ' + decodeHtmlEntities(result[0].Id_BKM) + '</b></h5>';

                    var date = new Date(result[0].Tgl_Input);

                    var monthNames = [
                        "January", "February", "March", "April", "May", "June",
                        "July", "August", "September", "October", "November", "December"
                    ];

                    var day = date.getDate();
                    var month = monthNames[date.getMonth()];
                    var year = date.getFullYear();
                    var formattedDate = day + '/' + month + '/' + year;

                    tanggalBKM.innerHTML = '<h5><b>Tanggal: ' + formattedDate + '</b></h5>';

                    symbolBKM.textContent = decodeHtmlEntities(result[0].Symbol);
                    nilaiBKM.textContent = numeral(parseFloat(result[0].Nilai_Pelunasan)).format("0,0.00");

                    terbilangBKM.textContent = decodeHtmlEntities(result[0].Terjemahan);

                    result.forEach(function (item, index) {
                        var row = document.createElement("div");
                        row.classList.add("row");
                        row.style.width = "95%";

                        // COA column
                        var coaCol = document.createElement("div");
                        coaCol.classList.add("col-sm-7", "text-left");
                        coaCol.style.borderLeft = "1px solid black";  // Border kiri

                        // Variabel item yang berisi properti yang akan digunakan
                        var namaCust = item.NamaCust;
                        var uraian = item.Uraian;

                        if (namaCust === '-') {
                            coaCol.textContent = decodeHtmlEntities(uraian);
                        } else if (namaCust !== '-' && uraian !== 'UANG MUKA (DP)') {
                            coaCol.textContent = decodeHtmlEntities(namaCust + ' - ' + uraian);
                        } else if (namaCust !== '-' && uraian === 'UANG MUKA (DP)') {
                            coaCol.textContent = decodeHtmlEntities(namaCust + ' - UANG TITIPAN');
                        }

                        row.appendChild(coaCol);

                        // Account Name column
                        var accountCol = document.createElement("div");
                        accountCol.classList.add("col-sm-2", "text-center");
                        accountCol.style.borderLeft = "1px solid black";  // Border kiri
                        accountCol.style.borderRight = "1px solid black";  // Border kiri
                        accountCol.textContent = decodeHtmlEntities(item.KodePerkiraan);
                        row.appendChild(accountCol);

                        // Description column
                        var descriptionCol = document.createElement("div");
                        descriptionCol.classList.add("col-sm-3", "text-right");
                        descriptionCol.style.borderRight = "1px solid black"; // Border kanan
                        descriptionCol.textContent = numeral(item.Nilai_Rincian).format("0,0.00");
                        row.appendChild(descriptionCol);

                        bkmDetailsContainer.appendChild(row);

                        if (index === result.length - 1) {
                            coaCol.style.borderBottom = "1px solid black";         // Border bawah
                            accountCol.style.borderBottom = "1px solid black";     // Border bawah
                            descriptionCol.style.borderBottom = "1px solid black";
                        }
                    });

                    symbolgtBKM.textContent = decodeHtmlEntities(result[0].Symbol);
                    grandTotalBKM.textContent = numeral(parseFloat(result[0].totalNilaiRincian)).format("0,0.00");

                    var today = new Date();
                    var day = today.getDate();
                    var month = monthNames[today.getMonth()];
                    var year = today.getFullYear();

                    var formattedToday = day + '/' + month + '/' + year;

                    sidoarjoBKM.innerHTML = "<h5><b>Sidoarjo, " + formattedToday + "</b></h5>";

                    printPreview('preview');
                    updateDateBKM();
                }
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });

    }
});

btnTampilBKK.addEventListener('click', function () {
    tglAwalBKK.value = today;
    tglAkhirBKK.value = today;
    idCetakBKK.value = '';

    $('#modalListBKK').on('shown.bs.modal', function () {
        initializeTables();

        $.ajax({
            type: 'GET',
            url: 'BKMPengembalianKE/getListFullBKK',
            data: {
                _token: csrfToken,
            },
            success: function (result) {
                if (result.length !== 0) {
                    updateDataTable(result, 5);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });

        var tableBKK = $('#tableListBKK').DataTable();
        tableBKK.clear().draw();
        tglAwalBKK.focus();
    });

    $('#modalListBKK').modal('show');
});

btnOkBKK.addEventListener('click', function () {
    var table = $('#tableListBKK').DataTable();
    table.clear().draw();

    $.ajax({
        type: 'GET',
        url: 'BKMPengembalianKE/getListBKK',
        data: {
            _token: csrfToken,
            tgl1: tglAwalBKK.value,
            tgl2: tglAkhirBKK.value
        },
        success: function (result) {
            if (result.length !== 0) {
                updateDataTable(result, 5);
            }
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
        }
    });
});

$('#tableListBKK tbody').on('click', 'tr', function () {
    var table = $('#tableListBKK').DataTable();
    table.$('tr.selected').removeClass('selected');
    $(this).addClass('selected');

    var data = table.row(this).data();

    idCetakBKK.value = decodeHtmlEntities(data[1]);
});

btnCetakBKK.addEventListener('click', function () {
    if (idCetakBKK.value === '') {
        Swal.fire({
            icon: 'error',
            text: 'Pilih 1 Id.BKK Untuk DiCetak!',
            returnFocus: false
        });
        return;
    }
    else {
        $.ajax({
            type: 'GET',
            url: 'BKMPengembalianKE/getCetakBKK',
            data: {
                _token: csrfToken,
                id_bkk: idCetakBKK.value
            },
            success: function (result) {
                if (result.length !== 0) {
                    let totalBKM = 0;
                    var bkmDetailsContainer = document.getElementById("bkkDetailsContainer");

                    bkmDetailsContainer.innerHTML = "";

                    namaCetakBKK.textContent = ': ' + decodeHtmlEntities(result[0].Id_bank);
                    voucherCetakBKK.textContent = ': ' + decodeHtmlEntities(result[0].Id_BKK);
                    descriptionCetakBKK.textContent = ": " + decodeHtmlEntities(result[0].Nama_Bank);
                    var today = new Date();

                    var options = { year: 'numeric', month: 'short', day: 'numeric' };
                    var formattedToday = today.toLocaleDateString('en-GB', options).replace(/ /g, '-');
                    postedCetakBKK.textContent = ": " + formattedToday;

                    var date = new Date(result[0].Tgl_Input);
                    var options = { year: 'numeric', month: 'short', day: 'numeric' };
                    var formattedDate = date.toLocaleDateString('en-GB', options).replace(/ /g, '-');
                    dateCetakBKK.textContent = ": " + formattedDate;

                    paidCetakBKK.textContent = ": " + result[0].NM_SUP ? decodeHtmlEntities(result[0].NM_SUP) : '';

                    if (result[0].Batal && result[0].Batal.trim() !== '') {
                        batalNote.textContent = 'BATAL: ' + decodeHtmlEntities(result[0].Batal);
                        batalNote.style.display = 'inline';
                    } else {
                        batalNote.style.display = 'none';
                    }

                    if (result[0].Alasan && result[0].Alasan.trim() !== '') {
                        alasanNote.textContent = 'ALASAN: ' + decodeHtmlEntities(result[0].Alasan);
                        alasanNote.style.display = 'inline';
                    } else {
                        alasanNote.style.display = 'none';
                    }

                    result.forEach(function (item, index) {
                        var row = document.createElement("div");
                        row.classList.add("row");

                        // COA column
                        var coaCol = document.createElement("div");
                        coaCol.classList.add("col-sm-2", "text-left");
                        coaCol.textContent = decodeHtmlEntities(item.KodePerkiraan);
                        row.appendChild(coaCol);

                        // Account Name column
                        var accountCol = document.createElement("div");
                        accountCol.classList.add("col-sm-3", "text-left");
                        accountCol.textContent = decodeHtmlEntities(item.Keterangan);
                        row.appendChild(accountCol);

                        // Description column
                        var descriptionCol = document.createElement("div");
                        descriptionCol.classList.add("col-sm-3", "text-left");
                        descriptionCol.textContent = decodeHtmlEntities(item.Rincian_Bayar);
                        row.appendChild(descriptionCol);

                        // Description column
                        var cekBgCol = document.createElement("div");
                        cekBgCol.classList.add("col-sm-2", "text-left");
                        cekBgCol.textContent = decodeHtmlEntities(item.No_BGCek);
                        row.appendChild(cekBgCol);

                        // Amount column
                        var amountCol = document.createElement("div");
                        amountCol.classList.add("col-sm-2", "text-right");
                        amountCol.textContent = numeral(parseFloat(item.Nilai_Rincian)).format("0,0.00");
                        row.appendChild(amountCol);

                        // Append the row to the container
                        bkmDetailsContainer.appendChild(row);

                        // Update the total
                        totalBKM += parseFloat(item.Nilai_Rincian);

                        // Add underline class only to the last row
                        if (index === result.length - 1) {
                            coaCol.classList.add("underline");
                            accountCol.classList.add("underline");
                            cekBgCol.classList.add("underline");
                            descriptionCol.classList.add("underline");
                            amountCol.classList.add("underline");
                        }
                    });

                    amountBKK.textContent = 'Amount ' + decodeHtmlEntities(result[0].Symbol)
                    totalAmountBKK.textContent = numeral(parseFloat(totalBKM)).format("0,0.00");

                    printPreview('preview2');
                    updateDateBKK();
                }
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });

    }
});

btnProses.addEventListener('click', function () {
    var id_bkm, idbkk, nilai, nilai1;
    var id, id1, Konversi, Konversi2;
    var IdPembayaran;
    var total1, total2;

    // Assign values
    id = idBKM.value.substring(0, 3);
    id1 = idBKK.value.substring(0, 3);
    id_bkm = isNaN(parseInt(id)) ? 0 : parseInt(id);
    idbkk = isNaN(parseInt(id1)) ? 0 : parseInt(id1);
    nilai = 0;
    nilai1 = 0;

    if (idBKK.value !== '' && idBKM.value !== '') {
        async function konversiDanProses() {
            nilai1 = numeral(uang.value).value();

            if (parseInt(idUang.value) === 1) {
                Konversi = await convertNumberToWordsRupiah(nilai1);
            } else {
                Konversi = await convertNumberToWordsDollar(nilai1);
            }

            nilai = numeral(uang1.value).value();

            if (parseInt(idUang1.value) === 1) {
                Konversi2 = await convertNumberToWordsRupiah(nilai);
            } else {
                Konversi2 = await convertNumberToWordsDollar(nilai);
            }

            // Make sure AJAX requests run only after the conversions
            await prosesBKM();
            await prosesBKK();
        }

        // Panggil function utama
        konversiDanProses().then(() => {
            Swal.fire({
                icon: 'success',
                text: "Data BKM Dengan No." + idBKM.value + " & BKK No. " + idBKK.value + " TerSimpan",
                returnFocus: false
            });
        });

    } else {
        Swal.fire({
            icon: 'error',
            text: "Tidak Ada Yg diPROSES!",
            returnFocus: false
        });
    }

    async function prosesBKM() {
        console.log(Konversi); // Make sure Konversi is logged

        return $.ajax({
            type: 'PUT',
            url: 'BKMPengembalianKE/insertBKM',
            data: {
                _token: csrfToken,
                idBKM: idBKM.value,
                tglinput: tgl.value,
                terjemahan: Konversi,
                nilaipelunasan: nilai1,
                IdBank: idBank.value,
                tgl: tgl.value,
                idUang: idUang.value,
                idJenis: idJenisBayar.value,
                idBank: idBank.value,
                kodeperkiraan: idPerkiraan.value,
                uraian: uraian.value,
                Kurs: numeral(kurs.value).value(),
                idCust: idCust.value,
                idbkm: id_bkm,
                jenis: jenisBank.value,
                tgl2: String(bln.value) + String(thn.value),
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }

    async function prosesBKK() {
        return $.ajax({
            type: 'PUT',
            url: 'BKMPengembalianKE/insertBKK',
            data: {
                _token: csrfToken,
                idBKK: idBKK.value,
                tgl: tgl.value,
                terjemahan: Konversi2,
                nilaipelunasan: nilai,
                IdBank: idBank1.value,
                idUang: idUang.value,
                idJenis: idJenisBayar.value,
                idBank: idBank1.value,
                nilai: nilai,
                kurs: numeral(kurs.value).value(),
                idBKM_acuan: idBKM.value,
                keterangan: uraian1.value,
                biaya: nilai,
                kodeperkiraan: idPerkiraan1.value,
                idbkk: idbkk,
                jenis: jenisBank1.value,
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }
});
