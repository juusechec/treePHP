<?php
/**
 * Se crea un arbol a partir de las filas resultantes de una consulta SQL y los Id's de las Filas.
 */
function crearArbol($filas,$ids){
    foreach ($ids as $index => $id){
        $valores[$index] = array_values(array_column($filas,$id));
    }
    function agregar(&$obj,$niveles,$valores,$inicial=0){
       if($inicial==$niveles){
            return true;
       } else {
            if(!isset($obj[$valores[$inicial]])){
                $obj[$valores[$inicial]] = array();
            }
            $objen = &$obj[$valores[$inicial]];
            $inicial++;
            agregar($objen,$niveles,$valores,$inicial);
       }
    }
    $arreglo = array();
    $niveles = count($valores);
    foreach ($valores[0] as $index => $valor){
        for ($i = 0; $i<$niveles; $i++) {
            $valoresNivel[$i] = $valores[$i][$index];
        }
        agregar($arreglo,$niveles,$valoresNivel);
    }
    return $arreglo;
}
/**
 * Con esta funcion se puede buscar en un arreglo y retorna la primera coincidencia que se encuentre.
 * El $callback sirve para evaluar las filas individualmente en busca de una condicion.
 * Funciona similar a la funcion array_filter.
 */
function array_findUnique($a,$callback){
    foreach ($a as $k) {
        $cond = $callback($k);        
        if($cond){
            return $k;
        }        
    }
    return false;
};