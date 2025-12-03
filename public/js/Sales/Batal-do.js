let buttonBatal = document.getElementById("buttonBatal");
let myModal = document.getElementById("my-modal");
let modalOverlay = document.getElementById("modal-overlay");
let modalIdTrans = document.getElementById("modal-idtransTmp");
let modalIdDo = document.getElementById("modal-idDO");
let modalValue = document.getElementById("modal-value");
let modalBtnBatalDO = document.getElementById("modal-btnBatalDO");
let modalForm = document.getElementById("modal-form");
let modalBtnStokKosong = document.getElementById("modal-btnStokKosong");

function openModal() {
    // Set the value of the hidden input field
    let table = document.getElementById("table_DO");
    let rows = table.getElementsByTagName("tr");
    for (let i = 1; i < rows.length; i++) {
        let cells = rows[i].cells;
        let checkbox = cells[0].getElementsByTagName("input")[0]; // get the checkbox in the current row
        if (checkbox.checked) {
            // check if the checkbox is checked
            let nomorDO = checkbox.value; // get the value of the "Nomor SP" column
            let TransTmp = cells[10].innerHTML;
            // console.log(nomorDO);
            let inputDO = document.createElement("input"); // create a new input element
            inputDO.type = "hidden"; // set the input type to 'hidden'
            inputDO.name = "nomorDOs[]";
            inputDO.value = nomorDO;
            modalForm.appendChild(inputDO); // append the input element to the form
            let inputTransTMP = document.createElement("input");
            inputTransTMP.type = "hidden";
            inputTransTMP.name = "nomorTransTmps[]";
            inputTransTMP.value = TransTmp;
            modalForm.appendChild(inputTransTMP);
            // console.log(modalForm);
        }
    }
    showModal();
}

function setModalValue() {
    // Set the value of the input field
    // modalValue.value = value;

    // Submit the form
    document.getElementById("modal-form").submit();
}

// Close the modal when the user clicks outside of it
// modalOverlay.addEventListener("click", function () {
//     hideModal();
// });

window.onclick = function (event) {
    if (event.target == myModal) {
        hideModal();
    }
};

function showModal() {
    var modal = document.getElementById("my-modal");
    modal.style.display = "block";
    setTimeout(function() {
        modal.style.opacity = 1;
      }, 100);
}

function hideModal() {
    var modal = document.getElementById("my-modal");
    modal.style.opacity = 0;
    setTimeout(function() {
        modal.style.display = "none";
      }, 500);
}

// // Get the modal
// var modal = document.getElementById("myModal");

// // Show the modal
// function showModal() {
//   modal.style.display = "block";
// }

// buttonBatal.addEventListener("click", function(){
//     showModal();
// });
// // Hide the modal when clicked outside of it
// window.onclick = function(event) {
//   if (event.target == modal) {
//     modal.style.display = "none";
//   }
// }
