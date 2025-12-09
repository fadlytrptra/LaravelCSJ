$(document).ready(function () {
    $("#tabel_Posisi").DataTable({
        order: [[0, "asc"]],
    });
    $("#tabel_Divisi").DataTable({
        order: [[0, "asc"]],
    });
    $("#tabel_Pegawai").DataTable({
        order: [[0, "asc"]],
    });
    $("#tabel_Shift").DataTable({
        order: [[0, "asc"]],
    });

    // function hideModalPosisi() {
    //     $("#modalPosisi").removeClass("show");
    //     $("#modalPosisi").css("display", "none");
    //     $("body").removeClass("modal-open");
    //     removeBackdrop();
    // }
    const Kd_Peg = document.getElementById("Id_Peg");
    const Nama_Peg = document.getElementById("Nama_Peg");
    const isiPegawai = document.getElementById("isiButton");
    const koreksiPegawai = document.getElementById("KoreksiButton");
    const SimpanIsiPegawai = document.getElementById("SimpanIsiButton");
    const SimpanKoreksiPegawai = document.getElementById("SimpanKoreksiButton");
    const BatalIsiPegawai = document.getElementById("BatalIsiButton");
    const BatalKoreksiPegawai = document.getElementById("BatalKoreksiButton");
    const HapusButton = document.getElementById("HapusButton");
    $("#tabel_Posisi tbody").on("click", "tr", function () {
        // Get the data from the clicked row
        clearForm();
        $("#Id_Div").val("");
        $("#Nama_Div").val("");
        var rowData = $("#tabel_Posisi").DataTable().row(this).data();
        // Populate the input fields with the data
        $("#Kd_Posisi").val(rowData[0]);
        $("#Nama_Posisi").val(rowData[1]);
        fetch("/ProgramPayroll/KaryawanHarian/" + rowData[0] + ".getDivisi")
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json(); // Assuming the response is in JSON format
            })
            .then((data) => {
                // Handle the data retrieved from the server (data should be an object or an array)

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
        // var idDivValue = rowData[0];
        // submitFormWithIdDiv(idDivValue);
        // Hide the modal immediately after populating the data
        hideModalPosisi();
    });
    $("#tabel_Divisi tbody").on("click", "tr", function () {
        // Get the data from the clicked row
        // clearForm();

        var rowData = $("#tabel_Divisi").DataTable().row(this).data();
        // Populate the input fields with the data
        $("#Id_Div").val(rowData[0]);
        $("#Nama_Div").val(rowData[1]);
        fetch(
            "/ProgramPayroll/KaryawanHarian/" + rowData[0] + ".getNamaPegawai"
        )
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json(); // Assuming the response is in JSON format
            })
            .then((data) => {
                // Handle the data retrieved from the server (data should be an object or an array)

                // Clear the existing table rows
                $("#tabel_Pegawai").DataTable().clear().draw();
                fetch(
                    "/ProgramPayroll/KaryawanHarian/" + rowData[0] + ".getKodePegawai"
                )
                    .then((response) => {
                        if (!response.ok) {
                            throw new Error("Network response was not ok");
                        }
                        return response.json(); // Assuming the response is in JSON format
                    })
                    .then((data) => {
                        // Handle the data retrieved from the server (data should be an object or an array)

                        // Clear the existing table rows


                        // Loop through the data and create table rows

                        if (data[0].kode != null) {
                            let kd_peg = data[0].kode;
                            let id_div = rowData[0];

                            $("#Id_Peg").val(kd_peg);
                            kd_peg = parseInt(kd_peg.toString().slice(-4)) + 1;
                            kd_peg = id_div.trim() + ("0000" + kd_peg.toString()).slice(-4);
                            $("#Id_Peg").val(kd_peg);
                        }



                        // Redraw the table to show the changes

                    })
                    .catch((error) => {
                        console.error("Error:", error);
                    });
                // Loop through the data and create table rows
                data.forEach((item) => {
                    var row = [item.kd_pegawai, item.nama_peg];
                    $("#tabel_Pegawai").DataTable().row.add(row);
                });

                // Redraw the table to show the changes
                $("#tabel_Pegawai").DataTable().draw();
            })
            .catch((error) => {
                console.error("Error:", error);
            });
        // var idDivValue = rowData[0];
        // submitFormWithIdDiv(idDivValue);
        // Hide the modal immediately after populating the data
        hideModalDivisi();
    });
    $("#tabel_Pegawai tbody").on("click", "tr", function () {
        // Get the data from the clicked row
        // clearForm();
        var rowData = $("#tabel_Pegawai").DataTable().row(this).data();
        // Populate the input fields with the data
        $("#Id_Peg").val(rowData[0]);
        $("#Nama_Peg").val(rowData[1]);
        fetch("/ProgramPayroll/KaryawanHarian/" + rowData[0] + ".getPegawai")
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json(); // Assuming the response is in JSON format
            })
            .then((data) => {
                // Handle the data retrieved from the server (data should be an object or an array)
                console.log(data);
                data.forEach((item) => {
                    $("#NomorInduk").val(item.No_Induk);
                    $("#NomorKartu").val(item.No_Kartu);
                    $("#Alamat").val(item.Alamat);
                    $("#namaKota").val(item.Kota);
                    $("#tempatLahir").val(item.Tmp_Lahir);
                    if (item.Tgl_Lahir != null) {
                        $("#TglLahir").val(item.Tgl_Lahir.split(" ")[0]);
                    }
                    $("#JenisKelamin").val(item.Jns_Kelamin);
                    $("#Agama").val(item.Agama);
                    $("#StatusKawin").val(item.Kawin);
                    if (item.Tgl_Masuk != null) {
                        $("#TglMasuk").val(handleEmptyValue(item.Tgl_Masuk.split(" ")[0]));
                    }
                    if (item.Tgl_Masuk_Awal != null) {
                        $("#TglMasukAwal").val(handleEmptyValue(item.Tgl_Masuk_Awal.split(" ")[0]));
                    }
                    $("#Jabatan").val(item.Jabatan);
                    $("#Golongan").val(item.Golongan);
                    $("#NomorAstek").val(item.No_Astek);
                    $("#NomorRBH").val(item.No_RBH);
                    $("#NomorKop").val(item.No_Koperasi);
                    if (item.Tgl_Agt_Kop != null) {
                        $("#TglMasukKop").val(handleEmptyValue(item.Tgl_Agt_Kop.split(" ")[0]));
                    }
                    $("#upahPokok").val(item.Gaji_Pokok);
                    $("#upahGolongan").val(item.U_Golongan);
                    $("#TunjanganJabatan").val(item.T_Jabatan);
                    $("#upahJenjang").val(item.U_Jenjang);
                    $("#TinggiBadan").val(item.Tinggi_badan);
                    $("#BeratBadan").val(item.berat_badan);
                    $("#Pendidikan").val(item.Pendidikan);
                    $("#Id_Shift").val(item.shift);
                    if (item.TglAwalKontrak != null) {
                        $("#TglAwalKontrak").val(item.TglAwalKontrak.split(" ")[0]);
                        console.log('lol');
                    }
                    if (item.TglAwalKontrak != null) {
                        $("#TglAkhirKontrak").val(
                            item.TglAkhirKontrak.split(" ")[0]
                        );
                    }

                    $("#JmlTanggungan").val(item.Tanggungan);
                    $("#NPWP").val(item.NPWP);
                    $("#NomorRek").val(item.no_rek);
                    $("#NIK").val(item.NIK);
                });
                // $("#Id_Div").val(data['Id_Div']);
                // $("#Id_Peg").val("");
                // $("#Nama_Peg").val("");
            })
            .catch((error) => {
                console.error("Error:", error);
            });
        // var idDivValue = rowData[0];
        // submitFormWithIdDiv(idDivValue);
        // Hide the modal immediately after populating the data
        hideModalPegawai();
    });
    $("#tabel_Shift tbody").on("click", "tr", function () {
        // Get the data from the clicked row
        var rowData = $("#tabel_Shift").DataTable().row(this).data();
        // Populate the input fields with the data
        $("#Id_Shift").val(rowData[0]);
        $("#Jam").val(rowData[1]);

        // var idDivValue = rowData[0];
        // submitFormWithIdDiv(idDivValue);
        // Hide the modal immediately after populating the data
        hideModalShift();
    });
    function checkInputs() {
        const inputs = [
            "Id_Div",
            "Id_Peg",
            "Nama_Peg",
            "NomorInduk",
            "NomorKartu",
            "Alamat",
            "namaKota",
            "tempatLahir",
            "TglLahir",
            "JenisKelamin",
            "Agama",
            "StatusKawin",
            "TglMasuk",
            "TglMasukAwal",
            "Jabatan",
            "Golongan",
            "NomorAstek",
            "NomorRBH",
            "NomorKop",
            "TglMasukKop",
            "upahPokok",
            "upahGolongan",
            "TunjanganJabatan",
            "upahJenjang",
            "TinggiBadan",
            "BeratBadan",
            "Pendidikan",
            "Id_Shift",
            "Kd_Posisi",
            "TglAwalKontrak",
            "TglAkhirKontrak",
            "JmlTanggungan",
            "NPWP",
            "NomorRek",
            "NIK",
        ];

        let isComplete = true;

        for (const input of inputs) {
            const value = document.getElementById(input).value.trim();
            if (value === "") {
                isComplete = false;
                break;
            }
        }

        if (isComplete) {
            // Semua input terisi, lanjutkan dengan operasi berikutnya
            // Misalnya, simpan data atau tampilkan pesan sukses.
            console.log("Semua input sudah terisi.");
        } else {
            // Ada input yang belum terisi, tampilkan pesan error.
            console.error("Mohon lengkapi semua input terlebih dahulu.");
        }
    }
    function handleEmptyValue(value) {
        return value.trim() === "" ? null : value;
    }
    SimpanIsiPegawai.addEventListener("click", function (event) {
        event.preventDefault();


        let csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");
        const id_div = document.getElementById("Id_Div").value;
        const kd_peg = document.getElementById("Id_Peg").value;
        const nama_peg = document.getElementById("Nama_Peg").value;
        const no_induk = document.getElementById("NomorInduk").value;
        const no_kartu = document.getElementById("NomorKartu").value;
        const jenis_peg = 1;
        const alamat = document.getElementById("Alamat").value;
        const kota = document.getElementById("namaKota").value;
        const tmp_lahir = document.getElementById("tempatLahir").value;
        const tgl_lahir = document.getElementById("TglLahir").value;
        const jns_kelamin = document.getElementById("JenisKelamin").value;
        const agama = document.getElementById("Agama").value;
        const kawin = document.getElementById("StatusKawin").value;
        const tgl_masuk = document.getElementById("TglMasuk").value;
        const tgl_masuk_awal = document.getElementById("TglMasukAwal").value;
        const jabatan = document.getElementById("Jabatan").value;
        const golongan = document.getElementById("Golongan").value;
        const no_astek = document.getElementById("NomorAstek").value;
        const no_rbh = document.getElementById("NomorRBH").value;
        const no_koperasi = document.getElementById("NomorKop").value;
        const tgl_agt_kop = document.getElementById("TglMasukKop").value;
        const gaji_pokok = document.getElementById("upahPokok").value;
        const u_golongan = document.getElementById("upahGolongan").value;
        const t_jabatan = document.getElementById("TunjanganJabatan").value;
        const u_jenjang = document.getElementById("upahJenjang").value;
        const Tinggi_Badan = document.getElementById("TinggiBadan").value;
        const berat_Badan = document.getElementById("BeratBadan").value;
        const pendidikan = document.getElementById("Pendidikan").value;
        const Shift = document.getElementById("Id_Shift").value;
        const pos = document.getElementById("Kd_Posisi").value;
        const TglAwalKontrak = document.getElementById("TglAwalKontrak").value;
        const TglAkhirKontrak =
            document.getElementById("TglAkhirKontrak").value;
        const Tanggungan = document.getElementById("JmlTanggungan").value;
        const NPWP = document.getElementById("NPWP").value;
        const No_rek = document.getElementById("NomorRek").value;
        const NIK = document.getElementById("NIK").value;
        if (nama_peg == "" || gaji_pokok == "" ||u_golongan == "" ||t_jabatan == "" ||u_jenjang == ""|| gaji_pokok == 0 ||u_golongan == 0 ||t_jabatan == 0 ||u_jenjang == 0) {
            alert("Nama/Upah Belum Terinput .....");
            console.log(tgl_lahir);
            return;
        }
        if (!isNaN(NIK) && NIK.length === 16) {
            console.log("Input adalah 16 digit.");
        } else {
            alert("Jumlah digit NIK yang Anda input tidak sesuai. Harus 16 digit")
            return;
        }
        const data = {
            _token: csrfToken,
            id_div: id_div,
            kd_peg: kd_peg,
            nama_peg: nama_peg,
            no_induk: handleEmptyValue(no_induk),
            no_kartu: handleEmptyValue(no_kartu),
            jenis_peg: jenis_peg,
            alamat: handleEmptyValue(alamat),
            kota: handleEmptyValue(kota),
            tmp_lahir: handleEmptyValue(tmp_lahir),
            tgl_lahir: handleEmptyValue(tgl_lahir),
            jns_kelamin: handleEmptyValue(jns_kelamin),
            agama: handleEmptyValue(agama),
            kawin: handleEmptyValue(kawin),
            tgl_masuk: handleEmptyValue(tgl_masuk),
            tgl_masuk_awal: handleEmptyValue(tgl_masuk_awal),
            jabatan: handleEmptyValue(jabatan),
            golongan: handleEmptyValue(golongan),
            no_astek: handleEmptyValue(no_astek),
            no_rbh: handleEmptyValue(no_rbh),
            no_koperasi: handleEmptyValue(no_koperasi),
            tgl_agt_kop: handleEmptyValue(tgl_agt_kop),
            gaji_pokok: handleEmptyValue(gaji_pokok),
            u_golongan: handleEmptyValue(u_golongan),
            t_jabatan: handleEmptyValue(t_jabatan),
            u_jenjang: handleEmptyValue(u_jenjang),
            Tinggi_Badan: handleEmptyValue(Tinggi_Badan),
            berat_Badan: handleEmptyValue(berat_Badan),
            pendidikan: handleEmptyValue(pendidikan),
            Shift: handleEmptyValue(Shift),
            pos: handleEmptyValue(pos),
            TglAwalKontrak: handleEmptyValue(TglAwalKontrak),
            TglAkhirKontrak: handleEmptyValue(TglAkhirKontrak),
            Tanggungan: handleEmptyValue(Tanggungan),
            NPWP: handleEmptyValue(NPWP),
            No_rek: handleEmptyValue(No_rek),
            NIK: handleEmptyValue(NIK),
        };
        console.log(data);

        const formContainer = document.getElementById("form-container");
        const form = document.createElement("form");
        form.setAttribute("action", "KaryawanHarian");
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
        // let csrfToken = document
        //     .querySelector('meta[name="csrf-token"]')
        //     .getAttribute("content");
        let csrfInput = document.createElement("input");
        csrfInput.type = "hidden";
        csrfInput.name = "_token";
        csrfInput.value = csrfToken;
        form.appendChild(csrfInput);
        const inputs = [
            "Id_Div",
            "Id_Peg",
            "Nama_Peg",

            "tempatLahir",
            "TglLahir",

            "upahPokok",
            "upahGolongan",

            "NomorRek",
        ];

        let isComplete = true;

        for (const input of inputs) {
            const value = document.getElementById(input).value.trim();
            if (value === "") {
                isComplete = false;
                break;
            }
        }
        function submitForm() {
            return new Promise((resolve, reject) => {
                form.onsubmit = resolve; // Resolve the Promise when the form is submitted
                form.submit();
            });
        }
        // if (isComplete) {
            //Call the submitForm function to initiate the form submission
            submitForm()
                .then(() => console.log("Form submitted successfully!"))
                .catch((error) =>
                    console.error("Form submission error:", error)
                );
        // } else {
        //     // Ada input yang belum terisi, tampilkan pesan error.
        //     alert("Mohon lengkapi semua input terlebih dahulu.");
        // }
        // let request = {
        //     method: "POST",
        //     headers: '_token'
        //     body: JSON.stringify(data),
        // };
        // fetch("KaryawanHarian", request)
        //     .then((response) => response.json())
        //     .then((result) => {
        //         alert("data sudah disimpan!");
        //         console.log(result);
        //     });
        // $.ajax({
        //     url: 'KaryawanHarian',
        //     type: 'POST',
        //     data: data,
        //     headers: {
        //         'X-CSRF-TOKEN': csrfToken
        //     },
        //     success: function(response) {
        //         console.log(response.message);
        //         // Handle success response
        //     },
        //     error: function(error) {
        //         console.log('Error:', error);
        //         // Handle error response
        //     }
        // });
        // Wrap form submission in a Promise
    });
    function handleEmptyValue(value) {
        return value.trim() === "" ? null : value;
    }
    SimpanKoreksiPegawai.addEventListener("click", function (event) {
        event.preventDefault();

        const id_div = document.getElementById("Id_Div").value;
        const kd_peg = document.getElementById("Id_Peg").value;
        const nama_peg = document.getElementById("Nama_Peg").value;
        const no_induk = document.getElementById("NomorInduk").value;
        const no_kartu = document.getElementById("NomorKartu").value;
        const jenis_peg = 1;
        const alamat = document.getElementById("Alamat").value;
        const kota = document.getElementById("namaKota").value;
        const tmp_lahir = document.getElementById("tempatLahir").value;
        const tgl_lahir = document.getElementById("TglLahir").value;
        const jns_kelamin = document.getElementById("JenisKelamin").value;
        const agama = document.getElementById("Agama").value;
        const kawin = document.getElementById("StatusKawin").value;
        const tgl_masuk = document.getElementById("TglMasuk").value;
        const tgl_masuk_awal = document.getElementById("TglMasukAwal").value;
        const jabatan = document.getElementById("Jabatan").value;
        const golongan = document.getElementById("Golongan").value;
        const no_astek = document.getElementById("NomorAstek").value;
        const no_rbh = document.getElementById("NomorRBH").value;
        const no_koperasi = document.getElementById("NomorKop").value;
        const tgl_agt_kop = document.getElementById("TglMasukKop").value;
        const gaji_pokok = document.getElementById("upahPokok").value;
        const u_golongan = document.getElementById("upahGolongan").value;
        const t_jabatan = document.getElementById("TunjanganJabatan").value;
        const u_jenjang = document.getElementById("upahJenjang").value;
        const Tinggi_Badan = document.getElementById("TinggiBadan").value;
        const berat_Badan = document.getElementById("BeratBadan").value;
        const pendidikan = document.getElementById("Pendidikan").value;
        const Shift = document.getElementById("Id_Shift").value;
        const pos = document.getElementById("Kd_Posisi").value;
        const TglAwalKontrak = document.getElementById("TglAwalKontrak").value;
        const TglAkhirKontrak =
            document.getElementById("TglAkhirKontrak").value;
        const Tanggungan = document.getElementById("JmlTanggungan").value;
        const NPWP = document.getElementById("NPWP").value;
        const No_rek = document.getElementById("NomorRek").value;
        const NIK = document.getElementById("NIK").value;
        const data = {
            id_div: id_div,
            kd_peg: kd_peg,
            nama_peg: nama_peg,
            no_induk: handleEmptyValue(no_induk),
            no_kartu: handleEmptyValue(no_kartu),
            jenis_peg: jenis_peg,
            alamat: handleEmptyValue(alamat),
            kota: handleEmptyValue(kota),
            tmp_lahir: handleEmptyValue(tmp_lahir),
            tgl_lahir: handleEmptyValue(tgl_lahir),
            jns_kelamin: handleEmptyValue(jns_kelamin),
            agama: handleEmptyValue(agama),
            kawin: handleEmptyValue(kawin),
            tgl_masuk: handleEmptyValue(tgl_masuk),
            tgl_masuk_awal: handleEmptyValue(tgl_masuk_awal),
            jabatan: handleEmptyValue(jabatan),
            golongan: handleEmptyValue(golongan),
            no_astek: handleEmptyValue(no_astek),
            no_rbh: handleEmptyValue(no_rbh),
            no_koperasi: handleEmptyValue(no_koperasi),
            tgl_agt_kop: handleEmptyValue(tgl_agt_kop),
            gaji_pokok: handleEmptyValue(gaji_pokok),
            u_golongan: handleEmptyValue(u_golongan),
            t_jabatan: handleEmptyValue(t_jabatan),
            u_jenjang: handleEmptyValue(u_jenjang),
            Tinggi_Badan: handleEmptyValue(Tinggi_Badan),
            berat_Badan: handleEmptyValue(berat_Badan),
            pendidikan: handleEmptyValue(pendidikan),
            Shift: handleEmptyValue(Shift),
            pos: handleEmptyValue(pos),
            TglAwalKontrak: handleEmptyValue(TglAwalKontrak),
            TglAkhirKontrak: handleEmptyValue(TglAkhirKontrak),
            Tanggungan: handleEmptyValue(Tanggungan),
            NPWP: handleEmptyValue(NPWP),
            No_rek: handleEmptyValue(No_rek),
            NIK: handleEmptyValue(NIK),
        };
        console.log(data);

        const formContainer = document.getElementById("form-container");
        const form = document.createElement("form");
        form.setAttribute("action", "KaryawanHarian/{idPeg}");
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
        const inputs = [
            "Id_Div",
            "Id_Peg",
            "Nama_Peg",

            "tempatLahir",
            "TglLahir",

            "upahPokok",
            "upahGolongan",

            "NomorRek",
        ];

        let isComplete = true;

        for (const input of inputs) {
            const value = document.getElementById(input).value.trim();
            if (value === "") {
                isComplete = false;
                break;
            }
        }

        function submitForm() {
            return new Promise((resolve, reject) => {
                form.onsubmit = resolve; // Resolve the Promise when the form is submitted
                form.submit();
            });
        }
        // if (isComplete) {
            // Call the submitForm function to initiate the form submission
            submitForm()
                .then(() => console.log("Form submitted successfully!"))
                .catch((error) =>
                    console.error("Form submission error:", error)
                );
        // } else {
        //     // Ada input yang belum terisi, tampilkan pesan error.
        //     alert("Mohon lengkapi semua input terlebih dahulu bro.");
        //     return;
        // }
    });

    const divisiButton = document.getElementById("divisiButton");
    const posisiButton = document.getElementById("posisiButton");
    const pegawaiButton = document.getElementById("pegawaiButton");
    const Id_Div = document.getElementById("Id_Div");
    const Nama_Div = document.getElementById("Nama_Div");
    const kd_peg = document.getElementById("Id_Peg");
    const nama_peg = document.getElementById("Nama_Peg");
    const no_induk = document.getElementById("NomorInduk");
    const no_kartu = document.getElementById("NomorKartu");
    const jenis_peg = 1;
    const alamat = document.getElementById("Alamat");
    const kota = document.getElementById("namaKota");
    const tmp_lahir = document.getElementById("tempatLahir");
    const tgl_lahir = document.getElementById("TglLahir");
    const jns_kelamin = document.getElementById("JenisKelamin");
    const agama = document.getElementById("Agama");
    const kawin = document.getElementById("StatusKawin");
    const tgl_masuk = document.getElementById("TglMasuk");
    const tgl_masuk_awal = document.getElementById("TglMasukAwal");
    const jabatan = document.getElementById("Jabatan");
    const golongan = document.getElementById("Golongan");
    const no_astek = document.getElementById("NomorAstek");
    const no_rbh = document.getElementById("NomorRBH");
    const no_koperasi = document.getElementById("NomorKop");
    const tgl_agt_kop = document.getElementById("TglMasukKop");
    const gaji_pokok = document.getElementById("upahPokok");
    const u_golongan = document.getElementById("upahGolongan");
    const t_jabatan = document.getElementById("TunjanganJabatan");
    const u_jenjang = document.getElementById("upahJenjang");
    const Tinggi_Badan = document.getElementById("TinggiBadan");
    const berat_Badan = document.getElementById("BeratBadan");
    const pendidikan = document.getElementById("Pendidikan");
    const Shift = document.getElementById("Id_Shift");
    const pos = document.getElementById("Kd_Posisi");
    const TglMasukKop = document.getElementById("TglMasukKop");
    const TglAwalKontrak = document.getElementById("TglAwalKontrak");
    const TglAkhirKontrak = document.getElementById("TglAkhirKontrak");
    const Tanggungan = document.getElementById("JmlTanggungan");
    const NPWP = document.getElementById("NPWP");
    const No_rek = document.getElementById("NomorRek");
    const NIK = document.getElementById("NIK");
    function clearForm(){
        Id_Div.value = "";
        Nama_Div.value = "";
        kd_peg.value = "";
        nama_peg.value = "";
        no_induk.value = "";
        no_kartu.value = "";
        jenis_peg.value = "";
        alamat.value = "";
        kota.value = "";
        tmp_lahir.value = "";
        // tgl_lahir.value = "";
        jns_kelamin.value = "";
        agama.value = "";
        kawin.value = "";
        // tgl_masuk.value = "";
        // tgl_masuk_awal.value = "";
        jabatan.value = "";
        golongan.value = "";
        no_astek.value = "";
        no_rbh.value = "";
        no_koperasi.value = "";
        // tgl_agt_kop.value = "";
        gaji_pokok.value = "";
        u_golongan.value = "";
        t_jabatan.value = "";
        u_jenjang.value = "";
        Tinggi_Badan.value = "";
        berat_Badan.value = "";
        pendidikan.value = "";
        Shift.value = "";
        // pos.disabled = false;
        TglMasukKop.value = "";
        TglAwalKontrak.value = "";
        TglAkhirKontrak.value = "";
        Tanggungan.value = "";
        NPWP.value = "";
        No_rek.value = "";
        NIK.value = "";
    }
    isiPegawai.addEventListener("click", function (event) {
        clearForm();
        posisiButton.disabled = false;
        divisiButton.disabled = false;
        // kd_peg.disabled = false;
        nama_peg.disabled = false;
        no_induk.disabled = false;
        no_kartu.disabled = false;
        jenis_peg.disabled = false;
        alamat.disabled = false;
        kota.disabled = false;
        tmp_lahir.disabled = false;
        tgl_lahir.disabled = false;
        jns_kelamin.disabled = false;
        agama.disabled = false;
        kawin.disabled = false;
        tgl_masuk.disabled = false;
        tgl_masuk_awal.disabled = false;
        jabatan.disabled = false;
        golongan.disabled = false;
        no_astek.disabled = false;
        no_rbh.disabled = false;
        no_koperasi.disabled = false;
        tgl_agt_kop.disabled = false;
        gaji_pokok.disabled = false;
        u_golongan.disabled = false;
        t_jabatan.disabled = false;
        u_jenjang.disabled = false;
        Tinggi_Badan.disabled = false;
        berat_Badan.disabled = false;
        pendidikan.disabled = false;
        Shift.disabled = false;
        // pos.disabled = false;
        TglAwalKontrak.disabled = false;
        TglAkhirKontrak.disabled = false;
        Tanggungan.disabled = false;
        NPWP.disabled = false;
        No_rek.disabled = false;
        NIK.disabled = false;

        isiPegawai.hidden = true;
        koreksiPegawai.hidden = true;
        // Kd_Peg.removeAttribute("readonly");
        Nama_Peg.removeAttribute("readonly");
        SimpanIsiPegawai.hidden = false;
        BatalIsiPegawai.hidden = false;
        document.getElementById("HapusButton").disabled = true;
    });
    BatalIsiPegawai.addEventListener("click", function (event) {
        posisiButton.disabled = true;
        divisiButton.disabled = true;
        pegawaiButton.disabled = true;
        kd_peg.disabled = true;
        nama_peg.disabled = true;
        no_induk.disabled = true;
        no_kartu.disabled = true;
        jenis_peg.disabled = true;
        alamat.disabled = true;
        kota.disabled = true;
        tmp_lahir.disabled = true;
        tgl_lahir.disabled = true;
        jns_kelamin.disabled = true;
        agama.disabled = true;
        kawin.disabled = true;
        tgl_masuk.disabled = true;
        tgl_masuk_awal.disabled = true;
        jabatan.disabled = true;
        golongan.disabled = true;
        no_astek.disabled = true;
        no_rbh.disabled = true;
        no_koperasi.disabled = true;
        tgl_agt_kop.disabled = true;
        gaji_pokok.disabled = true;
        u_golongan.disabled = true;
        t_jabatan.disabled = true;
        u_jenjang.disabled = true;
        Tinggi_Badan.disabled = true;
        berat_Badan.disabled = true;
        pendidikan.disabled = true;
        Shift.disabled = true;
        pos.disabled = true;
        TglAwalKontrak.disabled = true;
        TglAkhirKontrak.disabled = true;
        Tanggungan.disabled = true;
        NPWP.disabled = true;
        No_rek.disabled = true;
        NIK.disabled = true;
        isiPegawai.hidden = false;
        koreksiPegawai.hidden = false;
        // Kd_Peg.setAttribute("readonly", "readonly");
        Nama_Peg.setAttribute("readonly", "readonly");
        SimpanIsiPegawai.hidden = true;
        BatalIsiPegawai.hidden = true;
        document.getElementById("HapusButton").disabled = false;
    });
    koreksiPegawai.addEventListener("click", function (event) {
        // console.log(kd_peg + 'lol');
        clearForm();
        posisiButton.disabled = false;
        divisiButton.disabled = false;
        pegawaiButton.disabled = false;
        // kd_peg.disabled = false;
        // nama_peg.disabled = false;
        no_induk.disabled = false;
        no_kartu.disabled = false;
        jenis_peg.disabled = false;
        alamat.disabled = false;
        kota.disabled = false;
        tmp_lahir.disabled = false;
        tgl_lahir.disabled = false;
        jns_kelamin.disabled = false;
        agama.disabled = false;
        kawin.disabled = false;
        tgl_masuk.disabled = false;
        tgl_masuk_awal.disabled = false;
        jabatan.disabled = false;
        golongan.disabled = false;
        no_astek.disabled = false;
        no_rbh.disabled = false;
        no_koperasi.disabled = false;
        tgl_agt_kop.disabled = false;
        gaji_pokok.disabled = false;
        u_golongan.disabled = false;
        t_jabatan.disabled = false;
        u_jenjang.disabled = false;
        Tinggi_Badan.disabled = false;
        berat_Badan.disabled = false;
        pendidikan.disabled = false;
        Shift.disabled = false;
        // pos.disabled = false;
        TglAwalKontrak.disabled = false;
        TglAkhirKontrak.disabled = false;
        Tanggungan.disabled = false;
        NPWP.disabled = false;
        No_rek.disabled = false;
        NIK.disabled = false;
        isiPegawai.hidden = true;
        koreksiPegawai.hidden = true;
        SimpanKoreksiPegawai.hidden = false;
        BatalKoreksiPegawai.hidden = false;
        document.getElementById("HapusButton").disabled = true;
    });
    BatalKoreksiPegawai.addEventListener("click", function (event) {
        posisiButton.disabled = true;
        divisiButton.disabled = true;
        pegawaiButton.disabled = true;
        kd_peg.disabled = true;
        nama_peg.disabled = true;
        no_induk.disabled = true;
        no_kartu.disabled = true;
        jenis_peg.disabled = true;
        alamat.disabled = true;
        kota.disabled = true;
        tmp_lahir.disabled = true;
        tgl_lahir.disabled = true;
        jns_kelamin.disabled = true;
        agama.disabled = true;
        kawin.disabled = true;
        tgl_masuk.disabled = true;
        tgl_masuk_awal.disabled = true;
        jabatan.disabled = true;
        golongan.disabled = true;
        no_astek.disabled = true;
        no_rbh.disabled = true;
        no_koperasi.disabled = true;
        tgl_agt_kop.disabled = true;
        gaji_pokok.disabled = true;
        u_golongan.disabled = true;
        t_jabatan.disabled = true;
        u_jenjang.disabled = true;
        Tinggi_Badan.disabled = true;
        berat_Badan.disabled = true;
        pendidikan.disabled = true;
        Shift.disabled = true;
        pos.disabled = true;
        TglAwalKontrak.disabled = true;
        TglAkhirKontrak.disabled = true;
        Tanggungan.disabled = true;
        NPWP.disabled = true;
        No_rek.disabled = true;
        NIK.disabled = true;
        isiPegawai.hidden = false;
        koreksiPegawai.hidden = false;
        isiPegawai.hidden = false;
        koreksiPegawai.hidden = false;
        SimpanKoreksiPegawai.hidden = true;
        BatalKoreksiPegawai.hidden = true;
        document.getElementById("HapusButton").disabled = false;
    });
    HapusButton.addEventListener("click", function (event) {
        alert("Hubungi EDP ....");
    });
});
function showModalPosisi() {
    $("#modalPosisi").modal("show");
}
function hideModalPosisi() {
    $("#modalPosisi").modal("hide");
}
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
function showModalShift() {
    $("#modalShift").modal("show");
}
function hideModalShift() {
    $("#modalShift").modal("hide");
}
