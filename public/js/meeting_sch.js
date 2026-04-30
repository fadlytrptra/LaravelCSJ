jQuery(function ($) {

    //#region variables
    let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
    let lastDurasi = 0;

    //#endregion


    //#region functions
    function hitungJamAkhir(){
        let start = $("#jam_awal").val();

        if(!start) return;

        let parts = start.split(":");
        let hour = parseInt(parts[0]);
        let minute = parseInt(parts[1]);
        let date = new Date();

        date.setHours(hour);
        date.setMinutes(minute + lastDurasi);

        let h = String(date.getHours()).padStart(2,'0');
        let m = String(date.getMinutes()).padStart(2,'0');

        $("#jam_akhir").val(h + ":" + m);
    }

    //#endregion

    //#region addEventListener
    $(document).on("click",".btn-book",function(){
        let room = $(this).data("room");
        let start = $(this).data("start");
        let tanggal = $(this).data("tanggal");

        $("#room_id").val(room);
        $("#tanggal").val(tanggal);

        // isi default jam_awal
        $("#jam_awal").val($(this).data("start"));
        $("#jam_akhir").val("");

    });

    $("#save_meeting").click(function(){
        let deskripsi = $("#deskripsi").val().trim();

        if(deskripsi === ""){
            Swal.fire({
                icon:"warning",
                title:"Peringatan",
                text:"Tujuan meeting tidak boleh kosong"
            });
            return;
        }

        $.ajax({
            url: "/meeting/storeMeeting",
            type: "POST",
            data:{
                room: $("#room_id").val(),
                tanggal: $("#tanggal").val(),
                start: $("#jam_awal").val(),
                end: $("#jam_akhir").val(),
                deskripsi: deskripsi,
                _token: csrf
            },

            success:function(response){
                if(response.success){
                    Swal.fire({
                        icon:"success",
                        title:"Berhasil",
                        text:"Meeting berhasil dipesan"
                    }).then(()=>{
                        location.reload();
                    });

                } else{
                    Swal.fire({
                        icon:"error",
                        title:"Error",
                        text:response.error
                    });
                }
            }
        });
    });

    $(document).on("click",".btn-edit-meeting",function(){
        $("#edit_meeting_id").val($(this).data("id"));
        $("#edit_room_id").val($(this).data("room"));
        $("#edit_tanggal").val($(this).data("tanggal"));
        $("#edit_jam_awal").val($(this).data("start"));
        $("#edit_jam_akhir").val($(this).data("end"));
        $("#edit_deskripsi").val($(this).data("deskripsi"));
        $("#edit_status").val($(this).data("status"));
        $("#edit_pemesan").val($(this).data("pemesan"));
    });


    $("#update_meeting").click(function(){
        $.ajax({
            url: "/meeting/update",
            type: "POST",

            data:{
                id: $("#edit_meeting_id").val(),
                room: $("#edit_room_id").val(),
                tanggal: $("#edit_tanggal").val(),
                start: $("#edit_jam_awal").val(),
                end: $("#edit_jam_akhir").val(),
                status: $("#edit_status").val(),
                deskripsi: $("#edit_deskripsi").val(),
                _token: csrf
            },

            success:function(response){
                if(response.success){
                    Swal.fire({
                        icon:"success",
                        title:"Berhasil",
                        text:"Meeting berhasil diupdate"
                    }).then(()=>{
                        location.reload();
                    });

                }else{
                    Swal.fire({
                        icon:"error",
                        title:"Error",
                        text:response.error
                    });
                }
            }
        });
    });

    $(document).on("click",".durasi",function(){
        let start = $("#jam_awal").val();

        if(!start){
            Swal.fire({
                icon:"warning",
                text:"Pilih jam awal terlebih dahulu"
            });
            return;
        }

        $(".durasi").removeClass("active");
        $(this).addClass("active");

        lastDurasi = $(this).data("durasi");
        hitungJamAkhir();
    });

    $(document).on("click",".btn-cancel-meeting",function(){
        let id = $(this).data("id");
        Swal.fire({
            title:"Batalkan Meeting?",
            text:"Meeting akan dibatalkan",
            icon:"warning",
            showCancelButton:true,
            confirmButtonText:"Ya, Batalkan",
            cancelButtonText:"Tidak"
        }).then((result)=>{

            if(result.isConfirmed){
                $.ajax({
                    url:"/meeting/cancel",
                    type:"POST",

                    data:{
                        id:id,
                        _token:csrf
                    },

                    success:function(response){
                        if(response.success){
                            Swal.fire({
                                icon:"success",
                                title:"Berhasil",
                                text:"Meeting dibatalkan"
                            }).then(()=>{
                                location.reload();
                            });

                        }else{

                            Swal.fire({
                                icon:"error",
                                text:response.error
                            });
                        }
                    }
                });
            }
        });
    });

    //clear data ketika di close
    $('#bookingMeetingModal').on('hidden.bs.modal', function () {
        $('#deskripsi').val('');
        $('#jam_awal').val('');
        $('#jam_akhir').val('');
        $('#room_id').val('');
    });

    //#endregion

});
