var clienteIdSeleccion = 0;
var solicitudId = 0;
var listaDetalle = new Array();

/**
 * Se utiliza para asignar la fecha del día
 * a los input de fecha
 */
function GetDate() {
  let now = new Date();

  let day = ("0" + now.getDate()).slice(-2);
  let month = ("0" + (now.getMonth() + 1)).slice(-2);

  let today = now.getFullYear() + "-" + month + "-" + day;

  $("#fechaInicio").val(today);
  $("#fechaFinal").val(today);
}

/**
 * Obtiene el listado de pedidos registrados
 * en la base de datos correspondiente a la sucursal
 * asociada al usuario que ingreso al sistema.
 */
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

      ConsultaProductos();
    },
  });

  //console.log('Date in GT: ' + fechaInicio + ' - ' + fechaFinal);
}

/**
 * Obtiene el listado de productos asociados a un pedido
 * registrado en la base de datos rmym
 */
function ConsultaProductos() {
  let solicitudId = $("#listaPedidos").val();
  $.ajax({
    url: "../data/lista_productos_pedido.php",
    dataType: "json",
    type: "post",
    data: { id_solicitud: solicitudId },
    success: function (object) {
      let registro = "";
      // agregar a tabla
      const table1 = new DataTable("#example1");
      table1.clear().draw();
      $.each(object, function (i, producto) {
        table1.row
          .add([
            producto.codigo_producto,
            producto.nombre_producto,
            producto.cantidad,
            producto.precio,
            producto.subtotal,
            producto.observaciones,
          ])
          .draw(false);
        // ---------------
        // registro =
        //   "Cdg." +
        //   producto.codigo_producto +
        //   " Nom. " +
        //   producto.nombre_producto +
        //   " Cnt. " +
        //   producto.cantidad +
        //   " Prc. " +
        //   producto.precio +
        //   " Subtotal: " +
        //   producto.subtotal +
        //   " Obs." +
        //   producto.observaciones;
        // $selectProductos.append(
        //   "<option value=" +
        //   producto.codigo_producto +
        //   ">" +
        //   registro +
        //   "</option>"
        // );
      });
    },
  });
  //console.log(solicitudId);
}

/**
 * Carga el registro del pedido seleccionado
 * para editar.
 */
function CargaPedidoEdit() {
  // agregar a tabla
  let departamento;
  let observaciones;
  var departamentoId;
  let prioridad;
  let noSolicitud;
  let transporte;

  solicitudId = $("#listaPedidos").val();
  $.ajax({
    url: "../data/carga_pedido_edit.php",
    dataType: "json",
    type: "post",
    data: { id_solicitud: solicitudId },
    success: function (object) {
      departamentoId = object[0].id_departamento;
      clienteIdSeleccion = object[0].cliente;
      observaciones = object[0].observaciones;
      prioridad = object[0].prioridad;
      noSolicitud = object[0].nosolicitud;
      transporte = object[0].transporte;

      $("#observaciones").val(observaciones);
      $("#departamento").val(departamentoId);
      $("#sltPrioridad").val(prioridad);
      $("#hdnNoSolicitud").val(noSolicitud);
      $("#transporte").val(transporte);

      listaClientesConsulta();
      CargaProductosEdit(solicitudId);
    },
  });

  document.getElementById("subContainerDates").classList.toggle("subir");
  document.getElementById("departamento").focus();
}
const button = document.querySelector("#btn");
button.addEventListener("click", function () {
  document.getElementById("subContainerDates").classList.toggle("subir");
});

/**
 * Se selecciona el cliente en el select
 * automáticamente.
 */
function AsignarCliente() {
  $("#cliente").val(clienteIdSeleccion);
}

/**
 * Busca los registros (productos) asociados al pedido que se quiere editar.
 * @param {int} idsolicitud es el id del pedido consultado
 */
function CargaProductosEdit(idsolicitud) {
  const table1 = new DataTable("#example1");
  $.ajax({
    url: "../data/carga_productos_edit.php",
    dataType: "json",
    type: "post",
    data: { id_solicitud: idsolicitud },
    success: function (object) {
      table.clear().draw();
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
        // Añadir
        const table = new DataTable("#example");
        table.row
          .add([
            producto.codigo_producto,
            producto.cantidad,
            producto.precio,
            producto.subtotal,
            producto.nombre_producto,
          ])
          .draw(false);
        // let item =
        //   producto.codigo_producto +
        //   " - Cnt. " +
        //   producto.cantidad +
        //   " - Prc." +
        //   producto.precio +
        //   " - Sbt." +
        //   producto.subtotal +
        //   " - " +
        //   producto.nombre_producto;
        // $select.append("<option value=" + codigo + ">" + item + "</option>");
      });
    },
  });
}

function GuardarNuevoRegistro() {
  let clienteId = document.getElementById("cliente").value;
  let departamentoId = document.getElementById("departamento").value;
  let observaciones = document.getElementById("observaciones").value;
  let prioridad = document.getElementById("sltPrioridad").value;
  let noSolicitud = document.getElementById("hdnNoSolicitud").value;
  let transporte = document.getElementById("transporte").value;

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
    prioridad: prioridad,
    nosolicitud: noSolicitud,
    transporte: transporte,
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
      //console.log(object);
      alertify.success("Registro almacenado con exito");
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("Status: " + textStatus);
      console.log("Error: " + errorThrown);
      alertify.error("No se pudo almacenar el registro");
    },
  });
  let $selectLPedido = $("listaPedidos");
  $selectLPedido.empty();
  let $selectLProducto = $("listaProductos");
  $selectLProducto.empty();
  document.getElementById("observaciones").value = "";
  document.getElementById("sltPrioridad").value = "NORMAL";
  document.getElementById("hdnNoSolicitud").value = 0;
  document.getElementById("codigo").value = "";
  document.getElementById("producto").value = "";
  document.getElementById("cantidad").value = "";
  document.getElementById("tipo_precio").value = "";
  document.getElementById("precio").value = "";
  document.getElementById("subtotal").value = "";
  document.getElementById("observaciones_producto").value = "";
  document.getElementById("existencia").value = "";

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
