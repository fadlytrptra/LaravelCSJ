// get all element
var rows = document.querySelectorAll("#table_SJ tbody tr");
let modalTitle = document.getElementById("modal-title");
let button_submitSelected = document.getElementById("button_submitSelected");

// loop through each row and add a click event listener
rows.forEach(function (row) {
    // var setujuiBtn = row.querySelector('button[type="submit"]');

    // add a click event listener to the row to show the modal
    row.addEventListener("dblclick", function () {
        // call function to show modal and pass row data
        showModal(this);
    });
});

function showModal(row) {
    // get the data from the row
    let IdHeaderKirim = row.cells[5].textContent;

    // populate the modal with the data
    // console.log(row);
    modalTitle.textContent = "Surat Jalan " + row.cells[0].textContent;
    fetch("/SuratJalanManager/" + IdHeaderKirim)
        .then((response) => response.json())
        .then((data) => {
            // console.log(data);
            document.getElementById("Uraian").textContent = data[0].NamaType;
            document.getElementById("QtyPrimer").textContent =
                data[0].QtyPrimer;
            document.getElementById("QtySekunder").textContent =
                data[0].QtySekunder;
            document.getElementById("QtyTritier").textContent =
                data[0].QtyTritier;
            document.getElementById("MinDO").textContent = data[0].MinKirimDO;
            document.getElementById("MaxDO").textContent = data[0].MaxKirimDO;
        })
        .catch((error) => {
            console.error("Error:", error);
        });

    // show the modal
    document.getElementById("myModal").style.display = "block";
}

// get the modal element
var modal = document.getElementById("myModal");

// get the close button
var closeBtn = document.querySelector(".close");

// close the modal when the user clicks outside of it or on the close button
window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
};

closeBtn.addEventListener("click", function () {
    modal.style.display = "none";
});

button_submitSelected.addEventListener("click", function(event){
    event.preventDefault();
    let table = document.getElementById("table_SJ");
    let rows = table.getElementsByTagName("tr");
    for (let i = 1; i < rows.length; i++) {
        let cells = rows[i].cells;
        let checkbox = cells[0].getElementsByTagName("input")[0]; // get the checkbox in the current row
        // console.log(checkbox.value);
        if (checkbox.checked) {
            // check if the checkbox is checked
            let nomorDO =
                checkbox.value; // get the value of the "Nomor SP" column
            // console.log(nomorDO);
            let input = document.createElement("input"); // create a new input element
            input.type = "hidden"; // set the input type to 'hidden'
            input.name = "nomorSJs[]"; // set the input name to 'nomorSPs[]'
            input.value = nomorDO; // set the input value to the current nomorSP value
            form_submitSelected.appendChild(input); // append the input element to the form
            // console.log(form_submitSelected);
        }
    }

    // append the form to the document and submit it
    // document.body.appendChild(form_submitSelected);
    form_submitSelected.submit();
});
