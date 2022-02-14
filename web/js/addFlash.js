function ocultar(div){
    $("." + div).slideToggle(200);
}

setTimeout(function() {
    $('.alert-correcto').slideToggle(200);
}, 5000);
  
setTimeout(function() {
    $('.alert-error').slideToggle(200);
}, 5000);
  