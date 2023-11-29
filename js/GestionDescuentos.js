var textoDescuento = document.getElementById("mensajeDescuento");

function ExisteDescuento(codigoProducto) {        
    if (codigoProducto.length > 0) {
        let datos = { "codigo": codigoProducto.trim() }
        $.ajax({
            url: '../data/existe_descuento_producto.php',
            dataType: 'json',
            type: 'post',
            data: datos,
            success: function (object) {                  
               if (object[0].existe == 1) {
                 if (document.getElementById("sltTipoPago").value == "CREDITO") {
                    PorcentajeCredito();
                 }else{
                    PorcentajeContado();
                 }
               }                                    
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Status: " + textStatus);
                console.log("Error: " + errorThrown);
            }
        });
    }
}

function PorcentajeCredito() {        
        $.ajax({
            url: '../data/obtener_porcentaje_credito.php',
            dataType: 'json',
            type: 'post',
            // data: datos,
            success: function (object) {                
               if (object[0].porcentaje > 0) {
                document.getElementById("ctntMensaje").style.display = "flex";
                textoDescuento.innerText = "Producto con " + object[0].porcentaje + "% de descuento";
                document.getElementById("porcentajeDescuento").value = object[0].porcentaje;
            }                                    
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Status: " + textStatus);
                console.log("Error: " + errorThrown);
            }
        });
}

function PorcentajeContado() {   
    let codigo = document.getElementById("codigo").value;     
    let datos = { "codigo": codigo.trim() }
    $.ajax({
        url: '../data/obtener_porcentaje_contado.php',
        dataType: 'json',
        type: 'post',
        data: datos,
        success: function (object) {                
           if (object[0].porcentaje > 0) {
            document.getElementById("ctntMensaje").style.display = "flex";
            textoDescuento.innerText = "Producto con " + object[0].porcentaje + "% de descuento, precio venta";
            document.getElementById("porcentajeDescuento").value = object[0].porcentaje;  
        }                                    
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("Status: " + textStatus);
            console.log("Error: " + errorThrown);
        }
    });
}