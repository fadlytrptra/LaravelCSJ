var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

let tanggal = document.getElementById('tanggal');
let namaCustomer = document.getElementById('namaCustomer');
let id_penagihan = document.getElementById('id_penagihan');
let statusPPN = document.getElementById('statusPPN');
let jnsNotaKredit = document.getElementById('jnsNotaKredit');
let btnCetak = document.getElementById('btnCetak');
let btn_cust = document.getElementById('btn_cust');
let xnomor = '';

let notaKreditPPN = document.querySelector(".notaKreditPPN");
let notaKredit = document.querySelector(".notaKredit");
let notanotaSelisihPPN = document.querySelector(".notanotaSelisihPPN");
let notanotaSelisih = document.querySelector(".notanotaSelisih");



tanggal.valueAsDate = new Date();
btn_cust.focus();

tanggal.addEventListener("keypress", function (event) {
    if (event.key == "Enter") {
        btn_cust.focus();
    }
});

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

function scrollRowIntoView(rowElement) {
    rowElement.scrollIntoView({ block: 'nearest' });
}

function decodeHtmlEntities(text) {
    var txt = document.createElement("textarea");
    txt.innerHTML = text;
    return txt.value;
}

btn_cust.addEventListener("click", function (e) {
    e.preventDefault();
    try {
        Swal.fire({
            title: 'Customer',
            html: `
                <table id="table_list" class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID Nota</th>
                            <th scope="col">Nama Customer</th>
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
                const table = $("#table_list").DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    paging: false,
                    scrollY: '400px',
                    scrollCollapse: true,
                    order: [0, "asc"],
                    ajax: {
                        url: "CetakNotaKredit/getCustomer",
                        dataType: "json",
                        type: "GET",
                        data: {
                            _token: csrfToken,
                            tanggal: tanggal.value
                        }
                    },
                    columns: [
                        { data: "Id_NotaKredit" },
                        { data: "NamaCust" }
                    ]
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
            }
        }).then((result) => {
            if (result.isConfirmed) {
                console.log(result);

                id_penagihan.value = result.value.Id_NotaKredit.trim();
                namaCustomer.value = decodeHtmlEntities(result.value.NamaCust.trim());

                if (id_penagihan.value !== '') {
                    DisplaySuratJalan(id_penagihan.value);
                    DisplayDetail(id_penagihan.value);

                    btnCetak.focus();
                }
            }
        });
    } catch (error) {
        console.error(error);
    }
});

function DisplaySuratJalan(idtagih) {
    $.ajax({
        type: 'GET',
        url: 'CetakNotaKredit/getSuratJalan',
        data: {
            _token: csrfToken,
            id_penagihan: idtagih
        },
        success: function (result) {
            console.log(result);
            result.forEach(function (item, index) {
                if (xnomor !== '') {
                    xnomor += ', ';
                }
                xnomor += item.SuratJalan;
            });

            console.log('xnomor: ', xnomor);

        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
        }
    });
}

function DisplayDetail(idtagih) {
    $.ajax({
        type: 'GET',
        url: 'CetakNotaKredit/getDetil',
        data: {
            _token: csrfToken,
            id_penagihan: idtagih
        },
        success: function (result) {
            console.log(result);
            if (result.length > 0) {
                statusPPN.value = result[0].Status_PPN.trim();
                jnsNotaKredit.value = result[0].JnsNotaKredit.trim();
            } else {
                statusPPN.value = '';
                jnsNotaKredit.value = '';
            }
            console.log(jnsNotaKredit.value, statusPPN.value);


        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
        }
    });
}

function formatDate(dateStr) {
    var date = new Date(dateStr);
    var day = date.getDate();
    var month = date.getMonth() + 1;
    var year = date.getFullYear();

    return month + '/' + day + '/' + year;
}

function printPreview(previewClass) {
    document.querySelectorAll('.notaKreditPPN, .notaKredit, .notanotaSelisihPPN, .notanotaSelisih   ').forEach(function (preview) {
        preview.style.display = "none";
    });

    const previewToPrint = document.querySelector(`.${previewClass}`);
    previewToPrint.style.display = "block";

    window.print();

    previewToPrint.style.display = "none";
}

btnCetak.addEventListener('click', function (event) {
    event.preventDefault();
    console.log(jnsNotaKredit.value, statusPPN.value);


    if (jnsNotaKredit.value === '1') {
        $.ajax({
            type: 'GET',
            url: 'CetakNotaKredit/notaKreditPPN',
            data: {
                _token: csrfToken,
                id_penagihan: id_penagihan.value
            },
            success: function (result) {
                console.log(result);

                let data = result[0];
                var npwp = data.NPWP.trim();
                var formattedNpwp = npwp.substring(0, 2) + ' . ' +
                    npwp.substring(2, 5) + ' . ' +
                    npwp.substring(5, 8) + ' . ' +
                    npwp.substring(8, 9) + ' - ' +
                    npwp.substring(9, 12) + ' . ' +
                    npwp.substring(12, 15);

                if (statusPPN.value === 'Y') {
                    notaKreditPPN.querySelector("#nama").innerHTML = data.NamaNPWP.trim();
                    notaKreditPPN.querySelector("#alamat").innerHTML = data.AlamatNPWP.trim();
                    notaKreditPPN.querySelector("#npwp").innerHTML = formattedNpwp;
                    notaKreditPPN.querySelector("#nomor").innerHTML = 'NO. : ' + data.Id_NotaKredit.trim();
                    notaKreditPPN.querySelector("#ketPajak").innerHTML =
                        '( Atas Faktur Pajak No. 010.000.09-' + data.IdFakturPajak.trim() + ' &nbsp; &nbsp; Tgl. ' + formatDate(data.Tgl_Penagihan.trim()) + ' )';

                    notaKreditPPN.querySelector("#suratJalan").innerHTML = xnomor;

                    let totalRetur = 0;

                    notaKreditPPN.querySelector("#no").innerHTML = '';
                    notaKreditPPN.querySelector("#namaTypeBarang").innerHTML = '';
                    notaKreditPPN.querySelector("#qtyKonversi").innerHTML = '';
                    notaKreditPPN.querySelector("#satuanJual").innerHTML = '';
                    notaKreditPPN.querySelector("#hargaSatuan").innerHTML = '';
                    notaKreditPPN.querySelector("#total").innerHTML = '';

                    result.forEach(function (item, index) {
                        let nomer = document.createElement("div");
                        nomer.innerHTML = index + 1;
                        notaKreditPPN.querySelector("#no").appendChild(nomer);

                        // nama type barang
                        let combinedContent = item.NAMATYPEBARANG.trim() + '<br>' +
                            item.NamaBarang.trim() + '<br>' +
                            '( PO. No : ' + item.NO_PO.trim() + ')';

                        let combinedDiv = document.createElement("div");
                        combinedDiv.innerHTML = combinedContent;
                        notaKreditPPN.querySelector("#namaTypeBarang").appendChild(combinedDiv);

                        // qty konversi
                        let qty = parseFloat(item.QTyKonversi.trim());
                        let qtyDiv = document.createElement("div");
                        qtyDiv.innerHTML = qty.toLocaleString("en-US", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2,
                        });
                        notaKreditPPN.querySelector("#qtyKonversi").appendChild(qtyDiv);

                        // satuan jual
                        let satuanjualDiv = document.createElement("div");
                        satuanjualDiv.innerHTML = item.SatuanJual.trim();
                        notaKreditPPN.querySelector("#satuanJual").appendChild(satuanjualDiv);

                        // harga satuan
                        let hargasatuan = parseFloat(item.HargaSatuan.trim());
                        let hargasatuanDiv = document.createElement("div");
                        hargasatuanDiv.innerHTML = hargasatuan.toLocaleString("en-US", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2,
                        });
                        notaKreditPPN.querySelector("#hargaSatuan").appendChild(hargasatuanDiv);

                        // total
                        let totalValue = Number(item.QTyKonversi) * Number(item.HargaSatuan) * Number(item.NilaiKurs);
                        let total = document.createElement("div");
                        total.innerHTML = totalValue.toLocaleString("en-US", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2,
                        });;
                        notaKreditPPN.querySelector("#total").appendChild(total);

                        // Update total
                        totalRetur += totalValue;
                    });

                    notaKreditPPN.querySelector("#grandTotal1").innerHTML =
                        totalRetur.toLocaleString("en-US", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2,
                        });
                    notaKreditPPN.querySelector("#grandTotal2").innerHTML =
                        totalRetur.toLocaleString("en-US", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2,
                        });


                    let pajak = Number(totalRetur) * 0.1
                    notaKreditPPN.querySelector("#nilaiPajak").innerHTML =
                        pajak.toLocaleString("en-US", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2,
                        });;

                    notaKreditPPN.querySelector("#idPenagihan").innerHTML = data.Id_Penagihan.trim();
                    notaKreditPPN.querySelector("#tanggal").innerHTML = formatDate(data.Tanggal.trim());
                    notaKreditPPN.querySelector("#nama").innerHTML = data.NamaNPWP.trim();

                    printPreview('notaKreditPPN');

                } else {
                    notaKredit.querySelector("#tanggal").innerHTML = ': ' + formatDate(data.Tanggal.trim());
                    notaKredit.querySelector("#idNotaKredit").innerHTML = ': ' + data.Id_NotaKredit.trim();
                    notaKredit.querySelector("#nama").innerHTML = data.NamaCust.trim();
                    notaKredit.querySelector("#alamat").innerHTML = data.Alamat.trim();
                    notaKredit.querySelector("#suratJalan").innerHTML = data.SuratJalan ? data.SuratJalan.trim() : '';
                    notaKredit.querySelector("#idSuratPesanan").innerHTML = data.IDSuratPesanan ? data.IDSuratPesanan.trim() : '';

                    notaKredit.querySelector("#terbilang").innerHTML = data.Terbilang.trim();
                    notaKredit.querySelector("#idPenagihan").innerHTML = data.Id_Penagihan.trim();

                    let totalRetur = 0;

                    notaKredit.querySelector("#namaTypeBarang").innerHTML = '';
                    notaKredit.querySelector("#qtyKonversi").innerHTML = '';
                    notaKredit.querySelector("#satuanJual").innerHTML = '';
                    notaKredit.querySelector("#hargaSatuan").innerHTML = '';
                    notaKredit.querySelector("#total").innerHTML = '';

                    result.forEach(function (item, index) {

                        // nama type barang
                        let combinedContent = (item.NAMATYPEBARANG?.trim() ?? '') + '<br>' + (item.NamaBarang?.trim() ?? '');
                        let combinedDiv = document.createElement("div");
                        combinedDiv.innerHTML = combinedContent;
                        notaKredit.querySelector("#namaTypeBarang").appendChild(combinedDiv);

                        // qty konversi
                        let qty = parseFloat(item.QTyKonversi?.trim() ?? 0);
                        let qtyDiv = document.createElement("div");
                        qtyDiv.innerHTML = qty.toLocaleString("en-US", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2,
                        });
                        notaKredit.querySelector("#qtyKonversi").appendChild(qtyDiv);

                        // satuan jual
                        let satuanjualDiv = document.createElement("div");
                        satuanjualDiv.innerHTML = item.SatuanJual?.trim() ?? '';
                        notaKredit.querySelector("#satuanJual").appendChild(satuanjualDiv);

                        // harga satuan
                        let hargasatuan = parseFloat(item.HargaSatuan?.trim() ?? 0);
                        let hargasatuanDiv = document.createElement("div");
                        hargasatuanDiv.innerHTML = hargasatuan.toLocaleString("en-US", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2,
                        });
                        notaKredit.querySelector("#hargaSatuan").appendChild(hargasatuanDiv);

                        // total
                        let totalValue = (Number(item.QTyKonversi ?? 0) * Number(item.HargaSatuan ?? 0));
                        let total = document.createElement("div");
                        total.innerHTML = totalValue.toLocaleString("en-US", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2,
                        });
                        notaKredit.querySelector("#total").appendChild(total);

                        // Update total
                        totalRetur += totalValue;
                    });

                    notaKredit.querySelector("#grandTotal").innerHTML =
                        totalRetur.toLocaleString("en-US", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2,
                        });

                    printPreview('notaKredit');

                }

            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });


    } else if (jnsNotaKredit.value === '2') {
        $.ajax({
            type: 'GET',
            url: 'CetakNotaKredit/notaPotHargaPPN',
            data: {
                _token: csrfToken,
                id_penagihan: id_penagihan
            },
            success: function (result) {
                console.log(result);
                let data = result[0];

                if (statusPPN.value === 'Y') {

                } else {

                }

            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });

    } else if (jnsNotaKredit.value === '3') {
        $.ajax({
            type: 'GET',
            url: 'CetakNotaKredit/notaFreePPN',
            data: {
                _token: csrfToken,
                id_penagihan: id_penagihan
            },
            success: function (result) {
                console.log(result);
                let data = result[0];

                if (statusPPN.value === 'Y') {

                } else {

                }

            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });

    } else if (jnsNotaKredit.value === '5') {
        $.ajax({
            type: 'GET',
            url: 'CetakNotaKredit/notaSelisihPPN',
            data: {
                _token: csrfToken,
                id_penagihan: id_penagihan
            },
            success: function (result) {
                console.log(result);
                let data = result[0];

                if (statusPPN.value === 'Y') {
                    notanotaSelisihPPN.querySelector("#tanggal").innerHTML = ': ' + formatDate(data.Tanggal.trim());
                    notanotaSelisihPPN.querySelector("#idNotaKredit").innerHTML = ': ' + data.Id_NotaKredit.trim();
                    notanotaSelisihPPN.querySelector("#nama").innerHTML = data.NamaCust.trim();
                    notanotaSelisihPPN.querySelector("#alamat").innerHTML = data.Alamat.trim() + ' ' + data.Kota.trim();
                    notanotaSelisihPPN.querySelector("#suratJalan").innerHTML = data.SuratJalan ? data.SuratJalan.trim() : '';

                    // notanotaSelisihPPN.querySelector("#terbilang").innerHTML = data.Terbilang.trim();
                    notanotaSelisihPPN.querySelector("#idPenagihan").innerHTML = data.Id_Penagihan.trim();

                    let totalRetur = 0;

                    notanotaSelisihPPN.querySelector("#namaTypeBarang").innerHTML = '';
                    notanotaSelisihPPN.querySelector("#qtyKonversi").innerHTML = '';
                    notanotaSelisihPPN.querySelector("#satuanJual").innerHTML = '';
                    notanotaSelisihPPN.querySelector("#hargaSatuan").innerHTML = '';
                    notanotaSelisihPPN.querySelector("#total").innerHTML = '';

                    result.forEach(function (item, index) {

                        // nama type barang
                        let combinedContent = item.NAMA_BRG?.trim() ?? '';
                        let combinedDiv = document.createElement("div");
                        combinedDiv.innerHTML = combinedContent;
                        notanotaSelisihPPN.querySelector("#namaTypeBarang").appendChild(combinedDiv);

                        // qty konversi
                        let qty = parseFloat(item.QTyBrg?.trim() ?? 0);
                        let qtyDiv = document.createElement("div");
                        qtyDiv.innerHTML = qty.toLocaleString("en-US", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2,
                        });
                        notanotaSelisihPPN.querySelector("#qtyKonversi").appendChild(qtyDiv);

                        // satuan jual
                        // let satuanjualDiv = document.createElement("div");
                        // satuanjualDiv.innerHTML = item.SatuanJual?.trim() ?? '';
                        // notanotaSelisihPPN.querySelector("#satuanJual").appendChild(satuanjualDiv);

                        // harga satuan
                        let hargasatuan = parseFloat(item.HargaSP?.trim() ?? 0);
                        let hargasatuanDiv = document.createElement("div");
                        hargasatuanDiv.innerHTML = hargasatuan.toLocaleString("en-US", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2,
                        });
                        notanotaSelisihPPN.querySelector("#hargaSatuan").appendChild(hargasatuanDiv);

                        // total
                        let totalValue = (Number(item.QTyBrg ?? 0) * Number(item.HargaSP ?? 0));
                        let total = document.createElement("div");
                        total.innerHTML = totalValue.toLocaleString("en-US", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2,
                        });
                        notanotaSelisihPPN.querySelector("#total").appendChild(total);

                        // Update total
                        totalRetur += totalValue;
                    });

                    notanotaSelisihPPN.querySelector("#grandTotal").innerHTML =
                        totalRetur.toLocaleString("en-US", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2,
                        });

                    printPreview('notanotaSelisihPPN');
                } else {
                    notanotaSelisih.querySelector("#tanggal").innerHTML = ': ' + formatDate(data.Tanggal.trim());
                    notanotaSelisih.querySelector("#idNotaKredit").innerHTML = ': ' + data.Id_NotaKredit.trim();
                    notanotaSelisih.querySelector("#nama").innerHTML = data.NamaCust.trim();
                    notanotaSelisih.querySelector("#alamat").innerHTML = data.Alamat.trim();
                    notanotaSelisih.querySelector("#suratJalan").innerHTML = data.SuratJalan ? data.SuratJalan.trim() : '';
                    notanotaSelisih.querySelector("#idSuratPesanan").innerHTML = data.IDSuratPesanan ? data.IDSuratPesanan.trim() : '';

                    notanotaSelisih.querySelector("#terbilang").innerHTML = data.Terbilang.trim();
                    notanotaSelisih.querySelector("#idPenagihan").innerHTML = data.Id_Penagihan.trim();

                    let totalRetur = 0;

                    notanotaSelisih.querySelector("#namaTypeBarang").innerHTML = '';
                    notanotaSelisih.querySelector("#qtyKonversi").innerHTML = '';
                    notanotaSelisih.querySelector("#satuanJual").innerHTML = '';
                    notanotaSelisih.querySelector("#hargaSatuan").innerHTML = '';
                    notanotaSelisih.querySelector("#total").innerHTML = '';

                    result.forEach(function (item, index) {

                        // nama type barang
                        let combinedContent = item.NAMA_BRG?.trim() ?? '';
                        let combinedDiv = document.createElement("div");
                        combinedDiv.innerHTML = combinedContent;
                        notanotaSelisih.querySelector("#namaTypeBarang").appendChild(combinedDiv);

                        // qty konversi
                        let qty = parseFloat(item.QTyBrg?.trim() ?? 0);
                        let qtyDiv = document.createElement("div");
                        qtyDiv.innerHTML = qty.toLocaleString("en-US", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2,
                        });
                        notanotaSelisih.querySelector("#qtyKonversi").appendChild(qtyDiv);

                        // satuan jual
                        // let satuanjualDiv = document.createElement("div");
                        // satuanjualDiv.innerHTML = item.SatuanJual?.trim() ?? '';
                        // notanotaSelisih.querySelector("#satuanJual").appendChild(satuanjualDiv);

                        // harga satuan
                        let hargasatuan = parseFloat(item.HargaSP?.trim() ?? 0);
                        let hargasatuanDiv = document.createElement("div");
                        hargasatuanDiv.innerHTML = hargasatuan.toLocaleString("en-US", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2,
                        });
                        notanotaSelisih.querySelector("#hargaSatuan").appendChild(hargasatuanDiv);

                        // total
                        let totalValue = (Number(item.QTyBrg ?? 0) * Number(item.HargaSP ?? 0));
                        let total = document.createElement("div");
                        total.innerHTML = totalValue.toLocaleString("en-US", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2,
                        });
                        notanotaSelisih.querySelector("#total").appendChild(total);

                        // Update total
                        totalRetur += totalValue;
                    });

                    // notanotaSelisih.querySelector("#grandTotal").innerHTML = data.Nilai.trim();

                    notanotaSelisih.querySelector("#grandTotal").innerHTML = parseFloat(item.Nilai.trim()).toLocaleString("en-US", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2,
                    });

                    printPreview('notanotaSelisih');
                }

            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }
});
