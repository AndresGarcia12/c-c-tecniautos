<?php
session_start();
include "../conexion.php";

if (!empty($_POST)) {
    $alert = '';
    if (empty($_POST['nombre']) || empty($_POST['telefono']) || empty($_POST['direccion'])) {
        $alert = '<p class="msg_error">Todos los campos son obligatorios.</p>';
    } else {
        $nit = $_POST['nit'];
        $nombre = $_POST['nombre'];
        $telefono  = $_POST['telefono'];
        $direccion   = $_POST['direccion'];
        $user_id = $_SESSION['idUser'];

    

        $result = 0;

        if (is_numeric($nit) and $nit!=0) {
            $query = mysqli_query($conection, "SELECT * FROM cliente WHERE nit='$nit'");
            $result = mysqli_fetch_array($query);
        }

        if ($result > 0) {
            $alert = '<p class="msg_error">El numeor NIT ya existe.</p>';
        } else {
            $query_insert = mysqli_query($conection, "INSERT INTO cliente(nit,nombre,telefono,direccion,usuario_id)
                                                        VALUES('$nit','$nombre','$telefono','$direccion','$user_id')");
            if ($query_insert) {
                $alert = '<p class="msg_save">Cliente creado correctamente.</p>';
            } else {
                $alert = '<p class="msg_error">Error al guardar el usuario.</p>';
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
    <title>Registro Cliente</title>
</head>

<body>
    <?php include "includes/header.php"; ?>
    <section id="container">

        <div class="form_register">
            <h1><i class="fas fa-user-plus"></i> Registro Cliente</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

            <form action="" method="post">
                <label for="nit">Nit</label>
                <input type="number" name="nit" id="nit" placeholder="Numero de nit">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre completo">
                <label for="telefono">telefono</label>
                <input type="number" name="telefono" id="telefono" placeholder="Telefono">
                <label for="direccion">Direcccion</label>
                <input type="text" name="direccion" id="direccion" placeholder="Direccion completa">

                <button type="submit"  class="btn_save"><i class="fas fa-save"></i>Crear cliente</button>

            </form>


        </div>


    </section>
    <?php include "includes/footer.php"; ?>
</body>

</html>