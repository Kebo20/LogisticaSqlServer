<?php

require_once '../cado/ClaseLogistica.php';
$olog = new Logistica();
$lista = $olog->ListarExamenes("", 0, 100);

$cont = 0;

foreach ($lista as $reactivo) {
    $cont++;
    echo $cont . " : ";
    echo ($reactivo[1]);

    echo "<div align='center'> <a  onclick=\"detalles(" . $reactivo[0] . ",'" . $reactivo[1] . "' )\"  ><i class='fa fa-plus-circle  blue '></i></a></div>";
    echo "<br><br>";
}
