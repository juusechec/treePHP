<?php 
echo '<h1>Código de Árbol en PHP para transformar respuesta SQL en JSON</h1>';

/*
 * Se llaman las funciones del archivo tree.php
 */
require 'tree.php';
/*
 * Esta función construye los atributos de la jerarquía JSON haciendo foreach a los niveles del árbol.
 * Esta función no es dinámica, por tanto hay que saber el número de niveles y los campos que trae la consulta SQL.
 */
function crearArregloPorNiveles($arbol,$filas,$idNiveles){
    $response = array();
    foreach ($arbol as $nivel1 => $valnivel1) {
        $fila = array_findUnique($filas, function($k) use ($idNiveles,$nivel1) {
            return $k[$idNiveles[0]] == $nivel1;
        });
        array_push($response, array (
                'id_modalidad' => $fila['id_modalidad'],
                'descripcion' => $fila['descripcion_modalidad'],
                'sede' => array()
        ));
        foreach ($valnivel1 as $nivel2 => $valnivel2) {
            $fila = array_findUnique($filas, function($k) use ($idNiveles,$nivel1,$nivel2) {
                return ($k[$idNiveles[0]] == $nivel1 && $k[$idNiveles[1]] == $nivel2);
            });
            array_push($response[count($response)-1]['sede'], array (
                    'id_sede' => $fila['id_sede'],
                    'abreviatura' => $fila['abreviatura_sede'],
                    'consultorio' => array(),
                    'profesional' => array()
            ));
            foreach ($valnivel2 as $nivel3 => $valnivel3) {
                $fila = array_findUnique($filas, function($k) use ($idNiveles,$nivel1,$nivel2,$nivel3) {
                    return ($k[$idNiveles[0]] == $nivel1 && $k[$idNiveles[1]] == $nivel2 && $k[$idNiveles[2]] == $nivel3);
                });
                array_push($response[count($response)-1]['sede'][count($response[count($response)-1]['sede'])-1]['consultorio'], array (
                        'id_consultorio' => $fila['id_consultorio'],
                        'nombre' => $fila['nombre_consultorio']
                ));
                array_push($response[count($response)-1]['sede'][count($response[count($response)-1]['sede'])-1]['profesional'], array (
                        'id_profesional' => $fila['id_profesional'],
                        'nombre_persona' => $fila['nombre_persona']
                ));
            }
        }
    }
    return $response;
}
/*
 * Con esta funcion se obtiene como respuesta un Objeto en PHP para ser exportado a JSON.
 */
function unificarResultadosPorNiveles($rows, $idNiveles){
    $arbol = crearArbol($rows,$idNiveles);
    $response = crearArregloPorNiveles($arbol,$rows,$idNiveles);
    return $response;
}

/*
 * Esta es una variable que simula el resultado de la respuesta de una consulta.
 */
$resultadoSQL = array(
    0 => array(
        0 => '1',
        'id_modalidad' => '1',
        1 => 'MEDICINA',
        'descripcion_modalidad' => 'MEDICINA',
        2 => '1',
        'id_sede' => '1',
        3 => 'FCMA',
        'abreviatura_sede' => 'FCMA',
        4 => '1',
        'id_consultorio' => '1',
        5 => 'consultorio 1',
        'nombre_consultorio' => 'consultorio 1',
        6 => '1',
        'id_profesional' => '1',
        7 => '1000000000',
        'documento_persona' => '1000000000',
        8 => 'NEIFY NATHALYA USECHE CUELLAR',
        'nombre_persona' => 'NEIFY NATHALYA USECHE CUELLAR'
    ),
    1 => array(
        0 => '1',
        'id_modalidad' => '1',
        1 => 'MEDICINA',
        'descripcion_modalidad' => 'MEDICINA',
        2 => '4',
        'id_sede' => '4',
        3 => 'FCMB',
        'abreviatura_sede' => 'FCMB',
        4 => '3',
        'id_consultorio' => '3',
        5 => 'consultorio 1',
        'nombre_consultorio' => 'consultorio 1',
        6 => '1',
        'id_profesional' => '1',
        7 => '1000000000',
        'documento_persona' => '1000000000',
        8 => 'NEIFY NATHALYA USECHE CUELLAR',
        'nombre_persona' => 'NEIFY NATHALYA USECHE CUELLAR'
    ),
    2 => array(
        0 => '2',
        'id_modalidad' => '2',
        1 => 'ODONTOLOGÍA',
        'descripcion_modalidad' => 'ODONTOLOGÍA',
        2 => '1',
        'id_sede' => '1',
        3 => 'FCMA',
        'abreviatura_sede' => 'FCMA',
        4 => '1',
        'id_consultorio' => '1',
        5 => 'consultorio 1',
        'nombre_consultorio' => 'consultorio 1',
        6 => '1',
        'id_profesional' => '1',
        7 => '1000000000',
        'documento_persona' => '1000000000',
        8 => 'NEIFY NATHALYA USECHE CUELLAR',
        'nombre_persona' => 'NEIFY NATHALYA USECHE CUELLAR'
    ),
    3 => array(
        0 => '2',
        'id_modalidad' => '2',
        1 => 'ODONTOLOGÍA',
        'descripcion_modalidad' => 'ODONTOLOGÍA',
        2 => '2',
        'id_sede' => '2',
        3 => 'FMVI',
        'abreviatura_sede' => 'FMVI',
        4 => '2',
        'id_consultorio' => '2',
        5 => 'consultorio 2',
        'nombre_consultorio' => 'consultorio 2',
        6 => '2',
        'id_profesional' => '2',
        7 => 'E01010101',
        'documento_persona' => 'E01010101',
        8 => 'NEIFY CUELLAR',
        'nombre_persona' => 'NEIFY CUELLAR'
    ),
    4 => array(
        0 => '2',
        'id_modalidad' => '2',
        1 => 'ODONTOLOGÍA',
        'descripcion_modalidad' => 'ODONTOLOGÍA',
        2 => '4',
        'id_sede' => '4',
        3 => 'FCMB',
        'abreviatura_sede' => 'FCMB',
        4 => '3',
        'id_consultorio' => '3',
        5 => 'consultorio 1',
        'nombre_consultorio' => 'consultorio 1',
        6 => '1',
        'id_profesional' => '1',
        7 => '1000000000',
        'documento_persona' => '1000000000',
        8 => 'NEIFY NATHALYA USECHE CUELLAR',
        'nombre_persona' => 'NEIFY NATHALYA USECHE CUELLAR'
    ),
    5 => array(
        0 => '2',
        'id_modalidad' => '2',
        1 => 'ODONTOLOGÍA',
        'descripcion_modalidad' => 'ODONTOLOGÍA',
        2 => '4',
        'id_sede' => '4',
        3 => 'FCMB',
        'abreviatura_sede' => 'FCMB',
        4 => '3',
        'id_consultorio' => '3',
        5 => 'consultorio 1',
        'nombre_consultorio' => 'consultorio 1',
        6 => '2',
        'id_profesional' => '2',
        7 => 'E01010101',
        'documento_persona' => 'E01010101',
        8 => 'NEIFY CUELLAR',
        'nombre_persona' => 'NEIFY CUELLAR'
    ),
    6 => array(
        0 => '3',
        'id_modalidad' => '3',
        1 => 'PSICOLOGÍA',
        'descripcion_modalidad' => 'PSICOLOGÍA',
        2 => '1',
        'id_sede' => '1',
        3 => 'FCMA',
        'abreviatura_sede' => 'FCMA',
        4 => '1',
        'id_consultorio' => '1',
        5 => 'consultorio 1',
        'nombre_consultorio' => 'consultorio 1',
        6 => '1',
        'id_profesional' => '1',
        7 => '1000000000',
        'documento_persona' => '1000000000',
        8 => 'NEIFY NATHALYA USECHE CUELLAR',
        'nombre_persona' => 'NEIFY NATHALYA USECHE CUELLAR'
    ),
    7 => array(
        0 => '3',
        'id_modalidad' => '3',
        1 => 'PSICOLOGÍA',
        'descripcion_modalidad' => 'PSICOLOGÍA',
        2 => '1',
        'id_sede' => '1',
        3 => 'FCMA',
        'abreviatura_sede' => 'FCMA',
        4 => '1',
        'id_consultorio' => '1',
        5 => 'consultorio 1',
        'nombre_consultorio' => 'consultorio 1',
        6 => '3',
        'id_profesional' => '3',
        7 => '10101010',
        'documento_persona' => '10101010',
        8 => 'ULISES USECHE DELGADO',
        'nombre_persona' => 'ULISES USECHE DELGADO'
    ),
    8 => array(
        0 => '3',
        'id_modalidad' => '3',
        1 => 'PSICOLOGÍA',
        'descripcion_modalidad' => 'PSICOLOGÍA',
        2 => '4',
        'id_sede' => '4',
        3 => 'FCMB',
        'abreviatura_sede' => 'FCMB',
        4 => '3',
        'id_consultorio' => '3',
        5 => 'consultorio 1',
        'nombre_consultorio' => 'consultorio 1',
        6 => '1',
        'id_profesional' => '1',
        7 => '1000000000',
        'documento_persona' => '1000000000',
        8 => 'NEIFY NATHALYA USECHE CUELLAR',
        'nombre_persona' => 'NEIFY NATHALYA USECHE CUELLAR'
    ),
    9 => array(
        0 => '3',
        'id_modalidad' => '3',
        1 => 'PSICOLOGÍA',
        'descripcion_modalidad' => 'PSICOLOGÍA',
        2 => '4',
        'id_sede' => '4',
        3 => 'FCMB',
        'abreviatura_sede' => 'FCMB',
        4 => '3',
        'id_consultorio' => '3',
        5 => 'consultorio 1',
        'nombre_consultorio' => 'consultorio 1',
        6 => '3',
        'id_profesional' => '3',
        7 => '10101010',
        'documento_persona' => '10101010',
        8 => 'ULISES USECHE DELGADO',
        'nombre_persona' => 'ULISES USECHE DELGADO'
    ),
    10 => array(
        0 => '4',
        'id_modalidad' => '4',
        1 => 'FISIOTERAPIA',
        'descripcion_modalidad' => 'FISIOTERAPIA',
        2 => '100',
        'id_sede' => '100',
        3 => 'FCPO',
        'abreviatura_sede' => 'FCPO',
        4 => '4',
        'id_consultorio' => '4',
        5 => 'consultorio 1 postgrados',
        'nombre_consultorio' => 'consultorio 1 postgrados',
        6 => '4',
        'id_profesional' => '4',
        7 => '92100950407',
        'documento_persona' => '92100950407',
        8 => 'KAREN MARIANA USECHE CUELLAR',
        'nombre_persona' => 'KAREN MARIANA USECHE CUELLAR'
    ),
    11 => array(
        0 => '4',
        'id_modalidad' => '4',
        1 => 'FISIOTERAPIA',
        'descripcion_modalidad' => 'FISIOTERAPIA',
        2 => '100',
        'id_sede' => '100',
        3 => 'FCPO',
        'abreviatura_sede' => 'FCPO',
        4 => '5',
        'id_consultorio' => '5',
        5 => 'consultorio 4',
        'nombre_consultorio' => 'consultorio 4',
        6 => '4',
        'id_profesional' => '4',
        7 => '92100950407',
        'documento_persona' => '92100950407',
        8 => 'KAREN MARIANA USECHE CUELLAR',
        'nombre_persona' => 'KAREN MARIANA USECHE CUELLAR'
    )
);

/*
 * Las llaves de la consulta jerárquica se guardan en orden en un arreglo.
 */
$idsKeysSQL = array('id_modalidad','id_sede','id_profesional');
/*
 * Se ingresan los parámetros de Filas del SQL y las respectivas llaves que se establecieron en la consulta.
 */
$resultadoArray = unificarResultadosPorNiveles($resultadoSQL,$idsKeysSQL);
/*
 * Se imprime en pantalla en código en JSON.
 */
echo '<pre>';
echo json_encode($resultadoArray, JSON_PRETTY_PRINT);
echo '</pre>';


