<?php 

	class diccionario {
		var $Errores=array();
		var $Botones=array();

		public function __construct(){
			/// mensajes de error
			$this->Errores[0]="Error en la conexión de la base de datos";
			$this->Errores[1]="Error en la ejecución de una sentencia en la base de datos.";

			/// botones
			$this->Botones['edit']='<span class="iconify-inline" data-icon="fa:edit" ></span>';
			$this->Botones['del']='<span class="iconify-inline" data-icon="fontisto:trash"></span>';
			$this->Botones['name']='<span class="iconify-inline" data-icon="fa-solid:user"></span>';
			$this->Botones['email']='<span class="iconify-inline" data-icon="entypo:email"></span>';
			$this->Botones['sexo']='<span class="iconify-inline" data-icon="healthicons:sexual-reproductive-health"></span>';
			$this->Botones['area']='<span class="iconify-inline" data-icon="fa-solid:briefcase"></span>';
			$this->Botones['boletin']='<span class="iconify-inline" data-icon="fluent:mail-20-filled"></span>';
			$this->Botones['user-add']='<span class="iconify-inline" data-icon="ri:user-add-line"></span>';
			$this->Botones['btn-cerrar']='<span class="iconify-inline" data-icon="fa-regular:times-circle"></span>';
		}

		public function error($iderror){
			return $this->Errores[$iderror];
		}

	}
	
function limpiar_post($dato,$ENTER=false) // LIMPIA UNA CADENA DE COMILLAS SENCILLAS Y DOBLES SI ENTER=TRUE LIMPIA DEL CARACTER 10 Y 13 
{
	$dato=str_replace('"','',$dato);
	$dato=str_replace("'",'',$dato);
	if($ENTER) {
		$dato=str_replace("\n",'',$dato); 
		$dato=str_replace("\r",'',$dato);
	}
	return $dato;
}

function cleanInput($input) {
	$search = array(
		'@<script[^>]*?>.*?</script>@si',   // Elimina javascript
		'@<[\/\!]*?[^<>]*?>@si',			// Elimina las etiquetas HTML
		'@<style[^>]*?>.*?</style>@siU',	// Elimina las etiquetas de estilo
		'@<![\s\S]*?--[ \t\n\r]*>@'		 // Elimina los comentarios multi-línea
	);
	$output = preg_replace($search, '', $input);
	return $output;
}
 
function sanitize($input) {
    if (is_array($input)) {
        foreach($input as $var=>$val) {$output[$var] = sanitize($val);}
    }
    else {
        if (get_magic_quotes_gpc()) {$input = stripslashes($input);}
        $output  = cleanInput($input);
		$prohibido=array('/select/','/delete/','/from/','/truncate/','/where/','/update/','/alter/','/;/');
		$output = preg_replace($prohibido,'',$output);
    }
    return $output;
}
?>