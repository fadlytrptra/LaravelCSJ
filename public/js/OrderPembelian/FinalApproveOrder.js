$(function () {
    $('.DetailFinal').on('click', function (e) {
      e.preventDefault();
      document.getElementById("judulFinal").innerHTML="No Trans "+$(this).data('id');
      $.ajax({
          url: window.location.origin+"/FinalApproveOrderPembelian/"+$(this).data('id')+"/show",
          type: 'get',
          data: '_token = <?php echo csrf_token() ?>', // Remember that you need to have your csrf token included
          beforeSend: function () {
            // Show loading screen
            $("#loading-screen").css("display", "flex");
        },
          success: function( data ){

            document.getElementById("KategoriUtamaFinal").innerHTML="Kategori Utama: "+data.data.KatUtama;
            document.getElementById("KategoriFinal").innerHTML="Kategori: "+data.data.kategori;
            document.getElementById("SubKategoriFinal").innerHTML="Sub Kategori: "+data.data.SubKat;
            document.getElementById("NamaBarangFinal").innerHTML="Nama Barang: "+data.data.NamaBarang+"<text class='material-symbols-outlined' style='font-size:20px' id='iconKategoriBarang'>expand_more</text>";
            document.getElementById("QtyFinal").innerHTML="Qty Order: "+data.data.Qty+" "+data.data.Nama_satuan;
            document.getElementById("DivisiFinal").innerHTML="Divisi: "+data.data.Kd_div;
            // PEMESAN-------------------------------------------------------------------------------------
            if(data.data.Pemesan==null||data.data.Pemesan.length==0)
            {
              $("#PemesanFinal").hide();
            }
            else
            {
              $("#PemesanFinal").show();
              document.getElementById("PemesanFinal").innerHTML="Pemesan: "+data.data.Pemesan;
            }
            // USER----------------------------------------------------------------------------------------------
            document.getElementById("UserFinal").innerHTML="User: "+data.data.User;
            // STATUS BELI--------------------------------------------------------------------------------------------
            if(data.data.StatusBeli==1)
            {
              document.getElementById("StatusFinal").innerHTML="Status: Pengadaan Pembelian";
            }
            else
            {
              document.getElementById("StatusFinal").innerHTML="Status: Beli Sendiri";
            }
            // TGL BUTUH -------------------------------------------------------------------------------------------
            let date= ("0" + new Date(data.data.Tgl_Dibutuhkan).getDate()).slice(-2);
            let month = ("0" + (new Date(data.data.Tgl_Dibutuhkan).getMonth()+1)).slice(-2);
            let year = new Date(data.data.Tgl_Dibutuhkan).getFullYear();
            document.getElementById("TglButuhFinal").innerHTML="Tgl. Dibutuhkan: "+month+"/"+date+"/"+year;
            // KET ORDER-------------------------------------------------------------------------------------------------
            if(data.data.keterangan=='-'||data.data.keterangan==null||data.data.keterangan.length==0)
            {
              $("#KetOrderFinal").hide();
            }
            else
            {
              $("#KetOrderFinal").show();
              document.getElementById("KetOrderFinal").innerHTML="Ket. Order: "+data.data.keterangan;
            }
            // KET INTERNAL ------------------------------------------------------------------------------------------------
            if(data.data.Ket_Internal=='-'||data.data.Ket_Internal==null||data.data.Ket_Internal.length==0)
            {
              $("#KetInternalFinal").hide();
            }
            else
            {
              $("#KetInternalFinal").show()
              document.getElementById("KetInternalFinal").innerHTML="Ket. Internal: "+data.data.Ket_Internal;
            }
            // SUPPLIER ------------------------------------------------------------------------------------------
            if(data.data.supplier==null||data.data.supplier.length==0)
            {
              $("#Kota").hide();
              $("#Supplier").hide();
            }
            else
            {
              $("#Kota").show();
              $("#Supplier").show();
              document.getElementById("Supplier").innerHTML="Supplier: "+data.data.supplier +"<text class='material-symbols-outlined' style='font-size:20px' id='iconSupplier'>expand_more</text>";
              document.getElementById("Kota").innerHTML="Kota/Negara: "+data.data.kota+"/"+data.data.negara;
            }
            // HARGA ----------------------------------------------------------------------------------------
            if(data.data.Currency=='1')
            {
              document.getElementById("Harga").innerHTML="Harga: "+rupiah(data.data.PriceUnit);
              document.getElementById("Subtotal").innerHTML="Subtotal: "+rupiah(data.data.PriceSub);
              document.getElementById("PPN").innerHTML="PPN: "+rupiah(data.data.PPN);
              document.getElementById("Total").innerHTML="Total: "+rupiah(data.data.PriceExt)+"<text class='material-symbols-outlined' style='font-size:20px' id='iconHarga'>expand_more</text>";
            }
            else if(data.data.Currency=='2')
            {
              document.getElementById("Harga").innerHTML="Harga: "+dolar(data.data.PriceUnit);
              document.getElementById("Subtotal").innerHTML="Subtotal: "+dolar(data.data.PriceSub);
              document.getElementById("Total").innerHTML="Total: "+dolar(data.data.PriceExt);
            }
            // ACC MANAGER------------------------------------------------------------------------------------------
            let date2 = ("0" + new Date(data.data.Tgl_acc).getDate()).slice(-2);
            let month2 = ("0" + (new Date(data.data.Tgl_acc).getMonth()+1)).slice(-2);
            let year2 = new Date(data.data.Tgl_acc).getFullYear();
            let hour2 = ("0" + new Date(data.data.Tgl_acc).getHours()).slice(-2);
            let minute2 = ("0" + new Date(data.data.Tgl_acc).getMinutes()).slice(-2);
            let second2 = ("0" + new Date(data.data.Tgl_acc).getSeconds()).slice(-2);
            let format2=month2+"/"+date2+"/"+year2+" "+hour2+":"+minute2+":"+second2;
            document.getElementById("AccManager").innerHTML="Approved: "+format2+" BY:"+ data.data.Manager;

            // ACC MANAGER-------------------------------------------------------------------------------------
            let date3 = ("0" + new Date(data.data.Tgl_PBL_Acc).getDate()).slice(-2);
            let month3 = ("0" + (new Date(data.data.Tgl_PBL_Acc).getMonth()+1)).slice(-2);
            let year3 = new Date(data.data.Tgl_PBL_Acc).getFullYear();
            let hour3 = ("0" + new Date(data.data.Tgl_PBL_Acc).getHours()).slice(-2);
            let minute3 = ("0" + new Date(data.data.Tgl_PBL_Acc).getMinutes()).slice(-2);
            let second3 = ("0" + new Date(data.data.Tgl_PBL_Acc).getSeconds()).slice(-2);
            let format3=month3+"/"+date3+"/"+year3+" "+hour3+":"+minute3+":"+second3;
            document.getElementById("Offered").innerHTML="Offered: "+format3+" BY:"+data.data.Offered;

            // PEMBELIAN TERAKHIR -------------------------------------------------------------------------
            if(data.dataBeliTerakhir[0]==null)
            {
              $("#PembelianTerakhirFinal").hide();
              $("#History").hide();
            }
            else
            {
              $("#History").show();
              $("#PembelianTerakhirFinal").show();
              let date4= ("0" + new Date(data.dataBeliTerakhir[0].Tgl_order).getDate()).slice(-2);
              let month4 = ("0" + (new Date(data.dataBeliTerakhir[0].Tgl_order).getMonth()+1)).slice(-2);
              let year4 = new Date(data.dataBeliTerakhir[0].Tgl_order).getFullYear();
              let format4=month4+"/"+date4+"/"+year4;
              document.getElementById("PembelianTerakhirFinal").innerHTML= "PembelianTerakhir: "+format4
              +"<br>Supplier: "+ data.dataBeliTerakhir[0].NM_SUP+"<br>Harga Unit: "+rupiah(data.dataBeliTerakhir[0].PriceUnit);
            }
          //   console.log('yay');
          },
          error: function( data ){
              console.log(data);
          },
          complete: function () {
            // Hide loading screen
            $("#loading-screen").css("display", "none");
        },
      });

      var $url=$(this).attr('href');
      $(".formDetailFinal").attr('action',"");
      var action = $('.formDetailFinal').attr('action');
      $('.formDetailFinal').attr('action', action.replace("",""+$url+""));

      $("#loadingFinal").show();
      $("#DivDetailDataFinal").hide();
      $('#modalDetailFinal').modal({ backdrop: 'static', keyboard: false })
      $("body.modal-open").removeAttr("style");
        setTimeout(function() {
          $('#DivDetailDataFinal').show();
          $("#loadingFinal").hide();
        }, 1000);
    });
  });
