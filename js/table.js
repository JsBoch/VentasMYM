// function putData() {
//     let cuerpoTabla = document.getElementById("cuerpo");
//     // obtener inputs
//     var codigo = document.getElementById("codigo");
//     var producto = document.getElementById("producto");
//     var cantidad = document.getElementById("cantidad");
//     var tipoPrecio = document.getElementById("tipo_precio");
//     var precio = document.getElementById("precio");
//     var subTotal = document.getElementById("subtotal");
//     var obsProducto = document.getElementById("observaciones_producto");

//     // llenar tabla
//     let fila = document.createElement('tr');
//     let cod = document.createElement('td');
//     cod.innerHTML = codigo.value;
//     let pro = document.createElement('td');
//     pro.innerHTML = producto.value;
//     let can = document.createElement('td');
//     can.innerHTML = cantidad.value;
//     let tPre = document.createElement('td');
//     tPre.innerHTML = tipoPrecio.value;
//     let pre = document.createElement('td');
//     pre.innerHTML = precio.value;
//     let sTo = document.createElement('td');
//     sTo.innerHTML = subTotal.value;
//     let obP = document.createElement('td');
//     obP.innerHTML = obsProducto.value;




//     fila.appendChild(cod);
//     fila.appendChild(pro);
//     fila.appendChild(can);
//     fila.appendChild(tPre);
//     fila.appendChild(pre);
//     fila.appendChild(sTo);
//     fila.appendChild(obP);
//     cuerpoTabla.appendChild(fila);

//     // limpiar inputs
//     codigo.value = "";
//     producto.value = "";
//     cantidad.value = "";
//     tipoPrecio.value = "";
//     precio.value = "";
//     subTotal.value = "";
//     obsProducto.value = "";

// }

function seeOrder(formulario) {
    var formulario = document.getElementById(formulario);
    var contenderoTabal = document.getElementById('main-container');
    var agregarAlPedido = document.getElementById("shopping_cart");
    var enviarPedido = document.getElementById("send_order");
    var fechas = document.getElementById("subContainerDates");
    //console.log(formulario);
    formulario.style.display = "none";
    contenderoTabal.style.display = "block";
    agregarAlPedido.style.display = "block";
    enviarPedido.style.display = "block";
    contenderoTabal.style.width = "100%";
    contenderoTabal.style.margin = "0";
    fechas.style.display = "none";
}

function backToOrders(formulario) {
    var formulario = document.getElementById(formulario);
    var contenderoTabal = document.getElementById('main-container');
    var agregarAlPedido = document.getElementById("shopping_cart");
    var enviarPedido = document.getElementById("send_order");
    var fechas = document.getElementById("subContainerDates");

    formulario.style.display = "block";
    contenderoTabal.style.display = "none";
    agregarAlPedido.style.display = "none";
    enviarPedido.style.display = "none";
    fechas.style.display = "block";
}