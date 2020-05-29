<?php
$alert='';
session_start();
if (!empty($_SESSION['active'])) {
    header('location: sistema/');
} else {
    if (!empty($_POST)) {
        if (empty($_POST['usuario']) || empty($_POST['contraseña'])) {
            $alert = 'Ingrese su usuario y contraseña';
        } else {
            require_once "conexion.php";
            $user = mysqli_real_escape_string($conection,$_POST['usuario']);
            $password = md5(mysqli_real_escape_string($conection,$_POST['contraseña']));

            $query = mysqli_query($conection, "Select * From usuario where usuario = '$user' AND clave='$password'");
            mysqli_close($conection);
            $result = mysqli_num_rows($query);
            if ($result > 0) {
                $data = mysqli_fetch_array($query);
                print_r($data);
                $_SESSION['active'] = true;
                $_SESSION['idUser'] = $data['idusuario'];
                $_SESSION['nombre'] = $data['nombre'];
                $_SESSION['email'] = $data['correo'];
                $_SESSION['user'] = $data['usuario'];
                $_SESSION['rol'] = $data['rol'];

                header('location: sistema/');
            } else {
                $alert = 'El usuario o la clave son incorrectos';
                session_destroy();
            }
        }
    }
}
?>
<!doctype html>
<html>

<head>
    <link href="css/estilos.css" rel="stylesheet">
    <meta charset="utf-8">
    <title>Untitled Document</title>
</head>

<body>
    <header id="header">
        <img src="static/img/Logo.png" id="logo" alt="logo">
        <nav Id="nav">
            <un> <a href="index.php">Home</a></un>
            <un><a href="html/servicio1.html">Servicios en linea</a></un>
            <un><a href="html/serviciosdomiciliarios.html">Servicios domiciliarios</a></un>
        </nav>
        <div id="log-in">
            <form action="" method="post">
                <input type="text" height="50" name="usuario" placeholder="Usuario">
                <input type="password" id="password" name="contraseña" placeholder="password">
                <input type="checkbox" onclick="showpassword()">
                <label for="" style="color: white;">showpassword</label>
                <div class="alert"><?php echo isset($alert) ? $alert : '' ?></php>
                </div>
                <input type="submit" value="Ingresar">
            </form>

        </div>
    </header>
    <img src="static/img/STA.gif" id="servicio" alt="servicio">


    <div id="wrapper">
        <section id="Info">
            <h1>¿Quienes somos?</h1>

            <p1>Somos una compañía ampliamente reconocida en Bogotá dedicada por más de 20 años al servicio técnico automotriz oportuno y de alta calidad para el mantenimiento predictivo, preventivo, correctivo y embellecimiento del parque automotor que se comercializa en Colombia. Nuestro servicio al cliente y la experiencia en la prestación de servicio técnico automotriz con la garantía de una mano de obra calificada, suministro de repuestos originales e interacción con empleados, contratistas y proveedores, permiten lograr la satisfacción total y excelencia en nuestro servicio.
            </p1>

            <h1>Visión</h1>

            <p1>En el 2030 seremos reconocidos como una empresa líder en Cundinamarca en la prestación de servicios técnicos para el mantenimiento predictivo, preventivo, correctivo y embellecimiento automotriz, así como en la importación y comercialización de autopartes que garanticen una movilidad segura a nuestros clientes, un servicio al cliente con los más altos estándares de calidad y el desarrollo humano, familiar y profesional de nuestros colaboradores.</p1>

            <h1>Misión</h1>

            <p1>Prestar servicios técnicos automotrices de alta calidad para el parque automotor colombiano contribuyendo a la movilidad segura, confort, economía y protección del patrimonio de nuestros clientes, empleados, contratistas y proveedores, basados en la permanente capacitación técnica y bienestar de nuestro talento humano, suministrando y comercializando repuestos originales, favoreciendo el medio ambiente y un excelente servicio al cliente, empleados, contratistas y proveedores, generando un negocio rentable para los socios y los colaboradores.</p1>
            
            <h1>Valores corporativos.</h1>

            <p1>Todas nuestras actividades son realizadas basados en los siguientes valores: -Honestidad: Somos trasparentes en todas nuestras acciones empresariales. -Respeto: Somos respetuosos de nuestro cliente, empleados, contratistas, proveedores y del medio ambiente. Asesoramos, pero respetamos las decisiones que ellos tomen. -Seriedad: Somos comprometidos con el cumplimiento oportuno de los compromisos adquiridos. -Competitividad: Mantenemos altos estándares de calidad en todos nuestros procesos empresariales mediante un aprendizaje técnico continuo. -Entusiasmo: Somos una empresa con un talento humano motivado constantemente. Amamos nuestra actividad empresarial.</p1>
        </section>
    </div>

    <footer>

        <p2>Dirección: Calle 75A #24-46</p2>
        <p2>Tel: 250 1545 - 544 5228</p2>
        <p2>Correo: cyctecniautos@hotmail.com</p2>

    </footer>
    <script type="text/javascript" src="js/scripts.js"></script>
</body>

</html>