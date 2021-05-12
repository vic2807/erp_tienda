$(document).ready(function () {
    
    $(window).focus(formInit(200));

    function formInit(time) {
        setTimeout(function () {
            $('.login-form-wrapper').addClass('showLogin');
        }, time);
    }
});

function toast() {

    if (typeof showToast === 'undefined' || showToast === null) {
        return;
    }
    swal({
        type: 'success',
        title: "Éxito",
        text: "Hemos enviando un correo de recuperación al correo ingresado",
        showConfirmButton: false,
        timer: 3500
    })
}


function showCover(){
    $("#div_cover").show();
}

function hideCover(){
    $("#div_cover").hide();
}


$( "#cover_close" ).on( "click", function(ev) {
    hideCover();
});