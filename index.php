<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/mainStyles.css">
    <title>Form</title>
</head>
<body>
    <form action="" id="customer_registration">
        <h2>Registro de clientes</h2>
        <input placeholder="Ingrese NIT" type="text">
        <input placeholder="Ingrese DPI" type="text">
        <input placeholder="Ingrese Nombre" type="text">
        <input placeholder="Ingrese Razón Social" type="text">
        <select name="SD" id="departamentos" form="customer_registration">
        <option value="idRandom">ID Departamento</option>
        </select>
        <select name="SM" id="municipio" form="customer_registration">
        <option value="idRandom">Municipio</option>
        </select>
        <input placeholder="Ingrese Dirección" type="text">
        <input placeholder="Ingrese Teléfono" type="number">
        <input placeholder="Ingrese@email.com" type="email">
        <input placeholder="Ingrese Region" type="text">
        <textarea  rows="5" cols="33">Escribe alguna observación... </textarea>
        <input placeholder="Ingrese Transporte" type="text">
        <button type="submit">Enviar</button>
    </form>
</body>
</html>