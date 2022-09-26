var listaDetalle = new Array();

function cargarDetalle() {
  let codigo = document.getElementById("codigo").value;
  let producto = document.getElementById("producto").value;
  let cantidad = document.getElementById("cantidad").value;
  let objTipoPrecio = document.getElementById("tipo_precio");
  let selected = objTipoPrecio.options[objTipoPrecio.selectedIndex].text;
  let arrSplit = selected.split("-");
  let tipoPrecio = arrSplit[0];

  let precio = document.getElementById("precio").value;
  let subtotal = document.getElementById("subtotal").value;
  let observacionesProducto = document.getElementById(
    "observaciones_producto"
  ).value;

 if (precio.toString().length == 0 || precio == 0 || cantidad.toString().length || cantidad == 0) {
    colocarPrecio();
    CalculoSubtotal();
 }

 precio = document.getElementById("precio").value;
 subtotal = document.getElementById("subtotal").value;

  var jsonString = {
    codigo_producto: codigo,
    nombre_producto: producto,
    cantidad: cantidad,
    tipoprecio: tipoPrecio,
    precio: precio,
    subtotal: subtotal,
    observaciones: observacionesProducto,
  };

  listaDetalle.push(jsonString);
  // console.log(item);

    let item = codigo + " - Cnt. " + cantidad + ' - Prc.' + precio + ' - Sbt.' + subtotal + ' - ' + producto;
    var $select = $('#listado');
    $select.append('<option value=' + codigo + '>' + item + '</option>');
    //console.log(listaDetalle);

    /*var detalle = [{
         "codigo_producto": "MF-315-K",
         "nombre_producto": "PRODUCTO DE PRUEBA MF",
         "cantidad": 2,
         "tipoprecio": "venta",
         "precio": 23.30,
         "subtotal": 46.60,
         "observaciones": "primer registro de prueba"
     },
     {
         "codigo_producto": "MF-135-K",
         "nombre_producto": "PRODUCTO DOS MF",
         "cantidad": 3,
         "tipoprecio": "venta",
         "precio": 50.00,
         "subtotal": 150.00,
         "observaciones": "segundo registro de prueba"
     }];*/

  /**
   * Se carga el listado de clientes
   */
  document.getElementById("codigo").value = "";
  document.getElementById("producto").value = "";
  document.getElementById("cantidad").value = "";
  document.getElementById("tipo_precio").value = "";
  document.getElementById("precio").value = "";
  document.getElementById("subtotal").value = "";
  document.getElementById("observaciones_producto").value = "";
}

function GuardarRegistro() {
  let clienteSelect = document.getElementById("cliente");
  let clienteId = clienteSelect.dataset.id;

  if(clienteId == 0)
  {
    alert("Debe ingresar cliente.");
    clienteSelect.focus();
    return;
  }
  let departamentoId = document.getElementById("departamento").value;
  let observaciones = document.getElementById("observaciones").value;
  var contenderoTabal = document.getElementById("main-container");
  var agregarAlPedido = document.getElementById("shopping_cart");
  var enviarPedido = document.getElementById("send_order");
  var fechas = document.getElementById("subContainerDates");

  var principal = new Array();
  //var detalle = [];

  principal.push({
    id_cliente: clienteId,
    id_departamento: departamentoId,
    observaciones: observaciones,
  });

  var data1 = JSON.stringify(principal);
  var data2 = JSON.stringify(listaDetalle);

  $.ajax({
    url: "../data/registro_pedido.php",
    // dataType: 'json',
    type: "post",
    data: {
      registro_principal: data1,
      detalle_registro: data2,
      id_solicitud: 0,
    },
    success: function (object) {
      // console.log(object);
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("Status: " + textStatus);
      console.log("Error: " + errorThrown);
    },
  });
  let clienteRegistro = document.getElementById("cliente");
  clienteRegistro.value = "";
  clienteRegistro.dataset.id = 0;
  document.getElementById("observaciones").value = "";
  document.getElementById("codigo").value = "";
  document.getElementById("producto").value = "";
  document.getElementById("cantidad").value = "";
  document.getElementById("tipo_precio").value = "";
  document.getElementById("precio").value = "";
  document.getElementById("subtotal").value = "";
  document.getElementById("observaciones_producto").value = "";
  let $selectListado = $("#listado");
  $selectListado.empty();
  listaDetalle = new Array();
  if (agregarAlPedido.style.display == "block") {
    contenderoTabal.style.display = "none";
    agregarAlPedido.style.display = "none";
    enviarPedido.style.display = "none";
    fechas.style.display = "block";
  }

  alertify.success("Registro almacenado con exito");
}

function QuitarItemDeLista() {
  let objTipoPrecio = document.getElementById("listado");
  //let selected = objTipoPrecio.options[objTipoPrecio.selectedIndex].value;
  let selected = objTipoPrecio.selectedIndex;
  //console.log(selected);
  listaDetalle.splice(selected, 1);
  objTipoPrecio.remove(selected);
  //console.log(listaDetalle);
}
