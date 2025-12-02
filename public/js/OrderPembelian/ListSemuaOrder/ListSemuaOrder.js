$(document).ready(function () {
    $("#tabelData").DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ url('getAllOrder') }}",
            dataType: "json",
            type: "POST",
        },
        columns: [
            {
                data: "NO_SUP",
            },
            {
                data: "NM_SUP",
            },
            {
                data: "ALAMAT1",
            },
            {
                data: "KOTA1",
            },
            {
                data: "NEGARA1",
            },
            {
                data: "Actions",
            },
        ],
    });
});
