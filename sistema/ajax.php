<?php
session_start();
include "../conexion.php";
// print_r($_POST);
if(!empty($_POST)){
    if($_POST['action']=='infoProducto'){
        $producto_id = $_POST['producto'];        
        $query = mysqli_query($conection,"SELECT codproducto,descripcion FROM producto
                                        WHERE codproducto = $producto_id AND estatus=1");
        mysqli_close($conection);
        $result = mysqli_num_rows($query);

        if($result>0){
            $data = mysqli_fetch_assoc($query);
                echo json_encode($data,JSON_UNESCAPED_UNICODE);
                exit;
        }
            echo "Error"; 
            exit;
    }
    if($_POST['action']=='addproducto'){
    
        if(!empty($_POST['cantidad'])|| !empty($_POST['precio']) || !empty($_POST['producto_id'])){
    

            $cantidad = $_POST['cantidad'];
            $precio = $_POST['precio']; 
            $producto_id = $_POST['producto_id'];
            $iduser = $_SESSION['idUser'];
    
            $queryInsert=mysqli_query($conection,"INSERT 
                                                INTO entradas(codproducto,cantidad,precio,usuario_id)
                                                VALUES($producto_id,$cantidad,$precio,$iduser)");
            if($queryInsert){
                //Ejecutar procedimiento de almacenado
                $queryUpdate = mysqli_query($conection,"CALL actualizar_precio_producto($cantidad,$precio,$producto_id)");
                $result_pro = mysqli_num_rows($queryUpdate);
                if($result_pro > 0){
                    $data = mysqli_fetch_assoc($queryUpdate);
                    $data['producto_id']=$producto_id;
                    echo json_encode($data,JSON_UNESCAPED_UNICODE);
                    exit;
                }
            }else{
                echo 'Error';
            }
            mysqli_close($conection);
        }else{
            echo 'Error';
        
        }
        exit;
        
    }
}


