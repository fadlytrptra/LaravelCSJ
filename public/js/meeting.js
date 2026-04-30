jQuery(function ($) {

    let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

    let save_room = document.getElementById("save_room");
    let ruang_meeting = document.getElementById("ruang_meeting");
    let clear_room = document.getElementById("clear_room");
    let selectUser = document.getElementById("nomorUser_adm");

    if (typeof rooms !== "undefined") {
        $("#table_room").DataTable({

            processing: true,
            serverSide: false,
            responsive: true,
            ordering: false,
            autoWidth: false,
            searching: false,
            lengthChange: false,


            data: rooms,
            columns: [
                {
                    data: "nama_ruangan",
                    defaultContent: "-"
                },
                {
                    data: "id",
                    render: function (data) {
                        return `
                            <a href="/meeting/monthly/${data}" class="btn btn-sm btn-primary">
                                View
                            </a>
                        `;
                    }
                }
            ]
        });
    }

    if (save_room) {
        save_room.addEventListener("click", function () {
            $.ajax({

                url: "/meeting/room",
                type: "POST",

                data: {
                    ruang_meeting: ruang_meeting.value.trim(),
                    _token: csrf
                },

                success: function (response) {
                    if (response.success) {

                        Swal.fire({
                            icon: "success",
                            title: "Berhasil",
                            text: "Ruangan berhasil ditambahkan"
                        }).then(() => {

                            $("#tambahRoomModal").modal("hide");
                            location.reload();

                        });
                    }
                }
            });
        });
    }

    if (clear_room) {
        clear_room.addEventListener("click", function () {
            ruang_meeting.value = "";
        });
    }


    $("#save_admin").click(function(){
        $.ajax({
            url:'/meeting/admin/store',
            type:'POST',

            data:{
                nomorUser: $("#nomorUser_adm").val(),
                _token:$('meta[name="csrf-token"]').attr('content')
            },

            success:function(response){
                if(response.success){
                    Swal.fire({
                        icon:'success',
                        title:'Berhasil',
                        text:'Administrator berhasil ditambahkan'
                    }).then(()=>{
                        location.reload();
                    });

                }else{
                    Swal.fire({
                        icon:'error',
                        text:response.error
                    });
                }
            }
        });
    });

    if (selectUser) {
        selectUser.addEventListener("change", function(){
            let selectedOption = this.options[this.selectedIndex];
            let nama = selectedOption.getAttribute("data-nama");

            console.log("Nama User:", nama);
        });
    }

    $('#rekapMeetingModal').on('show.bs.modal', function () {
        updateRekapTitle()
        loadRekap()
    })

    function loadRekap(){
        let tanggal = $("#rekapTanggal").val()

        $.get('/meeting/rekap', {tanggal:tanggal}, function(res){
            let roomsRekap = res.rooms
            let meetings = res.meetings
            let header1 = '<th rowspan="2">Jam</th>'
            let header2 = ''

            roomsRekap.forEach(room=>{
                header1 += `<th colspan="2">${room.ruang_meeting}</th>`
                header2 += `<th>Pemesan</th><th>Tujuan</th>`
            })

            $("#roomHeader").html(header1)
            $("#roomSubHeader").html(header2)
            let start = 8
            let end = 16
            let html = ''
            let rendered = {}

            for(let i=start;i<end;i++){
                let slotStart = String(i).padStart(2,'0')+":00"
                let slotEnd = String(i+1).padStart(2,'0')+":00"

                html += `<tr>`
                html += `<td>${slotStart} - ${slotEnd}</td>`

                rooms.forEach(room=>{
                    let found = meetings.find(m=>{
                        let startHour = parseInt(m.jam_awal.substring(0,2))
                        let endHour = parseInt(m.jam_akhir.substring(0,2))

                        return (
                            m.ruangan_id == room.id &&
                            startHour <= i &&
                            endHour > i
                        )
                    })

                    if(found){
                        let startHour = parseInt(found.jam_awal.substring(0,2))
                        let endHour = parseInt(found.jam_akhir.substring(0,2))
                        let duration = endHour - startHour
                        let key = room.id + "_" + startHour

                        if(!rendered[key] && i === startHour){
                            html += `<td rowspan="${duration}" class="meeting_pemesan">${found.NamaUser ?? '-'}</td>`
                            html += `<td rowspan="${duration}" class="meeting_tujuan">${found.deskripsi ?? '-'}</td>`
                            rendered[key] = true
                        }

                    }else{
                        html += `<td>-</td><td>-</td>`
                    }
                })
                html += `</tr>`
            }

            $("#rekapBody").html(html)
        })
    }

    $("#btnFilterRekap").click(function(){
        updateRekapTitle()
        loadRekap()
    })

    $("#rekapTanggal").change(function(){
        updateRekapTitle()
        loadRekap()
    })

    function updateRekapTitle(){
        let tanggal = $("#rekapTanggal").val()

        if(tanggal){
            let d = new Date(tanggal)
            let formatted = d.toLocaleDateString('id-ID',{
                day:'2-digit',
                month:'long',
                year:'numeric'
            })

            $("#rekapTitle").text("Rekap Meeting Tanggal " + formatted)
        }
    }



});
