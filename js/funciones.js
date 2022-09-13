function CalculoSubtotal() {
    let precio = document.getElementById("precio").value;
    let cantidad = document.getElementById("cantidad").value;
    let subtotal = 0;
    if (precio.length > 0 && cantidad.length > 0) {
        subtotal = precio * cantidad;
    }

    document.getElementById("subtotal").value = subtotal;
}