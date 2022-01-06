<?php
include('includes/diccionario.php');
$Diccionario=new diccionario();
include('includes/bd.php');
include('includes/empleados_class.php');
$E=new empleado();
if($E->elimina_empleado($_GET)){
	echo "<body><script language='javascript'>alert('Registro eliminado satisfactoriamente.');parent.recargar();</script></body>";
}

?>