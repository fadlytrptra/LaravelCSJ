$(function () {
  $('.EditUser').on('click', function (e) {
    e.preventDefault();
    document.getElementById("judul").innerHTML=$(this).data('nama')+" - "+$(this).data('user')

    //get url dari href
    var $url=$(this).attr('href');
    $(".formEditUser").attr('action',"");
    var action = $('.formEditUser').attr('action');
    $('.formEditUser').attr('action', action.replace("",""+$url+""));
    $('#EditUser').modal({ backdrop: 'static', keyboard: false })
  });
});

$(function () {
  $('.EditAdmin').on('click', function (e) {
    e.preventDefault();
    document.getElementById("textPertanyaan").innerHTML="Anda yakin untuk mengganti "+$(this).data('nama')+" - "+$(this).data('user')+"Sebagai "+$(this).data('status')+"?";
     var $url=$(this).attr('href');
    $('#EditAdmin').modal({ backdrop: 'static', keyboard: false })
        .on('click', '#delete-btn', function(){
            window.open($url, '_self');
        });
  });
});