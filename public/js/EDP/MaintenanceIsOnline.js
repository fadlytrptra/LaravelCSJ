let namaPegawai = $("#namaPegawai");
let checkboxIsOnline = document.getElementById("IsOnline");

//#region load Form

namaPegawai.select2();
namaPegawai.focus();

//#endregion

//#region add event listener

namaPegawai.on("change", function () {
    let selectedOption = this.options[this.selectedIndex];
    let isOnline = selectedOption.getAttribute("data-isonline");

    if (isOnline == "1" || isOnline == "true" || isOnline == "True") {
        checkboxIsOnline.checked = true;
    } else {
        checkboxIsOnline.checked = false;
    }
});

namaPegawai.on("select2:select", function (event) {
    event.preventDefault();
    if (this.selectedIndex !== 0) {
        namaPegawaiText.value = this.value;
        namaPegawai.prop("disabled", true);
    }
});



//#endregion

//#region Function


//#endregion
