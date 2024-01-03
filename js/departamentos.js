function listaDepartamentos() {
    var datos;
    var id;
    var $select = $('#depa');

    // Agregar JSON a el select de Departamento
    //url: 'http://10.18.46.249/ventasmym/data/departamentos.php',
    $.ajax({
        url: '../data/departamentos.php',
        dataType: 'json',
        success: function (object) {
            // datos = object;
            //console.log(object);
            funcionCualquiera(object);
        }
    });

    function funcionCualquiera(datos) {
        $.each(datos, function (id, name) {
            $select.append('<option value=' + name.iddepartamento + '>' + name.nombre + '</option>');
        });
    };
}

// Enviar Datos

function findValue() {
    id = $('#depa').val(); //#addLocationIdReq es el identificador
    var url = "../data/municipios.php"; // URL a la cua enviar los datos
    var datos = {
        "departamentoId": id
    }
        
    if (id != 0) {
        enviarDatos(datos, url); // Ejecutar cuando se quiera enviar los datos
    }
    // de tu elemento
};

function enviarDatos(datos, url) {
    $.ajax({
        data: datos,
        url: url,
        type: 'post',
        dataType: "json",
        success: function (response) {
            paraLlenar(response); // Imprimir respuesta del archivo
        },
        error: function (error) {
            console.log(error); // Imprimir respuesta de error
        }
    });
}

// Agregar JSON a el select de Municipio
function paraLlenar(municipio) {
    var $selectMuni = $('#municipio');
    $selectMuni.empty();
    $.each(municipio, function (id, name) {
        $selectMuni.append('<option value=' + name.id_municipio + '>' + name.nombre + '</option>');
    });
};

function limpiarFormulario() {
    let nit = document.getElementById('nit');
    nit.value = "";
    document.getElementById('dpi').value = "";
    document.getElementById('nombre').value = "";
    document.getElementById('razonsocial').value = "";
    document.getElementById('direccion').value = "";
    document.getElementById('telefono').value = "";
    document.getElementById('correo').value = "";
    document.getElementById('region').value = "";
    document.getElementById('comentario').value = "";
    document.getElementById('transporte').value = "";

    nit.focus();
}

function Inicializar() {
    let bttnModificar = document.getElementById("bttnModificar");
    bttnModificar.style.display = 'none';
}