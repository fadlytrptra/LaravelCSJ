let nomor_suratJalan = document.getElementById("nomor_suratJalan");
let jumlah_kirim = document.getElementById("jumlah_kirim");
let jumlah_belumDiproses = document.getElementById("jumlah_belumDiproses");
let jumlah_sudahDiproses = document.getElementById("jumlah_sudahDiproses");
let button_proses = document.getElementById("button_proses");
let div_tableBarcode = document.getElementById("div_tableBarcode");
let table_Barcode = document.getElementById("table_Barcode");

//#region Load Form
nomor_suratJalan.focus();
//#endregion

//#region Input Filter

//#endregion

//#region Button-button
button_proses.addEventListener("click", function(){
    div_tableBarcode.style.display = "none";
    if(nomor_suratJalan.value == ""){
        alert("Isi Nomor Surat Jalan dahulu!");
        nomor_suratJalan.focus();
    }
    else{
        div_tableBarcode.style.display = "block";
    }
});
//#endregion
