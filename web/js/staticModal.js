$('#modalClose').modal({
    show: false,
    keyboard: false,
    backdrop: 'static',
    reset: true
});

$('.modal-reset').on('hidden.bs.modal', function(){
    $(this).find('form')[0].reset();
    // var fecha = new Date(); //Fecha actual
    // var mes = fecha.getMonth()+1; //obteniendo mes
    // var dia = fecha.getDate(); //obteniendo dia
    // var anio = fecha.getFullYear(); //obteniendo año
    // if(dia<10)
    //   dia='0'+dia; //agrega cero si el menor de 10
    // if(mes<10)
    //   mes='0'+mes //agrega cero si el menor de 10
    
    // let fechas = document.getElementsByClassName('fechaActual');
    //setDate(fechas, anio, mes, dia);
    setDateTime();
});

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

