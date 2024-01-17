var ventasxMes = new DataTable('#ventaxMes');
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

function GenerarTablaVenta(object){
    ventasxMes.clear().draw();
    $.each(object, function (i, resultado) {
        const formatoMoneda = new Intl.NumberFormat("es-GT", {
            style: "currency",
         currency: "GTQ",
             minimumFractionDigits: 2,
       });
      ventasxMes.row
        .add([
           resultado.fecha_registro,
           resultado.nofactura,
            formatoMoneda.format(resultado.monto),
        ])
        .draw(false);
    });  

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
            txtTotal.innerHTML = monto.format(object[0].venta).toString();
                    
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("Otro: " + jqXHR);
            console.log("Status: " + textStatus);
            console.log("Error: " + errorThrown);
        }
    });
}