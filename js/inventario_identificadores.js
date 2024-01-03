function ListaIdentificadores() {
    var datos;
    var id;
    var $select = $('#selectInventario');

    // Agregar JSON a el select de Departamento
    //url: 'http://10.18.46.249/ventasmym/data/departamentos.php',
    $.ajax({
        url: '../data/inventario_identificadores.php',
        dataType: 'json',
        success: function (object) {
            // console.log(object);
            AsignarIdentificadores(object);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("Status: " + textStatus);
            console.log("Error: " + errorThrown);
            alertify.error("Ocurrió un error en la validación!");
        },
    });

    function AsignarIdentificadores(datos) {
        $.each(datos, function (id, name) {
            $select.append('<option value=' + name.ididentificadorinventario + '>' + name.nombre + '</option>');
        });
    };
}

/**
 * Este método verifica si el código que se está ingresando ya existe en el inventario contado
 * si existe, muestra mensaje al usuario para no agregar otra línea del mismo producto, o bien eliminar 
 * la existente y agregar una nueva.
 */
function BuscarProductoContado() {
    let codigo = document.getElementById('txtCodigo').value;
    let idIdentificador = document.getElementById('selectInventario').value;
    let idUbicacion = document.getElementById('selectUbicacion').value;

    //let departamentoId = $('#departamento').val();
    let datos = {
        "codigo": codigo.trim(),
        "identificador": idIdentificador,
        "idubicacion": idUbicacion
    }

    $.ajax({
        url: '../data/inventario_buscar_producto_conteo.php',
        dataType: 'json',
        type: 'post',
        data: datos,
        success: function (object) {
            ValidacionProductoContado(object);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("Status: " + textStatus);
            console.log("Error: " + errorThrown);
        }
    });
}

function ValidacionProductoContado(object) {
    //console.log(object);

    $.each(object, function (id, registro) {
        if (registro.codigo === -3) {
            // alertify.success('El registro es válido');
            BuscarProducto(registro.codigo);
        }
        else {
            alertify.error('El producto ya fue contando');
            //aquí va la carga del producto encontrado
        }
    });
}

/**
 * Busca un producto según el código o nombre ingresado por el usuario.
 */
function BuscarProducto() {
    let buscar = false;
    let codigo = document.getElementById('txtCodigo').value;
    if (codigo.trim().length == 0) {
        codigo = document.getElementById('txtDescripcion').value;
        if (codigo.trim().length > 0) {
            buscar = true;
        }
    }
    else {
        buscar = true;
    }

    if (buscar == false) {
        return;
    }

    //let departamentoId = $('#departamento').val();
    let datos = { "codigo": codigo.trim() }

    $.ajax({
        url: '../data/inventario_buscar_producto.php',
        dataType: 'json',
        type: 'post',
        data: datos,
        success: function (object) {
            CargarDatosProducto(object);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("Status: " + textStatus);
            console.log("Error: " + errorThrown);
        }
    });
}

/**
 * Esta función carga los datos de la consulta de un producto a los controles correspondientes
 * en el formulario. 
 * @param {*} object 
 */
function CargarDatosProducto(object) {
    let txtCodigo = document.getElementById('txtCodigo');
    let txtDescripcion = document.getElementById('txtDescripcion');
    let txtExistencia = document.getElementById('txtExistenciaActual');
    let txtIdProducto = document.getElementById('txtIdProducto');
    let txtCosto = document.getElementById('txtCosto');
    let txtPromedioPonderado = document.getElementById('txtPromedioPonderado');
    let txtUltimaCompra = document.getElementById('txtUltimaCompra');
    
    $.each(object, function (id, registro) {
        if (registro.codigo === -3) {
            alertify.error('No se encontró el registro');
        }
        else {
            if (txtCodigo.value.trim().length == 0) {
                alertify.error("Debe ingresar el código del producto");
            }
            else {                
                txtDescripcion.value = registro.nombre.trim();
                txtExistencia.value = registro.existencia;

                txtIdProducto.value = registro.idproducto;
                txtCosto.value = registro.costo;
                txtPromedioPonderado.value = registro.promedio_ponderado;
                txtUltimaCompra.value = registro.ultima_compra;
            }
        }
    });
}

function DiferenciaExistencia() {
    let existenciaActual = document.getElementById("txtExistenciaActual").value;
    let existenciaFisica = document.getElementById("txtExistenciaFisica").value;
    let txtDiferencia = document.getElementById("txtDiferencia");

    if (parseInt(existenciaActual) > 0 && parseInt(existenciaFisica) > 0) {
        let diferencia = parseInt(existenciaActual) - parseInt(existenciaFisica);

        txtDiferencia.value = diferencia;
    }
}

function GuardarRegistroConteo() {
    let productoId = document.getElementById('txtIdProducto').value;
    let codigoProducto = document.getElementById('txtCodigo').value;
    let nombreProducto = document.getElementById('txtDescripcion').value;
    let existenciaFisica = document.getElementById('txtExistenciaFisica').value;
    let existenciaSistema = document.getElementById('txtExistenciaActual').value;
    let diferencia = document.getElementById('txtDiferencia').value;
    let costo = document.getElementById('txtCosto').vlaue;
    let promedioPonderado = document.getElementById('txtPromedioPonderado').value;
    let ultimaCompra = document.getElementById('txtUltimaCompra').value;
    let observaciones = document.getElementById('txtObservaciones').value;
    let identificadorId = document.getElementById('selectInventario').value;
    let selectInventario = document.getElementById('selectInventario');
    let nombreIdentificador = selectInventario.options[selectInventario.selectedIndex].text;
    //usuario se ingresa desde el backend
    //fecha registro se ingresa desde el backend
    let selectUbicacion = document.getElementById('selectUbicacion');
    let nombreUbicacion = selectUbicacion.options[selectUbicacion.selectedIndex].text;
    let ubicacionId = document.getElementById('selectUbicacion').value;

    var registroConteo = new Array();
    var jsonRegistro = {
        idProducto: productoId,
        codigo: codigoProducto,
        nombre: nombreProducto,
        existencia_fisica: existenciaFisica,
        existencia_sistema: existenciaSistema,
        diferencia_conteo: diferencia,
        costo_producto: costo,
        promedio_ponderado: promedioPonderado,
        ultima_compra: ultimaCompra,
        observaciones_conteo: observaciones,
        idIdentificador: identificadorId,
        nombre_identificador: nombreIdentificador,
        nombre_ubicacion: nombreUbicacion,
        idUbicacion: ubicacionId
    };
    
    registroConteo.push(jsonRegistro);

    var datos = JSON.stringify(registroConteo);
    
    console.log(datos);
    $.ajax({
        url: "../data/inventario_registro_producto_contado.php",
        dataType: 'json',
        type: "post",
        data: {
            registro_principal: datos,
        },
        success: function (object) {
            console.log(object);
            $.each(object, function (i, respuesta) {
                codigoRespuesta = respuesta.codigo;
                console.log(codigoRespuesta);
            });
            // if (codigoRespuesta == 1) {
            //     //alertify.success("Registro almacenado con exito");
            //     Validar_RegistroPedidoEnServidor(solicitudId, clienteId);
            // }
            // else {
            //     alertify.error("No se pudo almacenar el registro");
            // }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("Status: " + textStatus);
            console.log("Error: " + errorThrown);
            alertify.error("Ocurrió un error al guardar el registro");
        },
    });
}