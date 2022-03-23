function getDeposito() {
    let inputDepo   = document.getElementById("descripcionDepo");
    let fd          = new FormData();
    let codDeposito = document.getElementById("codDeposito").value;
    fd.append('codDeposito' , codDeposito);

    $.ajax({
        url     :   "ajaxDeposito",
        type    :   'POST',
        data    :   fd,
        processData: false,
        contentType: false,

        success: function(res){
            if(res.result == "OK"){
                inputDepo.value = res.info;
            }
            else{
                inputDepo.value = res.info;
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'El código de depósito que busca no existe',
                })
            }
            
        }
    })
}

function getProveedor() {
    let inputProv       = document.getElementById("descripcionProv");
    let fd              = new FormData();
    let codProveedor    = document.getElementById("codProveedor").value;
    fd.append('codProveedor' , codProveedor);

    $.ajax({
        url     :   "ajaxProveedor",
        type    :   'POST',
        data    :   fd,
        processData: false,
        contentType: false,

        success: function(res){
            if(res.result == "OK"){
                inputProv.value = res.info;
            }
            else{
                inputProv.value = res.info;
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'El código de proveedor que busca no existe',
                })
            }
            
        }
    })
}

function getValvula() {
    let codDesvio      = document.getElementById("codDesvio").value;
    let nroPartida     = document.getElementById("nroPartida").value;
    let fd             = new FormData();
    let inputValvula   = document.getElementById("valvula");
    fd.append('codDesvio' , codDesvio);
    fd.append('nroPartida' , nroPartida);

    $.ajax({
        url     :   "ajaxValvula",
        type    :   'POST',
        data    :   fd,
        processData: false,
        contentType: false,

        success: function(res){
            if(res.result == "OK"){
                inputValvula.value = res.info;
            }
            else{
                inputValvula.value = res.info;
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'La válvula que busca no existe',
                })
            }
            
        }
    })
}