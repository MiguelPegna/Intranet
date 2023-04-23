$(document).click(function() {
    $("#close").click(function(){
        $('.pop-up').removeClass('show');
        $('.pop-up-wrap').removeClass('show');
    });  
 });

function boton1(){
    $('.pop-up').addClass('show');
    $('.pop-up-wrap').addClass('show');
}

//boton2
$(document).click(function() {
    $("#close2").click(function(){
        $('.pop-up2').removeClass('show2');
        $('.pop-up-wrap2').removeClass('show2');
    });  
 });

function boton2(){
    $('.pop-up2').addClass('show2');
    $('.pop-up-wrap2').addClass('show2');
}

//boton3
$(document).click(function() {
    $("#close3").click(function(){
        $('.pop-up3').removeClass('show3');
        $('.pop-up-wrap3').removeClass('show3');
    });  
 });

function boton3(){
    $('.pop-up3').addClass('show3');
    $('.pop-up-wrap3').addClass('show3');
}