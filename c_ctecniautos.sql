-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-05-2020 a las 10:10:29
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `c&ctecniautos`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `actualizar_precio_producto` (`n_cantidad` INT, `n_precio` DECIMAL(10,2), `codigo` INT)  BEGIN
    	DECLARE nueva_existencia int;
        DECLARE nuevo_total  decimal(10,2);
        DECLARE nuevo_precio decimal(10,2);
        
        DECLARE cant_actual int;
        DECLARE pre_actual decimal(10,2);
        
        DECLARE actual_existencia int;
        DECLARE actual_precio decimal(10,2);
                
        SELECT precio,existencia INTO actual_precio,actual_existencia FROM producto WHERE codproducto = codigo;
        SET nueva_existencia = actual_existencia + n_cantidad;
        SET nuevo_total = (actual_existencia * actual_precio) + (n_cantidad * n_precio);
        SET nuevo_precio = nuevo_total / nueva_existencia;
        
        UPDATE producto SET existencia = nueva_existencia, precio = nuevo_precio WHERE codproducto = codigo;
        
        SELECT nueva_existencia,nuevo_precio;
        
    END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `idcliente` int(11) NOT NULL,
  `nit` int(11) DEFAULT NULL,
  `nombre` varchar(80) DEFAULT NULL,
  `telefono` int(11) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `dateadd` datetime NOT NULL DEFAULT current_timestamp(),
  `usuario_id` int(11) NOT NULL,
  `estatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`idcliente`, `nit`, `nombre`, `telefono`, `direccion`, `dateadd`, `usuario_id`, `estatus`) VALUES
(1, 1234567, 'Willian Juarez', 878766787, 'Guatemala, Guatemala', '2018-02-15 21:55:51', 1, 0),
(2, 87654321, 'Marta Gonzales', 34343434, 'Calzada Buena Vista', '2018-02-15 21:57:03', 1, 0),
(3, 0, 'Elena HernÃ¡ndez', 987897987, 'Guatemala, Chimaltenango', '2018-02-15 21:59:20', 2, 0),
(4, 0, 'Julio Maldonado', 908098979, 'Avenida las Americas Zona 14', '2018-02-15 22:00:31', 3, 0),
(5, 1234567890, 'Helen', 98789798, 'calle #1', '2018-02-18 10:53:53', 1, 0),
(6, 0, 'Juan', 7987987, 'Chimaltenango', '2018-02-18 10:56:44', 1, 0),
(7, 798798798, 'Jorge Maldonado', 2147483647, 'Colonia la Flores', '2018-02-18 11:10:07', 1, 0),
(8, 0, 'Marta Cabrera', 987987987, 'Guatemala', '2018-02-18 11:11:40', 2, 0),
(9, 79879879, 'Julio Estrada', 897987987, 'Avenida Elena', '2018-02-18 11:13:23', 3, 0),
(10, 2147483647, 'Roberto Morazan', 2147483647, 'Chimaltenango, Guatemala', '2018-03-04 19:17:22', 1, 0),
(11, 898798798, 'Rosa Pineda', 987998788, 'Ciudad Quetzal', '2018-03-04 19:17:45', 1, 0),
(12, 0, 'Angel Molina', 2147483647, 'Calzada Buena Vista', '2018-03-04 19:18:21', 1, 0),
(13, 12345678, 'Andres', 12345, 'Calle 4 #71-11', '2020-05-24 23:44:48', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallefactura`
--

CREATE TABLE `detallefactura` (
  `correlativo` bigint(11) NOT NULL,
  `nofactura` bigint(11) DEFAULT NULL,
  `codproducto` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `preciototal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_temp`
--

CREATE TABLE `detalle_temp` (
  `correlativo` int(11) NOT NULL,
  `nofactura` bigint(11) NOT NULL,
  `codproducto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `preciototal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `domicilios`
--

CREATE TABLE `domicilios` (
  `iddomicilio` bigint(20) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `telefono` int(15) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `tipodomicilio` varchar(255) NOT NULL,
  `fecha_domicilio` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entradas`
--

CREATE TABLE `entradas` (
  `correlativo` int(11) NOT NULL,
  `codproducto` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `usuario_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `entradas`
--

INSERT INTO `entradas` (`correlativo`, `codproducto`, `fecha`, `cantidad`, `precio`, `usuario_id`) VALUES
(1, 1, '0000-00-00 00:00:00', 150, '110.00', 1),
(2, 2, '2018-04-05 00:12:15', 100, '1500.00', 1),
(3, 3, '2018-04-07 22:48:23', 200, '250.00', 9),
(4, 4, '2018-09-08 22:28:50', 50, '10000.00', 1),
(5, 5, '2018-09-08 22:34:38', 100, '500.00', 1),
(6, 6, '2018-09-08 22:35:27', 8, '2000.00', 1),
(7, 7, '2018-12-02 00:15:09', 75, '2200.00', 1),
(8, 8, '2018-12-02 00:39:42', 75, '160.00', 1),
(9, 9, '2020-05-27 19:11:01', 3, '30000.00', 1),
(10, 10, '2020-05-27 22:52:24', 123, '330000.00', 1),
(11, 11, '2020-05-27 23:15:41', 30, '12300.00', 1),
(12, 1, '2020-05-28 19:33:04', 200, '200.00', 1),
(13, 5, '2020-05-28 19:50:06', 100, '600.00', 1),
(14, 5, '2020-05-28 19:50:07', 100, '600.00', 1),
(15, 5, '2020-05-28 19:50:07', 100, '600.00', 1),
(16, 5, '2020-05-28 19:50:08', 100, '600.00', 1),
(17, 5, '2020-05-28 19:51:31', 100, '600.00', 1),
(18, 12, '2020-05-29 00:31:11', 30, '300000.00', 1),
(19, 13, '2020-05-29 00:32:43', 50000, '40000.00', 1),
(20, 14, '2020-05-29 00:33:45', 50, '500000.00', 1),
(21, 15, '2020-05-29 00:35:28', 59, '400000.00', 1),
(22, 16, '2020-05-29 00:36:48', 70, '40000.00', 1),
(23, 17, '2020-05-29 00:38:15', 34, '300000.00', 1),
(24, 18, '2020-05-29 00:39:46', 35, '400000.00', 1),
(25, 19, '2020-05-29 00:44:03', 110, '400000.00', 1),
(26, 20, '2020-05-29 00:45:12', 89, '70000.00', 1),
(27, 21, '2020-05-29 01:18:14', 15, '1000.00', 1),
(28, 22, '2020-05-29 01:20:37', 4, '80000.00', 1),
(29, 22, '2020-05-29 01:21:19', 7, '100.00', 1),
(30, 22, '2020-05-29 01:21:51', 8, '70000.00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `nofactura` bigint(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(11) DEFAULT NULL,
  `codcliente` int(11) DEFAULT NULL,
  `totaltactura` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `codproducto` int(11) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `proveedor` int(11) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `existencia` int(11) DEFAULT NULL,
  `date_add` datetime NOT NULL DEFAULT current_timestamp(),
  `usuario_id` int(11) NOT NULL,
  `estatus` int(11) NOT NULL DEFAULT 1,
  `foto` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`codproducto`, `descripcion`, `proveedor`, `precio`, `existencia`, `date_add`, `usuario_id`, `estatus`, `foto`) VALUES
(1, 'Mouse USB', 11, '161.43', 345, '2018-04-05 00:09:34', 1, 0, 'img_producto.png'),
(2, 'Monitor LCD', 3, '1500.00', 100, '2018-04-05 00:12:15', 1, 0, 'img_producto.png'),
(3, 'Teclado USB', 9, '250.00', 200, '2018-04-07 22:48:23', 9, 0, 'img_producto.png'),
(4, 'Cama', 5, '10000.00', 50, '2018-09-08 22:28:50', 1, 0, 'img_21084f55f7b61c8baa2726ad0b4a1dca.jpg'),
(5, 'Plancha', 6, '583.33', 600, '2018-09-08 22:34:38', 1, 0, 'img_25c1e2ae283b99e83b387bf800052939.jpg'),
(6, 'Monitor', 11, '2000.00', 8, '2018-09-08 22:35:27', 1, 0, 'img_producto.png'),
(7, 'Monitor LCD 17', 9, '2200.00', 75, '2018-12-02 00:15:09', 1, 0, 'img_1328286905ecc9eec8e81b94fa1786b9.jpg'),
(8, 'USG 32 GB', 11, '160.00', 75, '2018-12-02 00:39:42', 1, 0, 'img_cce86641de32660a29e0fa49f58a950c.jpg'),
(9, 'ferrari', 14, '30000.00', 3, '2020-05-27 19:11:01', 1, 0, 'img_b7663d0fd025f059031cdadbb2f676fb.jpg'),
(10, 'Carrito', 14, '330000.00', 123, '2020-05-27 22:52:24', 1, 0, 'img_59919a8cb53524842cd7c3211c177fb9.jpg'),
(11, 'Carro Viejo', 14, '12300.00', 30, '2020-05-27 23:15:41', 1, 0, 'img_0dff41a684ff1efc789c4d4625c2dd1b.jpg'),
(12, 'bateria duralast gold', 3, '300000.00', 29, '2020-05-29 00:31:11', 1, 1, 'img_f4caeac8c4b11fcbab278f7365537338.jpg'),
(13, 'fram extended guard filtro de aceite', 15, '40000.00', 50000, '2020-05-29 00:32:43', 1, 1, 'img_24d956500020104bf00866d12f67ef0a.jpg'),
(14, 'Disco Rotor para Freno SHIMANO SM-RT54 MTB 160mm', 7, '500000.00', 50, '2020-05-29 00:33:45', 1, 1, 'img_bfaa2bba46d7561c4307e7123c80a17f.jpg'),
(15, 'Tambor de freno A.B.S.', 17, '400000.00', 59, '2020-05-29 00:35:28', 1, 1, 'img_1704a065ab3c812b8653f748809d0f4b.jpg'),
(16, 'FIltro de aire, K&N o  Remairfilters', 17, '40000.00', 70, '2020-05-29 00:36:48', 1, 1, 'img_a102ba1eaa3c552a50928b703e811a9f.jpg'),
(17, 'Alternador BOSCH', 17, '300000.00', 34, '2020-05-29 00:38:15', 1, 1, 'img_8ad3485af5d69d07efe7343f782c6ccf.jpg'),
(18, 'Amortiguador Sachs, Boge', 17, '400000.00', 35, '2020-05-29 00:39:46', 1, 1, 'img_bc41c3ae55f0ec7719e54481aafbe616.jpg'),
(19, 'Rotor freno BOSCH', 19, '400000.00', 110, '2020-05-29 00:44:03', 1, 1, 'img_f9f68c110e51208c3c8b9154177987a1.jpg'),
(20, 'Bujia, BPSCH', 17, '70000.00', 89, '2020-05-29 00:45:12', 1, 1, 'img_7efd11dbf477946c91a691e3cb7907d5.jpg'),
(21, 'batería de 1v', 19, '1000.00', 15, '2020-05-29 01:18:14', 1, 1, 'img_producto.png'),
(22, 'batería 2v', 17, '46352.63', 19, '2020-05-29 01:20:37', 1, 1, 'img_be45d564b2a185952d18f45e273c4de8.jpg');

--
-- Disparadores `producto`
--
DELIMITER $$
CREATE TRIGGER `entradas_A_I` AFTER INSERT ON `producto` FOR EACH ROW BEGIN
		INSERT INTO entradas(codproducto,cantidad,precio,usuario_id) 
		VALUES(new.codproducto,new.existencia,new.precio,new.usuario_id);    
	END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `codproveedor` int(11) NOT NULL,
  `proveedor` varchar(100) DEFAULT NULL,
  `contacto` varchar(100) DEFAULT NULL,
  `telefono` bigint(11) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `date_add` datetime NOT NULL DEFAULT current_timestamp(),
  `usuario_id` int(11) NOT NULL,
  `estatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`codproveedor`, `proveedor`, `contacto`, `telefono`, `direccion`, `date_add`, `usuario_id`, `estatus`) VALUES
(1, 'BIC', 'Claudia Rosales', 789877889, 'Avenida las Americas', '2018-03-20 23:13:43', 1, 0),
(2, 'CASIO', 'Jorge Herrera', 565656565656, 'Calzada Las Flores', '2018-03-20 23:14:41', 2, 0),
(3, 'Omega', 'Julio Estrada', 982877489, 'Avenida Elena Zona 4, Guatemala', '2018-03-24 23:21:10', 1, 0),
(4, 'Dell Compani', 'Roberto Estrada', 2147483647, 'Guatemala, Guatemala', '2018-03-24 23:21:59', 1, 0),
(5, 'Olimpia S.A', 'Elena Franco Morales', 564535676, '5ta. Avenida Zona 4 Ciudad', '2018-03-24 23:22:45', 1, 0),
(6, 'Oster', 'Fernando Guerra', 78987678, 'Calzada La Paz, Guatemala', '2018-03-24 23:24:43', 1, 0),
(7, 'ACELTECSA S.A', 'Ruben PÃ©rez', 789879889, 'Colonia las Victorias', '2018-03-24 23:25:39', 1, 0),
(8, 'Sony', 'Julieta Contreras', 89476787, 'Antigua Guatemala', '2018-03-24 23:26:45', 1, 0),
(9, 'VAIO', 'Felix Arnoldo Rojas', 476378276, 'Avenida las Americas Zona 13', '2018-03-24 23:30:33', 1, 0),
(10, 'SUMAR', 'Oscar Maldonado', 788376787, 'Colonia San Jose, Zona 5 Guatemala', '2018-03-24 23:32:28', 1, 0),
(11, 'HP', 'Angel Cardona', 2147483647, '5ta. calle zona 4 Guatemala', '2018-03-24 23:52:20', 2, 0),
(12, 'Martín Garcia', '', 2345773423, 'calle #11', '2020-05-27 12:56:01', 1, 0),
(13, '', 'Martín Garcia', 2345773423, 'calle #11', '2020-05-27 13:01:43', 1, 0),
(14, 'HotWheels', 'Martín Garcia', 2345773423, 'calle #11', '2020-05-27 13:02:13', 1, 1),
(15, 'Fram', 'Andres', 34535435, 'call', '2020-05-29 00:32:07', 1, 1),
(16, 'Shimano', 'Camlio', 45345345, 'calle 4', '2020-05-29 00:33:25', 1, 1),
(17, 'A.B.S', 'Javier', 234324234, 'calle 67', '2020-05-29 00:34:52', 1, 1),
(18, 'K&N', 'Morales', 345345, 'calle 67', '2020-05-29 00:36:08', 1, 1),
(19, 'BOSCH', 'Juan', 3638383, 'calle #79', '2020-05-29 00:37:35', 1, 1),
(20, 'Boge', 'hugo', 3453534, 'calle 89', '2020-05-29 00:39:14', 1, 1),
(21, 'BPSCH', 'Alberto', 2342423, 'sdfdsfsd', '2020-05-29 00:44:24', 1, 0),
(22, 'varta', 'nikkos karakalpakis', 3124567891, 'cll1 ·1 -1', '2020-05-29 01:16:53', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `codReserva` bigint(20) NOT NULL,
  `codproducto` int(20) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `telefono` int(15) NOT NULL,
  `comentario` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `reservas`
--

INSERT INTO `reservas` (`codReserva`, `codproducto`, `nombre`, `correo`, `telefono`, `comentario`) VALUES
(1, 3, 'Juan', 'juan@gmail.com', 232312313, 'Muy bueno lo quiero'),
(2, 1, 'Miguel', 'Miguel@gmail.com', 2343423, 'asdadasd'),
(3, 1, 'asdsad', 'asdad@sadad.com', 234242, 'dfsadasd'),
(4, 1, 'juana', 'juana@sadad.com', 23425, 'buen producto'),
(5, 1, 'juana', 'juana@sadad.com', 23425, 'buen producto'),
(6, 1, 'sdsdasd', 'asdasdasd@asdada', 234234, 'dfsdfsf'),
(7, 12, 'Juan', 'ernestogarc00@hotmaill.com', 234234234, 'Quiero para mi carro ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idrol` int(11) NOT NULL,
  `rol` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idrol`, `rol`) VALUES
(1, 'Administrador'),
(2, 'Supervisor'),
(3, 'Vendedor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sugerencias`
--

CREATE TABLE `sugerencias` (
  `idsugerencia` bigint(20) NOT NULL,
  `sugerencia` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `usuario` varchar(15) DEFAULT NULL,
  `clave` varchar(100) DEFAULT NULL,
  `rol` int(11) DEFAULT NULL,
  `estatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `nombre`, `correo`, `usuario`, `clave`, `rol`, `estatus`) VALUES
(1, 'Abel', 'info@abelosh.com', 'admin', '202cb962ac59075b964b07152d234b70', 1, 1),
(2, 'Julio Estrada', 'julio@gmail.com', 'julio', 'c027636003b468821081e281758e35ff', 2, 1),
(3, 'Carlos HernÃ¡ndez', 'carlos@gmail.com', 'carlos', '6572bdaff799084b973320f43f09b363', 3, 1),
(5, 'Marta Elena Franco', 'marta@gmail.com', 'marta', 'a763a66f984948ca463b081bf0f0e6d0', 3, 1),
(7, 'Carol Cabrera', 'carol@gmail.com', 'carol', 'a9a0198010a6073db96434f6cc5f22a8', 2, 0),
(8, 'Marvin Solares ', 'marvin@gmail.com', 'marvin', 'dba0079f1cb3a3b56e102dd5e04fa2af', 3, 1),
(9, 'Alan Melgar', 'alan@gmail.com', 'alan', '02558a70324e7c4f269c69825450cec8', 2, 1),
(10, 'Efrain GÃ³mez', 'efrain@gmail.com', 'efrain', '69423f0c254e5c1d2b0f5ee202459d2c', 2, 1),
(11, 'Fran Escobar', 'fran@gmail.com', 'fran', '2c20cb5558626540a1704b1fe524ea9a', 1, 1),
(12, 'Hana Montenegro', 'hana@gmail.com', 'hana', '52fd46504e1b86d80cfa22c0a1168a9d', 3, 1),
(13, 'Fredy Miranda', 'fredy@gmail.com', 'fredy', 'b89845d7eb5f8388e090fcc151d618c8', 2, 1),
(14, 'Roberto Salazar', 'roberto@hotmail.com', 'roberto', 'c1bfc188dba59d2681648aa0e6ca8c8e', 3, 1),
(15, 'William Fernando PÃ©rez', 'william@hotmail.com', 'william', 'fd820a2b4461bddd116c1518bc4b0f77', 3, 1),
(16, 'Francisco Mora', 'frans@gmail.com', 'frans', '64dd0133f9fb666ca6f4692543844f31', 3, 1),
(17, 'Ruben Guevara', 'ruben@hotmail.es', 'ruben', '32252792b9dccf239f5a5bd8e778dbc2', 3, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idcliente`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `detallefactura`
--
ALTER TABLE `detallefactura`
  ADD PRIMARY KEY (`correlativo`),
  ADD KEY `codproducto` (`codproducto`),
  ADD KEY `nofactura` (`nofactura`);

--
-- Indices de la tabla `detalle_temp`
--
ALTER TABLE `detalle_temp`
  ADD PRIMARY KEY (`correlativo`),
  ADD KEY `nofactura` (`nofactura`),
  ADD KEY `codproducto` (`codproducto`);

--
-- Indices de la tabla `domicilios`
--
ALTER TABLE `domicilios`
  ADD PRIMARY KEY (`iddomicilio`);

--
-- Indices de la tabla `entradas`
--
ALTER TABLE `entradas`
  ADD PRIMARY KEY (`correlativo`),
  ADD KEY `codproducto` (`codproducto`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`nofactura`),
  ADD KEY `usuario` (`usuario`),
  ADD KEY `codcliente` (`codcliente`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`codproducto`),
  ADD KEY `proveedor` (`proveedor`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`codproveedor`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`codReserva`),
  ADD KEY `codproducto` (`codproducto`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idrol`);

--
-- Indices de la tabla `sugerencias`
--
ALTER TABLE `sugerencias`
  ADD PRIMARY KEY (`idsugerencia`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`),
  ADD KEY `rol` (`rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idcliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `detallefactura`
--
ALTER TABLE `detallefactura`
  MODIFY `correlativo` bigint(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_temp`
--
ALTER TABLE `detalle_temp`
  MODIFY `correlativo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `domicilios`
--
ALTER TABLE `domicilios`
  MODIFY `iddomicilio` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `entradas`
--
ALTER TABLE `entradas`
  MODIFY `correlativo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `nofactura` bigint(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `codproducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `codproveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `codReserva` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idrol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `sugerencias`
--
ALTER TABLE `sugerencias`
  MODIFY `idsugerencia` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `cliente_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`idusuario`);

--
-- Filtros para la tabla `detallefactura`
--
ALTER TABLE `detallefactura`
  ADD CONSTRAINT `detallefactura_ibfk_2` FOREIGN KEY (`codproducto`) REFERENCES `producto` (`codproducto`),
  ADD CONSTRAINT `detallefactura_ibfk_3` FOREIGN KEY (`nofactura`) REFERENCES `factura` (`nofactura`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_temp`
--
ALTER TABLE `detalle_temp`
  ADD CONSTRAINT `detalle_temp_ibfk_1` FOREIGN KEY (`nofactura`) REFERENCES `factura` (`nofactura`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_temp_ibfk_2` FOREIGN KEY (`codproducto`) REFERENCES `producto` (`codproducto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `entradas`
--
ALTER TABLE `entradas`
  ADD CONSTRAINT `entradas_ibfk_1` FOREIGN KEY (`codproducto`) REFERENCES `producto` (`codproducto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `factura_ibfk_2` FOREIGN KEY (`codcliente`) REFERENCES `cliente` (`idcliente`),
  ADD CONSTRAINT `factura_ibfk_3` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`proveedor`) REFERENCES `proveedor` (`codproveedor`),
  ADD CONSTRAINT `producto_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD CONSTRAINT `proveedor_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`codproducto`) REFERENCES `producto` (`codproducto`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`rol`) REFERENCES `rol` (`idrol`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
