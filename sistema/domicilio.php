<?php
include "../conexion.php";
if (!empty($_POST) || !empty($_POST['id'])) {
    $alert = '';

        $nombre = $_POST['nombre'];
        $direccion = $_POST['direccion'];
        $telefono = $_POST['telefono'];
        $tipoDomicilio = $_POST['comentario'];

        


        $query_insert = mysqli_query($conection,"INSERT INTO domicilios ( nombre, telefono, direccion, tipodomicilio) 
                                                VALUES ('$nombre', $telefono,'$direccion','$tipoDomicilio')");

        if ($query_insert) {
            $alert = '<p class="msg_save">Compraste correctamente.</p>';
            header('Location: ../index.php');
                
        } else {
            $alert = '<p class="msg_error">Error al comprar.</p>';
        }

    mysqli_close($conection);
}





?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <title>Domicilio</title>
</head>

<body>
    <?php include "includes/header_inicio.php"; ?>
    <section id="container">

        <div class="form_register">
            <h1><i class="fas fa-edit"></i> Domicilio</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

            <form action="" method="post">


                <label for="nombre">Nombre</label>
                <input type="text"  name="nombre" id="nombre" placeholder="Nombre" value="">
                <label for="telefono">Telefono</label>
                <input type="number"  name="telefono" id="telefono" placeholder="Telefono" value="">
                <label for="direccion">Direccion</label>
                <input type="text"  name="direccion" id="direccion" placeholder="direccion" value="">
                <label for="comentario">Tipo de domicilio</label>
                <textarea name="comentario" id="comentario" placeholder="Tipo de domicilio...." cols="30" rows="10"></textarea>
            

                
                <div class="buttons">
                <button type="submit" class="btn_save"><i class="fab fa-rebel"></i>Reservar</button>
                <a href="catalogo_productos.php" class="btn_cancel">Cancelar</a>
                </div>
            </form>


        </div>


    </section>
    <!-- <?php include "includes/footer.php"; ?> -->
</body>

</html>