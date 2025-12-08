$(document).ready(function () {
    const pegawaiButton = document.getElementById("pegawaiButton");
    $("#table_Divisi").DataTable({
        order: [[0, "asc"]],
    });
    $("#table_Pegawai").DataTable({
        order: [[0, "asc"]],
    });
    $("#table_Divisi tbody").on("click", "tr", function () {
        // Get the data from the clicked row
        var rowData = $("#table_Divisi").DataTable().row(this).data();
        // Populate the input fields with the data
        $("#Id_Div").val(rowData[0]);
        $("#Nama_Div").val(rowData[1]);
        $("#Id_Pegawai").val("");
        $("#Nama_Pegawai").val("");
        fetch("/ProgramPayroll/MasterKartu/" + rowData[0] + ".getPegawai")
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json(); // Assuming the response is in JSON format
            })
            .then((data) => {
                // Handle the data retrieved from the server (data should be an object or an array)

                // Clear the existing table rows
                $("#table_Pegawai").DataTable().clear().draw();

                // Loop through the data and create table rows
                data.forEach((item) => {
                    var row = [item.Kd_Pegawai, item.Nama_Peg];
                    $("#table_Pegawai").DataTable().row.add(row);
                });

                // Redraw the table to show the changes
                $("#table_Pegawai").DataTable().draw();
            })
            .catch((error) => {
                console.error("Error:", error);
            });
        // var idDivValue = rowData[0];
        // submitFormWithIdDiv(idDivValue);
        // Hide the modal immediately after populating the data
        hideModalDivisi();
    });
    $("#table_Pegawai tbody").on("click", "tr", function () {
        // Get the data from the clicked row
        var rowData = $("#table_Pegawai").DataTable().row(this).data();
        // Populate the input fields with the data
        $("#Id_Pegawai").val(rowData[0]);
        $("#Nama_Pegawai").val(rowData[1]);
        fetch("/ProgramPayroll/MasterKartu/" + rowData[0] + ".getDataPegawai")
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json(); // Assuming the response is in JSON format
            })
            .then((data) => {
                console.log(data);
                data.forEach((item) => {
                    document.getElementById(
                        "Kd_Pegawai"
                    ).textContent = `KODE   : ${item.Kd_Pegawai}`;
                    document.getElementById(
                        "No_Kartu"
                    ).textContent = `NOMOR : ${item.No_Kartu}`;
                    document.getElementById(
                        "Nama_Divisi"
                    ).textContent = `DEPT   : ${item.Nama_Div}`;
                    document.getElementById(
                        "Nama_Peg"
                    ).textContent = `NAMA  : ${item.Nama_Peg}`;
                });
            })
            .catch((error) => {
                console.error("Error:", error);
            });
        // document.getElementById("printSection").hidden = false;
        // var idDivValue = rowData[0];
        // submitFormWithIdDiv(idDivValue);
        // Hide the modal immediately after populating the data
        hideModalPegawai();
    });
});

function showModalDivisi() {
    $("#modalDivisi").modal("show");
}
function hideModalDivisi() {
    $("#modalDivisi").modal("hide");
}
function showModalPegawai() {
    $("#modalPegawai").modal("show");
}
function hideModalPegawai() {
    $("#modalPegawai").modal("hide");
}
