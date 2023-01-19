<?php

echo "$dia $mes $anio";


//Haz lo mismo pero con la función PHP compact.

$array = array();

$resultado = compact('dia', 'mes', 'anio', $array);
print_r($resultado);