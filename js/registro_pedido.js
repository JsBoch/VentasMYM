

function cargarDetalle() {
    //var principal = [];
    var detalle = [];
//console.log(JSON.stringify(principal));

    //console.log(JSON.stringify(detalle));
    var principal = {
        "id_cliente": 2,
        "id_empleado": 1,
        "observaciones": "Primera prueba"
    };

   var detalle = [{
        "codigo_producto": "MF-315-K",
        "nombre_producto": "PRODUCTO DE PRUEBA MF",
        "cantidad": 2,
        "tipoprecio": "venta",
        "precio": 23.30,
        "subtotal": 46.60,
        "observaciones": "primer registro de prueba"
    },
    {
        "codigo_producto": "MF-135-K",
        "nombre_producto": "PRODUCTO DOS MF",
        "cantidad": 3,
        "tipoprecio": "venta",
        "precio": 50.00,
        "subtotal": 150.00,
        "observaciones": "segundo registro de prueba"
    }];
    
    /**
 * Se carga el listado de clientes
 */           
var data1 = JSON.stringify(principal);
var data2 = JSON.stringify(detalle);
    //console.log(data1);
    //console.log(data2);

   $.ajax({
        url: 'http://192.168.0.6/ventasmym/data/registro_pedido.php',
       // dataType: 'json',
        type: 'post',
        data: {"registro_principal":data1,"detalle_registro":data2},
        success: function(object) {
            console.log(object);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("Status: " + textStatus);
            console.log("Error: " + errorThrown);
        }
        
    })
    
}