var listaDetalle = new Array();
/**
 * Esta función establece la fecha actual 
 * al control de fecha del formulario
 */
$(document).ready(function () {
  var now = new Date();

  var day = ("0" + now.getDate()).slice(-2);
  var month = ("0" + (now.getMonth() + 1)).slice(-2);

  var today = now.getFullYear() + "-" + month + "-" + day;
  $("#fecha").val(today);
  $("#fechaCobroCheque").val(today);
});

function cargarDetalle() {
  let numeroEnvio = document.getElementById("numero_envio").value;
  var selectEmpresa = document.getElementById("empresa");
  var empresa = selectEmpresa.options[selectEmpresa.selectedIndex].text;
  var selectTipoPago = document.getElementById("tipo_pago");
  var tiopPago = selectTipoPago.options[selectTipoPago.selectedIndex].text;
  let pago = document.getElementById("pago").value;
  var radios = document.getElementsByName("forma_pago"); 
  var valorRadio = "";
  let radioValor = "";
  for (var radio of radios) {
    if (radio.checked) {
      radioValor = radio.value; 
    }
  } if(radioValor == "total"){
    valorRadio = "S";
  }else{
    valorRadio = "N";
  }

  let radioSeleccionado = radioValor;
  var selectBanco = document.getElementById("banco");
  var banco = selectBanco.options[selectBanco.selectedIndex].text;
  let numeroDeposito = document.getElementById("numero_deposito").value;
  let numeroCheque = document.getElementById("numero_cheque").value;
  let fechaCobroCheque = document.getElementById("fechaCobroCheque").value;
  let comentarioCheque = documento.getElementById("comentarioCheque").value;
  let checkboxCajaRural = document.getElementById("checkAvanzado");
  let chkPrefechado = document.getElementById("chkPrfechado");

  let checkboxCRValor = "";
  if (checkboxCajaRural.checked == true) {
    checkboxCRValor = "S";
  } else {
    checkboxCRValor = "N";
  }
  let prefechado = "";
  if(chkPrefechado.checked == true)
  {
    prefechado = "S";
  }
  else{
    prefechado = "N";
  }

  let checkboxCompraContado = document.getElementById("checkAvanzadoDos");
  let checkboxCCValor = "";
  if (checkboxCompraContado.checked == true) {
    checkboxCCValor = "S";
  } else {
    checkboxCCValor = "N";
  }


  let observacionesProducto = document.getElementById("observaciones_producto").value;


//   VALIDACIONES

// ---

//   if (producto.toString().length == 0) {
//     alertify.error("Debe ingresar un nombre de producto válido");
//     return;
//   }
  if (numeroEnvio.toString().length == 0 || parseFloat(numeroEnvio) == 0) {
    alertify.error("Debe ingresar el número de envio.");
    return;
  }

  if (pago.toString().length == 0 || parseFloat(pago) == 0) {
    alertify.error("Debe ingresar el monto.");
    return;
  }

// ---

  let existe = false;
  if (listaDetalle.length > 0) {
    listaDetalle.forEach(function (row) {
      let item = JSON.parse(JSON.stringify(row));

      if (item.numeroEnvio === numeroEnvio) {
        existe = true;
      }
    });

    if (existe) {
      alertify.error("El número de envio ya está agregado a la lista.");
      return;
    }
  }

  var jsonString = {
    no_envio: numeroEnvio,
    no_deposito: numeroDeposito,
    caja_rural: checkboxCRValor,
    compra_contado: checkboxCCValor,
    empresa: empresa,
    no_cheque: numeroCheque,
    tipo_pago: tiopPago,
    pago: pago,
    pago_total: valorRadio,
    observaciones: observacionesProducto,
    banco: banco,
    prefechado: prefechado,
    fecha_cobro: fechaCobroCheque,
    comentario_cheque: comentarioCheque
  };

  listaDetalle.push(jsonString);
  // console.log(item);

  let item =
  "Envio " +
    numeroEnvio +
  "Monto " +
    pago +
    "Observaciones " +
    observacionesProducto;

  var $select = $("#listado");
  $select.append("<option value=" + numeroEnvio + ">" + item + "</option>");
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

  document.getElementById("numero_envio").value = "";
  document.getElementById("pago").value = "";
  document.getElementById("numero_deposito").value = "";
  document.getElementById("numero_cheque").value = "";
  document.getElementById("observaciones_producto").value = "";
  checkboxCajaRural.checked = false;
  checkboxCompraContado.checked == false;
}

function GuardarRegistro(consulta) {
  let idRecibo = 0;
  if(consulta == "S")
  {
    idRecibo = $("#listaPedidos").val();
  }
  
  let clienteSelect = document.getElementById("cliente");
  let clienteId = 0;
  if(idRecibo > 0)
  {
    clienteId = clienteSelect.value;
  }
  else 
  {
    clienteId = clienteSelect.dataset.id;
  }

  if (clienteId == 0) {
    alertify.error("Debe ingresar cliente.");
    clienteSelect.focus();
    return;
  }

  if (listaDetalle.length == 0) {
    alertify.error("Debe asignar productos a la lista.");
    return;
  }


  let numeroRecibo = document.getElementById("numero_recibo").value;
  let nombreCliente = "";
  if(idRecibo > 0)
  {
    nombreCliente = clienteSelect.options[clienteSelect.selectedIndex].text;
  }
  else 
  {
    nombreCliente = document.getElementById("cliente").value;
  }

  var semanaSelect = document.getElementById("sltSemana");
  var semana = semanaSelect.options[semanaSelect.selectedIndex].text;
  let observaciones = document.getElementById("observaciones").value;
  var contenderoTabal = document.getElementById("main-container");
  var agregarAlPedido = document.getElementById("shopping_cart");
  var enviarPedido = document.getElementById("send_order");
  var fechas = document.getElementById("subContainerDates");
  var datosGenerales = document.getElementById("subContainerDatesAll");
  let fechaRecibo = $("#fecha").val();
  fechaRecibo = fechaRecibo.toString().replace(/-/gi, "");

  let cobro = 0;
  listaDetalle.forEach(element => {
    // let jsonItem = JSON.parse(element);
   cobro = parseFloat(cobro) + parseFloat(element.pago);
  });
  var principal = new Array();
  //var detalle = [];
  console.log(clienteId);
  principal.push({
    no_recibo: numeroRecibo,
    id_cliente: clienteId,
    nombre_cliente: nombreCliente,
    cobro: cobro,
    semana: semana,
    observaciones: observaciones,
    fecha:fechaRecibo
  });

  var data1 = JSON.stringify(principal);
  var data2 = JSON.stringify(listaDetalle);

  $.ajax({
    url: "../data/registro_recibo.php",
    // dataType: 'json',
    type: "post",
    data: {
      registro_principal: data1,
      detalle_registro: data2,
      id_recibo: idRecibo,
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
  let clienteRegistro = document.getElementById("cliente");
  clienteRegistro.value = "";
  clienteRegistro.dataset.id = 0;

  document.getElementById("numero_recibo").value = "";
  document.getElementById("cliente").value = "";
  document.getElementById("observaciones").value = "";
  let select = document.getElementById("sltSemana");
  select.value = "SEMANA 1";  
  document.getElementById("numero_envio").value = "";
  document.getElementById("pago").value = "";
  document.getElementById("numero_deposito").value = "";
  document.getElementById("numero_cheque").value = "";
  document.getElementById("observaciones_producto").value = "";
  document.getElementById("total_seleccionado").checked;
  document.getElementById("checkAvanzado").checked = false;
  document.getElementById("checkAvanzadoDos").checked = false;
 


  let $selectListado = $("#listado");
  $selectListado.empty();
  listaDetalle = new Array();
  if (agregarAlPedido.style.display == "block") {
    contenderoTabal.style.display = "none";
    agregarAlPedido.style.display = "none";
    enviarPedido.style.display = "none";
    fechas.style.display = "block";
    datosGenerales.style.display = "block";
  }
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
