<?php
// Procesamiento de la información y generación de la página

// Obtener datos del archivo XML
$xmlData = file_get_contents('https://catalegdades.caib.cat/resource/rjfm-vxun.xml');
$xml = simplexml_load_string($xmlData);

// Extraer información relevante para los filtros
$municipios = array_unique($xml->xpath('//Municipio'));
$codigosPostales = array_unique($xml->xpath('//CodigoPostal'));
$nombres = array_unique($xml->xpath('//NombreComercial | //RazonSocial'));

// Filtrar resultados
$resultados = array();
if ($_GET) {
    $filtroMunicipio = $_GET['municipio'] ?? '';
    $filtroCodigoPostal = $_GET['codigo_postal'] ?? '';
    $filtroNombre = $_GET['nombre'] ?? '';

    foreach ($xml->Rentacar as $rentacar) {
        if (($filtroMunicipio == '' || $rentacar->Municipio == $filtroMunicipio) &&
            ($filtroCodigoPostal == '' || $rentacar->CodigoPostal == $filtroCodigoPostal) &&
            ($filtroNombre == '' || stripos(implode(',', $nombres), $filtroNombre) !== false)) {
            $resultados[] = $rentacar;
        }
    }
}

// Función para ordenar la tabla
function cmp($a, $b) {
    return strcmp((string)$a->NombreComercial, (string)$b->NombreComercial);
}

usort($resultados, 'cmp');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consulta Rentacars Mallorca</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {
            // Manejar cambios en los filtros y realizar la búsqueda
            $('#municipio, #codigo_postal, #nombre').change(function () {
                actualizarResultados();
            });

            // Función para actualizar los resultados mediante AJAX
            function actualizarResultados() {
                $.ajax({
                    type: 'GET',
                    url: 'tu_pagina.php',
                    data: {
                        municipio: $('#municipio').val(),
                        codigo_postal: $('#codigo_postal').val(),
                        nombre: $('#nombre').val()
                    },
                    success: function (data) {
                        $('#resultados').html(data);
                    }
                });
            }
        });
    </script>
</head>
<body>
    <h1>Consulta Rentacars Mallorca</h1>
    <form>
        <label for="municipio">Municipio:</label>
        <select id="municipio" name="municipio">
            <option value="">Todos</option>
            <?php foreach ($municipios as $municipio) : ?>
                <option value="<?= $municipio ?>"><?= $municipio ?></option>
            <?php endforeach; ?>
        </select>

        <label for="codigo_postal">Código Postal:</label>
        <select id="codigo_postal" name="codigo_postal">
            <option value="">Todos</option>
            <?php foreach ($codigosPostales as $codigoPostal) : ?>
                <option value="<?= $codigoPostal ?>"><?= $codigoPostal ?></option>
            <?php endforeach; ?>
        </select>

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre">

        <input type="button" value="Buscar" onclick="actualizarResultados()">
    </form>

    <div id="resultados">
        <!-- Aquí se mostrarán los resultados -->
    </div>

    <table border="1">
        <tr>
            <th>Licencia de rentacar</th>
            <th>Nombre comercial</th>
            <th>Dirección completa</th>
            <th>Número de vehículos</th>
        </tr>
        <?php foreach ($resultados as $rentacar) : ?>
            <tr>
                <td><?= $rentacar->Licencia ?></td>
                <td><?= $rentacar->NombreComercial ?></td>
                <td><?= $rentacar->Direccion ?></td>
                <td><?= $rentacar->NumeroVehiculos ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
