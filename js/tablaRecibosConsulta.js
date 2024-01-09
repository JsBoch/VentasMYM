let now = new Date();
document.getElementById('anio').value = now.getFullYear();
var tablaRecibo = new DataTable('#datosRecibos');
var tablaDetalleRecibo = new DataTable('#datosDetalleRecibos');
let arrayRecibo = [];
let arrayDetalleRecibo = [];

function GetRecibosConsulta() {
    let mesSelect = document.getElementById("sltMes");
    let mesId = mesSelect.selectedIndex + 1;
    let anio = document.getElementById('anio').value;
   
    let datos = { mes: mesId,anio:anio };
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
        else{
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
        else{
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
            item.pago_total,
            item.no_deposito,
            item.no_cheque,
            item.banco,
            item.observaciones,
            item.prefechado,
            item.fecha_cobro,
            item.cobrado,
            item.comentario_cheque,
            item.mensaje_seguimiento_cheque,
            item.mensaje_deposito,
            item.mensaje_cheque,
            item.id_detalle_recibo            
          ])
          .draw(false);        
      })      
    }
  }