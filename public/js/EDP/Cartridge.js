//untuk membuka modal add device
$(function () {
    $('.AddCartridge').on('click', function (e) {
      e.preventDefault();
      $('#AddCartridge').modal({ backdrop: 'static', keyboard: false })
    });
  });

  $(function () {
    $('.EditCartridge').on('click', function (e) {
      e.preventDefault();
      $("#judulEditCatridge").html($(this).data('number'));
      $("#userEdit").val($(this).data('user'));
      $("#typeEdit").val($(this).data('type'));
      var $url=$(this).attr('href');
      $(".formEditService").attr('action',"");
      var action = $('.formEditService').attr('action');
      $('.formEditService').attr('action', action.replace("",""+$url+""));
      $('#EditCartridge').modal({ backdrop: 'static', keyboard: false })
    });
  });

