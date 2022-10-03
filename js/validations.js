const inputLatitud = document.querySelector('#txtLatitud');
const inputLongitud = document.querySelector('#txtLongitud');
const ubicacion = document.querySelector('#ubicacion');

inputLatitud.addEventListener('click', function(){
    inputLatitud.focus();
    document.execCommand('selectAll');
    document.execCommand('copy');
    alertify.success("Latitud fue copiada!");
})

inputLongitud.addEventListener('click', function(){
    inputLongitud.focus();
    document.execCommand('selectAll');
    document.execCommand('copy');
    alertify.success("Longitud fue copiada!");
})

ubicacion.addEventListener('click', function(){
    ubicacion.focus();
    document.execCommand('selectAll');
    document.execCommand('copy');
    alertify.success("La ubicación fue copiada!");
})