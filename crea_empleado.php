<?php
include('includes/diccionario.php');
$Diccionario=new diccionario();
include('includes/bd.php');
include('includes/empleados_class.php');
$E=new empleado();
if($E->guardar_empleado($_POST)){
	echo "<body><script language='javascript'>parent.recargar();</script></body>";
}

?>