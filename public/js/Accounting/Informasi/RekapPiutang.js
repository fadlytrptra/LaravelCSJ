let tglAkhirLaporan = document.getElementById('tglAkhirLaporan');
let btnProses = document.getElementById('btnProses');

let formkoreksi = document.getElementById('formkoreksi');
let methodkoreksi = document.getElementById('methodkoreksi');

const tanggalPenagihan = new Date();
const formattedDate2 = tanggalPenagihan.toISOString().substring(0, 10);
tglAkhirLaporan.value = formattedDate2;

btnProses.addEventListener('click', function (event) {
    event.preventDefault();

    fetch("/getCekRekPiutang/" + tglAkhirLaporan.value)
    .then((response) => response.json())
    .then((options) => {
        console.log(options);
        if (options[0].Jumlah > 0) {
            alert("Tanggal Tersebut Sudah Pernah Di Proses");
            btnProses.disabled = true;
            return;
        } else {
            methodkoreksi.value="PUT";
            formkoreksi.action = "/RekapPiutang/" + tglAkhirLaporan.value;
            formkoreksi.submit();
            btnProses.disabled = false;
        }
    })
})
