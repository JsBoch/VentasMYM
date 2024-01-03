function CalculoSubtotal() {
    let precio = document.getElementById("precio").value;
    let cantidad = document.getElementById("cantidad").value;
    let precioMasBajo = document.getElementById("precioMasBajo").value;
    let porcentajeDescuento = document.getElementById("porcentajeDescuento").value;
    let objTipoPrecio = document.getElementById("tipo_precio");
    let selected = objTipoPrecio.options[objTipoPrecio.selectedIndex].text;
    let arrSplit = selected.split("-");
    let tipoPrecio = arrSplit[0];

    // let sumaTotalInput = document.getElementById("totalGeneral");
    let sumaTotal = 0;

    let subtotalItem = 0;
    let totalItem = 0;
    let descuentoItem = 0;

    // if (sumaTotalInput.innerText.trim().length > 0) {
    //     sumaTotal = parseFloat(sumaTotalInput.innerText);
    // }    

    if (precio.length == 0 || parseFloat(precio) == 0) {
        document.getElementById("subtotal").value = "";
        //alertify.error("Debe ingresar un precio válido");
    } else if (cantidad.length == 0 || parseFloat(cantidad) == 0) {
        document.getElementById("subtotal").value = "";
        //alertify.error("Debe ingresar una cantidad válida");
    }
    else {
        if (parseFloat(precio.toString()) >= parseFloat(precioMasBajo.toString())) {
            
            if (precio.length > 0 && cantidad.length > 0) {
                subtotalItem = precio * cantidad;
                if (document.getElementById("sltTipoPago").value.toString().trim() == "CREDITO") {
                    if (porcentajeDescuento.length > 0 && parseFloat(porcentajeDescuento) > 0) {
                        descuentoItem = subtotalItem * porcentajeDescuento / 100;
                    }

                } else {
                    if (tipoPrecio.trim() === "VENTA") {
                        if (porcentajeDescuento.length > 0 && parseFloat(porcentajeDescuento) > 0) {
                            descuentoItem = subtotalItem * porcentajeDescuento / 100;
                        }
                    }
                }
                totalItem = subtotalItem - descuentoItem;

            }
            document.getElementById("total").value = subtotalItem;
            document.getElementById("descuento").value = descuentoItem;
            document.getElementById("subtotal").value = totalItem;
        } else {
            //mensaje de precio mas bajo        
            alertify.error("El precio es más bajo de lo autorizado");
            document.getElementById("precio").value = precioMasBajo;            
            if (precioMasBajo.length > 0 && cantidad.length > 0) {
                subtotalItem = precioMasBajo * cantidad;
                if (document.getElementById("sltTipoPago").value.toString().trim() == "CREDITO") {
                    if (porcentajeDescuento.length > 0 && parseFloat(porcentajeDescuento) > 0) {
                        descuentoItem = subtotalItem * porcentajeDescuento / 100;
                    }

                } else {
                    if (tipoPrecio.trim() === "VENTA") {
                        if (porcentajeDescuento.length > 0 && parseFloat(porcentajeDescuento) > 0) {
                            descuentoItem = subtotalItem * porcentajeDescuento / 100;
                        }
                    }
                }
                totalItem = subtotalItem - descuentoItem;
            }
            document.getElementById("total").value = subtotalItem;
            document.getElementById("descuento").value = descuentoItem;
            document.getElementById("subtotal").value = totalItem;
        }
        
        sumaTotal += parseFloat(totalItem);        
        sumaTotalInput.value = sumaTotal;
    }
}

function validarPrecioConCantidad() {
    let cantidad = document.getElementById("cantidad").value;
    if (parseInt(cantidad) == 3) {
        $("#tipo_precio option[id='precioTresUnidades']").attr("selected", true);
    }
    else if (parseInt(cantidad) == 6) {
        $("#tipo_precio option[id='precioSeisUnidades']").attr("selected", true);
    }
    else if (parseInt(cantidad) == 12) {
        $("#tipo_precio option[id='precioDoceUnidades']").attr("selected", true);
    }
    else {
        $("#tipo_precio option[id='precioVenta']").attr("selected", true);
    }
}