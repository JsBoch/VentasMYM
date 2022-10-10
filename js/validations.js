const ubicacion = document.querySelector('#ubicacion');

ubicacion.addEventListener('click', function(){
    let campo = document.getElementById('ubicacion');
    if (campo == "") {
        alertify.error("No hay ubicación");
    } else {
        ubicacion.focus();
        document.execCommand('selectAll');
        document.execCommand('copy');
        alertify.success("La ubicación fue copiada!");
    }    
})