let buttonCancel = document.getElementById("buttonCancel");
let buttonProses = document.getElementById("buttonProses");
let divButton = document.getElementById("divButton");
let divFitur = document.getElementById("divFitur");
let fiturUserSebelum = [];
let fiturUserSesudah = [];
let listFitur = document.getElementById("listFitur");
let namaPegawai = $("#namaPegawai");
let namaPegawaiText = document.getElementById("namaPegawaiText");
let namaProgram = $("#namaProgram");
let namaProgramText = document.getElementById("namaProgramText");

//#region load Form

namaPegawai.select2();
namaProgram.select2();
namaPegawai.focus();
namaProgram.prop("disabled", true);
divButton.style.display = "none";

//#endregion

//#region add event listener

namaPegawai.on("change", function () {
    if (this.selectedIndex !== 0) {
        this.classList.add("input-error");
        this.setCustomValidity("Tekan Enter!");
        this.reportValidity();
    }
});

namaPegawai.on("select2:select", function (event) {
    event.preventDefault();
    if (this.selectedIndex !== 0) {
        namaPegawaiText.value = this.value;
        namaPegawai.prop("disabled", true);
        namaProgram.prop("disabled", false);
        namaProgram.focus();
    }
});

namaProgram.on("change", function () {
    if (this.selectedIndex !== 0) {
        this.classList.add("input-error");
        this.setCustomValidity("Tekan Enter!");
        this.reportValidity();
    }
});

namaProgram.on("select2:select", function (event) {
    event.preventDefault();
    if (this.selectedIndex !== 0) {
        namaProgramText.value = this.value;
        namaProgram.prop("disabled", true);
        fetch(
            "/AllFitur/" + namaProgramText.value + "/" + namaPegawaiText.value
        )
            .then((response) => response.json())
            .then((data) => {
                console.log(data);
                let checklist;
                if (namaPegawaiText.value != 666) {
                    checklist = createChecklist(data[0], data[1], data[2]);
                } else {
                    checklist = createChecklist(data[0], data[1]);
                }
                divFitur.style.display = "block";
                listFitur.appendChild(checklist);
                divButton.style.display = "block";
                document.getElementById("item-0").focus();

                const checkboxes = document.querySelectorAll(
                    'input[type="checkbox"]:checked'
                );
                fiturUserSebelum = Array.from(checkboxes).map((checkbox) =>
                    parseInt(checkbox.value)
                );
            });
    }
});

buttonProses.addEventListener("click", function (event) {
    event.preventDefault();
    const checkedCheckboxes = document.querySelectorAll(
        'input[type="checkbox"]:checked'
    );
    fiturUserSesudah = Array.from(checkedCheckboxes).map((checkbox) =>
        parseInt(checkbox.value)
    );

    console.log(fiturUserSesudah);
    console.log(fiturUserSebelum);

    let deletedValues = [];
    let addedValues = [];

    fiturUserSebelum.forEach((value) => {
        if (!fiturUserSesudah.includes(value)) {
            deletedValues.push(value);
        }
    });

    fiturUserSesudah.forEach((value) => {
        if (!fiturUserSebelum.includes(value)) {
            addedValues.push(value);
        }
    });

    console.log("Deleted Values Are: ", deletedValues);
    console.log("Added Values Are: ", addedValues);

    // Create the form element
    var form = document.createElement("form");
    form.action = "/AllFitur/edit"; // Set the form action URL
    form.method = "POST"; // Set the form submission method

    let csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    // Create the CSRF token input
    let csrfInput = document.createElement("input");
    csrfInput.type = "hidden";
    csrfInput.name = "_token";
    csrfInput.value = csrfToken;

    // Create the first hidden input
    var input1 = document.createElement("input");
    input1.type = "hidden";
    input1.name = "addedValues";
    input1.value = JSON.stringify(addedValues);

    // Create the second hidden input
    var input2 = document.createElement("input");
    input2.type = "hidden";
    input2.name = "deletedValues";
    input2.value = JSON.stringify(deletedValues);

    // Append the inputs to the form
    form.appendChild(csrfInput);
    form.appendChild(input1);
    form.appendChild(input2);
    form.appendChild(namaPegawaiText);

    // Append the form to the listFitur div in the HTML
    listFitur.appendChild(form);

    // Submit the form
    form.submit();
});

buttonCancel.addEventListener("click", function (event) {
    event.preventDefault();
    namaPegawai.val(null).trigger("change");
    namaPegawai.prop("disabled", false);
    namaPegawai.focus();
    namaPegawaiText.value = "";
    namaProgram.val(null).trigger("change");
    namaProgram.prop("disabled", true);
    namaProgramText.value = "";
    listFitur.innerHTML = "";
    divFitur.style.display = "none";
    divButton.style.display = "none";
});

//#endregion

//#region Function

function createChecklist(array, checkedItems, publicItems) {
    let currentDiv;
    let checklist;
    let listItemCounter = 0;

    const fragment = document.createDocumentFragment();

    for (let i = 0; i < array.length; i++) {
        const item = array[i];

        if (listItemCounter % 15 === 0) {
            currentDiv = document.createElement("div");
            checklist = document.createElement("ul");
            currentDiv.appendChild(checklist);
            fragment.appendChild(currentDiv);
        }

        const listItem = document.createElement("li");

        const checkbox = document.createElement("input");
        checkbox.type = "checkbox";
        checkbox.id = `item-${i}`;
        checkbox.value = item.IdFitur;

        // Check the checkbox if its value exists in the checkedItems array
        const isChecked = checkedItems.some(
            (checkedItem) => checkedItem.Id_Fitur === item.IdFitur
        );
        if (isChecked) {
            checkbox.checked = true;
        }
        if (namaPegawaiText.value != 666) {
            const isPublic = publicItems.some(
                (publicItems) => publicItems.Id_Fitur === item.IdFitur
            );

            if (isPublic) {
                checkbox.checked = true;
                checkbox.disabled = true;
            }
        }

        const label = document.createElement("label");
        label.setAttribute("for", `item-${i}`);
        label.textContent = `${item.NamaMenu} - ${item.NamaFitur}`;

        listItem.appendChild(checkbox);
        listItem.appendChild(label);

        checklist.appendChild(listItem);

        listItemCounter++;
    }

    return fragment;
}

//#endregion
