let tableEnvioDevolucion = new DataTable('#tablaEnviosCliente');
var tablaDetalleEnvio = new DataTable('#tablaDetalleEnvio');
let arrayEnvio = [];
let arrayDetalleEnvio = [];
var filaEnvio;
let detalleVentaId = 0;
let cantidadDespachada = 0;
/**
 * Carga el listado de envíos asociados al cliente seleccionado por el usuario.
 * @param {*} idcliente 
 */
function GetEnviosDevolucionCliente(idcliente) {        
    let formatoMoneda = new Intl.NumberFormat('es-GT', {
      style: 'currency',
      currency: 'GTQ',
    });
  
    let datos = { clienteId: idcliente};
    arrayEnvio.length = 0;
    $.ajax({
      url: "../data/devolucion_carga_envios.php",
      dataType: "json",
      type: "post",
      data: datos,
      success: function (object) {
        if (object[0].nofactura != -3) {
          $.each(object, function (i, envio) {
            arrayEnvio.push(envio);
          });
          MostrarTableEnvios();
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log("Status: " + textStatus);
        console.log("Error: " + errorThrown);
        alertify.error("Ocurrió un error al guardar el registro");
      },
    });
  }

  /**
   * Carga los datos del arreglo EnvioDevolucion a la tabla de envíos
   * para mostrarla al usuario
   */
  function MostrarTableEnvios() {            
    let formatoMoneda = new Intl.NumberFormat('es-GT', {
      style: 'currency',
      currency: 'GTQ',
    });
  
    tableEnvioDevolucion.clear().draw();    
    if (arrayEnvio.length > 0) {
      arrayEnvio.forEach(function (item) {
        tableEnvioDevolucion.row
          .add([
            item.seriefactura,
            item.nofactura,
            formatoMoneda.format(item.montooriginal),           
            item.fecha_registro,                       
          ])
          .draw(false);        
      })      
    }
  }

  /**
   * Permite seleccionar una fila en la tabla de envíos
   */
  tableEnvioDevolucion.on("click", "tbody tr", (e) => {
    let classList = e.currentTarget.classList;
  
    if (classList.contains("selected")) {
      classList.remove("selected");
    } else {
        tableEnvioDevolucion
        .rows(".selected")
        .nodes()
        .each((row) => row.classList.remove("selected"));
      classList.add("selected");
    }
  });

  /**
   * Se establece un Listener click para cargar el detalle del 
   * envío seleccionado.
   */
$('#tablaEnviosCliente tbody').on('click', 'tr', function () {
    let data = tableEnvioDevolucion.row(this).data();
    let envioId = 0;
    arrayEnvio.forEach(function(item){
        if(item.nofactura == data[1])
        {
            envioId = item.idventa;
            return;
        }
    })
    
    console.log(envioId);
    GetConsultaDetalleEnvioDevolucion(envioId);
  });

  /**
   * Carga los registros asociados a un envío desde la base de datos a un 
   * arreglo.
   * @param {Identificador único del envío a trabajar} idenvio 
   */
  
function GetConsultaDetalleEnvioDevolucion(idenvio) {
    let datos = { envioId: idenvio };
    arrayDetalleEnvio.length = 0;
    $.ajax({
      url: "../data/devolucion_consulta_detalle_envio.php",
      dataType: "json",
      type: "post",
      data: datos,
      success: function (object) {
        if (object[0].codigormym != -3) {
          $.each(object, function (i, item) {
            arrayDetalleEnvio.push(item);
          });
          MostrarTablaDetalleEnvio();
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

  /**
   * Se cargan los registros del envío guardados en un array, a la tabla para mostrarlos al
   * usuario.
   */
  function MostrarTablaDetalleEnvio() {
    let formatoMoneda = new Intl.NumberFormat('es-GT', {
      style: 'currency',
      currency: 'GTQ',
    });
  
    tablaDetalleEnvio.clear().draw();
  
    if (arrayDetalleEnvio.length > 0) {
      arrayDetalleEnvio.forEach(function (item) {
        tablaDetalleEnvio.row
          .add([
            item.codigormym,
            item.producto,
            item.cantidad,            
            formatoMoneda.format(item.precio),
            item.devolucion,
            item.bodega_destino,
            item.idbodega,
            item.id_detalleventa
          ])
          .draw(false);
      })
    }
  }

  
/**
 * Función utilizada para obtener el id del producto seleccionado
 */
tablaDetalleEnvio.on("click", "tbody tr", (e) => {
    let classList = e.currentTarget.classList;
  
    if (classList.contains("selected")) {
      classList.remove("selected");
    } else {
      tablaDetalleEnvio
        .rows(".selected")
        .nodes()
        .each((row) => row.classList.remove("selected"));
      classList.add("selected");
    }
  });

  /**
   * Se obtiene los datos de la fila seleccionada en la tabla de 
   * detalle
   */
  $('#tablaDetalleEnvio tbody').on('click', 'tr', function () {
    let data = tablaDetalleEnvio.row(this).data();
    detalleVentaId = data[7];
    cantidadDespachada = data[2];
  });

  /**
   * Se asignan los valores ingresados por el usuario al array
   * del detalle del envío.
   */
  function asignarDevolucion(){
    let cantidadDevolucion = document.getElementById("inputCantidadDevolucion").value;
    let bodegaDestino = document.getElementById("inputBodegaDestino").value;

    if (cantidadDevolucion.length == 0 || parseFloat(cantidadDevolucion) == 0) {
     alertify.error("Debe ingresar el la cantidad a devolver.");
    }else if(parseFloat(cantidadDevolucion) > parseFloat(cantidadDespachada)){
      alertify.error("La devolucion no puede ser mayor al despacho");
    }else{
     arrayDetalleEnvio.forEach(function (item) {
      if (item.id_detalleventa === detalleVentaId) {
       item.devolucion = cantidadDevolucion;
       item.bodega_destino = bodegaDestino;
       return;
      }
     })
     MostrarTable();
    }
    //document.getElementById("modalPago").style.display = "none";
 }