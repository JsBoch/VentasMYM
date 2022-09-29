/**
 * Este código se establece para colocar un evento 
 * que intercepte el submit del formulario para poder ejecutar la función
 * ValidarFichaCliente, antes de ser enviado.
 */
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("customer_registration").addEventListener('submit', ValidarFichaCliente);
});
/**
 * Esta función verifica que se haya ingresado el nombre
 * del cliente, y ese mismo nombre lo coloca como razón social
 * para cuando sea lo mismo. Siempre el usuario podrá cambiar el 
 * valor del campo razon social.
 */
function EstablecerRazonSocial() {
    let nombreCliente = document.getElementById("nombre");
    let razonSocial = document.getElementById("razonsocial");

    if (nombreCliente.value.toString().length > 0) {
        razonSocial.value = nombreCliente.value;
    }

    let txtClienteId = document.getElementById("clienteId");
    let txtCodigo = document.getElementById("txtCodigo");
    txtClienteId.value = 0;
    txtCodigo.value = '';
}

function EstablecerRazonSocialConsulta() {
    let nombreCliente = document.getElementById("nombre");
    let razonSocial = document.getElementById("razonsocial");

    if (nombreCliente.value.toString().length > 0) {
        razonSocial.value = nombreCliente.value;
    }
}
/**
 * Esta función se utiliza para validar que la ficha de cliente
 * cumpla con el registro de los campos obligatorios antes 
 * de guardar.
 */
function ValidarFichaCliente(evento) {
    //este código detiene el evento submit 
    evento.preventDefault();
    let nit = document.getElementById("nit");
    let dpi = document.getElementById("dpi");
    let nombre = document.getElementById("nombre");
    let razonsocial = document.getElementById("razonsocial");
    let direccion = document.getElementById("direccion");
    let telefono = document.getElementById("telefono");
    let transporte = document.getElementById("transporte");

    if (nit.value.toString().length == 0 && dpi.value.toString().length == 0) {
        alertify.error("Debe ingresar nit o dpi.");
        nit.focus();
        return;
    } else if (nombre.value.toString().length == 0) {
        alertify.error("Debe ingresar el nombre del cliente.");
        nombre.focus();
        return;
    } else if (razonsocial.value.toString().length == 0) {
        alertify.error("Debe ingresar la razón social.");
        nombre.focus();
        return;
    }
    else if (direccion.value.toString().length == 0) {
        alertify.error("Debe ingresar la dirección.");
        direccion.focus();
        return;
    } else if (telefono.value.toString().length == 0) {
        alertify.error("Debe ingresar teléfono.");
        telefono.focus();
        return;
    } else if (transporte.value.toString().length == 0) {
        alertify.error("Debe ingresar transporte.");
        transporte.focus();
        return;
    }
    
    
    this.submit();
}

function ObtenerUbicacion() {
    /**
     * CÓDIGO PARA GEOLOCALIZACIÓN
     */
    /*if (navigator.geolocation) {
        var success = function (position) {
            var latitud = position.coords.latitude,
                longitud = position.coords.longitude;
            
                document.getElementById("txtLatitud").value = latitud;
                document.getElementById("txtLongitud").value = longitud;
        }
        navigator.geolocation.getCurrentPosition(success, function (msg) {
            console.error(msg);
        });

    }*/
    /*================================ */
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(muestraPosicion, errorPosicion);
    }        
}
function muestraPosicion(position){
    //alert('Te encuentras en las siguientes coordenadas: (' + position.coords.latitude + ', ' + position.coords.longitude + ')' );
    document.getElementById("txtLatitud").value = position.coords.latitude;
                document.getElementById("txtLongitud").value = position.coords.longitude        ;
  }
  
  function errorPosicion(err) {
      switch(err.code) {
          case err.PERMISSION_DENIED:
              alert("Debe permitir el acceso a su posición para que la aplicación pueda funcionar");
              break;
          case err.POSITION_UNAVAILABLE:
              alert("La información sobre su posición actual no está disponible");
              break;
          case err.TIMEOUT:
              alert("No se ha podido obtener su posición en un tiempo razonable");
              break;
          default:
              alert("Se ha producido un error desconocido al intentar obtener la posición actual");
              break;
      }
  }
/**
 * Esta función carga el listado por defecto de las regiones 
 * asociadas a la ubicación de un cliente. Es para los formularios de registro
 * y consulta de clientes.
 */
function listaRegiones()
{
    var $sltRegion = $('#region');    
    $sltRegion.append('<option value="REGION 1">REGION 1</option>');
    $sltRegion.append('<option value="REGION 2">REGION 2</option>');
    $sltRegion.append('<option value="REGION 3">REGION 3</option>');
    $sltRegion.append('<option value="REGION 4">REGION 4</option>');
}