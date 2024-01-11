var MacAddressImpresora = '';
function GetNumeroRecibo() {
    var serieRecibo = document.getElementById("serie_recibo");
    var numeracionRecibo = document.getElementById("numero_recibo");

    // Agregar JSON a el select de Departamento
    //url: 'http://10.18.46.249/ventasmym/data/departamentos.php',
    var datos;
    $.ajax({
        url: '../data/recibo_numeracion.php',
        dataType: 'json',        
        success: function (object) {
            AsignarDatos(object);
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.log("Status: " + textStatus);
          console.log("Error: " + errorThrown);
          alertify.error("Ocurrió un error al consultar la numeración.");
        }
    });

    function AsignarDatos(object) {           
        $.each(object, function (id, recibo) {
            if (recibo.serie == -3) {
                alertify.error("No tiene recibos asociados.");
            }else{
                serieRecibo.value = recibo.serie;
                numeracionRecibo.value = recibo.norecibo;
                MacAddressImpresora = recibo.mac_address;
            }
         });         
    };
}


function GetMacAddress() {   
    var datos;
    $.ajax({
        url: '../data/recibo_impresora.php',
        dataType: 'json',        
        success: function (object) {
            AsignarMac(object);
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.log("Status: " + textStatus);
          console.log("Error: " + errorThrown);
          alertify.error("Ocurrió un error al consultar la numeración.");
        }
    });

    function AsignarMac(object) {           
        $.each(object, function (id, recibo) {
            if (recibo.mac_address == -3) {
                alertify.error("No tiene recibos asociados.");
            }else{                
                MacAddressImpresora = recibo.mac_address;
            }
         });         
    };
}