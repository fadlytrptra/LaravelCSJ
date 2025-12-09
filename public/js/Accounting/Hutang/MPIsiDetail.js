let idDivisi = document.getElementById("idDivisi");
let namaDivisi = document.getElementById("namaDivisi");
let noPO = document.getElementById("noPO");
let tabelPO = document.getElementById("tabelPO");
//let tabelPO = $("#tabelPO").DataTable();


noPO.addEventListener("change", function() {
    if (this.selectedIndex !== 0) {
        this.classList.add("input-error");
        this.setCustomValidity("Tekan Enter!");
        this.reportValidity();
    }
})

noPO.addEventListener("keypress", function (event) {
    if (event.key == "Enter") {
        event.preventDefault();
        fetch("/detailtabelpo/" + noPO.value)
            .then((response) => response.json())
            .then((options) => {
                console.log(options);
                $("#tabelPO").DataTable({
                    data: options,
                    columns: [

                        {
                            title: "Divisi",
                            data: "Kd_div",
                            render: function (data) {
                                // The custom rendering function
                                return `<input type="checkbox" name="divisiCheckbox" value="${data}" /> ${data}`;
                            },
                        },
                        { title: "No. SJ", data: "No_SuratJalan" },
                        { title: "No. BTTB", data: "No_BTTB" },
                        { title: "Spesifikasi", data: "Primer" },
                        { title: "Qty", data: "Qty_Terima" },
                        { title: "Satuan", data: "Nama_satuan" },
                        { title: "MataUang", data: "Nama_MataUang" },
                        { title: "Hrg. Satuan", data: "IdTransaksi" },
                        { title: "Total Harga", data: "Hrg_idr_tot_bttb" },
                        { title: "Kurs", data: "Kurs_Rp" },
                        { title: "Hrg. Disc", data: "hrg_disc" },
                        { title: "Hrg. PPN", data: "hrg_ppn" },
                        { title: "Hrg. Terbayar", data: "Harga_Terbayar" },
                        { title: "Hrg. TerbayarRp", data: "Harga_Terbayar" },
                        { title: "Tgl. Datang", data: "Tritier" },
                        { title: "Tgl. Faktur", data: "Tgl_Faktur" },
                        { title: "Disc", data: "Disc_trm" },
                        { title: "PPN", data: "hrg_ppn" },
                        { title: "Lunas", data: "Tritier" },
                        { title: "No. Terima", data: "No_terima" },
                    ],
                });

            });
    }
});

idDivisi.addEventListener("change", function () {
    if (this.selectedIndex !== 0) {
        this.classList.add("input-error");
        this.setCustomValidity("Tekan Enter!");
        this.reportValidity();
    }
});

idDivisi.addEventListener("keypress", function (event) {
    if (event.key == "Enter") {
        event.preventDefault();
        let text = idDivisi.options[idDivisi.selectedIndex].text.split("|");
        namaDivisi.value = text[1];
        // fetch("/detaildivisi/" + idDivisi.value)
        //     .then((response) => response.json())
        //     .then((options) => {
        //         console.log(options);
        //         let text = namaDivisi.options[namaDivisi.selectedIndex].text.split("|");
        //         namaDivisi.value = text[1];
        //     });
    }
});
