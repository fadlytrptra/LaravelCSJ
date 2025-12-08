$(document).ready(function () {
    const originalValue = {};

    $("#table_Manager").DataTable({
        order: [[0, "asc"]],
        columnDefs: [
            {
                targets: "_all",
                className: "editable", // Apply editable class to all columns
            },
        ],
    });

    $("#table_Manager tbody").on("click", "tr", function () {
        // Get the data from the clicked row

        var rowData = $("#table_Manager").DataTable().row(this).data();
        // Populate the input fields with the data
        $("#Id_Manager").val(rowData[0]);
        $("#Nama_Manager").val(rowData[1]);
        fetch("/ProgramPayroll/settingDivisiStaff/" + "getStaff")
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json(); // Assuming the response is in JSON format
            })
            .then((data) => {
                // Handle the data retrieved from the server (data should be an object or an array)

                console.log(data);

                // Clear the existing table rows
                $("#table_Divisi_Staff").DataTable().clear().draw();

                // Loop through the data and create table rows
                data.forEach((item) => {
                    const checkboxHTML =
                        '<input type="checkbox" name="checkbox[]" value="' +
                        item.Id_Div +
                        '">';
                    var row = [
                        checkboxHTML,
                        item.Id_Div,
                        item.Kd_Pegawai,
                        item.Nama_Peg,
                        item.KD_MANAGER,
                    ];
                    $("#table_Divisi_Staff").DataTable().row.add(row);
                });

                // Redraw the table to show the changes
                $("#table_Divisi_Staff").DataTable().draw();
            })
            .catch((error) => {
                console.error("Error:", error);
            });
        hideModalManager();
    });
    const table = $("#table_Divisi_Staff").DataTable({
        order: [[0, "asc"]],
        // columnDefs: [
        //     {
        //         targets: "_all",
        //         className: "editable", // Apply editable class to all columns
        //     },
        // ],
    });
    $("#simpanButton").on("click", function () {
        const data = [];

        const checkedCheckboxes = $(
            "#table_Divisi_Staff tbody input[type=checkbox]:checked"
        );
        const kd_manager = document.getElementById("Id_Manager").value;
        checkedCheckboxes.each(function () {
            const row = $(this).closest("tr");
            const rowData = table.row(row).data();

            // const data = {
            //     id_div: rowData[1], // Kolom Id_Div
            //     kd_manager: kd_manager, // Kolom Kd_Pegawai
            //     kd_pegawai: rowData[2], // Kolom Nama_Peg
            // };
            const dataGabung = rowData[1] + "." + kd_manager + "." + rowData[2];
            data.push(dataGabung);
            const formContainer = document.getElementById("form-container");
            const form = document.createElement("form");
            form.setAttribute("action", "settingDivisiStaff/{kd_manager}");
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
                .catch((error) =>
                    console.error("Form submission error:", error)
                );
        });

        console.log(data);
    });

    // table.on("click", "tbody td.editable", function () {
    //     const cell = $(this);
    //     const currentValue = cell.text();
    //     originalValue[cell.index()] = currentValue;
    //     const input = $('<input type="text" class="edit-cell">').val(
    //         currentValue
    //     );
    //     cell.html(input);
    //     input.focus();
    // });

    // table.on("blur", "tbody td.editable input", function () {
    //     const input = $(this);
    //     const newValue = input.val();
    //     const cell = input.parent();
    //     const originalIndex = cell.index();
    //     if (newValue !== originalValue[originalIndex]) {
    //         cell.html(newValue);
    //     } else {
    //         cell.html(originalValue[originalIndex]);
    //     }
    // });

    // table.on("keyup", "tbody td.editable input", function (event) {
    //     if (event.key === "Enter") {
    //         const input = $(this);
    //         input.trigger("blur");
    //     }
    // });
});
function showModalManager() {
    $("#modalManager").modal("show");
}
function hideModalManager() {
    $("#modalManager").modal("hide");
}
