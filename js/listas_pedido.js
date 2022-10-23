// Agregar JSON a el select de Departamento
function listaDepartamentos() {
    $.ajax({
        url: '../data/departamentos.php',
        dataType: 'json',
        success: function(object) {
            var $select = $('#departamento');
            $.each(object, function(i, departamento) {
                $select.append('<option value=' + departamento.iddepartamento + '>' + departamento.nombre + '</option>');
            });

            listaClientes();
        }
    });
}
// Agregar JSON a el select de Departamento
function listaDepartamentosConsulta() {
    $.ajax({
        url: '../data/departamentos.php',
        dataType: 'json',
        success: function(object) {
            var $select = $('#depa');
            $.each(object, function(i, departamento) {
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
        success: function(object) {
            var $select = $('#departamento');
            $.each(object, function(i, departamento) {
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
        success: function(object) {
           /* var $selectCliente = $('#cliente');
            $selectCliente.empty();
            $.each(object, function(i, cliente) {
                $selectCliente.append('<option value=' + cliente.idcliente + '>' + cliente.nombre + '</option>');
            });*/            
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
        success: function(object) {
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
    let departamentoId = $('#depa').val();
    let datos = { "iddepartamento": departamentoId }
    $.ajax({
        url: '../data/lista_clientes.php',
        dataType: 'json',
        type: 'post',
        data: datos,
        success: function(object) {
           var $selectCliente = $('#cliente');
            $selectCliente.empty();
            $.each(object, function(i, cliente) {
                $selectCliente.append('<option value=' + cliente.idcliente + '>' + cliente.nombre + '</option>');
            });            
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
        success: function(object) {
           var $selectCliente = $('#cliente');
            $selectCliente.empty();
            $.each(object, function(i, cliente) {
                $selectCliente.append('<option value=' + cliente.idcliente + '>' + cliente.nombre + '</option>');
            });            
        }
    });           
}
/**
 * Cargar el código de los productos
 */
function listaProductos() {
    $.ajax({
        url: '../data/lista_productos.php',
        dataType: 'json',
        success: function(object) {
            codigoProducto(object);
            nombreProducto(object);
        }
    });
}

/**
 * Carga de los precios según el producto seleccionado
 */
function listaPrecios() {
    //let producto = document.getElementById('codigo').selectedOptions[0].getAttribute("data-valuep")
    //console.log(producto);
    let codigo = $('#codigo').val();    
    let datos = { "codigo": codigo }
    $.ajax({
        url: '../data/lista_precios.php',
        dataType: 'json',
        type: 'post',
        data: datos,
        success: function(object) {
            var $selectPrecio = $('#tipo_precio');
            $selectPrecio.empty();
            let precioVenta = object[0].venta;
            let precioUno = object[0].uno;
            let precioDos = object[0].dos;
            let precioTres = object[0].tres;
            let precioMasBajo;
            let inputPrecioMasBajo = document.getElementById("precioMasBajo");

            let precioAuxiliar;
            precioAuxiliar = precioVenta;
            
            if(precioUno > 0 && precioUno < precioAuxiliar)
            {
                precioAuxiliar = precioUno;
            }
            if(precioDos > 0 && precioDos < precioAuxiliar)
            {
                precioAuxiliar = precioDos;
            }
            if(precioTres > 0 && precioTres < precioAuxiliar)
            {
                precioAuxiliar = precioTres;                
            }
                    
            precioMasBajo = precioAuxiliar;
            inputPrecioMasBajo.value = precioMasBajo;            

            $selectPrecio.append('<option value=' + precioVenta + '> VENTA - ' + precioVenta + '</option>');
            $selectPrecio.append('<option value=' + precioUno + '> UNO - ' + precioUno + '</option>');
            $selectPrecio.append('<option value=' + precioDos + '> DOS - ' + precioDos + '</option>');
            $selectPrecio.append('<option value=' + precioTres + '> TRES - ' + precioTres + '</option>');
        }
    });    
}

/**
 * Carga el código del producto cuando se selecciona el nombre
 */
function getCodigo() {
    //let producto = document.getElementById('codigo').selectedOptions[0].getAttribute("data-valuep")    
    let codigoIngresado = document.getElementById("codigo");    
    let producto = document.getElementById("producto").value.trim(); //$('#producto').val();            
    let datos = { "producto": producto }
    $.ajax({
        url: '../data/obtener_codigo.php',
        dataType: 'json',
        type: 'post',
        data: datos,
        success: function(object) {
            codigoIngresado.value = object[0].codigo;    
            listaPrecios();        
        }
    });        
}

/**
 * Carga el nombre del producto cuando se selecciona el código
 */
function getNombreProducto() {
    //let producto = document.getElementById('codigo').selectedOptions[0].getAttribute("data-valuep")
    let codigo = document.getElementById("codigo").value; //$('#producto').val();      
    let datos = { "codigo": codigo }

    $.ajax({
        url: '../data/obtener_producto.php',
        dataType: 'json',
        type: 'post',
        data: datos,
        success: function(object) {
            var $inputProducto = $('#producto');
            //$inputProducto.value = object[0].nombre;
            document.getElementById("producto").value = object[0].nombre;
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("Status: " + textStatus);
            console.log("Error: " + errorThrown);
        }
    });
}

/**
 * Carga el listado de productos como una lista de autocompletar
 * @param {Json} datos con el listado de códigos a cargar 
 */
function codigoProducto(datos) {

    const data = [];

    $.each(datos, function(i, producto) {
        data.push(producto.codigo);
    });

    //console.log(data);
    const autocomplete = document.getElementById("codigo");
    const resultsHTML = document.getElementById("results");

    autocomplete.oninput = function() {
        let results = [];
        const userInput = this.value;
        resultsHTML.innerHTML = "";
        if (userInput.length > 0) {
            results = getResults(userInput);
            resultsHTML.style.display = "block";
            for (i = 0; i < results.length; i++) {
                resultsHTML.innerHTML += "<li>" + results[i] + "</li>";
            }
        }
        resultsHTML.style.padding = "1%";
    };

    function getResults(input) {
        const results = [];
        for (i = 0; i < data.length; i++) {
            if (input === data[i].slice(0, input.length)) {
                results.push(data[i]);
            }
        }
        return results;
    }

    resultsHTML.onclick = function(event) {
        const setValue = event.target.innerText;
        autocomplete.value = setValue;
        this.innerHTML = "";
        resultsHTML.style.padding = "0";
        autocomplete.focus();
    };
}

/**
 * Carga el listado de productos como una lista de autocompletar
 * @param {Json} datos con el listado de códigos a cargar 
 */
function nombreProducto(datos) {

    const data = [];

    $.each(datos, function(i, producto) {
        data.push(producto.nombre);
    });

    //console.log(data);
    const autocompleteProducto = document.getElementById("producto");
    const resultsHTMLProducto = document.getElementById("resultsProducto");

    autocompleteProducto.oninput = function() {
        let results = [];
        const userInput = this.value;
        resultsHTMLProducto.innerHTML = "";
        if (userInput.length > 0) {
            results = getResults(userInput);
            resultsHTMLProducto.style.display = "block";
            for (i = 0; i < results.length; i++) {
                resultsHTMLProducto.innerHTML += "<li>" + results[i] + "</li>";
            }
        }
        resultsHTMLProducto.style.padding = "1%";
    };

    function getResults(input) {
        const results = [];
        for (i = 0; i < data.length; i++) {
            if (input === data[i].slice(0, input.length)) {
                results.push(data[i]);
            }
        }
        return results;
    }

    resultsHTMLProducto.onclick = function(event) {
        const setValue = event.target.innerText;
        autocompleteProducto.value = setValue;
        this.innerHTML = "";
        resultsHTMLProducto.style.padding = "0";
        //document.getElementById('codigo').value = '';
        autocompleteProducto.focus();
    };
}

/**
 * Según el tipo de precio, se colocal el precio en el input
 * correspondiente.
 */

 function colocarPrecio()
 {
     document.getElementById('precio').value = document.getElementById('tipo_precio').value;    
 }



 /**
  * 
  * @param {array - Json} listado de clientes obtenidos desde la db
  * filtra la lista de un campo autocompletar para clientes
  */
 function ClientesMatch(datos) {    
    const data = [];

    $.each(datos, function(i, item) {
        data.push(item.nombre + "&" + item.idcliente);
    });

    //console.log(data);
    const autocompleteCliente = document.getElementById("cliente");
    const resultsClienteHTML = document.getElementById("ulclienteresult");

    autocompleteCliente.oninput = function() {
        let results = [];
        const userInput = this.value;
        resultsClienteHTML.innerHTML = "";
        if (userInput.length > 0) {
            results = getResultsClientes(userInput);
            resultsClienteHTML.style.display = "block";
            for (i = 0; i < results.length; i++) {
                resultsClienteHTML.innerHTML += "<li>" + results[i] + "</li>";
            }
        }
        resultsClienteHTML.style.padding = "1%";
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

    resultsClienteHTML.onclick = function(event) {
        const setValue = event.target.innerText;
        let valoresCliente = setValue.toString().split("&");

        autocompleteCliente.value = valoresCliente[0];//setValue;
        autocompleteCliente.dataset.id = valoresCliente[1];

        this.innerHTML = "";
        resultsClienteHTML.style.padding = "0";
        autocompleteCliente.focus();
    };
}

function obtenerIdCliente()
{
    let cliente = document.getElementById("cliente");
    //console.log(cliente.dataset.id);
}

function listaPrioridad()
{
    var $sltPrioridad = $('#sltPrioridad');    
    $sltPrioridad.append('<option value="NORMAL">NORMAL</option>');
    $sltPrioridad.append('<option value="URGENTE">URGENTE</option>');
}

/**
 * Buscar la existencia para un producto indicado
 * tanto en sa como en mym
 */
function CargarExistencia() {
    //let producto = document.getElementById('codigo').selectedOptions[0].getAttribute("data-valuep")
    //console.log(producto);
    let codigo = $('#codigo').val();        
    let datos = { "codigo": codigo }
    $.ajax({
        url: '../data/cargar_existencia.php',
        dataType: 'json',
        type: 'post',
        data: datos,
        success: function(object) {
            
            let existencia = object[0].existencia;            
            let inputExistencia = document.getElementById("existencia");           
            inputExistencia.value = existencia;
        }
    });    
}