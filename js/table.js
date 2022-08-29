function putData() {
    // obtener inputs
    var codigo = document.getElementById("codigo");
    var producto = document.getElementById("producto");
    var cantidad = document.getElementById("cantidad");
    var tipoPrecio = document.getElementById("tipo_precio");
    var precio = document.getElementById("precio");
    var subTotal = document.getElementById("subtotal");
    var obsProducto = document.getElementById("observaciones_producto");

    // obtener filas de tabla 
    var fila = document.createElement('tr');
    var colCode = document.createElement('td');
    var colNdp = document.createElement('td');
    var colCan = document.createElement('td');
    var colTdv = document.createElement('td');
    var colPre = document.createElement('td');
    var colSub = document.createElement('td');
    var colObs = document.createElement('td');
    colCode.innerHTML = codigo.value;
    colNdp.innerHTML = producto.value;
    colCan.innerHTML = cantidad.value;
    colTdv.innerHTML = tipoPrecio.value;
    colPre.innerHTML = precio.value;
    colSub.innerHTML = subTotal.value;
    colObs.innerHTML = obsProducto.value;
    fila.appendChild(colCode);
    fila.appendChild(colNdp);
    fila.appendChild(colCan);
    fila.appendChild(colTdv);
    fila.appendChild(colPre);
    fila.appendChild(colSub);
    fila.appendChild(colObs);

    document.getElementById("cuerpo").appendChild(file);


    codigo.value = "";
    producto.value = "";
    cantidad.value = "";
    tipoPrecio.value = "";
    precio.value = "";
    subTotal.value = "";
    obsProducto.value = "";

}

function seeOrder() {
    var formulario = document.getElementById('order_form');
    var contenderoTabal = document.getElementById('main-container');
    var altura = document.getElementById("tableHeight");
    var agregarAlPedido = document.getElementById("shopping_cart");
    var enviarPedido = document.getElementById("send_order");

    formulario.style.display = "none";
    contenderoTabal.style.display = "block";
    contenderoTabal.style.width = "100%";
    contenderoTabal.style.margin = "0";
    altura.style.height = "100vh"
    altura.style.marginBottom = "0";
    agregarAlPedido.style.display = "block";
    enviarPedido.style.display = "block";

}

function backToOrders() {
    var formulario = document.getElementById('order_form');
    var contenderoTabal = document.getElementById('main-container');
    var altura = document.getElementById("tableHeight");
    var agregarAlPedido = document.getElementById("shopping_cart");
    var enviarPedido = document.getElementById("send_order");

    formulario.style.display = "block";
    contenderoTabal.style.display = "none";
    agregarAlPedido.style.display = "none";
    enviarPedido.style.display = "none";
}