<?php 
	session_start();
	if($_SESSION['rol'] != 1) 
	{
		header("location: ./");
	}
	include "../conexion.php";

	if(!empty($_POST))
	{
		if($_POST['idcliente'] == 1){
			header("location: lista_clientes.php");
			mysqli_close($conection);
		}
		$idcliente = $_POST['idcliente'];

		//$query_delete = mysqli_query($conection,"DELETE FROM usuario WHERE idusuario =$idusuario ");
		$query_delete = mysqli_query($conection,"UPDATE cliente SET estatus = 0 WHERE idcliente = $idcliente ");
		mysqli_close($conection);
		if($query_delete){
			header("location: lista_cliente.php");
		}else{
			echo "Error al eliminar";
		}

	}
	
	if(empty($_REQUEST['id']))
	{
		header("location: lista_usuarios.php");
		mysqli_close($conection);
	}else{

		$idcliente = $_REQUEST['id'];

		$query = mysqli_query($conection,"SELECT * FROM cliente WHERE idcliente = $idcliente");
		
		mysqli_close($conection);
		$result = mysqli_num_rows($query);

		if($result > 0){
			while ($data = mysqli_fetch_array($query)) {
				# code...
				$nit = $data['nit'];
				$nombre = $data['nombre'];
			}
		}else{
			header("location: lista_clientes.php");
		}
	}

	
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Eliminar Usuario</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		<div class="data_delete">
			<h1><i class="fas fa-user-minus"></i> Eliminar cliente</h1>
			<h2>¿Está seguro de eliminar el siguiente registro?</h2>
			<p>Nit: <span><?php echo $nit; ?></span></p>
			<p>Nombre: <span><?php echo $nombre; ?></span></p>	

			<form method="post" action="">
				<input type="hidden" name="idcliente" value="<?php echo $idcliente; ?>">
				<a href="lista_cliente.php" class="btn_cancel">Cancelar</a>
				<input type="submit" value="Aceptar" class="btn_ok">
			</form>
		</div>


	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>