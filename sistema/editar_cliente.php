<?php 
	
	session_start();
	

	include "../conexion.php";

	if(!empty($_POST))
	{
		$alert='';
		if(empty($_POST['nombre']) || empty($_POST['telefono']) || empty($_POST['direccion']))
		{
			$alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
		}else{

            $idCliente = $_POST['id'];
            $nit = $_POST['nit'];
			$nombre = $_POST['nombre'];
			$telefono  = $_POST['telefono'];
            $direccion   = $_POST['direccion'];
            
            $result=0;

            if(is_numeric($nit) and $nit !=0){
			$query = mysqli_query($conection,"SELECT * FROM cliente
													   WHERE (nit = '$nit' AND idcliente != $idCliente)
                                                       ");
            $result =mysqli_fetch_array($query);
            

			if($result > 0){
				$alert='<p class="msg_error">El nit ya existe.</p>';
			}else{

                if($nit == ''){
                    $nit = 0;
                }
					$sql_update = mysqli_query($conection,"UPDATE cliente
															SET nit = $nit, nombre = '$nombre', telefono = '$telefono' ,direccion = '$direccion'
                                                            WHERE idcliente = $idCliente ");                                      
				
				if($sql_update){
					$alert='<p class="msg_save">Cliente actualizado correctamente</p>';
				}else{
					$alert='<p class="msg_error">Error al actualizar el cliente.</p>';
				}
			}
		}

		}

	}

	//Mostrar Datos
	if(empty($_REQUEST['id']))
	{
		header('Location: lista_clientes.php');
		mysqli_close($conection);
	}
	$idcliente = $_REQUEST['id'];

	$sql= mysqli_query($conection,"SELECT *
									FROM cliente
									WHERE idcliente= $idcliente ");
	mysqli_close($conection);
	$result_sql = mysqli_num_rows($sql);

	if($result_sql == 0){
		header('Location: lista_clientes.php');
	}else{
		while ($data = mysqli_fetch_array($sql)) {
			# code...
            $id        = $data['idcliente'];
            $nit       = $data['nit'];
			$nombre    = $data['nombre'];
			$telefono  = $data['telefono'];
			$direccion = $data['direccion'];

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
			<h1><i class="fas fa-user-edit"></i> Actualizar Cliente</h1>
			<hr>
            <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
            <form action="" method="post">
                <input type="hidden" name="id" value="<?php echo $id;?>">
                <label for="nit">Nit</label>
                <input type="number" name="nit" id="nit" placeholder="Numero de nit" value="<?php echo $nit;?>">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre completo" value="<?php echo $nombre;?>">
                <label for="telefono">telefono</label>
                <input type="number" name="telefono" id="telefono" placeholder="Telefono" value="<?php echo $telefono;?>">
                <label for="direccion">Direcccion</label>
                <input type="text" name="direccion" id="direccion" placeholder="Direccion completa" value="<?php echo $direccion;?>">

                <button type="submit"  class="btn_save"><i class="fas fa-save"></i> Guardar</button>

            </form>
		</div>
	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>