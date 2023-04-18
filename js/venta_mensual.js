function ConsultarVentaMes() {
    let mesSelect = $('#sltMesCV').val();
    
    let datos = { "mes": mesSelect }
    $.ajax({
        url: '../data/consulta_ventas_mes.php',
        dataType: 'json',
        type: 'post',
        data: datos,
        success: function (object) {            
            /*$.each(object, function (i, resultado) {
                console.log(resultado.nofactura);
            });*/
            GenerarTablaVenta(object);         
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("Otro: " + jqXHR);
            console.log("Status: " + textStatus);
            console.log("Error: " + errorThrown);
        }
    });
}

function GenerarTablaVenta(object)
{
    // Obtener la referencia del elemento body
  var body = document.getElementsByTagName("body")[0];

  // Crea un elemento <table> y un elemento <tbody>
  var tabla   = document.createElement("table");
  var tblBody = document.createElement("tbody");

  var encabezado = document.createElement("tr");

  var celF = document.createElement("th");
  var textCelF = document.createTextNode("FECHA");
  celF.appendChild(textCelF);
  encabezado.appendChild(celF);
  var celNF = document.createElement("th");
  var textCelNF = document.createTextNode("ENV.");
  celNF.appendChild(textCelNF);
  encabezado.appendChild(celNF);
  var celM = document.createElement("th");
  var textCelM = document.createTextNode("MONTO");
  celM.appendChild(textCelM);
  encabezado.appendChild(celM);

  tblBody.appendChild(encabezado);
    
    $.each(object, function (i, resultado) {
        // Crea las hileras de la tabla
    var hilera = document.createElement("tr");
        // Crea un elemento <td> y un nodo de texto, haz que el nodo de
      // texto sea el contenido de <td>, ubica el elemento <td> al final
      // de la hilera de la tabla
      var celdaF = document.createElement("td");
      var textoCeldaF = document.createTextNode(resultado.fecha_registro);
      celdaF.appendChild(textoCeldaF);

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
      
      hilera.appendChild(celdaF);
      hilera.appendChild(celdaNF);       
      hilera.appendChild(celdaM);  

      // agrega la hilera al final de la tabla (al final del elemento tblbody)
    tblBody.appendChild(hilera);
    });  
    
    

  // posiciona el <tbody> debajo del elemento <table>
  tabla.appendChild(tblBody);
  // appends <table> into <body>
  body.appendChild(tabla);
  // modifica el atributo "border" de la tabla y lo fija a "2";
  tabla.setAttribute("border", "1");
}

function ConsultarVentaTotalMes() {
    let mesSelect = $('#sltMesCV').val();
    
    let datos = { "mes": mesSelect }
    $.ajax({
        url: '../data/consulta_ventatotal_mes.php',
        dataType: 'json',
        type: 'post',
        data: datos,
        success: function (object) {               
            var txtTotal = document.getElementById("txtTotalVenta");
            const monto = new Intl.NumberFormat("es-GT", {
                style: "currency",
                currency: "GTQ",
                minimumFractionDigits: 2,
              });
            txtTotal.value = monto.format(object[0].venta);
                    
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("Otro: " + jqXHR);
            console.log("Status: " + textStatus);
            console.log("Error: " + errorThrown);
        }
    });
}