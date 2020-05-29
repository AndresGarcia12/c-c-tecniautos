<?php 
	session_start();
	include "../conexion.php";	
 ?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Lista de Productos</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		<h1><i class="fas fa-boxes"></i> Lista de productos</h1>
		<a href="registro_proveedor.php" class="btn_new"><i class="fas fa-boxes"></i><i class="fas fa-plus"></i> Crear productos</a>
		
		<form action="buscar_producto.php" method="get" class="form_search">
			<input type="text" name="busqueda" id="busqueda" placeholder="Buscar">
			<button type="submit" class="btn_search"><i class="fas fa-search"></i></button>
		</form>

		<table>
			<tr>
                <th>ID</th>
                <th>Producto</th>
				<th>Proveedor</th>
				<th>Precio</th>
				<th>Existencia</th>
				<th>Foto</th>
				<?php
						if ($_SESSION['rol']==1||$_SESSION['rol']==2) {
							?>
				<th>Acciones</th>
				<?php
						}
					 ?>
			</tr>
		<?php 
			//Paginador
			$sql_registe = mysqli_query($conection,"SELECT COUNT(*) as total_registro FROM producto WHERE estatus = 1 ");
			$result_register = mysqli_fetch_array($sql_registe);
			$total_registro = $result_register['total_registro'];

			$por_pagina = 5;

			if(empty($_GET['pagina']))
			{
				$pagina = 1;
			}else{
				$pagina = $_GET['pagina'];
			}

			$desde = ($pagina-1) * $por_pagina;
			$total_paginas = ceil($total_registro / $por_pagina);

			$query = mysqli_query($conection,"SELECT p.codproducto,p.proveedor,p.descripcion,p.precio, p.existencia, pr.proveedor, p.foto 
											  FROM producto p 
											  INNER JOIN proveedor pr
											  ON p.proveedor = pr.codproveedor
											  WHERE p.estatus = 1 ORDER BY p.codproducto ASC LIMIT $desde,$por_pagina 
											");
			mysqli_close($conection);
			$result = mysqli_num_rows($query);
			if($result > 0){

				while ($data = mysqli_fetch_array($query)) {
						if($data['foto']!='img_producto.png'){
							$foto = 'img/uploads/'.$data['foto'];
						}else{
							$foto = 'img/uploads/'.$data['foto'];
						}
					
			?>
				<tr class="row<?php echo $data['codproducto'];?>">
                    <td><?php echo $data["codproducto"]; ?></td>
                    <td><?php echo $data["descripcion"]; ?></td>
                    <td><?php echo $data["proveedor"]; ?></td>
					<td class="row<?php echo $data['celPrecio'];?>"><?php echo $data["precio"]; ?></td>
					<td class="row<?php echo $data['celExistencia'];?>"><?php echo $data["existencia"]; ?></td>
					<td><img class="img_producto" src="<?php echo $foto; ?>" alt="<?php echo $data['descripcion']; ?>"></td>
					<?php
						if ($_SESSION['rol']==1||$_SESSION['rol']==2) {
							?>
					<td>
						<a class="link_edit add_product" href="#" product="<?php echo $data["codproducto"]; ?>"><i class="fas fa-plus"></i></a>
						|
						<a class="link_edit" href="editar_producto.php?id=<?php echo $data["codproducto"]; ?>"><i class="fas fa-edit"></i></a>
						|
						<a class="link_delete" href="eliminar_confirmar_producto.php?id=<?php echo $data["codproducto"]; ?>"><i class="fas fa-trash"></i></a>
						<?php
						}
					 }
					 ?>
					</td>
				</tr>
			
		<?php 
				}
		 ?>


		</table>
		<div class="paginador">
			<ul>
			<?php 
				if($pagina != 1)
				{
			 ?>
				<li><a href="?pagina=<?php echo 1; ?>">|<</a></li>
				<li><a href="?pagina=<?php echo $pagina-1; ?>"><<</a></li>
			<?php 
				}
				for ($i=1; $i <= $total_paginas; $i++) { 
					# code...
					if($i == $pagina)
					{
						echo '<li class="pageSelected">'.$i.'</li>';
					}else{
						echo '<li><a href="?pagina='.$i.'">'.$i.'</a></li>';
					}
				}

				if($pagina != $total_paginas)
				{
			 ?>
				<li><a href="?pagina=<?php echo $pagina + 1; ?>">>></a></li>
				<li><a href="?pagina=<?php echo $total_paginas; ?> ">>|</a></li>
			<?php } ?>
			</ul>
		</div>


	</section>
	<!-- <?php include "includes/footer.php"; ?> -->
</body>
</html>