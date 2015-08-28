<html>
    <HEAD>
     <meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
    </HEAD>
    <body>
<?php 
echo '<h1>Código de Árbol en PHP para transformar JSON filas en JSON estructurado</h1>';
/*
 * Se llaman las funciones del archivo tree.php
 */
require 'tree.php';
/*
 * Esta función construye los atributos de la jerarquía JSON haciendo foreach a los niveles del árbol.
 * Esta función no es dinámica, por tanto hay que saber el número de niveles y los campos que trae la consulta SQL.
 */
function crearArregloPorNiveles($arbol,$resultado,$idNiveles){
    $response = array();
    foreach ($arbol as $nivel1 => $valnivel1) {
        $fila = array_findUnique($resultado, function($k) use ($idNiveles,$nivel1) {
            return $k[$idNiveles[0]] == $nivel1;
        });
        array_push($response, array (
                'tipo_cita' => $fila['id_modalidad'],
                'nombre_cita' => $fila['descripcion_modalidad'],
                'sedes' => array()
        ));
        foreach ($valnivel1 as $nivel2 => $valnivel2) {
            $fila = array_findUnique($resultado, function($k) use ($idNiveles,$nivel1,$nivel2) {
                return ($k[$idNiveles[0]] == $nivel1 && $k[$idNiveles[1]] == $nivel2);
            });
            array_push($response[count($response)-1]['sedes'], array (
                    'id_sede' => $fila['id_sede'],
                    'abreviatura_sede' => $fila['abreviatura_sede'],
                    'consultorios' => array(),
                    'profesionales' => array()
            ));
            foreach ($valnivel2 as $nivel3 => $valnivel3) {
                $fila = array_findUnique($resultado, function($k) use ($idNiveles,$nivel1,$nivel2,$nivel3) {
                    return ($k[$idNiveles[0]] == $nivel1 && $k[$idNiveles[1]] == $nivel2 && $k[$idNiveles[2]] == $nivel3);
                });
                array_push($response[count($response)-1]['sedes'][count($response[count($response)-1]['sedes'])-1]['consultorios'], array (
                        'id_consultorio' => $fila['id_consultorio'],
                        'nombre' => $fila['nombre_consultorio']
                ));
                array_push($response[count($response)-1]['sedes'][count($response[count($response)-1]['sedes'])-1]['profesionales'], array (
                        'id_profesional' => $fila['id_profesional'],
                        'nombre_persona' => $fila['nombre_persona'],
                        'Documento de Identidad' => $fila['documento_persona']
                ));
            }
        }
    }
    return $response;
}
/*
 * Con esta funcion se obtiene como respuesta un Objeto en PHP para ser exportado a JSON.
 */
function unificarResultadosPorNiveles($resultado, $idNiveles){
    $arbol = crearArbol($resultado,$idNiveles);
    $response = crearArregloPorNiveles($arbol,$resultado,$idNiveles);
    return $response;
}

function printRows($rows){
    echo "<h3>Filas SQL:</h3>\n<table border='1'>";
    foreach ($rows as $row)
    {
        echo "<tr>";    
        // $row is array... foreach( .. ) puts every element
        // of $row to $cell variable
        foreach($row as $cell)
            echo "<td>$cell</td>";
        echo "</tr>\n";
    }
    echo "</table>";
}
/*
 * Esta es una variable que carga el resultado de la lectura de un JSON.
 */
$resultadoJSON = file_get_contents('resultado_consulta.json');
/*
 * Se codifica el JSON como una variable PHP.
 */
$resultadoJSON = json_decode($resultadoJSON,true);
/*
 * Se imprime en pantalla las filas para comodidad del usuario.
 */
printRows($resultadoJSON);
/*
 * Las llaves de la consulta jerárquica se guardan en orden en un arreglo.
 */
$idsLlaves = array('id_modalidad','id_sede','id_profesional');
/*
 * Se ingresan los parámetros de Filas del SQL y las respectivas llaves que se establecieron en la consulta.
 */
$resultadoArray = unificarResultadosPorNiveles($resultadoJSON,$idsLlaves);
/*
 * Se imprime en pantalla en código en JSON.
 */
echo "<h3>Resultado en JSON:</h3>";
echo '<pre>';
echo json_encode($resultadoArray, JSON_PRETTY_PRINT);
echo '</pre>';
?>
    </body>
</html>

