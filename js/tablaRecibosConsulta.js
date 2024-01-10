let now = new Date();
document.getElementById('anio').value = now.getFullYear();
var tablaRecibo = new DataTable('#datosRecibos');
var tablaDetalleRecibo = new DataTable('#datosDetalleRecibos');
let arrayRecibo = [];
let arrayDetalleRecibo = [];
let arrayImpresion = [];
var reciboIdConsulta = 0;
var reciboDetalleIdConsulta = 0;


function GetRecibosConsulta() {
  let mesSelect = document.getElementById("sltMes");
  let mesId = mesSelect.selectedIndex + 1;
  let anio = document.getElementById('anio').value;

  let datos = { mes: mesId, anio: anio };
  arrayRecibo.length = 0;
  $.ajax({
    url: "../data/recibo_consulta_principal.php",
    dataType: "json",
    type: "post",
    data: datos,
    success: function (object) {
      if (object[0].id_recibo != -3) {
        $.each(object, function (i, recibo) {
          arrayRecibo.push(recibo);
        });
        MostrarTablaRecibo();
      }
      else {
        alertify.error('No se localizaron registros');
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("Status: " + textStatus);
      console.log("Error: " + errorThrown);
      alertify.error("Ocurrió un error al consultar los recibos");
    },
  });
}

function MostrarTablaRecibo() {
  let formatoMoneda = new Intl.NumberFormat('es-GT', {
    style: 'currency',
    currency: 'GTQ',
  });

  tablaRecibo.clear().draw();
  tablaDetalleRecibo.clear().draw();

  if (arrayRecibo.length > 0) {
    arrayRecibo.forEach(function (item) {
      tablaRecibo.row
        .add([
          item.serie_recibo,
          item.no_recibo,
          formatoMoneda.format(item.cobro),
          item.fecha_recibo,
          item.observacion,
          item.estado,
          item.id_recibo
        ])
        .draw(false);
    })
  }
}
// Seleccionr
tablaRecibo.on("click", "tbody tr", (e) => {
  let classList = e.currentTarget.classList;

  if (classList.contains("selected")) {
    classList.remove("selected");
  } else {
    tablaRecibo
      .rows(".selected")
      .nodes()
      .each((row) => row.classList.remove("selected"));
    classList.add("selected");
  }
});

// Enviar Id a Función
$('#datosRecibos tbody').on('click', 'tr', function () {
  let data = tablaRecibo.row(this).data();
  GetConsultaDetalleRecibo(data[6]);
});


//detalle recibo
function GetConsultaDetalleRecibo(idRecibo) {
  let datos = { reciboId: idRecibo };
  arrayDetalleRecibo.length = 0;
  $.ajax({
    url: "../data/recibo_consulta_detalle.php",
    dataType: "json",
    type: "post",
    data: datos,
    success: function (object) {
      if (object[0].id_recibo != -3) {
        $.each(object, function (i, recibo) {
          arrayDetalleRecibo.push(recibo);
        });
        MostrarTablaDetalleRecibo();
      }
      else {
        alertify.error('No se localizaron registros');
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("Status: " + textStatus);
      console.log("Error: " + errorThrown);
      alertify.error("Ocurrió un error al consultar los recibos");
    },
  });
}

function MostrarTablaDetalleRecibo() {
  let formatoMoneda = new Intl.NumberFormat('es-GT', {
    style: 'currency',
    currency: 'GTQ',
  });

  tablaDetalleRecibo.clear().draw();

  if (arrayDetalleRecibo.length > 0) {
    arrayDetalleRecibo.forEach(function (item) {
      tablaDetalleRecibo.row
        .add([
          item.no_envio,
          formatoMoneda.format(item.monto),
          formatoMoneda.format(item.abono),
          formatoMoneda.format(item.saldo),
          formatoMoneda.format(item.pago),
          item.tipo_pago,
          item.no_deposito,
          item.no_cheque,
          item.banco,
          item.prefechado,
          item.fecha_cobro,
          item.cobrado,
          item.mensaje_seguimiento_cheque,                    
          item.mensaje_deposito,          
          item.mensaje_cheque,
          item.observaciones,
          item.comentario_cheque,
          item.id_detalle_recibo
        ])
        .draw(false);
    })
  }
}

// Funciones modal de edicion
// Seleccionar
tablaDetalleRecibo.on("click", "tbody tr", (e) => {
  let classList = e.currentTarget.classList;

  if (classList.contains("selected")) {
    classList.remove("selected");
  } else {
    tablaDetalleRecibo
      .rows(".selected")
      .nodes()
      .each((row) => row.classList.remove("selected"));
    classList.add("selected");
  }
});

// Recibo
// Abrir modal y llenar campos
$('#datosRecibos tbody').on('click', 'tr', function () {
  // Conseguir la data
  let data = tablaRecibo.row(this).data();
  let inputFechaRecibo = document.getElementById('fechaRecibo');
  let inputObservacionesRecibo = document.getElementById('observaciones');
  inputFechaRecibo.value = data[3];
  inputObservacionesRecibo.value = data[4];
  reciboIdConsulta = data[6];

  // Para sacar info data[0];
  document.getElementById("btnEditar").addEventListener("click", abrirModalRecibo);
  function abrirModalRecibo() {
    document.getElementById("modalRecibo").style.display = "flex";
  }
});



document.getElementById("btn_cerrar").addEventListener("click", cerrarModalRecibo);

function cerrarModalRecibo() {
  document.getElementById("modalRecibo").style.display = "none";
}


// Detalle Recibo
// Abrir modal y llenar campos
$('#datosDetalleRecibos tbody').on('click', 'tr', function () {
  // Conseguir la data
  let data = tablaDetalleRecibo.row(this).data();  
  // Para sacar info data[0];
  reciboDetalleIdConsulta = data[17];
  let inputPago = document.getElementById('pago');
  let inputTipoPago = document.getElementById('tipoPago');
  let inputNumeroDeposito = document.getElementById('numeroDeposito');
  let inputNumeroCheque = document.getElementById('numeroCheque');
  let inputBanco = document.getElementById('banco');
  let inputPreFechado = document.getElementById('preFechado');
  let inputFechaCobro = document.getElementById('fechaCobro');
  let inputMensajeCheque = document.getElementById('mensajeCheque');

  let montoPago = data[4].substring(2);
  montoPago = montoPago.replace(",", "");
  inputPago.value = montoPago;
  
  for (var i, j = 0; i = inputTipoPago.options[j]; j++) {
    if (i.value == data[5]) {
      inputTipoPago.selectedIndex = j;
      break;
    }
  }

  inputNumeroDeposito.value = data[6];
  inputNumeroCheque.value = data[7]
  for (var i, j = 0; i = inputBanco.options[j]; j++) {
    if (i.value == data[8]) {
      inputBanco.selectedIndex = j;
      break;
    }
  }

  inputPreFechado.value = data[9];
  inputFechaCobro.value = data[10];
  inputMensajeCheque.value = data[16];

  document.getElementById("btnEditarDetalle").addEventListener("click", abrirModalDetalleRecibo);
  function abrirModalDetalleRecibo() {
    document.getElementById("modalDetalleRecibo").style.display = "flex";
  }
});


document.getElementById("btnCerrarDetalleRecibo").addEventListener("click", cerrarModalDetalleRecibo);

function cerrarModalDetalleRecibo() {
  document.getElementById("modalDetalleRecibo").style.display = "none";
}
/**
 * Toma los datos del modal de recibo y los actualiza directamente en la base de datos
 */
function ActualizarDatosRecibo() {
  let inputFechaRecibo = document.getElementById('fechaRecibo');
  let inputObservacionesRecibo = document.getElementById('observaciones');
  let principal = new Array();
  principal.push({
    fecha: inputFechaRecibo.value,
    observaciones: inputObservacionesRecibo.value
  });

  var data1 = JSON.stringify(principal);

  $.ajax({
    url: "../data/recibo_update_principal.php",
    dataType: 'json',
    type: "post",
    data: {
      id_recibo: reciboIdConsulta,
      registro_principal: data1
    },
    success: function (object) {
      $.each(object, function (i, respuesta) {
        codigoRespuesta = respuesta.codigo;
        reciboId = respuesta.id_recibo;
      });
      if (codigoRespuesta == 1) {
        alertify.success("Registro almacenado con exito");
        inputObservacionesRecibo.value = "";

        //Fecha del día
        let now = new Date();
        let day = ("0" + now.getDate()).slice(-2);
        let month = ("0" + (now.getMonth() + 1)).slice(-2);
        let today = now.getFullYear() + "-" + month + "-" + day;

        inputFechaRecibo.value = today;
        document.getElementById("modalRecibo").style.display = "none";
        //Validar_RegistroDeRecibo(reciboId, clienteId);
      }
      else {
        alertify.error("No se pudo almacenar el registro");
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("Status: " + textStatus);
      console.log("Error: " + errorThrown);
      alertify.error("Ocurrió un error al almacenar el registro");
    },
  });
}


function ActualizarDatosDetalleRecibo() {
  let inputFechaRecibo = document.getElementById('fechaRecibo');
  let inputObservacionesRecibo = document.getElementById('observaciones');

  let inputPago = document.getElementById('pago');
  let inputTipoPago = document.getElementById('tipoPago');
  let inputNumeroDeposito = document.getElementById('numeroDeposito');
  let inputNumeroCheque = document.getElementById('numeroCheque');
  let inputBanco = document.getElementById('banco');
  let banco = inputBanco.options[inputBanco.selectedIndex].text;
  let inputPreFechado = document.getElementById('preFechado');
  let inputFechaCobro = document.getElementById('fechaCobro');
  let inputMensajeCheque = document.getElementById('mensajeCheque');
  
  var jsonString = {    
    pago: inputPago.value,
    tipo_pago: inputTipoPago.value,
    no_deposito: inputNumeroDeposito.value,
    no_cheque: inputNumeroCheque.value,
    banco: banco,
    prefechado: inputPreFechado.value,
    fecha_cobro: inputFechaCobro.value,
    comentario_cheque: inputMensajeCheque.value    
  };
  let listaDetalle = new Array();

  listaDetalle.push(jsonString);
  var data1 = JSON.stringify(listaDetalle);

  $.ajax({
    url: "../data/recibo_update_detalle.php",
    dataType: 'json',
    type: "post",
    data: {
      id_detallerecibo: reciboDetalleIdConsulta,
      detalle_registro: data1
    },
    success: function (object) {
      console.log(object);
      $.each(object, function (i, respuesta) {
        codigoRespuesta = respuesta.codigo;
        reciboId = respuesta.id_detallerecibo;
      });
      if (codigoRespuesta == 1) {
        alertify.success("Registro almacenado con exito");
        inputObservacionesRecibo.value = "";

        //Fecha del día
        let now = new Date();
        let day = ("0" + now.getDate()).slice(-2);
        let month = ("0" + (now.getMonth() + 1)).slice(-2);
        let today = now.getFullYear() + "-" + month + "-" + day;

        inputFechaRecibo.value = today;
        
      // inputPago.value = 0;      
      // inputNumeroDeposito.value = "";
      // inputNumeroCheque.value = "";            
      // inputPreFechado.value = "";
      // inputFechaCobro.value = today;
      // inputMensajeCheque.value = "";

      GetRecibosConsulta();
      document.getElementById("modalDetalleRecibo").style.display = "none";

      }
      else {
        alertify.error("No se pudo almacenar el registro");
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {      
      console.log("Status: " + textStatus);
      console.log("Error: " + errorThrown);
      alertify.error("Ocurrió un error al almacenar el registro");
    },
  });
}


function GetDatosImpresion() {
  let datos = { id_recibo: reciboIdConsulta };
  arrayImpresion.length = 0;
  $.ajax({
    url: "../data/recibo_datos_impresion.php",
    dataType: "json",
    type: "post",
    data: datos,
    success: function (object) {
      if (object[0].id_recibo != -3) {
        $.each(object, function (i, recibo) {
          arrayImpresion.push(recibo);
        });
        ImprimirRecibo();
      }
      else {
        alertify.error('No se localizaron registros');
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("Status: " + textStatus);
      console.log("Error: " + errorThrown);
      alertify.error("Ocurrió un error al consultar los recibos");
    },
  });
}

function ImprimirRecibo()
{
  let formatoMoneda = new Intl.NumberFormat('es-GT', {
    style: 'currency',
    currency: 'GTQ',
  });

  if (arrayImpresion.length > 0) {
    arrayImpresion.forEach(function (item) {
      //codigo para impresion
      
    })
  }
}