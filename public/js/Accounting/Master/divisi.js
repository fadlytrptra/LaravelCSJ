$(document).ready(function () {
    const isiButton = document.getElementById("isiButton");
    const simpanButton = document.getElementById("simpanButton");
    const simpanKoreksiButton = document.getElementById("simpanKoreksiButton");
    const simpanDeleteButton = document.getElementById("simpanDeleteButton");
    const koreksiButton = document.getElementById("koreksiButton");
    const deleteButton = document.getElementById("deleteButton");
    const batalButton = document.getElementById("batalButton");
    const batalKoreksiButton = document.getElementById("batalKoreksiButton");
    const batalDeleteButton = document.getElementById("batalDeleteButton");
    const Id_Div = document.getElementById("Id_Div");
    const Nama_Div = document.getElementById("Nama_Div");
    const divisiButton = document.getElementById("divisiButton");
    const posisiButton = document.getElementById("posisiButton");
    const managerButton = document.getElementById("managerButton");
    const opsiJenisSelect = document.getElementById("opsiJenis");
    const opsiStatusSelect = document.getElementById("opsiStatus");
    const opsiAturanSelect = document.getElementById("opsiAturan");
    const JmlJam = document.getElementById("Jml_Jam");
    const grupDivisi = document.getElementById("grup_Divisi");
    var opsi = 0;
    $("#table_Divisi").DataTable({
        order: [[0, "asc"]],
    });
    $("#table_Peg_Lama").DataTable({
        order: [[0, "asc"]],
    });
    $("#table_Manager").DataTable({
        order: [[0, "asc"]],
    });
    var tabelDivisi = $("#tabelDivisi").DataTable({
        order: [[0, "asc"]],
        select: {
            style: "api",
            toggleable: false,
        },
    });
    $("#table_Divisi tbody").on("click", "tr", function () {
        // Get the data from the clicked row
        var rowData = $("#table_Divisi").DataTable().row(this).data();
        // Populate the input fields with the data
        $("#Id_Div").val(rowData[0]);
        $("#Nama_Div").val(rowData[1]);
        // fetch("/ProgramPayroll/Master/Divisi/" + rowData[0] + ".getPegawai")
        //     .then((response) => {
        //         if (!response.ok) {
        //             throw new Error("Network response was not ok");
        //         }
        //         return response.json(); // Assuming the response is in JSON format
        //     })
        //     .then((data) => {
        //         // Handle the data retrieved from the server (data should be an object or an array)

        //         // Clear the existing table rows
        //         $("#table_Divisi").DataTable().clear().draw();

        //         // Loop through the data and create table rows
        //         data.forEach((item) => {
        //             var row = [item.kd_pegawai, item.nama_peg];
        //             $("#table_Divisi").DataTable().row.add(row);
        //         });

        //         // Redraw the table to show the changes
        //         $("#table_Divisi").DataTable().draw();
        //     })
        //     .catch((error) => {
        //         console.error("Error:", error);
        //     });
        // var idDivValue = rowData[0];
        // submitFormWithIdDiv(idDivValue);
        // Hide the modal immediately after populating the data
        hideModalDivisi();
    });
    $("#table_Peg_Lama tbody").on("click", "tr", function () {
        // Get the data from the clicked row
        var rowData = $("#table_Peg_Lama").DataTable().row(this).data();

        // Populate the input fields with the data
        $("#Nama_Posisi").val(rowData[0]);
        $("#Kd_Posisi").val(rowData[1]);

        // Hide the modal immediately after populating the data
        hideModalPegawai();
    });
    $("#table_Manager tbody").on("click", "tr", function () {
        // Get the data from the clicked row

        var rowData = $("#table_Manager").DataTable().row(this).data();

        // Populate the input fields with the data
        $("#Nama_Manager").val(rowData[0]);
        $("#KD_Manager").val(rowData[1]);

        // Hide the modal immediately after populating the data
        hideModalManager();
    });
    $("#tabelDivisi tbody").on("click", "tr", function () {
        // Get the data from the clicked row

        var rowData = $("#tabelDivisi").DataTable().row(this).data();

        // Populate the input fields with the data
        if (opsi == 2 || opsi == 3) {
            console.log(opsi);
            $("#Id_Div").val(rowData[3]);
            $("#Nama_Div").val(rowData[2]);
            $("#Kd_Posisi").val(rowData[1]);
            $("#Nama_Posisi").val(rowData[0]);
            $("#KD_Manager").val(rowData[10]);
            $("#Nama_Manager").val(rowData[4]);
            $("#id_jenis").val(rowData[5]);
            $("#opsiJenis").val(rowData[5]);
            $("#Id_Status").val(rowData[6]);
            $("#opsiStatus").val(rowData[6]);
            $("#Jml_Jam").val(rowData[7]);
            $("#opsiAturan").val(rowData[8]);
            $("#grup_Divisi").val(rowData[9]);
        }

        // Hide the modal immediately after populating the data
        hideModalManager();
    });

    function clearForm() {
        $("#Id_Div").val("");
        $("#Nama_Div").val("");
        $("#Kd_Posisi").val("");
        $("#Nama_Posisi").val("");
        $("#KD_Manager").val("");
        $("#Nama_Manager").val("");
        $("#id_jenis").val("");
        $("#opsiJenis").val("");
        $("#Id_Status").val("");
        $("#opsiStatus").val("");
        $("#Jml_Jam").val("");
        $("#opsiAturan").val("");
        $("#grup_Divisi").val("");
    }
    isiButton.addEventListener("click", function () {
        opsi = 1;
        clearForm();
        //Hilangkan button isi dan koreksi
        isiButton.classList.add("d-none");
        koreksiButton.classList.add("d-none");
        //Yang ditampilkan ketika button isi ditekan\
        Id_Div.readOnly = false;
        Nama_Div.readOnly = false;

        posisiButton.disabled = false;
        managerButton.disabled = false;
        simpanButton.classList.remove("d-none");
        batalButton.classList.remove("d-none");
        opsiJenisSelect.removeAttribute("disabled");
        opsiStatusSelect.removeAttribute("disabled");
        opsiAturanSelect.removeAttribute("disabled");
        JmlJam.disabled = false;
        // divisiButton.disabled = false;
        grupDivisi.disabled = false;
    });

    batalButton.addEventListener("click", function () {
        //Tampilkan Button isi dan koreksi lagi
        clearForm();
        opsi = 0;
        isiButton.classList.remove("d-none");
        koreksiButton.classList.remove("d-none");
        //hide Button simpan dan batal
        simpanButton.classList.add("d-none");
        batalButton.classList.add("d-none");
        //Disable form
        Id_Div.readOnly = true;
        Nama_Div.readOnly = true;

        posisiButton.disabled = true;
        managerButton.disabled = true;
        divisiButton.disabled = true;
        opsiJenisSelect.setAttribute("disabled", "disabled");
        opsiStatusSelect.setAttribute("disabled", "disabled");
        opsiAturanSelect.setAttribute("disabled", "disabled");
        JmlJam.disabled = true;
        grupDivisi.disabled = true;
    });

    koreksiButton.addEventListener("click", function () {
        //Hide button isi dan koreksi
        opsi = 2;
        isiButton.classList.add("d-none");
        koreksiButton.classList.add("d-none");
        tabelDivisi.select.style("single");
        Nama_Div.readOnly = false;
        posisiButton.disabled = false;
        managerButton.disabled = false;
        opsiJenisSelect.removeAttribute("disabled");
        opsiStatusSelect.removeAttribute("disabled");
        opsiAturanSelect.removeAttribute("disabled");
        JmlJam.disabled = false;
        grupDivisi.disabled = false;
        // divisiButton.disabled = false;
        //Tampil Button simpan dan batal
        simpanKoreksiButton.classList.remove("d-none");
        batalKoreksiButton.classList.remove("d-none");
    });

    batalKoreksiButton.addEventListener("click", function () {
        clearForm();
        opsi = 0;
        tabelDivisi.rows().deselect();
        tabelDivisi.select.style("api");
        isiButton.classList.remove("d-none");
        simpanKoreksiButton.classList.add("d-none");
        koreksiButton.classList.remove("d-none");
        batalKoreksiButton.classList.add("d-none");
        divisiButton.disabled = true;
        Nama_Div.readOnly = true;
        posisiButton.disabled = true;
        managerButton.disabled = true;
        opsiJenisSelect.setAttribute("disabled", "disabled");
        opsiStatusSelect.setAttribute("disabled", "disabled");
        opsiAturanSelect.setAttribute("disabled", "disabled");
        JmlJam.disabled = true;
        grupDivisi.disabled = true;
    });
    deleteButton.addEventListener("click", function () {
        //Hide button isi dan koreksi
        opsi = 3;
        isiButton.classList.add("d-none");
        koreksiButton.classList.add("d-none");
        deleteButton.disabled = true;
        tabelDivisi.select.style("single");
        Nama_Div.readOnly = false;
        posisiButton.disabled = false;
        managerButton.disabled = false;
        opsiJenisSelect.removeAttribute("disabled");
        opsiStatusSelect.removeAttribute("disabled");
        opsiAturanSelect.removeAttribute("disabled");
        JmlJam.disabled = false;
        grupDivisi.disabled = false;
        // divisiButton.disabled = false;
        //Tampil Button simpan dan batal
        simpanDeleteButton.classList.remove("d-none");
        batalDeleteButton.classList.remove("d-none");
    });

    batalDeleteButton.addEventListener("click", function () {
        clearForm();
        opsi = 0
        tabelDivisi.rows().deselect();
        tabelDivisi.select.style("api");
        isiButton.classList.remove("d-none");
        koreksiButton.classList.remove("d-none");
        simpanDeleteButton.classList.add("d-none");
        // deleteButton.classList.remove("d-none");
        deleteButton.disabled = false;
        batalDeleteButton.classList.add("d-none");
        divisiButton.disabled = true;
        Nama_Div.readOnly = true;
        posisiButton.disabled = true;
        managerButton.disabled = true;
        opsiJenisSelect.setAttribute("disabled", "disabled");
        opsiStatusSelect.setAttribute("disabled", "disabled");
        opsiAturanSelect.setAttribute("disabled", "disabled");
        JmlJam.disabled = true;
        grupDivisi.disabled = true;
    });
    simpanButton.addEventListener("click", function (event) {
        event.preventDefault();
        const idDivInput = document.getElementById("Id_Div").value;
        const namaDivInput = document.getElementById("Nama_Div").value;
        const posisiInput = document.getElementById("Kd_Posisi").value;
        const namaPosisiInput = document.getElementById("Nama_Posisi").value;
        const managerInput = document.getElementById("KD_Manager").value;
        const namaManagerInput = document.getElementById("Nama_Manager").value;
        const jenisInput = document.getElementById("id_jenis").value;
        const statusInput = document.getElementById("Id_Status").value;
        const jmlJamInput = document.getElementById("Jml_Jam").value;
        const aturanInput = document.getElementById("opsiAturan").value;
        const grupDivisiInput = document.getElementById("grup_Divisi").value;
        if (idDivInput == "") {
            alert("Data Belum Lengkap ");
            return;
        }
        if (namaDivInput == "") {
            alert("Data Belum Lengkap ");
            return;
        }
        if (jmlJamInput == "") {
            alert("Isi Dulu Jumlah Jamnya");
            return;
        }
        console.log(jmlJamInput);
        if (jmlJamInput != 5 && jmlJamInput != 7 ) {
            alert("Jam hanya diisi 5 atau 7 saja ");
            return;
        }
        if (aturanInput == "") {
            alert("pilih dulu aturannya");
            return;
        }
        if (posisiInput == "") {
            alert("pilih dulu posisinya");
            return;
        }
        if (grupDivisiInput == "") {
            alert("pilih dulu grup divisinya");
            return;
        }
        const data = {
            kd_div: idDivInput,
            nama_div: namaDivInput,
            status: jenisInput,
            no_kabag: managerInput,
            jam: jmlJamInput,
            aturan: aturanInput,
            Id_Group_Div: grupDivisiInput,
            kstatus: statusInput,
            div_pos: posisiInput,
        };
        console.log(data);

        const formContainer = document.getElementById("form-container");
        const form = document.createElement("form");
        form.setAttribute("action", "Divisi");
        form.setAttribute("method", "POST");

        // Loop through the data object and add hidden input fields to the form
        for (const key in data) {
            const input = document.createElement("input");
            input.setAttribute("type", "hidden");
            input.setAttribute("name", key);
            input.value = data[key]; // Set the value of the input field to the corresponding data
            form.appendChild(input);
        }

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
    simpanKoreksiButton.addEventListener("click", function (event) {
        event.preventDefault();
        const idDivInput = document.getElementById("Id_Div").value;
        const namaDivInput = document.getElementById("Nama_Div").value;
        const posisiInput = document.getElementById("Kd_Posisi").value;
        const namaPosisiInput = document.getElementById("Nama_Posisi").value;
        const managerInput = document.getElementById("KD_Manager").value;
        const namaManagerInput = document.getElementById("Nama_Manager").value;
        const jenisInput = document.getElementById("id_jenis").value;
        const statusInput = document.getElementById("Id_Status").value;
        const jmlJamInput = document.getElementById("Jml_Jam").value;
        const aturanInput = document.getElementById("opsiAturan").value;
        const grupDivisiInput = document.getElementById("grup_Divisi").value;
        if (idDivInput == "") {
            alert("Data Belum Lengkap ");
            return;
        }
        if (namaDivInput == "") {
            alert("Data Belum Lengkap ");
            return;
        }
        if (jmlJamInput == "") {
            alert("Isi Dulu Jumlah Jamnya");
            return;
        }
        console.log(jmlJamInput);
        if (jmlJamInput != 5 && jmlJamInput != 7 ) {
            alert("Jam hanya diisi 5 atau 7 saja ");
            return;
        }
        if (aturanInput == "") {
            alert("pilih dulu aturannya");
            return;
        }
        if (posisiInput == "") {
            alert("pilih dulu posisinya");
            return;
        }
        if (grupDivisiInput == "") {
            alert("pilih dulu grup divisinya");
            return;
        }
        const data = {
            kd_div: idDivInput,
            nama_div: namaDivInput,
            status: jenisInput,
            no_kabag: managerInput,
            jam: jmlJamInput,
            aturan: aturanInput,
            Id_Group_Div: grupDivisiInput,
            kstatus: statusInput,
            div_pos: posisiInput,
        };
        console.log(data);

        const formContainer = document.getElementById("form-container");
        const form = document.createElement("form");
        form.setAttribute("action", "Divisi/" + idDivInput);
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
        ifUpdate.value = "Update Divisi"; // Set the value of the input field to the corresponding data
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
    simpanDeleteButton.addEventListener("click", function (event) {
        event.preventDefault();
        const idDivInput = document.getElementById("Id_Div").value;
        if (idDivInput == "") {
            alert("Pilih dulu divisinya !");
            return;
        }
        const data = {
            kd_div: idDivInput,
        };
        console.log(data);

        const formContainer = document.getElementById("form-container");
        const form = document.createElement("form");
        form.setAttribute("action", "Divisi/" + idDivInput);
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
        method.value = "DELETE"; // Set the value of the input field to the corresponding data
        form.appendChild(method);

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
    document.getElementById('opsiJenis').addEventListener('change', function() {
        const opsi = document.getElementById("opsiJenis").value;
        $("#id_jenis").val(opsi);
    });
    document.getElementById('opsiStatus').addEventListener('change', function() {
        const opsi = document.getElementById("opsiStatus").value;
        $("#Id_Status").val(opsi);
    });
});
function showModalDivisi() {
    $("#modalKdPeg").modal("show");
}

// Function to hide the modal
function hideModalDivisi() {
    $("#modalKdPeg").modal("hide");
}

function showModalPegawai() {
    $("#modalPeg").modal("show");
}

// Function to hide the modal
function hideModalPegawai() {
    $("#modalPeg").modal("hide");
}
function showModalManager() {
    $("#modalManager").modal("show");
}

// Function to hide the modal
function hideModalManager() {
    $("#modalManager").modal("hide");
}

// $(document).ready(function () {
//     $("#table_Divisi").DataTable({
//         order: [[0, "asc"]],
//     });

//     // Function to remove the backdrop
//     function removeBackdrop() {
//         $(".modal-backdrop").remove();
//     }

//     // Function to show the modal

//     $("#btnSimpan").on("click", function () {
//         simpanNilaiOpsi();
//         // You can also call simpanData() here if needed.
//     });

//     function simpanNilaiOpsi() {
//         const radioPerpanjang = document.getElementById("perpanjang");
//         const radioResign = document.getElementById("resign");
//         const kontrak1 = document.getElementById("kontrak1");
//         const kontrak2 = document.getElementById("kontrak2");
//         const kontrak3 = document.getElementById("kontrak3");
//         const kontrak4 = document.getElementById("kontrak4");
//         const kontrak5 = document.getElementById("kontrak5");
//         const kontrak6 = document.getElementById("kontrak6");
//         const Id_Div = document.getElementById("Id_Div").value;
//         const Id_Peg_Lama = document.getElementById("Id_Peg_Lama").value;
//         const Shift = document.getElementById("Shift").value;
//         const Id_Div_Baru = document.getElementById("Id_Div_Baru").value;
//         const Kd_Peg_Baru = document.getElementById("Kd_Peg_Baru").value;
//         const TglMasuk = document.getElementById("TglMasuk").value;
//         const TglMulai = document.getElementById("TglMulai").value;
//         const TglSelesai = document.getElementById("TglSelesai").value;
//         const TglKeluar = document.getElementById("TglKeluar").value;
//         let opsiKontrak;
//         if (kontrak1.checked) {
//             opsiKontrak = kontrak1.value;
//         } else if (kontrak2.checked) {
//             opsiKontrak = kontrak2.value;
//         } else if (kontrak3.checked) {
//             opsiKontrak = kontrak3.value;
//         } else if (kontrak4.checked) {
//             opsiKontrak = kontrak4.value;
//         } else if (kontrak5.checked) {
//             opsiKontrak = kontrak5.value;
//         } else if (kontrak6.checked) {
//             opsiKontrak = kontrak6.value;
//         }

//         let opsiKeluar;
//         if (radioPerpanjang.checked) {
//             opsiKeluar = radioPerpanjang.value;
//         } else if (radioResign.checked) {
//             opsiKeluar = radioResign.value;
//         }
//         // Now you can use these variables as needed.
//         // For example, you can log them to the console to see their values:
//         const data = {
//             Id_Div_Baru: Id_Div_Baru,
//             Id_Div: Id_Div,
//             Id_Peg_Lama: Id_Peg_Lama,
//             Kd_Peg_Baru: Kd_Peg_Baru,
//             TglKeluar: TglKeluar,
//             awalKontrak: TglMulai,
//             akhirKontrak: TglSelesai,
//             Shift: Shift,
//             ketlama: opsiKeluar,
//             ketbaru: opsiKontrak,
//             TglMasuk: TglMasuk,
//         };
//         console.log(data);
//         console.log(data);

//         const formContainer = document.getElementById("form-container");
//         const form = document.createElement("form");
//         form.setAttribute("action", "insertDivisi");
//         form.setAttribute("method", "POST");

//         // Loop through the data object and add hidden input fields to the form
//         for (const key in data) {
//             const input = document.createElement("input");
//             input.setAttribute("type", "hidden");
//             input.setAttribute("name", key);
//             input.value = data[key]; // Set the value of the input field to the corresponding data
//             form.appendChild(input);
//         }

//         formContainer.appendChild(form);

//         // Add CSRF token input field (assuming the csrfToken is properly fetched)
//         let csrfToken = document
//             .querySelector('meta[name="csrf-token"]')
//             .getAttribute("content");
//         let csrfInput = document.createElement("input");
//         csrfInput.type = "hidden";
//         csrfInput.name = "_token";
//         csrfInput.value = csrfToken;
//         form.appendChild(csrfInput);

//         // Wrap form submission in a Promise
//         function submitForm() {
//             return new Promise((resolve, reject) => {
//                 form.onsubmit = resolve; // Resolve the Promise when the form is submitted
//                 form.submit();
//             });
//         }

//         // Call the submitForm function to initiate the form submission
//         submitForm()
//             .then(() => console.log("Form submitted successfully!"))
//             .catch((error) => console.error("Form submission error:", error));
//         // const csrfToken = $('meta[name="csrf-token"]').attr("content");
//         //  $.ajax({
//         //     type: 'POST',
//         //     url: 'updateKontrak', // Replace this with the actual route to your controller method
//         //     data: data,
//         //     headers: {
//         //         'X-CSRF-TOKEN': csrfToken,
//         //     },
//         //     success: function(response) {
//         //         // Handle the response from the server if needed
//         //         console.log(response);
//         //     },
//         //     error: function(error) {
//         //         // Handle any errors that occur during the AJAX request
//         //         console.error('AJAX request error:', error);
//         //     }
//         // });
//         // console.log(data);
//     }

//     function simpanData() {
//         // Here you can add the code to send the extracted data to the server or perform any other action.
//         // You can access the variables extracted in the simpanNilaiOpsi() function here and process them further.
//         // For example:
//         // const formData = {
//         //     Id_Div: document.getElementById('Id_Div').value,
//         //     Id_Peg_Lama: document.getElementById('Id_Peg_Lama').value,
//         //     Shift: document.getElementById('Shift').value,
//         //     ...
//         // };
//         // Now you can send this formData to the server using AJAX or perform other actions.
//     }

//     // Attach click event to DataTable rows
//     $("#table_Divisi tbody").on("click", "tr", function () {
//         // Get the data from the clicked row
//         var rowData = $("#table_Divisi").DataTable().row(this).data();
//         // Populate the input fields with the data
//         $("#Id_Div").val(rowData[0]);
//         $("#Nama_Div").val(rowData[1]);
//         // fetch("/getPegawai/" + rowData[0])
//         //     .then((response) => {
//         //         if (!response.ok) {
//         //             throw new Error("Network response was not ok");
//         //         }
//         //         return response.json(); // Assuming the response is in JSON format
//         //     })
//         //     .then((data) => {
//         //         // Handle the data retrieved from the server (data should be an object or an array)

//         //         // Clear the existing table rows
//         //         $("#table_Peg_Lama").DataTable().clear().draw();

//         //         // Loop through the data and create table rows
//         //         data.forEach((item) => {
//         //             var row = [item.kd_pegawai, item.nama_peg];
//         //             $("#table_Peg_Lama").DataTable().row.add(row);
//         //         });

//         //         // Redraw the table to show the changes
//         //         $("#table_Peg_Lama").DataTable().draw();
//         //     })
//         //     .catch((error) => {
//         //         console.error("Error:", error);
//         //     });
//         // var idDivValue = rowData[0];
//         // submitFormWithIdDiv(idDivValue);
//         // Hide the modal immediately after populating the data
//         hideModalDivisi();
//     });
//     $("#table_Peg_Lama").DataTable({
//         order: [[0, "asc"]],
//     });

//     // Attach click event to table rows
//     $("#table_Peg_Lama tbody").on("click", "tr", function () {
//         // Get the data from the clicked row
//         console.log($("#table_Peg_Lama").DataTable().row(this));
//         var rowData = $("#table_Peg_Lama").DataTable().row(this).data();
//         console.log(rowData);
//         // Populate the input fields with the data
//         $("#Nama_Posisi").val(rowData[0]);
//         $("#Kd_Posisi").val(rowData[1]);

//         // Hide the modal immediately after populating the data
//         hideModalPegawai();
//     });
//     $("#table_Divisi_Baru").DataTable({
//         order: [[0, "asc"]],
//     });
//     $("#table_Divisi_Baru tbody").on("click", "tr", function () {
//         // Get the data from the clicked row

//         var rowData = $("#table_Divisi_Baru").DataTable().row(this).data();

//         // Populate the input fields with the data
//         $("#Id_Div_Baru").val(rowData[0]);
//         $("#Nama_Div_Baru").val(rowData[1]);

//         // Hide the modal immediately after populating the data
//         hideModalDivisiBaru();
//     });
//     function showModalDivisiBaru() {
//         $("#modalDivisiBaru").addClass("show");
//         $("#modalDivisiBaru").css("display", "block");
//         $("body").addClass("modal-open");
//     }

//     // Function to hide the modal
//     function hideModalDivisiBaru() {
//         $("#modalDivisiBaru").removeClass("show");
//         $("#modalDivisiBaru").css("display", "none");
//         $("body").removeClass("modal-open");
//         removeBackdrop();
//     }

//     $("#table_Shift").DataTable({
//         order: [[0, "asc"]],
//     });
//     $("#table_Shift tbody").on("click", "tr", function () {
//         // Get the data from the clicked row

//         var rowData = $("#table_Shift").DataTable().row(this).data();

//         // Populate the input fields with the data
//         $("#Shift").val(rowData[0]);
//         $("#Jam").val(rowData[1]);

//         // Hide the modal immediately after populating the data
//         hideModalShift();
//     });
//     function showModalShift() {
//         $("#modalShift").addClass("show");
//         $("#modalShift").css("display", "block");
//         $("body").addClass("modal-open");
//     }

//     // Function to hide the modal
//     function hideModalShift() {
//         $("#modalShift").removeClass("show");
//         $("#modalShift").css("display", "none");
//         $("body").removeClass("modal-open");
//         removeBackdrop();
//     }

//     $("#table_Manager").DataTable({
//         order: [[0, "asc"]],
//     });

//     // Attach click event to table rows
//     $("#table_Manager tbody").on("click", "tr", function () {
//         // Get the data from the clicked row
//         console.log($("#table_Manager").DataTable().row(this));
//         var rowData = $("#table_Manager").DataTable().row(this).data();
//         console.log(rowData);
//         // Populate the input fields with the data
//         $("#Nama_Manager").val(rowData[0]);
//         $("#KD_Manager").val(rowData[1]);

//         // Hide the modal immediately after populating the data
//         hideModalManager();
//     });

//     $("#tabelDivisi").DataTable({
//         order: [[0, "asc"]],
//         columnDefs: [
//             {
//                 targets: [9, 10], // Index of columns to hide (0-based index)
//                 visible: false,
//                 searchable: true,
//             },
//         ],
//         retrieve: true,
//     });
//     // Attach click event to the button to show the modal
//     $("#divisiButton").on("click", function () {
//         showModalDivisi();
//     });

//     // Attach hidden event to the modal
//     $("#modalKdPeg").on("hidden.bs.modal", function () {
//         removeBackdrop();
//     });

// });

// document.addEventListener("DOMContentLoaded", function () {
//     const dataTable = document.getElementById("tabelDivisi");
//     const idDivInput = document.getElementById("Id_Div");
//     const namaDivInput = document.getElementById("Nama_Div");
//     const posisiInput = document.getElementById("Kd_Posisi");
//     const namaPosisiInput = document.getElementById("Nama_Posisi");
//     const managerInput = document.getElementById("KD_Manager");
//     const namaManagerInput = document.getElementById("Nama_Manager");
//     const jenisInput = document.getElementById("id_jenis");
//     const statusInput = document.getElementById("Id_Status");
//     const jmlJamInput = document.getElementById("Jml_Jam");
//     const aturanInput = document.getElementById("opsiAturan");
//     const grupDivisiInput = document.getElementById("grup_Divisi");
//     const opsiJenisSelect = document.getElementById("opsiJenis");
//     const opsiStatusSelect = document.getElementById("opsiStatus");
//     let selectedRow = null;

//     // Fungsi untuk meng-unselect baris
//     function unselectRow(row) {
//         if (row) {
//             row.classList.remove("selected");
//             selectedRow = null;
//             // Reset nilai input
//             idDivInput.value = "";
//             namaDivInput.value = "";
//             posisiInput.value = "";
//             namaPosisiInput.value = "";
//             managerInput.value = "";
//             namaManagerInput.value = "";
//             jenisInput.value = "";
//             statusInput.value = "";
//             jmlJamInput.value = "";
//             aturanInput.value = "";
//             grupDivisiInput.value = "";
//         }
//     }

//     // Tambahkan event listener untuk mendengarkan klik pada baris
//     dataTable
//         .querySelector("tbody")
//         .addEventListener("click", function (event) {
//             const clickedRow = event.target.closest("tr");
//             if (clickedRow) {
//                 if (clickedRow === selectedRow) {
//                     // Jika baris yang dipilih saat ini adalah yang sebelumnya dipilih, unselect baris
//                     unselectRow(selectedRow);
//                 } else {
//                     // Jika baris yang dipilih adalah baris yang berbeda, unselect baris sebelumnya (jika ada)
//                     unselectRow(selectedRow);
//                     selectedRow = clickedRow;
//                     selectedRow.classList.add("selected");
//                     var dataHidden = $("#tabelDivisi")
//                         .DataTable()
//                         .row(clickedRow)
//                         .data();

//                     // var rowData = table.row(0).data();
//                     // Ambil data dari baris yang dipilih
//                     const idDiv = selectedRow.cells[2].textContent;
//                     const namaDiv = selectedRow.cells[1].textContent;
//                     const posisi = dataHidden[10];
//                     const namaPosisi = selectedRow.cells[0].textContent;
//                     const manager = dataHidden[9];
//                     const namaManager = selectedRow.cells[3].textContent;
//                     const jenis = selectedRow.cells[4].textContent;
//                     const status = selectedRow.cells[5].textContent;
//                     const jmlJam = selectedRow.cells[6].textContent;
//                     const aturan = selectedRow.cells[7].textContent;
//                     const grupDivisi = selectedRow.cells[8].textContent;

//                     // Isi data ke elemen input
//                     idDivInput.value = idDiv;
//                     namaDivInput.value = namaDiv;
//                     posisiInput.value = posisi;
//                     namaPosisiInput.value = namaPosisi;
//                     managerInput.value = manager;
//                     namaManagerInput.value = namaManager;
//                     jenisInput.value = jenis;
//                     statusInput.value = status;
//                     jmlJamInput.value = jmlJam;
//                     aturanInput.value = aturan;
//                     grupDivisiInput.value = grupDivisi;
//                     opsiJenisSelect.value = jenisInput.value;
//                     opsiStatusSelect.value = statusInput.value;
//                 }
//             }
//         });
// });

// document.addEventListener("DOMContentLoaded", function () {
//     const opsiJenis = document.getElementById("opsiJenis");
//     const idJenis = document.getElementById("id_jenis");

//     opsiJenis.addEventListener("change", function () {
//         idJenis.value = opsiJenis.value;
//     });
// });
// document.addEventListener("DOMContentLoaded", function () {
//     const opsiStatus = document.getElementById("opsiStatus");
//     const idStatus = document.getElementById("Id_Status");

//     opsiStatus.addEventListener("change", function () {
//         idStatus.value = opsiStatus.value;
//     });
// });

// document.addEventListener("DOMContentLoaded", function () {

//     //Button isi diklik maka

// });
