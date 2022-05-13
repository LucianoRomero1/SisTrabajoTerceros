window.onload = function() {

    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const id = urlParams.get('id')
    const idPara = urlParams.get('idPara');

    document.getElementById("idUrl").value = id;
    document.getElementById("idPara").value = idPara;
};