let PurchaseDate = document.getElementById("PurchaseDate");

PurchaseDate.valueAsDate = new Date();

function validateIpAddress() {
    var ipAddressInput = document.getElementById("ipAddress");
    var resultDiv = document.getElementById("result");
    var errorDiv = document.getElementById("error");

    if (ValidateIPaddress(ipAddressInput.value)) {
        resultDiv.innerHTML = "Valid Format IP Address ";
        errorDiv.innerHTML = "";
    } else {
        resultDiv.innerHTML = "";
        errorDiv.innerHTML = "Invalid Format IP Address ";
    }
}
function ValidateIPaddress(ipaddress) {
    if (
        /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/.test(
            ipaddress
        )
    ) {
        return true;
    } else {
        return false;
    }
}

function showModal(typemodal) {
    let osValue;
    Swal.fire({
        title: (typemodal == 'AddNewOS') ? "Insert New Operating System" :
               ((typemodal == 'AddNewLocation') ? "Insert New Location" : "Parameter \"typemodal\" Not Found!"),
        input: "text",
        inputAttributes: {
            autocapitalize: "off",
            placeholder: (typemodal == 'AddNewOS') ? "" :
            ((typemodal == 'AddNewLocation') ? "ID Lokasi - Nama Lokasi | Contoh: TPD - Tropodo" : "Parameter \"typemodal\" Not Found!")
        },
        showCancelButton: true,
        confirmButtonText: "Proses",
        showLoaderOnConfirm: true,
        preConfirm: async (input) => {
            try {
                const form = new FormData();
                const csrfToken = document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content");
                form.append("_token", csrfToken);
                form.append("input", input);
                form.append("typemodal", typemodal);
                const response = await fetch(`/Computer/TambahSWAL`, {
                    method: "POST",
                    headers: {
                        _token: csrfToken,
                    },
                    body: form,
                });

                if (!response.ok) {
                    throw new Error(response.statusText);
                }
                inputValue = input;
                return response.json();
            } catch (error) {
                console.error("Error:", error); // Debugging: Log any errors
                Swal.showValidationMessage(`Request failed: ${error}`);
            }
        },
        allowOutsideClick: () => !Swal.isLoading(),
    }).then((result) => {
        if (result.isConfirmed) {
            // console.log(result.value);
            if (result.value == "success") {
                Swal.fire({
                    title: "Berhasil!",
                    text: `Jenis OS ${osValue} Sudah diinput!`, // Use backticks for template literal
                    icon: "success",
                });
                fetchNewDataAndReloadSelectInput("inputos");
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
function fetchNewDataAndReloadSelectInput(jenis) {
    // Fetch the latest data for the select input
    if (jenis == "inputos") {
        fetch("/Computer/FetchOperatingSystems")
            .then((response) => response.json())
            .then((data) => {
                // Assuming data is an array of objects with id and name properties
                const selectInput = document.getElementById("TypeOS");
                // Clear existing options
                selectInput.innerHTML = "";
                // Add new options
                const defaultOption = document.createElement("option");
                defaultOption.selected = true;
                defaultOption.disabled = true;
                defaultOption.textContent = "-- Pilih Type OS --";
                selectInput.appendChild(defaultOption);
                data.forEach((os) => {
                    const option = document.createElement("option");
                    option.value = os.Is_OS;
                    option.textContent = os.Sistem_Operas;
                    selectInput.appendChild(option);
                });
            })
            .catch((error) =>
                console.error("Error fetching operating systems:", error)
            );
    }
}
