function getDeposito(from) {
    let array_depo  = switchModalDepo(from);
    let fd          = new FormData();
    fd.append('codDeposito' , array_depo[1]);

    $.ajax({
        url     :   "ajaxDeposito",
        type    :   'POST',
        data    :   fd,
        processData: false,
        contentType: false,

        success: function(res){
            if(res.result == "OK"){
                array_depo[0].value = res.info;
            }
            else{
                array_depo[0].value = res.info;
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'El código de depósito que busca no existe',
                })
            }
            
        }
    })
}

function getProveedor(from) {
    let array_prov  = switchModalProv(from);
    let fd              = new FormData();
    fd.append('codProveedor' , array_prov[1]);

    $.ajax({
        url     :   "ajaxProveedor",
        type    :   'POST',
        data    :   fd,
        processData: false,
        contentType: false,

        success: function(res){
            if(res.result == "OK"){
                array_prov[0].value = res.info;
            }
            else{
                array_prov[0].value = res.info;
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'El código de proveedor que busca no existe',
                })
            }
            
        }
    })
}

function getValvula(from) {
    let array_valvula  = switchModalValvula(from);
    let fd             = new FormData();
    fd.append('codDesvio' , array_valvula[0]);
    fd.append('nroPartida' , array_valvula[1]);

    $.ajax({
        url     :   "ajaxValvula",
        type    :   'POST',
        data    :   fd,
        processData: false,
        contentType: false,

        success: function(res){
            if(res.result == "OK"){
                array_valvula[2].value = res.info;
            }
            else{
                array_valvula[2].value = res.info;
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'La válvula que busca no existe',
                })
            }
            
        }
    })
}

function switchModalDepo(from){
    var inputDepo;
    var codDeposito;
    switch(from){
        case "envio":
            inputDepo   = document.getElementById("descripcionDepo_1");  
            codDeposito = document.getElementById("codDeposito_1").value;
            break;
        case "recepcion":
            inputDepo   = document.getElementById("descripcionDepo_2");  
            codDeposito = document.getElementById("codDeposito_2").value;
            break;
        case "devolucion":
            inputDepo   = document.getElementById("descripcionDepo_3");  
            codDeposito = document.getElementById("codDeposito_3").value;
            break;
        case "reingreso":
            inputDepo   = document.getElementById("descripcionDepo_4");  
            codDeposito = document.getElementById("codDeposito_4").value;
            break;
    }

    array = [];
    array.push(inputDepo);
    array.push(codDeposito);

    return array;
}

function switchModalProv(from){
    var inputProv;
    var codProveedor;
    switch(from){
        case "envio":
            inputProv   = document.getElementById("descripcionProv_1");  
            codProveedor = document.getElementById("codProveedor_1").value;
            break;
        case "recepcion":
            inputProv   = document.getElementById("descripcionProv_2");  
            codProveedor = document.getElementById("codProveedor_2").value;
            break;
        case "devolucion":
            inputProv   = document.getElementById("descripcionProv_3");  
            codProveedor = document.getElementById("codProveedor_3").value;
            break;
        case "reingreso":
            inputProv   = document.getElementById("descripcionProv_4");  
            codProveedor = document.getElementById("codProveedor_4").value;
            break;
    }

    array = [];
    array.push(inputProv);
    array.push(codProveedor);

    return array;
}

function switchModalValvula(from){
    var codDesvio;
    var nroPartida;
    var inputValvula;
    switch(from){
        case "envio":
            codDesvio      = document.getElementById("codDesvio_1").value;
            nroPartida     = document.getElementById("nroPartida_1").value;
            inputValvula   = document.getElementById("valvula_1");
            break;
        case "recepcion":
            codDesvio      = document.getElementById("codDesvio_2").value;
            nroPartida     = document.getElementById("nroPartida_2").value;
            inputValvula   = document.getElementById("valvula_2");
            break;
        case "devolucion":
            codDesvio      = document.getElementById("codDesvio_3").value;
            nroPartida     = document.getElementById("nroPartida_3").value;
            inputValvula   = document.getElementById("valvula_3");
            break;
        case "reingreso":
            codDesvio      = document.getElementById("codDesvio_4").value;
            nroPartida     = document.getElementById("nroPartida_4").value;
            inputValvula   = document.getElementById("valvula_4");
            break;
    }

    array = [];
    array.push(codDesvio, nroPartida, inputValvula);

    return array;
}