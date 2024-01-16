var textoDescuento = document.getElementById("mensajeDescuento");

function ExisteDescuento(codigoProducto) {        
    if (codigoProducto.length > 0) {
        /**
         * Se envía a la consulta el tipo de pago, para revisar si está asignado 
         * un producto con el tipo de pago crédito o contado
         */
        let tipo = document.getElementById("sltTipoPago").value;        
        let datos = { "codigo": codigoProducto.trim(),"tipo_pago":tipo.trim() }
        $.ajax({
            url: '../data/existe_descuento_producto.php',
            dataType: 'json',
            type: 'post',
            data: datos,
            success: function (object) {                  
               if (object[0].existe == 1) {
                 //se llama a la función que obtiene el porcentaje de descuento
                    PorcentajeDescuento(tipo);                 
               }                                    
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Status: " + textStatus);
                console.log("Error: " + errorThrown);
            }
        });
    }
}

/**
 * Ya no se utiliza porque se quito el descuento general, ahora los descuentos 
 * se asignan por producto, ya sea crédito o contado.
 */
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

function PorcentajeDescuento(tipo) {      
    let codigo = document.getElementById("codigo").value;     
    let datos = { "codigo": codigo.trim(),"tipo_pago":tipo }
    $.ajax({
        url: '../data/obtener_porcentaje_contado.php',
        dataType: 'json',
        type: 'post',
        data: datos,
        success: function (object) {                         
           if (object[0].porcentaje > 0) {
            document.getElementById("ctntMensaje").style.display = "flex";
            if(tipo.trim() == "CONTADO"){
            textoDescuento.innerText = "Producto con " + object[0].porcentaje + "% de descuento, solo con precio venta";
            }
            else{
                textoDescuento.innerText = "Producto con " + object[0].porcentaje + "% de descuento";
            }
            document.getElementById("porcentajeDescuento").value = object[0].porcentaje;  
        }                                    
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("Status: " + textStatus);
            console.log("Error: " + errorThrown);
        }
    });
}