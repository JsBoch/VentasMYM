 var tablaEstadoCuenta = new DataTable('#estadoCuenta');


function listaDepartamentosEstadoCuenta() {
    $.ajax({
        url: '../data/departamentos.php',
        dataType: 'json',
        success: function (object) {
            var $select = $('#sltDepartamentoEC');
            $.each(object, function (i, departamento) {
                $select.append('<option value=' + departamento.iddepartamento + '>' + departamento.nombre + '</option>');
            });

            listaClientesEC();
        }
    });
}

/**
 * Se carga el listado de clientes
 */
function listaClientesEC() {
    let departamentoId = $('#sltDepartamentoEC').val();
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
            ClientesMatchEC(object);
        }
    });
}

/**
 * 
 * @param {array - Json} listado de clientes obtenidos desde la db
 * filtra la lista de un campo autocompletar para clientes
 */
function ClientesMatchEC(datos) {
    const data = [];

    $.each(datos, function (i, item) {
        data.push(item.nombre + "&" + item.idcliente);
    });

    //console.log(data);
    const autocompleteCliente = document.getElementById("clienteEC");
    const resultsClienteHTML = document.getElementById("ulClienteECResult");

    autocompleteCliente.oninput = function () {
        let results = [];
        const userInput = this.value.toUpperCase();
        resultsClienteHTML.innerHTML = "";
        if (userInput.length > 0) {
            results = getResultsClientesEC(userInput);
            resultsClienteHTML.style.display = "block";
            for (i = 0; i < results.length; i++) {
                resultsClienteHTML.innerHTML += "<li>" + results[i] + "</li>";
            }
        }
        resultsClienteHTML.style.padding = "5px";
    };

    function getResultsClientesEC(input) {
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
        obtenerDireccionClienteEC(clienteIdDireccion);
    };
}

//let departamentoId = $('#departamento').val();

function obtenerDireccionClienteEC(idCliente) {
    let datos = { "idcliente": idCliente }
    $.ajax({
        url: '../data/obtener_direccion.php',
        dataType: 'json',
        type: 'post',
        data: datos,
        success: function (object) {
            let direccionClienteInput = document.querySelector("#direccion_clienteEC");
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

function ConsultarEstadoCuenta() {
    const autocompleteCliente = document.getElementById("clienteEC");
    let idCliente = autocompleteCliente.dataset.id;
    
    let datos = { "idcliente": idCliente }
    $.ajax({
        url: '../data/consulta_ec_cliente.php',
        dataType: 'json',
        type: 'post',
        data: datos,
        success: function (object) {            
            /*$.each(object, function (i, resultado) {
                console.log(resultado.nofactura);
            });*/
            GenerarTabla(object);         
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("Otro: " + jqXHR);
            console.log("Status: " + textStatus);
            console.log("Error: " + errorThrown);
        }
    });
}

function GenerarTabla(object){    
    tablaEstadoCuenta.clear().draw();
    $.each(object, function (i, resultado) {
        const formatoMoneda = new Intl.NumberFormat("es-GT", {
            style: "currency",
         currency: "GTQ",
             minimumFractionDigits: 2,
       });
        tablaEstadoCuenta.row
        .add([
            resultado.nofactura,
            formatoMoneda.format(resultado.monto),
            formatoMoneda.format(resultado.abono),
            formatoMoneda.format(resultado.saldo),
            resultado.dias_vencimiento
        ])
        .draw(false);
    });  
}

function ConsultarSaldoTotalCliente() {
    const autocompleteCliente = document.getElementById("clienteEC");
    let idCliente = autocompleteCliente.dataset.id;
    
    let datos = { "idcliente": idCliente }
    $.ajax({
        url: '../data/consulta_estadocuenta_total.php',
        dataType: 'json',
        type: 'post',
        data: datos,
        success: function (object) {               
            var txtTotal = document.getElementById("txtTotalSaldo");
            const monto = new Intl.NumberFormat("es-GT", {
                style: "currency",
                currency: "GTQ",
                minimumFractionDigits: 2,
              });
            txtTotal.innerHTML = monto.format(object[0].saldo).toString();
                    
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("Otro: " + jqXHR);
            console.log("Status: " + textStatus);
            console.log("Error: " + errorThrown);
        }
    });
}