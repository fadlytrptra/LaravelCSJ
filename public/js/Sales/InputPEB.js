// get all element
let IDDO = document.getElementById("IDDO");
let modalTitle = document.getElementById("modal-title");
let button_submitSelected = document.getElementById("button_submitSelected");
let PEB = document.getElementById("PEB");

// loop through each row and add a click event listener
// rows.forEach(function (row) {
//     // var setujuiBtn = row.querySelector('button[type="submit"]');

//     // add a click event listener to the row to show the modal
//     row.addEventListener("dblclick", function () {
//         // call function to show modal and pass row data
//         showModal(this);
//     });
// });

function showModal(row) {
    // populate the modal with the data
    IDDO = row;
    let pebValue;
    // modalTitle.textContent = "ID DO " + IDDO;
    // fetch("/InputPEB/" + IDDO)
    //     .then((response) => response.json())
    //     .then((data) => {
    //         // console.log(data);
    //         PEB.value = data[0].PEB ?? "";
    //     })
    //     .catch((error) => {
    //         console.error("Error:", error);
    //     });
    // // show the modal
    // document.getElementById("myModal").style.display = "block";
    Swal.fire({
        title: "Masukkan PEB",
        input: "text",
        inputAttributes: {
            autocapitalize: "off",
        },
        showCancelButton: true,
        confirmButtonText: "Proses",
        showLoaderOnConfirm: true,
        preConfirm: async (peb) => {
            try {
                const form = new FormData();
                const csrfToken = document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content");
                form.append("_token", csrfToken);
                form.append("peb", peb);
                form.append("iddo", IDDO);
                const response = await fetch(`/InputPEB`, {
                    method: "POST",
                    headers: {
                        _token: csrfToken,
                    },
                    body: form,
                });

                if (!response.ok) {
                    throw new Error(response.statusText);
                }
                pebValue = peb;
                return response.json();
            } catch (error) {
                console.error("Error:", error); // Debugging: Log any errors
                Swal.showValidationMessage(`Request failed: ${error}`);
            }
        },
        allowOutsideClick: () => !Swal.isLoading(),
    }).then((result) => {
        if (result.isConfirmed) {
            console.log(result.value);
            if (result.value == "success") {
                Swal.fire({
                    title: "Berhasil!",
                    text: `PEB ${pebValue} untuk ID DO ${IDDO} Sudah diinput`, // Use backticks for template literal
                    icon: "success",
                });
                $("#table_DO").DataTable().ajax.reload();
            } else {
                Swal.fire({
                    title: "Gagal!",
                    text: `${result.value}`, // Use backticks for template literal
                    icon: "error",
                });
            }
        }
    });
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

button_submitSelected.addEventListener("click", function (event) {
    event.preventDefault();
    $("#loading-screen").css("display", "flex");
    // console.log("mantap ", IDDO);
    const form = new FormData();
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
    form.append("_token", csrfToken);

    fetch("/cariBarcodeFilter/action", {
        method: "POST",
        body: form,
    })
        .then((response) => response.json())
        .then((data) => {
            // console.log(data);
        })
        .catch((error) => console.error(error))
        .finally(() => {
            $("#loading-screen").css("display", "none");
        });
});
