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