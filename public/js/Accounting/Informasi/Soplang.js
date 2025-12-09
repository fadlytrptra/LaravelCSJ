let tglAkhirLaporan = document.getElementById('tglAkhirLaporan');
let btnProses = document.getElementById('btnProses');

let formkoreksi = document.getElementById('formkoreksi');
let methodkoreksi = document.getElementById('methodkoreksi');

const tanggalPenagihan = new Date();
const formattedDate2 = tanggalPenagihan.toISOString().substring(0, 10);
tglAkhirLaporan.value = formattedDate2;

$.ajaxSetup({
    beforeSend: function () {
        // Show the loading screen before the AJAX request
        $("#loading-screen").css("display", "flex");
    },
    complete: function () {
        // Hide the loading screen after the AJAX request completes
        $("#loading-screen").css("display", "none");
    },
});

// btnProses.addEventListener('click', function (event) {
//     event.preventDefault();

//     methodkoreksi.value="PUT";
//     formkoreksi.action = "/Soplang/" + tglAkhirLaporan.value;
//     formkoreksi.submit();
// })
var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

btnProses.addEventListener("click", function (e) {
    e.preventDefault();
    btnProses.disabled = true; // Disable the button to prevent multiple clicks
    $.ajax({
        type: 'POST',
        url: 'Soplang',
        data: {
            _token: csrfToken,
            tglAkhirLaporan: tglAkhirLaporan.value,
        },
        success: function (response) {
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    html: response.success,
                    returnFocus: false
                });
                btnProses.disabled = false;
            }
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
            btnProses.disabled = false;
        }
    });
});

// btnProses.addEventListener("click", function (e) {
//     $.ajax({
//         type: 'PUT',
//         url: 'Soplang/proses',
//         data: {
//             _token: csrfToken,
//             tglAkhirLaporan: tglAkhirLaporan.value,
//         },
//         success: function (response) {
//             if (response.success) {
//                 Swal.fire({
//                     icon: 'success',
//                     title: 'Success',
//                     html: response.success,
//                     returnFocus: false
//                 });
//             }
//         },
//         error: function (xhr, status, error) {
//             console.error('Error:', error);
//         }
//     });
// });
