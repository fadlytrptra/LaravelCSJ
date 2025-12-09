$(document).ready(function () {
    const isiButton = document.getElementById("isiButton");
    const simpanIsiButton = document.getElementById("simpanIsiButton");
    const clearButton = document.getElementById("clearButton");
    const simpanKoreksiButton = document.getElementById("simpanKoreksiButton");
    const koreksiButton = document.getElementById("koreksiButton");
    const batalButton = document.getElementById("batalButton");
    const hapusButton = document.getElementById("hapusButton");
    const Id_Klinik = document.getElementById("Id_Klinik");
    const Nama_Klinik = document.getElementById("Nama_Klinik");
    const AlamatKlinik = document.getElementById("AlamatKlinik");
    const KotaKlinik = document.getElementById("KotaKlinik");
    const NomorTelepon = document.getElementById("NomorTelepon");
    const KlinikButton = document.getElementById("klinikButton");
    const simpanHapusButton = document.getElementById("simpanHapusButton");
    $("#table_Klinik").DataTable({
        order: [[0, "asc"]],
    });
    $("#table_Klinik tbody").on("click", "tr", function () {
        // Get the data from the clicked row
        var rowData = $("#table_Klinik").DataTable().row(this).data();
        // Populate the input fields with the data
        $("#Id_Klinik").val(rowData[0]);
        $("#Nama_Klinik").val(rowData[1]);

        var kode = document.getElementById("Id_Klinik").value;
        fetch("/ProgramPayroll/MasterKlinik/" + kode + ".getKlinik")
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json(); // Assuming the response is in JSON format
            })
            .then((data) => {
                data.forEach((item) => {
                    $("#AlamatKlinik").val(item.Alamat);
                    $("#KotaKlinik").val(item.Kota);
                    $("#NomorTelepon").val(item.Telp);
                });

                // Redraw the table to show the changes
                $("#table_Pegawai").DataTable().draw();
            })
            .catch((error) => {
                console.error("Error:", error);
            });
        // Hide the modal immediately after populating the data
        hideModalKlinik();
    });
    isiButton.addEventListener("click", function (event) {
        // KlinikButton.disabled = false;
        isiButton.hidden = true;
        clearButton.hidden = false;
        simpanIsiButton.hidden = false;
        // Id_Klinik.readOnly = false;
        koreksiButton.hidden = true;
        Nama_Klinik.readOnly = false;
        AlamatKlinik.readOnly = false;
        KotaKlinik.readOnly = false;
        NomorTelepon.readOnly = false;
        hapusButton.disabled = true;
        batalButton.disabled = false;
    });
    koreksiButton.addEventListener("click", function (event) {
        KlinikButton.disabled = false;
        koreksiButton.hidden = true;
        simpanKoreksiButton.hidden = false;
        clearButton.hidden = false;
        isiButton.hidden = true;
        Nama_Klinik.readOnly = false;
        AlamatKlinik.readOnly = false;
        KotaKlinik.readOnly = false;
        NomorTelepon.readOnly = false;
        hapusButton.disabled = true;
        batalButton.disabled = false;
    });
    batalButton.addEventListener("click", function (event) {
        KlinikButton.disabled = true;
        isiButton.hidden = false;
        simpanHapusButton.hidden = true;
        simpanIsiButton.hidden = true;
        clearButton.hidden = true;
        koreksiButton.hidden = false;
        simpanKoreksiButton.hidden = true;
        koreksiButton.disabled = false;
        isiButton.hidden = false;
        Id_Klinik.readOnly = true;
        Nama_Klinik.readOnly = true;
        AlamatKlinik.readOnly = true;
        KotaKlinik.readOnly = true;
        NomorTelepon.readOnly = true;
        hapusButton.disabled = false;
        batalButton.disabled = true;
        clearForm();
    });
    clearButton.addEventListener("click", function (event) {
        clearForm();
    });
    function clearForm() {
        $("#Id_Klinik").val("");
        $("#Nama_Klinik").val("");
        $("#AlamatKlinik").val("");
        $("#KotaKlinik").val("");
        $("#NomorTelepon").val("");

    }
    simpanIsiButton.addEventListener("click", function (event) {
        event.preventDefault();

        const Nama_Klinik = document.getElementById("Nama_Klinik").value;
        const AlamatKlinik = document.getElementById("AlamatKlinik").value;
        const KotaKlinik = document.getElementById("KotaKlinik").value;
        const NomorTelepon = document.getElementById("NomorTelepon").value;
        // if (Nama_Klinik === "" || AlamatKlinik === "" || KotaKlinik === "" || NomorTelepon === "") {
        //     // Salah satu atau lebih elemen input memiliki nilai kosong
        //     alert("Mohon isi semua field yang diperlukan.");
        //     return; // Menghentikan eksekusi lebih lanjut
        // }
        if (Nama_Klinik == "") {
            alert("Mohon isi nama kliniknya.");
         return; // Menghentikan eksekusi lebih lanjut
        }
        const data = {
            nm: Nama_Klinik,
            alamat: AlamatKlinik,
            kota: KotaKlinik,
            telp: NomorTelepon,
        };
        console.log(data);

        const formContainer = document.getElementById("form-container");
        const form = document.createElement("form");
        form.setAttribute("action", "MasterKlinik");
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
        const idklinik = document.getElementById("Id_Klinik").value;
        const Nama_Klinik = document.getElementById("Nama_Klinik").value;
        const AlamatKlinik = document.getElementById("AlamatKlinik").value;
        const KotaKlinik = document.getElementById("KotaKlinik").value;
        const NomorTelepon = document.getElementById("NomorTelepon").value;
        if (idklinik === "" || Nama_Klinik === "" || AlamatKlinik === "" || KotaKlinik === "" || NomorTelepon === "") {
            // Salah satu atau lebih elemen input memiliki nilai kosong
            alert("Masih ada field yang kosong !");
            return; // Menghentikan eksekusi lebih lanjut
        }
        const data = {
            idklinik: idklinik,
            nm: Nama_Klinik,
            alamat: AlamatKlinik,
            kota: KotaKlinik,
            telp: NomorTelepon,
        };
        console.log(data);

        const formContainer = document.getElementById("form-container");
        const form = document.createElement("form");
        form.setAttribute("action", "MasterKlinik/{idklinik}");
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
    hapusButton.addEventListener("click", function (event) {
        simpanHapusButton.hidden = false;
        koreksiButton.hidden = true;
        isiButton.hidden = true;
        clearButton.hidden = false;
        batalButton.disabled = false;
        KlinikButton.disabled = false;
        hapusButton.disabled = true;
    });
    simpanHapusButton.addEventListener("click", function (event) {
        event.preventDefault();
        const idklinik = document.getElementById("Id_Klinik").value;
        if (idklinik === "") {
            alert("Pilih Dulu Kliniknya !");
            return; // Menghentikan eksekusi lebih lanjut
        }
        const data = {
            idklinik: idklinik,
        };

        const formContainer = document.getElementById("form-container");
        const form = document.createElement("form");
        form.setAttribute("action", "MasterKlinik/{idklinik}");
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
});
function showModalKlinik() {
    $("#modalKlinik").modal("show");
}
function hideModalKlinik() {
    $("#modalKlinik").modal("hide");
}
