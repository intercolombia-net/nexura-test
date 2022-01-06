<?php
	
	class html {
		function init_html(){
			echo '<!DOCTYPE html>
						<html lang="en">
						<head>
							<!-- Required meta tags -->
								<meta charset="utf-8">
								<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
							<title>EMPLEADOS</title>
							<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
							<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
							<script src="https://code.iconify.design/2/2.0.3/iconify.min.js"></script>
						</head>';
		}

		function init_css($archivo){
			echo "<link rel=stylesheet href='css/$archivo'>";
		}

		function init_js($archivo){
			echo "<script src='js/$archivo'></script>";
		}

	}

?>