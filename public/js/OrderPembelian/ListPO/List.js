let bet1 = document.getElementById("betwendate1");
let bet2 = document.getElementById("betwendate2");
let no = document.getElementById("no_po");
let redisplayButton = document.getElementById("redisplayButton");
let lihat_BTTB = document.getElementById("lihat_BTTB");

bet1.valueAsDate = new Date();
bet2.valueAsDate = new Date();

$(document).ready(function () {
    bet1.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            bet2.focus();
        }
    });
    bet2.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            redisplayButton.focus();
        }
    });
    no.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            redisplayButton.focus();
        }
    });
});

redisplayButton.addEventListener("click", function (event) {
    if (radioButtonIsSelected()) {
        let radioButtonChecked = radioButtonIsSelected();
        let value = getSelectedDateRange();
        if (typeof value === "object") {
            $("#tabelchelsy").DataTable().clear().destroy();
            redisplay(value.startDate, value.endDate, null);
        } else {
            $("#tabelchelsy").DataTable().clear().destroy();
            redisplay(null, null, value);
        }
    }
});

function getSelectedDateRange() {
    let radioButtons = document.getElementsByName("radiobutton");
    for (let i = 0; i < radioButtons.length; i++) {
        if (radioButtons[i].checked) {
            return radioButtons[i].value === "nomor_po"
                ? no.value.trim()
                : { startDate: bet1.value, endDate: bet2.value };
        }
    }
}

function radioButtonIsSelected() {
    let radioButtons = document.getElementsByName("radiobutton");

    for (let i = 0; i < radioButtons.length; i++) {
        if (radioButtons[i].checked) {
            return radioButtons[i].value;
        }
    }
    return false;
}

function redisplay(MinDate, MaxDate, noPO) {
    if (MinDate && MaxDate && MinDate > MaxDate) {
        Swal.fire({
            icon: 'info',
            title: 'Info',
            text: 'Tanggal Awal tidak boleh lebih dari Tanggal Akhir',
            showConfirmButton: true,
            confirmButtonText: 'OK',
        });
        return;
    }
    let tabelData = $("#tabelchelsy").DataTable({
        responsive: true,
        destroy: true,
        processing: true,
        serverSide: true,
        scrollX: true,
        scrollY: "400px",
        // paging: false,
        lengthChange: false,
        pageLength: 100,
        searching: false,
        ajax: {
            url: "/GETPurchaseOrder",
            type: "GET",
            data: function (data) {
                data.MinDate = MinDate;
                data.MaxDate = MaxDate;
                data.noPO = noPO;
            },
        },
        columns: [
            { data: "NO_PO" },
            { data: "Status" },
            {
                data: "Tgl_sppb",
                render: function (data, type, row) {
                    let parts = data.split(" ")[0].split("-");
                    let tgl = parts[2] + "-" + parts[1] + "-" + parts[0];
                    return tgl;
                },
            },
            { data: "Kd_div" },
            { data: "Nama" },
            { data: "No_BTTB" },
        ],
    });

    // Detach any existing event listeners before attaching new ones
    $("#tabelchelsy tbody").off("click", "tr");
    $("#tabelchelsy tbody").on("click", "tr", function (event) {
        const classList = event.currentTarget.classList;

        if (classList.contains("selected")) {
            const data = tabelData.row(event.currentTarget).data();
            const url = "/OpenReviewPO" + "?No_PO=" + data.NO_PO;
            window.location.href = url;
        } else {
            tabelData
                .rows(".selected")
                .nodes()
                .each((row) => row.classList.remove("selected"));
            classList.add("selected");
        }
    });
}

// Detach any existing event listeners before attaching new ones
lihat_BTTB.removeEventListener("click", handleLihatBTTBClick);
function handleLihatBTTBClick(event) {
    let data = [];
    data = $("#tabelchelsy").DataTable().row(".selected").data();
    if (data == undefined) {
        alert("Pilih Data Yang Mau Di Review BTTB");
    } else {
        if (data.No_BTTB == null || data.No_BTTB == "") {
            alert("Data Tidak Dapat Di Review BTTB");
        } else {
            const url = "/OpenReviewBTTB" + "?No_BTTB=" + data.No_BTTB;
            window.location.href = url;
        }
    }
}
lihat_BTTB.addEventListener("click", handleLihatBTTBClick);
