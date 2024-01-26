/**
 * Este archivo contiene las funciones para obtener los valores ingresados por el usuario
 * y enviar esto a la base de datos.
 */
function GuardarRegistroDevolucion() {    
    let _devolucionId = 0; 
    let _motivo = document.getElementById("inputMotivo").value;
    let _noDevolucion = document.getElementById("inputNoDevolucion").value;
  
    var data1 = JSON.stringify(arrayEnvio);
    var data2 = JSON.stringify(arrayDetalleEnvio);
  
    console.log(data1);
    console.log(data2);
    
    let solicitudId = 0;
    let codigoRespuesta = 0;
  
    $.ajax({
      url: "../data/devolucion_registro.php",
      dataType: 'json',
      type: "post",
      data: {
        id_devolucion:_devolucionId,
        motivo:_motivo,
        nodevolucion:_noDevolucion,
        registro_principal: data1,
        detalle_registro: data2        
      },
      success: function (object) {          
        $.each(object, function (i, respuesta) {
          codigoRespuesta = respuesta.codigo;          
        });
        if(codigoRespuesta == 1)
        {
          alertify.success("Registro almacenado con exito");
          //Validar_RegistroPedidoEnServidor(solicitudId, clienteId);
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
  
    //limpiar
  }