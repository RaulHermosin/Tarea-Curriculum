<!DOCTYPE html>
<html>
    <!-- 
        Hay que bajarse el archivo xml de 
        
        https://catalegdades.caib.cat/api/views/j2yj-e83g/rows.xml?accessType=DOWNLOAD
        
        y guardarlo en dades/vacacional.xml
    
    -->
    <meta charset="UTF-8">
    <title>Unitats de vacacional</title>
    </head>
    <!-- cos-->

    <body>
        <?php

// cargamos el contenido del archivo

$arxiu = "coches.xml";
$pobles = array();


if(!$xml = simplexml_load_file($arxiu)){
    echo "No s'ha pogut carregar l'arxiu";
    die();
    } 
$mis_datos = $xml->row;

// carga los datos en el array
foreach ($mis_datos->row as $dades) {
    $municipi=(string) $dades->municipi;
    $unitats =(int) $dades->nombre_de_vehicles;
    $postal=(string) $dades->adre_a_de_l_establiment;
    if (isset($pobles[$municipi])) {
           $pobles[$municipi] += $unitats;
    } else {
        $pobles[$municipi] = $unitats;
    }
}
ksort($pobles);
?>
        <h1>Unitats de vacacional per poble</h1>
        <table border="1">
            <tr>
                <td>
                    <strong>Municipio</strong>
                </td>
                <td><strong>Numero_Coches</strong></td>
                <td><strong>Código_Postal</strong></td>
            </tr>
            <?php
            foreach ($pobles as $municipi=>$unitats){
                echo "<tr><td>$municipi</td><td>$unitats</td><td>$postal</td></tr>";
                }
                ?>


        </table>
        

    </body>

</html>