<?php 
	
	$host = 'localhost';
	$user = 'root';
	$password = '';
	$db = 'c&ctecniautos';

	$conection = @mysqli_connect($host,$user,$password,$db);

	if(!$conection){
		echo "Error en la conexión";
	}

?>