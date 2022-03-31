
function myFunction(e) {
    if(e.target.value != 0){
        document.getElementById("idProceso").value          = e.target.value;
        document.getElementById("actions").style.display    = "block";
    }
    else{
        document.getElementById("idProceso").value          = "";
        document.getElementById("actions").style.display    = "none";
    }
}

function getValueSelect(){
    let para  = document.getElementsByClassName("para");
    let value = document.getElementById("caracteristica").value;

    let stringValue = switchValue(value);
    switchOption(para, stringValue);
}

function switchValue(value){
    let stringValue;
    switch(value){
        case "1":
            stringValue = "Nitrurar";
            break;
        case "2":
            stringValue = "PVD - Nitruro de Cromo";
            break;
        case "3":
            stringValue = "Mecanizado final";
            break;
        case "4":
            stringValue = "Forja - Tratamiento térmico";
            break;
        case "5":
            stringValue = "Huecas a perforar";

    }

    return stringValue;
}

function switchOption(para, stringValue){
    for (let index = 0; index < para.length; index++) {
        para[index].value = stringValue;
    }
}

window.onload = function(){
    var fecha = new Date(); //Fecha actual
    var mes = fecha.getMonth()+1; //obteniendo mes
    var dia = fecha.getDate(); //obteniendo dia
    var anio = fecha.getFullYear(); //obteniendo año
    if(dia<10)
      dia='0'+dia; //agrega cero si el menor de 10
    if(mes<10)
      mes='0'+mes //agrega cero si el menor de 10
    
    let fechas = document.getElementsByClassName('fechaActual');
    setDate(fechas, anio, mes, dia);

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

function setDate(fechas, anio, mes, dia){
    for (let index = 0; index < fechas.length; index++) {
        fechas[index].value = anio+"-"+mes+"-"+dia;
    }
}



