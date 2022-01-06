<?php

class empleado{
	var $A_Sexo=array('M'=>'Masculino','F'=>'Femenino');
	var $A_Boletin=array(0=>'No',1=>'Si');
	var $B;

	function listar_empleados(){
		global $Diccionario;
		$h=new html();
		$h->init_html();
		$h->init_css('empleados.css');
		$h->init_js('empleados.js');
		$this->B=new bd();
		$Empleados=$this->B->consulta("SELECT e.*,a.nombre as narea FROM empleado e,areas a WHERE e.area_id=a.id ");
		$this->form_editar();
		echo "<div class='container-fluid'>
					<div class='row'>
						<div class='col-sm-12'>
							<div class='titulo-empleados'>Lista de Empleados</div>
							<div id='btn-crear'><a class='btn btn-primary btn-lg'>".$Diccionario->Botones['user-add']." Crear</a></div>";
		if($Empleados['ok']){
			echo "<table style='width:100%'>
						<tr>
							<th>".$Diccionario->Botones['name']." Nombre</th>
							<th>".$Diccionario->Botones['email']." Email</th>
							<th>".$Diccionario->Botones['sexo']." Sexo</th>
							<th>".$Diccionario->Botones['area']." Area</th>
							<th align='center'>".$Diccionario->Botones['boletin']." Boletin</th>
							<th align='center'>Modificar</th>
							<th align='center'>Eliminar</th>
						</tr>";
			$Contador=0;$b='#fff;';
			while($E=mysqli_fetch_object($Empleados['resultado']))
			{
				echo "<tr style='background-color:#".($b=($b=='fff'?'eee':'fff')).";'>
								<td>$E->nombre</td>
								<td>$E->email</td>
								<td>".$this->A_Sexo[$E->sexo]."</td>
								<td>$E->narea</td>
								<td align='center'>".$this->A_Boletin[$E->boletin]."</td>
								<td align='center'><a onclick='modificar($E->id);'>".$Diccionario->Botones['edit']."</a></td>
								<td align='center'><a onclick='borrar($E->id);'>".$Diccionario->Botones['del']."</a></td>
						</tr>";
			} // while
			echo "</table>";
		}
		else $this->muestra_error($Empleados['error']);
		echo "		</div><!-- col -->
					</div><!-- row -->
				</div><!-- container -->
			</body>
			<script language='javascript'>
				$(document).ready(function(){
						init_empleados();
					});
			</script>
			</html>";
	}

	function form_editar(){
		global $Diccionario;
		$txt_Areas=$this->get_areas();
		$txt_Roles=$this->get_roles();
		echo "<div id='capa-editar-crear' class='container-fluid'>
						<div id='cerrar'>
							<a id='btn-cerrar' class='btn btn-danger btn-sm'>".$Diccionario->Botones['btn-cerrar']."</a>
						</div>
						<h1 align='center'>Crear / Editar Empleado</h1>
						<form action='crea_empleado.php' method='post' target='Oculto_resultado' name='forma' id='forma'>
							<div class='row'>
								<div class='col-sm-6'>
									<div class='alert alert-info'>
										<h4>Los campos con asteriscos (*) son obligatorios</h4>
									</div>
								</div><!-- col-sm-6 -->
								<div class='col-sm-6'>
									<div class='alert alert-danger' id='capa_errores'>
										<span id='texto_errores'></span>
									</div>
								</div><!-- col-sm-6 -->
							</div><!-- row -->
							<div class='row'>
								<div class='col-sm-3 etiqueta'>
									Nombre completo *
								</div><!-- col-sm-3 -->
								<div class='col-sm-9 '>
									<input type='text' class='form-control obligatorio' name='nombre' id='nombre' value='' maxlength='255' placeholder='Nombre completo del empleado' pattern='[A-Za-z]'>
								</div><!-- col-sm-9 -->
								<div class='col-sm-3 etiqueta'>
									Correo Electrónico *
								</div><!-- col-sm-3 -->
								<div class='col-sm-9 '>
									<input type='email' class='form-control obligatorio' name='email' id='email' value='' maxlength='255' placeholder='Correo electrónico' >
								</div><!-- col-sm-9 -->
								<div class='col-sm-3 etiqueta'>
									Sexo *
								</div><!-- col-sm-3 -->
								<div class='col-sm-9 '>
									<label><input type='radio' class='obligatorio' value='M' name='sexo' id='sexo'> Masculino </label><br>
									<label><input type='radio' class='obligatorio' value='F' name='sexo' id='sexo'> Femenino </label>
								</div><!-- col-sm-9 -->
								<div class='col-sm-3 etiqueta'>
									Area *
								</div><!-- col-sm-3 -->
								<div class='col-sm-9 '>
									<select name='area' id='area' class='form-control obligatorio'>$txt_Areas</select>
								</div><!-- col-sm-9 -->
								<div class='col-sm-3 etiqueta'>
									Descripcion *
								</div><!-- col-sm-3 -->
								<div class='col-sm-9 '>
									<textarea name='descripcion' id='descripcion' class='form-control obligatorio' placeholder='Descripción de la experiencia del empleado'></textarea>
								</div><!-- col-sm-9 -->
								<div class='col-sm-3 etiqueta'>
									
								</div><!-- col-sm-3 -->
								<div class='col-sm-9'>
									<label><input type='checkbox' name='boletin' id='boletin' > Deseo recibir boletín informativo</label>
								</div><!-- col-sm-9 -->
								<div class='col-sm-3 etiqueta'>
									Roles *
								</div><!-- col-sm-3 -->
								<div class='col-sm-9'>
									$txt_Roles
								</div><!-- col-sm-9 -->
							</div><!-- row -->
							<div class='row'>
								<div class='col-sm-3'>
									
								</div><!-- col-sm-3 -->
								<div class='col-sm-4 col-sm-offset-4'>
									<button id='btn-guardar-empleado' type='button' class='btn btn-primary btn-lg'>Guardar</button>
								</div><!-- col-sm-4 -->
							</div><!-- row -->
							<input type='hidden' name='id' id='id' value=''>
						</form>
					</div>
					<iframe name='Oculto_resultado' id='Oculto_resultado' style='display:none' width='100%' height='500'></iframe>";
	}

	function get_areas(){
		$this->B=new bd();
		$txt_areas="<option value=''>Seleccione un Area</option>";
		$Areas=$this->B->consulta("SELECT id,nombre FROM areas ORDER BY nombre");
		if($Areas['ok']){
			while($A=mysqli_fetch_object($Areas['resultado'])){
				$txt_areas.="<option value='$A->id'>$A->nombre</option>";
			} // while
		}
		return $txt_areas;
	}

	function get_roles(){
		$this->B=new bd();
		$txt_roles="";
		$Roles=$this->B->consulta("SELECT id,nombre FROM roles ORDER BY nombre");
		if($Roles['ok']){
			while($R=mysqli_fetch_object($Roles['resultado'])){
				$txt_roles.="<label><input type='checkbox'  class='obligatorio' name='roles[]' id='roles' value='$R->id'> $R->nombre</label><br>";
			} // while
		}
		return $txt_roles;
	}

	function muestra_error($contenido){
		echo "<div class='alert alert-danger'><h3><i class='fa fa-exclamation-triangle fa-2x'></i> $contenido</h3></div>";
	}

	function guardar_empleado($data){
		$nombre=trim(limpiar_post($data['nombre'],true));
		$nombre=sanitize($nombre);
		$nombre= filter_var($nombre, FILTER_SANITIZE_STRING);
		$email=trim(limpiar_post($data['email'],true));
		$email=sanitize($email);
		$email= filter_var($email, FILTER_SANITIZE_EMAIL);
		$sexo=$data['sexo'];
		$descripcion=limpiar_post($data['descripcion']);
		$descripcion=sanitize($descripcion);
		$area=$data['area'];
		$roles=$data['roles'];
		$boletin=isset($data['boletin'])?1:0;
		$id=$data['id'];
		$this->B= new bd();
		$Existe_email=$this->B->consulta("SELECT id FROM empleado WHERE email='$email' ");
		$Existe_id=$this->B->consulta("SELECT id FROM empleado WHERE id='$id' ");
		$Registro=false;
		if($Existe_id['resultado']->num_rows){
			$Registro=mysqli_fetch_object($Existe_id['resultado']);
		}
		elseif($Existe_email['resultado']->num_rows){
			$Registro=mysqli_fetch_object($Existe_email['resultado']);
		}
		if($Registro){
			$resultado=$this->B->consulta("UPDATE empleado SET nombre='$nombre',email='$email',sexo='$sexo',descripcion='$descripcion',area_id='$area',boletin='$boletin' WHERE id='$Registro->id' ");
			if($resultado['ok']){
				$this->actualizar_roles($roles,$id);
				return true;
			}
			else {
				echo "<body><script language='javascript'>parent.mostrar_oculto();</script>";
				print_r($resultado);
				echo "</body>";
				return false;
			}
		} 
		else {
			$resultado=$this->B->consulta("INSERT INTO empleado SET nombre='$nombre',email='$email',sexo='$sexo',descripcion='$descripcion',area_id='$area',boletin='$boletin' ");
			if($resultado['ok']){
				$this->actualizar_roles($roles,$resultado['nuevo_id']);
				return true;
			}
			else{
				echo "<body><script language='javascript'>parent.mostrar_oculto();</script>";
				print_r($resultado);
				echo "</body>";
				return false;
			}
		}
	}

	function actualizar_roles($Roles_Nuevas,$id){
		$QRoles=$this->B->consulta("SELECT * FROM empleado_rol WHERE empleado_id=$id");
		$Roles_Actuales=array();
		if($QRoles['ok']){
			while($rol=mysqli_fetch_object($QRoles['resultado'])){
				$Roles_Actuales[]=$rol->rol_id;
			} // while
		}
		print_r($Roles_Actuales);
		echo "<br>";
		print_r($Roles_Nuevas);
		foreach($Roles_Nuevas as $rol){
			if(!in_array($rol,$Roles_Actuales)){
				$this->B->consulta("INSERT INTO empleado_rol SET empleado_id='$id',rol_id='$rol' ");
			}
		}
		foreach($Roles_Actuales as $rol){
			if(!in_array($rol,$Roles_Nuevas)){
				$this->B->consulta("DELETE FROM empleado_rol WHERE empleado_id='$id' and rol_id='$rol' ");
			}
		}
	}

	function get_empleado($data){
		$id=base64_decode($data['id']);
		$this->B= new bd();
		$Resultado=$this->B->consulta("SELECT * FROM empleado WHERE id='$id' ");
		if($Resultado['ok']){
			if($Empleado=mysqli_fetch_object($Resultado['resultado'])){
				if($Empleado->sexo=='M') {
					$sexo="sexo[0].checked=true;"; 
				}
				else {
					$sexo="sexo[1].checked=true;"; 
				}
				if($Empleado->boletin){
					$boletin="boletin.checked=true;";
				}
				else{
					$boletin="boletin.checked=false;";
				}
				$descripcion=base64_encode($Empleado->descripcion);
				$Qroles=$this->B->consulta("SELECT * FROM empleado_rol WHERE empleado_id='$id' ");
				$script_roles="";
				while($D=mysqli_fetch_object($Qroles['resultado'])){
					$script_roles.="verifica_rol($D->rol_id);";
				} // while
				echo "<body>
							<script language='javascript'>
								with(parent.document.forma){
									nombre.value='$Empleado->nombre';
									email.value='$Empleado->email';
									$sexo
									area.value='$Empleado->area_id';
									descripcion.value=atob('$descripcion');
									$boletin
									id.value='$id';
								}
								$script_roles
								parent.mostrar_edicion();

								function verifica_rol(dato){
									var Roles=parent.document.forma.roles;
									for(var i=0;i<Roles.length;i++){
										if(Roles[i].value==dato) Roles[i].checked=true;
									}	
								}
							</script>
						</body>";
			}
			else{
				echo "<body>";
				$this->muestra_error("Error obteniendo la información del empleado");
				echo "<script language='javascript'>parent.mostrar_oculto();</script></body>";
			}
		}
	}

	function elimina_empleado($data){
		$id=base64_decode($data['id']);
		$this->B= new bd();
		$Resultado=$this->B->consulta("DELETE FROM empleado WHERE id='$id' ");
		if($Resultado['ok']){
			return true;
		}
		else{
				echo "<body><script language='javascript'>parent.mostrar_oculto();</script>
				Error Eliminando el empleado<hr>";
				print_r($Resultado);
				echo "</body>";
				return false;
		}
	}
}
?>