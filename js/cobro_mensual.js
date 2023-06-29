function ConsultarCobroMes() {
    let mesSelect = $('#sltMesCV').val();
    
    let datos = { "mes": mesSelect }
    $.ajax({
        url: '../data/consulta_cobros_mes.php',
        dataType: 'json',
        type: 'post',
        data: datos,
        success: function (object) {            
            /*$.each(object, function (i, resultado) {
                console.log(resultado.nofactura);
            });*/
            GenerarTablaCobro(object);         
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("Otro: " + jqXHR);
            console.log("Status: " + textStatus);
            console.log("Error: " + errorThrown);
        }
    });
}

function GenerarTablaCobro(object)
{
    // Obtener la referencia del elemento body
    var body = document.getElementById("contenedorTabla");
    body.innerHTML = '';
    

  // Crea un elemento <table> y un elemento <tbody>
  var tabla   = document.createElement("table");
  var tblBody = document.createElement("tbody");
  var thead = document.createElement("thead");

  var encabezado = document.createElement("tr");

  var celR = document.createElement("th");
  var textCelR = document.createTextNode("RECIBO");
  celR.appendChild(textCelR);
  encabezado.appendChild(celR);
  var celNF = document.createElement("th");
  var textCelNF = document.createTextNode("ENVIO.");
  celNF.appendChild(textCelNF);
  encabezado.appendChild(celNF);
  var celM = document.createElement("th");
  var textCelM = document.createTextNode("COBRO");
  celM.appendChild(textCelM);
  encabezado.appendChild(celM);

  thead.appendChild(encabezado);
    
    $.each(object, function (i, resultado) {
        // Crea las hileras de la tabla
    var hilera = document.createElement("tr");
        // Crea un elemento <td> y un nodo de texto, haz que el nodo de
      // texto sea el contenido de <td>, ubica el elemento <td> al final
      // de la hilera de la tabla
      var celdaR = document.createElement("td");
      var textoCeldaR = document.createTextNode(resultado.no_recibo);
      celdaR.appendChild(textoCeldaR);

      var celdaNF = document.createElement("td");
      var textoCeldaNF = document.createTextNode(resultado.envio);
      celdaNF.appendChild(textoCeldaNF);
      var celdaM = document.createElement("td");
      const monto = new Intl.NumberFormat("es-GT", {
        style: "currency",
        currency: "GTQ",
        minimumFractionDigits: 2,
      });
      var textoCeldaM = document.createTextNode(monto.format(resultado.cobro));
      celdaM.appendChild(textoCeldaM);
      
      hilera.appendChild(celdaR);
      hilera.appendChild(celdaNF);       
      hilera.appendChild(celdaM);  

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

function ConsultarCobroTotalMes() {
    let mesSelect = $('#sltMesCV').val();
    
    let datos = { "mes": mesSelect }
    $.ajax({
        url: '../data/consulta_cobrototal_mes.php',
        dataType: 'json',
        type: 'post',
        data: datos,
        success: function (object) {               
            var txtTotal = document.getElementById("txtTotalCobro");
            const monto = new Intl.NumberFormat("es-GT", {
                style: "currency",
                currency: "GTQ",
                minimumFractionDigits: 2,
              });
            txtTotal.innerHTML = monto.format(object[0].cobro).toString();
                    
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("Otro: " + jqXHR);
            console.log("Status: " + textStatus);
            console.log("Error: " + errorThrown);
        }
    });
}