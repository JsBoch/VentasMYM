var clienteIdSeleccion = 0;
var solicitudId = 0;
var listaDetalle = new Array();

function GetDate() {
  let now = new Date();

  let day = ("0" + now.getDate()).slice(-2);
  let month = ("0" + (now.getMonth() + 1)).slice(-2);

  let today = now.getFullYear() + "-" + month + "-" + day;

  $("#fechaInicio").val(today);
  $("#fechaFinal").val(today);
}

function ConsultarPedidos() {
  let fechaInicio = $("#fechaInicio").val();
  let fechaFinal = $("#fechaFinal").val();
  fechaInicio = fechaInicio.toString().replace(/-/gi, "");
  fechaFinal = fechaFinal.replace(/-/gi, "");

  let datos = { fechaInicio: fechaInicio, fechaFinal: fechaFinal };
  $.ajax({
    url: "../data/lista_pedidos.php",
    dataType: "json",
    type: "post",
    data: datos,
    success: function (object) {
      let registro = "";
      var $selectPedidos = $("#listaPedidos");
      $selectPedidos.empty();
      $.each(object, function (i, pedido) {
        registro =
          "No." +
          pedido.nosolicitud +
          " Fecha: " +
          pedido.fecha_registro +
          " Cte. " +
          pedido.cliente +
          " Dpto. " +
          pedido.departamento +
          " estado: " +
          pedido.estado;
        $selectPedidos.append(
          "<option value=" + pedido.id_solicitud + ">" + registro + "</option>"
        );
      });
    },
  });

  //console.log('Date in GT: ' + fechaInicio + ' - ' + fechaFinal);
}

function ConsultaProductos() {
  let solicitudId = $("#listaPedidos").val();
  $.ajax({
    url: "../data/lista_productos_pedido.php",
    dataType: "json",
    type: "post",
    data: { id_solicitud: solicitudId },
    success: function (object) {
      let registro = "";
      var $selectProductos = $("#listaProductos");
      $selectProductos.empty();
      $.each(object, function (i, producto) {
        registro =
          "Cdg." +
          producto.codigo_producto +
          " Nom. " +
          producto.nombre_producto +
          " Cnt. " +
          producto.cantidad +
          " Prc. " +
          producto.precio +
          " Subtotal: " +
          producto.subtotal +
          " Obs." +
          producto.observaciones;
        $selectProductos.append(
          "<option value=" +
            producto.codigo_producto +
            ">" +
            registro +
            "</option>"
        );
      });
    },
  });
  //console.log(solicitudId);
}

function CargaPedidoEdit() {
  let departamento;
  let observaciones;
  var departamentoId;

  solicitudId = $("#listaPedidos").val();
  $.ajax({
    url: "../data/carga_pedido_edit.php",
    dataType: "json",
    type: "post",
    data: { id_solicitud: solicitudId },
    success: function (object) {
      departamentoId = object[0].id_departamento;
      clienteIdSeleccion = object[0].id_cliente;
      observaciones = object[0].observaciones;
      $("#observaciones").val(observaciones);
      $("#departamento").val(departamentoId);
      listaClientes();
      CargaProductosEdit(solicitudId);
    },
  });

  document.getElementById("departamento").focus();
}

function AsignarCliente() {
  $("#cliente").val(clienteIdSeleccion);
}

/**
 * Busca los registros (productos) asociados al pedido que se quiere editar.
 * @param {int} idsolicitud es el id del pedido consultado
 */
function CargaProductosEdit(idsolicitud) {
  $.ajax({
    url: "../data/carga_productos_edit.php",
    dataType: "json",
    type: "post",
    data: { id_solicitud: idsolicitud },
    success: function (object) {
      var $select = $("#listado");

      $select.empty();

      $.each(object, function (i, producto) {
        var jsonString = {
          codigo_producto: producto.codigo_producto,
          nombre_producto: producto.nombre_producto,
          cantidad: producto.cantidad,
          tipoprecio: producto.tipo_precio,
          precio: producto.precio,
          subtotal: producto.subtotal,
          observaciones: producto.observaciones,
        };

        listaDetalle.push(jsonString);
        let item =
          producto.codigo_producto +
          " - Cnt. " +
          producto.cantidad +
          " - Prc." +
          producto.precio +
          " - Sbt." +
          producto.subtotal +
          " - " +
          producto.nombre_producto;
        $select.append("<option value=" + codigo + ">" + item + "</option>");
      });
    },
  });
}

function GuardarNuevoRegistro() {
  let clienteId = document.getElementById("cliente").value;
  let departamentoId = document.getElementById("departamento").value;
  let observaciones = document.getElementById("observaciones").value;
  var formulario = document.getElementById("order_form");
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
      id_solicitud: solicitudId,
    },
    success: function (object) {
      console.log(object);
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("Status: " + textStatus);
      console.log("Error: " + errorThrown);
    },
  });
  let $selectLPedido = $("listaPedidos");
  $selectLPedido.empty();
  let $selectLProducto = $("listaProductos");
  $selectLProducto.empty();
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
    formulario.style.display = "block";
    contenderoTabal.style.display = "none";
    agregarAlPedido.style.display = "none";
    enviarPedido.style.display = "none";
    fechas.style.display = "block";
  }

  alertify.success("Registro almacenado con exito");
}

function QuitarItemDeListaEdit() {
  let objTipoPrecio = document.getElementById("listado");
  //let selected = objTipoPrecio.options[objTipoPrecio.selectedIndex].value;
  let selected = objTipoPrecio.selectedIndex;
  //console.log(selected);
  listaDetalle.splice(selected, 1);
  objTipoPrecio.remove(selected);
  //console.log(listaDetalle);
}

/**
 * Está función crea al array de objetos JSON
 * que conforman el registro de un pedido, por cada
 * producto que el usuario agrega a la lista.
 */
function cargarDetalleEdit() {
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

  let item =
    codigo +
    " - Cnt. " +
    cantidad +
    " - Prc." +
    precio +
    " - Sbt." +
    subtotal +
    " - " +
    producto;
  var $select = $("#listado");
  $select.append("<option value=" + codigo + ">" + item + "</option>");

  document.getElementById("codigo").value = "";
  document.getElementById("producto").value = "";
  document.getElementById("cantidad").value = "";
  document.getElementById("tipo_precio").value = "";
  document.getElementById("precio").value = "";
  document.getElementById("subtotal").value = "";
  document.getElementById("observaciones_producto").value = "";
}

function EliminarPedidoEdit() {
  let solicitudId = $("#listaPedidos").val();
  $.ajax({
    url: "../data/eliminar_pedido.php",
    dataType: "json",
    type: "post",
    data: { id_solicitud: solicitudId },
    success: function (object) {
      console.log(object[0]);
    },
  });
}
