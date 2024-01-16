var busquedaXCodigo = false;
var busquedaXNombre = false;
// Agregar JSON a el select de Departamento
function listaDepartamentos() {
    $.ajax({
        url: '../data/departamentos.php',
        dataType: 'json',
        success: function (object) {            
            var $select = $('#departamento');
            $.each(object, function (i, departamento) {
                $select.append('<option value=' + departamento.iddepartamento + '>' + departamento.nombre + '</option>');
            });

            listaClientes();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("Status: " + textStatus);
            console.log("Error: " + errorThrown);
        }
    });
}

function listaDepartamentosRecibo() {
    $.ajax({
        url: '../data/departamentos.php',
        dataType: 'json',
        success: function (object) {
            var $select = $('#departamento');
            $.each(object, function (i, departamento) {
                $select.append('<option value=' + departamento.iddepartamento + '>' + departamento.nombre + '</option>');
            });

            listaClientesConsultaPedido();
        }
    });
}
// Agregar JSON a el select de Departamento
function listaDepartamentosConsulta() {
    $.ajax({
        url: '../data/departamentos.php',
        dataType: 'json',
        success: function (object) {
            var $select = $('#depa');
            $.each(object, function (i, departamento) {
                $select.append('<option value=' + departamento.iddepartamento + '>' + departamento.nombre + '</option>');
            });

            listaClientesConsulta();
        }
    });
}

// Agregar JSON a el select de Departamento
function listaDepartamentosConsultaPedido() {
    $.ajax({
        url: '../data/departamentos.php',
        dataType: 'json',
        success: function (object) {
            var $select = $('#departamento');
            $.each(object, function (i, departamento) {
                $select.append('<option value=' + departamento.iddepartamento + '>' + departamento.nombre + '</option>');
            });

            listaClientesConsultaPedido();
        }
    });
}
/**
 * Se carga el listado de clientes
 */
function listaClientes() {
    let departamentoId = $('#departamento').val();
    let datos = { "iddepartamento": departamentoId }
    $.ajax({
        url: '../data/lista_clientes.php',
        dataType: 'json',
        type: 'post',
        data: datos,
        success: function (object) {
            // var $selectCliente = $('#cliente');
            //  $selectCliente.empty();
            //  $.each(object, function(i, cliente) {
            //      $selectCliente.append('<option value=' + cliente.id_cliente + '>' + cliente.nombre + '</option>');
            //  });
            ClientesMatch(object);
        }
    });
}

function listaClientesConsultaRegistro() {
    let departamentoId = $('#depa').val();
    let datos = { "iddepartamento": departamentoId }
    $.ajax({
        url: '../data/lista_clientes.php',
        dataType: 'json',
        type: 'post',
        data: datos,
        success: function (object) {
            /* var $selectCliente = $('#cliente');
             $selectCliente.empty();
             $.each(object, function(i, cliente) {
                 $selectCliente.append('<option value=' + cliente.idcliente + '>' + cliente.nombre + '</option>');
             });*/
            ClientesMatch(object);
        }
    });
}

function listaClientesConsulta() {
    let departamentoId = $('#departamento').val();    
    let datos = { "iddepartamento": departamentoId }
    $.ajax({
        url: '../data/lista_clientes.php',
        dataType: 'json',
        type: 'post',
        data: datos,
        success: function (object) {
            var $selectCliente = $('#cliente');
            $selectCliente.empty();
            $.each(object, function (i, cliente) {
                $selectCliente.append('<option value=' + cliente.idcliente + '>' + cliente.nombre + '</option>');
            });
            AsignarCliente();
        }        
    });
}

function listaClientesConsultaPedido() {
    let departamentoId = $('#departamento').val();
    let datos = { "iddepartamento": departamentoId }
    $.ajax({
        url: '../data/lista_clientes.php',
        dataType: 'json',
        type: 'post',
        data: datos,
        success: function (object) {
            var $selectCliente = $('#cliente');
            $selectCliente.empty();
            $.each(object, function (i, cliente) {
                $selectCliente.append('<option value=' + cliente.idcliente + '>' + cliente.nombre + '</option>');
            });
        }
    });
}
/**
 * Cargar el id, codigo, nombre y precios de productos según la sucursal a la que pertenece el vendedor.
 * El resultado se envía a las funciones codigoProducto: para establecer los códigos en una lista de autocompletar
 * y nombreProducto para establecer una lista de nombres para autocompletar.
 */
function listaProductos() {
    $.ajax({
        url: '../data/lista_productos.php',
        dataType: 'json',
        success: function (object) {                   
            codigoProducto(object);
            nombreProducto(object);
        }
    });
}

/**
 * Carga de los precios según el producto seleccionado
 */
function listaPrecios(codigo) {
    //let producto = document.getElementById('codigo').selectedOptions[0].getAttribute("data-valuep")
    //console.log(producto);
    //let codigo = $('#codigo').val();
    let datos = { "codigo": codigo }    
    $.ajax({
        url: '../data/lista_precios.php',
        dataType: 'json',
        type: 'post',
        data: datos,
        success: function (object) {
            var $selectPrecio = $('#tipo_precio');
            $selectPrecio.empty();
            let precioVenta = object[0].venta;
            let precioMinorista = object[0].minorista;
            let precioMayorista = object[0].mayorista;
            let precioEspecial = object[0].especial;
            let precioOferta = object[0].oferta;
            let precioDistribuidor = object[0].distribuidor;
            let precioUno = object[0].uno;
            let precioDos = object[0].dos;
            let precioTres = object[0].tres;
            let precioMasBajo;
            let inputPrecioMasBajo = document.getElementById("precioMasBajo");

            precioMasBajo = precioVenta;
           
            if (parseFloat(precioMinorista.toString()) > 0 && parseFloat(precioMinorista.toString()) < parseFloat(precioMasBajo.toString())) {
                precioMasBajo = precioMinorista;
            }
            if (parseFloat(precioMayorista.toString()) > 0 && parseFloat(precioMayorista.toString()) < parseFloat(precioMasBajo.toString())) {
                precioMasBajo = precioMayorista;
            }
            if (parseFloat(precioEspecial.toString()) > 0 && parseFloat(precioEspecial.toString()) < parseFloat(precioMasBajo.toString())) {
                precioMasBajo = precioEspecial;
            }
            if (parseFloat(precioOferta.toString()) > 0 && parseFloat(precioOferta.toString()) < parseFloat(precioMasBajo.toString())) {
                precioMasBajo = precioOferta;
            }
            if (parseFloat(precioDistribuidor.toString()) > 0 && parseFloat(precioDistribuidor.toString()) < parseFloat(precioMasBajo.toString())) {
                precioMasBajo = precioDistribuidor;
            }
            if (parseFloat(precioUno.toString()) > 0 && parseFloat(precioUno.toString()) < parseFloat(precioMasBajo.toString())) {
                precioMasBajo = precioUno;
            }
            if (parseFloat(precioDos.toString()) > 0 && parseFloat(precioDos.toString()) < parseFloat(precioMasBajo.toString())) {
                precioMasBajo = precioDos;
            }
            if (parseFloat(precioTres.toString()) > 0 && parseFloat(precioTres.toString()) < parseFloat(precioMasBajo.toString())) {
                precioMasBajo = precioTres;
            }
            
            inputPrecioMasBajo.value = precioMasBajo;            

            $selectPrecio.append('<option id="precioVenta" value=' + precioVenta + '> VENTA - ' + precioVenta + '</option>');
            $selectPrecio.append('<option id="precioTresUnidades" value=' + precioMinorista + '> 3 UNIDADES - ' + precioMinorista + '</option>');
            $selectPrecio.append('<option id="precioSeisUnidades" value=' + precioMayorista + '> 6 UNIDADES - ' + precioMayorista + '</option>');
            $selectPrecio.append('<option id="precioDoceUnidades" value=' + precioEspecial + '> 12 UNIDADES - ' + precioEspecial + '</option>');
            $selectPrecio.append('<option id="precioOferta" value=' + precioOferta + '> OFERTA - ' + precioOferta + '</option>');
            $selectPrecio.append('<option id="precioDistribuidor" value=' + precioDistribuidor + '> DISTRIBUIDOR - ' + precioDistribuidor + '</option>');
            $selectPrecio.append('<option id="precioUno" value=' + precioUno + '> UNO - ' + precioUno + '</option>');
            $selectPrecio.append('<option id="precioDos" value=' + precioDos + '> DOS - ' + precioDos + '</option>');
            $selectPrecio.append('<option id="precioTres" value=' + precioTres + '> TRES - ' + precioTres + '</option>');
            

            colocarPrecio();
        }
    });
}

/**
 * Carga el código del producto cuando se selecciona el nombre
 */
function getCodigo(producto) {
    //let producto = document.getElementById('codigo').selectedOptions[0].getAttribute("data-valuep")  
    //console.log("producto" +    producto);
    let codigoIngresado = document.getElementById("codigo");
    //let producto = document.getElementById("producto").value.trim(); //$('#producto').val();                
    
    if (producto.length > 0) {
        let datos = { "producto": producto.trim() }
        $.ajax({
            url: '../data/obtener_codigo.php',
            dataType: 'json',
            type: 'post',
            data: datos,
            success: function (object) {                             
                codigoIngresado.value = object[0].codigo;     
                listaPrecios(object[0].codigo);    
                CargarExistencia(object[0].codigo);                   
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Status: " + textStatus);
                console.log("Error: " + errorThrown);
            }
        });
    }
}

/**
 * Carga el nombre del producto cuando se selecciona el código
 */
function getNombreProducto(codigo) {
    //let producto = document.getElementById('codigo').selectedOptions[0].getAttribute("data-valuep")

    //let inputCodigo = document.getElementById("codigo");
    //let codigo = inputCodigo.value; //$('#producto').val();      
    let datos = { "codigo": codigo }
    
    if (codigo.length > 0 && codigo != "-3") {

        $.ajax({
            url: '../data/obtener_producto.php',
            dataType: 'json',
            type: 'post',
            data: datos,
            success: function (object) {                
                var $inputProducto = $('#producto');
                //$inputProducto.value = object[0].nombre;
                document.getElementById("producto").value = object[0].nombre;
            },
            error: function (jqXHR, textStatus, errorThrown) {                
                console.log("Status: " + textStatus);
                console.log("Error: " + errorThrown);
            }
        });
    }
    else {
        alertify.error('Debe ingresar un código válido.');
    }
}

/**
 * Carga el listado de productos como una lista de autocompletar
 * @param {Json} datos con el listado de códigos a cargar 
 */
function codigoProducto(datos) {    
    const data = [];

    /**
     * Se crea un arreglo que contiene solo los códigos de los productos de inventario
     * para crear la lista de autocompletar.
     */
    $.each(datos, function (i, producto) {
        data.push(producto.codigo);
    });

    /**
     * codigo: es el inputtext donde se colocará el código de producto seleccionado por el usuario.
     * results: es una lista desordenada ul que contendrá los códigos sugeridos que coicidan con el patrón
     * de búsqueda que vaya ingresando el usuario.
     */
    const autocomplete = document.getElementById("codigo");
    const resultsHTML = document.getElementById("results");

    /**
     * oninput, es cuando el usuario comience a escribir en el inputtext código
     */
    autocomplete.oninput = function () {
        let results = [];
        //this representa el inputtext codigo
        const userInput = this.value.toUpperCase();
        resultsHTML.innerHTML = "";
        if (userInput.length > 0) {
            results = getResults(userInput);
            resultsHTML.style.display = "block";
            for (i = 0; i < results.length; i++) {
                resultsHTML.innerHTML += "<li>" + results[i] + "</li>";
            }
        }
        resultsHTML.style.padding = "5px";
    };

    /**
     * Devuelve los resultados (codigos) que vayan coincidiendo con el patrón de búsqueda ingresado 
     * por el usuario, el cuál se recibe en el parámetro input.
     */
    function getResults(input) {
        const results = [];
        for (i = 0; i < data.length; i++) {
            if (input === data[i].slice(0, input.length)) {
                results.push(data[i]);
            }
        }
        return results;
    }

    /**
     * Se asocia el evento onclick a la lista de resultados sugeridos,
     * cuando el usuario lo selecciona, el valor se establece en el inputtext codigo
     * y se ejecutan las funciones:
     * getNombreProducto(): para obtener el nombre del producto según el código seleccionado.
     * listaPrecios(): para establecer el listado de precios del producto según el código seleccionado.
     * CargarExistencia(): para obtener la existencia del producto según el código seleccionado. 
     */
    resultsHTML.onclick = function (event) {
        const setValue = event.target.innerText;
        autocomplete.value = setValue;
        this.innerHTML = "";
        resultsHTML.style.padding = "0";
        getNombreProducto(autocomplete.value);
        listaPrecios(autocomplete.value);
        CargarExistencia(autocomplete.value);        
        ExisteDescuento(autocomplete.value);
    };
}

/**
 * Carga el listado de productos como una lista de autocompletar
 * @param {Json} datos con el listado de códigos a cargar 
 */
function nombreProducto(datos) {
    const data = [];    
    $.each(datos, function (i, producto) {
        data.push(producto.nombre);
    });

    
    const autocompleteProducto = document.getElementById("producto");
    const resultsHTMLProducto = document.getElementById("resultsProducto");

    autocompleteProducto.oninput = function () {
        let results = [];
        const userInput = this.value.toUpperCase();
        resultsHTMLProducto.innerHTML = "";
        if (userInput.length > 0) {
            //console.log(userInput);
            results = getResults(userInput);
            if(results !== undefined)
            {
            resultsHTMLProducto.style.display = "block";
            for (i = 0; i < results.length; i++) {
                resultsHTMLProducto.innerHTML += "<li>" + results[i] + "</li>";
            }
        }
        }
        resultsHTMLProducto.style.padding = "5px";
    };

    /*
    - Este método busca dentro del arreglo de productos
    aquellos registros que contengan las palabras que el usuario
    vaya ingresando en el control de producto.
    */
    function getResults(input) {
        if(input.length > 2)
        {
        const results = [];
        for (i = 0; i < data.length; i++) {
            //if (input === data[i].slice(0, input.length)) {
            if (data[i].includes(input)) {
                    //console.log(input);
                    //console.log(data[i]);
                results.push(data[i]);
            }
        }
        return results;
        }
    }

    resultsHTMLProducto.onclick = function (event) {
        const setValue = event.target.innerText;            
        autocompleteProducto.value = setValue;        
        this.innerHTML = "";
        resultsHTMLProducto.style.padding = "0";
        //document.getElementById('codigo').value = '';
        //autocompleteProducto.focus();
        //console.log(autocompleteProducto.value);
        getCodigo(autocompleteProducto.value);
    };
}

/**
 * Según el tipo de precio, se colocal el precio en el input
 * correspondiente.
 */

function colocarPrecio() {
    let precio = document.getElementById('tipo_precio').value;    
    if (parseFloat(precio) > 0) {
        document.getElementById('precio').value = precio;
    }
    else {
        alertify.error('El precio seleccionado es cero');
    }
}



/**
 * 
 * @param {array - Json} listado de clientes obtenidos desde la db
 * filtra la lista de un campo autocompletar para clientes
 */
function ClientesMatch(datos) {
    const data = [];

    $.each(datos, function (i, item) {
        data.push(item.nombre + "&" + item.idcliente);
    });

    //console.log(data);
    const autocompleteCliente = document.getElementById("cliente");
    const resultsClienteHTML = document.getElementById("ulclienteresult");

    autocompleteCliente.oninput = function () {
        let results = [];
        const userInput = this.value.toUpperCase();
        resultsClienteHTML.innerHTML = "";
        if (userInput.length > 0) {
            results = getResultsClientes(userInput);
            resultsClienteHTML.style.display = "block";
            for (i = 0; i < results.length; i++) {
                resultsClienteHTML.innerHTML += "<li>" + results[i] + "</li>";
            }
        }
        resultsClienteHTML.style.padding = "5px";
    };

    function getResultsClientes(input) {
        const results = [];
        for (i = 0; i < data.length; i++) {
            if (input === data[i].slice(0, input.length)) {
                results.push(data[i]);
            }
        }
        return results;
    }

    resultsClienteHTML.onclick = function (event) {
        const setValue = event.target.innerText;
        let clienteIdDireccion = 0;
        let valoresCliente = setValue.toString().split("&");       
        autocompleteCliente.value = valoresCliente[0];//setValue;
        autocompleteCliente.dataset.id = valoresCliente[1];
        clienteIdDireccion = valoresCliente[1];


        this.innerHTML = "";
        resultsClienteHTML.style.padding = "0";
        autocompleteCliente.focus();
        obtenerDireccionCliente(clienteIdDireccion);
        // GetSaldoCliente(valoresCliente[1]);
        
    };
}

function obtenerIdCliente() {
    let cliente = document.getElementById("cliente");
    //console.log(cliente.dataset.id);
}

function listaPrioridad() {
    var $sltPrioridad = $('#sltPrioridad');
    $sltPrioridad.append('<option value="NORMAL">NORMAL</option>');
    $sltPrioridad.append('<option value="URGENTE">URGENTE</option>');
    $sltPrioridad.append('<option value="PREVENTA">PREVENTA</option>');
}

function listaTipoPago() {
    var $stlTipoPago = $('#sltTipoPago');
    $stlTipoPago.append('<option value="CREDITO">CREDITO</option>');
    $stlTipoPago.append('<option value="CONTADO">CONTADO</option>');    
}
/**
 * Buscar la existencia para un producto indicado
 * tanto en sa como en mym
 */
function CargarExistencia(codigo) {
    //let producto = document.getElementById('codigo').selectedOptions[0].getAttribute("data-valuep")
    //console.log(producto);
    //let codigo = $('#codigo').val();
    let datos = { "codigo": codigo }
    $.ajax({
        url: '../data/cargar_existencia.php',
        dataType: 'json',
        type: 'post',
        data: datos,
        success: function (object) {            
            let existencia = 0;
            let inputExistencia = document.getElementById("existencia");
           
            /**
             * se recorren los dos resultados que devuelve la consulta 
             * y se suman esas existencias para colocarlas en el control para que la vea 
             * el usuario.
             */
            $.each(object, function (i, resultado) {
                existencia += parseFloat(resultado.existencia);
            });
            inputExistencia.value = existencia;
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("Otro: " + jqXHR);
            console.log("Status: " + textStatus);
            console.log("Error: " + errorThrown);
        }
    });
}

function limpiarNombre() {
    document.getElementById("producto").value = "";
}

function limpiarCodigo() {
    document.getElementById("codigo").value = "";
}


function obtenerDireccionCliente(idCliente) {
    let datos = { "idcliente": idCliente }
    $.ajax({
        url: '../data/obtener_direccion.php',
        dataType: 'json',
        type: 'post',
        data: datos,
        success: function (object) {
            let direccionClienteInput = document.querySelector("#direccion_cliente");
            let direccion = '';
            $.each(object, function (i, resultado) {
                direccion += resultado.direccion;
            });
            if(direccionClienteInput !== null)
            {
            direccionClienteInput.value = direccion;
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("Otro: " + jqXHR);
            console.log("Status: " + textStatus);
            console.log("Error: " + errorThrown);
        }
    });
}
