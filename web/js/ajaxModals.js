

function getValueDepo(){
    let codDepo     = document.getElementsByClassName("codDeposito");   
    let inputDepo  = document.getElementsByClassName("inputDepo");   
    let url         = "ajaxDeposito";
    let fd          = new FormData();
    fd.append('codDeposito' , codDepo[0].value);

    $.ajax({
        url     :   url,
        type    :   'POST',
        data    :   fd,
        processData: false,
        contentType: false,

        success: function(res){
            if(res.result == "OK"){
                for(var i = 0; i < inputDepo.length; i++){
                    inputDepo[i].value = res.info
                }
            }        
        }
    })
}


function getDeposito(from) {
    let array_depo  = switchModalDepo(from);
    let url         = "";
    let fd          = new FormData();
    fd.append('codDeposito' , array_depo[1]);

    if(from != "edit"){
        url = "ajaxDeposito";
    }
    else{
        url = "../../ajaxDeposito"
    }

    $.ajax({
        url     :   url,
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
    let url         = "";
    let fd              = new FormData();
    fd.append('codProveedor' , array_prov[1]);

    if(from != "edit"){
        url = "ajaxProveedor";
    }
    else{
        url = "../../ajaxProveedor"
    }

    $.ajax({
        url     :   url,
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
    let array_valvula       = switchModalValvula(from);
    let url                 = "";
    let retrabajar          = getAretrabajar(from);
    let caracteristica      = document.getElementsByClassName("para");
    let cantidadLimite      = document.getElementsByClassName("cantidad");
    let cantidadInicial     = document.getElementsByClassName("cantidadInicial");
    let sinTerminadoPunta   = document.getElementsByClassName("sinTerminadoPunta");
    let fd                  = new FormData();
    fd.append('codDesvio' , array_valvula[0]);
    fd.append('nroPartida' , array_valvula[1]);
    fd.append('tipo' , from);
    fd.append('caracteristica' , caracteristica[0].value);
    fd.append('retrabajar' , retrabajar.checked);

    if(from != "edit"){
        url = "ajaxValvula";
    }
    else{
        url = "../../ajaxValvula"
    }


    $.ajax({
        url     :   url,
        type    :   'POST',
        data    :   fd,
        processData: false,
        contentType: false,

        success: function(res){
            if(res.result == "OK"){
                array_valvula[2].value = res.info[0];
                // for(let i = 0; i <= cantidadLimite.length; i++){
                //     cantidadLimite[i].setAttribute("max", res.info[1]);
                //     cantidadLimite[i].value = res.info[1];
                //     if(i < 4){
                //         cantidadInicial[i].value = res.info[2];
                //     }
                // }
                setCantidad(from, cantidadInicial, cantidadLimite, sinTerminadoPunta, res);
                if(retrabajar.checked == true){
                    removeMaxARetrabajar(from);
                }
                
            }
            else{
                disabledButtonGuardar();
                array_valvula[2].value = res.info;
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: res.error,
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
        case "edit":
            inputDepo   = document.getElementById("descripcionDepo");  
            codDeposito = document.getElementById("codDeposito").value;
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
        case "edit":
            inputDepo   = document.getElementById("descripcionDepo");  
            codDeposito = document.getElementById("codDeposito").value;
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
        case "edit":
            codDesvio      = document.getElementById("codDesvio").value;
            nroPartida     = document.getElementById("nroPartida").value;
            inputValvula   = document.getElementById("valvula");
            break;
    }

    array = [];
    array.push(codDesvio, nroPartida, inputValvula);

    return array;
}

var maxValue = [];

function setCantidad(from, cantidadInicial, cantidadLimite, sinTerminadoPunta, res){
    switch(from){
        case "envio":
            cantidadLimite[0].value = res.info[1]; //este es el campo saldos
            cantidadLimite[1].value = res.info[1]; //este es el campo cantidad
            cantidadLimite[1].setAttribute("max", Math.floor(res.info[1] * 1.05));
            maxValue.push(Math.floor(res.info[1] * 1.05));
            cantidadInicial[0].value = res.info[2];
            document.querySelector('#buttonEnvio').disabled = false;
            if(res.info[3] != 0){
                sinTerminadoPunta[0].checked = true;
            }
            else{
                sinTerminadoPunta[0].checked = false;
            }
            break;
        case "recepcion":
            cantidadLimite[2].value = res.info[1]; //este es el campo saldos
            cantidadLimite[3].value = res.info[1]; //este es el campo cantidad
            cantidadLimite[3].setAttribute("max", Math.floor(res.info[1] * 1.05));
            maxValue.push(Math.floor(res.info[1] * 1.05));
            cantidadInicial[1].value = res.info[2];
            document.querySelector('#buttonRecepcion').disabled = false;
            if(res.info[3] != 0){
                sinTerminadoPunta[1].checked = true;
            }
            else{
                sinTerminadoPunta[1].checked = false;
            }
            break;
        case "reingreso":
            cantidadLimite[4].value = res.info[1]; //este es el campo saldos
            cantidadLimite[5].value = res.info[1]; //este es el campo cantidad
            cantidadLimite[5].setAttribute("max", Math.floor(res.info[1] * 1.05));
            maxValue.push(Math.floor(res.info[1] * 1.05));
            cantidadInicial[2].value = res.info[2];
            document.querySelector('#buttonReingreso').disabled = false;
            if(res.info[3] != 0){
                sinTerminadoPunta[2].checked = true;
            }
            else{
                sinTerminadoPunta[2].checked = false;
            }
            break;
        case "devolucion":
            cantidadLimite[6].value = res.info[1]; //este es el campo saldos
            cantidadLimite[7].value = res.info[1]; //este es el campo cantidad
            cantidadLimite[7].setAttribute("max", Math.floor(res.info[1] * 1.05));
            maxValue.push(Math.floor(res.info[1] * 1.05));
            cantidadInicial[3].value = res.info[2];
            document.querySelector('#buttonDevolucion').disabled = false;
            if(res.info[3] != 0){
                sinTerminadoPunta[3].checked = true;
            }
            else{
                sinTerminadoPunta[3].checked = false;
            }
            break;
        
    }
}

function checkRetrabajar(from){
    var cantidad  = document.getElementsByClassName("cantidad");
    var checkBox  = "";
    switch(from){
        case "envio":
            checkBox = document.getElementById("check_envio");
            break;
        case "recepcion":
            checkBox = document.getElementById("check_recepcion");
            break;
        case "reingreso":
            checkBox = document.getElementById("check_reingreso");
            break;
        case "devolucion":
            checkBox = document.getElementById("check_devolucion");
            break;
    }
    if(checkBox.checked == true){
        switch(from){
            case "envio":
                cantidad[1].removeAttribute("max");
                break;
            case "recepcion":
                cantidad[3].removeAttribute("max");
                break;
            case "reingreso":
                cantidad[5].removeAttribute("max");
                break;
            case "devolucion":
                cantidad[7].removeAttribute("max");
                break;
        }
    }else{
        switch(from){
            case "envio":
                cantidad[1].setAttribute("max", maxValue[0]);
                break;
            case "recepcion":
                cantidad[3].setAttribute("max", maxValue[0]);
                break;
            case "reingreso":
                cantidad[5].setAttribute("max", maxValue[0]);
                break;
            case "devolucion":
                cantidad[7].setAttribute("max", maxValue[0]);
                break;
        }
    }
}

function disabledButtonGuardar(){
    document.querySelector('#buttonEnvio').disabled = true;
    document.querySelector('#buttonRecepcion').disabled = true;
    document.querySelector('#buttonReingreso').disabled = true;
    document.querySelector('#buttonDevolucion').disabled = true;
}

function getAretrabajar(from){
    var retrabajar  = "";
    switch(from){
        case "envio":
            retrabajar = document.getElementById("check_envio");
            break;
        case "recepcion":
            retrabajar = document.getElementById("check_recepcion");
            break;
        case "reingreso":
            retrabajar = document.getElementById("check_reingreso");
            break;
        case "devolucion":
            retrabajar = document.getElementById("check_devolucion");
            break;
    }

    return retrabajar;
}

function removeMaxARetrabajar(from){
    var cantidad  = document.getElementsByClassName("cantidad");
    switch(from){
        case "envio":
            cantidad[1].removeAttribute("max");
            break;
        case "recepcion":
            cantidad[3].removeAttribute("max");
            break;
        case "reingreso":
            cantidad[5].removeAttribute("max");
            break;
        case "devolucion":
            cantidad[7].removeAttribute("max");
            break;
    }
}
