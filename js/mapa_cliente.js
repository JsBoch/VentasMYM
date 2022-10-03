/**
 * Esta función carga la ficha del cliente. Obtiene la información de la 
 * base de datos y carga el resultado a los imputs correspondientes.
 * Esta información también podrá ser editada.
 */
function CargarDatosCliente()
{
    let clienteSelect = document.getElementById("cliente");
    let clienteId = clienteSelect.dataset.id;

  if(clienteId == 0)
  {
    alert("Debe ingresar cliente.");
    clienteSelect.focus();
    return;
  }

  let txtCodigo = document.getElementById("txtCodigo");
  let txtNit = document.getElementById("nit");
  let txtDpi = document.getElementById("dpi");
  let txtNombre = document.getElementById("nombre");
  let txtRazonSocial = document.getElementById("razonsocial");  
  let txtDireccion = document.getElementById("direccion");
  let txtTelefono = document.getElementById("telefono");
  let txtCorreo = document.getElementById("correo");
  let txtRegion = document.getElementById("region");
  let txtComentario = document.getElementById("comentario");
  let txtCodigoPostal = document.getElementById("txtCodigoPostal");
  let txtTransporte = document.getElementById("transporte");
  let txtLatitud = document.getElementById("txtLatitud");
  let txtLongitud = document.getElementById("txtLongitud");  
  let txtClienteId = document.getElementById("clienteId");
  let inputUbicacion = document.getElementById("ubicacion");

  let datos = { "idcliente": clienteId }
    $.ajax({
        url: '../data/consulta_ubicacion_cliente.php',
        dataType: 'json',
        type: 'post',
        data: datos,
        success: function(object) {                             
            $.each(object, function(i, cliente) {
                txtCodigo.value = cliente.codigo;
                txtNit.value = cliente.nit;
                txtDpi.value = cliente.dpi;
                txtNombre.value = cliente.nombre;
                txtRazonSocial.value = cliente.razonsocial;
                $("#municipio").val(cliente.municipio);
                txtDireccion.value = cliente.direccion;
                txtTelefono.value = cliente.telefono;
                txtCorreo.value = cliente.email;
                txtRegion.value = cliente.region;
                txtComentario.value = cliente.comentario;
                txtCodigoPostal.value = cliente.codigo_postal;
                txtTransporte.value = cliente.transporte;
                txtLatitud.value = cliente.latitud;
                txtLongitud.value = cliente.longitud;
                txtClienteId.value = clienteId;
                inputUbicacion.value = cliente.latitud + "," + cliente.longitud;
            });
            
        }
    });    
}

function HabilitarEdicionFichaCliente()
{
    let chkEditar = document.getElementById("checkAvanzado");
    let bttnModificar = document.getElementById("bttnModificar");
    if (chkEditar.checked) {
        bttnModificar.style.display = 'block';
    }else {
      bttnModificar.style.display = 'none';
    }
}
/*function initMap(latitud,longitud)
{
    //console.log(latitud + " " + longitud);
    console.log(navigator.geolocation);
    if(navigator.geolocation){
        console.log("entro");
    //var success = function(position){
        console.log("adentro de success");
        var latlng = new google.maps.LatLng(14.6343,-90.5155)
        var myOptions = {
            zoom: 15,
            center: latlng,
            mapTypeControl: false,
            navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var map = new google.maps.Map(document.getElementById("map"), myOptions)
        var marker = new google.maps.Marker({
            position: latlng,
            map: map,
            //title:"Estás aquí! (en un radio de "+position.coords.accuracy+" metros)"
        })
    //}
}
}*/

/*var ubicacionActual;
var ubicacionDestino;

function initMap() {
    var directionsService = new google.maps.DirectionsService();
    var directionsRenderer = new google.maps.DirectionsRenderer();
     ubicacionActual = new google.maps.LatLng(14.6343, -90.5155);
     ubicacionDestino = new google.maps.LatLng(14.3009, -90.78581);
    var mapOptions = {
      zoom: 14,
      center: ubicacionActual
    }
    var map = new google.maps.Map(document.getElementById('map'), mapOptions);
    directionsRenderer.setMap(map);
  }
  
  function calcRoute() {
    var selectedMode = document.getElementById('mode').value;
    var request = {
        origin: ubicacionActual,
        destination: ubicacionDestino,
        // Note that JavaScript allows us to access the constant
        // using square brackets and a string value as its
        // "property."
        travelMode: google.maps.TravelMode[selectedMode]
    };
    directionsService.route(request, function(response, status) {
      if (status == 'OK') {
        directionsRenderer.setDirections(response);
      }
    });
  }*/
  
  