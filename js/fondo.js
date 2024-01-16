var fondoMensaje = document.getElementById("verNombreProducto");

var btnVer = document.getElementById("btnVer");
btnVer.addEventListener("click", function() {
    var nombreProducto = document.getElementById("producto").value;
    var nombre = document.getElementById("parrafoParaNombre");

    if (!nombreProducto == "") {
        fondoMensaje.style.display = "flex";
    nombre.innerHTML = nombreProducto;
    }else{
        alertify.error("No hay nombre de producto.");
    }
    
});

var fondoDireccion = document.getElementById("verDireccion");

var btnVer = document.getElementById("btnVerDireccion");
btnVer.addEventListener("click", function() {
    var direccion = document.getElementById("direccion_cliente").value;
    var inputDireccion = document.getElementById("parrafoParaDireccion");

    if (!direccion == "") {
        fondoDireccion.style.display = "flex";
        inputDireccion.innerHTML = direccion;
    }else{
        alertify.error("No hay dirección.");
    }
    
});



fondoMensaje.addEventListener("click", function() {
    fondoMensaje.style.display = "none";
});

fondoDireccion.addEventListener("click", function() {
    fondoDireccion.style.display = "none";
});