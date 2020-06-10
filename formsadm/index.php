<?php
require_once("../classes/ctrl_sesion.php");
require_once("../classes/venta.php");
require_once("../classes/conexion.php");


use \classes\ctrl_sesion\Ctrl_Sesion;
use \classes\conexion\Conexion;

Ctrl_Sesion::verificar_inicio_sesion();

$cnx = new Conexion();


?>
<!DOCTYPE html>
<html lang="es">

<head>
  <?php include("incluir_estilos_encabezado.php"); ?>
  <title>Sistema de ventas - ADMIN</title>

</head>

<body>
  <?php include("incluir_menu_formularios.php"); ?>
  <div style="margin: 30px;">
    <h1>Sistema de ventas en linea</h1>
    <h2>Bienvenido al sistema: <?php echo Ctrl_Sesion::get_nombre_usuario(); ?> </h2>
  </div>
  <?php include("incluir_estilos_pie.php"); ?>
</body>

</html>