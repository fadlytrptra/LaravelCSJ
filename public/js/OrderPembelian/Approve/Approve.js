$(function () {
    $(".DetailApprove").on("click", function (e) {
        e.preventDefault();
        document.getElementById("judul").innerHTML =
            "No Trans " + $(this).data("id");
        $.ajax({
            url:
                window.location.origin +
                "/Approve/" +
                $(this).data("id") +
                "/show",
            type: "get",
            data: "_token = <?php echo csrf_token() ?>", // Remember that you need to have your csrf token included
            beforeSend: function () {
                // Show loading screen
                $("#loading-screen").css("display", "flex");
            },
            success: function (data) {
                document.getElementById("KategoriUtama").innerHTML =
                    "Kategori Utama: " + data.data.KatUtama;
                document.getElementById("Kategori").innerHTML =
                    "Kategori: " + data.data.kategori;
                document.getElementById("SubKategori").innerHTML =
                    "Sub Kategori: " + data.data.SubKat;
                document.getElementById("NamaBarang").innerHTML =
                    "Nama Barang: " +
                    data.data.NamaBarang.replace(/</g, "&lt;").replace(
                        />/g,
                        "&gt;"
                    ) +
                    "<text class='material-symbols-outlined' style='font-size:20px' id='iconKategoriBarang'>expand_more</text>";
                document.getElementById("Qty").innerHTML =
                    "Qty Order: " + data.data.Qty + " " + data.data.Nama_satuan;
                document.getElementById("Divisi").innerHTML =
                    "Divisi: " + data.data.Kd_div;
                // PEMESAN -------------------------------------------------------------------------
                if (
                    data.data.Pemesan == null ||
                    data.data.Pemesan.length == 0
                ) {
                    $("#Pemesan").hide();
                } else {
                    $("#Pemesan").show();
                    document.getElementById("Pemesan").innerHTML =
                        "Pemesan: " + data.data.Pemesan;
                }

                // USER ------------------------------------------------------------------------------------
                document.getElementById("User").innerHTML =
                    "User: " + data.data.User;

                // STATUS BELI ---------------------------------------------------------------------------------
                if (data.data.StatusBeli.length == 1) {
                    document.getElementById("Status").innerHTML =
                        "Status: Pengadaan Pembelian";
                } else {
                    document.getElementById("Status").innerHTML =
                        "Status: Beli Sendiri";
                }

                // TGL BUTUH -------------------------------------------------------------------------------------
                let date, month, year;
                date = (
                    "0" + new Date(data.data.Tgl_Dibutuhkan).getDate()
                ).slice(-2);
                month = (
                    "0" +
                    (new Date(data.data.Tgl_Dibutuhkan).getMonth() + 1)
                ).slice(-2);
                year = new Date(data.data.Tgl_Dibutuhkan).getFullYear();
                format = month + "/" + date + "/" + year;
                document.getElementById("TglButuh").innerHTML =
                    "Tgl. Dibutuhkan: " + format;

                // KET ORDER -------------------------------------------------------------------------------
                if (
                    !data.data.keterangan ||
                    data.data.keterangan.length === 0
                ) {
                    $("#KetOrder").hide();
                    // document.getElementById("KetOrder").innerHTML="Ket. Order: -";
                } else {
                    $("#KetOrder").show();
                    document.getElementById("KetOrder").innerHTML =
                        "Ket. Order: " + data.data.keterangan;
                }

                // KET INTERNAL --------------------------------------------------------------------------
                if (
                    !data.data.Ket_Internal ||
                    data.data.Ket_Internal.length === 0
                ) {
                    document.getElementById("KetInternal").innerHTML =
                        "Ket. Internal: -";
                } else {
                    document.getElementById("KetInternal").innerHTML =
                        "Ket. Internal: " + data.data.Ket_Internal;
                }

                // PEMBELIAN TERAKHIR -------------------------------------------------------------------------
                $("#PembelianTerakhir").show();
                if (data.dataBeliTerakhir[0] == null) {
                    $("#PembelianTerakhir").hide();
                } else {
                    $("#PembelianTerakhir").show();
                    let date4 = (
                        "0" +
                        new Date(data.dataBeliTerakhir[0].Tgl_order).getDate()
                    ).slice(-2);
                    let month4 = (
                        "0" +
                        (new Date(
                            data.dataBeliTerakhir[0].Tgl_order
                        ).getMonth() +
                            1)
                    ).slice(-2);
                    let year4 = new Date(
                        data.dataBeliTerakhir[0].Tgl_order
                    ).getFullYear();
                    let format4 = month4 + "/" + date4 + "/" + year4;
                    document.getElementById("PembelianTerakhir").innerHTML =
                        "PembelianTerakhir: " +
                        format4 +
                        "<br>Supplier: " +
                        data.dataBeliTerakhir[0].NM_SUP +
                        "<br>Harga Unit: " +
                        rupiah(data.dataBeliTerakhir[0].PriceUnit);
                }
                //   console.log('yay');
            },
            error: function (xhr, status, error) {
                let err = eval("(" + xhr.responseText + ")");
                alert(err.Message);
            },
            complete: function () {
                // Hide loading screen
                $("#loading-screen").css("display", "none");
            },
        });

        let $url = $(this).attr("href");
        $(".formDetail").attr("action", "");
        let action = $(".formDetail").attr("action");
        $(".formDetail").attr("action", action.replace("", "" + $url + ""));

        $("#loading").show();
        $("#DivDetailData").hide();
        $("#modalDetailApprove").modal({ backdrop: "static", keyboard: false });
        $("#modalDetailApprove").modal("show");
        $("body.modal-open").removeAttr("style");
        setTimeout(function () {
            $("#DivDetailData").show();
            $("#loading").hide();
        }, 1000);
    });
});

// Event ESC
document.addEventListener('keydown', function(event) {
  if (event.key === "Escape") {
    var modalEl = document.getElementById('modalDetailApprove');
    var modal = bootstrap.Modal.getInstance(modalEl);
    if (modal) {
      modal.hide();
    }
  }
});

// Event klik di luar modal
document.addEventListener('click', function(event) {
  var modalEl = document.getElementById('modalDetailApprove');
  var modalDialog = modalEl.querySelector('.modal-dialog');

  if (modalEl.classList.contains('show') && !modalDialog.contains(event.target)) {
    var modal = bootstrap.Modal.getInstance(modalEl);
    if (modal) {
      modal.hide();
    }
  }
});
