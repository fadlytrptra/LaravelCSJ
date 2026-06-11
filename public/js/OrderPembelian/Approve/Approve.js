let tableApprove;
let tableBatal;

$(document).ready(function () {

    console.log('Approve.js loaded');

    // ==========================================
    // DATATABLE
    // ==========================================
    tableApprove = $('#table_Approve').DataTable({
        searching: true,
        order: [[2, 'desc']],
        columnDefs: [{
            orderable: false,
            targets: 0
        }]
    });

    tableBatal = $('#table_Batal').DataTable({
        searching: true,
        order: [[2, 'desc']],
        columnDefs: [{
            orderable: false,
            targets: 0
        }]
    });

    // ==========================================
    // PREVENT MIDDLE CLICK
    // ==========================================
    $(document).on('auxclick', '.DetailApprove', function (e) {
        if (e.button === 1) {
            e.preventDefault();
        }
    });

    // ==========================================
    // HANDLE CHECKBOX
    // ==========================================
    function handleCheckbox(No_trans, checked) {

        const add =
            document.getElementById(
                "DataCheckbox"
            );

        console.log(
            'handleCheckbox:',
            {
                No_trans,
                checked
            }
        );

        if (checked) {

            if (!document.getElementById(
                "ID" + No_trans
            )) {

                add.insertAdjacentHTML(
                    'beforeend',
                    `<input
                        type="hidden"
                        id="ID${No_trans}"
                        name="checkedBOX[]"
                        value="${No_trans}">`
                );

                console.log(
                    'Hidden input dibuat:',
                    No_trans
                );
            }

        } else {

            $('#ID' + No_trans)
                .remove();

            console.log(
                'Hidden input dihapus:',
                No_trans
            );
        }

        console.log(
            'checkedBOX sekarang:',
            $('input[name="checkedBOX[]"]')
                .map(function () {
                    return $(this).val();
                }).get()
        );
    }

    // ==========================================
    // CHECKBOX ACC
    // ==========================================
    $(document).on(
        'change',
        '.check-row-acc',
        function () {

            const No_trans =
                $(this).data('no-trans');

            console.log(
                'ACC checkbox clicked:',
                No_trans
            );

            handleCheckbox(
                No_trans,
                this.checked
            );
        }
    );

    // ==========================================
    // CHECKBOX BATAL
    // ==========================================
    $(document).on(
        'change',
        '.check-row-batal',
        function () {

            const No_trans =
                $(this).data('no-trans');

            console.log(
                'BATAL checkbox clicked:',
                No_trans
            );

            handleCheckbox(
                No_trans,
                this.checked
            );
        }
    );

    // ==========================================
    // CHECK ALL ACC
    // ==========================================
    $('#CheckedAllACC').on(
        'change',
        function () {

            console.log(
                'CheckedAllACC:',
                this.checked
            );

            const rows =
                tableApprove.rows({
                    search: 'applied'
                }).nodes();

            $('input.check-row-acc', rows)
                .prop(
                    'checked',
                    this.checked
                )
                .trigger('change');
        }
    );

    // ==========================================
    // CHECK ALL BATAL
    // ==========================================
    $('#CheckedAllBATAL').on(
        'change',
        function () {

            console.log(
                'CheckedAllBATAL:',
                this.checked
            );

            const rows =
                tableBatal.rows({
                    search: 'applied'
                }).nodes();

            $('input.check-row-batal', rows)
                .prop(
                    'checked',
                    this.checked
                )
                .trigger('change');
        }
    );

    // ==========================================
    // BUTTON ACC
    // ==========================================
    $('#btnProses').on(
        'click',
        function () {

            console.log(
                '=== ACC_PERMOHONAN ==='
            );

            console.log(
                'checkedBOX:',
                $('input[name="checkedBOX[]"]')
                    .map(function () {
                        return $(this).val();
                    }).get()
            );
        }
    );

    // ==========================================
    // BUTTON BATAL
    // ==========================================
    $('#btnProsesBatal').on(
        'click',
        function () {

            console.log(
                '=== BATAL_ACC ==='
            );

            console.log(
                'checkedBOX:',
                $('input[name="checkedBOX[]"]')
                    .map(function () {
                        return $(this).val();
                    }).get()
            );
        }
    );

    // ==========================================
    // FILTER STATUS
    // ==========================================
    $('#filterStatus').on(
        'change',
        function () {

            const value =
                $(this).val();

            console.log(
                'filterStatus:',
                value
            );

            if (value === 'ACC') {

                $('#tableACCWrapper')
                    .show();

                $('#tableBatalWrapper')
                    .hide();

                $('#footerACC')
                    .show();

                $('#footerBatal')
                    .hide();

                tableApprove
                    .columns
                    .adjust()
                    .draw();

            } else {

                $('#tableACCWrapper')
                    .hide();

                $('#tableBatalWrapper')
                    .show();

                $('#footerACC')
                    .hide();

                $('#footerBatal')
                    .show();

                tableBatal
                    .columns
                    .adjust()
                    .draw();
            }
        }
    );

});
