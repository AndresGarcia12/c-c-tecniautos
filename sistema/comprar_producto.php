<?php
include "../conexion.php";
if (!empty($_POST) || !empty($_POST['id'])) {
    $alert = '';
    
        $codproducto = $_POST['id'];
        $proveedor = $_POST['proveedor'];
        $producto = $_POST['producto'];
        $precio  = $_POST['precio'];
        $cantidad   = $_POST['cantidad'];



        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $telefono = $_POST['telefono'];
        $comentario = $_POST['comentario'];


        $query_insert = mysqli_query($conection,"INSERT INTO reservas (codproducto,nombre, correo, telefono, comentario) 
        VALUES ($codproducto,'$nombre', '$correo', $telefono, '$comentario')");

        if ($query_insert) {
            $query_update = mysqli_query($conection, "UPDATE producto 
                                                    SET existencia = $cantidad-1
                                                     WHERE codproducto = $codproducto");
            header('Location: compra_exitosa.php');
            $alert = '<p class="msg_save">Compraste correctamente.</p>';
                
        } else { 
            $alert = '<p class="msg_error">Error al comprar.</p>';
        }

    mysqli_close($conection);
}





if (empty($_REQUEST['id'])) {
    header('Location: catalogo_productos.php');
} else {
    $id_producto = $_REQUEST['id'];
    if (!is_numeric($id_producto)) {
        header('Location: catalogo_productos.php');
    }
    $query_producto = mysqli_query($conection,"SELECT p.codproducto,p.descripcion,p.precio,p.existencia,p.foto,pr.codproveedor,pr.proveedor
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
        header('Location: catalogo_productos.php');
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
    <?php include "includes/header_inicio.php"; ?>
    <section id="container">

        <div class="form_register">
            <h1><i class="fas fa-edit"></i> Actualizar Producto</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

            <form action="" method="post">

            <input type="hidden" name="id" value="<?php echo $data_producto['codproducto'];?>">
            <input type="hidden" name="foto_actual" id="foto_actual" value="<?php echo $data_producto['foto'];?>">
            <input type="hidden" name="foto_remove" id="foto_remove" value="<?php echo $data_producto['foto'];?>">

                <label for="proveedor">Nombre proveedor</label>
                <input type="text" readonly="readonly" name="proveedor" id="proveedor" placeholder="Proveedor" value="<?php echo $data_producto["proveedor"] ?>">

                <label for="producto">Nombre del Producto</label>
                <input type="text" readonly="readonly" name="producto" id="producto" placeholder="Nombre del Producto" value="<?php echo $data_producto["descripcion"] ?>">
                <label for="precio">precio</label>
                <input type="text" readonly="readonly" name="precio" id="precio" placeholder="Precio del Producto" value="<?php echo $data_producto["precio"] ?>">
                <input type="hidden" name="cantidad" id="cantidad" value="<?php echo $data_producto["existencia"] ?>">

                <div class="photo">
                    <label for="foto">Foto producto</label>
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

                <label for="producto">Nombre</label>
                <input type="text"  name="nombre" id="nombre" placeholder="Nombre" value="">
                <label for="precio">Correo</label>
                <input type="text"  name="correo" id="correo" placeholder="Correo" value="">
                <label for="producto">Telefono</label>
                <input type="number"  name="telefono" id="telefono" placeholder="Telefono" value="">
                <label for="comentario">Comentario</label>
                <textarea name="comentario" id="comentario" placeholder="Comentario...." cols="30" rows="10"></textarea>
            

                
                <div class="buttons">
                <button type="submit" class="btn_save"><i class="fas fa-shopping-cart"></i>Reservar</button>
                <a href="catalogo_productos.php" class="btn_cancel">Cancelar</a>
                </div>
            </form>


        </div>


    </section>
    <!-- <?php include "includes/footer.php"; ?> -->
</body>

</html>