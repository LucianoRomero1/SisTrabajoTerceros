
window.onload = function(){ 
    setDateTime();
    
    // let codDepo     = document.getElementsByClassName("codDeposito");  
    let inputDepo   = document.getElementsByClassName("inputDepo");   
    let url         = "ajaxDeposito";
    let fd          = new FormData();
    // fd.append('codDeposito' , codDepo[0].value);

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

function setDate(fechas, anio, mes, dia){
    for (let index = 0; index < fechas.length; index++) {
        fechas[index].value = anio+"-"+mes+"-"+dia;
    }
}

function setDateTime(){
    var now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    let fechas = document.getElementsByClassName('fechaActual');
    for (let index = 0; index < fechas.length; index++) {
        fechas[index].value = now.toISOString().slice(0,16);
    }
}



