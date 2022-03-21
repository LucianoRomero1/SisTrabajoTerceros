function changeValue(){
    let idDepo = document.getElementById("codDeposito").value;
    let depo = document.getElementById("descripcionDepo");
    console.log(idDepo);
    switch(idDepo){
        case "100":
            depo.value = "(MP) PRODUCCION";
            break;
        case "102":
            depo.value = "(MP) INSP. FINAL";
            break;
        case "103":
            depo.value = "(3B) PRODUCCION";
            break;
        case "201":
            depo.value = "(P.I) PARQUE INS FINAL";
            break;
        case "202":
            depo.value = "(3B) INSPECCIÓN FINAL";
            break;
        case "301":
            depo.value = "(P.I) PRODUCCION";
            break;
    }     
}