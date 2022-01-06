<?php
include('includes/config.php');
class bd {
	var $BD_conexion=false;

	public function conectar(){
		@session_start();
		if($_SESSION['LINKBD']=mysqli_connect(MYSQL_HOST,MYSQL_USER,MYSQL_PASSWD,MYSQL_BASE)) {
			$this->BD_conexion=true;
			mysqli_set_charset($_SESSION['LINKBD'],'latin1');
		}
		else {
			$this->BD_conexion=false;
			return $this->error_conexion();
		}
	}

	public function cerrar(){
		@session_start();
		$_SESSION['LINKBD']->close();
	}

	public function consulta($consulta){
		global $Diccionario;
		$Con=$this->conectar();
		@session_start();
		if($this->BD_conexion){
			if($Resultado=$_SESSION['LINKBD']->query($consulta)){
				if(strpos('  '.strtoupper($consulta),'INSERT ')){
					$nuevo_id=$_SESSION['LINKBD']->insert_id;
					$this->cerrar();
					return array('ok'=>true,'nuevo_id'=>$nuevo_id);
				}
				$this->cerrar();
				return array('ok'=>true,'resultado'=>$Resultado);
			}
			else{
				$Error=$_SESSION['LINKBD']->error;
				$this->cerrar();
				return array('ok'=>false,'error'=>$Diccionario->error(1)." ".$Error);
			}
		}
		else {
			return array('ok'=>false,'error'=>$Con);
		}
	}

	public function error_conexion(){
		global $Diccionario;
		return $Diccionario->error(0);
	}
}


?>