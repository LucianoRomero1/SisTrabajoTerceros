function setRole(username, rol){
    let url         = "setRole/"+username;
    let fd          = new FormData();
    fd.append('rol' , rol);
    fd.append('username' , username);

    $.ajax({
        url     :   url,
        type    :   'POST',
        data    :   fd,
        processData: false,
        contentType: false,

        success: function(res){
            if(res.result == "OK"){
                Swal.fire({
                    icon: 'success',
                    title: 'Correcto',
                    text: res.info,
                })
            }
            else{
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: res.error,
                })
            }        
        }
    })
}