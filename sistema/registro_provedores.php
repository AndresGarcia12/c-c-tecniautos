<?php
session_start();
if($_SESSION['rol'] != 1)
	{
		header("location: ./");
	}
include "../conexion.php";
if (!empty($_POST)) {
    $alert = '';
    if (empty($_POST['proveedor']) || empty($_POST['contacto']) || empty($_POST['telefono']|| empty($_POST['direccion']))) {
        $alert = '<p class="msg_error">Todos los campos son obligatorios.</p>';
    } else {

        $proveedor = $_POST['proveedor'];
        $contacto = $_POST['contacto'];
        $telefono  = $_POST['telefono'];
        $direccion   = $_POST['direccion'];
        $user_id = $_SESSION['idUser'];

        $result = 0;

        
            $query = mysqli_query($conection, "SELECT * FROM proveedor WHERE proveedor Like '$proveedor' ");
            $result = mysqli_fetch_array($query);
        

        if ($result > 0) {
            $alert = '<p class="msg_error">El  Proveedor ya existe.</p>';
        } else {
            $query_insert = mysqli_query($conection, "INSERT INTO proveedor(proveedor,contacto,telefono,direccion,usuario_id)
                                                        VALUES('$proveedor','$contacto','$telefono','$direccion','$user_id')");
            if ($query_insert) {
                $alert = '<p class="msg_save">Provedor creado correctamente.</p>';
            } else {
                $alert = '<p class="msg_error">Error al guardar el provedor.</p>';
            }
        }
    }
    mysqli_close($conection);
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <title>Registro Proveedores</title>
</head>

<body>
    <?php include "includes/header.php"; ?>
    <section id="container">

        <div class="form_register">
            <h1><i class="fas fa-building"></i> <i class="fas fa-plus"></i> Registro Proveedores</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

            <form action="" method="post">
                <label for="nit">Proveedor</label>
                <input type="text" name="proveedor" id="proveedor" placeholder="Nombre del Provedor">
                <label for="contacto">Nombre</label>
                <input type="text" name="contacto" id="contacto" placeholder="Nombre cocontacto">
                <label for="telefono">telefono</label>
                <input type="number" name="telefono" id="telefono" placeholder="Telefono">
                <label for="direccion">Direcccion</label>
                <input type="text" name="direccion" id="direccion" placeholder="Direccion completa">

                <button type="submit"  class="btn_save"><i class="fas fa-save"></i> Crear provedor</button>

            </form>


        </div>


    </section>
    <?php include "includes/footer.php"; ?>
</body>

</html>