var listaDetalle = new Array();

function cargarDetalle() {
  let codigo = document.getElementById("codigo").value;
  let producto = document.getElementById("producto").value;
  let cantidad = document.getElementById("cantidad").value;
  let objTipoPrecio = document.getElementById("tipo_precio");
  let porcentajeDescuento = document.getElementById("porcentajeDescuento").value;
  let descuento = document.getElementById("descuento").value;

let porcentajeItem =0, descuentoItem = 0;
  if (porcentajeDescuento.length > 0) {
    porcentajeItem = porcentajeDescuento;
  }
  if (descuento.length > 0) {
    descuentoItem = descuento;
  }
  // console.log(objTipoPrecio.options[objTipoPrecio.selectedIndex].text);
  // validación de tipo precio



  let selected = objTipoPrecio.options[objTipoPrecio.selectedIndex].text;
  let arrSplit = selected.split("-");
  let tipoPrecio = arrSplit[0];

  let precio = document.getElementById("precio").value;
  let subtotal = document.getElementById("subtotal").value;
  let observacionesProducto = document.getElementById("observaciones_producto").value;

  if (codigo.toString().length == 0 || codigo.toString() == "-3") {
    alertify.error("Debe ingresar un código válido");
    return;
  }
  if (producto.toString().length == 0) {
    alertify.error("Debe ingresar un nombre de producto válido");
    return;
  }
  if (cantidad.toString().length == 0 || parseFloat(cantidad) == 0) {
    alertify.error("Debe ingresar una cantidad válida");
    return;
  }

  if (precio.toString().length == 0 || parseFloat(precio) == 0) {
    alertify.error("Debe ingresar un precio válido");
    return;
  }

  precio = document.getElementById("precio").value;
  subtotal = document.getElementById("subtotal").value;

  let existe = false;
  if (listaDetalle.length > 0) {
    listaDetalle.forEach(function (row) {
      let item = JSON.parse(JSON.stringify(row));

      if (item.codigo_producto === codigo) {
        existe = true;
      }
    });

    if (existe) {
      alertify.error("El código ya está asignado a la lista.");
      return;
    }
  }

  var jsonString = {
    codigo_producto: codigo,
    nombre_producto: producto,
    cantidad: cantidad,
    tipoprecio: tipoPrecio,
    precio: precio,
    subtotal: subtotal,
    observaciones: observacionesProducto,
    porcentaje: porcentajeItem,
    descuento: descuentoItem
  };

  listaDetalle.push(jsonString);
  // console.log(item);
// Añadir
let formatoMoneda = new Intl.NumberFormat('es-GT', {
  style: 'currency',
  currency: 'GTQ',
});
  table.row
      .add([
          codigo,
          cantidad,
          formatoMoneda.format(precio),
          formatoMoneda.format(descuento),
          formatoMoneda.format(subtotal),
          producto
      ])
      .draw(false);
  // let item = codigo + " - Cnt. " + cantidad + ' - Prc.' + precio + ' - Sbt.' + subtotal + ' - ' + producto;
  // var $select = $('#listado');
  // $select.append('<option value=' + codigo + '>' + item + '</option>');
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
  document.getElementById("existencia").value = "";
  document.getElementById("porcentajeDescuento").value = "";
  document.getElementById("ctntMensaje").style.display = "none";

  /**
   * Se llama a la función que totaliza el pedido cuando se agregar un nuevo producto
   */
  TotalizarProductos();
}

function ValidarCampos() {
  let cantidad = document.getElementById("cantidad").value;
  let objTipoPrecio = document.getElementById("tipo_precio");
  let opcion = objTipoPrecio.options[objTipoPrecio.selectedIndex].id;

  if (opcion == 'precioTresUnidades' && parseInt(cantidad) != 3) {
    alertify.error('El precio no es acorde a la cantidad');
    //$("#tipo_precio option[id=2]").attr("selected",true);
  } else if (opcion == 'precioSeisUnidades' && parseInt(cantidad) != 6) {
    alertify.error('El precio no es acorde a la cantidad');
    // $("#tipo_precio option[id=3]").attr("selected",true);
  } else if (opcion == 'precioDoceUnidades' && parseInt(cantidad) != 12) {
    alertify.error('El precio no es acorde a la cantidad');
    //$("#tipo_precio option[id=4]").attr("selected",true);
  } else {
    cargarDetalle();
  }

}

function GuardarRegistro() {
  let clienteSelect = document.getElementById("cliente");
  let clienteId = clienteSelect.dataset.id;

  if (clienteId == 0) {
    alertify.error("Debe ingresar cliente.");
    clienteSelect.focus();
    return;
  }

  if (listaDetalle.length == 0) {
    alertify.error("Debe asignar productos a la lista.");
    return;
  }

  let departamentoId = document.getElementById("departamento").value;
  let observaciones = document.getElementById("observaciones").value;
  let prioridad = document.getElementById("sltPrioridad").value;
  let transporte = document.getElementById("transporte").value;
  let tipoPago = document.getElementById("sltTipoPago").value;

  var principal = new Array();
  //var detalle = [];

  principal.push({
    id_cliente: clienteId,
    id_departamento: departamentoId,
    observaciones: observaciones,
    prioridad: prioridad,
    nosolicitud: 0,
    transporte: transporte,
    tipoPago: tipoPago
  });

  var data1 = JSON.stringify(principal);
  var data2 = JSON.stringify(listaDetalle);

  console.log(data1);
  console.log(data2);
  
  let solicitudId = 0;
  let codigoRespuesta = 0;

  $.ajax({
    url: "../data/registro_pedido.php",
    dataType: 'json',
    type: "post",
    data: {
      registro_principal: data1,
      detalle_registro: data2,
      id_solicitud: 0,
    },
    success: function (object) {          
      $.each(object, function (i, respuesta) {
        codigoRespuesta = respuesta.codigo;
        solicitudId = respuesta.id_solicitud;
      });
      if(codigoRespuesta == 1)
      {
        //alertify.success("Registro almacenado con exito");
        Validar_RegistroPedidoEnServidor(solicitudId, clienteId);
      }
      else
      {
        alertify.error("No se pudo almacenar el registro ");
      }          
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("Status: " + textStatus);
      console.log("Error: " + errorThrown);
      alertify.error("Ocurrió un error al guardar el registro");
    },
  });

  let clienteRegistro = document.getElementById("cliente");
  clienteRegistro.value = "";
  clienteRegistro.dataset.id = 0;
  document.getElementById("transporte").value = "";
  document.getElementById("observaciones").value = "";
  document.getElementById("sltPrioridad").value = "NORMAL";
  document.getElementById("codigo").value = "";
  document.getElementById("producto").value = "";
  document.getElementById("cantidad").value = "";
  document.getElementById("tipo_precio").value = "";
  document.getElementById("precio").value = "";
  document.getElementById("subtotal").value = "";
  document.getElementById("observaciones_producto").value = "";
  document.getElementById("porcentajeDescuento").value = "";
  document.getElementById("descuento").value = "";
  document.getElementById("total").value = "";
  
  listaDetalle = new Array();
  table.clear().draw();
  document.getElementById("totalGeneral").innerHTML = "";
  backToOrders('subContainerDates');
}

function QuitarItemDeLista() {
  selected = table.row(".selected").index();
  listaDetalle.splice(selected, 1);
  table.row(".selected").remove().draw(false);
  TotalizarProductos();
}

/**
 * Esta función envía información a la capa de datos 
 * para ejecutar una consulta que valide el registro
 * de pedido, recién ingresado por un vendedor.
 * El objetivo es asegurar que el registro si se haya guardardo.
 */
function Validar_RegistroPedidoEnServidor(idSolicitud, idCliente) {
  const principal = new Array();

  principal.push({
    "id_pedido": idSolicitud,
    "id_cliente": idCliente
  });

  var data1 = JSON.stringify(principal);
  let codigoRespuesta;

  $.ajax({
    url: "../data/validar_pedido.php",
    dataType: 'json',
    type: "post",
    data: {
      "registroPedido": data1
    },
    success: function (object) {
      codigoRespuesta = object[0].cantidad;
      
      if (codigoRespuesta == 0) {
        alertify.error("Registro NO confirmado!");
      }
      else if (codigoRespuesta == 1) {
        alertify.success("Registro almacenado!");
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("Status: " + textStatus);
      console.log("Error: " + errorThrown);
      alertify.error("Ocurrió un error en la validación!");
    },
  });
}

/**
 * Se encarga de sumarizar los productos agregados al pedido para 
 * mostrar el total general al final de la tabla de detalle.
 */
function TotalizarProductos(){    
  if(listaDetalle.length > 0){
    let totalPedido = 0;
      listaDetalle.forEach(function(item){
         totalPedido = parseFloat(totalPedido) + parseFloat(item.subtotal); 
      });

      let inputTotal = document.getElementById("totalGeneral");
      let formatoMoneda = new Intl.NumberFormat('es-GT', {
        style: 'currency',
        currency: 'GTQ',
      });
      
      inputTotal.innerHTML = formatoMoneda.format(totalPedido);
  }
}