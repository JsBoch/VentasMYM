function CalculoSubtotal() {
    let precio = document.getElementById("precio").value;
    let cantidad = document.getElementById("cantidad").value;
    let precioMasBajo = document.getElementById("precioMasBajo").value;

    if (parseFloat(precio.toString()) > parseFloat(precioMasBajo.toString())) {        
        let subtotal = 0;
        if (precio.length > 0 && cantidad.length > 0) {
            subtotal = precio * cantidad;
        }

        document.getElementById("subtotal").value = subtotal;
    } else {
        //mensaje de precio mas bajo        
        alertify.error("El precio es más bajo de lo autorizado");
        document.getElementById("precio").value = precioMasBajo;
        let subtotal = 0;
        if (precioMasBajo.length > 0 && cantidad.length > 0) {
            subtotal = precioMasBajo * cantidad;
        }

        document.getElementById("subtotal").value = subtotal;
    }
}