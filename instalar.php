<?php

error_reporting(E_ALL);
include('includes/diccionario.php');
$Diccionario=new diccionario();
include('includes/bd.php');
$B=new bd();
echo "<body>Instalación de la prueba<br>";
echo "<br>Creando Areas..";
$B->consulta("DROP TABLE IF EXISTS areas");
$B->consulta("CREATE TABLE IF NOT EXISTS `areas` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `nombre` varchar(255) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1");
$B->consulta("INSERT INTO `areas` (`id`, `nombre`) VALUES
	(1, 'Administrativa y Financiera'),
	(2, 'Ingeniería'),
	(5, 'Desarrollo de Negocio'),
	(6, 'Proyectos'),
	(7, 'Servicios'),
	(8, 'Calidad')");
echo "<br>Creando Empleados..";
$B->consulta("DROP TABLE IF EXISTS `empleado`");
$B->consulta("CREATE TABLE IF NOT EXISTS `empleado` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `nombre` varchar(255) NOT NULL,
	  `email` varchar(255) NOT NULL,
	  `sexo` char(1) NOT NULL,
	  `area_id` int(11) NOT NULL,
	  `boletin` int(11) DEFAULT NULL,
	  `descripcion` text NOT NULL,
	  PRIMARY KEY (`id`),
	  KEY `area_id` (`area_id`)
	) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1");
$B->consulta("INSERT INTO `empleado` (`id`, `nombre`, `email`, `sexo`, `area_id`, `boletin`, `descripcion`) VALUES (3, 'Pedro Pérez', 'pperez@example.co', 'M', 5, 1, 'Hola mundo'),
	(4, 'Amalia Bayona', 'abayona@example.co', 'F', 8, 0, 'Para contactar a Amalia Bayona, puede escribir al correo electrónico abayona@example.co')");
echo "<br>Creando Rol por Empleado..";
$B->consulta("DROP TABLE IF EXISTS `empleado_rol`");
$B->consulta("CREATE TABLE IF NOT EXISTS `empleado_rol` (
	  `empleado_id` int(11) NOT NULL,
	  `rol_id` int(11) NOT NULL,
	  KEY `empleado_id` (`empleado_id`),
	  KEY `rol_id` (`rol_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=latin1");
$B->consulta("INSERT INTO `empleado_rol` (`empleado_id`, `rol_id`) VALUES
	(3, 4), (3, 7), (3, 2), (4, 1), (4, 2)");
echo "<br>Creando Roles..";
$B->consulta("DROP TABLE IF EXISTS `roles`");
$B->consulta("CREATE TABLE IF NOT EXISTS `roles` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `nombre` varchar(255) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1");
$B->consulta("INSERT INTO `roles` (`id`, `nombre`) VALUES
	(1, 'Desarrollador'), (2, 'Analista'), (3, 'Tester'), (4, 'Diseñador'), (5, 'Profesional PMO'), (6, 'Profesional de servicios'), (7, 'Auxiliar administrativo'), (8, 'Codirector')");
echo "<br>Creando llaves foraneas ..";
$B->consulta("ALTER TABLE `empleado` ADD CONSTRAINT `empleado_ibfk_1` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE");
$B->consulta("ALTER TABLE `empleado_rol`
  ADD CONSTRAINT `empleado_rol_ibfk_1` FOREIGN KEY (`empleado_id`) REFERENCES `empleado` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `empleado_rol_ibfk_2` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE");
echo "<br><br>Fin de la instalación";
echo "<script language='javascript'>setTimeout(function(){window.open('index.php','_self');},1000);</script>";
?>
