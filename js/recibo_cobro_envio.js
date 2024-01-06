let table = new DataTable('#example');
let arrayEnvio = [];
var filaEnvio;

function GetSaldoCliente(idcliente) {
  let clienteSelect = document.getElementById("cliente");
  let clienteId = idcliente;
  //   if (clienteSelect.value != null) {
  //     clienteId = clienteSelect.value;
  //   }
  //   else {
  //     clienteId = clienteSelect.dataset.id;
  //   }
  let formatoMoneda = new Intl.NumberFormat('es-GT', {
    style: 'currency',
    currency: 'GTQ',
  });

  let datos = { idCliente: clienteId };
  arrayEnvio.length = 0;
  $.ajax({
    url: "../data/recibo_cobro_envio.php",
    dataType: "json",
    type: "post",
    data: datos,
    success: function (object) {
      if (object[0].nofactura != -3) {
        $.each(object, function (i, envio) {
          arrayEnvio.push(envio);
        });
        MostrarTable();
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("Status: " + textStatus);
      console.log("Error: " + errorThrown);
      alertify.error("Ocurrió un error al guardar el registro");
    },
  });
}

/**
 * Esta función toma el monto que se ingresa en el campo de "pago" y lo desglosa
 * en el o los envío(s) que le aparezcan al cliente, en orden ascendente.
 */
function desgloceMonto() {
  let monto = document.getElementById("pago").value;
  if (monto.length == 0 || parseFloat(monto) == 0) {
    alertify.error("Debe ingresar el monto que recibe del cliente.");
  } else {
    arrayEnvio.forEach(function (item) {
      if (parseFloat(monto) > 0) {
        if (parseFloat(monto) <= parseFloat(item.saldo)) {
          item.pago = monto;
          monto = 0;
          return;
        } else {
          item.pago = item.saldo;
          monto = parseFloat(monto) - parseFloat(item.saldo);
        }
      }
    })

    MostrarTable();
  }
}

function MostrarTable() {
  var textoSaldo = document.getElementById("saldoTotal");
  let saldoTotal = 0;
  let pago = 0;
  let formatoMoneda = new Intl.NumberFormat('es-GT', {
    style: 'currency',
    currency: 'GTQ',
  });

  table.clear().draw();
  textoSaldo.innerHTML = "";
  if (arrayEnvio.length > 0) {
    arrayEnvio.forEach(function (item) {
      table.row
        .add([
          item.nofactura,
          formatoMoneda.format(item.saldo),
          formatoMoneda.format(item.pago),
          formatoMoneda.format(item.monto),
          formatoMoneda.format(item.abono),
          item.fecha,
          item.fecha_vencimiento,
          item.dias,
          item.idventa
        ])
        .draw(false);
      saldoTotal = parseFloat(saldoTotal) + parseFloat(item.saldo);
    })
    textoSaldo.innerHTML = formatoMoneda.format(saldoTotal);
  }
}


// Distinción de la fila seleccionada

table.on("click", "tbody tr", (e) => {
  let classList = e.currentTarget.classList;
  if (classList.contains("selected")) { 
    classList.remove("selected");
  } else {
    table
      .rows(".selected")
      .nodes()
      .each((row) => row.classList.remove("selected"));
    classList.add("selected");
  }
});

// Abrir modal con la inforamción.
$('#example tbody').on('click', 'tr', function () {
  let campoSaldo = document.getElementById("saldoModal");
  let data = table.row( this ).data();
  filaEnvio = data[8];
  document.getElementById("modalPago").style.display = "flex";
  campoSaldo.value =  data[1];
} );

document.getElementById("modal_x").addEventListener("click", cerrarModalPago);

function cerrarModalPago() {
  document.getElementById("modalPago").style.display = "none";
}

function asignarPago(){
   let campoPago = document.getElementById("pagoModal").value;
   let campoSaldo = document.getElementById("saldoModal").value;
   campoSaldo = campoSaldo.replace("Q","");
   campoSaldo = campoSaldo.replace(",","");
   if (campoPago.length == 0 || parseFloat(campoPago) == 0) {
    alertify.error("Debe ingresar el pago.");
   }else if(parseFloat(campoPago) > parseFloat(campoSaldo)){
     alertify.error("El pago no puede ser mayor al saldo");
   }else{
    arrayEnvio.forEach(function (item) {
     if (item.idventa === filaEnvio) {
      item.pago = campoPago;
      return;
     }
    })
    MostrarTable();
   }
   document.getElementById("modalPago").style.display = "none";
}