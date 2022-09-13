var datos;
var id;
var $select = $('#depa');
var $selectMuni = $('#municipio');

// Agregar JSON a el select de Departamento
//url: 'http://10.18.46.249/ventasmym/data/departamentos.php',
$.ajax({
    url: '../data/departamentos.php',
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


// Enviar Datos

function findValue() {
    id = $('#depa').val(); //#addLocationIdReq es el identificador
    var url = "../data/municipios.php"; // URL a la cua enviar los datos
    var datos = {
        "departamentoId": id
    }
    enviarDatos(datos, url); // Ejecutar cuando se quiera enviar los datos
    // de tu elemento
};

function enviarDatos(datos, url) {
    $.ajax({
        data: datos,
        url: url,
        type: 'post',
        dataType: "json",
        success: function(response) {
            paraLlenar(response); // Imprimir respuesta del archivo
        },
        error: function(error) {
            console.log(error); // Imprimir respuesta de error
        }
    });
}

// Agregar JSON a el select de Municipio
function paraLlenar(municipio) {
    $selectMuni.empty();
    $.each(municipio, function(id, name) {
        $selectMuni.append('<option value=' + name.id_municipio + '>' + name.nombre + '</option>');
    });
};

