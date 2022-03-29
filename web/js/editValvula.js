window.onload = function(){
    let caracteristica = document.getElementById("caracteristicaEditar");
    let stringValue = switchValue(caracteristica.value);
    caracteristica.value = stringValue;
}

function switchValue(caracteristica){
    let stringValue;
    switch(caracteristica){
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
