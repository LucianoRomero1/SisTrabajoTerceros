function backPage(tipoCaracteristica){
    if(tipoCaracteristica === undefined){
        window.location.href = '../afterHomePage?id='+ 1;
    }else{
        window.location.href = '../afterHomePage?id='+ tipoCaracteristica;
    }
    
}

function backPageStock(tipoCaracteristica){
    window.location.href = 'afterHomePage?id='+ tipoCaracteristica;
}