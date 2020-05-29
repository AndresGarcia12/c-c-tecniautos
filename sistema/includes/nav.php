		<nav>
			<ul>
				<li><a href="index.php"><i class="fas fa-home"></i> Inicio</a></li>
			<?php 
				if($_SESSION['rol'] == 1){
			 ?>
				<li class="principal">

					<a href="#"><i class="fas fa-users"></i> Usuarios</a>
					<ul>
						<li><a href="registro_usuario.php"><i class="fas fa-user-plus"></i> Nuevo Usuario</a></li>
						<li><a href="lista_usuarios.php"><i class="fas fa-users"></i> Lista de Usuarios</a></li>
					</ul>
				</li>
			<?php } ?>
				<li class="principal">
					<a href="#"><i class="fas fa-users"></i> Clientes</a>
					<ul>
						<li><a href="registro_clientes.php"><i class="fas fa-user-plus"></i> Nuevo Cliente</a></li>
						<li><a href="lista_clientes.php"><i class="fas fa-users"></i> Lista de Clientes</a></li>
					</ul>
				</li>
				<?php
				if($_SESSION["rol"]==1){
				?>
				<li class="principal">
					<a href="#"><i class="fas fa-industry"></i></i> Proveedores</a>
					<ul>
						<li><a href="registro_provedores.php"><i class="fas fa-industry"></i> <i class="fas fa-plus"></i> Nuevo Proveedor</a></li>
						<li><a href="listar_proveedores.php"><i class="fas fa-industry"></i> <i class="fas fa-industry"></i> Lista de Proveedores</a></li>
					</ul>
				</li>
				<?php
				}
				?>
				<li class="principal">
					<a href="#"><i class="fas fa-boxes"></i> Productos</a>
					<ul>
						<li><a href="registro_producto.php"><i class="fas fa-boxes"></i> <i class="fas fa-plus"></i> Nuevo Producto</a></li>
						<li><a href="lista_productos.php"><i class="fas fa-boxes"></i> Lista de Productos</a></li>
					</ul>
				</li>
				<li class="principal">
					<a href="#">Facturas</a>
					<ul>
						<li><a href="#">Nuevo Factura</a></li>
						<li><a href="#">Facturas</a></li>
					</ul>
				</li>
			</ul>
		</nav>