let redisplay = document.getElementById("button_redisplay");
let formCekRedisplay = document.getElementById("formCekRedisplay");
let formUpdate = document.getElementById("formUpdate");
let btn_update = document.getElementById("btn_update");
let no_po = document.getElementById("no_po");

let csrfToken = $('meta[name="csrf-token"]').attr("content");

btn_update.disabled = true;
formCekRedisplay.addEventListener("change", function (event) {
    redisplay.disabled = !radioButtonIsSelected();
    redisplay.focus();
});

redisplay.addEventListener("click", function (event) {
    if (radioButtonIsSelected()) {
        let radioButtonChecked = radioButtonIsSelected();
        let value = getSelectedInputValue();
        if (radioButtonChecked === "AllOrder") {
            $("#table_koreksi").DataTable().clear().destroy();
            redisplayData(null, null, 24);
        } else if (radioButtonChecked === "NomorOrder") {
            $("#table_koreksi").DataTable().clear().destroy();
            redisplayData(value, null, 11);
        } else if (radioButtonChecked === "User") {
            $("#table_koreksi").DataTable().clear().destroy();
            redisplayData(null, value, 23);
        }
    } else {
        alert("Silahkan Mengisi Form Input");
    }
});
function radioButtonIsSelected() {
    let radioButtons = document.getElementsByName("filter_radioButton");

    for (let i = 0; i < radioButtons.length; i++) {
        if (radioButtons[i].checked) {
            return radioButtons[i].value;
        }
    }
    return false;
}

function getSelectedInputValue() {
    let radioButtons = document.getElementsByName("filter_radioButton");

    for (let i = 0; i < radioButtons.length; i++) {
        if (radioButtons[i].checked) {
            if (radioButtons[i].value !== "AllOrder") {
                let inputText = document.getElementsByName(
                    "search_" + radioButtons[i].value
                )[0];
                return inputText.value.trim();
            } else {
                return radioButtons[i].value;
            }
        }
    }
    return false;
}

function redisplayData(noTrans, requester, kd) {
    let table = $("#table_koreksi").DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        scrollX: true,
        searching: false,
        scrollY: "400px",
        // paging: false,
        lengthChange:false,
        pageLength : 100,
        ajax: {
            url: "/StatusBeli/Redisplay",
            type: "GET",
            data: function (data) {
                (data.noTrans = noTrans),
                    (data.requester = requester),
                    (data.kd = kd);
            },
        },
        columns: [
            { data: "No_trans" },
            { data: "StatusPembelian" },
            { data: "Kd_brg" },
            { data: "NAMA_BRG" },
            { data: "nama_sub_kategori" },
            { data: "Qty" },
            { data: "Nama_satuan" },
            { data: "Nama" },
            { data: "Kd_div" },
        ],
        rowCallback: function (row, data) {
            $(row).on("dblclick", function (event) {
                clearData();
                no_po.value = data.No_trans;
                document.getElementById(
                    "status_beliPengadaanPembelian"
                ).checked = data.StatusPembelian === "Pengadaan Pembelian";
                document.getElementById("status_beliBeliSendiri").checked =
                    data.StatusPembelian === "Beli Sendiri";
                if (no_po.value != "") {
                    btn_update.disabled = false;
                } else {
                    btn_update.disabled = true;
                }
            });
        },
    });

    table.on("dblclick", "tbody tr", (e) => {
        const classList = e.currentTarget.classList;

        if (classList.contains("selected")) {
            classList.remove("selected");
        } else {
            table
                .rows(".selected")
                .nodes()
                .each((row) => row.classList.remove("selected"));
            classList.add("selected");
        }
    });
}

function clearData() {
    no_po.value = "";
    btn_update.disabled = true;
}

btn_update.addEventListener("click", function (event) {
    let stBeli;
    if (
        document.getElementById("status_beliPengadaanPembelian").checked == true
    ) {
        stBeli = 1;
    } else {
        stBeli = 0;
    }
    $.ajax({
        url: "/StatusBeli/Update",
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": csrfToken,
        },
        data: {
            noTrans: no_po.value,
            stBeli: stBeli,
        },
        beforeSend: function () {
            // Show loading screen
            $("#loading-screen").css("display", "flex");
        },
        success: function (response) {
            Swal.fire({
                icon: "success",
                title: "Data Berhasil DiUpdate!",
                showConfirmButton: false,
                timer: "2000",
            });
            clearData();
            $("#table_koreksi").DataTable().ajax.reload();
        },
        error: function (error) {
            Swal.fire({
                icon: "error",
                title: "Data Tidak Berhasil DiUpdate!",
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
});
