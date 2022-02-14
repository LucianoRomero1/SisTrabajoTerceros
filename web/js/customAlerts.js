
function sweetAlert(route) {
    Swal.fire({
        title: '¿Está seguro/a que desea volver?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: "Cancelar",
        confirmButtonText: 'Aceptar'   
    }).then((result) => {
        if (result.isConfirmed) {
            if(route == "create"){
                window.location.href = 'view'
            }else{
                window.location.href = '../view'
            }
            
        }
    })
}

function sweetAlertDelete(id) {

    Swal.fire({
        title: '¿Está seguro/a que desea eliminar?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: "Cancelar",
        confirmButtonText: 'Aceptar'   
    }).then((result) => {
        if (result.isConfirmed) {
            
            let fd = new FormData();
            fd.append('id' , id);
            let url = id;
            $.ajax
            ({
                method: 'POST',
                url: url,
                data: fd,
                processData: false,
                contentType: false,

                success: function (res)
                {
                    if(res.success){
                        Swal.fire({
                            icon: 'success',
                            title: 'Se eliminó correctamente',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        setTimeout(function(){location.reload()}, 1500);
                    }
                    else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: '¡Algo salió mal!',
                        })
                    }
                }
            });
        }
    })
}

// function sweetAlertUndo(id) {

//     Swal.fire({
//         title: '¿Está seguro/a que desea deshacer el movimiento?',
//         icon: 'warning',
//         showCancelButton: true,
//         confirmButtonColor: '#3085d6',
//         cancelButtonColor: '#d33',
//         cancelButtonText: "Cancelar",
//         confirmButtonText: 'Aceptar'   
//     }).then((result) => {
//         if (result.isConfirmed) {
            
//             let fd = new FormData();
//             fd.append('id' , id);
//             let url = "undo/"+id;
//             $.ajax
//             ({
//                 method: 'POST',
//                 url: url,
//                 data: fd,
//                 processData: false,
//                 contentType: false,

//                 success: function (res)
//                 {
//                     if(res.success){
//                         Swal.fire({
//                             icon: 'success',
//                             title: 'Se deshizo correctamente',
//                             showConfirmButton: false,
//                             timer: 1500
//                         })
//                         setTimeout(function(){location.reload()}, 1500);
//                     }
//                     else{
//                         Swal.fire({
//                             icon: 'error',
//                             title: 'Oops...',
//                             text: '¡Algo salió mal!',
//                         })
//                     }
//                 }
//             });
//         }
//     })
// }

function closeModal(idModal){
    Swal.fire({
        title: '¿Está seguro/a que desea cancelar el registro?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: "Cancelar",
        confirmButtonText: 'Aceptar'   
    }).then((result) => {
        if (result.isConfirmed) {
            $(idModal).modal('hide');
        }
    })
}

