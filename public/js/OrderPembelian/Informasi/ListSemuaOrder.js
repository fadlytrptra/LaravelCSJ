jQuery(function ($) {

    let csrfToken = $('meta[name="csrf-token"]').attr("content");

    /*
    |--------------------------------------------------------------------------
    | COLUMN TYPE
    |--------------------------------------------------------------------------
    */

    const columnTypeMap = {
        NO_ORDER: "string",
        Tgl_order: "date",
        NM_USER: "string",
        ID_DIVISI: "string",
        NM_DIVISI: "string",
        KODE_BARANG: "string",
        NM_BARANG: "string",
        SUB_KATEGORI: "string",
        KATEGORI: "string",
        KATEGORI_UTAMA: "string",
        QTY_PO: "number",
        SATUAN: "string",
        SUPPLIER: "string",
        JENIS_PEMBELIAN: "string",
        No_terima: "string",
        TGL_DATANG: "date",
        QTY_RCV: "number",
        NO_SJ: "string",
        PRICE_RCV: "number",
        DISC_RCV: "number",
        PRICE_RCV_PPN: "number",
        TGL_TRANSFER: "date",
        Id_Penagihan: "string",
        No_PIB: "string",
        No_sppb: "string",
        Tgl_sppb: "date",
    };


    /*
    |--------------------------------------------------------------------------
    | FILTER OPTIONS
    |--------------------------------------------------------------------------
    */

    const filterOptions = {

        string: [
            "=",
            "!=",
            "like",
            "in",
            "notin",
            "isnull",
            "isnotnull"
        ],

        number: [
            "=",
            "!=",
            "like",
            "in",
            "notin",
            "isbetween",
            "notbetween",
            "isnull",
            "isnotnull"
        ],

        date: [
            "=",
            "!=",
            "isbetween",
            "notbetween",
            "isnull",
            "isnotnull"
        ],

        boolean: [
            "=",
            "!=",
            "isnull",
            "isnotnull"
        ]
    };


    /*
    |--------------------------------------------------------------------------
    | DATATABLE
    |--------------------------------------------------------------------------
    */

    let tableListOrder = $("#tabelData").DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        ordering: true,
        pageLength: 10,
        lengthMenu: [
            [10, 25, 50, 100],
            [10, 25, 50, 100]
        ],

        ajax: {
            url: "ListSemuaOrder/create",
            type: "GET",
            dataType: "json",

            data: function (d) {

                d._token = csrfToken;

                let filters = [];

                $("#modalAdvancedSearch .advanced-filter-group").each(function () {

                    const column = $(this)
                        .find(".column-select")
                        .val();

                    const operator = $(this)
                        .find(".filter-type")
                        .val();

                    const sort = $(this)
                        .find(".sort-order")
                        .val();

                    const isBetween =
                        operator === "isbetween" ||
                        operator === "notbetween";

                    let value = null;

                    if (column && operator) {

                        const colType =
                            columnTypeMap[column];

                        if (colType === "date") {

                            if (isBetween) {

                                const value1 = $(this)
                                    .find(".search-date1")
                                    .val();

                                const value2 = $(this)
                                    .find(".search-date2")
                                    .val();

                                value = value1 + "," + value2;

                            } else {

                                value = $(this)
                                    .find(".search-date")
                                    .val();
                            }

                        } else if (colType === "number") {

                            if (isBetween) {

                                const value1 = $(this)
                                    .find(".search-number1")
                                    .val();

                                const value2 = $(this)
                                    .find(".search-number2")
                                    .val();

                                value = value1 + "," + value2;

                            } else {

                                value = $(this)
                                    .find(".search-number")
                                    .val();
                            }

                        } else {

                            value = $(this)
                                .find(".search-value")
                                .val();
                        }
                    }

                    const noValueOperator =
                        operator === "isnull" ||
                        operator === "isnotnull";

                    if (
                        column &&
                        operator &&
                        (
                            value ||
                            noValueOperator
                        )
                    ) {
                        filters.push({
                            column: column,
                            operator: operator,
                            value: value,
                            sort: sort
                        });
                    }
                    else if (
                        column &&
                        sort
                    ) {
                        filters.push({
                            column: column,
                            operator: operator,
                            value: value,
                            sort: sort
                        });
                    }
                });

                d.custom_filters = filters;

                d.maximumRecords =
                    parseInt($("#maximumRecords").val()) || 1000;
            }
        },

        columns: [
            {
                data: "NO_ORDER",
                title: "No. Order"
            },

            {
                data: "Tgl_order",
                title: "Tgl. Order",

                render: function (data) {
                    if (!data) {
                        return "";
                    }

                    let parts = data
                        .split(" ")[0]
                        .split("-");

                    return (
                        parts[2] +
                        "-" +
                        parts[1] +
                        "-" +
                        parts[0]
                    );
                }
            },

            {
                data: "NM_USER",
                title: "Nama User"
            },

            {
                data: "NM_DIVISI",
                title: "Nama Divisi"
            },

            {
                data: "KODE_BARANG",
                title: "Kode Barang"
            },

            {
                data: "NM_BARANG",
                title: "Nama Barang"
            },

            {
                data: "SUB_KATEGORI",
                title: "Sub Kategori"
            },

            {
                data: "KATEGORI",
                title: "Kategori"
            },

            {
                data: "KATEGORI_UTAMA",
                title: "Kategori Utama"
            },

            {
                data: "QTY_PO",
                title: "Qty. PO",

                render: function (data) {
                    if (data == null) {
                        return "";
                    }

                    return parseFloat(data).toFixed(2);
                }
            },

            {
                data: "SATUAN",
                title: "Satuan"
            },

            {
                data: "SUPPLIER",
                title: "Supplier"
            },

            {
                data: "JENIS_PEMBELIAN",
                title: "Jenis Pembelian"
            },

            {
                data: "No_terima",
                title: "No. Terima"
            },

            {
                data: "TGL_DATANG",
                title: "Tgl. Datang",

                render: function (data) {
                    if (!data) {
                        return "";
                    }

                    let parts = data
                        .split(" ")[0]
                        .split("-");

                    return (
                        parts[2] +
                        "-" +
                        parts[1] +
                        "-" +
                        parts[0]
                    );
                }
            },

            {
                data: "QTY_RCV",
                title: "Qty. RCV",

                render: function (data) {
                    if (data == null) {
                        return "";
                    }

                    return parseFloat(data).toFixed(2);
                }
            },

            {
                data: "NO_SJ",
                title: "No. SJ"
            },

            {
                data: "PRICE_RCV",
                title: "Price RCV",

                render: function (data) {
                    if (data == null) {
                        return "";
                    }

                    return numeral(data).format("0,0.00");
                }
            },

            {
                data: "DISC_RCV",
                title: "Disc RCV",

                render: function (data) {
                    if (data == null) {
                        return "";
                    }

                    return numeral(data).format("0,0.00");
                }
            },

            {
                data: "PRICE_RCV_PPN",
                title: "Price RCV PPN",

                render: function (data) {
                    if (data == null) {
                        return "";
                    }

                    return numeral(data).format("0,0.00");
                }
            },

            {
                data: "TGL_TRANSFER",
                title: "Tgl. Transfer",

                render: function (data) {
                    if (!data) {
                        return "";
                    }

                    let parts = data
                        .split(" ")[0]
                        .split("-");

                    return (
                        parts[2] +
                        "-" +
                        parts[1] +
                        "-" +
                        parts[0]
                    );
                }
            },

            {
                data: "Id_Penagihan",
                title: "Id Penagihan"
            },

            {
                data: "No_PIB",
                title: "No. PIB"
            },

            {
                data: "No_sppb",
                title: "No. SPPB"
            },

            {
                data: "Tgl_sppb",
                title: "Tgl. SPPB",

                render: function (data) {
                    if (!data) {
                        return "";
                    }

                    let parts = data
                        .split(" ")[0]
                        .split("-");

                    return (
                        parts[2] +
                        "-" +
                        parts[1] +
                        "-" +
                        parts[0]
                    );
                }
            }
        ],

        order: [
            [1, "desc"]
        ]
    });


    /*
    |--------------------------------------------------------------------------
    | AJAX LOADING
    |--------------------------------------------------------------------------
    */

    $.ajaxSetup({

        beforeSend: function () {

            $("#loading-screen").css(
                "display",
                "flex"
            );
        },

        complete: function () {

            $("#loading-screen").css(
                "display",
                "none"
            );
        }
    });


    /*
    |--------------------------------------------------------------------------
    | POPULATE COLUMN
    |--------------------------------------------------------------------------
    */

    function populateColumn() {

        let select =
            $(".column-select");

        select.empty();

        select.append(
            new Option(
                "No Column",
                ""
            )
        );

        tableListOrder
            .columns()
            .every(function () {

                let colData =
                    this.dataSrc();

                let colTitle =
                    this.header().textContent;

                if (colData) {

                    select.append(
                        $("<option>", {
                            value: colData,
                            text: colTitle
                        })
                    );
                }
            });

        select.prop(
            "selectedIndex",
            0
        );

        $(".advanced-filter-group")
            .each(function () {

                const group = $(this);

                const columnSelect =
                    group.find(".column-select");

                const today =
                    new Date()
                        .toISOString()
                        .split("T")[0];

                columnSelect
                    .val("")
                    .trigger("change");

                group
                    .find(".filter-type")
                    .val("")
                    .trigger("change");

                group
                    .find(".search-value")
                    .val("");

                group
                    .find(".search-date1")
                    .val(today);

                group
                    .find(".search-date2")
                    .val(today);

                group
                    .find(".search-date")
                    .val(today);
            });
    }


    /*
    |--------------------------------------------------------------------------
    | SELECT2
    |--------------------------------------------------------------------------
    */

    function initializeSelect2() {

        $(".column-select").select2({

            placeholder:
                "Select column name",

            allowClear: true,

            dropdownParent:
                $("#modalAdvancedSearch")
        });


        $(".filter-type").select2({

            placeholder:
                "Select Filter Type",

            allowClear: true,

            dropdownParent:
                $("#modalAdvancedSearch")
        });


        $(".sort-order").select2({

            placeholder:
                "Select Sort Type",

            allowClear: true,

            dropdownParent:
                $("#modalAdvancedSearch")
        });
    }


    /*
    |--------------------------------------------------------------------------
    | FILTER LABEL
    |--------------------------------------------------------------------------
    */

    function getFilterLabel(op) {

        switch (op) {

            case "=":
                return "Equal";

            case "!=":
                return "Not Equal";

            case "like":
                return "Contains";

            case "in":
                return "In";

            case "notin":
                return "Not In";

            case "isbetween":
                return "Is Between";

            case "notbetween":
                return "Is Not Between";

            case "isnull":
                return "Is Null";

            case "isnotnull":
                return "Is Not Null";

            default:
                return op;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | FILTER VISIBILITY
    |--------------------------------------------------------------------------
    */

    function handleFilterTypeVisibility() {

        $(".advanced-filter-group").each(
            function () {

                const group = $(this);

                const columnSelect =
                    group.find(".column-select");

                const filterType =
                    group.find(".filter-type");


                function updateVisibility() {

                    const selectedCol =
                        columnSelect.val();

                    const colType =
                        columnTypeMap[selectedCol] ||
                        "string";

                    const filter =
                        filterType.val();

                    const isBetween =
                        filter === "isbetween" ||
                        filter === "notbetween";

                    const allowed =
                        filterOptions[colType] ||
                        [];


                    /*
                    | Rebuild filter options
                    */

                    const prevVal =
                        filterType.val();

                    filterType.empty();

                    filterType.append(
                        new Option(
                            "No Filter",
                            ""
                        )
                    );

                    allowed.forEach(function (opt) {

                        filterType.append(
                            new Option(
                                getFilterLabel(opt),
                                opt
                            )
                        );
                    });


                    if (allowed.includes(prevVal)) {

                        filterType.val(prevVal);

                    } else {

                        filterType.val("");
                    }


                    /*
                    | Hide all inputs
                    */

                    group
                        .find(".search-value")
                        .hide();

                    group
                        .find(".search-date")
                        .hide();

                    group
                        .find(".search-number")
                        .hide();

                    group
                        .find(".div-date-between")
                        .hide();

                    group
                        .find(".div-number-between")
                        .hide();


                    /*
                    | Show correct input
                    */

                    if (colType === "date") {

                        if (isBetween) {

                            group
                                .find(".div-date-between")
                                .show();

                        } else {

                            group
                                .find(".search-date")
                                .show();
                        }

                    } else if (colType === "number") {

                        if (isBetween) {

                            group
                                .find(".div-number-between")
                                .show();

                        } else {

                            group
                                .find(".search-number")
                                .show();
                        }

                    } else {

                        group
                            .find(".search-value")
                            .show();
                    }
                }


                columnSelect.on(
                    "change",
                    updateVisibility
                );


                filterType.on(
                    "change",
                    function () {

                        const selectedCol =
                            columnSelect.val();

                        const colType =
                            columnTypeMap[selectedCol] ||
                            "string";

                        const filter =
                            filterType.val();

                        const isBetween =
                            filter === "isbetween" ||
                            filter === "notbetween";


                        group
                            .find(".search-value")
                            .hide();

                        group
                            .find(".search-date")
                            .hide();

                        group
                            .find(".search-number")
                            .hide();

                        group
                            .find(".div-date-between")
                            .hide();

                        group
                            .find(".div-number-between")
                            .hide();


                        if (colType === "date") {

                            if (isBetween) {

                                group
                                    .find(".div-date-between")
                                    .show();

                            } else {

                                group
                                    .find(".search-date")
                                    .show();
                            }

                        } else if (colType === "number") {

                            if (isBetween) {

                                group
                                    .find(".div-number-between")
                                    .show();

                            } else {

                                group
                                    .find(".search-number")
                                    .show();
                            }

                        } else {

                            group
                                .find(".search-value")
                                .show();
                        }
                    }
                );


                columnSelect.trigger("change");
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | INITIALIZATION
    |--------------------------------------------------------------------------
    */

    populateColumn();

    initializeSelect2();

    handleFilterTypeVisibility();


    /*
    |--------------------------------------------------------------------------
    | OPEN ADVANCED SEARCH
    |--------------------------------------------------------------------------
    */

    $("#btnAdvancedSearch").on(
        "click",
        function () {

            $("#modalAdvancedSearch").modal(
                "show"
            );
        }
    );


    /*
    |--------------------------------------------------------------------------
    | CLOSE ADVANCED SEARCH
    |--------------------------------------------------------------------------
    */

    $("#closeModalButton").on(
        "click",
        function () {

            $("#modalAdvancedSearch").modal(
                "hide"
            );
        }
    );


    /*
    |--------------------------------------------------------------------------
    | APPLY SEARCH
    |--------------------------------------------------------------------------
    */

    $("#applySearch").on(
        "click",
        function () {

            let isValid = true;

            let errorMsg = "";

            let firstInvalidInput;


            $(".advanced-filter-group")
                .each(function (i, el) {

                    const index = i + 1;

                    const column =
                        $(el)
                            .find(".column-select")
                            .val();

                    const filter =
                        $(el)
                            .find(".filter-type")
                            .val();

                    const isBetween =
                        filter === "isbetween" ||
                        filter === "notbetween";

                    let value;
                    let value1;
                    let value2;


                    if (column && filter) {

                        const colType =
                            columnTypeMap[column];


                        /*
                        | DATE
                        */

                        if (colType === "date") {

                            if (isBetween) {

                                value1 =
                                    $(el)
                                        .find(".search-date1")
                                        .val()
                                        .trim();

                                value2 =
                                    $(el)
                                        .find(".search-date2")
                                        .val()
                                        .trim();


                                if (!value1 || !value2) {

                                    isValid = false;

                                    errorMsg =
                                        `Tanggal awal dan akhir pada filter baris ${index} belum lengkap.`;

                                    firstInvalidInput =
                                        firstInvalidInput ||
                                        (
                                            !value1
                                                ? $(el).find(".search-date1")[0]
                                                : $(el).find(".search-date2")[0]
                                        );

                                    return false;
                                }


                                if (value1 > value2) {

                                    isValid = false;

                                    errorMsg =
                                        `Tanggal awal lebih besar daripada tanggal akhir pada filter baris ${index}.`;

                                    firstInvalidInput =
                                        firstInvalidInput ||
                                        $(el).find(
                                            ".search-date1"
                                        )[0];

                                    return false;
                                }

                            } else {

                                value =
                                    $(el)
                                        .find(".search-date")
                                        .val()
                                        .trim();


                                if (!value) {

                                    isValid = false;

                                    errorMsg =
                                        `Tanggal pada filter baris ${index} belum diisi.`;

                                    firstInvalidInput =
                                        firstInvalidInput ||
                                        $(el).find(
                                            ".search-date"
                                        )[0];

                                    return false;
                                }
                            }


                        /*
                        | NUMBER
                        */

                        } else if (colType === "number") {

                            if (isBetween) {

                                value1 =
                                    $(el)
                                        .find(".search-number1")
                                        .val()
                                        .trim();

                                value2 =
                                    $(el)
                                        .find(".search-number2")
                                        .val()
                                        .trim();


                                if (!value1 || !value2) {

                                    isValid = false;

                                    errorMsg =
                                        `Nilai angka antara pada filter baris ${index} belum lengkap.`;

                                    firstInvalidInput =
                                        firstInvalidInput ||
                                        (
                                            !value1
                                                ? $(el).find(".search-number1")[0]
                                                : $(el).find(".search-number2")[0]
                                        );

                                    return false;
                                }


                                if (
                                    parseFloat(value1) >
                                    parseFloat(value2)
                                ) {

                                    isValid = false;

                                    errorMsg =
                                        `Nilai angka awal lebih besar daripada angka akhir pada filter baris ${index}.`;

                                    firstInvalidInput =
                                        firstInvalidInput ||
                                        $(el).find(
                                            ".search-number1"
                                        )[0];

                                    return false;
                                }

                            } else {

                                value =
                                    $(el)
                                        .find(".search-number")
                                        .val()
                                        .trim();


                                if (!value) {

                                    isValid = false;

                                    errorMsg =
                                        `Nilai angka pada filter baris ${index} belum diisi.`;

                                    firstInvalidInput =
                                        firstInvalidInput ||
                                        $(el).find(
                                            ".search-number"
                                        )[0];

                                    return false;
                                }
                            }


                        /*
                        | STRING
                        */

                        } else {

                            value =
                                $(el)
                                    .find(".search-value")
                                    .val()
                                    .trim();


                            if (!value) {

                                isValid = false;

                                errorMsg =
                                    `Nilai pencarian pada filter baris ${index} belum diisi.`;

                                firstInvalidInput =
                                    firstInvalidInput ||
                                    $(el).find(
                                        ".search-value"
                                    )[0];

                                return false;
                            }
                        }
                    }
                });


            /*
            | Default maximum records
            */

            if ($("#maximumRecords").val() === "") {

                $("#maximumRecords").val(1000);
            }


            /*
            | Validation failed
            */

            if (!isValid) {

                Swal.fire({

                    icon: "warning",

                    title: "Invalid Input",

                    text: errorMsg
                });

                return;
            }


            /*
            | Reload
            */

            $("#modalAdvancedSearch").modal(
                "hide"
            );

            tableListOrder.ajax.reload();
        }
    );


    /*
    |--------------------------------------------------------------------------
    | EXPORT EXCEL
    |--------------------------------------------------------------------------
    */

    $("#btnExportExcel").on(
        "click",
        function () {

            let requestData = {

                _token: csrfToken,

                jenisStore: "exportToExcel",

                maximumRecords:
                    parseInt(
                        $("#maximumRecords").val()
                    ) || 1000,

                custom_filters: []
            };


            /*
            | Collect filters
            */

            $("#modalAdvancedSearch .advanced-filter-group")
                .each(function (i, el) {

                    const column =
                        $(this)
                            .find(".column-select")
                            .val();

                    const operator =
                        $(this)
                            .find(".filter-type")
                            .val();

                    const sort =
                        $(this)
                            .find(".sort-order")
                            .val();

                    const isBetween =
                        operator === "isbetween" ||
                        operator === "notbetween";

                    let value = null;


                    if (column && operator) {

                        const colType =
                            columnTypeMap[column];


                        if (colType === "date") {

                            if (isBetween) {

                                value =
                                    $(el)
                                        .find(".search-date1")
                                        .val()
                                        .trim()
                                    +
                                    ", " +
                                    $(el)
                                        .find(".search-date2")
                                        .val()
                                        .trim();

                            } else {

                                value =
                                    $(el)
                                        .find(".search-date")
                                        .val()
                                        .trim();
                            }


                        } else if (colType === "number") {

                            if (isBetween) {

                                value =
                                    $(el)
                                        .find(".search-number1")
                                        .val()
                                        .trim()
                                    +
                                    ", " +
                                    $(el)
                                        .find(".search-number2")
                                        .val()
                                        .trim();

                            } else {

                                value =
                                    $(el)
                                        .find(".search-number")
                                        .val()
                                        .trim();
                            }


                        } else {

                            value =
                                $(el)
                                    .find(".search-value")
                                    .val()
                                    .trim();
                        }
                    }


                    if (
                        (column && operator && value) ||
                        (column && sort)
                    ) {

                        requestData.custom_filters.push({

                            column: column,

                            operator: operator,

                            value: value,

                            sort: sort
                        });
                    }
                });


            /*
            | AJAX Export
            */

            $.ajax({

                url: "ListSemuaOrder",

                method: "POST",

                data: requestData,

                success: function (response) {

                    const dataToExport =
                        response.data.map(
                            function (row) {

                                return {

                                    "No. Order":
                                        row.NO_ORDER
                                            ?.trim(),

                                    "Tgl. Order":
                                        row.Tgl_order
                                            ? moment(
                                                row.Tgl_order
                                            ).format(
                                                "DD-MM-YYYY"
                                            )
                                            : "",

                                    "Nama User":
                                        row.NM_USER
                                            ?.trim(),

                                    "Nama Divisi":
                                        row.NM_DIVISI
                                            ?.trim(),

                                    "Kode Barang":
                                        row.KODE_BARANG,

                                    "Nama Barang":
                                        row.NM_BARANG
                                            ?.trim(),

                                    "Sub Kategori":
                                        row.SUB_KATEGORI
                                            ?.trim(),

                                    "Kategori":
                                        row.KATEGORI
                                            ?.trim(),

                                    "Kategori Utama":
                                        row.KATEGORI_UTAMA
                                            ?.trim(),

                                    "Qty. PO":
                                        parseFloat(
                                            row.QTY_PO ?? 0
                                        ),

                                    "Satuan":
                                        row.SATUAN
                                            ?.trim(),

                                    "Supplier":
                                        row.SUPPLIER
                                            ?.trim(),

                                    "Jenis Pembelian":
                                        row.JENIS_PEMBELIAN
                                            ?.trim(),

                                    "No. Terima":
                                        row.No_terima,

                                    "Tgl. Datang":
                                        row.TGL_DATANG
                                            ? moment(
                                                row.TGL_DATANG
                                            ).format(
                                                "DD-MM-YYYY"
                                            )
                                            : "",

                                    "Qty. RCV":
                                        parseFloat(
                                            row.QTY_RCV ?? 0
                                        ),

                                    "No. SJ":
                                        row.NO_SJ,

                                    "Price RCV":
                                        parseFloat(
                                            row.PRICE_RCV ?? 0
                                        ),

                                    "Disc RCV":
                                        parseFloat(
                                            row.DISC_RCV ?? 0
                                        ),

                                    "Price RCV PPN":
                                        parseFloat(
                                            row.PRICE_RCV_PPN ?? 0
                                        ),

                                    "Tgl. Transfer":
                                        row.TGL_TRANSFER
                                            ? moment(
                                                row.TGL_TRANSFER
                                            ).format(
                                                "DD-MM-YYYY"
                                            )
                                            : "",

                                    "Id Penagihan":
                                        row.Id_Penagihan,

                                    "No. PIB":
                                        row.No_PIB,

                                    "No. SPPB":
                                        row.No_sppb,

                                    "Tgl. SPPB":
                                        row.Tgl_sppb
                                            ? moment(
                                                row.Tgl_sppb
                                            ).format(
                                                "DD-MM-YYYY"
                                            )
                                            : ""
                                };
                            }
                        );


                    let ws =
                        XLSX.utils.json_to_sheet(
                            dataToExport
                        );

                    let wb =
                        XLSX.utils.book_new();

                    const sheetName =
                        moment().format(
                            "YYYY-MM-DD_HH-mm-ss"
                        );

                    XLSX.utils.book_append_sheet(
                        wb,
                        ws,
                        sheetName
                    );

                    XLSX.writeFile(
                        wb,
                        "ListSemuaOrder.xlsx"
                    );
                },

                error: function (xhr) {

                    console.error(
                        "Export error:",
                        xhr.responseText
                    );

                    Swal.fire({

                        icon: "error",

                        title: "Export Gagal",

                        text:
                            "Terjadi kesalahan saat mengambil data untuk Excel."
                    });
                }
            });
        }
    );

});
