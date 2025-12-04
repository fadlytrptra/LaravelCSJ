$(document).ready(function () {
    let csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
    //#region get element by id
    let jenis_pasca = $('input[name="jenis_pasca"]:checked').val();
    let jenis_pascaPengembalian = document.getElementById(
        "jenis_pascaPengembalian"
    );
    let jenis_pascaKurangLebih = document.getElementById(
        "jenis_pascaKurangLebih"
    );
    let customer = document.getElementById("customer");
    let surat_pesanan = document.getElementById("surat_pesanan");
    let surat_jalan = document.getElementById("surat_jalan");
    let barang_pesanan = document.getElementById("barang_pesanan");
    let qty_primerPengiriman = document.getElementById("qty_primerPengiriman");
    let qty_sekunderPengiriman = document.getElementById(
        "qty_sekunderPengiriman"
    );
    let qty_tritierPengiriman = document.getElementById(
        "qty_tritierPengiriman"
    );
    let qty_konversiPengiriman = document.getElementById(
        "qty_konversiPengiriman"
    );
    let qty_primerRetur = document.getElementById("qty_sekunderRetur");
    let qty_sekunderRetur = document.getElementById("qty_sekunderRetur");
    let qty_tritierRetur = document.getElementById("qty_tritierRetur");
    let qty_konversiRetur = document.getElementById("qty_konversiRetur");
    let tanggal_diterima = document.getElementById("tanggal_diterima");
    let bttb = document.getElementById("bttb");
    let qty_primerDiterimaCustomer = document.getElementById(
        "qty_primerDiterimaCustomer"
    );
    let qty_sekunderDiterimaCustomer = document.getElementById(
        "qty_sekunderDiterimaCustomer"
    );
    let qty_tritierDiterimaCustomer = document.getElementById(
        "qty_tritierDiterimaCustomer"
    );
    let qty_konversiDiterimaCustomer = document.getElementById(
        "qty_konversiDiterimaCustomer"
    );
    let penerima = document.getElementById("penerima");
    let alasan_kembali = document.getElementById("alasan_kembali");
    let submit_button = document.getElementById("submit_button");

    //#endregion

    //#region load form

    jenis_pascaPengembalian.focus();
    tanggal_diterima.valueAsDate = new Date();

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
        document.getElementById("qty_sekunderRetur"),
        function (value) {
            return /^-?\d*$/.test(value);
        },
        "Harus diisi dengan angka!"
    );
    setInputFilter(
        document.getElementById("qty_tritierRetur"),
        function (value) {
            return /^-?\d*$/.test(value);
        },
        "Harus diisi dengan angka!"
    );
    setInputFilter(
        document.getElementById("qty_konversiRetur"),
        function (value) {
            return /^-?\d*$/.test(value);
        },
        "Harus diisi dengan angka!"
    );
    setInputFilter(
        document.getElementById("qty_primerDiterimaCustomer"),
        function (value) {
            return /^-?\d*[.]?\d*$/.test(value);
        },
        "Must be a floating (real) number"
    );
    setInputFilter(
        document.getElementById("qty_sekunderDiterimaCustomer"),
        function (value) {
            return /^-?\d*[.]?\d*$/.test(value);
        },
        "Must be a floating (real) number"
    );
    setInputFilter(
        document.getElementById("qty_tritierDiterimaCustomer"),
        function (value) {
            return /^-?\d*[.]?\d*$/.test(value);
        },
        "Must be a floating (real) number"
    );
    setInputFilter(
        document.getElementById("qty_konversiDiterimaCustomer"),
        function (value) {
            return /^-?\d*[.]?\d*$/.test(value);
        },
        "Must be a floating (real) number"
    );

    //#endregion

    //#region Input Select Change

    customer.addEventListener("change", function () {
        let customer = this.value;
        surat_pesanan.focus();
        fetch("/options/pascakirimsp/" + customer)
            .then((response) => response.json())
            .then((options) => {
                surat_pesanan.innerHTML =
                    "<option disabled selected>-- Pilih Surat Pesanan --</option>";
                options.forEach((option) => {
                    let optionTag = document.createElement("option");
                    optionTag.value = option.IDSuratPesanan;
                    optionTag.text =
                        option.IDSuratPesanan + " | " + option.IDPengiriman;
                    surat_pesanan.appendChild(optionTag);
                });
            });
    });
    surat_pesanan.addEventListener("change", function () {
        // console.log(surat_pesanan.options[surat_pesanan.selectedIndex].text);
        let nomorSurat =
            surat_pesanan.options[surat_pesanan.selectedIndex].text.split(
                " | "
            );
        surat_jalan.value = nomorSurat[1];
        let suratPesanan = nomorSurat[0];
        if (suratPesanan.includes("/")) {
            suratPesanan = suratPesanan.replace(/\//g, ".");
        }
        barang_pesanan.focus();
        fetch(
            "/options/barangpesanan/" + suratPesanan + "/" + surat_jalan.value
        )
            .then((response) => response.json())
            .then((options) => {
                // console.log(options);
                barang_pesanan.innerHTML =
                    "<option disabled selected>-- Pilih Barang --</option>";
                options.forEach((option) => {
                    let optionTag = document.createElement("option");
                    optionTag.value =
                        option.IDHeaderKirim + " | " + option.IDDetailKirim;
                    optionTag.text = option.NamaType;
                    barang_pesanan.appendChild(optionTag);
                });
            });
    });
    barang_pesanan.addEventListener("change", function () {
        // console.log(this.value);
        let kodeBarang = this.value.split("| ");
        // console.log(kodeBarang[1]);
        bttb.focus();
        fetch("/options/returkirim/" + kodeBarang[1])
            .then((response) => response.json())
            .then((data) => {
                // console.log(data);
                qty_primerPengiriman.value =
                    parseFloat(data.kirim[0].JmlTerimaPrimer) +
                    " " +
                    data.kirim[0].satPrimer;
                qty_sekunderPengiriman.value =
                    parseFloat(data.kirim[0].JmlTerimaSekunder) +
                    " " +
                    data.kirim[0].satSekunder;
                qty_tritierPengiriman.value =
                    parseFloat(data.kirim[0].JmlTerimaTritier) +
                    " " +
                    data.kirim[0].SatTritier;

                let satPrimer = data.kirim[0].satPrimer;
                let satSekunder = data.kirim[0].satSekunder;
                let SatTritier = data.kirim[0].SatTritier;
                let Satuan = data.kirim[0].Satuan;
                if (
                    satPrimer != Satuan &&
                    satSekunder != Satuan &&
                    SatTritier != Satuan
                ) {
                    // console.log('hehe');
                    qty_konversiPengiriman.value =
                        parseFloat(data.kirim[0].JmlTerimaUmum) +
                        " " +
                        data.kirim[0].Satuan;
                    qty_konversiDiterimaCustomer.setAttribute(
                        "disabled",
                        false
                    );
                }
                // console.log('hoho');
                qty_primerRetur.value = data.retur[0].QtyPrimer;
                qty_sekunderRetur.value = data.retur[0].QtySekunder;
                qty_tritierRetur.value = data.retur[0].QtyTritier;
                qty_konversiRetur.value = data.retur[0].QTyKonversi;
            });
    });
    //#endregion

    //#region enter-enter

    jenis_pascaPengembalian.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
            customer.focus();
        }
    });

    jenis_pascaKurangLebih.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
            customer.focus();
        }
    });

    tanggal_diterima.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
            bttb.focus();
        }
    });

    bttb.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
            qty_primerDiterimaCustomer.value = "";
            qty_primerDiterimaCustomer.focus();
        }
    });

    qty_primerDiterimaCustomer.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
            qty_sekunderDiterimaCustomer.value = "";
            qty_sekunderDiterimaCustomer.focus();
        }
    });

    qty_sekunderDiterimaCustomer.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
            qty_tritierDiterimaCustomer.value = "";
            qty_tritierDiterimaCustomer.focus();
        }
    });

    qty_tritierDiterimaCustomer.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
            if (qty_konversiDiterimaCustomer.disabled) {
                penerima.focus();
            } else {
                qty_konversiDiterimaCustomer.value = "";
                qty_konversiDiterimaCustomer.focus();
            }
        }
    });

    qty_konversiDiterimaCustomer.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
            penerima.focus();
        }
    });

    penerima.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
            if (jenis_pascaPengembalian.checked == true) {
                alasan_kembali.focus();
            } else {
                submit_button.focus();
            }
        }
    });

    alasan_kembali.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
            submit_button.focus();
        }
    });
    //#endregion

    submit_button.addEventListener("click", function (event) {
        event.preventDefault();
        if (
            jenis_pascaPengembalian.checked == true &&
            alasan_kembali.value == ""
        ) {
            alert(
                "Jenis pasca kirim pengembalian harus mengisi alasan kembali"
            );
            alasan_kembali.focus();
        } else if (
            qty_primerPengiriman.value == 0 &&
            qty_sekunderPengiriman.value == 0 &&
            qty_tritierPengiriman.value == 0
        ) {
            alert("Tidak Bisa Melakukan Pasca Kirim, karena saldo sudah Nol");
        } else if (qty_primerDiterimaCustomer.value < 0) {
            alert("JmlTerimaPrimer Lebih Kecil Dari 0");
            qty_primerDiterimaCustomer.focus();
        } else if (qty_sekunderDiterimaCustomer.value < 0) {
            alert("JmlTerimaSekunder Lebih Kecil Dari 0");
            qty_sekunderDiterimaCustomer.focus();
        } else if (qty_tritierDiterimaCustomer.value < 0) {
            alert("JmlTerimaTritier Lebih Kecil Dari 0");
            qty_tritierDiterimaCustomer.focus();
        } else if (qty_konversiDiterimaCustomer.value < 0) {
            alert("JmlTerimaKonversi Lebih Kecil Dari 0");
            qty_konversiDiterimaCustomer.focus();
        } else if (barang_pesanan.selectedIndex == 0) {
            alert("Pilih item barang terlebih dahulu");
            barang_pesanan.focus();
        } else {
            // console.log("Semua kondisi telah terpenuhi, mengirim data...");

            // all conditions have been met, submit the form
            // document.getElementById("form_pascaKirim").submit();
            // console.log(surat_pesanan);
            $.ajax({
                url: "PascaKirim",
                type: "POST",
                data: {
                    _token: csrfToken,
                    jenis_pasca: jenis_pasca,
                    customer: customer.value,
                    surat_pesanan: surat_pesanan.value,
                    surat_jalan: surat_jalan.value,
                    barang_pesanan: barang_pesanan.value,
                    barang_pesananArray: barang_pesanan.value,
                    tanggal_diterima: tanggal_diterima.value,
                    bttb: bttb.value,
                    qty_konversiDiterimaCustomer:
                        qty_konversiDiterimaCustomer.value,
                    qty_primerDiterimaCustomer:
                        qty_primerDiterimaCustomer.value,
                    qty_sekunderDiterimaCustomer:
                        qty_sekunderDiterimaCustomer.value,
                    qty_tritierDiterimaCustomer:
                        qty_tritierDiterimaCustomer.value,
                    penerima: penerima.value,
                    alasan_kembali: alasan_kembali.value,
                },
                success: function (response) {
                    console.log(response);

                    if (response.message) {
                        Swal.fire({
                            icon: "success",
                            title: "Success!",
                            text: response.message,
                            showConfirmButton: true,
                        }).then(() => {
                            location.reload();
                            // document
                            //     .querySelectorAll("input")
                            //     .forEach((input) => (input.value = ""));
                            // $("#table_atas").DataTable().ajax.reload();
                            // idReferensi.value = response.IdReferensi;
                            // btn_proses.disabled = true;
                            // btn_batal.disabled = true;
                            // btn_isi.disabled = false;
                            // btn_koreksi.disabled = false;
                            // btn_hapus.disabled = false;
                            // btn_ok.click();
                        });
                    } else if (response.error) {
                        Swal.fire({
                            icon: "info",
                            title: "Info!",
                            text: response.error,
                            showConfirmButton: false,
                        });
                    }
                },
                error: function (xhr) {
                    alert(xhr.responseJSON.message);
                },
            });
        }
    });
});
