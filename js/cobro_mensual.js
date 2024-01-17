var cobroMensual = new DataTable('#cobroMensual');
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

function GenerarTablaCobro(object){
    cobroMensual.clear().draw();
    $.each(object, function (i, resultado) {
        const formatoMoneda = new Intl.NumberFormat("es-GT", {
            style: "currency",
         currency: "GTQ",
             minimumFractionDigits: 2,
       });
       cobroMensual.row
        .add([
           resultado.no_recibo,
           resultado.envio,
            formatoMoneda.format(resultado.cobro),
        ])
        .draw(false);
    });  
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