var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

let tahun = document.getElementById('tahun');
let bulan = document.getElementById('bulan');
let kursRupiah = document.getElementById('kursRupiah');
let idbkm = document.getElementById('idbkm');
let idPelunasan = document.getElementById('idPelunasan');

let btnOK = document.getElementById("btnOK");
let btnPilihBKM = document.getElementById('btnPilihBKM');
let btnProses = document.getElementById("btnProses");

let formkoreksi = document.getElementById("formkoreksi");
let methodkoreksi = document.getElementById("methodkoreksi");

let rowDataPertama;
kursRupiah.value = 0;

bulan.focus();
bulan.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        tahun.focus();
    }
});

tahun.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        btnOK.focus();
    }
});

function initializeDataTable(data) {
    if ($.fn.DataTable.isDataTable('#tableData')) {
        $('#tableData').DataTable().clear().destroy();
    }

    tableData = $('#tableData').DataTable({
        paging: false,
        searching: false,
        info: false,
        ordering: false,
        data: data,
        scrollY: data.length > 0 ? '300px' : '',
        autoWidth: false,
        columns: [
            {
                title: 'Tgl. Input',
                render: function (data) {
                    return `<input type="checkbox" name="penerimaCheckbox" value="${data}" /> ${data}`;
                }
            },
            { title: 'ID BKM' },
            { title: 'ID Bank' },
            { title: 'Nilai Pelunasan' },
            { title: 'Rincian Pelunasan' },
            { title: 'Kode Perkiraan' },
            { title: 'Uraian' }
        ],
        columnDefs: [
            { targets: 0, width: '10%' },
            { targets: 1, width: '10%' },
            { targets: 2, width: '10%' },
            { targets: 3, width: '15%' },
            { targets: 4, width: '15%' },
            { targets: 5, width: '10%' },
            { targets: 6, width: '15%' }
        ]
    });
}
initializeDataTable([]);

function fetchDataPelunasan() {
    $.ajax({
        url: "MaintenanceUpdateKursBKM/getDataPelunasan",
        type: "GET",
        dataType: "json",
        data: {
            _token: csrfToken,
            bulan: bulan.value,
            tahun: tahun.value
        },
        success: function (json) {
            if (json.data.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Tidak Ada Data BKM',
                    returnFocus: false
                });
            } else {
                const tableData = json.data.map(item => [
                    item.Tgl_Input,
                    item.Id_BKM,
                    item.Id_bank,
                    item.Nilai_Pelunasan,
                    item.RincianPelunasan,
                    item.KodePerkiraan,
                    item.Uraian,
                    item.Id_Pelunasan,
                ]);
                initializeDataTable(tableData);
            }
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
        }
    });
}

function escapeHtml(text) {
    return text
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

btnOK.addEventListener('click', function (event) {
    event.preventDefault();
    if (bulan.value === '' && tahun.value === '') {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Isi Dulu Bulan & Tahun!!',
            returnFocus: false
        }).then(() => {
            bulan.focus();
        })
    } else {
        fetchDataPelunasan();
    }
});

let rowDataArray = [];

// Handle checkbox change events
$("#tableData tbody").off("change", 'input[name="penerimaCheckbox"]');
$("#tableData tbody").on(
    "change",
    'input[name="penerimaCheckbox"]',
    function () {
        if (this.checked) {
            $('input[name="penerimaCheckbox"]')
                .not(this)
                .prop("checked", false);
            rowDataPertama = tableData
                .row($(this).closest("tr"))
                .data();

            // Add the selected row data to the array
            rowDataArray.push(rowDataPertama);

            console.log(rowDataArray);
            console.log(rowDataPertama, this, tableData);


        } else {
            // Remove the unchecked row data from the array
            rowDataPertama = null;
            rowDataArray = rowDataArray.filter(
                (row) => row !== rowDataPertama
            );

            console.log(rowDataArray);
            console.log(rowDataPertama, this, tableData);
        }
    }
);
function decodeHtmlEntities(str) {
    var textArea = document.createElement('textarea');
    textArea.innerHTML = str;
    return textArea.value;
}

btnPilihBKM.addEventListener('click', function (event) {
    event.preventDefault();
    console.log(rowDataArray);

    idPelunasan.value = decodeHtmlEntities(rowDataArray[0][7]);
    idbkm.value = decodeHtmlEntities(rowDataArray[0][1]);
    kursRupiah.focus();

    console.log(idbkm.value);
    console.log(idPelunasan.value);
});

kursRupiah.addEventListener("keypress", function (event) {
    if (event.key == "Enter") {
        event.preventDefault();
        kursRupiah.value = parseFloat(kursRupiah.value.replace(/[^0-9.]/g, '')).toFixed(2).replace(/\d(?=(\d{10})+\.)/g, '$&,');

        if (kursRupiah.value === 0.00 || kursRupiah.value === '0.00') {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Kurs TIDAK BOLEH = 0 !',
                returnFocus: false
            }).then(() => {
                kursRupiah.select();
            });
        } else {
            btnProses.focus();
        }
    }
});

btnProses.addEventListener('click', function (event) {
    $.ajax({
        type: 'PUT',
        url: 'MaintenanceUpdateKursBKM/proses',
        data: {
            _token: csrfToken,
            idPelunasan: idPelunasan.value,
            idbkm: idbkm.value,
            kursRupiah: kursRupiah.value
        },
        success: function (response) {
            console.log(response);

            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    html: response.success,
                    returnFocus: false
                }).then(() => {
                    kursRupiah.value = 0;
                    fetchDataPelunasan();
                });
            }
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
        }
    });

})

