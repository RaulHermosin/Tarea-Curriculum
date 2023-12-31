<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Unitats de vacacional</title>
    <style>
        body {
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
            color: #333;
            margin: 20px;
            text-align: center; /* Centrar el contenido del body */
        }

        h1 {
            color: #1e4090;
            margin-bottom: 20px; /* Añadir espacio en la parte inferior del título */
        }

        form {
            margin-bottom: 20px;
            display: inline-block; /* Mostrar el formulario como bloque en línea */
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"] {
            padding: 5px;
            width: 200px;
        }

        button {
            padding: 5px 10px;
            background-color: #1e4090;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #1e4090;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #1e4090;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <?php
    // cargamos el contenido del archivo
    $arxiu = file_get_contents('https://catalegdades.caib.cat/resource/rjfm-vxun.xml');
    $rentacars = array();

    if (!$xml = simplexml_load_string($arxiu)) {
        echo "No s'ha pogut carregar l'arxiu";
        die();
    }

    // utiliza XPath para obtener los datos específicos
    $data = $xml->xpath('//row');

    // carga los datos en el array
    foreach ($data as $dades) {
        $licencia = (string) $dades->signatura;
        $nomcomercial = (string) $dades->denominaci_comercial;
        $direccio = (string) $dades->adre_a_de_l_establiment;
        $nombrevehicles = (int) $dades->nombre_de_vehicles;

        // Agrega los datos a un array asociativo por cada iteración
        $rentacars[] = array(
            'licencia' => $licencia,
            'nomcomercial' => $nomcomercial,
            'direccio' => $direccio,
            'nombrevehicles' => $nombrevehicles
        );
    }

    // Manejo de la búsqueda
    $busqueda = isset($_GET['buscar']) ? $_GET['buscar'] : '';

    // Filtrar los resultados según la búsqueda
    $resultadosFiltrados = array_filter($rentacars, function ($rentacar) use ($busqueda) {
        return stripos($rentacar['licencia'], $busqueda) !== false || stripos($rentacar['nomcomercial'], $busqueda) !== false;
    });
    ?>

    <h1>Mallorca Rentacars</h1>

    <!-- Barra de búsqueda -->
    <form action="" method="get">
        <label for="buscar">Buscar:</label>
        <input type="text" name="buscar" id="buscar" value="<?= htmlspecialchars($busqueda) ?>">
        <button type="submit">Buscar</button>
    </form>

    <table border="1">
        <tr>
            <th>Licencia de rentacar</th>
            <th>Nombre comercial</th>
            <th>Dirección completa</th>
            <th>Número de vehículos</th>
        </tr>
        <?php
        foreach ($resultadosFiltrados as $rentacar) {
            echo "<tr>
                    <td>{$rentacar['licencia']}</td>
                    <td>{$rentacar['nomcomercial']}</td>
                    <td>{$rentacar['direccio']}</td>
                    <td>{$rentacar['nombrevehicles']}</td>
                  </tr>";
        }
        ?>
    </table>
</body>
</html>

