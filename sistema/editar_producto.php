<?php
session_start();
include "../conexion.php";
if ($_SESSION['rol'] != 1) {
    header("location: ./");
}



if (!empty($_POST)) {

    $alert = '';
    if (empty($_POST['proveedor']) || empty($_POST['producto']) || empty($_POST['precio']) || empty($_POST['id']) || $_POST['foto_remove']|| $_POST['foto_actual']) {
        $alert = '<p class="msg_error">Todos los campos son obligatorios.</p>';
    } else {
        $codproducto = $_POST['id'];
        $proveedor = $_POST['proveedor'];
        $producto = $_POST['producto'];
        $precio  = $_POST['precio'];
        $cantidad   = $_POST['cantidad'];
        $imgProducto = $_POST['foto_actual'];
        $imgRemove = $_POST['foto_remove'];
        $user_id = $_SESSION['idUser'];

        $foto = $_FILES['foto'];
        $nombre_foto = $foto['name'];
        $type = $foto['type'];
        $url_temp = $foto['tmp_name'];

        $upd = '';

        if ($nombre_foto != '') {
            $destino      = 'img/uploads/';
            $img_nombre   = 'img_' . md5(date('d-m-y h:m:s'));
            $imgProducto = $img_nombre . '.jpg';
            $src          = $destino . $img_producto;
        }else{
            if($_POST['foto_actual'] != $_POST['foto_remove']){
                $img_producto = 'img_producto.png';
            }
        }

        $result = 0;

        $query = mysqli_query($conection, "SELECT * FROM producto WHERE descripcion ='$producto'");
        $result = mysqli_fetch_array($query);


        if ($result > 0) {
            $alert = '<p class="msg_error">El producto ya existe.</p>';
        } else {

            $query_update = mysqli_query($conection, "UPDATE producto 
                                                    SET descripcion = '$producto',
                                                    proveedor = $proveedor,
                                                    precio= $precio,
                                                    existencia = $cantidad,
                                                    foto='$img_producto'
                                                     WHERE codproducto = $codproducto");   
            if ($query_update) {
                if (($nombre_foto != '' && ($_POST['foto_actual'] != 'img_producto.png')) || ($_POST['foto_actual'] != $_POST['foto_remove'])) {

                    unlink('img/uploads/'.$_POST['foto_actual']);
                }
                if ($nombre_foto != '') {
                    move_uploaded_file($url_temp, $src);
                }
                $alert = '<p class="msg_save">Producto actualizado correctamente.</p>';
            } else {
                $alert = '<p class="msg_error">Error al actualizar el producto.</p>';
            }
        }
    }
    mysqli_close($conection);
}


if (empty($_REQUEST['id'])) {
    header('Location: lista_producto.php');
} else {
    $id_producto = $_REQUEST['id'];
    if (!is_numeric($id_producto)) {
        header('Location: lista_productos.php');
    }
    $query_producto = mysqli_query($conection,"SELECT p.codproducto,p.descripcion,p.precio,p.foto,pr.codproveedor,pr.proveedor
                                            FROM producto p
                                            Inner JOIN proveedor pr
                                            ON p.proveedor = pr.codproveedor 
                                            Where p.codproducto = $id_producto AND p.estatus = 1");
    $result_producto = mysqli_num_rows($query_producto);

    $foto ='';
    $classRemove = 'notBlock';

    if($result_producto>0){
        $data_producto = mysqli_fetch_array($query_producto);

        if($data_producto['foto']!='img_producto.png'){
            $classRemove ='';
            $foto = '<img id="img" src="img/uploads/'.$data_producto['foto'].'" alt="'.$data_producto['foto'].'">';
        }
    }else{
        header('Location: lista_productos.php');
    }
   
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <title>Actualizar Producto</title>
</head>

<body>
    <?php include "includes/header.php"; ?>
    <section id="container">

        <div class="form_register">
            <h1><i class="fas fa-edit"></i> Actualizar Producto</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

            <form action="" method="POST" enctype="multipart/form-data">

            <input type="hidden" name="id" value="<?php echo $data_producto['codproducto'];?>">
            <input type="hidden" name="foto_actual" id="foto_actual" value="<?php echo $data_producto['foto'];?>">
            <input type="hidden" name="foto_remove" id="foto_remove" value="<?php echo $data_producto['foto'];?>">

                <label for="proveedor">Nombre</label>
                <select name="proveedor" id="proveedor" class=".notItemOne">
                <option value="<?php echo $data_producto["codproveedor"]; ?>" selected><?php echo $data_producto["proveedor"] ?></option>
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
                <input type="text" name="producto" id="producto" placeholder="Nombre del Producto" value="<?php echo $data_producto["descripcion"] ?>">
                <label for="precio">precio</label>
                <input type="number" name="precio" id="precio" placeholder="Precio del Producto" value="<?php echo $data_producto["precio"] ?>">

                <div class="photo">
                    <label for="foto">Foto</label>
                    <div class="prevPhoto">
                        <span class="delPhoto <?php echo $classRemove;?>">X</span>
                        <label for="foto"></label>
                        <?php echo $foto;?>
                    </div>
                    <div class="upimg">
                        <input type="file" name="foto" id="foto">
                    </div>
                    <div id="form_alert"></div>
                </div>
                <button type="submit" class="btn_save"><i class="fas fa-save"></i>Actualizar Producto</button>

            </form>


        </div>


    </section>
    <?php include "includes/footer.php"; ?>
</body>

</html>