$(function () {
    $('.AddNota').on('click', function (e) {
      e.preventDefault();
      $('#AddNota').modal({ backdrop: 'static', keyboard: false })
    });
  });

  $(function () {
    $('.EditNota').on('click', function (e) {
      e.preventDefault();
      $('#EditNota').modal({ backdrop: 'static', keyboard: false })
    });
  });

  $(function () {
    $('.AddService').on('click', function (e) {
      e.preventDefault();
      $('#AddService').modal({ backdrop: 'static', keyboard: false })
    });
  });

  $(function () {
    $('.DetailRefill').on('click', function (e) {
      e.preventDefault();
      $.ajax({
        url: window.location.origin+"/PerbaikanCartridge/"+$(this).data('id')+"/DetailRefill",
        type: 'get',
        data: '_token = <?php echo csrf_token() ?>', // Remember that you need to have your csrf token included
        success: function( data ){
            var table = $('#TabelDetailRefill').DataTable();
            table.clear().draw();
            for(let i=0; i<data.item.length; i++)
            {
                table.row.add( [
                    data.item[i].Type,
                    data.item[i].perbaikan,
                    data.item[i].total,
                ] ).draw();
            }
            console.log('yay');
        },
        error: function(xhr, status, error){
            var err = eval("(" + xhr.responseText + ")");
            alert(err.Message);
        }
    });

      $('#DetailRefill').modal({ backdrop: 'static', keyboard: false })
    });
  });
