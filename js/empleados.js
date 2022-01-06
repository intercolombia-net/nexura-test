function init_empleados(){
	$('#btn-crear').click(function(){
		document.forma.reset();
		$('#capa-editar-crear').fadeIn();
	});

	$('#btn-cerrar').click(function(){
		$('#capa-editar-crear').fadeOut();
	});

	$('#btn-guardar-empleado').click(function(){
		var Pasa=validaciones();
		if(Pasa) document.forma.submit();
	});

	$('.obligatorio').blur(function(){validaciones();});
	$('.obligatorio').change(function(){validaciones();});

	$('#nombre').on('input', function (e) {
		if (!/^[ a-záéíóúüñ]*$/i.test(this.value)) {
			this.value = this.value.replace(/[^ a-záéíóúüñ]+/ig,"");
		}
	});
	$('#descripcion').on('input', function (e) {
		if (!/^[ a-z0-9áéíóúüñ\n]*$/i.test(this.value)) {
			this.value = this.value.replace(/[^ a-z0-9áéíóúüñ\n]+/ig,"");
		}
	});
	$('#email').on('input', function (e) {
		if (!/^[a-z0-9@\._\-]*$/i.test(this.value)) {
			this.value = this.value.replace(/[^a-z0-9@\._\-]+/ig,"");
		}
	});

};

function validaciones(){
	var Pasa=true;
	var Errores='';
	var borde_alerta='2px solid #ffaaaa';
	var borde_estandar='1px solid #ced4da';
	with(document.forma){
		if(nombre.value.length>0){
			nombre.style.border=borde_estandar;
		}
		else {
			Pasa=false;
			nombre.style.border=borde_alerta;
			Errores += 'Debe digitar un nombre. ';
		}
		if(email.value.length>0){
			email.value=email.value.trim();
			email.value=email.value.replace(/[^a-z0-9@\._\-]+/ig,"");
			if(validar_email(email.value)){
				email.style.border=borde_estandar;
			}
			else {
				Pasa=false;
				email.style.border=borde_alerta;
				Errores += 'Debe digitar un email válido. ';
			}
		}
		else {
			Pasa=false;
			email.style.border=borde_alerta;
			Errores += 'Debe digitar un correo electrónico. ';
		}
		if(sexo.value.length>0){
			sexo[0].offsetParent.style.border='';
		}
		else {
			Pasa=false;
			sexo[0].offsetParent.style.border=borde_alerta;
			Errores += 'Debe seleccionar un sexo. ';
		}
		if(area.value.length>0){
			area.style.border=borde_estandar;
		}
		else{
			Pasa=false;
			area.style.border=borde_alerta;
			Errores += 'Debe seleccionar un área. ';
		}
		if(descripcion.value.length>0){
			descripcion.style.border=borde_estandar;
		}
		else{
			Pasa=false;
			descripcion.style.border=borde_alerta;
			Errores += 'Debe digitar una descripción de la experiencia del empleado. ';
		}
		var roles_marcados=false;
		for(var i=0;i<roles.length;i++){
			if(roles[i].checked) roles_marcados=true;
		}
		if(roles_marcados){
			roles[0].offsetParent.style.border='';
		}
		else {
			Pasa=false;
			roles[0].offsetParent.style.border=borde_alerta;
			Errores += 'Debe seleccionar al menos uno de los roles. ';
		}
	}
	if(Pasa) {
		$('#capa_errores').fadeOut();
		document.getElementById('btn-guardar-empleado').disabled=false; 
	}
	else {
		document.getElementById('btn-guardar-empleado').disabled=true;
		$('#texto_errores').html(Errores);
		$('#capa_errores').fadeIn();
	}
	return Pasa;
}

function validar_email($email){
	var formato_email = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,6})+$/;
  	return formato_email.test( $email );
}

function mostrar_oculto(){
	$('#Oculto_resultado').fadeIn();
	$('#capa-editar-crear').fadeOut();
}

function recargar(){
	window.open('empleados.php','_self');
}

function modificar(dato){
	window.open('modifica_empleado.php?id='+btoa(dato),'Oculto_resultado');
}

function mostrar_edicion(){
	$('#capa-editar-crear').fadeIn();
}

function borrar(dato){
	if(confirm('Seguro que desea borrar el empleado?')){
		window.open('elimina_empleado.php?id='+btoa(dato),'Oculto_resultado');
	}
}