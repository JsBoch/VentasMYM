var datos;
var id;
var $select = $('#depa');

$.ajax({
    url: 'http://localhost/ventasmym/data/departamentos.php',
    dataType: 'json',
    success: function(object) {
        // datos = object;
        // console.log(datos);
        funcionCualquiera(object);
    }
});

function funcionCualquiera(datos) {
    $.each(datos, function(id, name) {
        $select.append('<option value=' + name.iddepartamento + '>' + name.nombre + '</option>');
    });
};


function findValue() {
    id = $('#depa').val(); //#addLocationIdReq es el identificador
    // de tu elemento
    console.log(id);
};