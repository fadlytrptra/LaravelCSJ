jQuery(function ($) {

    let intercomData = [];

    $(document).ready(function(){
        $('#modalIntercom').on('shown.bs.modal', function(){
            loadIntercom();
        });

        $('#searchIntercom').on('keyup', function(){
            let keyword = $(this).val().toLowerCase();
            filterIntercom(keyword);
        });

         // reset saat modal ditutup
        $('#modalIntercom').on('hidden.bs.modal', function(){
            $('#searchIntercom').val('');
            renderTable(intercomData);
        });
    });

    function loadIntercom(){
        $.ajax({
            url: '/intercom',
            type: 'GET',
            dataType: 'json',

            success: function(res){
                intercomData = res;
                renderTable(intercomData);
            },

            error: function(){
                $('#intercomBody').html(`
                    <tr>
                        <td colspan="4" class="text-center text-danger">
                            Gagal mengambil data intercom
                        </td>
                    </tr>
                `);
            }
        });
    }

    function renderTable(data){
        let html = '';

        data.forEach(function(item){
            html += `
                <tr>
                    <td><b>${item.NO_EXT}</b></td>
                    <td>${item.DIVISI}</td>
                    <td>${item.NM_USER}</td>
                </tr>
            `;

        });

        if(html === ''){
            html = `
            <tr>
                <td colspan="4" class="text-center text-muted">
                    Data tidak ditemukan
                </td>
            </tr>
            `;
        }

        $('#intercomBody').html(html);

    }

    function filterIntercom(keyword){
        let filtered = intercomData.filter(function(item){
            return (
                item.NM_USER.toLowerCase().includes(keyword) ||
                item.DIVISI.toLowerCase().includes(keyword) ||
                String(item.NO_EXT).toLowerCase().includes(keyword)
            );
        });

        renderTable(filtered);
    }

});
