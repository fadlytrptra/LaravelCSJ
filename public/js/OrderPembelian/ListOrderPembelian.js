let tanggal_awal = document.getElementById("tanggal_awal");
let waktu_awal = document.getElementById("waktu_awal");
let tanggal_akhir = document.getElementById("tanggal_akhir");
let waktu_akhir = document.getElementById("waktu_akhir");
let radio_buttonPengadaanPembelian = document.getElementById("radio_buttonPengadaanPembelian");
let radio_buttonBeliSendiri = document.getElementById("radio_buttonBeliSendiri");
let checkbox_centangSemua = document.getElementById("checkbox_centangSemua");
let button_print = document.getElementById("button_print");
let table_ListOrderPembelian = $("#table_ListOrderPembelian").DataTable();

//#region Load Form

tanggal_awal.valueAsDate = new Date();
tanggal_akhir.valueAsDate = new Date();

let currentTime = new Date()
let hours = currentTime.getHours();
let minutes = currentTime.getMinutes();

// Format the time as HH:MM
let formattedTime = hours.toString().padStart(2, '0') + ':' + minutes.toString().padStart(2, '0');

// Set the value of the "waktu_awal" input field
waktu_awal.value = formattedTime;
waktu_akhir.value = formattedTime;

//#endregion

