$(document).ready(function () {
    $(function () {
        $(".DetailCustomer").on("click", function (e) {
            e.preventDefault();
            $("#modalCustomer").modal({ backdrop: "static", keyboard: false });
            document.getElementById("HeadDetailCustomer").innerHTML =
                "Detail Customer.  " + $(this).data("id");
            $.ajax({
                url:
                    window.location.origin +
                    "/Customer/" +
                    $(this).data("id") +
                    "/show",
                type: "get",
                data: "_token = <?php echo csrf_token() ?>", // Remember that you need to have your csrf token included
                beforeSend: function () {
                    // Show loading screen
                    $("#loading-screen").css("display", "flex");
                },
                success: function (data) {
                    document.getElementById("DetailCustomer").innerHTML =
                        "ID Customer: " +
                        data.data.IDCust +
                        "</br>Jenis Customer: " +
                        data.data.JnsCust +
                        " - " +
                        data.data.NamaJnsCust +
                        "</br>Nama Customer: " +
                        data.data.NamaCust +
                        "</br>Initial Customer: " +
                        data.data.KodeCust +
                        "</br>Contact Person: " +
                        data.data.ContactPerson +
                        "</br>Limit Pembelian: " +
                        data.data.LimitPembelian +
                        "</br>Alamat: " +
                        data.data.Alamat +
                        "</br>Kode Pos: " +
                        data.data.KodePos +
                        "</br>Kota: " +
                        data.data.Kota +
                        "</br>Province: " +
                        data.data.Province +
                        "</br>Negara: " +
                        data.data.Negara +
                        "</br>No. Telpon 1: " +
                        data.data.NoTelp1 +
                        "</br>No. Telpon 2: " +
                        data.data.NoTelp2 +
                        "</br>No Telex: " +
                        data.data.NoTelex +
                        "</br>No. Fax 1: " +
                        data.data.NoFax1 +
                        "</br>No. Fax 2: " +
                        data.data.NoFax2 +
                        "</br>Email: " +
                        data.data.Email +
                        "</br>Alamat Kirim: " +
                        data.data.AlamatKirim +
                        "</br>Kota Kirim: " +
                        data.data.KotaKirim +
                        "</br><hr></br>No.NPWP: " +
                        data.data.NPWP +
                        "</br>Nama di NPWP: " +
                        data.data.NamaNPWP +
                        "</br>Alamat di NPWP: " +
                        data.data.AlamatNPWP +
                        "</br><hr></br>Tanggal data diinputkan: " +
                        data.data.TimeInput;
                    // console.log('yay');
                },
                error: function (xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    alert(err.Message);
                },
                complete: function () {
                    // Hide loading screen
                    $("#loading-screen").css("display", "none");
                },
            });
        });
    });

    function OpenWindows(url) {
        window.open(url, "window name", "width=800, height=600");
    }

    // $(function () {
    //   $('.Detail').on('click', function (e) {
    //     e.preventDefault();
    //     $('#modalDetail').modal({ backdrop: 'static', keyboard: false })
    //   });
    // });

    // $('.DetailCustomer').on('click', function(e){
    //     e.preventDefault();
    //     var idcust = $(this).data('id');
    //     $.ajax({
    //         url: "{{ url('Sales/Master/Customer/getDetail') }}/" + idcust,
    //         method: "GET",
    //         dataType: "json",
    //         success: function(data){
    //             $('#NamaCustomer').text(data.NamaCust);
    //         }
    //     });
    //     $('#modalCustomer').modal('show');
    // });

    // $('#modal-customer').on('show.bs.modal', function (e) {
    //     var idcust = $(e.relatedTarget).data('id');
    //     // fetch data based on idcust
    // });

    //#region get element
    var csrfToken = $('meta[name="csrf-token"]').attr("content");

    let JnsCust = document.getElementById("JnsCust");
    let NamaCust = document.getElementById("NamaCust");
    let KodeCust = document.getElementById("KodeCust");
    let ContactPerson = document.getElementById("ContactPerson");
    let LimitBeli = document.getElementById("LimitBeli");
    let Alamat = document.getElementById("Alamat");
    let Kota = document.getElementById("Kota");
    let Province = document.getElementById("Province");
    let Negara = document.getElementById("Negara");
    let KodePos = document.getElementById("KodePos");
    let NoTelp1 = document.getElementById("NoTelp1");
    let NoTelp2 = document.getElementById("NoTelp2");
    let NoTelex = document.getElementById("NoTelex");
    let NoFax1 = document.getElementById("NoFax1");
    let NoFax2 = document.getElementById("NoFax2");
    let NoHp1 = document.getElementById("NoHp1");
    let NoHp2 = document.getElementById("NoHp2");
    let Email = document.getElementById("Email");
    let AlamatKirim = document.getElementById("AlamatKirim");
    let KotaKirim = document.getElementById("KotaKirim");
    let NPWP = document.getElementById("NPWP");
    let NamaNPWP = document.getElementById("NamaNPWP");
    let AlamatNPWP = document.getElementById("AlamatNPWP");
    let NITKU = document.getElementById("NITKU");
    let FormCustomer = document.getElementById("FormCustomer");
    let modalCustomer = document.getElementById("modalCustomer");
    let modalLabelCustomer = document.getElementById("modalLabelCustomer");
    let typeKegiatanForm = document.getElementById("typeKegiatanForm");
    let submit_btn = document.getElementById("submit_btn");
    let customerSales = $("#table_Customer").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "Customer/getallcustomer",
            dataType: "json",
            type: "GET",
            data: {
                _token: csrfToken,
            },
        },
        columns: [
            { data: "IDCustomer" },
            { data: "NamaCustomer" },
            { data: "KotaKirim" },
            { data: "Negara" },
            {
                data: "Actions",
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `
                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalCustomer"
                            data-typeForm="edit" data-idcustomer="${row.IDCustomer}">&#x270E; Edit</button>
                        <br>
                        <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="/Customer/${row.IDCustomer}" method="POST" enctype="multipart/form-data">
                            <button type="submit" class="btn btn-sm btn-danger"><span>&#x1F5D1;</span> Hapus</button>
                            <input type="hidden" name="_token" value="${csrfToken}">
                        </form>
                    `;
                },
            },
        ],
        initComplete: function () {
            let api = this.api();

            // Hapus pencarian global di input default DataTables
            $("#table_Customer_filter input")
                .off()
                .on("input", function () {
                    let value = this.value;
                    api.columns().search(""); // Reset semua pencarian kolom
                    api.column(1).search(value); // Cari berdasarkan NamaCustomer
                    api.draw();
                });
        },
    });
    // $("#table_Customer_filter input").on("keyup", function () {
    //     table
    //         .columns(0) // Kolom kedua (Kode_KodePerkiraan)
    //         .search(this.value) // Cari berdasarkan input pencarian
    //         .draw(); // Perbarui hasil pencarian
    // });
    let idCustomer;
    let button;
    let bankData;
    let typeform;
    let form;

    //#endregion

    modalCustomer.addEventListener("shown.bs.modal", function (event) {
        button = $(event.relatedTarget); // Button that triggered the modal
        bankData = button.data();
        typeform = button.data("typeform");
        idCustomer = button.data("idcustomer");
        typeKegiatanForm.value = typeform;
        console.log(bankData);
        form = $("#FormCustomer");

        if (typeform == "edit") {
            //setting up modal supaya bisa koreksi barang
            modalLabelCustomer.innerHTML = "Edit Customer";
            form.attr("action", "/Customer/" + idCustomer + "/edit");
            form.attr("method", "GET");
            // idBank.readOnly = true;
            // isiNamaBank.style.display = "block";
            // isiNamaBank.focus();
            // prosesButtonModal.disabled = true;
            console.log(idCustomer);

            $.ajax({
                //Get data bank menurut ID
                url: "/Customer/getCertainCustomer",
                method: "GET",
                data: {
                    idCustomer: idCustomer,
                },
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
                beforeSend: function () {
                    // Show loading screen
                    $("#loading-screen").css("display", "flex");
                },
                success: function (response) {
                    console.log(response.data);
                    JnsCust.value = response.data.IDJnsCust;
                    NamaCust.value = response.data.NamaCust;
                    KodeCust.value = response.data.KodeCust;
                    ContactPerson.value = response.data.ContactPerson;
                    LimitBeli.value = response.data.LimitBeli;
                    Alamat.value = response.data.Alamat;
                    Kota.value = response.data.Kota;
                    Province.value = response.data.Propinsi;
                    Negara.value = response.data.Negara;
                    KodePos.value = response.data.KodePos;
                    NoTelp1.value = response.data.NoTelp1;
                    NoTelp2.value = response.data.NoTelp2;
                    NoTelex.value = response.data.NoTelex;
                    NoFax1.value = response.data.NoFax1;
                    NoFax2.value = response.data.NoFax2;
                    NoHp1.value = response.data.NoHp1;
                    NoHp2.value = response.data.NoHp2;
                    Email.value = response.data.Email;
                    AlamatKirim.value = response.data.AlamatKirim;
                    NPWP.value = response.data.NPWP;
                    AlamatNPWP.value = response.data.AlamatNPWP;
                    NamaNPWP.value = response.data.NamaNPWP;
                    KotaKirim.value = response.data.KotaKirim;
                    NITKU.value = response.data.NITKU;
                },
                error: function (error) {
                    Swal.fire({
                        icon: "error",
                        title: "Data Tidak Berhasil Diload!",
                    });
                    console.error("Error saving data:", error);
                },
                complete: function () {
                    // Hide loading screen
                    $("#loading-screen").css("display", "none");
                },
            });
        } else if (typeform == "tambah") {
            modalLabelCustomer.innerHTML = "Tambah Customer";
            $("#modalCustomer").find("input, textarea, select").val("");
            // form.attr("action", "/MaintenanceBank/");
            // form.attr("method", "POST");
        }
    });

    function showWarningAndFocus(element, message) {
        Swal.fire({
            icon: "warning",
            title: "Warning!",
            text: message,
            returnFocus: false,
        }).then(() => {
            element.focus();
        });
        return false; // Prevent further execution
    }

    submit_btn.addEventListener("click", function (event) {
        event.preventDefault();

        if (NamaCust.value.trim() === "") {
            return showWarningAndFocus(NamaCust, "Isi Nama Customer dahulu!");
        }

        if (KodeCust.value.trim() === "") {
            return showWarningAndFocus(
                KodeCust,
                "Isi Initial Customer dahulu!"
            );
        }
        if (typeform == "edit") {
            $.ajax({
                url: "/Customer/" + idCustomer,
                type: "PUT",
                data: {
                    _token: csrfToken,
                    JnsCust: JnsCust.value,
                    NamaCust: NamaCust.value,
                    KodeCust: KodeCust.value,
                    ContactPerson: ContactPerson.value,
                    LimitBeli: LimitBeli.value,
                    Alamat: Alamat.value,
                    Kota: Kota.value,
                    Province: Province.value,
                    Negara: Negara.value,
                    KodePos: KodePos.value,
                    NoTelp1: NoTelp1.value,
                    NoTelp2: NoTelp2.value,
                    NoTelex: NoTelex.value,
                    NoFax1: NoFax1.value,
                    NoFax2: NoFax2.value,
                    NoHp1: NoHp1.value,
                    NoHp2: NoHp2.value,
                    Email: Email.value,
                    AlamatKirim: AlamatKirim.value,
                    NPWP: NPWP.value,
                    AlamatNPWP: AlamatNPWP.value,
                    NamaNPWP: NamaNPWP.value,
                    KotaKirim: KotaKirim.value,
                    NITKU: NITKU.value,
                },
                beforeSend: function () {
                    // Show loading screen
                    $("#loading-screen").css("display", "flex");
                },
                success: function (data) {
                    console.log(data);
                    Swal.fire({
                        icon: "success",
                        title: "Data Berhasil Diload!",
                    }).then((result) => {
                        $("#modalCustomer").modal("hide");
                        customerSales.ajax.reload();
                    });
                },
                error: function (xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    alert(err.Message);
                },
                complete: function () {
                    // Hide loading screen
                    $("#loading-screen").css("display", "none");
                },
            });
        } else if (typeform == "tambah") {
            $.ajax({
                url: "/Customer",
                type: "POST",
                data: {
                    _token: csrfToken,
                    JnsCust: JnsCust.value,
                    NamaCust: NamaCust.value,
                    KodeCust: KodeCust.value,
                    ContactPerson: ContactPerson.value,
                    LimitBeli: LimitBeli.value,
                    Alamat: Alamat.value,
                    Kota: Kota.value,
                    Province: Province.value,
                    Negara: Negara.value,
                    KodePos: KodePos.value,
                    NoTelp1: NoTelp1.value,
                    NoTelp2: NoTelp2.value,
                    NoTelex: NoTelex.value,
                    NoFax1: NoFax1.value,
                    NoFax2: NoFax2.value,
                    NoHp1: NoHp1.value,
                    NoHp2: NoHp2.value,
                    Email: Email.value,
                    AlamatKirim: AlamatKirim.value,
                    NPWP: NPWP.value,
                    AlamatNPWP: AlamatNPWP.value,
                    NamaNPWP: NamaNPWP.value,
                    KotaKirim: KotaKirim.value,
                    NITKU: NITKU.value,
                },
                beforeSend: function () {
                    // Show loading screen
                    $("#loading-screen").css("display", "flex");
                },
                success: function (data) {
                    console.log(data);
                    if (data.success) {
                        Swal.fire({
                            icon: "success",
                            title: "Data Berhasil Diload!",
                        }).then((result) => {
                            $("#modalCustomer").modal("hide");
                            customerSales.ajax.reload();
                        });
                    } else {
                        showWarningAndFocus(NamaCust, data.error);
                    }
                },
                error: function (xhr, status, error) {
                    showWarningAndFocus(NamaCust, xhr.responseJSON.error);
                },
                complete: function () {
                    // Hide loading screen
                    $("#loading-screen").css("display", "none");
                },
            });
            // form.attr("action", "/MaintenanceBank/");
            // form.attr("method", "POST");
        }
    });

    //#region enter-enter

    JnsCust.focus();

    JnsCust.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
            NamaCust.focus();
        }
    });
    NamaCust.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
            KodeCust.focus();
        }
    });
    KodeCust.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
            ContactPerson.focus();
        }
    });
    ContactPerson.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
            LimitBeli.focus();
        }
    });
    LimitBeli.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
            Alamat.focus();
        }
    });
    Alamat.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
            Kota.focus();
        }
    });
    Kota.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
            Province.focus();
        }
    });
    Province.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
            Negara.focus();
        }
    });
    Negara.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
            KodePos.focus();
        }
    });
    KodePos.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
            NoTelp1.focus();
        }
    });
    NoTelp1.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
            NoTelp2.focus();
        }
    });
    NoTelp2.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
            NoTelex.focus();
        }
    });
    NoTelex.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
            NoFax1.focus();
        }
    });
    NoFax1.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
            NoFax2.focus();
        }
    });
    NoFax2.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
            NoHp1.focus();
        }
    });
    NoHp1.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
            NoHp2.focus();
        }
    });
    NoHp2.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
            Email.focus();
        }
    });
    Email.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
            AlamatKirim.focus();
        }
    });
    AlamatKirim.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
            KotaKirim.focus();
        }
    });
    KotaKirim.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
            NPWP.focus();
        }
    });
    NPWP.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
            NamaNPWP.focus();
        }
    });
    NamaNPWP.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
            AlamatNPWP.focus();
        }
    });
    //#endregion

    //#region input filter
    //Penjelasan setinputfilter function: https://jsfiddle.net/KarmaProd/tgn9d1uL/4/
    function setInputFilter(textbox, inputFilter, errMsg) {
        [
            "input",
            "keydown",
            "keyup",
            "mousedown",
            "mouseup",
            "select",
            "contextmenu",
            "drop",
            "focusout",
        ].forEach(function (event) {
            textbox.addEventListener(event, function (e) {
                if (inputFilter(this.value)) {
                    // Accepted value
                    if (
                        ["keydown", "mousedown", "focusout"].indexOf(e.type) >=
                        0
                    ) {
                        this.classList.remove("input-error");
                        this.setCustomValidity("");
                    }
                    this.oldValue = this.value;
                    this.oldSelectionStart = this.selectionStart;
                    this.oldSelectionEnd = this.selectionEnd;
                } else if (this.hasOwnProperty("oldValue")) {
                    // Rejected value - restore the previous one
                    this.classList.add("input-error");
                    this.setCustomValidity(errMsg);
                    this.reportValidity();
                    this.value = this.oldValue;
                    this.setSelectionRange(
                        this.oldSelectionStart,
                        this.oldSelectionEnd
                    );
                } else {
                    // Rejected value - nothing to restore
                    this.value = "";
                }
            });
        });
    }

    setInputFilter(
        document.getElementById("LimitBeli"),
        function (value) {
            return /^-?\d*$/.test(value);
        },
        "Harus diisi dengan angka!"
    );
    setInputFilter(
        document.getElementById("KodePos"),
        function (value) {
            return /^-?\d*$/.test(value);
        },
        "Harus diisi dengan angka!"
    );
    setInputFilter(
        document.getElementById("NoTelp1"),
        function (value) {
            return /^-?\d*$/.test(value);
        },
        "Harus diisi dengan angka!"
    );
    setInputFilter(
        document.getElementById("NoTelp2"),
        function (value) {
            return /^-?\d*$/.test(value);
        },
        "Harus diisi dengan angka!"
    );
    setInputFilter(
        document.getElementById("NoTelex"),
        function (value) {
            return /^-?\d*$/.test(value);
        },
        "Harus diisi dengan angka!"
    );
    setInputFilter(
        document.getElementById("NoFax1"),
        function (value) {
            return /^-?\d*$/.test(value);
        },
        "Harus diisi dengan angka!"
    );
    setInputFilter(
        document.getElementById("NoFax2"),
        function (value) {
            return /^-?\d*$/.test(value);
        },
        "Harus diisi dengan angka!"
    );
    setInputFilter(
        document.getElementById("NoHp1"),
        function (value) {
            return /^-?\d*$/.test(value);
        },
        "Harus diisi dengan angka!"
    );
    setInputFilter(
        document.getElementById("NoHp2"),
        function (value) {
            return /^-?\d*$/.test(value);
        },
        "Harus diisi dengan angka!"
    );
    setInputFilter(
        document.getElementById("NPWP"),
        function (value) {
            return /^-?\d*$/.test(value);
        },
        "Harus diisi dengan angka!"
    );

    //#endregion
});
