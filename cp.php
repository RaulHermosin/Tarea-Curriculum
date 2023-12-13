<?php
// Procesamiento de la información y generación de la página

// Obtener datos del archivo XML
$xmlData = file_get_contents('https://catalegdades.caib.cat/resource/rjfm-vxun.xml');
$xml = simplexml_load_string($xmlData);
#var_dump($xml);

// Extraer información relevante para los filtros
$municipios = array_unique($xml->xpath('//municipi'));
$codigosPostales = array_unique($xml->xpath('//adre_a_de_l_establiment'));
$nombres = array_unique($xml->xpath('//denominaci_comercial'));

// Filtrar resultados
$resultados = array();
if ($_GET) {
    $filtroMunicipio = $_GET['municipio'] ?? '';
    $filtroCodigoPostal = $_GET['codigo_postal'] ?? '';
    $filtroNombre = $_GET['nombre'] ?? '';

    foreach ($xml->rows->row as $rentacar) {
        if (($filtroMunicipio == '' || $rentacar->municipi == $filtroMunicipio) &&
            ($filtroCodigoPostal == '' || $rentacar->adre_a_de_l_establiment == $filtroCodigoPostal) &&
            ($filtroNombre == '' || stripos(implode(',', $nombres), $filtroNombre) !== false)) {
           $resultados[] = $rentacar;
        }
    }
}

// Función para ordenar la tabla
function cmp($a, $b) {
    return strcmp((string)$a->denominaci_comercial, (string)$b->denominaci_comercial);
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
                    url: 'fabian.php',
                    data: {
                        municipio: $('#municipi').val(),
                        codigo_postal: $('#adre_a_de_l_establiment').val(),
                        nombre: $('#denominaci_comercial').val()
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
                <option value="<?= $codigoPostal ?>"><?= $adre_a_de_l_establiment ?></option>
            <?php endforeach; ?>
        </select>

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre">

        <input type="button" value="Buscar" onclick="actualizarResultados()">
    </form>

    <div id="resultados">
        <!-- Aquí se mostrarán los resultados -->
        <?php foreach ($resultados as $rentacar) : ?>
            <div>
                <p>signatura: <?= $rentacar->signatura ?></p>
                <p>denominaci_comercial: <?= $rentacar->denominaci_comercial ?></p>
                <p>adre_a_de_l_establiment: <?= $rentacar->adre_a_de_l_establiment ?></p>
                <p>nombre_de_vehicles: <?= $rentacar->nombre_de_vehicles ?></p>
            </div>
        <?php endforeach;?>
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
                <td><?= $rentacar->signatura ?></td>
                <td><?= $rentacar->denominaci_comercial ?></td>
                <td><?= $rentacar->adre_a_de_l_establiment ?></td>
                <td><?= $rentacar->nombre_de_vehicles ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
