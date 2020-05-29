<?php
session_start();
if ($_SESSION['rol'] != 1) {
    header("location: ./");
}
include "../conexion.php";
if (!empty($_POST)) {
    $alert = '';
    if (empty($_POST['proveedor']) || empty($_POST['producto']) || empty($_POST['precio']) || empty($_POST['cantidad']) || $_POST['cantidad'] < 0) {
        $alert = '<p class="msg_error">Todos los campos son obligatorios.</p>';
    } else {
        $proveedor = $_POST['proveedor'];
        $producto = $_POST['producto'];
        $precio  = $_POST['precio'];
        $cantidad   = $_POST['cantidad'];
        $user_id = $_SESSION['idUser'];

        $foto = $_FILES['foto'];
        $nombre_foto = $foto['name'];
        $type = $foto['type'];
        $url_temp = $foto['tmp_name'];

        $img_producto = 'img_producto.png';

        if ($nombre_foto != '') {
            $destino      = 'img/uploads/';
            $img_nombre   = 'img_' . md5(date('d-m-y h:m:s'));
            $img_producto = $img_nombre . '.jpg';
            $src          = $destino . $img_producto;
        }

        $result = 0;

        $query = mysqli_query($conection, "SELECT * FROM producto WHERE descripcion ='$producto'");
        $result = mysqli_fetch_array($query);


        if ($result > 0) {
            $alert = '<p class="msg_error">El producto ya existe.</p>';
        } else {

            $query_insert = mysqli_query($conection, "INSERT INTO producto(descripcion,proveedor,precio,existencia,usuario_id,foto)
                                                        VALUES('$producto','$proveedor','$precio','$cantidad','$user_id','$img_producto')");
            if ($query_insert) {
                if ($nombre_foto != '') {
                    move_uploaded_file($url_temp, $src);
                }
                $alert = '<p class="msg_save">El producto fue creado correctamente.</p>';
            } else {
                $alert = '<p class="msg_error">Error al guardar el producto.</p>';
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
    <title>Registro Producto</title>
</head>

<body>
    <?php include "includes/header.php"; ?>
    <section id="container">

        <div class="form_register">
            <h1><i class="fas fa-industry"></i> <i class="fas fa-plus"></i> Registro Producto</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

            <form action="" method="post" enctype="multipart/form-data">

                <label for="proveedor">Nombre</label>
                <select name="proveedor" id="proveedor">
                    <?php

                    $query_proveedor = mysqli_query($conection, "SELECT codproveedor,proveedor 
                                                            FROM proveedor 
                                                            WHERE estatus = 1 ORDER BY proveedor ASC ");
                    $result = mysqli_num_rows($query_proveedor);
                    mysqli_close($conection);
                    if ($result > 0) {
                        while ($proveedor_select = mysqli_fetch_array($query_proveedor)) {
                    ?>
                            <option value="<?php echo $proveedor_select["codproveedor"]; ?>"><?php echo $proveedor_select["proveedor"] ?></option>
                    <?php
                        }
                    }
                    ?>
                </select>
                <label for="producto">Nombre del Producto</label>
                <input type="text" name="producto" id="producto" placeholder="Nombre del Producto">
                <label for="precio">precio</label>
                <input type="number" name="precio" id="precio" placeholder="Precio del Producto">
                <label for="cantidad">Cantidad</label>
                <input type="number" name="cantidad" id="cantidad" placeholder="Cantidad del producto">

                <div class="photo">
                    <label for="foto">Foto</label>
                    <div class="prevPhoto">
                        <span class="delPhoto notBlock">X</span>
                        <label for="foto"></label>
                    </div>
                    <div class="upimg">
                        <input type="file" name="foto" id="foto">
                    </div>
                    <div id="form_alert"></div>
                </div>
                <button type="submit" class="btn_save"><i class="fas fa-save"></i>Guardar Producto</button>

            </form>


        </div>


    </section>
    <?php include "includes/footer.php"; ?>
</body>

</html>