$(document).ready(function () {
    const listDataButton = document.getElementById("listDataButton");
    const TambahButton = document.getElementById("TambahButton");
    $("#table_Divisi").DataTable({
        order: [[0, "asc"]],
    });
    $("#table_Klinik").DataTable({
        order: [[0, "asc"]],
    });
    $("#table_ListPegawai").DataTable({
        order: [[0, "asc"]],
        scrollX: true,
        select: {
            style: "single",
            toggleable: false,
        },
    });
    $("#table_Divisi tbody").on("click", "tr", function () {
        // Get the data from the clicked row
        var rowData = $("#table_Divisi").DataTable().row(this).data();
        // Populate the input fields with the data
        $("#Id_Div").val(rowData[0]);
        $("#Nama_Div").val(rowData[1]);

        // var idDivValue = rowData[0];
        // submitFormWithIdDiv(idDivValue);
        // Hide the modal immediately after populating the data
        hideModalDivisi();
    });
    $("#table_ListPegawai tbody").on("click", "tr", function () {
        // Get the data from the clicked row
        var rowData = $("#table_ListPegawai").DataTable().row(this).data();
        var checkBPJS = document.getElementById("checkBPJS");
        var parts = rowData[13].split("/");
        var tglKoperasi = parts[2] + "-" + parts[0] + "-" + parts[1];
        var TglMasukAwal = rowData[6].split(" ");
        var TglMasuk = rowData[7].split(" ");
        var TglLahir = rowData[27].split(" ");
        var selectElement = document.querySelector('select[name="JnsPeg"]');
        // Populate the input fields with the data
        $("#KdPeg").val(rowData[0]);
        selectElement.options[rowData[1]].selected = true;
        $("#NamaPeg").val(rowData[2]);
        $("#NIK").val(rowData[3]);
        $("#Alamat").val(rowData[4]);
        $("#Kota").val(rowData[5]);
        $("#TglMasukAwal").val(TglMasukAwal[0]);
        $("#TglMasuk").val(TglMasuk[0]);
        $("#NomorKartu").val(rowData[8]);
        $("#NomorInduk").val(rowData[9]);
        $("#NomorRBH").val(rowData[10]);
        $("#NomorAstek").val(rowData[11]);
        $("#NomorKoperasi").val(rowData[12]);
        $("#TglKoperasi").val(tglKoperasi);
        $("#NPWP").val(rowData[14]);
        $("#NomorRekening").val(rowData[15]);
        $("#NomorBPJS").val(rowData[16]);

        if (rowData[17] == "1") {
            console.log("masuk if");
            checkBPJS.checked = true;
        } else {
            console.log("masuk else");
            checkBPJS.checked = false;
        }
        $("#NamaIbu").val(rowData[18]);
        $("#IdKlinik").val(rowData[19]);
        $("#NamaKlinik").val(rowData[20]);
        $("#Jabatan").val(rowData[21]);
        $("#NomorPensiun").val(rowData[22]);
        $("#email").val(rowData[23]);
        $("#NomorTelepon").val(rowData[24]);
        $("input[name='vaksin'][value='" + rowData[25] + "']").prop(
            "checked",
            true
        );
        $("#TempatLahir").val(rowData[26]);
        $("#TglLahir").val(TglLahir[0]);
        $("#Kartu").val(rowData[28]);
        $("#NomorRekeningBCA").val(rowData[29]);
        // $("#Jabatan").val(rowData[21]);
        // $("#NomorRekening").val(rowData[15]);
        // $("#NomorRekening").val(rowData[15]);
        // $("#NomorRekening").val(rowData[15]);
        // $("#NomorRekening").val(rowData[15]);
        // var idDivValue = rowData[0];
        // submitFormWithIdDiv(idDivValue);
        // Hide the modal immediately after populating the data
        hideModalDivisi();
    });
    listDataButton.addEventListener("click", function (event) {
        event.preventDefault();
        var Id_Div = document.getElementById("Id_Div").value;
        // if (Id_Div == "") {
        //     Id_Div = null;
        // }
        console.log(Id_Div);
        fetch("/ProgramPayroll/MasterNomer/" + Id_Div + ".getPegawai")
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json(); // Assuming the response is in JSON format
            })
            .then((data) => {
                // Handle the data retrieved from the server (data should be an object or an array)

                // Clear the existing table rows
                $("#table_ListPegawai").DataTable().clear().draw();

                // Loop through the data and create table rows
                data.forEach((item) => {
                    var row = [
                        item.Kd_Pegawai,
                        item.Jenis_Peg,
                        item.Nama_Peg,
                        item.NIK,
                        item.Alamat,
                        item.Kota,
                        item.Tgl_Masuk_Awal,
                        item.Tgl_Masuk,
                        item.No_Kartu,
                        item.No_Induk,
                        item.No_RBH,
                        item.No_Astek,
                        item.No_Koperasi,
                        item.Tgl_Agt_Kop,
                        item.NPWP,
                        item.no_rek,
                        item.IdBPJS,
                        item.Penanggung,
                        item.IbuKandung,
                        item.Kd_Klinik,
                        item.Nama_Klinik,
                        item.Jabatan,
                        item.NoPensiun,
                        item.Email,
                        item.Telpon,
                        item.Vaksin,
                        item.Tmp_Lahir,
                        item.Tgl_Lahir,
                        item.NoKartuMakan,
                        item.RekBCA,
                    ];
                    $("#table_ListPegawai").DataTable().row.add(row);
                });

                // Redraw the table to show the changes
                $("#table_ListPegawai").DataTable().draw();
            })
            .catch((error) => {
                console.error("Error:", error);
            });
    });
    TambahButton.addEventListener("click", function (event) {
        var checkBPJS = document.getElementById("checkBPJS");
        var cvaksin = null;
        var radioButtons = document.getElementsByName("vaksin");

        for (var i = 0; i < radioButtons.length; i++) {
            if (radioButtons[i].checked) {
                if (radioButtons[i].value === "1") {
                    cvaksin = 1;
                } else if (radioButtons[i].value === "2") {
                    cvaksin = 2;
                } else {
                    cvaksin = 0;
                }
                console.log("Updated cvaksin:", cvaksin);
                break; // Exit the loop once a checked radio is found
            }
        }
        const kd_pegawai = document.getElementById("KdPeg").value;
        const nama = document.getElementById("NamaPeg").value;
        const NIK = document.getElementById("NIK").value;
        const alamat = document.getElementById("Alamat").value;
        const kota = document.getElementById("Kota").value;
        const tgl_masuk_awal = document.getElementById("TglMasukAwal").value;
        const tgl_masuk = document.getElementById("TglMasuk").value;
        const no_kartu = document.getElementById("NomorKartu").value;
        const no_induk = document.getElementById("NomorInduk").value;
        const no_rbh = document.getElementById("NomorRBH").value;
        const no_astek = document.getElementById("NomorAstek").value;
        const no_koperasi = document.getElementById("NomorKoperasi").value;
        const tglkop = document.getElementById("TglKoperasi").value;
        const no_npwp = document.getElementById("NPWP").value;
        const no_rek = document.getElementById("NomorRekening").value;
        const no_bpjs = document.getElementById("NomorBPJS").value;
        const nmibu = document.getElementById("NamaIbu").value;
        var tgg = null;
        const idklinik = document.getElementById("IdKlinik").value;
        var cekJnsPeg = document.getElementById("JnsPegs");
        var jnspeg = cekJnsPeg.value;
        const jab = document.getElementById("Jabatan").value;
        const nopen = document.getElementById("NomorPensiun").value;
        const email = document.getElementById("email").value;
        const notelp = document.getElementById("NomorTelepon").value;
        const kotalahir = document.getElementById("TempatLahir").value;
        const tgl_lahir = document.getElementById("TglLahir").value;
        const kartumakan = document.getElementById("Kartu").value;
        const rekBCA = document.getElementById("NomorRekeningBCA").value;
        if (rekBCA == "") {
            alert("Nomor Rekening BCA tidak boleh kosong")
            return;
        }
        if ((checkBPJS.checked == true)) {
            // console.log(checkBPJS.checked);
            tgg = 1;
        } else if ((checkBPJS.checked == false)) {
            // console.log(checkBPJS.checked);
            tgg = 0;
        }
        // return;
        const data = {
            kd_pegawai: kd_pegawai,
            nama: nama,
            NIK: NIK,
            alamat: alamat,
            kota: kota,
            tgl_masuk_awal: tgl_masuk_awal,
            tgl_masuk: tgl_masuk,
            no_kartu: no_kartu,
            no_induk: no_induk,
            no_rbh: no_rbh,
            no_astek: no_astek,
            no_koperasi: no_koperasi,
            tglkop: tglkop,
            no_npwp: no_npwp,
            no_rek: no_rek,
            no_bpjs: no_bpjs,
            nmibu: nmibu,
            tgg: tgg,
            idklinik: idklinik,
            jnspeg: jnspeg,
            jab: jab,
            nopen: nopen,
            email: email,
            notelp: notelp,
            cvaksin: cvaksin,
            kotalahir: kotalahir,
            tgl_lahir: tgl_lahir,
            kartumakan: kartumakan,
            rekBCA: rekBCA,

        };
        console.log(data);

        const formContainer = document.getElementById("form-container");
        const form = document.createElement("form");
        form.setAttribute("action", "MasterNomer/{kd_pegawai}");
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
});

function showModalDivisi() {
    $("#modalDivisi").modal("show");
}
function hideModalDivisi() {
    $("#modalDivisi").modal("hide");
}
