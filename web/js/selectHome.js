
function myFunction(e) {
    if(e.target.value != 0){
        document.getElementById("idProceso").value          = e.target.value;
        document.getElementById("actions").style.display    = "block";
    }
    else{
            document.getElementById("actions").style.display    = "none";
    }
}
