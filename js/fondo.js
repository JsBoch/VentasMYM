var fondoMensaje = document.getElementById("verNombreProducto");

var btnVer = document.getElementById("btnVer");
btnVer.addEventListener("click", function() {
    var nombreProducto = document.getElementById("producto").value;
    var nombre = document.getElementById("parrafoParaNombre");

    if (!nombreProducto == "") {
        fondoMensaje.style.display = "flex";
    nombre.innerHTML = nombreProducto;
    }else{
        alert("No hay nombre de producto.");
    }
    
});

fondoMensaje.addEventListener("click", function() {
    fondoMensaje.style.display = "none";
});