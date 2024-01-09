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
  let data = tablaRecibo.row( this ).data();
  GetConsultaDetalleRecibo(data[6]);
} );


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
            item.no_deposito,
            item.no_cheque,
            item.banco,
            item.prefechado,
            item.fecha_cobro,
            item.pago_total,
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
  // Seleccionr
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
      let data = tablaDetalleRecibo.row( this ).data();
      // Para sacar info data[0];
      document.getElementById("btnEditar").addEventListener("click", abrirModalRecibo);
      function abrirModalRecibo(){
        document.getElementById("modalRecibo").style.display = "flex";
      }

    } );

  

document.getElementById("btn_cerrar").addEventListener("click", cerrarModalRecibo);

function cerrarModalRecibo() {
  document.getElementById("modalRecibo").style.display = "none";
}


// Detalle Recibo
  // Abrir modal y llenar campos
  $('#datosDetalleRecibos tbody').on('click', 'tr', function () {
    // Conseguir la data
    let data = tablaDetalleRecibo.row( this ).data();
    // Para sacar info data[0];

    document.getElementById("btnEditarDetalle").addEventListener("click", abrirModalDetalleRecibo);
    function abrirModalDetalleRecibo(){
      document.getElementById("modalDetalleRecibo").style.display = "flex";
    }
  } );
  

document.getElementById("btnCerrarDetalleRecibo").addEventListener("click", cerrarModalDetalleRecibo);

function cerrarModalDetalleRecibo() {
  document.getElementById("modalDetalleRecibo").style.display = "none";
}