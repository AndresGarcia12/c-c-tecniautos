<?php 
	session_start();
	if($_SESSION['rol'] != 1)
	{
		header("location: ./");
	}
	include "../conexion.php";

	if(!empty($_POST))
	{
		$codproveedor = $_POST['codproveedor'];

		//$query_delete = mysqli_query($conection,"DELETE FROM usuario WHERE idusuario =$idusuario ");
		$query_delete = mysqli_query($conection,"UPDATE proveedor SET estatus = 0 WHERE codproveedor = $codproveedor");
		mysqli_close($conection);
		if($query_delete){
			header("location: listar_proveedores.php");
		}else{
			echo "Error al eliminar";
		}

	}




	if(empty($_REQUEST['id']))
	{
		header("location: listar_proveedores.php");
		mysqli_close($conection);
	}else{

		$codproveedor = $_REQUEST['id'];

		$query = mysqli_query($conection,"SELECT * 
												From proveedor
												WHERE codproveedor = $codproveedor ");
		
		mysqli_close($conection);
		$result = mysqli_num_rows($query);

		if($result > 0){
			while ($data = mysqli_fetch_array($query)) {
                # code...
                $proveedor = $data['proveedor'];
				$contacto = $data['contacto'];
				$telefono = $data['telefono'];
			}
		}else{
			header("location: listar_proveedores.php");
		}


	}


 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Eliminar Producto</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		<div class="data_delete">
		<h1><i class="fas fa-user-minus"></i> Eliminar producto</h1>
            <h2>¿Está seguro de eliminar el siguiente registro?</h2>
            <p>Proveedor: <span><?php echo $proveedor; ?></span></p>
			<p>Producto : <span><?php echo $producto; ?></span></p>
			<p>Precio   : <span><?php echo $precio; ?></span></p>
			<p>Cantidad : <span><?php echo $cantidad; ?></span></p>

			<form method="post" action="">
				<input type="hidden" name="codproveedor" value="<?php echo $codproveedor; ?>">
				<a href="listar_proveedores.php" class="btn_cancel">Cancelar</a>
				<input type="submit" value="Aceptar" class="btn_ok">
			</form>
		</div>


	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>