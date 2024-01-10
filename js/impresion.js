document.addEventListener("DOMContentLoaded", async () => {
    const URLPlugin = "http://localhost:8000"; // Si el plugin no está en local, coloca la IP. Por ejemplo 192.168.1.76:8000

    const $btnImprimir = document.querySelector("#btnImprimir")
        // $licencia = document.querySelector("#licencia"),
        // $impresora = document.querySelector("#impresora"),
        // $mensaje = document.querySelector("#mensaje");
    $btnImprimir.addEventListener("click", () => {
        alert("Hola mundo");
        const direccionMacDeLaImpresora = "86:67:7A:00:6D:33";
        const licencia = "";
        const mensaje = "";
        if (!direccionMacDeLaImpresora) {
            return alert("Por favor escribe la MAC de la impresora")
        }
        demostrarCapacidades(direccionMacDeLaImpresora, licencia, mensaje);
    });

    const demostrarCapacidades = async (macImpresora, licencia, mensaje) => {
        const conector = new ConectorEscposAndroid(licencia, URLPlugin);
        conector
        .Iniciar()
        .EstablecerAlineacion(ConectorEscposAndroid.ALINEACION_CENTRO)
        .DescargarImagenDeInternetEImprimir("https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQqKGP6QoNxu6RwDnZFbUJvsOEAhjCbIMcZXF9lDf7Sgg&s", 0, 216)
        .Iniciar() // En mi impresora debo invocar a "Iniciar" después de imprimir una imagen
        .EstablecerAlineacion(ConectorEscposAndroid.ALINEACION_CENTRO)
        .Feed(1)
        .EscribirTexto("No.Recibo: 05\n")
        .EstablecerAlineacion(ConectorEscposAndroid.ALINEACION_CENTRO)
        .Feed(1)
        .EscribirTexto("Cliente: Aaron Velasquez\n")
        .EstablecerAlineacion(ConectorEscposAndroid.ALINEACION_CENTRO)
        .Feed(1)
        .EscribirTexto("Fecha y hora: " + (new Intl.DateTimeFormat("es-GT").format(new Date())))
        .EstablecerAlineacion(ConectorEscposAndroid.ALINEACION_CENTRO)
        .Feed(1)
        .EscribirTexto("Vendedor: Nombre\n")
        .EstablecerAlineacion(ConectorEscposAndroid.ALINEACION_IZQUIERDA)
        .Feed(1)
        .EscribirTexto("No.Envio: 12054\n")
        .EstablecerAlineacion(ConectorEscposAndroid.ALINEACION_CENTRO)
        .EstablecerEnfatizado(true)
        .EstablecerTamañoFuente(1, 1)
        .EscribirTexto("Monto: Q.50\n")
        .Feed(1)
        .EstablecerTamañoFuente(1, 1)
        .EscribirTexto("Abono: Q.20\n")
        .Feed(1)
        .EstablecerTamañoFuente(1, 1)
        .EscribirTexto("Saldo: Q.30\n")
        .Feed(1)
        .EstablecerAlineacion(ConectorEscposAndroid.ALINEACION_CENTRO)
        .EscribirTexto("Comentario: Este es un texto de prueba para ejemplificar un comentario.\n")
        .Feed(2)
        .Corte(1)
        .Pulso(48, 60, 120)

    try {
        const respuesta = await conector.imprimirEn(macImpresora);
        if (respuesta === true) {
            alert("Impreso correctamente");
        } else {
            alert("Error: " + respuesta);
        }
    } catch (e) {
        alert("Error imprimiendo: " + e.message);
    }
}
});