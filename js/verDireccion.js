
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


fondoDireccion.addEventListener("click", function() {
    fondoDireccion.style.display = "none";
});