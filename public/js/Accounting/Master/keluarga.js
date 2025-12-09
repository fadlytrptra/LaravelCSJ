$(document).ready(function () {
    $("#tabel_Divisi").DataTable({
        order: [[0, "asc"]],
    });
    $("#tabel_Karyawan").DataTable({
        order: [[0, "asc"]],
    });
    $("#tabel_PISAT").DataTable({
        order: [[0, "asc"]],
    });
    $("#tabel_Kawin").DataTable({
        order: [[0, "asc"]],
    });
    $("#tabel_Keluarga").DataTable({
        order: [[0, "asc"]],
    });
    $("#tabel_Klinik").DataTable({
        order: [[0, "asc"]],
    });
    $("#tabel_Hubungan").DataTable({
        order: [[0, "asc"]],
    });
    $("#tabel_Pisat2").DataTable({
        order: [[0, "asc"]],
    });
    $("#tabel_Kawin2").DataTable({
        order: [[0, "asc"]],
    });

    // function hideModalDivisi() {
    //     $("#modalDivPeg").removeClass("show");
    //     $("#modalDivPeg").css("display", "none");
    //     $("body").removeClass("modal-open");
    //     removeBackdrop();
    // }
    // function hideModalKaryawan() {
    //     $("#modalKaryawan").removeClass("show");
    //     $("#modalKaryawan").css("display", "none");
    //     $("body").removeClass("modal-open");
    //     removeBackdrop();
    // }
    // function hideModalPISAT() {
    //     $("#modalPisat").removeClass("show");
    //     $("#modalPisat").css("display", "none");
    //     $("body").removeClass("modal-open");
    //     removeBackdrop();
    // }
    // function hideModalKawin() {
    //     $("#modalKawin").removeClass("show");
    //     $("#modalKawin").css("display", "none");
    //     $("body").removeClass("modal-open");
    //     removeBackdrop();
    // }
    // function removeBackdrop() {
    //     $(".modal-backdrop").remove();
    // }

    const divisiButton = document.getElementById("divisiButton");
    const karyawanButton = document.getElementById("karyawanButton");
    const clearButtonPekerja = document.getElementById("ClearPekerja");
    const simpanButtonPekerja = document.getElementById("SimpanPekerja");
    const clearButtonKel = document.getElementById("clearButtonKel");
    const tambahButtonKel = document.getElementById("tambahButtonKel");
    const simpanTambahKel = document.getElementById("simpanTambahKel");
    const batalTambahKel = document.getElementById("batalTambahKel");
    const koreksiButtonKel = document.getElementById("koreksiButtonKel");
    const simpanKoreksiKel = document.getElementById("simpanKoreksiKel");
    const batalKoreksiKel = document.getElementById("batalKoreksiKel");
    const hapusButtonKel = document.getElementById("hapusButtonKel");
    tambahButtonKel.addEventListener("click", function (event) {
        tambahButtonKel.hidden = true;
        simpanTambahKel.hidden = false;
        batalTambahKel.hidden = false;
        koreksiButtonKel.hidden = true;
        hapusButtonKel.disabled = true;
    });
    batalTambahKel.addEventListener("click", function (event) {
        tambahButtonKel.hidden = false;
        simpanTambahKel.hidden = true;
        batalTambahKel.hidden = true;
        koreksiButtonKel.hidden = false;
        hapusButtonKel.disabled = false;
    });
    koreksiButtonKel.addEventListener("click", function (event) {
        koreksiButtonKel.hidden = true;
        tambahButtonKel.hidden = true;
        simpanKoreksiKel.hidden = false;
        batalKoreksiKel.hidden = false;
        hapusButtonKel.disabled = true;
    });
    batalKoreksiKel.addEventListener("click", function (event) {
        tambahButtonKel.hidden = false;
        simpanKoreksiKel.hidden = true;
        batalKoreksiKel.hidden = true;
        koreksiButtonKel.hidden = false;
        hapusButtonKel.disabled = false;
    });
    clearButtonPekerja.addEventListener("click", function () {
        const checkbox = document.getElementById("checkBPJS");
        checkbox.checked = false;
        $("#Id_Div").val("");
        $("#Nama_Div").val("");
        $("#Id_Peg").val("");
        $("#Nama_Peg").val("");
        $("#NomorKK").val("");
        $("#Kd_PISAT").val("");
        $("#PISAT").val("");
        $("#Kd_Kawin").val("");
        $("#Kawin").val("");
        $("#tabel_Keluarga").DataTable().clear().draw();
    });
    clearButtonKel.addEventListener("click", function () {
        $("#Id_Keluarga").val("");
        $("#Nama_Keluarga").val("");
        $("#Id_Hub_Keluarga").val("");
        $("#Status_Hub_Keluarga").val("");
        $('input[name="opsiKelamin"]').prop("checked", false);
        $("#Kota_Lahir").val("");
        $("#TglLahir").val("");
        $("#Id_Pisat_Kel").val("");
        $("#Nama_Pisat_Kel").val("");
        $("#Id_Status_Kawin_Kel").val("");
        $("#Status_Kawin_Kel").val("");
        $("#NIK_Kel").val("");
        $("#BPJS_Kel").val("");
        $("#Id_Klinik_Kel").val("");
        $("#Nama_Klinik_Kel").val("");
    });

    simpanButtonPekerja.addEventListener("click", function (event) {
        event.preventDefault();
        const idPeg = document.getElementById("Id_Peg").value;
        const NoKK = document.getElementById("NomorKK").value;
        const Kd_PISAT = document.getElementById("Kd_PISAT").value;
        const Kd_Kawin = document.getElementById("Kd_Kawin").value;
        var tgg = 0;
        const checkbox = document.getElementById("checkBPJS");
        if (checkbox.checked) {
            tgg = 1;
        } else {
            tgg = 0;
        }
        const data = {
            kodeUpd: "simpanPegawai",
            kd_peg: idPeg,
            nokk: NoKK,
            PISAT: Kd_PISAT,
            status: Kd_Kawin,
            tgg: tgg,
        };
        console.log(data);

        const formContainer = document.getElementById("form-container");
        const form = document.createElement("form");
        form.setAttribute("action", "KaryawanKeluarga/{idPeg}");
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
        ifUpdate.value = "Update Pekerja"; // Set the value of the input field to the corresponding data
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

    divisiButton.addEventListener("click", function () {
        //Buat if yang mana yang checked di radio button maka lakukan ini
        var selectedValue = $("input[name='opsiKerja']:checked").val();
        var kode = "";
        if (selectedValue === "Harian") {
            kode = 1;
        } else if (selectedValue === "Staff") {
            kode = 2;
        }
        fetch("/ProgramPayroll/KaryawanKeluarga/" + kode + ".getDivisi")
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
                $("#tabel_Divisi").DataTable().clear().draw();

                // Loop through the data and create table rows
                data.forEach((item) => {
                    var row = [item.Id_Div, item.Nama_Div];
                    $("#tabel_Divisi").DataTable().row.add(row);
                });

                // Redraw the table to show the changes
                $("#tabel_Divisi").DataTable().draw();
            })
            .catch((error) => {
                console.error("Error:", error);
            });
    });

    karyawanButton.addEventListener("click", function () {
        var kode = document.getElementById("Id_Div").value;
        console.log(kode);
        fetch("/ProgramPayroll/KaryawanKeluarga/" + kode +".getPegawaiKeluarga")
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json(); // Assuming the response is in JSON format
            })
            .then((data) => {
                // Handle the data retrieved from the server (data should be an object or an array)

                // Clear the existing table rows
                $("#tabel_Karyawan").DataTable().clear().draw();

                // Loop through the data and create table rows
                data.forEach((item) => {
                    var row = [item.Kd_Pegawai, item.Nama_Peg];
                    $("#tabel_Karyawan").DataTable().row.add(row);
                });

                // Redraw the table to show the changes
                $("#tabel_Karyawan").DataTable().draw();
            })
            .catch((error) => {
                console.error("Error:", error);
            });
    });

    simpanTambahKel.addEventListener("click", function (event) {
        event.preventDefault();
        const idPeg = document.getElementById("Id_Peg").value;
        const idNik = document.getElementById("NIK_Kel").value;
        const nmKel = document.getElementById("Nama_Keluarga").value;
        const statKel = document.getElementById("Id_Hub_Keluarga").value;
        const tglLahir = document.getElementById("TglLahir").value;
        const idPisat = document.getElementById("Id_Pisat_Kel").value;
        const kotaLahir = document.getElementById("Kota_Lahir").value;
        const checkedKelamin = document.querySelector(
            'input[name="opsiKelamin"]:checked'
        );
        const statKawin = document.getElementById("Id_Status_Kawin_Kel").value;
        const idbpjs = document.getElementById("BPJS_Kel").value;
        const idklinik = document.getElementById("Id_Klinik_Kel").value;
        const data = {
            kdPeg: idPeg,
            idNik: idNik,
            nmKel: nmKel,
            statKel: statKel,
            tglLahir: tglLahir,
            idPisat: idPisat,
            kotaLahir: kotaLahir,
            kelamin: checkedKelamin.value,
            statKawin: statKawin,
            idbpjs: idbpjs,
            idklinik: idklinik,
        };
        console.log(data);

        const formContainer = document.getElementById("form-container");
        const form = document.createElement("form");
        form.setAttribute("action", "KaryawanKeluarga");
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

    // simpanTambahKel.addEventListener("click", function (event) {
    //     event.preventDefault();
    //     const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content"); // Ambil CSRF token dari meta tag
    //     const idPeg = document.getElementById("Id_Peg").value;
    //     const idNik = document.getElementById("NIK_Kel").value;
    //     const nmKel = document.getElementById("Nama_Keluarga").value;
    //     const statKel = document.getElementById("Id_Hub_Keluarga").value;
    //     const tglLahir = document.getElementById("TglLahir").value;
    //     const idPisat = document.getElementById("Id_Pisat_Kel").value;
    //     const kotaLahir = document.getElementById("Kota_Lahir").value;
    //     const checkedKelamin = document.querySelector(
    //         'input[name="opsiKelamin"]:checked'
    //     );
    //     const statKawin = document.getElementById("Id_Status_Kawin_Kel").value;
    //     const idbpjs = document.getElementById("BPJS_Kel").value;
    //     const idklinik = document.getElementById("Id_Klinik_Kel").value;

    //     const data = {
    //         kdPeg: idPeg,
    //         idNik: idNik,
    //         nmKel: nmKel,
    //         statKel: statKel,
    //         tglLahir: tglLahir,
    //         idPisat: idPisat,
    //         kotaLahir: kotaLahir,
    //         kelamin: checkedKelamin.value,
    //         statKawin: statKawin,
    //         idbpjs: idbpjs,
    //         idklinik: idklinik,
    //     };
    //     console.log(data);

    //     // Send data using XMLHttpRequest
    //     const xhr = new XMLHttpRequest();
    //     xhr.open("POST", "{{ route('KaryawanKeluarga.store') }}");
    //     xhr.setRequestHeader("Content-Type", "application/json");
    //     xhr.setRequestHeader("X-CSRF-Token", csrfToken);

    //     xhr.onload = function () {
    //         if (xhr.status === 200) {
    //             console.log("Form submitted successfully!");
    //             // Assuming your datatable has an API to refresh, use it here
    //             // For example, if you're using DataTables:
    //             // yourDatatable.api().ajax.reload();
    //         } else {
    //             console.error("Form submission error:", xhr.responseText);
    //         }
    //     };

    //     xhr.send(JSON.stringify(data));
    // });
    simpanKoreksiKel.addEventListener("click", function (event) {
        event.preventDefault();
        const idKel = document.getElementById("Id_Keluarga").value;
        const idNik = document.getElementById("NIK_Kel").value;
        const nmKel = document.getElementById("Nama_Keluarga").value;
        const statKel = document.getElementById("Id_Hub_Keluarga").value;
        const tglLahir = document.getElementById("TglLahir").value;
        const idPisat = document.getElementById("Id_Pisat_Kel").value;
        const kotaLahir = document.getElementById("Kota_Lahir").value;
        const checkedKelamin = document.querySelector(
            'input[name="opsiKelamin"]:checked'
        );
        const statKawin = document.getElementById("Id_Status_Kawin_Kel").value;
        const idbpjs = document.getElementById("BPJS_Kel").value;
        const idklinik = document.getElementById("Id_Klinik_Kel").value;
        const data = {
            kodeUpd: "simpanKeluarga",
            idKel: idKel,
            idNik: idNik,
            nmKel: nmKel,
            statKel: statKel,
            tglLahir: tglLahir,
            idPisat: idPisat,
            kotaLahir: kotaLahir,
            kelamin: checkedKelamin.value,
            statKawin: statKawin,
            idbpjs: idbpjs,
            idklinik: idklinik,
        };
        console.log(data);

        const formContainer = document.getElementById("form-container");
        const form = document.createElement("form");
        form.setAttribute("action", "KaryawanKeluarga/{idKel}");
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
    hapusButtonKel.addEventListener("click", function (event) {
        event.preventDefault();
        const konfirmasi = window.confirm("Anda yakin ingin menghapus data?");
        if (konfirmasi) {
            const id = document.getElementById("Id_Keluarga").value;

        const data = {
            idKel: id,
        };

        const formContainer = document.getElementById("form-container");
        const form = document.createElement("form");
        form.setAttribute("action", "KaryawanKeluarga/{id}" );
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
        }
        else {
            alert("Penghapusan dibatalkan.");
        }

    });

    $("#tabel_Divisi tbody").on("click", "tr", function () {
        // Get the data from the clicked row
        var rowData = $("#tabel_Divisi").DataTable().row(this).data();
        // Populate the input fields with the data
        $("#Id_Div").val(rowData[0]);
        $("#Nama_Div").val(rowData[1]);
        hideModalDivisi();
    });
    $("#tabel_Karyawan tbody").on("click", "tr", function () {
        // Get the data from the clicked row
        var rowData = $("#tabel_Karyawan").DataTable().row(this).data();
        const checkbox = document.getElementById("checkBPJS");

        // Populate the input fields with the data
        $("#Id_Peg").val(rowData[0]);
        $("#Nama_Peg").val(rowData[1]);
        fetch("/ProgramPayroll/KaryawanKeluarga/" + rowData[0] +".getDataPegawai")
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json(); // Assuming the response is in JSON format
            })
            .then((data) => {
                // Handle the data retrieved from the server (data should be an object or an array)

                // Loop through the data and create table rows
                data.forEach((item) => {
                    $("#Nama_Peg").val(item.Nama_Peg);
                    $("#NomorKK").val(item.NoKK);
                    $("#Kd_PISAT").val(item.KdPisat);
                    $("#PISAT").val(item.Pisat);
                    $("#Kd_Kawin").val(item.StatusKK);
                    $("#Kawin").val(item.Status);
                    const penanggungValue = Number(item.Penanggung);

                    // Gunakan operator === untuk perbandingan dengan angka
                    if (penanggungValue === 0) {
                        checkbox.checked = false; // Set unchecked jika item.Penanggung bernilai 0
                    } else if (penanggungValue === 1) {
                        checkbox.checked = true; // Set checked jika item.Penanggung bernilai 1
                    }
                });

                // Redraw the table to show the changes
            })
            .catch((error) => {
                console.error("Error:", error);
            });
        fetch("/ProgramPayroll/KaryawanKeluarga/" + rowData[0] + ".getDataKeluarga")
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json(); // Assuming the response is in JSON format
            })
            .then((data) => {
                // Handle the data retrieved from the server (data should be an object or an array)

                // Clear the existing table rows
                $("#tabel_Keluarga").DataTable().clear().draw();
                console.log(data);
                // Loop through the data and create table rows
                data.forEach((item) => {
                    var row = [
                        item.IdKeluarga,
                        item.Nama,
                        item.StatusKeluarga,
                        item.Hubungan,
                        item.Kelamin,
                        item.KotaLahir,
                        item.TglLahir,
                        item.KdPisat,
                        item.Pisat,
                        item.StatusKawin,
                        item.Status,
                        item.NIK,
                        item.IdBPJS,
                        item.Klinik,
                        item.Nama_Klinik,
                    ];
                    $("#tabel_Keluarga").DataTable().row.add(row);
                });

                // Redraw the table to show the changes
                $("#tabel_Keluarga").DataTable().draw();
            })
            .catch((error) => {
                console.error("Error:", error);
            });
        hideModalKaryawan();
    });
    $("#tabel_PISAT tbody").on("click", "tr", function () {
        // Get the data from the clicked row
        var rowData = $("#tabel_PISAT").DataTable().row(this).data();
        // Populate the input fields with the data
        $("#Kd_PISAT").val(rowData[0]);
        $("#PISAT").val(rowData[1]);
        hideModalPISAT();
    });
    $("#tabel_Kawin tbody").on("click", "tr", function () {
        // Get the data from the clicked row
        var rowData = $("#tabel_Kawin").DataTable().row(this).data();
        // Populate the input fields with the data
        $("#Kd_Kawin").val(rowData[0]);
        $("#Kawin").val(rowData[1]);
        hideModalKawin();
    });
    $("#tabel_Keluarga tbody").on("click", "tr", function () {
        // Get the data from the clicked row
        var rowData = $("#tabel_Keluarga").DataTable().row(this).data();
        var date = rowData[6].split(" ")[0];
        // Populate the input fields with the data
        $("#Id_Keluarga").val(rowData[0]);
        $("#Nama_Keluarga").val(rowData[1]);
        $("#Id_Hub_Keluarga").val(rowData[2]);
        $("#Status_Hub_Keluarga").val(rowData[3]);
        $('input[name="opsiKelamin"][value="' + rowData[4] + '"]').prop(
            "checked",
            true
        );
        $("#Kota_Lahir").val(rowData[5]);
        $("#TglLahir").val(date);
        $("#Id_Pisat_Kel").val(rowData[7]);
        $("#Nama_Pisat_Kel").val(rowData[8]);
        $("#Id_Status_Kawin_Kel").val(rowData[9]);
        $("#Status_Kawin_Kel").val(rowData[10]);
        $("#NIK_Kel").val(rowData[11]);
        $("#BPJS_Kel").val(rowData[12]);
        $("#Id_Klinik_Kel").val(rowData[13]);
        $("#Nama_Klinik_Kel").val(rowData[14]);
    });
    $("#tabel_Hubungan tbody").on("click", "tr", function () {
        // Get the data from the clicked row
        var rowData = $("#tabel_Hubungan").DataTable().row(this).data();
        // Populate the input fields with the data
        $("#Id_Hub_Keluarga").val(rowData[0]);
        $("#Status_Hub_Keluarga").val(rowData[1]);
        hideModalHubungan();
    });
    $("#tabel_Pisat2 tbody").on("click", "tr", function () {
        // Get the data from the clicked row
        var rowData = $("#tabel_Pisat2").DataTable().row(this).data();
        // Populate the input fields with the data
        $("#Id_Pisat_Kel").val(rowData[0]);
        $("#Nama_Pisat_Kel").val(rowData[1]);
        hideModalPisat2();
    });
    $("#tabel_Kawin2 tbody").on("click", "tr", function () {
        // Get the data from the clicked row
        var rowData = $("#tabel_Kawin2").DataTable().row(this).data();
        // Populate the input fields with the data
        $("#Id_Status_Kawin_Kel").val(rowData[0]);
        $("#Status_Kawin_Kel").val(rowData[1]);
        hideModalKawin2();
    });
});
function showModalDivisi() {
    $("#modalDivPeg").modal("show");
}
function hideModalDivisi() {
    $("#modalDivPeg").modal("hide");
}
function showModalKaryawan() {
    $("#modalKaryawan").modal("show");
}
function hideModalKaryawan() {
    $("#modalKaryawan").modal("hide");
}
function showModalPisat() {
    $("#modalPisat").modal("show");
}
function hideModalPisat() {
    $("#modalPisat").modal("hide");
}
function showModalKawin() {
    $("#modalKawin").modal("show");
}
function hideModalKawin() {
    $("#modalKawin").modal("hide");
}
function showModalHubungan() {
    $("#modalHubungan").modal("show");
}
function hideModalHubungan() {
    $("#modalHubungan").modal("hide");
}
function showModalPisat2() {
    $("#modalPisat2").modal("show");
}
function hideModalPisat2() {
    $("#modalPisat2").modal("hide");
}
function showModalKawin2() {
    $("#modalKawin2").modal("show");
}
function hideModalKawin2() {
    $("#modalKawin2").modal("hide");
}
