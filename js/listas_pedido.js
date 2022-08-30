// Agregar JSON a el select de Departamento
function listaDepartamentos() {
    $.ajax({
        url: 'http://192.168.0.6/ventasmym/data/departamentos.php',
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

/**
 * Se carga el listado de clientes
 */
function listaClientes() {
    let departamentoId = $('#departamento').val();
    let datos = { "iddepartamento": departamentoId }
    $.ajax({
        url: 'http://192.168.0.6/ventasmym/data/lista_clientes.php',
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
        url: 'http://192.168.0.6/ventasmym/data/lista_productos.php',
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
        url: 'http://192.168.0.6/ventasmym/data/lista_precios.php',
        dataType: 'json',
        type: 'post',
        data: datos,
        success: function(object) {
            var $selectPrecio = $('#tipo_precio');
            $selectPrecio.empty();

            $selectPrecio.append('<option value=' + object[0].venta + '> VENTA - ' + object[0].venta + '</option>');
            $selectPrecio.append('<option value=' + object[0].uno + '> UNO - ' + object[0].uno + '</option>');
            $selectPrecio.append('<option value=' + object[0].dos + '> DOS - ' + object[0].dos + '</option>');
            $selectPrecio.append('<option value=' + object[0].tres + '> TRES - ' + object[0].tres + '</option>');
        }
    });    
}

/**
 * Carga el código del producto cuando se selecciona el nombre
 */
function getCodigo() {
    //let producto = document.getElementById('codigo').selectedOptions[0].getAttribute("data-valuep")    
    let codigoIngresado = document.getElementById("codigo").value.trim();
    let producto = document.getElementById("producto").value.trim(); //$('#producto').val();        
    let datos = { "producto": producto }
    $.ajax({
        url: 'http://192.168.0.6/ventasmym/data/obtener_codigo.php',
        dataType: 'json',
        type: 'post',
        data: datos,
        success: function(object) {
            document.getElementById("codigo").value = object[0].codigo;
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
        url: 'http://192.168.0.6/ventasmym/data/obtener_producto.php',
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
        results.style.padding = "1%";
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