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

function GenerarTabla(object)
{
    // Obtener la referencia del elemento body
  var body = document.getElementById("contenedorTabla");

  // Crea un elemento <table> y un elemento <tbody>
  var tabla   = document.createElement("table");
  var tblBody = document.createElement("tbody");
  var thead = document.createElement("thead");

  var encabezado = document.createElement("tr");

  var celNF = document.createElement("th");
  var textCelNF = document.createTextNode("ENV.");
  celNF.appendChild(textCelNF);
  encabezado.appendChild(celNF);
  var celM = document.createElement("th");
  var textCelM = document.createTextNode("MONTO");
  celM.appendChild(textCelM);
  encabezado.appendChild(celM);
  var celA = document.createElement("th");
  var textCelA = document.createTextNode("ABONO");
  celA.appendChild(textCelA);
  encabezado.appendChild(celA);
  var celS = document.createElement("th");
  var textCelS = document.createTextNode("SALDO");
  celS.appendChild(textCelS);
  encabezado.appendChild(celS);
  var celDV = document.createElement("th");
  var textCelDV = document.createTextNode("ANTIG.");
  celDV.appendChild(textCelDV);
  encabezado.appendChild(celDV);

  thead.appendChild(encabezado);
    
    $.each(object, function (i, resultado) {
        // Crea las hileras de la tabla
    var hilera = document.createElement("tr");
        // Crea un elemento <td> y un nodo de texto, haz que el nodo de
      // texto sea el contenido de <td>, ubica el elemento <td> al final
      // de la hilera de la tabla
      var celdaNF = document.createElement("td");
      var textoCeldaNF = document.createTextNode(resultado.nofactura);
      celdaNF.appendChild(textoCeldaNF);
      var celdaM = document.createElement("td");
      const monto = new Intl.NumberFormat("es-GT", {
        style: "currency",
        currency: "GTQ",
        minimumFractionDigits: 2,
      });
      var textoCeldaM = document.createTextNode(monto.format(resultado.monto));
      celdaM.appendChild(textoCeldaM);
      var celdaA = document.createElement("td");
      const abono = new Intl.NumberFormat("es-GT", {
        style: "currency",
        currency: "GTQ",
        minimumFractionDigits: 2,
      });
      var textoCeldaA = document.createTextNode(abono.format(resultado.abono));
      celdaA.appendChild(textoCeldaA);
      var celdaS = document.createElement("td");
      const saldo = new Intl.NumberFormat("es-GT", {
        style: "currency",
        currency: "GTQ",
        minimumFractionDigits: 2,
      });
      var textoCeldaS = document.createTextNode(saldo.format(resultado.saldo));
      celdaS.appendChild(textoCeldaS);
      var celdaDV = document.createElement("td");
      var textoCeldaDV = document.createTextNode(resultado.dias_vencimiento);
      celdaDV.appendChild(textoCeldaDV);

      hilera.appendChild(celdaNF);       
      hilera.appendChild(celdaM);
      hilera.appendChild(celdaA);
      hilera.appendChild(celdaS);
      hilera.appendChild(celdaDV);

      // agrega la hilera al final de la tabla (al final del elemento tblbody)
    tblBody.appendChild(hilera);
    });  
    
    
    tabla.appendChild(thead);
  // posiciona el <tbody> debajo del elemento <table>
  tabla.appendChild(tblBody);
  // appends <table> into <body>
  body.appendChild(tabla);
  // modifica el atributo "border" de la tabla y lo fija a "2";
  tabla.setAttribute("id", "tablaDatos");
}