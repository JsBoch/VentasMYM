var clienteIdSeleccion = 0;
var listaDetalle = new Array();

$(document).ready(function () {
  var now = new Date();

  var day = ("0" + now.getDate()).slice(-2);
  var month = ("0" + (now.getMonth() + 1)).slice(-2);

  var today = now.getFullYear() + "-" + month + "-" + day;
  $("#fechaInicio").val(today);
  $("#fechaFinal").val(today);
});

function ConsultarRecibos() {
  let fechaInicio = $("#fechaInicio").val();
  let fechaFinal = $("#fechaFinal").val();
  fechaInicio = fechaInicio.toString().replace(/-/gi, "");
  fechaFinal = fechaFinal.replace(/-/gi, "");

  let datos = { fechaInicio: fechaInicio, fechaFinal: fechaFinal };
  $.ajax({
    url: "../data/lista_recibos.php",
    dataType: "json",
    type: "post",
    data: datos,
    success: function (object) {
      let registro = "";
      var $selectPedidos = $("#listaPedidos");
      $selectPedidos.empty();
      $.each(object, function (i, pedido) {
        registro =
          " No. " +
          pedido.no_recibo +
          " Cliente: " +
          pedido.nombre_cliente +
          " Cobro: " +
          pedido.cobro;
        $selectPedidos.append(
          "<option value=" + pedido.id_recibo + ">" + registro + "</option>"
        );
      });

      ConsultaProductos();
    },
  });

  //console.log('Date in GT: ' + fechaInicio + ' - ' + fechaFinal);
}

function ConsultaProductos() {
  let solicitudId = $("#listaPedidos").val();
  $.ajax({
    url: "../data/detalle_recibo.php",
    dataType: "json",
    type: "post",
    data: { id_solicitud: solicitudId },
    success: function (object) {
      let registro = "";
      var $selectProductos = $("#listaProductos");
      $selectProductos.empty();
      $.each(object, function (i, producto) {
        registro =
          "No." +
          producto.no_envio +
          " Pago. " +
          producto.pago +
          " Obs. " +
          producto.observaciones;

        $selectProductos.append(
          "<option value=" + producto.no_envio + ">" + registro + "</option>"
        );
      });
    },
  });
  //console.log(solicitudId);
}

function CargaPedidoEdit() {
  let observaciones;
  var departamentoId;
  let idRecibo;
  let noRecibo;
  let cliente;
  let semana;

  solicitudId = $("#listaPedidos").val();
  $.ajax({
    url: "../data/carga_recibo_edit.php",
    dataType: "json",
    type: "post",
    data: { id_solicitud: solicitudId },
    success: function (object) {
      idRecibo = object[0].id_recibo;
      noRecibo = object[0].no_recibo;
      departamentoId = object[0].iddepartamento;
      clienteIdSeleccion = object[0].id_cliente;  
      cliente = object[0].cliente;
      semana = object[0].semana;
      observaciones = object[0].observacion;

      $("#numero_recibo").val(noRecibo);
      $("#departamento").val(departamentoId);
      $("#cliente").val(cliente);
      $("#sltSemana").val(semana);
      $("#observaciones").val(observaciones);
      listaClientesConsulta();
      CargaProductosEdit(solicitudId);
    },
  });

  document.getElementById("departamento").focus();
}

function listaClientesConsulta() {
  let departamentoId = $("#departamento").val();
  let datos = { iddepartamento: departamentoId };
  
  $.ajax({
    url: "../data/lista_clientes.php",
    dataType: "json",
    type: "post",
    data: datos,
    success: function (object) {
      var $selectCliente = $("#cliente");
      $selectCliente.empty();
      $.each(object, function (i, cliente) {
        $selectCliente.append(
          "<option value=" +
            cliente.idcliente +
            ">" +
            cliente.nombre +
            "</option>"
        );
      });
      AsignarCliente();
    },
  });
}

function AsignarCliente() {
  $("#cliente").val(clienteIdSeleccion);
}

function CargaProductosEdit(idsolicitud) {
  $.ajax({
    url: "../data/carga_detalle_recibo.php",
    dataType: "json",
    type: "post",
    data: { id_solicitud: idsolicitud },
    success: function (object) {
      var $select = $("#listado");

      $select.empty();

      $.each(object, function (i, producto) {
        var jsonString = {
          no_envio: producto.no_envio,
          no_deposito: producto.no_deposito,
          caja_rural: producto.caja_rural,
          empresa: producto.empresa,
          no_cheque: producto.no_cheque,
          tipo_pago: producto.tipo_pago,
          pago: producto.pago,
          pago_total: producto.pago_total,
          observaciones: producto.observaciones,
          banco: producto.banco
        };

        listaDetalle.push(jsonString);

        let item =
          "Envio " +
          producto.no_envio +
          "Monto " +
          producto.pago +
          "Observaciones " +
          producto.observaciones;

        var $select = $("#listado");
        $select.append(
          "<option value=" + producto.no_envio + ">" + item + "</option>"
        );
      });
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log(jqXHR);
      console.log("Status: " + textStatus);
      console.log("Error: " + errorThrown);
  }
  });
}
