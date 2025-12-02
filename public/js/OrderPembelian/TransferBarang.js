let redisplay = document.getElementById("button_redisplay");
let formCekRedisplay = document.getElementById("formCekRedisplay");
let select_divisi = document.getElementById("select_divisi");
let no_bttb = document.getElementById("no_bttb");
let check_koreksi = document.getElementById("check_koreksi");

formCekRedisplay.addEventListener("input", function (event) {
    let radioButtons = document.getElementsByName("filter_radioButton");
    console.log(select_divisi.selectedIndex != 0);
    if (
        radioButtons[0].checked == true ||
        (radioButtons[1].checked == true && no_bttb.value.trim() != "")
    ) {
        redisplay.disabled = false;
    } else {
        redisplay.disabled = true;
    }
});

no_bttb.addEventListener("change", function (event) {
    redisplay.focus();
});

redisplay.addEventListener("click", function (event) {
    if (radioButtonIsSelected()) {
        let radioButtonChecked = radioButtonIsSelected();
        let value = getSelectedInputValue();
        if (check_koreksi.checked == true) {
            if (radioButtonChecked === "Divisi") {
                $("#table_trasferBarang").DataTable().clear().destroy();
                redisplayData(value, null, 32);
            } else if (radioButtonChecked === "NoBTTB") {
                $("#table_trasferBarang").DataTable().clear().destroy();
                redisplayData(null, value, 33);
            }
        } else {
            if (radioButtonChecked === "Divisi") {
                $("#table_trasferBarang").DataTable().clear().destroy();

                redisplayData(value, null, 18);
            } else if (radioButtonChecked === "NoBTTB") {
                $("#table_trasferBarang").DataTable().clear().destroy();
                redisplayData(null, value, 27);
            }
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
            if (radioButtons[i].value !== "NoBTTB") {
                return select_divisi.value;
            } else {
                return no_bttb.value.trim();
            }
        }
    }
    return false;
}

function redisplayData(Kd_Div, noBTTB, kd) {
    let table = $("#table_trasferBarang").DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        searching: false,
        scrollY: "400px",
        paging: false,
        scrollX: true,
        ajax: {
            url: "/TransferBrg/Redisplay",
            type: "GET",
            data: function (data) {
                (data.Kd_Div = Kd_Div), (data.noBTTB = noBTTB), (data.kd = kd);
            },
        },
        columns: [{ data: "No_PO" }, { data: "No_BTTB" }, { data: "NM_SUP" }],
        rowCallback: function (row, data) {
            $(row).on("click", function (event) {
                const classList = event.currentTarget.classList;

                if (classList.contains("selected")) {
                    if (check_koreksi.checked == true) {
                        const url =
                            "/TransferBarang/TransferBTTB" +
                            "?No_PO=" +
                            data.No_PO +
                            "&No_BTTB=" +
                            data.No_BTTB +
                            "&koreksi=" +
                            1;
                        OpenNewTab(url);
                    } else {
                        const url =
                            "/TransferBarang/TransferBTTB" +
                            "?No_PO=" +
                            data.No_PO +
                            "&No_BTTB=" +
                            data.No_BTTB +
                            "&koreksi=" +
                            0;
                        OpenNewTab(url);
                    }
                } else {
                    table
                        .rows(".selected")
                        .nodes()
                        .each((row) => row.classList.remove("selected"));
                    classList.add("selected");
                }
            });
        },
    });
}
$(document).ready(function () {
    $.ajax({
        url: "/TransferBrg/Divisi",
        type: "GET",
        beforeSend: function () {
            // Show loading screen
            $("#loading-screen").css("display", "flex");
        },
        success: function (response) {
            response.forEach(function (data) {
                let option = document.createElement("option");
                option.value = data.KD_DIV;
                option.text = data.NM_DIV;
                select_divisi.add(option);
            });
        },
        error: function (error) {
            console.error("Error Fetch Data:", error);
        },
        complete: function () {
            // Hide loading screen
            $("#loading-screen").css("display", "none");
        },
    });
});
