<?php

error_reporting(E_ALL);
include('includes/diccionario.php');
$Diccionario=new diccionario();
include('includes/bd.php');
include('includes/html.php');
include('includes/empleados_class.php');

$E=new empleado();
$E->listar_empleados();

?>
