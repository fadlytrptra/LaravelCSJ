$(document).ready(function () {
    const simpanButton = document.getElementById("Simpan");
    $("#table_Divisi").DataTable({
        order: [[0, "asc"]],
    });
    $("#table_Supervisor").DataTable({
        order: [[0, "asc"]],
    });
    $("#table_Manager").DataTable({
        order: [[0, "asc"]],
    });
    $("#table_Divisi tbody").on("click", "tr", function () {
        // Get the data from the clicked row
        var rowData = $("#table_Divisi").DataTable().row(this).data();
        // Populate the input fields with the data
        $("#Id_Div").val(rowData[0]);
        $("#Nama_Div").val(rowData[1]);
        var kode = document.getElementById("Id_Div").value;
        fetch("/ProgramPayroll/settingDivisiHarian/" + kode + ".getData")
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json(); // Assuming the response is in JSON format
            })
            .then((data) => {
                data.forEach((item) => {
                    $("#Id_Manager_Lama").val(item.Kd_Mng);
                    $("#Nama_Manager_Lama").val(item.Mng);
                    $("#Id_Supervisor_Lama").val(item.Supervisor);
                    $("#Nama_Supervisor_Lama").val(item.Spv);
                });

                // Redraw the table to show the changes
                $("#table_Pegawai").DataTable().draw();
            })
            .catch((error) => {
                console.error("Error:", error);
            });
        // Hide the modal immediately after populating the data
        hideModalDivisi();
    });
    $("#table_Supervisor tbody").on("click", "tr", function () {
        // Get the data from the clicked row
        var rowData = $("#table_Supervisor").DataTable().row(this).data();
        // Populate the input fields with the data
        $("#Id_Supervisor").val(rowData[0]);
        $("#Nama_Supervisor").val(rowData[1]);

        // Hide the modal immediately after populating the data
        hideModalSupervisor();
    });
    $("#table_Manager tbody").on("click", "tr", function () {
        // Get the data from the clicked row

        var rowData = $("#table_Manager").DataTable().row(this).data();
        // Populate the input fields with the data
        $("#Id_Manager").val(rowData[0]);
        $("#Nama_Manager").val(rowData[1]);

        // Hide the modal immediately after populating the data
        hideModalManager();
    });
    simpanButton.addEventListener("click", function (event) {
        event.preventDefault();
        const idDiv = document.getElementById("Id_Div").value;
        const IdMngr = document.getElementById("Id_Manager").value;
        const IdSupervisorLama = document.getElementById("Id_Supervisor_Lama").value;
        const IdMngrLama = document.getElementById("Id_Manager_Lama").value;
        const IdSupervisor = document.getElementById("Id_Supervisor").value;
        var IdMngrFinal,IdSupervisorFinal;
        if (idDiv == "") {
            alert("Pilih Dulu Divisinya");
            return;
        }
        if (IdSupervisor !== "") {
            const IdSuper = IdSupervisor.split(" / ");
            IdSupervisorFinal = IdSuper[1];
            // const dataGabung = idDiv + "." + IdMngr +"." + IdSpv;

        }else{
            IdSupervisorFinal = IdSupervisorLama;

        }

        if (IdMngr !== "") {
            IdMngrFinal = IdMngr;
        }else{
            IdMngrFinal = IdMngrLama;

        }

        const data = {
            idDiv: idDiv,
            IdMngr: IdMngrFinal,
            IdSpv: IdSupervisorFinal,
        };
        // const data = [

        // ];
        // for (let i = 0; i < 4; i++) {
        //     data.push(dataGabung);
        // }
        console.log(data);

        const formContainer = document.getElementById("form-container");
        const form = document.createElement("form");
        form.setAttribute("action", "settingDivisiHarian/{idDiv}");
        form.setAttribute("method", "POST");

        // Loop through the data object and add hidden input fields to the form
        for (const key in data) {
            const input = document.createElement("input");
            input.setAttribute("type", "hidden");
            input.setAttribute("name", key);
            input.value = data[key]; // Set the value of the input field to the corresponding data
            form.appendChild(input);
        }
        // Create method input with "PUT" Value
        const method = document.createElement("input");
        method.setAttribute("type", "hidden");
        method.setAttribute("name", "_method");
        method.value = "PUT"; // Set the value of the input field to the corresponding data
        form.appendChild(method);

        // Create input with "Update Keluarga" Value
        const ifUpdate = document.createElement("input");
        ifUpdate.setAttribute("type", "hidden");
        ifUpdate.setAttribute("name", "_ifUpdate");
        ifUpdate.value = "Update Keluarga"; // Set the value of the input field to the corresponding data
        form.appendChild(ifUpdate);

        formContainer.appendChild(form);

        // Add CSRF token input field (assuming the csrfToken is properly fetched)
        let csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");
        let csrfInput = document.createElement("input");
        csrfInput.type = "hidden";
        csrfInput.name = "_token";
        csrfInput.value = csrfToken;
        form.appendChild(csrfInput);

        // Wrap form submission in a Promise
        function submitForm() {
            return new Promise((resolve, reject) => {
                form.onsubmit = resolve; // Resolve the Promise when the form is submitted
                form.submit();
            });
        }

        // Call the submitForm function to initiate the form submission
        submitForm()
            .then(() => console.log("Form submitted successfully!"))
            .catch((error) => console.error("Form submission error:", error));
    });
});
function showModalDivisi() {
    $("#modalDivisi").modal("show");
}
function hideModalDivisi() {
    $("#modalDivisi").modal("hide");
}
function showModalManager() {
    $("#modalManager").modal("show");
}
function hideModalManager() {
    $("#modalManager").modal("hide");
}
function showModalSupervisor() {
    $("#modalSupervisor").modal("show");
}
function hideModalSupervisor() {
    $("#modalSupervisor").modal("hide");
}
