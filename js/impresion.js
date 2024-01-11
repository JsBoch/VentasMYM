document.addEventListener("DOMContentLoaded", async () => {
    const URLPlugin = "http://localhost:8000"; // Si el plugin no está en local, coloca la IP. Por ejemplo 192.168.1.76:8000

    const $btnImprimir = document.querySelector("#btnImprimir")
    // $licencia = document.querySelector("#licencia"),
    // $impresora = document.querySelector("#impresora"),
    // $mensaje = document.querySelector("#mensaje");
    $btnImprimir.addEventListener("click", () => {
        const direccionMacDeLaImpresora = MacAddressImpresora.trim();//"86:67:7A:00:6D:33";
        const licencia = "YjE4Yzk3MzFfXzIwMjQtMDEtMTBfXzIwMjQtMDItMDkjIyNSTGpjY1JmZHpzbnVGM1pOdVByc0JjRnkxaDZ2amRiZ25IMm53WWVXU1NBS1FWczhNUkVjcUpLbGZJY0ltcm5ubkJOMnJGMURpbGE2M1daNi9iMmk0VE8xTkZTcFdoVUZOcHZqb3lsVU8xY2lqOWZaVURYVzZyUWpvTWxNTWd2K0cwby9UdXNNRzB0STZyNjNQLzl5aU9lTGdzWWxzVWwwMlkybkxpOWRVTFdMOFZhaWd4d3pCVHQzWUc0bmxFejhwRHlSVDNINlRQTjRyRHFMRWFpYkp2bXZCWE1YaHNBMCs0K0dVRVgyS3BFWnFpNWR3dW45aEcxbnVnSjNSdHloSVoxUnFYeGFaaEhQNHV0T3ZiOUxKbDQ2L3B3NjgzOUlUVU5GWEEwTHNjQnovUElQT2ZrUm1vaHpBRjFkSHhCRjFwUHhWUjFRTXJPajJpS1JKOG1lOEVZZWszK2JaV2RaRjlMT21MNXU5L3RkVGowUlRKTnhGUlo1UGFOK0laZjFZMXZtbjcwaVhiWUN4aXZGUkh5L2NlVVFYK0dOTGtCZFo1U1BQa0xCQnU4VDFPeS9JYlBPaUMxeVg3M2lsRHA4dHZzTWtiOFhsUU52TXdwNDdoUnZsbm0xY3krM1RvSjgweXJRd2dqWmx3SmtmQWNyc05zQkJxUzBwWGhnR0Y3cg==";
        const mensaje = "";
        if (!direccionMacDeLaImpresora) {
            return alert("Por favor escribe la MAC de la impresora")
        }
        demostrarCapacidades(direccionMacDeLaImpresora, licencia, mensaje);
    });

    const demostrarCapacidades = async (macImpresora, licencia, mensaje) => {
        let formatoMoneda = new Intl.NumberFormat('es-GT', {
            style: 'currency',
            currency: 'GTQ',
        });

        const arr = await ImprimirRecibo();
        // console.log(arr);
        // if (arr.length > 0) {
        //       arr.forEach(function (item) {
        //         console.log(item.no_recibo);                
        //       })
        // }       
        const conector = new ConectorEscposAndroid(licencia, URLPlugin);
        conector
            .Iniciar()
            .EstablecerAlineacion(ConectorEscposAndroid.ALINEACION_CENTRO)
            .DescargarImagenDeInternetEImprimir("https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQqKGP6QoNxu6RwDnZFbUJvsOEAhjCbIMcZXF9lDf7Sgg&s", 0, 216)
            .Iniciar() // En mi impresora debo invocar a "Iniciar" después de imprimir una imagen
            .Feed(1)
            .EstablecerAlineacion(ConectorEscposAndroid.ALINEACION_CENTRO)
            //.Feed(1)
            .EscribirTexto("Fecha Recibo: " + arr[0].fecha_recibo + "\n")
            // .EstablecerAlineacion(ConectorEscposAndroid.ALINEACION_CENTRO)
            //.Feed(1)
            .EscribirTexto("Serie: " + arr[0].serie_recibo + " No. " + arr[0].no_recibo + "\n")
            .EstablecerAlineacion(ConectorEscposAndroid.ALINEACION_IZQUIERDA)
            //.Feed(1)
            //.EscribirTexto("Fecha: " + (new Intl.DateTimeFormat("es-GT").format(new Date())))
            // .EstablecerAlineacion(ConectorEscposAndroid.ALINEACION_CENTRO)
            // .Feed(1)
            .EscribirTexto("Monto: Q. " + arr[0].cobro + "\n")
            // .EstablecerAlineacion(ConectorEscposAndroid.ALINEACION_IZQUIERDA)
            .Feed(1)
            .EscribirTexto("Observaciones: " + arr[0].observacion + "\n")
            // .EstablecerAlineacion(ConectorEscposAndroid.ALINEACION_CENTRO)
            // .EstablecerEnfatizado(true)
            // .EstablecerTamañoFuente(1, 1)
            // .EscribirTexto("Monto: Q.50\n")
            // .Feed(1)
            // .EstablecerTamañoFuente(1, 1)
            // .EscribirTexto("Abono: Q.20\n")
            // .Feed(1)
            // .EstablecerTamañoFuente(1, 1)
            // .EscribirTexto("Saldo: Q.30\n")
            // .Feed(1)
            // .EstablecerAlineacion(ConectorEscposAndroid.ALINEACION_CENTRO)
            // .EscribirTexto("Comentario: Este es un texto de prueba para ejemplificar un comentario.\n")
            .Feed(1)
            .EstablecerAlineacion(ConectorEscposAndroid.ALINEACION_CENTRO)
            .EscribirTexto("No.ENVIO     SALDO     PAGO\n")
        //.CorteParcial()
        .EstablecerAlineacion(ConectorEscposAndroid.ALINEACION_DERECHA)
        arr.forEach(function (item) {
            //console.log(item.no_recibo);                
            conector.EscribirTexto(item.no_envio + "   " + item.saldo + "   " + item.pago + "\n")
        })
        conector.Feed(3)
        conector.EstablecerAlineacion(ConectorEscposAndroid.ALINEACION_DERECHA)
        conector.EscribirTexto("Distribuidora de repuestos MYM\n");
        conector.Feed(1)
        conector.EscribirTexto("Repuestos de alta calidad, en marcas: SAP, EISSLER, BULL, TREE FIVE 555, NEW YORK, NAMCO y muchas mas.\n");
        conector.Feed(1)
        conector.EscribirTexto("Contactanos al: (+502) 4608-0447\n");
        conector.Feed(1)
        conector.EscribirTexto("ventas@grupoautomotriz-mym.com\n");
        conector.Feed(1)
        conector.EstablecerAlineacion(ConectorEscposAndroid.ALINEACION_CENTRO)
        conector.DescargarImagenDeInternetEImprimir("http://138.118.105.190:8095/codigoQr.png", 0, 216)
        conector.Iniciar()
        conector.Corte(1)
        conector.Pulso(48, 60, 120)

        try {
            const respuesta = await conector.imprimirEn(macImpresora);
            if (respuesta === true) {
                //alert("Impreso correctamente");
            } else {
                alert("Error: " + respuesta);
            }
        } catch (e) {
            alert("Error imprimiendo: " + e.message);
        }
    }
});