<?php

session_start();

if ($_SESSION['rol'] != 1) {
	header("location: ./");
}

include "../conexion.php";

if (!empty($_POST)) {
	$alert = '';
	if (empty($_POST['proveedor']) || empty($_POST['contacto']) || empty($_POST['telefono']) || empty($_POST['direccion'])) {
		$alert = '<p class="msg_error">Todos los campos son obligatorios.</p>';
	} else {

		$codproveedor = $_POST['id'];
		$proveedor = $_POST['proveedor'];
		$contacto = $_POST['contacto'];
		$telefono  = $_POST['telefono'];
		$direccion   = $_POST['direccion'];

		$result = 0;

		$query = mysqli_query($conection, "SELECT * FROM proveedor WHERE proveedor Like '$proveedor' ");
		$result = mysqli_fetch_array($query);

		if ($result > 0) {
			$alert = '<p class="msg_error">El Proveedor ya existe.</p>';
		} else {

			$sql_update = mysqli_query($conection, "UPDATE proveedor
															SET proveedor = '$proveedor', contacto = '$contacto', telefono = '$telefono' ,direccion = '$direccion'
                                                            WHERE codproveedor = $codproveedor ");

			if ($sql_update) {
				$alert = '<p class="msg_save">Proveedor actualizado correctamente</p>';
			} else {
				$alert = '<p class="msg_error">Error al actualizar el Proveedor.</p>';
			}
		}
	}
}



//Mostrar Datos
if (empty($_REQUEST['id'])) {
	header('Location: listar_proveedores.php');
	mysqli_close($conection);
}
$codproveedor = $_REQUEST['id'];

$sql = mysqli_query($conection, "SELECT *
									FROM proveedor
									WHERE codproveedor = $codproveedor");
mysqli_close($conection);
$result_sql = mysqli_num_rows($sql);

if ($result_sql == 0) {
	header('Location: listar_proveedores.php');
} else {
	while ($data = mysqli_fetch_array($sql)) {
		# code...
		$id              = $data['codproveedor'];
		$proveedor       = $data['proveedor'];
		$contacto        = $data['contacto'];
		$telefono        = $data['telefono'];
		$direccion       = $data['direccion'];
	}
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Actualizar Cliente</title>
</head>

<body>
	<?php include "includes/header.php"; ?>
	<section id="container">

		<div class="form_register">
			<h1><i class="fas fa-edit"></i> Actualizar Proveedor</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
			<form action="" method="post">
				<input type="hidden" name="id" value="<?php echo $id; ?>">
				<label for="proveedor">Proveedor</label>
				<input type="text" name="proveedor" id="proveedor" placeholder="Numero de nit" value="<?php echo $proveedor; ?>">
				<label for="contacto">Contacto</label>
				<input type="text" name="contacto" id="contacto" placeholder="Nombre del Contacto" value="<?php echo $contacto; ?>">
				<label for="telefono">telefono</label>
				<input type="number" name="telefono" id="telefono" placeholder="Telefono" value="<?php echo $telefono; ?>">
				<label for="direccion">Direcccion</label>
				<input type="text" name="direccion" id="direccion" placeholder="Direccion completa" value="<?php echo $direccion; ?>">

				<button type="submit" class="btn_save"><i class="fas fa-save"></i> Guardar</button>

			</form>
		</div>
	</section>
	<?php include "includes/footer.php"; ?>
</body>

</html>